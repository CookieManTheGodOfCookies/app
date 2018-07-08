<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckChange extends Controller
{
    public function check(Request $request)
    {
        $app = DB::table('applications')->where('id', '=', $request->appID)->get()[0];
        $checked = $app->checked_by_manager;
        $checked ?
            DB::table('applications')->where('id', $app->id)->update(['checked_by_manager' => 0]) :
            DB::table('applications')->where('id', $app->id)->update(['checked_by_manager' => 1]);
        return redirect()->back();
    }
}
