<?php

namespace App\Http\Controllers;

use App\Lecture;
use App\Goal;
use App\Subject;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class GoalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:administrator');
    }

    public function index(Request $request)
    {
        return view('goal.index', [
            'goals' => Goal::all(),
        ]);
    }

    public function indexWithInstance(Request $request, $lecture_id)
    {
        if(isset($lecture_id)) {
            $lecture = Lecture::find($lecture_id);
            $data["lecture"] = $lecture;
        }

        return view('goal.index', $data);
    }

    public function connection(Request $request, $lecture_id)
    {
        if(isset($lecture_id)) {
            $lecture = Lecture::find($lecture_id);
            $data["lecture"] = $lecture;
        }

        return view('goal.connection', $data);
    }

    public function connectionStore(Request $request, $lecture_id)
    {

        $goal = Goal::find($request->goal_id);
        $subject = Subject::find($request->subject_id);

        $goal->subjects()->attach($subject);
        return $request->goal_id. " -- " . $request->subject_id;
    }

    public function connectionDestroy(Request $request, $lecture_id)
    {

        $goal = Goal::find($request->goal_id);
        $subject = Subject::find($request->subject_id);

        $goal->subjects()->detach($subject);
        return $request->goal_id. " -- " . $request->subject_id;
    }

    public function store(Request $request, $lecture_id)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
        ]);

        $lecture = Lecture::find($lecture_id);
        $goal = new Goal();
        $goal->title = $request->title;
        $goal->description = $request->description;

        $goal->lecture()->associate($lecture);
        $goal->save();

        return redirect('/lectures/'.$lecture_id.'/goals');
    }

    public function edit(Request $request, $lecture_id, $goal_id)
    {
        $lecture = Lecture::find($lecture_id);
        $goal = Goal::find($goal_id);
        $data["lecture"] = $lecture;
        $data["goal"] = $goal;

        return view('goal.edit', $data);
    }

    public function update(Request $request, $lecture_id, $goal_id)
    {
        $goal = Goal::find($goal_id);
        $goal->title = $request->title;
        $goal->description = $request->description;
        $goal->save();
        return redirect('/lectures/'.$lecture_id.'/goals');
    }

    public function destroy(Request $request, $lecture_id, $goal_id)
    {
        $goal = Goal::find($goal_id);

        $goal->delete();

        return redirect('/lectures/'.$lecture_id.'/goals');
    }
}
