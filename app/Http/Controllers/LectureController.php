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


        return redirect('/lectures');
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
        return redirect('/lectures');
    }

    public function destroy(Request $request, $lecture_id)
    {
        $lecture = Lecture::find($lecture_id);

        $lecture->delete();

        return redirect('/lectures');
    }
}
