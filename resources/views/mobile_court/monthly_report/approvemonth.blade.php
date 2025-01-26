@extends('layout.app')

@section('content')
<!-- monthly_report/approved -->
@if (session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif
@if (session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

<form method="post" action="{{ route('m.approved')}}" autocomplete="off">
@csrf
<div class="card panel-default">
    <div class="card-header smx ">
        <h2 class="card-title">প্রতিবেদন</h2>
    </div>

    <div class="card-body cpv p-15">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="form-group">
                    <label class="control-label">প্রতিবেদন দাখিলের সময়</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                        <input type="text" class="form-control" placeholder="mm-yyyy" id="report_approve_date" name="report_approve_date" required="true" />
                    </div>
                </div>
                {{-- submit_button("অনুসন্ধান", "class": "btn btn-primary pull-right") --}}
                <input type="submit" value="অনুসন্ধান" class="btn btn-primary pull-right">
            </div>
        </div>
    </div>
    
</div>
</form>


{{-- stylesheet_link('vendors/datepicker.css') --}}
{{-- javascript_include("vendors/bootstrap-datepicker.js") --}}
@endsection
@section('scripts')

<script>

    jQuery(document).ready(function () {


        var checkout = $('#report_approve_date').datepicker({
            format: "mm-yyyy",
            viewMode: "months",
            minViewMode: "months",
            changeMonth: true,
            changeYear: true
        }).on('changeDate',function (ev) {
            checkout.hide();
        }).data('datepicker');

    });
</script>

@endsection