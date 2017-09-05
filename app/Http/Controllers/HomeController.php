<?php

namespace App\Http\Controllers;

use App\Classes\BrowserInterval;
use App\Classes\CountIntervalForAll;
use App\Classes\OSInterval;
use App\Classes\UniqueIntervalForAll;
use App\clicks;
use App\Records;
use App\tracker;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


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

        $qry = new UniqueIntervalForAll();
        $qry2 = new CountIntervalForAll();
        $qry->setInterval($start,$end);
        $qry2->setInterval($start,$end);

        if($request->type) {
            $totals = $qry2->executeClick();
            $uniques = $qry->executeClick();
            $trackers = $this->merge($totals,$uniques);
            $browsers = $browser_qry->executeClick();
            $os = $os_qry->executeClick();
            return view('clicks', compact('trackers','browsers','os'));
        }
        else {
            $totals = $qry2->executeOpen();
            $uniques = $qry->executeOpen();
            $trackers = $this->merge($totals,$uniques);
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


    // utility function
    public function merge($totals,$uniques)
    {

        $arr = array();

        foreach ($totals as $key => $value) {
            $obj = new \stdClass();
            $obj->t_id = $value->id;
            $obj->total = $value->total;
            $arr[] = $obj;
        }

        $i = 0;
        foreach ($uniques as $key => $value) {
            $arr[$i]->unique = $value->total;
            $i++;
        }

        return $arr;

    }


    // Generate Data for strength testing
    public function trackerCreater(Request $request){

        for($i=0;$i<10000;$i++){
            $tracker = new tracker;

            do{
                $tr_id = rand(0,100000000);
            }while(tracker::where('t_id','=',$tr_id)->first());

            $tracker->t_id = $tr_id;
            $tracker->c_id = Auth::user()->id;

            $tracker->save();

            $count = rand(0,200);

            for($i = 0;$i<$count;$i++){
                $record = new Records;

                $record->t_id = $tr_id;
                $record->ip_address = '127.0.0.1';
                $record->Browser = 'Chrome';
                $record->OS = 'Windows';
                $record->Device = 'Others';
                $record->Time = Carbon::now();

                $record->save();
            }

            $count = rand(0,200);

            for($i = 0;$i<$count;$i++){
                $record = new Clicks;

                $record->t_id = $tr_id;
                $record->ip_address = '127.0.0.1';
                $record->Browser = 'Chrome';
                $record->OS = 'Windows';
                $record->Device = 'Others';
                $record->Time = Carbon::now();

                $record->save();
            }
        }
    }

}
