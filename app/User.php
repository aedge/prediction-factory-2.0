<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function predictions() {
        return $this->hasMany(Prediction::class);
    }
    
    public function leagues() {
        return $this->belongsToMany(League::class, 'user_leagues');

    }
    
    public function createdLeagues() {
        return $this->hasMany(League::class);
    }
    
    public function competitions() {
        
        return $this->hasMany('user_competitions', 'user_id')
                    ->leftJoin('competitions', 'user_competitions.competition_id', '=', 'competitions.id')
                    ->select('competitions.*');


    }
    
    public function roles() {
        return $this->belongsToMany('Role', 'users_roles');
    }
    
    /**
      * Find out if User is an employee, based on if has any roles
      *
      * @return boolean
      */
    public function isEmployee()
    {
        $roles = $this->roles->toArray();
        return !empty($roles);
    }
    
    
     /**
      * Find out if user has a specific role
      *
      * $return boolean
      */
     public function hasRole($check)
     {
         return in_array($check, array_fetch($this->roles->toArray(), 'name'));
     }
 
     /**
      * Get key in array with corresponding value
      *
      * @return int
      */
     private function getIdInArray($array, $term)
     {
         foreach ($array as $key => $value) {
             if ($value == $term) {
                 return $key;
             }
         }
 
         throw new UnexpectedValueException;
     }
 
     /**
      * Add roles to user to make them a concierge
      */
     public function makeEmployee($title)
     {
         $assigned_roles = array();
 
         $roles = array_fetch(Role::all()->toArray(), 'name');
 
         switch ($title) {
             case 'system_admin':
                 
             case 'league_admin':
                 $assigned_roles[] = $this->getIdInArray($roles, 'enter_results');
             case 'user':
                 $assigned_roles[] = $this->getIdInArray($roles, 'enter_predictions');
                 $assigned_roles[] = $this->getIdInArray($roles, 'view_league_predictions');
                 break;
             default:
                 throw new \Exception("The employee status entered does not exist");
         }
 
         $this->roles()->attach($assigned_roles);
     }
}
