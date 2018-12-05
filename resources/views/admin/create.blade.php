@extends('admin.index')

@section('content')

<div class="box">
    <div class="box-header">
      <h3 class="box-title">{{ $title }}</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        {!! Form::open(['url' => aurl('clients')]) !!}
            <div class="form-group">
                {!! Form::label('name', trans('admin.name')) !!}
                {!! Form::text('name', old('name'),['class'=>'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('gender', trans('admin.gender')) !!}
                {!! Form::select('gender', ['male'=>trans('admin.male'), 'female'=>trans('admin.female'), 'other'=>trans('admin.other')], old('gender'),['class'=>'form-control',
            'placeholder'=>'Choose Gender']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('age', trans('admin.age')) !!}
                {!! Form::number('age', old('age'),['class'=>'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('country', trans('admin.country')) !!}
                {!! Form::text('country', old('country'),['class'=>'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('fb', trans('admin.fb')) !!}
                {!! Form::text('fb', old('fb'),['class'=>'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('phone', trans('admin.phone')) !!}
                {!! Form::number('phone', old('phone'),['class'=>'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('email', trans('admin.email')) !!}
                {!! Form::email('email', old('email'),['class'=>'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('preflang', trans('admin.preflang')) !!}
                {!! Form::text('preflang', old('preflang'),['class'=>'form-control']) !!}
            </div>
            {!! Form::submit('Submit') !!}
        {!! Form::close() !!}

    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->


{{-- @push('js')
@endpush --}}

@endsection