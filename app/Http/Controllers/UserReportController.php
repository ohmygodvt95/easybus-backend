<?php

namespace App\Http\Controllers;

use App\Province;
use App\UserReport;
use Illuminate\Http\Request;

use App\Http\Requests;

class UserReportController extends Controller
{
    private $perPage = 15;

    public static function status($string)
    {
        $list = [
            'new_report' => 'Chưa xử lý',
            'progress_report' => 'Đang sử lý',
            'success_report' => 'Đã xử lý'
        ];
        return $list[$string];
    }

    public function index($provinceId, Request $request)
    {
        $keys = array_keys($request->all());
        $values = array_values($request->all());

        $province = Province::find($provinceId);

        $reports = UserReport::where('provinceID', $provinceId);
        for ($i = 0; $i < count($keys); $i++){
            $reports = $reports->where($keys[$i],'like', "%$values[$i]%");
        }
        $reports= $reports->orderBy('id', 'DESC')->paginate($this->perPage);

        return view('userreport.index', [
            'pageTitle' => "User report: $province->name",
            'province' => $province,
            'reports' => $reports
        ]);
    }
}
