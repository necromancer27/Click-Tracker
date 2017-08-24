<?php

namespace App\Http\Controllers;

use App\tracker;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $t_controller = new TrackerController;
        $trackers = $t_controller->index();

        return view('home',compact('trackers'));
    }

    function multiTracker(Request $request){

        if(!$request->has('type'))
            return "Invalid Request type required";

        if($request->has('id'))
            return $this->singleTracker($request);

        $t_controller = new TrackerController;
        $t_ids =  $t_controller->index();
        $request->request->add(['id' => 0]);

        $trackers = array();
        foreach($t_ids as $t_id){
            $request->merge(['id' => $t_id]);
            $trackers[] = $this->singleTracker($request);
        }

        if($request->type)
            return view('clicks',compact('trackers'));
        else
            //return $trackers;
            return view('opens',compact('trackers'));
    }


    public function singleTracker(Request $request){

        if(!(Tracker::where('t_id','=',$request->id)->first()))
            return "Invalid tracker";

        $id = $request->id;
        $start = Carbon::createFromFormat('Y-m-d H:i:s','1900-1-1 00:00:00');
        $end = Carbon::createFromFormat('Y-m-d H:i:s','2100-1-1 00:00:00');

        if($request->has('from')){
            $start = Carbon::createFromFormat('Y-m-d H:i:s',$request->from);
        }
        if($request->has('to')){
            $end = Carbon::createFromFormat('Y-m-d H:i:s',$request->to);
        }

        if(!$request->type) {
            $t_controller = new TrackerController;
            return $t_controller->interval($id,$start,$end);
        }
        else{
            $clk_controller = new ClicksController;
            return $clk_controller->interval($id,$start,$end);
        }
    }
}
