<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function assigned_to()
    {
        return $this->belongsTo(User::class);
    }

    public function ticket_type()
    {
        return $this->belongsTo(TicketType::class);
    }

    public function add_comment()
    {

    }

    public function close()
    {
        $this->completed_at = date('Y-m-d H:i:s');

        $this->save();
    }
}
