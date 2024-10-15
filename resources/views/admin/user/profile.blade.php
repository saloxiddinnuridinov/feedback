@extends('admin.layouts.simple.master')
@section('title', 'Add User')

@section('css')
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-xl-12">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header pb-0">
                                <h5>Add User</h5>
                            </div>
                            {!! Form::open(['route' => 'update.profile', 'enctype' => 'multipart/form-data']) !!}
                            <div class="card-body">
                                <form action="{{ route('update.profile') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="name">Name</label>
                                            <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="surname">Surname</label>
                                            <input type="text" name="surname" class="form-control" value="{{ Auth::user()->surname }}">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="image">Profile Image</label>
                                            <input type="file" name="image" class="form-control">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="email">Email</label>
                                            <input type="email" name="email" class="form-control" value="{{ Auth::user()->email }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        @if(Auth::user()->image)
                                            <img src="{{ asset(Auth::user()->image) }}" alt="{{ Auth::user()->name }}" width="100">
                                        @endif
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="old_password">Old Password</label>
                                        <input type="password" id="old_password" name="old_password" class="form-control">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="new_password">New Password</label>
                                        <input type="password" id="new_password" name="new_password" class="form-control">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="new_password_confirmation">Confirm New Password</label>
                                        <input type="password" name="new_password_confirmation" class="form-control">
                                    </div>
                                    <br>
                                    <button type="submit" class="btn btn-primary">Update Profile</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection
