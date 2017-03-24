<?php

namespace App\Http\Controllers;

use App\Province;
use App\UserReport;
use Illuminate\Http\Request;

use App\Http\Requests;

class UserReportController extends Controller
{
    private $perPage = 2;

    public static function status($string)
    {
        $list = [
            'new_report' => 'Chưa xử lý',
            'progress_report' => 'Đang sử lý',
            'success_report' => 'Đã xử lý'
        ];
        return $list[$string];
    }

    /**
     * @param $provinceId
     * @param Request $request
     * @return mixed
     */
    public function index($provinceId, Request $request)
    {
        $keys = array_keys($request->all());
        $values = array_values($request->all());

        $province = Province::find($provinceId);

        $reports = UserReport::where('provinceID', $provinceId);

        if($request->has('per_page')){
            $this->perPage = $request->per_page;
        }

        if($request->has('busline_id') && $request->busline_id){
            $reports = $reports->where('busline_id', 'like', "%$request->busline_id%");
        }

        if($request->has('route') && $request->route){
            $reports = $reports->where('route', 'like', "%$request->route%");
        }

        if($request->has('status') && $request->status){
            $reports = $reports->where('status', 'like', "%$request->status%");
        }

        if($request->has('from') && $request->from){
            $reports = $reports->whereDate('created_at', '>=', $request->from);
        }

        if($request->has('to') && $request->to){
            $reports = $reports->whereDate('created_at', '<=', $request->to);
        }

        $reports = $reports->orderBy('id', 'DESC')->paginate($this->perPage);
        $str = "";
        if(count($values) > 2){
            $str="?";
            for($i = 0; $i < count($values); $i++){
                $str .= "$keys[$i]=$values[$i]";
                if($i < count($values) - 1) $str .= "&";
            }
        }

//        $reports = $reports->withPath('/province/'.$province->id.'/userreport'.$str);

        return view('userreport.index', [
            'pageTitle' => "User report: $province->name",
            'province' => $province,
            'reports' => $reports
        ]);
    }
}
