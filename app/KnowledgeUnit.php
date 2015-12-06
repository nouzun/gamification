<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KnowledgeUnit extends Model
{
    protected $attributes = array(
        'title' => '',
    );
    protected $fillable = ['title'];

    // Questions will be here
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
}
