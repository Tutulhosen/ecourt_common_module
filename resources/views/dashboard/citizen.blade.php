@extends('layout.app')
 @yield('style')
<link href="{{ asset('plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />

@section('content')
    <div class="row court_type" style="text-align: center">
        <div class="col-md-4">
            <button id="gccButton" class="btn btn-success btn-lg court_type_button active">জেনারেল সার্টিফিকেট কোর্ট</button>
        </div>
        <div class="col-md-4">
            <button id="emcButton" class="btn btn-success btn-lg court_type_button">এক্সিকিউটিভ ম্যাজিস্ট্রেট কোর্ট</button>
        </div>
        <div class="col-md-4">
            <button id="mcButton" class="btn btn-success btn-lg court_type_button">মোবাইল কোর্ট</button>
        </div>
    </div>
    <br>
        {{-- gcc citizen dashboard  --}}
        @include('dashboard.inc.gcc_citizen_dashboard')

        {{-- emc citizen dashboard  --}}
        @include('dashboard.inc.emc_citizen_dashboard')
        
    
        {{-- mobile court citizen dashboard  --}}
        @include('dashboard.inc.mc_citizen_dashboard')

        <style>
            .dashboard_title{
                width: 40%;
                margin: auto;
                text-align: center;
                border: 4px double green;
                padding: 10px;
            }
            .chart-container {
                width: 100%;
                height: 700px;
            }
        
            .pie-chart-container {
                height: 500px;
                width: 500px;
            }
        
             /* Default button styling */
            .court_type_button {
                background-color: #28a745; /* Default green color */
                color: white;
                border: none;
            }

            /* Style for the selected/active button */
            .court_type_button.active {
                background-color: #416e4b !important; /* Blue color for the active button */
                color: white;
            }
        </style>
        

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
    integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

<script>
    $(document).ready(function() {
        // Set default dashboard visibility
        $('#gccDashboard').show();
        $('#emcDashboard').hide();
        $('#mcDashboard').hide();

        // Button click event handlers
        $('#gccButton').click(function() {
            $('.citizen_dashboard').hide(); // Hide all dashboards
            $('#gccDashboard').show(); // Show only Gcc dashboard
            $('.court_type_button').removeClass('active'); // Remove active class from all buttons
            $(this).addClass('active'); // Add active class to clicked button
        });

        $('#emcButton').click(function() {
            $('.citizen_dashboard').hide(); // Hide all dashboards
            $('#emcDashboard').show(); // Show only Emc dashboard
            $('.court_type_button').removeClass('active'); // Remove active class from all buttons
            $(this).addClass('active'); // Add active class to clicked button
        });

        $('#mcButton').click(function() {
            $('.citizen_dashboard').hide(); // Hide all dashboards
            $('#mcDashboard').show(); // Show only Mc dashboard
            $('.court_type_button').removeClass('active'); // Remove active class from all buttons
            $(this).addClass('active'); // Add active class to clicked button
        });
    });
</script>



@endsection

{{-- Includable CSS Related Page --}}
@section('styles')
<link href="{{ asset('plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
<!--end::Page Vendors Styles-->
@endsection

{{-- Scripts Section Related Page --}}
@section('scripts')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="{{ asset('plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
<script src="{{ asset('js/pages/widgets.js') }}"></script>
@endsection