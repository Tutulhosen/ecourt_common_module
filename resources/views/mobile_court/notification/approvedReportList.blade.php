@extends('layout.app')

@section('content')
{{-- stylesheet_link('vendors/datepicker.css') --}}
{{-- javascript_include("vendors/bootstrap-datepicker.js") }}
{{-- javascript_include("js/report/reportscript.js") --}}
{{-- javascript_include("js/jquery.canvasjs.min.js") --}}
{{-- javascript_include("assets/scripts.js") --}}
{{-- stylesheet_link('css/select2.css') --}}
{{-- javascript_include("js/select2.min.js") --}}
{{-- javascript_include("js/monthly_report/english_to_bangla.js") --}}
{{-- javascript_include("js/monthly_report/country_based_report.js") --}}
{{-- javascript_include("js/monthly_report/demoMonthlyReport.js") --}}
<link rel="stylesheet" href="{{ asset('/mobile_court/cssmc/protibedon.css') }}">   
<style>
    .btn.btn-primary {
        color: #fff;
        background-color: #21740c;
        border-color: #21740c;
    }
    .select2-container .select2-selection--single{
        height: 46px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow{
        top: 13px !important;
    }
</style>
<div class="card panel-default" style="margin-bottom: 20px">
    <div class="card-header smx">
        <h4 class="card-title"> অনুসন্ধানের উপাত্তসমূহ</h4>
    </div>
    <div class="card-body p-15 cpv">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                    <div class="clearfix">
                        <label class="control-label">প্রতিবেদনের নাম </label>
                        <div class="form-group">
                            <select id="reportList" name="reportList" class="input" style="width: 100% !important;">
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
                        <input type="text" class="form-control" placeholder="মাস  নির্বাচন করুন ..."  id="report_date" name="report_date" required="true"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button class="btn btn-success float-right" style="margin-right:27px" type="submit"  onclick="approvedReportList.getReportDetails()">অনুসন্ধান </button>
    </div>


    <div class="card-body p-15 cpv">

        <div id="printDemoReport">

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
</div>
@endsection
@section('scripts')
<script src="{{ asset('/mobile_court/javascripts/source/report/reportscript.js') }}"></script>
<script src="{{ asset('/mobile_court/javascripts/source/monthly_report/english_to_bangla.js') }}"></script>
<script src="{{ asset('/mobile_court/javascripts/source/monthly_report/country_based_report.js') }}"></script>
<script src="{{ asset('/mobile_court/javascripts/source/monthly_report/demoMonthlyReport.js') }}"></script>

<script src="{{ asset('/mobile_court/javascripts/source/misNotification/approvedReportList.js') }}"></script>
@endsection