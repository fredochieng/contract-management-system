<?php $__env->startSection('title', 'Pending Contracts'); ?>
<?php $__env->startSection('content_header'); ?>
<h1 class="pull-left">Contracts<small>Pending Contracts</small></h1>

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
                <li class="active"><a href="#pending-contracts" data-toggle="tab">Pending Contracts</a></li>
                <li><a href="#overdue-contracts" data-toggle="tab">Overdue Contracts</a></li>
                <li><a href="#open_contracts" data-toggle="tab">Open Contracts</a></li>
                <li><a href="#assigned-contracts" data-toggle="tab">Assigned Contracts</a></li>
                <li><a href="#my-pending-contracts" data-toggle="tab">My Contracts</a></li>
                <div class="btn-group pull-right" style="padding:6px;">
                    <a class="btn btn-info btn-sm btn-flat" href="/contract/create"><i class="fa fa-clock-o fa-fw"></i> New Contract</a>
                </div>

            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="pending-contracts">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-success">
                                <div class="box-body">
                                    <table id="example1" class="table no-margin">
                                        <thead>
                                            <tr>
                                                <th>S/N</th>
                                                <th>Contract Title</th>
                                                <?php if(auth()->check()): ?> <?php if(auth()->user()->isLegal() || auth()->user()->isUser() ): ?>
                                                <th>Party Name</th>
                                                <?php else: ?>
                                                <th>Party Name</th>
                                                <?php endif; ?> <?php endif; ?>
                                                <th>Effective Date</th>
                                                <th>Expiry Date</th>
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
                                                <td><a href="/contract/<?php echo e($pending_contract->contract_id); ?>/view"><?php echo e($pending_contract->contract_title); ?></a></td>
                                                <td>
                                                    <span class="label" style="background-color:#FFF;color:#0073b7;border:1px solid #0073b7;">
                                                    														<i class="fa fa-briefcase fa-fw"></i> <?php echo e($pending_contract->party_name); ?>													</span></td>
                                                <td><?php echo e(date("d-m-Y",strtotime($pending_contract->effective_date))); ?></td>
                                                <td><?php echo e(date("d-m-Y",strtotime($pending_contract->expiry_date))); ?></td>
                                                <td><span class="pull-right-container">
                                                        <?php if($pending_contract->contract_status == 'created'): ?>
                                                        <small class="badge bg-purple"><?php echo e($pending_contract->contract_status); ?></small></span>                                                    <?php elseif($pending_contract->contract_status == 'published'): ?>
                                                    <small class="badge bg-yellow"><?php echo e($pending_contract->contract_status); ?></small></span>
                                                    <?php elseif($pending_contract->contract_status== 'ammended'): ?>
                                                    <small class="badge bg-blue"><?php echo e($pending_contract->contract_status); ?></small></span>
                                                    <?php elseif($pending_contract->contract_status== 'approved'): ?>
                                                    <small class="badge bg-green"><?php echo e($pending_contract->contract_status); ?></small></span>
                                                    <?php elseif($pending_contract->contract_status== 'terminated'): ?>
                                                    <small class="badge bg-red"><?php echo e($pending_contract->contract_status); ?></small></span>
                                                </td>
                                                <?php endif; ?> <?php if(auth()->check()): ?> <?php if(auth()->user()->isAdmin() || auth()->user()->isLegal()): ?>
                                                <td>
                                                    <?php if($pending_contract->assigned =='' && $pending_contract->escalation_duration >=1): ?>
                                                    <span class="label" style="background-color:#FFF;color:#ff0000;border:1px solid #ff0000">Overdue</span>                                                    <?php elseif($pending_contract->assigned=='' && $pending_contract->escalation_duration
                                                    <1): ?> <span class="label" style="background-color:#FFF;color:#1e3fda;border:1px solid #1e3fda">Open</span>
                                                        <?php else: ?>
                                                        <span class="label" style="background-color:#FFF;color:#058e29;border:1px solid #058e29">Assigned</span>                                                        <?php endif; ?>
                                                </td>
                                                <?php endif; ?> <?php endif; ?>
                                                <td>
                                                    <center>
                                                        <div class="btn-group">
                                                            <?php if(auth()->check()): ?> <?php if(auth()->user()->isUser() && ($pending_contract->contract_status == 'created' || $pending_contract->contract_status=='ammended')): ?>
                                                            <a href="/contract/<?php echo e($pending_contract->contract_id); ?>/edit" class="btn btn-flat btn-success btn-sm"><i class="fa fa-edit"></i> Edit</a>                                                            <?php else: ?>
                                                            <a href="/contract/<?php echo e($pending_contract->contract_id); ?>/view" class="btn btn-flat btn-primary btn-sm"><i class="fa fa-eye"></i> View</a>                                                             <?php endif; ?> <?php endif; ?> <?php echo e(Form::hidden('_method','POST')); ?>

                                                            <?php echo Form::open(['action'=>['ContractController@destroy',$pending_contract->contract_id],'method'=>'POST','class'=>'floatit','enctype'=>'multipart/form-data']); ?> <?php echo e(Form::hidden('_method','DELETE')); ?>

                                                            <a href="#modal_delete_contract" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#modal_delete_contract"
                                                                class="btn btn-flat btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</a>                                                            
                                                        </div>
                                                    </center>
                                                </td>
                                                <?php echo Form::close(); ?>

                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <!-- Modal to delete a contract by legal team/legal admin -->

                                            <div class="modal fade" id="modal_delete_contract">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                                <span aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title">Delete Contract</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-12">

                                                                    <p>Are you sure you want to delete the contract?</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> No</button>
                                                            <button type="submit" class="btn btn-danger btn-flat"><i class="fa fa-check"></i> Yes</button>
                                                        </div>
                                                        <?php echo Form::close(); ?>

                                                    </div>
                                                    <!-- /.modal-content -->
                                                </div>
                                                <!-- /.modal-dialog -->
                                            </div>
                                            <!-- End modal to delete a contract by legal team/ legal admin -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="overdue-contracts">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-success">
                                <div class="box-body">
                                    <table id="example2" class="table no-margin">
                                        <thead>
                                            <tr>
                                                <th>S/NDD</th>
                                                <th>Contract Title</th>
                                                <?php if(auth()->check()): ?> <?php if(auth()->user()->isLegal() || auth()->user()->isUser() ): ?>
                                                <th>Party Name</th>
                                                <?php else: ?>
                                                <th>Party Name</th>
                                                <?php endif; ?> <?php endif; ?>
                                                <th>Effective Date</th>
                                                <th>Expiry Date</th>
                                                <th>Status</th>
                                                <?php if(auth()->check()): ?> <?php if(auth()->user()->isAdmin() || auth()->user()->isLegal()): ?>
                                                <th>Alert</th>
                                                <?php endif; ?> <?php endif; ?>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $overdue_pending_contracts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$overdue_pending_contract): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($key+1); ?></td>
                                                <td><a href="/contract/<?php echo e($overdue_pending_contract->contract_id); ?>/view"><?php echo e($overdue_pending_contract->contract_title); ?></a></td>
                                                <td>
                                                    <span class="label" style="background-color:#FFF;color:#0073b7;border:1px solid #0073b7;">
                                                    														<i class="fa fa-briefcase fa-fw"></i> <?php echo e($overdue_pending_contract->party_name); ?>													</span></td>
                                                <td><?php echo e(date("d-m-Y",strtotime($overdue_pending_contract->effective_date))); ?></td>
                                                <td><?php echo e(date("d-m-Y",strtotime($overdue_pending_contract->expiry_date))); ?></td>
                                                <td><span class="pull-right-container">
                                                        <?php if($overdue_pending_contract->contract_status == 'created'): ?>
                                                        <small class="badge bg-purple"><?php echo e($overdue_pending_contract->contract_status); ?></small></span>                                                    <?php elseif($overdue_pending_contract->contract_status == 'published'): ?>
                                                    <small class="badge bg-yellow"><?php echo e($overdue_pending_contract->contract_status); ?></small></span>
                                                    <?php elseif($overdue_pending_contract->contract_status== 'ammended'): ?>
                                                    <small class="badge bg-blue"><?php echo e($overdue_pending_contract->contract_status); ?></small></span>
                                                    <?php elseif($overdue_pending_contract->contract_status== 'approved'): ?>
                                                    <small class="badge bg-green"><?php echo e($overdue_pending_contract->contract_status); ?></small></span>
                                                    <?php elseif($overdue_pending_contract->contract_status== 'terminated'): ?>
                                                    <small class="badge bg-red"><?php echo e($pending_contract->contract_status); ?></small></span>
                                                </td>
                                                <?php endif; ?> <?php if(auth()->check()): ?> <?php if(auth()->user()->isAdmin() || auth()->user()->isLegal()): ?>
                                                <td>
                                                    <?php if($overdue_pending_contract->assigned =='' && $overdue_pending_contract->escalation_duration >=1): ?>
                                                    <span class="label" style="background-color:#FFF;color:#ff0000;border:1px solid #ff0000">Overdue</span>                                                    <?php endif; ?>
                                                </td>
                                                <?php endif; ?> <?php endif; ?>
                                                <td>
                                                    <center>
                                                        <div class="btn-group">
                                                            <?php if(auth()->check()): ?> <?php if(auth()->user()->isUser() && ($overdue_pending_contract->contract_status == 'created' || $overdue_pending_contract->contract_status=='ammended')): ?>
                                                            <a href="/contract/<?php echo e($overdue_pending_contract->contract_id); ?>/edit" class="btn btn-flat btn-success btn-sm"><i class="fa fa-edit"></i> Edit</a>                                                            <?php else: ?>
                                                            <a href="/contract/<?php echo e($overdue_pending_contract->contract_id); ?>/view" class="btn btn-flat btn-primary btn-sm"><i class="fa fa-eye"></i> View</a>                                                             <?php endif; ?> <?php endif; ?> <?php echo e(Form::hidden('_method','POST')); ?>

                                                            <?php echo Form::open(['action'=>['ContractController@destroy',$overdue_pending_contract->contract_id],'method'=>'POST','class'=>'floatit','enctype'=>'multipart/form-data']); ?> <?php echo e(Form::hidden('_method','DELETE')); ?>

                                                            <a href="#modal_delete_contract" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#modal_delete_contract"
                                                                class="btn btn-flat btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</a>                                                            
                                                        </div>
                                                    </center>
                                                </td>
                                                <?php echo Form::close(); ?>

                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <!-- Modal to delete a contract by legal team/legal admin -->

                                            <div class="modal fade" id="modal_delete_contract">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                                <span aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title">Delete Contract</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-12">

                                                                    <p>Are you sure you want to delete the contract?</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> No</button>
                                                            <button type="submit" class="btn btn-danger btn-flat"><i class="fa fa-check"></i> Yes</button>
                                                        </div>
                                                        <?php echo Form::close(); ?>

                                                    </div>
                                                    <!-- /.modal-content -->
                                                </div>
                                                <!-- /.modal-dialog -->
                                            </div>
                                            <!-- End modal to delete a contract by legal team/ legal admin -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="assigned-contracts">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-success">
                                <div class="box-body">
                                    <table id="example3" class="table no-margin">
                                        <thead>
                                            <tr>
                                                <th>S/N</th>
                                                <th>Contract Title</th>
                                                <?php if(auth()->check()): ?> <?php if(auth()->user()->isLegal() || auth()->user()->isUser() ): ?>
                                                <th>Party Name</th>
                                                <?php else: ?>
                                                <th>Party Name</th>
                                                <?php endif; ?> <?php endif; ?>
                                                <th>Effective Date</th>
                                                <th>Expiry Date</th>
                                                <th>Status</th>
                                                <?php if(auth()->check()): ?> <?php if(auth()->user()->isAdmin() || auth()->user()->isLegal()): ?>
                                                <th>Alert</th>
                                                <?php endif; ?> <?php endif; ?>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $assigned_pending_contracts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$assigned_pending_contract): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($key+1); ?></td>
                                                <td><a href="/contract/<?php echo e($assigned_pending_contract->contract_id); ?>/view"><?php echo e($assigned_pending_contract->contract_title); ?></a></td>
                                                <td>
                                                    <span class="label" style="background-color:#FFF;color:#0073b7;border:1px solid #0073b7;">
                                                                    														<i class="fa fa-briefcase fa-fw"></i> <?php echo e($assigned_pending_contract->party_name); ?>													</span></td>
                                                <td><?php echo e(date("d-m-Y",strtotime($assigned_pending_contract->effective_date))); ?></td>
                                                <td><?php echo e(date("d-m-Y",strtotime($assigned_pending_contract->expiry_date))); ?></td>
                                                <td><span class="pull-right-container">
                                                                        <?php if($assigned_pending_contract->contract_status == 'created'): ?>
                                                                        <small class="badge bg-purple"><?php echo e($assigned_pending_contract->contract_status); ?></small></span>                                                    <?php elseif($assigned_pending_contract->contract_status == 'published'): ?>
                                                    <small class="badge bg-yellow"><?php echo e($assigned_pending_contract->contract_status); ?></small></span>
                                                    <?php elseif($assigned_pending_contract->contract_status== 'ammended'): ?>
                                                    <small class="badge bg-blue"><?php echo e($overdue_pending_contract->contract_status); ?></small></span>
                                                    <?php elseif($assigned_pending_contract->contract_status== 'approved'): ?>
                                                    <small class="badge bg-green"><?php echo e($assigned_pending_contract->contract_status); ?></small></span>
                                                    <?php elseif($assigned_pending_contract->contract_status== 'terminated'): ?>
                                                    <small class="badge bg-red"><?php echo e($assigned_pending_contract->contract_status); ?></small></span>
                                                </td>
                                                <?php endif; ?> <?php if(auth()->check()): ?> <?php if(auth()->user()->isAdmin() || auth()->user()->isLegal()): ?>
                                                <td>
                                                    <span class="label" style="background-color:#FFF;color:#058e29;border:1px solid #058e29">Assigned</span>
                                                </td>
                                                <?php endif; ?> <?php endif; ?>
                                                <td>
                                                    <center>
                                                        <div class="btn-group">
                                                            <?php if(auth()->check()): ?> <?php if(auth()->user()->isUser() && ($assigned_pending_contract->contract_status == 'created' || $assigned_pending_contract->contract_status=='ammended')): ?>
                                                            <a href="/contract/<?php echo e($assigned_pending_contract->contract_id); ?>/edit" class="btn btn-flat btn-success btn-sm"><i class="fa fa-edit"></i> Edit</a>                                                            <?php else: ?>
                                                            <a href="/contract/<?php echo e($assigned_pending_contract->contract_id); ?>/view" class="btn btn-flat btn-primary btn-sm"><i class="fa fa-eye"></i> View</a>                                                             <?php endif; ?> <?php endif; ?> <?php echo e(Form::hidden('_method','POST')); ?>

                                                            <?php echo Form::open(['action'=>['ContractController@destroy',$assigned_pending_contract->contract_id],'method'=>'POST','class'=>'floatit','enctype'=>'multipart/form-data']); ?> <?php echo e(Form::hidden('_method','DELETE')); ?>

                                                            <a href="#modal_delete_contract" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#modal_delete_contract"
                                                                class="btn btn-flat btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</a>                                                            
                                                        </div>
                                                    </center>
                                                </td>
                                                <?php echo Form::close(); ?>

                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <!-- Modal to delete a contract by legal team/legal admin -->

                                            <div class="modal fade" id="modal_delete_contract">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                                                <span aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title">Delete Contract</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-12">

                                                                    <p>Are you sure you want to delete the contract?</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> No</button>
                                                            <button type="submit" class="btn btn-danger btn-flat"><i class="fa fa-check"></i> Yes</button>
                                                        </div>
                                                        <?php echo Form::close(); ?>

                                                    </div>
                                                    <!-- /.modal-content -->
                                                </div>
                                                <!-- /.modal-dialog -->
                                            </div>
                                            <!-- End modal to delete a contract by legal team/ legal admin -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="my-pending-contracts">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-success">
                                <div class="box-body">
                                    <table id="example4" class="table no-margin">
                                        <thead>
                                            <tr>
                                                <th>S/N</th>
                                                <th>Contract Title</th>
                                                <?php if(auth()->check()): ?> <?php if(auth()->user()->isLegal() || auth()->user()->isUser() ): ?>
                                                <th>Party Name</th>
                                                <?php else: ?>
                                                <th>Party Name</th>
                                                <?php endif; ?> <?php endif; ?>
                                                <th>Effective Date</th>
                                                <th>Expiry Date</th>
                                                <th>Status</th>
                                                <?php if(auth()->check()): ?> <?php if(auth()->user()->isAdmin() || auth()->user()->isLegal()): ?>
                                                <th>Alert</th>
                                                <?php endif; ?> <?php endif; ?>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $my_pending_contracts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$my_pending_contract): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($key+1); ?></td>
                                                <td><a href="/contract/<?php echo e($my_pending_contract->contract_id); ?>/view"><?php echo e($my_pending_contract->contract_title); ?></a></td>
                                                <td>
                                                    <span class="label" style="background-color:#FFF;color:#0073b7;border:1px solid #0073b7;">
                                                                                        														<i class="fa fa-briefcase fa-fw"></i> <?php echo e($my_pending_contract->party_name); ?>													</span></td>
                                                <td><?php echo e(date("d-m-Y",strtotime($my_pending_contract->effective_date))); ?></td>
                                                <td><?php echo e(date("d-m-Y",strtotime($my_pending_contract->expiry_date))); ?></td>
                                                <td><span class="pull-right-container">
                                                                                            <?php if($my_pending_contract->contract_status == 'created'): ?>
                                                                                            <small class="badge bg-purple"><?php echo e($my_pending_contract->contract_status); ?></small></span>                                                    <?php elseif($my_pending_contract->contract_status == 'published'): ?>
                                                    <small class="badge bg-yellow"><?php echo e($my_pending_contract->contract_status); ?></small></span>
                                                    <?php elseif($my_pending_contract->contract_status== 'ammended'): ?>
                                                    <small class="badge bg-blue"><?php echo e($my_pending_contract->contract_status); ?></small></span>
                                                    <?php elseif($my_pending_contract->contract_status== 'approved'): ?>
                                                    <small class="badge bg-green"><?php echo e($my_pending_contract->contract_status); ?></small></span>
                                                    <?php elseif($my_pending_contract->contract_status== 'terminated'): ?>
                                                    <small class="badge bg-red"><?php echo e($my_pending_contract->contract_status); ?></small></span>
                                                </td>
                                                <?php endif; ?> <?php if(auth()->check()): ?> <?php if(auth()->user()->isAdmin() || auth()->user()->isLegal()): ?>
                                                <td>
                                                    <?php if($my_pending_contract->assigned =='' && $my_pending_contract->escalation_duration >=1): ?>
                                                    <span class="label" style="background-color:#FFF;color:#ff0000;border:1px solid #ff0000">Overdue</span>                                                    <?php elseif($my_pending_contract->assigned=='' && $my_pending_contract->escalation_duration
                                                    <1): ?> <span class="label" style="background-color:#FFF;color:#1e3fda;border:1px solid #1e3fda">Open</span>
                                                        <?php else: ?>
                                                        <span class="label" style="background-color:#FFF;color:#058e29;border:1px solid #058e29">Assigned</span>                                                        <?php endif; ?>
                                                </td>
                                                <?php endif; ?> <?php endif; ?>
                                                <td>
                                                    <center>
                                                        <div class="btn-group">
                                                            <?php if(auth()->check()): ?> <?php if(auth()->user()->isUser() && ($my_pending_contract->contract_status == 'created' || $my_pending_contract->contract_status=='ammended')): ?>
                                                            <a href="/contract/<?php echo e($my_pending_contract->contract_id); ?>/edit" class="btn btn-flat btn-success btn-sm"><i class="fa fa-edit"></i> Edit</a>                                                            <?php else: ?>
                                                            <a href="/contract/<?php echo e($my_pending_contract->contract_id); ?>/view" class="btn btn-flat btn-primary btn-sm"><i class="fa fa-eye"></i> View</a>                                                             <?php endif; ?> <?php endif; ?> <?php echo e(Form::hidden('_method','POST')); ?>

                                                            <?php echo Form::open(['action'=>['ContractController@destroy',$my_pending_contract->contract_id],'method'=>'POST','class'=>'floatit','enctype'=>'multipart/form-data']); ?> <?php echo e(Form::hidden('_method','DELETE')); ?>

                                                            <a href="#modal_delete_contract" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#modal_delete_contract"
                                                                class="btn btn-flat btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</a>                                                            
                                                        </div>
                                                    </center>
                                                </td>
                                                <?php echo Form::close(); ?>

                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <!-- Modal to delete a contract by legal team/legal admin -->

                                            <div class="modal fade" id="modal_delete_contract">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                                                                    <span aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title">Delete Contract</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-12">

                                                                    <p>Are you sure you want to delete the contract?</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> No</button>
                                                            <button type="submit" class="btn btn-danger btn-flat"><i class="fa fa-check"></i> Yes</button>
                                                        </div>
                                                        <?php echo Form::close(); ?>

                                                    </div>
                                                    <!-- /.modal-content -->
                                                </div>
                                                <!-- /.modal-dialog -->
                                            </div>
                                            <!-- End modal to delete a contract by legal team/ legal admin -->
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
        <table id="example1" class="table no-margin">
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>Contract Title</th>
                    <?php if(auth()->check()): ?> <?php if(auth()->user()->isLegal() || auth()->user()->isUser() ): ?>
                    <th>Party Name</th>
                    <?php else: ?>
                    <th>Party Name</th>
                    <?php endif; ?> <?php endif; ?>
                    <th>Effective Date</th>
                    <th>Expiry Date</th>
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
                    <td><a href="/contract/<?php echo e($pending_contract->contract_id); ?>/view"><?php echo e($pending_contract->contract_title); ?></a></td>
                    <td>
                        <span class="label" style="background-color:#FFF;color:#0073b7;border:1px solid #0073b7;">
                    														<i class="fa fa-briefcase fa-fw"></i> <?php echo e($pending_contract->party_name); ?>													</span></td>
                    <td><?php echo e(date("d-m-Y",strtotime($pending_contract->effective_date))); ?></td>
                    <td><?php echo e(date("d-m-Y",strtotime($pending_contract->expiry_date))); ?></td>
                    <td><span class="pull-right-container">
                        <?php if($pending_contract->contract_status == 'created'): ?>
                        <small class="badge bg-purple"><?php echo e($pending_contract->contract_status); ?></small></span> <?php elseif($pending_contract->contract_status
                        == 'published'): ?>
                        <small class="badge bg-yellow"><?php echo e($pending_contract->contract_status); ?></small></span>
                        <?php elseif($pending_contract->contract_status== 'ammended'): ?>
                        <small class="badge bg-blue"><?php echo e($pending_contract->contract_status); ?></small></span>
                        <?php elseif($pending_contract->contract_status== 'approved'): ?>
                        <small class="badge bg-green"><?php echo e($pending_contract->contract_status); ?></small></span>
                        <?php elseif($pending_contract->contract_status== 'terminated'): ?>
                        <small class="badge bg-red"><?php echo e($pending_contract->contract_status); ?></small></span>
                    </td>
                    <?php endif; ?> <?php if(auth()->check()): ?> <?php if(auth()->user()->isAdmin() || auth()->user()->isLegal()): ?>
                    <td>
                        <?php if($pending_contract->assigned=='' && $pending_contract->escalation_duration >=10): ?>
                        <span class="label" style="background-color:#FFF;color:#ff0000;border:1px solid #ff0000">Overdue</span>                        <?php elseif($pending_contract->assigned=='' && $pending_contract->escalation_duration
                        <10): ?> <span class="label" style="background-color:#FFF;color:#1e3fda;border:1px solid #1e3fda">Open</span>
                            <?php else: ?>
                            <span class="label" style="background-color:#FFF;color:#058e29;border:1px solid #058e29">Assigned</span>                            <?php endif; ?>
                    </td>
                    <?php endif; ?> <?php endif; ?>
                    <td>
                        <center>
                            <div class="btn-group">
                                <?php if(auth()->check()): ?> <?php if(auth()->user()->isUser() && ($pending_contract->contract_status == 'created' || $pending_contract->contract_status=='ammended')): ?>
                                <a href="/contract/<?php echo e($pending_contract->contract_id); ?>/edit" class="btn btn-flat btn-success btn-sm"><i class="fa fa-edit"></i> Edit</a>                                <?php else: ?>
                                <a href="/contract/<?php echo e($pending_contract->contract_id); ?>/view" class="btn btn-flat btn-primary btn-sm"><i class="fa fa-eye"></i> View</a>                                 <?php endif; ?> <?php endif; ?> <?php echo e(Form::hidden('_method','POST')); ?> <?php echo Form::open(['action'=>['ContractController@destroy',$pending_contract->contract_id],'method'=>'POST','class'=>'floatit','enctype'=>'multipart/form-data']); ?> <?php echo e(Form::hidden('_method','DELETE')); ?>

                                <a href="#modal_delete_contract" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#modal_delete_contract"
                                    class="btn btn-flat btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</a>                                
                            </div>
                        </center>
                    </td>
                    <?php echo Form::close(); ?>

                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <!-- Modal to delete a contract by legal team/legal admin -->

                <div class="modal fade" id="modal_delete_contract">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Delete Contract</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">

                                        <p>Are you sure you want to delete the contract?</p>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> No</button>
                                <button type="submit" class="btn btn-danger btn-flat"><i class="fa fa-check"></i> Yes</button>
                            </div>
                            <?php echo Form::close(); ?>

                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- End modal to delete a contract by legal team/ legal admin -->
            </tbody>
        </table>
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