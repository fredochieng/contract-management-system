@extends('adminlte::page')
@section('title', 'Users')
@section('content_header')
<h1>
    Users
    <a href="" class="btn btn-xs btn-info pull-right btn-flat" href="#modal_new_user" data-toggle="modal" data-target="#modal_new_user">ADD NEW USER</a>
</h1>

@stop
@section('content')
<style>
    .description {
        height: 90px !important
    }
</style>
<div class="box">
    <div class="box-body">
        <table id="example1" class="table table-striped table-bordered records">
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Organization</th>
                    <th>Position</th>
                    <th>Role</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>

                @foreach($users as $count => $user)
                <tr>
                    <td>{{ $count + 1 }}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->organization_name}}</td>
                    <td>{{$user->job_title}}</td>
                    <td>{{$user->name}}</td>
                    <td><a href="#modal_edit_user_{{$user->id}}" data-toggle="modal" data-target="#modal_edit_user_{{$user->id}}"
                            class="btn btn-info btn-xs btn-flat">Edit</a> {!! Form::open(['action'=>['AdminController@destroy',$user->id],'method'=>'POST','class'=>'floatit','enctype'=>'multipart/form-data'])
                        !!} {{Form::hidden('_method','DELETE')}}
                        <button type="submit" class="btn btn-danger btn-xs btn-flat" onClick="return confirm('Are you sure you want to delete this contract party?');">   <strong>  <i class="fa fa-close"></i></strong></button>                        {!! Form::close() !!}
                    </td>
                    <div class="modal fade" id="modal_edit_user_{{$user->id}}">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                {!! Form::open(['action'=>['AdminController@update',$user->id],'method'=>'POST','class'=>'form','enctype'=>'multipart/form-data'])
                                !!}
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">UPDATE USER</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            {{Form::label('name', 'Full Name')}}<br>
                                            <div class="form-group">
                                                {{Form::text('ame', $user->name,['class'=>'form-control', 'placeholder'=>''])}}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            {{Form::label('email', 'Email')}}<br>
                                            <div class="form-group">
                                                {{Form::text('email', $user->email,['class'=>'form-control', 'placeholder'=>''])}}

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary pull-left btn-flat" name="save_user">UPDATE USER</button>
                                </div>
                                {{Form::hidden('_method','PUT')}} {!! Form::close() !!}
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>
<div class="modal fade" id="modal_new_user">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            {!! Form::open(['action'=>'AdminController@store','method'=>'POST','class'=>'form','enctype'=>'multipart/form-data']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">New User</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        {{Form::label('name', 'Full Name')}}<br>
                        <div class="form-group">
                            {{Form::text('name', '',['class'=>'form-control', 'placeholder'=>''])}}
                        </div>
                    </div>
                    <div class="col-md-6">
                        {{Form::label('email', 'Email')}}<br>
                        <div class="form-group">
                            {{Form::text('email', '',['class'=>'form-control', 'placeholder'=>''])}}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                        {{Form::label('role_id', 'User Role')}}<br>
                         {{ Form::select('role_id',$roles,null, ['class'
                        => 'form-control select2','placeholder'=>'--Select User Role--']) }}
                        </div>
                    </div>
                    <div class="col-md-6">

                        {{Form::label('organization_id', 'Organization')}}<br>
                        <div class="form-group">
                        {{ Form::select('organization_id',$organizations,null,
                        ['class' => 'form-control select2','placeholder'=>'--Select Organization--']) }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        {{Form::label('job_title', 'Job Title')}}<br>
                        <div class="form-group">
                            {{Form::text('job_title', '',['class'=>'form-control', 'placeholder'=>''])}}
                        </div>
                    </div>
                    <div class="col-md-6">
                        {{Form::label('password', 'Password')}}<br>
                        <div class="form-group">
                          {{ Form::password('password', array('placeholder'=>'Password', 'class'=>'form-control' ) ) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary pull-left btn-flat" name="save_user">CREATE USER</button>
            </div>

            {!! Form::close() !!}
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>




@stop
@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<link rel="stylesheet" href="/css/bootstrap-datepicker.min.css">
@stop
@section('js')

<script src="/js/bootstrap-datepicker.min.js"></script>
<script>
    $(function () {
         $('#example1').DataTable()
    });
</script>

@stop
