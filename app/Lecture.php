<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Lecture extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $attributes = array(
        'title' => '',
        'description' => '',
    );
    protected $fillable = ['title','description'];

    protected $appends = ['gamenessIndex', 'level'];

    function getLevelAttribute() {
        $level = 1;
        $lecture_id = $this->id;

        $numberOfEasyAssignment = DB::table('assignments')
            ->select(DB::raw('COUNT(assignments.id) as numberOfEasyAssignment'))
            ->where('difficulty_level', '=', 1)
            ->whereIn('assignments.knowledge_unit_id', function($query) use ($lecture_id)
            {
                $query->select(DB::raw('knowledge_units.id'))
                    ->from('knowledge_units')
                    ->whereIn('knowledge_units.topic_id', function($query) use ($lecture_id)
                    {
                        $query->select(DB::raw('topics.id'))
                            ->from('topics')
                            ->whereIn('topics.subject_id', function($query) use ($lecture_id) {
                                $query->select(DB::raw('subjects.id'))
                                    ->from('subjects')
                                    ->where('subjects.lecture_id', '=', $lecture_id);
                            });
                    });
            })
            ->pluck('numberOfEasyAssignment');

        $numberOfFinishedEasyAssignment = DB::table('users_assignments')
            ->where('users_assignments.user_id', '=', Auth::user()->id)
            ->leftJoin('assignments', 'users_assignments.assignment_id', '=', 'assignments.id')
            ->select(DB::raw('COUNT(assignments.id) as numberOfFinishedEasyAssignment'))
            ->where('assignments.difficulty_level', '=', 1)
            ->whereIn('assignments.knowledge_unit_id', function($query) use ($lecture_id)
            {
                $query->select(DB::raw('knowledge_units.id'))
                    ->from('knowledge_units')
                    ->whereIn('knowledge_units.topic_id', function($query) use ($lecture_id)
                    {
                        $query->select(DB::raw('topics.id'))
                            ->from('topics')
                            ->whereIn('topics.subject_id', function($query) use ($lecture_id) {
                                $query->select(DB::raw('subjects.id'))
                                    ->from('subjects')
                                    ->where('subjects.lecture_id', '=', $lecture_id);
                            });
                    });
            })
            ->pluck('numberOfFinishedEasyAssignment');

        if($numberOfEasyAssignment == $numberOfFinishedEasyAssignment){
            $level++;
        }

        return $level;

    }

    function getGamenessIndexAttribute() {

    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function goals()
    {
        return $this->hasMany(Goal::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
