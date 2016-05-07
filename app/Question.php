<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $attributes = array(
        'title' => '',
        'description' => '',
    );
    protected $fillable = ['title','description'];

    public function knowledge_unit()
    {
        return $this->belongsTo(KnowledgeUnit::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function correctAnswers()
    {
        return $this->answers()
            ->where('answers.correct', '=', 1);
    }

    // this is a recommended way to declare event handlers
    protected static function boot() {
        parent::boot();

        static::deleting(function($question) { // before delete() method call this
            $question->answers()->delete();
        });
    }
}
