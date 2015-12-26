<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model {
    protected $attributes = array(
        'description' => '',
        'correct' => 0,
    );

    protected $fillable = ['description','correct'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}