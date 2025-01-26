@php

    //==========Notification Count=======//

    if (Auth::check()) {
        $notification_count = 0;
        $case_status = [];
        $rm_case_status = [];
        $officeInfo = user_office_info();
        $isCitizen = globalUserInfo()->is_citizen;

        $nameWords = explode(' ', auth()->user()->name);
        // $appeal_ids_with_investigation = DB::table('em_investigation_report')->select('appeal_id')->distinct()->get();
        $appeal_id_in_appeal_table = [];
        // foreach ($appeal_ids_with_investigation as $value) {
        //     array_push($appeal_id_in_appeal_table, $value->appeal_id);
        // }

        if ($isCitizen) {
            // $CaseTrialCount = DB::table('em_appeal_citizens')
            //     ->join('em_appeals', 'em_appeals.id', '=', 'em_appeal_citizens.appeal_id')
            //     ->where('em_appeals.next_date', date('Y-m-d', strtotime(now())))
            //     ->where('is_hearing_required', 1)
            //     ->whereIn('em_appeal_citizens.citizen_type_id', [1, 2])
            //     ->where('em_appeal_citizens.citizen_id', globalUserInfo()->citizen_id)
            //     ->count();
            $CaseTrialCount = 0;
            $notification_count = $CaseTrialCount;
        }

        if ($isCitizen) {
            $notification_count = $notification_count;
            $CaseTrialCount = $CaseTrialCount;
        }
    }
@endphp

<style type="text/css">
    .notification {
        position: absolute;
        top: 0;
        right: 40px;
    }

    .dropdown-menu .dropdown-submenu {
        position: relative;
    }

    .dropdown-menu .dropdown-submenu .dropdown-menu {
        top: 0;
        left: 100%;
        margin-top: -1px;
        border-radius: .25rem;
        display: none;
        /* Hide by default */
    }

    .dropdown-submenu .navi-link .navi-text:hover {
        color: green
    }

    .dropdown-menu .dropdown-submenu:hover .dropdown-menu {
        display: block;
        /* Show on hover */
    }
</style>

@php

    //===========//Menu Permission==========//
    use Illuminate\Support\Facades\Auth;
    if (Auth::guard('parent_office')->check()) {
        $menu = ['1'];
    }
    if (Auth::check()) {
        $nameWords = explode(' ', auth()->user()->name);
        global $menu;
        $menu = [
            1,
            2,
            3,
            4,
            5,
            6,
            7,
            8,
            9,
            10,
            11,
            12,
            13,
            14,
            15,
            16,
            17,
            18,
            19,
            20,
            21,
            22,
            23,
            24,
            25,
            26,
            27,
            28,
            29,
            30,
            31,
            32,
            33,
            34,
            35,
            36,
            37,
            38,
            39,
            80,
        ];
        $user = Auth::user();
        $isCourtUser = DB::table('doptor_user_access_info')
            ->where('user_id', Auth::user()->id)
            ->where('court_type_id', 1)
            ->first();
        // dd($isCourtUser );
        if (globalUserInfo()->role_id == 1) {
            $menu = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 99, 37, 33, 38, 39, 80];
        } elseif (globalUserInfo()->role_id == 2 || globalUserInfo()->role_id == 8 || globalUserInfo()->role_id == 25) {
            // Admin
            $menu = [
                1,
                2,
                3,
                6,
                7,
                8,
                9,
                10,
                23,
                24,
                26,
                27,
                33,
                35,
                99,
                37,
                33,
                38,
                39,
                40,
                80,
                44,
                45,
                99,
                100,
                101,
                102,
                103,
                104,
            ]; // 35 = Report // 99 role permission create // 100 = short order //101= short decission //102= adalot
        } elseif (globalUserInfo()->role_id == 34) {
            // Admin
            $menu = [1, 35, 40]; // 35 = Report // 99 role permission create
        } elseif ($user->is_citizen == 1) {
            // dd($user);
            $assigned_permissions = [];
            if ($user->citizen_type_id == 1) {
                $menu = [1, 28];
            } elseif ($user->citizen_type_id == 2) {
                $menu = [1];
            }
        }
        // dd($user, $menu, globalUserInfo()->role_id);
    }

    //=================//Menu Permission=======//

@endphp

<div id="kt_header" class="header header-fixed">
    <!--begin::Container-->
    {{-- @if (citizen_auth_menu()) --}}
    <div class="container align-items-stretch justify-content-between">

        <!--begin::Topbar-->
        <div class="topbar_wrapper">
            <div class="topbar">

                @auth
                    @if (in_array(1, $menu))
                        <div class="dropdown">
                            <!--begin::Toggle-->
                            <div class="topbar-item" data-offset="10px,0px" data-menu-toggle="click" data-toggle="tooltip"
                                data-placement="right" title data-original-title="" aria-haspopup="true">

                                <a href="{{ route('dashboard.index', session('court_type_id') ?? '') }}"
                                    class="navi-link  ">
                                    <div class="btn-dropdown mr-2 pulse pulse-primary" style="padding-left: 0 !important;">
                                        <span class="svg-icon auth-svg-icon-bar svg-icon-xl svg-icon-primary">
                                            <!--begin::Svg Icon | path:assets/media/svg/icons/Code/Compiling.svg-->

                                            <i class="fa fa-home"></i>
                                            <p class="navi-text">ড্যাশবোর্ড </p>
                                        </span>
                                        <span class="pulse-ring"></span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endif

                    @if (in_array(99, $menu))
                        <div class="dropdown">
                            <!--begin::Toggle-->
                            <div class="topbar-item" data-offset="10px,0px" data-menu-toggle="click" data-toggle="tooltip"
                                data-placement="right" title data-original-title="" aria-haspopup="true">
                                <a href="{{ route('role-permission.index', [
                                    'court_type_id' => 1,
                                ]) }}"
                                    class="navi-link {{ request()->is('role-permission/index') ? 'menu-item-active' : '' }}">
                                    <div class="btn-dropdown mr-2 pulse pulse-primary" style="padding-left: 0 !important;">
                                        <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                            {{--      <svg xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                                viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24" />
                                                    <path
                                                        d="M5,4 L19,4 C19.2761424,4 19.5,4.22385763 19.5,4.5 C19.5,4.60818511 19.4649111,4.71345191 19.4,4.8 L14,12 L14,20.190983 C14,20.4671254 13.7761424,20.690983 13.5,20.690983 C13.4223775,20.690983 13.3458209,20.6729105 13.2763932,20.6381966 L10,19 L10,12 L4.6,4.8 C4.43431458,4.5790861 4.4790861,4.26568542 4.7,4.1 C4.78654809,4.03508894 4.89181489,4 5,4 Z"
                                                        fill="#000000" />
                                                </g>
                                            </svg> --}}
                                            <!--end::Svg Icon-->
                                            <p class="navi-text">রোল পারমিশন</p>
                                        </span>
                                        <span class="pulse-ring"></span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endif


                    @if ($user->citizen_type_id == 2)
                        <div class="dropdown">
                            <!--begin::Toggle-->

                            <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px" title="">
                                <div
                                    class=" btn-clean btn-dropdown mr-2 {{ request()->is('citizen/appeal/create') ? 'menu-item-active' : '' }}">
                                    <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24" />
                                                <path
                                                    d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z"
                                                    fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                <path
                                                    d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z"
                                                    fill="#000000" fill-rule="nonzero" />
                                            </g>
                                        </svg>
                                        <p class="navi-text">রিকুইজিশন প্রক্রিয়াকরণ</p>
                                    </span>
                                </div>
                            </div>

                            <!--begin::Dropdown-->
                            <div class="dropdown-menu p-0 m-0 dropdown-menu-anim-up dropdown-menu-sm dropdown-menu-right">
                                <!--begin::Nav-->
                                <ul class="navi navi-hover py-4">
                                    <!--begin::Item-->
                                    <li class="navi-item">
                                        <a href=" {{ route('citizen.appeal.create') }} " class="navi-link  ">
                                            <span class="symbol2 symbol-20 mr-3">
                                                <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                                    <i style="color: #3699ff; margin-top: 0 !important;"
                                                        class="fas fa-user"></i>
                                                    <!--end::Svg Icon-->
                                                </span>
                                            </span>
                                            <span class="navi-text">সার্টিফিকেট রিকুইজিশান নিবন্ধন</span>
                                        </a>
                                    </li>
                                    <!--end::Item-->
                                </ul>
                                <!--end::Nav-->
                            </div>
                            <!--end::Dropdown-->
                        </div>
                    @endif
                    @if (in_array(28, $menu) && $user->role_id != 2 && $user->role_id != 8 && $user->role_id != 25)
                        <div class="dropdown">
                            <!--begin::Toggle-->
                            <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px" title="">
                                <div
                                    class=" btn-clean btn-dropdown mr-2 {{ request()->is('emc/citizen/appeal/create', 'report') ? 'menu-item-active' : '' }}">
                                    <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24" />
                                                <path
                                                    d="M3.51471863,18.6568542 L13.4142136,8.75735931 C13.8047379,8.36683502 14.4379028,8.36683502 14.8284271,8.75735931 L16.2426407,10.1715729 C16.633165,10.5620972 16.633165,11.1952621 16.2426407,11.5857864 L6.34314575,21.4852814 C5.95262146,21.8758057 5.31945648,21.8758057 4.92893219,21.4852814 L3.51471863,20.0710678 C3.12419433,19.6805435 3.12419433,19.0473785 3.51471863,18.6568542 Z"
                                                    fill="#000000" opacity="0.3" />
                                                <path
                                                    d="M9.87867966,6.63603897 L13.4142136,3.10050506 C13.8047379,2.70998077 14.4379028,2.70998077 14.8284271,3.10050506 L21.8994949,10.1715729 C22.2900192,10.5620972 22.2900192,11.1952621 21.8994949,11.5857864 L18.363961,15.1213203 C17.9734367,15.5118446 17.3402718,15.5118446 16.9497475,15.1213203 L9.87867966,8.05025253 C9.48815536,7.65972824 9.48815536,7.02656326 9.87867966,6.63603897 Z"
                                                    fill="#000000" />
                                                <path
                                                    d="M17.3033009,4.86827202 L18.0104076,4.16116524 C18.2056698,3.96590309 18.5222523,3.96590309 18.7175144,4.16116524 L20.8388348,6.28248558 C21.0340969,6.47774772 21.0340969,6.79433021 20.8388348,6.98959236 L20.131728,7.69669914 C19.9364658,7.89196129 19.6198833,7.89196129 19.4246212,7.69669914 L17.3033009,5.5753788 C17.1080387,5.38011665 17.1080387,5.06353416 17.3033009,4.86827202 Z"
                                                    fill="#000000" opacity="0.3" />
                                            </g>
                                        </svg>
                                        <p class="navi-text">অভিযোগ দায়ের </p>
                                    </span>
                                </div>
                            </div>

                            <!--begin::Dropdown-->
                            <div class="dropdown-menu p-0 m-0 dropdown-menu-anim-up dropdown-menu-sm dropdown-menu-right">
                                <!--begin::Nav-->
                                <ul class="navi navi-hover py-4">
                                    <!--begin::Item-->

                                    <li class="navi-item">
                                        <a href="{{ route('emc.citizen.appeal.create') }}"
                                            class="navi-link {{ request()->is('citizen/appeal/create') ? 'menu-item-active' : '' }}">
                                            <span class="symbol symbol-20 mr-3">
                                                <span class="svg-icon menu-icon svg-icon-primary">
                                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Safe-chat.svg-->
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                        height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none"
                                                            fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24" height="24" />
                                                            <path
                                                                d="M3,16 L5,16 C5.55228475,16 6,15.5522847 6,15 C6,14.4477153 5.55228475,14 5,14 L3,14 L3,12 L5,12 C5.55228475,12 6,11.5522847 6,11 C6,10.4477153 5.55228475,10 5,10 L3,10 L3,8 L5,8 C5.55228475,8 6,7.55228475 6,7 C6,6.44771525 5.55228475,6 5,6 L3,6 L3,4 C3,3.44771525 3.44771525,3 4,3 L10,3 C10.5522847,3 11,3.44771525 11,4 L11,19 C11,19.5522847 10.5522847,20 10,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,16 Z"
                                                                fill="#000000" opacity="0.3" />
                                                            <path
                                                                d="M16,3 L19,3 C20.1045695,3 21,3.8954305 21,5 L21,15.2485298 C21,15.7329761 20.8241635,16.200956 20.5051534,16.565539 L17.8762883,19.5699562 C17.6944473,19.7777745 17.378566,19.7988332 17.1707477,19.6169922 C17.1540423,19.602375 17.1383289,19.5866616 17.1237117,19.5699562 L14.4948466,16.565539 C14.1758365,16.200956 14,15.7329761 14,15.2485298 L14,5 C14,3.8954305 14.8954305,3 16,3 Z"
                                                                fill="#000000" />
                                                        </g>
                                                    </svg>
                                                    <!--end::Svg Icon-->
                                                </span>
                                            </span>
                                            <span class="navi-text">অভিযোগ দায়ের করুন</span>
                                        </a>
                                    </li>

                                </ul>
                                <!--end::Nav-->
                            </div>
                            <!--end::Dropdown-->

                        </div>
                    @endif
                    @if ($isCourtUser)
                        <div class="dropdown">
                            <!--begin::Toggle-->
                            <div class="topbar-item" data-offset="10px,0px" data-menu-toggle="click"
                                data-toggle="tooltip" data-placement="right" title="" data-original-title=""
                                aria-haspopup="true">
                                <a href="{{ route('mobile.court.openclose') }}" class="navi-link">
                                    <div class="btn-dropdown mr-2 pulse pulse-primary"
                                        style="padding-left: 0 !important;">
                                        <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                            <i class="fas fa-landmark"></i>
                                            <p class="navi-text">কর্মসূচি প্রণয়ন</p>
                                        </span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endif

                    @if ($user->is_citizen)
                        @if (globalUserInfo()->citizen_type_id == 1)
                            <div class="dropdown">
                                <!--begin::Toggle-->
                                <div class="topbar-item" data-offset="10px,0px" data-menu-toggle="click"
                                    data-toggle="tooltip" data-placement="right" title="" data-original-title=""
                                    aria-haspopup="true">
                                    <a href="{{ route('gcc.citizen.certify.copy.list') }}" class="navi-link">
                                        <div class="btn-dropdown mr-2 pulse pulse-primary"
                                            style="padding-left: 0 !important;">
                                            <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                                <i class="fas fa-landmark"></i>
                                                <p class="navi-text">সার্টিফিকেট কপির আবেদন</p>
                                            </span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endif

                        <div class="dropdown">
                            <!--begin::Toggle-->
                            <div class="topbar-item cs_notification" data-toggle="dropdown" data-offset="10px,0px"
                                title="">

                                <div class=" btn-clean btn-dropdown mr-10">
                                    <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x"
                                        style="position: relative">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <path
                                                    d="M17,12 L18.5,12 C19.3284271,12 20,12.6715729 20,13.5 C20,14.3284271 19.3284271,15 18.5,15 L5.5,15 C4.67157288,15 4,14.3284271 4,13.5 C4,12.6715729 4.67157288,12 5.5,12 L7,12 L7.5582739,6.97553494 C7.80974924,4.71225688 9.72279394,3 12,3 C14.2772061,3 16.1902508,4.71225688 16.4417261,6.97553494 L17,12 Z"
                                                    fill="#000000" />
                                                <rect fill="#000000" opacity="0.3" x="10" y="16" width="4"
                                                    height="4" rx="2" />
                                            </g>
                                        </svg>
                                        <p class="navi-text">নোটিফিকেশন</p>
                                    </span>
                                    @if (!empty($certify_copy_fee_count_gcc_citizen) || !empty($hearing_count_gcc_citizen) || !empty($cancel_certify_copy))
                                        @if ($certify_copy_fee_count_gcc_citizen > 0 || $hearing_count_gcc_citizen > 0 || $cancel_certify_copy > 0)
                                            <span class="menu-label" style="position: absolute">
                                                <span class="label label-rounded label-danger "
                                                    data-notification={{ $certify_copy_fee_count_gcc_citizen + $hearing_count_gcc_citizen + $cancel_certify_copy }}>{{ en2bn($certify_copy_fee_count_gcc_citizen + $hearing_count_gcc_citizen + $cancel_certify_copy) }}</span>
                                            </span>
                                        @endif
                                    @endif

                                </div>
                            </div>




                            <!--begin::Dropdown-->
                            <div class="dropdown-menu p-0 m-0 dropdown-menu-anim-up dropdown-menu-sm dropdown-menu-right">
                                <!--begin::Nav-->
                                <ul class="navi navi-hover py-4">
                                    <!--begin::Item-->


                                    @if (!empty($certify_copy_fee_count_gcc_citizen) || !empty($hearing_count_gcc_citizen) || !empty($cancel_certify_copy))
                                        @if ($certify_copy_fee_count_gcc_citizen > 0)
                                            <li class="navi-item">
                                                <a href="{{ route('gcc.citizen.appeal.certify_copy_fee_case') }}"
                                                    class="navi-link ">

                                                    <span class="navi-text"> সার্টিফিকেট কপির ফি প্রদান</span>
                                                    <span class="menu-label">
                                                        <span
                                                            class="label label-rounded label-danger">{{ en2bn($certify_copy_fee_count_gcc_citizen) }}
                                                        </span>
                                                    </span>
                                                </a>
                                            </li>
                                        @endif

                                        @if ($hearing_count_gcc_citizen > 0)
                                            <li class="navi-item">
                                                <a href="{{ route('gcc.citizen.appeal.for.hearing') }}"
                                                    class="navi-link ">

                                                    <span class="navi-text"> শুনানি</span>
                                                    <span class="menu-label">
                                                        <span
                                                            class="label label-rounded label-danger">{{ en2bn($hearing_count_gcc_citizen) }}
                                                        </span>
                                                    </span>
                                                </a>
                                            </li>
                                        @endif

                                        @if ($cancel_certify_copy > 0)
                                            <li class="navi-item">
                                                <a href="{{ route('gcc.citizen.appeal.certify.copy.cancel') }}"
                                                    class="navi-link ">

                                                    <span class="navi-text"> সার্টিফিকেট আবেদন বাতিল</span>
                                                    <span class="menu-label">
                                                        <span
                                                            class="label label-rounded label-danger">{{ en2bn($cancel_certify_copy) }}
                                                        </span>
                                                    </span>
                                                </a>
                                            </li>
                                        @endif
                                    @else
                                        <li class="navi-item">
                                            <a class="navi-link ">

                                                <span class="navi-text text-danger"> কোন তথ্য নেই</span>

                                            </a>
                                        </li>
                                    @endif


                                    <!--end::Item-->
                                </ul>
                                <!--end::Nav-->
                            </div>
                            <!--end::Dropdown-->
                        </div>

                        {{-- @if ($user->citizen_type_id == 2)
                            <div class="dropdown">
                                <!--begin::Toggle-->
                                <div class="topbar-item" data-offset="10px,0px" data-menu-toggle="click"
                                    data-toggle="tooltip" data-placement="right" title="" data-original-title=""
                                    aria-haspopup="true">
                                    <a href="" class="navi-link">
                                        <div class="btn-dropdown mr-2 pulse pulse-primary"
                                            style="padding-left: 0 !important;">
                                            <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                                <i class="fas fa-landmark"></i>
                                                <p class="navi-text">মামলা ট্র্যাকিং</p>
                                                
                                            </span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endif --}}
                        <div class="dropdown">
                            <!--begin::Toggle-->
                            <div class="topbar-item" data-offset="10px,0px" data-menu-toggle="click"
                                data-toggle="tooltip" data-placement="right" title="" data-original-title=""
                                aria-haspopup="true">
                                <a href="{{ route('support.center.citizen') }}" class="navi-link">
                                    <div class="btn-dropdown mr-2 pulse pulse-primary"
                                        style="padding-left: 0 !important;">
                                        <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                            <i class="fas fa-landmark"></i>
                                            <p class="navi-text">সাপোর্ট</p>
                                        </span>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="dropdown">
                            <!--begin::Toggle-->
                            <div class="topbar-item" data-offset="10px,0px" data-menu-toggle="click"
                                data-toggle="tooltip" data-placement="right" title="" data-original-title=""
                                aria-haspopup="true">
                                <a href="{{ route('download.form') }}" class="navi-link">
                                    <div class="btn-dropdown mr-2 pulse pulse-primary"
                                        style="padding-left: 0 !important;">
                                        <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                            <i class="fas fa-landmark"></i>
                                            <p class="navi-text">ফর্ম ডাউনলোড</p>
                                        </span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endif


                    @if (in_array(2, $menu))
                        <div class="dropdown">
                            <!--begin::Toggle-->

                            <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px" title="">
                                <div
                                    class=" btn-clean btn-dropdown mr-2 {{ request()->is('admin/doptor/management/import/dortor/offices/search') ? 'menu-item-active' : '' }}">
                                    <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                        {{-- <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24" />
                                                <path
                                                    d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z"
                                                    fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                <path
                                                    d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z"
                                                    fill="#000000" fill-rule="nonzero" />
                                            </g>
                                        </svg> --}}
                                        <i class="fas fa-user"></i>
                                        <p class="navi-text">ইউজার</p>
                                    </span>
                                </div>
                            </div>

                            <!--begin::Dropdown-->
                            <div class="dropdown-menu p-0 m-0 dropdown-menu-anim-up dropdown-menu-sm dropdown-menu-right">
                                <!--begin::Nav-->
                                <ul class="navi navi-hover py-4">
                                    <!--begin::Item-->
                                    <li class="navi-item">
                                        <a href=" {{ route('admin.doptor.management.import.offices.search') }} "
                                            class="navi-link  ">
                                            <span class="symbol2 symbol-20 mr-3">
                                                <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                                    <i style="color: #3699ff; margin-top: 0 !important;"
                                                        class="fas fa-user"></i>
                                                    <!--end::Svg Icon-->
                                                </span>
                                            </span>
                                            <span class="navi-text">দপ্তর ইউজার</span>
                                        </a>
                                    </li>




                                    <!--end::Item-->
                                </ul>
                                <!--end::Nav-->
                            </div>
                            <!--end::Dropdown-->
                        </div>
                    @endif
                    @if ($isCourtUser)
                        <div class="dropdown">
                            <!--begin::Toggle-->
                            <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px" title="">
                                <div
                                    class=" btn-clean btn-dropdown mr-2 {{ request()->is('peshkar/adm/dm/list', 'doptor/user/management/office_list') ? 'menu-item-active' : '' }}">
                                    <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                        <i class="fas fa-gavel"></i>
                                        <p class="navi-text">কোর্ট পরিচালনা </p>
                                    </span>
                                </div>
                            </div>
                            <!--begin::Dropdown-->
                            <div class="dropdown-menu p-0 m-0 dropdown-menu-anim-up dropdown-menu-sm dropdown-menu-right">
                                <!--begin::Nav-->
                                <ul class="navi navi-hover py-4">
                                    <!--begin::Item-->
                                    <li class="navi-item">
                                        <a href="{{ route('mobile.court.prosecution.create.page') }}"
                                            class="navi-link  ">
                                            <span class="symbol2 symbol-20 mr-3">
                                                <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                                    <i style="color: #3699ff; margin-top: 0 !important;"
                                                        class="fas fa-user"></i>
                                                    <!--end::Svg Icon-->
                                                </span>
                                            </span>
                                            <span class="navi-text">স্বপ্রণোদিত কোর্ট</span>
                                        </a>
                                    </li>
                                    <li class="navi-item">
                                        <a href=" " class="navi-link  ">
                                            <span class="symbol2 symbol-20 mr-3">
                                                <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                                    <i style="color: #3699ff; margin-top: 0 !important;"
                                                        class="fas fa-user"></i>
                                                    <!--end::Svg Icon-->
                                                </span>
                                            </span>
                                            <span class="navi-text">অসম্পূর্ণ মামলা(স্বপ্রণোদিত)</span>
                                        </a>
                                    </li>
                                    <li class="navi-item">
                                        <a href=" " class="navi-link  ">
                                            <span class="symbol2 symbol-20 mr-3">
                                                <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                                    <i style="color: #3699ff; margin-top: 0 !important;"
                                                        class="fas fa-user"></i>
                                                    <!--end::Svg Icon-->
                                                </span>
                                            </span>
                                            <span class="navi-text">আসামি ছাড়া মামলা</span>

                                        </a>


                                    </li>
                                    <li class="navi-item">
                                        <a href="" class="navi-link  ">
                                            <span class="symbol2 symbol-20 mr-3">
                                                <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                                    <i style="color: #3699ff; margin-top: 0 !important;"
                                                        class="fas fa-user"></i>
                                                    <!--end::Svg Icon-->
                                                </span>
                                            </span>
                                            <span class="navi-text">প্রসিকিউশনের তালিকা</span>
                                        </a>
                                    </li>
                                    <li class="navi-item">
                                        <a href=" " class="navi-link  ">
                                            <span class="symbol2 symbol-20 mr-3">
                                                <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                                    <i style="color: #3699ff; margin-top: 0 !important;"
                                                        class="fas fa-user"></i>
                                                    <!--end::Svg Icon-->
                                                </span>
                                            </span>
                                            <span class="navi-text">অসম্পূর্ণ মামলা(প্রসিকিউশনসহ)</span>
                                        </a>
                                    </li>
                                    <li class="navi-item">
                                        <a href="" class="navi-link  ">
                                            <span class="symbol2 symbol-20 mr-3">
                                                <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                                    <i style="color: #3699ff; margin-top: 0 !important;"
                                                        class="fas fa-user"></i>
                                                    <!--end::Svg Icon-->
                                                </span>
                                            </span>
                                            <span class="navi-text">মামলার তথ্য</span>
                                        </a>
                                    </li>
                                    <!--end::Item-->
                                </ul>
                                <!--end::Nav-->
                            </div>
                            <!--end::Dropdown-->
                        </div>
                    @endif





                    @if ($user->role_id == 2)
                        <div class="dropdown">
                            <!--begin::Toggle-->
                            <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px" title="">
                                <div
                                    class=" btn-clean btn-dropdown mr-2 {{ request()->is('peshkar/adm/dm/list', 'doptor/user/management/office_list') ? 'menu-item-active' : '' }}">
                                    <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                        <i class="fas fa-landmark"></i>
                                        <p class="navi-text"> দাপ্তরিক</p>
                                    </span>
                                </div>
                            </div>
                            <!--begin::Dropdown-->
                            <div class="dropdown-menu p-0 m-0 dropdown-menu-anim-up dropdown-menu-sm dropdown-menu-right">
                                <!--begin::Nav-->
                                <ul class="navi navi-hover py-4">

                                    <li class="navi-item">
                                        <a href="{{ route('mc_sottogolpo.index') }}" class="navi-link  ">
                                            <span class="symbol2 symbol-20 mr-3">
                                                <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                                    <i style="color: #3699ff; margin-top: 0 !important;"
                                                        class="fas fa-user"></i>
                                                    <!--end::Svg Icon-->
                                                </span>
                                            </span>
                                            <span class="navi-text">গল্পের তালিকা</span>
                                        </a>
                                    </li>
                                    <li class="navi-item">
                                        <a href="{{ route('jurisdiction.determination') }}" class="navi-link  ">
                                            <span class="symbol2 symbol-20 mr-3">
                                                <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                                    <i style="color: #3699ff; margin-top: 0 !important;"
                                                        class="fas fa-user"></i>
                                                    <!--end::Svg Icon-->
                                                </span>
                                            </span>
                                            <span class="navi-text">অধিক্ষেত্র নির্ধারণ</span>
                                        </a>
                                    </li>
                                    <li class="navi-item">
                                        <a href="{{ route('mobile.court.mamla.cnacel') }}" class="navi-link  ">
                                            <span class="symbol2 symbol-20 mr-3">
                                                <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                                    <i style="color: #3699ff; margin-top: 0 !important;"
                                                        class="fas fa-user"></i>
                                                    <!--end::Svg Icon-->
                                                </span>
                                            </span>
                                            <span class="navi-text"> মামলা বাতিল </span>
                                        </a>
                                    </li>

                                    {{-- Report --}}

                                    @if (in_array(35, $menu))
                                        <li class="navi-item dropdown-submenu">
                                            <a href="#" class="navi-link dropdown-toggle" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                <span class="symbol2 symbol-20 mr-3">
                                                    <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                                        <i style="color: #3699ff; margin-top: 0 !important;"
                                                            class="fas fa-user"></i>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                                <span class="navi-text">প্রতিবেদন</span>
                                            </a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item"
                                                    href="{{ route('gcc.report.index') }}">GCC-প্রতিবেদন</a>
                                                <a class="dropdown-item" href="{{ route('emc-report') }}">
                                                    EMC-প্রতিবেদন</a>
                                                <a class="dropdown-item" href="{{ route('mc.monthly_report') }}">
                                                    MC-প্রতিবেদন</a>

                                            </div>
                                        </li>
                                    @endif
                                    <!--end::Item-->
                                </ul>
                                <!--end::Nav-->
                            </div>
                            <!--end::Dropdown-->
                        </div>
                    @endif


                    <div class="topbar-item">
                        <div class="btn-mobile w-auto btn-clean d-flex align-items-center btn-sm px-2"
                            id="kt_quick_user_toggle" style="margin-top: 3px">
                            <span class="text-muted font-size-base d-none d-md-inline mr-1">
                                @if (Auth::user()->profile_pic != null)
                                    @if (Auth::user()->doptor_user_flag == 1)
                                        <img src="{{ Auth::user()->profile_pic }}">
                                    @else
                                        <img src="{{ url('/') }}/uploads/profile/{{ Auth::user()->profile_pic }}">
                                    @endif
                                @else
                                    <img src="{{ url('/') }}/uploads/profile/default.jpg">
                                @endif

                            </span>
                            <span class="text-dark font-size-base d-none d-md-inline mr-3 text-left">
                                <i style="float: right; padding-left: 20px; padding-top: 12px;"
                                    class="fas fa-chevron-down"></i>
                                <b>
                                    @if (count($nameWords) > 2)
                                        {{ $nameWords[0] }} {{ $nameWords[1] }}
                                    @else
                                        {{ auth()->user()->name }}
                                    @endif
                                </b>
                                @if (Auth::user()->is_citizen == 0 && Auth::user()->role_id != null)
                                    <br>{{ Auth::user()->role->role_name }}
                                @else
                                    <br>{{ citizen_type_name_by_type(Auth::user()->citizen_type_id) }}
                                @endif

                            </span>

                        </div>
                    </div>



                    @if (in_array(2, $menu))
                        <div class="dropdown">
                            <!--begin::Toggle-->
                            <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px" title="">
                                <div
                                    class=" btn-clean btn-dropdown mr-2 {{ request()->is('peshkar/adm/dm/list', 'doptor/user/management/office_list') ? 'menu-item-active' : '' }}">
                                    <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                        <i class="fas fa-gavel"></i>
                                        <p class="navi-text">আর্কাইভ</p>
                                    </span>
                                </div>
                            </div>
                            <!--begin::Dropdown-->
                            <div class="dropdown-menu p-0 m-0 dropdown-menu-anim-up dropdown-menu-sm dropdown-menu-right">
                                <!--begin::Nav-->
                                <ul class="navi navi-hover py-4">
                                    <!--begin::Item-->
                                    <li class="navi-item dropdown-submenu">
                                        <a href="#" class="navi-link dropdown-toggle" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">

                                            <span class="navi-text">EMC-আর্কাইভ</span>
                                        </a>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('emc.closed_list') }}">নিষ্পত্তিকৃত
                                                মামলা</a>
                                            <a class="dropdown-item" href="{{ route('emc.old_closed_list') }}">পুরাতন
                                                নিষ্পত্তিকৃত মামলা</a>

                                        </div>
                                    </li>
                                    <li class="navi-item dropdown-submenu">
                                        <a href="#" class="navi-link dropdown-toggle" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">

                                            <span class="navi-text">GCC-আর্কাইভ</span>
                                        </a>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('gcc.closed_list') }}">নিষ্পত্তিকৃত
                                                মামলা</a>
                                            <a class="dropdown-item" href="{{ route('gcc.old_closed_list') }}">পুরাতন
                                                নিষ্পত্তিকৃত মামলা</a>

                                        </div>
                                    </li>


                                    <!--end::Item-->
                                </ul>
                                <!--end::Nav-->
                            </div>
                            <!--end::Dropdown-->
                        </div>
                    @endif


                    @if (in_array(40, $menu))
                        <div class="dropdown">
                            <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px" title="">
                                <div
                                    class=" btn-clean btn-dropdown mr-2 {{ request()->is('peshkar/adm/dm/list', 'doptor/user/management/office_list') ? 'menu-item-active' : '' }}">
                                    <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                        <i class="fas fa-cog"></i>
                                        <p class="navi-text">সেটিংস</p>
                                    </span>
                                </div>
                            </div>
                            <div class="dropdown-menu p-0 m-0 dropdown-menu-anim-up dropdown-menu-sm dropdown-menu-right">
                                <!--begin::Nav-->
                                <ul class="navi navi-hover py-4">
                                    @if (in_array(100, $menu))
                                        <li class="navi-item dropdown-submenu">
                                            <a href="#" class="navi-link dropdown-toggle" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">

                                                <span class="navi-text">সংক্ষিপ্ত আদেশ</span>
                                            </a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item"
                                                    href="{{ route('gcc.settings.short-decision') }}"> GCC-সংক্ষিপ্ত
                                                    আদেশ</a>
                                                <a class="dropdown-item" href="{{ route('emc.short-decision') }}">
                                                    EMC-সংক্ষিপ্ত আদেশ</a>

                                            </div>
                                        </li>
                                    @endif

                                    @if (in_array(101, $menu))
                                        <li class="navi-item dropdown-submenu">
                                            <a href="#" class="navi-link dropdown-toggle" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">

                                                <span class="navi-text">গৃহীত ব্যবস্থা</span>
                                            </a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item"
                                                    href="{{ route('certificate_asst.short.decision') }}">GCC-গৃহীত
                                                    ব্যবস্থা</a>
                                                <a class="dropdown-item" href="{{ route('peshkar.short.decision') }}">
                                                    EMC-গৃহীত ব্যবস্থা</a>

                                            </div>
                                        </li>
                                    @endif


                                    {{-- Adalot settings --}}

                                    @if (in_array(102, $menu))
                                        <li class="navi-item dropdown-submenu">
                                            <a href="#" class="navi-link dropdown-toggle" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">

                                                <span class="navi-text">আদালত</span>
                                            </a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('gcc.court') }}">GCC-আদালত</a>
                                                <a class="dropdown-item" href="{{ route('emc.court') }}"> EMC-আদালত</a>

                                            </div>
                                        </li>
                                    @endif




                                    {{-- Mamla Nirikkha --}}
                                    @if (in_array(35, $menu))
                                        <li class="navi-item dropdown-submenu">
                                            <a href="#" class="navi-link dropdown-toggle" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">

                                                <span class="navi-text">মামলা নিরীক্ষা</span>
                                            </a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('gcc.log_index') }}">GCC-মামলা
                                                    নিরীক্ষা</a>
                                                <a class="dropdown-item" href="{{ route('emc.log_index') }}"> EMC-মামলা
                                                    নিরীক্ষা</a>

                                            </div>
                                        </li>
                                    @endif


                                    {{-- Emc News --}}

                                    @if (in_array(35, $menu))
                                        <li class="navi-item dropdown-submenu">
                                            <a href="#" class="navi-link dropdown-toggle" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">

                                                <span class="navi-text">ফিচার নিউজ</span>
                                            </a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('gcc.news') }}">GCC-ফিচার
                                                    নিউজ</a>
                                                <a class="dropdown-item" href="{{ route('emc.news') }}"> EMC-ফিচার
                                                    নিউজ</a>

                                            </div>
                                        </li>
                                    @endif

                                    {{-- Register --}}

                                    @if (in_array(35, $menu))
                                        <li class="navi-item dropdown-submenu">
                                            <a href="#" class="navi-link dropdown-toggle" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">

                                                <span class="navi-text">রেজিস্টার</span>
                                            </a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item"
                                                    href="{{ route('gcc.register.list') }}">GCC-রেজিস্টার</a>
                                                <a class="dropdown-item" href="{{ route('emc.register.list') }}">
                                                    EMC-রেজিস্টার</a>
                                                <a class="dropdown-item" href="{{ route('mc.registerlist') }}">
                                                    MC-রেজিস্টার</a>

                                            </div>
                                        </li>
                                    @endif


                                    <li class="navi-item dropdown-submenu">
                                        <a href="#" class="navi-link dropdown-toggle" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">

                                            <span class="navi-text">আইন ও ধারা </span>
                                        </a>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('mc.law.index') }}">আইন /বিধিমালা</a>
                                            <a class="dropdown-item" href="{{ route('mc.section.index') }}">ধারা /
                                                বিধি</a>

                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @endif


                    @if ($user->role_id == 2)
                        <div class="dropdown">
                            <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px" title="">
                                <div
                                    class=" btn-clean btn-dropdown mr-2 {{ request()->is('peshkar/adm/dm/list', 'doptor/user/management/office_list') ? 'menu-item-active' : '' }}">
                                    <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                        {{-- <i class="fas fa-cog"></i> --}}
                                        {{--  <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <path
                                                d="M17,12 L18.5,12 C19.3284271,12 20,12.6715729 20,13.5 C20,14.3284271 19.3284271,15 18.5,15 L5.5,15 C4.67157288,15 4,14.3284271 4,13.5 C4,12.6715729 4.67157288,12 5.5,12 L7,12 L7.5582739,6.97553494 C7.80974924,4.71225688 9.72279394,3 12,3 C14.2772061,3 16.1902508,4.71225688 16.4417261,6.97553494 L17,12 Z"
                                                fill="#000000" />
                                            <rect fill="#000000" opacity="0.3" x="10" y="16" width="4"
                                                height="4" rx="2" />
                                        </g>
                                    </svg> --}}
                                        <p class="navi-text">নোটিফিকেশন</p>
                                    </span>
                                </div>
                            </div>
                            <div class="dropdown-menu p-0 m-0 dropdown-menu-anim-up dropdown-menu-sm dropdown-menu-right">
                                <!--begin::Nav-->
                                <ul class="navi navi-hover py-4">

                                    <li class="navi-item ">
                                        <a href="{{ route('misnotification.levelConfig', ['level' => 1]) }}"
                                            class="navi-link">

                                            <span class="navi-text">প্রথম পর্যায় নোটিফিকেশন</span>
                                        </a>
                                        <a href="{{ route('misnotification.levelConfig', ['level' => 2]) }}"
                                            class="navi-link">

                                            <span class="navi-text"> দ্বিতীয় পর্যায় নোটিফিকেশন</span>
                                        </a>
                                        <a href="{{ route('misnotification.levelConfig', ['level' => 3]) }}"
                                            class="navi-link">

                                            <span class="navi-text"> তৃতীয় পর্যায় নোটিফিকেশন</span>
                                        </a>
                                        <a href="{{ route('misnotification.pendingReportList') }}" class="navi-link">

                                            <span class="navi-text"> নোটিফিকেশন প্রেরন</span>
                                        </a>
                                        <a href="{{ route('misnotification.approvedReportList') }}" class="navi-link">

                                            <span class="navi-text">অনুমোদন বাতিল</span>
                                        </a>
                                      
                                       
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @endif

                    {{-- @dd (in_array(28, $menu)) --}}
                    @if ($user->role_id == 2)
                        <div class="dropdown">
                            <!--begin::Toggle-->

                            <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px" title="">
                                <div
                                    class=" btn-clean btn-dropdown mr-2 {{ request()->is('register/list', 'citizen/appeal/cause_list', 'support/center', 'log_index' . 'calendar', 'report') ? 'menu-item-active' : '' }}">
                                    <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            width="24px" height="24px" viewBox="0 0 24 24" version="1.1">

                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24" />
                                                <circle fill="#000000" cx="12" cy="5" r="2" />
                                                <circle fill="#000000" cx="12" cy="12" r="2" />
                                                <circle fill="#000000" cx="12" cy="19" r="2" />
                                            </g>
                                        </svg>
                                        <p class="navi-text">অন্যান্য</p>

                                    </span>
                                </div>
                            </div>
                            <div class="dropdown-menu p-0 m-0 dropdown-menu-anim-up dropdown-menu-sm dropdown-menu-right">
                                <!--begin::Nav-->
                                <ul class="navi navi-hover py-4">
                                    <!--begin::Item-->
                                    @if (in_array(2, $menu))
                                        <li class="navi-item dropdown-submenu">
                                            <a href="#" class="navi-link dropdown-toggle" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">

                                                <span class="navi-text">ইউজারের তথ্য</span>
                                            </a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('gcc.user.list') }}">
                                                    GCC-ইউজার</a>
                                                <a class="dropdown-item" href="{{ route('emc.user.list') }}">
                                                    EMC-ইউজার</a>
                                                <a class="dropdown-item" href="{{ route('mc.user.list') }}">
                                                    MC-ইউজার</a>

                                            </div>
                                        </li>

                                        <li class="navi-item">
                                            <a href="{{ route('setting.emc.crpcsection') }}"
                                                class="navi-link {{ request()->is('support/center') ? 'menu-item-active' : '' }}">

                                                <span class="navi-text">ফৌজদারি কার্যবিধি আইনের সংশ্লিষ্ট ধারা</span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a href="{{ route('download.form') }}"
                                                class="navi-link {{ request()->is('gcc/download/form') ? 'menu-item-active' : '' }}">

                                                <span class="navi-text">ফর্ম ডাউনলোড</span>
                                            </a>
                                        </li>
                                    @endif

                                    <!--end::Item-->
                                </ul>
                                <!--end::Nav-->
                            </div>

                        </div>
                    @endif

                    {{-- @endif --}}
                @elseif (Auth::guard('parent_office')->check())
                    @if (in_array(1, $menu))
                        <div class="dropdown">
                            <!--begin::Toggle-->
                            <div class="topbar-item" data-offset="10px,0px" data-menu-toggle="click"
                                data-toggle="tooltip" data-placement="right" title data-original-title=""
                                aria-haspopup="true">

                                <a href="{{ route('dashboard.index', session('court_type_id') ?? '') }}"
                                    class="navi-link  ">
                                    <div class="btn-dropdown mr-2 pulse pulse-primary"
                                        style="padding-left: 0 !important;">
                                        <span class="svg-icon auth-svg-icon-bar svg-icon-xl svg-icon-primary">
                                            <!--begin::Svg Icon | path:assets/media/svg/icons/Code/Compiling.svg-->

                                            <i class="fa fa-home"></i>
                                            <p class="navi-text">ড্যাশবোর্ড </p>
                                        </span>
                                        <span class="pulse-ring"></span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endif

                    <div class="topbar-item">
                        <div class="btn  -mobile w-auto btn-clean d-flex align-items-center btn-sm px-2"
                            id="kt_quick_user_toggle" style="margin: -12px">
                            <span class="text-muted font-size-base d-none d-md-inline mr-1">
                                <img src="{{ url('/') }}/uploads/profile/default.jpg">


                            </span>
                            <span class="text-dark font-size-base d-none d-md-inline mr-3 text-left">
                                <i style="float: right; padding-left: 20px; padding-top: 12px;"
                                    class="fas fa-chevron-down"></i>
                                <b>
                                    {{ Auth::guard('parent_office')->user()->name_bn }}
                                </b>


                                <br>{{-- Auth::user()->role->role_name --}}
                            </span>

                        </div>
                    </div>
                @else
                    <div class="tpbar_text_menu topbar-item mr-2">
                        <div class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-2"
                            id="kt_quick_user_toggle">
                            <a href="" class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">ধারা
                                ভিত্তিক অভিযোগের ধরণ</a>
                        </div>
                    </div>
                    <div class="tpbar_text_menu topbar-item mr-2">
                        <div class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-2"
                            id="kt_quick_user_toggle">
                            <a href="" class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">প্রসেস
                                ম্যাপ</a>
                        </div>
                    </div>
                    <div class="tpbar_text_menu tpbar_text_mlast topbar-item mr-8">
                        <div class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-2"
                            id="kt_quick_user_toggle">
                            <a href="" class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">আইন ও
                                বিধি</a>
                        </div>
                    </div>
                    <div class="topbar-item">
                        <div class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-2"
                            id="topbar_social_icon">
                            <a href="" class="social-svg-icon svg-icon-primary svg-icon-2x">
                                <svg style="color: rgb(109, 91, 220);" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 320 512">Copyright 2022 Fonticons, Inc. --><path
                                        d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"
                                        fill="#6d5bdc"></path></svg>
                            </a>
                        </div>
                    </div>

                    <div class="topbar-item">
                        <div class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-2"
                            id="topbar_social_icon">
                            <a href="" class="social-svg-icon svg-icon-primary svg-icon-2x">
                                <svg style="color: rgb(108, 90, 220);" xmlns="http://www.w3.org/2000/svg" width="16"
                                    height="16" fill="currentColor" class="bi bi-twitter" viewBox="0 0 16 16">
                                    <path
                                        d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"
                                        fill="#6c5adc"></path>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <div class="topbar-item mr-8">
                        <div class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-2"
                            id="topbar_social_icon">
                            <a href="" class="social-svg-icon svg-icon-primary svg-icon-2x">
                                <svg style="color: rgb(108, 90, 220);" xmlns="http://www.w3.org/2000/svg" width="16"
                                    height="16" fill="currentColor" class="bi bi-youtube" viewBox="0 0 16 16">
                                    <path
                                        d="M8.051 1.999h.089c.822.003 4.987.033 6.11.335a2.01 2.01 0 0 1 1.415 1.42c.101.38.172.883.22 1.402l.01.104.022.26.008.104c.065.914.073 1.77.074 1.957v.075c-.001.194-.01 1.108-.082 2.06l-.008.105-.009.104c-.05.572-.124 1.14-.235 1.558a2.007 2.007 0 0 1-1.415 1.42c-1.16.312-5.569.334-6.18.335h-.142c-.309 0-1.587-.006-2.927-.052l-.17-.006-.087-.004-.171-.007-.171-.007c-1.11-.049-2.167-.128-2.654-.26a2.007 2.007 0 0 1-1.415-1.419c-.111-.417-.185-.986-.235-1.558L.09 9.82l-.008-.104A31.4 31.4 0 0 1 0 7.68v-.123c.002-.215.01-.958.064-1.778l.007-.103.003-.052.008-.104.022-.26.01-.104c.048-.519.119-1.023.22-1.402a2.007 2.007 0 0 1 1.415-1.42c.487-.13 1.544-.21 2.654-.26l.17-.007.172-.006.086-.003.171-.007A99.788 99.788 0 0 1 7.858 2h.193zM6.4 5.209v4.818l4.157-2.408L6.4 5.209z"
                                        fill="#6c5adc"></path>
                                </svg>
                            </a>
                        </div>
                    </div>




                    <div class="topbar-item">
                        <div class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-2"
                            id="kt_quick_user_toggle">
                            <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                <svg style="color: rgb(108, 90, 220);" xmlns="http://www.w3.org/2000/svg" width="16"
                                    height="16" fill="currentColor" class="bi bi-play-fill" viewBox="0 0 16 16">
                                    <path
                                        d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393z"
                                        fill="#6c5adc"></path>
                                </svg>
                                <!--end::Svg Icon-->
                            </span><b> Online Course</b>
                            <!-- <input type="button" id="loginID" class="btn btn-info" value="{{ __('লগইন') }}"
                                                                                                                                                                                                                                                                data-toggle="modal" data-target="#exampleModalLong"> -->
                        </div>
                    </div>
                    <div class="topbar-item">
                        <div class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-2"
                            id="kt_quick_user_toggle">
                            <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24" />
                                        <path
                                            d="M12,22 C6.4771525,22 2,17.5228475 2,12 C2,6.4771525 6.4771525,2 12,2 C17.5228475,2 22,6.4771525 22,12 C22,17.5228475 17.5228475,22 12,22 Z M11.613922,13.2130341 C11.1688026,13.6581534 10.4887934,13.7685037 9.92575695,13.4869855 C9.36272054,13.2054673 8.68271128,13.3158176 8.23759191,13.760937 L6.72658218,15.2719467 C6.67169475,15.3268342 6.63034033,15.393747 6.60579393,15.4673862 C6.51847004,15.7293579 6.66005003,16.0125179 6.92202169,16.0998418 L8.27584113,16.5511149 C9.57592638,16.9844767 11.009274,16.6461092 11.9783003,15.6770829 L15.9775173,11.6778659 C16.867756,10.7876271 17.0884566,9.42760861 16.5254202,8.3015358 L15.8928491,7.03639343 C15.8688153,6.98832598 15.8371895,6.9444475 15.7991889,6.90644684 C15.6039267,6.71118469 15.2873442,6.71118469 15.0920821,6.90644684 L13.4995401,8.49898884 C13.0544207,8.94410821 12.9440704,9.62411747 13.2255886,10.1871539 C13.5071068,10.7501903 13.3967565,11.4301996 12.9516371,11.8753189 L11.613922,13.2130341 Z"
                                            fill="#000000" />
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span><b>333</b>
                            <!-- <a href="{{ url('/citizenRegister') }}" type="button" class="btn btn-info"
                                                                                                                                                                                                                                                                value="">{{ __('নাগরিক নিবন্ধন') }}</a> -->
                        </div>
                    </div>
                @endauth
                <!--end::User-->
            </div>
        </div>
        <!--end::Topbar-->
    </div>
    {{-- @else
     @include('mobile_first_registration.non_verified_account_header')
    @endif --}}

    <!--end::Container-->
</div>
