<?php

namespace App\Http\Controllers;

use App\Repositories\AssignmentRepository;
use App\Subject;
use Illuminate\Http\Request;

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
}
