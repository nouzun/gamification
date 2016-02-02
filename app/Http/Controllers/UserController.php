<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller {

    public function show(Request $request, $user_id)
    {
        $user = User::find($user_id);

        if(!isset($user)) abort(403,"Unknown User");

        $data = array(
            'user'  => $user,
        );

        return view('profile.show', $data);
    }

    public function showCurrent(Request $request)
    {
        $user = Auth::user();

        $data = array(
            'user'  => $user,
        );

        return view('profile.show', $data);
    }


    public function edit(Request $request, $user_id)
    {
        $user = User::find($user_id);

        if(!isset($user)) abort(403,"Unknown User");

        $data = array(
            'user'  => $user,
        );

        return view('profile.edit', $data);
    }

    public function store(Request $request, $user_id)
    {
        $user = User::find($user_id);
        if (isset($request->avatar)) {
            $user->avatar = $request->avatar;
        } else {
            $user->avatar = STAPLER_NULL;
        }

        $user->save();

        return redirect('/user');
    }

    public function getHome()
    {
        return view('home');
    }
}