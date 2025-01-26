<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>আদালত</title>
    <link rel="shortcut icon" href="{{ asset('media/logos/favicon.ico') }}" />
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body>

    <section class="relative">
    {{-- @foreach ($gcc_role as $item)
        {{$item->role_name}}
    @endforeach --}}
  
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
            <a href="{{ route('logout.custom') }}"  class="" style="background-color:#bb2d3b " 
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
            
                <span class="text-white">{{ __('লগ আউট') }}</span>
            </a>
            <form id="logout-form" action="{{ route('logout.custom') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
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
          <a href="{{ route('logout.custom') }}"  class="" style="background-color:#bb2d3b " 
                                     onclick="event.preventDefault();
                                                   document.getElementById('logout-form').submit();">
          
              <span class="text-white">{{ __('লগ আউট') }}</span>
          </a>
          <form id="logout-form" action="{{ route('logout.custom') }}" method="POST" class="d-none">
                                          @csrf
                                      </form>
        </li>
        
      </ul>
      <div class="absolute left-0 right-0 bottom-2 lg:bottom-20 container mx-auto px-2 flex flex-wrap justify-center lg:justify-between gap-2 lg:gap-10">
        
        <a href="{{ route('redirect.select.court',3) }}" class="bg-white p-2 lg:p-4 flex items-center gap-2 w-full lg:w-[22%] rounded-lg">
            <img class="w-10 h-10 lg:w-[3.453125em] lg:h-[4.13625em]" width="100%" height="100%" src="{{asset('images/emc.png')}}" alt="E-Court">
            <span>
                এক্সিকিউটিভ ম্যাজিস্ট্রেট কোর্ট
            </span>
        </a>
        <a href="{{ route('redirect.select.court',2) }}" class="bg-white p-2 lg:p-4 flex items-center gap-2 w-full lg:w-[22%] rounded-lg">
            <img class="w-10 h-10 lg:w-[3.453125em] lg:h-[4.13625em]" width="100%" height="100%" src="{{asset('images/admin_login.png')}}" alt="E-Court">
            <span>
                জেনারেল সার্টিফিকেট কোর্ট
            </span>
        </a>
        <a href="{{ route('dashboard.index',1) }}" class="bg-white p-2 lg:p-4 flex items-center gap-2 w-full lg:w-[22%] rounded-lg">
            <img class="w-10 h-10 lg:w-[3.453125em] lg:h-[4.13625em]" width="100%" height="100%" src="{{asset('images/mc.png')}}" alt="E-Court">
            <span>
                মোবাইল কোর্ট
            </span>
        </a>
      </div>
    </section>
    



  </body>
  
  <script>
    function toggleMenu() {
      document.getElementById("mobileMenu").classList.toggle("hidden");
    }
  </script>
</html>
