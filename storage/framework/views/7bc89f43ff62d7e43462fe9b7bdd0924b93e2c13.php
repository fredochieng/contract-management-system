<?php $__env->startSection('title', 'Contracts'); ?>

<?php $__env->startSection('content_header'); ?>
  <h1>
  	Contracts
  	<a  href="/admin/contract/create" class="btn btn-xs btn-info pull-right btn-flat" >NEW CONTRACT</a>
  </h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
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
                    <?php $__currentLoopData = $contracts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$contract): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    	<tr>
                        <td><?php echo e($key+1); ?></td>
                        <td><a href="/contract/<?php echo e($contract->contract_id); ?>/view"><?php echo e($contract->contract_title); ?></a></td>
                        <td><?php echo e($contract->party_name); ?></td>
              <td><a href="/<?php echo e($contract->draft_file); ?>" target="_blank"><i class="fa fa-fw fa-download"></i> Contract</a> |
                        <a href="/<?php echo e($contract->draft_file); ?>"  target="_blank"><i class="fa fa-fw fa-download"></i> CRF</a>
                        </td>
                        <td><?php echo e(date("d-m-Y",strtotime($contract->effective_date))); ?></td>
                        <td><?php echo e(date("d-m-Y",strtotime($contract->expiry_date))); ?></td>
                        <td><span class="pull-right-container">
                        <?php if($contract->contract_status == 'created'): ?>
                        <small class="label pull-center btn-default"><?php echo e($contract->contract_status); ?></small></span>
                        <?php elseif($contract->contract_status == 'approved'): ?>
                        <small class="label pull-center btn-info"><?php echo e($contract->contract_status); ?></small></span>
                        <?php elseif($contract->contract_status== 'archived'): ?>
                        <small class="label pull-center btn-success"><?php echo e($contract->contract_status); ?></small></span></td>
                        <?php elseif($contract->contract_status== 'rejected'): ?>
                        <small class="label pull-center btn-danger"><?php echo e($contract->contract_status); ?></small></span>
                        </td>
                        <?php endif; ?>
                        </td>
                        <?php if($contract->contract_status == 'created' && $contract->contract_stage ==1 ||
                        $contract->contract_status == 'rejected' && $contract->contract_stage ==3 ): ?>
                            <td><a href="/admin/contract/<?php echo e($contract->contract_id); ?>/edit" id="editBtn" class="label bg-primary">Edit</a>

                        <?php else: ?>
                            <td><a href="/contract/<?php echo e($contract->contract_id); ?>/view" id="editBtn" class="label bg-green">Published</a>

                        <?php endif; ?>
                          <?php echo Form::open(['action'=>['ContractController@destroy',$contract->contract_id],'method'=>'POST','class'=>'floatit','enctype'=>'multipart/form-data']); ?>

           <?php echo e(Form::hidden('_method','DELETE')); ?>


            <button type="submit" class="btn btn-danger btn-xs btn-flat" onClick="return confirm('Are you sure you want to delete this contract?');">   <strong>  <i class="fa fa-close"></i></strong></button>
            <?php echo Form::close(); ?>

                      </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                     </table>
        		 </div>
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
    })
 </script>
<?php echo $__env->make('sweet::alert', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>