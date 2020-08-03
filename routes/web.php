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

use App\Http\Middleware\ApiAuthMiddleware;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/orm','Pruebascontroller@test2');



// rutas pruebas
/*
Route::get('/votes','VotesController@pruebas');
Route::get('/user','UserController@pruebas');
Route::get('/list','ListController@pruebas');
Route::get('/candidates','CandidateController@pruebas');
Route::get('/certificate','CertificateController@pruebas'); */



// rutas api

Route::post('/api/login','UserController@login');
Route::get('/api/userbyid/{id}','UserController@UserById')->middleware(ApiAuthMiddleware::class);


// candidates
Route::post('/api/register/candidate','CandidateController@storeCandidate');
Route::post('/api/upload','CandidateController@upload');
Route::get('/api/image/{filename}','CandidateController@getImage');
Route::put('/api/edit/candidate/{id}','CandidateController@update');
Route::delete('/api/delete/candidate/{id}','CandidateController@destroy');

Route::get('/api/candidates','CandidateController@getCandidates');
Route::get('/api/candidate/list/{id}','CandidateController@getCanByList');

Route::get('/api/candidate/{id}','CandidateController@getCandidateById');




// list
Route::get('/api/lists','ListController@getLists');
Route::get('/api/lists/votes','ListController@getListsVotes');


Route::get('/api/list/{id}','ListController@getListById');

Route::post('/api/register/list','ListController@storeList');
Route::put('/api/edit/list/{id}','ListController@update');
Route::delete('/api/delete/list/{id}','ListController@destroy');

Route::put('/api/vote/{id}','ListController@votar');


Route::put('/api/edit/user','ListController@updateVoteUser');



// types candidates
Route::get('/api/types','TypeCandidatesController@getTypes');



// votes

//Route::post('/api/vote','VotesController@storeVote');
/*
Route::get('/api/votes/{id}','VotesController@getVotesByList');


Route::put('/api/vote/{id}','VotesController@update');


Route::get('/api/get/vote/{id}','VotesController@getVotesById');

*/