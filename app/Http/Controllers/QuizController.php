<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Assignment;
use App\Lecture;
use App\Quiz;
use App\Repositories\QuizRepository;
use App\Subject;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Log;
use App\Http\Requests;

class QuizController extends Controller
{
    protected $quizzes;

    public function __construct(QuizRepository $quizzes)
    {
        $this->middleware('auth:all');
        $this->quizzes = $quizzes;
    }

    public function manage(Request $request)
    {
        return view('quiz.manage', [
            'lectures' => Lecture::all(),
        ]);
    }

    public function index(Request $request, $lecture_id)
    {
        $lecture = Lecture::find($lecture_id);
        $subjects = $lecture->subjects()->get();
        Log::info('$lecture_id: '.$lecture_id);
        $data = array(
            'subjects'  => $subjects,
        );

        return view('quiz.index', $data);
    }

    public function addQuiz(Request $request, $lecture_id, $subject_id)
    {
        $subject = Subject::find($subject_id);
        $mytime = Carbon::now();
        $data = array(
            'subjectOnly'  => $subject,
            'today' => $mytime->toDateString(),
        );
        return view('quiz.edit', $data);
    }

   public function indexWithQuiz(Request $request, $lecture_id, $subject_id, $quiz_id)
   {
       $quiz = Quiz::find($quiz_id);

       $data = array(
           'quiz'  => $quiz,
       );
       if(isset($subject_id)) {
           $subject = Subject::find($subject_id);
           $data["subject"] = $subject;
       }
       return view('quiz.quiz', $data);

    }

    public function store(Request $request, $lecture_id, $subject_id)
    {
        $subject = Subject::find($subject_id);
        $quiz = new Quiz();
        $quiz->duration = $request->duration;
        $quiz->due_date = $request->due_date.' 23:59';
        $quiz->subject()->associate($subject);
        $quiz->save();

        return redirect('/lectures/'.$lecture_id.'/subjects/'.$subject_id.'/quiz');
    }

    public function storeQuiz(Request $request, $lecture_id, $subject_id, $assignment_id)
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
        return redirect('/lectures/'.$lecture_id.'/assignments');
    }
}
