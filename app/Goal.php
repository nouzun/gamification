<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    protected $attributes = array(
        'title' => '',
        'description' => '',
    );
    protected $fillable = ['title','description'];

    protected $appends = ['done'];

    function getDoneAttribute() {
        $done = true;
        foreach($this->subjects() as $subject){
            if($subject->allEasyAssignmentsDone == false){
                $done = false;
                break;
            }
        }
        return $done;
    }

    public function lecture()
    {
        return $this->belongsTo(Lecture::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'goals_subjects', 'goal_id', 'subject_id')->withTimestamps();
    }
}
