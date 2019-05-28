<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Committee extends Model
{
    public function ticket_types()
    {
        return $this->hasMany(TicketType::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
