@extends('admin.layouts.simple.master')
@section('title', 'Add Subject Table')

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
                                <h5>Post show</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- Name Field -->
                                    <div class="col-sm-2">
                                        {!! Form::label('name', 'Name:') !!}
                                    </div>
                                    <div class="col-sm-10">
                                        <p>{{ $user->name }}</p>
                                    </div>

                                    <!-- Surname Field -->
                                    <div class="col-sm-2">
                                        {!! Form::label('surname', 'Surname:') !!}
                                    </div>
                                    <div class="col-sm-10">
                                        <p>{{ $user->surname }}</p>
                                    </div>

                                    <!-- Email Field -->
                                    <div class="col-sm-2">
                                        {!! Form::label('email', 'Email:') !!}
                                    </div>
                                    <div class="col-sm-10">
                                        <p>{{ $user->email }}</p>
                                    </div>

                                    <!-- Image Field -->
                                    <div class="col-sm-2">
                                        {!! Form::label('image', 'Image:') !!}
                                    </div>
                                    <div class="col-sm-10">
                                        <p>  <img src="{{ asset($user->image) }}" style="max-width: 200px;"></p>
                                    </div>

                                    <!-- Role Field -->
                                    <div class="col-sm-12">
                                        {!! Form::label('role', 'Role:') !!}
                                    </div>
                                    <div class="col-sm-12">
                                        <p>{{$user->role }}</p>
                                    </div>

                                    <!-- Is Active Field -->
                                    <div class="col-sm-2">
                                        {!! Form::label('is_active', 'Is Active:') !!}
                                    </div>
                                    <div class="col-sm-10">
                                        <p>
                                            @if ($user->is_active)
                                                <i class="fa fa-check-circle text-success"></i>
                                            @else
                                                <i class="fa fa-times-circle text-danger"></i>
                                            @endif
                                        </p>
                                    </div>

                                    <!-- Created At Field -->
                                    <div class="col-sm-2">
                                        {!! Form::label('created_at', 'Created At:') !!}
                                    </div>
                                    <div class="col-sm-10">
                                        <p>{{ $user->created_at }}</p>
                                    </div>

                                    <!-- Updated At Field -->
                                    <div class="col-sm-2">
                                        {!! Form::label('updated_at', 'Updated At:') !!}
                                    </div>
                                    <div class="col-sm-10">
                                        <p>{{ $user->updated_at }}</p>
                                    </div>

                                </div>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                      style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <div class="card-footer">
                                        <div class="col-sm-9 offset-sm-3">
                                            <button class="btn btn-danger" type="submit">Delete</button>
                                            <a class="btn btn-info" href="{{ route('users.edit', $user->id) }}">Edit</a>
                                            <a class="btn btn-primary" href="{{ route('users.index') }}">Cancel</a>
                                        </div>
                                    </div>
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
