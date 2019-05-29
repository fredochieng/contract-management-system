@extends('adminlte::page')
@section('title', 'Wananchi Legal | View Report')
@section('content_header')
@if($report_type=='status')
    @if($status=='1')
         <h1 class="pull-left">View Reports<small Pending contracts for duration {{$from}} - {{$to}}</small></h1>
         @elseif($status==2)
         <h1 class="pull-left">View Reports<small> Reviewed contracts for duration {{$from}} - {{$to}}</small></h1>
         @elseif($status==3)
         <h1 class="pull-left">View Reports<small>Approved contracts for duration {{$from}} - {{$to}}</small></h1>
         @elseif($status==4)
         <h1 class="pull-left">View Reports<small>Closed contracts for duration {{$from}} - {{$to}}</small></h1>
         @elseif($status==5)
         <h1 class="pull-left">View Reports<small>All contracts for duration {{$from}} - {{$to}}</small></h1>
    @endif
@elseif($report_type=='contract_type')
<h1 class="pull-left">View Reports<small>{{$contract_type_name}} contracts</small></h1>
@elseif($report_type=='contract_party')
<h1 class="pull-left">View Reports<small>{{$party->party_name}} contracts</small></h1>
@elseif($report_type=='contract_expiry')
    @if($expiry_id==1)
    <h1 class="pull-left">View Reports<small>Active contracts</small></h1>
    @elseif($expiry_id==2)
    <h1 class="pull-left">View Reports<small>Expired contracts</small></h1>
    @endif
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
                                <th>Date Created</th>
                                 {{--  @if($status==3)
                                <th>Date Approved</th>  --}}
                                @if($status==4)
                                <th>Date Closed</th>
                                @endif
                                <th>Status</th>
                                {{--  @if($status=='Closed')
                                <th>Type of Contract</th>
                                @endif
                                <th>Date Created</th>
                                @if($status==2)
                                <th>Draft Sent Date</th>
                                @elseif($status==3)
                                <th>Date Approved</th>
                                @elseif($status==4)
                                <th>Date Closed</th>
                                @endif  --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contracts as $key=>$collection)
                            <tr>
                                <td>{{ $key+1}}</td>
                              <td><a href="/contract/{{$collection->contract_id}}/view">{{$collection->contract_code}}</a>
                            </td>
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
                                @if($collection->name == '')
                                <td>Not assigned</td>
                                @else
                                <td>{{$collection->name}}</td>
                                @endif

                                @if($status=='Closed')
                                <td>{{$collection->contract_type_name}}</td>
                                @endif

                                <td>{{date("Y-m-d H:m:s",strtotime($collection->created_date))}}
                               </td>
                                <td>{{date("Y-m-d H:m:s",strtotime($collection->date))}}
                               </td>
<td><span class="pull-right-container">
        <small class="badge bg-{{ $collection->label_color }}">{{$collection->status_name}}</small></span>
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
                                <th>Date Created</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contract_type_report as $key=>$collection1)
                            <tr>
                                <td>{{ $key+1}}</td>
                             <td><a href="/contract/{{$collection1->contract_id}}/view">{{$collection1->contract_code}}</a>
                                </td>
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
                              @if($collection1->name == '')
                            <td>Not assigned</td>
                            @else
                            <td>{{$collection1->name}}</td>
                            @endif
                                <td>{{date("Y-m-d H:m:s",strtotime($collection1->created_at))}}
                                </td>
                                <td><span class="pull-right-container">
                                        <small class="badge bg-{{ $collection1->label_color }}">{{$collection1->status_name}}</small></span>
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
                                <th>Date Created</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contract_party_report as $key=>$collection1)
                            <tr>
                                <td>{{ $key+1}}</td>
                            <td><a href="/contract/{{$collection1->contract_id}}/view">{{$collection1->contract_code}}</a>
                            </td>
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
                              @if($collection1->name == '')
                            <td>Not assigned</td>
                            @else
                            <td>{{$collection1->name}}</td>
                            @endif
                                <td>{{date("Y-m-d H:m:s",strtotime($collection1->created_date))}}
                                </td>
                                <td><span class="pull-right-container">
                                            <small class="badge bg-{{ $collection1->label_color }}">{{$collection1->status_name}}</small></span>
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
@elseif($report_type=='contract_expiry')
<div class="row">
    <div class="col-xs-12">
        <div class="box box-success">
            <div class="box-body">
                <div class="table-responsive">
                    <table id="example1" class="table no-margin">
                        <thead>
                            <tr>
                                <th>Ticket #</th>
                                <th>Contract Title</th>
                                <th>Party Name</th>
                                <th>Reviewer</th>
                                <th>Date Created</th>
                                <th>Status</th>
                                <th>Expiry Alert</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contract_expiry_report as $key=>$collection1)
                            @if($expiry_id==2)
                            <?php if($collection1->expired == 0 ){ continue; } ?>
                            @elseif($expiry_id==1)
                            <?php if($collection1->expired == 1 ){ continue; } ?>
                            @endif

                            <tr>
                                <td><a
                                        href="/contract/{{$collection1->contract_id}}/view">{{$collection1->contract_code}}</a>
                                </td>
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
                                @if($collection1->name == '')
                                <td>Not assigned</td>
                                @else
                                <td>{{$collection1->name}}</td>
                                @endif
                                <td>{{date("Y-m-d H:m:s",strtotime($collection1->created_date))}}
                                </td>

                                <td><span class="pull-right-container">
                                        <small
                                            class="badge bg-{{ $collection1->label_color }}">{{$collection1->status_name}}</small></span>
                                </td>
                                @if($collection1->expired==1)
                                <td><span class="pull-right-container"><small class="badge bg-red">Expired</small></span> </td>
                                </td>
                                @else
                                <td><span class="pull-right-container">
                                        <small class="badge bg-aqua">Active</small></span>
                                </td>
                                @endif
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
