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
        
        Validator::extend('date_multi_format', function($attribute, $value, $formats) {
        // iterate through all formats
        foreach($formats as $format) {

          // parse date with current format
          $parsed = date_parse_from_format($format, $value);

          // if value matches given format return true=validation succeeded 
          if ($parsed['error_count'] === 0 && $parsed['warning_count'] === 0) {
            return true;
          }
        }

        // value did not match any of the provided formats, so return false=validation failed
        return false;
      });
    }
}
