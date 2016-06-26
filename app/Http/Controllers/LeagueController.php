<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Repositories\LeagueRepository;
use App\Repositories\CompetitionRepository;

class LeagueController extends Controller
{
    
    protected $leagues;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(LeagueRepository $leagues)
    {
        $this->middleware('auth');

        $this->leagues = $leagues;
    }

    /**
     * Display a list of all of the user's task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        
        $competitions = new CompetitionRepository();
        
        $leagues = $this->leagues->forUserWithMembers($request->user());
        
        foreach($leagues as $league) {
            if($league->creator_id == $request->user()->id){
                $league->isCreator = true;
            } else {
                $league->isCreator = false;
            }
            
        }
        return view('leagues.index', ['leagues' => $leagues, 'competitions' => $competitions->allActive(),]);
    }
    
    
    public function create(){
        
        $competitions = new CompetitionRepository();
        
        return view('leagues.add', [
            'competitions' => $competitions->allActive(),
        ]);
        
    }
    
    /** 
     * Store League 
     * 
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
                        'name' => 'required|max:255',
                        'competition_id' => 'required|integer'
                        ]);
                        
        $request->user()->leagues()->create([
            'name'        => $request->name,
            "description" => $request->description,
            "creator_id"  =>  $request->user()->id,
            "competition_id" => $request->competition_id,
        ]);
        
        return redirect('/leagues');

    }
    
    public function join(Request $request) 
    {
        $this->validate($request, [
                        'code' => 'required|max:255'
                        ]);
        
        $league = $this->leagues->forCode($request->code);
        
        if(is_null($league)) {
            
        } else {
            
            $user_league = $league->members()->where('user_id', $request->user()->id)->first();
           
            if(is_null($user_league)) {
                $league->members()->attach($request->user());
                $league->save();
            }
        }
        
        return redirect('/leagues');
                        
                        
    }
}
