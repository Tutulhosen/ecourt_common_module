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
            
            display: flex;
           
        
        }
        .eye_close {
            
            display: none;
           
        
        }
    </style>

<style>
    /* Updated CSS styles */
    /* Adjust container to display items horizontally */
    .items-center {
      display: flex;
      align-items: center;
    }

    /* Style select options */
    select.form-control {
      padding: 0.375rem 0.75rem;
      font-size: 1rem;
      line-height: 1.5;
      color: #495057;
      background-color: #fff;
      background-clip: padding-box;
      border: 1px solid #ced4da;
      border-radius: 0.25rem;
      transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    select.form-control-2 {
      padding: 0.375rem 12.75rem;
      /* width: 12.75rem; */
      /* height: 0.375rem; */
      font-size: 1rem;
      line-height: 1.5;
      color: #495057;
      background-color: #fff;
      background-clip: padding-box;
      border: 1px solid #ced4da;
      border-radius: 0.25rem;
      transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    /* Align password fields */
    .password-fields {
      display: flex;
      justify-content: space-between;
    }
    .select-container {
        display: flex;
        gap: 1rem; /* Adjust the gap between select fields */
    }
    .align-left {
        text-align: left !important;
    }

    /* Your existing styles */
  </style>


    <section class="relative">
    
      {{-- <img class="min-h-[150vh]" src="{{asset('images/bg.png')}}" alt="E-Court" width="100%" height="100%" /> --}}
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

      
      <div class="absolute left-0 right-0 bottom-0 top-40 container mx-auto px-2 flex flex-col items-center gap-2 lg:gap-10">
        <!-- Your other content -->
    
        <div class="w-full lg:w-3/3">
            <form id="" action="{{ route('password.match.organization') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 lg:p-8 rounded-lg shadow-md">
    
                @csrf
                <input type="hidden" name="user_id" value="{{ $user_id }}">
    
                <h2 class="text-xl font-semibold mb-4 headline">{{ $page_title }}</h2>
    
                <div class="flex flex-wrap ">
                    <div class="w-full lg:w-1/4 px-2 mb-5">
                        <label class="block text-sm font-medium text-gray-700">বিভাগ নির্বাচন<span class="text-red-500">*</span></label>
                        <select class="w-full p-2 border border-[#ced4da] rounded-md text-[#495057] text-sm font-medium text-gray-700" aria-label=".form-select-lg example" name="division_id" id="division_id" required>
                            <option value="">বিভাগ নির্বাচন করুন </option>
                            @foreach ($division as $single_division)
                                <option value="{{ $single_division->id }}">{{ $single_division->division_name_bn }}
                                </option>
                            @endforeach
                            @error('division_id')
                            <div class="error_alert">{{ $message }}</div>
                        @enderror
                        </select>
                    </div>
                    <div class="w-full lg:w-1/4 px-2 mb-5">
                        <label class="block text-sm font-medium text-gray-700">জেলা নির্বাচন করুন <span class="text-red-500">*</span></label>
                        <select class="w-full p-2 border border-[#ced4da] rounded-md text-[#495057] text-sm font-medium text-gray-700" aria-label=".form-select-lg example" name="district_id"
                            id="district_id" required>
                            <option value="">জেলা নির্বাচন করুন </option>
                            @error('district_id')
                                <div class="error_alert">{{ $message }}</div>
                            @enderror
                        </select>
                    </div>
                    <div class="w-full lg:w-1/4 px-2 mb-5">
                        <label class="block text-sm font-medium text-gray-700">উপজেলা নির্বাচন করুন <span class="text-red-500">*</span></label>
                        <select class="w-full p-2 border border-[#ced4da] rounded-md text-[#495057] text-sm font-medium text-gray-700" aria-label=".form-select-lg example" name="upazila_id"
                            id="upazila_id" required>
                            <option value="">উপজেলা নির্বাচন করুন </option>
                            @error('upazila_id')
                                <div class="error_alert">{{ $message }}</div>
                            @enderror
                        </select>
                    </div>
                    <div class="w-full lg:w-1/4 px-2 mb-5">
                        <label class="block text-sm font-medium text-gray-700">প্রতিষ্ঠানের ধরন নির্বাচন করুন <span class="text-red-500">*</span></label>
                        <select class="w-full p-2 border border-[#ced4da] rounded-md text-[#495057] text-sm font-medium text-gray-700" aria-label=".form-select-lg example" name="organization_type"
                                id="organization_type" required>
                                <option value="">প্রতিষ্ঠানের ধরন নির্বাচন করুন </option>
                                <option value="BANK">ব্যাংক</option>
                                <option value="GOVERNMENT">সরকারি প্রতিষ্ঠান</option>
                                <option value="OTHER_COMPANY">স্বায়ত্তশাসিত প্রতিষ্ঠান</option>
                                @error('organization_type')
                                    <div class="error_alert">{{ $message }}</div>
                                @enderror
                        </select>
                    </div>
                </div>
                <div class="flex flex-wrap">
                    <div class="w-full lg:w-1/2 px-2 mb-5">
                        <label class="block text-sm font-medium text-gray-700">প্রতিষ্ঠানের নাম<span class="text-red-500">*</span></label>
                        <select class="w-full p-2 border border-[#ced4da] rounded-md text-[#495057] text-sm font-medium text-gray-700" aria-label=".form-select-lg example" name="office_id" id="office_id" required>
                            <option value="">প্রতিষ্ঠান নির্বাচন করুন </option>
                 
                            @error('office_id')
                                <div class="error_alert">{{ $message }}</div>
                            @enderror
                        </select>
                    </div>
                    <div class="w-full lg:w-1/2 px-2 mb-5">
                        <label class="block text-sm font-medium text-gray-700">প্রতিষ্ঠানের নাম বাংলাতে<span class="text-red-500">*</span></label>
                        <input type="text" name="office_name_bn" id="office_name_bn" class="w-full p-2 border border-[#ced4da] rounded-md text-[#495057] text-sm font-medium text-gray-700" value="{{ old('office_name_bn') }}">
                        @error('office_name_bn')
                            <div class="error_alert">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="flex flex-wrap">
                    <div class="w-full lg:w-1/2 px-2 mb-5">
                        <label class="block text-sm font-medium text-gray-700">প্রতিষ্ঠানের নাম ইংরেজিতে<span class="text-red-500">*</span></label>
                        <input type="text" name="office_name_en" id="office_name_en" class="w-full p-2 border border-[#ced4da] rounded-md text-[#495057] text-sm font-medium text-gray-700" value="{{ old('office_name_en') }}">
                        @error('office_name_en')
                        <div class="error_alert">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-full lg:w-1/2 px-2 mb-5">
                        <label class="block text-sm font-medium text-gray-700">প্রতিষ্ঠানের ঠিকানা<span class="text-red-500">*</span></label>
                        <input type="text" name="organization_physical_address" id="organization_physical_address" class="w-full p-2 border border-[#ced4da] rounded-md text-[#495057] text-sm font-medium text-gray-700" value="{{ old('organization_physical_address') }}" >
                        @error('organization_physical_address')
                            <div class="error_alert">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="flex flex-wrap">
                    <div class="w-full lg:w-1/2 px-2 mb-5">
                        <label class="block text-sm font-medium text-gray-700">প্রতিষ্ঠান প্রতিনিধির আইডি (ইংরেজিতে)<span class="text-red-500">*</span></label>
                        <input type="text" name="organization_employee_id" id="organization_employee_id" class="w-full p-2 border border-[#ced4da] rounded-md text-[#495057] text-sm font-medium text-gray-700" value="{{ old('organization_employee_id') }}">
                        @error('organization_employee_id')
                            <div class="error_alert">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-full lg:w-1/2 px-2 mb-5">
                        <label class="block text-sm font-medium text-gray-700">পদবী<span class="text-red-500">*</span></label>
                        <input type="text" name="designation" id="designation" class="w-full p-2 border border-[#ced4da] rounded-md text-[#495057] text-sm font-medium text-gray-700" value="{{ old('designation') }}">
                        @error('designation')
                            <div class="error_alert">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="flex flex-wrap">
                    <div class="w-full lg:w-1/2 px-2 mb-5">
                        <label class="block text-sm font-medium text-gray-700">রাউটিং নং (ইংরেজিতে)<span class="text-red-500">*</span></label>
                        <input type="text" name="organization_id" id="organization_id" class="w-full p-2 border border-[#ced4da] rounded-md text-[#495057] text-sm font-medium text-gray-700" value="{{ old('organization_id') }}">
                        @error('organization_id')
                            <div class="error_alert">{{ $message }}</div>
                        @enderror
                    </div>
                    
                </div>
                <div class="flex gap-4">
                    <div class="w-full lg:w-6/12">
                        <label for="password" class="block text-sm font-medium text-gray-700"><span class="requird_symble">*</span>নতুন পাসওয়ার্ড</label>
                        <div class="input-group">
                            <div class="flex items-center border rounded-md">
                                <input type="password" id="password" name="password" class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full h-10 pl-3 pr-12  rounded-md outline-none" />
                                <button type="button" onclick="togglePasswordVisibility('password')" class="flex items-center eye_open">
                                   
                                    <!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
                                    <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9.75 12C9.75 10.7574 10.7574 9.75 12 9.75C13.2426 9.75 14.25 10.7574 14.25 12C14.25 13.2426 13.2426 14.25 12 14.25C10.7574 14.25 9.75 13.2426 9.75 12Z" fill="#1C274C"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M2 12C2 13.6394 2.42496 14.1915 3.27489 15.2957C4.97196 17.5004 7.81811 20 12 20C16.1819 20 19.028 17.5004 20.7251 15.2957C21.575 14.1915 22 13.6394 22 12C22 10.3606 21.575 9.80853 20.7251 8.70433C19.028 6.49956 16.1819 4 12 4C7.81811 4 4.97196 6.49956 3.27489 8.70433C2.42496 9.80853 2 10.3606 2 12ZM12 8.25C9.92893 8.25 8.25 9.92893 8.25 12C8.25 14.0711 9.92893 15.75 12 15.75C14.0711 15.75 15.75 14.0711 15.75 12C15.75 9.92893 14.0711 8.25 12 8.25Z" fill="#1C274C"/>
                                    </svg>
                                </button>
                                <button type="button" onclick="togglePasswordVisibility('password')" style="display: none" class="flex items-center eye_close">
                                  

                                    <!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
                                    <svg fill="#000000" width="25px" height="25px" viewBox="0 0 96 96" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M82.24,22.2438A5.999,5.999,0,1,0,73.7562,13.76L69.455,18.0612A41.15,41.15,0,0,0,48,12.0022c-22.1588,0-35.6814,15.7022-46.9893,32.67a5.9842,5.9842,0,0,0,0,6.6558,110.6522,110.6522,0,0,0,15.8105,19.367L13.76,73.7562A5.999,5.999,0,1,0,22.2438,82.24ZM13.2677,48C25.3256,30.7921,35.2742,24.0015,48,24.0015a29.3537,29.3537,0,0,1,12.6716,2.8431l-9.5927,9.5926A11.1546,11.1546,0,0,0,48,36.0007,12.0112,12.0112,0,0,0,36.0007,48a11.1589,11.1589,0,0,0,.4365,3.0789L25.3014,62.2147A88.0132,88.0132,0,0,1,13.2677,48Z"/>
                                        <path d="M94.9893,44.6721c-2.4234-3.6363-4.9809-7.1751-7.6709-10.5528l-8.5461,8.5461c1.3007,1.6669,2.6131,3.4128,3.96,5.3346C71.1761,64.4924,61.5307,71.3423,49.5475,71.89L38.5714,82.8663A42.5472,42.5472,0,0,0,48,83.9978c22.1588,0,35.6814-15.7022,46.9893-32.67A5.9842,5.9842,0,0,0,94.9893,44.6721Z"/>
                                    </svg>
                                </button>
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
    
                <button type="submit" class="w-full lg:w-auto bg-green-500 text-white p-2 rounded-md mt-4 mx-auto block" onclick="return confirm('আপনি কি সংরক্ষণ করতে চান?')">সংরক্ষণ করুন</button>
                
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


<script src="{{asset('assets/js/pages/custom/login/login-3.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function() {


        $(".only_english").keypress(function(event) {
            var ew = event.which;
            if (ew == 32)
                return true;
            if (48 <= ew && ew <= 57)
                return true;
            if (65 <= ew && ew <= 90)
                return true;
            if (97 <= ew && ew <= 122)
                return true;
            return false;
        });

        jQuery('select[name="division_id"]').on('change', function() {
            var dataID = jQuery(this).val();
            // alert(dataID);
            // var category_id = jQuery('#category_id option:selected').val();
            jQuery("#district_id").after('<div class="loadersmall"></div>');
            // $("#loading").html("<img src='{{ asset('media/preload.gif') }}' />");
            // jQuery('select[name="mouja"]').html('<option><div class="loadersmall"></div></option');
            // jQuery('select[name="mouja"]').attr('disabled', 'disabled');
            // jQuery('.loadersmall').remove();
            if (dataID) {
                jQuery.ajax({
                    url: '{{ url('/') }}/case/dropdownlist/getdependentdistrict/' +
                        dataID,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        jQuery('select[name="district_id"]').html(
                            '<div class="loadersmall"></div>');
                        //console.log(data);
                        // jQuery('#mouja_id').removeAttr('disabled');
                        // jQuery('#mouja_id option').remove();

                        jQuery('select[name="district_id"]').html(
                            '<option value="">-- নির্বাচন করুন --</option>');
                        jQuery.each(data, function(key, value) {
                            jQuery('select[name="district_id"]').append(
                                '<option value="' + key + '">' + value +
                                '</option>');
                        });
                        jQuery('.loadersmall').remove();
                        // $('select[name="mouja"] .overlay').remove();
                        // $("#loading").hide();
                    }
                });
            } else {
                $('select[name="district_id"]').empty();
            }
        });

        // Upazila Dropdown
        jQuery('select[name="district_id"]').on('change', function() {
            var dataID = jQuery(this).val();
            // var category_id = jQuery('#category_id option:selected').val();
            jQuery("#upazila_id").after('<div class="loadersmall"></div>');
            // $("#loading").html("<img src='{{ asset('media/preload.gif') }}' />");
            // jQuery('select[name="mouja"]').html('<option><div class="loadersmall"></div></option');
            // jQuery('select[name="mouja"]').attr('disabled', 'disabled');
            // jQuery('.loadersmall').remove();
            /*if(dataID)
            {*/
            jQuery.ajax({
                url: '{{ url('/') }}/case/dropdownlist/getdependentupazila/' +
                    dataID,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    jQuery('select[name="upazila_id"]').html(
                        '<div class="loadersmall"></div>');
                    //console.log(data);
                    // jQuery('#mouja_id').removeAttr('disabled');
                    // jQuery('#mouja_id option').remove();

                    jQuery('select[name="upazila_id"]').html(
                        '<option value="">-- নির্বাচন করুন --</option>');
                    jQuery.each(data, function(key, value) {
                        jQuery('select[name="upazila_id"]').append(
                            '<option value="' + key + '">' + value + '</option>'
                        );
                    });
                    jQuery('.loadersmall').remove();
                    // $('select[name="mouja"] .overlay').remove();
                    // $("#loading").hide();
                }
            });

        });

        jQuery('#organization_type').on('change', function() {
            var organization_type = jQuery(this).val();
            jQuery("#office_id").after('<div class="loadersmall"></div>');
            jQuery.ajax({
                url: '{{ url('/') }}/case/dropdownlist/getdependentorganization/',
                type: "POST",
                dataType: "json",
                data: {

                    _token: "{{ csrf_token() }}",
                    division_id: $('#division_id').val(),
                    district_id: $('#district_id').val(),
                    upazila_id: $('#upazila_id').val(),
                    organization_type: organization_type
                },
                success: function(data) {


                    jQuery('select[name="office_id"]').html(
                        '<option value="">-- নির্বাচন করুন --</option>');
                    jQuery.each(data, function(key, value) {
                        jQuery('select[name="office_id"]').append(
                            '<option value="' + value.id + '">' + value
                            .office_name_bn + '</option>'
                        );
                    });
                    jQuery('select[name="office_id"]').append(
                        '<option value="OTHERS">অনন্যা</option>'
                    );
                }
            });

        })


        jQuery('#office_id').on('change', function() {

            var dataID = jQuery(this).val();
            if (dataID == "OTHERS") {
                $('#organization_physical_address').val("");
                $('#organization_physical_address').prop('readonly', false);
                $('#organization_id').val("");;
                $('#organization_id').prop('readonly', false);

                $('#office_name_bn').val("");
                $('#office_name_bn').prop('readonly', false);
                $('#office_name_en').val("");
                $('#office_name_en').prop('readonly', false);
            } else {
                jQuery.ajax({
                    url: '{{ url('/') }}/case/dropdownlist/getdependentOfficeName/' +
                        dataID,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('#organization_physical_address').val(data
                            .organization_physical_address);
                        $('#organization_physical_address').prop('readonly', true);
                        $('#organization_id').val(data.organization_routing_id);
                        $('#organization_id').prop('readonly', true);
                        $('#office_name_bn').val(data.office_name_bn);
                        $('#office_name_en').val(data.office_name_en);
                        $('#office_name_bn').prop('readonly', true);
                        $('#office_name_en').prop('readonly', true);
                    }
                });
            }

        })

       

        $('#password, #confirm_password').on('keyup', function() {
            if ($('#password').val() == $('#confirm_password').val()) {
                $('#message').html('Matching').css('color', 'green');
            } else
                $('#message').html('Not Matching').css('color', 'red');
        });

        


        $("#password").on('keyup', function() {
            var number = /([0-9])/;
            var alphabets = /([a-zA-Z])/;
            var special_characters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;
            if ($('#password').val().length < 6) {
                $('#password-strength-status').removeClass();
                $('#password-strength-status').addClass('text-red-500');
                $('#password-strength-status').html("দুর্বল (অন্তত 6টি অক্ষর হতে হবে।)");
                jQuery('#password').removeClass('waring-border-field-succes');
                jQuery('#password').addClass('waring-border-field');
            } else {
                if ($('#password').val().match(number) && $('#password').val().match(alphabets) && $(
                        '#password').val().match(special_characters)) {
                    $('#password-strength-status').removeClass();
                    $('#password-strength-status').addClass('text-green-500');
                    $('#password-strength-status').html("শক্তিশালী");
                    jQuery('#password').removeClass('waring-border-field');
                    jQuery('#password').addClass('waring-border-field-succes');
                } else {
                    $('#password-strength-status').removeClass();
                    $('#password-strength-status').addClass('text-yellow-500');
                    $('#password-strength-status').html(
                        "মাঝারি (পাসওয়ার্ডে অন্তত একটি বড় হাতের অক্ষর, একটি ছোট হাতের অক্ষর, একটি সংখ্যা এবং একটি বিশেষ অক্ষর থাকতে হবে।)"
                    );
                    jQuery('#password').removeClass('waring-border-field');
                    jQuery('#password').addClass('waring-border-field-succes');
                }
            }
        });

        function isEmail(email) {
            var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            return regex.test(email);
        }

        function isPhone(phone) {
            var regex = /(^(\+8801|8801|01|008801))[1|3-9]{1}(\d){8}$/;
            return regex.test(phone);
        }

        $('#mobile_no').on('keyup', function() {

            let is_phone = isPhone($('#mobile_no').val());

            if (!is_phone) {
                $(this).addClass('waring-border-field');
                $(this).next('.phone_alert').removeClass('hide');
                $(this).next('.phone_alert').addClass('show warning-message-alert');
            } else {

                $(this).removeClass('waring-border-field');
                $(this).next('.phone_alert').addClass('hide');
                $(this).next('.phone_alert').removeClass('show warning-message-alert');
            }

        })
        $('#email').on('keyup', function() {

            let is_email = isEmail($('#email').val());
            if (!is_email) {
                $(this).addClass('waring-border-field');
                $(this).next('.email_alert').removeClass('hide');
                $(this).next('.email_alert').addClass('show warning-message-alert');
            } else {

                $(this).removeClass('waring-border-field');
                $(this).next('.email_alert').addClass('hide');
                $(this).next('.email_alert').removeClass('show warning-message-alert');
            }


        })


    });
</script>

</html>
