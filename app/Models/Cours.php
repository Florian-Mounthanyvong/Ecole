<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cours extends Model
{
    use HasFactory;
    function formation(){
        return $this->belongsTo(Formation::class, 'formation_id');
    }


    function users(){
        return $this->belongsToMany(User::class, 'cours_users', 'cours_id', 'user_id');
    }

    function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    function plannings(){
        return $this->hasMany(Planning::class,'cours_id');
    }

}
