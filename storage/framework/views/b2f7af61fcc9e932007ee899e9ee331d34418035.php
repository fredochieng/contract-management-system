<?php $__env->startSection('title', 'CMS | Users'); ?>
<?php $__env->startSection('content_header'); ?>
<h1 class="pull-left">Users<small>Manage Users</small></h1>
<div style="clear:both"></div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<div class="nav-tabs-custom" style="font-size:12px;">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab-legal-counsel" data-toggle="tab">Legal Counsel</a></li>
        <li><a href="#tab-standard-users" data-toggle="tab">Standard Users</a></li>
        <div class="btn-group pull-right" style="padding:6px;">
            <a class="btn btn-primary btn-sm btn-flat" href="#modal_new_user" data-toggle="modal" data-target="#modal_new_user"><i class="fa fa-plus"></i> New User</a>
        </div>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab-legal-counsel">
            <div class="box box-success">
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="example1" class="table no-margin">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Organization</th>
                                    <th>Position</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $legal_counsel_users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $count => $legal_counsel_user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($count + 1); ?></td>
                                    <td><?php echo e($legal_counsel_user->name); ?></td>
                                    <td><?php echo e($legal_counsel_user->email); ?></td>
                                    <td><?php echo e($legal_counsel_user->organization_name); ?></td>
                                    <td><?php echo e($legal_counsel_user->job_title); ?></td>
                                    <td>
                                        <a href="#modal_edit_user_<?php echo e($legal_counsel_user->id); ?>" data-backdrop="static" data-keyboard="false" data-toggle="modal"
                                            data-target="#modal_edit_user_<?php echo e($legal_counsel_user->id); ?>" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>                                        <?php echo e(Form::hidden('_method','DELETE')); ?> &nbsp;
                                        <a href="#modal_delete_user_<?php echo e($legal_counsel_user->id); ?>" data-backdrop="static" data-keyboard="false" data-toggle="modal"
                                            data-target="#modal_delete_user_<?php echo e($legal_counsel_user->id); ?>" class="btn btn-xs btn-danger delete_user_button"><i class="glyphicon glyphicon-trash"></i> Delete</a>
                                    </td>

                                </tr>
                                <div class="modal fade" id="modal_edit_user_<?php echo e($legal_counsel_user->id); ?>">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <?php echo Form::open(['action'=>['UserController@update',$legal_counsel_user->id],'method'=>'POST','class'=>'form','enctype'=>'multipart/form-data']); ?>

                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                  <span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title">Edit User</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <?php echo e(Form::label('name', 'Full Name')); ?><br>
                                                        <div class="form-group">
                                                            <?php echo e(Form::text('name', $legal_counsel_user->name,['class'=>'form-control', 'placeholder'=>''])); ?>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <?php echo e(Form::label('email', 'Email')); ?><br>
                                                        <div class="form-group">
                                                            <?php echo e(Form::text('email', $legal_counsel_user->email,['class'=>'form-control', 'placeholder'=>''])); ?>


                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <?php echo Form::label('organization_id', 'Organization' . ''); ?> <?php echo Form::select('organization_id', $organizations, $legal_counsel_user->organization_id,
                                                            ['placeholder' => 'Please select user organization', 'class'
                                                            => 'form-control select2']);; ?>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <?php echo e(Form::label('job_title', 'Job Title')); ?><br>
                                                        <div class="form-group">
                                                            <?php echo e(Form::text('job_title', $legal_counsel_user->job_title,['class'=>'form-control', 'placeholder'=>''])); ?>


                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <?php echo Form::label('role_id', 'User Role' . ''); ?> <?php echo Form::select('role_id', $roles, $legal_counsel_user->role_id, ['placeholder'
                                                            => 'Please select user role', 'class' => 'form-control select2']);; ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                                                <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-check"></i> Save Changes</button>
                                            </div>
                                            <?php echo e(Form::hidden('_method','PUT')); ?> <?php echo Form::close(); ?>

                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- Modal delete user -->
                                <div class="modal fade" id="modal_delete_user_<?php echo e($legal_counsel_user->id); ?>">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <?php echo e(Form::hidden('_method','POST')); ?> <?php echo Form::open(['action'=>['UserController@destroy',$legal_counsel_user->id],'method'=>'POST','class'=>'floatit','enctype'=>'multipart/form-data']); ?> <?php echo e(Form::hidden('_method','DELETE')); ?>

                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title">Delete User</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                    <p>Are you sure you want to delete <span style="font-weight:bold"><?php echo e($legal_counsel_user->name); ?></span>?</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                                                <button type="submit" class="btn btn-danger btn-flat"><i class="fa fa-check"></i> Yes</button>
                                            </div>
                                            <?php echo Form::close(); ?>

                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- End modal delete user -->
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane" id="tab-standard-users">
            <div class="box box-success">
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="example2" class="table no-margin">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Organization</th>
                                    <th>Position</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $standard_users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $count => $standard_user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($count + 1); ?></td>
                                    <td><?php echo e($standard_user->name); ?></td>
                                    <td><?php echo e($standard_user->email); ?></td>
                                    <td><?php echo e($standard_user->organization_name); ?></td>
                                    <td><?php echo e($standard_user->job_title); ?></td>
                                    <td>
                                        <a href="#modal_edit_user_<?php echo e($standard_user->id); ?>" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#modal_edit_user_<?php echo e($standard_user->id); ?>" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>                                        <?php echo e(Form::hidden('_method','DELETE')); ?> &nbsp;
                                        <a href="#modal_delete_standard_user_<?php echo e($standard_user->id); ?>" data-backdrop="static" data-keyboard="false" data-toggle="modal"
                                            data-target="#modal_delete_standard_user_<?php echo e($standard_user->id); ?>" class="btn btn-xs btn-danger delete_user_button"><i class="glyphicon glyphicon-trash"></i> Delete</a>
                                    </td>
                                </tr>

                                <div class="modal fade" id="modal_edit_user_<?php echo e($standard_user->id); ?>">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <?php echo Form::open(['action'=>['UserController@update',$standard_user->id],'method'=>'POST','class'=>'form','enctype'=>'multipart/form-data']); ?>

                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                                  <span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title">Edit User</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <?php echo e(Form::label('name', 'Full Name')); ?><br>
                                                        <div class="form-group">
                                                            <?php echo e(Form::text('name', $standard_user->name,['class'=>'form-control', 'placeholder'=>''])); ?>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <?php echo e(Form::label('email', 'Email')); ?><br>
                                                        <div class="form-group">
                                                            <?php echo e(Form::text('email', $standard_user->email,['class'=>'form-control', 'placeholder'=>''])); ?>


                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <?php echo Form::label('organization_id', 'Organization' . ''); ?> <?php echo Form::select('organization_id', $organizations, $standard_user->organization_id,
                                                            ['placeholder' => 'Please select user organization', 'class'
                                                            => 'form-control select2']);; ?>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <?php echo e(Form::label('job_title', 'Job Title')); ?><br>
                                                        <div class="form-group">
                                                            <?php echo e(Form::text('job_title', $standard_user->job_title,['class'=>'form-control', 'placeholder'=>''])); ?>


                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <?php echo Form::label('role_id', 'User Role' . ''); ?> <?php echo Form::select('role_id', $roles, $standard_user->role_id, ['placeholder'
                                                            => 'Please select user role', 'class' => 'form-control select2']);; ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                                                <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-check"></i> Save Changes</button>
                                            </div>
                                            <?php echo e(Form::hidden('_method','PUT')); ?> <?php echo Form::close(); ?>

                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- Modal delete user -->
                                <div class="modal fade" id="modal_delete_standard_user_<?php echo e($standard_user->id); ?>">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <?php echo e(Form::hidden('_method','POST')); ?> <?php echo Form::open(['action'=>['UserController@destroy',$standard_user->id],'method'=>'POST','class'=>'floatit','enctype'=>'multipart/form-data']); ?> <?php echo e(Form::hidden('_method','DELETE')); ?>

                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                            <span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title">Delete User</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12">

                                                        <p>Are you sure you want to delete <span style="font-weight:bold"><?php echo e($standard_user->name); ?></span>?</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                                                <button type="submit" class="btn btn-danger btn-flat"><i class="fa fa-check"></i> Yes</button>
                                            </div>
                                            <?php echo Form::close(); ?>

                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- End modal delete user -->
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div class="modal fade in" id="modal_new_user" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php echo Form::open(['action'=>'UserController@store','method'=>'POST','class'=>'form','enctype'=>'multipart/form-data']); ?>

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add New User</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo e(Form::label('name', 'Full Name')); ?><br>
                        <div class="form-group">
                            <?php echo e(Form::text('name', '',['class'=>'form-control', 'required', 'placeholder'=>''])); ?>

                        </div>
                    </div>
                    <div class="col-md-12">
                        <?php echo e(Form::label('email', 'Email')); ?><br>
                        <div class="form-group">
                            <?php echo e(Form::text('email', '',['class'=>'form-control', 'required', 'placeholder'=>''])); ?>

                        </div>
                    </div>
                    <div class="col-md-6">

                        <?php echo e(Form::label('organization_id', 'Organization')); ?><br>
                        <div class="form-group">
                            <?php echo e(Form::select('organization_id',$organizations,null, ['class' => 'form-control select2', 'required', 'placeholder'=>'--Select
                            Organization--'])); ?>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <?php echo e(Form::label('job_title', 'Job Title')); ?><br>
                        <div class="form-group">
                            <?php echo e(Form::text('job_title', '',['class'=>'form-control', 'required', 'placeholder'=>''])); ?>

                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <?php echo e(Form::label('role_id', 'User Role')); ?><br> <?php echo e(Form::select('role_id',$roles,null, ['class' =>
                            'form-control select2', 'required', 'placeholder'=>'--Select User Role--'])); ?>

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-check"></i> Create New User</button>
            </div>

            <?php echo Form::close(); ?>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- PAGE FOOTER -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="/css/admin_custom.css">
<link rel="stylesheet" href="/css/bootstrap-datepicker.min.css">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>

<script src="/js/bootstrap-datepicker.min.js"></script>
<script>
    $(function () {
         $('#example1').DataTable()
         $('#example2').DataTable()
    });

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>