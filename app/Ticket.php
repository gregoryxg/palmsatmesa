<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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

    public function validate_user(User $user)
    {
        $user_follows_ticket = $this->users()->where(['user_id'=>$user->id])->count();

        $user_in_ticket_type_committee = $this->ticket_type->committee->users()->where(['user_id'=>$user->id])->get()->count();

        if ($user_follows_ticket == 0 && $user_in_ticket_type_committee == 0)
        {
            return false;
        }

        return true;
    }

    public function assign($user_id)
    {

    }

    public function follow($ticket_id, $user_id)
    {

    }

    public function close()
    {
        $this->completed_at = date('Y-m-d H:i:s');

        $this->save();
    }
}
