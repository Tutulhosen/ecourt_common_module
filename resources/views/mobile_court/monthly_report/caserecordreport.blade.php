
@extends('layout.app')
@section('content')
@if (session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif
@if (session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif
<form method="post" autocomplete="off">
@csrf
<input type="hidden" id="id" name="id" value="">
<input type="hidden" id="report_type_id" name="report_type_id" value="6"/>

    <div class="card panel-default">
        <div class="card-header smx">
            <h4 class="card-title">
                মোবাইল কোর্ট কেস রেকর্ড পর্যালোচনা সংক্রন্ত প্রতিবেদন
            </h4>
        </div>
        <div class="card-body cpv ">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">প্রতিবেদন দাখিলের সময়</label>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                            <input type="text" class="form-control" placeholder="mm-yyyy" id="report_date"
                                   name="report_date"
                                   required="true"/>
                        </div>
                    </div>
                </div>

                <div id="reportdiv" style="display: none;margin-top:40px">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label">
                                    কেস রেকর্ড পর্যালোচনা প্রমাপ</label>
                                    <input type="text" id="caserecord_promap" name="caserecord_promap" class="input
                                    form-control" onchange="showTotalcase(this.value)" readonly="readonly">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label">কেস রেকর্ড পর্যালোচনা সংখ্যা</label>
                                <input type="number" id="caserecord_count" name="caserecord_count" class="input
                                form-control" onchange="showTotalcase(this.value)">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label">প্রমাপ অর্জন হয়েছে কিনা</label>
                                <input type="radio" id="commentyes" name="comment1" value="1" checked/> প্রমাপ অর্জিত
                                হয়েছে
                                <input type="radio" id="commentno" name="comment1" value="2"/> প্রমাপ অর্জিত হয়নি
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">মন্তব্য</label>
                                <textarea id="comment2" name="comment2" class="input form-control" cols="50" rows="4" spellcheck="false"></textarea>
                            </div>
                        </div>
                    </div>
                    <div id="adm_comment" class="row hidden d-none">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">এ ডি এম - এর মন্তব্য</label>
                                <p class="form-control" id="comment_from_adm"></p>
                            </div>
                        </div>
                    </div>
                    <!-- form-group -->
                    <div class="panel-footer">
                     
                        <div class="pull-right">
                            <button class="btn btn-success mr5" type="submit" id="btn_submit">সংরক্ষণ করুন</button>
                        </div>
                    </div>
                    <!-- panel-footer -->
                </div>
            </div>
        </div>
    </div>
</form>

<div id="messageModal">
    @include('message.partials.message')
</div>

@endsection

@section('scripts')
<script src="{{ asset('/mobile_court/javascripts/source/report/common.js') }}"></script>
 
<script>

    function showTotalcase(sel) {
        var totalcase = "#case_total";
        var case_manual = document.getElementById("case_manual");
        var case_system = document.getElementById("case_system");

        var totalcase_str = parseInt(case_manual.value) + parseInt(case_system.value);
        $(totalcase).val(totalcase_str);
    }

    function showTotalfine(sel) {
        var totalfine = "#fine_total";
        var fine_manual = document.getElementById("fine_manual");
        var fine_system = document.getElementById("fine_system");

        var totalfine_str = parseInt(fine_manual.value) + parseInt(fine_system.value);
        $(totalfine).val(totalfine_str);
    }
    function showTotalcriminal(sel) {
        var totalcriminal = "#criminal_total";
        var criminal_manual = document.getElementById("criminal_manual");
        var criminal_system = document.getElementById("criminal_system");

        var totalcriminal_str = parseInt(criminal_manual.value) + parseInt(criminal_system.value);
        $(totalcriminal).val(totalcriminal_str);
    }

</script>
@endsection