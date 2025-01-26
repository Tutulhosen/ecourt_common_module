<section class="">
    <div class="w-full grid w-full grid-cols-1 my-auto mb-8 md:grid-cols-2 xl:gap-14 md:gap-5 "
        style="margin-top: 50px">
        <div class="w-full h-auto"style="">
            @include('landing.sider')
        </div>
        <div class="flex items-center flex-col"
            style=" background-image: url('{{ asset('landing_page/images/banner/imageTwo.png') }}'); background-repeat: no-repeat;  background-position: center; ">
            <div class="flex space-x-4">
                <div class="relative inline-block text-left">
                    <div>
                        <button id="dropdown-button-login" type="button"
                            class="inline-flex justify-center items-center border-2 border-[#00984F] shadow-sm px-[70px] text-sm font-bold focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-[#00984F] focus:ring-yellow-500 py-[12px] bg-white text-[#00984F]">
                            <span id="dropdown-selected-option-login"
                                class="w-full text-left overflow-hidden">লগইন</span>
                            <svg id="caret-login" class="ml-2.5 -mr-1.5 h-5 w-5 hidden" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M6.293 7.293a1 1 0 011.414 0L10 9.586l2.293-2.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>

                    <div id="dropdown-menu-login"
                        class="origin-top-right absolute w-full left-0 mt-2 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none bg-white hidden"
                        role="menu" aria-orientation="vertical" aria-labelledby="dropdown-button-login"
                        tabindex="-1">
                        <div class="py-3 px-3 text-black flex flex-col items-stretch space-y-3" role="none">
                            <a href="{{route('show_log_in_page',['type_id'=>encrypt(1)])}}" id="dropdown-login-option" type="button"
                                class="inline-flex justify-center items-center rounded-full border border-[#00984F] shadow-sm px-4 py-2 bg-[#00984F] text-sm font-medium text-white hover:bg-[#00984F] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-[#00984F] focus:ring-yellow-500 py-[6px] w-full">
                                <span id="dropdown-login-option-text"
                                    class="w-full text-center overflow-hidden flex-1">নাগরিক লগইন</span>
                            </a>
                            <a href="{{route('show_log_in_page',['type_id'=>encrypt(2)])}}" id="dropdown-admin-option" type="button"
                                class="inline-flex justify-center items-center rounded-full border border-[#00984F] shadow-sm px-4 py-2 bg-[#00984F] text-sm font-medium text-white hover:bg-[#00984F] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-[#00984F] focus:ring-yellow-500 py-[6px] w-full">
                                <span id="dropdown-admin-option-text"
                                    class="w-full text-center overflow-hidden flex-1">প্রাতিষ্ঠানিক লগইন</span>
                            </a>
                            <a href="{{route('show_log_in_page',['type_id'=>encrypt(3)])}}" id="dropdown-admin-option" type="button"
                                class="inline-flex justify-center items-center rounded-full border border-[#00984F] shadow-sm px-4 py-2 bg-[#00984F] text-sm font-medium text-white hover:bg-[#00984F] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-[#00984F] focus:ring-yellow-500 py-[6px] w-full">
                                <span id="dropdown-admin-option-text"
                                    class="w-full text-center overflow-hidden flex-1">আইনজীবী লগইন</span>
                            </a>
                            <a href="{{route('show_log_in_page',['type_id'=>encrypt(4)])}}" id="dropdown-admin-option" type="button"
                                class="inline-flex justify-center items-center rounded-full border border-[#00984F] shadow-sm px-4 py-2 bg-[#00984F] text-sm font-medium text-white hover:bg-[#00984F] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-[#00984F] focus:ring-yellow-500 py-[6px] w-full">
                                <span id="dropdown-admin-option-text"
                                    class="w-full text-center overflow-hidden flex-1">কেন্দ্রীয় প্রতিষ্ঠান</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="relative inline-block text-left">
                    <div>
                        <button id="dropdown-button-registration" type="button"
                            class="inline-flex justify-center items-center border-2 border-[#00984F] shadow-sm px-[70px] text-sm font-bold focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-[#00984F] focus:ring-yellow-500 py-[12px] bg-white text-[#00984F]">
                            <span id="dropdown-selected-option-registration"
                                class="w-full text-left overflow-hidden">নিবন্ধন</span>
                            <svg id="caret-registration" class="ml-2.5 -mr-1.5 h-5 w-5 hidden" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M6.293 7.293a1 1 0 011.414 0L10 9.586l2.293-2.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>

                    <div id="dropdown-menu-registration"
                        class="origin-top-right absolute w-full left-0 mt-4 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none bg-white hidden"
                        role="menu" aria-orientation="vertical" aria-labelledby="dropdown-button-registration"
                        tabindex="-1">
                        <div class="py-3 px-3 text-black flex flex-col items-stretch space-y-3" role="none">
                            <a href="{{ route('citizen.registration.by.type',['type_id'=>encrypt(1)]) }}" id="dropdown-registration-option" type="button"
                                class="inline-flex justify-center items-center rounded-full border border-[#00984F] shadow-sm px-4 py-2 bg-[#00984F] text-sm font-medium text-white hover:bg-[#00984F] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-[#00984F] focus:ring-yellow-500 py-[6px] w-full">
                                <span id="dropdown-registration-option-text"
                                    class="w-full text-center overflow-hidden flex-1">নাগরিক নিবন্ধন </span>
                            </a>
                           
                            <a href="{{ route('citizen.registration.by.type',['type_id'=>encrypt(2)]) }}" id="dropdown-registration-option" type="button"
                                class="inline-flex justify-center items-center rounded-full border border-[#00984F] shadow-sm px-4 py-2 bg-[#00984F] text-sm font-medium text-white hover:bg-[#00984F] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-[#00984F] focus:ring-yellow-500 py-[6px] w-full">
                                <span id="dropdown-registration-option-text"
                                    class="w-full text-center overflow-hidden flex-1">প্রাতিষ্ঠানিক নিবন্ধন</span>
                            </a>
                           
                            <a href="{{ route('citizen.registration.by.type',['type_id'=>encrypt(3)]) }}" id="dropdown-registration-option" type="button"
                                class="inline-flex justify-center items-center rounded-full border border-[#00984F] shadow-sm px-4 py-2 bg-[#00984F] text-sm font-medium text-white hover:bg-[#00984F] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-[#00984F] focus:ring-yellow-500 py-[6px] w-full">
                                <span id="dropdown-registration-option-text"
                                    class="w-full text-center overflow-hidden flex-1">আইনজীবী নিবন্ধন </span>
                            </a>
                            {{-- <a href="{{ route('citizen.registration.by.type',['type_id'=>encrypt(4)]) }}" id="dropdown-registration-option" type="button"
                                class="inline-flex justify-center items-center rounded-full border border-[#00984F] shadow-sm px-4 py-2 bg-[#00984F] text-sm font-medium text-white hover:bg-[#00984F] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-[#00984F] focus:ring-yellow-500 py-[6px] w-full">
                                <span id="dropdown-registration-option-text"
                                    class="w-full text-center overflow-hidden flex-1">কেন্দ্রীয় নিবন্ধন </span>
                            </a> --}}
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
