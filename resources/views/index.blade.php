@extends('mobile_court.layout.app')

@section('style')
@endsection


    <!--begin::Landing hero-->
    @auth
    @section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-4"style="margin-top:100px;text-align:center;">
                        <img src="{{ asset('images/book.png') }}" alt="Girl in a jacket" width="100%" height="250">
                    </div>
                    <div class="col-md-8">
                        <div style="margin-top: 165px; margin-left: 55px;">
                            <h1 class="phome_h1_text">স্মার্ট এক্সিকিউটিভ ম্যাজিস্ট্রেট কোর্ট </h1>
                        </div>
                    </div>
                    <div class="col-md-12 mt-5">
                        গণপ্রজাতন্ত্রী বাংলাদেশ সরকারের স্মার্ট এক্সিকিউটিভ ম্যাজিস্ট্রেট কোর্ট  ব্যবস্থার অনলাইন প্ল্যাটফর্মে
                        আপনাকে
                        স্বাগতম।
                        সিস্টেমটির মাধ্যমে নাগরিক অভিযোগ দায়ের  করতে পারবে, আপীল করতে পারবে এবং আপীলের
                        সর্বশেষ অবস্থা সম্পর্কে জানতে পারবে।
                        পাশাপাশি নাগরিক মামলা দাখিল করার পর মামলার সর্বশেষ অবস্থা সিস্টেম কর্তৃক স্বয়ংক্রিয়ভাবে
                        SMS ও ই-মেইলের মাধ্যমে সম্পর্কে জানানো হবে।
                        জনগণের হয়রানি লাঘবকল্পে একটি ইলেক্ট্রনিক সিস্টেমের মাধ্যমে তাদেরকে মামলার নকল সরবরাহ ও সেবা
                        প্রদানের বিষয়ে গুরুত্বপূর্ণ ভূমিকা রাখবে।
                    </div>
                    <div class="col-md-6 mt-5">
                        <a href=""><button type="button" class="px-15 btn btn-success">বিস্তারিত</button></a>
                        <a href="#!" class="svg-home-play" style="#008841 !importan">
                            <span class="svg-icon  svg-icon-primary svg-icon-2x">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"></rect>
                                        <path
                                            d="M9.82866499,18.2771971 L16.5693679,12.3976203 C16.7774696,12.2161036 16.7990211,11.9002555 16.6175044,11.6921539 C16.6029128,11.6754252 16.5872233,11.6596867 16.5705402,11.6450431 L9.82983723,5.72838979 C9.62230202,5.54622572 9.30638833,5.56679309 9.12422426,5.7743283 C9.04415337,5.86555116 9,5.98278612 9,6.10416552 L9,17.9003957 C9,18.1765381 9.22385763,18.4003957 9.5,18.4003957 C9.62084305,18.4003957 9.73759731,18.3566309 9.82866499,18.2771971 Z"
                                            fill="#000000"></path>
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span>
                            <strong>Watch Video</strong>
                        </a>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-md-12 mt-10 row" style="background-color:#f0f1ef ;">
            <div class="row">
                <div class="col-md-1 mt-5">
                    <p type="text">খবরঃ</p>
                </div>
                {{-- <div class="col-md-11 mt-5">
                    <marquee style="font-size: 18px" direction="left" scrollamount="3" onmouseover="this.stop()"
                        onmouseout="this.start()">
                        @foreach ($short_news as $row)
                            {{ $row->news_details }}
                        @endforeach
                    </marquee>
                </div> --}}
            </div>
        </div>
    </div>
    {{-- @include('_information_help_center_links') --}}
   @endsection 
    @else
    @section('landing')
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <div class="row " style=" margin-top: 100px;">
               
                    <div class="col-md-4"style="text-align:center;">
                        <img src="{{ asset('images/book.png') }}" alt="Girl in a jacket" width="400" height="250">
                    </div>
                    <div class="col-md-8">    
                        
                    </div>
                    <div class="col-md-12 py-2">
                        
                    <h1 style="font-weight: 700">স্মার্ট এক্সিকিউটিভ ম্যাজিস্ট্রেট কোর্ট </h1>
                       
                    </div>
                    <div class="col-md-12" style="font-size: 16px;text-align: justify;
                    line-height: 30px;">
                    
                    স্মার্ট এক্সিকিউটিভ ম্যাজিস্ট্রেট কোর্ট
                    গণপ্রজাতন্ত্রী বাংলাদেশ সরকারের স্মার্ট এক্সিকিউটিভ ম্যাজিস্ট্রেট কোর্ট ব্যবস্থার ভার্চুয়াল প্ল্যাটফর্মে স্বাগতম। সিস্টেমটির মাধ্যমে যে কোন নাগরিক যে কোন স্থান থেকে ফৌজদারী কার্যবিধি ১৮৯৮ এর প্রিভেন্টিভ সেকশনের অধীন অপরাধ সংক্রান্ত অভিযোগ দায়ের করতে পারবে। পাশাপাশি সিস্টেমটির মাধ্যমে নাগরিক মামলার বিচারিক কার্যক্রমসহ সর্বশেষ অবস্থা সম্পর্কে বিস্তারিত জানতে পারবে। মামলার প্রতিটি ধাপের কার্যক্রম সংশ্লিষ্ট ব্যক্তিবর্গকে এসএমএস ও ই-মেইলের মাধ্যমে  জানানো হবে।
                    </div>
                    {{-- <div class="col-md-6 mt-5">
                        <a href=""><button type="button" class="px-15 btn btn-success" >বিস্তারিত</button></a>
                        <a class="svg-home-play" href="" style="color:#008841 !important">
                            <span class="svg-icon  svg-icon-primary svg-icon-2x" style="color:#008841 !important">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"/>
                                        <path d="M9.82866499,18.2771971 L16.5693679,12.3976203 C16.7774696,12.2161036 16.7990211,11.9002555 16.6175044,11.6921539 C16.6029128,11.6754252 16.5872233,11.6596867 16.5705402,11.6450431 L9.82983723,5.72838979 C9.62230202,5.54622572 9.30638833,5.56679309 9.12422426,5.7743283 C9.04415337,5.86555116 9,5.98278612 9,6.10416552 L9,17.9003957 C9,18.1765381 9.22385763,18.4003957 9.5,18.4003957 C9.62084305,18.4003957 9.73759731,18.3566309 9.82866499,18.2771971 Z" fill="#000000"/>
                                    </g>
                                </svg><!--end::Svg Icon-->
                            </span>
                            <strong>Watch Video</strong>
                        </a>
                    </div> --}}
                </div>
    
            </div>
            <div class="col-lg-3 phomebuttons">
    
                <div class="card phomebutton_card" style="background: #f6f6f7 !important">
                    <div class="card-body phomebutton_cbody">
    
                        {{-- <input type="button" id="loginID" class="btn btn-success btn-block active"
                            value="{{ __('লগইন') }}" data-toggle="modal" data-target="#exampleModalLong">
    
                        <input type="button" id="loginID2" class="btn btn-success btn-block active"
                            value="{{ __('CDAP দিয়ে লগইন') }}" data-toggle="modal" data-target="#exampleModalLong2"> --}}
    
                        <a href="{{ url('/login/page') }}" type="button" class="btn btn-success btn-block active"
                            value="">{{ __('লগইন') }}</a>
                        <a href="{{ url('/registration') }}" type="button" class="btn btn-success btn-block active"
                            value="">{{ __('নিবন্ধন') }}</a>
                    </div>
                </div>
            </div>
        </div>
    
        
            <div class="row mt-5" style="background-color:#f0f1ef;margin-left:-2px;margin-right:-2px">
                <div class="col-md-1 mt-5">
                    <p type="text">খবরঃ</p>
                </div>
                {{-- <div class="col-md-11 mt-5">
                    <marquee style="font-size: 18px" direction="left" scrollamount="3" onmouseover="this.stop()"
                        onmouseout="this.start()">
                        @foreach ($short_news as $row)
                            {{ $row->news_details }}
                        @endforeach
                    </marquee>
                </div> --}}
            </div>
        
        
    </div>
    {{-- @include('_information_help_center_links') --}}
    @endsection
    @endauth


    
@section('scripts')
    <script>
        $(document).ready(function() {
            $("a.h2.btn.btn-info").on('click', function(event) {
                if (this.hash !== "") {
                    event.preventDefault();
                    var hash = this.hash;
                    $('html, body').animate({
                        scrollTop: $(hash).offset().top
                    }, 800, function() {
                        window.location.hash = hash;
                    });
                }
            });
        });
    </script>
@endsection
