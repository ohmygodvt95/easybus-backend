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
                    <li><a href="#">Home</a></li>
                    <li class="active">Events Management System</li>
                </ol>
                <h2 class="text-center">Events Management System</h2>
                @if (session('message'))
                    <div class="alert alert-{{ session('type') }}">
                        {{ session('message') }}
                    </div>
                @endif
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h2>List events</h2>
                        <hr>
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <td>Type</td>
                                <th>Created at</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($events as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td><a href="{{ url('events/'.$item->id.'/edit') }}" title="{{ $item->title }}">{{ str_limit($item->title, 80) }}</a></td>
                                        <td>{{ $item->type }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>
                                            <form action="{{ url('events/'.$item->id) }}" method="POST"
                                                  style="display: inline-block"
                                                  onsubmit="return confirm('Do you really want to delete this event?');">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="panel-footer">
                        <h6><i class="fa fa-fw fa-plus"></i><a href="{{ url('events/create') }}">Create event</a></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
