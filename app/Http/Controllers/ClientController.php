<?php

namespace App\Http\Controllers;

use App\classes\countInterval;
use App\classes\uniqueInterval;
use App\client;
use App\tracker;
use Carbon\Carbon;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\TrackerController;
use App\Http\Controllers\ClicksController;
use Illuminate\Support\Facades\Session;


class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Client::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function central(){

        if(!$_SERVER['HTTP_ID']){
            $t_controller = new TrackerController;
            return $t_controller->index();
        }

        if(!(Tracker::where('t_id','=',$_SERVER['HTTP_ID'])->first()))
            return "Invalid tracker";

        $id = $_SERVER['HTTP_ID'];
        $start = Carbon::createFromFormat('Y-m-d H:i:s','1900-1-1 00:00:00');
        $end = Carbon::createFromFormat('Y-m-d H:i:s','2100-1-1 00:00:00');

        if($_SERVER['HTTP_FROM']){
            $start = Carbon::createFromFormat('Y-m-d H:i:s',$_SERVER['HTTP_FROM']);
        }
        if($_SERVER['HTTP_TO']){
            $end = Carbon::createFromFormat('Y-m-d H:i:s',$_SERVER['HTTP_TO']);
        }

        if(!$_SERVER['HTTP_TYPE']) {
            $t_controller = new TrackerController;
          return $t_controller->interval($id,$start,$end);
        }
        else{
            $clk_controller = new ClicksController;
          return $clk_controller->interval($id,$start,$end);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(client $client)
    {
        //
    }
}
