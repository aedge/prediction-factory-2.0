<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class League extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['competition_id','creator_id','description','name'];
    
    public function creator() {
        return $this->hasOne(User::class);
    }
    
    public function members() {
        return $this->belongsToMany('App\User', 'user_leagues');
    }
    
    public function memberScores() {
        return $this->belongsToMany('App\User', 'user_leagues')
                    ->leftJoin('user_competitions', 'user_competitions.user_id', '=', 'user_leagues.user_id')
                    ->select('users.*', 'user_competitions.totalpoints', 'user_competitions.accuracy')
                    ->orderBy('user_competitions.totalpoints');
            
    }
    
    public function competition() {
        return $this->belongsTo(Competition::class);
    }
    
}
