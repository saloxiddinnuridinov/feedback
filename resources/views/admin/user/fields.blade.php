<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Surname Field -->
<div class="form-group col-sm-6">
    {!! Form::label('surname', 'Surname:') !!}
    {!! Form::text('surname', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::text('email', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Password Field -->
<div class="form-group col-sm-6">
    {!! Form::label('password', 'Password:') !!}
    {!! Form::text('password', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Image Field -->
<div class="form-group col-sm-6">
    <label for="image">Image:</label>
    <input type="file" class="form-control" id="image" name="image">
</div>
<div class="clearfix"></div>

<!-- Role Field -->
<div class="form-group col-sm-6">
    {!! Form::label('role', 'Role:') !!}
    {!! Form::select('role', ['admin' => 'admin', 'user' => 'user'], null, ['class' => 'form-control custom-select']) !!}
</div>

<!-- Role Field -->
<div class="form-group col-sm-6">
    {!! Form::label('specialist', 'Specialist:') !!}
    {!! Form::select('specialist', ['All' => 'All', 'Sirtqi' => 'Sirtqi', 'Masofaviy' => 'Masofaviy', 'Kunduzgi' => 'Kunduzgi'], null, ['class' => 'form-control custom-select']) !!}
</div>

<!-- Is Active Field -->
<div class="form-group col-sm-6">
    <div class="form-check">
        {!! Form::hidden('is_active', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('is_active', 1, null, ['class' => 'form-check-input']) !!}
        {!! Form::label('is_active', 'Is Active', ['class' => 'form-check-label']) !!}
    </div>
</div>
