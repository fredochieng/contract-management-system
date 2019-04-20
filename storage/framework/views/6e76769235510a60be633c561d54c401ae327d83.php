<?php $__env->startSection('title', 'Contract Parties'); ?>
<?php $__env->startSection('content_header'); ?>
   <h1 class="pull-left">Contract Parties<small>Manage Contract Parties</small></h1>

    <div class="pull-right"><a class="btn btn-primary btn-sm btn-flat" href="#modal_new_party" data-toggle="modal" data-target="#modal_new_party">NEW CONTRACT PARTY</a></div>
    <div style="clear:both"></div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<style>
    .description {
        height: 90px !important
    }
</style>
<div class="box box-success">
    <div class="box-body">
        <table id="example1" class="table no-margin">
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>Party Name</th>
                    <th>Address</th>
                    <th>Telephone</th>
                    <th>Email</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>

                <?php $__currentLoopData = $parties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $count=> $party): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($count+1); ?></td>
                    <td><?php echo e($party->party_name); ?></td>
                    <td><?php echo e($party->address); ?></td>
                    <td><?php echo e($party->telephone); ?></td>
                    <td><?php echo e($party->email); ?></td>
                    <td><a href="#modal_edit_party_<?php echo e($party->party_id); ?>" data-toggle="modal" data-target="#modal_edit_party_<?php echo e($party->party_id); ?>"
                            class="btn btn-info btn-xs btn-flat">Edit</a> <?php echo Form::open(['action'=>['PartyController@destroy',$party->party_id],'method'=>'POST','class'=>'floatit','enctype'=>'multipart/form-data']); ?> <?php echo e(Form::hidden('_method','DELETE')); ?>

                        <button type="submit" class="btn btn-danger btn-xs btn-flat" onClick="return confirm('Are you sure you want to delete this contract party?');">   <strong>  <i class="fa fa-close"></i></strong></button>                        <?php echo Form::close(); ?>

                    </td>
                    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modal_edit_party_<?php echo e($party->party_id); ?>">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <?php echo Form::open(['action'=>['PartyController@update',$party->party_id],'method'=>'POST','class'=>'form','enctype'=>'multipart/form-data']); ?>

                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">UPDATE CONTRACT PARTY</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <?php echo e(Form::label('party_name', 'Party Name')); ?><br>
                                            <div class="form-group">
                                                <?php echo e(Form::text('party_name', $party->party_name,['class'=>'form-control', 'placeholder'=>''])); ?>

                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <?php echo e(Form::label('address', 'Address')); ?><br>
                                            <div class="form-group">
                                                <?php echo e(Form::text('address', $party->address,['class'=>'form-control', 'placeholder'=>''])); ?>


                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <?php echo e(Form::label('email', 'Email')); ?><br>
                                            <div class="form-group">
                                                <?php echo e(Form::text('email', $party->email,['class'=>'form-control', 'placeholder'=>''])); ?>


                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <?php echo e(Form::label('telephone', 'Telephone')); ?><br>
                                            <div class="form-group">
                                                <?php echo e(Form::text('telephone', $party->telephone,['class'=>'form-control', 'placeholder'=>''])); ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                                <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-save"></i> Save Changes</button>
                            </div>
                                <?php echo e(Form::hidden('_method','PUT')); ?> <?php echo Form::close(); ?>

                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
</div>
<div class="modal fade" id="modal_new_party" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <?php echo Form::open(['action'=>'PartyController@store','method'=>'POST','class'=>'form','enctype'=>'multipart/form-data']); ?>

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">New Contract Party</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <?php echo e(Form::label('party_name', 'Party Name')); ?><br>
                        <div class="form-group">
                            <?php echo e(Form::text('party_name', '',['class'=>'form-control', 'placeholder'=>''])); ?>

                        </div>
                    </div>
                    <div class="col-md-6">

                        <?php echo e(Form::label('contact_person', 'Contact Person')); ?><br>
                        <div class="form-group">
                            <?php echo e(Form::text('contact_person', '',['class'=>'form-control', 'placeholder'=>''])); ?>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <?php echo e(Form::label('telephone', 'Telephone')); ?><br>
                        <div class="form-group">
                            <?php echo e(Form::text('telephone', '',['class'=>'form-control', 'placeholder'=>''])); ?>


                        </div>
                    </div>
                    <div class="col-md-4">
                        <?php echo e(Form::label('email', 'Email')); ?><br>
                        <div class="form-group">
                            <?php echo e(Form::text('email', '',['class'=>'form-control', 'placeholder'=>''])); ?>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <?php echo e(Form::label('address', 'Address')); ?><br>
                        <div class="form-group">
                            <?php echo e(Form::text('address', '',['class'=>'form-control', 'placeholder'=>''])); ?>

                        </div>
                    </div>
                </div>
            </div>
           <div class="modal-footer">
            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
            <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-check"></i> Create Contract Party</button>
        </div>

            <?php echo Form::close(); ?>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
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
        $('#example1').DataTable()
    //Initialize Select2 Elements
	<?php if(isset($_GET['new']) && $_GET['new']=='true'){ ?>
	$('#modal_new_party').modal('show');

	<?php } ?>

	 $(".records").DataTable();

	$('.select2').select2()
	 $('.issued_date').datepicker( {
	 	format: 'dd-mm-yyyy',
		orientation: "bottom",
		autoclose: true,
		 showDropdowns: true,

	 })
 })
</script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>