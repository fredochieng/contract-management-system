<?php $__env->startSection('title', 'My Contracts'); ?>
<?php $__env->startSection('content_header'); ?>
<h1>
    My Contracts
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
                    <th style="width:160px;">Party Name</th>
                    <th style="width:145px;">Uploads</th>
                    <th style="width:90px;">Effective Date</th>
                    <th style="width:90px;">Expiry Date</th>
                    <th style="width:50px;">Status</th>
                    <th style="width:50px;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $my_contracts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$my_contract): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($key+1); ?></td>
                    <td><a href="/contract/<?php echo e($my_contract->contract_id); ?>/view"><?php echo e($my_contract->contract_title); ?></a></td>
                    <td><?php echo e($my_contract->party_name); ?></td>
                    <td><a href="/<?php echo e($my_contract->draft_file); ?>" target="_blank"><i class="fa fa-fw fa-download"></i> Contract</a>                        |
                        <a href="/<?php echo e($my_contract->draft_file); ?>" target="_blank"><i class="fa fa-fw fa-download"></i> CRF</a>
                    </td>
                    <td><?php echo e(date("d-m-Y",strtotime($my_contract->effective_date))); ?></td>
                    <td><?php echo e(date("d-m-Y",strtotime($my_contract->expiry_date))); ?></td>
                    <td><span class="pull-right-container">
                        <?php if($my_contract->contract_status == 'created'): ?>
                        <small class="label pull-center btn-warning"><?php echo e($my_contract->contract_status); ?></small></span>
                        <?php elseif($my_contract->contract_status
                        == 'published'): ?>
                        <small class="label pull-center btn-info"><?php echo e($my_contract->contract_status); ?></small></span>
                        <?php elseif($my_contract->contract_status== 'submitted'): ?>
                        <small class="label label-success"><?php echo e($my_contract->contract_status); ?></small></span>
                        <?php elseif($my_contract->contract_status== 'ammended'): ?>
                        <small class="label pull-center btn-danger"><?php echo e($my_contract->contract_status); ?></small></span>
                        <?php elseif($my_contract->contract_status== 'approved'): ?>
                        <small class="label pull-center btn-success"><?php echo e($my_contract->contract_status); ?></small></span>
                        <?php elseif($my_contract->contract_status== 'terminated'): ?>
                        <small class="label pull-center btn-danger"><?php echo e($my_contract->contract_status); ?></small></span>
                    </td>
                    <?php endif; ?>
                    </td>
                    <td>
                       <?php if(auth()->check()): ?> <?php if(auth()->user()->isUser() && ($my_contract->contract_status
                        == 'created' || $my_contract->contract_status == 'ammended')): ?>
                        <a href="/contract/<?php echo e($my_contract->contract_id); ?>/edit">
                                <span class = "fa fa-pencil bigger"></span></center></a> <?php else: ?>

                        <a href="/contract/<?php echo e($my_contract->contract_id); ?>/view">
                                                                    <span class = "fa fa-eye bigger"></span></center></a>
                                                                    <?php endif; ?> <?php endif; ?> <?php echo Form::open(['action'=>['ContractController@destroy',$my_contract->contract_id],'method'=>'POST','class'=>'floatit','enctype'=>'multipart/form-data']); ?> <?php echo e(Form::hidden('_method','DELETE')); ?> 
                        <a class="delete" data-id="<?php echo e($my_contract->contract_id); ?>" href="javascript:void(0)">
                                <span style="color:red;" class = "fa fa-trash bigger"></span></a>
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