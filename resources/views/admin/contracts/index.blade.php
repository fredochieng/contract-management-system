@extends('adminlte::page')

@section('title', 'Contracts')

@section('content_header')
  <h1>
  	Contracts
  	<a  href="/admin/contract/create" class="btn btn-xs btn-info pull-right btn-flat" >NEW CONTRACT</a>
  </h1>
@stop

@section('content')
  <style>
  	.description{height:90px !important}
  </style>
            <div class="box">
                <div class="box-body">
                <table id="example1" class="table table-striped table-bordered records">
                	<thead>
                    	<tr>
                        	<th>#</th>
                            <th>Contract Title</th>
                            <th>Party Name</th>
                            <th style="width:135px;">Uploads</th>
                            <th style="width:90px;">Effective Date</th>
                            <th style="width:90px;">Expiry Date</th>
                            <th>Status</th>
                            <th style="width:70px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($contracts as $key=>$contract)
                    	<tr>
                        <td>{{ $key+1}}</td>
                        <td><a href="/contract/{{$contract->contract_id}}/view">{{$contract->contract_title}}</a></td>
                        <td>{{$contract->party_name}}</td>
              <td><a href="/{{$contract->draft_file}}" target="_blank"><i class="fa fa-fw fa-download"></i> Contract</a> |
                        <a href="/{{$contract->draft_file}}"  target="_blank"><i class="fa fa-fw fa-download"></i> CRF</a>
                        </td>
                        <td>{{date("d-m-Y",strtotime($contract->effective_date))}}</td>
                        <td>{{date("d-m-Y",strtotime($contract->expiry_date))}}</td>
                        <td><span class="pull-right-container">
                        @if($contract->contract_status == 'created')
                        <small class="label pull-center btn-default">{{$contract->contract_status}}</small></span>
                        @elseif($contract->contract_status == 'approved')
                        <small class="label pull-center btn-info">{{$contract->contract_status}}</small></span>
                        @elseif($contract->contract_status== 'archived')
                        <small class="label pull-center btn-success">{{$contract->contract_status}}</small></span></td>
                        @elseif($contract->contract_status== 'rejected')
                        <small class="label pull-center btn-danger">{{$contract->contract_status}}</small></span>
                        </td>
                        @endif
                        </td>
                        @if($contract->contract_status == 'created' && $contract->contract_stage ==1 ||
                        $contract->contract_status == 'rejected' && $contract->contract_stage ==3 )
                            <td><a href="/admin/contract/{{$contract->contract_id}}/edit" id="editBtn" class="label bg-primary">Edit</a>

                        @else
                            <td><a href="/contract/{{$contract->contract_id}}/view" id="editBtn" class="label bg-green">Published</a>

                        @endif
                          {!! Form::open(['action'=>['ContractController@destroy',$contract->contract_id],'method'=>'POST','class'=>'floatit','enctype'=>'multipart/form-data']) !!}
           {{Form::hidden('_method','DELETE')}}

            <button type="submit" class="btn btn-danger btn-xs btn-flat" onClick="return confirm('Are you sure you want to delete this contract?');">   <strong>  <i class="fa fa-close"></i></strong></button>
            {!! Form::close() !!}
                      </tr>
                        @endforeach
                        </tbody>
                     </table>
        		 </div>
        </div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="/css/bootstrap-datepicker.min.css">
@stop

@section('js')

<script src="/js/bootstrap-datepicker.min.js"></script>
 <script>
      $(function () {
      $('#example1').DataTable()
    })
 </script>
@include('sweet::alert')
@stop
