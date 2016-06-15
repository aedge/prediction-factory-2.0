<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('auth/login');
});

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

// Main Application routes ...
//Route::get('predictions', 'HomeController@predictions');
Route::get('leagues', 'LeagueController@index');
Route::post('leagues/new', 'LeagueController@store');
Route::post('leagues/join', 'LeagueController@join');
Route::get('predictions', 'PredictionController@index');
Route::get('results', 'ResultController@index');

// API Routes
Route::get('api/groups/{id}', 'ApiController@competitionGroups');
Route::get('api/events/{id}', 'ApiController@groupEvents');
Route::get('api/competitions', 'ApiController@userCompetitions');
Route::post('/api/prediction', 'ApiController@storePrediction');
Route::post('/api/result', 'ApiController@storeResult');
Route::get('api/results/{id}', 'ApiController@groupResults');
Route::post('api/processresults', 'ApiController@processResults');


