<?php

namespace App\Http\Controllers;

use App\KnowledgeUnit;
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

    public function indexWithInstance(Request $request, $subject_id, $topic_id)
    {
        $data = array(
            'knowledgeunits'  => $this->knowledgeUnits->forTopic($topic_id),
        );

        if(isset($topic_id)) {
            $subject = Subject::find($subject_id);
            $topic = Topic::find($topic_id);
            $data["subject"] = $subject;
            $data["topic"] = $topic;
        }
        return view('knowledgeunit.index', $data);
    }

    public function store(Request $request, $subject_id, $topic_id)
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

        return redirect('subjects/'.$subject_id.'/topics/'.$topic_id.'/knowledgeunits');
    }
}
