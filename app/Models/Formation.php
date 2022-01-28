<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    use HasFactory;
    function cours(){
        return $this->hasMany(Cours::class,'formation_id');
    }

    function users(){
        return $this->hasMany(User::class,'formation_id');
    }

}
