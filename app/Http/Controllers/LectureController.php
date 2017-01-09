<?php

namespace App\Http\Controllers;

use App\Lecture;
use App\Repositories\LectureRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class LectureController extends Controller
{
    protected $lectures;

    public function __construct(LectureRepository $lectures)
    {
        $this->middleware('auth:administrator');
        $this->lectures = $lectures;
    }

    public function index(Request $request)
    {
        return view('lecture.index', [
            'lectures' => Lecture::all(),
        ]);
    }

    public function toolbox(Request $request)
    {
        return view('lecture.toolbox', [
            'lectures' => Lecture::all(),
        ]);
    }

    public function toolbox_rewarding(Request $request)
    {
        return view('lecture.toolbox_rewarding', [
            'lectures' => Lecture::all(),
        ]);
    }

    public function toolbox_achievement(Request $request)
    {
        return view('lecture.toolbox_achievement', [
            'lectures' => Lecture::all(),
        ]);
    }

    public function toolbox_level(Request $request)
    {
        return view('lecture.toolbox_level', [
            'lectures' => Lecture::all(),
        ]);
    }

    public function toolbox_quest(Request $request)
    {
        return view('lecture.toolbox_quest', [
            'lectures' => Lecture::all(),
        ]);
    }

    public function toolbox_leaderboard(Request $request)
    {
        return view('lecture.toolbox_leaderboard', [
            'lectures' => Lecture::all(),
        ]);
    }

    public function toolbox_store(Request $request, $lecture_id)
    {
        $enable = $request->enable;
        $module = $request->module;

        $lecture = Lecture::find($lecture_id);
        $lecture[$module] = $enable;
        $g_index = $lecture->g_index;
        if ($enable) $g_index ++; else $g_index --;
        $lecture->g_index = $g_index;
        $lecture->save();

        return $enable;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
        ]);

        $request->user()->lectures()->create([
            'title' => $request->title,
            'description' => $request->description,
        ]);


        return redirect('/lectures/manage');
    }

    public function edit(Request $request, $lecture_id)
    {
        $lecture = Lecture::find($lecture_id);
        $data["lecture"] = $lecture;

        return view('lecture.edit', $data);
    }

    public function content(Request $request, $lecture_id)
    {
        $lecture = Lecture::find($lecture_id);
        $data["lecture"] = $lecture;

        return view('lecture.content', $data);
    }

    public function update(Request $request, $lecture_id)
    {
        $lecture = Lecture::find($lecture_id);
        $lecture->title = $request->title;
        $lecture->description = $request->description;
        $lecture->save();
        return redirect('/lectures/manage');
    }

    public function destroy(Request $request, $lecture_id)
    {
        $lecture = Lecture::find($lecture_id);

        $lecture->delete();

        return redirect('/lectures/manage');
    }
}
