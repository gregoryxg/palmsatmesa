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
}
