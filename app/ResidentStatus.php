<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResidentStatus extends Model
{
    public function User()
    {
        return $this->hasMany(User::class);
    }
}
