<?php $__env->startSection('title', 'Contract Management System'); ?>
<?php $__env->startSection('content_header'); ?>
<h1>Contract Party: <?php echo e($party->party_name); ?></h1>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">
        <!-- Custom Tabs (Pulled to the right) -->
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab-summary" data-toggle="tab">Summary</a></li>
                <li><a href="">Approved Contracts</a></li>
                <li><a href="">Ammended Contracts</a></li>
                <li><a href="">Terminated Contracts</a></li>
                <li><a href="#tab-edit" data-toggle="tab">Edit Contract Party</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab-summary">
                    <div class="row ">
                        <div class="col-md-3 col-sm-6 col-xs-12 ">
                            <div class="info-box">
                                <span class="info-box-icon bg-yellow "><i class="fa fa-desktop"></i></span>
                                <div class="info-box-content ">
                                    <span class="info-box-text ">Pending Contracts</span>
                                    <span class="info-box-number " style="font-size:42px "><?php echo e($total_pending_contracts); ?></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-3 col-sm-6 col-xs-12 ">
                            <div class="info-box ">
                                <span class="info-box-icon bg-green "><i class="fa fa-briefcase "></i></span>
                                <div class="info-box-content ">
                                    <span class="info-box-text ">Approved Contracts</span>
                                    <span class="info-box-number " style="font-size:42px "><?php echo e($total_approved_contracts); ?></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->

                        <!-- fix for small devices only -->
                        <div class="clearfix visible-sm-block "></div>
                        <div class="col-md-3 col-sm-6 col-xs-12 ">
                            <div class="info-box ">
                                <span class="info-box-icon bg-blue "><i class="fa fa-certificate "></i></span>
                                <div class="info-box-content ">
                                    <span class="info-box-text ">Ammended Contracts</span>
                                    <span class="info-box-number " style="font-size:42px "><?php echo e($total_ammended_contracts); ?></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-3 col-sm-6 col-xs-12 ">
                            <div class="info-box ">
                                <span class="info-box-icon bg-red "><i class="fa fa-rocket "></i></span>
                                <div class="info-box-content ">
                                    <span class="info-box-text ">Terminated Contracts</span>
                                    <span class="info-box-number " style="font-size:42px "><?php echo e($total_terminated_contracts); ?></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <div class="row ">
                        <div class="col-xs-4 ">
                            <div class="box box-success ">
                                <div class="box-header ">
                                    <h3 class="box-title ">Contract Party Details</h3>
                                </div>
                                <div class="box-body ">
                                    <table id="clientTable " class="table table-striped table-hover ">
                                        <tbody>
                                            <tr>
                                                <td><b>Name</b></td>
                                                <td><?php echo e($party->party_name); ?></td>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><b>Status</b></td>
                                                <td><span class="badge " style="background-color:#3479da ">Active</span></td>
                                            </tr>
                                            <tr>
                                                <td><b>Contact Person</b></td>
                                                <td>Christine Fredrick</td>
                                            </tr>
                                            <tr>
                                                <td><b>Telephone</b></td>
                                                <td><?php echo e($party->telephone); ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Email</b></td>
                                                <td><a href="#"><?php echo e($party->email); ?></a></td>
                                            </tr>
                                            <tr>
                                                <td><b>Address</b></td>
                                                <td><?php echo e($party->address); ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Total Contracts</b></td>
                                                <td><span class="badge bg-purple "><?php echo e($total_contracts); ?></span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-8 ">
                            <div class="box box-success ">
                                <div class="box-header ">
                                    <h3 class="box-title ">Latest Approved Contracts</h3>
                                    <div class="pull-right box-tools ">
                                        <button type="button " class="btn btn-default btn-sm btn-flat " data-widget="collapse
                                    " data-toggle="tooltip " title="Collapse "><i class="fa fa-minus "></i></button>
                                    </div>
                                </div>
                                <div class="box-body ">
                                    <div class="table-responsive ">
                                        <table id="example1" class="table no-margin">
                                            <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Contract Title</th>
                                                    <th>Effective Date</th>
                                                    <th>Expiry Date</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $approved_contracts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$approved_contract): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($key+1); ?></td>
                                                    <td><a href="/contract/<?php echo e($approved_contract->contract_id); ?>/view"><?php echo e($approved_contract->contract_title); ?></a></td>
                                                    <td><?php echo e(date("d-m-Y",strtotime($approved_contract->effective_date))); ?></td>
                                                    <td><?php echo e(date("d-m-Y",strtotime($approved_contract->expiry_date))); ?></td>
                                                    </td>
                                                    <?php echo Form::close(); ?>

                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="box box-success ">
                                <div class="box-header ">
                                    <h3 class="box-title ">Latest Ammended Contracts</h3>
                                    <div class="pull-right box-tools ">
                                        <button type="button " class="btn btn-default btn-sm btn-flat " data-widget="collapse
                                    " data-toggle="tooltip " title="Collapse "><i class="fa fa-minus "></i></button>
                                    </div>
                                </div>
                                <div class="box-body ">
                                    <div class="table-responsive ">
                                        <table id="example1" class="table no-margin">
                                            <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Contract Title</th>
                                                    <th>Effective Date</th>
                                                    <th>Expiry Date</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $terminated_contracts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$terminated_contract): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($key+1); ?></td>
                                                    <td><a href="/contract/<?php echo e($terminated_contract->contract_id); ?>/view"><?php echo e($terminated_contract->contract_title); ?></a></td>
                                                    <td><?php echo e(date("d-m-Y",strtotime($terminated_contract->effective_date))); ?></td>
                                                    <td><?php echo e(date("d-m-Y",strtotime($terminated_contract->expiry_date))); ?></td>
                                                    </td>
                                                    <?php echo Form::close(); ?>

                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="box box-success ">
                                <div class="box-header ">
                                    <h3 class="box-title ">Latest Terminated Contracts</h3>
                                    <div class="pull-right box-tools ">
                                        <button type="button " class="btn btn-default btn-sm btn-flat " data-widget="collapse
                                    " data-toggle="tooltip " title="Collapse "><i class="fa fa-minus "></i></button>
                                    </div>
                                </div>
                                <div class="box-body ">
                                    <div class="table-responsive ">
                                        <table id="example1" class="table no-margin">
                                            <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Contract Title</th>
                                                    <th>Effective Date</th>
                                                    <th>Expiry Date</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $ammended_contracts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$ammended_contract): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($key+1); ?></td>
                                                    <td><a href="/contract/<?php echo e($ammended_contract->contract_id); ?>/view"><?php echo e($ammended_contract->contract_title); ?></a></td>
                                                    <td><?php echo e(date("d-m-Y",strtotime($ammended_contract->effective_date))); ?></td>
                                                    <td><?php echo e(date("d-m-Y",strtotime($ammended_contract->expiry_date))); ?></td>
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
                <div class="tab-pane" id="tab-edit">
                    <div class="row ">
                        <div class="col-md-3 col-sm-6 col-xs-12 ">
                            <div class="info-box">
                                <span class="info-box-icon bg-yellow "><i class="fa fa-desktop"></i></span>
                                <div class="info-box-content ">
                                    <span class="info-box-text ">Pendingggg Contracts</span>
                                    <span class="info-box-number " style="font-size:42px "><?php echo e($total_pending_contracts); ?></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-3 col-sm-6 col-xs-12 ">
                            <div class="info-box ">
                                <span class="info-box-icon bg-green "><i class="fa fa-briefcase "></i></span>
                                <div class="info-box-content ">
                                    <span class="info-box-text ">Approved Contracts</span>
                                    <span class="info-box-number " style="font-size:42px "><?php echo e($total_approved_contracts); ?></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->

                        <!-- fix for small devices only -->
                        <div class="clearfix visible-sm-block "></div>
                        <div class="col-md-3 col-sm-6 col-xs-12 ">
                            <div class="info-box ">
                                <span class="info-box-icon bg-blue "><i class="fa fa-certificate "></i></span>
                                <div class="info-box-content ">
                                    <span class="info-box-text ">Ammended Contracts</span>
                                    <span class="info-box-number " style="font-size:42px "><?php echo e($total_ammended_contracts); ?></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-3 col-sm-6 col-xs-12 ">
                            <div class="info-box ">
                                <span class="info-box-icon bg-red "><i class="fa fa-rocket "></i></span>
                                <div class="info-box-content ">
                                    <span class="info-box-text ">Terminated Contracts</span>
                                    <span class="info-box-number " style="font-size:42px "><?php echo e($total_terminated_contracts); ?></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <div class="row ">
                        <div class="col-xs-4 ">
                            <div class="box box-success ">
                                <div class="box-header ">
                                    <h3 class="box-title ">Contract Party Details</h3>
                                </div>
                                <div class="box-body ">
                                    <table id="clientTable " class="table table-striped table-hover ">
                                        <tbody>
                                            <tr>
                                                <td><b>Name</b></td>
                                                <td><?php echo e($party->party_name); ?></td>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><b>Status</b></td>
                                                <td><span class="badge " style="background-color:#3479da ">Active</span></td>
                                            </tr>
                                            <tr>
                                                <td><b>Contact Person</b></td>
                                                <td>Christine Fredrick</td>
                                            </tr>
                                            <tr>
                                                <td><b>Telephone</b></td>
                                                <td><?php echo e($party->telephone); ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Email</b></td>
                                                <td><a href="#"><?php echo e($party->email); ?></a></td>
                                            </tr>
                                            <tr>
                                                <td><b>Address</b></td>
                                                <td><?php echo e($party->address); ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Total Contracts</b></td>
                                                <td><span class="badge bg-purple "><?php echo e($total_contracts); ?></span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-8 ">
                            <div class="box box-success ">
                                <div class="box-header ">
                                    <h3 class="box-title ">Latestffddxdd Approved Contracts</h3>
                                    <div class="pull-right box-tools ">
                                        <button type="button " class="btn btn-default btn-sm btn-flat " data-widget="collapse
                                                    " data-toggle="tooltip " title="Collapse "><i class="fa fa-minus "></i></button>
                                    </div>
                                </div>
                                <div class="box-body ">
                                    <div class="table-responsive ">
                                        <table id="example1" class="table no-margin">
                                            <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Contract Title</th>
                                                    <th>Effective Date</th>
                                                    <th>Expiry Date</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $approved_contracts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$approved_contract): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($key+1); ?></td>
                                                    <td><a href="/contract/<?php echo e($approved_contract->contract_id); ?>/view"><?php echo e($approved_contract->contract_title); ?></a></td>
                                                    <td><?php echo e(date("d-m-Y",strtotime($approved_contract->effective_date))); ?></td>
                                                    <td><?php echo e(date("d-m-Y",strtotime($approved_contract->expiry_date))); ?></td>
                                                    </td>
                                                    <?php echo Form::close(); ?>

                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="box box-success ">
                                <div class="box-header ">
                                    <h3 class="box-title ">Latestjjiji Ammended Contracts</h3>
                                    <div class="pull-right box-tools ">
                                        <button type="button " class="btn btn-default btn-sm btn-flat " data-widget="collapse
                                                    " data-toggle="tooltip " title="Collapse "><i class="fa fa-minus "></i></button>
                                    </div>
                                </div>
                                <div class="box-body ">
                                    <div class="table-responsive ">
                                        <table id="example1" class="table no-margin">
                                            <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Contract Title</th>
                                                    <th>Effective Date</th>
                                                    <th>Expiry Date</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $terminated_contracts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$terminated_contract): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($key+1); ?></td>
                                                    <td><a href="/contract/<?php echo e($terminated_contract->contract_id); ?>/view"><?php echo e($terminated_contract->contract_title); ?></a></td>
                                                    <td><?php echo e(date("d-m-Y",strtotime($terminated_contract->effective_date))); ?></td>
                                                    <td><?php echo e(date("d-m-Y",strtotime($terminated_contract->expiry_date))); ?></td>
                                                    </td>
                                                    <?php echo Form::close(); ?>

                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="box box-success ">
                                <div class="box-header ">
                                    <h3 class="box-title ">Latest Terminated Contracts</h3>
                                    <div class="pull-right box-tools ">
                                        <button type="button " class="btn btn-default btn-sm btn-flat " data-widget="collapse
                                                    " data-toggle="tooltip " title="Collapse "><i class="fa fa-minus "></i></button>
                                    </div>
                                </div>
                                <div class="box-body ">
                                    <div class="table-responsive ">
                                        <table id="example1" class="table no-margin">
                                            <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Contract Title</th>
                                                    <th>Effective Date</th>
                                                    <th>Expiry Date</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $ammended_contracts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$ammended_contract): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($key+1); ?></td>
                                                    <td><a href="/contract/<?php echo e($ammended_contract->contract_id); ?>/view"><?php echo e($ammended_contract->contract_title); ?></a></td>
                                                    <td><?php echo e(date("d-m-Y",strtotime($ammended_contract->effective_date))); ?></td>
                                                    <td><?php echo e(date("d-m-Y",strtotime($ammended_contract->expiry_date))); ?></td>
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
                <div class="tab-pane " id="tab-editddd">
                    <div class="row ">
                        <div class="container-fluid ">
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
























































<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
<link rel="stylesheet " href="/css/admin_custom.css ">
<link rel="stylesheet " href="/css/bootstrap-datepicker.min.css ">
<link rel="stylesheet " href="/css/select2.min.css ">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
<script src="/js/bootstrap-datepicker.min.js "></script>
<script src="/js/select2.full.min.js "></script>

























































<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>