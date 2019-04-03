<?php $__env->startSection('title', 'Contract Details'); ?>

<?php $__env->startSection('content_header'); ?>
  <h1>View Contract Details</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>


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
     <?php echo e($contract->party_name); ?>

        <small class="pull-right" style="font-weight:bold">Ticket Number: <?php echo e($contract->contract_id); ?></small>
          </h2>
        </div>
      </div>

      <div class="row invoice-info">
      <!-- Contract Details row -->
       <?php echo Form::open(['action'=>['ContractController@submit', $contract->contract_id],'method'=>'POST','class'=>'form','enctype'=>'multipart/form-data']); ?>

      <div class="row">
          <div class="col-md-6">
            <?php echo e(Form::text('contract_id',$contract->contract_id,['class'=>'form-control hidden','placeholder'=>'The contract Title'])); ?>


                    	<?php echo e(Form::label('title', 'Contract Title ')); ?>

                         <div class="form-group">

                             
                            <h4><?php echo e($contract->contract_title); ?></h4>
                        </div>
            </div>
          <div class="col-md-6">

                    	<?php echo e(Form::label('party_name', 'Party Name ')); ?>

                         <div class="form-group">

                             
                            <h4><?php echo e($contract->party_name); ?></h4>

                        </div>
            </div>

            <div class="col-md-6">

                    	<?php echo e(Form::label('effective_date', 'Effective Date ')); ?>

                         <div class="form-group">

                             
                              <h4><?php echo e($contract->effective_date); ?></h4>
                        </div>
            	   </div>

                     <div class="col-md-6">

                    	<?php echo e(Form::label('expiry_date', 'Expiry Date ')); ?>

                         <div class="form-group">

                             
                    <h4><?php echo e($contract->expiry_date); ?></h4>
                            </div>
                   </div>

                   <div class="col-md-12">
               			  <?php echo e(Form::label('description', 'Contract Description')); ?>


                         <div class="form-group">
                             
                        <h4><?php echo e($contract->description); ?></h4>
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

                <?php echo Form::close(); ?>

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
                  <td style="width:120px"> <a href="/<?php echo e($contract_drafts->draft_file); ?>" class="btn btn-primary" target="_blank"><i class="fa fa-fw fa-download"></i> Contract document</a></td>
                  <td style="width:120px">  <button type="button" class="btn btn-primary">
            <i class="fa fa-download"></i> CRF Document
          </button></td>
                  <td>Published</td>
                </tr>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->

</section>
 </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="/css/bootstrap-datepicker.min.css">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>



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

<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>