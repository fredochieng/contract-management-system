<?php $__env->startSection('title', 'Wananchi Legal | View Report'); ?>
<?php $__env->startSection('content_header'); ?>
<?php if($report_type=='status'): ?>
    <?php if($status=='1'): ?>
         <h1 class="pull-left">View Reports<small Pending contracts for duration <?php echo e($from); ?> - <?php echo e($to); ?></small></h1>
         <?php elseif($status==2): ?>
         <h1 class="pull-left">View Reports<small> Reviewed contracts for duration <?php echo e($from); ?> - <?php echo e($to); ?></small></h1>
         <?php elseif($status==3): ?>
         <h1 class="pull-left">View Reports<small>Approved contracts for duration <?php echo e($from); ?> - <?php echo e($to); ?></small></h1>
         <?php elseif($status==4): ?>
         <h1 class="pull-left">View Reports<small>Closed contracts for duration <?php echo e($from); ?> - <?php echo e($to); ?></small></h1>
         <?php elseif($status==5): ?>
         <h1 class="pull-left">View Reports<small>All contracts for duration <?php echo e($from); ?> - <?php echo e($to); ?></small></h1>
    <?php endif; ?>
<?php elseif($report_type=='contract_type'): ?>
<h1 class="pull-left">View Reports<small><?php echo e($contract_type_name); ?> contracts</small></h1>
<?php elseif($report_type=='contract_party'): ?>
<h1 class="pull-left">View Reports<small><?php echo e($party->party_name); ?> contracts</small></h1>
<?php elseif($report_type=='contract_expiry'): ?>
    <?php if($expiry_id==1): ?>
    <h1 class="pull-left">View Reports<small>Active contracts</small></h1>
    <?php elseif($expiry_id==2): ?>
    <h1 class="pull-left">View Reports<small>Expired contracts</small></h1>
    <?php endif; ?>
<?php endif; ?>
<div style="clear:both"></div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php if($report_type=='status'): ?>
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
                                <th>Reviewer</th>
                                <th>Date Created</th>
                                 
                                <?php if($status==4): ?>
                                <th>Date Closed</th>
                                <?php endif; ?>
                                <th>Status</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $contracts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$collection): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($key+1); ?></td>
                              <td><a href="/contract/<?php echo e($collection->contract_id); ?>/view"><?php echo e($collection->contract_code); ?></a>
                            </td>
                                <td><a
                                        href="/contract/<?php echo e($collection->contract_id); ?>/view"><?php echo e($collection->contract_title); ?></a>
                                </td>
                                <td><a href="/contract-party/<?php echo e($collection->party_id); ?>/view-contract-party"
                                        target="_blank">
                                        <span class="label"
                                            style="background-color:#FFF;color:#0073b7;border:1px solid #0073b7;">
                                            <i class="fa fa-briefcase fa-fw"></i>
                                            <?php echo e($collection->party_name); ?> </a></span>
                                </td>
                                <?php if($collection->name == ''): ?>
                                <td>Not assigned</td>
                                <?php else: ?>
                                <td><?php echo e($collection->name); ?></td>
                                <?php endif; ?>

                                <?php if($status=='Closed'): ?>
                                <td><?php echo e($collection->contract_type_name); ?></td>
                                <?php endif; ?>

                                <td><?php echo e(date("Y-m-d H:m:s",strtotime($collection->created_date))); ?>

                               </td>
                                <td><?php echo e(date("Y-m-d H:m:s",strtotime($collection->date))); ?>

                               </td>
<td><span class="pull-right-container">
        <small class="badge bg-<?php echo e($collection->label_color); ?>"><?php echo e($collection->status_name); ?></small></span>
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
<?php elseif($report_type=='contract_type'): ?>
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
                                <th>Reviewer</th>
                                <th>Date Created</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $contract_type_report; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$collection1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($key+1); ?></td>
                             <td><a href="/contract/<?php echo e($collection1->contract_id); ?>/view"><?php echo e($collection1->contract_code); ?></a>
                                </td>
                                <td><a
                                        href="/contract/<?php echo e($collection1->contract_id); ?>/view"><?php echo e($collection1->contract_title); ?></a>
                                </td>
                                <td><a href="/contract-party/<?php echo e($collection1->party_id); ?>/view-contract-party"
                                        target="_blank">
                                        <span class="label"
                                            style="background-color:#FFF;color:#0073b7;border:1px solid #0073b7;">
                                            <i class="fa fa-briefcase fa-fw"></i>
                                            <?php echo e($collection1->party_name); ?> </a></span>
                                </td>
                              <?php if($collection1->name == ''): ?>
                            <td>Not assigned</td>
                            <?php else: ?>
                            <td><?php echo e($collection1->name); ?></td>
                            <?php endif; ?>
                                <td><?php echo e(date("Y-m-d H:m:s",strtotime($collection1->created_at))); ?>

                                </td>
                                <td><span class="pull-right-container">
                                        <small class="badge bg-<?php echo e($collection1->label_color); ?>"><?php echo e($collection1->status_name); ?></small></span>
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
<?php elseif($report_type=='contract_party'): ?>
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
                                <th>Reviewer</th>
                                <th>Date Created</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $contract_party_report; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$collection1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($key+1); ?></td>
                            <td><a href="/contract/<?php echo e($collection1->contract_id); ?>/view"><?php echo e($collection1->contract_code); ?></a>
                            </td>
                                <td><a
                                        href="/contract/<?php echo e($collection1->contract_id); ?>/view"><?php echo e($collection1->contract_title); ?></a>
                                </td>
                                <td><a href="/contract-party/<?php echo e($collection1->party_id); ?>/view-contract-party"
                                        target="_blank">
                                        <span class="label"
                                            style="background-color:#FFF;color:#0073b7;border:1px solid #0073b7;">
                                            <i class="fa fa-briefcase fa-fw"></i>
                                            <?php echo e($collection1->party_name); ?> </a></span>
                                </td>
                              <?php if($collection1->name == ''): ?>
                            <td>Not assigned</td>
                            <?php else: ?>
                            <td><?php echo e($collection1->name); ?></td>
                            <?php endif; ?>
                                <td><?php echo e(date("Y-m-d H:m:s",strtotime($collection1->created_date))); ?>

                                </td>
                                <td><span class="pull-right-container">
                                            <small class="badge bg-<?php echo e($collection1->label_color); ?>"><?php echo e($collection1->status_name); ?></small></span>
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
<?php elseif($report_type=='contract_expiry'): ?>
<div class="row">
    <div class="col-xs-12">
        <div class="box box-success">
            <div class="box-body">
                <div class="table-responsive">
                    <table id="example1" class="table no-margin">
                        <thead>
                            <tr>
                                <th>Ticket #</th>
                                <th>Contract Title</th>
                                <th>Party Name</th>
                                <th>Reviewer</th>
                                <th>Date Created</th>
                                <th>Status</th>
                                <th>Expiry Alert</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $contract_expiry_report; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$collection1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($expiry_id==2): ?>
                            <?php if($collection1->expired == 0 ){ continue; } ?>
                            <?php elseif($expiry_id==1): ?>
                            <?php if($collection1->expired == 1 ){ continue; } ?>
                            <?php endif; ?>

                            <tr>
                                <td><a
                                        href="/contract/<?php echo e($collection1->contract_id); ?>/view"><?php echo e($collection1->contract_code); ?></a>
                                </td>
                                <td><a
                                        href="/contract/<?php echo e($collection1->contract_id); ?>/view"><?php echo e($collection1->contract_title); ?></a>
                                </td>
                                <td><a href="/contract-party/<?php echo e($collection1->party_id); ?>/view-contract-party"
                                        target="_blank">
                                        <span class="label"
                                            style="background-color:#FFF;color:#0073b7;border:1px solid #0073b7;">
                                            <i class="fa fa-briefcase fa-fw"></i>
                                            <?php echo e($collection1->party_name); ?> </a></span>
                                </td>
                                <?php if($collection1->name == ''): ?>
                                <td>Not assigned</td>
                                <?php else: ?>
                                <td><?php echo e($collection1->name); ?></td>
                                <?php endif; ?>
                                <td><?php echo e(date("Y-m-d H:m:s",strtotime($collection1->created_date))); ?>

                                </td>

                                <td><span class="pull-right-container">
                                        <small
                                            class="badge bg-<?php echo e($collection1->label_color); ?>"><?php echo e($collection1->status_name); ?></small></span>
                                </td>
                                <?php if($collection1->expired==1): ?>
                                <td><span class="pull-right-container"><small class="badge bg-red">Expired</small></span> </td>
                                </td>
                                <?php else: ?>
                                <td><span class="pull-right-container">
                                        <small class="badge bg-aqua">Active</small></span>
                                </td>
                                <?php endif; ?>
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
<?php endif; ?>
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