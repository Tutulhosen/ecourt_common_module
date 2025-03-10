@extends('layout.app')

@section('content')
<style>
    #example thead th {
        color: white !important;
        background-color: #008841 !important;
        font-weight: bold;
        font-size: 16px
    }
    #example tbody td {
        
        font-size: 16px
    }
  
</style>
    <!--begin::Card-->
    <div class="card" style="margin-bottom: 20px">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">
                    এক্সিকিউটিভ ম্যাজিস্ট্রেট আদালতে মামলা কার্যকলাপ নিরীক্ষা
                </h3>
            </div>
        </div>
        <div class="card-body">
            @php

                if (isset($_GET['case_no'])) {
                    $case_no = $_GET['case_no'];
                } else {
                    $case_no = null;
                }
            @endphp
            <form class="form-inline" method="GET" action="{{ route('emc.log_index') }}">
                @csrf
                <div class="container mb-4">
                    <div class="row">
                        <div class="col-lg-3">
                            <input type="text" class="form-control " name="case_no" placeholder="মামলা নং"
                                value="{{ $case_no }}">
                        </div>
                        <div class="col-lg-2 mt-1">
                            <button type="submit" class="btn btn-success font-weight-bolder mb-2 ml-2">অনুসন্ধান
                                করুন</button>
                        </div>
                    </div>
                </div>
            </form>
            <table class="table table-hover mb-6 font-size-h5" id="example">
                <thead class="thead-light font-size-h6">
                    <tr>
                        <th scope="col" width="30">#</th>
                        <th scope="col">মামলা নং</th>
                        <th scope="col">মামলার তারিখ</th>
                        <th scope="col">আদালতের নাম</th>
                        <th scope="col">উপজেলা</th>
                        <th scope="col">জেলা</th>
                        <th scope="col">বিভাগ</th>
                        <th scope="col" width="70">অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 0
                    @endphp
                    @foreach ($cases as $row)
                        <tr>
                            <td scope="row" class="tg-bn">{{ en2bn(++$i) }}.</td>
                            <td>{{ $row->case_no }}</td>
                            <td>{{ en2bn($row->created_at) }}</td>
                            <td>{{ $row->court_name }}</td>
                            <td>{{ $row->upazila_name_bn }}</td>
                            <td>{{ $row->district_name_bn }}</td>
                            <td>{{ $row->division_name_bn }}</td>
                            <td>
                                <a href="{{ route('emc.log_index_single', ['id' => encrypt($row->id)]) }}"
                                    class="btn btn-success font-weight-bold btn-sm">নিরীক্ষা</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center pt-5">
            {{-- {{ $cases->links('pagination::bootstrap-4') }}  Use Bootstrap 4 pagination links --}}
        </div>

    </div>

    <!--end::Card-->
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
