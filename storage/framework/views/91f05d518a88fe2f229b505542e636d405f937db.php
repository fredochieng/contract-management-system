<?php $__env->startSection('title', 'Contracts'); ?>

<?php $__env->startSection('content_header'); ?>
  <h1>
  	Contracts
  	<a  href="/contract/create" class="btn btn-xs btn-info pull-right btn-flat" >NEW CONTRACT</a>
  </h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  <style>
  	.description{height:90px !important}
  </style>
            <div class="box">
                <div class="box-body">
                <table class="table table-striped table-bordered records">
                	<thead>
                    	<tr>
                        	<th>#</th>
                            <th>Contract Title</th>
                            <th>Party Name</th>
                            <th>Uploads</th>
                            <th>Effective Date</th>
                            <th>Expiry Date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $contracts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$contract): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    	<tr>
                        <td><?php echo e($key+1); ?></td>
                        <td><a href="/contract/<?php echo e($contract->contract_id); ?>/view"><?php echo e($contract->contract_title); ?></a></td>
                        <td><?php echo e($contract->party_name); ?></td>
              <td><a href="/<?php echo e($contract->draft_file); ?>" class="btn btn-xs btn-default" target="_blank"><i class="fa fa-fw fa-download"></i> CONTRACT</a> |
                        <a href="/<?php echo e($contract->draft_file); ?>" class="btn btn-xs btn-default" target="_blank"><i class="fa fa-fw fa-download"></i> CRF</a>
                        </td>
                        <td><?php echo e(date("d-m-Y",strtotime($contract->effective_date))); ?></td>
                        <td><?php echo e(date("d-m-Y",strtotime($contract->expiry_date))); ?></td>
                        <td><a href="/contract/<?php echo e($contract->contract_id); ?>/edit" class="btn btn-info btn-xs btn-flat">Edit</a>
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
 <script></script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>