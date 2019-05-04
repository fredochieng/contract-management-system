@extends('adminlte::page')
@section('title', 'CMS | View Report')
@section('content_header')
@if($report_type=='status')
<h1 class="pull-left">View Reports<small>{{$status}} contracts for duration {{$from}} - {{$to}}</small></h1>
@elseif($report_type=='contract_type')
<h1 class="pull-left">View Reports<small>{{$contract_type_name}} contracts</small></h1>
@elseif($report_type=='contract_party')
<h1 class="pull-left">View Reports<small>{{$party->party_name}} contracts</small></h1>
@endif
<div style="clear:both"></div>

@stop

@section('content')
@if($report_type=='status')
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
                                <th>Reviewer</th>
                                @if($status=='Closed')
                                <th>Type of Contract</th>
                                @endif
                                @if($status=='Closed')
                                <th>Signed Contract</th>
                                @elseif($status=='Amended')
                                <th>Amended Contract</th>
                                @elseif($status=='Terminated' || 'Pending' || 'Approved')
                                <th>Contract Draft</th>
                                @endif
                                <th>Date Uploaded</th>
                                @if($status=='Closed')
                                <th>Date Closed</th>
                                @elseif($status=='Amended')
                                <th>Date Amended</th>
                                @elseif($status=='Terminated')
                                <th>Date Terminated</th>
                                @elseif($status=='Pending')
                                <th>Date Submitted</th>
                                @elseif($status=='Approved')
                                <th>Date Approved</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contracts as $key=>$collection)
                            <tr>
                                <td>{{ $key+1}}</td>
                                <td>{{$collection->contract_code}}</td>
                                <td><a
                                        href="/contract/{{$collection->contract_id}}/view">{{$collection->contract_title}}</a>
                                </td>
                                <td><a href="/contract-party/{{$collection->party_id}}/view-contract-party"
                                        target="_blank">
                                        <span class="label"
                                            style="background-color:#FFF;color:#0073b7;border:1px solid #0073b7;">
                                            <i class="fa fa-briefcase fa-fw"></i>
                                            {{$collection->party_name}} </a></span>
                                </td>
                                <td>{{$collection->name}}</td>
                                @if($status=='Closed')
                                <td>{{$collection->contract_type_name}}</td>
                                @endif
                                <td><a href="/{{$collection->draft_file}}" target="_blank"><i
                                            class="fa fa-fw fa-download"></i> Contract</a>
                                </td>
                                <td>{{date("Y-m-d",strtotime($collection->published_time))}}
                                </td>
                                <td>{{date("Y-m-d",strtotime($collection->action_date))}}
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
@elseif($report_type=='contract_type')
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
                                <th>Reviewer</th>
                                <th>Signed Contract</th>
                                <th>Date Uploaded</th>
                                <th>Date Closed</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contract_type_report as $key=>$collection1)
                            <tr>
                                <td>{{ $key+1}}</td>
                                <td>{{$collection1->contract_code}}</td>
                                <td><a
                                        href="/contract/{{$collection1->contract_id}}/view">{{$collection1->contract_title}}</a>
                                </td>
                                <td><a href="/contract-party/{{$collection1->party_id}}/view-contract-party"
                                        target="_blank">
                                        <span class="label"
                                            style="background-color:#FFF;color:#0073b7;border:1px solid #0073b7;">
                                            <i class="fa fa-briefcase fa-fw"></i>
                                            {{$collection1->party_name}} </a></span>
                                </td>
                                <td>{{$collection1->name}}</td>
                                <td><a href="/{{$collection1->draft_file}}" target="_blank"><i
                                            class="fa fa-fw fa-download"></i> Contract</a>
                                </td>
                                <td>{{date("Y-m-d",strtotime($collection1->published_time))}}
                                </td>
                                <td>{{date("Y-m-d",strtotime($collection1->action_date))}}
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
@elseif($report_type=='contract_party')
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
                                <th>Reviewer</th>
                                <th>Signed Contract</th>
                                <th>Date Uploaded</th>
                                <th>Date Closed</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contract_party_report as $key=>$collection1)
                            <tr>
                                <td>{{ $key+1}}</td>
                                <td>{{$collection1->contract_code}}</td>
                                <td><a
                                        href="/contract/{{$collection1->contract_id}}/view">{{$collection1->contract_title}}</a>
                                </td>
                                <td><a href="/contract-party/{{$collection1->party_id}}/view-contract-party"
                                        target="_blank">
                                        <span class="label"
                                            style="background-color:#FFF;color:#0073b7;border:1px solid #0073b7;">
                                            <i class="fa fa-briefcase fa-fw"></i>
                                            {{$collection1->party_name}} </a></span>
                                </td>
                                <td>{{$collection1->name}}</td>
                                <td><a href="/{{$collection1->draft_file}}" target="_blank"><i
                                            class="fa fa-fw fa-download"></i> Contract</a>
                                </td>
                                <td>{{date("Y-m-d",strtotime($collection1->published_time))}}
                                </td>
                                <td>{{date("Y-m-d",strtotime($collection1->action_date))}}
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
@endif
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
});
</script>
@stop
