<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tracker;
use App\Records;
use App\user;
use App\classes\TransparentPixelResponse;
use Illuminate\Support\Facades\Auth;
use UAParser\Parser;
use Illuminate\Support\Facades\Log;
use App\classes\count;
use App\classes\unique;
use App\classes\countInterval;
use App\classes\uniqueInterval;
use Carbon\Carbon;

class TrackerController extends Controller
{

    function index(){
		return tracker::where('c_id','=',Auth::user()->id)->pluck('t_id');
	}

    
	// Generate new token
	function create(Request $request){

		$tracker = new tracker;

		$token = $request->token;


		if(Auth::user()->token == $token){

			do{
				$tr_id = rand(0,100000000);
			}while(tracker::where('t_id','=',$tr_id)->first());
			
			$tracker->t_id = $tr_id;
			$tracker->c_id = Auth::user()->id;
			
			$tracker->save();
			//$uri = "http://openTracker/tracker/".$id;
			return redirect('/home');
		}
		else
			return "Invalid Client";
	}


	// Record a tracker request
	function open($tr_id){

		$record = new Records;
		$tracker = new tracker;
		$track = $tracker->where('t_id','=',$tr_id)->first();
		
		if($track){
			
			//$track->opened = $track->opened+1;
			
			$record->t_id = $tr_id;

			$record->ip_address = $_SERVER['REMOTE_ADDR'];

			$ua = $_SERVER['HTTP_USER_AGENT'];;
			$parser = Parser::create();
			$result = $parser->parse($ua);
			$record->browser = $result->ua->family;
			$record->os = $result->os->family;
			$record->device = $result->device->family;
			
			//$record->time = date("D dS M,Y h:i a");
			$record->Time = date("Y-m-d H:i:s");

			$record->save();
			//$track->save();
			return new TransparentPixelResponse();
		}
		else
			return "Tracker not found";
	}



// ---------------------------------------------// Stattistics for open


    function latest($id,$start,$end){
        return (Records::select('Time')
            ->where('t_id','=',$id)
            ->where('Time','>=',$start)
            ->where('Time','<',$end)
            ->latest()->first())['Time'];
    }


	function interval($id,$start,$end){

        $cquery = new countInterval($id);
        $cquery->setInterval($start,$end);

        $uquery = new uniqueInterval($id);
        $uquery->setInterval($start,$end);

       $respose = new \StdClass();
       $respose->id = $id;
       $respose->total_opens = $cquery->executeOpen();
       $respose->unique_opens = $uquery->executeOpen();
       $respose->Latest_open = $this->latest($id,$start,$end);

       if(!$respose->Latest_open)
           $respose->Latest_open = "---Not Available---";

        return $respose;
	}


//
//	function forAll($qry){
//
//		$ids = Tracker::pluck('t_id');
//
//		foreach($ids as $id){
//
//			$qry->setVal($id);
//			$value = $qry->executeOpen($id);
//			$counts[] = array( $id => $value);
//		}
//
//		return $counts;
//	}
//
//
////	function alltimeStats($type,$id){
////
////		if(!(Tracker::where('t_id','=',$id)->first()))
////			return "Invalis tracker";
////
////		if($type == 'total')
////			$qry = new count;
////		else if($type == 'unique')
////			$qry = new unique;
////		else
////			return "Invalid Route";
////
////		$qry->setVal($id);
////		return $qry->executeOpen();
////	}
//
//
////	function intervalStats($type,$id){
////
////		if(!(Tracker::where('t_id','=',$id)->first()))
////			return "Invalis tracker";
////
////		if($type == 'total')
////			$qry = new CountInterval($id);
////		else if($type == 'unique')
////			$qry = new uniqueInterval($id);
////		else
////			return "Invalid Route";
////
////		return $this->interval($qry);
////	}
////
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
//
////------------------------------------------------//
//
//	function test(){
//
//		foreach($_POST as $key=>$value) {
//                // if (substr($key,0,5)=="HTTP_") {
//                //     $key=str_replace(" ","-",ucwords(strtolower(str_replace("_"," ",substr($key,5)))));
//                //     $out[$key]=$value;
//                // }else{
//                    $out[$key]=$value;
//        		// }
//            }
//            return $out;
//
//		// return $_SERVER["HTTP_A"];
//
//	}

}
