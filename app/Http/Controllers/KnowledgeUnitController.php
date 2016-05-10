<?php

namespace App\Http\Controllers;

use App\KnowledgeUnit;
use App\Lecture;
use App\Repositories\KnowledgeUnitRepository;
use App\Subject;
use App\Topic;
use Log;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class KnowledgeUnitController extends Controller
{
    protected $knowledgeUnits;

    public function __construct(KnowledgeUnitRepository $knowledeUnits)
    {
        $this->middleware('auth:administrator');
        $this->knowledgeUnits = $knowledeUnits;
    }

    public function index(Request $request)
    {

    }

    public function indexWithInstance(Request $request, $lecture_id, $subject_id, $topic_id)
    {
        $lecture = Lecture::find($lecture_id);
        $subject = Subject::find($subject_id);
        $topic = Topic::find($topic_id);
        $data["nav"] = "<a href=\"" . url('/lectures/'). "\">".
            $lecture->title ."</a> <span class=\"fa fa-chevron-right\"></span> <a href=\"".
            url('/lectures/'.$lecture->id.'/subjects/') ."\">" .
            $subject->title .
            "</a> <span class=\"fa fa-chevron-right\"></span> <a href=\"".
            url('/lectures/'.$lecture->id.'/subjects/'.$subject->id.'/topics/') ."\">".
            $topic->title.
            "</a>";
        $data["lecture_id"] = $lecture_id;
        $data["subject_id"] = $subject_id;
        $data["topic_id"] = $topic_id;
        if(isset($topic_id)) {
            $data["knowledgeunits"] = $this->knowledgeUnits->forTopic($topic_id);
        }
        return view('knowledgeunit.index', $data);
    }

    public function store(Request $request, $lecture_id, $subject_id, $topic_id)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
        ]);


        $topic = Topic::find($topic_id);
        Log::info('$topic_id: '.$topic->title);
        $knowledgeUnit = new KnowledgeUnit();
        $knowledgeUnit->title = $request->title;
        $knowledgeUnit->description = $request->description;
        $knowledgeUnit->difficulty_level = $request->difficulty_level;

        $knowledgeUnit->topic()->associate($topic);
        $knowledgeUnit->save();

        return redirect('/lectures/'.$lecture_id.'/subjects/'.$subject_id.'/topics/'.$topic_id.'/knowledgeunits');
    }

    public function edit(Request $request, $lecture_id, $subject_id, $topic_id, $knowledgeunit_id)
    {
        $lecture = Lecture::find($lecture_id);
        $subject = Subject::find($subject_id);
        $topic = Topic::find($topic_id);
        $knowledgeunit = KnowledgeUnit::find($knowledgeunit_id);
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
            "</a>";
        $data["lecture_id"] = $lecture_id;
        $data["subject_id"] = $subject_id;
        $data["topic_id"] = $topic_id;
        $data["knowledge_unit"] = $knowledgeunit;

        return view('knowledgeunit.edit', $data);
    }

    public function update(Request $request, $lecture_id, $subject_id, $topic_id, $knowledgeunit_id)
    {
        $knowledgeunit = KnowledgeUnit::find($knowledgeunit_id);
        $knowledgeunit->title = $request->title;
        $knowledgeunit->description = $request->description;
        $knowledgeunit->difficulty_level = $request->difficulty_level;
        $knowledgeunit->save();
        return redirect('/lectures/'.$lecture_id.'/subjects/'.$subject_id.'/topics/'.$topic_id.'/knowledgeunits');
    }

    public function destroy(Request $request, $lecture_id, $subject_id, $topic_id, $knowledgeunit_id)
    {
        $knowledgeunit = KnowledgeUnit::find($knowledgeunit_id);

        $knowledgeunit->delete();

        return redirect('/lectures/'.$lecture_id.'/subjects/'.$subject_id.'/topics/'.$topic_id.'/knowledgeunits');
    }
}
