<?php

namespace App\Classes;
use App\Classes\query;
use App\Records;
use App\clicks;

class count implements query{

	private $val;

	public function setVal($id){
		$this->val = $id;
	}


	public function executeOpen(){
		return Records::where('t_id','=',$this->val)->get()->count();
	}

	public function executeClick(){
		return Clicks::where('t_id','=',$this->val)->get()->count();
	}


}