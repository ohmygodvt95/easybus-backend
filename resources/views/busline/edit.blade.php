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
<p class="browserupgrade">You are using an <strong>outdated</strong> browser.
    Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<div class="container-fluid main" ng-controller="BuslineController">
    <div>
        <input type="text" class="busline" value="{{ $busLine }}" title="">
        <input type="text" class="reports" value="{{ $reports }}" title="">
        <input type="text" class="action" value="{{ $action }}" title="">
        <input type="text" class="target" value="{{ $target }}" title="">
        <input type="text" class="route" value="{{ $route }}" title="">
    </div>
    <div class="col-sm-3">
        <div class="list-group">
        	<a class="list-group-item active">
        		<h4 class="list-group-item-heading">Tuyến : @{{ busline.busLine.code }}</h4>
        		<p class="list-group-item-text">@{{ busline.busLine.name }}</p>
        	</a>
            <a class="list-group-item">
                <h4 class="list-group-item-heading"> * Có <b>@{{ reports.length }}</b> yêu cầu {{ $action }} <b ng-click="focus( {{ $target }} )">{{ $target }}</b></h4>
                <p class="list-group-item-text">{{ $reports }}</p>
            </a>
            <a class="list-group-item" ng-repeat="report in reports" ng-if="'{{ $action }}' == 'add'" ng-click="addMarker(report.add_station[0][2])">
                <h4 class="list-group-item-heading">@{{ report.add_station[0][2].new_address_name }}</h4>
                <p class="list-group-item-text">
                    @{{ report.add_station[0][2].code }}
                    <span class="pull-right" ng-click="addOne(report)">Thêm mới</span>
                </p>
            </a>
        </div>
        <hr>
        <button class="btn btn-primary" ng-click="delete()" ng-if="'{{ $action }}' == 'delete'">Approve</button>
        <input class="form-control" ng-model="new_address_name" ng-if="'{{ $action }}' == 'add'" placeholder="New Name">
        <button class="btn btn-primary" ng-click="addAverage()" ng-if="'{{ $action }}' == 'add'">Thêm mới sử dụng trung bình</button>
        <hr>
        <a href="{{ URL::previous() }}">Go back</a>
    </div>
    <div class="col-sm-9" id="map">

    </div>
</div>
<script src="http://code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/lodash/4.17.4/lodash.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC6hSkhk2QfFbInDsa1mJlvqjzSjjIfpY0" type="text/javascript"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.8/angular.js" type="text/javascript" ></script>
<script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/factory/buslineFactory.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/factory/provinceFactory.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/factory/reportFactory.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/factory/filterFactory.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/factory/busStopFactory.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/buslineController.js') }}" type="text/javascript"></script>
</body>
</html>
