<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Repositories\GroupRepository;
use App\Repositories\EventRepository;
use App\Repositories\CompetitionRepository;
use App\EventOption;
use App\Prediction;
use Response;
use DB;

class ApiController extends Controller
{
    
    protected $groups;
    protected $events;
    protected $competitions;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(GroupRepository $groups, 
                                EventRepository $events, 
                                CompetitionRepository $competitions)
    {
        $this->middleware('auth');

        $this->groups = $groups;
        $this->events = $events;
        $this->competitions = $competitions;
    }

    public function competitionGroups(Request $request, $id)
    {
        $groups = $this->groups->forCompetitionId($id);
        
        return Response::json($groups);
        
        
    }
    
    public function groupEvents(Request $request, $groupid){
        
        $events = $this->events->forGroupWithPredictionsId($groupid, $request->user()->id);

        $outputEvents = array();
        
        foreach($events as $event){
            if($event->eventtype == "footballmatch"){
                $nameDetails = explode("vs", $event->eventname);
                $outputEvent = array(
                                    'id'       => $event->id,
                                    'hometeam' => trim($nameDetails[0]),
                                    'awayteam' => trim($nameDetails[1]),
                                    'notes'    => $event->eventnote,
                                    'type'     => $event->eventtype    
                                 );
            }
            else if($event->eventtype == "textbox"){
                $outputEvent = array(
                                    'id'       => $event->id,
                                    'name'  => $event->eventname,
                                    'notes' => $event->eventnote,
                                    'type'  => $event->eventtype    
                                 );
            }
            
            $pointsScored = 0;
            $todaysDate  = date("Y-m-d");
            if($todaysDate >= $event->date){
                $outputEvent['disabled'] = 'true';
            } else {
                $outputEvent['disabled'] = 'false';
            }
            
            $tempDate = date_create($event->date);
            $outputEvent['date'] = date_format($tempDate, 'l jS F Y');
            
            foreach($event->eventoptions as $eventoption){
                $optionName = $eventoption->text;
                $optionPred = '';
                if(isset($eventoption->predictions)){
                    foreach($eventoption->predictions as $pred){
                        $optionPred = $pred->predictionvalue;
                        $pointsScored += $pred->pointsscored;
                    }
                }
                
                $outputEvent[$optionName] = $optionPred;
                $outputEvent['points'] = $pointsScored;
            }
            array_push($outputEvents, $outputEvent);
        }
        
        return Response::json($outputEvents);
        
    }
    
    public function groupResults(Request $request, $groupid){
        
        $events = $this->events->forGroupId($groupid);

        $outputEvents = array();
        
        foreach($events as $event){
            if($event->eventtype == "footballmatch"){
                $nameDetails = explode("vs", $event->eventname);
                $outputEvent = array(
                                    'id'       => $event->id,
                                    'hometeam' => trim($nameDetails[0]),
                                    'awayteam' => trim($nameDetails[1]),
                                    'notes'    => $event->eventnote,
                                    'type'     => $event->eventtype    
                                 );
            }
            else if($event->eventtype == "textbox"){
                $outputEvent = array(
                                    'id'       => $event->id,
                                    'name'  => $event->eventname,
                                    'notes' => $event->eventnote,
                                    'type'  => $event->eventtype    
                                 );
            }
            
            $pointsScored = 0;
            $todaysDate  = date("Y-m-d");
            if($todaysDate >= $event->date){
                $outputEvent['disabled'] = 'true';
            } else {
                $outputEvent['disabled'] = 'false';
            }
            
            $tempDate = date_create($event->date);
            $outputEvent['date'] = date_format($tempDate, 'l jS F Y');
            
            foreach($event->eventoptions as $eventoption){
                $optionName = $eventoption->text;
                $optionresult = $eventoption->result;
                
                $outputEvent[$optionName] = $optionresult;
            }
            array_push($outputEvents, $outputEvent);
        }
        
        return Response::json($outputEvents);
        
    }
    
    public function userCompetitions(Request $request)
    {
        $activeCompetitions = $this->competitions->allActive();
        
        return Response::json($activeCompetitions);
    }
    
    public function storePrediction(Request $request)
    {
        if ($request->isJson())
        {
            $eventid = $request->input('id');
            
            $eventoptions = DB::table('event_options')->where('event_id', '=', $eventid)->get();
            
            foreach($eventoptions as $eventoption)
            {
                $prediction = Prediction::firstOrNew([
                                        "user_id" => $request->user()->id,
                                        "event_option_id" => $eventoption->id,
                                      ]);
                $prediction->predictionvalue = $request->input($eventoption->text);
                if($prediction->predictionvalue == null){
                   $prediction->predictionvalue = ""; 
                }
                
                $prediction->save();
            }
            
            
            return response()->json(['success' => $eventoptions]);
        }
        return response()->json(['success' => 'false']);
    }
    
    public function storeResult(Request $request)
    {
        if ($request->isJson())
        {
            $eventid = $request->input('id');
            
            $eventoptions = EventOption::where('event_id', '=', $eventid)->get();
            
            foreach($eventoptions as $eventoption)
            {
                $eventoption->result = $request->input($eventoption->text);
                if($eventoption->result == null){
                   $eventoption->result = ""; 
                }
                
                $eventoption->save();
            }
            
            
            return response()->json(['success' => $eventoptions]);
        }
        return response()->json(['success' => 'false']);
    }
    
    public function processResults(Request $request)  {
        
        $success = $this->events->processResults();
        
        return response()->json(['success' => $success]);
        
    }
}
