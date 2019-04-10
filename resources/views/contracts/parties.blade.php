@extends('adminlte::page')

@section('title', 'Contract Parties')

@section('content_header')
  <h1>
  	Contract Parties
  	<a href="" class="btn btn-xs btn-info pull-right btn-flat"  href="#modal_new_party" data-toggle="modal" data-target="#modal_new_party">NEW CONTRACT PARTY</a>
  </h1>
@stop

@section('content')
  <style>
  	.description{height:90px !important}
  </style>
            <div class="box">
                <div class="box-body">
                <table class="table table-striped table-bordered records">
                	<thead>
                    	<tr>

                            <th>Party Name</th>
                            <th>Address</th>
                            <th>Telephone</th>
                            <th>Email</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($parties as $party)
                            <tr>
                                <td>{{$party->party_name}}</td>
                                <td>{{$party->address}}</td>
                                <td>{{$party->telephone}}</td>
                                <td>{{$party->email}}</td>
                                <td><a href="#modal_edit_party_{{$party->party_id}}" data-toggle="modal" data-target="#modal_edit_party_{{$party->party_id}}" class="btn btn-info btn-xs btn-flat" >Edit</a>
                                 {!! Form::open(['action'=>['PartyController@destroy',$party->party_id],'method'=>'POST','class'=>'floatit','enctype'=>'multipart/form-data']) !!}
           {{Form::hidden('_method','DELETE')}}
            <button type="submit" class="btn btn-danger btn-xs btn-flat" onClick="return confirm('Are you sure you want to delete this contract party?');">   <strong>  <i class="fa fa-close"></i></strong></button>
            {!! Form::close() !!}
                                </td>
                                <div class="modal fade" id="modal_edit_party_{{$party->party_id}}">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              {!! Form::open(['action'=>['PartyController@update',$party->party_id],'method'=>'POST','class'=>'form','enctype'=>'multipart/form-data']) !!}
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">UPDATE CONTRACT PARTY</h4>
              </div>
              <div class="modal-body">
              	<div class="row">
                	   <div class="col-md-12">
                    	{{Form::label('party_name', 'Party Name')}}<br>
                         <div class="form-group">
                             {{Form::text('party_name', $party->party_name,['class'=>'form-control', 'placeholder'=>''])}}
            	   </div>
                </div>
                 <div class="col-md-4">
                    	{{Form::label('address', 'Address')}}<br>
                         <div class="form-group">
                             {{Form::text('address', $party->address,['class'=>'form-control', 'placeholder'=>''])}}

            	   </div>
                </div>
                  <div class="col-md-4">
                    	{{Form::label('email', 'Email')}}<br>
                         <div class="form-group">
                             {{Form::text('email', $party->email,['class'=>'form-control', 'placeholder'=>''])}}

            	   </div>
                </div>
                 <div class="col-md-4">
                    	{{Form::label('telephone', 'Telephone')}}<br>
                         <div class="form-group">
                             {{Form::text('telephone', $party->telephone,['class'=>'form-control', 'placeholder'=>''])}}
            	   </div>
                </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary pull-left btn-flat" name="save_party">UPDATE</button>
              </div>
               {{Form::hidden('_method','PUT')}}
              {!! Form::close() !!}
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
    <div class="modal fade" id="modal_new_party">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
            {!! Form::open(['action'=>'PartyController@store','method'=>'POST','class'=>'form','enctype'=>'multipart/form-data']) !!}
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">New Contract Party</h4>
              </div>
              <div class="modal-body">
              	<div class="row">
                	   <div class="col-md-6">
                    	{{Form::label('party_name', 'Party Name')}}<br>
                         <div class="form-group">
                             {{Form::text('party_name', '',['class'=>'form-control', 'placeholder'=>''])}}
            	   </div>
                </div>
                  <div class="col-md-6">

                    	{{Form::label('contact_person', 'Contact Person')}}<br>
                         <div class="form-group">
                             {{Form::text('contact_person', '',['class'=>'form-control', 'placeholder'=>''])}}
            	   </div>
                </div>
                   <div class="col-md-4">
                    	{{Form::label('telephone', 'Telephone')}}<br>
                         <div class="form-group">
                             {{Form::text('telephone', '',['class'=>'form-control', 'placeholder'=>''])}}

            	   </div>
                </div>
                  <div class="col-md-4">
                    	{{Form::label('email', 'Email')}}<br>
                         <div class="form-group">
                             {{Form::text('email', '',['class'=>'form-control', 'placeholder'=>''])}}
            	   </div>
                </div>
                <div class="col-md-4">
                    	{{Form::label('address', 'Address')}}<br>
                         <div class="form-group">
                             {{Form::text('address', '',['class'=>'form-control', 'placeholder'=>''])}}
            	   </div>
                </div>
            </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary pull-left btn-flat" name="save_party">SUBMIT</button>
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
    //Initialize Select2 Elements
	<?php if(isset($_GET['new']) && $_GET['new']=='true'){ ?>
	$('#modal_new_party').modal('show');

	<?php } ?>

	 $(".records").DataTable();

	$('.select2').select2()
	 $('.issued_date').datepicker( {
	 	format: 'dd-mm-yyyy',
		orientation: "bottom",
		autoclose: true,
		 showDropdowns: true,

	 })
 })
	 </script>

@stop