@extends('adminlte::page')
@section('title', 'Contract Management System')
@section('content_header')
<h1>Dashboard</h1>
@stop
@section('content')
@if (auth()->check())
@if (auth()->user()->isAdmin())
<div class="row">
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3>{{ $submitted_contract_count }}</h3>
                <p>Submitted Contracts</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">View Contracts <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>{{ $published_contract_count }}</h3>
                <p>Published Contracts</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer ">View Contracts <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-green">
            <div class="inner">
                <h3>{{ $approved_contract_count }}</h3>
                <p>Approved Contracts</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">View Contracts <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-red">
            <div class="inner">
                <h3>{{ $ammended_contract_count }}</h3>
                <p>Ammended Contracts</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">View Contracts <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
</div>
<div class="row">
    <div class="col-md-9">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Latest Submitted Contracts</h3>

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
                                <th style="width:145px;">Uploads</th>
                                <th style="width:145px;">Submitted By</th>
                                <th style="width:145px;">Date</th>
                                {{--
                                <th style="width:90px;">Effective Date</th>
                                <th style="width:90px;">Expiry Date</th> --}}
                                <th style="width:50px;">Status</th>
                                <th style="width:50px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contracts as $key=>$contract)
                            <tr>
                                <td>{{ $key+1}}</td>
                                <td><a href="/contract/{{$contract->contract_id}}/view">{{$contract->contract_title}}</a></td>
                                <td>{{$contract->party_name}}</td>
                                <td><a href="/{{$contract->draft_file}}" target="_blank"><i class="fa fa-fw fa-download"></i> Contract</a>                                    |
                                    <a href="/{{$contract->draft_file}}" target="_blank"><i class="fa fa-fw fa-download"></i> CRF</a>
                                </td>
                                <td>{{$contract->name}}</td>
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
                                <td>
                                    @if($contract->contract_status == 'created' && $contract->contract_stage ==1 || $contract->contract_status == 'ammended'
                                    && $contract->contract_stage ==4 ) {{-- <a href="/contract/{{$contract->contract_id}}/edit"
                                        id="editBtn" class="label bg-primary">Edit</a> --}}
                                    <a href="/contract/{{$contract->contract_id}}/edit">
                                            <span class = "fa fa-pencil bigger"></span></center></a>                                    @else {{--
                                    <a href="/contract/{{$contract->contract_id}}/view" id="editBtn" class="label bg-green">Published</a>                                    --}}
                                    <a href="/contract/{{$contract->contract_id}}/view">
                                                                                <span class = "fa fa-eye bigger"></span></center></a>                                    @endif {!! Form::open(['action'=>['ContractController@destroy',$contract->contract_id],'method'=>'POST','class'=>'floatit','enctype'=>'multipart/form-data'])
                                    !!} {{Form::hidden('_method','DELETE')}} {{-- <button type="submit" class="btn btn-danger btn-xs btn-flat"
                                        onClick="return confirm('Are you sure you want to delete this contract?');">   <strong>  <i class="fa fa-close"></i></strong></button>                                    --}}
                                    <a class="delete" data-id="{{ $contract->contract_id }}" href="javascript:void(0)">
                                            <span style="color:red;" class = "fa fa-trash bigger"></span></a>
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
                <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">View All Contracts</a>
            </div>
            <!-- /.box-footer -->
        </div>
    </div>

    <div class="col-md-3">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Contracts Statistics</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    {{-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> --}}
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="">
                <div class="col-md-12">
                    <div class="progress-group">
                        <span class="progress-text">Approved Contracts</span>
                        <span class="progress-number"><b>{{ $approved_percentage }}%</span>

                        <div class="progress sm">
                        <div class="progress-bar progress-bar-green" style="width: {{ $approved_percentage }}%"></div>
                        </div>
                    </div>
                    <!-- /.progress-group -->
                    <div class="progress-group">
                        <span class="progress-text">Submitted Contracts</span>
                        <span class="progress-number"><b>{{ $submitted_percentage }}%</span>

                        <div class="progress sm">
                            <div class="progress-bar progress-bar-purple" style="width: {{ $submitted_percentage }}%"></div>
                        </div>
                    </div>
                    <!-- /.progress-group -->
                    <!-- /.progress-group -->
                    <div class="progress-group">
                        <span class="progress-text">Ammended Contracts</span>
                        <span class="progress-number"><b>{{ $ammended_percentage }}%</span>

                        <div class="progress sm">
                            <div class="progress-bar progress-bar-aqua" style="width: {{ $ammended_percentage }}%"></div>
                        </div>
                    </div>
                    <!-- /.progress-group -->
                    <div class="progress-group">
                        <span class="progress-text">Published Contracts</span>
                        <span class="progress-number"><b>{{ $submitted_percentage }}%</span>

                        <div class="progress sm">
                            <div class="progress-bar progress-bar-yellow" style="width: {{ $submitted_percentage }}%"></div>
                        </div>
                    </div>
                    <!-- /.progress-group -->
                    <!-- /.progress-group -->
                    <div class="progress-group">
                        <span class="progress-text">Terminated Contracts</span>
                        <span class="progress-number"><b>{{ $terminated_percentage }}%</span>

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
{{-- Published Contracts --}}
<div class="row">
    <div class="col-md-9">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Latest Submitted Contracts</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                    {{-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> --}}
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
                                <th style="width:145px;">Uploads</th>
                                {{--
                                <th style="width:90px;">Effective Date</th>
                                <th style="width:90px;">Expiry Date</th> --}}
                                <th style="width:50px;">Status</th>
                                <th style="width:50px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contracts as $key=>$contract)
                            <tr>
                                <td>{{ $key+1}}</td>
                                <td><a href="/contract/{{$contract->contract_id}}/view">{{$contract->contract_title}}</a></td>
                                <td>{{$contract->party_name}}</td>
                                <td><a href="/{{$contract->draft_file}}" target="_blank"><i class="fa fa-fw fa-download"></i> Contract</a>                                    |
                                    <a href="/{{$contract->draft_file}}" target="_blank"><i class="fa fa-fw fa-download"></i> CRF</a>
                                </td>
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
                                <td>
                                    @if($contract->contract_status == 'created' && $contract->contract_stage ==1 || $contract->contract_status == 'ammended'
                                    && $contract->contract_stage ==4 ) {{-- <a href="/contract/{{$contract->contract_id}}/edit"
                                        id="editBtn" class="label bg-primary">Edit</a> --}}
                                    <a href="/contract/{{$contract->contract_id}}/edit">
                                            <span class = "fa fa-pencil bigger"></span></center></a>                                    @else {{--
                                    <a href="/contract/{{$contract->contract_id}}/view" id="editBtn" class="label bg-green">Published</a>                                    --}}
                                    <a href="/contract/{{$contract->contract_id}}/view">
                                                                                <span class = "fa fa-eye bigger"></span></center></a>                                    @endif {!! Form::open(['action'=>['ContractController@destroy',$contract->contract_id],'method'=>'POST','class'=>'floatit','enctype'=>'multipart/form-data'])
                                    !!} {{Form::hidden('_method','DELETE')}} {{-- <button type="submit" class="btn btn-danger btn-xs btn-flat"
                                        onClick="return confirm('Are you sure you want to delete this contract?');">   <strong>  <i class="fa fa-close"></i></strong></button>                                    --}}
                                    <a class="delete" data-id="{{ $contract->contract_id }}" href="javascript:void(0)">
                                            <span style="color:red;" class = "fa fa-trash bigger"></span></a>
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
                <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">View All Contracts</a>
            </div>
            <!-- /.box-footer -->
        </div>
    </div>

</div>
@elseif (auth()->user()->isUser())
<h>Standard User Dashboard</h>
@elseif (auth()->user()->isLegal())
<h>Legal Counsel Dashboard</h>
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
        $(document).ready(function() {
});
    });

</script>

@stop
