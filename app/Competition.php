<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','type','currentgroup','startdate','enddate'];

    
    public function groups() {
        return $this->hasMany(Group::class);
    }
    
    public function leagues() {
        return $this->belongsToMany('App\League');
    }
    
    public function events() {
        return $this->hasManyThrough('App\Event', 'App\Group');
    }
}