<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\League;

class LeagueCreateProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        League::created(function ($league) {
            
            $leaguePassword = md5($league->name . $league->id . date("dmYhis"));
            
            $league->password = $leaguePassword;
            
            $league->save();
    
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
