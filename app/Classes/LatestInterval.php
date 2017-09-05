<?php
/**
 * Created by PhpStorm.
 * User: aditya.go
 * Date: 05/09/17
 * Time: 6:04 PM
 */

namespace App\Classes;


use App\clicks;
use App\Records;

class LatestInterval implements query
{
    private $start;
    private $end;
    private $val;

    public function __construct($id){
        $this->val = $id;
    }

    public function setInterval($_start,$_end){
        $this->start = $_start;
        $this->end = $_end;
    }

    public function executeOpen()
    {
        return (Records::select('Time')
            ->where('t_id','=',$this->val)
            ->where('Time','>=',$this->start)
            ->where('Time','<',$this->end)
            ->latest()->first())['Time'];
    }

    public function executeClick()
    {
        return (Clicks::select('Time')
            ->where('t_id','=',$this->val)
            ->where('Time','>=',$this->start)
            ->where('Time','<',$this->end)
            ->latest()->first())['Time'];
    }
}