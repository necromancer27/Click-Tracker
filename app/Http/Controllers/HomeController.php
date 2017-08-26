<?php

namespace App\Http\Controllers;

use App\Classes\BrowserInterval;
use App\Classes\OSInterval;
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

        $start = Carbon::createFromFormat('Y-m-d H:i:s','1900-1-1 00:00:00');
        $end = Carbon::createFromFormat('Y-m-d H:i:s','2100-1-1 00:00:00');

        if($request->has('from')){
            $start = Carbon::createFromFormat('Y-m-d H:i:s',$request->from);
        }
        if($request->has('to')){
            $end = Carbon::createFromFormat('Y-m-d H:i:s',$request->to);
        }

        if($request->has('id'))
            return $this->singleTracker($request,$start,$end);

        $browser_qry = new BrowserInterval();
        $os_qry = new OSInterval();
        $browser_qry->setInterval($start,$end);
        $os_qry->setInterval($start,$end);

        $t_controller = new TrackerController;
        $t_ids =  $t_controller->index();
        $request->request->add(['id' => 0]);

        $trackers = array();
        foreach($t_ids as $t_id){
            $request->merge(['id' => $t_id]);
            $trackers[] = $this->singleTracker($request,$start,$end);
        }

        if($request->type) {
            $browsers = $browser_qry->executeClick();
            $os = $os_qry->executeClick();
            return view('clicks', compact('trackers','browsers','os'));
        }
        else {
            $browsers = $browser_qry->executeOpen();
            $os = $os_qry->executeOpen();
            return view('opens', compact('trackers','browsers','os'));
        }
    }


    public function singleTracker($request,$start,$end){

        if(!(Tracker::where('t_id','=',$request->id)->first()))
            return "Invalid tracker";

        if(!$request->type) {
            $t_controller = new TrackerController;
            return $t_controller->interval($request->id,$start,$end);
        }
        else{
            $clk_controller = new ClicksController;
            return $clk_controller->interval($request->id,$start,$end);
        }
    }
}
