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
/*
Route::get('/', function () {
    return view('welcome');
});
*/
Route::get('/', function()
{
    return View::make('home');
});

Route::get('/charts', function()
{
    return View::make('mcharts');
});

Route::get('/tables', function()
{
    return View::make('table');
});

Route::get('/forms', function()
{
    return View::make('form');
});

Route::get('/grid', function()
{
    return View::make('grid');
});

Route::get('/buttons', function()
{
    return View::make('buttons');
});


Route::get('/icons', function()
{
    return View::make('icons');
});

Route::get('/panels', function()
{
    return View::make('panel');
});

Route::get('/typography', function()
{
    return View::make('typography');
});

Route::get('/notifications', function()
{
    return View::make('notifications');
});

Route::get('/blank', function()
{
    return View::make('blank');
});

Route::get('/login', function()
{
    return View::make('login');
});

Route::get('/documentation', function()
{
    return View::make('documentation');
});

// Authentication routes...
Route::get('/auth/login', 'Auth\AuthController@getLogin');
Route::post('/auth/login', 'Auth\AuthController@postLogin');
Route::get('/auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('/auth/register', 'Auth\AuthController@getRegister');
Route::post('/auth/register', 'Auth\AuthController@postRegister');

// Subjects
Route::get('/subjects', 'SubjectController@index');
Route::post('/subjects', 'SubjectController@store');
Route::delete('/subject/{subject}', 'SubjectController@destroy');

// Topics
Route::get('/topics', 'TopicController@indexFromSubjects');
Route::get('/subjects/{subject_id}/topics', 'TopicController@index');
Route::post('/subjects/{subject_id}/topics', 'TopicController@store');
Route::delete('/topic/{topic}', 'TopicController@destroy');

Route::get('/question/{id}', 'QuestionController@show');
Route::get('/questions', 'QuestionController@index');
Route::post('/questions', 'QuestionController@store');
Route::delete('/question/{id}', 'QuestionController@destroy');