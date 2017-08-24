<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tracker;
use App\Records;
use App\client;
use App\clicks;
use Illuminate\Support\Facades\Auth;
use UAParser\Parser;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\classes\count;
use App\classes\unique;
use App\classes\countInterval;
use App\classes\uniqueInterval;
use Carbon\Carbon;
use App\Http\Controllers\TrackerController;

class ClicksController extends Controller
{
    
	function click($tr_id){
		$click = new Clicks;
		$tracker = new tracker;
		$track = $tracker->where('t_id','=',$tr_id)->first();
		
		if($track){

			$valid = $click->where('t_id','=',$tr_id)
							->where('ip_address','=',$_SERVER['REMOTE_ADDR'])
							->where('Time','>',Carbon::now()->subMinute())
							->first();
			if($valid)
				return "Invalid Click ";
			
			$click->t_id = $tr_id;

			$click->ip_address = $_SERVER['REMOTE_ADDR'];

			$ua = $_SERVER['HTTP_USER_AGENT'];;
			$parser = Parser::create();
			$result = $parser->parse($ua);
			$click->browser = $result->ua->family;
			$click->os = $result->os->family;
			$click->device = $result->device->family;
			
			//$record->time = date("D dS M,Y h:i a");
			$click->Time = date("Y-m-d H:i:s");

			$click->save();
			//$track->save();
			//return redirect('http://www.google.com');
			return "redirect";
		}
		else
			return "Tracker not found";
	}



	function interval($id,$start,$end){

        $cquery = new countInterval($id);
        $cquery->setInterval($start,$end);

        $uquery = new uniqueInterval($id);
        $uquery->setInterval($start,$end);

        $respose = new \StdClass();
        $respose->id = $id;
        $respose->total_clicks = $cquery->executeClick();
        $respose->unique_clicks = $uquery->executeClick();
        $respose->Latest_click = $this->latest($id,$start,$end);

        if(!$respose->Latest_click)
            $respose->Latest_click = '---Not Available---';

		return $respose;
	}


	function rate(Request $request){

		if(!(Tracker::where('t_id','=',$request->id)->first()))
			return "Invalid tracker";

        if(!(Records::where('t_id','=',$request->id)->first()))
            return 0;

        $start = Carbon::createFromFormat('Y-m-d H:i:s','1900-1-1 00:00:00');
        $end = Carbon::createFromFormat('Y-m-d H:i:s','2100-1-1 00:00:00');

		if($request->type){
		    $uquery = new uniqueInterval($request->id);
		    $uquery->setInterval($start,$end);

		    return ($uquery->executeClick()/$uquery->executeOpen())*100;
        }
        else{
		    $cquery = new countInterval($request->id);
		    $cquery->setInterval($start,$end);

            return ($cquery->executeClick()/$cquery->executeOpen())*100;
        }

	}

	function clicked(){

        if(!(Tracker::where('t_id','=',$_SERVER['HTTP_ID'])->first()))
            return "Invalid tracker";

        $start = Carbon::createFromFormat('Y-m-d H:i:s','1900-1-1 00:00:00');
        $end = Carbon::createFromFormat('Y-m-d H:i:s','2100-1-1 00:00:00');

        if($_SERVER['HTTP_FROM']){
            $start = Carbon::createFromFormat('Y-m-d H:i:s',$_SERVER['HTTP_FROM']);
        }
        if($_SERVER['HTTP_TO']){
            $end = Carbon::createFromFormat('Y-m-d H:i:s',$_SERVER['HTTP_TO']);
        }

		return Clicks::select('ip_address','Browser','OS','Time')
						->where('t_id','=',$_SERVER['HTTP_ID'])
                        ->where('Time','>=',$start)
                        ->where('Time','<',$end)
                        ->get();
	}

	function latest($id,$start,$end){
		return (Clicks::select('Time')
						->where('t_id','=',$id)
                        ->where('Time','>=',$start)
                        ->where('Time','<',$end)
                        ->latest()->first())['Time'];
	}


	function topClick(){

        $start = Carbon::createFromFormat('Y-m-d H:i:s','1900-1-1 00:00:00');
        $end = Carbon::createFromFormat('Y-m-d H:i:s','2100-1-1 00:00:00');

//        if($_SERVER['HTTP_FROM']){
//            $start = Carbon::createFromFormat('Y-m-d H:i:s',$_SERVER['HTTP_FROM']);
//        }
//        if($_SERVER['HTTP_TO']){
//            $end = Carbon::createFromFormat('Y-m-d H:i:s',$_SERVER['HTTP_TO']);
//        }

		return collect(DB::table('clicks')
                ->join('trackers','trackers.t_id','=','clicks.t_id')
                 ->select('clicks.t_id', DB::raw('count(*) as total'))
                ->where('trackers.c_id','=',Auth::user()->id)
                 ->where('Time','>=',$start)
                 ->where('Time','<',$end)
                 ->groupBy('t_id')
                 ->orderBy('total','desc')
                 ->first());

	}



    function forAll($qry){

        $ids = Tracker::pluck('t_id');

        foreach($ids as $id){

            $qry->setVal($id);
            $value = $qry->executeClick($id);
            $counts[] = array( $id => $value);
        }

        return $counts;
    }


    //
//	function alltimeStats($type,$id){
//
//		if(!(Tracker::where('t_id','=',$id)->first()))
//			return "Invalis tracker";
//
//
//		if($type == 'total')
//			$qry = new count;
//		else if($type == 'unique')
//			$qry = new unique;
//		else
//			return "Invalid Route";
//
//
//		$qry->setVal($id);
//		return $qry->executeClick();
//	}
//
//
//	function intervalStats($type,$id){
//
//		if(!(Tracker::where('t_id','=',$id)->first()))
//			return "Invalis tracker";
//
//		if($type == 'total')
//			$qry = new countInterval($id);
//		else if($type == 'unique')
//			$qry = new uniqueInterval($id);
//		else
//			return "Invalid Route";
//
//		return $this->interval($qry);
//	}
//
//
//	function allStats($type){
//
//		if($type == 'total')
//			$qry = new count;
//		else if($type == 'unique')
//			$qry = new unique;
//		else
//			return "Invalid Route";
//
//		return $this->forAll($qry);
//	}



}
