@extends('adminlte::page')
@section('title', 'Contract Details')
@section('content_header')
<h1 class="pull-left">Contracts<small>View Contract</small></h1>

<div class="pull-right"><a class="btn btn-primary btn-sm btn-flat" href="/contract/create"><i class="fa fa-plus"></i> New Contract</a></div>
<div style="clear:both"></div>
@stop
@section('content')
<style>
    .description {
        height: 90px !important
    }
</style>
<div class="box box-success" style="font-size:12px" ;>
    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header" style="font-weight:bold">
                    Contract Title: {{ $contract->contract_title }}
                    <small class="pull-right" style="font-weight:bold">Ticket Number: # {{ $contract->contract_code }}</small>
                </h2>
            </div>
        </div>
        <div class="invoice-info">
            <!-- Contract Details row -->
            {!! Form::open(['action'=>['ContractController@publish', $contract->contract_id],'method'=>'POST','class'=>'form','enctype'=>'multipart/form-data'])
            !!}
            <div class="row">
                <div class="col-md-6">
                    {{Form::text('contract_id',$contract->contract_id,['class'=>'form-control hidden','placeholder'=>'The contract Title'])}}
                    {{Form::label('title', 'Contract Title ')}}
                    <div class="form-group">
                        <h6>{{ $contract->contract_title }}</h6>
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
                        @if($contract->expiry_date =='')
                        <h4>N/A</h4>
                        @else {{ $contract->expiry_date }} @endif
                    </div>
                </div>
                <div class="col-md-3">
                    {{Form::label('contract_status', 'Contract Status')}}
                    <div class="form-group">
                        <span class="pull-right-container">
                         @if($contract->contract_status == 'Created')
                        <small class="badge bg-purple">{{$contract->contract_status}}</small></span>
                        @elseif($contract->contract_status == 'Pending')
                        <small class="badge bg-yellow">{{$contract->contract_status}}</small></span>
                        @elseif($contract->contract_status == 'Approved')
                        <small class="badge bg-green">{{$contract->contract_status}}</small></span>
                        @elseif($contract->contract_status == 'Closed')
                        <small class="badge bg-aqua">{{$contract->contract_status}}</small></span>
                        @elseif($contract->contract_status == 'Amended')
                        <small class="badge bg-blue">{{$contract->contract_status}}</small></span>
                        @elseif($contract->contract_status == 'Terminated')
                        <small class="badge bg-red">{{$contract->contract_status}}</small></span>
                        @endif
                    </div>
                </div>
                <div class="col-md-12">
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
                    @if (auth()->check()) @if($contract->contract_status=='Created' && (auth()->user()->isLegal() || auth()->user()->isAdmin()))
                {!! Form::open(['action'=>['ContractController@publish',$contract->contract_id],'method'=>'POST','class'=>'floatit',
                    'enctype'=>'multipart/form-data'])!!}
                    <a href="#modal_publish_contract" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#modal_publish_contract"
                        class="btn btn-success">
                                                <i class="fa fa-check"></i> Publish Contract</a> @elseif(auth()->user()->isUser()
                    && ($contract->contract_status=='Created' && $contract->created_by== Auth::user()->id)) {{--
                    <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Publish Contract</button> --}}
                    {!! Form::open(['action'=>['ContractController@publish',$contract->contract_id],'method'=>'POST','class'=>'floatit',
                    'enctype'=>'multipart/form-data'])!!}
                    <a href="#modal_publish_contract" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#modal_publish_contract"
                        class="btn btn-success">
                                                                    <i class="fa fa-check"></i> Publish Contract</a> @endif @endif @if (auth()->check()) @if( $contract->contract_status =='Pending' && auth()->user()->isUser())
                    <p class="col-md-6 text-green well well-sm no-shadow" style="margin-top: 10px;">
                        The contract has been submitted for review by the legal team</p>

                    @endif @endif @if (auth()->check()) @if($contract->contract_status=='Pending' && $contract->assigned== '1' && (auth()->user()->isAdmin()))
                    <a href="#modal_approve_contract" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#modal_approve_contract"
                        class="btn btn-success"><i class="fa fa-check"></i> Approve Contract</a>

                    <a href="#modal_ammend_contract" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#modal_ammend_contract"
                        class="btn btn-info"><i class="fa fa-refresh"></i> Ammend Contract</a>

                    <a href="#modal_terminate_contract" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#modal_terminate_contract"
                        class="btn btn-danger"><i class="fa fa-close"></i> Terminate Contract</a> @elseif($contract->contract_status=='Pending'
                    && $contract->assigned== '1' && $contract->assigned_user_id== Auth::user()->id && (auth()->user()->isLegal()))
                    <a href="#modal_approve_contract" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#modal_approve_contract"
                        class="btn btn-success"><i class="fa fa-check"></i> Approve Contract</a>

                    <a href="#modal_ammend_contract" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#modal_ammend_contract"
                        class="btn btn-info"><i class="fa fa-refresh"></i> Ammend Contract</a>

                    <a href="#modal_terminate_contract" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#modal_terminate_contract"
                        class="btn btn-danger"><i class="fa fa-close"></i> Terminate Contract</a> @elseif($contract->contract_status=='Pending'
                    && $contract->assigned== '1' && $contract->assigned_user_id != Auth::user()->id && (auth()->user()->isLegal()))
                    <p class="col-md-6 text-red well well-sm no-shadow" style="margin-top: 10px;">
                        This contract has already been taken by another legal counsel member
                    </p>

                    @elseif($contract->contract_status=='Pending' && $contract->assigned=='' && (auth()->user()->isLegal())) {!! Form::open(['action'=>['ContractController@workonContract',$contract->contract_id],'method'=>'POST','class'=>'floatit',
                    'enctype'=>'multipart/form-data'])!!}
                    <a href="#modal_work_on" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#modal_work_on" class="btn btn-success">
                                                <i class="fa fa-check"></i> Work on Contract</a> @elseif($contract->contract_status=='Pending'
                    && $contract->assigned=='' && (auth()->user()->isAdmin())) {!! Form::open(['action'=>['ContractController@assignContract',$contract->contract_id],'method'=>'POST','class'=>'floatit',
                    'enctype'=>'multipart/form-data'])!!}
                    <a href="#modal_assign_contract" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#modal_assign_contract"
                        class="btn btn-info"><i class="fa fa-check"></i> Assign Contract</a> {!! Form::open(['action'=>['ContractController@workonContract',$contract->contract_id],'method'=>'POST','class'=>'floatit',
                    'enctype'=>'multipart/form-data'])!!}
                    <a href="#modal_work_on" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#modal_work_on" class="btn btn-success"><i class="fa fa-check"></i> Work on Contract</a>                    @endif @endif @if (auth()->check()) @if($contract->contract_status =='Amended' && (auth()->user()->isLegal()
                    || auth()->user()->isAdmin()) && $contract->created_by != Auth::user()->id)
                    <p class="col-md-6 text-red well well-sm no-shadow" style="margin-top: 10px;">
                        This contract has been amended waiting for the action by the contract party
                    </p>
                    @endif @endif @if (auth()->check()) @if($contract->contract_status =='Amended' && (auth()->user()->isLegal() || auth()->user()->isAdmin())
                    && $contract->created_by == Auth::user()->id)
                    <a href="/contract/{{$contract->contract_id}}/edit" class="btn btn-success"><i class="fa fa-check"></i> Approve Changes</a>                    @endif @endif @if (auth()->check()) @if($contract->contract_status =='Amended' && (auth()->user()->isUser()))
                    <a href="/contract/{{$contract->contract_id}}/edit" class="btn btn-success"><i class="fa fa-check"></i> Approve Changes</a>                    {{-- <a href="#modal_approve_changes" data-toggle="modal" data-target="#modal_approve_changes" class="btn btn-success">
                                                        <i class="fa fa-check"></i> APPROVE CHANGES</a>
                    <a href="#modal_reject_changes" data-toggle="modal" data-target="#modal_reject_changes" class="btn btn-danger">
                                                        <i class="fa fa-close"></i> REJECT CHANGES</a>                    --}} @endif @endif @if (auth()->check()) @if($contract->contract_status =='Approved' && (auth()->user()->isAdmin()
                    || auth()->user()->isLegal()) && $contract->created_by != Auth::user()->id)

                    <p class="col-md-6 text-blue well well-sm no-shadow" style="margin-top: 10px;">
                        Contract approved and awaiting upload of signed contract
                    </p>
                    @endif @endif @if (auth()->check()) @if($contract->contract_status =='Closed' && $contract->signed_contract_file == '' &&
                    (auth()->user()->isAdmin() || auth()->user()->isLegal()))
                    <a href="#modal_archive_contract" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#modal_archive_contract"
                        class="btn btn-success"><i class="fa fa-file-archive-o"></i>  Archive Contract</a>@endif @endif @if (auth()->check()) @if($contract->contract_status =='Closed' && (auth()->user()->isUser()))

                    <p class="col-md-6 text-blue well well-sm no-shadow" style="margin-top: 10px;">
                        Contract closed
                    </p>
                     @endif @endif @if (auth()->check()) @if($contract->signed_contract_file !='' && (auth()->user()->isAdmin()
                    || auth()->user()->isLegal()))

                    <p class="col-md-6 text-blue well well-sm no-shadow" style="margin-top: 10px;">
                        Contract closed
                    </p> @endif @endif @if (auth()->check()) @if($contract->contract_status =='Approved' && (auth()->user()->isUser()
                    || $contract->created_by == Auth::user()->id))
                    <a href="#modal_upload_signed_contract" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#modal_upload_signed_contract"
                        class="btn btn-success"><i class="fa fa-check"></i> Upload Signed Contract</a> @endif
                    @endif @if($contract->contract_status =='Terminated')
                    <p class="col-md-6 text-red well well-sm no-shadow" style="margin-top: 10px;">
                        This contract has been terminated and the contract party has neen notified
                    </p>
                    @endif @if($last_draft_contract_section->crf_form =='') @else
                    <a href="/{{$last_draft_contract_section->crf_form}}" class="btn btn-primary pull-right" style="margin-right: 10px;" target="_blank"><i class="fa fa-fw fa-download"></i> CRF Document</a>                    @endif

                    <a href="/{{$last_draft_contract_section->draft_file}}" class="btn btn-primary pull-right" style="margin-right: 10px;" target="_blank"><i class="fa fa-fw fa-download"></i>@if($contract->contract_status =='Closed') Signed Contract Document @else Latest Contract Document @endif</a>{!!
                    Form::close() !!}

                </div>
            </div>
    </section>
    <!-- Modal publish contract by legal team/legal admin/standard user -->
    <div class="modal fade" id="modal_publish_contract">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(['action'=>'ContractController@publish','method'=>'POST','class'=>'form','enctype'=>'multipart/form-data'])
                !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Publish Contract</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            {{Form::text('contract_id',$contract->contract_id,['class'=>'form-control hidden','placeholder'=>'The contract Title'])}}
                            <p>Are you sure you want to publish the contract?</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                    <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-check"></i> Publish Contract</button>
                </div>
                {!! Form::close() !!}
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- End modal to confirm working on a contract by legal team/ legal admin -->
    <!-- Modal to confirm working on a contract by legal team/legal admin -->
    <div class="modal fade" id="modal_work_on">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(['action'=>'ContractController@workonContract','method'=>'POST','class'=>'form','enctype'=>'multipart/form-data'])
                !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Work On The Contract</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            {{Form::text('contract_id',$contract->contract_id,['class'=>'form-control hidden','placeholder'=>'The contract Title'])}}
                            <p>Are you sure you want to work on the contract?</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                    <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-check"></i> Work on Contract</button>
                </div>
                {!! Form::close() !!}
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- End modal to confirm working on a contract by legal team/ legal admin -->
    <!-- Modal to assign a contract by legal team/legal admin -->
    <div class="modal fade" id="modal_assign_contract">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(['action'=>'ContractController@assignContract','method'=>'POST','class'=>'form','enctype'=>'multipart/form-data'])
                !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Assign Contract To Legal Counsel Member</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            {{Form::text('contract_id',$contract->contract_id,['class'=>'form-control hidden','placeholder'=>'The contract Title'])}}
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{Form::label('id', 'Legal Team Member')}}<br> {{ Form::select('id',$legal_team,null,
                                    ['class' => 'form-control select2', 'required', 'placeholder'=>'Select Legal Team Member'])
                                    }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                    <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-check"></i> Assign Contract</button>
                    <script type="text/javascript">
                        $(".select2").select2();
                    </script>
                </div>
                {!! Form::close() !!}
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- End modal to assign a contract by legal team/ legal admin -->
    <!-- Modal to approve a contract by legal team/legal admin -->
    <div class="modal fade" id="modal_approve_contract">
        <div class="modal-dialog">
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
                            <div class="form-group" required=''>
                                <h>Classify the contract</h><br/><br/>
                                <label><input type="radio" name="contract_type" value="1" required class="flat-red" >&nbsp;&nbsp; Standard</label>&nbsp;&nbsp;
                                <label><input type="radio" name="contract_type" value="2" class="flat-red">&nbsp;&nbsp; Non Standard</label>
                            </div>
                            {{Form::label('comments', 'Comments (optional)')}}<br>
                            <div class="form-group">
                                {{Form::textarea('comments', '',['class'=>'form-control', 'placeholder'=>'Comments are optional'])}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                    <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-check"></i> Approve Contract</button>
                </div>
                {!! Form::close() !!}
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- End modal to approve a contract by legal team/ legal admin -->

    <!-- Modal to upload signed contract by legal team/legal admin -->
    <div class="modal fade" id="modal_upload_signed_contract">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(['action'=>'ContractController@uploadSignedContract','method'=>'POST','class'=>'form','enctype'=>'multipart/form-data'])
                !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Upload Signed Contract(Signed by contracting party and initiating department)</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            {{Form::text('contract_id',$contract->contract_id,['class'=>'form-control hidden','placeholder'=>'The contract Title'])}}
                            <div class="col-md-12">
                                {{Form::label('signed_contract', 'Upload Signed Contract *')}}
                                <div class="form-group">
                                    {{ Form::file('signed_contract',['class'=>'form-control', 'required', 'accept'=>'.doc , .docx , .pdf'])}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                    <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-check"></i> Upload Signed Contract</button>
                </div>
                {!! Form::close() !!}
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- End modal to upload signed contract by legal team/ legal admin -->

    <!-- Modal to archive a contract by legal team/legal admin -->
    <div class="modal fade" id="modal_archive_contract">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(['action'=>'ContractController@archiveContract','method'=>'POST','class'=>'form','enctype'=>'multipart/form-data'])
                !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Archive Contract</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            {{Form::text('contract_id',$contract->contract_id,['class'=>'form-control hidden','placeholder'=>'The contract Title'])}}
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{Form::label('cabinet_id', 'Cabinet Number (Optional)')}}<br> {{ Form::select('cabinet_id',$cabinet_number,null,
                                    ['class' => 'form-control select2','placeholder'=>'Select Cabinet Number']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                    <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-check"></i> Archive Contract</button>
                    <script type="text/javascript">
                        $(".select2").select2();
                    </script>
                </div>
                {!! Form::close() !!}
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- End modal to archive a contract by legal team/ legal admin -->

    <!-- Modal to ammend a contract by legal team -->
    <div class="modal fade" id="modal_ammend_contract">
        <div class="modal-dialog">
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
                        <div class="col-md-12">
                            {{Form::text('contract_id',$contract->contract_id,['class'=>'form-control hidden','placeholder'=>'The contract Title'])}}
                            {{Form::label('ammended_contract_document', 'Upload Amended Contract Document (optional)')}}

                            <div class="form-group">
                                {{Form::file('ammended_contract_document',['class'=>'form-control'])}}
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
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                    <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-check"></i> Ammend Contract</button>
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
        <div class="modal-dialog">
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
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                    <button type="submit" class="btn btn-danger btn-flat"><i class="fa fa-check"></i> Terminate Contract</button>
                </div>
                {!! Form::close() !!}
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- End modal to terminate a contract by legal team -->
    {{-- End legal dept/admin action modals --}}
    <div class="box box-success">
        <section class="invoice">
            <div class="box-header">
                <h3 class="box-title">Contract History</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                    <table id="example1" class="table no-margin">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>User</th>
                                <th>Date</th>
                                <th>Contract Draft</th>
                                <th style="width:120px">CRF Document</th>
                                <th>
                                    <center>Status</center>
                                </th>
                                <th>Comments</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contract_drafts as $key=> $contracts)
                            <tr>
                                <td>{{ $key + 1}}</td>
                                <td>{{ $contracts->name }}</td>
                                <td>{{ $contracts->contract_drafts_created_at }}</td>
                                <td style="width:120px"> <a href="/{{$contracts->draft_file}}" target="_blank"><i class="fa fa-fw fa-download"></i> Download</a></td>
                                @if($contracts->crf_form =='')
                                <td style="width:120px"> <a href="#"> No CRF Document</a></td>
                                @else
                                <td style="width:120px"> <a href="/{{$contracts->crf_form}}" target="_blank"><i class="fa fa-fw fa-download"></i> Download</a></td>
                                @endif
                                <td>
                                    <center><span class="pull-right-container">
                                    @if($contracts->contract_drafts_status == 'Created')
                                    <small class="badge bg-purple">{{$contracts->contract_drafts_status}}</small></span>
                                    @elseif($contracts->contract_drafts_status== 'Pending')
                                        <small class="badge bg-yellow">{{$contracts->contract_drafts_status}}</small></span>
                                        @elseif($contracts->contract_drafts_status== 'Approved')
                                        <small class="badge bg-green">{{ $contracts->contract_drafts_status}}</small></span>
                                        @elseif($contracts->contract_drafts_status== 'Closed')
                                        <small class="badge bg-aqua">{{ $contracts->contract_drafts_status}}</small></span>
                                        @elseif ($contracts->contract_drafts_status== 'Amended')
                                        <small class="badge bg-blue">{{$contracts->contract_drafts_status}}</small></span>
                                        @elseif($contracts->contract_drafts_status== 'Terminated')
                                        <small class="badge bg-red">{{ $contracts->contract_drafts_status}}</small></span>
                                    </center>
                                </td>
                                @endif
                                <td><a href="#modal_show_action_comments" data-toggle="modal" data-target="#modal_show_action_comments_{{ $contracts->contract_draft_id  }}"><strong><center>View</center></strong></a></p>
                                </td>
                            </tr>
                            <!-- Modal to show comments for an approved contract -->
                            <div class="modal fade" id="modal_show_action_comments_{{ $contracts->contract_draft_id }}">
                                <div class="modal-dialog">
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
                                                    <div class="form-group">
                                                        {{Form::text('contract_id',$contracts->contract_id,['class'=>'form-control hidden','placeholder'=>'The contract Title'])}}
                                                        @if($contracts->comments == '')
                                                        <p>No comments left for this action...</p>
                                                        @else
                                                        <p>{{$contracts->comments}}</p>
                                                        @endif
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
                            @endforeach
                        </tbody>
                    </table>
                </div>
        </section>

        </div>
    </div>
@stop
@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="/iCheck/all.css">
@stop
@section('js')
    <script src="/js/bootstrap-datepicker.min.js"></script>
    <script src="/iCheck/icheck.min.js"></script>
    <script>
        $(function () {
            // $(".select2").select2();
            $('#example1').DataTable()
            //iCheck for checkbox and radio inputs
            $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass   : 'iradio_flat-green'
            })
         })
    </script>
@stop
