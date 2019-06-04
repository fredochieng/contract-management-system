<div class="modal fade" id="modal_delete_contract_{{$pending_contract->contract_id}}">
            <div class="modal-dialog">
                <div class="modal-content">
                    {!! Form::open(['action'=>['ContractController@deleteCreatedContract', $pending_contract->contract_id],'method'=>'POST','class'=>'floatit','enctype'=>'multipart/form-data'])
                    !!} {{Form::hidden('_method','DELETE')}}
                    <!-- <input type="hidden" name='contract' value="{{$pending_contract->contract_id}}"> -->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Delete Contract</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                            {{Form::text('contract_id',$pending_contract->contract_id,['class'=>'form-control hidden','placeholder'=>'The contract Title'])}}
                                <p>Are you sure you want to delete the contract <b>{{$pending_contract->contract_code}}</b>?</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> No</button>
                        <button type="submit" class="btn btn-danger btn-flat"><i class="fa fa-check"></i> Yes</button>
                    </div>
                    {!! Form::close() !!}
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
