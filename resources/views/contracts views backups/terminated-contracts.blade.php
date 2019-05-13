@extends('adminlte::page')
@section('title', 'CMS | Terminated Contracts')
@section('content_header')
<h1 class="pull-left">Contracts<small>Terminated Contracts</small></h1>
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
                <li class="active"><a href="#terminated-contracts" data-toggle="tab">Terminated Contracts</a></li>
                <li><a href="#terminated-by-me-contracts" data-toggle="tab">Terminated By Me</a></li>
                <li><a href="#my-terminated-contracts" data-toggle="tab">My Terminated Contracts</a></li>
                <div class="btn-group pull-right" style="padding:6px;">
                    <a class="btn btn-primary btn-sm btn-flat" href="/contract/create"><i class="fa fa-plus"></i> New Contract</a>
                </div>

            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="terminated-contracts">
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
                                                @foreach($terminated_contracts as $key=>$terminated_contract)
                                                <tr>
                                                    <td>{{ $key+1}}</td>
                                                    <td><a href="/contract/{{$terminated_contract->contract_id}}/view">{{$terminated_contract->contract_code}}</a>
                                                        </td>
                                                    <td><a href="/contract/{{$terminated_contract->contract_id}}/view">{{$terminated_contract->contract_title}}</a></td>
                                                    <td><a href="/contract-party/{{$terminated_contract->party_id}}/view-contract-party"
                                                            target="_blank">
                                                                                        <span class="label" style="background-color:#FFF;color:#0073b7;border:1px solid #0073b7;">
                                                                             <i class="fa fa-briefcase fa-fw"></i> {{$terminated_contract->party_name}}	</a></span>
                                                    </td>
                                                    <td>{{date("d-m-Y",strtotime($terminated_contract->effective_date))}}</td>
                                                    @if($terminated_contract->expiry_date == '')
                                                    <td>N/A</td>
                                                    @else
                                                    <td>{{date("d-m-Y",strtotime($terminated_contract->expiry_date))}}
                                                    </td>
                                                    @endif
                                                    <td><span class="pull-right-container">
                                                            @if($terminated_contract->contract_status == 'created')
                                                            <small class="label pull-center btn-warning">{{$terminated_contract->contract_status}}</small></span>                                                        @elseif($terminated_contract->contract_status == 'pending')
                                                        <small class="label pull-center btn-info">{{ $terminated_contract->contract_status}}</small></span>
                                                        @elseif($terminated_contract->contract_status== 'submitted')
                                                        <small class="label label-success">{{$terminated_contract->contract_status}}</small></span>
                                                        @elseif($terminated_contract->contract_status== 'amended')
                                                        <small class="label pull-center btn-danger">{{$terminated_contract->contract_status}}</small></span>
                                                        @elseif($terminated_contract->contract_status== 'approved')
                                                        <small class="label pull-center btn-success">{{$terminated_contract->contract_status}}</small></span>
                                                        @elseif($terminated_contract->contract_status== 'Terminated')
                                                        <small class="label pull-center btn-danger">{{$terminated_contract->contract_status}}</small></span>
                                                    </td>
                                                    @endif
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a class="btn btn-info btn-block btn-sm btn-flat" href="/contract/{{$terminated_contract->contract_id}}/view"><i class="fa fa-eye"></i> View</a>
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
                <div class="tab-pane" id="terminated-by-me-contracts">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-success">
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table id="example2" class="table no-margin">
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
                                                @foreach($terminated_by_me_contracts as $key=>$terminated_by_me_contract)
                                                <tr>
                                                    <td>{{ $key+1}}</td>
                                                    <td><a href="/contract/{{$terminated_by_me_contract->contract_id}}/view">{{$terminated_by_me_contract->contract_code}}</a>
                                                    </td>
                                                    <td><a href="/contract/{{$terminated_by_me_contract->contract_id}}/view">{{$terminated_by_me_contract->contract_title}}</a></td>
                                                    <td><a href="/contract-party/{{$terminated_by_me_contract->party_id}}/view-contract-party"
                                                            target="_blank">
                                                                                                                                                                                <span class="label" style="background-color:#FFF;color:#0073b7;border:1px solid #0073b7;">
                                                                                                                                                                     <i class="fa fa-briefcase fa-fw"></i> {{$terminated_by_me_contract->party_name}}	</a></span>
                                                    </td>
                                                    <td>{{date("d-m-Y",strtotime($terminated_by_me_contract->effective_date))}}</td>
                                                    @if($terminated_by_me_contract->expiry_date == '')
                                                        <td>N/A</td>
                                                        @else
                                                        <td>{{date("d-m-Y",strtotime($terminated_by_me_contract->expiry_date))}}
                                                        </td>
                                                        @endif

                                                    <td><span class="pull-right-container">
                                                            @if($terminated_by_me_contract->contract_status == 'created')
                                                            <small class="label pull-center btn-warning">{{$terminated_by_me_contract->contract_status}}</small></span>                                                        @elseif($terminated_contract->contract_status == 'pending')
                                                        <small class="label pull-center btn-info">{{ $terminated_by_me_contract->contract_status}}</small></span>
                                                        @elseif($terminated_by_me_contract->contract_status== 'submitted')
                                                        <small class="label label-success">{{$terminated_by_me_contract->contract_status}}</small></span>
                                                        @elseif($terminated_by_me_contract->contract_status== 'amended')
                                                        <small class="label pull-center btn-danger">{{$terminated_by_me_contract->contract_status}}</small></span>
                                                        @elseif($terminated_by_me_contract->contract_status== 'approved')
                                                        <small class="label pull-center btn-success">{{$terminated_by_me_contract->contract_status}}</small></span>
                                                        @elseif($terminated_by_me_contract->contract_status== 'Terminated')
                                                        <small class="label pull-center btn-danger">{{$terminated_by_me_contract->contract_status}}</small></span>
                                                    </td>
                                                    @endif
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a class="btn btn-info btn-block btn-sm btn-flat" href="/contract/{{$terminated_by_me_contract->contract_id}}/view"><i class="fa fa-eye"></i> View</a>
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
                <div class="tab-pane" id="my-terminated-contracts">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-success">
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table id="example3" class="table no-margin">
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
                                                @foreach($my_terminated_contracts as $key=>$my_terminated_contract)
                                                <tr>
                                                    <td>{{ $key+1}}</td>
                                                    <td><a href="/contract/{{$my_terminated_contract->contract_id}}/view">{{$my_terminated_contract->contract_code}}</a>
                                                    </td>
                                                    <td><a href="/contract/{{$my_terminated_contract->contract_id}}/view">{{$my_terminated_contract->contract_title}}</a></td>
                                                    <td><a href="/contract-party/{{$my_terminated_contract->party_id}}/view-contract-party"
                                                            target="_blank">
                                                                                                                                                                                <span class="label" style="background-color:#FFF;color:#0073b7;border:1px solid #0073b7;">
                                                                                                                                                                     <i class="fa fa-briefcase fa-fw"></i> {{$my_terminated_contract->party_name}}	</a></span>
                                                    </td>
                                                    <td>{{date("d-m-Y",strtotime($my_terminated_contract->effective_date))}}</td>
                                                    @if($my_terminated_contract->expiry_date == '')
                                                    <td>N/A</td>
                                                    @else
                                                    <td>{{date("d-m-Y",strtotime($my_terminated_contract->expiry_date))}}
                                                    </td>
                                                    @endif
                                                    <td><span class="pull-right-container">
                                                                                                @if($my_terminated_contract->contract_status == 'created')
                                                                                                <small class="label pull-center btn-warning">{{$my_terminated_contract->contract_status}}</small></span>                                                        @elseif($terminated_contract->contract_status == 'pending')
                                                        <small class="label pull-center btn-info">{{ $my_terminated_contract->contract_status}}</small></span>
                                                        @elseif($my_terminated_contract->contract_status== 'submitted')
                                                        <small class="label label-success">{{$my_terminated_contract->contract_status}}</small></span>
                                                        @elseif($my_terminated_contract->contract_status== 'amended')
                                                        <small class="label pull-center btn-danger">{{$my_terminated_contract->contract_status}}</small></span>
                                                        @elseif($my_terminated_contract->contract_status== 'approved')
                                                        <small class="label pull-center btn-success">{{$my_terminated_contract->contract_status}}</small></span>
                                                        @elseif($my_terminated_contract->contract_status== 'Terminated')
                                                        <small class="label pull-center btn-danger">{{$my_terminated_contract->contract_status}}</small></span>
                                                    </td>
                                                    @endif
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a class="btn btn-info btn-block btn-sm btn-flat" href="/contract/{{$my_terminated_contract->contract_id}}/view"><i class="fa fa-eye"></i> View</a>
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
            <div class="tabel-responsive">
                <table id="example1" class="table table-striped table-bordered records">
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
                        @foreach($terminated_contracts as $key=>$terminated_contract)
                        <tr>
                            <td>{{ $key+1}}</td>
                            <td><a href="/contract/{{$terminated_contract->contract_id}}/view">{{$terminated_contract->contract_code}}</a>
                            </td>
                            <td><a href="/contract/{{$terminated_contract->contract_id}}/view">{{$terminated_contract->contract_title}}</a></td>
                            <td>{{$terminated_contract->party_name}}</td>
                            <td>{{date("d-m-Y",strtotime($terminated_contract->effective_date))}}</td>

                            @if($terminated_contract->expiry_date == '')
                                <td>N/A</td>
                                @else
                                <td>{{date("d-m-Y",strtotime($terminated_contract->expiry_date))}}
                                </td>
                                @endif
                            <td><span class="pull-right-container">
                        @if($terminated_contract->contract_status == 'created')
                        <small class="label pull-center btn-warning">{{$terminated_contract->contract_status}}</small></span>@elseif($terminated_contract->contract_status
                                == 'pending')
                                <small class="label pull-center btn-info">{{ $terminated_contract->contract_status}}</small></span>
                                @elseif($terminated_contract->contract_status== 'submitted')
                                <small class="label label-success">{{$terminated_contract->contract_status}}</small></span>
                                @elseif($terminated_contract->contract_status== 'amended')
                                <small class="label pull-center btn-danger">{{ $ammended_contract->contract_status}}</small></span>
                                @elseif($terminated_contract->contract_status== 'approved')
                                <small class="label pull-center btn-success">{{$terminated_contract->contract_status}}</small></span>
                                @elseif($terminated_contract->contract_status== 'Terminated')
                                <small class="label pull-center btn-danger">{{$terminated_contract->contract_status}}</small></span>
                            </td>
                            @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a class="btn btn-info btn-block btn-sm btn-flat" href="/contract/{{$terminated_contract->contract_id}}/view"><i class="fa fa-eye"></i> View</a>
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
