@extends('layout.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('/mobile_court/cssmc/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('/mobile_court/cssmc/jquery.alerts.css') }}">
    <link rel="stylesheet" href="{{ asset('/mobile_court/cssmc/monthly_report_table.css') }}">
    <link rel="stylesheet" href="{{ asset('/mobile_court/cssmc/morris/morris.css') }}">
    <link rel="stylesheet" href="{{ asset('/mobile_court/cssmc/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('/mobile_court/cssmc/jquery-ui-1.11.0.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/mobile_court/javascripts/source/dashboard/loading_plugin/loading.css') }}">

@endsection
@section('content')
    {{-- @include('dashboard.inc.icon_card') --}}

    <style type="text/css">
        fieldset {
            border: 1px solid #ddd !important;
            margin: 0;

            padding: 10px;
            position: relative;
            border-radius: 4px;
            background-color: #d5f7d5;
            padding-left: 10px !important;
        }

        fieldset .form-label {
            color: black;
        }

        legend {
            font-size: 14px;
            font-weight: 00;
            width: 45%;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px 5px 5px 10px;
            background-color: #008841;
            color: white
        }

        .list-group-flush>.list-group-item {
            padding-left: 0;
        }
        .btn-active {
            background-color: #008841 !important; 
            border-color: #008841 !important;
        }
        .btn-active.active {
            background-color: #0bb7af !important; 
            border-color: #0bb7af !important;
        }
        .dashboard {
            display: none; 
        }
        .dashboard.active {
            display: block; 
        }
    </style>

    <style type="text/css">
        /*highchart css*/

        .highcharts-figure,
        .highcharts-data-table table {
            /*min-width: 310px; */
            /*max-width: 1000px;*/
            /*margin: 1em auto;*/
        }

        #container {
            /*height: 400px;*/
        }

        .highcharts-data-table table {
            font-family: Verdana, sans-serif;
            border-collapse: collapse;
            border: 1px solid #EBEBEB;
            margin: 10px auto;
            text-align: center;
            width: 100%;
            /*max-width: 500px;*/
        }

        .highcharts-data-table caption {
            padding: 1em 0;
            font-size: 1.2em;
            color: #555;
        }

        .highcharts-data-table th {
            font-weight: 600;
            padding: 0.5em;
        }

        .highcharts-data-table td,
        .highcharts-data-table th,
        .highcharts-data-table caption {
            padding: 0.5em;
        }

        .highcharts-data-table thead tr,
        .highcharts-data-table tr:nth-child(even) {
            background: #f8f8f8;
        }

        .highcharts-data-table tr:hover {
            background: #f1f7ff;
        }


        /*Pie chart*/
        .highcharts-figure,
        .highcharts-data-table table {
            min-width: 320px;
            max-width: 1030px;
            margin: 1em auto;
        }

        .highcharts-data-table table {
            font-family: Verdana, sans-serif;
            border-collapse: collapse;
            border: 1px solid #EBEBEB;
            margin: 10px auto;
            text-align: center;
            width: 100%;
            max-width: 500px;
        }

        .highcharts-data-table caption {
            padding: 1em 0;
            font-size: 1.2em;
            color: #555;
        }

        .highcharts-data-table th {
            font-weight: 600;
            padding: 0.5em;
        }

        .highcharts-data-table td,
        .highcharts-data-table th,
        .highcharts-data-table caption {
            padding: 0.5em;
        }

        .highcharts-data-table thead tr,
        .highcharts-data-table tr:nth-child(even) {
            background: #f8f8f8;
        }

        .highcharts-data-table tr:hover {
            background: #f1f7ff;
        }


        input[type="number"] {
            min-width: 50px;
        }
        .highcharts-credits{
            display: none; 
        }
    </style>

    

    <form action="javascript:void(0)" class="form" method="POST" style="width: 100%">
        @csrf
        <!-- <div class="card-body"> -->
        <fieldset class="mb-6">
            <legend>ফিল্টারিং ফিল্ড সমূহ</legend>

            <div class="row">
                <div class="col-lg-2 mb-5">
                    <select name="division" id="division_id" class="form-control form-control-sm">
                        <option value="">-বিভাগ নির্বাচন করুন-</option>
                        @foreach ($divisions as $value)
                            <option value="{{ $value->id }}"> {{ $value->division_name_bn }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-2 mb-5">
                    <!-- <label>জেলা <span class="text-danger">*</span></label> -->
                    <select name="district" id="district_id" class="form-control form-control-sm">
                        <option value="">-জেলা নির্বাচন করুন-</option>
                    </select>
                </div>
                <div class="col-lg-2 mb-5">
                    <!-- <label>উপজেলা </label> -->
                    <select name="upazila" id="upazila_id" class="form-control form-control-sm">
                        <option value="">-উপজেলা নির্বাচন করুন-</option>
                    </select>
                </div>
                <div class="col-lg-2 mb-5">
                    <input type="text" name="date_from" id="date_from"
                        class="form-control form-control-sm common_datepicker" placeholder="তারিখ হতে" autocomplete="off">
                </div>
                <div class="col-lg-2 mb-5">
                    <input type="text" name="date_to" id="date_to"
                        class="form-control form-control-sm common_datepicker" placeholder="তারিখ পর্যন্ত"
                        autocomplete="off">
                </div>
            </div>
        </fieldset>
        <!-- </div> -->

        <div class="row court_type" style="text-align: center">
            <div class="col-md-4"><button class="btn btn-success btn-lg court_type_button btn-active active">জেনারেল সার্টিফিকেট কোর্ট</button></div>
            <div class="col-md-4"><button class="btn btn-success btn-lg court_type_button btn-active">এক্সিকিউটিভ ম্যাজিস্ট্রেট কোর্ট</button></div>
            <div class="col-md-4"><button class="btn btn-success btn-lg court_type_button btn-active">মোবাইল কোর্ট</button></div>
        </div>
        <br>

        {{-- gcc dashboard  --}}
        @include('dashboard.inc.gcc_dashboard')

        {{-- emc dashboard  --}}
        @include('dashboard.inc.emc_dashboard')
        

        {{-- mobile court dashboard  --}}
        @include('dashboard.inc.mc_dashboard')
        
        

        <!-- <button class="btn btn-success save-data">Test Ajax</button> -->
    </form>


@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('.court_type_button');
        const dashboards = document.querySelectorAll('.dashboard');

        function setActiveButtonAndDashboard(buttonIndex) {
            // Remove active class from all buttons and hide all dashboards
            buttons.forEach((btn, index) => {
                btn.classList.remove('active');
                dashboards[index].classList.remove('active');
            });

            // Add active class to the clicked button and corresponding dashboard
            buttons[buttonIndex].classList.add('active');
            dashboards[buttonIndex].classList.add('active');
        }

        // Set default active button and dashboard
        setActiveButtonAndDashboard(0);

        // Add click event listeners to all buttons
        buttons.forEach((button, index) => {
            button.addEventListener('click', function() {
                setActiveButtonAndDashboard(index);
            });
        });
    });
</script>

{{-- Includable CSS Related Page --}}
@section('styles')
    <link href="{{ asset('plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Page Vendors Styles-->
@endsection

{{-- Scripts Section Related Page --}}
@section('scripts')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="{{ asset('plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
    <script src="{{ asset('js/pages/widgets.js') }}"></script>
    <script>
        $('.Count').each(function() {
            var en2bnnumbers = {
                0: '০',
                1: '১',
                2: '২',
                3: '৩',
                4: '৪',
                5: '৫',
                6: '৬',
                7: '৭',
                8: '৮',
                9: '৯'
            };
            var bn2ennumbers = {
                '০': 0,
                '১': 1,
                '২': 2,
                '৩': 3,
                '৪': 4,
                '৫': 5,
                '৬': 6,
                '৭': 7,
                '৮': 8,
                '৯': 9
            };

            function replaceEn2BnNumbers(input) {
                var output = [];
                for (var i = 0; i < input.length; ++i) {
                    if (en2bnnumbers.hasOwnProperty(input[i])) {
                        output.push(en2bnnumbers[input[i]]);
                    } else {
                        output.push(input[i]);
                    }
                }
                return output.join('');
            }

            function replaceBn2EnNumbers(input) {
                var output = [];
                for (var i = 0; i < input.length; ++i) {
                    if (bn2ennumbers.hasOwnProperty(input[i])) {
                        output.push(bn2ennumbers[input[i]]);
                    } else {
                        output.push(input[i]);
                    }
                }
                return output.join('');
            }
            var $this = $(this);
            var nubmer = replaceBn2EnNumbers($this.text());
            jQuery({
                Counter: 0
            }).animate({
                Counter: nubmer
            }, {
                duration: 2000,
                easing: 'swing',
                step: function() {
                    var nn = Math.ceil(this.Counter).toString();
                    // console.log(replaceEn2BnNumbers(nn));
                    $this.text(replaceEn2BnNumbers(nn));
                }
            });
        });

        jQuery(document).ready(function() {
        
            case_status_statistic();
            payment_statistic();
            case_pie_chart();

            crpc_statistic();
            emc_case_status_statistic();
            case_statistics_area();
            emc_case_pie_chart();

            // District Dropdown
            jQuery('select[name="division"]').on('change', function() {
                var dataID = jQuery(this).val();
                // var category_id = jQuery('#category_id option:selected').val();
                jQuery("#district_id").after('<div class="loadersmall"></div>');

                if (dataID !== undefined) {
                    jQuery.ajax({
                        url: '{{ url('/') }}/case/dropdownlist/getdependentdistrict/' +
                            dataID,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            jQuery('select[name="district"]').html(
                                '<div class="loadersmall"></div>');
                            //console.log(data);
                            // jQuery('#mouja_id').removeAttr('disabled');
                            // jQuery('#mouja_id option').remove();

                            jQuery('select[name="district"]').html(
                                '<option value="">-- নির্বাচন করুন --</option>');
                            jQuery.each(data, function(key, value) {
                                jQuery('select[name="district"]').append(
                                    '<option value="' + key + '">' + value +
                                    '</option>');
                            });
                            jQuery('.loadersmall').remove();
                            // $('select[name="mouja"] .overlay').remove();
                            // $("#loading").hide();
                        }
                    });
                } else {
                    $('select[name="district"]').empty();
                }
            });

            // Upazila Dropdown
            jQuery('select[name="district"]').on('change', function() {
                var dataID = jQuery(this).val();
                // var category_id = jQuery('#category_id option:selected').val();
                jQuery("#upazila_id").after('<div class="loadersmall"></div>');
                // $("#loading").html("<img src='{{ asset('media/preload.gif') }}' />");
                // jQuery('select[name="mouja"]').html('<option><div class="loadersmall"></div></option');
                // jQuery('select[name="mouja"]').attr('disabled', 'disabled');
                // jQuery('.loadersmall').remove();
                /*if(dataID)
                {*/
                jQuery.ajax({
                    url: '{{ url('/') }}/generalCertificate/case/dropdownlist/getdependentupazila/' +
                        dataID,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        jQuery('select[name="upazila"]').html(
                            '<div class="loadersmall"></div>');
                        //console.log(data);
                        // jQuery('#mouja_id').removeAttr('disabled');
                        // jQuery('#mouja_id option').remove();

                        jQuery('select[name="upazila"]').html(
                            '<option value="">-- নির্বাচন করুন --</option>');
                        jQuery.each(data, function(key, value) {
                            jQuery('select[name="upazila"]').append('<option value="' +
                                key + '">' + value + '</option>');
                        });
                        jQuery('.loadersmall').remove();
                        // $('select[name="mouja"] .overlay').remove();
                        // $("#loading").hide();
                    }
                });
                //}

                // Load Court
                var courtID = jQuery(this).val();
                // var category_id = jQuery('#category_id option:selected').val();
                jQuery("#court_id").after('<div class="loadersmall"></div>');
                // $("#loading").html("<img src='{{ asset('media/preload.gif') }}' />");
                // jQuery('select[name="mouja"]').html('<option><div class="loadersmall"></div></option');
                // jQuery('select[name="mouja"]').attr('disabled', 'disabled');
                // jQuery('.loadersmall').remove();
                // if(courtID)
                // {
                jQuery.ajax({
                    url: '{{ url('/') }}/court/dropdownlist/getdependentcourt/' + courtID,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        jQuery('select[name="court"]').html('<div class="loadersmall"></div>');
                        //console.log(data);
                        // jQuery('#mouja_id').removeAttr('disabled');
                        // jQuery('#mouja_id option').remove();

                        jQuery('select[name="court"]').html(
                            '<option value="">-- নির্বাচন করুন --</option>');
                        jQuery.each(data, function(key, value) {
                            jQuery('select[name="court"]').append('<option value="' +
                                key + '">' + value + '</option>');
                        });
                        jQuery('.loadersmall').remove();
                        // $('select[name="mouja"] .overlay').remove();
                        // $("#loading").hide();
                    }
                });
                //}
                /*else
                {
                    $('select[name="upazila"]').empty();
                    $('select[name="court"]').empty();
                }*/
            });

        });
    </script>

    <script src="{{ asset('js/pages/crud/forms/widgets/bootstrap-datepicker.js') }}"></script>
    <script>
        // common datepicker
        $('.common_datepicker').datepicker({
            format: "dd/mm/yyyy",
            todayHighlight: true,
            orientation: "bottom left"
        });
    </script>
    

    @include('dashboard.inc.js.gcc_js')
    @include('dashboard.inc.js.emc_js')
    @include('dashboard.inc.js.mc_js')

@endsection

{{-- gcc dashboard js  --}}


