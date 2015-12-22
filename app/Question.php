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
}
