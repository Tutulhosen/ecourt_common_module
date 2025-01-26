<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>আদালত</title>
    <link rel="shortcut icon" href="{{ asset('media/logos/favicon.ico') }}" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" type="text/css" /> --}}
    <style>
        ::selection {
            background-color: #0BA14A;
            color: white;
        }

        .dropdown:hover .dropdown-menu {
            display: block;
            width: 100%
        }

        /* .input_bangla {
            font-family: boishakhi !important;
            font-size: 14px !important;
        }

        @font-face {
            font-family: 'boishakhi';
            src: url('/fonts/Boishkhi/Boishkhi.ttf') format('truetype');
        } */
    </style>
</head>

<body>

    <main>
        <section class="relative">
            <img class="h-screen" src="{{ asset('images/bg_new.jpg') }}" style="object-fit: cover" alt="E-Court"
                width="100%" height="100%" />
            <div
                class="absolute top-0 lg:top-0 right-0 left-0 w-full px-5 bg-white py-1 lg:py-3 rounded-sm flex justify-between">
                <div style="display: flex; align-items: center">
                    <a href="{{ route('home.index') }}">
                        <img class="w-[7em] h-[2em] lg:w-[15.5625em] lg:h-[4.75em]"
                            src="{{ asset('images/logo_court.jpeg') }}" alt="E-Court" width="100%" height="100%" />
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
                        <a class="bg-[#0BA14A] text-white px-8 py-2 rounded-md"
                            href="{{ route('show_log_in_page') }}">লগইন</a>

                    </li>
                    <li class="mt-1">
                         <a class="bg-[#0BA14A] text-white px-8 py-2 rounded-md"
                            href="{{ route('citizen.registration') }}">নিবন্ধন</a>

                      {{--   <div class="relative inline-block text-left">
                            <div>
                                <button id="dropdown-button" type="button"
                                    class="inline-flex justify-center items-center rounded-full border border-[#00984F] shadow-sm px-4 py-2 bg-[#00984F] text-sm font-medium text-white hover:bg-[#00984F] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-[#00984F] focus:ring-yellow-500 py-[4px]"
                                    aria-haspopup="true" aria-expanded="">
                                    <span id="dropdown-selected-option"
                                        class="w-full text-left overflow-hidden flex-1">প্রশাসনিক লগইন</span>
                                    <svg id="caret" class="ml-2.5 -mr-1.5 h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M6.293 7.293a1 1 0 011.414 0L10 9.586l2.293-2.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                            <div id="dropdown-menu"
                                class="origin-top-right absolute w-full left-0 mt-4 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none bg-white"
                                role="menu" aria-orientation="vertical" aria-labelledby="dropdown-button"
                                tabindex="-1">
                                <div class="py-3 px-3 text-black flex flex-col items-stretch space-y-3" role="none">
                                    <button id="dropdown-button" type="button"
                                        class="inline-flex justify-center items-center rounded-full border border-[#00984F] shadow-sm px-4 py-2 bg-[#00984F] text-sm font-medium text-white hover:bg-[#00984F] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-[#00984F] focus:ring-yellow-500 py-[4px] w-full">
                                        <span id="dropdown-selected-option" class="w-full text-center overflow-hidden flex-1">কোর্ট লগইন</span>
                                    </button>
                                    <button id="dropdown-button" type="button"
                                        class="inline-flex justify-center items-center rounded-full border border-[#00984F] shadow-sm px-4 py-2 bg-[#00984F] text-sm font-medium text-white hover:bg-[#00984F] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-[#00984F] focus:ring-yellow-500 py-[4px] w-full">
                                        <span id="dropdown-selected-option" class="w-full text-center overflow-hidden flex-1">এডমিন লগইন</span>
                                    </button>
                                </div>
                                
                            </div>
                        </div> --}}

                    </li>
                </ul>
                <button class="lg:hidden" onclick="toggleMenu()">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                        <path
                            d="M0 96C0 78.3 14.3 64 32 64H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H416c17.7 0 32 14.3 32 32z" />
                    </svg>
                </button>
            </div>
            <ul id="mobileMenu"
                class="hidden lg:hidden absolute bg-white right-0 left-0 top-[2.5rem] z-50 p-4 drop-shadow-2xl [&>li]:border-b [&>li]:pb-2 flex flex-col gap-3 [&>li>a]:text-[12px]">
                <li>
                    <a href="#"> প্রসেস ম্যাপ </a>
                </li>
                <li>
                    <a href="{{ URL('http://bdlaws.minlaw.gov.bd/act-98.html') }}" target="_blank"> আইন ও বিধি </a>
                </li>
                <li>
                    <a href="tel:+333" class="flex items-center gap-2">
                        <span>
                            <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <path
                                    d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z" />
                            </svg>
                        </span>
                        <span> 333 </span>
                    </a>
                </li>
                <li>
                    <a class="bg-[#0BA14A] text-white px-8 py-2 rounded-md"
                        href="{{ route('show_log_in_page') }}">লগইন</a>
                </li>
                <li>
                    <a class="bg-[#0BA14A] text-white px-8 py-2 rounded-md"
                        href="{{ route('citizen.registration') }}">নিবন্ধন</a>
                </li>
            </ul>
            <div
                class="absolute left-0 right-0 bottom-2 lg:bottom-20 container mx-auto px-2 lg:justify-between gap-2 lg:gap-10 flex flex-col gap-3 items-center">



                <a href="{{ route('show_admin_log_in_page') }}"
                    class="bg-white p-2 lg:p-4 flex items-center justify-center gap-8 w-full lg:w-[22%] rounded-lg">
                    <img class="w-10 h-10 lg:w-[3.453125em] lg:h-[4.13625em]" width="100%" height="100%"
                        src="{{ asset('images/admin_login.png') }}" alt="E-Court">
                    <span>
                        প্রশাসনিক লগইন
                    </span>
                </a>
                <a href="{{ route('nothi.v2.login') }}"
                    class="bg-white lg:p-4 flex items-center justify-center gap-8 w-full lg:w-[22%] rounded-lg">
                    <img class="w-10 h-10 lg:w-[3.453125em] lg:h-[4.13625em]" width="100%" height="100%"
                        src="{{ asset('images/emc.png') }}" alt="E-Court">
                    <span>
                        কোর্ট লগইন<span class="invisible">hfds</span>
                    </span>
                </a>

            </div>
        </section>

        <section class="px-5 my-6">
            <div style="margin-left:-2px;margin-right:-2px; display: flex; align-items: center; gap: 10px">
                <div class="py-3">
                    <p type="text">খবরঃ</p>
                </div>
                {{-- <div style="background-color:#D9D9D9;"> --}}
                <marquee class="py-1" style="font-size: 16px; background-color:#D9D9D9;" direction="left"
                    scrollamount="3" onmouseover="this.stop()" onmouseout="this.start()">
                    গণপ্রজাতন্ত্রী বাংলাদেশ সরকারের নির্বাহী ম্যাজিস্ট্রেট আদালত
                    ব্যবস্থার অনলাইন প্ল্যাটফর্মে আপনাকে স্বাগতম। সিস্টেমটির মাধ্যমে নাগরিক মামলার আবেদন করতে পারবে,
                    আপীল করতে পারবে এবং আপীলের সর্বশেষ অবস্থা সম্পর্কে জানতে পারবে। পাশাপাশি নাগরিক মামলা দাখিল করার
                    পর
                    মামলার সর্বশেষ অবস্থা সিস্টেম কর্তৃক স্বয়ংক্রিয়ভাবে SMS ও ই-মেইলের মাধ্যমে সম্পর্কে জানানো হবে।
                    জনগণের হয়রানি লাঘবকল্পে একটি ইলেক্ট্রনিক সিস্টেমের মাধ্যমে তাদেরকে মামলার নকল সরবরাহ ও সেবা
                    প্রদানের
                    বিষয়ে গুরুত্বপূর্ণ ভূমিকা রাখবে
                </marquee>
                {{-- </div> --}}
        </section>



        <section>
            <h4 class="px-5 text-[18px] font-semibold" style="color: #0BA14A">সহায়ক তথ্য ও সেবা</h4>
            <div class="flex flex-col md:flex-row justify-evenly gap-5 space-y-4 md:space-y-0 my-6">

                <a href="{{ route('cause_list') }}"
                    class="h4 text-center text-dark hover:text-[#0BA14A] font-weight-bold font-size-h4 mb-3 hover:shadow-xl">
                    <div style="height: 200px; width: 200px;"
                        class="flex flex-col items-center justify-center border border-gray-200 rounded transform transition-transform duration-300 hover:scale-105 hover:bg-gray-100">
                        <img height="130" width="130" src="{{ asset('images/gcc_login/img_one.png') }}" />
                        <!-- <span class="mt-2">মামলার তথ্য জানুন</span> -->
                        <span class="mt-2">মামলার তথ্য জানুন</span>

                    </div>
                </a>
                <a href="{{ route('investigator.verify') }}" class="hover:text-[#0BA14A]">
                    <div style="height: 200px; width: 200px;"
                        class="flex flex-col items-center justify-center border border-gray-200 hover:shadow-xl rounded transform transition-transform duration-300 hover:scale-105 hover:bg-gray-100"">
                        <img height="150" width="150" src="{{ asset('images/gcc_login/img_two.png') }}" />
                        <span class="">তদন্ত প্রতিবেদন</span>
                    </div>
                </a>
                <div style="height: 200px; width: 200px;"
                    class="flex hover:text-[#0BA14A] flex-col items-center justify-center border border-gray-200 hover:shadow-xl rounded transform transition-transform duration-300 hover:scale-105 hover:bg-gray-100"">
                    <img height="140" width="140" src="{{ asset('images/gcc_login/img_three.png') }}" />
                    <span class="mt-2">সাপোর্ট সেন্টার</span>
                </div>
                <div style="height: 200px; width: 200px;"
                    class="flex hover:text-[#0BA14A] flex-col items-center justify-center border border-gray-200 hover:shadow-xl rounded transform transition-transform duration-300 hover:scale-105 hover:bg-gray-100"">
                    <img height="130" width="130" src="{{ asset('images/gcc_login/img_four.png') }}" />
                    <span class="mt-3">ল'জ অব বাংলাদেশ</span>
                </div>
            </div>
        </section>
    </main>

    @include('layout.landingFooter')

</body>

<script>
    function toggleMenu() {
        document.getElementById("mobileMenu").classList.toggle("hidden");
    }
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
    integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {


        jQuery('select[name="division"]').on('change', function() {

            var dataID = jQuery(this).val();

            jQuery("#district_id").after('<div class="loadersmall"></div>');

            if (dataID) {
                jQuery.ajax({
                    url: '{{ url('/') }}/dropdownlist/get/district/' +
                        dataID,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        console.log('response district ', data)
                        jQuery('select[name="district"]').html(
                            '<div class="loadersmall"></div>');

                        jQuery('select[name="district"]').html(
                            '<option value="">-- জেলা নির্বাচন করুন --</option>');
                        jQuery.each(data, function(key, value) {
                            jQuery('select[name="district"]').append(
                                '<option value="' + key +
                                '">' + value + '</option>');
                        });
                        jQuery('.loadersmall').remove();
                    }
                });
            } else {
                $('select[name="district"]').empty();
            }
        });


    })
</script>
<script type="text/javascript">
    jQuery(document).ready(function() {


        const dropdownButton = document.getElementById("dropdown-button");
        const dropdownMenu = document.getElementById("dropdown-menu");
        const dropdownSelectedOption = document.getElementById("dropdown-selected-option");
        const caret = document.getElementById("caret");

        function toggleCaret() {
            caret.style.transform == 'rotate(0deg)' ? caret.style.transform = 'rotate(180deg)' : caret.style
                .transform = 'rotate(0deg)';
        }

        dropdownButton.addEventListener("click", function(event) {
            event.stopPropagation();

            toggleCaret();
            dropdownMenu.classList.toggle("hidden");
            dropdownButton.setAttribute("aria-expanded", dropdownMenu.classList.contains("hidden") ?
                "false" : "true");
        });

        // Add placeholder text to list items
        const dropdownItems = dropdownMenu.querySelectorAll("[role='menuitem']");
        dropdownItems.forEach(function(item) {
            item.addEventListener("click", function(event) {
                event.preventDefault();
                dropdownSelectedOption.textContent = item.textContent;
                dropdownMenu.classList.add("hidden");
                dropdownButton.setAttribute("aria-expanded", "false");
                toggleCaret();

            });
        });

        // Dismiss dropdown when clicking outside of it
        document.addEventListener("click", function(event) {
            if (!dropdownMenu.contains(event.target)) {
                dropdownMenu.classList.add("hidden");
                dropdownButton.setAttribute("aria-expanded", "false");
                caret.style.transform = 'rotate(0deg)';
            }
        });


    })
</script>

</html>
