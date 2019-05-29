<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    public function User()
    {
        return $this->hasMany(User::class);
    }

    public function events_in_date_range($DaysBefore = 30, $DaysAfter = 30)
    {
        return $this->hasManyThrough(Event::class, User::class)->where([
            ['date', '>=' , date('Y-m-d', strtotime('-' . $DaysBefore . ' Days'))],
            ['date', '<=' , date('Y-m-d', strtotime('+' . $DaysAfter . ' Days'))]
        ]);
    }

    public function events()
    {
        return $this->hasManyThrough(Event::class, User::class);
    }
}
