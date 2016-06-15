<?php

namespace App\Repositories;

use App\User;
use App\League;

class LeagueRepository
{
    /**
     * Get all of the Leagues for a given User.
     *
     * @param  User  $user
     * @return Collection
     */
    public function forUser(User $user)
    {
        return $user->leagues()
                    ->with('competition')
                    ->get();
    }
        
    public function forUserWithMembers(User $user)
    {
        return $user->leagues()
                    ->with('competition')
                    ->with('memberScores')
                    ->get();
    }
    
    public function forCode($code) {
        return League::where('password', '=', $code)->with('members')->first();
    }
    
}