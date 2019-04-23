@extends('adminlte::page')
@section('title', 'CMS | Approved Contracts')
@section('content_header')
<h1 class="pull-left">Contracts<small>Approved Contracts</small></h1>
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
                <li class="active"><a href="#approved-contracts" data-toggle="tab">Approved Contracts</a></li>
                <li><a href="#approved-by-me-contracts" data-toggle="tab">Approved By Me</a></li>
                <li><a href="#my-approved-contracts" data-toggle="tab">My Approved Contracts</a></li>
                <div class="btn-group pull-right" style="padding:6px;">
                    <a class="btn btn-primary btn-sm btn-flat" href="/contract/create"><i class="fa fa-plus"></i> New Contract</a>
                </div>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="approved-contracts">
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
                                                    <th>Uploads</th>
                                                    <th>Effective Date</th>
                                                    <th>Expiry Date</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($approved_contracts as $key=>$approved_contract)
                                                <tr>
                                                    <td>{{ $key+1}}</td>
                                                    <td><a href="/contract/{{$approved_contract->contract_id}}/view">{{$approved_contract->contract_title}}</a></td>
                                                    <td><a href="/contract-party/{{$approved_contract->party_id}}/view-contract-party"
                                                            target="_blank">
                                                       <span class="label" style="background-color:#FFF;color:#0073b7;border:1px solid #0073b7;">
                                                       <i class="fa fa-briefcase fa-fw"></i> {{$approved_contract->party_name}}	</a></span>
                                                    </td>
                                                    <td><a href="/{{$approved_contract->draft_file}}" target="_blank"><i class="fa fa-fw fa-download"></i> Contract</a>                                                        |
                                                        <a href="/{{$approved_contract->draft_file}}" target="_blank"><i class="fa fa-fw fa-download"></i> CRF</a>
                                                    </td>
                                                    <td>{{date("d-m-Y",strtotime($approved_contract->effective_date))}}</td>
                                                    <td>{{date("d-m-Y",strtotime($approved_contract->expiry_date))}}</td>
                                                    <td><span class="pull-right-container">
                                                        @if($approved_contract->contract_status == 'created')
                                                        <small class="label pull-center btn-warning">{{$approved_contract->contract_status}}</small></span>                                                        @elseif($approved_contract->contract_status == 'published')
                                                        <small class="label pull-center btn-info">{{ $approved_contract->contract_status}}</small></span>
                                                        @elseif($approved_contract->contract_status== 'submitted')
                                                        <small class="label label-success">{{$approved_contract->contract_status}}</small></span>
                                                        @elseif($approved_contract->contract_status== 'ammended')
                                                        <small class="label pull-center btn-danger">{{$approved_contract->contract_status}}</small></span>
                                                        @elseif($approved_contract->contract_status== 'approved')
                                                        <small class="label pull-center btn-success">{{$approved_contract->contract_status}}</small></span>
                                                        @elseif($approved_contract->contract_status== 'terminated')
                                                        <small class="label pull-center btn-danger">{{$approved_contract->contract_status}}</small></span>
                                                    </td>
                                                    @endif
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-block btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Actions<span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>
                                                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                                                <li><a href="/contract/{{$approved_contract->contract_id}}/view"
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
                                        <table id="example2" class="table no-margin">
                                            <thead>
                                                <tr>
                                                    <th style="width:25px;">S/N</th>
                                                    <th style="width:400px;">Contract Title</th>
                                                    <th style="width:160px;">Party Name</th>
                                                    <th style="width:145px;">Uploads</th>
                                                    <th style="width:90px;">Effective Date</th>
                                                    <th style="width:90px;">Expiry Date</th>
                                                    <th style="width:50px;">Status</th>
                                                    <th style="width:50px;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($approved_by_me_contracts as $key=>$approved_by_me_contract)
                                                <tr>
                                                    <td>{{ $key+1}}</td>
                                                    <td><a href="/contract/{{$approved_by_me_contract->contract_id}}/view">{{$approved_by_me_contract->contract_title}}</a></td>
                                                    <td><a href="/contract-party/{{$approved_by_me_contract->party_id}}/view-contract-party"
                                                            target="_blank">
                                                                                                   <span class="label" style="background-color:#FFF;color:#0073b7;border:1px solid #0073b7;">
                                                                                                   <i class="fa fa-briefcase fa-fw"></i> {{$approved_by_me_contract->party_name}}	</a></span>
                                                    </td>
                                                    <td><a href="/{{$approved_by_me_contract->draft_file}}" target="_blank"><i class="fa fa-fw fa-download"></i> Contract</a>                                                        |
                                                        <a href="/{{$approved_by_me_contract->draft_file}}" target="_blank"><i class="fa fa-fw fa-download"></i> CRF</a>
                                                    </td>
                                                    <td>{{date("d-m-Y",strtotime($approved_by_me_contract->effective_date))}}</td>
                                                    <td>{{date("d-m-Y",strtotime($approved_by_me_contract->expiry_date))}}</td>
                                                    <td><span class="pull-right-container">
                                                    @if($approved_by_me_contract->contract_status == 'created')
                                                    <small class="label pull-center btn-warning">{{$approved_by_me_contract->contract_status}}</small></span>                                                        @elseif($approved_contract->contract_status == 'published')
                                                        <small class="label pull-center btn-info">{{ $approved_by_me_contract->contract_status}}</small></span>
                                                        @elseif($approved_contract->contract_status== 'submitted')
                                                        <small class="label label-success">{{$approved_by_me_contract->contract_status}}</small></span>
                                                        @elseif($approved_by_me_contract->contract_status== 'ammended')
                                                        <small class="label pull-center btn-danger">{{$approved_by_me_contract->contract_status}}</small></span>
                                                        @elseif($approved_by_me_contract->contract_status== 'approved')
                                                        <small class="label pull-center btn-success">{{$approved_by_me_contract->contract_status}}</small></span>
                                                        @elseif($approved_by_me_contract->contract_status== 'terminated')
                                                        <small class="label pull-center btn-danger">{{$approved_by_me_contract->contract_status}}</small></span>
                                                    </td>
                                                    @endif
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-block btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Actions<span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>
                                                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                                                <li><a href="/contract/{{$approved_contract->contract_id}}/view"
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
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="my-approved-contracts">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-success">
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table id="example3" class="table no-margin">
                                            <thead>
                                                <tr>
                                                    <th style="width:25px;">S/N</th>
                                                    <th style="width:400px;">Contract Title</th>
                                                    <th style="width:160px;">Party Name</th>
                                                    <th style="width:145px;">Uploads</th>
                                                    <th style="width:90px;">Effective Date</th>
                                                    <th style="width:90px;">Expiry Date</th>
                                                    <th style="width:50px;">Status</th>
                                                    <th style="width:50px;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($my_approved_contracts as $key=>$my_approved_contract)
                                                <tr>
                                                    <td>{{ $key+1}}</td>
                                                    <td><a href="/contract/{{$my_approved_contract->contract_id}}/view">{{$my_approved_contract->contract_title}}</a></td>
                                                    <td><a href="/contract-party/{{$my_approved_contract->party_id}}/view-contract-party"
                                                            target="_blank">
                                                                                                   <span class="label" style="background-color:#FFF;color:#0073b7;border:1px solid #0073b7;">
                                                                                                   <i class="fa fa-briefcase fa-fw"></i> {{$my_approved_contract->party_name}}	</a></span>
                                                    </td>
                                                    <td><a href="/{{$my_approved_contract->draft_file}}" target="_blank"><i class="fa fa-fw fa-download"></i> Contract</a>                                                        |
                                                        <a href="/{{$my_approved_contract->draft_file}}" target="_blank"><i class="fa fa-fw fa-download"></i> CRF</a>
                                                    </td>
                                                    <td>{{date("d-m-Y",strtotime($my_approved_contract->effective_date))}}</td>
                                                    <td>{{date("d-m-Y",strtotime($my_approved_contract->expiry_date))}}</td>
                                                    <td><span class="pull-right-container">
                                                            @if($approved_contract->contract_status == 'created')
                                                            <small class="label pull-center btn-warning">{{$my_approved_contract->contract_status}}</small></span>                                                        @elseif($approved_contract->contract_status == 'published')
                                                        <small class="label pull-center btn-info">{{ $my_approved_contract->contract_status}}</small></span>
                                                        @elseif($my_approved_contract->contract_status== 'submitted')
                                                        <small class="label label-success">{{$my_approved_contract->contract_status}}</small></span>
                                                        @elseif($my_approved_contract->contract_status== 'ammended')
                                                        <small class="label pull-center btn-danger">{{$my_approved_contract->contract_status}}</small></span>
                                                        @elseif($my_approved_contract->contract_status== 'approved')
                                                        <small class="label pull-center btn-success">{{$my_approved_contract->contract_status}}</small></span>
                                                        @elseif($my_approved_contract->contract_status== 'terminated')
                                                        <small class="label pull-center btn-danger">{{$my_approved_contract->contract_status}}</small></span>
                                                    </td>
                                                    @endif
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-block btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Actions<span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>
                                                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                                                <li><a href="/contract/{{$approved_contract->contract_id}}/view"
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
        <table id="example4" class="table no-margin">
            <thead>
                <tr>
                    <th style="width:25px;">S/N</th>
                    <th style="width:400px;">Contract Title</th>
                    <th style="width:160px;">Party Name</th>
                    <th style="width:145px;">Uploads</th>
                    <th style="width:90px;">Effective Date</th>
                    <th style="width:90px;">Expiry Date</th>
                    <th style="width:50px;">Status</th>
                    <th style="width:50px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($approved_contracts as $key=>$approved_contract)
                <tr>
                    <td>{{ $key+1}}</td>
                    <td><a href="/contract/{{$approved_contract->contract_id}}/view">{{$approved_contract->contract_title}}</a></td>
                    <td>{{$approved_contract->party_name}}</td>
                    <td><a href="/{{$approved_contract->draft_file}}" target="_blank"><i class="fa fa-fw fa-download"></i> Contract</a>                        |
                        <a href="/{{$approved_contract->draft_file}}" target="_blank"><i class="fa fa-fw fa-download"></i> CRF</a>
                    </td>
                    <td>{{date("d-m-Y",strtotime($approved_contract->effective_date))}}</td>
                    <td>{{date("d-m-Y",strtotime($approved_contract->expiry_date))}}</td>
                    <td><span class="pull-right-container">
                                @if($approved_contract->contract_status == 'created')
                                <small class="label pull-center btn-warning">{{$approved_contract->contract_status}}</small></span>                        @elseif($approved_contract->contract_status == 'published')
                        <small class="label pull-center btn-info">{{ $approved_contract->contract_status}}</small></span>
                        @elseif($approved_contract->contract_status== 'submitted')
                        <small class="label label-success">{{$approved_contract->contract_status}}</small></span>
                        @elseif($approved_contract->contract_status== 'ammended')
                        <small class="label pull-center btn-danger">{{$approved_contract->contract_status}}</small></span>
                        @elseif($approved_contract->contract_status== 'approved')
                        <small class="label pull-center btn-success">{{$approved_contract->contract_status}}</small></span>
                        @elseif($approved_contract->contract_status== 'terminated')
                        <small class="label pull-center btn-danger">{{$approved_contract->contract_status}}</small></span>
                    </td>
                    @endif
                    </td>
                    <td>
                        {{-- @if (auth()->check()) @if (auth()->user()->isAdmin()) --}} @if (auth()->check()) @if(auth()->user()->isUser() && ($approved_contract->contract_status
                        == 'created' || $approved_contract->contract_status == 'ammended'))
                        <a href="/contract/{{$approved_contract->contract_id}}/edit">
                                        <span class = "fa fa-pencil bigger"></span></center></a>                        @else

                        <a href="/contract/{{$approved_contract->contract_id}}/view">
                                                                            <span class = "fa fa-eye bigger"></span></center></a>                        @endif @endif {!! Form::open(['action'=>['ContractController@destroy',$approved_contract->contract_id],'method'=>'POST','class'=>'floatit','enctype'=>'multipart/form-data'])
                        !!} {{Form::hidden('_method','DELETE')}} {{-- <button type="submit" class="btn btn-danger btn-xs btn-flat"
                            onClick="return confirm('Are you sure you want to delete this contract?');">   <strong>  <i class="fa fa-close"></i></strong></button>                        --}}
                        <a class="delete" data-id="{{ $approved_contract->contract_id }}" href="javascript:void(0)">
                                        <span style="color:red;" class = "fa fa-trash bigger"></span></a>
                    </td>
                    {!! Form::close() !!}
                </tr>
                @endforeach
            </tbody>
        </table>
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
    $(function () {
        $('#example1').DataTable()
        $('#example2').DataTable()
        $('#example3').DataTable()
        $('#example4').DataTable()
    });

</script>


















@stop
