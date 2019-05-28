<?php $__env->startSection('title', 'Wananchi Legal | New Contract Request'); ?>
<?php $__env->startSection('content_header'); ?>
<h1>Contracts<small> New contract request</small></h1>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">New Contract Request</h3>
    </div>
    <div class="box-body">
        <div class="col-md-12">

            <?php echo Form::open(['action'=>'ContractController@store','method'=>'POST','class'=>'form','enctype'=>'multipart/form-data']); ?>

            <div class="row">

                <div class="col-md-6">

                    <?php echo e(Form::label('party_name', 'Party Name* ')); ?>

                    <div class="form-group">

                        <select id="party_name" class=" col-md-12 " required name="party_name"> </select>

                    </div>
                    <p>If you are not able to find the Contract Party Name/Supplier.
                        <a href="/party?new=true" target="_blank"><strong>Click here to capture the details</strong></a>
                    </p>
                </div>
                <div class="col-md-6">

                    <?php echo e(Form::label('title', 'Contract Title* ')); ?>

                    <div class="form-group">

                        <?php echo e(Form::text('title', '',['class'=>'form-control', 'required','placeholder'=>'The Contract Title'])); ?>


                    </div>
                </div>
            </div>
            <div class="row">
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="warranty_months">Contract Term</label>
                        <div class="input-group">
                            <input type="number" required class="form-control" name="term_id">
                            <span class="input-group-addon">months</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Contract Renewal Type</label>
                        <select class="form-control select2" name="renewal_id" required style="width: 100%;" tabindex="-1" aria-hidden="true">
                            <option selected="selected">Please select contract renewal type</option>
                            <?php $__currentLoopData = $renewal_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($row->id); ?>"><?php echo e($row->renewal_type); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <?php echo e(Form::label('contract_document', 'Upload Contract/Service Order Form(SOF)*')); ?>

                    <div class="form-group">
                        <?php echo e(Form::file('contract_document',['class'=>'form-control', 'required', 'accept'=>'.doc , .docx , .pdf'])); ?>

                    </div>
                </div>

                <div class="col-md-4">
                    <?php echo e(Form::label('contract_document', 'Upload CAF Document')); ?>

                    <div class="form-group">
                        <?php echo e(Form::file('caf_document',['class'=>'form-control', 'accept'=>'.doc , .docx , .pdf'])); ?>

                    </div>
                </div>

 <div class="col-md-4">
   <?php echo e(Form::label('Upload Supporting Documents')); ?>

             <div class="input-group control-group increment" >
          <input type="file" name="filename[]" required class="form-control">
          <div class="input-group-btn">
            <button class="btn btn-success" type="button"><i class="glyphicon glyphicon-plus"></i>Add</button>
          </div>
        </div>
        <div class="clone hide">
          <div class="control-group input-group" style="margin-top:10px">
            <input type="file" name="filename[]" class="form-control">
            <div class="input-group-btn">
              <button class="btn btn-danger" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
            </div>
          </div>
        </div>
        </div>

                <div class="col-md-12">
                    <?php echo e(Form::label('description', 'Description')); ?>

                    <div class="form-group">
                        <?php echo e(Form::textarea('description', '',['class'=>'form-control description',
                        'placeholder'=>'Summary of the contract, contract terms, nature of the services, payment terms, commencement dates, terminations'])); ?>

                    </div>
                </div>
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Create
                        Request</button>
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
<script src="/js/select2.full.min.js"></script>
<script>
    $(function () {
        $(".btn-success").click(function(){
          var html = $(".clone").html();
          $(".increment").after(html);
      });

      $("body").on("click",".btn-danger",function(){
          $(this).parents(".control-group").remove();
      });
    //Initialize Select2 Elements
$(".select2").select2();
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>