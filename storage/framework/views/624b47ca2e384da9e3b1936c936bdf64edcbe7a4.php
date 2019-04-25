<?php $__env->startSection('title', 'CMS | Terminated Contracts'); ?>
<?php $__env->startSection('content_header'); ?>
<h1 class="pull-left">Contracts<small>Terminated Contracts</small></h1>
<?php if(auth()->check()): ?> <?php if(auth()->user()->isUser()): ?>
<div class="pull-right"><a class="btn btn-primary btn-sm btn-flat" href="/contract/create"><i class="fa fa-plus"></i> New Contract</a></div>
<?php endif; ?> <?php endif; ?>
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
<div class="row">
    <div class="col-md-12">
        <!-- Custom Tabs (Pulled to the right) -->
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#terminated-contracts" data-toggle="tab">Terminated Contracts</a></li>
                <li><a href="#terminated-by-me-contracts" data-toggle="tab">Terminated By Me</a></li>
                <li><a href="#my-terminated-contracts" data-toggle="tab">My Terminated Contracts</a></li>
                <div class="btn-group pull-right" style="padding:6px;">
                    <a class="btn btn-info btn-sm btn-flat" href="/contract/create"><i class="fa fa-plus"></i> New Contract</a>
                </div>

            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="terminated-contracts">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-success">
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table id="example1" class="table no-margin">
                                            <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Contract Title</th>
                                                    <th>Party Name</th>
                                                    <th>Effective Date</th>
                                                    <th>Expiry Date</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $terminated_contracts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$terminated_contract): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($key+1); ?></td>
                                                    <td><a href="/contract/<?php echo e($terminated_contract->contract_id); ?>/view"><?php echo e($terminated_contract->contract_title); ?></a></td>
                                                    <td><a href="/contract-party/<?php echo e($terminated_contract->party_id); ?>/view-contract-party"
                                                            target="_blank">
                                                                                        <span class="label" style="background-color:#FFF;color:#0073b7;border:1px solid #0073b7;">
                                                                             <i class="fa fa-briefcase fa-fw"></i> <?php echo e($terminated_contract->party_name); ?>	</a></span>
                                                    </td>
                                                    <td><?php echo e(date("d-m-Y",strtotime($terminated_contract->effective_date))); ?></td>
                                                    <td><?php echo e(date("d-m-Y",strtotime($terminated_contract->expiry_date))); ?></td>
                                                    <td><span class="pull-right-container">
                                                            <?php if($terminated_contract->contract_status == 'created'): ?>
                                                            <small class="label pull-center btn-warning"><?php echo e($terminated_contract->contract_status); ?></small></span>                                                        <?php elseif($terminated_contract->contract_status == 'published'): ?>
                                                        <small class="label pull-center btn-info"><?php echo e($terminated_contract->contract_status); ?></small></span>
                                                        <?php elseif($terminated_contract->contract_status== 'submitted'): ?>
                                                        <small class="label label-success"><?php echo e($terminated_contract->contract_status); ?></small></span>
                                                        <?php elseif($terminated_contract->contract_status== 'ammended'): ?>
                                                        <small class="label pull-center btn-danger"><?php echo e($terminated_contract->contract_status); ?></small></span>
                                                        <?php elseif($terminated_contract->contract_status== 'approved'): ?>
                                                        <small class="label pull-center btn-success"><?php echo e($terminated_contract->contract_status); ?></small></span>
                                                        <?php elseif($terminated_contract->contract_status== 'terminated'): ?>
                                                        <small class="label pull-center btn-danger"><?php echo e($terminated_contract->contract_status); ?></small></span>
                                                    </td>
                                                    <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-block btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Actions<span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>
                                                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                                                <li><a href="/contract/<?php echo e($terminated_contract->contract_id); ?>/view"
                                                                        class="view-contract"><i class="fa fa-eye"></i> View</a></li>

                                                                <li>
                                                                    <a href="#modal_delete_contract" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#modal_delete_contract"
                                                                        class="delete-product"><i class="fa fa-trash"></i>  Delete</a></li>
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
                        </div>

                    </div>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="terminated-by-me-contracts">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-success">
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table id="example2" class="table no-margin">
                                            <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Contract Title</th>
                                                    <th>Party Name</th>
                                                    <th>Effective Date</th>
                                                    <th>Expiry Date</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $terminated_by_me_contracts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$terminated_by_me_contract): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($key+1); ?></td>
                                                    <td><a href="/contract/<?php echo e($terminated_by_me_contract->contract_id); ?>/view"><?php echo e($terminated_by_me_contract->contract_title); ?></a></td>
                                                    <td><a href="/contract-party/<?php echo e($terminated_by_me_contract->party_id); ?>/view-contract-party"
                                                            target="_blank">
                                                                                                                                                                                <span class="label" style="background-color:#FFF;color:#0073b7;border:1px solid #0073b7;">
                                                                                                                                                                     <i class="fa fa-briefcase fa-fw"></i> <?php echo e($terminated_by_me_contract->party_name); ?>	</a></span>
                                                    </td>
                                                    <td><?php echo e(date("d-m-Y",strtotime($terminated_by_me_contract->effective_date))); ?></td>
                                                    <td><?php echo e(date("d-m-Y",strtotime($terminated_by_me_contract->expiry_date))); ?></td>

                                                    <td><span class="pull-right-container">
                                                            <?php if($terminated_by_me_contract->contract_status == 'created'): ?>
                                                            <small class="label pull-center btn-warning"><?php echo e($terminated_by_me_contract->contract_status); ?></small></span>                                                        <?php elseif($terminated_contract->contract_status == 'published'): ?>
                                                        <small class="label pull-center btn-info"><?php echo e($terminated_by_me_contract->contract_status); ?></small></span>
                                                        <?php elseif($terminated_by_me_contract->contract_status== 'submitted'): ?>
                                                        <small class="label label-success"><?php echo e($terminated_by_me_contract->contract_status); ?></small></span>
                                                        <?php elseif($terminated_by_me_contract->contract_status== 'ammended'): ?>
                                                        <small class="label pull-center btn-danger"><?php echo e($terminated_by_me_contract->contract_status); ?></small></span>
                                                        <?php elseif($terminated_by_me_contract->contract_status== 'approved'): ?>
                                                        <small class="label pull-center btn-success"><?php echo e($terminated_by_me_contract->contract_status); ?></small></span>
                                                        <?php elseif($terminated_by_me_contract->contract_status== 'terminated'): ?>
                                                        <small class="label pull-center btn-danger"><?php echo e($terminated_by_me_contract->contract_status); ?></small></span>
                                                    </td>
                                                    <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-block btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Actions<span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>
                                                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                                                <li><a href="/contract/<?php echo e($terminated_contract->contract_id); ?>/view"
                                                                        class="view-contract"><i class="fa fa-eye"></i> View</a></li>

                                                                <li>
                                                                    <a href="#modal_delete_contract" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#modal_delete_contract"
                                                                        class="delete-product"><i class="fa fa-trash"></i>  Delete</a></li>
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
                        </div>

                    </div>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="my-terminated-contracts">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-success">
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table id="example3" class="table no-margin">
                                            <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Contract Title</th>
                                                    <th>Party Name</th>
                                                    <th>Effective Date</th>
                                                    <th>Expiry Date</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $my_terminated_contracts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$my_terminated_contract): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($key+1); ?></td>
                                                    <td><a href="/contract/<?php echo e($my_terminated_contract->contract_id); ?>/view"><?php echo e($my_terminated_contract->contract_title); ?></a></td>
                                                    <td><a href="/contract-party/<?php echo e($my_terminated_contract->party_id); ?>/view-contract-party"
                                                            target="_blank">
                                                                                                                                                                                <span class="label" style="background-color:#FFF;color:#0073b7;border:1px solid #0073b7;">
                                                                                                                                                                     <i class="fa fa-briefcase fa-fw"></i> <?php echo e($my_terminated_contract->party_name); ?>	</a></span>
                                                    </td>
                                                    <td><?php echo e(date("d-m-Y",strtotime($my_terminated_contract->effective_date))); ?></td>
                                                    <td><?php echo e(date("d-m-Y",strtotime($my_terminated_contract->expiry_date))); ?></td>
                                                    <td><span class="pull-right-container">
                                                                                                <?php if($my_terminated_contract->contract_status == 'created'): ?>
                                                                                                <small class="label pull-center btn-warning"><?php echo e($my_terminated_contract->contract_status); ?></small></span>                                                        <?php elseif($terminated_contract->contract_status == 'published'): ?>
                                                        <small class="label pull-center btn-info"><?php echo e($my_terminated_contract->contract_status); ?></small></span>
                                                        <?php elseif($my_terminated_contract->contract_status== 'submitted'): ?>
                                                        <small class="label label-success"><?php echo e($my_terminated_contract->contract_status); ?></small></span>
                                                        <?php elseif($my_terminated_contract->contract_status== 'ammended'): ?>
                                                        <small class="label pull-center btn-danger"><?php echo e($my_terminated_contract->contract_status); ?></small></span>
                                                        <?php elseif($my_terminated_contract->contract_status== 'approved'): ?>
                                                        <small class="label pull-center btn-success"><?php echo e($my_terminated_contract->contract_status); ?></small></span>
                                                        <?php elseif($my_terminated_contract->contract_status== 'terminated'): ?>
                                                        <small class="label pull-center btn-danger"><?php echo e($my_terminated_contract->contract_status); ?></small></span>
                                                    </td>
                                                    <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-block btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Actions<span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>
                                                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                                                <li><a href="/contract/<?php echo e($terminated_contract->contract_id); ?>/view"
                                                                        class="view-contract"><i class="fa fa-eye"></i> View</a></li>

                                                                <li>
                                                                    <a href="#modal_delete_contract" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#modal_delete_contract"
                                                                        class="delete-product"><i class="fa fa-trash"></i>  Delete</a></li>
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
            <div class="tabel-responsive">
                <table id="example1" class="table table-striped table-bordered records">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Contract Title</th>
                            <th>Party Name</th>
                            <th>Effective Date</th>
                            <th>Expiry Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $terminated_contracts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$terminated_contract): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($key+1); ?></td>
                            <td><a href="/contract/<?php echo e($terminated_contract->contract_id); ?>/view"><?php echo e($terminated_contract->contract_title); ?></a></td>
                            <td><?php echo e($terminated_contract->party_name); ?></td>
                            <td><?php echo e(date("d-m-Y",strtotime($terminated_contract->effective_date))); ?></td>
                            <td><?php echo e(date("d-m-Y",strtotime($terminated_contract->expiry_date))); ?></td>
                            <td><span class="pull-right-container">
                        <?php if($terminated_contract->contract_status == 'created'): ?>
                        <small class="label pull-center btn-warning"><?php echo e($terminated_contract->contract_status); ?></small></span><?php elseif($terminated_contract->contract_status
                                == 'published'): ?>
                                <small class="label pull-center btn-info"><?php echo e($terminated_contract->contract_status); ?></small></span>
                                <?php elseif($terminated_contract->contract_status== 'submitted'): ?>
                                <small class="label label-success"><?php echo e($terminated_contract->contract_status); ?></small></span>
                                <?php elseif($terminated_contract->contract_status== 'ammended'): ?>
                                <small class="label pull-center btn-danger"><?php echo e($ammended_contract->contract_status); ?></small></span>
                                <?php elseif($terminated_contract->contract_status== 'approved'): ?>
                                <small class="label pull-center btn-success"><?php echo e($terminated_contract->contract_status); ?></small></span>
                                <?php elseif($terminated_contract->contract_status== 'terminated'): ?>
                                <small class="label pull-center btn-danger"><?php echo e($terminated_contract->contract_status); ?></small></span>
                            </td>
                            <?php endif; ?>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-block btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Actions<span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>
                                    <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                        <li><a href="/contract/<?php echo e($terminated_contract->contract_id); ?>/view" class="view-contract"><i class="fa fa-eye"></i> View</a></li>

                                        <li>
                                            <a href="#modal_delete_contract" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#modal_delete_contract"
                                                class="delete-product"><i class="fa fa-trash"></i>  Delete</a></li>
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
        $(function () {
      $('#example1').DataTable()
      $('#example2').DataTable()
       $('#example3').DataTable()
       $('#example4').DataTable()
     });
    </script>























<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>