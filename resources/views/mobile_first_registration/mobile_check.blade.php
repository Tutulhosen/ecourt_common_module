@php
    $max_edit_time = 10;
    $last_edit_time = strtotime($updated_at_otp);
    //dd($last_edit_time);
    $current_time = time();
    //$remaining_minutes = abs(($current_time - $last_edit_time)/60 - $max_edit_time);
    $remaining_minutes = $max_edit_time - ($current_time - $last_edit_time) / 60;
    $remaining_ms = ($current_time - $last_edit_time) * 1000;
    
@endphp
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
        
        .requird_symble{
            color: red;
            padding: 5px
        }
    </style>

    <section class="relative">
    {{-- @foreach ($gcc_role as $item)
        {{$item->role_name}}
    @endforeach --}}
  
      <img class="h-screen lg:min-h-[120vh]" src="{{asset('images/bg.png')}}" alt="E-Court" width="100%" height="100%" />
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

      <div class="absolute left-0 right-0 bottom-0 lg:bottom-20 top-[140px] container mx-auto px-2 flex flex-col items-center gap-2 lg:gap-10">
        <!-- Your other content -->
        @if (isset($results))
            <h4 class="p-2 text-center"
                style="color: #fff;
            background-color: #886400;
            border-color: #008841;
            border-radius:5px
            ">
                {{ $results }} এর জন্য
            </h4>
        @endif
        
        <div class="w-full lg:w-2/3" >
            <form id="nidVerifyForm" action="{{ route('registration.otp.verify') }}" 
            method="POST" enctype="multipart/form-data" class="bg-white p-6 lg:p-8 rounded-lg shadow-md">
            @csrf
                
                
            <div class="cont" style="text-align: center">
                <h1 class="headline" style="font-size: 30px">মোবাইল নম্বর ভেরিফিকেশন ফর্ম</h1><br>
                @if ($errors->any())
                    <div style="background-color: red; color:white; padding:8px; border-radius:5px">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <p style="font-size: 20px;">আপনার মোবাইল ফোনে <span style="color:red">{{ $mobile }}
                </span> প্রদত্ত ওটিপি কোড টি লিখুন</p><br>
            <p style="color: #008841">
                আপনার প্রদত্ত মোবাইল নম্বরে একটি ওটিপি প্রদান করা হয়েছে। সেই ওটিপি প্রদান করে আপনার
                মোবাইল নম্বর যাচাই করুন
            </p>
            <br>
            </div>
                <input type="hidden" name="user_id" value="{{ $user_id }}">

                <div class="flex justify-center">
                    <div class="w-full lg:w-8/12">
                        <div class="form-group flex  justify-around">
                            {{-- <div class="code-container"></div>
                            <div class="w-full lg:w-1/6"></div> --}}
                            <div class="flex flex-col">
                                <input type="text" name="otp_1" id="otp_1" class=" code w-[6em] h-10 border border-gray-300 rounded-md mx-1 text-center" placeholder="0" minlength="1" data-item="2" maxlength="1" required>
                            </div>
                            <div class="flex flex-col">
                                <input type="text" name="otp_2" id="otp_2" class=" code w-[6em] h-10 border border-gray-300 rounded-md mx-1 text-center" placeholder="0" minlength="1" data-item="3" maxlength="1" required>
                            </div>
                            <div class="flex flex-col">
                                <input type="text" name="otp_3" id="otp_3" class=" code w-[6em] h-10 border border-gray-300 rounded-md mx-1 text-center" placeholder="0" minlength="1" data-item="4" maxlength="1" required>
                            </div>
                            <div class="flex flex-col">
                                <input type="text" name="otp_4" id="otp_4" class=" code w-[6em] h-10 border border-gray-300 rounded-md mx-1 text-center" placeholder="0" minlength="1" data-item="" maxlength="1" required>
                            </div>
                            
                            
                            
                            
                        </div><br>
                        <div class="text-center">
                            <a href="" class="text-success"><b class="text-lg" style="color:#1bc5bd">এখনও ওটিপি আসে নাই?</b></a>
                        </div>
                        <div class="text-center">
                            <h2 id="count_down_show" class="text-primary" style="color: #3699ff; font-size:20px"></h2>
                        </div>
                        <div class="text-center">
                            <a href="{{ route('registration.citizen.reg.opt.resend', ['user_id' => encrypt($user_id)]) }}" class="text-danger"><b class="text-lg" style="color: red">পুনরায় চেষ্টা করুন</b></a>
                        </div>
                    </div>
                </div>
                <button type="submit" class="w-full lg:w-auto bg-green-500 text-white p-2 rounded-md mt-4 mx-auto block">পরবর্তী ধাপ</button>
            </form>
        </div>
        
        
        
    </div>

    </section>
    



  </body>
  <style type="text/css">
    label.error {
        color: red;
        font-size: 12px;
    }
</style>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
    integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.js"></script>
    <script type="text/javascript">
    $('.code').on('keyup', function() {

        var new_id = $(this).data('item');
        $('#otp_' + new_id).focus();
    })


    countdown("count_down_show", "timer", 0);

    function countdown(elementName, elementName2, seconds) {
        var minutes = parseFloat({{ $remaining_minutes }});

        var element, endTime, hours, mins, msLeft, time;

        function twoDigits(n) {
            return (n <= 9 ? "0" + n : n);
        }

        function updateTimer() {
            msLeft = endTime - (+new Date);

            if (msLeft < 1000) {
                element.innerHTML = "Time is up!";
                //element1.innerHTML = "Time is up!";
                //  jQuery('#time_showing').addClass('text-danger');
                //  jQuery('#time_in_modal').addClass('text-danger');
                jQuery('.buttonsDiv').hide();
                jQuery('#user_form_update_button').hide();
            } else {
                time = new Date(msLeft);
                hours = time.getUTCHours();
                mins = time.getUTCMinutes();
                element.innerHTML = (hours ? hours + ':' + twoDigits(mins) : mins) + ':' + twoDigits(time
                .getUTCSeconds());
                setTimeout(updateTimer, time.getUTCMilliseconds() + 500);
                //element1.innerHTML=(hours ? hours + ':' + twoDigits( mins ) : mins) + ':' + twoDigits( time.getUTCSeconds() );
                setTimeout(updateTimer, time.getUTCMilliseconds() + 500);
            }
        }

        element = document.getElementById(elementName);
        //element1 = document.getElementById( elementName2 );
        endTime = (+new Date) + 1000 * (60 * minutes + seconds) + 500;
        updateTimer();
    }


    // $(document).ready(function() {
    // Jquery custome validate
    $.validator.addMethod("nidlength", function(value, element) {
        var nid = $('#nid_no').val().length;
        if (nid == 10 || nid == 13 || nid == 17) {
            return true;
        }
        // return nid == 10 || nid == 13 || nid == 17;
        // return value.indexOf(" ") < 0 && value != ""; 
    }, "শুধুমাত্র ১০, ১৩ অথবা ১৭ সংখ্যা প্রযোজ্য");

    // Validate User Registration
    $('#nidVerifyForm').validate({
        focusInvalid: false,
        ignore: "",
        rules: {
            nid_no: {
                required: true,
                digits: true,
                nidlength: true,
                minlength: 10,
                maxlength: 17
            },
            dob: {
                required: true,
                date: true
            }
        },

        messages: {

            nid_no: {
                required: "ন্যাশনাল আইডি প্রদান করুন",
                minlength: "সর্বনিন্ম {0} টি সংখ্যা প্রদান করুন"
            },

            dob: {
                required: "ন্যাশনাল আইডি অনুসারে জন্ম তারিখ প্রদান করুন "
            },
        },

        invalidHandler: function(event, validator) {
            //display error alert on form submit    
        },

        errorPlacement: function(label, element) { // render error placement for each input type  
            $('<span class="error"></span>').insertAfter(element).append(label)
            // $('<span class="error"></span>').insertAfter(element).append(label)
            var parent = $(element).parent('.input-with-icon');
            parent.removeClass('success-control').addClass('error-control');
        },

        highlight: function(element) { // hightlight error inputs

        },

        unhighlight: function(element) { // revert the change done by hightlight

        },

        success: function(label, element) {
            var parent = $(element).parent('.input-with-icon');
            parent.removeClass('error-control').addClass('success-control');
        },

        submitHandler: function(form) {
            form.submit();
        }
    });
    // });   
    </script>

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

        // common datepicker =============== start
        $('.common_datepicker').datepicker({
            format: "yyyy/mm/dd",
            todayHighlight: true,
            mindate: new Date(),
            orientation: "bottom left"
        });
        // common datepicker =============== end


    




    });
</script>
@endsection
</html>
