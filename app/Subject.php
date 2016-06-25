<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Subject extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
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

    public function lecture()
    {
        return $this->belongsTo(Lecture::class);
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    public function goals()
    {
        return $this->belongsToMany(Goal::class, 'goals_subjects', 'goal_id', 'subject_id')->withTimestamps();
    }
}
