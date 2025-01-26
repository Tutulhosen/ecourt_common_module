@extends('dashboard.inc.emc.layouts.app')

@section('content')

    <style>
        .blink {
            animation: blinker 1.5s linear infinite;
            color: red;
            font-family: sans-serif;
        }

        @keyframes blinker {
            50% {
                opacity: 0;
            }
        }
    </style>
    <style>
        #example thead th {
            color: white !important;
            font-weight: bold;
            font-size: 16px;
            background-color: green;
        }

        #example tbody td {

            font-size: 16px
        }
    </style>

    <!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header flex-wrap py-5">
            <div class="card-title">
                <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>
            </div>
            @if (Auth::user()->role_id == 5)
                <div class="card-toolbar">
                    <a href="{{ url('case/add') }}" class="btn btn-sm btn-primary font-weight-bolder">
                        <i class="la la-plus"></i>নতুন মামলা এন্ট্রি
                    </a>
                </div>
            @endif
        </div>
        <div class="card-body overflow-auto">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    {{ $message }}
                </div>
            @endif
            @if ($message = Session::get('error'))
                <div class="alert alert-danger">
                    {{ $message }}
                </div>
            @endif

            @include('appeal.search')
            @php
                $trial_date = date('Y-m-d', strtotime(now()));
                $trial_time = date('H:i:s', strtotime(now()));
                $today = date('Y-m-d', strtotime(now()));
                $today_time = date('H:i:s', strtotime(now()));
            @endphp



            <table class="table table-hover mb-6 font-size-h5" id="example">
                <thead class="thead-customStyle font-size-h6">
                    <tr>
                        <th scope="col">ক্রমিক নং</th>
                        <th scope="col">মামলার অবস্থা</th>
                        @if (Auth::user()->citizen_type_id != 2)
                            <th scope="col">রোল</th>
                        @endif
                        <th scope="col">মামলা নম্বর</th>
                        <th scope="col">আবেদনকারীর নাম</th>
                        <th scope="col">ম্যানুয়াল মামলা নম্বর</th>

                        <th scope="col">পরবর্তী তারিখ</th>
                     
                     
                        <th scope="col" width="70">পদক্ষেপ </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($results as $key => $row)
                        @if ($row->appeal_status == 'CLOSED')
                            @php
                                $finalOrderDate = date_create($row->final_order_publish_date);
                                $today = date_create(date('Y-m-d', strtotime(now())));
                                $diff = date_diff($finalOrderDate, $today);
                                $difference = $diff->format('%a');

                            @endphp
                        @endif
                        @php

                            if (date('a', strtotime($row->next_date_trial_time)) == 'am') {
                                $time = 'সকাল';
                            } else {
                                $time = 'বিকাল';
                            }
                        @endphp

                        <tr>

                            <td scope="row" class="tg-bn">{{ en2bn($loop->index + 1) }}.</td>
                            <td> {{ appeal_status_bng($row->appeal_status) }}</td> {{-- Helper Function for Bangla Status --}}
                            @if (Auth::user()->citizen_type_id != 2)
                                <td>{{ citizen_type_name($row->type_id) }}</td>
                            @endif

                            <td>{{ $row->case_no }}</td>
                            <td>

                                {{ isset($row->citizen_name) ? $row->citizen_name : '-' }}
                            </td>
                            <td>{{ $row->manual_case_no }}</td>

                            @if ($row->appeal_status == 'ON_TRIAL' || $row->appeal_status == 'ON_TRIAL_DM')
                                <td>{{ $row->next_date == '1970-01-01' ? '-' : en2bn($row->next_date) }}</td>
                            @else
                                <td class="text-center"> -- </td>
                            @endif
                            
                            <td>
                                <div class="btn-group float-right">
                                    <button class="btn btn-primary font-weight-bold btn-sm dropdown-toggle" type="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">পদক্ষেপ </button>
                                    @if (Auth::user()->citizen_type_id != 2)
                                            @if (!empty($court_type))
                                                @if ($court_type=='gcc')
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item"
                                                            href="{{ route('gcc.citizen.appeal.case.details', encrypt($row->id)) }}">বিস্তারিত
                                                            তথ্য</a>
        
                                                        <a class="dropdown-item"
                                                            href="{{ route('gcc.citizen.appealTraking', encrypt($row->id)) }}">মামলা
                                                            ট্র্যাকিং</a>
                                                        @if($row->is_hearing_required == 1)
                                                                <a class="dropdown-item" href="">অনলাইন শুনানি</a>
                                                        @endif
                                                        @if ($row->appeal_status == 'CLOSED' && globalUserInfo()->citizen_type_id == 1)
                                                            @if ($row->appeal_process_fee_status == 'SENT_TO_DEFAULTER')
                                                                <a class="dropdown-item" href="{{ route('gcc.citizen.certify.copy.fee', ['id' => encrypt($row->id), 'court_id' => encrypt($row->court_id)]) }}">সার্টিফাইড কপির ফি প্রদান</a>
                                                            @elseif ($row->appeal_process_fee_status == 'CERTIFY_COPY_FEE_COMPLETE')
                                                                <a class="dropdown-item" href="{{ route('gcc.citizen.attached.certify.copy.page', ['id' => encrypt($row->id), 'court_id' => encrypt($row->court_id)]) }}">সার্টিফাইড কপি যুক্ত করুন</a>
                                                            @elseif ($row->appeal_process_fee_status == 'PROCESS_COMPLETE' && $row->appeal_process_status != 'CANCEL_APPEAL')
                                                                <a class="dropdown-item" href="{{ route('gcc.citizen.appeal.court.fee', ['id' => encrypt($row->id), 'court_id' => encrypt($row->court_id)]) }}">আপিল করুন</a>
                                                            @elseif($row->appeal_process_fee_status == NULL && $row->appeal_status == 'CLOSED')
                                                                <a class="dropdown-item" href="{{ route('gcc.citizen.court.fee', ['id' => encrypt($row->id), 'court_id' => encrypt($row->court_id)]) }}">সার্টিফাইড কপির জন্য আবেদন</a>
                                                            
                                                            @endif
                                                            

                                                        @endif
        
        
        
        
                                                        @if (globalUserInfo()->role_id == 36)
                                                            @if ($row->appeal_status == 'SEND_ASST_TO_EM' || $row->appeal_status == 'SEND_ASST_TO_ADM')
                                                                <a class="dropdown-item" href="">সংশোধন
                                                                    করুন</a>
                                                            @endif
                                                        @endif
        
                                                        @if ($row->next_date == $today && $row->next_date_trial_time <= $today_time && $row->is_hearing_required == 1)
                                                            <a class="dropdown-item blink" href="" style="color: red;"
                                                                target="_blank">অনলাইন শুনানি</a>
                                                        @endif
                                                    </div>
                                                @endif
                                            @else
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item"
                                                        href="{{ route('emc.citizen.appeal.case.details', encrypt($row->id)) }}">বিস্তারিত
                                                        তথ্য</a>

                                                    <a class="dropdown-item"
                                                        href="{{ route('emc.citizen.appealTraking', encrypt($row->id)) }}">মামলা
                                                        ট্র্যাকিং</a>
                                               
                                                    {{-- @if (globalUserInfo()->role_id != 20 && globalUserInfo()->role_id != 36)
                                                        <a class="dropdown-item"
                                                            href="">নথি দেখুন
                                                        </a>
                                                    @endif --}}




                                                    @if (globalUserInfo()->role_id == 36)
                                                        @if ($row->appeal_status == 'SEND_ASST_TO_EM' || $row->appeal_status == 'SEND_ASST_TO_ADM')
                                                            <a class="dropdown-item" href="">সংশোধন
                                                                করুন</a>
                                                        @endif
                                                    @endif

                                                    @if ($row->next_date == $today && $row->next_date_trial_time <= $today_time && $row->is_hearing_required == 1)
                                                        <a class="dropdown-item blink" href="" style="color: red;"
                                                            target="_blank">অনলাইন শুনানি</a>
                                                    @endif
                                                </div>
                                            @endif
                                            
                                    
                                         
                                    @else
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item"
                                                href="{{ route('gcc.pp.citizen.appeal.case.details', encrypt($row->id)) }}">বিস্তারিত
                                                তথ্য</a>
                                            <a class="dropdown-item"
                                                href="{{ route('gcc.pp.citizen.appeal.case.tracking', encrypt($row->id)) }}">মামলা
                                                ট্র্যাকিং</a>
                                            {{-- @if ($row->appeal_status == 'CLOSED' && globalUserInfo()->citizen_type_id == 2)
                                                <a class="dropdown-item"
                                                    href="{{ route('gcc.pp.citizen.case.appeal', encrypt($row->id)) }}">আপীল</a>
                                            @endif --}}

                                            @if (globalUserInfo()->role_id == 36)
                                                @if ($row->appeal_status == 'SEND_ASST_TO_EM' || $row->appeal_status == 'SEND_ASST_TO_ADM')
                                                    <a class="dropdown-item" href="">সংশোধন
                                                        করুন</a>
                                                @endif
                                            @endif








                                            @if ($row->next_date == $today && $row->next_date_trial_time <= $today_time && $row->is_hearing_required == 1)
                                                <a class="dropdown-item blink" href="" style="color: red;"
                                                    target="_blank">অনলাইন শুনানি</a>
                                            @endif
                                        </div>
                                    @endif


                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
            integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            $('.case_modal_loader').on('click', function() {

                //alert();
                $('#hidden_id_paste').val($(this).data('id'));
                $('#case_modal').modal('show');

            })

            function ReportFormSubmit(id) {
                console.log(id);

                let kharij_reason = $("#kharij_reason").val();
                let hide_case_id = $("#hidden_id_paste").val();
                let _token = $('meta[name="csrf-token"]').attr('content');

                // var formData = new FormData();
                $.ajax({
                    type: 'POST',
                    url: "",
                    data: {
                        kharij_reason: kharij_reason,
                        hide_case_id: hide_case_id,
                        _token: _token
                    },
                    success: (data) => {
                        // form[0].reset();
                        toastr.success(data.success, "Success");
                        console.log(data);
                        // console.log(data.html);
                        // $('.ajax').remove();
                        // $('#legalReportSection').empty();
                        // $('#legalReportSection').append(data.data)
                        // $('#hearing_add_button_close').click()
                        // $("#"+ formId + " #submit").removeClass('spinner spinner-white spinner-right disabled');
                        $('.modal').modal('hide');
                        location.reload();
                        // form[0].reset();
                        // window.history.back();


                    },
                    error: function(data) {
                        console.log(data);
                        // $("#"+ formId + " #submit").removeClass('spinner spinner-white spinner-right disabled');

                    }
                });
            }
        </script>
    @endsection

    {{-- Includable CSS Related Page --}}
    @section('styles')
        <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
        <!--end::Page Vendors Styles-->
    @endsection

    {{-- Scripts Section Related Page --}}
    @section('scripts')
        <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
        <script src="{{ asset('js/pages/crud/datatables/advanced/multiple-controls.js') }}"></script>
        <!--end::Page Scripts-->

        <script>
            $(document).ready(function() {

                var myTable = $('#example').DataTable({
                    ordering: false,
                    searching: false,
                    info: false,
                    dom: '<"top"i>rt<"bottom"flp><"clear">',

                });

                // Initialize the datepicker
                $('.common_datepicker').datepicker({
                    format: "dd/mm/yyyy",
                    todayHighlight: true,
                    orientation: "bottom left"
                });


            });
        </script>
    @endsection
