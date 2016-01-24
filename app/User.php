<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Support\Facades\DB;
use Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    protected $appends = ['points'];

    function getPointsAttribute() {

        $points = DB::table('users_assignments')
            ->select(DB::raw('SUM(point) as points'))
            ->where('user_id', '=', $this->id)
            ->pluck('points');

        Log::info('$points: '.$points);

        /*
            $point = DB::select('SELECT point FROM users_assignments WHERE user_id=? AND assignment_id=?',
                [Auth::user()->id, $this->id]);
        */
        return $points;
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function assignments()
    {
        return $this->belongsToMany(Assignment::class, 'users_assignments', 'user_id', 'assignment_id');
    }

    public function answers()
    {
        return $this->belongsToMany(Answer::class, 'users_answers', 'user_id', 'answer_id');
    }
}
