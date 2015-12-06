<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $attributes = array(
        'description' => '',
    );
    protected $fillable = ['description'];

    public function knowledge_unit()
    {
        return $this->belongsTo(KnowledgeUnit::class);
    }
}
