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
    return redirect('/home');
});



Route::group(['middleware' => ['web']],function (){

    Route::post('/tracker', 'TrackerController@create');

    Route::get('/open/{tr_id}', 'TrackerController@open');

    Route::get('/click/{tr_id}', 'ClicksController@click');

    Route::get('/stats/rate','ClicksController@rate');

    Route::get('/stats/clicked','ClicksController@clicked');

    Route::get('/stats/topClick','ClicksController@topClick');

    Route::get('/stats','HomeController@multiTracker');

    Route::auth();

    Route::get('/home','HomeController@index');


    //    Route::post('/test', 'TrackerController@test');
});



