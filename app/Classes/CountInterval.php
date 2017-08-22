<?php

namespace App\classes;
use App\classes\query;
use Carbon\Carbon;
use App\Records;
use App\Clicks;

class countInterval implements query{

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

	public function executeOpen(){

		return Records::where('t_id','=',$this->val)->where('Time','>=',$this->start)->where('Time','<',$this->end)->count();
	}

	public function executeClick(){

		return Clicks::where('t_id','=',$this->val)->where('Time','>=',$this->start)->where('Time','<',$this->end)->count();
	}
}