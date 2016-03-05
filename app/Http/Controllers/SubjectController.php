<?php

namespace App\Http\Controllers;

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

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
        ]);

        $request->user()->subjects()->create([
            'title' => $request->title,
            'description' => $request->description,
        ]);


        return redirect('/subjects');
    }

    public function destroy(Request $request, Subject $subject)
    {
        $this->authorize('destroy', $subject);

        $subject->delete();

        return redirect('/subjects');
    }
}
