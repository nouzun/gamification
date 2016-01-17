<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model {
    protected $attributes = array(
        'description' => '',
        'correct' => 0,
    );

    protected $fillable = ['description','correct'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_answers', 'user_id', 'answer_id');
    }
}