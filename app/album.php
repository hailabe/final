<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class album extends Model
{
    use Notifiable;

    protected $fillable=[
        'album_name','album_artist','producer','release_date',
        'album_art','price','rating','album_des','album_path',
    ];

    protected $hidden=[
        
    ];

    protected $casts = [
        
    ];
}
