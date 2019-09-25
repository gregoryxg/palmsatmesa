<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Validator;
use Auth;

class Event extends Model
{
    protected $fillable = [
        'title',
        'size',
        'date',
        'reservable_id',
        'start_time',
        'end_time',
        'reservation_fee',
        'security_deposit',
        'agree_to_terms',
        'esign_consent',
        'user_id',
        'event_type_id',
        'stripe_charge_id',
        'stripe_receipt_url',
        'reserved_from_ip_address'
        ];

    public function timeslot()
    {
        return $this->belongsTo(Timeslot::class);
    }

    public function reservable()
    {
        return $this->belongsTo(Reservable::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function verify($event_type)
    {
        $this->user_id = Auth::id();

        $this->reserved_from_ip_address = Request()->ip();

        $this->event_type_id = EventType::where(['type' => $event_type])->first()->id;

        return ['status'=>'success'];
    }

    public static function checkReservationEligibility(Array $eventParameters)
    {
        $user = User::findOrFail(Auth::user()->id);

        if (!$user->unit->reservations_allowed)
        {
            return ['errors'=>'Your unit (' . $user->unit_id . ') is not permitted to add events to the calendar.'];
        }

        if (!$user->account_approved)
        {
            return ['errors'=>'Your account has not been approved yet.'];
        }

        try {
            $futureEvents = $user->unit->events()
                ->where('date', '>=', date('Y-m-d'))
                ->orderBy('date')
                ->get();

            if (count($futureEvents) >= $eventParameters['maxEvents'])
            {
                return ["errors"=>"You have reached your unit's maximum number of future events (" . $eventParameters['maxEvents'] . "). You must wait for some to pass, or cancel some."];
            }

            $eventParameters['minDate'] = date('Y-m-d', strtotime("+" . $eventParameters['advanceDays'] . " days"));

            $events = $user->unit->events()
                ->where('date', '>=', date('Y-m-d', strtotime('-' . ($eventParameters['daysPerEvent']-1) .' days', strtotime($eventParameters['minDate']))))
                ->orderBy('date')
                ->get();

            if (!empty($events))
            {
                foreach ($events as $event)
                {
                    do {
                        if ($event->date > $eventParameters['minDate'])
                            $daysBetween = (strtotime($event->date) - strtotime($eventParameters['minDate']));
                        else
                            $daysBetween = (strtotime($eventParameters['minDate']) - strtotime($event->date));

                        $daysBetween = round($daysBetween / (60*60*24));

                        //echo "Event: $event->date - minDate: $eventParameters['minDate'] - DaysBetween: $daysBetween<br/>";

                        if ($daysBetween < 30)
                        {
                            $eventParameters['minDate'] = date('Y-m-d', strtotime("+1 day", strtotime($eventParameters['minDate'])));
                        }

                    } while($daysBetween < $eventParameters['daysPerEvent']);
                }
            }

            if ($eventParameters['minDate'] > date('Y-m-d', strtotime("+" . $eventParameters['maxRange'] . " days")))
            {
                return ["errors"=>"Your future reservations do not allow for any reservable times in the next " . $eventParameters['maxRange'] . " days. You must cancel some to create more (only 1 reservation allowed every " . $eventParameters['daysPerEvent'] . " day period."];
            }

            $eventParameters['locations'] = Reservable::where([['active','=',true]])->get();

            return $eventParameters;

        } catch (Exception $ex)
        {
            return ["errors"=>"Something went wrong...cannot create a new reservation at this time. Please contact support."];
        }
    }

    public function confirm()
    {
        $validator = Validator::make($this->toArray(), [
                'title' => ['required', 'string', 'max:50'],
                'date' => [
                    'required',
                    'date_format:Y-m-d',
                    'after_or_equal:'.date('Y-m-d', strtotime("+7 days")),
                    'before_or_equal:'.date('Y-m-d', strtotime("+".config('event.maxRange') . " days")),
                    'event_buffer:true',
                    'duplicate_event:true',
                    'unit_events:true'
                ],
                'start_time' => ['required', 'date_format:g:i A', 'before:end_time', 'after_or_equal:9:00 AM', 'before_or_equal:8:00 PM'],
                'end_time' => ['required', 'date_format:g:i A', 'after:start_time', 'after_or_equal:10:00 AM', 'before_or_equal:9:00 PM', 'event_duration:true'],
                'reservable_id' => ['required', 'integer', 'exists:reservables,id'],
                'size' => ['required', 'integer', 'min:1', 'max:'.Reservable::find($this->reservable_id)->guest_limit],
                'agree_to_terms' => ['accepted'],
                'esign_consent' => ['accepted']
            ],
            [

                'start_time.before'=>'The start time must be before the end time',

                'end_time.after'=>'The end time must be after the start time',

                'date.event_buffer'=>'Reservation date must not be within ' . config('event.daysPerEvent') . ' days of another event for your unit.',

                'end_time.event_duration'=>'Reservations must not exceed 4 hours.',

                'size.max'=>'The maximum guests for the ' . Reservable::find($this->reservable_id)->description . ' is ' . Reservable::find($this->reservable_id)->guest_limit . '.',

                'date.duplicate_event'=>'There is an overlapping event at that time. Please check the calendar, and choose a new date and/or time.',

                'date.unit_events'=>"You have reached your unit's maximum number of future events (" . config('event.maxEvents') . "). You must wait for some to pass, or cancel some."

            ]
        );

        return $validator;
    }
}
