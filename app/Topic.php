<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Topic extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $attributes = array(
        'title' => '',
        'description' => '',
        'topic_content' => '',
    );
    protected $fillable = ['title','description','topic_content'];
    // Knowledge Units will be here
    public function knowledgeunits()
    {
        return $this->hasMany(KnowledgeUnit::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
