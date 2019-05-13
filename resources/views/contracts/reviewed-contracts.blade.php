@extends('adminlte::page')
@section('title', 'Wananchi Legal | Pending Contracts')
@section('content_header')
<h1 class="pull-left">Contracts<small>Reviewed Contracts</small></h1>
<div style="clear:both"></div>
@stop
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- Custom Tabs (Pulled to the right) -->
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                @if(!auth()->user()->isUser())
                <li class="active"><a href="#reviewed-contracts" data-toggle="tab">Reviewed Contracts</a></li>
                <li><a href="#draft_sent_for_review" data-toggle="tab">Draft Review Sent</a></li>
                <li><a href="#final_draft_sent" data-toggle="tab">Final Drafts Sent</a></li>
                <li><a href="#final_execution_sent" data-toggle="tab">Final Execution Version Sent</a></li>
                <li><a href="#uploaded_caf" data-toggle="tab">CAF Uploaded (Signed Off)</a></li>
                @else
                <li class="active"><a href="#reviewed-contracts" data-toggle="tab">Reviewed Contracts</a></li>
                <li><a href="#draft_sent_for_review" data-toggle="tab">Draft Review Received</a></li>
                <li><a href="#final_draft_sent" data-toggle="tab">Final Drafts Received</a></li>
                <li><a href="#final_execution_sent" data-toggle="tab">Final Execution Version Received</a></li>
                <li><a href="#uploaded_caf" data-toggle="tab">CAF Uploaded (Signed Off)</a></li>
                @endif
                <div class="btn-group pull-right" style="padding:6px;">
                    <a class="btn btn-primary btn-sm btn-flat" href="/contract/create"><i class="fa fa-plus"></i> New
                        Contract</a>
                </div>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="reviewed-contracts">
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
                                                    <th>Stage</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($reviewed_contracts as $key=>$reviewed_contract)
                                                <tr>
                                                    <td>{{ $key+1}}</td>
                                                    <td><a
                                                            href="/contract/{{$reviewed_contract->contract_id}}/view">{{$reviewed_contract->contract_code}}</a>
                                                    </td>
                                                    <td><a
                                                            href="/contract/{{$reviewed_contract->contract_id}}/view">{{$reviewed_contract->contract_title}}</a>
                                                    </td>
                                                    <td><a href="/contract-party/{{$reviewed_contract->party_id}}/view-contract-party"
                                                            target="_blank">
                                                            <span class="label"
                                                                style="background-color:#FFF;color:#0073b7;border:1px solid #0073b7;">
                                                                <i class="fa fa-briefcase fa-fw"></i>
                                                                {{$reviewed_contract->party_name}} </a></span>
                                                    </td>
                                                    <td><span class="pull-right-container">
                                                            <small class="badge bg-aqua">{{$reviewed_contract->stage_name}}</small></span>
                                                    </td>
                                                    <td><span class="pull-right-container">
                                                            <small
                                                                class="badge bg-yellow">{{$reviewed_contract->status_name}}</small></span>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a class="btn btn-info btn-block btn-sm btn-flat"
                                                                href="/contract/{{$reviewed_contract->contract_id}}/view"><i
                                                                    class="fa fa-eye"></i> View</a>
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
                <div class="tab-pane" id="draft_sent_for_review">
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
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($draft_sent_for_review as $key=>$reviewed_contract)
                                                <tr>
                                                    <td>{{ $key+1}}</td>
                                                    <td><a
                                                            href="/contract/{{$reviewed_contract->contract_id}}/view">{{$reviewed_contract->contract_code}}</a>
                                                    </td>
                                                    <td><a
                                                            href="/contract/{{$reviewed_contract->contract_id}}/view">{{$reviewed_contract->contract_title}}</a>
                                                    </td>
                                                    <td><a href="/contract-party/{{$reviewed_contract->party_id}}/view-contract-party"
                                                            target="_blank">
                                                            <span class="label"
                                                                style="background-color:#FFF;color:#0073b7;border:1px solid #0073b7;">
                                                                <i class="fa fa-briefcase fa-fw"></i>
                                                                {{$reviewed_contract->party_name}} </a></span>
                                                    </td>
                                                    <td><span class="pull-right-container">
                                                            <small
                                                                class="badge bg-yellow">{{$reviewed_contract->status_name}}</small></span>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a class="btn btn-info btn-block btn-sm btn-flat"
                                                                href="/contract/{{$reviewed_contract->contract_id}}/view"><i
                                                                    class="fa fa-eye"></i> View</a>
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
                <div class="tab-pane" id="final_draft_sent">
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
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($final_draft_sent as $key=>$reviewed_contract)
                                                <tr>
                                                    <td>{{ $key+1}}</td>
                                                    <td><a
                                                            href="/contract/{{$reviewed_contract->contract_id}}/view">{{$reviewed_contract->contract_code}}</a>
                                                    </td>
                                                    <td><a
                                                            href="/contract/{{$reviewed_contract->contract_id}}/view">{{$reviewed_contract->contract_title}}</a>
                                                    </td>
                                                    <td><a href="/contract-party/{{$reviewed_contract->party_id}}/view-contract-party"
                                                            target="_blank">
                                                            <span class="label"
                                                                style="background-color:#FFF;color:#0073b7;border:1px solid #0073b7;">
                                                                <i class="fa fa-briefcase fa-fw"></i>
                                                                {{$reviewed_contract->party_name}} </a></span>
                                                    </td>
                                                    <td><span class="pull-right-container">
                                                            <small
                                                                class="badge bg-yellow">{{$reviewed_contract->status_name}}</small></span>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a class="btn btn-info btn-block btn-sm btn-flat"
                                                                href="/contract/{{$reviewed_contract->contract_id}}/view"><i
                                                                    class="fa fa-eye"></i> View</a>
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
                <div class="tab-pane" id="final_execution_sent">
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
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($final_execution_sent as $key=>$reviewed_contract)
                                                <tr>
                                                    <td>{{ $key+1}}</td>
                                                    <td><a
                                                            href="/contract/{{$reviewed_contract->contract_id}}/view">{{$reviewed_contract->contract_code}}</a>
                                                    </td>
                                                    <td><a
                                                            href="/contract/{{$reviewed_contract->contract_id}}/view">{{$reviewed_contract->contract_title}}</a>
                                                    </td>
                                                    <td><a href="/contract-party/{{$reviewed_contract->party_id}}/view-contract-party"
                                                            target="_blank">
                                                            <span class="label"
                                                                style="background-color:#FFF;color:#0073b7;border:1px solid #0073b7;">
                                                                <i class="fa fa-briefcase fa-fw"></i>
                                                                {{$reviewed_contract->party_name}} </a></span>
                                                    </td>
                                                    <td><span class="pull-right-container">
                                                            <small
                                                                class="badge bg-yellow">{{$reviewed_contract->status_name}}</small></span>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a class="btn btn-info btn-block btn-sm btn-flat"
                                                                href="/contract/{{$reviewed_contract->contract_id}}/view"><i
                                                                    class="fa fa-eye"></i> View</a>
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
                <div class="tab-pane" id="uploaded_caf">
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
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($uploaded_caf as $key=>$reviewed_contract)
                                                <tr>
                                                    <td>{{ $key+1}}</td>
                                                    <td><a
                                                            href="/contract/{{$reviewed_contract->contract_id}}/view">{{$reviewed_contract->contract_code}}</a>
                                                    </td>
                                                    <td><a
                                                            href="/contract/{{$reviewed_contract->contract_id}}/view">{{$reviewed_contract->contract_title}}</a>
                                                    </td>
                                                    <td><a href="/contract-party/{{$reviewed_contract->party_id}}/view-contract-party"
                                                            target="_blank">
                                                            <span class="label"
                                                                style="background-color:#FFF;color:#0073b7;border:1px solid #0073b7;">
                                                                <i class="fa fa-briefcase fa-fw"></i>
                                                                {{$reviewed_contract->party_name}} </a></span>
                                                    </td>
                                                    <td><span class="pull-right-container">
                                                            <small
                                                                class="badge bg-yellow">{{$reviewed_contract->status_name}}</small></span>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a class="btn btn-info btn-block btn-sm btn-flat"
                                                                href="/contract/{{$reviewed_contract->contract_id}}/view"><i
                                                                    class="fa fa-eye"></i> View</a>
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
            </div>
            <!-- /.tab-content -->
        </div>
        <!-- nav-tabs-custom -->
    </div>
    <!-- /.col -->
</div>
{{-- <div class="box box-success">
    <div class="box-body">
        <div class="table-responsive">
          <div class="table-responsive">
                <table id="example1" class="table no-margin">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Ticket #</th>
                            <th>Contract Title</th>
                            <th>Party Name</th>
                            <th>Stage</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reviewed_contracts as $key=>$reviewed_contract)
                        <tr>
                            <td>{{ $key+1}}</td>
                            <td><a
                                    href="/contract/{{$reviewed_contract->contract_id}}/view">{{$reviewed_contract->contract_code}}</a>
                            </td>
                            <td><a
                                    href="/contract/{{$reviewed_contract->contract_id}}/view">{{$reviewed_contract->contract_title}}</a>
                            </td>
                            <td><a href="/contract-party/{{$reviewed_contract->party_id}}/view-contract-party" target="_blank">
                                    <span class="label" style="background-color:#FFF;color:#0073b7;border:1px solid #0073b7;">
                                        <i class="fa fa-briefcase fa-fw"></i>
                                        {{$reviewed_contract->party_name}} </a></span>
                            </td>
                            <td><span class="pull-right-container">
                                    <small class="badge bg-aqua">{{$reviewed_contract->stage_name}}</small></span>
                            </td>
                            <td><span class="pull-right-container">
                                    <small class="badge bg-yellow">{{$reviewed_contract->status_name}}</small></span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a class="btn btn-info btn-block btn-sm btn-flat"
                                        href="/contract/{{$reviewed_contract->contract_id}}/view"><i class="fa fa-eye"></i> View</a>
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
</div> --}}
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
