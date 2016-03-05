<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class Authenticate
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if(!$this->auth->check())
        {
            return redirect()->route('auth.login')
                ->with('status', 'success')
                ->with('message', 'Please login with your ozu email.');
        }

        if($role == 'all')
        {
            return $next($request);
        }

        if( $this->auth->guest() || !$this->auth->user()->hasRole($role))
        {
            //return response('Unauthorized.', 401);
            //abort(403, 'Unauthorized action.');
            return redirect('/');
        }
        /*
        if ($this->auth->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('auth/login');
            }
        }
        */
        return $next($request);
    }
}
