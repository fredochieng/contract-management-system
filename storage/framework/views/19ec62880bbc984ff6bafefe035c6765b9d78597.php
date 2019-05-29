<?php $__env->startSection('title', 'Wananchi Legal | System Settings'); ?>

<?php $__env->startSection('content_header'); ?>
<h1>System</h1></h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">
        <!-- Custom Tabs -->
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#general" data-toggle="tab" aria-expanded="true">General</a></li>
                <li class=""><a href="#labels" data-toggle="tab" aria-expanded="false">Labels</a></li>
                <li class=""><a href="#email" data-toggle="tab" aria-expanded="false">Email</a></li>
                <li class=""><a href="#tickets" data-toggle="tab" aria-expanded="false">Contracts</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="general">
                    <form role="form" action="" method="post" id="generalSettingsForm">
                        <div class="form-group">
                            <label for="app_name" class="control-label">Application Name</label>
                            <input class="form-control" id="app_name" value=""
                                placeholder="Application Name" type="text" name="app_name" required="">
                            <p class="help-block">Application Name as it appears throughout the system</p>
                        </div>
                        <div class="form-group">
                            <label for="app_url" class="control-label">Application URL</label>
                            <input class="form-control" id="app_url" value=""
                                placeholder="Application URL" type="text" name="app_url" required="">
                            <p class="help-block">Full installation URL including http:
                        </div>
                        <div class="form-group">
                            <label for="company_name" class="control-label">Company Name</label>
                            <input class="form-control" id="company_name" value=""
                                placeholder="Company Name" type="text" name="company_name" required="">
                            <p class="help-block">Company Name as it appears throughout the system</p>
                        </div>
                        <div class="form-group">
                            <label for="company_details" class="control-label">Company Details</label>
                            <textarea class="form-control" rows="3" placeholder="Company Details ..."
                                id="company_details" name="company_details"></textarea>
                            <p class="help-block">Company Details used in the system for reports</p>
                        </div>
                        <div class="form-group">
                            <label for="log_retention" class="control-label">Log Retention</label>
                            <input class="form-control" id="log_retention" value="365"
                                placeholder="Log Retention (days)" type="number" name="log_retention" required="">
                            <p class="help-block">Delete log entries older then (days)</p>
                        </div>
                        <div class="form-group">
                            <label for="asset_tag_prefix" class="control-label">Default Contract Ticket Prefix</label>
                            <input class="form-control" id="asset_tag_prefix" value="WGT-" placeholder="Asset Tag Prefix"
                                type="text" name="asset_tag_prefix" required="">
                        </div>

                        <div class="form-group">
                            <div class="pull-right" style="margin:10px 0px;"><button type="submit"
                                    class="btn btn-flat btn-success">Save Changes</button></div>
                        </div>
                        <div style="clear:both;"></div>

                        <input type="hidden" name="action" value="generalSettings">
                        <input type="hidden" name="route" value="system/settings">
                        <input type="hidden" name="section" value="">
                    </form>
                </div><!-- /.tab-pane -->
                <div class="tab-pane" id="email">
                    <form role="form" action="" method="post" id="emailSettingsForm">
                        <div class="form-group">
                            <label for="email_from_address" class="control-label">Email From Address</label>
                            <input class="form-control" id="email_from_address" value="legal@ke.wananchi.com"
                                placeholder="Email From Address" type="text" name="email_from_address" required="">
                        </div>
                        <div class="form-group">
                            <label for="email_from_name" class="control-label">Emails From Name</label>
                            <input class="form-control" id="email_from_name" value="Wananchi Legal"
                                placeholder="Emails From Name" type="text" name="email_from_name" required="">
                        </div>

                        <div class="form-group">
                            <div class="pull-right" style="margin:10px 0px;"><button type="submit"
                                    class="btn btn-flat btn-success">Save Changes</button></div>
                        </div>

                        <div style="clear:both;"></div>
                        <input type="hidden" name="action" value="emailSettings">
                        <input type="hidden" name="route" value="system/settings">
                        <input type="hidden" name="section" value="email">
                    </form>
                </div><!-- /.tab-pane -->

                <div class="tab-pane" id="tickets">
                    <div class="row">

                        <div class="col-md-6">

                            <div class="box box-success">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Organization Entities</h3>
                                    <div class="box-tools pull-right">
                                        <a href="#" data-toggle="modal" data-target="#modal_add_entity" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> NEW ENTITY</a>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table class="table table-no-margin">
                                            <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Name</th>
                                                    <th class="text-right"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                    <?php $__currentLoopData = $entities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $count => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td><?php echo e($count+1); ?></td>
                                                            <td><?php echo e($row->organization_name); ?></td>
                                                            <td>
                                                                <div class="pull-right btn-group">
                                                                    <a href="#" class="btn btn-flat btn-success btn-sm"><i class="fa fa-edit"></i></a></div>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /.tab-pane -->
            </div><!-- /.tab-content -->
        </div><!-- nav-tabs-custom -->
    </div><!-- /.col-->
</div>
<?php echo $__env->make('system.modals.modal_add_entity', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>