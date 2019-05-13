@extends('adminlte::page')
@section('title', 'CMS | Created Contracts')
@section('content_header')
<h1 class="pull-left">Contracts<small>Created Contracts</small></h1>
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
                <li class="active"><a href="#created-contracts" data-toggle="tab">Created Contracts</a></li>
                <div class="btn-group pull-right" style="padding:6px;">
                    <a class="btn btn-primary btn-sm btn-flat" href="/contract/create"><i class="fa fa-plus"></i> New Contract</a>
                </div>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="created-contracts">
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
                                                @foreach($created_contracts as $key=>$created_contract)
                                                <tr>
                                                    <td>{{ $key+1}}</td>
                                                    <td><a href="/contract/{{$created_contract->contract_id}}/view">{{$created_contract->contract_code}}</a></td>
                                                    <td><a href="/contract/{{$created_contract->contract_id}}/view">{{$created_contract->contract_title}}</a></td>
                                                    <td><a href="/contract-party/{{$created_contract->party_id}}/view-contract-party"
                                                            target="_blank">
                                                    <span class="label" style="background-color:#FFF;color:#0073b7;border:1px solid #0073b7;">
                                                    <i class="fa fa-briefcase fa-fw"></i> {{$created_contract->party_name}}	</a></span>
                                                    </td>
                                                    <td>{{date("d-m-Y",strtotime($created_contract->effective_date))}}</td>
                                                    @if($created_contract->expiry_date == '')
                                                    <td>N/A</td>
                                                    @else
                                                    <td>{{date("d-m-Y",strtotime($created_contract->expiry_date))}}</td>
                                                    @endif
                                                    <td><span class="pull-right-container">

                                                        <small class="badge bg-purple">{{$created_contract->contract_status}}</small>

                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-block btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Actions<span class="caret"></span>
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                                            <li><a href="/contract/{{$created_contract->contract_id}}/edit" class="view-contract"><i class="fa fa-pencil"></i> Edit</a></li>
                                                            {{Form::hidden('_method','DELETE')}}
                                                            <li><a href="#modal_delete_contract_{{$created_contract->contract_id}}}"
                                                                    data-backdrop="static" data-keyboard="false" data-toggle="modal"
                                                                    data-target="#modal_delete_contract_{{$created_contract->contract_id}}"
                                                                    class="delete-product"><i class="fa fa-trash"></i>  Delete</a></li>
                                                        </ul>
                                    </div>
                                    </td>
                                    {!! Form::close() !!}
                                    </tr>
                                    <!-- Modal to delete a contract by legal team/legal admin -->
                                    <div class="modal fade" id="modal_delete_contract_{{$created_contract->contract_id}}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                {!! Form::open(['action'=>['ContractController@deleteCreatedContract', $created_contract->contract_id],'method'=>'POST','class'=>'floatit','enctype'=>'multipart/form-data'])
                                                !!} {{Form::hidden('_method','DELETE')}}
                                                <input type="hidden" name='contract' value="{{$created_contract->contract_id}}">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title">Delete Contract</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                        <p>Are you sure you want to delete the contract <span style="font-weight:bold">{{$created_contract->contract_code}}</span>?</p>
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
                    @foreach($created_contracts as $key=>$created_contract)
                    <tr>
                        <td>{{ $key+1}}</td>
                        <td><a href="/contract/{{$created_contract->contract_id}}/view">{{$created_contract->contract_code}}</a></td>
                        <td><a href="/contract/{{$created_contract->contract_id}}/view">{{$created_contract->contract_title}}</a></td>
                        <td><a href="/contract-party/{{$created_contract->party_id}}/view-contract-party" target="_blank">
                                                                    <span class="label" style="background-color:#FFF;color:#0073b7;border:1px solid #0073b7;">
                                                                    <i class="fa fa-briefcase fa-fw"></i> {{$created_contract->party_name}}	</a></span>
                        </td>
                        <td>{{date("d-m-Y",strtotime($created_contract->effective_date))}}</td>
                        @if($created_contract->expiry_date == '')
                        <td>N/A</td>
                        @else
                        <td>{{date("d-m-Y",strtotime($created_contract->expiry_date))}}</td>
                        @endif
                        <td><span class="pull-right-container">
                                                                        <small class="badge bg-purple">{{$created_contract->contract_status}}</small>
                                                                    </td>
                                                                    <td>
                                                                        <div class="btn-group">
                                                                            <button type="button" class="btn btn-block btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Actions<span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <li><a href="/contract/{{$created_contract->contract_id}}/edit" class="view-contract"><i class="fa fa-pencil"></i> Edit</a></li>
                                <li>
                                    <a href="#modal_user_delete_contract_{{$created_contract->contract_id}}" data-backdrop="static" data-keyboard="false" data-toggle="modal"
                                        data-target="#modal_user_delete_contract_{{$created_contract->contract_id}}" class="delete-product"><i class="fa fa-trash"></i>  Delete</a>
                                </li>
                            </ul>
        </div>
        </td>
        {!! Form::close() !!}
        </tr>
        <!-- Modal to delete a contract by legal team/legal admin -->
        <div class="modal fade" id="modal_user_delete_contract_{{$created_contract->contract_id}}">
            <div class="modal-dialog">
                <div class="modal-content">
                    {!! Form::open(['action'=>['ContractController@deleteCreatedContract', $created_contract->contract_id],'method'=>'POST','class'=>'floatit','enctype'=>'multipart/form-data'])
                    !!} {{Form::hidden('_method','DELETE')}}
                    <input type="hidden" name='contract' value="{{$created_contract->contract_id}}">
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
        @endforeach
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
