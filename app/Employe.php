<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Attendance;
class Employe extends Model
{
    use Notifiable;

    protected $guarded = ['id'];

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }

    protected $fillable = [
        'firstName',
        'lastName',
        'contact'
    ];
}
