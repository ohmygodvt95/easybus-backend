@extends('layouts.app')
@section('css')
    <style>
        .panel-body .col-sm-4 {
            padding: 50px;
        }
        .panel-body .col-sm-4 div{
            height: 100px;
            line-height: 100px;
            box-shadow: 0 0 5px gray;
            border-radius: 5px;
            cursor: pointer;
            background-color: #31b0d5;
        }
        .panel-body .col-sm-4 div a{
            color: #FFFFFF;
            font-size: 20px;
            font-weight: bold;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <ol class="breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li><a href="{{ url('/system') }}">EasyBus Management System</a></li>
                    <li class="active">{{ $province->name }}</li>
                </ol>
                <h2 class="text-center">Province: {{ $province->name }}</h2>
                <div class="panel panel-default">
                    <div class="panel-body text-center">
                        <div class="col-sm-4">
                            <div>
                                <a href="#">Quản lý tuyến bus</a>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div>
                                <a href="#">Quản lý điểm bus</a>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div>
                                <a href="{{ Request::path() }}/userreport">Quản lý yêu cầu</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
