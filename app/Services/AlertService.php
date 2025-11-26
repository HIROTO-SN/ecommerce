<?php

namespace App\Services;

use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class AlertService
 {
    public static function success( string $field, ?string $message = null ) {
        $suffix = $message ?? 'updated successfully!';
        $text = ucfirst( str_replace( '_', ' ', $field ) ) . ' ' . $suffix;

        LivewireAlert::title( 'Success' )
        ->text( $text )
        ->position( 'center' )
        ->timer( 2000 )
        ->success()
        ->show();
    }

    public static function error( string $field, ?string $message = null ) {
        $suffix = $message ?? 'could not be updated.';
        $text = ucfirst( str_replace( '_', ' ', $field ) ) . ' ' . $suffix;

        LivewireAlert::title( 'Error' )
        ->text( $text )
        ->position( 'center' )
        ->timer( 3000 )
        ->error()
        ->show();
    }

    public static function warning( string $field, ?string $message = null ) {
        $suffix = $message ?? 'requires attention.';
        $text = ucfirst( str_replace( '_', ' ', $field ) ) . ' ' . $suffix;

        LivewireAlert::title( 'Warning' )
        ->text( $text )
        ->position( 'center' )
        ->timer( 2500 )
        ->warning()
        ->show();
    }

    public static function info( string $field, ?string $message = null ) {
        $suffix = $message ?? 'information.';
        $text = ucfirst( str_replace( '_', ' ', $field ) ) . ' ' . $suffix;

        LivewireAlert::title( 'Info' )
        ->text( $text )
        ->position( 'center' )
        ->timer( 2000 )
        ->info()
        ->show();
    }

    public static function custom( string $title, string $type = 'info', ?string $message = null, ?string $position = 'center', int $timer = 2000 ) {
        LivewireAlert::title( ucfirst( $title ) )
        ->text( $message ?? '' )
        ->position( $position )
        ->timer( $timer )
        -> {
            $type}
            ()
            ->show();
        }

    }