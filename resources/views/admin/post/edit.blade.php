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
                                <form class="form theme-form" action="{{route('posts.update', ['post' => $post->id])}}" method="POST" enctype="multipart/form-data">
                                    @method('put')
                                    @csrf
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- Title Uz Field -->
                                            <div class="form-group col-sm-6">
                                                {!! Form::label('title_uz', 'Title Uz:') !!}
                                                {!! Form::text('title_uz', $post->title_uz, ['class' => 'form-control', 'required']) !!}
                                            </div>

                                            <!-- Title Ru Field -->
                                            <div class="form-group col-sm-6">
                                                {!! Form::label('title_ru', 'Title Ru:') !!}
                                                {!! Form::text('title_ru', $post->title_ru, ['class' => 'form-control', 'required']) !!}
                                            </div>

                                            <!-- Title En Field -->
                                            <div class="form-group col-sm-6">
                                                {!! Form::label('title_en', 'Title En:') !!}
                                                {!! Form::text('title_en', $post->title_en, ['class' => 'form-control', 'required']) !!}
                                            </div>

                                            <!-- Date Field -->
                                            <div class="form-group col-sm-6">
                                                {!! Form::label('date', 'Date:') !!}
                                                {!! Form::date('date', $post->date, ['class' => 'form-control', 'id' => 'date']) !!}
                                            </div>

                                            <div class="form-group col-sm-12 col-lg-12">
                                                {!! Form::label('description_uz', 'Description Uz:') !!}
                                                <textarea id="editor_uz" class="form-control" name="description_uz" required>{!! htmlspecialchars_decode($post->description_uz) !!}</textarea>
                                            </div>

                                            <div class="form-group col-sm-12 col-lg-12">
                                                {!! Form::label('description_ru', 'Description Ru:') !!}
                                                <textarea id="editor_ru" class="form-control" name="description_ru" required>{!! htmlspecialchars_decode($post->description_ru) !!}</textarea>
                                            </div>

                                            <div class="form-group col-sm-12 col-lg-12">
                                                {!! Form::label('description_en', 'Description En:') !!}
                                                <textarea id="editor_en" class="form-control" name="description_en" required>{!! htmlspecialchars_decode($post->description_en) !!}</textarea>
                                            </div>

                                            <!-- Picture Field -->
                                            <div class="form-group col-sm-6">
                                                <label for="picture">Picture:</label>
                                                <input type="file" class="form-control" id="picture" name="picture">
                                            </div>
                                            <!-- Other Pictures Field -->
                                            <div class="form-group col-sm-6">
                                                <label for="other_pictures">Other Pictures:</label>
                                                <input type="file" class="form-control" id="other_pictures" name="other_pictures[]" multiple>
                                            </div>

                                            <!-- Active Field -->
                                            <div class="form-group col-sm-6">
                                                <label for="active">Status:</label><br>
                                                <div class="form-check form-check-inline">
                                                    {!! Form::radio('active', "1", $post->active == 1, ['class' => 'form-check-input', 'id' => 'active']) !!}
                                                    <label class="form-check-label" for="active">Active</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    {!! Form::radio('active', "0", $post->active == 0, ['class' => 'form-check-input', 'id' => 'inactive']) !!}
                                                    <label class="form-check-label" for="inactive">Inactive</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="col-sm-9 offset-sm-3">
                                            <button class="btn btn-primary" type="submit">Submit</button>
                                            <a class="btn btn-secondary" href="{{route('posts.index')}}">Cancel</a>
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
