<div class="modal fade" id="modal_user_comment_final" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php echo Form::open(['action'=>'ContractController@commentFinalDraft', $contract->contract_id,'method'=>'POST','class'=>'form','enctype'=>'multipart/form-data']); ?>

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Comment on Final Contract (<span style="font-weight:bolder"><?php echo e($contract->contract_code); ?></span>)</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo e(Form::text('contract_id',$contract->contract_id,['class'=>'form-control hidden','placeholder'=>'The contract Title'])); ?>

                        <?php echo e(Form::label('comments', 'Comments')); ?><br>
                        <div class="form-group">
                            <?php echo e(Form::textarea('comments', '',['class'=>'form-control', 'placeholder'=>'Comments are optional'])); ?>

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i>
                    Cancel</button>
                <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-check"></i> Comment
                    </button>
            </div>
            <?php echo Form::close(); ?>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
