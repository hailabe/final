<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class producer extends Authenticatable
{
    use Notifiable;

    protected $guard='producer';

    protected $fillable=[
        'name','email','password','phoneNo'
    ];

    protected $hidden=[
        'password'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
