@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
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
                        <table class="table table-bordered table-hover">
                            <tbody>
                                <tr>
                                    <form action="{{ Request::path() }}" method="GET">
                                        <td>
                                            <h6>Hiển thị</h6>
                                            <select name="per_page" id="" title="Perpage" class="form-control">
                                                <option value="@{{ per }}" ng-repeat="per in [10, 15, 20, 25, 30, 35, 40]">@{{ per }}</option>
                                            </select>
                                        </td>
                                        <td>
                                            <h6>Tuyến</h6>
                                            <select name="busline_id" id="" title="busline_id" class="form-control btn-sm">
                                                <option value="">Toàn bộ</option>
                                                @foreach($province->busLine()->get(['code', 'name']) as $e)
                                                    <option value="{{ $e->code }}">{{ $e->code }} - {{ $e->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>

                                        <td>
                                            <h6>Chiều</h6>
                                            <select name="route" id="" title="route" class="form-control btn-sm">
                                                <option value="">Toàn bộ</option>
                                                <option value="go">Chiều đi</option>
                                                <option value="return">Chiều về</option>
                                            </select>
                                        </td>
                                        <td>
                                            <h6>Trạng thái</h6>
                                            <select name="status" title="route" class="form-control btn-sm">
                                                <option value="">Toàn bộ</option>
                                                <option value="new_report"
                                                    {{ Request::get('status') == 'new_report' ? 'selected' : '' }}>Chưa xử lý</option>
                                                <option value="progress_report"
                                                    {{ Request::get('status') == 'progress_report' ? 'selected' : '' }}>Đang xử lý</option>
                                                <option value="success_report"
                                                    {{ Request::get('status') == 'success_report' ? 'selected' : '' }}>Đã xử lý</option>
                                            </select>
                                        </td>
                                        <td>
                                            <h6>From date</h6>
                                            <input name="from" data-provide="datepicker" placeholder="From date"
                                                data-date-format="yyyy-mm-dd" title="From" class="form-control"
                                               value="{{ Request::get('from') }}"
                                            />
                                        </td>
                                        <td>
                                            <h6>To date</h6>
                                            <input name="to" data-provide="datepicker" class="form-control"
                                                data-date-format="yyyy-mm-dd" title="to" placeholder="To date"
                                                value="{{ Request::get('to') }}"
                                            />
                                        </td>
                                        <td>
                                            <h6>Action</h6>
                                            <button type="submit" class="btn btn-primary btn-sm">Lọc</button>
                                        </td>
                                    </form>

                                </tr>
                            </tbody>
                        </table>
                        <a href="{{ url('/system/'.$province->id."/userreport") }}">Xóa bộ lọc</a>
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
    <script src="{{ asset('components/lodash/dist/lodash.min.js') }}"></script>
    <script src="{{ asset('components/angular/angular.min.js') }}" type="text/javascript" ></script>
    <script src="{{ asset('components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/factory/buslineFactory.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/factory/provinceFactory.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/factory/reportFactory.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/factory/filterFactory.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/reportController.js') }}" type="text/javascript"></script>
@endsection
