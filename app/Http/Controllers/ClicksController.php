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
    
	function click($tr_id,Request $request){
		$click = new Clicks;
		$tracker = new tracker;
		$track = $tracker->where('t_id','=',$tr_id)->first();
		
		if($track){

			$valid = $click->where('t_id','=',$tr_id)
							->where('ip_address','=',$request->ip())
							->where('Time','>',Carbon::now()->subMinute())
							->first();
			if($valid)
				return http_response_code(500);
			
			$click->t_id = $tr_id;

			//$click->ip_address = $_SERVER['REMOTE_ADDR'];
            $click->ip_address = $request->ip();

			//$ua = $_SERVER['HTTP_USER_AGENT'];;
            $ua = $request->header('User-Agent');
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
			return http_response_code(500);
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

		    $data = ($uquery->executeClick()/$uquery->executeOpen())*100;
        }
        else{
		    $cquery = new countInterval($request->id);
		    $cquery->setInterval($start,$end);

            $data = ($cquery->executeClick()/$cquery->executeOpen())*100;
        }
        return $data;
	}

	function clicked(Request $request){

        if(!(Tracker::where('t_id','=',$request->id)->first()))
            return "Invalid tracker";

        $start = Carbon::createFromFormat('Y-m-d H:i:s','1900-1-1 00:00:00');
        $end = Carbon::createFromFormat('Y-m-d H:i:s','2100-1-1 00:00:00');

        if($request->has('from')){
            $start = Carbon::createFromFormat('Y-m-d H:i:s',$request->from);
        }
        if($request->has('to')){
            $end = Carbon::createFromFormat('Y-m-d H:i:s',$request->to);
        }

		return Clicks::select('ip_address','Browser','OS','Time')
						->where('t_id','=',$request->id)
                        ->where('Time','>=',$start)
                        ->where('Time','<',$end)
                        ->get();
	}

	function topClick(Request $request){

        $start = Carbon::createFromFormat('Y-m-d H:i:s','1900-1-1 00:00:00');
        $end = Carbon::createFromFormat('Y-m-d H:i:s','2100-1-1 00:00:00');

        if($request->has('from')){
            $start = Carbon::createFromFormat('Y-m-d H:i:s',$request->from);
        }
        if($request->has('to')){
            $end = Carbon::createFromFormat('Y-m-d H:i:s',$request->to);
        }

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


}
