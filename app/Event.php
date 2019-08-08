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
        'agree_to_terms',
        'esign_consent',
        'user_id',
        'event_type_id',
        'stripe_charge_id',
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

        $event_count = $this->user->unit->events_in_date_range->count();

        $checkExisting = Event::where(['date'=>$this->date, 'reservable_id'=>$this->reservable_id, 'timeslot_id'=>$this->timeslot_id])->get();

        $reservation_limit = $this->user->unit->reservation_limit;

        $existing_unit_events = $this->user->unit->events()->where([['date', '=', date('Y-m-d', strtotime($this->date))]])->get()->count();

        if ($existing_unit_events > 0)
        {
            return ['status'=>'errors',
                'response_msg'=>"Your unit already has a reservation for that date. Please select a different date."];
        }
        else if ($event_count >= $reservation_limit)
        {
            return ['status'=>'errors',
                'response_msg'=>"You have reached your limit (".$reservation_limit.") on future reservations ($event_count scheduled).
                 You will need to delete some, or wait until the next one has passed."];
        }
        else if(count($checkExisting) > 0)
        {
            return ['status'=>'errors',
                'response_msg'=>'A reservation for that location at that date and time already exists.'];
        }
        else
        {
            return ['status'=>'success'];
        }
    }
}
