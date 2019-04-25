@extends('adminlte::page')
@section('title', 'CMS | Pending Contracts')
@section('content_header')
<h1 class="pull-left">Contracts<small>Pending Contracts</small></h1>
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
<div class="row">
    <div class="col-md-12">
        <!-- Custom Tabs (Pulled to the right) -->
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#pending-contracts" data-toggle="tab">Pending Contracts</a></li>
                <li><a href="#overdue-contracts" data-toggle="tab">Overdue Contracts</a></li>
                <li><a href="#open_contracts" data-toggle="tab">Open Contracts</a></li>
                <li><a href="#assigned-contracts" data-toggle="tab">Assigned Contracts</a></li>
                <li><a href="#my-pending-contracts" data-toggle="tab">My Contracts</a></li>
                <div class="btn-group pull-right" style="padding:6px;">
                    <a class="btn btn-primary btn-sm btn-flat" href="/contract/create"><i class="fa fa-plus"></i> New Contract</a>
                </div>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="pending-contracts">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-success">
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table id="example1" class="table no-margin">
                                            <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Contract Title</th>
                                                    <th>Party Name</th>
                                                    <th>Effective Date</th>
                                                    <th>Expiry Date</th>
                                                    <th>Status</th>
                                                    @if(auth()->check()) @if (auth()->user()->isAdmin() || auth()->user()->isLegal())
                                                    <th>Alert</th>
                                                    @endif @endif
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($pending_contracts as $key=>$pending_contract)
                                                <tr>
                                                    <td>{{ $key+1}}</td>
                                                    <td><a href="/contract/{{$pending_contract->contract_id}}/view">{{$pending_contract->contract_title}}</a></td>
                                                    <td><a href="/contract-party/{{$pending_contract->party_id}}/view-contract-party"
                                                            target="_blank">
                                                    <span class="label" style="background-color:#FFF;color:#0073b7;border:1px solid #0073b7;">
                                                    <i class="fa fa-briefcase fa-fw"></i> {{$pending_contract->party_name}}	</a></span>
                                                    </td>
                                                    <td>{{date("d-m-Y",strtotime($pending_contract->effective_date))}}</td>
                                                    @if($pending_contract->expiry_date == '')
                                                    <td>N/A</td>
                                                    @else
                                                    <td>{{date("d-m-Y",strtotime($pending_contract->expiry_date))}}</td>
                                                    @endif
                                                    <td><span class="pull-right-container">
                                                        @if($pending_contract->contract_status == 'created')
                                                        <small class="badge bg-purple">{{$pending_contract->contract_status}}</small></span>                                                        @elseif($pending_contract->contract_status == 'published')
                                                        <small class="badge bg-yellow">{{ $pending_contract->contract_status}}</small></span>
                                                        @elseif($pending_contract->contract_status== 'ammended')
                                                        <small class="badge bg-blue">{{$pending_contract->contract_status}}</small></span>
                                                        @elseif($pending_contract->contract_status== 'approved')
                                                        <small class="badge bg-green">{{$pending_contract->contract_status}}</small></span>
                                                        @elseif($pending_contract->contract_status== 'terminated')
                                                        <small class="badge bg-red">{{$pending_contract->contract_status}}</small></span>
                                                    </td>
                                                    @endif @if(auth()->check()) @if (auth()->user()->isAdmin() || auth()->user()->isLegal())
                                                    <td>
                                                        @if ($pending_contract->assigned =='' && $pending_contract->escalation_duration >=1)
                                                        <span class="label" style="background-color:#FFF;color:#ff0000;border:1px solid #ff0000">Overdue</span>                                                        @elseif($pending_contract->assigned=='' && $pending_contract->escalation_duration
                                                        <1) <span class="label" style="background-color:#FFF;color:#1e3fda;border:1px solid #1e3fda">Open</span>
                                                            @else
                                                            <span class="label" style="background-color:#FFF;color:#058e29;border:1px solid #058e29">Assigned</span>                                                            @endif
                                                    </td>
                                                    @endif @endif

                                                    <td>
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-block btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Actions<span class="caret"></span><span class="sr-only">Toggle Dropdown</span>
                                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                                                <li><a href="/contract/{{$pending_contract->contract_id}}/view"
                                                                        class="view-contract"><i class="fa fa-eye"></i> View</a></li>
                                                                <li>
                                                                    <a href="#modal_delete_contract" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#modal_delete_contract"
                                                                        class="delete-product"><i class="fa fa-trash"></i>  Delete</a></li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                    {!! Form::close() !!}
                                                </tr>
                                                @endforeach
                                                <!-- Modal to delete a contract by legal team/legal admin -->

                                                <div class="modal fade" id="modal_delete_contract">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            {{-- {!! Form::open(['action'=>'ContractController@destroy','method'=>'POST','class'=>'form','enctype'=>'multipart/form-data'])
                                                            !!} --}}
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                                <span aria-hidden="true">&times;</span></button>
                                                                <h4 class="modal-title">Delete Contract</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-md-12">

                                                                        <p>Are you sure you want to delete the contract?</p>
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
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="overdue-contracts">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-success">
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table id="example2" class="table no-margin">
                                            <thead>
                                                <tr>
                                                    <th>S/NDD</th>
                                                    <th>Contract Title</th>
                                                    @if(auth()->check()) @if (auth()->user()->isLegal() || auth()->user()->isUser() )
                                                    <th>Party Name</th>
                                                    @else
                                                    <th>Party Name</th>
                                                    @endif @endif
                                                    <th>Effective Date</th>
                                                    <th>Expiry Date</th>
                                                    <th>Status</th>
                                                    @if(auth()->check()) @if (auth()->user()->isAdmin() || auth()->user()->isLegal())
                                                    <th>Alert</th>
                                                    @endif @endif
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($overdue_pending_contracts as $key=>$overdue_pending_contract)
                                                <tr>
                                                    <td>{{ $key+1}}</td>
                                                    <td><a href="/contract/{{$overdue_pending_contract->contract_id}}/view">{{$overdue_pending_contract->contract_title}}</a></td>
                                                    <td><a href="/contract-party/{{$overdue_pending_contract->party_id}}/view-contract-party"
                                                            target="_blank">
                                                                                                    <span class="label" style="background-color:#FFF;color:#0073b7;border:1px solid #0073b7;">
                                                                                                    <i class="fa fa-briefcase fa-fw"></i> {{$overdue_pending_contract->party_name}}	</a></span>
                                                    </td>
                                                    <td>{{date("d-m-Y",strtotime($overdue_pending_contract->effective_date))}}</td>
                                                    @if($overdue_pending_contract->expiry_date == '')
                                                    <td>N/A</td>
                                                    @else
                                                    <td>{{date("d-m-Y",strtotime($overdue_pending_contract->expiry_date))}}</td>
                                                    @endif
                                                    <td><span class="pull-right-container">
                                                        @if($overdue_pending_contract->contract_status == 'created')
                                                        <small class="badge bg-purple">{{$overdue_pending_contract->contract_status}}</small></span>                                                        @elseif($overdue_pending_contract->contract_status == 'published')
                                                        <small class="badge bg-yellow">{{ $overdue_pending_contract->contract_status}}</small></span>
                                                        @elseif($overdue_pending_contract->contract_status== 'ammended')
                                                        <small class="badge bg-blue">{{$overdue_pending_contract->contract_status}}</small></span>
                                                        @elseif($overdue_pending_contract->contract_status== 'approved')
                                                        <small class="badge bg-green">{{$overdue_pending_contract->contract_status}}</small></span>
                                                        @elseif($overdue_pending_contract->contract_status== 'terminated')
                                                        <small class="badge bg-red">{{$pending_contract->contract_status}}</small></span>
                                                    </td>
                                                    @endif @if(auth()->check()) @if (auth()->user()->isAdmin() || auth()->user()->isLegal())
                                                    <td>
                                                        @if ($overdue_pending_contract->assigned =='' && $overdue_pending_contract->escalation_duration >=1)
                                                        <span class="label" style="background-color:#FFF;color:#ff0000;border:1px solid #ff0000">Overdue</span>                                                        @endif
                                                    </td>
                                                    @endif @endif
                                                    <td>
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-block btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Actions<span class="caret"></span><span class="sr-only">Toggle Dropdown</span>
                                                                                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                                                <li><a href="/contract/{{$pending_contract->contract_id}}/view"
                                                                        class="view-contract"><i class="fa fa-eye"></i> View</a></li>
                                                                <li>
                                                                    <a href="#modal_delete_contract1" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#modal_delete_contract1"
                                                                        class="delete-product"><i class="fa fa-trash"></i>  Delete</a></li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                    {!! Form::close() !!}
                                                </tr>
                                                @endforeach
                                                <!-- Modal to delete a contract by legal team/legal admin -->

                                                <div class="modal fade" id="modal_delete_contract1">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            {{-- {!! Form::open(['action'=>'ContractController@destroy','method'=>'POST','class'=>'form','enctype'=>'multipart/form-data'])
                                                            !!} --}}
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                                <span aria-hidden="true">&times;</span></button>
                                                                <h4 class="modal-title">Delete Contract</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-md-12">

                                                                        <p>Are you sure you want to delete the contract?</p>
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
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="assigned-contracts">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-success">
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table id="example3" class="table no-margin">
                                            <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Contract Title</th>
                                                    @if(auth()->check()) @if (auth()->user()->isLegal() || auth()->user()->isUser() )
                                                    <th>Party Name</th>
                                                    @else
                                                    <th>Party Name</th>
                                                    @endif @endif
                                                    <th>Effective Date</th>
                                                    <th>Expiry Date</th>
                                                    <th>Status</th>
                                                    @if(auth()->check()) @if (auth()->user()->isAdmin() || auth()->user()->isLegal())
                                                    <th>Alert</th>
                                                    @endif @endif
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($assigned_pending_contracts as $key=>$assigned_pending_contract)
                                                <tr>
                                                    <td>{{ $key+1}}</td>
                                                    <td><a href="/contract/{{$assigned_pending_contract->contract_id}}/view">{{$assigned_pending_contract->contract_title}}</a></td>
                                                    <td><a href="/contract-party/{{$assigned_pending_contract->party_id}}/view-contract-party"
                                                            target="_blank">
                                                                                                    <span class="label" style="background-color:#FFF;color:#0073b7;border:1px solid #0073b7;">
                                                                                                    <i class="fa fa-briefcase fa-fw"></i> {{$assigned_pending_contract->party_name}}	</a></span>
                                                    </td>
                                                    <td>{{date("d-m-Y",strtotime($assigned_pending_contract->effective_date))}}</td>
                                                    @if($assigned_pending_contract->expiry_date == '')
                                                    <td>N/A</td>
                                                    @else
                                                    <td>{{date("d-m-Y",strtotime($assigned_pending_contract->expiry_date))}}</td>
                                                    @endif
                                                    <td><span class="pull-right-container">
                                                                        @if($assigned_pending_contract->contract_status == 'created')
                                                                        <small class="badge bg-purple">{{$assigned_pending_contract->contract_status}}</small></span>                                                        @elseif($assigned_pending_contract->contract_status == 'published')
                                                        <small class="badge bg-yellow">{{ $assigned_pending_contract->contract_status}}</small></span>
                                                        @elseif($assigned_pending_contract->contract_status== 'ammended')
                                                        <small class="badge bg-blue">{{$overdue_pending_contract->contract_status}}</small></span>
                                                        @elseif($assigned_pending_contract->contract_status== 'approved')
                                                        <small class="badge bg-green">{{$assigned_pending_contract->contract_status}}</small></span>
                                                        @elseif($assigned_pending_contract->contract_status== 'terminated')
                                                        <small class="badge bg-red">{{$assigned_pending_contract->contract_status}}</small></span>
                                                    </td>
                                                    @endif @if(auth()->check()) @if (auth()->user()->isAdmin() || auth()->user()->isLegal())
                                                    <td>
                                                        <span class="label" style="background-color:#FFF;color:#058e29;border:1px solid #058e29">Assigned</span>
                                                    </td>
                                                    @endif @endif
                                                    <td>
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown" aria-expanded="true">Actions<span class="caret"></span><span class="sr-only">Toggle Dropdown</span>
                                                                                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                                                <li><a href="/contract/{{$assigned_pending_contract->contract_id}}/view"
                                                                        class="view-contract"><i class="fa fa-eye"></i> View</a></li>
                                                                <li>
                                                                    <a href="#modal_delete_contract2" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#modal_delete_contract2"
                                                                        class="delete-product"><i class="fa fa-trash"></i>  Delete</a></li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                    {!! Form::close() !!}
                                                </tr>
                                                @endforeach
                                                <!-- Modal to delete a contract by legal team/legal admin -->

                                                <div class="modal fade" id="modal_delete_contract2">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            {{-- {!! Form::open(['action'=>'ContractController@destroy','method'=>'POST','class'=>'form','enctype'=>'multipart/form-data'])
                                                            !!} --}}
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                                                <span aria-hidden="true">&times;</span></button>
                                                                <h4 class="modal-title">Delete Contract</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-md-12">

                                                                        <p>Are you sure you want to delete the contract?</p>
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
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="my-pending-contracts">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-success">
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table id="example4" class="table no-margin">
                                            <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Contract Title</th>
                                                    @if(auth()->check()) @if (auth()->user()->isLegal() || auth()->user()->isUser() )
                                                    <th>Party Name</th>
                                                    @else
                                                    <th>Party Name</th>
                                                    @endif @endif
                                                    <th>Effective Date</th>
                                                    <th>Expiry Date</th>
                                                    <th>Status</th>
                                                    @if(auth()->check()) @if (auth()->user()->isAdmin() || auth()->user()->isLegal())
                                                    <th>Alert</th>
                                                    @endif @endif
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($my_pending_contracts as $key=>$my_pending_contract)
                                                <tr>
                                                    <td>{{ $key+1}}</td>
                                                    <td><a href="/contract/{{$my_pending_contract->contract_id}}/view">{{$my_pending_contract->contract_title}}</a></td>
                                                    <td><a href="/contract-party/{{$my_pending_contract->party_id}}/view-contract-party"
                                                            target="_blank">
                                                                                                    <span class="label" style="background-color:#FFF;color:#0073b7;border:1px solid #0073b7;">
                                                                                                    <i class="fa fa-briefcase fa-fw"></i> {{$my_pending_contract->party_name}}	</a></span>
                                                    </td>
                                                    <td>{{date("d-m-Y",strtotime($my_pending_contract->effective_date))}}</td>
                                                    @if($my_pending_contract->expiry_date == '')
                                                    <td>N/A</td>
                                                    @else
                                                    <td>{{date("d-m-Y",strtotime($my_pending_contract->expiry_date))}}</td>
                                                    @endif
                                                    <td><span class="pull-right-container">
                                                                                            @if($my_pending_contract->contract_status == 'created')
                                                                                            <small class="badge bg-purple">{{$my_pending_contract->contract_status}}</small></span>                                                        @elseif($my_pending_contract->contract_status == 'published')
                                                        <small class="badge bg-yellow">{{ $my_pending_contract->contract_status}}</small></span>
                                                        @elseif($my_pending_contract->contract_status== 'ammended')
                                                        <small class="badge bg-blue">{{$my_pending_contract->contract_status}}</small></span>
                                                        @elseif($my_pending_contract->contract_status== 'approved')
                                                        <small class="badge bg-green">{{$my_pending_contract->contract_status}}</small></span>
                                                        @elseif($my_pending_contract->contract_status== 'terminated')
                                                        <small class="badge bg-red">{{$my_pending_contract->contract_status}}</small></span>
                                                    </td>
                                                    @endif @if(auth()->check()) @if (auth()->user()->isAdmin() || auth()->user()->isLegal())
                                                    <td>
                                                        @if ($my_pending_contract->assigned =='' && $my_pending_contract->escalation_duration >=1)
                                                        <span class="label" style="background-color:#FFF;color:#ff0000;border:1px solid #ff0000">Overdue</span>                                                        @elseif($my_pending_contract->assigned=='' && $my_pending_contract->escalation_duration
                                                        <1) <span class="label" style="background-color:#FFF;color:#1e3fda;border:1px solid #1e3fda">Open</span>
                                                            @else
                                                            <span class="label" style="background-color:#FFF;color:#058e29;border:1px solid #058e29">Assigned</span>                                                            @endif
                                                    </td>
                                                    @endif @endif
                                                    <td>
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown" aria-expanded="true">Actions<span class="caret"></span><span class="sr-only">Toggle Dropdown</span>
                                                                                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                                                <li><a href="/contract/{{$my_pending_contract->contract_id}}/view"
                                                                        class="view-contract"><i class="fa fa-eye"></i> View</a></li>
                                                                <li>
                                                                    <a href="#modal_delete_contract3" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#modal_delete_contract3"
                                                                        class="delete-product"><i class="fa fa-trash"></i>  Delete</a></li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                    {!! Form::close() !!}
                                                </tr>
                                                @endforeach
                                                <!-- Modal to delete a contract by legal team/legal admin -->

                                                <div class="modal fade" id="modal_delete_contract3">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            {{-- {!! Form::open(['action'=>'ContractController@destroy','method'=>'POST','class'=>'form','enctype'=>'multipart/form-data'])
                                                            !!} --}}
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                                                                    <span aria-hidden="true">&times;</span></button>
                                                                <h4 class="modal-title">Delete Contract</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-md-12">

                                                                        <p>Are you sure you want to delete the contract?</p>
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
                                            </tbody>
                                        </table>
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
@else
<div class="box box-success">
    <div class="box-body">
        <div class="table-responsive">
            <table id="example1" class="table no-margin">
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Contract Title</th>
                        @if(auth()->check()) @if (auth()->user()->isLegal() || auth()->user()->isUser() )
                        <th>Party Name</th>
                        @else
                        <th>Party Name</th>
                        @endif @endif
                        <th>Effective Date</th>
                        <th>Expiry Date</th>
                        <th>Status</th>
                        @if(auth()->check()) @if (auth()->user()->isAdmin() || auth()->user()->isLegal())
                        <th>Alert</th>
                        @endif @endif
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pending_contracts as $key=>$pending_contract)
                    <tr>
                        <td>{{ $key+1}}</td>
                        <td><a href="/contract/{{$pending_contract->contract_id}}/view">{{$pending_contract->contract_title}}</a></td>
                        <td><a href="/contract-party/{{$pending_contract->party_id}}/view-contract-party" target="_blank">
                                                                    <span class="label" style="background-color:#FFF;color:#0073b7;border:1px solid #0073b7;">
                                                                    <i class="fa fa-briefcase fa-fw"></i> {{$pending_contract->party_name}}	</a></span>
                        </td>
                        <td>{{date("d-m-Y",strtotime($pending_contract->effective_date))}}</td>
                        @if($pending_contract->expiry_date == '')
                        <td>N/A</td>
                        @else
                        <td>{{date("d-m-Y",strtotime($pending_contract->expiry_date))}}</td>
                        @endif
                        <td><span class="pull-right-container">
                        @if($pending_contract->contract_status == 'created')
                        <small class="badge bg-purple">{{$pending_contract->contract_status}}</small></span> @elseif($pending_contract->contract_status
                            == 'published')
                            <small class="badge bg-yellow">{{ $pending_contract->contract_status}}</small></span>
                            @elseif($pending_contract->contract_status== 'ammended')
                            <small class="badge bg-blue">{{$pending_contract->contract_status}}</small></span>
                            @elseif($pending_contract->contract_status== 'approved')
                            <small class="badge bg-green">{{$pending_contract->contract_status}}</small></span>
                            @elseif($pending_contract->contract_status== 'terminated')
                            <small class="badge bg-red">{{$pending_contract->contract_status}}</small></span>
                        </td>
                        @endif @if(auth()->check()) @if (auth()->user()->isAdmin() || auth()->user()->isLegal())
                        <td>
                            @if ($pending_contract->assigned=='' && $pending_contract->escalation_duration >=10)
                            <span class="label" style="background-color:#FFF;color:#ff0000;border:1px solid #ff0000">Overdue</span>                            @elseif ($pending_contract->assigned=='' && $pending_contract->escalation_duration
                            <10) <span class="label" style="background-color:#FFF;color:#1e3fda;border:1px solid #1e3fda">Open</span>
                                @else
                                <span class="label" style="background-color:#FFF;color:#058e29;border:1px solid #058e29">Assigned</span>                                @endif
                        </td>
                        @endif @endif
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown" aria-expanded="true">Actions<span class="caret"></span><span class="sr-only">Toggle Dropdown</span>
                                                                                                                                            </button>
                                <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                    <li><a href="/contract/{{$pending_contract->contract_id}}/view" class="view-contract"><i class="fa fa-eye"></i> View</a></li>
                                    <li>
                                        <a href="#modal_delete_contract4" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#modal_delete_contract4"
                                            class="delete-product"><i class="fa fa-trash"></i>  Delete</a></li>
                                </ul>
                            </div>
                        </td>
                        {!! Form::close() !!}
                    </tr>
                    @endforeach
                    <!-- Modal to delete a contract by legal team/legal admin -->

                    <div class="modal fade" id="modal_delete_contract4">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                {{-- {!! Form::open(['action'=>'ContractController@destroy','method'=>'POST','class'=>'form','enctype'=>'multipart/form-data'])
                                !!} --}}
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Delete Contract</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">

                                            <p>Are you sure you want to delete the contract?</p>
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
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif @endif
@stop
@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<link rel="stylesheet" href="/css/bootstrap-datepicker.min.css">
@stop
@section('js')

<script src="/js/bootstrap-datepicker.min.js"></script>
<script src="/js/bootbox.min.js"></script>
<script>
    $(function ()
    {
    $('#example1').DataTable()
    $('#example2').DataTable()
    $('#example3').DataTable()
    $('#example4').DataTable()
});

</script>




























































@stop
