<div class="modal fade" id="modal_share_final_execution" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            {!!
            Form::open(['action'=>'ContractController@shareFinalExecution', $contract->contract_id,'method'=>'POST','class'=>'form','enctype'=>'multipart/form-data'])
            !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Share Final Execution Version (<span style="font-weight:bolder">{{$contract->contract_code}}</span>) for sign off</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        {{Form::text('contract_id',$contract->contract_id,['class'=>'form-control hidden','placeholder'=>'The contract Title'])}}
                        {{Form::label('Upload Final Execution Version')}}
                            <div class="form-group">
                                {{Form::file('final_execution_version',['class'=>'form-control', 'required'])}}
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
                <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-check"></i> Send
                    </button>
            </div>
            {!! Form::close() !!}
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>