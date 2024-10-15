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
                                <h5>Add Post</h5>
                            </div>
                            <!-- Form with multipart/form-data encoding -->
                            {!! Form::open(['route' => 'users.store', 'enctype' => 'multipart/form-data']) !!}
                            <div class="card-body">

                                <div class="row">
                                    @include('admin.user.fields')
                                </div>

                            </div>
                            <div class="card-footer">
                                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                                <a href="{{ route('users.index') }}" class="btn btn-default"> Cancel </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.editor')

@endsection

@section('script')
@endsection
