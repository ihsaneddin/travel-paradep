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
  });
});


// Applies auth filter to the routes within admin/
//Route::when('admin/*', 'confide');


