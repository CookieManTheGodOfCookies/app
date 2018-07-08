<?php

namespace App\Http\Controllers;

use App\application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->user()->role === 'USER') {
            $applications = $request->user()->applications()->orderBy('created_at', 'desc')->get();
            return view('home', compact('applications'));
        }
        else if($request->user()->role === 'MANAGER') {
            $applications = application::query()->orderBy('created_at', 'desc')->get();
//            dd($applications);
//            dd($applications[0]->user->name);
            return view('home', compact('applications'));
        }

    }
}
