<?php

namespace App\Repositories;

use App\Group;
use App\Competition;


class GroupRepository
{
    /**
     * Get all of the Groups for a given competition.
     *
     * @param  User  $user
     * @return Collection
     */
    public function forCompetition(Competition $competition)
    {
        return $competition->groups()
                           ->orderBy('startdate', 'asc')
                           ->get();
    }
    
    public function forCompetitionId($id)
    {
       return Competition::findOrFail($id)->groups()
                                        ->orderBy('startdate', 'asc')
                                        ->get(); 
        
    }
    
}