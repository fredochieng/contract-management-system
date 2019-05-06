@extends('adminlte::page')
@section('title', 'CMS | My Assigned Contracts')
@section('content_header')
<h1 class="pull-left">Contracts<small>My Assigned Contracts</small></h1>
@if(auth()->check()) @if(auth()->user()->isUser())
<div class="pull-right"><a class="btn btn-primary btn-sm btn-flat" href="/contract/create"><i class="fa fa-plus"></i> New Contract</a></div>
@endif @endif
<div style="clear:both"></div>
@stop
@section('content')
<style>
    .description {
        height: 90px !important
    }
</style>
@if (session('update'))
<div class="alert alert-success alert-dismissable custom-success-box" style="margin: 15px;">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong> {{ session('update') }} </strong>
</div>
@endif @if (auth()->check()) @if(auth()->user()->isAdmin() || auth()->user()->isLegal())
<div class="row" style="font-size:12px;">
    <div class="col-md-12">
        <!-- Custom Tabs (Pulled to the right) -->
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#my-assigned-contracts" data-toggle="tab">My Asigned Contracts</a></li>
                <li><a href="#approved-by-me-contracts" data-toggle="tab">Transferred Contracts</a></li>
                <div class="btn-group pull-right" style="padding:6px;">
                    <a class="btn btn-info btn-sm btn-flat" href="/contract/create"><i class="fa fa-plus"></i> New Contract</a>
                </div>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="my-assigned-contracts">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-success">
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table id="example1" class="table no-margin">
                                            <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Ticket #</th>
                                                    <th>Contract Title</th>
                                                    <th>Party Name</th>
                                                    <th>Effective Date</th>
                                                    <th>Expiry Date</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($assigned_contracts as $key=>$assigned_contract)
                                                <tr>
                                                    <td>{{ $key+1}}</td>
                                                    <td><a href="/contract/{{$assigned_contract->contract_id}}/view">{{$assigned_contract->contract_code}}</a></td>
                                                    <td><a href="/contract/{{$assigned_contract->contract_id}}/view">{{$assigned_contract->contract_title}}</a></td>
                                                    <td><a href="/contract-party/{{$assigned_contract->party_id}}/view-contract-party"
                                                            target="_blank">
                                                       <span class="label" style="background-color:#FFF;color:#0073b7;border:1px solid #0073b7;">
                                                       <i class="fa fa-briefcase fa-fw"></i> {{$assigned_contract->party_name}}	</a></span>
                                                    </td>

                                                    <td>{{date("d-m-Y",strtotime($assigned_contract->effective_date))}}</td>
                                                    @if($assigned_contract->expiry_date == '')
                                                    <td>N/A</td>
                                                    @else
                                                    <td>{{date("d-m-Y",strtotime($assigned_contract->expiry_date))}}</td>
                                                    @endif
                                                    <td><span class="pull-right-container">
                                                        @if($assigned_contract->contract_status == 'Created')
                                                        <small class="label pull-center btn-warning">{{$assigned_contract->contract_status}}</small></span>
                                                        @elseif($assigned_contract->contract_status == 'Pending')
                                                        <small class="label pull-center btn-info">{{ $assigned_contract->contract_status}}</small></span>
                                                        @elseif($assigned_contract->contract_status== 'Closed')
                                                        <small class="label label-default">{{$assigned_contract->contract_status}}</small></span>
                                                        @elseif($assigned_contract->contract_status== 'Amended')
                                                        <small class="label pull-center btn-danger">{{$assigned_contract->contract_status}}</small></span>
                                                        @elseif($assigned_contract->contract_status== 'Approved')
                                                        <small class="label pull-center btn-success">{{$assigned_contract->contract_status}}</small></span>
                                                        @elseif($assigned_contract->contract_status== 'Terminated')
                                                        <small class="label pull-center btn-danger">{{$assigned_contract->contract_status}}</small></span>
                                                    </td>
                                                    @endif
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-block btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Actions<span class="caret"></span><span class="sr-only">Toggle Dropdown</span>
                                                                                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                                                <li><a href="/contract/{{$assigned_contract->contract_id}}/view"
                                                                        class="view-contract"><i class="fa fa-eye"></i> View</a></li>
                                                                <li>
                                                                    <a href="#modal_transfer_contract" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#modal_transfer_contract"
                                                                        class="delete-product"><i class="fa fa-refresh"></i>  Transfer</a></li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                    {!! Form::close() !!}
                                                </tr>
                                                <!-- Modal transfer contract by legal team/legal admin -->
                                                <div class="modal fade" id="modal_transfer_contract">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            {!! Form::open(['action'=>'ContractController@transferContract','method'=>'POST','class'=>'form','enctype'=>'multipart/form-data'])
                                                            !!}
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                                                    <span aria-hidden="true">&times;</span></button>
                                                                <h4 class="modal-title">Transfer Contract To Another Legal Counsel Member</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        {{Form::text('contract_id',$assigned_contract->contract_id,['class'=>'form-control hidden','placeholder'=>'The contract Title'])}}
                                                                        <div class="col-md-12">
                                                                            <div class="form-group">
                                                                                {{Form::label('id', 'Legal Team Member')}}<br>                                                                                {{ Form::select('id',$legal_team,null, ['class'
                                                                                => 'form-control select2','placeholder'=>'--Select
                                                                                Legal Team Member--']) }}
                                                                            </div>

                                                                            {{Form::label('comments', 'Comments (optional)')}}<br>
                                                                            <div class="form-group">
                                                                                {{Form::textarea('comments', '',['class'=>'form-control', 'placeholder'=>'Comments are optional'])}}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                                                                <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-check"></i> Transfer Contract</button>
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
                                                <!-- End modal transfer contract by legal team/ legal admin -->
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="approved-by-me-contracts">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-success">
                                <div class="box-body">
                                    <div class="table-responsive">
                                        // Transferec Contracts Table Here
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
        </div>
        <!-- nav-tabs-custom -->
    </div>
    <!-- /.col -->
</div>
@endif @endif
@include('page.footer')
@stop
@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<link rel="stylesheet" href="/css/bootstrap-datepicker.min.css">
@stop
@section('js')

<script src="/js/bootstrap-datepicker.min.js"></script>
<script src="/js/bootbox.min.js"></script>
<script>
    $(function () {
        $('#example1').DataTable()
        $('#example2').DataTable()
        $('#example3').DataTable()
        $('#example4').DataTable()
    });

</script>
@stop
