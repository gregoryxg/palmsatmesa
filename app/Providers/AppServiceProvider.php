<?php

namespace App\Providers;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Validator;
use Snipe\BanBuilder\CensorWords;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);

        Validator::extend('profanity', function($attr, $value){
            $censor = new CensorWords;
            $string = $censor->censorString($value, true);

            if ($string['orig'] !== $string['clean']) {
                return false; // Error
            }
            return true;
        });
    }
}
