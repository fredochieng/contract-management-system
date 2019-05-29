<?php $__env->startSection('title', 'Wananchi Legal | Closed Contracts'); ?>
<?php $__env->startSection('content_header'); ?>
<h1 class="pull-left">Contracts<small>Closed Contracts</small></h1>
<div style="clear:both"></div>
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
<?php endif; ?> <?php if(auth()->check()): ?> <?php if(auth()->user()->isAdmin() || auth()->user()->isLegal()): ?>
<div class="row" style="font-size:12px;">
    <div class="col-md-12">
        <!-- Custom Tabs (Pulled to the right) -->
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#approved-contracts" data-toggle="tab">Closed Contracts</a></li>
                <li><a href="#approved-by-me-contracts" data-toggle="tab">Closed By Me</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="approved-contracts">
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
                                                    <th>Signed Contract</th>
                                                    <th>Expiry Date</th>
                                                    <th>Status</th>
                                                     <th>Expiry Alert</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $approved_contracts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$approved_contract): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($key+1); ?></td>
                                                    <td><a href="/contract/<?php echo e($approved_contract->contract_id); ?>/view"><?php echo e($approved_contract->contract_code); ?></a></td>
                                                    <td><a
                                                            href="/contract/<?php echo e($approved_contract->contract_id); ?>/view"><?php echo e($approved_contract->contract_title); ?></a>
                                                    </td>
                                                    <td><a href="/contract-party/<?php echo e($approved_contract->party_id); ?>/view-contract-party"
                                                            target="_blank">
                                                            <span class="label"
                                                                style="background-color:#FFF;color:#0073b7;border:1px solid #0073b7;">
                                                                <i class="fa fa-briefcase fa-fw"></i>
                                                                <?php echo e($approved_contract->party_name); ?> </a></span>
                                                    </td>
                                               <td>
                                                <a href="/<?php echo e($approved_contract->draft_file); ?>" style="margin-right:128px" target="_blank"><i
                                                        class="fa fa-fw fa-download"></i>Download </a> </td>
                                               <td><?php echo e(date('Y-m-d', strtotime($approved_contract->expiry_date))); ?></td>
                                                   <td><span class="pull-right-container">
                                                        <small class="badge bg-blue"><?php echo e($approved_contract->status_name); ?></small></span>
                                                </td>

                                                     <?php if($approved_contract->expired==1): ?>
                                               <td><span class="pull-right-container"><small class="badge bg-red">Expired</small></span>                </td>
                                                    </td>
                                                    <?php else: ?>
                                                    <td><span class="pull-right-container">
                                                            <small class="badge bg-aqua">Active</small></span>
                                                    </td>
                                                    <?php endif; ?>

                                                    <td>
                                                        <div class="btn-group">
                                                            <a class="btn btn-info btn-block btn-sm btn-flat"
                                                                href="/contract/<?php echo e($approved_contract->contract_id); ?>/view"><i
                                                                    class="fa fa-eye"></i> View</a>
                                                        </div>
                                                    </td>
                                                    <?php echo Form::close(); ?>

                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="approved-by-me-contracts">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-success">
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table id="example2" class="table no-margin">
                                            <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Ticket #</th>
                                                    <th>Contract Title</th>
                                                    <th>Party Name</th>
                                                    <th>Expiry Alert</th>
                                                    <th>Status</th>
                                                     <th>Expiry Alert</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $approved_by_me_contracts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$approved_by_me_contract): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($key+1); ?></td>
                                                    <td><a href="/contract/<?php echo e($approved_by_me_contract->contract_id); ?>/view"><?php echo e($approved_by_me_contract->contract_code); ?></a></td>
                                                    <td><a
                                                            href="/contract/<?php echo e($approved_by_me_contract->contract_id); ?>/view"><?php echo e($approved_by_me_contract->contract_title); ?></a>
                                                    </td>
                                                    <td><a href="/contract-party/<?php echo e($approved_by_me_contract->party_id); ?>/view-contract-party"
                                                            target="_blank">
                                                            <span class="label"
                                                                style="background-color:#FFF;color:#0073b7;border:1px solid #0073b7;">
                                                                <i class="fa fa-briefcase fa-fw"></i>
                                                                <?php echo e($approved_by_me_contract->party_name); ?> </a></span>
                                                    </td>
                                                     <td><?php echo e($approved_by_me_contract->expiry_date); ?></td>
                                                   <td><span class="pull-right-container">
                                                        <small class="badge bg-blue"><?php echo e($approved_contract->status_name); ?></small></span>
                                                </td>

                                                     <?php if($approved_by_me_contract->expired==1): ?>
                                               <td><span class="pull-right-container"><small class="badge bg-red">Expired</small></span>                </td>
                                                    </td>
                                                    <?php else: ?>
                                                    <td><span class="pull-right-container">
                                                            <small class="badge bg-aqua">Active</small></span>
                                                    </td>
                                                    <?php endif; ?>

                                                    <td>
                                                        <div class="btn-group">
                                                            <a class="btn btn-info btn-block btn-sm btn-flat"
                                                                href="/contract/<?php echo e($approved_by_me_contract->contract_id); ?>/view"><i
                                                                    class="fa fa-eye"></i> View</a>
                                                        </div>
                                                    </td>
                                                    <?php echo Form::close(); ?>

                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
        </div>
        <!-- nav-tabs-custom -->
    </div>
    <!-- /.col -->
</div>
<?php else: ?>
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
                    <th>Expiry Date</th>
                    <th>Status</th>
                    <th>Expiry Alert</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $approved_contracts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$approved_contract): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($key+1); ?></td>
                    <td><a href="/contract/<?php echo e($approved_contract->contract_id); ?>/view"><?php echo e($approved_contract->contract_code); ?></a>
                    </td>
                    <td><a href="/contract/<?php echo e($approved_contract->contract_id); ?>/view"><?php echo e($approved_contract->contract_title); ?></a>
                    </td>
                    <td><a href="/contract-party/<?php echo e($approved_contract->party_id); ?>/view-contract-party" target="_blank">
                            <span class="label" style="background-color:#FFF;color:#0073b7;border:1px solid #0073b7;">
                                <i class="fa fa-briefcase fa-fw"></i>
                                <?php echo e($approved_contract->party_name); ?> </a></span>
                    </td>
                    <td><?php echo e($approved_contract->expiry_date); ?></td>
                    <td><span class="pull-right-container">
                            <small class="badge bg-blue"><?php echo e($approved_contract->status_name); ?></small></span>
                    </td>

                    <?php if($approved_contract->expired==1): ?>
                    <td><span class="pull-right-container"><small class="badge bg-red">Expired</small></span> </td>
                    </td>
                    <?php else: ?>
                    <td><span class="pull-right-container">
                            <small class="badge bg-aqua">Active</small></span>
                    </td>
                    <?php endif; ?>

                    <td>
                        <div class="btn-group">
                            <a class="btn btn-info btn-block btn-sm btn-flat"
                                href="/contract/<?php echo e($approved_contract->contract_id); ?>/view"><i class="fa fa-eye"></i> View</a>
                        </div>
                    </td>
                    <?php echo Form::close(); ?>

                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        </div>
    </div>
</div>
<?php endif; ?> <?php endif; ?>
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
        $('#example2').DataTable()
        $('#example3').DataTable()
        $('#example4').DataTable()
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>