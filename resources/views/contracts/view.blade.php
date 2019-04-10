@extends('adminlte::page')
@section('title', 'Contract Details')
@section('content_header')
<h1>View Contract Details</h1>

@stop
@section('content')
<style>
    .description {
        height: 90px !important
    }
</style>
<div class="box box-success">
    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header" style="font-weight:bold">
                    Contract Party: {{ $contract->party_name }}
                    <small class="pull-right" style="font-weight:bold">Contract Number: # {{ $contract->contract_id }}</small>
                </h2>
            </div>
        </div>
        <div class="row invoice-info">
            <!-- Contract Details row -->
            {!! Form::open(['action'=>['ContractController@publish', $contract->contract_id],'method'=>'POST','class'=>'form','enctype'=>'multipart/form-data'])
            !!}
            <div class="row">
                <div class="col-md-6">
                    {{Form::text('contract_id',$contract->contract_id,['class'=>'form-control hidden','placeholder'=>'The contract Title'])}}
                    {{Form::label('title', 'Contract Title ')}}
                    <div class="form-group">
                        <h4>{{ $contract->contract_title }}</h4>
                    </div>
                </div>
                <div class="col-md-3">
                    {{Form::label('party_name', 'Party Name ')}}
                    <div class="form-group">
                        <h4>{{ $contract->party_name }}</h4>
                    </div>
                </div>
                <div class="col-md-3">
                    {{Form::label('contract_type', 'Contract Type ')}}
                    <div class="form-group">
                        @if($contract->contract_type_name =='')
                        <h4>N/A</h4>
                        @else {{ $contract->contract_type_name }} @endif
                    </div>
                </div>
                <div class="col-md-6">
                    {{Form::label('effective_date', 'Effective Date ')}}
                    <div class="form-group">
                        <h4>{{ $contract->effective_date }}</h4>
                    </div>
                </div>
                <div class="col-md-3">
                    {{Form::label('expiry_date', 'Expiry Date ')}}
                    <div class="form-group">
                        <h4>{{ $contract->expiry_date }}</h4>
                    </div>
                </div>
                <div class="col-md-3">
                    {{Form::label('contract_status', 'Contract Status')}}
                    <div class="form-group">
                        <span class="pull-right-container">
        @if($contract->contract_status == 'created')
                <small class="label pull-center btn-default">{{$contract->contract_status}}</small></span>                        @elseif($contract->contract_status == 'published')
                        <small class="label pull-center btn-info">{{$contract->contract_status}}</small></span>
                        @elseif($contract->contract_status == 'submitted')
                        <small class="label pull-center btn-success">{{$contract->contract_status}}</small></span>
                        @elseif($contract->contract_status == 'approved')
                        <small class="label pull-center btn-success">{{$contract->contract_status}}</small></span>
                        @elseif($contract->contract_status == 'ammended')
                        <small class="label pull-center btn-warning">{{$contract->contract_status}}</small></span>
                        @elseif($contract->contract_status == 'terminated')
                        <small class="label pull-center btn-danger">{{$contract->contract_status}}</small></span>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    {{Form::label('description', 'Contract Description')}}
                    <div class="form-group">
                        <h4>{{ $contract->description }}</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                </div>
            </div>
            <div class="row no-print">
                <div class="col-xs-12">
                    @if( $contract->contract_status =='created' && $contract->contract_stage ==1)
                    <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> PUBLISH CONTRACT</button> @elseif($contract->contract_status
                    =='published' && $contract->contract_stage ==2)
                    <a href="#modal_submit_contract" data-toggle="modal" data-target="#modal_submit_contract" class="btn btn-success"><i class="fa fa-check"></i> SUBMIT CONTRACT</a>
                    <a href="#modal_ammend_contract" data-toggle="modal" data-target="#modal_ammend_contract" class="btn btn-info"><i class="fa fa-refresh"></i> AMMEND CONTRACT</a>
                    <a href="#modal_terminate_contract" data-toggle="modal" data-target="#modal_terminate_contract" class="btn btn-danger"><i class="fa fa-close"></i> TERMINATE CONTRACT</a>
                    @elseif($contract->contract_status =='submitted' && $contract->contract_stage ==3)
                    {{-- This actions are for the leag admin --}}
                    <a href="#modal_approve_contract" data-toggle="modal" data-target="#modal_approve_contract" class="btn btn-success"><i class="fa fa-check"></i> APPROVE CONTRACT</a>
                    <a href="#modal_admin_ammend_contract" data-toggle="modal" data-target="#modal_admin_ammend_contract" class="btn btn-info"><i class="fa fa-refresh"></i> AMMEND CONTRACT</a>
                    <a href="#modal_admin_terminate_contract" data-toggle="modal" data-target="#modal_admin_terminate_contract" class="btn btn-danger"><i class="fa fa-close"></i> TERMINATE CONTRACT</a>
                     @elseif($contract->contract_status =='terminated')
                    <p class="text-red">This contract has been terminated and the initiator has been notified</p>
                    @endif

                    <a href="/{{$last_draft_contract_section->crf_file}}" class="btn btn-primary pull-right" style="margin-right: 10px;" target="_blank"><i class="fa fa-fw fa-download"></i> Latest CRF Document</a>
                    <a href="/{{$contract->draft_file}}" class="btn btn-primary pull-right" style="margin-right: 10px;" target="_blank"><i class="fa fa-fw fa-download"></i> Latest Contract Document</a>                    {!! Form::close() !!}

                </div>
            </div>
    </section>
    <!-- Modal to submit a contract by legal team -->
    <div class="modal fade" id="modal_submit_contract">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                {!! Form::open(['action'=>'ContractController@submit','method'=>'POST','class'=>'form','enctype'=>'multipart/form-data'])
                !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Submit Contract To Head of Legal</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            {{Form::text('contract_id',$contract->contract_id,['class'=>'form-control hidden','placeholder'=>'The contract Title'])}}
                            {{Form::label('comments', 'Comments (optional)')}}<br>
                            <div class="form-group">
                                {{Form::textarea('comments', '',['class'=>'form-control', 'placeholder'=>'Comments are optional'])}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success pull-left btn-flat" name="approve"><i class="fa fa-check"></i> SUBMIT CONTRACT</button>
                </div>
                {!! Form::close() !!}
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- End modal to submit a contract by legal team -->

    <!-- Modal to ammend a contract by legal team -->
    <div class="modal fade" id="modal_ammend_contract">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                {!! Form::open(['action'=>'ContractController@ammend','method'=>'POST','class'=>'form','enctype'=>'multipart/form-data'])
                !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Ammend Contract</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            {{Form::text('contract_id',$contract->contract_id,['class'=>'form-control hidden','placeholder'=>'The contract Title'])}}
                            {{Form::label('ammended_contract_document', 'Upload Ammended Contract Document (optional)')}}

                            <div class="form-group">
                                {{Form::file('ammended_contract_document',['class'=>'form-control'])}}
                            </div>
                        </div>
                        <div class="col-md-6">
                            {{Form::label('ammended_contract_crf', 'Upload Ammended Contract CRF (optional)')}}

                            <div class="form-group">
                                {{Form::file('ammended_contract_crf',['class'=>'form-control'])}}
                            </div>
                        </div>
                        <div class="col-md-12">
                            {{Form::label('comments', 'Comments *')}}<br>
                            <div class="form-group">
                                {{Form::textarea('comments', '',['class'=>'form-control', 'required', 'placeholder'=>''])}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success pull-left btn-flat" name="reject"><i class="fa fa-close"></i> AMMEND CONTRACT</button>
                </div>
                {!! Form::close() !!}
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- End modal to ammend a contract by legal team -->

    <!-- Modal to terminate a contract by legal team -->
    <div class="modal fade" id="modal_terminate_contract">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                {!! Form::open(['action'=>'ContractController@terminate','method'=>'POST','class'=>'form','enctype'=>'multipart/form-data'])
                !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Terminate Contract</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            {{Form::text('contract_id',$contract->contract_id,['class'=>'form-control hidden','placeholder'=>'The contract Title'])}}
                            {{Form::label('comments', 'Comments *')}}<br>
                            <div class="form-group">
                                {{Form::textarea('comments', '',['class'=>'form-control', 'required', 'placeholder'=>''])}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success pull-left btn-flat" name="reject"><i class="fa fa-close"></i> TERMINATE CONTRACT</button>
                </div>
                {!! Form::close() !!}
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- End modal to terminate a contract by legal team -->

    {{-- Legal admin action modals --}}
    <!-- Modal to approve a contract by legal admin-->
    <div class="modal fade" id="modal_approve_contract">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                {!! Form::open(['action'=>'ContractController@approve','method'=>'POST','class'=>'form','enctype'=>'multipart/form-data'])
                !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Approve Contract</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            {{Form::text('contract_id',$contract->contract_id,['class'=>'form-control hidden','placeholder'=>'The contract Title'])}}
                            {{Form::label('comments', 'Comments (optional)')}}<br>
                            <div class="form-group">
                                {{Form::textarea('comments', '',['class'=>'form-control', 'placeholder'=>'Comments are optional'])}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success pull-left btn-flat" name="approve"><i class="fa fa-check"></i> SUBMIT CONTRACT</button>
                </div>
                {!! Form::close() !!}
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- End modal to approve a contract by legal admin -->

    <!-- Modal to ammend a contract by legal admin -->
    <div class="modal fade" id="modal_admin_ammend_contract">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                {!! Form::open(['action'=>'ContractController@ammend','method'=>'POST','class'=>'form','enctype'=>'multipart/form-data'])
                !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Ammend Contract</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            {{Form::text('contract_id',$contract->contract_id,['class'=>'form-control hidden','placeholder'=>'The contract Title'])}}
                            {{Form::label('ammended_contract_document', 'Upload Ammended Contract Document (optional)')}}

                            <div class="form-group">
                                {{Form::file('ammended_contract_document',['class'=>'form-control'])}}
                            </div>
                        </div>
                        <div class="col-md-6">
                            {{Form::label('ammended_contract_crf', 'Upload Ammended Contract CRF (optional)')}}

                            <div class="form-group">
                                {{Form::file('ammended_contract_crf',['class'=>'form-control'])}}
                            </div>
                        </div>
                        <div class="col-md-12">
                            {{Form::label('comments', 'Comments *')}}<br>
                            <div class="form-group">
                                {{Form::textarea('comments', '',['class'=>'form-control', 'required', 'placeholder'=>''])}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success pull-left btn-flat" name="reject"><i class="fa fa-close"></i> AMMEND CONTRACT</button>
                </div>
                {!! Form::close() !!}
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- End modal to ammend a contract by legal admin -->

    <!-- Modal to terminate a contract by legal admin -->
    <div class="modal fade" id="modal_admin_terminate_contract">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                {!! Form::open(['action'=>'ContractController@terminate','method'=>'POST','class'=>'form','enctype'=>'multipart/form-data'])
                !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Terminate Contract</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            {{Form::text('contract_id',$contract->contract_id,['class'=>'form-control hidden','placeholder'=>'The contract Title'])}}
                            {{Form::label('ammended_contract_document', 'Upload Ammended Contract Document (optional)')}}

                            <div class="form-group">
                                {{Form::file('ammended_contract_document',['class'=>'form-control'])}}
                            </div>
                        </div>
                        <div class="col-md-6">
                            {{Form::label('ammended_contract_crf', 'Upload Ammended Contract CRF (optional)')}}

                            <div class="form-group">
                                {{Form::file('ammended_contract_crf',['class'=>'form-control'])}}
                            </div>
                        </div>
                        <div class="col-md-12">
                            {{Form::label('comments', 'Comments *')}}<br>
                            <div class="form-group">
                                {{Form::textarea('comments', '',['class'=>'form-control', 'required', 'placeholder'=>''])}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success pull-left btn-flat" name="reject"><i class="fa fa-close"></i> TERMINATE CONTRACT</button>
                </div>
                {!! Form::close() !!}
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- End modal to terminate a contract by legal admin -->
    {{-- End legal admin action modals --}}
    <div class="box box-success">
        <section class="invoice">
            <div class="box-header">
                <h3 class="box-title">Contract History</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width:40px">#</th>
                            <th style="width:130px">User</th>
                            <th>Position</th>
                            <th>Date Created</th>
                            <th>Contract Draft</th>
                            <th>CRF</th>
                            <th>
                                <center>Status</center>
                            </th>
                            <th>
                                <center>Stage</center>
                            </th>
                            <th>Comments</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contract_drafts as $key=> $contracts)
                        <tr>
                            <td>{{ $key + 1}}</td>
                            <td>{{ $contracts->name }}</td>
                            <td>{{ $contracts->job_title }}</td>
                            <td>{{ $contracts->contract_drafts_created_at }}</td>
                            <td style="width:120px"> <a href="/{{$contracts->draft_file}}" target="_blank"><i class="fa fa-fw fa-download"></i> Download</a></td>
                            <td style="width:120px"> <a href="/{{$contracts->crf_file}}" target="_blank"><i class="fa fa-fw fa-download"></i> Download</a></td>
                            <td>
                                <center><span class="pull-right-container">
                                    @if($contracts->contract_drafts_status == 'created')
                                        <small class="label pull-center btn-default">{{$contracts->contract_drafts_status}}</small></span>                                    @elseif($contracts->contract_drafts_status== 'published')
                                    <small class="label pull-center btn-info">{{$contracts->contract_drafts_status}}</small></span>
                                    @elseif($contracts->contract_drafts_status== 'submitted')
                                    <small class="label pull-center btn-success">{{ $contracts->contract_drafts_status}}</small></span>
                                    @elseif($contracts->contract_drafts_status== 'approved')
                                    <small class="label pull-center btn-success">{{ $contracts->contract_drafts_status}}</small></span>
                                    @elseif ($contracts->contract_drafts_status== 'ammended')
                                    <small class="label pull-center btn-warning">{{$contracts->contract_drafts_status}}</small></span>
                                </center>
                                @elseif($contracts->contract_drafts_status== 'terminated')
                                <small class="label pull-center btn-danger">{{ $contracts->contract_drafts_status}}</small></span>
                            </td>
                            @endif
                            <td>
                                <center>
                                    @if($contracts->contract_drafts_status== 'archived')
                                    <p class="text-light-primary">archived</p>
                                    @elseif($contracts->contract_drafts_status== 'rejected')
                                    <p class="text-light-primary">oh hold</p>
                                    @else
                                    <p class="text-light-primary">{{ $contracts->task }}</p>
                                    @endif
                                </center>
                            </td>
                            <td><a href="#modal_approve_comments" data-toggle="modal" data-target="#modal_approve_comments"><strong>Comments</strong></a></p>
                            </td>
                        </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
            <!-- Modal to show comments for an approved contract -->
            <div class="modal fade" id="modal_approve_comments">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        {!! Form::open(['class'=>'form']) !!}
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Comments</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    {{Form::label('comments', 'Comments *')}}<br>
                                    <div class="form-group">
                                        {{Form::text('contract_id',$contract->contract_id,['class'=>'form-control hidden','placeholder'=>'The contract Title'])}}
                                        <p>{{ $contracts->comments }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- End modal show comments for an approved contract -->
        </section>
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
                    })
    </script>

@stop
