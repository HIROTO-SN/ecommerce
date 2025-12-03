<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Contracts\TwoFactorChallengeViewResponse;
use Laravel\Fortify\Http\Responses\SimpleViewResponse;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(TwoFactorChallengeViewResponse::class, function () {
            return new SimpleViewResponse('livewire.auth.two-factor.two-factor-challenge');
        });
    }

    public function boot()
    {
        Fortify::twoFactorChallengeView(function () {
            return view('livewire.auth.two-factor.two-factor-challenge');
        });
    }
}