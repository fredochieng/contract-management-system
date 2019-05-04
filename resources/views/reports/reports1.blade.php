@extends('adminlte::page')
@section('title', 'CMS | Manage Reports')
@section('content_header')
<h1 class="pull-left">Reports<small>Manage Reports</small></h1>
<div style="clear:both"></div>
@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Timesheet</h3>
            </div><!-- /.box-header -->
            <?php
            $report_type = 'status';
            $report_type1 = 'contract_type';
            $report_type2 = 'contract_party';

            ?>
        {!!
        Form::open(['action'=>['ReportController@show' , $report_type ],
        'method'=>'GET','class'=>'form','enctype'=>'multipart/form-data',
        'target'=>'_blank'])
        !!}
            <div class="box-body">
                <p>Generate a report based on the status in the selected period.</p>
                <div class="form-group">
                    <label>Contract Status</label>
                    <select class="form-control select2" name="status_id" style="width: 100%;" tabindex="-1"
                        aria-hidden="true">
                        <option selected="selected">Please select contract status</option>
                        @foreach ( $status as $row )
                        <option value="{{ $row->status_id }}">{{ $row->status_name }}</option>
                        @endforeach
                    </select>
                </div>

                {{Form::label('Start Date* ')}}
                <div class="form-group">
                    {{Form::text('start_date', '',['class'=>'form-control start_date',
                        'placeholder'=>'Start Date','autocomplete'=>'off', 'required']
                         )}}
                </div>
                {{Form::label('End Date* ')}}
                <div class="form-group">
                    {{Form::text('end_date', '',['class'=>'form-control start_date',
                                            'placeholder'=>'End Date','autocomplete'=>'off', 'required']
                                             )}}
                </div>
            </div>
            <input type="hidden" name="report" value="status">
            <input type="hidden" name="route" value="reports/view">
            <div class="box-footer"><button type="submit" class="btn btn-primary btn-flat">Generate
                    Report</button>
            </div>
            {!! Form::close() !!}
        </div>
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Other Reports</h3>
            </div><!-- /.box-header -->
            <div class="box-body">

                <p><a href="" class="btn btn-default btn-flat">Users (Detailed List)</a></p>
                <p><a href="" class="btn btn-default btn-flat">Legal Counsel (Detailed List)</a></p>

                <p></p>
            </div>

        </div>


    </div>

    <div class="col-md-6">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Contract Type Report</h3>
            </div><!-- /.box-header -->
            {!!
            Form::open(['action'=>['ReportController@show' , $report_type1],
            'method'=>'GET','class'=>'form','enctype'=>'multipart/form-data',
            'target'=>'_blank'])
            !!}
            <div class="box-body">
                <p>Generate a report of contract types.</p>
                <div class="form-group">
                    <label>Contract Type</label>
                    <select class="form-control select2" name="contract_type_id" style="width: 100%;" tabindex="-1"
                        aria-hidden="true">
                        <option selected="selected">Please select contract type</option>
                        @foreach ( $contract_types as $row )
                        <option value="{{ $row->contract_type_id }}">{{ $row->contract_type_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <input type="hidden" name="report" value="contract_type">
            <input type="hidden" name="route" value="reports/view">
            <div class="box-footer"><button type="submit" class="btn btn-primary btn-flat">Generate Report</button>
            </div>
            {!! Form::close() !!}
        </div>


        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Contracting Party Report</h3>
            </div><!-- /.box-header -->
           {!!
        Form::open(['action'=>['ReportController@show' , $report_type2 ],
        'method'=>'GET','class'=>'form','enctype'=>'multipart/form-data',
        'target'=>'_blank'])
        !!}
            <div class="box-body">
                <p>Generate a report of contracting parties.</p>
                <div class="form-group">
                    <label>Contract Type</label>
                    <select class="form-control select2" name="status_id" style="width: 100%;" tabindex="-1"
                        aria-hidden="true">
                        <option selected="selected">Please select contract type</option>
                        @foreach ( $parties as $row )
                        <option value="{{ $row->party_id }}">{{ $row->party_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <input type="hidden" name="report" value="party">
            <input type="hidden" name="route" value="reports/view">
            <div class="box-footer"><button type="submit" class="btn btn-primary btn-flat">Generate Report</button>
            </div>
            {!! Form::close() !!}
        </div>

    </div>
</div>












































@stop

































































































































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
        $(".select2").select2();
        $('.start_date').datepicker( {
        format: 'dd-mm-yyyy',
        orientation: "bottom",
        autoclose: true,
        showDropdowns: true,
        todayHighlight: true,
        toggleActive: true,
        startDate: new Date(),
        clearBtn: true,

        })
        $('#example1').DataTable()
        $('#example2').DataTable()
        $('#example3').DataTable()
        $('#example4').DataTable()
    });
</script>






































































































































































































@stop
