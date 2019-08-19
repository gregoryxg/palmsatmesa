<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timeslot extends Model
{
    protected $fillable = ['start_time', 'end_time', 'active'];
    
    public function reservables()
    {
        return $this->belongsToMany(Reservable::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
