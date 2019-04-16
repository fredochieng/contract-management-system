@extends('adminlte::page')
@section('title', 'My Contracts')
@section('content_header')
<h1>
    My Contracts
    <a href="/contract/create" class="btn btn-xs btn-info pull-right btn-flat">NEW CONTRACT</a>
</h1>
@stop
@section('content')
<style>
    .description {
        height: 90px !important
    }
</style>
@if (session('update'))
<div class="alert alert-success alert-dismissable custom-success-box" style="margin: 15px;">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong> {{ session('update') }} </strong>
</div>
@endif
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
                @foreach($my_contracts as $key=>$my_contract)
                <tr>
                    <td>{{ $key+1}}</td>
                    <td><a href="/contract/{{$my_contract->contract_id}}/view">{{$my_contract->contract_title}}</a></td>
                    <td>{{$my_contract->party_name}}</td>
                    <td><a href="/{{$my_contract->draft_file}}" target="_blank"><i class="fa fa-fw fa-download"></i> Contract</a>                        |
                        <a href="/{{$my_contract->draft_file}}" target="_blank"><i class="fa fa-fw fa-download"></i> CRF</a>
                    </td>
                    <td>{{date("d-m-Y",strtotime($my_contract->effective_date))}}</td>
                    <td>{{date("d-m-Y",strtotime($my_contract->expiry_date))}}</td>
                    <td><span class="pull-right-container">
                        @if($my_contract->contract_status == 'created')
                        <small class="label pull-center btn-warning">{{$my_contract->contract_status}}</small></span>
                        @elseif($my_contract->contract_status
                        == 'published')
                        <small class="label pull-center btn-info">{{ $my_contract->contract_status}}</small></span>
                        @elseif($my_contract->contract_status== 'submitted')
                        <small class="label label-success">{{$my_contract->contract_status}}</small></span>
                        @elseif($my_contract->contract_status== 'ammended')
                        <small class="label pull-center btn-danger">{{$my_contract->contract_status}}</small></span>
                        @elseif($my_contract->contract_status== 'approved')
                        <small class="label pull-center btn-success">{{$my_contract->contract_status}}</small></span>
                        @elseif($my_contract->contract_status== 'terminated')
                        <small class="label pull-center btn-danger">{{$my_contract->contract_status}}</small></span>
                    </td>
                    @endif
                    </td>
                    <td>
                       @if (auth()->check()) @if(auth()->user()->isUser() && ($my_contract->contract_status
                        == 'created' || $my_contract->contract_status == 'ammended'))
                        <a href="/contract/{{$my_contract->contract_id}}/edit">
                                <span class = "fa fa-pencil bigger"></span></center></a> @else

                        <a href="/contract/{{$my_contract->contract_id}}/view">
                                                                    <span class = "fa fa-eye bigger"></span></center></a>
                                                                    @endif @endif {!! Form::open(['action'=>['ContractController@destroy',$my_contract->contract_id],'method'=>'POST','class'=>'floatit','enctype'=>'multipart/form-data'])
                        !!} {{Form::hidden('_method','DELETE')}} {{-- <button type="submit" class="btn btn-danger btn-xs btn-flat"
                            onClick="return confirm('Are you sure you want to delete this contract?');">   <strong>  <i class="fa fa-close"></i></strong></button>                        --}}
                        <a class="delete" data-id="{{ $my_contract->contract_id }}" href="javascript:void(0)">
                                <span style="color:red;" class = "fa fa-trash bigger"></span></a>
                    </td>
                    {!! Form::close() !!}
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>




@stop
@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<link rel="stylesheet" href="/css/bootstrap-datepicker.min.css">
@stop
@section('js')

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
@stop
