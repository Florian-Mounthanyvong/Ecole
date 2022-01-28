<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    public $timestamps = false;
    protected $hidden = ['mdp'];
    protected $fillable = ['login', 'mdp', 'nom','prenom','formation_id'];
    protected $attributes = [ 'type' => 'NULL'];

    public function getAuthPassword()
    {
        return $this->mdp;
    }
    public function isAdmin(){
        return $this->type == 'admin';
    }
    public function isEtudiant(){
        return $this->type == 'etudiant';
    }
    public function isEnseignant(){
        return $this->type == 'enseignant';
    }
    function cours(){
        return $this->belongsToMany(Cours::class, 'cours_users', 'user_id', 'cours_id');
    }
    function cour(){
        return $this->hasMany(Cours::class,'user_id');
    }
    public function plannings()
    {
        return $this->hasManyThrough(
            Planning::class,
            Cours::class,
            'user_id',
            'cours_id',
            'id',
            'id'
        );
    }

    function formation(){
        return $this->belongsTo(Formation::class, 'formation_id');
    }


}
