@extends('layouts.app')
@section('css')
@endsection
@section('content')
    <div class="container" xmlns="a" ng-app="EasyBus">
        <div class="row" ng-controller="ReportController">
            <div class="col-sm-12">
                <ol class="breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li><a href="{{ url('/system') }}">EasyBus Management System</a></li>
                    <li><a href="{{ url('/system/'.$province->id) }}">{{ $province->name }}</a></li>
                    <li class="active">User report</li>
                </ol>
                <h2 class="text-center"> Province: {{ $province->name }} | <span class="text-primary">User report</span></h2>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <table class="table table-bordered table-hover table-striped">
                        	<thead>
                        		<tr>
                        			<th>User email</th>
                                    <th>Bus Line</th>
                                    <th>Station</th>
                                    <th>Route</th>
                                    <th>Status</th>
                                    <th>Timestamps</th>
                        		</tr>
                        	</thead>
                        	<tbody>
                                <tr>
                                    <form action="{{ Request::path() }}" method="GET">
                                        <td>Bộ lọc</td>
                                        <td colspan="2">
                                            <select name="busline_id" id="" title="busline_id" class="form-control btn-sm">
                                                <option value="">Toàn bộ</option>
                                                @foreach($province->busLine()->get(['code', 'name']) as $e)
                                                    <option value="{{ $e->code }}">{{ $e->code }} - {{ $e->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>

                                        <td>
                                            <select name="route" id="" title="route" class="form-control btn-sm">
                                                <option value="">Toàn bộ</option>
                                                <option value="go">Chiều đi</option>
                                                <option value="return">Chiều về</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="status" id="" title="route" class="form-control btn-sm">
                                                <option value="">Toàn bộ</option>
                                                <option value="new_report">Chưa xử lý</option>
                                                <option value="progress_report">Đang xử lý</option>
                                                <option value="success_report">Đã xử lý</option>
                                            </select>
                                        </td>
                                        <td><button type="submit" class="btn btn-primary btn-sm btn-block">Lọc</button></td>
                                    </form>
                                </tr>
                                @foreach($reports as $report)
                                    <tr>
                                        <td>{{ $report->email }}</td>
                                        <td>{{ $report->busLine()->first()->code }}</td>
                                        <td ng-click="filter({ id: {{ $report->id }} })">{{ $report->busLine()->first()->name }}</td>
                                        <td>{{ $report->route }}</td>
                                        <td>{{ \App\Http\Controllers\UserReportController::status($report->status) }}</td>
                                        <td>{{ $report->created_at }}</td>
                                    </tr>
                                @endforeach
                        	</tbody>
                        </table>
                        <hr>
                        {{ $reports->links() }}
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="panel panel-danger" ng-if="filterResult.recommendDeleteGroup.length > 0">
                    <div class="panel-heading">Delete request</div>
                    <div class="panel-body" ng-repeat="group in filterResult.recommendDeleteGroup">
                        <hr>
                        <a href="/busline/@{{ filterResult.report.busline_id }}/edit?reports=[@{{ pluck(group.data, 'id')
                        .toString() }}]&action=delete&target=@{{ group.busStop.code }}&route=@{{ filterResult.report.route }}">Xử lý nhóm request @{{ $index + 1 }}</a>
                        <p>Code: @{{ group.busStop.code }} - @{{ group.busStop.address_name }}</p>
                        <ul class="list-group">
                            <li class="list-group-item" ng-repeat="item in group.data">
                                @{{ item.id }}
                                - Ds các điểm muốn xóa [@{{ item.delete_station.toString() }}]
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="panel panel-success" ng-if="filterResult.recommendAddGroup.length > 0">
                    <div class="panel-heading">Add request</div>
                    <div class="panel-body" ng-repeat="group in filterResult.recommendAddGroup">
                        <hr>
                        <a href="/busline/@{{ filterResult.report.busline_id }}/edit?reports=[@{{ pluck(group.data, 'id')
                        .toString() }}]&action=add&route=@{{ filterResult.report.route }}">Xử lý nhóm request @{{ $index + 1 }}</a>
                        <p>Code: @{{ group.busStop.code }} - @{{ group.busStop.address_name }}</p>
                        <ul class="list-group">
                            <li class="list-group-item" ng-repeat="item in group.data">
                                @{{ item.id }}
                                - Ds các điểm muốn thêm [@{{ item.add_station.length }}]
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/lodash/4.17.4/lodash.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.8/angular.js" type="text/javascript" ></script>
    <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/factory/buslineFactory.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/factory/provinceFactory.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/factory/reportFactory.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/factory/filterFactory.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/reportController.js') }}" type="text/javascript"></script>
@endsection
