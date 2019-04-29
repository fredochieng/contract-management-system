@extends('adminlte::page')
@section('title', 'CMS | Profile')
@section('content_header')
<h1 class="pull-left">My Profile</h1>
<div style="clear:both"></div>














@stop
@section('content')
<div class="row" style="font-size:10px;">
    <div class="col-xs-12">
        <div class="box box-success">
            <div class="box-body">
                <div class="container-fluid">
                    <div class="row">
                        {!! Form::open(['action'=>['UserController@updateUserProfile',$auth_users->id],'method'=>'POST','class'=>'form','enctype'=>'multipart/form-data'])
                        !!}
                        <input type="hidden" name='contract' value="{{$auth_users->id}}">
                        <div class="col-md-6">
                            {{Form::label('name', 'Full Name')}}<br>
                            <div class="form-group">
                                {{Form::text('name', $auth_users->name, ['class'=>'form-control', 'placeholder'=>''])}}
                            </div>
                            {{Form::label('email', 'Email')}}<br>
                            <div class="form-group">
                                {{Form::text('email', $auth_users->email,['class'=>'form-control', 'readonly'=>''])}}
                            </div>
                            <div class="form-group">
                                {!! Form::label('organization_id', 'Organization' . '') !!} {!! Form::select('organization_id', $organizations, $auth_users->organization_id,
                                ['placeholder' => 'Please select user organization', 'class' => 'form-control select2', 'disabled="disabled"']);
                                !!}
                            </div>

                        </div>

                        <div class="col-md-6">

                            {{Form::label('job_title', 'Job Title')}}<br>
                            <div class="form-group">
                                {{Form::text('job_title', $auth_users->job_title, ['class'=>'form-control', 'placeholder'=>''])}}
                            </div>

                            <div class="form-group">
                                <label for="password">Change Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter only if you want to change">
                            </div>
                            {{Form::label('password', 'Password *')}}<br>
                            <div class="form-group">
                                {{Form::password('confirm_password', ['class'=>'form-control', 'required'])}}
                            </div>
                            <p class="text-red">Enter you current password to make changes to you profile</p>

                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save Changes</button>
                            </div>
                        </div>

                        <input type="hidden" name="action" value="editProfile">
                        <input type="hidden" name="route" value="profile">

                        <input type="hidden" name="id" value="1">
                        </form>
                        <!-- /.form -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




























































@stop
