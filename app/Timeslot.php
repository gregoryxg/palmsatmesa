<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timeslot extends Model
{
    public function reservables()
    {
        return $this->belongsToMany(Reservable::class);
    }
}
