<?php

namespace App\Http\Controllers;

use App\KnowledgeUnit;
use App\Question;
use App\Repositories\QuestionRepository;
use App\Subject;
use App\Topic;
use Log;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class QuestionController extends Controller
{
    protected $questions;

    public function __construct(QuestionRepository $questions)
    {
        $this->middleware('auth:administrator');
        $this->questions = $questions;
    }

    public function index()
    {

    }

    public function indexWithInstance(Request $request, $subject_id, $topic_id, $knowledgeunit_id)
    {
        $data = array(
            'questions'  => $this->questions->forKnowledgeUnit($knowledgeunit_id),
        );

        if(isset($topic_id)) {
            $subject = Subject::find($subject_id);
            $topic = Topic::find($topic_id);
            $knowledgeunit = KnowledgeUnit::find($knowledgeunit_id);
            $data["subject"] = $subject;
            $data["topic"] = $topic;
            $data["knowledge_unit"] = $knowledgeunit;
        }
        return view('question.index', $data);
    }

    public function store(Request $request, $subject_id, $topic_id, $knowledgeunit_id)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
        ]);


        $knowledgeUnit = KnowledgeUnit::find($knowledgeunit_id);
        Log::info('$knowledgeUnit: '.$knowledgeUnit->title);
        $question = new Question();
        $question->title = $request->title;
        $question->description = $request->description;

        $question->knowledge_unit()->associate($knowledgeUnit);
        $question->save();

        return redirect('subjects/'.$subject_id.'/topics/'.$topic_id.'/knowledgeunits/'.$knowledgeunit_id.'/questions');
    }

    public function edit(Request $request, $subject_id, $topic_id, $knowledgeunit_id, $question_id)
    {
        $subject = Subject::find($subject_id);
        $topic = Topic::find($topic_id);
        $knowledgeunit = KnowledgeUnit::find($knowledgeunit_id);
        $question = Question::find($question_id);
        $data["subject"] = $subject;
        $data["topic"] = $topic;
        $data["knowledge_unit"] = $knowledgeunit;
        $data["question"] = $question;

        return view('question.edit', $data);
    }

    public function update(Request $request, $subject_id, $topic_id, $knowledgeunit_id, $question_id)
    {
        $question = Question::find($question_id);
        $question->title = $request->title;
        $question->description = $request->description;
        $question->save();
        return redirect('subjects/'.$subject_id.'/topics/'.$topic_id.'/knowledgeunits/'.$knowledgeunit_id.'/questions');
    }
}
