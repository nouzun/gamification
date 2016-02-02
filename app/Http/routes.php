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

Route::get('/', 'HomeController@index');

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

$s = 'social.';
Route::get('/social/redirect/{provider}',   ['as' => $s . 'redirect',   'uses' => 'Auth\AuthController@getSocialRedirect']);
Route::get('/social/handle/{provider}',     ['as' => $s . 'handle',     'uses' => 'Auth\AuthController@getSocialHandle']);

Route::get('/documentation', function()
{
    return View::make('documentation');
});

// Authentication routes...
$a = 'auth.';
Route::get('/login',            ['as' => $a . 'login',          'uses' => 'Auth\AuthController@getLogin']);
Route::post('/login',           ['as' => $a . 'login-post',     'uses' => 'Auth\AuthController@postLogin']);

Route::group(['prefix' => 'admin', 'middleware' => 'auth:administrator'], function()
{
    $a = 'admin.';
    Route::get('/', ['as' => $a . 'home', 'uses' => 'UserController@showCurrent']);
    //Route::get('/', ['as' => $a . 'home', 'uses' => 'AdminController@getHome']);
});

Route::group(['prefix' => 'user', 'middleware' => 'auth:all'], function()
{
    $a = 'user.';
    Route::get('/', ['as' => $a . 'home', 'uses' => 'UserController@showCurrent']);
    Route::get('/{user_id}', ['as' => $a . 'show', 'uses' => 'UserController@show']);
    Route::get('/{user_id}/edit', ['as' => $a . 'edit', 'uses' => 'UserController@edit']);
    Route::post('/{user_id}/edit', ['as' => $a . 'edit', 'uses' => 'UserController@store']);
});

Route::group(['middleware' => 'auth:all'], function()
{
    $a = 'authenticated.';
    Route::get('/logout', ['as' => $a . 'logout', 'uses' => 'Auth\AuthController@getLogout']);
});

// Registration routes...
Route::get('/auth/register', 'Auth\AuthController@getRegister');
Route::post('/auth/register', 'Auth\AuthController@postRegister');

// Subjects
Route::get('/subjects', 'SubjectController@index');
Route::post('/subjects', 'SubjectController@store');
Route::delete('/subject/{subject}', 'SubjectController@destroy');

// Assignments
Route::get('/assignments', 'AssignmentController@index');
Route::get('/assignments/subjects/{subject_id}', 'AssignmentController@indexWithInstance');
Route::get('/assignments/subjects/{subject_id}/quiz/{assignment_id}', 'AssignmentController@indexWithQuiz');
Route::post('/assignments/subjects/{subject_id}', 'AssignmentController@store');
Route::post('/assignments/subjects/{subject_id}/quiz/{assignment_id}', 'AssignmentController@storeQuiz');
Route::delete('/assignment/{subject}', 'AssignmentController@destroy');

// Topics
Route::get('/topics', 'TopicController@index');
Route::get('/subjects/{subject_id}/topics', 'TopicController@indexWithInstance');
Route::post('/subjects/{subject_id}/topics', 'TopicController@store');
Route::delete('/topic/{topic}', 'TopicController@destroy');

// Knowledge Units
Route::get('/subjects/{subject_id}/topics/{topic_id}/knowledgeunits', 'KnowledgeUnitController@indexWithInstance');
Route::post('/subjects/{subject_id}/topics/{topic_id}/knowledgeunits', 'KnowledgeUnitController@store');
Route::delete('/knowledgeunits/{knowledgeunit_id}', 'KnowledgeUnitController@destroy');

// Questions
Route::get('/subjects/{subject_id}/topics/{topic_id}/knowledgeunits/{knowledgeunit_id}/questions', 'QuestionController@indexWithInstance');
Route::post('/subjects/{subject_id}/topics/{topic_id}/knowledgeunits/{knowledgeunit_id}/questions', 'QuestionController@store');
Route::delete('/questions/{question_id}', 'QuestionController@destroy');

// Answers
Route::get('/subjects/{subject_id}/topics/{topic_id}/knowledgeunits/{knowledgeunit_id}/questions/{question_id}/answers', 'AnswerController@indexWithInstance');
Route::post('/subjects/{subject_id}/topics/{topic_id}/knowledgeunits/{knowledgeunit_id}/questions/{question_id}/answers', 'AnswerController@store');
Route::delete('/answers/{answer_id}', 'AnswerController@destroy');