<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $attributes = array(
        'title' => '',
        'description' => '',
    );
    protected $fillable = ['title','description'];
    // Knowledge Units will be here
    public function knowledge_units()
    {
        return $this->hasMany(KnowledgeUnit::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
