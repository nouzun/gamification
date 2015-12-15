<?php

namespace App\Http\Controllers;

use App\Repositories\SubjectRepository;
use App\Subject;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SubjectController extends Controller
{
    /**
     * The task repository instance.
     *
     * @var TaskRepository
     */
    protected $subjects;

    public function __construct(SubjectRepository $subjects)
    {
        $this->middleware('auth');
        $this->subjects = $subjects;
    }

    public function index(Request $request)
    {

        //$subjects = Subject::where('user_id', $request->user()->id)->get();

        return view('subject.index', [
            'subjects' => $this->subjects->forUser($request->user()),
        ]);


        //return view('subject.index');
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
