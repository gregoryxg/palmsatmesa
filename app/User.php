<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'unit_id',
        'gate_code',
        'resident_status_id',
        'mobile_phone',
        'home_phone',
        'work_phone',
        'email',
        'password'
    ];
}
