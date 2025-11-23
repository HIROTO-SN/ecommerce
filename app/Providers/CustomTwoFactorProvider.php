<?php

namespace App\Providers;

use Laravel\Fortify\TwoFactorAuthenticationProvider;
use App\Services\MyGoogle2FA;

class CustomTwoFactorProvider extends TwoFactorAuthenticationProvider {
    protected MyGoogle2FA $google2fa;

    /**
    * Inject MyGoogle2FA ( Laravel auto-resolves this )
    */

    public function __construct( MyGoogle2FA $google2fa ) {
        $this->google2fa = $google2fa;
    }

    /**
    * Verify TOTP using MyGoogle2FA with a +/- 1 window
    */

    public function verify( $secret, $code ) {
        // get timestamp from MyGoogle2FA ( not from provider )
        $timestamp = $this->google2fa->getTimestamp();

        // window: previous ( -1 ), current ( 0 ), next ( +1 )
        foreach ( [ -1, 0, 1 ] as $offset ) {

            $generated = $this->google2fa->oathTotp(
                $secret,
                $timestamp + $offset
            );

            if ( hash_equals( $generated, $code ) ) {
                return true;
            }
        }

        return false;
    }
}