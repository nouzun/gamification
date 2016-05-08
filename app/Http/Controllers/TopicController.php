<?php

namespace App\Http\Controllers;

use App\Lecture;
use App\Repositories\TopicRepository;
use App\Subject;
use App\Topic;
use Illuminate\Http\Request;
use Log;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class TopicController extends Controller
{
    protected $topics;

    public function __construct(TopicRepository $topics)
    {
        $this->middleware('auth:administrator');
        $this->topics = $topics;
    }

    public function index(Request $request)
    {
        $data = array(
            'subjects'  => $this->topics->subjectsForUser($request->user()),
        );

        if (count($data["subjects"]) > 0) {
            $subject_id = $data["subjects"][0]->id;
            $subject = Subject::find($subject_id);
            $data["subject"] = $subject;
            $data["topics"] = $this->topics->forSubject($subject_id);
        }

        return view('topic.index', $data);
    }

    public function indexWithInstance(Request $request, $lecture_id, $subject_id)
    {
        /*
        $data = array(
            'subjects'  => $this->topics->subjectsForUser($request->user()),
        );
        */
        if(isset($subject_id)) {
            $lecture = Lecture::find($lecture_id);
            $subject = Subject::find($subject_id);
            $data["nav"] = "<a href=\"" .
                url('/lectures/'). "\">".
                $lecture->title ."</a> <span class=\"fa fa-chevron-right\"></span> <a href=\"".
                url('/lectures/'.$lecture->id.'/subjects/') ."\">" .
                $subject->title .
                "</a>";
            $data["lecture_id"] = $lecture_id;
            $data["subject_id"] = $subject_id;
            $data["topics"] = $this->topics->forSubject($subject_id);
        }

        return view('topic.index', $data);
    }

    public function show(Request $request, $lecture_id, $subject_id, $topic_id)
    {
        $subject = Subject::find($subject_id);
        $topic = Topic::find($topic_id);
        $data["subject"] = $subject;
        $data["topic"] = $topic;
        return view('topic.show', $data);
    }

    public function store(Request $request, $lecture_id, $subject_id)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
        ]);


        $subject = Subject::find($subject_id);
        Log::info('$subject_id: '.$subject->title);
        $topic = new Topic();
        $topic->title = $request->title;
        $topic->description = $request->description;
        $topic->topic_content = $request->topic_content;

        $topic->subject()->associate($subject);
        $topic->save();

        return redirect('/lectures/'.$lecture_id.'/subjects/'.$subject_id.'/topics');
    }

    public function edit(Request $request, $lecture_id, $subject_id, $topic_id)
    {
        $lecture = Lecture::find($lecture_id);
        $subject = Subject::find($subject_id);
        $topic = Topic::find($topic_id);
        $data["nav"] = "<a href=\"" . url('/lectures/'). "\">". $lecture->title ."</a> <span class=\"fa fa-chevron-right\"></span> <a href=\"". url('/lectures/'.$lecture->id.'/subjects/') ."\">" . $subject->title . "</a>";
        $data["lecture_id"] = $lecture_id;
        $data["subject_id"] = $subject_id;
        $data["topic"] = $topic;

        return view('topic.edit', $data);
    }

    public function update(Request $request, $lecture_id, $subject_id, $topic_id)
    {
        $topic = Topic::find($topic_id);
        $topic->title = $request->title;
        $topic->description = $request->description;
        $topic->topic_content = $request->topic_content;
        $topic->save();
        return redirect('/lectures/'.$lecture_id.'/subjects/'.$subject_id.'/topics');
    }

    public function destroy(Request $request, $lecture_id, $subject_id, $topic_id)
    {
        $topic = Topic::find($topic_id);

        $topic->delete();

        return redirect('/lectures/'.$lecture_id.'/subjects/'.$subject_id.'/topics');
    }
}
