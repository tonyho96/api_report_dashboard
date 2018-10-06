@extends('dashboard.layouts.master')
@section('content')
  @if(Session::has('message'))
   <div class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismissible">{{ Session::get('message') }}
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
  </div>
  @endif
    <!-- content -->
    <section class="content" style="padding: 40px;">
            @if ($errors->has('error'))
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                {{$errors->first('error')}}
              </div>
            @endif
               @if (Session::has('message'))
               <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                <p><i class="icon fa fa-check"></i>{{Session::get('message')}}</p>
              </div>
             @endif
        <div class="row">
            <div class="col-xs-12">
                <div class="box  box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit user</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        {!! Form::open(['action' => ['UserController@update', $user->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal']) !!}
                        {!! Form::token() !!}
                        <div class="box-body">
                            <div class="form-group required">
                                {!! Form::label('name', 'Name', ['class' => 'col-sm-2 control-label']) !!}
                                <div class="col-sm-10">
                                    {!! Form::text('name', $user->name, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group required">
                                {!! Form::label('email', 'Email', ['class' => 'col-sm-2 control-label']) !!}
                                <div class="col-sm-10">
                                    {!! Form::email('email', $user->email, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group required">
                                {!! Form::label('Role', 'Role', ['class' => 'col-sm-2 control-label']) !!}
                                <div class="col-sm-10">
                                    {!! Form::select('role',array('1' => 'Admin', '2' => 'User'),$user->role, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group required">
                                {!! Form::label('password', 'Password', ['class' => 'col-sm-2 control-label']) !!}
                                <div class="col-sm-10">
                                    {!! Form::password('password', ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group required">
                                {!! Form::label('mailchimp_api_key', 'Mailchimp API Key', ['class' => 'col-sm-2 control-label']) !!}
                                <div class="col-sm-10">
                                    {!! Form::text('mailchimp_api_key', $user->mailchimp_api_key, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            {{--<div class="form-group required">--}}
                                {{--{!! Form::label('role', trans('users.role'), ['class' => 'col-sm-2 control-label']) !!}--}}
                                {{--<div class="col-sm-10">--}}
                                    {{--{!! Form::select('role', $roles, config('user.roles.company_admin'), ['class' => 'form-control']) !!}--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <a href="{{action('UserController@index')}}" class="btn btn-default">Cancel</a>
                            <button type="submit" class="btn btn-info pull-right">Submit</button>
                        </div>
                        <!-- /.box-footer -->
                        {!! Form::close() !!}
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    </section>
    </div>
    </div>
@stop
