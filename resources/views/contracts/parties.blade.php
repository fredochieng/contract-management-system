@extends('adminlte::page')
@section('title', 'Contract Parties')
@section('content_header')
<h1 class="pull-left">Contract Parties<small>Manage Contract Parties</small></h1>

<div class="pull-right"><a class="btn btn-primary btn-sm btn-flat" href="#modal_new_party" data-toggle="modal" data-target="#modal_new_party"><i class="fa fa-plus"></i>
    New Contract Party</a></div>
<div style="clear:both"></div>






















@stop
@section('content')
<style>
    .description {
        height: 90px !important
    }
</style>
<div class="box box-success" style="font-size:10px;">
    <div class="box-body">
        <div class="table-responsive">
            <table id="example1" class="table no-margin">
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Party Name</th>
                        <th>Contact Person</th>
                        <th>Telephone</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($parties as $count=> $party)
                    <tr>
                        <td>{{ $count+1}}</td>
                        <td><a href="/contract-party/{{$party->party_id}}/view-contract-party">
                             <span class="label" style="background-color:#FFF;color:#0073b7;border:1px solid #0073b7;">
                              <i class="fa fa-briefcase fa-fw"></i> {{$party->party_name}}</a></span>
                        </td>
                        <td>{{$party->contact_person}}</td>
                        <td>{{$party->telephone}}</td>
                        <td>{{$party->email}}</td>
                        <td>
                            <a href="#modal_edit_party_{{$party->party_id}}" data-toggle="modal" data-target="#modal_edit_party_{{$party->party_id}}"
                                class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a &nbsp;
                               {!! Form::open(['action'=>['PartyController@destroy',$party->party_id],'method'=>'POST','class'=>'floatit','enctype'=>'multipart/form-data'])
                            !!} {{Form::hidden('_method','DELETE')}}
                            <a href="#modal_delete_user_{{ $party->party_id }}" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#modal_delete_party_{{ $party->party_id }}"
                                class="btn btn-xs btn-danger delete_user_button"><i class="glyphicon glyphicon-trash"></i> Delete</a>
                        </td>


                        <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modal_edit_party_{{$party->party_id}}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    {!! Form::open(['action'=>['PartyController@update',$party->party_id],'method'=>'POST','class'=>'form','enctype'=>'multipart/form-data'])
                                    !!}
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Update Contract Party</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                {{Form::label('party_name', 'Party Name')}}<br>
                                                <div class="form-group">
                                                    {{Form::text('party_name', $party->party_name,['class'=>'form-control', 'placeholder'=>''])}}
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                {{Form::label('contact_person', 'Contact Person')}}<br>
                                                <div class="form-group">
                                                    {{Form::text('contact_person', $party->contact_person,['class'=>'form-control', 'placeholder'=>''])}}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                {{Form::label('telephone', 'Telephone')}}<br>
                                                <div class="form-group">
                                                    {{Form::text('telephone', $party->telephone,['class'=>'form-control', 'placeholder'=>''])}}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                {{Form::label('email', 'Email')}}<br>
                                                <div class="form-group">
                                                    {{Form::text('email', $party->email,['class'=>'form-control', 'placeholder'=>''])}}

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                {{Form::label('physical_address', 'Physical Address')}}<br>
                                                <div class="form-group">
                                                    {{Form::text('physical_address', $party->physical_address,['class'=>'form-control', 'placeholder'=>''])}}

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                {{Form::label('postal_address', 'Postal Address')}}<br>
                                                <div class="form-group">
                                                    {{Form::text('postal_address', $party->postal_address,['class'=>'form-control', 'placeholder'=>''])}}

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                                        <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-save"></i> Save Changes</button>
                                    </div>
                                    {{Form::hidden('_method','PUT')}} {!! Form::close() !!}
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                    </tr>

                    <!-- Modal to delete a contract by legal team/legal admin -->
                    <div class="modal fade" id="modal_delete_party_{{$party->party_id}}">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                {!! Form::open(['action'=>['PartyController@destroy', $party->party_id],'method'=>'POST','class'=>'floatit','enctype'=>'multipart/form-data'])
                                !!} {{Form::hidden('_method','DELETE')}}
                                <input type="hidden" name='contract' value="{{$party->party_di}}">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Delete Contract Party</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p>Are you sure you want to delete {{ $party->party_name }}?</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> No</button>
                                    <button type="submit" class="btn btn-danger btn-flat"><i class="fa fa-check"></i> Yes</button>
                                </div>
                                {!! Form::close() !!}
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- End modal to delete a contract by legal team/ legal admin -->
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
<div class="modal fade" id="modal_new_party" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            {!! Form::open(['action'=>'PartyController@store','method'=>'POST','class'=>'form','enctype'=>'multipart/form-data']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">New Contract Party</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        {{Form::label('party_name', 'Party Name')}}<br>
                        <div class="form-group">
                            {{Form::text('party_name', '',['class'=>'form-control', 'required', 'placeholder'=>''])}}
                        </div>
                    </div>
                    <div class="col-md-12">

                        {{Form::label('contact_person', 'Contact Person')}}<br>
                        <div class="form-group">
                            {{Form::text('contact_person', '',['class'=>'form-control', 'required', 'placeholder'=>''])}}
                        </div>
                    </div>
                    <div class="col-md-6">
                        {{Form::label('telephone', 'Telephone')}}<br>
                        <div class="form-group">
                            {{Form::text('telephone', '',['class'=>'form-control', 'required', 'placeholder'=>''])}}

                        </div>
                    </div>
                    <div class="col-md-6">
                        {{Form::label('email', 'Email')}}<br>
                        <div class="form-group">
                            {{Form::text('email', '',['class'=>'form-control', 'required', 'placeholder'=>''])}}
                        </div>
                    </div>
                    <div class="col-md-6">
                        {{Form::label('physical_address', 'Physical Address')}}<br>
                        <div class="form-group">
                            {{Form::text('physical_address', '',['class'=>'form-control', 'required', 'placeholder'=>''])}}
                        </div>
                    </div>

                    <div class="col-md-6">
                        {{Form::label('postal_address', 'Postal Address')}}<br>
                        <div class="form-group">
                            {{Form::text('postal_address', '',['class'=>'form-control', 'required', 'placeholder'=>''])}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-check"></i> Create Contract Party</button>
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
