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

        $top_users = DB::select(DB::raw('
                SELECT id, SUM( t_union.point ) AS points, first_name, last_name
                FROM users
                LEFT JOIN (
                (
                SELECT user_id, POINT
                FROM users_assignments
                )
                UNION ALL
                (
                SELECT user_id, POINT
                FROM users_quizzes
                )
                )t_union ON users.id = t_union.user_id
                WHERE id = t_union.user_id
                GROUP BY id
                ORDER BY points DESC
                LIMIT 10'));

        return $top_users;
    }


}
