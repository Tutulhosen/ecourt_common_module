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
    <div class="card card-custom" style="margin-bottom: 20px">
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

            <form action="{{ url('gcc/register/printPdf') }}" class="form" method="GET" enctype="multipart/form-data"
                id="myForm">
                @include('register.gcc.search')
                <div class="col-md-12">
                    <fieldset class="mb-8">
                        <legend>রেজিস্টার এর তথ্য নির্বাচন করুন</legend>
                        @csrf
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-9  font-weight-bolder" id="checkVal">
                                <input checked type="checkbox" onchange="myFunction('serialNo','kromikNo')" id="kromikNo"
                                    name="kromikNo" value="kromikNo">
                                <label for="kromikNo"> ক্রমিক নম্বর</label>&nbsp;&nbsp;
                                <input checked type="checkbox" onchange="myFunction('appealStat','appealStatus')"
                                    id="appealStatus" name="appealStatus" value="appealStatus"
                                    style="margin-left:43px !important">
                                <label for="appealStatus"> আপিল অবস্থা</label>&nbsp;&nbsp;
                                <input checked type="checkbox" onchange="myFunction('caseNum','caseNo')" id="caseNo"
                                    name="caseNo" value="caseNo" style="margin-left: 43px !important">
                                <label for="caseNo"> মামলা নম্বর</label>&nbsp;&nbsp;
                                <input checked type="checkbox" onchange="myFunction('caseResult','caseDecision')"
                                    id="caseDecision" name="caseDecision" value="caseDecision"
                                    style="margin-left: 24px !important">
                                <label for="caseDecision"> মামলার সিদ্ধান্ত</label>&nbsp;&nbsp;
                                <input checked type="checkbox" onchange="myFunction('courtName','relatedCourt')"
                                    id="relatedCourt" name="relatedCourt" value="relatedCourt">
                                <label for="relatedCourt"> সংশ্লিষ্ট আদালত</label>&nbsp;&nbsp;<br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-9  font-weight-bolder" id="checkVal">
                                <input checked type="checkbox" onchange="myFunction('nxtSunaniTime','nextHearingTime')"
                                    id="nextHearingTime" name="nextHearingTime" value="nextHearingTime">
                                <label for="nextHearingTime"> পরবর্তী শুনানীর সময়</label>&nbsp;&nbsp;
                                <input checked type="checkbox" onchange="myFunction('nxtSunaniDate','nextHearingDate')"
                                    id="nextHearingDate" name="nextHearingDate" value="nextHearingDate">
                                <label for="nextHearingDate"> পরবর্তী শুনানীর তারিখ</label>&nbsp;&nbsp;
                                <input checked type="checkbox" onchange="myFunction('applicantName','appellantName')"
                                    id="appellantName" name="appellantName" value="appellantName">
                                <label for="appellantName">আপীলকারীর নাম</label>&nbsp;&nbsp;
                                <input checked type="checkbox" onchange="myFunction('lawName','ruleName')" id="ruleName"
                                    name="ruleName" value="ruleName">
                                <label for="ruleName"> সংশ্লিষ্ট ধারা</label>&nbsp;&nbsp;<br>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-danger float-right">Print</button>
                    </fieldset>
                </div>
            </form>
            <table class="table table-hover mb-6 font-size-h5" id="example">
                <thead class="thead-customStyle2 font-size-h6">
                    <tr>
                        <th class="serialNo" scope="col" width="30"> ক্রমিক নম্বর</th>
                        <th class="appealStat" scope="col">আপিল অবস্থা</th>
                        <th class="caseNum" scope="col">মামলা নম্বর</th>
                        <th class="caseResult" scope="col">মামলার সিদ্ধান্ত</th>
                        <th class="courtName" scope="col">সংশ্লিষ্ট আদালত</th>
                        <th class="nxtSunaniDate" scope="col">পরবর্তী শুনানীর তারিখ</th>
                        <th class="nxtSunaniTime" scope="col">পরবর্তী শুনানীর সময়</th>
                        <th class="applicantName" scope="col">আপীলকারীর নাম</th>
                        <th class="lawName" scope="col"> সংশ্লিষ্ট ধারা</th>
                    </tr>
                </thead>
                <tbody>
                        @php
                            $i = 1;
                        @endphp
                    @foreach ($results as $key => $row)
                        <tr>
                            {{-- @dd($row) --}}
                            <td scope="row" class="tg-bn serialNo">{{ en2bn($i++) }}.</td>
                            <td class="appealStat"> {{ appeal_status_bng($row->appeal_status) }}</td> {{-- Helper Function for Bangla Status --}}
                            <td class="caseNum">{{ $row->case_no }}</td>
                            <td class="caseResult"> {{ case_dicision_status_bng($row->appeal_status) }}</td>
                            {{-- Helper Function for Bangla Status --}}
                            <td class="courtName">
                                {{ isset($row->court_name) ? $row->court_name : '-' }}
                            </td>
                            <td class="nxtSunaniDate">
                                {{-- @dd(isset($row->appealCauseList)); --}}
                                @php
                                    $hearingDate = null;
                                @endphp
                                @if (!empty($row->appealCauseList))
                                    @foreach ($row->appealCauseList as $key => $item)
                                        @php
                                            if ($item->trial_date == '1970-01-01') {
                                                $hearingDate = '---';
                                            } else {
                                                $hearingDate = $item->trial_date;
                                            }
                                            if (date('a', strtotime($item->trial_time)) == 'am') {
                                                $time = 'সকাল';
                                            } else {
                                                $time = 'বিকাল';
                                            }
                                        @endphp
                                    @endforeach
                                @endif
                                {{ en2bn($hearingDate) ?? '' }}
                            </td>
                            <td class="nxtSunaniTime">@php
                                $hearingTime = null;
                            @endphp
                                @if (!empty($row->appealCauseList))
                                    @foreach ($row->appealCauseList as $key => $item)
                                        @php
                                            if (isset($item->trial_time) && $item->trial_date != '1970-01-01') {
                                                $hearingTime =
                                                    $time . ' ' . en2bn(date('h:i', strtotime($item->trial_time)));
                                            } else {
                                                $hearingTime = '----';
                                            }

                                        @endphp
                                    @endforeach
                                @endif
                                {{ $hearingTime }}
                            </td>
                            <td class="applicantName">
                                {{-- @dd($row->appealCitizensJoin); --}}
                                {{ $row->applicant_citizen_name }}
                                @php
                                    $appName = null;
                                @endphp
                           

                                {{ $appName ?? '' }}
                            </td>
                            <td class="lawName">{{ $row->law_section }}</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>

       
        </div>
    </div>
    <script>
        function myFunction(className, id) {
            console.log(id);
            var checkBox = document.getElementById(id);
            if (checkBox.checked == true) {
                console.log('true');
                $('.' + className).show(20);
            } else {
                console.log('false');
                $('.' + className).hide(20);
            }
        }

        function formSubmit() {
            console.log('asda');
            $("#myForm").attr('action', '/gcc/register/list');
            $("#myForm").submit();
        }
    </script>
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
