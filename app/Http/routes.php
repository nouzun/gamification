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

// Course content
Route::get('/content', function()
{
    return View::make('content');
});

// Game
Route::get('/game', function()
{
    return View::make('game/index');
});

// Lectures
Route::get('/lectures/manage', 'LectureController@index');
Route::get('/lectures/toolbox', 'LectureController@toolbox');
Route::get('/lectures/{lecture_id}/toolbox/rewarding', 'LectureController@toolbox_rewarding');
Route::post('/lectures/{lecture_id}/toolbox/store', 'LectureController@toolbox_store');
Route::get('/lectures/{lecture_id}/toolbox/achievement', 'LectureController@toolbox_achievement');
Route::get('/lectures/{lecture_id}/toolbox/level', 'LectureController@toolbox_level');
Route::get('/lectures/{lecture_id}/toolbox/quest', 'LectureController@toolbox_quest');
Route::get('/lectures/{lecture_id}/toolbox/leaderboard', 'LectureController@toolbox_leaderboard');


Route::post('/lectures', 'LectureController@store');
Route::get('/lectures/{lecture_id}/edit', 'LectureController@edit');
Route::post('/lectures/{lecture_id}/edit', 'LectureController@update');
Route::get('/lectures/{lecture_id}/destroy', 'LectureController@destroy');
Route::get('/lectures/{lecture_id}/content', 'LectureController@content');
Route::get('/lectures/{lecture_id}/assignments', 'LectureController@assignment');

// Subjects
Route::get('/lectures/{lecture_id}/subjects', 'SubjectController@indexWithInstance');
Route::post('/lectures/{lecture_id}/subjects', 'SubjectController@store');
Route::get('/lectures/{lecture_id}/subjects/{subject_id}/edit', 'SubjectController@edit');
Route::post('/lectures/{lecture_id}/subjects/{subject_id}/edit', 'SubjectController@update');
Route::get('/lectures/{lecture_id}/subjects/{subject_id}/destroy', 'SubjectController@destroy');

// Goals
Route::get('/lectures/{lecture_id}/goals', 'GoalController@indexWithInstance');
Route::get('/lectures/{lecture_id}/goalsandsubjects', 'GoalController@connection');
Route::post('/lectures/{lecture_id}/goalsandsubjects', 'GoalController@connectionStore');
Route::post('/lectures/{lecture_id}/goalsandsubjects/destroy', 'GoalController@connectionDestroy');
Route::post('/lectures/{lecture_id}/goals', 'GoalController@store');
Route::get('/lectures/{lecture_id}/goals/{goal_id}/edit', 'GoalController@edit');
Route::post('/lectures/{lecture_id}/goals/{goal_id}/edit', 'GoalController@update');
Route::get('/lectures/{lecture_id}/goals/{goal_id}/destroy', 'GoalController@destroy');

// Assignments
Route::get('/lectures/{lecture_id}/assignments', 'AssignmentController@index');
Route::get('/lectures/{lecture_id}/assignments/subjects/{subject_id}', 'AssignmentController@indexWithInstance');
Route::get('/lectures/{lecture_id}/assignments/subjects/{subject_id}/quiz/{assignment_id}', 'AssignmentController@indexWithQuiz');
Route::post('/lectures/{lecture_id}/assignments/subjects/{subject_id}', 'AssignmentController@store');
Route::post('/lectures/{lecture_id}/assignments/subjects/{subject_id}/quiz/{assignment_id}', 'AssignmentController@storeQuiz');
Route::delete('/lectures/{lecture_id}/assignment/{subject}', 'AssignmentController@destroy');

// Topics
Route::get('/topics', 'TopicController@index');
Route::get('/lectures/{lecture_id}/subjects/{subject_id}/topics', 'TopicController@indexWithInstance');
Route::post('/lectures/{lecture_id}/subjects/{subject_id}/topics', 'TopicController@store');
Route::get('/lectures/{lecture_id}/subjects/{subject_id}/topics/{topic_id}/content', 'TopicController@show');
Route::get('/lectures/{lecture_id}/subjects/{subject_id}/topics/{topic_id}/edit', 'TopicController@edit');
Route::post('/lectures/{lecture_id}/subjects/{subject_id}/topics/{topic_id}/edit', 'TopicController@update');
Route::get('/lectures/{lecture_id}/subjects/{subject_id}/topics/{topic_id}/destroy', 'TopicController@destroy');

// Knowledge Units
Route::get('/lectures/{lecture_id}/subjects/{subject_id}/topics/{topic_id}/knowledgeunits', 'KnowledgeUnitController@indexWithInstance');
Route::get('/lectures/{lecture_id}/subjects/{subject_id}/topics/{topic_id}/knowledgeunits/{knowledgeunit_id}/quiz', 'KnowledgeUnitController@indexWithQuiz');
Route::post('/lectures/{lecture_id}/subjects/{subject_id}/topics/{topic_id}/knowledgeunits/{knowledgeunit_id}/quiz', 'KnowledgeUnitController@storeQuiz');
Route::post('/lectures/{lecture_id}/subjects/{subject_id}/topics/{topic_id}/knowledgeunits', 'KnowledgeUnitController@store');
Route::get('/lectures/{lecture_id}/subjects/{subject_id}/topics/{topic_id}/knowledgeunits/{knowledgeunit_id}/edit', 'KnowledgeUnitController@edit');
Route::post('/lectures/{lecture_id}/subjects/{subject_id}/topics/{topic_id}/knowledgeunits/{knowledgeunit_id}/edit', 'KnowledgeUnitController@update');
Route::get('/lectures/{lecture_id}/subjects/{subject_id}/topics/{topic_id}/knowledgeunits/{knowledgeunit_id}/destroy', 'KnowledgeUnitController@destroy');

// Questions
Route::get('/lectures/{lecture_id}/subjects/{subject_id}/topics/{topic_id}/knowledgeunits/{knowledgeunit_id}/assignments/{assignment_id}/questions', 'QuestionController@indexWithInstance');
Route::post('/lectures/{lecture_id}/subjects/{subject_id}/topics/{topic_id}/knowledgeunits/{knowledgeunit_id}/assignments/{assignment_id}/questions', 'QuestionController@store');
Route::get('/lectures/{lecture_id}/subjects/{subject_id}/topics/{topic_id}/knowledgeunits/{knowledgeunit_id}/assignments/{assignment_id}/questions/{question_id}/edit', 'QuestionController@edit');
Route::post('/lectures/{lecture_id}/subjects/{subject_id}/topics/{topic_id}/knowledgeunits/{knowledgeunit_id}/assignments/{assignment_id}/questions/{question_id}/edit', 'QuestionController@update');
Route::get('/lectures/{lecture_id}/subjects/{subject_id}/topics/{topic_id}/knowledgeunits/{knowledgeunit_id}/assignments/{assignment_id}/questions/{question_id}/destroy', 'QuestionController@destroy');

// Answers
Route::get('/lectures/{lecture_id}/subjects/{subject_id}/topics/{topic_id}/knowledgeunits/{knowledgeunit_id}/assignments/{assignment_id}/questions/{question_id}/answers', 'AnswerController@indexWithInstance');
Route::post('/lectures/{lecture_id}/subjects/{subject_id}/topics/{topic_id}/knowledgeunits/{knowledgeunit_id}/assignments/{assignment_id}/questions/{question_id}/answers', 'AnswerController@store');
Route::get('/lectures/{lecture_id}/subjects/{subject_id}/topics/{topic_id}/knowledgeunits/{knowledgeunit_id}/assignments/{assignment_id}/questions/{question_id}/answers/{answer_id}/edit', 'AnswerController@edit');
Route::post('/lectures/{lecture_id}/subjects/{subject_id}/topics/{topic_id}/knowledgeunits/{knowledgeunit_id}/assignments/{assignment_id}/questions/{question_id}/answers/{answer_id}/edit', 'AnswerController@update');
Route::get('/lectures/{lecture_id}/subjects/{subject_id}/topics/{topic_id}/knowledgeunits/{knowledgeunit_id}/assignments/{assignment_id}/questions/{question_id}/answers/{answer_id}/destroy', 'AnswerController@destroy');