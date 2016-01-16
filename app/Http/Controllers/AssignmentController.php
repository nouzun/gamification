<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Assignment;
use App\KnowledgeUnit;
use App\Repositories\AssignmentRepository;
use App\Subject;
use App\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Log;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AssignmentController extends Controller
{
    protected $assignments;

    public function __construct(AssignmentRepository $assignments)
    {
        $this->middleware('auth');
        $this->assignments = $assignments;
    }

    public function index(Request $request)
    {
        $subjects = Subject::all();
        $data = array(
            'subjects'  => $subjects,
        );

        return view('assignment.index', $data);
    }

    public function indexWithInstance(Request $request, $subject_id)
    {
        $subject = Subject::find($subject_id);
        $data = array(
            'subjectOnly'  => $subject,
        );
        return view('assignment.index', $data);
    }

   public function indexWithQuiz(Request $request, $subject_id, $assignment_id)
   {
       $assignment = Assignment::find($assignment_id);

       $data = array(
           'assignment'  => $assignment,
       );
       if(isset($subject_id)) {
           $subject = Subject::find($subject_id);
           $data["subject"] = $subject;
       }
       return view('assignment.quiz', $data);

    }

    public function store(Request $request, $subject_id)
    {
        $subject = Subject::find($subject_id);
        $assignment = new Assignment();
        $assignment->subject()->associate($subject);
        $assignment->save();
        $assignment->knowledgeunits()->sync(Input::get('knowledgeunits'));

        return redirect('assignments/subjects/'.$subject_id);
    }
}
