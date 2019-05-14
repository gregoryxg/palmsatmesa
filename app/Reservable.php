<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservable extends Model
{
    public function timeslots()
    {
        return $this->belongsToMany(Timeslot::class);
    }
}
