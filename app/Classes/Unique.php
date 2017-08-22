<?php

namespace App\Classes;
use App\Classes\query;
use App\Records;
use App\Clicks;

class unique implements query{

	private $val;

	public function setVal($id){
		$this->val = $id;
	}


	public function executeOpen(){

		return Records::select('ip_address')
			    		->where('t_id','=',$this->val)
			    		->distinct()
			    		->get()->count();
	}

	public function executeClick(){

		return Clicks::select('ip_address')
			    		->where('t_id','=',$this->val)
			    		->distinct()
			    		->get()->count();
	}

}