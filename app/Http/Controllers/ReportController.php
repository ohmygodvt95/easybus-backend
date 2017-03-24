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
        $report->route = $data->route;
        $report->report_type = $data->report_type;
        $report->email = $data->email;
        $stations_delete = [];
        $stations_add = [];

        $i = 0;
        foreach ($data->list_bus_stop as $station) {
            if ($station->report_type == "delete")
                array_push($stations_delete, intval($station->code));
            else if ($station->report_type == "add"){
                if ($i == 0){
                    array_push($stations_add, ['first', $station->code.$i.$data->list_bus_stop[$i + 1]->code, $station]);
                }
                else if($i == count($data->list_bus_stop) - 1){
                    array_push($stations_add, ['last', $data->list_bus_stop[$i + 1]->code.$station->code,$station]);
                }
                else{
                    array_push($stations_add, ['mid', $data->list_bus_stop[$i - 1]->code.$data->list_bus_stop[$i + 1]->code,
                        $station, $data->list_bus_stop[$i - 1], $data->list_bus_stop[$i + 1]]);
                }
            }
            $i++;
        }

        $report->delete_station = $stations_delete;
        $report->add_station = $stations_add;
        $report->save();

        return response()->json(['status' => 'success'], 200);
    }

    public function index(Request $request)
    {
        $reports = UserReport::where("status", "=", "new_report")
            ->with('busline')
            ->orderBy("id", "DESC")
            ->paginate(self::MAX);

        return response()->json($reports);
    }

    public function show(Request $request)
    {
        $report = UserReport::find($request->report);
        return response()->json($report);
    }
}
