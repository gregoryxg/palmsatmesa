<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;

class Event extends Model
{
    protected $fillable = [
        'title',
        'size',
        'date',
        'reservable_id',
        'timeslot_id',
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
}
