<?php
/**
 * Created by PhpStorm.
 * User: aditya.go
 * Date: 26/08/17
 * Time: 3:03 PM
 */

namespace App\Classes;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OSInterval implements query
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
            ->select('records.OS as name', DB::raw('count(*) as count'))
            ->where('trackers.c_id','=',Auth::user()->id)
            ->where('Time','>=',$this->start)
            ->where('Time','<',$this->end)
            ->groupBy('records.OS')
            ->get());
    }

    public function executeClick(){
        return collect(DB::table('clicks')
            ->join('trackers','trackers.t_id','=','clicks.t_id')
            ->select('clicks.OS as name', DB::raw('count(*) as count'))
            ->where('trackers.c_id','=',Auth::user()->id)
            ->where('Time','>=',$this->start)
            ->where('Time','<',$this->end)
            ->groupBy('clicks.OS')
            ->get());

    }

}