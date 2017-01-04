<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Log;

class Quiz extends Model
{
    protected $appends = ['done', 'point'];

    function getDoneAttribute() {
        $is_done = 0;
        $is_done_query = DB::table('users_quizzes')
            ->where('user_id', '=', Auth::user()->id)
            ->where('quiz_id', '=', $this->id)
            ->first();

        if (!is_null($is_done_query)) {
            $is_done = 1;
        }

        return $is_done;
    }

    function getPointAttribute() {

        $point = DB::table('users_quizzes')
            ->where('user_id', '=', Auth::user()->id)
            ->where('quiz_id', '=', $this->id)
            ->pluck('point');


        Log::info('111 $point: '.$point);

        return $point;
    }

    // Questions will be here
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_quizzes', 'user_id', 'quiz_id')->withTimestamps();
    }
}
