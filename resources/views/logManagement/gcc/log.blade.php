@php
    $user = Auth::user();
    $roleID = Auth::user()->role_id;
    $badi = 'ধারকের বিবরণ';
    $bibadi = 'খাতকের বিবরণ';
    switch ($data->appeal->applicant_type) {
        case 'BANK':
            $org_type = 'ব্যাংক';
            break;
        case 'GOVERNMENT':
            $org_type = 'সরকারি প্রতিষ্ঠান';
            break;
        case 'OTHER_COMPANY':
            $org_type = 'স্বায়ত্তশাসিত প্রতিষ্ঠান';
            break;
    }
@endphp
@extends('layout.app')

@section('content')
    <!--begin::Card-->

    <div class="card" style="margin-bottom: 20px">
        <div class="card-header" style="padding: 20px">
            <div class="card-title" style="display: flex; justify-content: space-between; padding: 0; margin: 0%">
                <h3 class="card-label" style="width: 60%; text-align: right; font-size: 28px; font-weight: bold">
                    মামলা কার্যকলাপ নিরীক্ষা
                </h3>
                <h3 class="card-label">
                    <a class="btn btn-danger btn-linkt" target="_blank" href="{{ route('gcc.create_log_pdf', ['id' => $data->apepal_id]) }}">জেনারেট পিডিএফ</a>
                </h3>
            </div>
        </div>
        <div class="card-body">
            <div class="card-body" style="padding: 0%">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        {{ $message }}
                    </div>
                @endif
                                 <div class="row">
                    <div class="col-md-12">
                        {{-- <a onclick='printDiv();' class="align-right btn btn-primary float-right" href="">Print</a> --}}
                        {{-- {{ route('case_audit.caseActivityPDFlog', $info->id) }} --}}

                        {{-- <div class="col-md-4">
                                <a href="{{ route('emc.create_log_pdf',['id'=>$data->apepal_id]) }}" class="btn btn-danger btn-link">জেনারেট পিডিএফ</a>
                            </div> --}}
                        <div class="row text-center">
                            <div class="col-md-6">
                                <h5><span class="font-weight-bolder">মামলা নং: </span>{{ en2bn($data->info->case_no) }}</h5>
                                <h5><span class="font-weight-bolder">আদালতের নাম: </span> {{ $data->info->court_name }}</h5>
                            </div>
                            <div class="col-md-6">
                                <h5><span class="font-weight-bolder">বিভাগ: </span> {{ $data->info->division_name_bn }}</h5>
                                <h5><span class="font-weight-bolder">জেলা: </span> {{ $data->info->district_name_bn }}</h5>
                                <h5><span class="font-weight-bolder">উপজেলা: </span> {{ $data->info->upazila_name_bn }}</h5>
                            </div>
                        </div>
                    </div>



                    <div class="col-md-6">
                        <table class="table table-striped border">
                            <thead>
                                <th class="h3" scope="col" colspan="2">সাধারণ তথ্য</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">দাবিকৃত অর্থের পরিমাণ</th>
                                    <td>{{ en2bn($data->appeal->loan_amount) ?? '-' }} টাকা</td>
                                </tr>
                                <tr>
                                    <th scope="row">দাবিকৃত অর্থের পরিমাণ (কথায়)</th>
                                    <td>{{ $data->appeal->loan_amount_text ?? '-' }} টাকা</td>
                                </tr>
                                <tr>
                                    <th scope="row">জেলা</th>
                                    <td>{{ $data->appeal->district_name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">উপজেলা</th>
                                    <td>{{ $data->appeal->upazila_name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">প্রাতিষ্ঠানের নাম</th>
                                    <td>{{ $data->appeal->office_name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">প্রাতিষ্ঠানের ঠিকানা</th>
                                    <td>{{ get_office_by_id($data->appeal->office_id)->organization_physical_address ?? '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">প্রাতিষ্ঠানের ধরণ</th>
                                    <td>{{ $org_type ?? ('-' ?? '-') }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">প্রাতিষ্ঠানের আইডি (রাউটিং নং )</th>
                                    <td>{{ get_office_by_id($data->appeal->office_id)->organization_routing_id ?? '-' }}
                                    </td>
                                </tr>

                                <tr>
                                    <th scope="row">মামলার ধারা</th>
                                    <td>{{ $data->appeal->law_section ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">মামলা নং</th>
                                    <td>{{ en2bn($data->appeal->case_no) ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">মামলা রুজুর তারিখ</th>
                                    <td>{{ en2bn($data->appeal->case_date) ?? '-' }}</td>
                                </tr>

                            </tbody>
                        </table>



                    </div>
                    <div class="col-md-6">

                        <table class="table table-striped border">
                            <thead>
                                <th class="h3" scope="col" colspan="7">{{ $badi }}</th>
                            </thead>
                            <thead>
                                <tr style="text-align:center">
                                    <th scope="row" width="10">ক্রম</th>
                                    <th scope="row" width="100">নাম</th>
                                    <th scope="row" width="100">পিতা/স্বামীর নাম</th>
                                    <th scope="row">প্রাতিষ্ঠানে প্রতিনিধির , EmployeeID</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $k = 1; @endphp
                                @foreach ($data->applicantCitizen as $badi)
                                    <tr style="text-align:center">
                                        <td>{{ en2bn($k) }}.</td>
                                        <td>{{ $badi->citizen_name ?? '-' }}</td>
                                        <td>{{ $badi->father ?? '-' }}</td>
                                        <td>{{ $badi->organization_employee_id ?? '-' }}</td>
                                    </tr>
                                    @php $k++; @endphp
                                @endforeach
                            </tbody>
                        </table>

                        <br>
                        <table class="table table-striped border">
                            <thead>
                                <th class="h3" scope="col" colspan="4">{{ $bibadi }}</th>
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
                                    <td>{{ $data->defaulterCitizen->citizen_name ?? '-' }}</td>
                                    <td>{{ $data->defaulterCitizen->father ?? '-' }}</td>
                                    <td>{{ $data->defaulterCitizen->present_address ?? '-' }}</td>
                                    <td>{{ $data->defaulterCitizen->permanent_address ?? '-' }}</td>
                                </tr>
                                @php $k++; @endphp

                            </tbody>
                        </table>
                        <br>
                        @if (count($data->nomineeCitizen) > 0)
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
                                    @foreach ($data->nomineeCitizen as $nominee)
                                        <tr>
                                            <td>{{ en2bn($k) }}.</td>
                                            <td>{{ $nominee->citizen_name ?? '-' }}</td>
                                            <td>{{ $nominee->father ?? '-' }}</td>
                                            <td>{{ $nominee->present_address ?? '-' }}</td>
                                        </tr>
                                        @php $k++; @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                        <br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 my-5">
                        <table class="tg">
                            <thead>
                                <tr>
                                    <th class="font-weight-bolder">তারিখ ও সময়</th>
                                    <th class="font-weight-bolder">ব্যবহারকারীর নাম</th>
                                    <th class="font-weight-bolder">ব্যবহারকারীর পদবি</th>
                                    <th class="font-weight-bolder">অ্যাক্টিভিটি</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data->case_details as $case_details_single)
                                    @php

                                        $user_name = DB::table('users')
                                            ->select('name')
                                            ->where('id', '=', $case_details_single->user_id)
                                            ->first();
                                        if (!empty($user_name)) {
                                            $userName=$user_name->name;
                                        } else {
                                            $userName=' ';
                                        }
                                        
                                        
                                       if(!empty($case_details_single->details_url))
                                       {
                                        $details_url='/log/logid/'.encrypt($case_details_single->id);
                                       }
                                    @endphp
                                    <tr>

                                        <td>{{ en2bn($case_details_single->created_at) }}</td>
                                        <td>{{ $userName }}</td>
                                        <td>{{ $case_details_single->designation }}</td>
                                        <td>@php
                                            echo $case_details_single->activity;
                                            echo '<br>';
                                            if (!empty($case_details_single->files)) {
                                                $files = json_decode($case_details_single->files);

                                                if (!empty($files->file_path)) {
                                                    if (empty($files->file_category)) {
                                                        $file_cat = 'জারিকারের রিপোর্ট ফাইল';
                                                    } else {
                                                        $file_cat = $files->file_category;
                                                    }
                                                    echo '<a href="' .
                                                        url('/') .
                                                        '/' .
                                                        $files->file_path .
                                                        '" target="_blank" class="btn btn-sm btn-success font-size-h5 float-left mr-3">
                                              <i class="fa fas fa-file-pdf"></i>
                                              <b>' .
                                                        $file_cat .
                                                        '</b></a>';
                                                } else {
                                                    foreach ($files as $file) {
                                                        echo '<a href="' . getGccBaseUrl() . '/' . $file->file_path . $file->file_name
                                                             .
                                                            '" target="_blank" class="btn btn-sm btn-success font-size-h5 float-left mr-3">
                                                  <i class="fa fas fa-file-pdf"></i>
                                                  <b>' .
                                                            $file->file_category .
                                                            '</b></a>';
                                                    }
                                                }
                                            }

                                            if (!empty($case_details_single->details_url)) {
                                                echo '<a href="/gcc' .
                                                    $details_url .
                                                    '"  class="btn btn-sm btn-success font-size-h5 float-left">
                                                      
                                                      <b>বিস্তারিত দেখুন</b>
                                                      
                                                    </a>';
                                            }

                                        @endphp</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-striped border">
                            <thead>
                                <th class="h3" scope="col" colspan="2">সংযুক্তি</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        @forelse ($data->attachmentList as $key => $row)
                                            <div class="form-group mb-2" id="deleteFile{{ $row->id }}">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <button class="btn bg-success-o-75"
                                                            type="button">{{ en2bn(++$key) . ' - নম্বর :' }}</button>
                                                    </div>
                                               
                                                    <input readonly type="text" class="form-control"
                                                        value="{{ $row->file_category ?? '' }}" />
                                                    <div class="input-group-append">
                                                        <a href="{{ getGccBaseUrl() . '/' . $row->file_path . $row->file_name }}"
                                                            target="_blank"
                                                            class="btn btn-sm btn-success font-size-h5 float-left">
                                                            <i class="fa fas fa-file-pdf"></i>
                                                            <b>দেখুন</b>
                                                            {{-- <embed src="{{ asset('uploads/sf_report/'.$data[0]['case_register'][0]['sf_report']) }}" type="application/pdf" width="100%" height="600px" />  --}}
                                                        </a>
                                                        {{-- <a href="minarkhan.com" class="btn btn-success" type="button">দেখুন </a> --}}
                                                    </div>
                                                    <!-- <div class="input-group-append">
                                                                             <a href="javascript:void(0);" id="" onclick="deleteFile({{ $row->id }} )" class="btn btn-danger">
                                                                                 <i class="fas fa-trash-alt"></i>
                                                                                 <b>মুছুন</b>
                                                                             </a>
                                                                         </div> -->
                                                </div>
                                            </div>
                                        @empty
                                            <div class="pt-5">
                                                <p class="text-center font-weight-normal font-size-lg">কোনো সংযুক্তি খুঁজে
                                                    পাওয়া যায়নি</p>
                                            </div>
                                        @endforelse
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
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
@endsection
