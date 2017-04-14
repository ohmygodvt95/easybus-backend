<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BusLine;
use App\BusStop;
use App\UserReport;
class BusLineController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request)
    {

    	return view('busline.edit', [
    	    'busLine' => $request->busline,
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
        $busLine = BusLine::where('code', $request->busline)->first();

        $throughStops = [];
        if($request->route == 'go'){
            $arr = explode(" ",trim($busLine->goRouteThroughStops));
        }
        else{
            $arr = explode(" ",trim($busLine->returnRouteThroughStops));
        }
        foreach ($arr as $value){
            array_push($throughStops, BusStop::where('code', $value)->first());
        }

        return response()
            ->json([
                'busLine' => $busLine,
                'throughStops' => $throughStops
            ]);
    }

    function update(Request $request){
        $busLine = BusLine::where('code', $request->busline)->first();
        if($request->action == 'delete'){
            $busStop = BusStop::where('code', $request->target)->first();
            if($request->route == 'go'){
                $busLine->goRouteThroughStops = str_replace("$request->target ", "", $busLine->goRouteThroughStops);
                $busLine->update();

                $busStop->busPassBy = str_replace("$busLine->code", "", $busStop->busPassBy);
                $busStop->busPassBy = str_replace(",,", ",", $busStop->busPassBy);
                $busStop->update();

                $reports = UserReport::whereIn('id', json_decode($request->reports))->get();
                foreach ($reports as &$report){
                    $report->delete_station = array_diff($report->delete_station, [$request->target]);
                    $report->update();
                }
            }
            else{
                $busLine->returnRouteThroughStops = str_replace("$request->target ", "", $busLine->returnRouteThroughStops);
                $busLine->update();

                $busStop->busPassBy = str_replace("$busLine->code", "", $busStop->busPassBy);
                $busStop->busPassBy = str_replace(",,", ",", $busStop->busPassBy);
                $busStop->update();

                $reports = UserReport::whereIn('id', json_decode($request->reports))->get();
                foreach ($reports as &$report){
                    $report->delete_station = array_diff($report->delete_station, [$request->target]);
                    $report->update();
                }
            }
            return response()->json([
                'status' => $request->action.' bus stop '.$request->route,
                'busLine' => $busLine->code,
                'busStop' => $busStop->code
            ]);
        }
        else{
            if($request->target != 'all'){
                $report = UserReport::find(intval($request->target));
                $busStop = null;
                if($report->add_station[0][2]['code'] == 'not_in_system'){
                    $busStop = new BusStop();
                    $busStop->provinceID = $busLine->provinceID;
                    $busStop->busPassBy = $busLine->code;
                    $busStop->address_name = $report->add_station[0][2]['new_address_name'];
                    $busStop->code = random_int(10000, 99999);
                    $longLat = explode('|', $report->add_station[0][2]['new_location']);
                    $busStop->location = "$longLat[1]|$longLat[0]";
                    $busStop->save();
                }
                else{
                    $busStop = BusStop::where('code', '=', $report->add_station[0][2]['code'])->first();
                    $busStop->busPassBy = $busStop->busPassBy.",".$busLine->code;
                    $busStop->update();
                }

                $prev = $report->add_station[0][3]['code'];
                $next = $report->add_station[0][4]['code'];
                if($request->route == 'go'){
                    $busLine->goRouteThroughStops = str_replace("$prev $next", "$prev $busStop->code $next",
                        $busLine->goRouteThroughStops);
                }
                else{
                    $busLine->returnRouteThroughStops = str_replace("$prev $next", "$prev $busStop->code $next",
                        $busLine->returnRouteThroughStops);
                }

                $reports = UserReport::whereIn('id', json_decode($request->reports))->get();
                foreach ($reports as $r){
                    $r->status = 'success_report';
                    $r->update();
                }

                $busLine->update();

                return response()->json(['busStop' => $busStop, 'busLine' => $busLine]);
            }
            else{
                $busStop = null;

                $reports = UserReport::whereIn('id', json_decode($request->reports))->get();

                $long = 0;
                $lat = 0;
                $i = 0;
                foreach ($reports as $r){
                    $tmp = explode('|', $r->add_station[0][3]['new_location']);
                    $long += doubleval($tmp[1]);
                    $lat += doubleval($tmp[0]);
                    $i++;
                }
                $long = $long / $i;
                $lat = $lat / $i;

                $busStop = new BusStop();
                $busStop->provinceID = $busLine->provinceID;
                $busStop->busPassBy = $busLine->code;
                $busStop->address_name = $request->new_address_name;
                $busStop->code = random_int(10000, 99999);
                $busStop->location = "$long|$lat";
                $busStop->save();

                $prev = $reports[0]->add_station[0][3]['code'];
                $next = $reports[0]->add_station[0][4]['code'];
                if($request->route == 'go'){
                    $busLine->goRouteThroughStops = str_replace("$prev $next", "$prev $busStop->code $next",
                        $busLine->goRouteThroughStops);
                }
                else{
                    $busLine->returnRouteThroughStops = str_replace("$prev $next", "$prev $busStop->code $next",
                        $busLine->returnRouteThroughStops);
                }

                foreach ($reports as $r){
                    $r->status = 'success_report';
                    $r->update();
                }

                $busLine->update();

                return response()->json(['busStop' => $busStop, 'busLine' => $busLine, 'prev' => $prev, 'next' => $next]);
            }
        }
    }
}
