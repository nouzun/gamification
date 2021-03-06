<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Assignment;
use App\KnowledgeUnit;
use App\Lecture;
use App\Subject;
use App\Topic;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class AssignmentController extends Controller
{
    public function index(Request $request, $lecture_id, $subject_id, $topic_id, $knowledgeunit_id, $assignment_id)
    {
        $lecture = Lecture::find($lecture_id);
        $subject = Subject::find($subject_id);
        $topic = Topic::find($topic_id);
        $knowledgeunit = KnowledgeUnit::find($knowledgeunit_id);
        $assignment = Assignment::find($assignment_id);
        $questionsAll = new Collection;
        $questionsAll = $questionsAll->merge($assignment->questions()->get());

        $data = array(
            'assignment'  => $assignment,
            'questionsAll' => $questionsAll,
        );
        if(isset($subject_id)) {
            $data["nav"] = "<a href=\"" . url('/lectures/'.$lecture->id.'/content/'). "\">".
                $lecture->title .
                "</a> <span class=\"fa fa-chevron-right\"></span> <a href=\"".
                url('/lectures/'.$lecture->id.'/content/') ."\">" .
                $subject->title .
                "</a> <span class=\"fa fa-chevron-right\"></span> <a href=\"".
                url('/lectures/'.$lecture->id.'/subjects/'.$subject->id.'/topics/'.$topic->id.'/content') ."\">".
                $topic->title .
                "</a> <span class=\"fa fa-chevron-right\"></span> <a href=\"".
                url('/lectures/'.$lecture->id.'/content/') ."\">".
                $knowledgeunit->title .
                "</a> <span class=\"fa fa-chevron-right\"></span> <a href=\"".
                url('/lectures/'.$lecture->id.'/subjects/'.$subject->id.'/topics/'.$topic->id.'/knowledgeunits/'.$knowledgeunit->id.'/assignments/'.$assignment->id.'/quiz') ."\">".
                level2Text($assignment->difficulty_level) ." Assignment" .
                "</a>";


            $data["lecture"] = $lecture;
            $data["subject_id"] = $subject_id;
            $data["topic_id"] = $topic_id;
            $data["knowledgeunit_id"] = $knowledgeunit_id;
            $data["all_easy_done"] = 0;
            $data["goal_done"] = 0;
            if($subject->allEasyAssignmentsDone) {
                $data["all_easy_done"] = 1;
                foreach($subject->goals as $goal){
                    if($goal->done) $data["goal_done"] = 1;
                }
            }
        }
        return view('assignment.quiz', $data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function store(Request $request, $lecture_id, $subject_id, $topic_id, $knowledgeunit_id, $assignment_id)
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

        $subject = Subject::find($subject_id);

        if($subject->allEasyAssignmentsDone){
            $now = Carbon::now()->toDateTimeString();
            DB::insert('INSERT INTO users_rewards (user_id,reward_id,subject_id,created_at,updated_at) VALUES (?,?,?,?,?)',
                [$request->user()->id, 1, $subject_id, $now, $now]);

            foreach ($subject->goals as $goal) {
                if($goal->done) {
                    DB::insert('INSERT INTO users_rewards (user_id,reward_id,goal_id,created_at,updated_at) VALUES (?,?,?,?,?)',
                        [$request->user()->id, 4, $goal->id, $now, $now]);
                }
            }
        
        }

        $redirect_url = '/lectures/'.$lecture_id.'/subjects/'.$subject_id.'/topics/'.$topic_id.'/knowledgeunits/'.$knowledgeunit_id.'/assignments/'.$assignment_id.'/quiz';

        return redirect($redirect_url);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
