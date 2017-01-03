<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
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
    protected $fillable = ['avatar', 'first_name', 'last_name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    protected $appends = ['points', 'timeline'];

    public static $rules = [
        'first_name'            => 'required',
        'last_name'             => 'required',
        'email'                 => 'required|email|unique:users',
        'password'              => 'required|min:6|max:20',
        'password_confirmation' => 'required|same:password',
        'g-recaptcha-response'  => 'required'
    ];
    public static $messages = [
        'first_name.required'   => 'First Name is required',
        'last_name.required'    => 'Last Name is required',
        'email.required'        => 'Email is required',
        'email.email'           => 'Email is invalid',
        'password.required'     => 'Password is required',
        'password.min'          => 'Password needs to have at least 6 characters',
        'password.max'          => 'Password maximum length is 20 characters',
        'g-recaptcha-response.required' => 'Captcha is required'
    ];

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

        if (!is_numeric($points)) $points = 0;
        /*
            $point = DB::select('SELECT point FROM users_assignments WHERE user_id=? AND assignment_id=?',
                [Auth::user()->id, $this->id]);
        */
        return $points;
    }

    function getTimelineAttribute() {
        $date = new Carbon;
        $date->subDays(2);
        $today = Carbon::now();

        // Assignments that need to be completed in 2 days
        $waiting_assignments = DB::table('assignments')
            ->select(DB::raw('id, point, created_at, due_date as date, \'reminder\' as type'))
            ->where('due_date', '>', $date->toDateTimeString())
            ->where('due_date', '>=', $today->toDateTimeString())
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

    public function lectures()
    {
        return $this->hasMany(Lecture::class);
    }

    public function assignments()
    {
        return $this->belongsToMany(Assignment::class, 'users_assignments', 'user_id', 'assignment_id')->withTimestamps();
    }
/*
    public function knowledgeunits()
    {
        return $this->belongsToMany(Assignment::class, 'users_knowledgeunits', 'user_id', 'knowledgeunit_id')->withTimestamps();
    }
*/
    public function answers()
    {
        return $this->belongsToMany(Answer::class, 'users_answers', 'user_id', 'answer_id')->withTimestamps();
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    public function hasRole($name)
    {
        foreach($this->roles as $role)
        {
            if($role->name == $name) return true;
        }

        return false;
    }

    public function assignRole($role)
    {
        return $this->roles()->attach($role);
    }

    public function removeRole($role)
    {
        return $this->roles()->detach($role);
    }

    public function social()
    {
        return $this->hasMany(Social::class);
    }

    public function isCurrent()
    {
        if (Auth::guest()) return false;
        return Auth::user()->id == $this->id;
    }
}
