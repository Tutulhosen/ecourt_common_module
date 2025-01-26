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

            {{-- @include('appeal.search') --}}
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
                        <th scope="col">আবেদন নম্বর</th>
                        <th scope="col">মামলা নম্বর</th>
                        <th scope="col">আবেদনকারীর নাম</th>
                        {{-- <th scope="col">আবেদনের অবস্থা</th> --}}

                        <th scope="col">আবেদনের তারিখ</th>
                     
                     
                        <th scope="col" width="70">পদক্ষেপ </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($list as $item)
                        <tr>
                            <td>{{ en2bn($loop->index + 1) }}</td>
                            <td>{{ en2bn($item->certify_id) }}</td>
                            <td>{{ en2bn($item->case_no) }}</td>
                            <td>{{ $item->applicent_name }}</td>
                            {{-- <td>{{ $item->status }}</td> --}}
                            <td>{{ en2bn(\Carbon\Carbon::parse($item->created_at)->format('Y-m-d')) }}</td>
                            <td>
                                <div class="btn-group float-right">
                                    <button class="btn btn-primary font-weight-bold btn-sm dropdown-toggle" type="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">পদক্ষেপ </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            {{-- <a class="dropdown-item" href="">বিস্তারিত তথ্য</a>  --}}
                                            <a href="{{route('gcc.citizen.certify.applicent.form', $item->id)}}" class="dropdown-item" href="">আবেদন পত্র</a>
                                            @if (!empty($item->certify_copy_fee) && $item->certify_copy_fee== 'REQUEST_FOR_FEE')
                                                <a href="{{ route('gcc.citizen.certify.copy.fee', ['id' => encrypt($item->id), 'court_id' => encrypt($item->court_id)]) }}" class="dropdown-item">সার্টিফাইড কপির ফি প্রদান</a>
                                            @endif
                                            
                                        </div>
                                   


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
