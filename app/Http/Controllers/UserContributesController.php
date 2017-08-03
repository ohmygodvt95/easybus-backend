<?php

namespace App\Http\Controllers;

use App\Contribute;
use App\Event;
use Illuminate\Http\Request;

use App\Http\Requests;

class UserContributesController extends Controller
{
    public function store(Request $request)
    {
        $data = json_decode($request->string_data);

        $contribute = new Contribute();
        $contribute->stringdata = $request->string_data;
        $contribute->contact = $data->email;
        $contribute->save();

        if(strlen($data->email) > 0){
            $event = new Event();
            $event->title = "Cảm ơn bạn $data->email đã đóng góp thông tin";
            $event->content = "Cảm ơn bạn $data->email đã đóng góp thông tin cho tuyến bus $data->bus_name. \n 
            Hi vọng bạn sẽ có thêm nhiều đóng góp dữ liệu cho cộng đồng";
            $event->type = "contributes";
            $event->save();
        }

        return response()->json(['status' => 'Success']);
    }
}
