<?php

namespace App\classes;
use App\classes\query;
use Carbon\Carbon;
use App\Records;
use App\Clicks;


class uniqueInterval implements query{

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

		return Records::select('ip_address')
							->where('t_id','=',$this->val)
							->where('Time','>=',$this->start)
							->where('Time','<',$this->end)
							->distinct()
							->get()
							->count();
							
	}


	public function executeClick(){

		return Clicks::select('ip_address')
							->where('t_id','=',$this->val)
							->where('Time','>=',$this->start)
							->where('Time','<',$this->end)
							->distinct()
							->get()
							->count();
							
	}

}