<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BusStop;
use App\Http\Requests;

class BusStopController extends Controller
{
    function show(Request $request){
        return response()->json(BusStop::where('code', $request->busstop)->first());
    }
}
