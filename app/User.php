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
use Carbon\Carbon;
use Codesleeve\Stapler\ORM\StaplerableInterface;
use Codesleeve\Stapler\ORM\EloquentTrait;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract,
                                    StaplerableInterface
{
    use Authenticatable, Authorizable, CanResetPassword, EloquentTrait;

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
    protected $fillable = ['avatar', 'name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    protected $appends = ['points', 'timeline'];

    public function __construct(array $attributes = array()) {
        $this->hasAttachedFile('avatar', [
            'styles' => [
                'medium' => '300x300',
                'thumb' => '100x100'
            ]
        ]);

        parent::__construct($attributes);
    }

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

    function getTimelineAttribute() {
        $date = new Carbon;
        $date->subDays(2);

        // Assignments that need to be completed in 2 days
        $waiting_assignments = DB::table('assignments')
            ->select(DB::raw('id, point, created_at, due_date as date, \'reminder\' as type'))
            ->where('due_date', '>', $date->toDateTimeString())
            ->whereNotExists(function($query)
            {
                $query->select(DB::raw(1))
                    ->from('users_assignments')
                    ->whereRaw('users_assignments.assignment_id = assignments.id')
                    ->where('users_assignments.user_id', '=', $this->id);
            });

        $timeline = DB::table('users_assignments')
            ->select(DB::raw('assignment_id, point, null, created_at as date,  \'assignment\' as type'))
            ->where('user_id', '=', $this->id)
            ->union($waiting_assignments)
            ->orderBy('date', 'desc')
            ->get();

        return $timeline;
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function assignments()
    {
        return $this->belongsToMany(Assignment::class, 'users_assignments', 'user_id', 'assignment_id')->withTimestamps();
    }

    public function answers()
    {
        return $this->belongsToMany(Answer::class, 'users_answers', 'user_id', 'answer_id')->withTimestamps();
    }
}
