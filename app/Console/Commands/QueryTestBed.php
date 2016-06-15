<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\Factory;
use App\Repositories\EventRepository;
use App\Competition;
use App\Prediction;
use App\Event;
use App\EventOption;

class QueryTestBed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'querytestbed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Query Test Bed';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        
        parent::__construct();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(){
        
        $er = new EventRepository();
        $comp = Competition::find(2);
        
        print_r($comp);
        
        $events = $er->forCompetition($comp);
        
        
        
        print_r($events);
    }
}