<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketType extends Model
{
    public function ticket()
    {
        return $this->hasMany(Ticket::class);
    }

    public function committee()
    {
        return $this->belongsTo(Committee::class);
    }
}
