<?php

namespace App\Providers;

use App\Services\MyGoogle2FA;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Support\Facades\Vite;
use Filament\Support\Assets\Js;
use Illuminate\Support\ServiceProvider;
use PragmaRX\Google2FAQRCode\Google2FA;

class AppServiceProvider extends ServiceProvider {
    /**
    * Register any application services.
    */

    public function register(): void {
        $this->app->bind( Google2FA::class, MyGoogle2FA::class );
    }

    /**
    * Bootstrap any application services.
    */

    public function boot(): void {
        FilamentAsset::register( [
            // Local asset build using Vite
            // Js::make( 'sweetalert2', Vite::asset( 'resources/js/sweetalert2.js' ) ),

            // Or via CDN
            Js::make( 'sweetalert2', 'https://cdn.jsdelivr.net/npm/sweetalert2@11' ),
        ] );
    }
}