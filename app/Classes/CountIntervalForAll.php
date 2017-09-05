<?php
/**
 * Created by PhpStorm.
 * User: aditya.go
 * Date: 05/09/17
 * Time: 2:47 PM
 */

namespace App\Classes;


use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CountIntervalForAll implements query
{
    protected $start;
    protected $end;

    public function __construct()
    {
        $this->start = Carbon::createFromFormat('Y-m-d H:i:s','1900-1-1 00:00:00');;
        $this->end = Carbon::createFromFormat('Y-m-d H:i:s','2100-1-1 00:00:00');
    }

    public function setInterval($_start,$_end)
    {
        $this->start = $_start;
        $this->end = $_end;
    }

    public function executeOpen()
    {
        return collect(DB::table('trackers')
            ->join('Records','trackers.t_id','=','Records.t_id')
            ->select('trackers.t_id as id', DB::raw('count(*) as total'))
            ->where('trackers.c_id','=',Auth::user()->id)
            ->where('Time','>=',$this->start)
            ->where('Time','<',$this->end)
            ->groupBy('trackers.t_id')
            ->get());
    }

    public function executeClick()
    {
        return DB::table('clicks')
            ->join('trackers','trackers.t_id','=','clicks.t_id')
            ->select('clicks.t_id as id', DB::raw('count(*) as total'))
            ->where('trackers.c_id','=',Auth::user()->id)
            ->where('Time','>=',$this->start)
            ->where('Time','<',$this->end)
            ->groupBy('trackers.t_id')
            ->get();
    }
}