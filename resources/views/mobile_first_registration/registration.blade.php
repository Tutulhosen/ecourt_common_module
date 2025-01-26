<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>আদালত</title>
    <link rel="shortcut icon" href="{{ asset('media/logos/favicon.ico') }}" />
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body>

    <style>
        .custom-bg-color1:hover{
            background-color: #11a14a; /* Custom background color for the first button */
        }

        .custom-bg-color2:hover {
            background-color: #11a14a; /* Custom background color for the second button */
        }

        .custom-bg-color3:hover {
            background-color: #11a14a; /* Custom background color for the third button */
        }

        .custom-bg-color4:hover {
            background-color: #ee2d41; /* Custom background color for the fourth button */
        }
    </style>
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
                  <span>
                      <svg class="w-6 h-6 fill-current" xmlns="http://www.w3.org/2000/svg"
                          viewBox="0 0 512 512">
                          <path
                              d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z" />
                      </svg>
                  </span>
                  <span> 333 </span>
              </a>
          </li>
          <li class="mt-1">
              <a class="bg-[#0BA14A] text-white px-8 py-2 rounded-md"
                  href="{{ route('show_log_in_page') }}">লগইন</a>
          </li>
          <li class="mt-1">
              <a class="bg-[#0BA14A] text-white px-8 py-2 rounded-md"
                  href="{{ route('citizen.registration') }}">নিবন্ধন</a>
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



      <a href="{{ route('citizen.registration.by.type',['type_id'=>encrypt(1)]) }}" class="bg-green-500 text-white p-2 lg:p-4 flex items-center gap-2 rounded-lg w-full lg:w-[25%] text-center custom-bg-color1">
        <span class="flex items-center justify-center w-full">
         
            <svg class="w-6 h-6 fill-current mr-2 " xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" width="512" height="512"><path d="M12,16a4,4,0,1,1,4-4A4,4,0,0,1,12,16ZM5.683,16H1a1,1,0,0,1-1-1A6.022,6.022,0,0,1,5.131,9.084a1,1,0,0,1,1.1,1.266A6.009,6.009,0,0,0,6,12a5.937,5.937,0,0,0,.586,2.57,1,1,0,0,1-.9,1.43ZM17,24H7a1,1,0,0,1-1-1,6,6,0,0,1,12,0A1,1,0,0,1,17,24ZM18,8a4,4,0,1,1,4-4A4,4,0,0,1,18,8ZM6,8a4,4,0,1,1,4-4A4,4,0,0,1,6,8Zm17,8H18.317a1,1,0,0,1-.9-1.43A5.937,5.937,0,0,0,18,12a6.009,6.009,0,0,0-.236-1.65,1,1,0,0,1,1.105-1.266A6.022,6.022,0,0,1,24,15,1,1,0,0,1,23,16Z"/></svg>
            <span>নাগরিক নিবন্ধন</span>
        </span>
    </a>
    <a href="{{ route('citizen.registration.by.type',['type_id'=>encrypt(2)]) }}" class="bg-green-500 text-white p-2 lg:p-4 flex items-center gap-2 rounded-lg w-full lg:w-[25%] text-center custom-bg-color2">
        <span class="flex items-center justify-center w-full">
           
            <svg class="w-6 h-6 fill-current mr-2" xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" width="512" height="512"><circle cx="9" cy="6" r="6"/><path d="M13.043,14H4.957A4.963,4.963,0,0,0,0,18.957V24H18V18.957A4.963,4.963,0,0,0,13.043,14Z"/><polygon points="21 10 21 7 19 7 19 10 16 10 16 12 19 12 19 15 21 15 21 12 24 12 24 10 21 10"/></svg>
            <span>প্রাতিষ্ঠানিক নিবন্ধন</span>
        </span>
    </a>
    <a href="{{ route('citizen.registration.by.type',['type_id'=>encrypt(3)]) }}" class="bg-green-500 text-white p-2 lg:p-4 flex items-center gap-2 rounded-lg w-full lg:w-[25%] text-center custom-bg-color3">
        <span class="flex items-center justify-center w-full">
      
            <svg class="w-6 h-6 fill-current mr-2" xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" width="512" height="512"><circle cx="9" cy="6" r="6"/><path d="M13.043,14H4.957A4.963,4.963,0,0,0,0,18.957V24H18V18.957A4.963,4.963,0,0,0,13.043,14Z"/><polygon points="21 10 21 7 19 7 19 10 16 10 16 12 19 12 19 15 21 15 21 12 24 12 24 10 21 10"/></svg>
            <span>আইনজীবী নিবন্ধন</span>
        </span>
    </a>
    <a href="" class="bg-red-500 text-white p-2 lg:p-4 flex items-center gap-2 rounded-lg w-full lg:w-[25%] text-center custom-bg-color4">
        <span class="flex items-center justify-center w-full">
  
            <svg class="w-6 h-6 fill-current mr-2" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 24 24" style="enable-background:new 0 0 24 24;" xml:space="preserve" width="512" height="512">
            <g>
                <path d="M12.479,14.265v-3.279h11.049c0.108,0.571,0.164,1.247,0.164,1.979c0,2.46-0.672,5.502-2.84,7.669   C18.744,22.829,16.051,24,12.483,24C5.869,24,0.308,18.613,0.308,12S5.869,0,12.483,0c3.659,0,6.265,1.436,8.223,3.307L18.392,5.62   c-1.404-1.317-3.307-2.341-5.913-2.341C7.65,3.279,3.873,7.171,3.873,12s3.777,8.721,8.606,8.721c3.132,0,4.916-1.258,6.059-2.401   c0.927-0.927,1.537-2.251,1.777-4.059L12.479,14.265z"/>
            </g>

            </svg>
            <span>Google Login</span>
        </span>
    </a>

  </div>
</section>
    {{-- <section class="relative">

  
      <img class="h-screen" src="{{asset('images/bg.png')}}" alt="E-Court" width="100%" height="100%" />
      <div
        class="absolute top-0 lg:top-3 right-0 left-0 w-full bg-white container mx-auto px-2 py-1 lg:px-8 lg:py-3 rounded-sm flex justify-between"
      >
        <a href="{{route('home.index')}}">
            <img
            class="w-[7em] h-[2em] lg:w-[15.5625em] lg:h-[4.75em]"
            src="{{asset('images/logo_court.jpeg')}}"
            alt="E-Court"
            width="100%"
            height="100%"
            />
        </a>
        <ul class="items-center gap-8 [&>li>a]:text-[20px] hidden lg:flex">
          <li><a href="#">প্রসেস ম্যাপ</a></li>
          <li><a href="#">আইন ও বিধি</a></li>
          <li>
            <a href="#" class="flex items-center gap-2">
              <span>
                <svg
                  class="w-6 h-6 fill-current"
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 512 512"
                >
                  <path
                    d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z"
                  />
                </svg>
              </span>
              <span> 333 </span>
            </a>
          </li>
          <li>
            <a class="bg-[#0BA14A] text-white px-8 py-2 rounded-md" href="{{route('show_log_in_page')}}"
              >লগইন</a
            >
          </li>
          <li>
            <a class="bg-[#0BA14A] text-white px-8 py-2 rounded-md" href="{{route('citizen.registration')}}"
              >নিবন্ধন</a
            >
          </li>
        </ul>
        <button class="lg:hidden" onclick="toggleMenu()">
          <svg
            class="w-6 h-6"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 448 512"
          >
            <path
              d="M0 96C0 78.3 14.3 64 32 64H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H416c17.7 0 32 14.3 32 32z"
            />
          </svg>
        </button>
      </div>
      <ul
      id="mobileMenu"
        class="hidden lg:hidden absolute bg-white right-0 left-0 top-[2.5rem] z-50 p-4 drop-shadow-2xl [&>li]:border-b [&>li]:pb-2 flex flex-col gap-3 [&>li>a]:text-[12px]"
      >
        <li>
          <a href="#"> প্রসেস ম্যাপ </a>
        </li>
        <li>
          <a href="#"> আইন ও বিধি </a>
        </li>
        <li>
          <a href="#" class="flex items-center gap-2">
            <span>
              <svg
                class="w-4 h-4 fill-current"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 512 512"
              >
                <path
                  d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z"
                />
              </svg>
            </span>
            <span> 333 </span>
          </a>
        </li>
        <li>
          <a class="bg-[#0BA14A] text-white px-8 py-2 rounded-md" href="{{route('show_log_in_page')}}"
            >লগইন</a
          >
        </li>
        <li>
          <a class="bg-[#0BA14A] text-white px-8 py-2 rounded-md" href="{{route('citizen.registration')}}"
            >নিবন্ধন</a
          >
        </li>
      </ul>

      <div class="absolute left-0 right-0 bottom-2 lg:bottom-20 container mx-auto px-2 flex flex-col items-center gap-2 lg:gap-10 mt-0 lg:mt-2">
        <a href="{{ route('citizen.registration.by.type',['type_id'=>encrypt(1)]) }}" class="bg-green-500 text-white p-2 lg:p-4 flex items-center gap-2 rounded-lg w-full lg:w-[25%] text-center custom-bg-color1">
            <span class="flex items-center justify-center w-full">
             
                <svg class="w-6 h-6 fill-current mr-2 " xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" width="512" height="512"><path d="M12,16a4,4,0,1,1,4-4A4,4,0,0,1,12,16ZM5.683,16H1a1,1,0,0,1-1-1A6.022,6.022,0,0,1,5.131,9.084a1,1,0,0,1,1.1,1.266A6.009,6.009,0,0,0,6,12a5.937,5.937,0,0,0,.586,2.57,1,1,0,0,1-.9,1.43ZM17,24H7a1,1,0,0,1-1-1,6,6,0,0,1,12,0A1,1,0,0,1,17,24ZM18,8a4,4,0,1,1,4-4A4,4,0,0,1,18,8ZM6,8a4,4,0,1,1,4-4A4,4,0,0,1,6,8Zm17,8H18.317a1,1,0,0,1-.9-1.43A5.937,5.937,0,0,0,18,12a6.009,6.009,0,0,0-.236-1.65,1,1,0,0,1,1.105-1.266A6.022,6.022,0,0,1,24,15,1,1,0,0,1,23,16Z"/></svg>
                <span>নাগরিক নিবন্ধন</span>
            </span>
        </a>
        <a href="{{ route('citizen.registration.by.type',['type_id'=>encrypt(2)]) }}" class="bg-green-500 text-white p-2 lg:p-4 flex items-center gap-2 rounded-lg w-full lg:w-[25%] text-center custom-bg-color2">
            <span class="flex items-center justify-center w-full">
               
                <svg class="w-6 h-6 fill-current mr-2" xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" width="512" height="512"><circle cx="9" cy="6" r="6"/><path d="M13.043,14H4.957A4.963,4.963,0,0,0,0,18.957V24H18V18.957A4.963,4.963,0,0,0,13.043,14Z"/><polygon points="21 10 21 7 19 7 19 10 16 10 16 12 19 12 19 15 21 15 21 12 24 12 24 10 21 10"/></svg>
                <span>প্রাতিষ্ঠানিক নিবন্ধন</span>
            </span>
        </a>
        <a href="{{ route('citizen.registration.by.type',['type_id'=>encrypt(3)]) }}" class="bg-green-500 text-white p-2 lg:p-4 flex items-center gap-2 rounded-lg w-full lg:w-[25%] text-center custom-bg-color3">
            <span class="flex items-center justify-center w-full">
          
                <svg class="w-6 h-6 fill-current mr-2" xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" width="512" height="512"><circle cx="9" cy="6" r="6"/><path d="M13.043,14H4.957A4.963,4.963,0,0,0,0,18.957V24H18V18.957A4.963,4.963,0,0,0,13.043,14Z"/><polygon points="21 10 21 7 19 7 19 10 16 10 16 12 19 12 19 15 21 15 21 12 24 12 24 10 21 10"/></svg>
                <span>আইনজীবী নিবন্ধন</span>
            </span>
        </a>
        <a href="" class="bg-red-500 text-white p-2 lg:p-4 flex items-center gap-2 rounded-lg w-full lg:w-[25%] text-center custom-bg-color4">
            <span class="flex items-center justify-center w-full">
      
                <svg class="w-6 h-6 fill-current mr-2" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 24 24" style="enable-background:new 0 0 24 24;" xml:space="preserve" width="512" height="512">
                <g>
                    <path d="M12.479,14.265v-3.279h11.049c0.108,0.571,0.164,1.247,0.164,1.979c0,2.46-0.672,5.502-2.84,7.669   C18.744,22.829,16.051,24,12.483,24C5.869,24,0.308,18.613,0.308,12S5.869,0,12.483,0c3.659,0,6.265,1.436,8.223,3.307L18.392,5.62   c-1.404-1.317-3.307-2.341-5.913-2.341C7.65,3.279,3.873,7.171,3.873,12s3.777,8.721,8.606,8.721c3.132,0,4.916-1.258,6.059-2.401   c0.927-0.927,1.537-2.251,1.777-4.059L12.479,14.265z"/>
                </g>

                </svg>
                <span>Google Login</span>
            </span>
        </a>
        
        
    </div> --}}

    </section>
    

    @include('layout.landingFooter')


  </body>
  
  <script>
    function toggleMenu() {
      document.getElementById("mobileMenu").classList.toggle("hidden");
    }
  </script>
</html>
