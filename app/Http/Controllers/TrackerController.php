<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tracker;
use App\Records;
use App\user;
use App\classes\TransparentPixelResponse;
use Illuminate\Support\Facades\Auth;
use UAParser\Parser;
use Carbon\Carbon;

class TrackerController extends Controller
{

    function index(){
		return tracker::where('c_id','=',Auth::user()->id)->pluck('t_id');
	}

    
	// Generate new token
	function create(Request $request){

		$tracker = new tracker;

		if(User::where('token','=',$request->token)->first()){
		    $c_id = (User::where('token','=',$request->token)->first())['id'];

		    do{
                $tr_id = rand(0,100000000);
            }while(tracker::where('t_id','=',$tr_id)->first());

            $tracker->t_id = $tr_id;
            $tracker->c_id = $c_id;

            $tracker->save();
            return redirect('/home');
		}
		else
			return http_response_code('500');
           // return "invlid tracker";
	}


	// Record a tracker request
	function open($tr_id,Request $request){

		$record = new Records;
		$tracker = new tracker;
		$track = $tracker->where('t_id','=',$tr_id)->first();
		
		if($track){

            $notValid = $record->where('t_id','=',$tr_id)
                ->where('ip_address','=',$request->ip())
                ->where('Time','>',Carbon::now()->subMinute())
                ->first();
            if($notValid)
                return http_response_code(500);

			$record->t_id = $tr_id;
            $record->ip_address = $request->ip();
            $ua = $request->header('User-Agent');

			$parser = Parser::create();
			$result = $parser->parse($ua);
			$record->browser = $result->ua->family;
			$record->os = $result->os->family;
			$record->device = $result->device->family;

			$record->Time = date("Y-m-d H:i:s");

			$record->save();

            return new TransparentPixelResponse();
		}
		else{
            http_response_code(500);
            return http_response_code();
        }
	}

}
