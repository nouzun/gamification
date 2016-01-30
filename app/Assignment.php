<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Log;

class Assignment extends Model
{
    protected $appends = ['done', 'point'];

    function getDoneAttribute() {
        $is_done = 0;
        $is_done_query = DB::table('users_assignments')
            ->where('user_id', '=', Auth::user()->id)
            ->where('assignment_id', '=', $this->id)
            ->first();

        if (!is_null($is_done_query)) {
            $is_done = 1;
        }

        return $is_done;
    }

    function getPointAttribute() {

        $point = DB::table('users_assignments')
            ->where('user_id', '=', Auth::user()->id)
            ->where('assignment_id', '=', $this->id)
            ->pluck('point');

        /*
            $point = DB::select('SELECT point FROM users_assignments WHERE user_id=? AND assignment_id=?',
                [Auth::user()->id, $this->id]);
        */
        return $point;
    }

    public function knowledgeunits()
    {
        return $this->belongsToMany(KnowledgeUnit::class, 'quiz', 'assignment_id', 'knowledgeunit_id')->withTimestamps();
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_assignments', 'user_id', 'assignment_id')->withTimestamps();
    }
}
