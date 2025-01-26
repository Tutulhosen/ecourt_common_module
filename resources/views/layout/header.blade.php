@if (Auth::check())

    <style type="text/css">
        .notification {
            position: absolute;
            top: 0;
            right: 40px;
        }
    </style>
    <div id="kt_header" class="header header-fixed">
        <!--begin::Container-->
        <div class="container d-flex align-items-stretch justify-content-between">
            <!--begin::Header Menu Wrapper-->
            <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
                <!--begin::Header Logo-->
                <div class="header-logo">
                    <a href="{{ url('/') }}">
                        <img alt="Logo" src="{{ asset(App\Models\SiteSetting::first()->site_logo) }}"
                            width="150" />
                    </a>
                </div>
            </div>
            <!--end::Header Menu Wrapper-->
            <!--begin::Topbar-->
            <div class="topbar_wrapper">
                <div class="topbar gcc-header-area">
                    <div class="tpbar_text_menu topbar-item topbarmenu_item mr-2 dashboard-tmenu">
                        <a href="{{ url('/dashboard') }}" class="menu-link font-size-h5 font-weight-bolder">
                            <span class="text-info">ড্যাশবোর্ড</span>
                        </a>
                    </div>

                    <div class="topbar-item topbarmenu_item">
                        <div class="btn  -mobile w-auto btn-clean d-flex align-items-center btn-lg px-2"
                            id="kt_quick_user_toggle">
                            <span class="text-muted font-size-base d-none d-md-inline mr-1">
                                @if (Auth::user()->profile_pic != null)
                                    <img src="{{ url('/') }}/uploads/profile/{{ Auth::user()->profile_pic }}">
                                @else
                                    <img src="{{ url('/') }}/uploads/profile/default.jpg">
                                @endif
                            </span>
                            <span
                                class="text-dark font-size-base d-none d-md-inline mr-3">{{ auth()->user()->name }}</span>
                            <span
                                class="symbol symbol-lg-35 symbol-25 symbol-light-info bg-primary p-2 text-light rounded">
                                <span class="">{{ Auth::user()->role->role_name }}</span>
                            </span>
                        </div>
                    </div>
                    <!--end::User-->
                </div>
            </div>
            <!--end::Topbar-->
        </div>
        <!--end::Container-->
    </div>
@else
    <style type="text/css">
        .notification {
            position: absolute;
            top: 0;
            right: 40px;
        }

        #dropdownMenuButton::after {
            color: white !important;
            /* Change this color to the desired color */
        }

        .btn-head {
            font-family: Raleway-SemiBold;
            font-size: 13px;
            letter-spacing: 1px;
            background-color: #00984F;
            border-radius: 40px;
            color: white !important;
            transition: all 0.3s ease 0s;
            padding: 5px 20px;
            border: none;
            outline: none;
        }

        .btn-head:focus {
            box-shadow: 0 0 0 4px #FFD700, 0 0 0 6px #5c6963;
            outline: none;
        }

        .btn-child {
            font-family: Raleway-SemiBold;
            font-size: 13px;
            letter-spacing: 1px;
            /* line-height: 15px; */
            background-color: #00984F;
            border-radius: 40px;
            /* background: transparent; */
            color: white !important;
            transition: all 0.3s ease 0s;
            padding: 6px 17px
        }

        /* .btn-secondarys:hover {
            color: #FFF;
            background: #02532c;
        } */
    </style>
    <div id="kt_header" class="header header-fixed" style="height: 100px; padding-left: 20px; padding-right: 20px">
        <!--begin::Container-->
        <div class=" d-flex align-items-center justify-content-between" style="width: 100%">
            <!--begin::Header Menu Wrapper-->
            <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
                <!--begin::Header Logo-->
                <div class="header-logo">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('images/logo_court.jpeg') }}" alt="E-Court"
                            style="width: 15em; height: 4em; max-width: 100%; height: auto;">
                        {{-- <img alt="Logo" src="{{asset('images/logo_court.jpeg')}}" width="150" /> --}}
                    </a>
                </div>
            </div>
            <!--end::Header Menu Wrapper-->
            <!--begin::Topbar-->
            <div class="topbar_wrapper mb-3">
                <div class="topbar pt-3">
                    {{-- <div class="tpbar_text_menu topbar-item topbarmenu_item mr-2">
                        <div class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-2"
                            id="kt_quick_user_toggle">
                            <a href="{{ route('cprc.home.page') }}" class="svg-icon svg-icon-primary svg-icon-2x">ধারা ভিত্তিক অভিযোগের ধরণ</a>
                        </div>
                    </div> --}}

                    {{-- 
                    <li><a class="text-[16px]" href="{{ route('mc_citizen_public_view.new') }}">মোবাইল কোর্টের অপরাধের
                তথ্য</a></li>
                    --}}
                    <div class="tpbar_text_menu topbar-item topbarmenu_item mr-2">
                        <div class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-2"
                            id="kt_quick_user_toggle">
                            <a href="{{ route('mc_citizen_public_view.new') }}"
                                class="svg-icon svg-icon-primary svg-icon-2x">মোবাইল কোর্টের অপরাধের
                                তথ্য</a>
                        </div>
                    </div>
                    <div class="tpbar_text_menu topbar-item topbarmenu_item mr-2">
                        <div class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-2"
                            id="kt_quick_user_toggle">
                            <a href="{{ URL('http://bdlaws.minlaw.gov.bd/act-98.html') }}"
                                class="svg-icon svg-icon-primary svg-icon-2x">প্রসেস ম্যাপ</a>
                        </div>
                    </div>
                    <div class="tpbar_text_menu tpbar_text_mlast topbar-item topbarmenu_item mr-8">
                        <div class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-2"
                            id="kt_quick_user_toggle">
                            <a href="" class="svg-icon svg-icon-primary svg-icon-2x">আইন ও বিধি</a>
                        </div>
                    </div>
                    <div class="tpbar_text_menu tpbar_text_mlast topbar-item topbarmenu_item mr-8">
                        <div class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-2"
                            id="kt_quick_user_toggle">
                            {{-- <a href="" class="svg-icon svg-icon-primary svg-icon-2x">আইন ও বিধি</a> --}}
                            <a href="tel:+333" class="d-flex align-items-center" style="gap: 10px">
                                {{--  <span>
                                                <svg class="w-6 h-6 fill-current" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 512 512">
                                                    <path
                                                        d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z" />
                                                </svg>
                                            </span> --}}
                                <img class="" width="100%" height="100%"
                                    src="{{ asset('landing_page/images/nav/Vector.png') }}" alt="E-Court">
                                <span> হেল্পলাইন: </span>
                                <span style="color: red; font-weight: 700"> ১৬১২৪৩ </span>
                                {{-- <span> 333 </span> --}}
                            </a>
                        </div>
                    </div>
                    <div class="tpbar_text_menu tpbar_text_mlast topbar-item topbarmenu_item mt-3">
                        <div class="dropdown">
                            <button class="btn btn-head dropdown-toggle " type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="">
                                প্রশাসনিক লগইন
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"
                                style="margin-top: 30px; margin-left: 15px; padding: 10px; display: flex; flex-direction: column; gap: 10px">
                                <a href="{{ route('nothi.v2.login') }}" class=" btn btn-child" aria-haspopup="true"
                                    aria-expanded="false" style=" href="#">কোর্ট
                                    লগইন</a>
                                <a href="{{ route('show_admin_log_in_page') }}" class=" btn btn-child"
                                    aria-haspopup="true" aria-expanded="false" style=" href="#">এডমিন
                                    লগইন</a>
                            </div>
                        </div>
                    </div>
                </div>
                {{--  <div class="tpbar_text_menu tpbar_text_mlast topbar-item topbarmenu_item mt-2">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle " type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                style="background-color: #00984F; font-size: 16px; color:white">
                                প্রশাসনিক লগইন
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="margin-top: 20px">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
                    </div> --}}
                {{--  <div class="topbar-item topbarmenu_item">
                        <div class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-2"
                            id="topbar_social_icon">
                            <a href="https://www.facebook.com/Ecourtbd" target="_blank"
                                class="social-svg-icon svg-icon-primary svg-icon-2x">
                                <svg style="color: rgb(109, 91, 220);" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 320 512">Copyright 2022 Fonticons, Inc. --><path
                                        d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"
                                        fill="#6d5bdc"></path></svg>
                            </a>
                        </div>
                    </div>

                    <div class="topbar-item topbarmenu_item">
                        <div class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-2"
                            id="topbar_social_icon">
                            <a href="https://twitter.com/ecourtbd" target="_blank"
                                class="social-svg-icon svg-icon-primary svg-icon-2x">
                                <svg style="color: rgb(108, 90, 220);" xmlns="http://www.w3.org/2000/svg" width="16"
                                    height="16" fill="currentColor" class="bi bi-twitter" viewBox="0 0 16 16">
                                    <path
                                        d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"
                                        fill="#6c5adc"></path>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <div class="topbar-item topbarmenu_item mr-8">
                        <div class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-2"
                            id="topbar_social_icon">
                            <a href="https://www.youtube.com/channel/UCfN6060uxEIITJVH-dnsb9A" target="_blank"
                                class="social-svg-icon svg-icon-primary svg-icon-2x">
                                <svg style="color: rgb(108, 90, 220);" xmlns="http://www.w3.org/2000/svg" width="16"
                                    height="16" fill="currentColor" class="bi bi-youtube" viewBox="0 0 16 16">
                                    <path
                                        d="M8.051 1.999h.089c.822.003 4.987.033 6.11.335a2.01 2.01 0 0 1 1.415 1.42c.101.38.172.883.22 1.402l.01.104.022.26.008.104c.065.914.073 1.77.074 1.957v.075c-.001.194-.01 1.108-.082 2.06l-.008.105-.009.104c-.05.572-.124 1.14-.235 1.558a2.007 2.007 0 0 1-1.415 1.42c-1.16.312-5.569.334-6.18.335h-.142c-.309 0-1.587-.006-2.927-.052l-.17-.006-.087-.004-.171-.007-.171-.007c-1.11-.049-2.167-.128-2.654-.26a2.007 2.007 0 0 1-1.415-1.419c-.111-.417-.185-.986-.235-1.558L.09 9.82l-.008-.104A31.4 31.4 0 0 1 0 7.68v-.123c.002-.215.01-.958.064-1.778l.007-.103.003-.052.008-.104.022-.26.01-.104c.048-.519.119-1.023.22-1.402a2.007 2.007 0 0 1 1.415-1.42c.487-.13 1.544-.21 2.654-.26l.17-.007.172-.006.086-.003.171-.007A99.788 99.788 0 0 1 7.858 2h.193zM6.4 5.209v4.818l4.157-2.408L6.4 5.209z"
                                        fill="#6c5adc"></path>
                                </svg>
                            </a>
                        </div>
                    </div>


                    <div class="topbar-item topbarmenu_item">
                        <div class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-2"
                            id="kt_quick_user_toggle">
                            <span class="svg-icon svg-icon-primary svg-icon-2x">
                                <svg style="color: rgb(108, 90, 220);" xmlns="http://www.w3.org/2000/svg"
                                    width="16" height="16" fill="currentColor" class="bi bi-play-fill"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393z"
                                        fill="#6c5adc"></path>
                                </svg><!--end::Svg Icon-->
                            </span><b><a href="https://muktopaath.gov.bd/" target="_blank" class="text-dark">অনলাইন
                                    কোর্স</a></b>
                        </div>
                    </div>
                    <div class="topbar-item topbarmenu_item">
                        <div class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-2"
                            id="kt_quick_user_toggle">
                            <span class="svg-icon svg-icon-primary svg-icon-2x">
                                <i class="fa fa-phone"></i>
                            </span><b><a href="tel:+333">333</a></b>
                        </div>
                    </div> --}}
                <!--end::User-->

            </div>
        </div>
        <!--end::Topbar-->
    </div>
    <!--end::Container-->
    </div>
@endif
