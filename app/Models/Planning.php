<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planning extends Model
{
    use HasFactory;
    public $timestamps = false;
    function cour(){
        return $this->belongsTo(Cours::class, 'cours_id');
    }

}
