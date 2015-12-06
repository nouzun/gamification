<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SubjectController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index(Request $request)
    {
        /*
        $subjects = Subject::where('user_id', $request->user()->id)->get();

        return view('subject.index', [
            'subjects' => $subjects,
        ]);
        */

        return view('subject.index');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
        ]);

        $request->user()->subjects()->create([
            'title' => $request->title,
        ]);


        return redirect('/subjects');
    }
}
