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
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ url('/events') }}">Events Management System</a></li>
                    <li class="active">Create event</li>
                </ol>
                <h2 class="text-center">Create event</h2>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-8 col-sm-offset-2">
                                <form action="{{ url('events') }}" method="POST">
                                    <h3>Title</h3>
                                    <input class="form-control" type="text" name="title" title="title"
                                           required
                                           placeholder="Title" value="{{ old('title') }}">
                                    <h3>Type</h3>
                                    <select class="form-control" name="type" title="type">
                                        <option value="news">News</option>
                                        <option value="notification">Notification</option>
                                    </select>
                                    <h3>Content</h3>
                                    <textarea class="form-control" rows="10" name="content" title="title"
                                        required
                                        placeholder="Content">{{ old('content') }}</textarea>
                                    <hr>
                                    <button type="submit" class="btn btn-primary">Create event</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <h6><a href="{{ url('events/create') }}"></a></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
