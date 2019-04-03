@extends('adminlte::page')
@section('title', 'Contract Details')
@section('content_header')
<h1>View Contract Details</h1>
@stop
@section('content')
<style>
   .description{height:90px !important}
</style>
<div class="box box-success">
<section class="invoice">
   <!-- title row -->
   <div class="row">
      <div class="col-xs-12">
         <h2 class="page-header" style="font-weight:bold">
            Contract Party:
            {{ $contract->party_name }}
            <small class="pull-right" style="font-weight:bold">Ticket Number: {{ $contract->contract_id }}</small>
         </h2>
      </div>
   </div>
   <div class="row invoice-info">
      <!-- Contract Details row -->
      {!! Form::open(['action'=>['ContractController@submit', $contract->contract_id],'method'=>'POST','class'=>'form','enctype'=>'multipart/form-data']) !!}
      <div class="row">
         <div class="col-md-6">
            {{Form::text('contract_id',$contract->contract_id,['class'=>'form-control hidden','placeholder'=>'The contract Title'])}}
            {{Form::label('title', 'Contract Title ')}}
            <div class="form-group">
               {{--  {{Form::text('title',$contract->contract_title,['class'=>'form-control','placeholder'=>'The contract Title'])}}  --}}
               <h4>{{ $contract->contract_title }}</h4>
            </div>
         </div>
         <div class="col-md-6">
            {{Form::label('party_name', 'Party Name ')}}
            <div class="form-group">
               {{--  {{Form::text('title',$contract->party_name,['class'=>'form-control','placeholder'=>'The contract Title'])}}  --}}
               <h4>{{ $contract->party_name }}</h4>
            </div>
         </div>
         <div class="col-md-6">
            {{Form::label('effective_date', 'Effective Date ')}}
            <div class="form-group">
               {{--  {{Form::text('effective_date', date("m-d-Y",strtotime($contract->effective_date)),['class'=>'form-control issued_date','placeholder'=>'Effective date','autocomplete'=>'off'])}}  --}}
               <h4>{{ $contract->effective_date }}</h4>
            </div>
         </div>
         <div class="col-md-6">
            {{Form::label('expiry_date', 'Expiry Date ')}}
            <div class="form-group">
               {{--  {{Form::text('expiry_date', date("m-d-Y",strtotime($contract->expiry_date)),['class'=>'form-control issued_date','placeholder'=>'Expiry Date', 'autocomplete'=>'off'])}}  --}}
               <h4>{{ $contract->expiry_date }}</h4>
            </div>
         </div>
         <div class="col-md-12">
            {{Form::label('description', 'Contract Description')}}
            <div class="form-group">
               {{--  {{Form::textarea('description', $contract->description,['class'=>'form-control description','placeholder'=>'Fully Describe your contract here for clarifications'])}}  --}}
               <h4>{{ $contract->description }}</h4>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-xs-6">
         </div>
      </div>
      <div class="row no-print">
         <div class="col-xs-12">
            <a href=""></a>
            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>Publish Contract</button>
            <button type="button" class="btn btn-success pull-right"><i class="fa fa-download"></i> CRF
            </button>
            <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
            <i class="fa fa-download"></i> Contract Document
            </button>
            {!! Form::close() !!}
         </div>
      </div>
</section>
</Table>
</div>
<div class="box box-success">
   <section class="invoice">
      <div class="box-header">
         <h3 class="box-title">Contract History</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
         <table id="example1" class="table table-bordered table-striped">
            <thead>
               <tr>
                  <th style="width:40px">#</th>
                  <th style="width:100px">User</th>
                  <th>Position</th>
                   <th>Date Created</th>
                  <th>Contract Draft</th>
                  <th>CRF</th>
                  <th>Status</th>
               </tr>
            </thead>
            <tbody>
               <tr>

                  <td>1</td>
                  <td>{{ $contract->name }}</td>
                  <td>Legal Admin</td>
                  <td>{{ $contract->created_at }}</td>
                  <td style="width:120px"> <a href="/{{$contract->draft_file}}" class="btn btn-primary" target="_blank"><i class="fa fa-fw fa-download"></i> Contract document</a></td>
                  <td style="width:120px">  <button type="button" class="btn btn-primary">
                     <i class="fa fa-download"></i> CRF Document
                     </button>
                  </td>
                  <td><center><p class="text-light-blue">{{ $contract->status }}</p></center></td>
               </tr>
            </tbody>
         </table>
      </div>
      <!-- /.box-body -->
   </section>
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
      $('#example2').DataTable({
        'paging'      : true,
        'lengthChange': false,
        'searching'   : false,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : false
      })
    })
</script>
@stop
