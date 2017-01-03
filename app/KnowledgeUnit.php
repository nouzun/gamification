<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KnowledgeUnit extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $attributes = array(
        'title' => '',
        'description' => '',
    );

    protected $appends = ['done', 'point'];

    function getDoneAttribute() {
        $is_done = 0;
        $is_done_query = DB::table('users_knowledgeunits')
            ->where('user_id', '=', Auth::user()->id)
            ->where('knowledgeunit_id', '=', $this->id)
            ->first();

        if (!is_null($is_done_query)) {
            $is_done = 1;
        }

        return $is_done;
    }

    function getPointAttribute() {

        $point = DB::table('users_knowledgeunits')
            ->where('user_id', '=', Auth::user()->id)
            ->where('knowledgeunit_id', '=', $this->id)
            ->pluck('point');

        return $point;
    }

    protected $fillable = ['title','description'];

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    public function assignments_level($level)
    {
        return $this->hasMany(Assignment::class)->where('difficulty_level', $level);
    }
/*
    public function assignments()
    {
        return $this->belongsToMany(Assignment::class, 'quiz', 'assignment_id', 'knowledgeunit_id')->withTimestamps();
    }
*/
    public function users()
    {
        return $this->belongsToMany(User::class, 'users_knowledgeunits', 'user_id', 'knowledgeunit_id')->withTimestamps();
    }
}
