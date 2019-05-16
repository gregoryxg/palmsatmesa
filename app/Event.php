<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
        'reserved_from_ip_address'
        ];

    public function timeslot($date)
    {
        return $this->belongsTo(Timeslot::class);
    }
}
