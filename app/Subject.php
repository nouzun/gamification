<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Log;

class Subject extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $attributes = array(
        'title' => '',
        'description' => '',
    );
    protected $fillable = ['title','description'];

    protected $appends = ['assignmentDoneCount', 'assignmentTotal'];

    function getAssignmentTotalAttribute() {
        $numberOfTotalAssignment = DB::table('assignments')
            ->select(DB::raw('COUNT(id) as numberOfTotalAssignment'))
            ->whereIn('assignments.knowledge_unit_id', function($query)
            {
                $query->select(DB::raw(1))
                    ->from('knowledge_units')
                    ->whereIn('topic_id', function($query)
                    {
                        $query->select(DB::raw(1))
                            ->from('topics')
                            ->where('topics.subject_id', '=', $this->id);
                    });
            })
            ->pluck('numberOfTotalAssignment');

        if (!is_numeric($numberOfTotalAssignment)) $numberOfTotalAssignment = 0;

        Log::info('$numberOfTotalAssignment: '.$numberOfTotalAssignment);

        return $numberOfTotalAssignment;
    }

    function getAssignmentDoneCountAttribute() {
        $numberOfFinishedAssignment = DB::table('users_assignments')
            ->leftJoin('assignments', 'users_assignments.assignment_id', '=', 'assignments.id')
            ->select(DB::raw('COUNT(assignments.id) as numberOfFinishedAssignment'))
            ->where('user_id', '=', Auth::user()->id)
            ->whereIn('assignments.knowledge_unit_id', function($query)
            {
                $query->select(DB::raw(1))
                    ->from('knowledge_units')
                    ->whereIn('topic_id', function($query)
                    {
                        $query->select(DB::raw(1))
                            ->from('topics')
                            ->where('topics.subject_id', '=', $this->id);
                    });
            })
            ->pluck('numberOfFinishedAssignment');

        Log::info('querty: '.$numberOfFinishedAssignment);

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

    public function goals()
    {
        return $this->belongsToMany(Goal::class, 'goals_subjects', 'goal_id', 'subject_id')->withTimestamps();
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

}
