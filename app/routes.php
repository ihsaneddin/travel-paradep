<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

//

//admin namespace
Route::group(['namespace' => 'admin'], function(){

  Route::get('/', [ 'as' => 'admin.dashboards.index', 'before' => 'confide|csrf' ,'uses' => 'Dashboards@index']);
  Route::group(['prefix' => 'admin', 'before' => 'confide|permission|csrf'], function()
  {
    Route::resource('dashboards','Dashboards', ['only' => ['index']]);
    Route::resource('profiles', 'Profiles', ['only' => ['show', 'edit', 'update']]);
    Route::get('profiles/{profiles}/new_password', array('as' => 'admin.profiles.new_password', 'uses' => 'Profiles@new_password'));
    Route::put('profiles/{profiles}/change_password', array('as' => 'admin.profiles.change_password', 'uses' => 'Profiles@change_password'));

    Route::group(['prefix' => 'master', 'namespace' => 'master'], function()
    {
      Route::resource('users', 'Users');
      Route::resource('cars', 'Cars');
      Route::resource('routes', 'Routes');
      Route::resource('stations', 'Stations');
      Route::resource('drivers', 'Drivers');
      Route::resource('schedules', 'Schedules');

      // custom routes for masters
      Route::get('cars/{cars}/edit_stationed_at', array('as' => 'admin.master.cars.edit_stationed_at', 'uses' => 'Cars@edit_stationed_at'));
      Route::post('cars/{cars}/stationed_at', array('as' => 'admin.master.cars.stationed_at', 'uses' => 'Cars@stationed_at'));
      Route::get('drivers/{drivers}/edit_stationed_at', array('as' => 'admin.master.drivers.edit_stationed_at', 'uses' => 'Drivers@edit_stationed_at'));
      Route::post('drivers/{drivers}/stationed_at', array('as' => 'admin.master.drivers.stationed_at', 'uses' => 'Drivers@stationed_at'));
    });

    Route::group(array('prefix' => 'process', 'namespace' => 'process'), function(){
      Route::resource('bookings', 'Bookings', array('only' => ['index', 'show', 'destroy']));
      Route::resource('trips', 'Trips');
      Route::resource('schedules', 'Schedules');
      Route::resource('trips.bookings', 'Bookings', array('only' => ['create', 'store', 'edit', 'update']));

      #custom route for trips
      Route::put('trips/{trips}/ready', array('as' => 'admin.process.trips.ready', 'uses' => 'Trips@ready'));
      Route::put('trips/{trips}/cancel', array('as' => 'admin.process.trips.cancel', 'uses' => 'Trips@cancel'));
      Route::put('trips/{trips}/depart', array('as' => 'admin.process.trips.depart', 'uses' => 'Trips@depart'));
      Route::put('trips/{trips}/arrive', array('as' => 'admin.process.trips.arrive', 'uses' => 'Trips@arrive'));

      #custom routes for bookings
      Route::put('trips/{trips}/bookings/{bookings}/payment', array('as' => 'admin.process.trips.bookings.payment', 'uses' => 'Bookings@payment'));
      Route::put('trips/{trips}/bookings/{bookings}/cancel', array('as' => 'admin.process.trips.bookings.cancel', 'uses' => 'Bookings@cancel'));
      Route::put('bookings/{bookings}/move', array('as' => 'admin.process.bookings.move', 'use' => 'Bookings@move'));
    });

  });

  //confide routes here
  Route::get('sign_in', ['as' => 'admin.sessions.create', 'uses' => 'Sessions@create']);
  Route::post('sign_in', ['as' => 'admin.sessions.store', 'uses' => 'Sessions@store']);
  Route::get('sign_out', ['as' => 'admin.sessions.destroy', 'uses' => 'Sessions@destroy']);

});

//api

Route::group(['namespace' => 'api', 'prefix' => 'api'], function()
{
  //datatable namespace
  Route::group(['namespace' => 'datatable', 'prefix' => 'datatable'], function()
  {
    Route::resource('users', 'Users', ['only' => ['index']]);
    Route::resource('cars', 'Cars', ['only' => ['index']]);
    Route::resource('stations', 'Stations', ['only' => ['index']]);
    Route::resource('drivers', 'Drivers', ['only' => ['index']]);
    Route::resource('routes', 'Routes', ['only' => ['index']]);
    Route::resource('schedules', 'Schedules', ['only' => ['index']]);
  });
});


// Applies auth filter to the routes within admin/
//Route::when('admin/*', 'confide');


