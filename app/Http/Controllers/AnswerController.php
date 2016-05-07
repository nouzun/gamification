<?php

namespace App\Http\Controllers;

use App\Answer;
use App\KnowledgeUnit;
use App\Question;
use App\Repositories\AnswerRepository;
use App\Subject;
use App\Topic;
use Log;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AnswerController extends Controller
{
    protected $answers;

    public function __construct(AnswerRepository $answers)
    {
        $this->middleware('auth:administrator');
        $this->answers = $answers;
    }

    public function index()
    {

    }

    public function indexWithInstance(Request $request, $subject_id, $topic_id, $knowledgeunit_id, $question_id)
    {
        $data = array(
            'answers'  => $this->answers->forQuestion($question_id),
        );

        if(isset($knowledgeunit_id)) {
            $subject = Subject::find($subject_id);
            $topic = Topic::find($topic_id);
            $knowledgeunit = KnowledgeUnit::find($knowledgeunit_id);
            $question = Question::find($question_id);
            $data["subject"] = $subject;
            $data["topic"] = $topic;
            $data["knowledge_unit"] = $knowledgeunit;
            $data["question"] = $question;
        }
        return view('answer.index', $data);
    }

    public function store(Request $request, $subject_id, $topic_id, $knowledgeunit_id, $question_id)
    {
        $this->validate($request, [
            'description' => 'required',
        ]);

        $question = Question::find($question_id);
        Log::info('$knowledgeUnit: '.$question->title);
        $answer = new Answer();
        $answer->correct = $request->correct ?  $request->correct : 0;
        $answer->description = $request->description;

        $answer->question()->associate($question);
        $answer->save();

        return redirect('subjects/'.$subject_id.'/topics/'.$topic_id.'/knowledgeunits/'.$knowledgeunit_id.'/questions/'.$question_id.'/answers');
    }

    public function edit(Request $request, $subject_id, $topic_id, $knowledgeunit_id, $question_id, $answer_id)
    {
        $subject = Subject::find($subject_id);
        $topic = Topic::find($topic_id);
        $knowledgeunit = KnowledgeUnit::find($knowledgeunit_id);
        $question = Question::find($question_id);
        $answer = Answer::find($answer_id);
        $data["subject"] = $subject;
        $data["topic"] = $topic;
        $data["knowledge_unit"] = $knowledgeunit;
        $data["question"] = $question;
        $data["answer"] = $answer;

        return view('answer.edit', $data);
    }

    public function update(Request $request, $subject_id, $topic_id, $knowledgeunit_id, $question_id, $answer_id)
    {
        $answer = Answer::find($answer_id);
        $answer->correct = $request->correct ?  $request->correct : 0;
        $answer->description = $request->description;
        $answer->save();
        return redirect('subjects/'.$subject_id.'/topics/'.$topic_id.'/knowledgeunits/'.$knowledgeunit_id.'/questions/'.$question_id.'/answers');
    }

    public function destroy(Request $request, $subject_id, $topic_id, $knowledgeunit_id, $question_id, $answer_id)
    {
        $answer = Answer::find($answer_id);
        $answer->delete();
        return redirect('subjects/'.$subject_id.'/topics/'.$topic_id.'/knowledgeunits/'.$knowledgeunit_id.'/questions/'.$question_id.'/answers');
    }
}
