<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public function timeslot($date)
    {
        return $this->belongsTo(Timeslot::class);
    }
}
