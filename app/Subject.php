<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $attributes = array(
        'title' => '',
        'description' => '',
    );
    protected $fillable = ['title','description'];

    // Topics will be here
    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
