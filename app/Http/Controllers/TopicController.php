<?php

namespace App\Http\Controllers;

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
        $this->middleware('auth');
        $this->topics = $topics;
    }

    public function index(Request $request, $subject_id)
    {
        $subject = Subject::find($subject_id);
        return view('topic.index', [
            'subject' => $subject,
            'topics' => $this->topics->forSubject($subject_id),
        ]);
    }

    public function store(Request $request, $subject_id)
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

        $topic->subject()->associate($subject);
        $topic->save();

        return redirect('subjects/'.$subject_id.'/topics');
    }

    public function destroy(Request $request, Topic $topic)
    {
        $this->authorize('destroy', $topic);

        $topic->delete();

        return redirect('/topics');
    }
}
