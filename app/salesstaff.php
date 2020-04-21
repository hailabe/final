<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class salesstaff extends Authenticatable
{
    use Notifiable;

    protected $guard='salesstaff';

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
