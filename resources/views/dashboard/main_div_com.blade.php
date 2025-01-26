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
            font-weight: bold;
            width: 45%;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px 5px 5px 10px;
            background-color: #5cb85c;
        }

        .list-group-flush>.list-group-item {
            padding-left: 0;
        }
        .btn-active {
            background-color: #28a745 !important; 
            border-color: #28a745 !important;
        }
        .btn-active.active {
            background-color: #416e4b !important; 
            border-color: #416e4b !important;
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

    <form action="javascript:void(0)" class="form" method="POST">
        @csrf


        <div class="row court_type" style="text-align: center">
            <div class="col-md-4"><button class="btn btn-success btn-lg court_type_button btn-active active">এক্সিকিউটিভ
                    ম্যাজিস্ট্রেট কোর্ট</button></div>
            <div class="col-md-4"><button class="btn btn-success btn-lg court_type_button btn-active"> জেনারেল সার্টিফিকেট
                    কোর্ট</button></div>
            <div class="col-md-4"><button class="btn btn-success btn-lg court_type_button btn-active">মোবাইল কোর্ট</button>
            </div>
        </div>
        <br>

        {{-- gcc dashboard  --}}
        @include('dashboard.div_com.emc.dashboard')

        {{-- emc dashboard  --}}
        @include('dashboard.div_com.gcc.dashboard')


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


    @include('dashboard.inc.div_com_js.gcc_js')
    @include('dashboard.inc.div_com_js.emc_js')
    @include('dashboard.inc.js.mc_js')
@endsection
