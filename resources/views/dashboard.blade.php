@extends('adminlte::page')
@section('title', 'CMS | Dashboard')
@section('content_header')
<h1>Dashboard</h1>






@stop
@section('content')
<div class="row">
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3>{{ $published_contract_count }}</h3>
                <p>Pending Contracts</p>
            </div>
            <div class="icon">
                <i class="fa fa-desktop"></i>
            </div>
            <a href="pending-contracts" class="small-box-footer">View Contracts  <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-blue">
            <div class="inner">
                <h3>{{ $ammended_contract_count }}</h3>
                <p>Ammended Contracts</p>
            </div>
            <div class="icon">
                <i class="fa fa-certificate"></i>
            </div>
            <a href="ammended-contracts" class="small-box-footer">View Contracts  <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-green">
            <div class="inner">
                <h3>{{ $approved_contract_count }}</h3>
                <p>Approved Contracts</p>
            </div>
            <div class="icon">
                <i class="fa fa-briefcase"></i>
            </div>
            <a href="approved-contracts" class="small-box-footer">View Contracts  <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-red">
            <div class="inner">
                <h3>{{ $terminated_contract_count }}</h3>
                <p>Terminated Contracts</p>
            </div>
            <div class="icon">
                <i class="fa fa-rocket"></i>
            </div>
            <a href="terminated-contracts" class="small-box-footer">View Contracts  <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
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
                </button> {{-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>                    --}}
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                            <tr>
                                <th style="width:25px;">S/N</th>
                                <th style="width:200px;">Contract Title</th>
                                <th style="width:160px;">Party Name</th>
                                {{--
                                <th style="width:145px;">Uploads</th> --}} {{--
                                <th style="width:145px;">Submitted By</th> --}}
                                <th style="width:145px;">Date</th>
                                {{--
                                <th style="width:90px;">Effective Date</th>
                                <th style="width:90px;">Expiry Date</th> --}}

                                <th style="width:145px;">Status</th>
                                @if(auth()->check()) @if (auth()->user()->isAdmin() || auth()->user()->isLegal())
                                <th style="width:70px;">Alert</th>
                                {{--
                                <th style="width:70px;">Assign</th> --}} @endif @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contracts as $key=>$contract)
                            <tr>
                                <td>{{ $key+1}}</td>
                                <td><a href="/contract/{{$contract->contract_id}}/view">{{$contract->contract_title}}</a></td>
                                <td><a href="/contract-party/{{$contract->party_id}}/view-contract-party" target="_blank">
                                                                                    <span class="label" style="background-color:#FFF;color:#0073b7;border:1px solid #0073b7;">
                                                                                    <i class="fa fa-briefcase fa-fw"></i> {{$contract->party_name}}	</a></span>
                                </td>
                                {{--
                                <td><a href="/{{$contract->draft_file}}" target="_blank"><i class="fa fa-fw fa-download"></i> Contract</a>                                    |
                                    <a href="/{{$contract->draft_file}}" target="_blank"><i class="fa fa-fw fa-download"></i> CRF</a>
                                </td> --}} {{--
                                <td>{{$contract->name}}</td> --}}
                                <td>{{$contract->created_at}}</td>
                                {{--
                                <td>{{date("d-m-Y",strtotime($contract->effective_date))}}</td>
                                <td>{{ date("d-m-Y",strtotime($contract->expiry_date))</td> }} --}}
                                <td><span class="pull-right-container">
                                                                    @if($contract->contract_status == 'created')
                                                                    <small class="badge bg-purple">{{$contract->contract_status}}</small></span>                                    @elseif($contract->contract_status == 'published')
                                    <small class="badge bg-yellow">{{ $contract->contract_status}}</small></span>
                                    @elseif($contract->contract_status== 'ammended')
                                    <small class="badge bg-blue">{{$contract->contract_status}}</small></span>
                                    @elseif($contract->contract_status== 'approved')
                                    <small class="badge bg-green">{{$contract->contract_status}}</small></span>
                                    @elseif($contract->contract_status== 'terminated')
                                    <small class="badge bg-red">{{$contract->contract_status}}</small></span>
                                </td>
                                @endif
                                </td>
                                @if(auth()->check()) @if (auth()->user()->isAdmin() || auth()->user()->isLegal())
                                <td>
                                    @if ($contract->assigned=='' && $contract->escalation_duration >=1)
                                    <span class="label" style="background-color:#FFF;color:#ff0000;border:1px solid #ff0000">Overdue</span>                                    @elseif ($contract->assigned=='' && $contract->escalation_duration
                                    <1) <span class="label" style="background-color:#FFF;color:#1e3fda;border:1px solid #1e3fda">Open</span>
                                        @else
                                        <span class="label" style="background-color:#FFF;color:#058e29;border:1px solid #058e29">Assigned</span>                                        @endif
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
                    <a href="pending-contracts" class="uppercase">View All Approved Contracts</a>
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
                <h3 class="box-title">Latest Approved Contracts</h3>
                @elseif(auth()->user()->isUser())
                <h3 class="box-title">Latest Ammended Contracts</h3>
                @endif @endif
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button> {{-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>                    --}}
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                            <tr>
                                <th style="width:25px;">S/N</th>
                                <th style="width:300px;">Contract Title</th>
                                <th style="width:160px;">Party Name</th>
                                {{--
                                <th style="width:145px;">Uploads</th> --}} {{--
                                <th style="width:145px;">Submitted By</th> --}}
                                <th style="width:145px;">Date</th>
                                {{--
                                <th style="width:90px;">Effective Date</th>
                                <th style="width:90px;">Expiry Date</th> --}}
                                <th style="width:50px;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contracts1 as $key=>$contract1)
                            <tr>
                                <td>{{ $key+1}}</td>
                                <td><a href="/contract/{{$contract1->contract_id}}/view">{{$contract1->contract_title}}</a></td>
                                <td><a href="/contract-party/{{$contract1->party_id}}/view-contract-party" target="_blank">
                                                                                                                        <span class="label" style="background-color:#FFF;color:#0073b7;border:1px solid #0073b7;">
                                                                                                                        <i class="fa fa-briefcase fa-fw"></i> {{$contract1->party_name}}	</a></span>
                                </td>
                                {{--
                                <td><a href="/{{$contract->draft_file}}" target="_blank"><i class="fa fa-fw fa-download"></i> Contract</a>                                    |
                                    <a href="/{{$contract->draft_file}}" target="_blank"><i class="fa fa-fw fa-download"></i> CRF</a>
                                </td> --}} {{--
                                <td>{{$contract->name}}</td> --}}
                                <td>{{$contract1->created_at}}</td>
                                {{--
                                <td>{{date("d-m-Y",strtotime($contract->effective_date))}}</td>
                                <td>{{ date("d-m-Y",strtotime($contract->expiry_date))</td> }} --}}
                                <td><span class="pull-right-container">
                                            @if($contract1->contract_status == 'created')
                                            <small class="badge bg-purple">{{$contract1->contract_status}}</small></span>                                    @elseif($contract1->contract_status == 'published')
                                    <small class="badge bg-yellow">{{ $contract1->contract_status}}</small></span>
                                    @elseif($contract1->contract_status== 'ammended')
                                    <small class="badge bg-blue">{{$contract1->contract_status}}</small></span>
                                    @elseif($contract1->contract_status== 'approved')
                                    <small class="badge bg-green">{{$contract1->contract_status}}</small></span>
                                    @elseif($contract1->contract_status== 'terminated')
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
                    <a href="approved-contracts" class="uppercase">View All Approved Contracts</a>
                </div>
                @else
                <div class="box-footer text-center">
                    <a href="approved-contracts" class="uppercase">View All Ammended Contracts</a>
                </div>
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
                    <!-- /.progress-group -->
                    @if(auth()->check()) @if (auth()->user()->isAdmin() || auth()->user()->isUser())
                    <div class="progress-group">
                        <span class="progress-text">Pending Contracts</span>
                        <span class="progress-number"><b>{{ $published_contract_count }}</b>/{{ $total_contracts_count }}</span>

                        <div class="progress sm">
                            <div class="progress-bar progress-bar-yellow" style="width: {{ $published_percentage }}%"></div>
                        </div>
                    </div>
                    @else @endif @endif
                    <div class="progress-group">
                        <span class="progress-text">Approved Contracts</span>
                        <span class="progress-number"><b>{{ $approved_contract_count }}</b>/{{ $total_contracts_count }}</span>

                        <div class="progress sm">
                            <div class="progress-bar progress-bar-green" style="width: {{ $approved_percentage }}%"></div>
                        </div>
                    </div>
                    <!-- /.progress-group -->
                    <div class="progress-group">
                        <span class="progress-text">Ammended Contracts</span>
                        <span class="progress-number"><b>{{ $ammended_contract_count }}</b>/{{ $total_contracts_count }}</span>

                        <div class="progress sm">
                            <div class="progress-bar progress-bar-blue" style="width: {{ $ammended_percentage }}%"></div>
                        </div>
                    </div>
                    <div class="progress-group">
                        <span class="progress-text">Terminated Contracts</span>
                        <span class="progress-number"><b>{{ $terminated_contract_count }}</b>/{{ $total_contracts_count }}</span>

                        <div class="progress sm">
                            <div class="progress-bar progress-bar-red" style="width: {{ $terminated_percentage }}%"></div>
                        </div>
                    </div>
                </div>
                <div class="box-footer text-center">
                    <a href="approved-contracts" class="uppercase"></a>
                </div>
                <div class="box-footer text-center">
                    <a href="approved-contracts" class="uppercase">View All Contracts</a>
                </div>
            </div>
            <!-- /.box-body -->
            <!-- /.box-footer -->
        </div>
        @if(auth()->check()) @if (auth()->user()->isAdmin())
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
        @endif @endif
    </div>
</div>





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
