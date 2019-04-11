<?php $__env->startSection('title', 'Contract Details'); ?>
<?php $__env->startSection('content_header'); ?>
<h1>View Contract Details</h1>




<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<style>
    .description {
        height: 90px !important
    }
</style>
<div class="box box-success">
    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header" style="font-weight:bold">
                    Contract Party: <?php echo e($contract->party_name); ?>

                    <small class="pull-right" style="font-weight:bold">Contract Number: # <?php echo e($contract->contract_id); ?></small>
                </h2>
            </div>
        </div>
        <div class="row invoice-info">
            <!-- Contract Details row -->
            <?php echo Form::open(['action'=>['ContractController@publish', $contract->contract_id],'method'=>'POST','class'=>'form','enctype'=>'multipart/form-data']); ?>

            <div class="row">
                <div class="col-md-6">
                    <?php echo e(Form::text('contract_id',$contract->contract_id,['class'=>'form-control hidden','placeholder'=>'The contract Title'])); ?>

                    <?php echo e(Form::label('title', 'Contract Title ')); ?>

                    <div class="form-group">
                        <h4><?php echo e($contract->contract_title); ?></h4>
                    </div>
                </div>
                <div class="col-md-3">
                    <?php echo e(Form::label('party_name', 'Party Name ')); ?>

                    <div class="form-group">
                        <h4><?php echo e($contract->party_name); ?></h4>
                    </div>
                </div>
                <div class="col-md-3">
                    <?php echo e(Form::label('contract_type', 'Contract Type ')); ?>

                    <div class="form-group">
                        <?php if($contract->contract_type_name ==''): ?>
                        <h4>N/A</h4>
                        <?php else: ?> <?php echo e($contract->contract_type_name); ?> <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <?php echo e(Form::label('effective_date', 'Effective Date ')); ?>

                    <div class="form-group">
                        <h4><?php echo e($contract->effective_date); ?></h4>
                    </div>
                </div>
                <div class="col-md-3">
                    <?php echo e(Form::label('expiry_date', 'Expiry Date ')); ?>

                    <div class="form-group">
                        <h4><?php echo e($contract->expiry_date); ?></h4>
                    </div>
                </div>
                <div class="col-md-3">
                    <?php echo e(Form::label('contract_status', 'Contract Status')); ?>

                    <div class="form-group">
                        <span class="pull-right-container">
        <?php if($contract->contract_status == 'created'): ?>
                <small class="label pull-center btn-default"><?php echo e($contract->contract_status); ?></small></span>                        <?php elseif($contract->contract_status == 'published'): ?>
                        <small class="label pull-center btn-info"><?php echo e($contract->contract_status); ?></small></span>
                        <?php elseif($contract->contract_status == 'submitted'): ?>
                        <small class="label pull-center btn-success"><?php echo e($contract->contract_status); ?></small></span>
                        <?php elseif($contract->contract_status == 'approved'): ?>
                        <small class="label pull-center btn-success"><?php echo e($contract->contract_status); ?></small></span>
                        <?php elseif($contract->contract_status == 'ammended'): ?>
                        <small class="label pull-center btn-warning"><?php echo e($contract->contract_status); ?></small></span>
                        <?php elseif($contract->contract_status == 'terminated'): ?>
                        <small class="label pull-center btn-danger"><?php echo e($contract->contract_status); ?></small></span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <?php echo e(Form::label('description', 'Contract Description')); ?>

                    <div class="form-group">
                        <h4><?php echo e($contract->description); ?></h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                </div>
            </div>
            <div class="row no-print">
                <div class="col-xs-12">
                    <?php if( $contract->contract_status =='created' && $contract->contract_stage ==1): ?>
                    <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> PUBLISH CONTRACT</button> <?php elseif($contract->contract_status
                    =='published' && $contract->contract_stage ==2): ?>
                    <a href="#modal_submit_contract" data-toggle="modal" data-target="#modal_submit_contract" class="btn btn-success"><i class="fa fa-check"></i> SUBMIT CONTRACT</a>
                    <a href="#modal_ammend_contract" data-toggle="modal" data-target="#modal_ammend_contract" class="btn btn-info"><i class="fa fa-refresh"></i> AMMEND CONTRACT</a>
                    <a href="#modal_terminate_contract" data-toggle="modal" data-target="#modal_terminate_contract" class="btn btn-danger"><i class="fa fa-close"></i> TERMINATE CONTRACT</a>                    <?php elseif($contract->contract_status =='submitted' && $contract->contract_stage ==3): ?> 
                    <a href="#modal_approve_contract" data-toggle="modal" data-target="#modal_approve_contract" class="btn btn-success"><i class="fa fa-check"></i> APPROVE CONTRACT</a>
                    <a href="#modal_admin_ammend_contract" data-toggle="modal" data-target="#modal_admin_ammend_contract" class="btn btn-info"><i class="fa fa-refresh"></i> AMMEND CONTRACT</a>
                    <a href="#modal_admin_terminate_contract" data-toggle="modal" data-target="#modal_admin_terminate_contract" class="btn btn-danger"><i class="fa fa-close"></i> TERMINATE CONTRACT</a>                    <?php elseif($contract->contract_status =='terminated'): ?>
                    <p class="col-md-6 text-red well well-sm no-shadow" style="margin-top: 10px;">
                        his contract has been terminated and the initiator has been notified
                    </p>
                    <?php elseif($contract->contract_status =='ammended'): ?>
                    <p class="col-md-6 text-red well well-sm no-shadow" style="margin-top: 10px;">
                        This contract has been ammended waiting for the action by the contract party
                    </p>
                    <?php endif; ?>

                    <a href="/<?php echo e($last_draft_contract_section->crf_file); ?>" class="btn btn-primary pull-right" style="margin-right: 10px;" target="_blank"><i class="fa fa-fw fa-download"></i> Latest CRF Document</a>
                    <a href="/<?php echo e($contract->draft_file); ?>" class="btn btn-primary pull-right" style="margin-right: 10px;" target="_blank"><i class="fa fa-fw fa-download"></i> Latest Contract Document</a>                    <?php echo Form::close(); ?>


                </div>
            </div>
    </section>
    <!-- Modal to submit a contract by legal team -->
    <div class="modal fade" id="modal_submit_contract">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <?php echo Form::open(['action'=>'ContractController@submit','method'=>'POST','class'=>'form','enctype'=>'multipart/form-data']); ?>

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Submit Contract To Head of Legal</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?php echo e(Form::text('contract_id',$contract->contract_id,['class'=>'form-control hidden','placeholder'=>'The contract Title'])); ?>

                            <div class="form-group">
                                <h>Classify the contract</h><br/><br/>
                                <label><input type="radio" name="contract_type" value="1" class="flat-red" checked >&nbsp;&nbsp; Standard</label>&nbsp;&nbsp;
                                <label><input type="radio" name="contract_type" value="2" class="flat-red">&nbsp;&nbsp; Non Standard</label>
                            </div>
                            <?php echo e(Form::label('comments', 'Comments (optional)')); ?><br>
                            <div class="form-group">
                                <?php echo e(Form::textarea('comments', '',['class'=>'form-control', 'placeholder'=>'Comments are optional'])); ?>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success pull-left btn-flat" name="approve"><i class="fa fa-check"></i> SUBMIT CONTRACT</button>
                </div>
                <?php echo Form::close(); ?>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- End modal to submit a contract by legal team -->

    <!-- Modal to ammend a contract by legal team -->
    <div class="modal fade" id="modal_ammend_contract">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <?php echo Form::open(['action'=>'ContractController@ammend','method'=>'POST','class'=>'form','enctype'=>'multipart/form-data']); ?>

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Ammend Contract</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo e(Form::text('contract_id',$contract->contract_id,['class'=>'form-control hidden','placeholder'=>'The contract Title'])); ?>

                            <?php echo e(Form::label('ammended_contract_document', 'Upload Ammended Contract Document (optional)')); ?>


                            <div class="form-group">
                                <?php echo e(Form::file('ammended_contract_document',['class'=>'form-control'])); ?>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <?php echo e(Form::label('ammended_contract_crf', 'Upload Ammended Contract CRF (optional)')); ?>


                            <div class="form-group">
                                <?php echo e(Form::file('ammended_contract_crf',['class'=>'form-control'])); ?>

                            </div>
                        </div>
                        <div class="col-md-12">
                            <?php echo e(Form::label('comments', 'Comments *')); ?><br>
                            <div class="form-group">
                                <?php echo e(Form::textarea('comments', '',['class'=>'form-control', 'required', 'placeholder'=>''])); ?>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success pull-left btn-flat" name="reject"><i class="fa fa-close"></i> AMMEND CONTRACT</button>
                </div>
                <?php echo Form::close(); ?>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- End modal to ammend a contract by legal team -->

    <!-- Modal to terminate a contract by legal team -->
    <div class="modal fade" id="modal_terminate_contract">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <?php echo Form::open(['action'=>'ContractController@terminate','method'=>'POST','class'=>'form','enctype'=>'multipart/form-data']); ?>

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Terminate Contract</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?php echo e(Form::text('contract_id',$contract->contract_id,['class'=>'form-control hidden','placeholder'=>'The contract Title'])); ?>

                            <?php echo e(Form::label('comments', 'Comments *')); ?><br>
                            <div class="form-group">
                                <?php echo e(Form::textarea('comments', '',['class'=>'form-control', 'required', 'placeholder'=>''])); ?>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success pull-left btn-flat" name="reject"><i class="fa fa-close"></i> TERMINATE CONTRACT</button>
                </div>
                <?php echo Form::close(); ?>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- End modal to terminate a contract by legal team -->

    
    <!-- Modal to approve a contract by legal admin-->
    <div class="modal fade" id="modal_approve_contract">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <?php echo Form::open(['action'=>'ContractController@approve','method'=>'POST','class'=>'form','enctype'=>'multipart/form-data']); ?>

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Approve Contract</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?php echo e(Form::text('contract_id',$contract->contract_id,['class'=>'form-control hidden','placeholder'=>'The contract Title'])); ?>

                            <?php echo e(Form::label('comments', 'Comments (optional)')); ?><br>
                            <div class="form-group">
                                <?php echo e(Form::textarea('comments', '',['class'=>'form-control', 'placeholder'=>'Comments are optional'])); ?>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success pull-left btn-flat" name="approve"><i class="fa fa-check"></i> SUBMIT CONTRACT</button>
                </div>
                <?php echo Form::close(); ?>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- End modal to approve a contract by legal admin -->

    <!-- Modal to ammend a contract by legal admin -->
    <div class="modal fade" id="modal_admin_ammend_contract">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <?php echo Form::open(['action'=>'ContractController@ammend','method'=>'POST','class'=>'form','enctype'=>'multipart/form-data']); ?>

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Ammend Contract</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo e(Form::text('contract_id',$contract->contract_id,['class'=>'form-control hidden','placeholder'=>'The contract Title'])); ?>

                            <?php echo e(Form::label('ammended_contract_document', 'Upload Ammended Contract Document (optional)')); ?>


                            <div class="form-group">
                                <?php echo e(Form::file('ammended_contract_document',['class'=>'form-control'])); ?>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <?php echo e(Form::label('ammended_contract_crf', 'Upload Ammended Contract CRF (optional)')); ?>


                            <div class="form-group">
                                <?php echo e(Form::file('ammended_contract_crf',['class'=>'form-control'])); ?>

                            </div>
                        </div>
                        <div class="col-md-12">
                            <?php echo e(Form::label('comments', 'Comments *')); ?><br>
                            <div class="form-group">
                                <?php echo e(Form::textarea('comments', '',['class'=>'form-control', 'required', 'placeholder'=>''])); ?>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success pull-left btn-flat" name="reject"><i class="fa fa-close"></i> AMMEND CONTRACT</button>
                </div>
                <?php echo Form::close(); ?>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- End modal to ammend a contract by legal admin -->

    <!-- Modal to terminate a contract by legal admin -->
    <div class="modal fade" id="modal_admin_terminate_contract">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <?php echo Form::open(['action'=>'ContractController@terminate','method'=>'POST','class'=>'form','enctype'=>'multipart/form-data']); ?>

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Terminate Contract</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo e(Form::text('contract_id',$contract->contract_id,['class'=>'form-control hidden','placeholder'=>'The contract Title'])); ?>

                            <?php echo e(Form::label('ammended_contract_document', 'Upload Ammended Contract Document (optional)')); ?>


                            <div class="form-group">
                                <?php echo e(Form::file('ammended_contract_document',['class'=>'form-control'])); ?>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <?php echo e(Form::label('ammended_contract_crf', 'Upload Ammended Contract CRF (optional)')); ?>


                            <div class="form-group">
                                <?php echo e(Form::file('ammended_contract_crf',['class'=>'form-control'])); ?>

                            </div>
                        </div>
                        <div class="col-md-12">
                            <?php echo e(Form::label('comments', 'Comments *')); ?><br>
                            <div class="form-group">
                                <?php echo e(Form::textarea('comments', '',['class'=>'form-control', 'required', 'placeholder'=>''])); ?>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success pull-left btn-flat" name="reject"><i class="fa fa-close"></i> TERMINATE CONTRACT</button>
                </div>
                <?php echo Form::close(); ?>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- End modal to terminate a contract by legal admin -->
    
    <div class="box box-success">
        <section class="invoice">
            <div class="box-header">
                <h3 class="box-title">Contract History</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width:40px">#</th>
                            <th style="width:130px">User</th>
                            <th>Position</th>
                            <th>Date Created</th>
                            <th>Contract Draft</th>
                            <th>CRF</th>
                            <th>
                                <center>Status</center>
                            </th>
                            <th>
                                <center>Stage</center>
                            </th>
                            <th>Comments</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $contract_drafts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $contracts): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($key + 1); ?></td>
                            <td><?php echo e($contracts->name); ?></td>
                            <td><?php echo e($contracts->job_title); ?></td>
                            <td><?php echo e($contracts->contract_drafts_created_at); ?></td>
                            <td style="width:120px"> <a href="/<?php echo e($contracts->draft_file); ?>" target="_blank"><i class="fa fa-fw fa-download"></i> Download</a></td>
                            <td style="width:120px"> <a href="/<?php echo e($contracts->crf_file); ?>" target="_blank"><i class="fa fa-fw fa-download"></i> Download</a></td>
                            <td>
                                <center><span class="pull-right-container">
                                    <?php if($contracts->contract_drafts_status == 'created'): ?>
                                        <small class="label pull-center btn-default"><?php echo e($contracts->contract_drafts_status); ?></small></span>                                    <?php elseif($contracts->contract_drafts_status== 'published'): ?>
                                    <small class="label pull-center btn-info"><?php echo e($contracts->contract_drafts_status); ?></small></span>
                                    <?php elseif($contracts->contract_drafts_status== 'submitted'): ?>
                                    <small class="label pull-center btn-success"><?php echo e($contracts->contract_drafts_status); ?></small></span>
                                    <?php elseif($contracts->contract_drafts_status== 'approved'): ?>
                                    <small class="label pull-center btn-success"><?php echo e($contracts->contract_drafts_status); ?></small></span>
                                    <?php elseif($contracts->contract_drafts_status== 'ammended'): ?>
                                    <small class="label pull-center btn-warning"><?php echo e($contracts->contract_drafts_status); ?></small></span>
                                </center>
                                <?php elseif($contracts->contract_drafts_status== 'terminated'): ?>
                                <small class="label pull-center btn-danger"><?php echo e($contracts->contract_drafts_status); ?></small></span>
                            </td>
                            <?php endif; ?>
                            <td>
                                <center>
                                    <p class="text-light-primary"><?php echo e($contracts->task); ?></p>
                                </center>
                            </td>
                            <td><a href="#modal_show_action_comments" data-toggle="modal" data-target="#modal_show_action_comments_<?php echo e($contracts->contract_draft_id); ?>"><strong>Comments</strong></a></p>
                            </td>
                        </tr>
                        <!-- Modal to show comments for an approved contract -->
                        <div class="modal fade" id="modal_show_action_comments_<?php echo e($contracts->contract_draft_id); ?>">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <?php echo Form::open(['class'=>'form']); ?>

                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Comments</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <?php echo e(Form::text('contract_id',$contracts->contract_id,['class'=>'form-control hidden','placeholder'=>'The contract Title'])); ?>

                                                    <?php if($contracts->comments == ''): ?>
                                                    <p>No comments left for this action...</p>
                                                    <?php else: ?>
                                                    <p><?php echo e($contracts->comments); ?></p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                    </div>
                                    <?php echo Form::close(); ?>

                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- End modal show comments for an approved contract -->
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </section>
        </tbody>
        </table>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="/iCheck/all.css">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script src="/js/bootstrap-datepicker.min.js"></script>
    <script src="/iCheck/icheck.min.js"></script>
    <script>
        $(function () {
                    $('#example1').DataTable()
            //iCheck for checkbox and radio inputs
            $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass   : 'iradio_flat-green'
            })
                    })
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>