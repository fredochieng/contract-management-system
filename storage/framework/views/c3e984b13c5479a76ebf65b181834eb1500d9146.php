<?php $__env->startSection('title', 'Wananchi Legal | Pending Contracts'); ?>
<?php $__env->startSection('content_header'); ?>
<h1 class="pull-left">Contracts<small>Pending Contracts</small></h1>
<div style="clear:both"></div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php if(session('update')): ?>
<div class="alert alert-success alert-dismissable custom-success-box" style="margin: 15px;">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong> <?php echo e(session('update')); ?> </strong>
</div>
<?php endif; ?> <?php if(auth()->check()): ?> <?php if(auth()->user()->isAdmin() || auth()->user()->isLegal()): ?>
<div class="row">
    <div class="col-md-12">
        <!-- Custom Tabs (Pulled to the right) -->
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#pending-contracts" data-toggle="tab">Pending Contracts</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="pending-contracts">
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
                                                    <th>Status</th>
                                                    <?php if(auth()->check()): ?> <?php if(auth()->user()->isAdmin() ||
                                                    auth()->user()->isLegal()): ?>
                                                    <th>Alert</th>
                                                    <?php endif; ?> <?php endif; ?>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $pending_contracts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$pending_contract): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($key+1); ?></td>
                                                    <td><a
                                                            href="/contract/<?php echo e($pending_contract->contract_id); ?>/view"><?php echo e($pending_contract->contract_code); ?></a>
                                                    </td>
                                                    <td><a
                                                            href="/contract/<?php echo e($pending_contract->contract_id); ?>/view"><?php echo e($pending_contract->contract_title); ?></a>
                                                    </td>
                                                    <td><a href="/contract-party/<?php echo e($pending_contract->party_id); ?>/view-contract-party"
                                                            target="_blank">
                                                            <span class="label"
                                                                style="background-color:#FFF;color:#0073b7;border:1px solid #0073b7;">
                                                                <i class="fa fa-briefcase fa-fw"></i>
                                                                <?php echo e($pending_contract->party_name); ?> </a></span>
                                                    </td>
                                                  <td><span class="pull-right-container">
                                                        <small class="badge bg-yellow"><?php echo e($pending_contract->status_name); ?></small></span>
                                                </td>
                                                    <?php if(auth()->check()): ?> <?php if(auth()->user()->isAdmin() ||
                                                    auth()->user()->isLegal()): ?>
                                                    <td>
                                                        <?php if($pending_contract->assigned =='' && $pending_contract->escalation_duration >=1): ?>
                                                        <span class="label"
                                                            style="background-color:#FFF;color:#ff0000;border:1px solid #ff0000">Overdue</span>
                                                        <?php elseif($pending_contract->assigned=='' &&
                                                        $pending_contract->escalation_duration
                                                        <1): ?> <span class="label"
                                                            style="background-color:#FFF;color:#1e3fda;border:1px solid #1e3fda">
                                                            Open</span>
                                                            <?php else: ?>
                                                            <span class="label"
                                                                style="background-color:#FFF;color:#058e29;border:1px solid #058e29">Assigned</span>
                                                            <?php endif; ?>
                                                    </td>
                                                    <?php endif; ?> <?php endif; ?>
                                                    <td>
                                                            <a class="btn btn-info btn-sm btn-flat"
                                                                href="/contract/<?php echo e($pending_contract->contract_id); ?>/view"><i
                                                                    class="fa fa-eye"></i> View</a>

                                                                    <?php if(auth()->check()): ?> <?php if(auth()->user()->isAdmin()): ?>
                                                                    <a href="#modal_delete_contract" data-backdrop="static" data-keyboard="false" data-toggle="modal"
                                            data-target="#modal_delete_contract_<?php echo e($pending_contract->contract_id); ?>" class="btn btn-danger btn-sm btn-flat"><i class="glyphicon glyphicon-trash"></i> Delete</a>
                                            <?php endif; ?> <?php endif; ?>
                                                    </td>
                                                    <?php echo Form::close(); ?>

                                                </tr>
                                                <?php echo $__env->make('contracts.modals.modal_delete_contract', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
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
                        <th>Status</th>
                        <?php if(auth()->check()): ?> <?php if(auth()->user()->isAdmin() || auth()->user()->isLegal()): ?>
                        <th>Alert</th>
                        <?php endif; ?> <?php endif; ?>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $pending_contracts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$pending_contract): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($key+1); ?></td>
                        <td><a
                                href="/contract/<?php echo e($pending_contract->contract_id); ?>/view"><?php echo e($pending_contract->contract_code); ?></a>
                        </td>
                        <td><a
                                href="/contract/<?php echo e($pending_contract->contract_id); ?>/view"><?php echo e($pending_contract->contract_title); ?></a>
                        </td>
                        <td><a href="/contract-party/<?php echo e($pending_contract->party_id); ?>/view-contract-party"
                                target="_blank">
                                <span class="label"
                                    style="background-color:#FFF;color:#0073b7;border:1px solid #0073b7;">
                                    <i class="fa fa-briefcase fa-fw"></i> <?php echo e($pending_contract->party_name); ?> </a></span>
                        </td>

                        <td><span class="pull-right-container">
                                <small class="badge bg-yellow"><?php echo e($pending_contract->status_name); ?></small></span>
                        </td>
                         <?php if(auth()->check()): ?> <?php if(auth()->user()->isAdmin() || auth()->user()->isLegal()): ?>
                        <td>
                            <?php if($pending_contract->assigned=='' && $pending_contract->escalation_duration >=10): ?>
                            <span class="label"
                                style="background-color:#FFF;color:#ff0000;border:1px solid #ff0000">Overdue</span>
                            <?php elseif($pending_contract->assigned=='' && $pending_contract->escalation_duration
                            <10): ?> <span class="label"
                                style="background-color:#FFF;color:#1e3fda;border:1px solid #1e3fda">Open</span>
                                <?php else: ?>
                                <span class="label"
                                    style="background-color:#FFF;color:#058e29;border:1px solid #058e29">Assigned</span>
                                <?php endif; ?>
                        </td>
                        <?php endif; ?> <?php endif; ?>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown"
                                    aria-expanded="true">Actions<span class="caret"></span><span class="sr-only">Toggle
                                        Dropdown</span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                    <li><a href="/contract/<?php echo e($pending_contract->contract_id); ?>/view"
                                            class="view-contract"><i class="fa fa-eye"></i> View</a></li>
                                </ul>
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
    $(function ()
    {
    $('#example1').DataTable()
    $('#example2').DataTable()
    $('#example3').DataTable()
    $('#example4').DataTable()
});

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>