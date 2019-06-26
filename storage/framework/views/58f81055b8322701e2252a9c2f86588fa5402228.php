<div class="modal fade" id="modal_classify_contract" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php echo Form::open(['action'=>'ContractController@classifyContract', $contract->contract_id,'method'=>'POST','class'=>'form','enctype'=>'multipart/form-data']); ?>

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Classify Contract Request</h4>
            </div>

            <div class="modal-body">
                <div class="row">
                 <?php echo e(Form::text('contract_id',$contract->contract_id,['class'=>'form-control hidden','placeholder'=>'The contract Title'])); ?>

                <div class="col-md-12">
                   <div class="form-group">
                    <select class="form-control select2" required name="contract_type_id" style="width: 100%;" tabindex="-1"
                        aria-hidden="true">
                                            <option value="">Please select contract type</option>
                                            <?php $__currentLoopData = $contract_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($row->contract_type_id); ?>"><?php echo e($row->contract_type_name); ?>

                                            </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i>
                    Cancel</button>
                <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-check"></i>Classify
                    Contract</button>
            </div>
            <?php echo Form::close(); ?>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
