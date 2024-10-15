<!-- Title Uz Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title_uz', 'Title Uz:') !!}
    {!! Form::text('title_uz', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Title Ru Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title_ru', 'Title Ru:') !!}
    {!! Form::text('title_ru', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Title En Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title_en', 'Title En:') !!}
    {!! Form::text('title_en', null, ['class' => 'form-control', 'required']) !!}
</div>
<!-- Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('date', 'Date:') !!}
    {!! Form::date('date', null, ['class' => 'form-control','id'=>'date']) !!}
</div>

<!-- Description Uz Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description_uz', 'Description Uz:') !!}
    <div id="editor_uz">
        {!! Form::textarea('description_uz', null, ['class' => 'form-control', 'required']) !!}
    </div>
</div>

<!-- Description Ru Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description_ru', 'Description Ru:') !!}
    <div id="editor_ru">
        {!! Form::textarea('description_ru', null, ['class' => 'form-control', 'required']) !!}
    </div>
</div>

<!-- Description En Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description_en', 'Description En:') !!}
    <div id="editor_en">
        {!! Form::textarea('description_en', null, ['class' => 'form-control', 'required']) !!}
    </div>
</div>

<!-- Picture Field -->
<div class="form-group col-sm-6">
    <label for="picture">Picture:</label>
    <input type="file" class="form-control" id="picture" name="picture" required>
</div>

<!-- Other Pictures Field -->
<div class="form-group col-sm-6">
    <label for="other_pictures">Other Pictures:</label>
    <input type="file" class="form-control" id="other_pictures" name="other_pictures[]" multiple>
</div>

<!-- Active Field -->
<div class="form-group col-sm-6">
    <label for="picture">Status:</label>
    <div class="form-check">
        <label class="form-check-label">
            {!! Form::radio('active', "1", null, ['class' => 'form-check-input']) !!}
            <i class="fa fa-check-circle text-success"></i> Active
        </label>
    </div>
    <div class="form-check">
        <label class="form-check-label">
            {!! Form::radio('active', "0", null, ['class' => 'form-check-input']) !!}
            <i class="fa fa-times-circle text-danger"></i> Inactive
        </label>
    </div>
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#date').datepicker()
    </script>
@endpush



