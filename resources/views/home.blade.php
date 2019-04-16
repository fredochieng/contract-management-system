@extends('adminlte::page')
@section('title', 'Contract Management System')
@section('content_header')
<h1>Dashboard</h1>
@stop
@section('content')
<div class="row">
    @if (auth()->check()) @if (auth()->user()->isAdmin())
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>{{ $submitted_contract_count }}</h3>
                <p>Submitted Contracts</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>

        </div>
    </div>
    @elseif(auth()->user()->isLegal())
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-purple">
            <div class="inner">
                <h3>{{ $published_contract_count }}</h3>
                <p>Pending Contracts</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>

        </div>
    </div>
    @elseif(auth()->user()->isUser())
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3>{{ $ammended_contract_count }}</h3>
                <p>Ammended Contracts</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>

        </div>
    </div>
    @endif @endif
@if (auth()->check()) @if (auth()->user()->isAdmin() || auth()->user()->isUser())
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-purple">
            <div class="inner">
                <h3>{{ $published_contract_count }}</h3>
                <p>Pending Contracts</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>

        </div>
    </div>
    @elseif(auth()->user()->isLegal())
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3>{{ $ammended_contract_count }}</h3>
                <p>Ammended Contracts</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>

        </div>
    </div>
    @endif @endif
  @if (auth()->check()) @if (auth()->user()->isAdmin() || auth()->user()->isUser())
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-green">
            <div class="inner">
                <h3>{{ $approved_contract_count }}</h3>
                <p>Approved Contracts</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>

        </div>
    </div>
    @elseif(auth()->user()->isLegal())
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>{{ $submitted_contract_count }}</h3>
                <p>Submitted Contracts</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>

        </div>
    </div>
    @endif @endif
    @if (auth()->check()) @if (auth()->user()->isAdmin())
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3>{{ $ammended_contract_count }}</h3>
                <p>Ammended Contracts</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>

        </div>
    </div>
    <@elseif(auth()->user()->isLegal())
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-green">
            <div class="inner">
                <h3>{{ $approved_contract_count }}</h3>
                <p>Approved Contracts</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>

        </div>
    </div>
    @elseif(auth()->user()->isUser())
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-red">
            <div class="inner">
                <h3>{{ $terminated_contract_count }}</h3>
                <p>Terminated Contracts</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>

        </div>
    </div>
    @endif @endif
    <!-- ./col -->
</div>
<div class="row">
    <div class="col-md-6">
        <div class="box box-info">
            <div class="box-header with-border">
                @if(auth()->check()) @if (auth()->user()->isAdmin())
                <h3 class="box-title">Latest Submitted Contracts</h3>
                @elseif(auth()->user()->isLegal())
                <h3 class="box-title">Latest Published Contracts</h3>
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
                    <table id="example1" class="table no-margin">
                        <thead>
                            <tr>
                                <th style="width:25px;">S/N</th>
                                <th style="width:300px;">Contract Title</th>
                                <th style="width:160px;">Party Name</th>
                                {{--  <th style="width:145px;">Uploads</th>  --}}
                                {{--  <th style="width:145px;">Submitted By</th>  --}}
                                <th style="width:145px;">Date</th>
                                {{--
                                <th style="width:90px;">Effective Date</th>
                                <th style="width:90px;">Expiry Date</th> --}}
                                <th style="width:50px;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contracts as $key=>$contract)
                            <tr>
                                <td>{{ $key+1}}</td>
                                <td><a href="/contract/{{$contract->contract_id}}/view">{{$contract->contract_title}}</a></td>
                                <td>{{$contract->party_name}}</td>
                                {{--  <td><a href="/{{$contract->draft_file}}" target="_blank"><i class="fa fa-fw fa-download"></i> Contract</a>                                    |
                                    <a href="/{{$contract->draft_file}}" target="_blank"><i class="fa fa-fw fa-download"></i> CRF</a>
                                </td>  --}}
                                {{--  <td>{{$contract->name}}</td>  --}}
                                <td>{{$contract->created_at}}</td>
                                {{--
                                <td>{{date("d-m-Y",strtotime($contract->effective_date))}}</td>
                                <td>{{ date("d-m-Y",strtotime($contract->expiry_date))</td> }} --}}
                                <td><span class="pull-right-container">
                                    @if($contract->contract_status == 'created')
                                    <small class="label pull-center btn-warning">{{$contract->contract_status}}</small></span>                                    @elseif($contract->contract_status == 'published')
                                    <small class="label pull-center btn-info">{{ $contract->contract_status}}</small></span>
                                    @elseif($contract->contract_status== 'submitted')
                                    <small class="label label-success">{{$contract->contract_status}}</small></span>
                                    @elseif($contract->contract_status== 'ammended')
                                    <small class="label pull-center btn-danger">{{$contract->contract_status}}</small></span>
                                    @elseif($contract->contract_status== 'approved')
                                    <small class="label pull-center btn-success">{{$contract->contract_status}}</small></span>
                                    @elseif($contract->contract_status== 'terminated')
                                    <small class="label pull-center btn-danger">{{$contract->contract_status}}</small></span>
                                </td>
                                @endif
                                </td>
                                {!! Form::close() !!}
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->

            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix" style="">

            </div>
            <!-- /.box-footer -->
        </div>
    </div>
    <div class="col-md-6">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Contracts Statistics</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button> {{-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>                --}}
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="">
                <div class="col-md-12">
                    <div class="progress-group">
                        <span class="progress-text">Approved Contracts</span>
                        <span class="progress-number"><b>{{ $approved_contract_count }}</b>/{{ $total_contracts_count }}</span>

                        <div class="progress sm">
                            <div class="progress-bar progress-bar-green" style="width: {{ $approved_percentage }}%"></div>
                        </div>
                    </div>
                    <!-- /.progress-group -->
                    <div class="progress-group">
                        <span class="progress-text">Submitted Contracts</span>
                        <span class="progress-number"><b>{{ $submitted_contract_count }}</b>/{{ $total_contracts_count }}</span>

                        <div class="progress sm">
                            <div class="progress-bar progress-bar-purple" style="width: {{ $submitted_percentage }}%"></div>
                        </div>
                    </div>
                    <!-- /.progress-group -->
                    <!-- /.progress-group -->
                    <div class="progress-group">
                        <span class="progress-text">Ammended Contracts</span>
                        <span class="progress-number"><b>{{ $ammended_contract_count }}</b>/{{ $total_contracts_count }}</span>

                        <div class="progress sm">
                            <div class="progress-bar progress-bar-aqua" style="width: {{ $ammended_percentage }}%"></div>
                        </div>
                    </div>
                    <!-- /.progress-group -->
                    <div class="progress-group">
                        <span class="progress-text">Published Contracts</span>
                        <span class="progress-number"><b>{{ $published_contract_count }}</b>/{{ $total_contracts_count }}</span>

                        <div class="progress sm">
                            <div class="progress-bar progress-bar-yellow" style="width: {{ $published_percentage }}%"></div>
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

            </div>
            <!-- /.box-body -->
            <!-- /.box-footer -->
        </div>
    </div>

</div>
<div class="row">
    <div class="col-md-6">
        <div class="box box-info">
            <div class="box-header with-border">
                @if(auth()->check()) @if (auth()->user()->isAdmin())
                <h3 class="box-title">Latest Published Contracts</h3>
                @elseif(auth()->user()->isLegal())
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
                    <table id="example2" class="table no-margin">
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
                                <td>{{$contract1->party_name}}</td>
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
                                    <small class="label pull-center btn-warning">{{$contract1->contract_status}}</small></span>
                                    @elseif($contract1->contract_status == 'published')
                                    <small class="label pull-center btn-info">{{ $contract1->contract_status}}</small></span>
                                    @elseif($contract1->contract_status== 'submitted')
                                    <small class="label label-success">{{$contract1->contract_status}}</small></span>
                                    @elseif($contract1->contract_status== 'ammended')
                                    <small class="label pull-center btn-danger">{{$contract1->contract_status}}</small></span>
                                    @elseif($contract1->contract_status== 'approved')
                                    <small class="label pull-center btn-success">{{$contract1->contract_status}}</small></span>
                                    @elseif($contract1->contract_status== 'terminated')
                                    <small class="label pull-center btn-danger">{{$contract1->contract_status}}</small></span>
                                </td>
                                @endif
                                </td>
                                {!! Form::close() !!}
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix" style="">

            </div>
            <!-- /.box-footer -->
        </div>
    </div>
    @if(auth()->check()) @if (auth()->user()->isAdmin())
    <div class="col-md-6">
        <div class="box box-info">
            <div class="box-header with-border">
                @if(auth()->check()) @if (auth()->user()->isAdmin())
                <h3 class="box-title">Registered Users</h3>
                @elseif(auth()->user()->isLegal())
                <h3 class="box-title">Latest Approved Contracts</h3>
                @elseif(auth()->user()->isUser())
                <h3 class="box-title">Latest Ammended Contracts</h3>
                @endif @endif
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button> {{-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>                --}}
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="">
                <div class="table-responsive">
                    <table id="example3" class="table no-margin">
                        <thead>
                           <tr>
                            <th>S/N</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Organization</th>
                            <th>Position</th>
                            <th>Role</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $key=>$user)
                          <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->organization_name}}</td>
                                <td>{{$user->job_title}}</td>
                                <td>{{$user->role_name}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix" style="">
               
            </div>
            <!-- /.box-footer -->
        </div>
    </div>
    @endif @endif
</div>
</div>
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
         iDisplayLength: 5,
         $('#example2').DataTable()
         $('#example3').DataTable()
        $(document).ready(function() {
});
    });
</script>

@stop
