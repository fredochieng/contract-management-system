<?php $__env->startSection('title', 'Contracts'); ?>
<?php $__env->startSection('content_header'); ?>
<h1>
    Contracts
    <div class="pull-right"><a class="btn btn-primary btn-sm btn-flat" href="/contract/create">NEW CONTRACT</a></div>
</h1>



<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<style>
    .description {
        height: 90px !important
    }
</style>
<?php if(session('update')): ?>
<div class="alert alert-success alert-dismissable custom-success-box" style="margin: 15px;">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong> <?php echo e(session('update')); ?> </strong>
</div>
<?php endif; ?>
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
                <?php $__currentLoopData = $contracts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$contract): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($key+1); ?></td>
                    <td><a href="/contract/<?php echo e($contract->contract_id); ?>/view"><?php echo e($contract->contract_title); ?></a></td>
                    <td><?php echo e($contract->party_name); ?></td>
                    <td><a href="/<?php echo e($contract->draft_file); ?>" target="_blank"><i class="fa fa-fw fa-download"></i> Contract</a>

                    </td>
                    <td><?php echo e(date("d-m-Y",strtotime($contract->effective_date))); ?></td>
                    <td><?php echo e(date("d-m-Y",strtotime($contract->expiry_date))); ?></td>
                    <td><span class="pull-right-container">
                        <?php if($contract->contract_status == 'created'): ?>
                        <small class="badge bg-purple"><?php echo e($contract->contract_status); ?></small></span>
                         <?php elseif($contract->contract_status == 'published'): ?>
                        <small class="badge bg-yellow"><?php echo e($contract->contract_status); ?></small></span>
                        <?php elseif($contract->contract_status== 'ammended'): ?>
                        <small class="badge bg-blue"><?php echo e($contract->contract_status); ?></small></span>
                        <?php elseif($contract->contract_status== 'approved'): ?>
                        <small class="badge bg-green"><?php echo e($contract->contract_status); ?></small></span>
                        <?php elseif($contract->contract_status== 'terminated'): ?>
                        <small class="badge bg-red"><?php echo e($contract->contract_status); ?></small></span>
                    </td>
                    <?php endif; ?>
                    </td>
                    <td>
                        <?php if(auth()->check()): ?> <?php if(auth()->user()->isUser() && ($contract->contract_status == 'created' ||
                            $contract->contract_status== 'ammended')): ?>
                            <a href="/contract/<?php echo e($contract->contract_id); ?>/edit" class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit Contract">
                            <span class = "fa fa-pencil bigger"></span></a>
                        <?php else: ?>
                        <a href="/contract/<?php echo e($contract->contract_id); ?>/view" class="btn btn-primary btn-xs" data-toggle="tooltip" title="View Contract Details">
                            <span class = "fa fa-eye bigger"></span></a>
                        <?php endif; ?> <?php endif; ?>
                        <?php echo e(Form::hidden('_method','POST')); ?> <?php echo Form::open(['action'=>['ContractController@destroy',$contract->contract_id],'method'=>'POST','class'=>'floatit','enctype'=>'multipart/form-data']); ?> <?php echo e(Form::hidden('_method','DELETE')); ?>

                        <button type="submit" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete Contract" onClick="return confirm('Are you sure you want to delete this contract?');">   <strong>  <i class="fa fa-trash"></i></strong></button>                        
                        </td>
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
<script src="/js/bootbox.min.js"></script>

<script>
    $(function () {
         $('#example1').DataTable()
    });

</script>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>