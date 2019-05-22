@extends('adminlte::page')
@section('title', 'Wananchi Legal | My Assigned Contracts')
@section('content_header')
<h1 class="pull-left">Contracts<small>My Assigned Contracts</small></h1>
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
                                                <th>Date Created</th>
                                                <th>Expiry Date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($assigned_contracts as $key=>$approved_contract)
                                            <tr>
                                                <td>{{ $key+1}}</td>
                                                <td><a href="/contract/{{$approved_contract->contract_id}}/view">{{$approved_contract->contract_code}}</a>
                                                </td>
                                                <td><a href="/contract/{{$approved_contract->contract_id}}/view">{{$approved_contract->contract_title}}</a>
                                                </td>
                                                <td><a href="/contract-party/{{$approved_contract->party_id}}/view-contract-party" target="_blank">
                                                        <span class="label" style="background-color:#FFF;color:#0073b7;border:1px solid #0073b7;">
                                                            <i class="fa fa-briefcase fa-fw"></i>
                                                            {{$approved_contract->party_name}} </a></span>
                                                </td>
                                                <td>{{ $approved_contract->created_date }}</td>
                                                <td>{{ $approved_contract->expiry_date}}</td>
                                                <td><span class="pull-right-container">
                                                        <small class="badge bg-blue">{{$approved_contract->status_name}}</small></span>
                                                </td>

                                                <td>
                                                    <div class="btn-group">
                                                        <a class="btn btn-info btn-block btn-sm btn-flat"
                                                            href="/contract/{{$approved_contract->contract_id}}/view"><i class="fa fa-eye"></i> View</a>
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
