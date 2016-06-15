<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prediction extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['event_option_id','user_id','predictionvalue','pointsscored','multiplier'];
    
    public function eventoption() {
        return $this->belongsTo(EventOption::class);
    }
    
    public function user() {
        return $this->belongsTo(User::class);
    }
}