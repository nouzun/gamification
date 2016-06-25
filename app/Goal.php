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

    public function lecture()
    {
        return $this->belongsTo(Lecture::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'goals_subjects', 'goal_id', 'subject_id')->withTimestamps();
    }
}
