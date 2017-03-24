<!doctype html>
<html class="no-js" lang="" ng-app="EasyBus">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>UserReport</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{ asset('components/bootstrap/dist/css/bootstrap.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('components/font-awesome/css/font-awesome.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('css/report.css') }}">
		<base href="{{ url("/") }}">
    </head>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <div class="container" ng-controller="ReportController">
            <form action="/report" method="get" accept-charset="utf-8">
                <select ng-model="provinceID" title="">
                    <option value="@{{ province.id }}" ng-repeat="province in static.provinces">@{{ province.name }}</option>
                </select>
                <select name="byBusline" title="">
                </select>
                <select name="byRoute" title="">
                    <option value="">Tất cả các chiều</option>
                    <option value="go">Chiều đi</option>
                    <option value="return">Chiều về</option>
                </select>
                <select name="byTime" title="">
                    <option value="DESC">Mới nhất</option>
                    <option value="ASC">Cũ nhất</option>
                </select>
                <button type="submit">Tìm</button>
            </form>
            <hr>
            <button ng-click="prev()" class="btn btn-primary">Prev</button>
            @{{ reports.current_page }} / @{{ reports.last_page }} <button ng-click="next()"  class="btn btn-primary">Next</button>
            <hr>
            <div class="list-group col-sm-6">
                <a href="#" class="list-group-item" ng-repeat="report in reports.data"
                    ng-click="filter(report)">
                    <p class="list-group-item-heading">
                        <b>
                            @{{ report.busline_id }} - @{{ report.busline.name }}
                            <span class="pull-right">@{{ report.id }} - @{{ report.route }}</span>
                        </b>
                    </p>
                    <div class="list-group-item-text">
                        <div class="text-success" ng-if="report.add_station.length > 0">
                            Thêm: @{{ report.add_station.length }} điểm
                        </div>
                        <div class="text-danger" ng-if="report.delete_station.length > 0">
                            Xóa : @{{ report.delete_station.length }} điểm [@{{ report.delete_station.toString() }}]
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-danger" ng-if="filterResult.recommendDeleteGroup.length > 0">
                    <div class="panel-heading">Delete request</div>
                	<div class="panel-body" ng-repeat="group in filterResult.recommendDeleteGroup">
                        <hr>
                        <a href="/busline/@{{ filterResult.report.busline_id }}/edit?reports=[@{{ pluck(group.data, 'id')
                        .toString() }}]&action=delete&target=@{{ group.busStop.code }}&route=@{{ filterResult.report.route }}">
                            Xử lý nhóm request @{{ $index + 1 }}
                        </a>
                        <p>Code: @{{ group.busStop.code }} - @{{ group.busStop.address_name }}</p>
                        <ul class="list-group">
                        	<li class="list-group-item" ng-repeat="item in group.data">
                                @{{ item.id }}
                                - Ds các điểm muốn xóa [@{{ item.delete_station.toString() }}]
                            </li>
                        </ul>
                	</div>
                </div>
                <div class="panel panel-success"
                    ng-if="filterResult.recommendAddGroup.length > 0">
                    <div class="panel-heading">Add request</div>
                    <div class="panel-body"
                        ng-repeat="group in filterResult.recommendAddGroup">
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
      	<script src="{{ asset('components/jquery/dist/jquery.min.js') }}"></script>
        <script src="{{ asset('components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('components/lodash/dist/lodash.min.js') }}"></script>
        {{-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC6hSkhk2QfFbInDsa1mJlvqjzSjjIfpY0" type="text/javascript"></script> --}}
		<script src="{{ asset('components/angular/angular.min.js') }}" type="text/javascript" ></script>
        <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/factory/buslineFactory.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/factory/provinceFactory.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/factory/reportFactory.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/factory/filterFactory.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/reportController.js') }}" type="text/javascript"></script>
    </body>
</html>
