<?php

namespace App\Livewire\Modals;

use App\Providers\CustomTwoFactorProvider;
use App\Services\AlertService;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class EditFieldModal extends Component {
    public $field;
    public $value;
    public $passkeys;
    public $twoFactorEnabled;
    public $show2faInput;
    public $twoFactorCode;
    public $qrCode;
    public $password_confirmation;
    protected $rules = [
        'value' => 'required|string|max:255',
    ];

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

        // ✅ アラート表示
        AlertService::success( $this->field );

        // ✅ 画面リフレッシュ（再読み込みやデータ更新用）
        $this->dispatch( 'close-modal' );
        $this->dispatch( 'user-updated' );

    }

    public function mount( $field, $value, $passkeys, $twoFactorEnabled, $show2faInput, $twoFactorCode, $qrCode ) {
        $this->field = $field;
        $this->value = $value;
        $this->passkeys = $passkeys;
        $this->twoFactorEnabled = $twoFactorEnabled;
        $this->show2faInput = $show2faInput;
        $this->twoFactorCode = $twoFactorCode;
        $this->qrCode = $qrCode;

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

        AlertService::success( $this->field );
        $this->dispatch( 'close-modal' );
    }

    public function render() {
        return view( 'livewire.modals.edit-field-modal' );
    }

}