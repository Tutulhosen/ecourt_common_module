<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>আদালত</title>
    <link rel="shortcut icon" href="{{ asset('media/logos/favicon.ico') }}" />
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

</head>

<body>

    <style>
        .headline {
            text-align: center;
            background-color: green;
            color: white;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 10px;
            /* Adjust border radius as needed */
        }

        #mobile_no::placeholder {
            font-size: 12px;
            /* Adjust the font size as needed */
        }

        .requird_symble {
            color: red;
            padding: 5px
        }
    </style>

    <section class="">
        @include('landing.nav')

        <img class="h-screen" src="{{ asset('images/bg.jpg') }}" alt="E-Court" width="100%" height="100%" />


        <div
            class="absolute left-0 right-0 bottom-0 lg:bottom-40 container mx-auto px-2 flex flex-col items-center gap-2 lg:gap-10">
            <!-- Your other content -->

            <div class="w-full lg:w-2/3">
                <form id="nidVerifyForm" action="{{ route('citizen.registration.otp.sent') }}" method="POST"
                    enctype="multipart/form-data" class="bg-white p-6 lg:p-8 rounded-lg shadow-md">
                    @csrf
                    @if (isset($results))
                        <h4 class="p-2 text-center"
                            style="color: #fff;
                    background-color: #886400;
                    border-color: green;
                    border-radius:5px
                    ">
                            {{ $results }} এর জন্য
                        </h4>
                    @endif
                    <input type="hidden" name="role_id" value="{{ $role_id }}">
                    <input type="hidden" name="type_id" value="{{ $type_id }}">
                    <h2 class="text-xl font-semibold mb-4 headline">
                        <svg class="w-6 h-6 fill-current mr-2 " xmlns="http://www.w3.org/2000/svg" id="Layer_1"
                            data-name="Layer 1" viewBox="0 0 24 24" width="512" height="512">
                            <path
                                d="M12,16a4,4,0,1,1,4-4A4,4,0,0,1,12,16ZM5.683,16H1a1,1,0,0,1-1-1A6.022,6.022,0,0,1,5.131,9.084a1,1,0,0,1,1.1,1.266A6.009,6.009,0,0,0,6,12a5.937,5.937,0,0,0,.586,2.57,1,1,0,0,1-.9,1.43ZM17,24H7a1,1,0,0,1-1-1,6,6,0,0,1,12,0A1,1,0,0,1,17,24ZM18,8a4,4,0,1,1,4-4A4,4,0,0,1,18,8ZM6,8a4,4,0,1,1,4-4A4,4,0,0,1,6,8Zm17,8H18.317a1,1,0,0,1-.9-1.43A5.937,5.937,0,0,0,18,12a6.009,6.009,0,0,0-.236-1.65,1,1,0,0,1,1.105-1.266A6.022,6.022,0,0,1,24,15,1,1,0,0,1,23,16Z" />
                        </svg> {{ $page_title }}
                    </h2>
                    <div class="flex  justify-between gap-4">
                        <div class="w-full lg:w-1/3">
                            <label for="input_name" class="block text-sm font-medium text-gray-700"><span
                                    class="requird_symble">*</span>{{ $name_field_label }}</label>
                            <input type="text" id="input_name" name="input_name"
                                class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full h-10 pl-3 pr-12 border border-gray-300 rounded-md"
                                value="{{ old('input_name') }}">
                            @error('input_name')
                                <div class="error_alert">{{ $message }}</div>
                            @enderror

                        </div>
                        <div class="w-full lg:w-1/3">
                            <label for="mobile_no" class="block text-sm font-medium text-gray-700"><span
                                    class="requird_symble">*</span>{{ $mobile_field_label }}</label>
                            <input type="text" id="mobile_no" name="mobile_no"
                                class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full h-10 pl-3 pr-12 border border-gray-300 rounded-md"
                                placeholder="মোবাইল নং ইংরেজিতে ১১ অক্ষর" value="{{ old('mobile_no') }}">
                            @if (session('already_registered_message'))
                                <div class="error_alert">
                                    {{ session('already_registered_message') }}
                                </div>
                            @endif
                            @error('mobile_no')
                                <div class="error_alert">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="w-full lg:w-1/3">
                            <label for="email"
                                class="block text-sm font-medium text-gray-700">{{ $email_field_label }}</label>
                            <input type="email" id="email" name="email"
                                class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full h-10 pl-3 pr-12 border border-gray-300 rounded-md">
                            @if (session('already_registered_by_email'))
                                <div class="error_alert">
                                    {{ session('already_registered_by_email') }}
                                </div>
                            @endif
                            @error('email')
                                <div class="error_alert">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <button type="submit"
                        class="w-full lg:w-auto bg-[green] text-white p-2 rounded-md mt-4 mx-auto block">পরবর্তী
                        ধাপ</button>
                </form>
            </div>



        </div>

    </section>



    @include('layout.landingFooter')

</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
    integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ asset('landing_page/js/nav.js') }}"></script>
<style type="text/css">
    .error_alert {
        color: red;
        font-size: 12px;

    }
</style>
<script>
    function toggleMenu() {
        document.getElementById("mobileMenu").classList.toggle("hidden");
    }
</script>

</html>
