<?php

namespace App\Repositories;

use App\Competition;

class CompetitionRepository
{
    /**
     * Get all of the Competitions for a given user.
     *
     * @param  User  $user
     * @return Collection
     */
    public function allActive()
    {
        return Competition::where('enddate', '>=', date('Y-m-d'))
                                ->orderBy('name', 'asc')
                                ->get();
    }
}