<?php

namespace App\Providers;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Validator;
use Snipe\BanBuilder\CensorWords;
use App\User;
use App\Event;
use DB;
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

      Validator::extend('unit_events', function ($attribute, $value) {

            $user = User::findOrFail(Auth::user()->id);

            $futureEvents = $user->unit->events()
                ->where('date', '>=', date('Y-m-d'))
                ->where('cancelled_at', '=', null)
                ->get();

            if (count($futureEvents) >= config('event.maxEvents')) {
                return false;
            }
            else {
                return true;
            }
      });

      Validator::extend('event_buffer', function ($attribute, $value) {

            $user = User::findOrFail(Auth::user()->id);

            $events = $user->unit->events()
                ->where('cancelled_at', '=', null)
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

      Validator::extend('duplicate_event', function($attribute, $value, $parameters, $validator) {

        $reservable_id = $validator->getData()['reservable_id'];

        $checkExisting = Event::where('date', '=', date('Y-m-d', strtotime($value)))
        ->where('cancelled_at', '=', null)
        ->where('reservable_id', '=', $reservable_id)
        ->where(function ($query) use ($validator) {

            $start_time = date('H:i:s', strtotime('-1 hour', strtotime($validator->getData()['start_time'])));

            $end_time = date('H:i:s', strtotime('+1 hour', strtotime($validator->getData()['end_time'])));

            $start_time_end = date('H:i:s', strtotime('-1 second', strtotime($end_time)));

            $end_time_start = date('H:i:s', strtotime('+1 second', strtotime($start_time)));

            $query->whereBetween('start_time', [
                $start_time,
                $start_time_end
            ])
            ->orWhereBetween('end_time', [
                $end_time_start,
                $end_time
            ]);
        })->get();

        if (!$checkExisting->isEmpty())
            return false;
        else
            return true;

      });
    }
}
