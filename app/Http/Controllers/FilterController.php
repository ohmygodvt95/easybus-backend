<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserReport;
use App\Busline;
use App\BusStop;
class FilterController extends Controller
{
    function show($id){
        $report = UserReport::find($id);
        $recommendGroupDeleteReports = [];
        $recommendGroupAddReports= [];

        foreach ($report->delete_station as $element){
            $line = UserReport::where('busline_id', $report->busline_id)
                ->where('status', 'new_report')
                ->where('route', $report->route)
                ->where('delete_station', 'like', "%$element%")
                ->get(['id', 'busline_id', 'route', 'delete_station']);
            if($line)
                array_push($recommendGroupDeleteReports,
                    [
                        'busStop' => BusStop::where('code', $element)->first(),
                        'data' => $line
                    ]);
        }

        foreach ($report->add_station as $element){
            $line = UserReport::where('busline_id', $report->busline_id)
                ->where('status', 'new_report')
                ->where('route', $report->route)
                ->where('add_station', 'like', "%$element%")
                ->get(['id', 'busline_id', 'route', 'add_station']);
            if($line)
                array_push($recommendGroupAddReports,
                    [
                        'busStop' => BusStop::where('code', $element)->first(),
                        'data' => $line
                    ]);
        }

        return response()->json([
            'report' => $report,
            'recommendDeleteGroup' => $recommendGroupDeleteReports,
            'recommendAddGroup' => $recommendGroupAddReports,
        ]);
    }
}
