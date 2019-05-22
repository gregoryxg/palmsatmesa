<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TicketUser;

class Ticket extends Model
{
    protected $fillable = ['ticket_type_id', 'subject', 'body'];

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

    public function follow()
    {

    }

    public function close()
    {
        $this->completed_at = date('Y-m-d H:i:s');

        $this->save();
    }
}
