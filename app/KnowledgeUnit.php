<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KnowledgeUnit extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $attributes = array(
        'title' => '',
        'description' => '',
    );
    protected $fillable = ['title','description'];

    // Questions will be here
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function assignments()
    {
        return $this->belongsToMany(Assignment::class, 'quiz', 'assignment_id', 'knowledgeunit_id')->withTimestamps();
    }
}
