<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\Factory;
use App\Competition;
use App\Group;
use App\Event;
use App\EventOption;

class GenerateEuro2016 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generateeuro2016';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Euro 2016 Competition';

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
    public function handle()
    {
        $competition = Competition::firstOrCreate([
                                                    "name" => "Euro 2016",
                                                    "type" => "Football",
                                                    "startdate" => "2016-06-10",
                                                    "enddate" => "2016-07-10"
                                                 ]);
    
        $groupA = Group::firstOrCreate([
                                        "name" => "Group A",
                                        "competition_id" => $competition->id,
                                        "startdate" => "2016-06-10",
                                        "enddate" => "2016-06-19"
                                      ]);
        $groupB = Group::firstOrCreate([
                                        "name" => "Group B",
                                        "competition_id" => $competition->id,
                                        "startdate" => "2016-06-11",
                                        "enddate" => "2016-06-20"
                                      ]);
        $groupC = Group::firstOrCreate([
                                        "name" => "Group C",
                                        "competition_id" => $competition->id,
                                        "startdate" => "2016-06-12",
                                        "enddate" => "2016-06-21"
                                      ]);
        $groupD = Group::firstOrCreate([
                                        "name" => "Group D",
                                        "competition_id" => $competition->id,
                                        "startdate" => "2016-06-12",
                                        "enddate" => "2016-06-21"
                                      ]);
         $groupE = Group::firstOrCreate([
                                        "name" => "Group E",
                                        "competition_id" => $competition->id,
                                        "startdate" => "2016-06-13",
                                        "enddate" => "2016-06-22"
                                      ]);
         $groupF = Group::firstOrCreate([
                                        "name" => "Group F",
                                        "competition_id" => $competition->id,
                                        "startdate" => "2016-06-14",
                                        "enddate" => "2016-06-22"
                                      ]);
                                      
         $groupAll = Group::firstOrCreate([
                                        "name" => "Overall",
                                        "competition_id" => $competition->id,
                                        "startdate" => "2016-06-10",
                                        "enddate" => "2016-07-10"
                                      ]);
         $groupAll = Group::firstOrCreate([
                                        "name" => "Round of 16",
                                        "competition_id" => $competition->id,
                                        "startdate" => "2016-06-25",
                                        "enddate" => "2016-06-27"
                                      ]);
          $groupAll = Group::firstOrCreate([
                                        "name" => "Quarter Finals",
                                        "competition_id" => $competition->id,
                                        "startdate" => "2016-06-30",
                                        "enddate" => "2016-07-03"
                                      ]);
                                      
          $groupAll = Group::firstOrCreate([
                                        "name" => "Semi Finals",
                                        "competition_id" => $competition->id,
                                        "startdate" => "2016-07-06",
                                        "enddate" => "2016-07-07"
                                      ]);
                                      
          $groupAll = Group::firstOrCreate([
                                        "name" => "Final",
                                        "competition_id" => $competition->id,
                                        "startdate" => "2016-07-10",
                                        "enddate" => "2016-07-10"
                                      ]);
                                      
                                      
        $file = "/home/ubuntu/workspace/storage/app/euros.txt";
        
        $strings = array();
		// Create output device and write CSV.
		if (($input_fp = fopen($file, 'r')) === FALSE) {
			$this->error('Can\'t open the input file!');
		}
		
		while (($data = fgets($input_fp)) !== FALSE) {
			
			$entries = explode(" ", trim($data));
            //print_r($entries);
            if(sizeof($entries) >= 5){
			    
    			if($entries[3] == "Group"){
    			    $currentGroupName = "Group " . $entries[4];
    			    $currentGroup = $competition->groups()->where('name', '=', $currentGroupName)->first();
    	            //$this->info($currentGroup->name);		    
    			}
    			
    		    if((sizeof($entries) >= 9) && ($entries[4] == 'vs')){
    		        //print_r(explode("/", $entries[1]));
    		        
    		        $day = explode("/", $entries[1])[1];
    		        $nextEntry = "";
    		        $eventName = "";
    		        $eventDesc = "";
    		        $i = 3;
    		        while($nextEntry != '@'){
    		            $entry = $entries[$i];
    		            $eventName .= " " . $entry;
    		            $i++;
    		            $nextEntry = $entries[$i];
    		        }
    		        while($i < sizeof($entries)){
    		            $eventDesc .= " " . $entries[$i];
    		            $i++;
    		        }
    		        
    		        $eventDesc = $entries[2] . $eventDesc;
    		        
    		        $eventName = trim($eventName);
    		        $eventDesc = trim($eventDesc);
    		        $date = "2016-06-" . $day;
    		        
    		        $this->comment($currentGroup->name);
    		        $this->comment($date);
    		        $this->comment($eventName);
    		        $this->comment($eventDesc);
    		        
    		        $newEvent = new Event(["eventname" => $eventName,
    		                              "eventnote" => $eventDesc,
    		                              "date" => $date]);
    		                              
                    $newEvent = $currentGroup->events()->save($newEvent);
                    
                    $options = array(
                                    new EventOption(['text' => 'homescore', 'datatype' => 'integer']),
                                    new EventOption(['text' => 'awayscore', 'datatype' => 'integer']),
                                    new EventOption(['text' => 'result', 'datatype' => 'string', 'possibleanswers' => 'HW|AW|D']),
                                );
                                
                    $newEvent->eventOptions()->saveMany($options);
    		        
    		 
    		    }	
			}
    			
			
			
		}
		fclose($input_fp);
		
    }
}
