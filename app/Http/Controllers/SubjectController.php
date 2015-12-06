<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        $subjects = Subject::where('user_id', $request->user()->id)->get();

        return view('subjects.index', [
            'subjects' => $subjects,
        ]);
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
