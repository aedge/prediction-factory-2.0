<?php

namespace App\Repositories;

use App\User;
use App\Competition;


class PredictionRepository
{
    /**
     * Get all of the Predictions for a given user.
     *
     * @param  User  $user
     * @return Collection
     */
    public function forUser(User $user)
    {
        return $user->predictions()
                    ->orderBy('competition_id', 'asc')
                    ->get();
    }
    
    public function forUserCompetition(User $user, Competition $competition) 
    {
        return $user->predictions()->eventoption()->event()->where('competition_id', $competition->id)->get();
        
    }
    
}