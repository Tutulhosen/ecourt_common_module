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
    <!--begin::Row-->
    <div class="row">

        <div class="col-md-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b example example-compact">
                <div class="card-header">
                    <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>
                </div>
                <!-- <div class="loadersmall"></div> -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (Session::has('withError'))
                    <div class="alert alert-danger text-center">
                        {{ Session::get('withError') }}
                    </div>
                @endif


                <div class="card-body overflow-auto">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            {{ $message }}
                        </div>
                    @endif

                    <form class="form-inline" method="POST" action="{{route('gcc.old_closed_list.search')}}">

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
                                {{-- <th scope="col" style="">সার্টিফিকেট অবস্থা</th> --}}
                                <th scope="col">মামলা নম্বর</th>
                                <th scope="col">আবেদনের তারিখ</th>
                                <th scope="col">আবেদনকারী</th>
                                <th scope="col">জেনারেল সার্টিফিকেট আদালত</th>
                                <th scope="col">সর্বশেষ আদেশ এর তারিখ</th>
                                <th scope="col">পদক্ষেপ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($results as $key => $row)
                                <tr>
                                    <td scope="row" class="tg-bn">{{ en2bn($key + 1) }}.</td>

                                    <td>{{ $row['case_no'] }}</td>
                                    <td>{{ en2bn($row['appeal_date']) }}</td>
                                    <td>{{ $row['org_name'] }}</td>
                                    <td>{{$row['court_name']}}</td>
                                    <td>{{ en2bn($row['last_order_date']) }}</td>

                                    <td>
                                        <div class="btn-group float-right">
                                            <button class="btn btn-primary font-weight-bold btn-sm dropdown-toggle"
                                                type="button" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">পদক্ষেপ</button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item"
                                                    href="{{ route('gcc.showAppealViewPage', encrypt($row['id'])) }}">বিস্তারিত
                                                    তথ্য</a>

                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                   
                </div>

            </div>
        </div>

    </div>
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
