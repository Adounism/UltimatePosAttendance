<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Device extends Model
{
    use Notifiable;

    protected $guarded = ['id'];

    protected $fillable = [
        'macAddress',
        'platform',
        'enabled',
    ];
}
