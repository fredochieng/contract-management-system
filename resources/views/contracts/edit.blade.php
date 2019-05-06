@extends('adminlte::page')
@section('title', 'Edit Contract')
@section('content_header')
<h1>Contracts<small> Edit Contract</small></h1>
@stop
@section('content')
<style>
    .description {
        height: 90px !important
    }
</style>

<div class="box box-success" style="font-size:10px;">
    <div class="box-header with-border">
        <h3 class="box-title">&nbsp;&nbsp;&nbsp; Edit Contract</h3>
    </div>
    <div class="box-body">
        <div class="col-md-12">

            {!!
            Form::open(['action'=>['ContractController@update',$contract->contract_id],'method'=>'POST','class'=>'form','enctype'=>'multipart/form-data'])
            !!}

            <div class="row">

                <div class="col-md-6">

                    {{Form::label('party_name', 'Party Name* ')}}
                    <div class="form-group">
                        <select id="party_name" class="form-control" name="party_name">
                            <option value="{{$contract->party_name_id}}" selected>{{$contract->party_name}}</option>

                        </select>
                    </div>

                    <p>If you are not able to find the Contract Party Name/Supplier.
                        <a href="/party?new=true" target="_blank"><strong>Click here to capture the details</strong></a>
                    </p>

                </div>
                <div class="col-md-6">

                    {{Form::label('title', 'Contract Title* ')}}
                    <div class="form-group">

                        {{Form::text('title',$contract->contract_title,['class'=>'form-control','placeholder'=>'The contract Title'])}}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">

                    {{Form::label('effective_date', 'Effective Date* ')}}
                    <div class="form-group">

                        {{Form::text('effective_date', date("m-d-Y",strtotime($contract->effective_date)),['class'=>'form-control issued_date','placeholder'=>'Effective
                        date','autocomplete'=>'off'])}}

                    </div>
                </div>

                <div class="col-md-6">

                    @if($contract->draft_file) <a href="{{$contract->draft_file}}"><strong>Download</strong></a> @endif {{Form::label('contract_document',
                    'Upload Contract Document *')}}

                    <div class="form-group">
                        {{Form::file('contract_document',['class'=>'form-control'])}}
                    </div>
                </div>

                <div class="col-md-12">

                    {{Form::label('description', 'Description')}}

                    <div class="form-group">
                        {{Form::textarea('description', $contract->description,['class'=>'form-control description','placeholder'=>'Fully Describe
                        your contract here for clarifications'])}}
                    </div>
                </div>

                <div class="col-md-12">
                    <button type="submit" class="btn btn-success"><i class="fa fa-save fa-fw"></i> Save Changes</button>
                </div>

                {{Form::hidden('_method','PUT')}} {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@include('page.footer')
@stop
@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<link rel="stylesheet" href="/css/bootstrap-datepicker.min.css">
@stop
@section('js')
<script src="/js/bootstrap-datepicker.min.js"></script>

<script>
    $(function() {
    //Initialize Select2 Elements
    $("#party_name").select2({
        ajax: {
            url: "/party/get_party",
            type: 'GET',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                console.log(params);
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function(data, params) {
                params.page = params.page || 1;
                var retVal = [];
                $.each(data, function(index, element) {
                    var lineObj = {
                        id: element.id,
                        text: element.text
                    }
                    retVal.push(lineObj);
                });

                return {
                    results: retVal,
                    pagination: {
                        more: (params.page * 30) < data.total_count
                    }
                };
            },
            cache: true
        },
        placeholder: 'Select the contract Party/Supplier',
        escapeMarkup: function(markup) {
            return markup;
        }, // let our custom formatter work
        minimumInputLength: 3,
        templateResult: formatRepo,
        templateSelection: formatRepoSelection
    });

    function formatRepo(repo) {
        if (repo.loading) {
            return repo.text;
        }

        var markup = repo.text;

        return markup;
    }

    function formatRepoSelection(repo) {
        return repo.text;
    }
    $('.issued_date').datepicker({
        format: 'dd-mm-yyyy',
        orientation: "bottom",
        autoclose: true,
        showDropdowns: true,

    })
})

</script>
@stop
