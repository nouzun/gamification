<?php

namespace App\Http\Controllers;

use App\Assignment;
use App\KnowledgeUnit;
use App\Lecture;
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

    public function indexWithInstance(Request $request, $lecture_id, $subject_id, $topic_id, $knowledgeunit_id, $assignment_id)
    {
        $lecture = Lecture::find($lecture_id);
        $subject = Subject::find($subject_id);
        $topic = Topic::find($topic_id);
        $knowledgeunit = KnowledgeUnit::find($knowledgeunit_id);
        $assignment = Assignment::find($assignment_id);
        if(isset($knowledgeunit_id)) {
            $data["nav"] = "<a href=\"" . url('/lectures/'). "\">".
                $lecture->title .
                "</a> <span class=\"fa fa-chevron-right\"></span> <a href=\"".
                url('/lectures/'.$lecture->id.'/subjects/') ."\">" .
                $subject->title .
                "</a> <span class=\"fa fa-chevron-right\"></span> <a href=\"".
                url('/lectures/'.$lecture->id.'/subjects/'.$subject->id.'/topics/') ."\">".
                $topic->title .
                "</a> <span class=\"fa fa-chevron-right\"></span> <a href=\"".
                url('/lectures/'.$lecture->id.'/subjects/'.$subject->id.'/topics/'.$topic->id.'/knowledgeunits') ."\">".
                $knowledgeunit->title .
                "</a> <span class=\"fa fa-chevron-right\"></span> <a href=\"".
                url('/lectures/'.$lecture->id.'/subjects/'.$subject->id.'/topics/'.$topic->id.'/knowledgeunits/'.$knowledgeunit->id.'/assignments/'.$assignment->id.'/questions') ."\">".
                "Assignment " . $assignment->difficulty_level . '</a>';

            $data["lecture_id"] = $lecture_id;
            $data["subject_id"] = $subject_id;
            $data["topic_id"] = $topic_id;
            $data["knowledgeunit_id"] = $knowledgeunit_id;
            $data["assignment_id"] = $assignment_id;
            $data["questions"] = $this->questions->forAssignment($assignment_id);
        }
        return view('question.index', $data);
    }

    public function store(Request $request, $lecture_id, $subject_id, $topic_id, $knowledgeunit_id, $assignment_id)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
        ]);


        $assignment = KnowledgeUnit::find($assignment_id);

        $question = new Question();
        $question->title = $request->title;
        $question->description = $request->description;

        $question->assignment()->associate($assignment);
        $question->save();

        return redirect('/lectures/'.$lecture_id.'/subjects/'.$subject_id.'/topics/'.$topic_id.'/knowledgeunits/'.$knowledgeunit_id.'/assignments/'.$assignment_id.'/questions');
    }

    public function edit(Request $request, $lecture_id, $subject_id, $topic_id, $knowledgeunit_id, $assignment_id, $question_id)
    {
        $lecture = Lecture::find($lecture_id);
        $subject = Subject::find($subject_id);
        $topic = Topic::find($topic_id);
        $knowledgeunit = KnowledgeUnit::find($knowledgeunit_id);
        $assignment = Assignment::find($assignment_id);
        $question = Question::find($question_id);
        $data["nav"] = "<a href=\"" . url('/lectures/'). "\">".
            $lecture->title .
            "</a> <span class=\"fa fa-chevron-right\"></span> <a href=\"".
            url('/lectures/'.$lecture->id.'/subjects/') ."\">" .
            $subject->title .
            "</a> <span class=\"fa fa-chevron-right\"></span> <a href=\"".
            url('/lectures/'.$lecture->id.'/subjects/'.$subject->id.'/topics/') ."\">".
            $topic->title .
            "</a> <span class=\"fa fa-chevron-right\"></span> <a href=\"".
            url('/lectures/'.$lecture->id.'/subjects/'.$subject->id.'/topics/'.$topic->id.'/knowledgeunits') ."\">".
            $knowledgeunit->title .
            "</a> <span class=\"fa fa-chevron-right\"></span> <a href=\"" .
            url('/lectures/'.$lecture->id.'/subjects/'.$subject->id.'/topics/'.$topic->id.'/knowledgeunits/'.$knowledgeunit->id.'/assignments/'.$assignment_id.'/questions') ."\">".
            "Assignment " . $assignment->difficulty_level .
            "</a> <span class=\"fa fa-chevron-right\"></span>".
            $question->title;

        $data["lecture_id"] = $lecture_id;
        $data["subject_id"] = $subject_id;
        $data["topic_id"] = $topic_id;
        $data["knowledgeunit_id"] = $knowledgeunit_id;
        $data["assignment_id"] = $assignment_id;
        $data["question"] = $question;

        return view('question.edit', $data);
    }

    public function update(Request $request, $lecture_id, $subject_id, $topic_id, $knowledgeunit_id, $assignment_id, $question_id)
    {
        $question = Question::find($question_id);
        $question->title = $request->title;
        $question->description = $request->description;
        $question->save();
        return redirect('/lectures/'.$lecture_id.'/subjects/'.$subject_id.'/topics/'.$topic_id.'/knowledgeunits/'.$knowledgeunit_id.'/assignments/'.$assignment_id.'/questions');
    }

    public function destroy(Request $request, $lecture_id, $subject_id, $topic_id, $knowledgeunit_id, $assignment_id, $question_id)
    {
        $question = Question::find($question_id);
        $question->delete();
        return redirect('/lectures/'.$lecture_id.'/subjects/'.$subject_id.'/topics/'.$topic_id.'/knowledgeunits/'.$knowledgeunit_id.'/assignments/'.$assignment_id.'/questions');
    }
}
