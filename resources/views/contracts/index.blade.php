@extends('adminlte::page')

@section('title', 'Contracts')

@section('content_header')
  <h1>
  	Contracts
  	<a  href="/contract/create" class="btn btn-xs btn-info pull-right btn-flat" >NEW CONTRACT</a>
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
              <td><a href="/{{$contract->draft_file}}" class="btn btn-xs btn-default" target="_blank"><i class="fa fa-fw fa-download"></i> CONTRACT</a> |
                        <a href="/{{$contract->draft_file}}" class="btn btn-xs btn-default" target="_blank"><i class="fa fa-fw fa-download"></i> CRF</a>
                        </td>
                        <td>{{date("d-m-Y",strtotime($contract->effective_date))}}</td>
                        <td>{{date("d-m-Y",strtotime($contract->expiry_date))}}</td>
                        <td>{{ $contract->contract_status}}</td>
                        @if($contract->contract_status == 'created')
                            <td><a href="/contract/{{$contract->contract_id}}/edit" id="editBtn" class="label bg-primary">Edit</a>

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
    /**  function deleteContract($contract->contract-id)
    swal({ title: "Are you sure you want to delete this user?",
        text: "You won't be able to revert this!", type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete user!"
    })  **/
 </script>

@stop
