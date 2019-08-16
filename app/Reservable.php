<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservable extends Model
{
    public function timeslots()
    {
        return $this->belongsToMany(Timeslot::class);
    }
    
    public function active_timeslots()
    {
        return $this->belongsToMany(Timeslot::class)->where(['timeslots.active'=>true])->wherePivot('active',true);
    }
}
