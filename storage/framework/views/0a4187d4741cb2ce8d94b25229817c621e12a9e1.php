<?php $__env->startSection('title', 'Contract Management System'); ?>
<?php $__env->startSection('content_header'); ?>
<h1>Dashboard</h1>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php if(auth()->check()): ?>
<?php if(auth()->user()->isAdmin()): ?>
<div class="row">
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3><?php echo e($submitted_contract_count); ?></h3>
                <p>Submitted Contracts</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">View Contracts <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3><?php echo e($published_contract_count); ?></h3>
                <p>Published Contracts</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer ">View Contracts <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-green">
            <div class="inner">
                <h3><?php echo e($approved_contract_count); ?></h3>
                <p>Approved Contracts</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">View Contracts <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-red">
            <div class="inner">
                <h3><?php echo e($ammended_contract_count); ?></h3>
                <p>Ammended Contracts</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">View Contracts <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
</div>
<div class="row">
    <div class="col-md-9">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Latest Submitted Contracts</h3>

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
                                <th style="width:145px;">Uploads</th>
                                <th style="width:145px;">Submitted By</th>
                                <th style="width:145px;">Date</th>
                                
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
                                <td><a href="/<?php echo e($contract->draft_file); ?>" target="_blank"><i class="fa fa-fw fa-download"></i> Contract</a>                                    |
                                    <a href="/<?php echo e($contract->draft_file); ?>" target="_blank"><i class="fa fa-fw fa-download"></i> CRF</a>
                                </td>
                                <td><?php echo e($contract->name); ?></td>
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
                                <td>
                                    <?php if($contract->contract_status == 'created' && $contract->contract_stage ==1 || $contract->contract_status == 'ammended'
                                    && $contract->contract_stage ==4 ): ?> 
                                    <a href="/contract/<?php echo e($contract->contract_id); ?>/edit">
                                            <span class = "fa fa-pencil bigger"></span></center></a>                                    <?php else: ?> 
                                    <a href="/contract/<?php echo e($contract->contract_id); ?>/view">
                                                                                <span class = "fa fa-eye bigger"></span></center></a>                                    <?php endif; ?> <?php echo Form::open(['action'=>['ContractController@destroy',$contract->contract_id],'method'=>'POST','class'=>'floatit','enctype'=>'multipart/form-data']); ?> <?php echo e(Form::hidden('_method','DELETE')); ?> 
                                    <a class="delete" data-id="<?php echo e($contract->contract_id); ?>" href="javascript:void(0)">
                                            <span style="color:red;" class = "fa fa-trash bigger"></span></a>
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
                <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">View All Contracts</a>
            </div>
            <!-- /.box-footer -->
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-red">
            <div class="inner">
                <h3><?php echo e($ammended_contract_count); ?></h3>
                <p>Ammended Contracts</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">View Contracts <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-md-3">

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
                        <span class="progress-number"><b><?php echo e($approved_percentage); ?>%</span>

                        <div class="progress sm">
                        <div class="progress-bar progress-bar-green" style="width: <?php echo e($approved_percentage); ?>%"></div>
                        </div>
                    </div>
                    <!-- /.progress-group -->
                    <div class="progress-group">
                        <span class="progress-text">Submitted Contracts</span>
                        <span class="progress-number"><b><?php echo e($submitted_percentage); ?>%</span>

                        <div class="progress sm">
                            <div class="progress-bar progress-bar-purple" style="width: <?php echo e($submitted_percentage); ?>%"></div>
                        </div>
                    </div>
                    <!-- /.progress-group -->
                    <!-- /.progress-group -->
                    <div class="progress-group">
                        <span class="progress-text">Ammended Contracts</span>
                        <span class="progress-number"><b><?php echo e($ammended_percentage); ?>%</span>

                        <div class="progress sm">
                            <div class="progress-bar progress-bar-aqua" style="width: <?php echo e($ammended_percentage); ?>%"></div>
                        </div>
                    </div>
                    <!-- /.progress-group -->
                    <div class="progress-group">
                        <span class="progress-text">Published Contracts</span>
                        <span class="progress-number"><b><?php echo e($submitted_percentage); ?>%</span>

                        <div class="progress sm">
                            <div class="progress-bar progress-bar-yellow" style="width: <?php echo e($submitted_percentage); ?>%"></div>
                        </div>
                    </div>
                    <!-- /.progress-group -->
                    <!-- /.progress-group -->
                    <div class="progress-group">
                        <span class="progress-text">Terminated Contracts</span>
                        <span class="progress-number"><b><?php echo e($terminated_percentage); ?>%</span>

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
    <div class="col-md-9">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Latest Submitted Contracts</h3>

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
                                <th style="width:145px;">Uploads</th>
                                
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
                                <td><a href="/<?php echo e($contract->draft_file); ?>" target="_blank"><i class="fa fa-fw fa-download"></i> Contract</a>                                    |
                                    <a href="/<?php echo e($contract->draft_file); ?>" target="_blank"><i class="fa fa-fw fa-download"></i> CRF</a>
                                </td>
                                
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
                                <td>
                                    <?php if($contract->contract_status == 'created' && $contract->contract_stage ==1 || $contract->contract_status == 'ammended'
                                    && $contract->contract_stage ==4 ): ?> 
                                    <a href="/contract/<?php echo e($contract->contract_id); ?>/edit">
                                            <span class = "fa fa-pencil bigger"></span></center></a>                                    <?php else: ?> 
                                    <a href="/contract/<?php echo e($contract->contract_id); ?>/view">
                                                                                <span class = "fa fa-eye bigger"></span></center></a>                                    <?php endif; ?> <?php echo Form::open(['action'=>['ContractController@destroy',$contract->contract_id],'method'=>'POST','class'=>'floatit','enctype'=>'multipart/form-data']); ?> <?php echo e(Form::hidden('_method','DELETE')); ?> 
                                    <a class="delete" data-id="<?php echo e($contract->contract_id); ?>" href="javascript:void(0)">
                                            <span style="color:red;" class = "fa fa-trash bigger"></span></a>
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
                <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">View All Contracts</a>
            </div>
            <!-- /.box-footer -->
        </div>
    </div>

</div>
<?php elseif(auth()->user()->isUser()): ?>
<h>Standard User Dashboard</h>
<?php elseif(auth()->user()->isLegal()): ?>
<h>Legal Counsel Dashboard</h>
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
        $(document).ready(function() {
});
    });

</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>