<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Skill;
use App\Userskill;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();

        $other_users = User::where('id', '<>', Auth::user()->id) 
                            ->whereHas('mySkills', function ($query) use ($user) {
                                
                                $query->whereIn('skill_id', $user->mySkills->pluck('skill_id')->toArray());
                            })
                            ->doesntHave('followers')
                            ->doesntHave('following')
                        ->get(); 
        return view('home',compact('other_users'));
    }
}
