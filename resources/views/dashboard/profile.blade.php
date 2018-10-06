@extends('dashboard.layouts.master')
@section('content')
<!-- content -->
@if(Session::has('message'))
  <div class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismissible">{{ Session::get('message') }}
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  </div>
@endif
    <section class="content" style="padding: 40px;">
        <div class="row">
            <div class="col-xs-12">
                <div class="box  box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Profile setting:</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        {!! Form::open(['action' => ['DashboardController@saveProfile'], 'method' => 'POST', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal']) !!}
                        {!! Form::token() !!}
                        <div class="box-body">

                            <div class="form-group required">
                                {!! Form::label('time_zone', 'Timezone', ['class' => 'col-sm-4 control-label']) !!}
                                <div class="col-sm-10">
                                    {!! Form::select('time_zone', $timezone_list, isset($user_time_zone) ? $user_time_zone : '', ['class' => 'form-control','required' =>'required']) !!}
                                </div>
                            </div>

                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <a href="{{action('UserController@index')}}" class="btn btn-default">Cancel</a>
                            <button type="submit" class="btn btn-info pull-right">Save</button>
                        </div>
                        <!-- /.box-footer -->
                        {!! Form::close() !!}
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    </section>
@stop
