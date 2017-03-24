@extends('layouts.app')
@section('css')
    <style>
        .box ul{
            min-height: 100px;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <ol class="breadcrumb">
                    <li class="active">Home</li>
                </ol>
                <h2 class="text-center">Chọn hệ thống quản lý</h2>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-sm-6">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Easybus management</h3>
                                </div>
                                <div class="panel-body box">
                                    <ul>
                                        <li>Quản lý tuyến bus</li>
                                        <li>Quản lý điểm bus</li>
                                        <li>Quản lý phản hồi của người dùng</li>
                                    </ul>
                                    <hr>
                                    <a href="{{ url('system') }}" class="btn btn-block btn-danger btn-lg btn-block">
                                        Quản lý
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Events management</h3>
                                </div>
                                <div class="panel-body box">
                                    <ul>
                                        <li>Quản lý tin tức mới</li>
                                        <li>Quản lý thông báo</li>
                                    </ul>
                                    <hr>
                                    <a href="{{ url('events') }}" class="btn btn-block btn-danger btn-lg btn-block">
                                        Quản lý
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
