<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Title;
use Livewire\WithFileUploads;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

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

        if ( $field === 'phone' ) {
            $this->value = $this->formatPhone( $user->phone );
        } elseif ( $field === 'password' ) {
            $this->value = '';
            $this->password_confirmation = '';
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

    private function formatPhone( $number ) {
        if ( !$number ) return '';

        // 例: 09012345678 → 090-1234-5678 に変換
        if ( preg_match( '/^0(\d{2})(\d{4})(\d{4})$/', $number, $matches ) ) {
            return "0{$matches[1]}-{$matches[2]}-{$matches[3]}";
        } elseif ( preg_match( '/^0(\d{3})(\d{3})(\d{4})$/', $number, $matches ) ) {
            return "0{$matches[1]}-{$matches[2]}-{$matches[3]}";
        }

        return $number;
        // フォーマットできない場合はそのまま
    }
}