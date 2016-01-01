<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Assignment;
use App\KnowledgeUnit;
use App\Repositories\AssignmentRepository;
use App\Subject;
use App\Topic;
use Illuminate\Http\Request;
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

    public function index()
    {
        $subjects = Subject::with(['topics', 'topics.knowledgeunits'])->get();
        $data = array(
            'subjects'  => $subjects,
        );

        return view('assignment.index', $data);
    }

    public function indexWithInstance(Request $request, $subject_id, $topic_id, $knowledgeunit_id)
    {
        $knowledgeunit = KnowledgeUnit::find($knowledgeunit_id);

        $knowledgeunit->load('questions', 'questions.answers', 'questions.correctAnswers');

        $data = array(
            'knowledgeunit'  => $knowledgeunit,
        );
        if(isset($knowledgeunit_id)) {
            $subject = Subject::find($subject_id);
            $topic = Topic::find($topic_id);
            $data["subject"] = $subject;
            $data["topic"] = $topic;
        }
        return view('assignment.quiz', $data);
    }

    public function store(Request $request, $subject_id, $topic_id, $knowledgeunit_id)
    {
        $assignment = new Assignment();

        foreach ($request->answers as $answer) {
            $selected[] = new Answer(['answer' => $answer]);
        }

        $assignment->user()->associate($request->user());
        $assignment->answers()->saveMany($selected);
    }
}
