<?php
/**
 * Created by PhpStorm.
 * User: aditya.go
 * Date: 24/08/17
 * Time: 7:45 PM
 */

namespace App\Classes;

use App\clicks;
use App\Records;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BrowserInterval implements query
{
    private $start;
    private $end;

    public function setInterval($_start,$_end){
        $this->start = $_start;
        $this->end = $_end;
    }

    public function executeOpen(){
        return collect(DB::table('records')
                        ->join('trackers','trackers.t_id','=','records.t_id')
                        ->select('records.Browser as name', DB::raw('count(*) as count'))
                        ->where('trackers.c_id','=',Auth::user()->id)
                        ->where('Time','>=',$this->start)
                        ->where('Time','<',$this->end)
                        ->groupBy('records.Browser')
                        ->get());
    }

    public function executeClick(){
        return collect(DB::table('clicks')
                        ->join('trackers','trackers.t_id','=','clicks.t_id')
                        ->select('clicks.Browser as name', DB::raw('count(*) as count'))
                        ->where('trackers.c_id','=',Auth::user()->id)
                        ->where('Time','>=',$this->start)
                        ->where('Time','<',$this->end)
                        ->groupBy('clicks.Browser')
                        ->get());

    }
}