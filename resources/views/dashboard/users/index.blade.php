@extends('dashboard.layouts.master')
@section('content')
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
                <div class="box">
                    @if (Auth::user()->isAdmin())
                    <div class="box-header">
                        <h3 class="box-title">User list</h3><br>
                        <a href="{{ action('UserController@create') }}" class="btn btn-success"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
                    </div>
                    @endif
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="users-table" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Mailchimp API Key</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            @foreach($users as $index => $user)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    @if ($user->role === 1)
                                    <td>Admin</td>
                                    @else
                                    <td>User</td>
                                    @endif
                                    <td>{{ $user->mailchimp_api_key }}</td>
                                    <td>
                                        <a href="{{ action('UserController@edit', $user->id) }}" class="btn btn-success"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                                        @if ($user->email !== Auth::user()->email)
                                        {!! Form::open(['action' => ['UserController@destroy', $user->id],
                                            'method' => 'DELETE',
                                            'onsubmit' => 'return confirmForm(this);',
                                            'data-confirm-message' => trans('labels.confirm_delete'),
                                            'class' => 'inline',
                                            ]) !!}

                                        {{ Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger', 'onClick' => 'return window.confirm("Are you sure?")']) }}
                                        {!! Form::close() !!}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    </section>

@stop
