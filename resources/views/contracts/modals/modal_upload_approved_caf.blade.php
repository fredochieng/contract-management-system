<div class="modal fade" id="modal_upload_approved_caf">
    <div class="modal-dialog">
        <div class="modal-content">
            {!!
            Form::open(['action'=>'ContractController@uploadApprovedCAF','method'=>'POST','class'=>'form','enctype'=>'multipart/form-data'])
            !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Share Approved CAF
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        {{Form::text('contract_id',$contract->contract_id,['class'=>'form-control hidden','placeholder'=>'The contract Title'])}}
                        <div class="col-md-12">
                            {{Form::label('Share Approved CAF with user *')}}
                            <div class="form-group">
                                {{ Form::file('approved_caf',['class'=>'form-control', 'required', 'accept'=>'.doc , .docx , .pdf'])}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i>
                    Cancel</button>
                <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-check"></i> Share Approved CAF
                    </button>
            </div>
            {!! Form::close() !!}
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
