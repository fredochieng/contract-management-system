<?php $__env->startSection('title', 'Contract Management System'); ?>
<?php $__env->startSection('content_header'); ?>
<h1>Dashboard</h1>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <?php if(auth()->check()): ?> <?php if(auth()->user()->isAdmin()): ?>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3><?php echo e($submitted_contract_count); ?></h3>
                <p>Submitted Contracts</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>

        </div>
    </div>
    <?php elseif(auth()->user()->isLegal()): ?>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-purple">
            <div class="inner">
                <h3><?php echo e($published_contract_count); ?></h3>
                <p>Pending Contracts</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>

        </div>
    </div>
    <?php elseif(auth()->user()->isUser()): ?>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3><?php echo e($ammended_contract_count); ?></h3>
                <p>Ammended Contracts</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>

        </div>
    </div>
    <?php endif; ?> <?php endif; ?>
<?php if(auth()->check()): ?> <?php if(auth()->user()->isAdmin() || auth()->user()->isUser()): ?>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-purple">
            <div class="inner">
                <h3><?php echo e($published_contract_count); ?></h3>
                <p>Pending Contracts</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>

        </div>
    </div>
    <?php elseif(auth()->user()->isLegal()): ?>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3><?php echo e($ammended_contract_count); ?></h3>
                <p>Ammended Contracts</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>

        </div>
    </div>
    <?php endif; ?> <?php endif; ?>
  <?php if(auth()->check()): ?> <?php if(auth()->user()->isAdmin() || auth()->user()->isUser()): ?>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-green">
            <div class="inner">
                <h3><?php echo e($approved_contract_count); ?></h3>
                <p>Approved Contracts</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>

        </div>
    </div>
    <?php elseif(auth()->user()->isLegal()): ?>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3><?php echo e($submitted_contract_count); ?></h3>
                <p>Submitted Contracts</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>

        </div>
    </div>
    <?php endif; ?> <?php endif; ?>
    <?php if(auth()->check()): ?> <?php if(auth()->user()->isAdmin()): ?>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3><?php echo e($ammended_contract_count); ?></h3>
                <p>Ammended Contracts</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>

        </div>
    </div>
    <<?php elseif(auth()->user()->isLegal()): ?>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-green">
            <div class="inner">
                <h3><?php echo e($approved_contract_count); ?></h3>
                <p>Approved Contracts</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>

        </div>
    </div>
    <?php elseif(auth()->user()->isUser()): ?>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-red">
            <div class="inner">
                <h3><?php echo e($terminated_contract_count); ?></h3>
                <p>Terminated Contracts</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>

        </div>
    </div>
    <?php endif; ?> <?php endif; ?>
    <!-- ./col -->
</div>
<div class="row">
    <div class="col-md-6">
        <div class="box box-info">
            <div class="box-header with-border">
                <?php if(auth()->check()): ?> <?php if(auth()->user()->isAdmin()): ?>
                <h3 class="box-title">Latest Submitted Contracts</h3>
                <?php elseif(auth()->user()->isLegal()): ?>
                <h3 class="box-title">Latest Published Contracts</h3>
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
                    <table id="example1" class="table no-margin">
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
                            <?php $__currentLoopData = $contracts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$contract): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($key+1); ?></td>
                                <td><a href="/contract/<?php echo e($contract->contract_id); ?>/view"><?php echo e($contract->contract_title); ?></a></td>
                                <td><?php echo e($contract->party_name); ?></td>
                                
                                
                                <td><?php echo e($contract->created_at); ?></td>
                                
                                <td><span class="pull-right-container">
                                    <?php if($contract->contract_status == 'created'): ?>
                                    <small class="label pull-center btn-warning"><?php echo e($contract->contract_status); ?></small></span>                                    <?php elseif($contract->contract_status == 'published'): ?>
                                    <small class="label pull-center btn-info"><?php echo e($contract->contract_status); ?></small></span>
                                    <?php elseif($contract->contract_status== 'submitted'): ?>
                                    <small class="label label-success"><?php echo e($contract->contract_status); ?></small></span>
                                    <?php elseif($contract->contract_status== 'ammended'): ?>
                                    <small class="label pull-center btn-danger"><?php echo e($contract->contract_status); ?></small></span>
                                    <?php elseif($contract->contract_status== 'approved'): ?>
                                    <small class="label pull-center btn-success"><?php echo e($contract->contract_status); ?></small></span>
                                    <?php elseif($contract->contract_status== 'terminated'): ?>
                                    <small class="label pull-center btn-danger"><?php echo e($contract->contract_status); ?></small></span>
                                </td>
                                <?php endif; ?>
                                </td>
                                <?php echo Form::close(); ?>

                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->

            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix" style="">

            </div>
            <!-- /.box-footer -->
        </div>
    </div>
    <div class="col-md-6">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Contracts Statistics</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button> 
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="">
                <div class="col-md-12">
                    <div class="progress-group">
                        <span class="progress-text">Approved Contracts</span>
                        <span class="progress-number"><b><?php echo e($approved_contract_count); ?></b>/<?php echo e($total_contracts_count); ?></span>

                        <div class="progress sm">
                            <div class="progress-bar progress-bar-green" style="width: <?php echo e($approved_percentage); ?>%"></div>
                        </div>
                    </div>
                    <!-- /.progress-group -->
                    <div class="progress-group">
                        <span class="progress-text">Submitted Contracts</span>
                        <span class="progress-number"><b><?php echo e($submitted_contract_count); ?></b>/<?php echo e($total_contracts_count); ?></span>

                        <div class="progress sm">
                            <div class="progress-bar progress-bar-purple" style="width: <?php echo e($submitted_percentage); ?>%"></div>
                        </div>
                    </div>
                    <!-- /.progress-group -->
                    <!-- /.progress-group -->
                    <div class="progress-group">
                        <span class="progress-text">Ammended Contracts</span>
                        <span class="progress-number"><b><?php echo e($ammended_contract_count); ?></b>/<?php echo e($total_contracts_count); ?></span>

                        <div class="progress sm">
                            <div class="progress-bar progress-bar-aqua" style="width: <?php echo e($ammended_percentage); ?>%"></div>
                        </div>
                    </div>
                    <!-- /.progress-group -->
                    <div class="progress-group">
                        <span class="progress-text">Published Contracts</span>
                        <span class="progress-number"><b><?php echo e($published_contract_count); ?></b>/<?php echo e($total_contracts_count); ?></span>

                        <div class="progress sm">
                            <div class="progress-bar progress-bar-yellow" style="width: <?php echo e($published_percentage); ?>%"></div>
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

            </div>
            <!-- /.box-body -->
            <!-- /.box-footer -->
        </div>
    </div>

</div>
<div class="row">
    <div class="col-md-6">
        <div class="box box-info">
            <div class="box-header with-border">
                <?php if(auth()->check()): ?> <?php if(auth()->user()->isAdmin()): ?>
                <h3 class="box-title">Latest Published Contracts</h3>
                <?php elseif(auth()->user()->isLegal()): ?>
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
                    <table id="example2" class="table no-margin">
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
                                    <small class="label pull-center btn-warning"><?php echo e($contract1->contract_status); ?></small></span>
                                    <?php elseif($contract1->contract_status == 'published'): ?>
                                    <small class="label pull-center btn-info"><?php echo e($contract1->contract_status); ?></small></span>
                                    <?php elseif($contract1->contract_status== 'submitted'): ?>
                                    <small class="label label-success"><?php echo e($contract1->contract_status); ?></small></span>
                                    <?php elseif($contract1->contract_status== 'ammended'): ?>
                                    <small class="label pull-center btn-danger"><?php echo e($contract1->contract_status); ?></small></span>
                                    <?php elseif($contract1->contract_status== 'approved'): ?>
                                    <small class="label pull-center btn-success"><?php echo e($contract1->contract_status); ?></small></span>
                                    <?php elseif($contract1->contract_status== 'terminated'): ?>
                                    <small class="label pull-center btn-danger"><?php echo e($contract1->contract_status); ?></small></span>
                                </td>
                                <?php endif; ?>
                                </td>
                                <?php echo Form::close(); ?>

                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix" style="">

            </div>
            <!-- /.box-footer -->
        </div>
    </div>
    <?php if(auth()->check()): ?> <?php if(auth()->user()->isAdmin()): ?>
    <div class="col-md-6">
        <div class="box box-info">
            <div class="box-header with-border">
                <?php if(auth()->check()): ?> <?php if(auth()->user()->isAdmin()): ?>
                <h3 class="box-title">Registered Users</h3>
                <?php elseif(auth()->user()->isLegal()): ?>
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
                    <table id="example3" class="table no-margin">
                        <thead>
                           <tr>
                            <th>S/N</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Organization</th>
                            <th>Position</th>
                            <th>Role</th>
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
                                <td><?php echo e($user->job_title); ?></td>
                                <td><?php echo e($user->role_name); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix" style="">
               
            </div>
            <!-- /.box-footer -->
        </div>
    </div>
    <?php endif; ?> <?php endif; ?>
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
         iDisplayLength: 5,
         $('#example2').DataTable()
         $('#example3').DataTable()
        $(document).ready(function() {
});
    });
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>