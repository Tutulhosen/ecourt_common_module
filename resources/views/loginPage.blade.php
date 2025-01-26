@extends('layout.app')

@section('style')
@endsection

@section('landing')
    <!--begin::Landing hero-->
    <link rel="stylesheet" type="text/css" href="http://parsleyjs.org/src/parsley.css" />
    @auth
        <script>
            window.location.href = "{{ route('dashboard.index') }}";
        </script>
    @else
        <style>
            .hide {
                display: none;
            }

            .show {
                display: block;
            }

            .waring-border-field {
                border: 2px solid tomato;
            }

            .warning-message-alert {
                color: red;
            }

            .waring-message-alert-success {
                color: aqua;
            }

            .waring-border-field-succes {
                border: 2px solid aqua;
            }


            #password-strength-status {
                padding: 5px 10px;
                color: #FFFFFF;
                border-radius: 4px;
                margin-top: 5px;
            }

            .medium-password {
                background-color: #b7d60a;
                border: #BBB418 1px solid;
            }

            .weak-password {
                background-color: #ce1d14;
                border: #AA4502 1px solid;
            }

            .strong-password {
                background-color: #12CC1A;
                border: #0FA015 1px solid;
            }

            .waring-border-field {
                border: 2px solid #f5c6cb !important;

            }

            .warning-message-alert {
                color: red;
            }

            .waring-border-field-succes {
                border: 2px solid #c3e6cb !important;

            }
        </style>

        <div
            style="background-image: url('{{ asset('images/bg.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; padding: 50px; border-radius: 10px;">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6 shadow-sm p-3 mb-5 bg-white rounded mt-3">
                    <img src="{{ asset('/images/logo_court.jpeg') }}" class="w-50" alt="">
                    <p class="text-dark h4 text-center">ইকোর্ট সিস্টেমে লগইন করুন</p>
                    <form action="javascript:void(0)" class="form fv-plugins-bootstrap fv-plugins-framework"
                        id="kt_login_singin_form" action="" novalidate="novalidate">
                        @csrf
                        <div class="form-group fv-plugins-icon-container has-success">

                            <input type="hidden" name="citizen_type_id" id="citizen_type_id" value="{{ $type_id }}">
                            <label class="font-size-h6 font-weight-bolder text-dark pt-5">মোবাইল/ইমেইল</label>
                            <input class="form-control h-auto border-info" placeholder="মোবাইল/ইমেইল" type="text"
                                name="email" autocomplete="off">
                            <div class="d-flex justify-content-between mt-n5">

                                <label class="font-size-h6 font-weight-bolder text-dark pt-10">পাসওয়ার্ড</label>
                            </div>
                            <div class="input-group" id="show_hide_password_1"
                                style="border:1px solid#8950fc!important; border-radius:5px ">
                                <input type="password" id="password" name="password"
                                    placeholder="ব্যবহারকারীর পাসওয়ার্ড লিখুন" class="form-control h-auto border-info"
                                    value="" id="password">
                                <div class="input-group-addon bg-secondary">
                                    <a href=""><i class="fa fa-eye-slash p-5 mt-1" aria-hidden="true"></i></a>
                                </div>
                            </div>


                            <div class="row">
                                <div id="password_reset_btn" class="col-md-4 pt-5">
                                    <a href="" type="button" value="">{{ __('পাসওয়ার্ড রিসেট') }}</a>
                                </div>
                                <div class="col-md-8"></div>
                            </div>
                            <div class="pb-lg-0 pb-5 pt-5">
                                <button onclick="labelmk()" id="kt_login_singin_form_submit_button"
                                    class="text-center btn btn-success w-100">লগইন</button>
                            </div>
                            {{-- <p class="h4 pt-5 text-dark">ইকোর্ট সিস্টেমে একাউন্ট নেই? <a
                                    href="{{ route('citizen.registration') }}">রেজিস্ট্রেশন করুন </a></p> --}}
                        </div>
                    </form>
                </div>
                <div class="col-md-3"></div>
            </div>



        </div>
    @endauth


    {{-- @include('_information_help_center_links') --}}
    <style type="text/css">
        label.error {
            color: red;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
        integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.js"></script>
    <script type="text/javascript"></script>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {

            $("#show_hide_password_1 a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password_1 input').attr("type") == "text") {
                    $('#show_hide_password_1 input').attr('type', 'password');
                    $('#show_hide_password_1 i').addClass("fa-eye-slash");
                    $('#show_hide_password_1 i').removeClass("fa-eye");
                } else if ($('#show_hide_password_1 input').attr("type") == "password") {
                    $('#show_hide_password_1 input').attr('type', 'text');
                    $('#show_hide_password_1 i').removeClass("fa-eye-slash");
                    $('#show_hide_password_1 i').addClass("fa-eye");
                }
            });

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

            $("#password_reset_btn").on('click', function(e) {
                e.preventDefault();
                const citizen_type_id = $("#kt_login_singin_form #citizen_type_id").val();
                if (!citizen_type_id) {
                    toastr.info('Please select a login type', "Error");
                    return;
                } else {
                    // return redirect()->route('applicant.forget.password');
                    // alert(citizen_type_id)
                    window.location.href = `/applicant/forget/password/${citizen_type_id}`;
                }
            })

        });
    </script>

    <script type="text/javascript">
        function labelmk() {
            var _token = $("#kt_login_singin_form input[name='_token']").val();
            var email = $("#kt_login_singin_form input[name='email']").val();
            var password = $("#kt_login_singin_form input[name='password']").val();
            var citizen_type_id = $("#kt_login_singin_form #citizen_type_id").val();


            if (email == '' || password == '') {
                toastr.info('Email or password not will be null!', "Error");
                return;
            }
            $.ajax({
                url: "{{ url('') }}/logined_in",
                type: 'POST',
                data: {
                    _token: _token,
                    email: email,
                    password: password,
                    citizen_type_id: citizen_type_id,
                },
                success: function(data) {

                    if ($.isEmptyObject(data.error)) {
                        toastr.success(data.success, "Success");
                        //$('#exampleModalLong').modal('toggle');
                        console.log(data.success);
                        setTimeout(function() {
                            // location.reload();
                            $(location).attr('href', "{{ url('') }}/dashboard/{id}");
                        }, 1000);
                    } else {
                        //toastr.error(data.error, "Error");
                        Swal.fire(data.nothi_msg);

                        // printErrorMsg(data.error);
                    }
                }
            });
        }
    </script>
@endsection
