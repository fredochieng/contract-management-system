<?php $__env->startSection('title', 'New Contract'); ?>

<?php $__env->startSection('content_header'); ?>
  <h1>New Contract</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  <style>
  	.description{height:90px !important}
  </style>
            <div class="box">

                <div class="box-body">
                <div class="col-md-8">

             <?php echo Form::open(['action'=>'ContractController@store','method'=>'POST','class'=>'form','enctype'=>'multipart/form-data']); ?>

                <div class="row">

                <div class="col-md-12">

                    	<?php echo e(Form::label('party_name', 'Party Name* ')); ?>

                         <div class="form-group">

                            <select id="party_name"  class="form-control" required name="party_name"> </select>

                        </div>
                        <p>If you are not able to find the Contract Party Name/Supplier.
                         <a href="/admin/party?new=true" target="_blank"><strong>Click here to capture the details</strong></a></p>
                        <br>
            	   </div>
               <div class="col-md-12">

                    	<?php echo e(Form::label('title', 'Contract Title* ')); ?>

                         <div class="form-group">

                             <?php echo e(Form::text('title', '',['class'=>'form-control', 'required','placeholder'=>'The Contract Title'])); ?>


                        </div>
            	   </div>

                     <div class="col-md-6">

                    	<?php echo e(Form::label('effective_date', 'Effective Date* ')); ?>

                         <div class="form-group">

                             <?php echo e(Form::text('effective_date', '',['class'=>'form-control issued_date','placeholder'=>'Effective Date','autocomplete'=>'off'])); ?>


                        </div>
            	   </div>

                     <div class="col-md-6">

                    	<?php echo e(Form::label('expiry_date', 'Expiry Date ')); ?>

                         <div class="form-group">

                             <?php echo e(Form::text('expiry_date', '',['class'=>'form-control issued_date','placeholder'=>'Expiry Date', 'autocomplete'=>'off'])); ?>

                        </div>
            	   </div>

                    <div class="col-md-6">

               			  <?php echo e(Form::label('contract_document', 'Upload Contract Document *')); ?>


                         <div class="form-group">
                             <?php echo e(Form::file('contract_document',['class'=>'form-control', 'required'])); ?>

                        </div>
                  </div>

                   <div class="col-md-6">
               			  <?php echo e(Form::label('contract_crf', 'Upload Contract CRF (optional)')); ?>


                         <div class="form-group">
                             <?php echo e(Form::file('contract_crf',['class'=>'form-control'])); ?>

                        </div>
                  </div>

                   <div class="col-md-12">
               			  <?php echo e(Form::label('description', 'Description')); ?>

                         <div class="form-group">
                             <?php echo e(Form::textarea('description', '',['class'=>'form-control description','placeholder'=>'Fully Describe your contract here for clarifications'])); ?>

                        </div>
                  </div>
             <div class="col-md-12">

             <button type="submit" class="btn btn-primary btn-flat" name="update_status">CREATE NEW CONTRACT </button>
             </div>
              <?php echo Form::close(); ?>

            </div>
            </div>
        </div>
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

	 })
 })
	 </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>