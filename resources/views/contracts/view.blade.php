@extends('adminlte::page')
@section('title', 'Wananchi Legal | Contract Details')
@section('content_header')
<h1 class="pull-left">Contracts<small><span
            style="font-weight:bold">{{$contract->contract_title}}({{$contract->contract_code}})</span></small></h1>
<div style="clear:both"></div>
@stop
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- Custom Tabs (Pulled to the right) -->
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab-details" data-toggle="tab">Contract Details</a></li>
                <li><a href="#tab-description" data-toggle="tab">Contract Description</a></li>
                <li><a href="#tab-history" data-toggle="tab">Contract History</a></li>
                <li class=""><a href="tab-details" data-toggle="tab">Request CAF</a></li>
                <li class=""><a href="tab-details" data-toggle="tab">Request Further Info</a></li>
                {{-- @if($contract->assigned_user_id == Auth::user()->id) --}}
                    @if(auth()->check())
                           @if(!auth()->user()->isUser() && ($contract->stage=='1') &&($contract->assigned=='0'))
                                 <div class="btn-group pull-right" style="padding:6px;">
                                      <a href="" class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#modal_work_on_contract">Assign to me</a>
                                  </div>
                            @elseif (auth()->user()->isAdmin() && ($contract->contract_status=='Approved'))
                                  <div class="btn-group pull-right" style="padding:6px;">
                                    <a href="#" class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#modal_request_caf">Request CAF</a>
                                </div>
                            @endif
                    @endif
                {{-- @endif --}}
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab-details">
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="box box-success">
                                <div class="box-header">
                                    <h3 class="box-title">Contract Details </h3>
                                    <div class="pull-right box-tools">
                                        <button type="button" class="btn btn-default btn-sm btn-flat"
                                            data-widget="collapse" data-toggle="tooltip" title="Collapse"><i
                                                class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table id="clientTable" class="table no-margin">
                                            <tbody>
                                                <tr>
                                                    <td><b>Ticket No</b></td>
                                                    <td><span
                                                            style="font-weight:bold">{{ $contract->contract_code }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>Contract Title</b></td>
                                                    <td><span
                                                            style="font-weight:bold">{{ $contract->contract_title }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>Contract Type</b></td>
                                                    @if($contract->contract_type_name=='')
                                                    <td>N/A</td>
                                                    @else
                                                    <td><small
                                                            class="badge bg-green">{{$contract->contract_type_name}}</small>
                                                    </td>
                                                    @endif
                                                </tr>
                                                <tr>
                                                    <td><b>Contract Term</b></td>
                                                    <td>{{ $contract->term }}</td>
                                                </tr>
                                                <tr>
                                                    <td><b>Contract Renewal Type</b></td>
                                                    <td>{{ $contract->renewal_type }}</td>
                                                </tr>
                                                <tr>
                                                    <td><b>Contract Status</b></td>
                                                    <td>
                                                        @if($contract->contract_status == '1')
                                                        <small
                                                            class="badge bg-yellow">{{$contract->status_name}}</small></span>
                                                        @elseif($contract->contract_status == '2')
                                                        <small
                                                            class="badge bg-blue">{{$contract->status_name}}</small></span>
                                                        @elseif($contract->contract_status == 'Closed')
                                                        <small
                                                            class="badge bg-aqua">{{$contract->contract_status}}</small></span>
                                                        @elseif($contract->contract_status == 'Amended')
                                                        <small
                                                            class="badge bg-blue">{{$contract->contract_status}}</small></span>
                                                        @elseif($contract->contract_status == 'Terminated')
                                                        <small
                                                            class="badge bg-red">{{$contract->contract_status}}</small></span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>Contract Party</b></td>
                                                    <td><a href="/contract-party/{{$contract->party_id}}/view-contract-party"
                                                            target="_blank">{{ $contract->party_name }}</a></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Legal Nature of Entity</b></td>
                                                    <td>{{ $contract->legal_entity_type }}</td>
                                                </tr>
                                                <tr>
                                                    <td><b>Postal Address</b></td>
                                                    <td>{{ $contract->physical_address }}</td>
                                                </tr>
                                                <tr>
                                                    <td><b>Physical Address</b></td>
                                                    <td>{{ $contract->postal_address }}</td>
                                                </tr>
                                                <tr>
                                                    <td><b>Contact Person</b></td>
                                                    <td>{{ $contract->contact_person }}</td>
                                                </tr>
                                                <tr>
                                                    <td><b>Email Address</b></td>
                                                    <td>{{ $contract->email }}</td>
                                                </tr>
                                                <tr>
                                                    <td><b>Phone Number</b></td>
                                                    <td>{{ $contract->telephone }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-6">
                            <div class="box box-success">
                                <div class="box-header">
                                    <h3 class="box-title">People </h3>
                                    <div class="pull-right box-tools">
                                        <button type="button" class="btn btn-default btn-sm btn-flat"
                                            data-widget="collapse" data-toggle="tooltip" title="Collapse"><i
                                                class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table id="clientTable" class="table no-margin">
                                            <tr>
                                                <td><b>Assignee</b></td>
                                                @if($contract->assigned=='')
                                                <td>Not assigned</td>
                                                @elseif($contract->assigned_user_id==Auth::user()->id)
                                                <td>Me</td>
                                                @else
                                                <td>{{ $contract->name }}</td>
                                                @endif
                                                @if(auth()->check()) @if(!auth()->user()->isUser())
                                                <td><a href="" data-toggle="modal"
                                                        data-target="#modal_assign_contract">Assign someone else</a>
                                                </td>
                                                @endif @endif
                                            </tr>
                                            @if(auth()->check()) @if(!auth()->user()->isUser())
                                            <tr>
                                                <td><b>Creator</b></td>
                                                <td>{{$created_user->name}}</td>
                                            </tr>
                                            @endif @endif
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="box box-success">
                                <div class="box-header">
                                    <h3 class="box-title">Dates</h3>
                                    <div class="pull-right box-tools">
                                        <button type="button" class="btn btn-default btn-sm btn-flat"
                                            data-widget="collapse" data-toggle="tooltip" title="Collapse"><i
                                                class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table id="clientTable" class="table no-margin">
                                            <tr>
                                                <td><b>Created</b></td>
                                                <td>{{ $contract->created_date }}</td>

                                                <td><b>Submitted</b></td>
                                                @if(empty($date_submitted->date))
                                                <td>N/A</td>
                                                @else
                                                <td>{{ $date_submitted->date }}</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td><b>Approved</b></td>
                                                @if (empty($date_approved->date))
                                                <td>N/A</td>
                                                @else
                                                <td>{{ $date_approved->date }}</td>
                                                @endif

                                                <td><b>Closed</b></td>
                                                @if(empty($date_closed->date))
                                                <td>N/A</td>
                                                @else
                                                <td>{{ $date_closed->date}}</td>
                                                @endif
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="box box-success">
                                <div class="box-header">
                                    <h3 class="box-title">Contract Document & CAF Document</h3>
                                    <div class="pull-right box-tools">
                                        <button type="button" class="btn btn-default btn-sm btn-flat"
                                            data-widget="collapse" data-toggle="tooltip" title="Collapse"><i
                                                class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table id="clientTable" class="table no-margin">
                                            <tr>
                                                <a href="/{{$last_draft_contract_section->draft_file}}" class="btn btn-primary" style="margin-right:78px"
                                                    target="_blank"><i class="fa fa-fw fa-download"></i>
                                                    @if($contract->stage =='1')
                                                             Contract Draft
                                                    @elseif($contract->stage =='2')
                                                             Reviewed Contract
                                                    @elseif($contract->stage =='3')
                                                             Final Draft
                                                    @elseif($contract->stage =='4' || '5')
                                                    Final Execution
                                                    @endif
                                                </a>

                                                @if($contract->stage =='5')
                                                <a href="/{{$caf_form->crf_form}}" class="btn btn-primary" style="margin-right:128px"
                                                    target="_blank"><i class="fa fa-fw fa-download"></i>CAF Document
                                                </a>
                                                @endif

                                                  @if(auth()->check())
                                                         @if(auth()->user()->isUser() && ($contract->stage=='2') && ($contract->user_comments ==''))
                                                             <a href="" data-toggle="modal" data-target="#modal_user_comment">Comment on the reviewed draft</a>
                                                         @elseif(auth()->user()->isUser() && ($contract->stage=='3') && ($contract->user_comments ==''))
                                                             <a href="" data-toggle="modal" data-target="#modal_user_comment_final">Comment on the final draft</a>
                                                         @elseif(auth()->user()->isUser() && ($contract->stage=='4'))
                                                             <a href="" data-toggle="modal" data-target="#modal_upload_caf">Upload CAF Document</a>


                                                         @elseif(!auth()->user()->isUser() && ($contract->contract_status=='2') && ($contract->user_comments !=''))
                                                             <a href="" data-toggle="modal" data-target="#modal_view_user_comment">View user comments</a>
                                                         @elseif(!auth()->user()->isUser() && ($contract->contract_status=='3') && ($contract->user_comments !=''))
                                                             <a href="" data-toggle="modal" data-target="#modal_view_user_comment">View user comments</a>
                                                        @endif
                                                   @endif

                                            </tr>

                                            {{-- <tr>
                                                @if($last_draft_contract_section->crf_form =='') @else
                                                <a href="/{{$last_draft_contract_section->crf_form}}"
                                                    class="btn btn-primary" target="_blank"><i
                                                        class="fa fa-fw fa-download"></i> CAF Document</a> @endif
                                            </tr> --}}
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row no-print">
                        <div class="col-xs-12">
                            @if(auth()->check())
                                @if(!auth()->user()->isUser() && ($contract->stage=='1') && ($contract->assigned_user_id == Auth::user()->id))
                                     <a href="#" data-target="#modal_share_reviewed_contract" data-toggle="modal" class="btn btn-primary">
                                     <i class="fa fa-check"></i> Share Reviewed Contract </a>
                                @elseif(!auth()->user()->isUser() && ($contract->stage=='2'))
                                      <a href="#" data-target="#modal_share_final_draft" data-toggle="modal" class="btn btn-primary">
                                      <i class="fa fa-check"></i> Share Final Draft </a>
                                @elseif(!auth()->user()->isUser() && ($contract->stage=='3'))
                                <a href="#" data-target="#modal_share_final_execution" data-toggle="modal" class="btn btn-primary">
                                    <i class="fa fa-check"></i> Share Final Execution Version </a>
                                @endif
                            @endif











                            @if(auth()->check())
                            @if(auth()->user()->isUser() && ($contract->contract_status=='Created'))
                            <a href="#" data-target="#modal_submit_contract" data-toggle="modal" class="btn btn-primary">
                                <i class="fa fa-check"></i> Submit Contract </a>
                            @elseif(auth()->user()->isLegal() && ($contract->contract_status=='Pending') &&
                            ($contract->assigned_user_id== Auth::user()->id))
                            <a href="#modal_approve_contract" data-toggle="modal" data-target="#modal_approve_contract"
                                class="btn btn-primary"><i class="fa fa-check"></i> Approve Contract</a>
                            <a href="#modal_ammend_contract" data-toggle="modal" data-target="#modal_ammend_contract"
                                class="btn btn-info"><i class="fa fa-refresh"></i> Reviewed Contract</a>
                            <a href="#modal_terminate_contract" data-toggle="modal"
                                data-target="#modal_terminate_contract" class="btn btn-danger"><i
                                    class="fa fa-close"></i> Terminate Contract</a>
                            @elseif(auth()->user()->isAdmin() && ($contract->contract_status=='Pending'))
                            <a href="#modal_approve_contract" data-toggle="modal" data-target="#modal_approve_contract"
                                class="btn btn-primary"><i class="fa fa-check"></i> Approve Contract</a>
                            <a href="#modal_ammend_contract" data-toggle="modal" data-target="#modal_ammend_contract"
                                class="btn btn-info"><i class="fa fa-refresh"></i> Reviewed Contract</a>
                            <a href="#modal_terminate_contract" data-toggle="modal"
                                data-target="#modal_terminate_contract" class="btn btn-danger">
                                <i class="fa fa-close"></i> Terminate Contract</a>
                            @elseif(auth()->user()->isUser() && ($contract->contract_status=='Pending'))
                            <p class="col-md-6 text-blue well well-sm no-shadow" style="margin-top: 10px;">
                                Contract submitted awaiting action by the legal department</p>
                            @elseif(auth()->user()->isUser() && ($contract->contract_status=='Approved'))
                            <a href="#" data-toggle="modal" data-target="#modal_upload_signed_contract"
                                class="btn btn-primary"><i class="fa fa-check"></i> Upload Signed Contract</a>
                            @elseif(!auth()->user()->isUser() && ($contract->contract_status=='Approved'))
                            <p class="col-md-6 text-blue well well-sm no-shadow" style="margin-top: 10px;">
                                Contract approved for signature awaiting action by the user</p>
                            @elseif(!auth()->user()->isUser() && ($contract->contract_status=='Closed') &&
                            ($contract->signed_contract_file == ''))
                            <a href="" data-backdrop="static" data-toggle="modal" data-target="#modal_archive_contract"
                                class="btn btn-primary"><i class="fa fa-file-archive-o"></i> Archive Contract</a>
                            @elseif(auth()->user()->isUser() && ($contract->contract_status=='Closed') &&
                            ($contract->signed_contract_file == ''))
                            <p class="col-md-6 text-blue well well-sm no-shadow" style="margin-top: 10px;">
                                Contract closed
                            </p>
                            @endif
                            @endif
                        </div>
                    </div>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane " id="tab-description">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-success">
                                <div class="box-body">
                                    <div class="col-md-12">
                                        {{Form::label('description', 'Contract Description')}}
                                        <div class="form-group">
                                            {{Form::textarea('description', $contract->description,['class'=>'form-control description','placeholder'=>'Contract description'])}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="tab-pane " id="tab-history">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-success">
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
                                                    <td>{{ $contracts->contract_drafts_created_at }}</td>
                                                    <td style="width:120px"> <a href="/{{$contracts->draft_file}}"
                                                            target="_blank"><i class="fa fa-fw fa-download"></i>
                                                            Download</a></td>
                                                    @if($contracts->crf_form =='')
                                                    <td style="width:120px"> <a href="#"> No CRF Document</a></td>
                                                    @else
                                                    <td style="width:120px"> <a href="/{{$contracts->crf_form}}"
                                                            target="_blank"><i class="fa fa-fw fa-download"></i>
                                                            Download</a></td>
                                                    @endif
                                                    <td>
                                                        <center><span class="pull-right-container">
                                                           @if($contracts->stage_id== '1')
                                                            <small
                                                                class="badge bg-yellow">{{$contracts->stage_name}}</small></span>
                                                            @elseif($contracts->stage_id== '2')
                                                            <small
                                                                class="badge bg-blue">{{ $contracts->stage_name}}</small></span>
                                                            @elseif($contracts->stage_id== '3')
                                                            <small
                                                                class="badge bg-aqua">{{ $contracts->stage_name}}</small></span>
                                                            @elseif ($contracts->stage_id== '4')
                                                            <small
                                                                class="badge bg-purple">{{$contracts->stage_name}}</small></span>
                                                            @elseif($contracts->contract_drafts_status== 'Terminated')
                                                            <small
                                                                class="badge bg-red">{{ $contracts->contract_drafts_status}}</small></span>
                                                        </center>
                                                    </td>
                                                    @endif
                                                    <td><a href="#modal_show_action_comments" data-toggle="modal"
                                                            data-target="#modal_show_action_comments_{{ $contracts->contract_draft_id  }}"><strong>
                                                                <center>View</center>
                                                            </strong></a></p>
                                                    </td>
                                                </tr>
                                                <!-- Modal to show comments for an approved contract -->
                                                <div class="modal fade"
                                                    id="modal_show_action_comments_{{ $contracts->contract_draft_id }}">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            {!! Form::open(['class'=>'form']) !!}
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
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
                                </div>
                            </div>
                        </div>
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- nav-tabs-custom -->
        </div>
        <!-- /.col -->
    </div>
    @include('contracts.modals.modal_share_reviewed_contract')
    @include('contracts.modals.modal_user_comment')
    {{-- @include('contracts.modals.modal_view_user_comment') --}}
    @include('contracts.modals.modal_share_final_draft')
    @include('contracts.modals.modal_user_comment_final')
    {{-- @include('contracts.modals.modal_view_user_comment') --}}
    @include('contracts.modals.modal_share_final_execution')
    @include('contracts.modals.modal_upload_caf')






    @include('contracts.modals.modal_submit_contract')
    @include('contracts.modals.modal_assign_contract')
    @include('contracts.modals.modal_work_on_contract')
    @include('contracts.modals.modal_approve_contract')
    @include('contracts.modals.modal_request_caf')
    @include('contracts.modals.modal_upload_signed_contract')
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
            $(".select2").select2();
            $('#example1').DataTable()
            //iCheck for checkbox and radio inputs
            $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass   : 'iradio_flat-green'
            })
         })
    </script>
    @stop
