<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Busline;
use App\BusStop;
use App\UserReport;
class BuslineController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request)
    {

    	return view('busline.edit', [
    	    'busline' => $request->busline,
    	    'reports' => $request->reports,
            'action' => $request->action,
            'target' => $request->target,
            'route' => $request->route
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    function show(Request $request){
        $busline = Busline::where('code', $request->busline)->first();

        $throughStops = [];
        if($request->route == 'go'){
            $arr = explode(" ",trim($busline->goRouteThroughStops));
        }
        else{
            $arr = explode(" ",trim($busline->returnRouteThroughStops));
        }
        foreach ($arr as $value){
            array_push($throughStops, BusStop::where('code', $value)->first());
        }

        return response()
            ->json([
                'busline' => $busline,
                'throughStops' => $throughStops
            ]);
    }

    function update(Request $request){
        $busline = Busline::where('code', $request->busline)->first();
        if($request->action == 'delete'){
            if($request->route == 'go'){
                $busline->goRouteThroughStops = str_replace("$request->target ", "", $busline->goRouteThroughStops);
                $busline->update();

                $busStop = BusStop::where('code', $request->target)->first();
                $busStop->busPassBy = str_replace("$busline->code", "", $busStop->busPassBy);
                $busStop->busPassBy = str_replace(",,", ",", $busStop->busPassBy);
                $busStop->update();

                $reports = UserReport::whereIn('id', json_decode($request->reports))->get();
                foreach ($reports as &$report){
                    $report->delete_station = array_diff($report->delete_station, [$request->target]);
                    $report->update();
                }
            }
        }
    }
}
