@extends('layout.app')

@section('content')
<style>
  .form-group .control-label {
    background-color: #008841;
    width: 100%;
    padding: 3px 6px;
    color: #fff;
  }
  .btn.btn-primary {
    color: #fff;
    background-color: #008841;
    border-color: #008841;
}
.custom-control-label::before {

background-color: transparent;
}
.select2-container .select2-selection--single{
    height: 46px !important;
}
.select2-container--default .select2-selection--single .select2-selection__arrow{
    top: 13px !important;
}
/* .custom-checkbox .custom-control-label::before {
border-radius: transparent;
} */
</style>
{{-- stylesheet_link('vendors/datepicker.css') --}}
{{-- javascript_include("vendors/bootstrap-datepicker.js") --}}
{{-- javascript_include("js/report/reportscript.js") --}}
{{-- javascript_include("js/jquery.canvasjs.min.js") --}}
{{-- javascript_include("assets/scripts.js") --}}
{{-- stylesheet_link('css/select2.css') --}}
{{-- javascript_include("js/select2.min.js") --}}
{{-- javascript_include("js/monthly_report/english_to_bangla.js") }--}
{{-- javascript_include("js/monthly_report/country_based_report.js") --}}
{{-- javascript_include("js/monthly_report/demoMonthlyReport.js") --}}

<link rel="stylesheet" href="{{ asset('/mobile_court/cssmc/protibedon.css') }}">         
            <div class="card panel-default" style="margin-bottom: 20px">
                <div class="card-header" style="font-size: 20px">
                    অনুসন্ধানের উপাত্তসমূহ
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <div class="clearfix">
                                    <label class="control-label">প্রতিবেদনের নাম </label>
                                    <div class="form-group">
                                        <select id="reportList" name="reportList" class="input form-control" style="width: 100% !important;">
                                            <option value="">প্রতিবেদনের নাম নির্বাচন করুন...</option>
                                            <option value="1">মোবাইল কোর্টের মাসিক প্রতিবেদন</option>
                                            <option value="2">মোবাইল কোর্টের আপিল মামলার তথ্য</option>
                                            <option value="3">অতিরিক্ত জেলা ম্যাজিস্ট্রেট আদালতের  মামলার তথ্য</option>
                                            <option value="4">এক্সিকিউটিভ ম্যাজিস্ট্রেট আদালতের মামলার তথ্য</option>
                                            <option value="5">এক্সিকিউটিভ ম্যাজিস্ট্রেটের আদালত পরিদর্শন</option>
                                            <option value="6">মোবাইল কোর্ট কেস রেকর্ড পর্যালোচনা</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="control-label">বিবেচ্য মাস </label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                    <input type="text" class="form-control common_datepicker" placeholder="মাস  নির্বাচন করুন ..."  id="report_date" name="report_date" required="true"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary float-right" style="margin-right:27px" type="submit"  onclick="pendingReportList.getReportDetails()">অনুসন্ধান </button>
                </div>


                <div class="card-body p-15 cpv">

                    <div id="printDemoReport">

                        {{-- stylesheet_link('css/protibedon.css') --}}
                        <div class="form_top_title">
                            <table style="width: 100%">
                                <tr>
                                    <td style="padding: 10px; font-size: larger" colspan="3" class="centertext"><b><span id="report_name_mbl"> প্রতিবেদনের  নাম </span></b></td>
                                </tr>
                            </table>
                        </div>
                        <div class="form_top_title">

                        </div>

                        <table id='ReportTable' border="1" style="border-collapse:collapse;" cellpadding="2px"
                            cellspacing="2px" width="100%">

                        </table>
                    </div>

                </div>
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel"> নতুন বার্তা</h5>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <input type="hidden" id="divId" value="">
                                    <input type="hidden" id="zillaId" value="">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">গ্রহীতা:</label>
                                        <div class="col-sm-12">
                                            <div class="custom-control custom-checkbox">
                                                <input value="34" type="checkbox" class="notificationProfile" id="notificationProfile1">
                                                <label class="custom-control-label" for="notificationProfile1">বিভাগীয় কমিশনার</label>
                                            </div>
                            
                                            <div class="custom-control custom-checkbox">
                                                <input value="38" type="checkbox" class="notificationProfile" id="notificationProfile3">
                                                <label class="custom-control-label" for="notificationProfile3">অতিরিক্ত জেলা ম্যাজিস্ট্রেট</label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input value="37" type="checkbox" class="notificationProfile" id="notificationProfile4">
                                                <label class="custom-control-label" for="notificationProfile4">জেলা প্রশাসক</label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input value="27" type="checkbox" class="notificationProfile" id="notificationProfile5">
                                                <label class="custom-control-label" for="notificationProfile5">সহকারী কমিশনার - জুডিসিয়াল মুন্সিখানা (এসি-জেএম)
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label"> বার্তা:</label>
                                        <textarea style="height:150px;" maxlength="160" class="form-control" id="message-text"></textarea>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"> বাতিল</button>
                                <button type="button" class="btn btn-primary" onclick="pendingReportList.sendMessage()">বার্তা প্রেরণ</button>
                            </div>
                        </div>
                    </div>  
                </div>
            </div>
@endsection

@section('scripts')
<script>
    document.getElementById('notificationProfile4').addEventListener('click', function() {
    console.log('Checkbox clicked. Checked state:', this.checked);
    });
    document.getElementById('notificationProfile5').addEventListener('click', function() {
    console.log('Checkbox clicked. Checked state:', this.checked);
    });
    document.getElementById('notificationProfile3').addEventListener('click', function() {
    console.log('Checkbox clicked. Checked state:', this.checked);
    });
    
    document.getElementById('notificationProfile1').addEventListener('click', function() {
    console.log('Checkbox clicked. Checked state:', this.checked);
    });
</script>
    {{--  var checkout = $('#common_datepicker').datepicker({
        format: "mm-yyyy",
        viewMode: "months",
        minViewMode: "months",
        changeMonth: true,
        changeYear: true
    }) --}}
    <script src="{{ asset('js/pages/crud/forms/widgets/bootstrap-datepicker.js') }}"></script>
    <script>
        // common datepicker
        $('.common_datepicker').datepicker({
            format: "mm-yyyy",
            viewMode: "months",
            minViewMode: "months",
            changeMonth: true,
            changeYear: true
        });
    </script>

<script src="{{ asset('/mobile_court/javascripts/source/report/reportscript.js') }}"></script>
<script src="{{ asset('/mobile_court/javascripts/source/monthly_report/english_to_bangla.js') }}"></script>
<script src="{{ asset('/mobile_court/javascripts/source/monthly_report/country_based_report.js') }}"></script>
<script src="{{ asset('/mobile_court/javascripts/source/monthly_report/demoMonthlyReport.js') }}"></script>

<script src="{{ asset('/mobile_court/javascripts/source/misNotification/pendingReportList.js') }}"></script>
<script src="{{ asset('/mobile_court/javascripts/source/misNotification/misNotification.js') }}"></script>
@endsection