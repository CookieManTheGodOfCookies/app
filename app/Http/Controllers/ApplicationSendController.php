<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\application;
use App\Http\Controllers\Auth;
use Carbon\Carbon;

class ApplicationSendController extends Controller
{
    /**
     * Проверяет и
     * сохраняет данные в табличку
     * @param Request $app
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $app)
    {
        $currentTime = Carbon::now();
        if(!empty($app->user()->applications()->get()->toArray())) {
            $lastAppTime = $app->user()->applications()->orderBy('created_at', 'desc')->first()->created_at;
            $diff = $lastAppTime->diffInHours($currentTime, false);
            if ($diff < 24)
                return redirect('/home')->withErrors(['timeError' => 'You can send one application per day!']);
        }

        $this->validate($app, [
            'theme' => 'required|max:255',
            'message' => 'required|max:255'
        ]);

        $application = new application;
        if($app->hasFile('file'))
        {
            $file = $app->file('file');
            $extension = $file->getClientOriginalExtension();
//            dd($extension);
            $filename = $app->user()->id. '_'.$file->getFilename() . ".".$extension;
            $file->move(public_path() . '/userFiles', $filename);
            $application->attached_filename = $filename;
        }
        else $application->attached_filename = 'NULL';
        $application->theme = $app->theme;
        $application->message = $app->message;
        $application->user_id = $app->user()->id;
        $application->save();

        return redirect('/home')->with('status', 'Application sent!');
    }
}