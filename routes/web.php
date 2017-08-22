<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => ['web']],function (){
    Route::post('/signup', 'ClientController@create');

    Route::post('/login', 'ClientController@login');

    Route::get('/client', 'ClientController@index');

    Route::post('/tracker', 'TrackerController@create');

    Route::get('/trackers', 'TrackerController@index');

    Route::post('/open/{tr_id}', 'TrackerController@open');

    Route::post('/click/{tr_id}', 'ClicksController@click');

    Route::get('/stats/rate','ClicksController@rate');

    Route::get('/stats/clicked','ClicksController@clicked');

    Route::get('/stats/topClick','ClicksController@topClick');

    Route::get('/stats','ClientController@central');

    Route::post('/test', 'TrackerController@test');

});



//Route::get('/tracker/{tr_id}', 'TrackerController@retrieve');


//Route::get('/stats/opens/{type}','TrackerController@allstats');
//
//Route::get('/stats/clicks/{type}','ClicksController@allstats');
////



//Route::get('/stats/opens/{type}/{id}','TrackerController@alltimeStats');
//
//Route::get('/stats/clicks/{type}/{id}','ClicksController@alltimeStats');
//
//Route::get('/stats/openInterval/{type}/{id}','TrackerController@intervalStats');
//
//Route::get('/stats/clickInterval/{type}/{id}','ClicksController@intervalStats');
