<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Log;
use Illuminate\Support\Facades\Auth;

class LogController extends Controller
{
    public function index()
    {
        if (Auth::user()->level = 'pelayan') {
            # code...
            $logs = Log::orderBY('id', 'desc')->where('user_id', Auth::user()->id)->get();
        } else {
            # code...
            $logs = Log::all()->orderBY('id', 'desc');
        }
        return view('log.index', compact('logs'));
    }
}
