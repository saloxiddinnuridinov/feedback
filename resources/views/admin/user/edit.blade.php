@extends('admin.layouts.simple.master')s

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
                                <h5>Edit Subject</h5>
                            </div>
                            <div class="card-body">
                                <form class="form theme-form" action="{{route('users.update', ['user' => $user->id])}}" method="POST" enctype="multipart/form-data">
                                    @method('put')
                                    @csrf
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-sm-6">
                                                {!! Form::label('name', 'Name:') !!}
                                                {!! Form::text('name', $user->name, ['class' => 'form-control', 'required']) !!}
                                            </div>

                                            <!-- Surname Field -->
                                            <div class="form-group col-sm-6">
                                                {!! Form::label('surname', 'Surname:') !!}
                                                {!! Form::text('surname', $user->surname, ['class' => 'form-control', 'required']) !!}
                                            </div>

                                            <!-- Email Field -->
                                            <div class="form-group col-sm-6">
                                                {!! Form::label('email', 'Email:') !!}
                                                {!! Form::text('email', $user->email, ['class' => 'form-control', 'required']) !!}
                                            </div>

                                            <!-- Password Field -->
                                            <div class="form-group col-sm-6">
                                                <label for="password">Password:</label>
                                                <input type="password" class="form-control" id="password" name="password">
                                            </div>

                                            <!-- Image Field -->
                                            <div class="form-group col-sm-6">
                                                <label for="image">Image:</label>
                                                <input type="file" class="form-control" id="image" name="image">
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <img src="{{ asset($user->image) }}" alt="Post Image"
                                                     style="max-width: 100px; max-height: 100px;">
                                            </div>

                                            <!-- Role Field -->
                                            <div class="form-group col-sm-6">
                                                {!! Form::label('role', 'Role:') !!}
                                                {!! Form::select('role', ['admin' => 'admin', 'user' => 'user'], $user->role, ['class' => 'form-control custom-select']) !!}
                                            </div>

                                            <!-- Role Field -->
                                            <div class="form-group col-sm-6">
                                                {!! Form::label('specialist', 'Specialist:') !!}
                                                {!! Form::select('specialist', ['All' => 'All', 'Sirtqi' => 'Sirtqi', 'Masofaviy' => 'Masofaviy', 'Kunduzgi' => 'Kunduzgi'], $user->specialist, ['class' => 'form-control custom-select']) !!}
                                            </div>

                                            <!-- Is Active Field -->
                                            <div class="form-group col-sm-6">
                                                {!! Form::label('is_active', 'Active:') !!}
                                                <div class="form-check">
                                                    {!! Form::hidden('is_active', 0, ['class' => 'form-check-input']) !!}
                                                    {!! Form::checkbox('is_active', 1, $user->is_active == 1, ['class' => 'form-check-input']) !!}
                                                    {!! Form::label('is_active', 'Is Active', ['class' => 'form-check-label']) !!}
                                                </div>
                                            </div>

                                            <?php
                                            $telegram_users = \App\Models\TelegramUser::all();
                                            ?>
                                            <div class="form-group col-sm-6">
                                                {!! Form::label('telegram_user', 'Telegram User:') !!}
                                                {!! Form::select('telegram_user', $telegram_users->pluck('name', 'id')->toArray(), null, ['class' => 'form-control custom-select', 'placeholder' => 'Select a Telegram User']) !!}
                                            </div>


                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="col-sm-9 offset-sm-3">
                                            <button class="btn btn-primary" type="submit">Submit</button>
                                            <a class="btn btn-secondary" href="{{route('users.index')}}">Cancel</a>
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
    @include('admin.editor')
@endsection

@section('script')
@endsection
