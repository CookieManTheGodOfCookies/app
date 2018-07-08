<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\application;
use App\Http\Controllers\Auth;
use Carbon\Carbon;

class ApplicationSendController extends Controller
{
    /**
     * Сохраняет данные в табличку
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $app)
    {
        if(!empty($app->user()->applications()->get()->toArray())) {
            $lastAppTime = $app->user()->applications()->orderBy('created_at', 'desc')->first()->created_at;
//            dd($lastAppTime);
            $currentTime = Carbon::now();
            $diff = $lastAppTime->diffInHours($currentTime, false);
            if ($diff < 24)
                return redirect('/home')->withErrors(['timeError' => 'You can send one application per day!']);
        }

        $this->validate($app, [
            'theme' => 'required|max:255',
            'message' => 'required|max:255'
        ]);

        $application = new application;
        $application->theme = $app->theme;
        $application->message = $app->message;
        $application->user_id = $app->user()->id;
        $application->save();

        return redirect('/home')->with('status', 'Application sent!');
    }
}
