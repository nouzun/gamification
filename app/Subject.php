<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Subject extends Model
{
    protected $attributes = array(
        'title' => '',
        'description' => '',
    );
    protected $fillable = ['title','description'];

    protected $appends = ['assignmentDoneCount'];

    function getAssignmentDoneCountAttribute() {
        $numberOfFinishedAssignment = DB::table('users_assignments')
            ->leftJoin('assignments', 'users_assignments.assignment_id', '=', 'assignments.id')
            ->select(DB::raw('COUNT(assignments.id) as numberOfFinishedAssignment'))
            ->where('user_id', '=', Auth::user()->id)
            ->where('assignments.subject_id', '=', $this->id)
            ->groupBy('assignments.subject_id')
            ->pluck('numberOfFinishedAssignment');

        if (!is_numeric($numberOfFinishedAssignment)) $numberOfFinishedAssignment = 0;

        return $numberOfFinishedAssignment;
    }

    // Topics will be here
    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
}
