@extends('layout.app')

@section('content')
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

            <form class="form-inline" method="POST" action="{{route('emc.closed_list.search')}}">

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
                    <tr>
                        <th scope="col">ক্রমিক নং</th>
                        <th scope="col">মামলার অবস্থা</th>
                        <th scope="col">মামলা নম্বর</th>
                        <th scope="col">আবেদনকারীর নাম</th>
                        <th scope="col">ম্যানুয়াল মামলা নম্বর</th>

                        <th scope="col">পরবর্তী তারিখ</th>
                        <th scope="col">শুনানির সময়</th>
                        <th scope="col" width="70">পদক্ষেপ </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($results as $key => $row)
                        {{-- @dd($row) --}}
                        @if ($row['appeal_status'] == 'CLOSED')
                            @php
                                $finalOrderDate = date_create($row['final_order_publish_date']);
                                $today = date_create(date('Y-m-d', strtotime(now())));
                                $diff = date_diff($finalOrderDate, $today);
                                $difference = $diff->format('%a');

                            @endphp
                        @endif
                        @php

                            if (date('a', strtotime($row['next_date_trial_time'])) == 'am') {
                                $time = 'সকাল';
                            } else {
                                $time = 'বিকাল';
                            }
                        @endphp

                        <tr>

                            <td scope="row" class="tg-bn">{{ en2bn($key + 1) }}.</td>
                            <td> {{ appeal_status_bng($row['appeal_status']) }}</td> {{-- Helper Function for Bangla Status --}}
                            <td>{{ $row['case_no'] }}</td>
                            <td>

                                {{ /* get_the_applicant_by_id($row->id)  */ $row['applicantcitizen_name'] }}
                            </td>
                            <td>{{ $row['manual_case_no'] }}</td>

                            @if ($row['appeal_status'] == 'ON_TRIAL' || $row['appeal_status'] == 'ON_TRIAL_DM')
                                <td>{{ $row['next_date'] == '1970-01-01' ? '-' : en2bn($row['next_date']) }}</td>
                            @else
                                <td class="text-center"> -- </td>
                            @endif
                            <td>
                                @if ($row['appeal_status'] == 'ON_TRIAL' || $row['appeal_status'] == 'ON_TRIAL_DM')
                                    @if (date('a', strtotime($row['next_date_trial_time'])) == 'am' && $row['next_date'] != '1970-01-01')
                                        সকাল
                                    @elseif(date('a', strtotime($row['next_date_trial_time'])) == 'pm' && $row['next_date'] != '1970-01-01')
                                        বিকাল
                                    @else
                                    @endif
                                @endif

                                @if ($row['appeal_status'] == 'ON_TRIAL' || $row['appeal_status'] == 'ON_TRIAL_DM')
                                    {{ isset($row['next_date_trial_time']) ? en2bn(date('h:i', strtotime($row['next_date_trial_time']))) : '-' }}
                                @else
                                    {{ '--' }}
                                @endif

                            </td>
                            <td>
                                <div class="btn-group float-right">
                                    <button class="btn btn-primary font-weight-bold btn-sm dropdown-toggle" type="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">পদক্ষেপ </button>
                                    @if ($row['is_old_style'] == 1)
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item"
                                                href="{{ route('emc.show.appeal.details', encrypt($row['id'])) }}">বিস্তারিত
                x                                তথ্য</a>
                                            <a class="dropdown-item" href="{{ route('emc.show.appeal.case.traking', encrypt($row['id'])) }}">মামলা
                                                ট্র্যাকিং</a>
                                            @if (globalUserInfo()->role_id != 20 && globalUserInfo()->role_id != 36)
                                                <a class="dropdown-item" href="{{ route('emc.show.appeal.case.nothiView', encrypt($row['id'])) }}">নথি দেখুন
                                                </a>
                                            @endif
                                            

                                            @if ($row['next_date'] == $today && $row['next_date_trial_time'] <= $today_time && $row['is_hearing_required'] == 1)
                                                <a class="dropdown-item blink"
                                                    href="{{ route('jitsi.meet', ['appeal_id' => encrypt($row['id'])]) }}"
                                                    style="color: red;" target="_blank">অনলাইন শুনানি</a>
                                            @endif
                                        </div>
                                    @else
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="#">OLD DATA</a>
                                        </div>
                                    @endif

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

           
        </div>
    </div>
    <!--end::Card-->
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
