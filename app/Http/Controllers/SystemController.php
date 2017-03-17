<?php

namespace App\Http\Controllers;

use App\Province;
use Illuminate\Http\Request;

use App\Http\Requests;

class SystemController extends Controller
{
    public function index()
    {
        $provinces = Province::all();
        return view('system.index', [
            'pageTitle' => 'Easybus management system',
            'provinces' => $provinces
        ]);
    }

    public function show($id)
    {
        $province = Province::find($id);

        if($province == null){
            return redirect('/system');
        }
        else{
            return view('system.show', [
                'pageTitle' => "Hệ thống bus: $province->name",
                'province' => $province
            ]);
        }
    }
}
