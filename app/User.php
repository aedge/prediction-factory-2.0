<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function predictions() {
        return $this->hasMany(Prediction::class);
    }
    
    public function leagues() {
        return $this->belongsToMany(League::class, 'user_leagues');

    }
    
    public function createdLeagues() {
        return $this->hasMany(League::class);
    }
    
    public function competitions() {
        
        return $this->hasMany('user_competitions', 'user_id')
                    ->leftJoin('competitions', 'user_competitions.competition_id', '=', 'competitions.id')
                    ->select('competitions.*');


    }
}
