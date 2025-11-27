<?php

namespace App\Livewire\Auth\TwoFactor;

use App\Models\User;
use App\Providers\CustomTwoFactorProvider;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class TwoFactorChallenge extends Component {
    public $code;

    public function submit() {
        $userId = session( 'login.id' );
        $user = User::find( $userId );

        if ( ! $user ) {
            session()->flash( 'error', 'Session expired. Please login again.' );
            return redirect( '/login' );
        }

        $secret = decrypt( $user->two_factor_secret );
        $provider = app( CustomTwoFactorProvider::class );
        $valid = $provider->verify( $secret, $this->code );

        if ( ! $valid ) {
            $this->addError( 'twoFactorCode', 'The code is invalid.' );
            return;
        }

        session()->forget( 'login.id' );
        Auth::login( $user );
        session()->regenerate();

        return redirect()->intended( '/' );
    }

    public function render() {
        return view( 'livewire.auth.two-factor.two-factor-challenge' );
    }
}