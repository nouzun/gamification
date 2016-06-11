<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lecture extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $attributes = array(
        'title' => '',
        'description' => '',
    );
    protected $fillable = ['title','description'];

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function goals()
    {
        return $this->hasMany(Goal::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
