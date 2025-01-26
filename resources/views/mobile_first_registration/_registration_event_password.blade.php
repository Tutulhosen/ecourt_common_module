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

    <style>
        .headline {
            text-align: center;
            background-color: green;
            color: white;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 10px; /* Adjust border radius as needed */
        }
        #mobile_no::placeholder {
            font-size: 12px; /* Adjust the font size as needed */
        }
        .requird_symble{
            color: red;
            padding: 5px
        }
        .eye_open {
            position: absolute;
            top: 16px;
            right: 51%;
            height: 100%;
            display: flex;
            align-items: center;
        
        }
        .eye_close {
            position: absolute;
            top: 16px;
            right: 51%;
            height: 100%;
            display: none;
            align-items: center;
        
        }
    </style>

    <section class="relative">
    {{-- @foreach ($gcc_role as $item)
        {{$item->role_name}}
    @endforeach --}}
  
      {{-- <img class="h-screen" src="{{asset('images/bg.png')}}" alt="E-Court" width="100%" height="100%" /> --}}
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
          {{-- <li>
            <a class="bg-[#0BA14A] text-white px-8 py-2 rounded-md" href="{{route('show_log_in_page')}}"
              >লগইন</a
            >
          </li>
          <li>
            <a class="bg-[#0BA14A] text-white px-8 py-2 rounded-md" href="{{route('citizen.registration')}}"
              >নিবন্ধন</a
            >
          </li> --}}
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
        {{-- <li>
            <a class="bg-[#0BA14A] text-white px-8 py-2 rounded-md" href="{{route('show_log_in_page')}}"
              >লগইন</a
            >
          </li>
          <li>
            <a class="bg-[#0BA14A] text-white px-8 py-2 rounded-md" href="{{route('citizen.registration')}}"
              >নিবন্ধন</a
            >
          </li> --}}
      </ul>

      <div class="absolute left-0 right-0 bottom-0 lg:bottom-20 container mx-auto px-2 flex flex-col items-center gap-2 lg:gap-10">
        <!-- Your other content -->
    
        <div class="w-full lg:w-2/3">
            <form id="" action="{{ route('password.match') }}" 
            method="POST" enctype="multipart/form-data" class="bg-white p-6 lg:p-8 rounded-lg shadow-md">

            @csrf
            <input type="hidden" name="user_id" value="{{ $user_id }}">
                
            
                <h2 class="text-xl font-semibold mb-4 headline">
                     {{ $page_title }}</h2>

                     <div class="flex gap-4">
                        <div class="w-full lg:w-6/12">
                            <label for="password" class="block text-sm font-medium text-gray-700"><span class="requird_symble">*</span>নতুন পাসওয়ার্ড</label>
                            <div class="input-group">
                                <input type="password" id="password" name="password" class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full h-10 pl-3 pr-12 border border-gray-300 rounded-md" />
                                <div class="input-group-addon bg-secondary flex items-center eye_open" >
                                    <a href="#" onclick="togglePasswordVisibility('password')" class="flex items-center">
                                     
                                        <!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
                                        <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9.75 12C9.75 10.7574 10.7574 9.75 12 9.75C13.2426 9.75 14.25 10.7574 14.25 12C14.25 13.2426 13.2426 14.25 12 14.25C10.7574 14.25 9.75 13.2426 9.75 12Z" fill="#1C274C"/>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M2 12C2 13.6394 2.42496 14.1915 3.27489 15.2957C4.97196 17.5004 7.81811 20 12 20C16.1819 20 19.028 17.5004 20.7251 15.2957C21.575 14.1915 22 13.6394 22 12C22 10.3606 21.575 9.80853 20.7251 8.70433C19.028 6.49956 16.1819 4 12 4C7.81811 4 4.97196 6.49956 3.27489 8.70433C2.42496 9.80853 2 10.3606 2 12ZM12 8.25C9.92893 8.25 8.25 9.92893 8.25 12C8.25 14.0711 9.92893 15.75 12 15.75C14.0711 15.75 15.75 14.0711 15.75 12C15.75 9.92893 14.0711 8.25 12 8.25Z" fill="#1C274C"/>
                                        </svg>
                                    </a>
                                </div>

                                <div class="input-group-addon bg-secondary flex items-center eye_close">
                                    <a href="#" onclick="togglePasswordVisibility('password')" class="flex items-center">
                                

                                        <!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
                                        <svg fill="#000000" width="25px" height="25px" viewBox="0 0 96 96" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M82.24,22.2438A5.999,5.999,0,1,0,73.7562,13.76L69.455,18.0612A41.15,41.15,0,0,0,48,12.0022c-22.1588,0-35.6814,15.7022-46.9893,32.67a5.9842,5.9842,0,0,0,0,6.6558,110.6522,110.6522,0,0,0,15.8105,19.367L13.76,73.7562A5.999,5.999,0,1,0,22.2438,82.24ZM13.2677,48C25.3256,30.7921,35.2742,24.0015,48,24.0015a29.3537,29.3537,0,0,1,12.6716,2.8431l-9.5927,9.5926A11.1546,11.1546,0,0,0,48,36.0007,12.0112,12.0112,0,0,0,36.0007,48a11.1589,11.1589,0,0,0,.4365,3.0789L25.3014,62.2147A88.0132,88.0132,0,0,1,13.2677,48Z"/>
                                            <path d="M94.9893,44.6721c-2.4234-3.6363-4.9809-7.1751-7.6709-10.5528l-8.5461,8.5461c1.3007,1.6669,2.6131,3.4128,3.96,5.3346C71.1761,64.4924,61.5307,71.3423,49.5475,71.89L38.5714,82.8663A42.5472,42.5472,0,0,0,48,83.9978c22.1588,0,35.6814-15.7022,46.9893-32.67A5.9842,5.9842,0,0,0,94.9893,44.6721Z"/>
                                        </svg>
                                    </a>
                                </div>

                            </div>
                            <div id="password-strength-status" class="text-danger"></div>
                            @error('password')
                                <style>
                                    .eye_open {
                                        top: 8px;
                                    }
                                    .eye_close {
                                        top: 8px;
                                    }
                                </style>
                                <div class="error_alert">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="w-full lg:w-6/12">
                            <label for="confirm_password" class="block text-sm font-medium text-gray-700"><span class="requird_symble">*</span>কনফার্ম পাসওয়ার্ড</label>
                            <input type="password" id="confirm_password" name="confirm_password" class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full h-10 pl-3 pr-12 border border-gray-300 rounded-md" />
                            <span id='message'></span>
                            @error('confirm_password')
                                <div class="error_alert">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                <button type="submit" class="w-full lg:w-auto bg-green-500 text-white p-2 rounded-md mt-4 mx-auto block">পরবর্তী ধাপ</button>
            </form>
        </div>
        
        
        
    </div>

    </section>
    
    <style type="text/css">
        .error_alert {
            color: red;
            font-size: 12px;
            
        }
    </style>


  </body>
    <script src="{{ asset('plugins/global/plugins.bundle.js') }}"></script>

  <script>
   
    function togglePasswordVisibility(inputId) {

        const passwordInput = document.getElementById(inputId);
        const passwordToggleIcon = document.getElementById('passwordToggleIcon');

        if (passwordInput.type === "password") {
            passwordInput.type = "text";

            $(".eye_open").css("display", "none");
            $(".eye_close").css("display", "flex");
            
        } else {
            passwordInput.type = "password";
            
            $(".eye_open").css("display", "flex");
            $(".eye_close").css("display", "none");
        }
    }
    
    
</script>
  
  <script>
    function toggleMenu() {
      document.getElementById("mobileMenu").classList.toggle("hidden");
    }
  </script>
</html>
