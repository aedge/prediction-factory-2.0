<?php

namespace App\Repositories;

use App\User;
use App\Competition;
use App\Group;
use App\EventOption;
use App\Prediction;


class EventRepository
{
    /**
     * Get all of the Predictions for a given user.
     *
     * @param  User  $user
     * @return Collection
     */
    public function forCompetition(Competition $competition)
    {
        return $competition->events()
                    ->orderBy('date', 'asc')
                    ->with('eventoptions.predictions')
                    ->get();
                    
                    
    }
    
    public function forGroup(Group $group) 
    {
        return $group->events()
                    ->orderBy('date', 'asc')
                    ->with('eventoptions')
                    ->get();
        
    }
    
    public function forGroupId($groupId) 
    {
        return Group::findOrFail($groupId)
                    ->events()
                    ->orderBy('date', 'asc')
                    ->with('eventoptions')
                    ->get();
        
    }
    
    
    public function forGroupWithPredictions(Group $group, User $user) {
        
        return $group->events()
                    ->orderBy('date', 'asc')
                    ->with(array('eventoptions.predictions' => function($query)
                                {
                                    $query->$query->where('user_id', '=', $user->id);
                                }))
                    ->get();
    }
    
    public function forGroupWithPredictionsId($groupId, $userId) {
        
        return Group::findOrFail($groupId)
                ->events()
                ->orderBy('date', 'asc')
                ->with(array('eventoptions.predictions' => function($query) use($userId)
                    {
                        $query->where('user_id', '=', $userId);
                    }))
                ->get();
    }
    
    public function processResults() {
        
        $eventOptions = EventOption::all();
        
        foreach($eventOptions as $eventOption) {
            $predictions = Prediction::where('event_option_id', $eventOption->id)->get();
            
            foreach($predictions as $prediction){
                if($prediction->predictionvalue == $eventOption->result){
                    $prediction->pointsscored = $eventOption->availablepoints;
                }
            }
            
            $eventOption->push();
        }
        
        $users = User::all();
        
        foreach($users as $user){
            $totalpoints = Prediction::where('user_id', $user->id)->sum('pointsscored');
            $user->totalpoints = $totalpoints;
            $user->save();
        }
        
        return true;
    }
}