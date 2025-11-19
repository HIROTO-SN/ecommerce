<?php

namespace App\Services;

use PragmaRX\Google2FA\Google2FA;

class MyGoogle2FA extends Google2FA
 {
    public function getOneTimeBeforeOtp(
        #[ \SensitiveParameter ]
        $secret
    ) {
        return $this->oathTotp( $secret, $this->getTimestamp() - 1 );
    }
}