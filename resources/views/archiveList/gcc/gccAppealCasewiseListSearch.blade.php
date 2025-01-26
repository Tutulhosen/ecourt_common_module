@extends('layout.app')

@section('content')
    <!--begin::Card-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <style>
        #example thead th {
            color: white !important;
            font-weight: bold;
            font-size: 16px
        }
        #example tbody td {
            
            font-size: 16px
        }
      
    </style>
    <div class="card">

        <div class="card-header flex-wrap py-5">
            <div class="card-title" style="display: flex; justify-content: space-between; width: 100%">
                <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>
            </div>
        </div>
        <div class="card-body overflow-auto " id="element-to-print-list">
            <div id="card-title-print" class="py-5" style="display: none">
                <h3 class="card-title-print h2 font-weight-bolder">{{ $page_title }}</h3>
            </div>
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    {{ $message }}
                </div>
            @endif
    
                <form class="form-inline" method="POST" action="{{route('gcc.closed_list.search')}}">

                    @csrf
                
                    <div class="container">
                    <div class="row">
                        <div class="col-lg-3 mb-5">
                            <input type="text" name="date_start" id="date_start" class="w-100 form-control common_datepicker" placeholder="তারিখ হতে" autocomplete="off">
                        </div>
                        <div class="col-lg-3 mb-5">
                            <input type="text" name="date_end" id="date_end" class="w-100 form-control common_datepicker" placeholder="তারিখ পর্যন্ত" autocomplete="off">
                        </div>
                        <div class="col-lg-3">
                                <input type="text" class="form-control w-100" id="case_no" name="case_no" placeholder="মামলা নং" value="">
                        </div>
                        <div class="col-lg-3 ">
                            <button type="submit" class="btn btn-success font-weight-bolder mb-2 ml-2" id="search_btn">অনুসন্ধান করুন</button>
                        </div>
                    </div>
                    </div>
                
                </form>
            @php
                $today = date('Y-m-d', strtotime(now()));
                $today_time = date('H:i:s', strtotime(now()));
            @endphp
            
            <table class="table table-hover mb-6 font-size-h5" id="example">
                <thead class="thead-customStyle2 font-size-h6">
                    <tr style="text-align: justify">
                        <th scope="col">ক্রমিক নং</th>
                        {{-- <th scope="col">ক্রমিক নং</th> --}}
                        <th scope="col" style="">সার্টিফিকেট অবস্থা</th>
                        <th scope="col">মামলা নম্বর</th>
                        <th scope="col">ম্যানুয়াল মামলা নম্বর</th>
                        <th scope="col">আবেদনকারীর নাম</th>
                        <th scope="col">জেনারেল সার্টিফিকেট আদালত</th>
                        <th scope="col">পরবর্তী তারিখ</th>
                        <th scope="col">পদক্ষেপ</th>
                    </tr>
                </thead>
                <tbody>
    
                    @foreach ($results as $key => $row)
                    {{-- @dd($key) --}}
                    
                        <tr>
                            <td scope="row" class="tg-bn">{{ $loop->index+1 }}.</td>
                            <td> {{ appeal_status_bng($row['appeal_status']) }}</td> {{-- Helper Function for Bangla Status --}}
                            <td>
                                @if (isset($row['case_entry_type']))
                                    {{-- @dd($row->case_entry_type) --}}
                                    @if ($row['case_entry_type'] == 'RUNNING')
                                        {{ en2bn($row['case_no']) }} (ম্যানুয়াল মামলা)
                                    @else
                                        {{ en2bn($row['case_no']) }} (সিস্টেম এর মামলা)
                                    @endif
    
                                    {{-- {{ en2bn($row->case_no) }} --}}
                                @else
                                    {{ en2bn($row['case_no']) }}
                                @endif
                            </td>
                            <td>{{ $row['manual_case_no'] }}</td>
    
                            @if ($row['is_applied_for_review'] == 0)
                            <td>{{ $row['applicant_name'] }}</td>
                            @else
                                <td>{{ $row->reviewerName->name }}</td>
                            @endif
                            <td>{{$row['court_name']}}</td>
                            <td>{{ $row['next_date'] == '1970-01-01' ? '-' : en2bn($row['next_date']) }}</td>
    
                            <td>
                                <div class="btn-group float-right">
                                    <button class="btn btn-primary font-weight-bold btn-sm dropdown-toggle" type="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">পদক্ষেপ</button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="{{ route('gcc.closed_list.details', encrypt($row['id'])) }}">বিস্তারিত তথ্য</a>
                                        @if ($row['appeal_status'] != 'SEND_TO_ASST_GCO' && $row['appeal_status'] != 'SEND_TO_GCO')
                                            <a class="dropdown-item" href="{{ route('gcc.closed_list.nothi', encrypt($row['id'])) }}">নথি দেখুন</a>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
    
            
        </div>
    </div>
    <!--end::Card-->


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>



@endsection

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


