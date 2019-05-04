@extends('adminlte::page')
@section('title', 'CMS | Amended Contracts')
@section('content_header')
<h1 class="pull-left">Contracts<small>Amended Contracts</small></h1>
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
                <li class="active"><a href="#ammended-contracts" data-toggle="tab">Amended Contracts</a></li>
                <li><a href="#ammended-by-me-contracts" data-toggle="tab">Amended By Me</a></li>
                <li><a href="#my-ammended-contracts" data-toggle="tab">My Amended Contracts</a></li>
                <div class="btn-group pull-right" style="padding:6px;">
                    <a class="btn btn-primary btn-sm btn-flat" href="/contract/create"><i class="fa fa-plus"></i> New Contract</a>
                </div>

            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="ammended-contracts">
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
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($ammended_contracts as $key=>$ammended_contract)
                                                <tr>
                                                    <td>{{ $key+1}}</td>
                                                    <td><a href="/contract/{{$ammended_contract->contract_id}}/view">{{$ammended_contract->contract_title}}</a></td>
                                                    <td><a href="/contract-party/{{$ammended_contract->party_id}}/view-contract-party"
                                                            target="_blank">
                                                                                                                        <span class="label" style="background-color:#FFF;color:#0073b7;border:1px solid #0073b7;">
                                                                                                                        <i class="fa fa-briefcase fa-fw"></i> {{$ammended_contract->party_name}}	</a></span>
                                                    </td>
                                                    <td>{{date("d-m-Y",strtotime($ammended_contract->effective_date))}}</td>
                                                    @if($ammended_contract->expiry_date == '')
                                                    <td>N/A</td>
                                                    @else
                                                    <td>{{date("d-m-Y",strtotime($ammended_contract->expiry_date))}}</td>
                                                    @endif
                                                    <td><span class="pull-right-container">
                                                            @if($ammended_contract->contract_status == 'created')
                                                            <small class="label pull-center btn-warning">{{$ammended_contract->contract_status}}</small></span>                                                        @elseif($ammended_contract->contract_status == 'pending')
                                                        <small class="label pull-center btn-info">{{ $ammended_contract->contract_status}}</small></span>
                                                        @elseif($ammended_contract->contract_status== 'submitted')
                                                        <small class="label label-success">{{$ammended_contract->contract_status}}</small></span>
                                                        @elseif($ammended_contract->contract_status== 'Amended')
                                                        <small class="label pull-center btn-primary">{{$ammended_contract->contract_status}}</small></span>
                                                        @elseif($ammended_contract->contract_status== 'approved')
                                                        <small class="label pull-center btn-success">{{$ammended_contract->contract_status}}</small></span>
                                                        @elseif($ammended_contract->contract_status== 'terminated')
                                                        <small class="label pull-center btn-danger">{{$ammended_contract->contract_status}}</small></span>
                                                    </td>
                                                    @endif
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a class="btn btn-info btn-block btn-sm btn-flat" href="/contract/{{$ammended_contract->contract_id}}/view"><i class="fa fa-eye"></i> View</a>
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
                <div class="tab-pane" id="ammended-by-me-contracts">
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
                                                    <th style="width:90px;">Effective Date</th>
                                                    <th style="width:90px;">Expiry Date</th>
                                                    <th style="width:50px;">Status</th>
                                                    <th style="width:50px;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($ammended_by_me_contracts as $key=>$ammended_by_me_contract)
                                                <tr>
                                                    <td>{{ $key+1}}</td>
                                                    <td><a href="/contract/{{$ammended_by_me_contract->contract_id}}/view">{{$ammended_by_me_contract->contract_title}}</a></td>
                                                    <td><a href="/contract-party/{{$ammended_by_me_contract->party_id}}/view-contract-party"
                                                            target="_blank">
                                                         <span class="label" style="background-color:#FFF;color:#0073b7;border:1px solid #0073b7;">
                                                            <i class="fa fa-briefcase fa-fw"></i> {{$ammended_by_me_contract->party_name}}</a></span>
                                                    </td>
                                                    <td>{{date("d-m-Y",strtotime($ammended_by_me_contract->effective_date))}}</td>
                                                    @if($ammended_by_me_contract->expiry_date == '')
                                                    <td>N/A</td>
                                                    @else
                                                    <td>{{date("d-m-Y",strtotime($ammended_by_me_contract->expiry_date))}}</td>
                                                    @endif
                                                    <td><span class="pull-right-container">
                                                            @if($ammended_by_me_contract->contract_status == 'created')
                                                            <small class="label pull-center btn-warning">{{$ammended_by_me_contract->contract_status}}</small></span>                                                        @elseif($ammended_contract->contract_status == 'pending')
                                                        <small class="label pull-center btn-info">{{ $ammended_by_me_contract->contract_status}}</small></span>
                                                        @elseif($ammended_by_me_contract->contract_status== 'submitted')
                                                        <small class="label label-success">{{$ammended_by_me_contract->contract_status}}</small></span>
                                                        @elseif($ammended_by_me_contract->contract_status== 'Amended')
                                                        <small class="label pull-center btn-primary">{{$ammended_by_me_contract->contract_status}}</small></span>
                                                        @elseif($ammended_by_me_contract->contract_status== 'approved')
                                                        <small class="label pull-center btn-success">{{$ammended_by_me_contract->contract_status}}</small></span>
                                                        @elseif($ammended_by_me_contract->contract_status== 'terminated')
                                                        <small class="label pull-center btn-danger">{{$ammended_by_me_contract->contract_status}}</small></span>
                                                    </td>
                                                    @endif
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a class="btn btn-info btn-block btn-sm btn-flat" href="/contract/{{$ammended_by_me_contract->contract_id}}/view"><i class="fa fa-eye"></i> View</a>
                                                        </div>
                                                    </td>
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
                <div class="tab-pane" id="my-ammended-contracts">
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
                                                    <th style="width:90px;">Effective Date</th>
                                                    <th style="width:90px;">Expiry Date</th>
                                                    <th style="width:50px;">Status</th>
                                                    <th style="width:50px;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($my_ammended_contracts as $key=>$my_ammended_contract)
                                                <tr>
                                                    <td>{{ $key+1}}</td>
                                                    <td><a href="/contract/{{$my_ammended_contract->contract_id}}/view">{{$my_ammended_contract->contract_title}}</a></td>
                                                    <td><a href="/contract-party/{{$my_ammended_contract->party_id}}/view-contract-party"
                                                            target="_blank">
                                                                                                     <span class="label" style="background-color:#FFF;color:#0073b7;border:1px solid #0073b7;">
                                                                                                        <i class="fa fa-briefcase fa-fw"></i> {{$my_ammended_contract->party_name}}</a></span>
                                                    </td>
                                                    <td>{{date("d-m-Y",strtotime($my_ammended_contract->effective_date))}}</td>
                                                    @if($my_ammended_contract->expiry_date == '')
                                                    <td>N/A</td>
                                                    @else
                                                    <td>{{date("d-m-Y",strtotime($my_ammended_contract->expiry_date))}}</td>
                                                    @endif
                                                    <td><span class="pull-right-container">
                                                                                                @if($my_ammended_contract->contract_status == 'created')
                                                                                                <small class="label pull-center btn-warning">{{$my_ammended_contract->contract_status}}</small></span>                                                        @elseif($ammended_contract->contract_status == 'pending')
                                                        <small class="label pull-center btn-info">{{ $my_ammended_contract->contract_status}}</small></span>
                                                        @elseif($my_ammended_contract->contract_status== 'submitted')
                                                        <small class="label label-success">{{$my_ammended_contract->contract_status}}</small></span>
                                                        @elseif($my_ammended_contract->contract_status== 'Amended')
                                                        <small class="label pull-center btn-primary">{{$my_ammended_contract->contract_status}}</small></span>
                                                        @elseif($my_ammended_contract->contract_status== 'approved')
                                                        <small class="label pull-center btn-success">{{$my_ammended_contract->contract_status}}</small></span>
                                                        @elseif($my_ammended_contract->contract_status== 'terminated')
                                                        <small class="label pull-center btn-danger">{{$my_ammended_contract->contract_status}}</small></span>
                                                    </td>
                                                    @endif
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a class="btn btn-info btn-block btn-sm btn-flat" href="/contract/{{$my_ammended_contract->contract_id}}/view"><i class="fa fa-eye"></i> View</a>
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
                <div class="tab-pane" id="my-pending-contracts">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-success">
                                <div class="box-body">
                                    <table id="example4" class="table no-margin">

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
        <table id="example1" class="table table-striped table-bordered records">
            <thead>
                <tr>
                    <th style="width:25px;">S/N</th>
                    <th style="width:400px;">Contract Title</th>
                    <th style="width:160px;">Party Name</th>
                    <th style="width:90px;">Effective Date</th>
                    <th style="width:90px;">Expiry Date</th>
                    <th style="width:50px;">Status</th>
                    <th style="width:50px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ammended_contracts as $key=>$ammended_contract)
                <tr>
                    <td>{{ $key+1}}</td>
                    <td><a href="/contract/{{$ammended_contract->contract_id}}/view">{{$ammended_contract->contract_title}}</a></td>
                    <td><a href="/contract-party/{{$ammended_contract->party_id}}/view-contract-party" target="_blank">
                                                                                                                     <span class="label" style="background-color:#FFF;color:#0073b7;border:1px solid #0073b7;">
                                                                                                                        <i class="fa fa-briefcase fa-fw"></i> {{$ammended_contract->party_name}}</a></span>
                    </td>
                    <td>{{date("d-m-Y",strtotime($ammended_contract->effective_date))}}</td>
                    @if($ammended_contract->expiry_date == '')
                    <td>N/A</td>
                    @else
                    <td>{{date("d-m-Y",strtotime($ammended_contract->expiry_date))}}</td>
                    @endif
                    <td><span class="pull-right-container">
                        @if($ammended_contract->contract_status == 'created')
                        <small class="label pull-center btn-warning">{{$ammended_contract->contract_status}}</small></span>                        @elseif($ammended_contract->contract_status == 'pending')
                        <small class="label pull-center btn-info">{{ $ammended_contract->contract_status}}</small></span>
                        @elseif($ammended_contract->contract_status== 'submitted')
                        <small class="label label-success">{{$ammended_contract->contract_status}}</small></span>
                        @elseif($ammended_contract->contract_status== 'Amended')
                        <small class="label pull-center btn-danger">{{$ammended_contract->contract_status}}</small></span>
                        @elseif($ammended_contract->contract_status== 'approved')
                        <small class="label pull-center btn-success">{{$ammended_contract->contract_status}}</small></span>
                        @elseif($ammended_contract->contract_status== 'terminated')
                        <small class="label pull-center btn-danger">{{$ammended_contract->contract_status}}</small></span>
                    </td>
                    @endif
                    </td>
                    <td>
                        <div class="btn-group">
                            <a class="btn btn-info btn-block btn-sm btn-flat" href="/contract/{{$ammended_contract->contract_id}}/view"><i class="fa fa-eye"></i> View</a>
                        </div>
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
