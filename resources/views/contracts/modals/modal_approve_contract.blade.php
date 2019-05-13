<div class="modal fade" id="modal_approve_contract" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            {!!
            Form::open(['action'=>'ContractController@approve', $contract->contract_id,'method'=>'POST','class'=>'form','enctype'=>'multipart/form-data'])
            !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Approve Contract (<span style="font-weight:bolder">{{$contract->contract_code}}</span>) For Signature</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        {{Form::text('contract_id',$contract->contract_id,['class'=>'form-control hidden','placeholder'=>'The contract Title'])}}
                        <div class="form-group" required=''>
                        <h>Classify the contract</h><br /><br />
                            <label><input type="radio" name="contract_type" value="1" required
                                    class="flat-red">&nbsp;&nbsp; Standard</label>&nbsp;&nbsp;
                            <label><input type="radio" name="contract_type" value="2" class="flat-red">&nbsp;&nbsp; Non
                                Standard</label>
                        </div>
                        {{Form::label('approved_contract_document', 'Upload Approved Contract Document (optional)')}}

                            <div class="form-group">
                                {{Form::file('approved_contract_document',['class'=>'form-control'])}}
                            </div>
                        {{Form::label('comments', 'Comments (optional)')}}<br>
                        <div class="form-group">
                            {{Form::textarea('comments', '',['class'=>'form-control', 'placeholder'=>'Comments are optional'])}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i>
                    Cancel</button>
                <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-check"></i> Approve
                    Contract</button>
            </div>
            {!! Form::close() !!}
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
