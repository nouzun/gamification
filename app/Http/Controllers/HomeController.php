<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:all');
    }

    public function index(){
        $top_users = $this->leaderBoard();

        $data["top_users"] = (empty($top_users) ? null : $top_users);

        return view('home', $data);
    }

    public function leaderBoard(){

        $top_users = DB::table('users_assignments')
            ->leftJoin('users', 'users_assignments.user_id', '=', 'users.id')
            ->select(DB::raw('user_id, SUM(point) as points, users.first_name, users.last_name'))
            ->groupBy('user_id')
            ->orderBy('points', 'desc')
            ->take(10)
            ->get();

        return $top_users;
    }


}
