<div class="sticky bg-white z-30 top-0 w-full px-5 bg-white py-1 lg:py-3 rounded-sm flex justify-between shadow-lg">
    <div style="display: flex; align-items: center">
        <a href="{{ route('home.index') }}">
            <img class="w-[7em] h-[2em] lg:w-[15.5625em] lg:h-[4.75em]" src="{{ asset('images/logo_court.jpeg') }}"
                alt="E-Court" width="100%" height="100%" />
        </a>

    </div>
    <ul class="items-center gap-8 [&>li>a]:text-[16px] hidden lg:flex me-7">

        <li><a class="text-[16px]" href="{{ route('mc_citizen_public_view.new') }}">মোবাইল কোর্টের অপরাধের
                তথ্য</a></li>
        <li><a href="#">প্রসেস ম্যাপ</a></li>
        <li><a href="{{ URL('http://bdlaws.minlaw.gov.bd/act-98.html') }}" target="_blank">আইন ও বিধি</a>
        </li>
        <li>
            <a href="tel:+333" class="flex items-center gap-2">
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
        </li>
        <li class="mt-1">
            {{-- <a class="bg-[#0BA14A] text-white px-8 py-2 rounded-md"
                            href="{{ route('show_log_in_page') }}">লগইন</a> --}}

        </li>
        <li class="mt-1">
            {{--  <a class="bg-[#0BA14A] text-white px-8 py-2 rounded-md"
                            href="{{ route('citizen.registration') }}">নিবন্ধন</a> --}}

            <div class="relative inline-block text-left">
                <div>
                    <button id="dropdown-button" type="button"
                        class="inline-flex justify-center items-center rounded-full border border-[#00984F] shadow-sm px-4 py-2 bg-[#00984F] text-sm font-medium text-white hover:bg-[#00984F] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-[#00984F] focus:ring-yellow-500 py-[4px]"
                        aria-haspopup="true" aria-expanded="">
                        <span id="dropdown-selected-option" class="w-full text-left overflow-hidden flex-1">প্রশাসনিক
                            লগইন</span>
                        <svg id="caret" class="ml-2.5 -mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M6.293 7.293a1 1 0 011.414 0L10 9.586l2.293-2.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
                <div id="dropdown-menu"
                    class="origin-top-right absolute w-full left-0 mt-4 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none bg-white hidden z-10"
                    role="menu" aria-orientation="vertical" aria-labelledby="dropdown-button" tabindex="-1" >
                    <div class="py-3 px-3 text-black flex flex-col items-stretch space-y-3" role="none">
                        <a href="{{route('nothi.v2.login')}}" id="dropdown-button" type="button"
                            class="inline-flex justify-center items-center rounded-full border border-[#00984F] shadow-sm px-4 py-2 bg-[#00984F] text-sm font-medium text-white hover:bg-[#00984F] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-[#00984F] focus:ring-yellow-500 py-[4px] w-full">
                            <span id="dropdown-selected-option" class="w-full text-center overflow-hidden flex-1">কোর্ট
                                লগইন</span>
                        </a>
                        <a href="{{route('show_admin_log_in_page')}}" id="dropdown-button" type="button"
                            class="inline-flex justify-center items-center rounded-full border border-[#00984F] shadow-sm px-4 py-2 bg-[#00984F] text-sm font-medium text-white hover:bg-[#00984F] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-[#00984F] focus:ring-yellow-500 py-[4px] w-full">
                            <span id="dropdown-selected-option" class="w-full text-center overflow-hidden flex-1">এডমিন
                                লগইন</span>
                        </a>
                    </div>

                </div>
            </div>

        </li>
    </ul>
    <button class="lg:hidden" onclick="toggleMenu()">
        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
            <path
                d="M0 96C0 78.3 14.3 64 32 64H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H416c17.7 0 32 14.3 32 32z" />
        </svg>
    </button>
</div>
