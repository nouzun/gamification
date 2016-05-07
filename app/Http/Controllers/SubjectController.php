<?php

namespace App\Http\Controllers;

use App\Lecture;
use App\Repositories\SubjectRepository;
use App\Subject;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SubjectController extends Controller
{
    protected $subjects;

    public function __construct(SubjectRepository $subjects)
    {
        $this->middleware('auth:administrator');
        $this->subjects = $subjects;
    }

    public function index(Request $request)
    {
        return view('subject.index', [
            'subjects' => Subject::all(),
            //'subjects' => $this->subjects->forUser($request->user()),
        ]);
    }

    public function indexWithInstance(Request $request, $lecture_id)
    {
        if(isset($lecture_id)) {
            $lecture = Lecture::find($lecture_id);
            $data["lecture"] = $lecture;
            //$data["subjects"] = $this->subjects->forLectures($lecture_id);
        }

        return view('subject.index', $data);
    }

    public function store(Request $request, $lecture_id)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
        ]);

        $lecture = Lecture::find($lecture_id);
        //Log::info('$subject_id: '.$lecture->title);
        $subject = new Subject();
        $subject->title = $request->title;
        $subject->description = $request->description;

        $subject->lecture()->associate($lecture);
        $subject->save();

        return redirect('/lectures/'.$lecture_id.'/subjects');
    }

    public function edit(Request $request, $lecture_id, $subject_id)
    {
        $lecture = Lecture::find($lecture_id);
        $subject = Subject::find($subject_id);
        $data["lecture"] = $lecture;
        $data["subject"] = $subject;

        return view('subject.edit', $data);
    }

    public function update(Request $request, $lecture_id, $subject_id)
    {
        $subject = Subject::find($subject_id);
        $subject->title = $request->title;
        $subject->description = $request->description;
        $subject->save();
        return redirect('/lecture/'.$lecture_id.'/subjects');
    }

    public function destroy(Request $request, $lecture_id, $subject_id)
    {
        $subject = Subject::find($subject_id);

        $subject->delete();

        return redirect('/lecture/'.$lecture_id.'/subjects');
    }
}
