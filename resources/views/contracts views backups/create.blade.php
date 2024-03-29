@extends('adminlte::page')
@section('title', 'New Contract')
@section('content_header')
<h1>Contracts<small> Create contract</small></h1>
@stop
@section('content')
<div class="box box-success" style="font-size:10px;">
    <div class="box-header with-border">
        <h3 class="box-title">Create New Contract</h3>
    </div>
    <div class="box-body">
        <div class="col-md-12">

            {!! Form::open(['action'=>'ContractController@store','method'=>'POST','class'=>'form','enctype'=>'multipart/form-data'])
            !!}
            <div class="row">

                <div class="col-md-6">

                    {{Form::label('party_name', 'Party Name* ')}}
                    <div class="form-group">

                        <select id="party_name" class=" col-md-12 " required name="party_name"> </select>

                    </div>
                    <p>If you are not able to find the Contract Party Name/Supplier.
                        <a href="/party?new=true" target="_blank"><strong>Click here to capture the details</strong></a></p>
                </div>
                <div class="col-md-6">

                    {{Form::label('title', 'Contract Title* ')}}
                    <div class="form-group">

                        {{Form::text('title', '',['class'=>'form-control', 'required','placeholder'=>'The Contract Title'])}}

                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-md-6">

                    {{Form::label('effective_date', 'Effective Date* ')}}
                    <div class="form-group">

                        {{Form::text('effective_date', '',['class'=>'form-control issued_date','placeholder'=>'Effective Date','autocomplete'=>'off', 'readonly'])}}

                    </div>
                </div>

                <div class="col-md-6">
                    {{Form::label('contract_document', 'Upload Contract Document *')}}
                    <div class="form-group">
                        {{Form::file('contract_document',['class'=>'form-control', 'required', 'accept'=>'.doc , .docx , .pdf'])}}
                    </div>
                </div>

                <div class="col-md-12">
                    {{Form::label('description', 'Description')}}
                    <div class="form-group">
                        {{Form::textarea('description', '',['class'=>'form-control description','placeholder'=>'Contract description'])}}
                    </div>
                </div>
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Create New Contract</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<link rel="stylesheet" href="/css/bootstrap-datepicker.min.css">
@stop
@section('js')
<script src="/js/bootstrap-datepicker.min.js"></script>
<script>
    $(function () {
    //Initialize Select2 Elements

	$("#party_name").select2({
  ajax: {
    url: "/party/get_party",
	type:'GET',
    dataType: 'json',
    delay: 250,
    data: function (params) {
		console.log(params);
      return {
        q: params.term, // search term
        page: params.page
      };
    },
    processResults: function (data, params) {

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
  escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
  minimumInputLength: 3,
  templateResult: formatRepo,
  templateSelection: formatRepoSelection
});

function formatRepo (repo) {
 if (repo.loading) {
    return repo.text;
  }

  var markup =repo.text;

  return markup;
}

function formatRepoSelection (repo) {
  return repo.text ;
}
	 $('.issued_date').datepicker( {
	 	format: 'dd-mm-yyyy',
		orientation: "bottom",
		autoclose: true,
         showDropdowns: true,
         todayHighlight: true,
         toggleActive: true,
         startDate: new Date(),
         clearBtn: true,

	 })
 });

</script>
@stop
