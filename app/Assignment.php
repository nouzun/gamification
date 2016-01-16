<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    public function knowledgeunits()
    {
        return $this->belongsToMany(KnowledgeUnit::class, 'quiz', 'assignment_id', 'knowledgeunit_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

}
