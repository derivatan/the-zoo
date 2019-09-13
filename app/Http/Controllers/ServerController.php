<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class ServerController extends Controller
{
    public function test(Request $request)
    {
        return [
            'ip'         => $request->ip(),
            'user-agent' => $request->userAgent(),
            'time'       => Carbon::now(),
            'text'       => 'räksmörgås',
            'input'      => $request->all(),
        ];
    }
}
