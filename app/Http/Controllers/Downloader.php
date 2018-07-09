<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;

class Downloader extends Controller
{
    public function downloadAttached($filename) {
        return \response()->download(public_path('/userFiles/'.$filename));
    }
}
