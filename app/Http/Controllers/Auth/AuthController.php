<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Contracts\Auth\Guard;
use App\User;
use App\Social;
use App\Role;
use Input, Validator, Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\CaptchaTrait;

class AuthController extends Controller {

    use CaptchaTrait;

    protected $auth;

    protected $userRepository;

    public function __construct( Guard $auth, UserRepository $userRepository )
    {
        $this->auth = $auth;
        $this->userRepository = $userRepository;
    }

    public function getLogin()
    {
        return view('auth.login');
    }

    public function postLogin()
    {
        $email      = Input::get('email');
        $password   = Input::get('password');
        $remember   = Input::get('remember');

        if($this->auth->attempt([
            'email'     => $email,
            'password'  => $password
        ], $remember == 1 ? true : false))
        {
            if( $this->auth->user()->hasRole('user'))
            {
                //return redirect('/');
                return redirect()->route('user.home');
            }

            if( $this->auth->user()->hasRole('administrator'))
            {
                return redirect()->route('admin.home');
                //return redirect('/');
            }

        }
        else
        {
            return redirect()->back()
                ->with('message','Incorrect email or password')
                ->with('status', 'danger')
                ->withInput();
        }

    }

    public function getLogout()
    {
        \Auth::logout();

        return redirect()->route('auth.login')
            ->with('status', 'success')
            ->with('message', 'Logged out');

    }

    public function getRegister()
    {
        return view('auth.register');
    }

    public function postRegister()
    {
        $input = Input::all();
        $validator = Validator::make($input, User::$rules, User::$messages);
        if($validator->fails())
        {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if($this->captchaCheck() == false)
        {
            return redirect()->back()
                ->withErrors(['Wrong Captcha'])
                ->withInput();
        }

        $data = [
            'first_name'    => $input['first_name'],
            'last_name'     => $input['last_name'],
            'email'         => $input['email'],
            'password'      => $input['password']
        ];

        $this->userRepository->register($data);

        return redirect()->route('auth.login')
            ->with('status', 'success')
            ->with('message', 'You are registered successfully. Please login.');

    }

    public function getSocialRedirect( $provider )
    {
        $providerKey = \Config::get('services.' . $provider);
        if(empty($providerKey))
            return view('pages.status')
                ->with('error','No such provider');

        return Socialite::driver( $provider )->redirect();

    }

    public function getSocialHandle( $provider )
    {

        $user = Socialite::driver( $provider )->user();

        $socialUser = null;

        //Check is this email present
        $userCheck = User::where('email', '=', $user->email)->first();
        if(!empty($userCheck))
        {
            $socialUser = $userCheck;
        }
        else
        {
            $sameSocialId = Social::where('social_id', '=', $user->id)->where('provider', '=', $provider )->first();

            if(empty($sameSocialId))
            {
                //There is no combination of this social id and provider, so create new one
                $newSocialUser = new User;
                $newSocialUser->email              = $user->email;
                $name = explode(' ', $user->name);
                $newSocialUser->first_name         = isset($name[0]) ? $name[0] : "";
                $newSocialUser->last_name          = isset($name[2]) ? $name[2] : (isset($name[1]) ? $name[1] : "");
                $newSocialUser->save();

                $socialData = new Social;
                $socialData->social_id = $user->id;
                $socialData->provider= $provider;
                $newSocialUser->social()->save($socialData);

                // Add role
                $role = Role::whereName('user')->first();
                $newSocialUser->assignRole($role);

                $socialUser = $newSocialUser;
            }
            else
            {
                //Load this existing social user
                $socialUser = $sameSocialId->user;
            }

        }

        $this->auth->login($socialUser, true);

        if( $this->auth->user()->hasRole('user'))
        {
            return redirect('/');
        }

        if( $this->auth->user()->hasRole('administrator'))
        {
            return redirect('/');
        }

        return App::abort(500);
    }

}