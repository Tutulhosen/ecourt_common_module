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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

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

        #caret {
            transition: transform 0.15s ease-in-out;
        }

        .swiper {
            width: 100%;
            height: 100%;
        }

        .swiper-slide {
            text-align: center;
            font-size: 18px;
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .swiper-slide img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

</head>

<body>

    <main>

        {{-- navbar --}}
        @include('landing.nav')
        @include('landing.banner')
        @include('landing.digital')
        @include('landing.mamlaRegister')
        @include('landing.faq')
        @include('landing.counter')
        @include('landing.help')
        @include('landing.golpos')
        {{-- @include('landing.latestUpdate') --}}
        {{--  <section class="px-5 my-6">
            <div style="margin-left:-2px;margin-right:-2px; display: flex; align-items: center; gap: 10px">
                <div class="py-3">
                    <p type="text">খবরঃ</p>
                </div>
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
        </section> --}}




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

<script src="{{ asset('landing_page/js/nav.js') }}"></script>
<script src="{{ asset('landing_page/js/counter.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<!-- Initialize Swiper -->
<script>
    var swiper = new Swiper(".mySwiper", {
        pagination: {
            el: ".swiper-pagination",
            dynamicBullets: true,

        },
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
    });
</script>

</html>
