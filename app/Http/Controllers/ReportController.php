<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\UserReport;
use App\BusLine;
use App\BusStop;
use App\Setting;
use App\Province;
class ReportController extends Controller
{
    const MAX = 5;
    public function getIndex(Request $request)
    {
        return view('report.index');
    }

    public function store(Request $request)
    {

        $data = json_decode($request->string_data);
        $report = new UserReport();
        $report->stringdata = $request->string_data;
        $report->busline_id = $data->busline_id;
        $report->route  = $data->route;
        $report->report_type = $data->report_type;
        $report->email = $data->email;
        $stations_delete = [];
        $stations_add = [];
        foreach ($data->list_bus_stop as $station) {
            if($station->report_type == "delete") array_push($stations_delete, intval($station->code));
            else if($station->report_type == "add") array_push($stations_add, intval($station->code)); 
        }
        $report->delete_station = $stations_delete;
        $report->add_station = $stations_add;
        $report->save();
        return response()->json(['status' => 'success'], 200);
    }

    public function index(Request $request)
    {
        $reports = UserReport::where("status", "=", "new_report")->with('busline')->orderBy("id", "DESC")->paginate(self::MAX);
        return response()->json($reports);
    }
}
