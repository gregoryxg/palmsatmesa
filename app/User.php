<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
/*use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;*/

//class User extends Model implements AuthenticatableContract {
class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    //use Authenticatable;

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
