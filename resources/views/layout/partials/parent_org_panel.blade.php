@if (Auth::guard('parent_office')->check())
    <div id="kt_quick_user" class="offcanvas offcanvas-right p-10">
        <!--begin::Header-->
        <div class="offcanvas-header d-flex align-items-center justify-content-between pb-5">
            <h3 class="font-weight-bolder m-0">ইউজার প্রোফাইল
                <!-- <small class="text-muted font-size-sm ml-2">12 messages</small> -->
            </h3>
            <a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_user_close">
                <i class="ki ki-close icon-xs text-muted"></i>
            </a>
        </div>
        <!--end::Header-->
        <div class="offcanvas-content pr-5 mr-n5">
            <!--begin::Header-->
            <div class="d-flex align-items-center mt-5">
                <div class="symbol symbol-100 mr-5">
                    
                        <div class="symbol-label"><img src="{{ url('/') }}/uploads/profile/default.jpg" width="90"
                                height="90"></div>
                  
                </div>
                <div class="d-flex flex-column">
                    {{-- route('my-profile.index') --}}
                    <a href="" class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary">
                        {{Auth::guard('parent_office')->user()->name_bn}}</a>
                    <div class="text-muted mt-1"><?php //auth()->user()->role->role_name
                    ?></div>
                    
                    <div class="navi mt-2">
                        <a href="#" class="navi-item">
                            <span class="navi-link p-0 pb-2">
                                <span class="navi-icon mr-1">
                                    <span class="svg-icon svg-icon-lg svg-icon-primary">
                                        <!--begin::Svg Icon | path:media/svg/icons/Communication/Mail-notification.svg-->
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24" />
                                                <path
                                                    d="M21,12.0829584 C20.6747915,12.0283988 20.3407122,12 20,12 C16.6862915,12 14,14.6862915 14,18 C14,18.3407122 14.0283988,18.6747915 14.0829584,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,8 C3,6.8954305 3.8954305,6 5,6 L19,6 C20.1045695,6 21,6.8954305 21,8 L21,12.0829584 Z M18.1444251,7.83964668 L12,11.1481833 L5.85557487,7.83964668 C5.4908718,7.6432681 5.03602525,7.77972206 4.83964668,8.14442513 C4.6432681,8.5091282 4.77972206,8.96397475 5.14442513,9.16035332 L11.6444251,12.6603533 C11.8664074,12.7798822 12.1335926,12.7798822 12.3555749,12.6603533 L18.8555749,9.16035332 C19.2202779,8.96397475 19.3567319,8.5091282 19.1603533,8.14442513 C18.9639747,7.77972206 18.5091282,7.6432681 18.1444251,7.83964668 Z"
                                                    fill="#000000" />
                                                <circle fill="#000000" opacity="0.3" cx="19.5" cy="17.5"
                                                    r="2.5" />
                                            </g>
                                        </svg>
                                        <!--end::Svg Icon-->
                                    </span>
                                </span>
                                <span class="navi-text text-muted text-hover-primary">{{Auth::guard('parent_office')->user()->org_email}}</span>
                            </span>
                        </a>

                    </div>
                </div>
            </div>

            <!--end::Header-->

            <div class="separator separator-dashed mt-8 mb-5"> </div>
            <!--end::Separator-->
            <!--begin::Nav-->
            <div class="navi navi-spacer-x-0 p-0">
                <!--begin::Item-->
                {{-- route('my-profile.basic_edit') --}}
                <a href="" class="navi-item">
                    <div class="navi-link">
                        <div class="symbol symbol-40 bg-light mr-3">
                            <div class="symbol-label">
                                <span class="svg-icon svg-icon-md svg-icon-success">

                                    <i class="fa fa-id-card" aria-hidden="true"></i>

                                    <!--end::Svg Icon-->
                                </span>
                            </div>
                        </div>
                        <div class="navi-text">
                            <div class="font-weight-bold">প্রোফাইল বেসিক</div>
                            <div class="text-muted">একাউন্ট সেটিংস
                            </div>
                        </div>
                    </div>
                </a>
                {{-- route('my-profile.imageUpload') --}}
                <a href="" class="navi-item">
                    <div class="navi-link">
                        <div class="symbol symbol-40 bg-light mr-3">
                            <div class="symbol-label">
                                <span class="svg-icon svg-icon-md svg-icon-success">

                                    <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24"
                                        stroke-linecap="round" stroke-linejoin="round" height="1em" width="1em"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>

                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24" />
                                        <path
                                            d="M13.2070325,4 C13.0721672,4.47683179 13,4.97998812 13,5.5 C13,8.53756612 15.4624339,11 18.5,11 C19.0200119,11 19.5231682,10.9278328 20,10.7929675 L20,17 C20,18.6568542 18.6568542,20 17,20 L7,20 C5.34314575,20 4,18.6568542 4,17 L4,7 C4,5.34314575 5.34314575,4 7,4 L13.2070325,4 Z"
                                            fill="#000000" />
                                        <circle fill="#000000" opacity="0.3" cx="18.5" cy="5.5" r="2.5" />
                                    </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>
                            </div>
                        </div>
                        <div class="navi-text">
                            <div class="font-weight-bold">প্রোফাইল ইমেজ</div>
                            <div class="text-muted">ইমেজ আপডেট
                            </div>
                        </div>
                    </div>
                </a>
                {{-- route('change.password.logged.in') --}}
                <a href="" class="navi-item">
                    <div class="navi-link">
                        <div class="symbol symbol-40 bg-light mr-3">
                            <div class="symbol-label">
                                <span class="svg-icon svg-icon-md svg-icon-success">

                                    <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24"
                                        stroke-linecap="round" stroke-linejoin="round" height="1em" width="1em"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4">
                                        </path>
                                    </svg>
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24" />
                                        <path
                                            d="M13.2070325,4 C13.0721672,4.47683179 13,4.97998812 13,5.5 C13,8.53756612 15.4624339,11 18.5,11 C19.0200119,11 19.5231682,10.9278328 20,10.7929675 L20,17 C20,18.6568542 18.6568542,20 17,20 L7,20 C5.34314575,20 4,18.6568542 4,17 L4,7 C4,5.34314575 5.34314575,4 7,4 L13.2070325,4 Z"
                                            fill="#000000" />
                                        <circle fill="#000000" opacity="0.3" cx="18.5" cy="5.5" r="2.5" />
                                    </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>
                            </div>
                        </div>
                        <div class="navi-text">
                            <div class="font-weight-bold">পাসওয়ার্ড</div>
                            <div class="text-muted">পাসওয়ার্ড রিসেট
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <!--end::Nav-->
            <!--begin::Separator-->
            <div class="separator separator-dashed my-7"></div>

            {{-- route('custom_logout') --}}



            <a href="{{ route('logout.custom') }}" class="btn btn-sm btn-light-primary font-weight-bolder py-2 px-5"
                style="background-color:#bb2d3b "
                onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                <span class="svg-icon svg-icon-md svg-icon-success text-white">
                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512"
                        height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                        <path d="M192 277.4h189.7l-43.6 44.7L368 352l96-96-96-96-31 29.9 44.7 44.7H192v42.8z"></path>
                        <path
                            d="M255.7 421.3c-44.1 0-85.5-17.2-116.7-48.4-31.2-31.2-48.3-72.7-48.3-116.9 0-44.1 17.2-85.7 48.3-116.9 31.2-31.2 72.6-48.4 116.7-48.4 44 0 85.3 17.1 116.5 48.2l30.3-30.3c-8.5-8.4-17.8-16.2-27.7-23.2C339.7 61 298.6 48 255.7 48 141.2 48 48 141.3 48 256s93.2 208 207.7 208c42.9 0 84-13 119-37.5 10-7 19.2-14.7 27.7-23.2l-30.2-30.2c-31.1 31.1-72.5 48.2-116.5 48.2zM448.004 256.847l-.849-.848.849-.849.848.849z">
                        </path>
                    </svg>
                    &nbsp;
                </span>
                <span class="text-white">{{ __('লগ আউট') }}</span>
            </a>
            <form id="logout-form" action="{{ route('logout.custom') }}" method="POST" class="d-none">
                @csrf
            </form>

        </div>
    </div>
@endif