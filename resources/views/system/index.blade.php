@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <ol class="breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li class="active">EasyBus Management System</li>
                </ol>
                <h2 class="text-center">Chọn địa bàn tỉnh/thành phố</h2>
                <div class="panel panel-default">
                	<div class="panel-body">
                        @foreach($provinces as $province)
                            <div class="col-sm-4">
                                <div class="panel panel-primary">
                                      <div class="panel-heading">
                                            <h3 class="panel-title">{{ $province-> name }}</h3>
                                      </div>
                                      <div class="panel-body">
                                        <b>{{ $province->busLine()->count() }}</b> tuyến bus
                                        <hr>
                                        <b>{{ $province->busStop()->count() }}</b> điểm đỗ
                                        <hr>
                                          <a href="{{ url('/system/'.$province->id) }}" class="btn btn-block btn-primary">Quản lý</a>
                                      </div>
                                </div>
                            </div>
                        @endforeach
                	</div>
                </div>
            </div>
        </div>
    </div>
@endsection
