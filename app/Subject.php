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

    protected $appends = ['assignmentDoneCount', 'assignmentTotal', 'allEasyAssignmentsDone'];

    function getAllEasyAssignmentsDoneAttribute() {
        $allEasyAssignmentsDone = false;

        $subject_id = $this->id;

        $numberOfEasyAssignment = DB::table('assignments')
            ->select(DB::raw('COUNT(assignments.id) as numberOfEasyAssignment'))
            ->where('difficulty_level', '=', 1)
            ->whereIn('assignments.knowledge_unit_id', function($query) use ($subject_id)
            {
                $query->select(DB::raw('knowledge_units.id'))
                    ->from('knowledge_units')
                    ->whereIn('knowledge_units.topic_id', function($query) use ($subject_id)
                    {
                        $query->select(DB::raw('topics.id'))
                            ->from('topics')
                            ->where('topics.subject_id', '=', $subject_id);
                    });
            })
            ->pluck('numberOfEasyAssignment');

        Log::info('########## numberOfEasyAssignment: '.$numberOfEasyAssignment);

        $numberOfFinishedEasyAssignment = DB::table('users_assignments')
            ->where('users_assignments.user_id', '=', Auth::user()->id)
            ->leftJoin('assignments', 'users_assignments.assignment_id', '=', 'assignments.id')
            ->select(DB::raw('COUNT(assignments.id) as numberOfFinishedEasyAssignment'))
            ->where('assignments.difficulty_level', '=', 1)
            ->whereIn('assignments.knowledge_unit_id', function($query) use ($subject_id)
            {
                $query->select(DB::raw('knowledge_units.id'))
                    ->from('knowledge_units')
                    ->whereIn('knowledge_units.topic_id', function($query) use ($subject_id)
                    {
                        $query->select(DB::raw('topics.id'))
                            ->from('topics')
                            ->where('topics.subject_id', '=', $subject_id);
                    });
            })
            ->pluck('numberOfFinishedEasyAssignment');

        Log::info('$numberOfFinishedEasyAssignment: '.$numberOfFinishedEasyAssignment);

        if($numberOfEasyAssignment == $numberOfFinishedEasyAssignment){
            $allEasyAssignmentsDone = true;
        }

        return $allEasyAssignmentsDone;
    }

    function getAssignmentTotalAttribute() {
        $numberOfTotalAssignment = DB::table('assignments')
            ->select(DB::raw('COUNT(id) as numberOfTotalAssignment'))
            ->where('assignments.enable', '=', 1)
            ->whereIn('assignments.knowledge_unit_id', function($query)
            {
                $query->select(DB::raw('knowledge_units.id'))
                    ->from('knowledge_units')
                    ->whereIn('knowledge_units.topic_id', function($query)
                    {
                        $query->select(DB::raw('topics.id'))
                            ->from('topics')
                            ->where('topics.subject_id', '=', $this->id);
                    });
            })
            ->pluck('numberOfTotalAssignment');

        if (!is_numeric($numberOfTotalAssignment)) $numberOfTotalAssignment = 0;

        Log::info('subject: '. $this->id.' $numberOfTotalAssignment: '.$numberOfTotalAssignment);

        return $numberOfTotalAssignment;
    }

    function getAssignmentDoneCountAttribute() {
        $numberOfFinishedAssignment = DB::table('users_assignments')
            ->leftJoin('assignments', 'users_assignments.assignment_id', '=', 'assignments.id')
            ->select(DB::raw('COUNT(assignments.id) as numberOfFinishedAssignment'))
            ->where('user_id', '=', Auth::user()->id)
            ->whereIn('assignments.knowledge_unit_id', function($query)
            {
                $query->select(DB::raw('knowledge_units.id'))
                    ->from('knowledge_units')
                    ->whereIn('knowledge_units.topic_id', function($query)
                    {
                        $query->select(DB::raw('topics.id'))
                            ->from('topics')
                            ->where('topics.subject_id', '=', $this->id);
                    });
            })
            ->pluck('numberOfFinishedAssignment');

        Log::info('subject: '.$this->id.' $numberOfFinishedAssignment: '.$numberOfFinishedAssignment);

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
