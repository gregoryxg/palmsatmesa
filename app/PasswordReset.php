<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    protected $fillable = ['email', 'token', 'expires_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }
}
