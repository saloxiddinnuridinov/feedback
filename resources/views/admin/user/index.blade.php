@extends('admin.layouts.simple.master')
@section('title', '"Ipak yoʻli" turizm va madiny meros xalqaro universiteti')


@section('style')
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .pagination {
            display: flex;
            justify-content: center;
            padding: 20px 0;
        }

        .pagination a {
            color: black;
            float: left;
            padding: 8px 16px;
            text-decoration: none;
            transition: background-color 0.3s;
            margin: 0 4px;
            border: 1px solid #ddd;
        }

        .pagination a.active {
            background-color: #4CAF50;
            color: white;
            border: 1px solid #4CAF50;
        }

        .pagination a:hover:not(.active) {
            background-color: #ddd;
        }

    </style>
@endsection

@section('breadcrumb-title')
    <h3>Users</h3>
@endsection

@section('breadcrumb-items')
    <div class="py-3">
        <div class="justify-content-between row mx-2">
            <a  href="{{route('users.create')}}" class="btn btn-success font-weight-bold"><i class="fa fa-plus"></i></a>
        </div>
    </div>
@endsection

@section('content')
    @if(session()->has('message'))
        <div class="alert {{session('error') ? 'alert-danger' : 'alert-success'}}">
            {{ session('message') }}
        </div>
    @endif
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    @include('admin.user.table')
                    <div class="pagination">
                        {{ $users->links('admin.pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection
