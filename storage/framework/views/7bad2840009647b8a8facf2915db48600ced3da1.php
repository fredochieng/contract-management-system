<?php $__env->startSection('title', 'Wananchi Legal | Contract Details'); ?>
<?php $__env->startSection('content_header'); ?>
<h1 class="pull-left">Contracts<small><span
            style="font-weight:bold"><?php echo e($contract->contract_title); ?>(<?php echo e($contract->contract_code); ?>)</span></small></h1>
<div style="clear:both"></div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">
        <!-- Custom Tabs (Pulled to the right) -->
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab-details" data-toggle="tab">Contract Details</a></li>
                <li><a href="#tab-description" data-toggle="tab">Contract Description</a></li>
                <li><a href="#tab-history" data-toggle="tab">Contract History</a></li>
                <li class=""><a href="tab-details" data-toggle="tab">Request CAF</a></li>
                <li class=""><a href="tab-details" data-toggle="tab">Request Further Info</a></li>
                
                    <?php if(auth()->check()): ?>
                           <?php if(!auth()->user()->isUser() && ($contract->stage=='1') &&($contract->assigned=='0')): ?>
                                 <div class="btn-group pull-right" style="padding:6px;">
                                      <a href="" class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#modal_work_on_contract">Assign to me</a>
                                  </div>
                            <?php elseif(auth()->user()->isAdmin() && ($contract->contract_status=='Approved')): ?>
                                  <div class="btn-group pull-right" style="padding:6px;">
                                    <a href="#" class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#modal_request_caf">Request CAF</a>
                                </div>
                            <?php endif; ?>
                    <?php endif; ?>
                
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab-details">
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="box box-success">
                                <div class="box-header">
                                    <h3 class="box-title">Contract Details </h3>
                                    <div class="pull-right box-tools">
                                        <button type="button" class="btn btn-default btn-sm btn-flat"
                                            data-widget="collapse" data-toggle="tooltip" title="Collapse"><i
                                                class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table id="clientTable" class="table no-margin">
                                            <tbody>
                                                <tr>
                                                    <td><b>Ticket No</b></td>
                                                    <td><span
                                                            style="font-weight:bold"><?php echo e($contract->contract_code); ?></span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>Contract Title</b></td>
                                                    <td><span
                                                            style="font-weight:bold"><?php echo e($contract->contract_title); ?></span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>Contract Type</b></td>
                                                    <?php if($contract->contract_type_name==''): ?>
                                                    <td>N/A</td>
                                                    <?php else: ?>
                                                    <td><small
                                                            class="badge bg-green"><?php echo e($contract->contract_type_name); ?></small>
                                                    </td>
                                                    <?php endif; ?>
                                                </tr>
                                                <tr>
                                                    <td><b>Contract Term</b></td>
                                                    <td><?php echo e($contract->term); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Contract Renewal Type</b></td>
                                                    <td><?php echo e($contract->renewal_type); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Contract Status</b></td>
                                                    <td>
                                                        <?php if($contract->contract_status == '1'): ?>
                                                        <small
                                                            class="badge bg-yellow"><?php echo e($contract->status_name); ?></small></span>
                                                        <?php elseif($contract->contract_status == '2'): ?>
                                                        <small
                                                            class="badge bg-blue"><?php echo e($contract->status_name); ?></small></span>
                                                        <?php elseif($contract->contract_status == 'Closed'): ?>
                                                        <small
                                                            class="badge bg-aqua"><?php echo e($contract->contract_status); ?></small></span>
                                                        <?php elseif($contract->contract_status == 'Amended'): ?>
                                                        <small
                                                            class="badge bg-blue"><?php echo e($contract->contract_status); ?></small></span>
                                                        <?php elseif($contract->contract_status == 'Terminated'): ?>
                                                        <small
                                                            class="badge bg-red"><?php echo e($contract->contract_status); ?></small></span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>Contract Party</b></td>
                                                    <td><a href="/contract-party/<?php echo e($contract->party_id); ?>/view-contract-party"
                                                            target="_blank"><?php echo e($contract->party_name); ?></a></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Legal Nature of Entity</b></td>
                                                    <td><?php echo e($contract->legal_entity_type); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Postal Address</b></td>
                                                    <td><?php echo e($contract->physical_address); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Physical Address</b></td>
                                                    <td><?php echo e($contract->postal_address); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Contact Person</b></td>
                                                    <td><?php echo e($contract->contact_person); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Email Address</b></td>
                                                    <td><?php echo e($contract->email); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Phone Number</b></td>
                                                    <td><?php echo e($contract->telephone); ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-6">
                            <div class="box box-success">
                                <div class="box-header">
                                    <h3 class="box-title">People </h3>
                                    <div class="pull-right box-tools">
                                        <button type="button" class="btn btn-default btn-sm btn-flat"
                                            data-widget="collapse" data-toggle="tooltip" title="Collapse"><i
                                                class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table id="clientTable" class="table no-margin">
                                            <tr>
                                                <td><b>Assignee</b></td>
                                                <?php if($contract->assigned==''): ?>
                                                <td>Not assigned</td>
                                                <?php elseif($contract->assigned_user_id==Auth::user()->id): ?>
                                                <td>Me</td>
                                                <?php else: ?>
                                                <td><?php echo e($contract->name); ?></td>
                                                <?php endif; ?>
                                                <?php if(auth()->check()): ?> <?php if(!auth()->user()->isUser()): ?>
                                                <td><a href="" data-toggle="modal"
                                                        data-target="#modal_assign_contract">Assign someone else</a>
                                                </td>
                                                <?php endif; ?> <?php endif; ?>
                                            </tr>
                                            <?php if(auth()->check()): ?> <?php if(!auth()->user()->isUser()): ?>
                                            <tr>
                                                <td><b>Creator</b></td>
                                                <td><?php echo e($created_user->name); ?></td>
                                            </tr>
                                            <?php endif; ?> <?php endif; ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="box box-success">
                                <div class="box-header">
                                    <h3 class="box-title">Dates</h3>
                                    <div class="pull-right box-tools">
                                        <button type="button" class="btn btn-default btn-sm btn-flat"
                                            data-widget="collapse" data-toggle="tooltip" title="Collapse"><i
                                                class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table id="clientTable" class="table no-margin">
                                            <tr>
                                                <td><b>Created</b></td>
                                                <td><?php echo e($contract->created_date); ?></td>

                                                <td><b>Submitted</b></td>
                                                <?php if(empty($date_submitted->date)): ?>
                                                <td>N/A</td>
                                                <?php else: ?>
                                                <td><?php echo e($date_submitted->date); ?></td>
                                                <?php endif; ?>
                                            </tr>
                                            <tr>
                                                <td><b>Approved</b></td>
                                                <?php if(empty($date_approved->date)): ?>
                                                <td>N/A</td>
                                                <?php else: ?>
                                                <td><?php echo e($date_approved->date); ?></td>
                                                <?php endif; ?>

                                                <td><b>Closed</b></td>
                                                <?php if(empty($date_closed->date)): ?>
                                                <td>N/A</td>
                                                <?php else: ?>
                                                <td><?php echo e($date_closed->date); ?></td>
                                                <?php endif; ?>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="box box-success">
                                <div class="box-header">
                                    <h3 class="box-title">Contract Document & CAF Document</h3>
                                    <div class="pull-right box-tools">
                                        <button type="button" class="btn btn-default btn-sm btn-flat"
                                            data-widget="collapse" data-toggle="tooltip" title="Collapse"><i
                                                class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table id="clientTable" class="table no-margin">
                                            <tr>
                                                <a href="/<?php echo e($last_draft_contract_section->draft_file); ?>" class="btn btn-primary" style="margin-right:78px"
                                                    target="_blank"><i class="fa fa-fw fa-download"></i>
                                                    <?php if($contract->stage =='1'): ?>
                                                             Contract Draft
                                                    <?php elseif($contract->stage =='2'): ?>
                                                             Reviewed Contract
                                                    <?php elseif($contract->stage =='3'): ?>
                                                             Final Draft
                                                    <?php elseif($contract->stage =='4' || '5'): ?>
                                                    Final Execution
                                                    <?php endif; ?>
                                                </a>

                                                <?php if($contract->stage =='5'): ?>
                                                <a href="/<?php echo e($caf_form->crf_form); ?>" class="btn btn-primary" style="margin-right:128px"
                                                    target="_blank"><i class="fa fa-fw fa-download"></i>CAF Document
                                                </a>
                                                <?php endif; ?>

                                                  <?php if(auth()->check()): ?>
                                                         <?php if(auth()->user()->isUser() && ($contract->stage=='2') && ($contract->user_comments =='')): ?>
                                                             <a href="" data-toggle="modal" data-target="#modal_user_comment">Comment on the reviewed draft</a>
                                                         <?php elseif(auth()->user()->isUser() && ($contract->stage=='3') && ($contract->user_comments =='')): ?>
                                                             <a href="" data-toggle="modal" data-target="#modal_user_comment_final">Comment on the final draft</a>
                                                         <?php elseif(auth()->user()->isUser() && ($contract->stage=='4')): ?>
                                                             <a href="" data-toggle="modal" data-target="#modal_upload_caf">Upload CAF Document</a>
                                                         <?php elseif(!auth()->user()->isUser() && ($contract->contract_status=='2') && ($contract->user_comments !='')): ?>
                                                             <a href="" data-toggle="modal" data-target="#modal_view_user_comment">View user comments</a>
                                                         <?php elseif(!auth()->user()->isUser() && ($contract->contract_status=='3') && ($contract->user_comments !='')): ?>
                                                             <a href="" data-toggle="modal" data-target="#modal_view_user_comment">View user comments</a>
                                                        <?php endif; ?>
                                                   <?php endif; ?>

                                            </tr>

                                            
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row no-print">
                        <div class="col-xs-12">
                            <?php if(auth()->check()): ?>
                                <?php if(!auth()->user()->isUser() && ($contract->stage=='1') && ($contract->assigned_user_id == Auth::user()->id)): ?>
                                     <a href="#" data-target="#modal_share_reviewed_contract" data-toggle="modal" class="btn btn-primary">
                                     <i class="fa fa-check"></i> Share Reviewed Contract </a>
                                <?php elseif(!auth()->user()->isUser() && ($contract->stage=='2')): ?>
                                      <a href="#" data-target="#modal_share_final_draft" data-toggle="modal" class="btn btn-primary">
                                      <i class="fa fa-check"></i> Share Final Draft </a>
                                <?php elseif(!auth()->user()->isUser() && ($contract->stage=='3')): ?>
                                <a href="#" data-target="#modal_share_final_execution" data-toggle="modal" class="btn btn-primary">
                                    <i class="fa fa-check"></i> Share Final Execution Version </a>
                                <?php endif; ?>
                            <?php endif; ?>











                            <?php if(auth()->check()): ?>
                            <?php if(auth()->user()->isUser() && ($contract->contract_status=='Created')): ?>
                            <a href="#" data-target="#modal_submit_contract" data-toggle="modal" class="btn btn-primary">
                                <i class="fa fa-check"></i> Submit Contract </a>
                            <?php elseif(auth()->user()->isLegal() && ($contract->contract_status=='Pending') &&
                            ($contract->assigned_user_id== Auth::user()->id)): ?>
                            <a href="#modal_approve_contract" data-toggle="modal" data-target="#modal_approve_contract"
                                class="btn btn-primary"><i class="fa fa-check"></i> Approve Contract</a>
                            <a href="#modal_ammend_contract" data-toggle="modal" data-target="#modal_ammend_contract"
                                class="btn btn-info"><i class="fa fa-refresh"></i> Reviewed Contract</a>
                            <a href="#modal_terminate_contract" data-toggle="modal"
                                data-target="#modal_terminate_contract" class="btn btn-danger"><i
                                    class="fa fa-close"></i> Terminate Contract</a>
                            <?php elseif(auth()->user()->isAdmin() && ($contract->contract_status=='Pending')): ?>
                            <a href="#modal_approve_contract" data-toggle="modal" data-target="#modal_approve_contract"
                                class="btn btn-primary"><i class="fa fa-check"></i> Approve Contract</a>
                            <a href="#modal_ammend_contract" data-toggle="modal" data-target="#modal_ammend_contract"
                                class="btn btn-info"><i class="fa fa-refresh"></i> Reviewed Contract</a>
                            <a href="#modal_terminate_contract" data-toggle="modal"
                                data-target="#modal_terminate_contract" class="btn btn-danger">
                                <i class="fa fa-close"></i> Terminate Contract</a>
                            <?php elseif(auth()->user()->isUser() && ($contract->contract_status=='Pending')): ?>
                            <p class="col-md-6 text-blue well well-sm no-shadow" style="margin-top: 10px;">
                                Contract submitted awaiting action by the legal department</p>
                            <?php elseif(auth()->user()->isUser() && ($contract->contract_status=='Approved')): ?>
                            <a href="#" data-toggle="modal" data-target="#modal_upload_signed_contract"
                                class="btn btn-primary"><i class="fa fa-check"></i> Upload Signed Contract</a>
                            <?php elseif(!auth()->user()->isUser() && ($contract->contract_status=='Approved')): ?>
                            <p class="col-md-6 text-blue well well-sm no-shadow" style="margin-top: 10px;">
                                Contract approved for signature awaiting action by the user</p>
                            <?php elseif(!auth()->user()->isUser() && ($contract->contract_status=='Closed') &&
                            ($contract->signed_contract_file == '')): ?>
                            <a href="" data-backdrop="static" data-toggle="modal" data-target="#modal_archive_contract"
                                class="btn btn-primary"><i class="fa fa-file-archive-o"></i> Archive Contract</a>
                            <?php elseif(auth()->user()->isUser() && ($contract->contract_status=='Closed') &&
                            ($contract->signed_contract_file == '')): ?>
                            <p class="col-md-6 text-blue well well-sm no-shadow" style="margin-top: 10px;">
                                Contract closed
                            </p>
                            <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane " id="tab-description">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-success">
                                <div class="box-body">
                                    <div class="col-md-12">
                                        <?php echo e(Form::label('description', 'Contract Description')); ?>

                                        <div class="form-group">
                                            <?php echo e(Form::textarea('description', $contract->description,['class'=>'form-control description','placeholder'=>'Contract description'])); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="tab-pane " id="tab-history">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-success">
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table id="example1" class="table no-margin">
                                            <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>User</th>
                                                    <th>Date</th>
                                                    <th>Contract Draft</th>
                                                    <th style="width:120px">CRF Document</th>
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
                                                    <td><?php echo e($contracts->contract_drafts_created_at); ?></td>
                                                    <td style="width:120px"> <a href="/<?php echo e($contracts->draft_file); ?>"
                                                            target="_blank"><i class="fa fa-fw fa-download"></i>
                                                            Download</a></td>
                                                    <?php if($contracts->crf_form ==''): ?>
                                                    <td style="width:120px"> <a href="#"> No CRF Document</a></td>
                                                    <?php else: ?>
                                                    <td style="width:120px"> <a href="/<?php echo e($contracts->crf_form); ?>"
                                                            target="_blank"><i class="fa fa-fw fa-download"></i>
                                                            Download</a></td>
                                                    <?php endif; ?>
                                                    <td>
                                                        <center><span class="pull-right-container">
                                                           <?php if($contracts->stage_id== '1'): ?>
                                                            <small
                                                                class="badge bg-yellow"><?php echo e($contracts->stage_name); ?></small></span>
                                                            <?php elseif($contracts->stage_id== '2'): ?>
                                                            <small
                                                                class="badge bg-blue"><?php echo e($contracts->stage_name); ?></small></span>
                                                            <?php elseif($contracts->stage_id== '3'): ?>
                                                            <small
                                                                class="badge bg-aqua"><?php echo e($contracts->stage_name); ?></small></span>
                                                            <?php elseif($contracts->stage_id== '4'): ?>
                                                            <small
                                                                class="badge bg-purple"><?php echo e($contracts->stage_name); ?></small></span>
                                                            <?php elseif($contracts->contract_drafts_status== 'Terminated'): ?>
                                                            <small
                                                                class="badge bg-red"><?php echo e($contracts->contract_drafts_status); ?></small></span>
                                                        </center>
                                                    </td>
                                                    <?php endif; ?>
                                                    <td><a href="#modal_show_action_comments" data-toggle="modal"
                                                            data-target="#modal_show_action_comments_<?php echo e($contracts->contract_draft_id); ?>"><strong>
                                                                <center>View</center>
                                                            </strong></a></p>
                                                    </td>
                                                </tr>
                                                <!-- Modal to show comments for an approved contract -->
                                                <div class="modal fade"
                                                    id="modal_show_action_comments_<?php echo e($contracts->contract_draft_id); ?>">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <?php echo Form::open(['class'=>'form']); ?>

                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
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
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- nav-tabs-custom -->
        </div>
        <!-- /.col -->
    </div>
    <?php echo $__env->make('contracts.modals.modal_share_reviewed_contract', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('contracts.modals.modal_user_comment', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    
    <?php echo $__env->make('contracts.modals.modal_share_final_draft', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('contracts.modals.modal_user_comment_final', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    
    <?php echo $__env->make('contracts.modals.modal_share_final_execution', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('contracts.modals.modal_upload_caf', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>






    <?php echo $__env->make('contracts.modals.modal_submit_contract', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('contracts.modals.modal_assign_contract', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('contracts.modals.modal_work_on_contract', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('contracts.modals.modal_approve_contract', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('contracts.modals.modal_request_caf', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('contracts.modals.modal_upload_signed_contract', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
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
            $(".select2").select2();
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