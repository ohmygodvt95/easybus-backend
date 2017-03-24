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
                    <li class="active">Update event</li>
                </ol>
                <h2 class="text-center">Update event</h2>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-8 col-sm-offset-2">
                                <form action="{{ url('events/'.$event->id) }}" method="POST">
                                    <input type="hidden" name="_method" value="PATCH">
                                    <h3>Title</h3>
                                    <input class="form-control" type="text" name="title" title="title"
                                           required
                                           placeholder="Title" value="{{ $event->title }}">
                                    <h3>Type</h3>
                                    <select class="form-control" name="type" title="type">
                                        <option value="news" {{ $event->type == 'news' ? 'selected' : '' }}>News</option>
                                        <option value="notification" {{ $event->type == 'notification' ? 'selected' : '' }}>Notification</option>
                                    </select>
                                    <h3>Content</h3>
                                    <textarea class="form-control" rows="10" name="content" title="title"
                                              required
                                              placeholder="Content">{{ $event->content }}</textarea>
                                    <hr>
                                    <button type="submit" class="btn btn-primary">Update event</button>
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
