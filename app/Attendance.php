<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{

    protected $guarded = ['id'];
 
    public function employe(){
        return $this->belongsTo(Employe::class);
    }

    protected $fillable = [
        'heure_arriver',
        'heure_deppart',
    ];
}
