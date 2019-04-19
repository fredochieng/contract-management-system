<?php $__env->startSection('title', 'Pending Contracts'); ?>
<?php $__env->startSection('content_header'); ?>
<h1>
    Pending Contracts
    <a href="/contract/create" class="btn btn-xs btn-info pull-right btn-flat">NEW CONTRACT</a>
</h1>





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
<?php endif; ?>
<div class="box">
    <div class="box-body">
        <table id="example1" class="table table-striped table-bordered records">
            <thead>
                <tr>
                    <th style="width:25px;">S/N</th>
                    <th style="width:400px;">Contract Title</th>
                    <?php if(auth()->check()): ?> <?php if(auth()->user()->isLegal() || auth()->user()->isUser() ): ?>
                    <th style="width:350px;">Party Name</th>
                    <?php else: ?>
                    <th style="width:150px;">Party Name</th>
                    <?php endif; ?> <?php endif; ?> <?php if(auth()->check()): ?> <?php if(auth()->user()->isLegal() || auth()->user()->isUser() ): ?>
                    <th style="width:245px;">Uploads</th>
                    <?php else: ?>
                    <th style="width:145px;">Uploads</th>
                    <?php endif; ?> <?php endif; ?>
                    <th style="width:150px;">Effective Date</th>
                    <th style="width:150px;">Expiry Date</th>
                    <th style="width:50px;">Status</th>
                    <?php if(auth()->check()): ?> <?php if(auth()->user()->isAdmin() && 'contracts.assigned'=='' ): ?>
                    <th style="width:70px;">Alert</th>
                    <?php endif; ?> <?php endif; ?>
                    <th style="width:60px;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $pending_contracts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$pending_contract): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($key+1); ?></td>
                    <td><a href="/contract/<?php echo e($pending_contract->contract_id); ?>/view"><?php echo e($pending_contract->contract_title); ?></a></td>
                    <td><?php echo e($pending_contract->party_name); ?></td>
                    <td><a href="/<?php echo e($pending_contract->draft_file); ?>" target="_blank"><i class="fa fa-fw fa-download"></i> Contract</a>                        |
                        <a href="/<?php echo e($pending_contract->draft_file); ?>" target="_blank"><i class="fa fa-fw fa-download"></i> CRF</a>
                    </td>
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
                    <?php endif; ?>
                    </td>
                    <?php if(auth()->check()): ?> <?php if(auth()->user()->isAdmin() && $pending_contract->assigned==''): ?>
                    <td>
                        <div class="progress progress-xs">
                            <div class="progress-bar progress-bar-danger" style="width: 100%"></div>
                        </div>
                    </td>
                    <?php else: ?>
                  <td>
                        <div class="progress progress-xs">
                            <div class="progress-bar progress-bar-success" style="width: 100%"></div>
                        </div>
                    </td> 
                    <?php endif; ?> <?php endif; ?>
                    <td>
                        <?php if(auth()->check()): ?> <?php if(auth()->user()->isUser() && ($pending_contract->contract_status == 'created' || $pending_contract->contract_status==
                        'ammended')): ?>
                        <a href="/contract/<?php echo e($pending_contract->contract_id); ?>/edit" class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit Contract">
                            <i class = "fa fa-pencil bigger"></i></a> <?php else: ?>
                        <a href="/contract/<?php echo e($pending_contract->contract_id); ?>/view" class="btn btn-primary btn-xs" data-toggle="tooltip" title="View Contract Details">
                            <i class = "fa fa-eye bigger"></i></a> <?php endif; ?> <?php endif; ?> <?php if(auth()->check()): ?>
                        <?php if((auth()->user()->isLegal() || auth()->user()->isAdmin()) && ($pending_contract->contract_status
                        == 'published' && $pending_contract->assigned == '')): ?> <?php else: ?> <?php endif; ?> <?php endif; ?> <?php echo e(Form::hidden('_method','POST')); ?> <?php echo Form::open(['action'=>['ContractController@destroy',$pending_contract->contract_id],'method'=>'POST','class'=>'floatit','enctype'=>'multipart/form-data']); ?> <?php echo e(Form::hidden('_method','DELETE')); ?>

                        <button type="submit" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete Contract" onClick="return confirm('Are you sure you want to delete this contract?');">   <strong>  <i class="fa fa-trash"></i></strong></button>                        
                    </td>
                    <?php echo Form::close(); ?>

                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
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
        $(document).ready(function() {

        $('.delete').click(function(e) {

            e.preventDefault();

            var cont_id = $(this).attr('data-id');
            var parent = $(this).parent("td").parent("tr");

            bootbox.dialog({
                message: " Are you sure you want to delete the contract?",
                title: "<i class='fa fa-trash'></i> Delete Contract",
                buttons: {
                    danger: {
                        label: "No",
                        className: "btn-primary",
                        callback: function() {
                            $('.bootbox').modal('hide');
                        }
                    },
                    success: {
                        label: "Delete",
                        className: "btn-success",
                        callback: function() {
                            $.post('', {
                                    'delete': cont_id
                                })
                                .done(function(response) {
                                    bootbox.alert(response);
                                    parent.fadeOut('slow');
                                })
                                .fail(function() {
                                    bootbox.alert('Something Went Wrong ....');
                                })

                        }
                    }
                }
            });

        });
});
    });

</script>








<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>