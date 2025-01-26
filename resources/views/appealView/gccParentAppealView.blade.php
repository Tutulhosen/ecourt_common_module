
@extends('layout.app')

@section('content')

    <style type="text/css">
        .tg {
            border-collapse: collapse;
            border-spacing: 0;
            width: 100%;
        }

        .tg td {
            border-color: black;
            border-style: solid;
            border-width: 1px;
            font-size: 14px;
            overflow: hidden;
            padding: 6px 5px;
            word-break: normal;
        }

        .tg th {
            border-color: black;
            border-style: solid;
            border-width: 1px;
            font-size: 14px;
            font-weight: normal;
            overflow: hidden;
            padding: 6px 5px;
            word-break: normal;
        }

        .tg .tg-nluh {
            background-color: #dae8fc;
            border-color: #cbcefb;
            text-align: left;
            vertical-align: top
        }

        .tg .tg-19u4 {
            background-color: #ecf4ff;
            border-color: #cbcefb;
            font-weight: bold;
            text-align: right;
            vertical-align: top
        }
    </style>

    <!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header flex-wrap py-5">
            {{-- <div class="card-title"> --}}
            <div class="container">
                <div class="row">
                    <div class="col-10">
                        <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>
                    </div>
                   
                </div>
            </div>
            
        </div>
        <div class="card-body">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    {{ $message }}
                </div>
            @endif

            <div class="row">
                <div class="col-md-6">
                    <table class="table table-striped border">
                        <thead>
                            <th class="h3" scope="col" colspan="2">সাধারণ তথ্য</th>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">দাবিকৃত অর্থের পরিমাণ</th>
                                <td>{{ en2bn($appeal['loan_amount']) ?? '-' }} টাকা</td>
                            </tr>
                            <tr>
                                <th scope="row">দাবিকৃত অর্থের পরিমাণ (কথায়)</th>
                                <td>{{ $appeal['loan_amount_text'] ?? '-' }} টাকা</td>
                            </tr>
                            <tr>
                                <th scope="row">জেলা</th>
                                <td>{{ $appeal['district_name'] ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th scope="row">উপজেলা</th>
                                <td>{{ $appeal['upazila_name'] ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th scope="row">প্রাতিষ্ঠানের নাম</th>
                                <td>{{ $appeal['office_name'] ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th scope="row">প্রাতিষ্ঠানের ঠিকানা</th>
                                <td>{{ get_office_by_id($appeal['office_id'])->organization_physical_address ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th scope="row">প্রাতিষ্ঠানের ধরণ</th>
                                <td>{{ $org_type ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th scope="row">প্রাতিষ্ঠানের আইডি (রাউটিং নং )</th>
                                <td>{{ get_office_by_id($appeal['office_id'])->organization_routing_id ?? '-' }}</td>
                            </tr>

                            <tr>
                                <th scope="row">মামলার ধারা</th>
                                <td>{{ $appeal['law_section'] ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th scope="row">মামলা নং</th>
                                <td>{{ en2bn($appeal['case_no']) ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th scope="row">মামলা রুজুর তারিখ</th>
                                <td>{{ en2bn($appeal['case_date']) ?? '-' }}</td>
                            </tr>

                        </tbody>
                    </table>

                   

                </div>
                <div class="col-md-6">

                    <table class="table table-striped border">
                        <thead>
                            <th class="h3" scope="col" colspan="7">ধারকের বিবরণ</th>
                        </thead>
                        <thead>
                            <tr style="text-align:center">
                                <th scope="row" width="10">ক্রম</th>
                                <th scope="row" width="100">নাম</th>
                                <th scope="row" width="100">পিতা/স্বামীর নাম</th>
                                <th scope="row">প্রতিষ্ঠান প্রতিনিধির আইডি</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $k = 1; @endphp
                            @foreach ($applicantCitizen as $badi)
                                <tr style="text-align:center">
                                    <td>{{ en2bn($k) }}.</td>
                                    <td>{{ $badi['citizen_name'] ?? '-' }}</td>
                                    <td>{{ $badi['father'] ?? '-' }}</td>
                                    <td>{{ $badi['organization_employee_id'] ?? '-' }}</td>
                                </tr>
                                @php $k++; @endphp
                            @endforeach
                        </tbody>
                    </table>

                    <br>
                    <table class="table table-striped border">
                        <thead>
                            <th class="h3" scope="col" colspan="4">খাতকের বিবরণ</th>
                        </thead>
                        <thead>
                            <tr>
                                <th scope="row" width="10">ক্রম</th>
                                <th scope="row" width="150">নাম</th>
                                <th scope="row" width="150">পিতা/স্বামীর নাম</th>
                                <th scope="row">বর্তমান ঠিকানা</th>
                                <th scope="row">স্থায়ী ঠিকানা</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $k = 1; @endphp

                            <tr>
                                <td>{{ en2bn($k) }}.</td>
                                <td>{{ $defaulterCitizen['citizen_name'] ?? '-' }}</td>
                                <td>{{ $defaulterCitizen['father'] ?? '-' }}</td>
                                <td>{{ $defaulterCitizen['present_address'] ?? '-' }}</td>
                                <td>{{ $defaulterCitizen['permanent_address'] ?? '-' }}</td>
                            </tr>
                            @php $k++; @endphp

                        </tbody>
                    </table>
                    <br>
                    @if (count($nomineeCitizen) > 0)
                        <table class="table table-striped border">
                            <thead>
                                <th class="h3" scope="col" colspan="4">উত্তরাধিকারের বিবরণ</th>
                            </thead>
                            <thead>
                                <tr>
                                    <th scope="row" width="10">ক্রম</th>
                                    <th scope="row" width="200">নাম</th>
                                    <th scope="row">পিতা/স্বামীর নাম</th>
                                    <th scope="row">ঠিকানা</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $k = 1; @endphp
                                @foreach ($nomineeCitizen as $nominee)
                                    <tr>
                                        <td>{{ en2bn($k) }}.</td>
                                        <td>{{ $nominee['citizen_name'] ?? '-' }}</td>
                                        <td>{{ $nominee['father'] ?? '-' }}</td>
                                        <td>{{ $nominee['present_address'] ?? '-' }}</td>
                                    </tr>
                                    @php $k++; @endphp
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                    <br>
                </div>
                <div class="col-md-12">
                    <table class="table table-striped border">
                        <thead>
                            <th class="h3" scope="col" colspan="2">সংযুক্তি</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    @forelse ($attachmentList as $key => $row)
                                        <div class="form-group mb-2" id="deleteFile{{ $row['id'] }}">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <button class="btn bg-success-o-75"
                                                        type="button">{{ en2bn(++$key) . ' - নম্বর :' }}</button>
                                                </div>
                                                {{-- <input readonly type="text" class="form-control" value="{{ asset($row->file_path . $row->file_name) }}" /> --}}
                                                <input readonly type="text" class="form-control"
                                                    value="{{ $row['file_category'] ?? '' }}" />
                                                <div class="input-group-append">
                                                    <a href="{{ asset($row['file_path'] . $row['file_name']) }}"
                                                        target="_blank"
                                                        class="btn btn-sm btn-success font-size-h5 float-left">
                                                        <i class="fa fas fa-file-pdf"></i>
                                                        <b>দেখুন</b>
                                                        {{-- <embed src="{{ asset('uploads/sf_report/'.$data[0]['case_register'][0]['sf_report']) }}" type="application/pdf" width="100%" height="600px" />  --}}
                                                    </a>
                                                    {{-- <a href="minarkhan.com" class="btn btn-success" type="button">দেখুন </a> --}}
                                                </div>
                                                <!-- <div class="input-group-append">
                                          <a href="javascript:void(0);" id="" onclick="deleteFile({{ $row['id'] }} )" class="btn btn-danger">
                                              <i class="fas fa-trash-alt"></i>
                                              <b>মুছুন</b>
                                          </a>
                                      </div> -->
                                            </div>
                                        </div>
                                    @empty
                                        <div class="pt-5">
                                            <p class="text-center font-weight-normal font-size-lg">কোনো সংযুক্তি খুঁজে পাওয়া
                                                যায়নি</p>
                                        </div>
                                    @endforelse
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <br>

            <br>




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
    @endsection