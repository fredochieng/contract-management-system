<?php $__env->startSection('title', 'Contract Management System'); ?>
<?php $__env->startSection('content_header'); ?>
<h1>Dashboard</h1>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3><?php echo e($published_contract_count); ?></h3>
                <p>Pending Contracts</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="pending-contracts" class="small-box-footer">View Contracts  <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-blue">
            <div class="inner">
                <h3><?php echo e($ammended_contract_count); ?></h3>
                <p>Ammended Contracts</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">View Contracts  <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-green">
            <div class="inner">
                <h3><?php echo e($approved_contract_count); ?></h3>
                <p>Approved Contracts</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer">View Contracts  <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-red">
            <div class="inner">
                <h3><?php echo e($terminated_contract_count); ?></h3>
                <p>Terminated Contracts</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">View Contracts  <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
</div>
<div class="row">
    <div class="col-md-8">
        <div class="box box-success">
            <div class="box-header with-border">
                <?php if(auth()->check()): ?> <?php if(auth()->user()->isAdmin() || auth()->user()->isLegal()): ?>
                <h3 class="box-title">Latest Pending Contracts</h3>
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
                                <th style="width:25px;">S/N</th>
                                <th style="width:200px;">Contract Title</th>
                                <th style="width:160px;">Party Name</th>
                                 
                                <th style="width:145px;">Date</th>
                                
                                <th style="width:50px;">Status</th>
                                <?php if(auth()->check()): ?> <?php if(auth()->user()->isAdmin() || auth()->user()->isLegal()): ?>
                                <th style="width:70px;">Alert</th>
                                 <?php endif; ?> <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $contracts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$contract): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($key+1); ?></td>
                                <td><a href="/contract/<?php echo e($contract->contract_id); ?>/view"><?php echo e($contract->contract_title); ?></a></td>
                                <td><?php echo e($contract->party_name); ?></td>
                                 
                                <td><?php echo e($contract->created_at); ?></td>
                                
                                <td><span class="pull-right-container">
                                                                    <?php if($contract->contract_status == 'created'): ?>
                                                                    <small class="badge bg-purple"><?php echo e($contract->contract_status); ?></small></span>                                    <?php elseif($contract->contract_status == 'published'): ?>
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
                                <?php if(auth()->check()): ?> <?php if(auth()->user()->isAdmin() || auth()->user()->isLegal()): ?>
                                <td>
                                    <?php if($contract->assigned=='' && $contract->escalation_duration >=10): ?>
                                    <span class="label" style="background-color:#FFF;color:#ff0000;border:1px solid #ff0000">Overdue</span>                                    <?php elseif($contract->assigned=='' && $contract->escalation_duration
                                    <10): ?> <span class="label" style="background-color:#FFF;color:#1e3fda;border:1px solid #1e3fda">Open</span>
                                        <?php else: ?>
                                        <span class="label" style="background-color:#FFF;color:#058e29;border:1px solid #058e29">Assigned</span>                                        <?php endif; ?>
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
    </div>
    <div class="col-md-4">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Contracts Statistics</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="">
                <div class="col-md-12">
                    <!-- /.progress-group -->
                    <div class="progress-group">
                        <span class="progress-text">Pending Contracts</span>
                        <span class="progress-number"><b><?php echo e($published_contract_count); ?></b>/<?php echo e($total_contracts_count); ?></span>

                        <div class="progress sm">
                            <div class="progress-bar progress-bar-yellow" style="width: <?php echo e($published_percentage); ?>%"></div>
                        </div>
                    </div>
                    <div class="progress-group">
                        <span class="progress-text">Approved Contracts</span>
                        <span class="progress-number"><b><?php echo e($approved_contract_count); ?></b>/<?php echo e($total_contracts_count); ?></span>

                        <div class="progress sm">
                            <div class="progress-bar progress-bar-green" style="width: <?php echo e($approved_percentage); ?>%"></div>
                        </div>
                    </div>
                    <!-- /.progress-group -->
                    <div class="progress-group">
                        <span class="progress-text">Ammended Contracts</span>
                        <span class="progress-number"><b><?php echo e($ammended_contract_count); ?></b>/<?php echo e($total_contracts_count); ?></span>

                        <div class="progress sm">
                            <div class="progress-bar progress-bar-blue" style="width: <?php echo e($ammended_percentage); ?>%"></div>
                        </div>
                    </div>
                    <div class="progress-group">
                        <span class="progress-text">Terminated Contracts</span>
                        <span class="progress-number"><b><?php echo e($terminated_contract_count); ?></b>/<?php echo e($total_contracts_count); ?></span>

                        <div class="progress sm">
                            <div class="progress-bar progress-bar-red" style="width: <?php echo e($terminated_percentage); ?>%"></div>
                        </div>
                    </div>
                </div>
                <div class="box-footer text-center">
                    <a href="approved-contracts" class="uppercase">View All Contracts</a>
                </div>
            </div>
            <!-- /.box-body -->
            <!-- /.box-footer -->
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <div class="box box-success">
            <div class="box-header with-border">
                <?php if(auth()->check()): ?> <?php if(auth()->user()->isAdmin() || auth()->user()->isLegal()): ?>
                <h3 class="box-title">Latest Approved Contracts</h3>
                <?php elseif(auth()->user()->isUser()): ?>
                <h3 class="box-title">Latest Ammended Contracts</h3>
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
                                <th style="width:25px;">S/N</th>
                                <th style="width:300px;">Contract Title</th>
                                <th style="width:160px;">Party Name</th>
                                 
                                <th style="width:145px;">Date</th>
                                
                                <th style="width:50px;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $contracts1; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$contract1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($key+1); ?></td>
                                <td><a href="/contract/<?php echo e($contract1->contract_id); ?>/view"><?php echo e($contract1->contract_title); ?></a></td>
                                <td><?php echo e($contract1->party_name); ?></td>
                                 
                                <td><?php echo e($contract1->created_at); ?></td>
                                
                                <td><span class="pull-right-container">
                                    <?php if($contract1->contract_status == 'created'): ?>
                                    <small class="badge bg-purple"><?php echo e($contract1->contract_status); ?></small></span> <?php elseif($contract1->contract_status
                                    == 'published'): ?>
                                    <small class="badge bg-yellow"><?php echo e($contract1->contract_status); ?></small></span>
                                    <?php elseif($contract1->contract_status== 'ammended'): ?>
                                    <small class="badge bg-blue"><?php echo e($contract1->contract_status); ?></small></span>
                                    <?php elseif($contract1->contract_status== 'approved'): ?>
                                    <small class="badge bg-green"><?php echo e($contract1->contract_status); ?></small></span>
                                    <?php elseif($contract1->contract_status== 'terminated'): ?>
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
                    <a href="approved-contracts" class="uppercase">View All Approved Contracts</a>
                </div>
                <?php else: ?>
                <div class="box-footer text-center">
                    <a href="approved-contracts" class="uppercase">View All Ammended Contracts</a>
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
    <?php if(auth()->check()): ?> <?php if(auth()->user()->isAdmin()): ?>
    <div class="col-md-4">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#legalcounsel" data-toggle="tab">Legal Counsel</a></li>
                <li><a href="#standardusers" data-toggle="tab">Standard Users</a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="legalcounsel">
                    <div class="box-body" style="">
                        <div class="table-responsive">
                            <table id="example3" class="table no-margin">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th style="width:200px">Name</th>
                                        <th>Email</th>
                                        <th style="width:40px">Entity</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($key + 1); ?></td>
                                        <td><?php echo e($user->name); ?></td>
                                        <td><?php echo e($user->email); ?></td>
                                        <td><?php echo e($user->organization_name); ?></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="box-footer text-center">
                    <a href="approved-contracts" class="uppercase">View All Users</a>
                </div>
                <div class="tab-pane" id="standardusers">
                    <div class="box-body" style="">
                        <div class="table-responsive">
                            <table id="example4" class="table no-margin">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th style="width:200px">Name</th>
                                        <th>Email</th>
                                        <th style="width:40px">Entity</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $standard_users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($key + 1); ?></td>
                                        <td><?php echo e($user->name); ?></td>
                                        <td><?php echo e($user->email); ?></td>
                                        <td><?php echo e($user->organization_name); ?></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?> <?php endif; ?>
        </div>
    </div>


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