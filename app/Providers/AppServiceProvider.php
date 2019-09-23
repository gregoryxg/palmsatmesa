<?php

namespace App\Providers;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Validator;
use Snipe\BanBuilder\CensorWords;
use App\User;
use Auth;

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

      Validator::extend('event_buffer', function ($attribute, $value) {

            $user = User::findOrFail(Auth::user()->id);

            $events = $user->unit->events()
                ->whereBetween('date', [
                    date('Y-m-d', strtotime('-' . (config('event.daysPerEvent')-1) .' days', strtotime($value))),
                    date('Y-m-d', strtotime('+' . (config('event.daysPerEvent')-1) .' days', strtotime($value)))
                ])->get();

            if (!$events->isEmpty())
                return false;
            else
                return true;
      });

      Validator::extend('event_duration', function($attribute, $value, $parameters, $validator) {

        $start_time = $validator->getData()['start_time'];

        $duration = (strtotime($value) - strtotime($start_time))/(60*60);

        if ($duration <= 4)
            return true;
        else
            return false;

      });
    }
}
