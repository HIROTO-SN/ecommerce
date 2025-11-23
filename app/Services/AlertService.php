<?php

namespace App\Services;

use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class AlertService
 {
    public static function success( string $field, ?string $message = null ) {
        $text = $message ?? ucfirst( str_replace( '_', ' ', $field ) ) . ' updated successfully!';

        LivewireAlert::title( 'Success' )
        ->text( $text )
        ->position( 'center' )
        ->timer( 2000 )
        ->success()
        ->show();
    }

    public static function error( string $field, ?string $message = null ) {
        $text = $message ?? ucfirst( str_replace( '_', ' ', $field ) ) . ' could not be updated.';

        LivewireAlert::title( 'Error' )
        ->text( $text )
        ->position( 'center' )
        ->timer( 3000 )
        ->error()
        ->show();
    }

    public static function warning( string $field, ?string $message = null ) {
        $text = $message ?? ucfirst( str_replace( '_', ' ', $field ) ) . ' requires attention.';

        LivewireAlert::title( 'Warning' )
        ->text( $text )
        ->position( 'center' )
        ->timer( 2500 )
        ->warning()
        ->show();
    }

    public static function info( string $field, ?string $message = null ) {
        $text = $message ?? ucfirst( str_replace( '_', ' ', $field ) ) . ' information.';

        LivewireAlert::title( 'Info' )
        ->text( $text )
        ->position( 'center' )
        ->timer( 2000 )
        ->info()
        ->show();
    }

}