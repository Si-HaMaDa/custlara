@extends('admin.index')

@section('content')

<div class="box">
    <div class="box-header">
      <h3 class="box-title">{{ $title }}</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        {!! Form::open(['route' => ['clients.update', $client->id], 'method' => 'put']) !!}
            <div class="form-group">
                {!! Form::label('name', trans('admin.name')) !!}
                {!! Form::text('name', $client->name,['class'=>'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('gender', trans('admin.gender')) !!}
                {!! Form::select('gender', ['male'=>trans('admin.male'), 'female'=>trans('admin.female'), 'other'=>trans('admin.other')], $client->gender,['class'=>'form-control', 'placeholder'=>'Choose Gender']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('age', trans('admin.age')) !!}
                {!! Form::number('age', $client->age,['class'=>'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('country', trans('admin.country')) !!}
                {!! Form::text('country', $client->country,['class'=>'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('fb', trans('admin.fb')) !!}
                {!! Form::text('fb', $client->fb,['class'=>'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('phone', trans('admin.phone')) !!}
                {!! Form::number('phone', $client->phone,['class'=>'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('email', trans('admin.email')) !!}
                {!! Form::email('email', $client->email,['class'=>'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('preflang', trans('admin.preflang')) !!}
                {!! Form::text('preflang', $client->preflang,['class'=>'form-control']) !!}
            </div>
            <div class="form-group" id='df_call'>
                {!! Form::label('f_call', trans('admin.if_fail_call')) !!}
                <label for="f_call" class="btn btn-danger">
                    {!! Form::checkbox('f_call', 1); !!}
                </label>
            </div>
            <div id="d_statu">
                <div class="form-group">
                    {!! Form::label('statu', trans('admin.statu')) !!}
                    {!! Form::select('statu', ['0'=>trans('admin.new'), '1'=>trans('admin.process'), '2'=>trans('admin.atten'), '3'=>trans('admin.finished_fail'), '4'=>trans('admin.finished_succ')], $client->statu,['class'=>'form-control',
                'placeholder'=>'Choose Statu']) !!}
                </div>
                <div class="form-group">
                    @if($client->statu == 0)
                    <a href="javascript:;" onclick='start_conv()' class='btn btn-primary'>Start conversation</a>
                    @elseif($client->statu == 1)
                    <a href="javascript:;" onclick='end_convs()' class='btn btn-success'>successful conversation</a>
                    <a href="javascript:;" onclick='end_convf()' class='btn btn-danger'>failed conversation</a>
                    <a href="javascript:;" onclick='need_atten()' class='btn btn-warning'>Needs Attention</a>
                    @elseif($client->statu == 2)
                    <a href="javascript:;" onclick='start_soul()' class='btn btn-warning'>Start Dealing</a>
                    @endif
                </div>
            </div>
            <div class="form-group" id='try_note' style='display:none'>
                {!! Form::textarea('try_note', '',['class'=>'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('notes', trans('admin.notes')) !!}
                {!! Form::textarea('notes', $client->notes,['class'=>'form-control']) !!}
            </div>

            <div class="panel panel-primary">
                <div class="panel-heading"><h4>Older Tries</h4></div>
                <div class="panel-body">
                    <div class="panel panel-default">
                        <div class="panel-heading">Older Tries</div>
                        <div class="panel-body">
                        Panel content
                        </div>
                        <div class="panel-body">
                        Panel content
                        </div>
                    </div>
                </div>
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