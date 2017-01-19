<!doctype html>
<html class="no-js" lang="" ng-app="EasyBus">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>UserReport</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
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
                <select ng-model="provinceID">
                    <option value="@{{ province.id }}" ng-repeat="province in static.provinces">@{{ province.name }}</option>
                </select>
                <select name="byBusline">
                </select>
                <select name="byRoute">
                    <option value="">Tất cả các chiều</option>
                    <option value="go">Chiều đi</option>
                    <option value="return">Chiều về</option>
                </select>
                <select name="byTime">
                    <option value="DESC">Mới nhất</option>
                    <option value="ASC">Cũ nhất</option>
                </select>
                <button type="submit">Tìm</button>
            </form>
            <hr>
            <button ng-click="prev()" class="btn btn-primary">Prev</button> @{{ reports.current_page }} / @{{ reports.last_page }} <button ng-click="next()"  class="btn btn-primary">Next</button>
            <hr>
            <div class="list-group col-sm-6">
                <a href="#" class="list-group-item" ng-repeat="report in reports.data">
                    <h4 class="list-group-item-heading">@{{ report.busline_id }} - @{{ report.busline.name }} <span class="pull-right">@{{ report.id }}</span></h4>
                    <p class="list-group-item-text">
                        <p class="text-success" ng-if="report.add_station.length > 0">Thêm: @{{ report.add_station.length }} điểm: [@{{ report.add_station.toString() }}]</p> 
                        <p class="text-danger" ng-if="report.delete_station.length > 0">Xóa : @{{ report.delete_station.length }} điểm</p>
                    </p>
                </a>
            </div>
        </div>
      	<script src="http://code.jquery.com/jquery-1.12.4.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		{{-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC6hSkhk2QfFbInDsa1mJlvqjzSjjIfpY0" type="text/javascript"></script> --}}
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.8/angular.js" type="text/javascript" ></script>
        <script src="{{ asset('js/reportController.js') }}" type="text/javascript"></script>
    </body>
</html>