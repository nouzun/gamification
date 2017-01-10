<?php

namespace App\Http\Controllers;

use App\Answer;
use App\KnowledgeUnit;
use App\Lecture;
use App\Question;
use App\Quiz;
use App\Repositories\AnswerRepository;
use App\Subject;
use App\Topic;
use App\Assignment;
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

    public function indexWithInstance(Request $request, $lecture_id, $subject_id, $topic_id, $knowledgeunit_id, $assignment_id, $question_id)
    {
        $lecture = Lecture::find($lecture_id);
        $subject = Subject::find($subject_id);
        $topic = Topic::find($topic_id);
        $knowledgeunit = KnowledgeUnit::find($knowledgeunit_id);
        $assignment = Assignment::find($assignment_id);
        $question = Question::find($question_id);
        if(isset($question_id)) {
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
                level2Text($assignment->difficulty_level) ." Assignment" .
                "</a> <span class=\"fa fa-chevron-right\"></span> <a href=\"".
                url('/lectures/'.$lecture->id.'/subjects/'.$subject->id.'/topics/'.$topic->id.'/knowledgeunits/'.$knowledgeunit->id.'/assignments/'.$assignment->id.'/questions/'.$question->id) ."\">".
                $question->title .
                "</a>";

            $data["lecture_id"] = $lecture_id;
            $data["subject_id"] = $subject_id;
            $data["topic_id"] = $topic_id;
            $data["knowledgeunit_id"] = $knowledgeunit_id;
            $data["assignment_id"] = $assignment_id;
            $data["question_id"] = $question_id;
            $data["answers"] = $this->answers->forQuestion($question_id);
        }
        return view('answer.index', $data);
    }

    public function indexWithQuiz(Request $request, $lecture_id, $subject_id, $quiz_id, $question_id)
    {
        $lecture = Lecture::find($lecture_id);
        $subject = Subject::find($subject_id);
        $quiz = Quiz::find($quiz_id);
        $question = Question::find($question_id);
        if(isset($question_id)) {
            $data["nav"] = "<a href=\"" . url('/lectures/'). "\">".
                $lecture->title .
                "</a> <span class=\"fa fa-chevron-right\"></span> <a href=\"".
                url('/lectures/'.$lecture->id.'/subjects/') ."\">" .
                $subject->title .
                "</a> <span class=\"fa fa-chevron-right\"></span> <a href=\"".
                url('/lectures/'.$lecture->id.'/subjects/'.$subject->id.'/quizzes/'.$quiz->id.'/questions') ."\">".
                "Quiz" .
                "</a> <span class=\"fa fa-chevron-right\"></span> <a href=\"".
                url('/lectures/'.$lecture->id.'/subjects/'.$subject->id.'/quizzes/'.$quiz->id.'/questions/'.$question->id) ."\">".
                $question->title .
                "</a>";

            $data["lecture_id"] = $lecture_id;
            $data["subject_id"] = $subject_id;
            $data["quiz_id"] = $quiz_id;
            $data["question_id"] = $question_id;
            $data["answers"] = $this->answers->forQuestion($question_id);
        }
        return view('answer.index', $data);
    }

    public function store(Request $request, $lecture_id, $subject_id, $topic_id, $knowledgeunit_id, $assignment_id, $question_id)
    {
        $this->validate($request, [
            'description' => 'required',
        ]);

        $question = Question::find($question_id);

        $answer = new Answer();
        $answer->correct = $request->correct ?  $request->correct : 0;
        $answer->description = $request->description;
        if($answer->correct) {
            $answer->explanation = $request->explanation;
        }

        $answer->question()->associate($question);
        $answer->save();

        return redirect('/lectures/'.$lecture_id.'/subjects/'.$subject_id.'/topics/'.$topic_id.'/knowledgeunits/'.$knowledgeunit_id.'/assignments/'.$assignment_id.'/questions/'.$question_id.'/answers');
    }

    public function storeWithQuiz(Request $request, $lecture_id, $subject_id, $quiz_id, $question_id)
    {
        $this->validate($request, [
            'description' => 'required',
        ]);

        $question = Question::find($question_id);

        $answer = new Answer();
        $answer->correct = $request->correct ?  $request->correct : 0;
        $answer->description = $request->description;
        if($answer->correct) {
            $answer->explanation = $request->explanation;
        }

        $answer->question()->associate($question);
        $answer->save();

        return redirect('/lectures/'.$lecture_id.'/subjects/'.$subject_id.'/quizzes/'.$quiz_id.'/questions/'.$question_id.'/answers');
    }

    public function edit(Request $request, $lecture_id, $subject_id, $topic_id, $knowledgeunit_id, $assignment_id, $question_id, $answer_id)
    {
        $lecture = Lecture::find($lecture_id);
        $subject = Subject::find($subject_id);
        $topic = Topic::find($topic_id);
        $knowledgeunit = KnowledgeUnit::find($knowledgeunit_id);
        $assignment = Assignment::find($assignment_id);
        $question = Question::find($question_id);
        $answer = Answer::find($answer_id);
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
            level2Text($assignment->difficulty_level) ." Assignment" .
            "</a> <span class=\"fa fa-chevron-right\"></span> <a href=\"".
            url('/lectures/'.$lecture->id.'/subjects/'.$subject->id.'/topics/'.$topic->id.'/knowledgeunits/'.$knowledgeunit->id.'/assignments/'.$assignment->id.'/questions/'.$question->id) ."\">".
            $question->title .
            "</a>";

        $data["lecture_id"] = $lecture_id;
        $data["subject_id"] = $subject_id;
        $data["topic_id"] = $topic_id;
        $data["knowledgeunit_id"] = $knowledgeunit_id;
        $data["assignment_id"] = $assignment_id;
        $data["question_id"] = $question_id;
        $data["answer"] = $answer;

        return view('answer.edit', $data);
    }

    public function editWithQuiz(Request $request, $lecture_id, $subject_id, $quiz_id, $question_id, $answer_id)
    {
        $lecture = Lecture::find($lecture_id);
        $subject = Subject::find($subject_id);
        $quiz = Quiz::find($quiz_id);
        $question = Question::find($question_id);
        $answer = Answer::find($answer_id);
        $data["nav"] = "<a href=\"" . url('/lectures/'). "\">".
            $lecture->title .
            "</a> <span class=\"fa fa-chevron-right\"></span> <a href=\"".
            url('/lectures/'.$lecture->id.'/subjects/') ."\">" .
            $subject->title .
            "</a> <span class=\"fa fa-chevron-right\"></span> <a href=\"".
            url('/lectures/'.$lecture->id.'/subjects/'.$subject->id.'/quizzes/'.$quiz->id.'/questions') ."\">".
            "Quiz" .
            "</a> <span class=\"fa fa-chevron-right\"></span> <a href=\"".
            url('/lectures/'.$lecture->id.'/subjects/'.$subject->id.'/quizzes/'.$quiz->id.'/questions/'.$question->id) ."\">".
            $question->title .
            "</a>";

        $data["lecture_id"] = $lecture_id;
        $data["subject_id"] = $subject_id;
        $data["quiz_id"] = $quiz_id;
        $data["question_id"] = $question_id;
        $data["answer"] = $answer;

        return view('answer.edit', $data);
    }

    public function update(Request $request, $lecture_id, $subject_id, $topic_id, $knowledgeunit_id, $assignment_id, $question_id, $answer_id)
    {
        $answer = Answer::find($answer_id);
        $answer->correct = $request->correct ?  $request->correct : 0;
        $answer->description = $request->description;
        if($answer->correct) {
            $answer->explanation = $request->explanation;
        }
        $answer->save();
        return redirect('/lectures/'.$lecture_id.'/subjects/'.$subject_id.'/topics/'.$topic_id.'/knowledgeunits/'.$knowledgeunit_id.'/assignments/'.$assignment_id.'/questions/'.$question_id.'/answers');
    }

    public function updateWithQuiz(Request $request, $lecture_id, $subject_id, $quiz_id, $question_id, $answer_id)
    {
        $answer = Answer::find($answer_id);
        $answer->correct = $request->correct ?  $request->correct : 0;
        $answer->description = $request->description;
        if($answer->correct) {
            $answer->explanation = $request->explanation;
        }
        $answer->save();
        return redirect('/lectures/'.$lecture_id.'/subjects/'.$subject_id.'/quizzes/'.$quiz_id.'/questions/'.$question_id.'/answers');
    }

    public function destroy(Request $request, $lecture_id, $subject_id, $topic_id, $knowledgeunit_id, $assignment_id, $question_id, $answer_id)
    {
        $answer = Answer::find($answer_id);
        $answer->delete();
        return redirect('/lectures/'.$lecture_id.'/subjects/'.$subject_id.'/topics/'.$topic_id.'/knowledgeunits/'.$knowledgeunit_id.'/assignments/'.$assignment_id.'/questions/'.$question_id.'/answers');
    }

    public function destroyWithQuiz(Request $request, $lecture_id, $subject_id, $quiz_id, $question_id, $answer_id)
    {
        $answer = Answer::find($answer_id);
        $answer->delete();
        return redirect('/lectures/'.$lecture_id.'/subjects/'.$subject_id.'/quizzes/'.$quiz_id.'/questions/'.$question_id.'/answers');
    }
}
