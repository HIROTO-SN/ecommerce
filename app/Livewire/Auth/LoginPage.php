<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

#[ Title( 'Login' ) ]

class LoginPage extends Component {
    public $email;
    public $password;

    protected $casts = [
        'two_factor_secret' => 'encrypted', // 自動暗号化
        '   ' => 'encrypted',
    ];

    public function render() {
        return view( 'livewire.auth.login-page' );
    }

    public function save() {
        // バリデーション
        $this->validate( [
            'email' => 'required|email|max:255',
            'password' => 'required|min:6|max:255',
        ] );

        $user = User::where( 'email', $this->email )->first();
        if ( !$user || !Hash::check( $this->password, $user->password ) ) {
            session()->flash( 'error', 'Invalid credentials' );
            return;
        }

        if ( $user->two_factor_secret ) {
            session( [ 'login.id' => $user->id ] );
            return redirect()->route( 'two-factor.login' );
        }
        Auth::login( $user );
        session()->regenerate();
        return redirect()->intended( '/' );
    }
}