<?php $__env->startSection('title', 'Wananchi Legal | Manage Reports'); ?>
<?php $__env->startSection('content_header'); ?>
<h1 class="pull-left">Reports<small>Manage Reports</small></h1>
<div style="clear:both"></div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row" style="font-size:12px;">
    <div class="col-md-12">
        <!-- Custom Tabs (Pulled to the right) -->
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab-contract-status" data-toggle="tab">Contract Status</a></li>
                <li><a href="#tab-contract-type" data-toggle="tab">Contract Type</a></li>
                <li><a href="#tab-contract-party" data-toggle="tab">Contracting Party</a></li>
                <li><a href="#tab-contract-expiry" data-toggle="tab">Contract Expiry</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab-contract-status">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="box box-success">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Timesheet Reports with Contract Status</h3>
                                </div><!-- /.box-header -->
                                <?php
                        $report_type = 'status';
                        $report_type1 = 'contract_type';
                        $report_type2 = 'contract_party';
                        $report_type3 = 'contract_expiry';
                        ?>
                                <?php echo Form::open(['action'=>['ReportController@show' , $report_type ],
                                'method'=>'GET','class'=>'form','enctype'=>'multipart/form-data',
                                'target'=>'_blank']); ?>

                                <div class="box-body">
                                    <p>Generate a report based on the status in the selected period.</p>
                                    <div class="form-group">
                                        <label>Contract Status</label>
                                        <select class="form-control select2" name="status_id" style="width: 100%;"
                                            tabindex="-1" aria-hidden="true">
                                            <option selected="selected">Please select contract status</option>
                                            <?php $__currentLoopData = $status; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($row->status_id); ?>"><?php echo e($row->status_name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>

                                    <?php echo e(Form::label('Start Date* ')); ?>

                                    <div class="form-group">
                                        <?php echo e(Form::text('start_date', '',['class'=>'form-control start_date',
                                    'placeholder'=>'Start Date','autocomplete'=>'off']
                                     )); ?>

                                    </div>
                                    <?php echo e(Form::label('End Date* ')); ?>

                                    <div class="form-group">
                                        <?php echo e(Form::text('end_date', '',['class'=>'form-control start_date',
                                                        'placeholder'=>'End Date','autocomplete'=>'off']
                                                         )); ?>

                                    </div>
                                </div>
                                <input type="hidden" name="report" value="status">
                                <input type="hidden" name="route" value="reports/view">
                                <div class="box-footer"><button type="submit" class="btn btn-primary btn-flat">Generate
                                        Report</button>
                                </div>
                                <?php echo Form::close(); ?>

                            </div>
                        </div>

                    </div>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="tab-contract-type">
                        <div class="row">
                            <div class="col-md-8">
                           <div class="box box-success">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Contract Type Report</h3>
                                </div><!-- /.box-header -->
                                <?php echo Form::open(['action'=>['ReportController@show' , $report_type1],
                                'method'=>'GET','class'=>'form','enctype'=>'multipart/form-data',
                                'target'=>'_blank']); ?>

                                <div class="box-body">
                                    <p>Generate a report of contract types.</p>
                                    <div class="form-group">
                                        <label>Contract Type</label>
                                        <select class="form-control select2" name="contract_type_id" style="width: 100%;" tabindex="-1"
                                            aria-hidden="true">
                                            <option selected="selected">Please select contract type</option>
                                            <?php $__currentLoopData = $contract_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($row->contract_type_id); ?>"><?php echo e($row->contract_type_name); ?>

                                            </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden" name="report" value="contract_type">
                                <input type="hidden" name="route" value="reports/view">
                                <div class="box-footer"><button type="submit" class="btn btn-primary btn-flat">Generate
                                        Report</button>
                                </div>
                                <?php echo Form::close(); ?>

                            </div>
                            </div>
                        </div>
                    </div>
                <div class="tab-pane" id="tab-contract-party">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="box box-success">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Contracting Party Report</h3>
                                </div><!-- /.box-header -->
                                <?php echo Form::open(['action'=>['ReportController@show' , $report_type2 ],
                                'method'=>'GET','class'=>'form','enctype'=>'multipart/form-data',
                                'target'=>'_blank']); ?>

                                <div class="box-body">
                                    <p>Generate a report of contracting parties.</p>
                                    <div class="form-group">
                                        <label>Contract Type</label>
                                        <select class="form-control select2" name="contract_party_id" style="width: 100%;"
                                            tabindex="-1" aria-hidden="true">
                                            <option selected="selected">Please select contract type</option>
                                            <?php $__currentLoopData = $parties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($row->party_id); ?>"><?php echo e($row->party_name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden" name="report" value="party">
                                <input type="hidden" name="route" value="reports/view">
                                <div class="box-footer"><button type="submit" class="btn btn-primary btn-flat">Generate
                                        Report</button>
                                </div>
                                <?php echo Form::close(); ?>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.tab-pane -->
              <div class="tab-pane" id="tab-contract-expiry">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="box box-success">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Contract Expiry Report</h3>
                                </div><!-- /.box-header -->
                                <?php echo Form::open(['action'=>['ReportController@show' , $report_type3],
                                'method'=>'GET','class'=>'form','enctype'=>'multipart/form-data',
                                'target'=>'_blank']); ?>

                                <div class="box-body">
                                    <p>Generate a reports of contract expiry.</p>
                                    <div class="form-group">
                                        <label>Contract Expiry Alert</label>
                                        <select class="form-control select2" name="expiry_id" style="width: 100%;" tabindex="-1"
                                            aria-hidden="true">
                                            <option selected="selected">Please select contract expiry alert</option>
                                            <?php $__currentLoopData = $contract_expiry_alert; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($row->expiry_id); ?>"><?php echo e($row->expiry_alert); ?>

                                            </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="box-footer"><button type="submit" class="btn btn-primary btn-flat">Generate
                                        Report</button>
                                </div>
                                <?php echo Form::close(); ?>

                            </div>
                        </div>
                    </div>
                <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
        </div>
        <!-- nav-tabs-custom -->
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="/css/admin_custom.css">
<link rel="stylesheet" href="/css/bootstrap-datepicker.min.css">

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>

<script src="/js/bootstrap-datepicker.min.js"></script>
<script>
    $(function () {
        $(".select2").select2();
        $('.start_date').datepicker( {
        format: 'yyyy-mm-dd',
        orientation: "bottom",
        autoclose: true,
        showDropdowns: true,
        todayHighlight: true,
        toggleActive: true,
        clearBtn: true,

        })
        $('#example1').DataTable()
        $('#example2').DataTable()
        $('#example3').DataTable()
        $('#example4').DataTable()
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>