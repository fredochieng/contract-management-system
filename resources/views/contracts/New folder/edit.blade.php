
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
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        {{--  <div class="col-sm-4 invoice-col">
          From
          <address>
            <strong>Admin, Inc.</strong><br>
            795 Folsom Ave, Suite 600<br>
            San Francisco, CA 94107<br>
            Phone: (804) 123-5432<br>
            Email: info@almasaeedstudio.com
          </address>
        </div>  --}}
        <!-- /.col -->
        {{--  <div class="col-sm-4 invoice-col">
          To
          <address>
            <strong>John Doe</strong><br>
            795 Folsom Ave, Suite 600<br>
            San Francisco, CA 94107<br>
            Phone: (555) 539-1037<br>
            Email: john.doe@example.com
          </address>
        </div>  --}}
        <!-- /.col -->
        {{--  <div class="col-sm-4 invoice-col">
          <b>Invoice #007612</b><br>
          <br>
          <b>Order ID:</b> 4F3S8J<br>
          <b>Payment Due:</b> 2/22/2014<br>
          <b>Account:</b> 968-34567
        </div>  --}}
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Contract Details row -->
      <div class="row">
          <div class="col-md-6">

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
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <div class="col-xs-6">
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- this row will not appear when printing -->
      <div class="row no-print">
        <div class="col-xs-12">
          <a href="#" target="_blank" class="btn btn-primary"><i class="fa fa-check"></i>Publish Contract</a>
          <button type="button" class="btn btn-success pull-right"><i class="fa fa-download"></i> CRF
          </button>
          <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
            <i class="fa fa-download"></i> Contract Document
          </button>
        </div>
      </div>
    </section>


   </Table>
</div>

<div class="box">
            <div class="box-header">
              <h3 class="box-title">Contract Details</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width:40px">#</th>
                  <th style="width:220px">User</th>
                  <th>Position</th>
                  <th>Contract Draft</th>
                  <th>CRF</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                  <td>1</td>
                  <td>Fredrick Ochieng</td>
                   <td>03/04/2019</td>
                  <td style="width:120px">  <button type="button" class="btn btn-primary">
            <i class="fa fa-download"></i> Contract Document
          </button></td>
                  <td style="width:120px">  <button type="button" class="btn btn-primary">
            <i class="fa fa-download"></i> Contract Document
          </button></td>
                  <td>Published</td>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
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
