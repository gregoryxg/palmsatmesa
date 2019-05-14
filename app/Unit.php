<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    public function User()
    {
        return $this->hasMany(User::class);
    }
}