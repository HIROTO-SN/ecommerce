<?php

namespace App\Livewire;

use App\Models\User;
use App\Providers\CustomTwoFactorProvider;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Title;
use Livewire\WithFileUploads;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Laravel\Fortify\TwoFactorAuthenticationProvider;
use PragmaRX\Google2FAQRCode\Google2FA;

#[ Title( 'My Account' ) ]

class MyAccountPage extends Component {

    use WithFileUploads;

    public $photo;
    public $avatar_url;

    // 編集モーダル用
    public $showModal = false;
    public $field;
    public $value;
    public $password_confirmation;
    public $passkeys = [];
    public $qrCode;
    public $show2faInput = false;
    public $twoFactorCode;
    public $twoFactorEnabled;

    protected $rules = [
        'value' => 'required|string|max:255',
    ];

    protected $listeners = [ 'avatar-updated' => 'refreshUser' ];

    public function render() {
        $user = auth()->user();

        if ( $user->avatar_url ) {
            $this->photo = $user->avatar_url;
        }

        return view( 'livewire.my-account-page', [
            'user' => $user,
            'orders_count' => $user->orders()->count(),
            'delivered_count' => $user->orders()->where( 'status', 'delivered' )->count(),
            'canceled_count' => $user->orders()->where( 'status', 'canceled' )->count(),
            'recent_orders' => $user->orders()->latest()->take( 5 )->get(),
            'default_address' => $user->orders()->latest()->first()?->address,
        ] );
    }

    public function updatedPhoto() {
        $rules = [
            'photo' => 'nullable|image|max:2048'
        ];

        $this->validate( $rules );
        $user = User::find( auth()->id() );

        // 旧画像を削除（任意）
        if ( $user->avatar_url && Storage::disk( 'public' )->exists( $user->avatar_url ) ) {
            Storage::disk( 'public' )->delete( $user->avatar_url );
        }

        // 画像を保存（publicディスク）
        $path = $this->photo->store( 'avatars', 'public' );

        // ✅ データベース更新
        $user->avatar_url = $path;
        $user->save();

        // フロント再描画用イベント発火
        $this->dispatch( 'avatar-updated' );

        // 一時ファイルをリセット
        $this->photo = null;

        LivewireAlert::title( 'Success' )
        ->text( 'Your profile picture has been updated successfully!' )
        ->position( 'center' )
        ->timer( 2000 )
        ->success()
        ->show();
    }

    // ✅ 編集モーダルを開く

    public function edit( $field ) {
        $this->field = $field;
        $user = auth()->user();
        $this->resetValidation();

        if ( $field === 'phone' ) {
            $this->value = $this->formatPhone( $user->phone );
        } elseif ( $field === 'password' ) {
            $this->value = '';
            $this->password_confirmation = '';
        } elseif ( $field === '2fa' ) {
            // Check if user already has 2FA enabled
            $this->twoFactorEnabled = !empty( $user->two_factor_secret );

            if ( !$this->twoFactorEnabled ) {
                // Only generate QR if not enabled yet
                $this->show2faInput = false;
                $this->twoFactorCode = '';
                $this->generateTwoFactorQr();
            }
        } elseif ( $field === 'passkey' ) {
            // ✅ パスキー専用モーダルを開く（登録済みパスキー一覧を取得）
            $this->passkeys = $user->passkeys()->orderByDesc( 'last_used_at' )->get();
        } else {
            $this->value = $user->$field;
        }

        $this->showModal = true;
    }

    // ✅ 保存処理

    public function save() {
        $user = auth()->user();

        // バリデーションの切り替え
        if ( $this->field === 'email' ) {
            $this->validate( [ 'value' => 'required|email' ] );
        } elseif ( $this->field === 'password' ) {
            $this->validate( [
                'value' => 'required|min:8|same:password_confirmation',
            ] );
        } elseif ( $this->field === 'phone' ) {
            // 電話番号のバリデーション
            $this->validate( [
                'value' => [
                    'required',
                    'regex:/^0\d{1,4}-\d{1,4}-\d{4}$/', // ハイフンあり形式をチェック
                ],
            ] );
        } else {
            $this->validate( $this->rules );
        }

        // ✅ 更新データを動的に生成
        $data = [
            $this->field => $this->field === 'password'
            ? Hash::make( $this->value )
            : ( $this->field === 'phone'
            ? preg_replace( '/-/', '', $this->value ) // ハイフン削除
            : $this->value ),
        ];

        // ✅ データベース更新
        $user->update( $data );

        // ✅ モーダルを閉じる
        $this->showModal = false;

        // ✅ アラート表示
        LivewireAlert::title( 'Success' )
        ->text( ucfirst( str_replace( '_', ' ', $this->field ) ) . ' updated successfully!' )
        ->position( 'center' )
        ->timer( 2000 )
        ->success()
        ->show();

        // ✅ 画面リフレッシュ（再読み込みやデータ更新用）
        $this->dispatch( 'user-updated' );

    }

    public function confirmTwoFactor() {
        $this->validate( [
            'twoFactorCode' => 'required|digits:6',
        ] );

        $user = auth()->user();

        // Get secret from session ( not DB )
        $secret = session( 'two_factor_temp_secret' );

        if ( ! $secret ) {
            $this->addError( 'twoFactorCode', 'Session expired. Please try again.' );
            return;
        }

        $provider = app( CustomTwoFactorProvider::class );

        // Validate code ( including extended window if you replaced provider )
        $valid = $provider->verify( $secret, $this->twoFactorCode );

        if ( ! $valid ) {
            $this->addError( 'twoFactorCode', 'The code is invalid.' );
            return;
        }

        // 2FA confirmed → now save in DB
        $user->forceFill( [
            'two_factor_secret' => encrypt( $secret ),
            'two_factor_confirmed_at' => now(),
        ] )->save();

        // Remove temp secret from session
        session()->forget( 'two_factor_temp_secret' );

        session()->flash( 'success', 'Two-factor authentication has been enabled.' );
    }

    private function generateTwoFactorQr() {
        $user = auth()->user();
        $provider = app( TwoFactorAuthenticationProvider::class );
        $google2fa = new Google2FA();

        // Always generate new temporary secret for preview
        $secret = session( 'two_factor_temp_secret' ) ?? $provider->generateSecretKey();
        session( [ 'two_factor_temp_secret' => $secret ] );

        // Generate QR from this temporary secret
        $this->qrCode = $google2fa->getQRCodeInline(
            config( 'app.name' ),
            $user->email,
            $secret
        );
    }

    public function disableTwoFactor() {
        $user = auth()->user();
        $user->forceFill( [
            'two_factor_secret' => null,
            'two_factor_confirmed_at' => null,
        ] )->save();

        $this->twoFactorEnabled = false;
        $this->show2faInput = false;
        $this->twoFactorCode = '';

        session()->flash( 'success', 'Two-factor authentication has been disabled.' );
    }

    private function formatPhone( $number ) {
        if ( !$number ) return '';

        // 例: 09012345678 → 090-1234-5678 に変換
        if ( preg_match( '/^0(\d{2})(\d{4})(\d{4})$/', $number, $matches ) ) {
            return "0{$matches[1]}-{$matches[2]}-{$matches[3]}";
        } elseif ( preg_match( '/^0(\d{3})(\d{3})(\d{4})$/', $number, $matches ) ) {
            return "0{$matches[1]}-{$matches[2]}-{$matches[3]}";
        }

        return $number;
    }
}