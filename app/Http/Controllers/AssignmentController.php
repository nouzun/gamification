<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Assignment;
use App\KnowledgeUnit;
use App\Repositories\AssignmentRepository;
use App\Subject;
use App\Topic;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Log;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AssignmentController extends Controller
{
    protected $assignments;

    public function __construct(AssignmentRepository $assignments)
    {
        $this->middleware('auth:administrator');
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
        return view('assignment.edit', $data);
    }

   public function indexWithQuiz(Request $request, $subject_id, $assignment_id)
   {
       $assignment = Assignment::find($assignment_id);

       $questionsAll = new Collection;

       foreach ($assignment->knowledgeunits()->get() as $knowledgeunit)
       {
           //Log::info('111 $knowledgeunit: '.$knowledgeunit->title);
           $questionsAll = $questionsAll->merge($knowledgeunit->questions()->get());
       }

       $data = array(
           'assignment'  => $assignment,
           'questionsAll' => $questionsAll,
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
        $assignment->due_date = $request->due_date;
        $assignment->subject()->associate($subject);
        $assignment->save();
        $assignment->knowledgeunits()->attach(Input::get('knowledgeunits'));

        return redirect('assignments/subjects/'.$subject_id);
    }

    public function storeQuiz(Request $request, $subject_id, $assignment_id)
    {
        $point = 0;
        $answers = Input::get('answers');
        $request->user()->assignments()->attach(array($assignment_id));
        $request->user()->answers()->attach($answers);

        foreach($answers as $answer_id) {
            $answer = Answer::find($answer_id);
            if ($answer->correct) {
                $point++;
            }
        }
        DB::update('UPDATE (users_assignments) SET point=? WHERE user_id=? AND assignment_id=?',
            [$point, $request->user()->id, $assignment_id]);
        return redirect('assignments');
    }
}
