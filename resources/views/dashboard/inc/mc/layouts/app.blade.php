<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<!--begin::Head-->

<head>
    <base href="">
    <meta charset="utf-8" />
    <!-- <title>@yield('title', $page_title ?? 'Page Title') | {{ config('app.name') }}</title> -->
    <title>@yield('title', $page_title ?? ' এক্সিকিউটিভ ম্যাজিস্ট্রেট কোর্ট') </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- <meta name="_token" content="{{ csrf_token() }}" /> -->
    <meta name="description" content="Civil Suit Judiciary of Bangladesh" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    {{-- <link rel="shortcut icon" href="{{ asset('media/logos/favicon.ico') }}" /> --}}
    {{-- <link rel="shortcut icon" href="{{ asset(App\Models\SiteSetting::first()->fevicon) }}" /> --}}
    <link rel="shortcut icon" href="{{ asset('media/logos/favicon.ico') }}" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/fontawesome.min.css"  />

    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="{{ asset('plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('plugins/custom/prismjs/prismjs.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/style.bundle.css') }}" rel="stylesheet" type="text/css" />

    <!--end::Global Theme Styles-->
    <!--begin::Layout Themes(used by all pages)-->
    <link href="{{ asset('css/themes/layout/header/base/light.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/themes/layout/header/menu/light.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/themes/layout/brand/light.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/themes/layout/aside/light.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/landing/custom.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://beta-idp.stage.mygov.bd/css/mygov-widgets.css" rel="stylesheet"/>
    <!--end::Layout Themes-->

    <!--begin::Page Custom Styles(used by specific page)-->
    @stack('head')
    <!--end::Page Custom Styles-->

    <!--begin::Page Vendors Styles(used by this page)-->
    {{-- Includable CSS Related Page --}}
    @yield('styles')
    <style>
        #pagePreLoader {
            position: fixed;
            width: 100%;
            height: 100%;
            background: #fff url('https://teamphotousa.com/assets/images/teamphoto-loading.gif') no-repeat center;
            z-index: 9999999;
        }

        #toast-container>div {
            opacity: 1 !important;
        }

        .toast.toast-success
         {
            background-color: #0bb7af !important;
            color: #fff !important;
        }
        .toast.toast-error,
        .toast.toast-warning
        {
            background-color: #ee2d41 !important;
            color: #fff !important;
        }

    </style>

<style>
    .input_bangla {
    font-family: boishakhi !important;
    font-size: 14px !important;
    }
    @font-face {
        font-family: 'boishakhi';
        src: url('/fonts/Boishkhi/Boishkhi.ttf') format('truetype');
    }
</style>

    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" type="text/css" /> 
    <link href="{{ asset('css/landing/custom.css') }}" rel="stylesheet" type="text/css" />


</head>
<!--end::Head-->
<!--begin::Body-->

<body onload="" id="kt_body"
    class="header-fixed header-mobile-fixed aside-fixed aside-minimize-hoverable page-loading">
    <div class="" onload="pagePreLoaderOff()" id="pagePreLoader"></div>
    @include('layout.mobile_header')
    <div class="" id="kt_wrapper">
        @php
            $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        @endphp

        @auth
            @include('layout.auth_header')
        @else
            {{-- @include('layout.header') --}}
        @endauth
            
        @php
        if (str_contains($uri_path, '/forget/password/mobile/check')) {
            $uri_path = 'forget/password/mobile/check';
          }
        if (str_contains($uri_path, 'forget/password/otp/resend')) {
            $uri_path = 'forget/password/otp/resend';
          }
        if (str_contains($uri_path, '/citizen/mobile/check/')) {
            $uri_path = '/citizen/mobile/check/';
          }
          if (str_contains($uri_path, '/advocate/mobile/check')) {
            $uri_path = '/advocate/mobile/check';
          }
        @endphp
        
      
  
            <div class="container" style="margin-top:90px; margin-bottom:25px">
                @if (request()->is('dashboard'))
                    @yield('content')
                @else
                    <div class="row">
                        @if(isset($users) && $users != null)
                            <div class="custom-col-12">
                                @yield('content')
                            </div>
                        @elseif(isset($court_page) && $court_page != null)
                            <div class="custom-col-12">
                                @yield('content')
                            </div>
                        @else
                            <div class="col-md-12">
                                @yield('content')
                            </div>
                        @endif
                    </div>
                @endif
            </div>
      
        
        @yield('landing')

       
    </div>

  
    <!-- begin::User Panel-->
    @include('layout.partials.user_panel')
    <!-- end::User Panel-->

    <!--begin::Quick Panel -->
    @include('layout.partials.quick_panel')
    <!--end::Quick Panel-->


    @if(!Auth::check())
        @include('layouts.landing._footer')
    @endif

        
    <!--begin::Scrolltop-->
    <div id="kt_scrolltop" class="scrolltop">
        <span class="svg-icon">
            <!--begin::Svg Icon | path:media/svg/icons/Navigation/Up-2.svg-->
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                height="24px" viewBox="0 0 24 24" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <polygon points="0 0 24 0 24 24 0 24" />
                    <rect fill="#000000" opacity="0.3" x="11" y="10" width="2" height="10"
                        rx="1" />
                    <path
                        d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z"
                        fill="#000000" fill-rule="nonzero" />
                </g>
            </svg>
            <!--end::Svg Icon-->
        </span>
    </div>
    <!--end::Scrolltop-->

    <script>
        /*var HOST_URL = "https://preview.keenthemes.com/metronic/theme/html/tools/preview"; */
    </script>
    <!--begin::Global Config(global config for global JS scripts)-->
    <script>
        var KTAppSettings = {
            "breakpoints": {
                "sm": 576,
                "md": 768,
                "lg": 992,
                "xl": 1200,
                "xxl": 1400
            },
            "colors": {
                "theme": {
                    "base": {
                        "white": "#ffffff",
                        "primary": "#3699FF",
                        "secondary": "#E5EAEE",
                        "success": "#1BC5BD",
                        "info": "#8950FC",
                        "warning": "#FFA800",
                        "danger": "#F64E60",
                        "light": "#E4E6EF",
                        "dark": "#181C32"
                    },
                    "light": {
                        "white": "#ffffff",
                        "primary": "#E1F0FF",
                        "secondary": "#EBEDF3",
                        "success": "#C9F7F5",
                        "info": "#EEE5FF",
                        "warning": "#FFF4DE",
                        "danger": "#FFE2E5",
                        "light": "#F3F6F9",
                        "dark": "#D6D6E0"
                    },
                    "inverse": {
                        "white": "#ffffff",
                        "primary": "#ffffff",
                        "secondary": "#3F4254",
                        "success": "#ffffff",
                        "info": "#ffffff",
                        "warning": "#ffffff",
                        "danger": "#ffffff",
                        "light": "#464E5F",
                        "dark": "#ffffff"
                    }
                },
                "gray": {
                    "gray-100": "#F3F6F9",
                    "gray-200": "#EBEDF3",
                    "gray-300": "#E4E6EF",
                    "gray-400": "#D1D3E0",
                    "gray-500": "#B5B5C3",
                    "gray-600": "#7E8299",
                    "gray-700": "#5E6278",
                    "gray-800": "#3F4254",
                    "gray-900": "#181C32"
                }
            },
            "font-family": "Poppins"
        };
    </script>
    <!--end::Global Config-->
    <!--begin::Global Theme Bundle(used by all pages)-->
    <script src="{{ asset('plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('plugins/custom/prismjs/prismjs.bundle.js') }}"></script>
    <script src="{{ asset('js/scripts.bundle.js') }}"></script>
    <!--end::Global Theme Bundle-->

    {{-- csrf Token --}}
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

    <!--begin::Page Vendors(used by this page)-->
    {{-- Includable JS Related Page --}}
    {{-- Toster Alert --}}
    <script src="{{ asset('js/pages/features/miscellaneous/toastr.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#pagePreLoader").addClass('d-none');
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": false,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };

            @if (Session::has('success'))
                toastr.success("{{ session('success') }}", "Success");
            @endif
            @if (Session::has('error'))
                toastr.error("{{ session('error') }}", "Error");
            @endif
            @if (Session::has('info'))
                toastr.info("{{ session('info') }}", "Info");
            @endif
            @if (Session::has('warning'))
                toastr.warning("{{ session('warning') }}", "Warning");
            @endif

            function setCookie(name, value, days) {
                var expires = "";
                if (days) {
                    var date = new Date();
                    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                    expires = "; expires=" + date.toUTCString();
                }
                document.cookie = name + "=" + (value || "") + expires + "; path=/";
            }

            function getCookie(name) {
                var nameEQ = name + "=";
                var ca = document.cookie.split(';');
                for (var i = 0; i < ca.length; i++) {
                    var c = ca[i];
                    while (c.charAt(0) == ' ') c = c.substring(1, c.length);
                    if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
                }
                return null;
            }


            var current_notifiaction = $('.cs_notification_count').data('notification');
            var previous_notification = getCookie('previous_notification');

            if (previous_notification == null) {
                previous_notification = 0;
            }
            if(current_notifiaction<previous_notification)
            {
                previous_notification=0;
            }

            var notify = current_notifiaction - previous_notification;


            $.ajax({
                url: '{{ route('en2bn') }}',
                method: 'get',
                data: {
                    notify: notify,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status == 'success') {

                        //$('.perssion_list').html(response.html);

                        $('.cs_notification_count').text(response.notify);
                    }
                }
            });


            if (current_notifiaction == previous_notification) {
                $('.cs_notification_count').hide();
            } else {
                $('.cs_notification').on('click', function() {
                    
                    $('.cs_notification_count').hide();




                    setCookie('previous_notification', current_notifiaction, 30);
                });

            }


        });
    </script>

    @yield('scripts')
</body>
<!--end::Body-->

</html>