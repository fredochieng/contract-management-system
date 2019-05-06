@extends('adminlte::page')
@section('title', 'Contracts')
@section('content_header')
<h1>
    Contracts
    <div class="pull-right"><a class="btn btn-primary btn-sm btn-flat" href="/contract/create">NEW CONTRACT</a></div>
</h1>







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
@endif
<div class="box">
    <div class="box-body">
        <table id="example1" class="table table-striped table-bordered records">
            <thead>
                <tr>
                    <th style="width:25px;">S/N</th>
                    <th style="width:400px;">Contract Title</th>
                    <th style="width:160px;">Party Name</th>
                    <th style="width:145px;">Uploads</th>
                    <th style="width:90px;">Effective Date</th>
                    <th style="width:90px;">Expiry Date</th>
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
                    <td><a href="/{{$contract->draft_file}}" target="_blank"><i class="fa fa-fw fa-download"></i> Contract</a>

                    </td>
                    <td>{{date("d-m-Y",strtotime($contract->effective_date))}}</td>
                    <td>{{date("d-m-Y",strtotime($contract->expiry_date))}}</td>
                    <td><span class="pull-right-container">
                        @if($contract->contract_status == 'created')
                        <small class="badge bg-purple">{{$contract->contract_status}}</small></span> @elseif($contract->contract_status
                        == 'pending')
                        <small class="badge bg-yellow">{{ $contract->contract_status}}</small></span>
                        @elseif($contract->contract_status== 'amended')
                        <small class="badge bg-blue">{{$contract->contract_status}}</small></span>
                        @elseif($contract->contract_status== 'terminated') @elseif($contract->contract_status== 'closed')
                        <small class="badge bg-aqua">{{$contract->contract_status}}</small></span>
                    </td>
                    @endif
                    </td>
                    <td>
                        @if (auth()->check()) @if(auth()->user()->isUser() && ($contract->contract_status == 'created' || $contract->contract_status==
                        'amended'))
                        <a href="/contract/{{$contract->contract_id}}/edit" class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit Contract">
                            <span class = "fa fa-pencil bigger"></span></a> @else
                        <a href="/contract/{{$contract->contract_id}}/view" class="btn btn-primary btn-xs" data-toggle="tooltip" title="View Contract Details">
                            <span class = "fa fa-eye bigger"></span></a> @endif @endif {{ Form::hidden('_method','POST')
                        }} {!! Form::open(['action'=>['ContractController@destroy',$contract->contract_id],'method'=>'POST','class'=>'floatit','enctype'=>'multipart/form-data'])
                        !!} {{Form::hidden('_method','DELETE')}}
                        <button type="submit" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete Contract" onClick="return confirm('Are you sure you want to delete this contract?');">   <strong>  <i class="fa fa-trash"></i></strong></button>                        {{-- <a class="delete" data-id="{{ $contract->contract_id }}" href="javascript:void(0)">
                                <span style="color:red;" class = "fa fa-trash bigger"></span></a> --}}
                    </td>
                    {!! Form::close() !!}
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@include('page.footer')
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
