<?php $__env->startSection('title', 'CMS | Dashboard'); ?>
<?php $__env->startSection('content_header'); ?>
<h1>Dashboard</h1>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row" style="font-size:10px;">
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3><?php echo e($published_contract_count); ?></h3>
                <p>Pending Contracts</p>
            </div>
            <div class="icon">
                <i class="fa fa-desktop"></i>
            </div>
            <a href="pending-contracts" class="small-box-footer">View Contracts <i
                    class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-blue">
            <div class="inner">
                <h3><?php echo e($ammended_contract_count); ?></h3>
                <p>Amended Contracts</p>
            </div>
            <div class="icon">
                <i class="fa fa-certificate"></i>
            </div>
            <a href="amended-contracts" class="small-box-footer">View Contracts <i
                    class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3><?php echo e($closed_contract_count); ?></h3>
                <p>Closed Contracts</p>
            </div>
            <div class="icon">
                <i class="fa fa-briefcase"></i>
            </div>
            <a href="closed-contracts" class="small-box-footer">View Contracts <i
                    class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-red">
            <div class="inner">
                <h3><?php echo e($terminated_contract_count); ?></h3>
                <p>Terminated Contracts</p>
            </div>
            <div class="icon">
                <i class="fa fa-rocket"></i>
            </div>
            <a href="terminated-contracts" class="small-box-footer">View Contracts <i
                    class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
</div>
<div class="row" style="font-size:10px;">
    <div class="col-md-8">
        <div class="box box-success">
            <div class="box-header with-border">
                <?php if(auth()->check()): ?> <?php if(auth()->user()->isAdmin() || auth()->user()->isLegal()): ?>
                <h3 class="box-title">Latest Pending Contracts (Unassigned)</h3>
                <?php elseif(auth()->user()->isUser()): ?>
                <h3 class="box-title">Latest Approved Contracts</h3>
                <?php endif; ?> <?php endif; ?>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Ticket</th>
                                <th>Contract Title</th>
                                <th>Party Name</th>
                                <th>Effective Date</th>
                                <th>Status</th>
                                <?php if(auth()->check()): ?> <?php if(auth()->user()->isAdmin() || auth()->user()->isLegal()): ?>
                                <th>Alert</th>
                                <?php endif; ?> <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $contracts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$contract): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($key+1); ?></td>
                                <td><a href="/contract/<?php echo e($contract->contract_id); ?>/view"><?php echo e($contract->contract_code); ?></a>
                                </td>
                                <td><a
                                        href="/contract/<?php echo e($contract->contract_id); ?>/view"><?php echo e($contract->contract_title); ?></a>
                                </td>
                                <td><a href="/contract-party/<?php echo e($contract->party_id); ?>/view-contract-party"
                                        target="_blank">
                                        <span class="label"
                                            style="background-color:#FFF;color:#0073b7;border:1px solid #0073b7;">
                                            <i class="fa fa-briefcase fa-fw"></i> <?php echo e($contract->party_name); ?> </a></span>
                                </td>
                                <td><?php echo e($contract->created_at); ?></td>
                                <td><span class="pull-right-container">
                                        <?php if($contract->contract_status == 'Created'): ?>
                                        <small class="badge bg-purple"><?php echo e($contract->contract_status); ?></small></span>
                                    <?php elseif($contract->contract_status == 'Pending'): ?>
                                    <small class="badge bg-yellow"><?php echo e($contract->contract_status); ?></small></span>
                                    <?php elseif($contract->contract_status== 'Amended'): ?>
                                    <small class="badge bg-blue"><?php echo e($contract->contract_status); ?></small></span>
                                    <?php elseif($contract->contract_status== 'Approved'): ?>
                                    <small class="badge bg-green"><?php echo e($contract->contract_status); ?></small></span>
                                    <?php elseif($contract->contract_status== 'Closed'): ?>
                                    <small class="badge bg-aqua"><?php echo e($contract->contract_status); ?></small></span>
                                    <?php elseif($contract->contract_status== 'Terminated'): ?>
                                    <small class="badge bg-red"><?php echo e($contract->contract_status); ?></small></span>
                                </td>
                                <?php endif; ?>
                                </td>
                                <?php if(auth()->check()): ?> <?php if(auth()->user()->isAdmin() || auth()->user()->isLegal()): ?>
                                <td>
                                    <?php if($contract->assigned=='' && $contract->escalation_duration >=1): ?>
                                    <span class="label"
                                        style="background-color:#FFF;color:#ff0000;border:1px solid #ff0000">Overdue</span>
                                    <?php elseif($contract->assigned=='' && $contract->escalation_duration
                                    <1): ?> <span class="label"
                                        style="background-color:#FFF;color:#1e3fda;border:1px solid #1e3fda">Open</span>
                                        <?php else: ?>
                                        <span class="label"
                                            style="background-color:#FFF;color:#058e29;border:1px solid #058e29">Assigned</span>
                                        <?php endif; ?>
                                </td>
                                <?php endif; ?> <?php endif; ?> <?php echo Form::close(); ?>

                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <?php if(auth()->check()): ?> <?php if(auth()->user()->isAdmin() || auth()->user()->isLegal()): ?>
                <div class="box-footer text-center">
                    <a href="pending-contracts" class="uppercase">View All Pending Contracts</a>
                </div>
                <?php else: ?>
                <div class="box-footer text-center">
                    <a href="pending-contracts" class="uppercase">View All Approved Contracts</a>
                </div>
                <?php endif; ?> <?php endif; ?>
                <!-- /.table-responsive -->

            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix" style="">

            </div>
            <!-- /.box-footer -->
        </div>
        <div class="box box-success">
            <div class="box-header with-border">
                <?php if(auth()->check()): ?> <?php if(auth()->user()->isAdmin() || auth()->user()->isLegal()): ?>
                <h3 class="box-title">Latest Closed Contracts</h3>
                <?php elseif(auth()->user()->isUser()): ?>
                <h3 class="box-title">Latest Amended Contracts</h3>
                <?php endif; ?> <?php endif; ?>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Ticket #</th>
                                <th>Contract Title</th>
                                <th>Party Name</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $contracts1; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$contract1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($key+1); ?></td>
                                <td><a
                                        href="/contract/<?php echo e($contract1->contract_id); ?>/view"><?php echo e($contract1->contract_code); ?></a>
                                </td>
                                <td><a
                                        href="/contract/<?php echo e($contract1->contract_id); ?>/view"><?php echo e($contract1->contract_title); ?></a>
                                </td>
                                <td><a href="/contract-party/<?php echo e($contract1->party_id); ?>/view-contract-party"
                                        target="_blank">
                                        <span class="label"
                                            style="background-color:#FFF;color:#0073b7;border:1px solid #0073b7;">
                                            <i class="fa fa-briefcase fa-fw"></i> <?php echo e($contract1->party_name); ?> </a></span>
                                </td>
                                <td><?php echo e($contract1->created_at); ?></td>
                                <td><span class="pull-right-container">
                                        <?php if($contract1->contract_status == 'Created'): ?>
                                        <small class="badge bg-purple"><?php echo e($contract1->contract_status); ?></small></span>
                                    <?php elseif($contract1->contract_status == 'Pending'): ?>
                                    <small class="badge bg-yellow"><?php echo e($contract1->contract_status); ?></small></span>
                                    <?php elseif($contract1->contract_status== 'Amended'): ?>
                                    <small class="badge bg-blue"><?php echo e($contract1->contract_status); ?></small></span>
                                    <?php elseif($contract1->contract_status== 'Approved'): ?>
                                    <small class="badge bg-green"><?php echo e($contract1->contract_status); ?></small></span>
                                    <?php elseif($contract1->contract_status== 'Closed'): ?>
                                    <small class="badge bg-aqua"><?php echo e($contract1->contract_status); ?></small></span>
                                    <?php elseif($contract1->contract_status== 'Terminated'): ?>
                                    <small class="badge bg-purple"><?php echo e($contract1->contract_status); ?></small></span>
                                </td>
                                <?php endif; ?>
                                </td>
                                <?php echo Form::close(); ?>

                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <?php if(auth()->check()): ?> <?php if(auth()->user()->isAdmin() || auth()->user()->isLegal()): ?>
                <div class="box-footer text-center">
                    <a href="closed-contracts" class="uppercase">View All Closed Contracts</a>
                </div>
                <?php else: ?>
                <div class="box-footer text-center">
                    <a href="approved-contracts" class="uppercase">View All Amended Contracts</a>
                </div>
                <?php endif; ?> <?php endif; ?>
                <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix" style="">
            </div>
            <!-- /.box-footer -->
        </div>
    </div>

    <div class="col-md-4">
        <?php if(auth()->check()): ?> <?php if(auth()->user()->isLegal()): ?>
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">My Assigned Contracts</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Ticket #</th>
                                <th>Contract Title</th>
                                <th>Party Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $assigned_contracts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$assigned_contract): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($key+1); ?></td>
                                <td><a
                                        href="/contract/<?php echo e($assigned_contract->contract_id); ?>/view"><?php echo e($assigned_contract->contract_code); ?></a>
                                </td>
                                <td><a
                                        href="/contract/<?php echo e($assigned_contract->contract_id); ?>/view"><?php echo e($assigned_contract->contract_title); ?></a>
                                </td>
                                <td><a href="/contract-party/<?php echo e($assigned_contract->party_id); ?>/view-contract-party"
                                        target="_blank">
                                        <?php echo e($assigned_contract->party_name); ?></a>
                                </td>
                                <?php echo Form::close(); ?>

                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <div class="box-footer text-center">
                    <a href="my-assigned-contracts" class="uppercase">View My Assigned Contracts</a>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix" style="">
            </div>
            <!-- /.box-footer -->
        </div>
        <?php elseif(auth()->user()->isAdmin() || auth()->user()->isUser()): ?>
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Contracts Statistics</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                            class="fa fa-minus"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="">
                <div class="col-md-12">
                    <!-- /.progress-group -->
                    <?php if(auth()->check()): ?> <?php if(auth()->user()->isAdmin() || auth()->user()->isUser()): ?>
                    <div class="progress-group">
                        <span class="progress-text">Pending Contracts</span>
                        <span
                            class="progress-number"><b><?php echo e($published_contract_count); ?></b>/<?php echo e($total_contracts_count); ?></span>

                        <div class="progress sm">
                            <div class="progress-bar progress-bar-yellow" style="width: <?php echo e($published_percentage); ?>%">
                            </div>
                        </div>
                    </div>
                    <?php else: ?> <?php endif; ?> <?php endif; ?>
                    <div class="progress-group">
                        <span class="progress-text">Approved Contracts</span>
                        <span
                            class="progress-number"><b><?php echo e($approved_contract_count); ?></b>/<?php echo e($total_contracts_count); ?></span>

                        <div class="progress sm">
                            <div class="progress-bar progress-bar-green" style="width: <?php echo e($approved_percentage); ?>%">
                            </div>
                        </div>
                    </div>
                    <div class="progress-group">
                        <span class="progress-text">Closed Contracts</span>
                        <span
                            class="progress-number"><b><?php echo e($closed_contract_count); ?></b>/<?php echo e($total_contracts_count); ?></span>

                        <div class="progress sm">
                            <div class="progress-bar progress-bar-grey" style="width: <?php echo e($closed_percentage); ?>%"></div>
                        </div>
                    </div>
                    <!-- /.progress-group -->
                    <div class="progress-group">
                        <span class="progress-text">Amended Contracts</span>
                        <span
                            class="progress-number"><b><?php echo e($ammended_contract_count); ?></b>/<?php echo e($total_contracts_count); ?></span>

                        <div class="progress sm">
                            <div class="progress-bar progress-bar-blue" style="width: <?php echo e($ammended_percentage); ?>%">
                            </div>
                        </div>
                    </div>
                    <div class="progress-group">
                        <span class="progress-text">Terminated Contracts</span>
                        <span
                            class="progress-number"><b><?php echo e($terminated_contract_count); ?></b>/<?php echo e($total_contracts_count); ?></span>

                        <div class="progress sm">
                            <div class="progress-bar progress-bar-red" style="width: <?php echo e($terminated_percentage); ?>%">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer text-center">
                    <a href="approved-contracts" class="uppercase"></a>
                </div>
                <div class="box-footer text-center">
                    <a href="approved-contracts" class="uppercase">View All Contracts</a>
                </div>
            </div>
            <!-- /.box-body -->
            <!-- /.box-footer -->
        </div>
        <?php endif; ?> <?php endif; ?> <?php if(auth()->check()): ?> <?php if(auth()->user()->isAdmin()): ?>
        <div class="box box-success">
            <div class="box-header with-border">
                <?php if(auth()->check()): ?> <?php if(auth()->user()->isAdmin() || auth()->user()->isLegal()): ?>
                <h3 class="box-title">Latest Contract Parties</h3>
                <?php else: ?> <?php endif; ?> <?php endif; ?>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Party Name</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $parties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$party): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($key+1); ?></td>
                                <td><a href="/contract-party/<?php echo e($party->party_id); ?>/view-contract-party" target="_blank">
                                        <?php echo e($party->party_name); ?></a>
                                </td>
                                <td><?php echo e($party->email); ?></td>
                                </td>
                                <?php echo Form::close(); ?>

                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <div class="box-footer text-center">
                    <a href="approved-contracts" class="uppercase">View All Contract Parties</a>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix" style="">
            </div>
            <!-- /.box-footer -->
        </div>
        <?php elseif(auth()->user()->isLegal()): ?>
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Contracts Statistics</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                            class="fa fa-minus"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="">
                <div class="col-md-12">
                    <div class="progress-group">
                        <span class="progress-text">Approved Contracts</span>
                        <span
                            class="progress-number"><b><?php echo e($approved_contract_count); ?></b>/<?php echo e($total_contracts_count); ?></span>

                        <div class="progress sm">
                            <div class="progress-bar progress-bar-green" style="width: <?php echo e($approved_percentage); ?>%">
                            </div>
                        </div>
                    </div>
                    <div class="progress-group">
                        <span class="progress-text">Closed Contracts</span>
                        <span
                            class="progress-number"><b><?php echo e($closed_contract_count); ?></b>/<?php echo e($total_contracts_count); ?></span>

                        <div class="progress sm">
                            <div class="progress-bar progress-bar-grey" style="width: <?php echo e($closed_percentage); ?>%"></div>
                        </div>
                    </div>
                    <!-- /.progress-group -->
                    <div class="progress-group">
                        <span class="progress-text">Amended Contracts</span>
                        <span
                            class="progress-number"><b><?php echo e($ammended_contract_count); ?></b>/<?php echo e($total_contracts_count); ?></span>

                        <div class="progress sm">
                            <div class="progress-bar progress-bar-blue" style="width: <?php echo e($ammended_percentage); ?>%">
                            </div>
                        </div>
                    </div>
                    <div class="progress-group">
                        <span class="progress-text">Terminated Contracts</span>
                        <span
                            class="progress-number"><b><?php echo e($terminated_contract_count); ?></b>/<?php echo e($total_contracts_count); ?></span>

                        <div class="progress sm">
                            <div class="progress-bar progress-bar-red" style="width: <?php echo e($terminated_percentage); ?>%">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer text-center">
                    <a href="approved-contracts" class="uppercase"></a>
                </div>
                <div class="box-footer text-center">
                    <a href="approved-contracts" class="uppercase">View All Contracts</a>
                </div>
            </div>
            <!-- /.box-body -->
            <!-- /.box-footer -->
        </div>
        <?php endif; ?> <?php endif; ?>
    </div>
</div>

<!-- PAGE FOOTER -->
<?php echo $__env->make('page.footer', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="/css/admin_custom.css">
<link rel="stylesheet" href="/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="/css/select2.min.css">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
<script src="/js/bootstrap-datepicker.min.js"></script>
<script src="/js/select2.full.min.js"></script>
<script src="/js/bootbox.min.js"></script>

<script>
    $(function () {
         $('#example1').DataTable()
         $('#example2').DataTable()
         $('#example3').DataTable()
         $('#example4').DataTable()
         //Initialize Select2 Elements
          $('.select2').select2()
        $(document).ready(function() {
});
    });

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>