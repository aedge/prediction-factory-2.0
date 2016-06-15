<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['eventname','eventnote','date'];
    
    public function group()
    {
        return $this->belongsTo(Group::class);
    }
    
    public function eventoptions()
    {
        return $this->hasMany(EventOption::class);
    }
}
