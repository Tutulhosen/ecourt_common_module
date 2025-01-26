<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>আদালত</title>
    <link rel="shortcut icon" href="{{ asset('media/logos/favicon.ico') }}" />
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.5.2/cdn.min.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        ::selection {
            background-color: #0BA14A;
            color: white;
        }
    </style>
    <style>
        .toast-top-right {
            top: 1rem;
            right: 1rem;
            position: fixed;
            z-index: 9999;
        }
    </style>
</head>

<body>
    <header class="shadow-lg sticky z-30 top-0 bg-white h-auto py-3">
        @include('doptor_court_navbar')
    </header>

    <main style=" padding: 20px">
        <section>
            <div class="container mx-auto px-20 justify-center gap-2 lg:gap-10 flex gap-3 items-center">
                <a href="{{ route('redirect.select.court', 3) }}"
                    class="bg-white p-2 lg:p-4 flex items-center gap-4 w-full h-[100px] border border-[#0E9242] rounded-lg shadow-[0_4px_6px_0_rgba(14,146,66,0.2)]  transition-colors duration-200 hover:bg-[#f2f5f3]">
                    <img class="w-10 h-10 lg:w-[3.453125em] lg:h-[4.13625em]" width="100%" height="100%"
                        src="{{ asset('images/gcc_login/login_image/one.png') }}" alt="E-Court">
                    <span class="text-[#0E9242]">
                        এক্সিকিউটিভ ম্যাজিস্ট্রেট কোর্ট
                    </span>
                </a>

                <a href="{{ route('redirect.select.court', 2) }}"
                    class="bg-white p-2 lg:p-4 flex items-center gap-4 w-full h-[100px] border border-[#0E9242] rounded-lg shadow-[0_4px_6px_0_rgba(14,146,66,0.2)]  transition-colors duration-200 hover:bg-[#f2f5f3]">
                    <img class="w-10 h-10 lg:w-[3.453125em] lg:h-[4.13625em]" width="100%" height="100%"
                        src="{{ asset('images/gcc_login/login_image/two.png') }}" alt="E-Court">
                    <span class="text-[#0E9242]">
                        জেনারেল সার্টিফিকেট কোর্ট
                    </span>
                </a>

                <a href="{{ route('redirect.select.court', 1) }}"
                    class="bg-white p-2 lg:p-4 flex items-center  gap-4 w-full h-[100px] border border-[#0E9242] rounded-lg shadow-[0_4px_6px_0_rgba(14,146,66,0.2)]  transition-colors duration-200 hover:bg-[#f2f5f3]">
                    <img class="w-24 h-10" width="100%" style="height: 70px; width: 80px"
                        src="{{ asset('images/gcc_login/login_image/three.png') }}" alt="E-Court">
                    <span class="text-[#0E9242]">
                        মোবাইল কোর্ট
                    </span>
                </a>


                <!-- <a href="{{ route('dashboard.index', 1) }}"
                    class="bg-white p-2 lg:p-4 flex justify-center items-center gap-2 w-full rounded-lg 
                    shadow-lg">
                    <img class="w-10 h-10 lg:w-[3.453125em] lg:h-[4.13625em]" width="100%" height="100%"
                        src="{{ asset('images/gcc_login/court/one.png') }}" alt="E-Court">
                    <span>
                        মোবাইল কোর্ট
                    </span>
                </a> -->

            </div>
        </section>
        <div style="padding: 40px;" class="flex flex-row justify-center">

            <img width="800" src="{{ asset('images/gcc_login/court/two.png') }}" alt="E-Court">
        </div>
        <section>
            <h5 class="font-bold text-xl px-10">কোর্ট লগইন</h5>
            <p class="my-2 text-justify text-[14px] px-10">
                গণপ্রজাতন্ত্রী বাংলাদেশ সরকারের জেনারেল সার্টিফিকেট আদালত ব্যবস্থার  অনলাইন প্ল্যাটফর্মে আপনাকে স্বাগতম। সিস্টেমটির মাধ্যমে প্রতিষ্ঠান মামলার  আবেদন করতে পারবে, আপীল করতে পারবে এবং আপীলের সর্বশেষ অবস্থা সম্পর্কে  জানতে পারবে। পাশাপাশি প্রতিষ্ঠান মামলা দাখিল করার পর মামলার সর্বশেষ  অবস্থা সম্পর্কে সিস্টেম কর্তৃক স্বয়ংক্রিয়ভাবে SMS ও ই-মেইলের মাধ্যমে  জানানো হবে। প্রতিষ্টানের ও জনগণের সময় ও শ্রম লাঘবকল্পে একটি ইলেক্ট্রনিক  সিস্টেমের মাধ্যমে তাদেরকে মামলার নকল সরবরাহ ও সেবা প্রদানের বিষয়ে  গুরুত্বপূর্ণ ভূমিকা রাখবে।
            </p>
        </section>
    </main>

    @include('layout.landingFooter')
    <script>
        function toggleMenu() {
            document.getElementById("mobileMenu").classList.toggle("hidden");
        }
    </script>
    <script>
        @if (session('error'))

            toastr.options = {
                "closeButton": true,
                "positionClass": "toast-top-right",
                "timeOut": "5000",
            };
            toastr.error("{{ session('error') }}");
        @endif
    </script>

</body>



</html>
