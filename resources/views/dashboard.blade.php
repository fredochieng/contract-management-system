@extends('adminlte::page')
@section('title', 'Wananchi Legal | Dashboard')
@section('content_header')
<h1>Dashboard</h1>
@stop
@section('content')
<div class="row">
    <a href="pending-contracts">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-yellow">
                <span class="info-box-icon"><i class="fa fa-desktop"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><b>Pending</b></span>
                    <span class="info-box-number">{{ $draft_created_count }}</span>
                    <div class="progress">
                        <div class="progress-bar" style="width:  {{ $draft_created_per }}%"></div>
                    </div>
                    <span class="progress-description">
                        {{-- 70% Increase in 30 Days --}}
                        View Contracts
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
    </a>
    <a href="closed-contracts">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-blue">
                <span class="info-box-icon"><i class="fa fa-briefcase"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><b>Closed</b></span>
                    <span class="info-box-number">{{ $closed_contract_count }}</span>
                    <div class="progress">
                        <div class="progress-bar" style="width: {{ $closed_per }}%"></div>
                    </div>
                    <span class="progress-description">
                        View Contracts
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
    </a>
    <!-- /.col -->
    <a href="approved-contracts">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-green">
                <span class="info-box-icon"><i class="fa fa-thumbs-o-up"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><b>Approved</b></span>
                    <span class="info-box-number">{{ $approved_contract_count }}</span>
                    <div class="progress">
                        <div class="progress-bar" style="width: {{ $approved_per }}%"></div>
                    </div>
                    <span class="progress-description">
                        View Contracts
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
    </a>
    <!-- /.col -->
    <a href="reviewed-contracts">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-aqua">
                <span class="info-box-icon"><i class="fa fa-certificate"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><b>Reviewed</b></span>
                    <span class="info-box-number">{{ $tot_reviewed_count }}</span>
                    <div class="progress">
                        <div class="progress-bar" style="width: {{ $reviewed_per }}%"></div>
                    </div>
                    <span class="progress-description">
                        View Contracts
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
    </a>
    <!-- /.col -->
</div>

<div class="row">
    <div class="col-md-8">
        <div class="box box-success">
            <div class="box-header with-border">
                @if(auth()->check()) @if (auth()->user()->isAdmin() || auth()->user()->isLegal())
                <h3 class="box-title">Latest Pending Contracts</h3>
                @elseif(auth()->user()->isUser())
                <h3 class="box-title">Latest Approved Contracts</h3>
                @endif @endif
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    {{-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>                    --}}
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="">
                <div class="table-responsive">
                    <table id="example1" class="table no-margin">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Ticket</th>
                                <th>Contract Title</th>
                                <th>Party Name</th>
                                <th>Date Created</th>
                                @if(auth()->check()) @if (auth()->user()->isAdmin() || auth()->user()->isLegal())
                                <th>Alert</th>
                                @endif @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contracts as $key=>$contract)
                            <tr>
                                <td>{{ $key+1}}</td>
                                <td><a href="/contract/{{$contract->contract_id}}/view">{{$contract->contract_code}}</a>
                                </td>
                                <td><a
                                        href="/contract/{{$contract->contract_id}}/view">{{$contract->contract_title}}</a>
                                </td>
                                <td><a href="/contract-party/{{$contract->party_id}}/view-contract-party"
                                        target="_blank">
                                        <span class="label"
                                            style="background-color:#FFF;color:#0073b7;border:1px solid #0073b7;">
                                            <i class="fa fa-briefcase fa-fw"></i> {{$contract->party_name}} </a></span>
                                </td>
                                <td>{{$contract->created_date}}</td>
                                </td>
                                @if(auth()->check()) @if (auth()->user()->isAdmin() || auth()->user()->isLegal())
                                <td>
                                    @if ($contract->assigned=='' && $contract->escalation_duration >=1)
                                    <span class="label"
                                        style="background-color:#FFF;color:#ff0000;border:1px solid #ff0000">Overdue</span>
                                    @elseif ($contract->assigned=='' && $contract->escalation_duration
                                    <1) <span class="label"
                                        style="background-color:#FFF;color:#1e3fda;border:1px solid #1e3fda">Open</span>
                                        @else
                                        <span class="label"
                                            style="background-color:#FFF;color:#058e29;border:1px solid #058e29">Assigned</span>
                                        @endif
                                </td>
                                @endif @endif {!! Form::close() !!}
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if(auth()->check()) @if (auth()->user()->isAdmin() || auth()->user()->isLegal())
                <div class="box-footer text-center">
                    <a href="pending-contracts" class="uppercase">View All Pending Contracts</a>
                </div>
                @else
                <div class="box-footer text-center">
                    <a href="approved-contracts" class="uppercase">View All Approved Contracts</a>
                </div>
                @endif @endif
                <!-- /.table-responsive -->

            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix" style="">

            </div>
            <!-- /.box-footer -->
        </div>
        <div class="box box-success">
            <div class="box-header with-border">
                @if(auth()->check()) @if (auth()->user()->isAdmin() || auth()->user()->isLegal())
                <h3 class="box-title">Latest Closed Contracts</h3>
                @elseif(auth()->user()->isUser())
                <h3 class="box-title">Latest Closed Contracts</h3>
                @endif @endif
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    {{-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>                    --}}
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Ticket #</th>
                                <th>Contract Title</th>
                                <th>Party Name</th>
                                {{--  <th>Date Reviewed</th>  --}}
                                <th>Expiry Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contracts1 as $key=>$contract1)
                            <tr>
                                <td>{{ $key+1}}</td>
                                <td><a
                                        href="/contract/{{$contract1->contract_id}}/view">{{$contract1->contract_code}}</a>
                                </td>
                                <td><a
                                        href="/contract/{{$contract1->contract_id}}/view">{{$contract1->contract_title}}</a>
                                </td>
                                <td><a href="/contract-party/{{$contract1->party_id}}/view-contract-party"
                                        target="_blank">
                                        <span class="label"
                                            style="background-color:#FFF;color:#0073b7;border:1px solid #0073b7;">
                                            <i class="fa fa-briefcase fa-fw"></i> {{$contract1->party_name}} </a></span>
                                </td>
                                <td>{{ date('Y-m-d', strtotime($contract1->expiry_date))}}</td>
                                <td><span class="pull-right-container">
                                        @if($contract1->contract_status == 'Created')
                                        <small class="badge bg-purple">{{$contract1->contract_status}}</small></span>
                                    @elseif($contract1->contract_status == 'Pending')
                                    <small class="badge bg-yellow">{{ $contract1->contract_status}}</small></span>
                                    @elseif($contract1->contract_status== 'Amended')
                                    <small class="badge bg-blue">{{$contract1->contract_status}}</small></span>
                                    @elseif($contract1->contract_status== 'Approved')
                                    <small class="badge bg-green">{{$contract1->contract_status}}</small></span>
                                    @elseif($contract1->contract_status== 'Closed')
                                    <small class="badge bg-aqua">{{$contract1->contract_status}}</small></span>
                                    @elseif($contract1->contract_status== 'Terminated')
                                    <small class="badge bg-purple">{{$contract1->contract_status}}</small></span>
                                </td>
                                @endif
                                </td>
                                {!! Form::close() !!}
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if(auth()->check()) @if (auth()->user()->isAdmin() || auth()->user()->isLegal())
                <div class="box-footer text-center">
                    <a href="closed-contracts" class="uppercase">View All Closed Contracts</a>
                </div>
                {{--  @else
                <div class="box-footer text-center">
                    <a href="approved-contracts" class="uppercase">View All Amended Contracts</a>
                </div>  --}}
                @endif @endif
                <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix" style="">
            </div>
            <!-- /.box-footer -->
        </div>
    </div>

    <div class="col-md-4">
        @if(auth()->check()) @if (auth()->user()->isLegal())
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">My Assigned Contracts</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Ticket #</th>
                                <th>Contract Title</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($assigned_contracts as $key=>$assigned_contract)
                            <tr>
                                <td>{{ $key+1}}</td>
                                <td><a
                                        href="/contract/{{$assigned_contract->contract_id}}/view">{{$assigned_contract->contract_code}}</a>
                                </td>
                                <td><a
                                        href="/contract/{{$assigned_contract->contract_id}}/view">{{$assigned_contract->contract_title}}</a>
                                </td>
                                {!! Form::close() !!}
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="box-footer text-center">
                    <a href="my-assigned-contracts" class="uppercase">View My Assigned Contracts</a>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix" style="">
            </div>
            <!-- /.box-footer -->
        </div>
        @elseif(auth()->user()->isAdmin() || auth()->user()->isUser())
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Contracts Statistics</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                            class="fa fa-minus"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="">
                <div class="col-md-12">
                    <!-- /.progress-group -->
                    @if(auth()->check()) @if (auth()->user()->isAdmin() || auth()->user()->isUser())
                    <div class="progress-group">
                        <span class="progress-text">Pending Contracts</span>
                        <span
                            class="progress-number"><b>{{ $draft_created_count }}</b>/{{ $total_contracts_count }}</span>

                        <div class="progress sm">
                            <div class="progress-bar progress-bar-yellow" style="width: {{ $draft_created_per }}%">
                            </div>
                        </div>
                    </div>
                    @else @endif @endif
                    <div class="progress-group">
                        <span class="progress-text">Reviewed Contracts</span>
                        <span
                            class="progress-number"><b>{{ $tot_reviewed_count }}</b>/{{ $total_contracts_count }}</span>

                        <div class="progress sm">
                            <div class="progress-bar progress-bar-aqua" style="width: {{ $reviewed_per }}%">
                            </div>
                        </div>
                    </div>
                    <div class="progress-group">
                        <span class="progress-text">Approved Contracts</span>
                        <span
                            class="progress-number"><b>{{ $approved_contract_count }}</b>/{{ $total_contracts_count }}</span>

                        <div class="progress sm">
                            <div class="progress-bar progress-bar-green" style="width: {{ $approved_per }}%">
                            </div>
                        </div>
                    </div>
                    <div class="progress-group">
                        <span class="progress-text">Closed Contracts</span>
                        <span
                            class="progress-number"><b>{{ $closed_contract_count }}</b>/{{ $total_contracts_count }}</span>

                        <div class="progress sm">
                            <div class="progress-bar progress-bar-blue" style="width: {{ $closed_per}}%"></div>
                        </div>
                    </div>
                    <!-- /.progress-group -->
                    {{-- <div class="progress-group">
                        <span class="progress-text">Amended Contracts</span>
                        <span
                            class="progress-number"><b>{{ $ammended_contract_count }}</b>/{{ $total_contracts_count }}</span>

                    <div class="progress sm">
                        <div class="progress-bar progress-bar-blue" style="width: {{ $ammended_percentage }}%">
                        </div>
                    </div>
                </div> --}}
                {{-- <div class="progress-group">
                        <span class="progress-text">Terminated Contracts</span>
                        <span
                            class="progress-number"><b>{{ $terminated_contract_count }}</b>/{{ $total_contracts_count }}</span>

                <div class="progress sm">
                    <div class="progress-bar progress-bar-red" style="width: {{ $terminated_percentage }}%">
                    </div>
                </div>
            </div> --}}
        </div>
        <div class="box-footer text-center">
            <a href="approved-contracts" class="uppercase"></a>
        </div>
        <div class="box-footer text-center">
            {{--  <a href="approved-contracts" class="uppercase">View All Contracts</a>  --}}
        </div>
    </div>
    <!-- /.box-body -->
    <!-- /.box-footer -->
</div>
@endif @endif @if(auth()->check()) @if (auth()->user()->isAdmin())
<div class="box box-success">
    <div class="box-header with-border">
        @if(auth()->check()) @if (auth()->user()->isAdmin() || auth()->user()->isLegal())
        <h3 class="box-title">Latest Contract Parties</h3>
        @else @endif @endif
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body" style="">
        <div class="table-responsive">
            <table class="table no-margin">
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Party Name</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($parties as $key=>$party)
                    <tr>
                        <td>{{ $key+1}}</td>
                        <td><a href="/contract-party/{{$party->party_id}}/view-contract-party" target="_blank">
                                {{$party->party_name}}</a>
                        </td>
                        <td>{{$party->email}}</td>
                        </td>
                        {!! Form::close() !!}
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="box-footer text-center">
            <a href="approved-contracts" class="uppercase">View All Contract Parties</a>
        </div>
        <!-- /.table-responsive -->
    </div>
    <!-- /.box-body -->
    <div class="box-footer clearfix" style="">
    </div>
    <!-- /.box-footer -->
</div>
@elseif(auth()->user()->isLegal())
<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">Contracts Statistics</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body" style="">
        <div class="col-md-12">
            <div class="progress-group">
                <span class="progress-text">Reviewed Contracts</span>
                <span class="progress-number"><b>{{ $draft_review_count }}</b>/{{ $total_contracts_count }}</span>

                <div class="progress sm">
                    <div class="progress-bar progress-bar-grey" style="width: {{ $draft_review_per }}%"></div>
                </div>
            </div>
            <!-- /.progress-group -->
            <div class="progress-group">
                <span class="progress-text">Approved Contracts</span>
                <span class="progress-number"><b>{{ $approved_contract_count }}</b>/{{ $total_contracts_count }}</span>

                <div class="progress sm">
                    <div class="progress-bar progress-bar-blue" style="width: {{ $approved_per }}%">
                    </div>
                </div>
            </div>
            <div class="progress-group">
                <span class="progress-text">Closed Contracts</span>
                <span class="progress-number"><b>{{ $closed_contract_count }}</b>/{{ $total_contracts_count }}</span>

                <div class="progress sm">
                    <div class="progress-bar progress-bar-blue" style="width: {{ $closed_per }}%">
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer text-center">
            <a href="approved-contracts" class="uppercase"></a>
        </div>
        <div class="box-footer text-center">
            {{--  <a href="approved-contracts" class="uppercase">View All Contracts</a>  --}}
        </div>
    </div>
    <!-- /.box-body -->
    <!-- /.box-footer -->
</div>
@endif @endif
</div>
</div>

<!-- PAGE FOOTER -->
@stop
@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<link rel="stylesheet" href="/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="/css/select2.min.css">
@stop
@section('js')
<script src="/js/bootstrap-datepicker.min.js"></script>
<script src="/js/select2.full.min.js"></script>
<script src="/js/bootbox.min.js"></script>

<script>
    $(function () {
         $('#example1').DataTable()
         $('#example2').DataTable()
         $('#example3').DataTable()
         $('#example4').DataTable()
         //Initialize Select2 Elements
          $('.select2').select2()
        $(document).ready(function() {
});
    });
</script>
@stop
