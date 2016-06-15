<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventOption extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['text','datatype','possibleanswers','result'];
    
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    
    public function predictions() {
        return $this->hasMany(Prediction::class);
    }

}
