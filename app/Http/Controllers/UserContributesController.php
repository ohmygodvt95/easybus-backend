<?php

namespace App\Http\Controllers;

use App\Contribute;
use Illuminate\Http\Request;

use App\Http\Requests;

class UserContributesController extends Controller
{
    public function store(Request $request)
    {
        $contribute = new Contribute();
        $contribute->stringdata = $request->string_data;
        $contribute->save();
        return response()->json(['status' => 'Success']);
    }
}
