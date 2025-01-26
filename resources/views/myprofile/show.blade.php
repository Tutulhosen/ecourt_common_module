@extends('layout.app')

@section('content')


    @php //echo $userManagement->name;
    //exit();
    @endphp

    <!--begin::Card-->
    <div class="row" style="margin-bottom: 20px">
        <div class="col-md-10 mx-auto">
            <div class="card card-custom">
                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h3 class="card-label"> ব্যবহারকারীর বিস্তারিত </h3>
                    </div>
                </div>
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        {{ $message }}
                    </div>
                @endif
                {{-- @foreach ($userManagement as $userManagement) --}}
                <div class="card-body" >
                    <div class="profile_image mb-5" style="text-align: center">
                        <div class="row">
                            <div class="col-md-6 mx-auto">
                                <h3>প্রোফাইল ইমেজ</h3>
                                @if (Auth::user()->profile_pic != null )
                                    <img class="img-fluid" src="{{ url('/') }}/uploads/profile/{{  Auth::user()->profile_pic  }}" width="200"
                                        height="200">
                                @else
                                    <img src="{{ url('/') }}/uploads/profile/default.jpg" width="200" height="200">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="d-flex mb-3">
                        <span class="text-dark-100 flex-root font-weight-bold font-size-h6">নামঃ</span>
                        <span class="text-dark flex-root font-weight-bolder font-size-h6">{{ Auth::user()->name }}</span>
                    </div>
                    <div class="d-flex mb-3">
                        <span class="text-dark-100 flex-root font-weight-bold font-size-h6">ইউজারনেমঃ</span>
                        <span class="text-dark flex-root font-weight-bolder font-size-h6">{{ Auth::user()->username }}</span>
                    </div>
                    <div class="d-flex mb-3">
                        <span class="text-dark-100 flex-root font-weight-bold font-size-h6">ইউজার রোলঃ</span>
                        <span class="text-dark flex-root font-weight-bolder font-size-h6">{{ citizen_type_name_by_type(Auth::user()->citizen_type_id) }}</span>
                    </div>
                    <div class="d-flex mb-3">
                        <span class="text-dark-100 flex-root font-weight-bold font-size-h6">মোবাইল নাম্বারঃ</span>
                        <span class="text-dark flex-root font-weight-bolder font-size-h6">{{ Auth::user()->mobile_no }}</span>
                    </div>
                    @if (globalUserInfo()->citizen_type_id==2)
                        <div class="d-flex mb-3">
                            <span class="text-dark-100 flex-root font-weight-bold font-size-h6">অফিসের নামঃ</span>
                            <span class="text-dark flex-root font-weight-bolder font-size-h6">{{$officeInfo->office_name_bn}}</span>
                        </div>
                    @endif
                    @if (globalUserInfo()->citizen_type_id==2)
                        <div class="d-flex mb-3">
                            <span class="text-dark-100 flex-root font-weight-bold font-size-h6">ঠিকানাঃ</span>
                            <span class="text-dark flex-root font-weight-bolder font-size-h6">{{$officeInfo->organization_physical_address}}</span>
                        </div>
                    @endif
                    @if (globalUserInfo()->citizen_type_id==1)
                        <div class="d-flex mb-3">
                            <span class="text-dark-100 flex-root font-weight-bold font-size-h6">বর্তমান ঠিকানাঃ</span>
                            <span class="text-dark flex-root font-weight-bolder font-size-h6">{{$user_address->present_address}}</span>
                        </div>
                        <div class="d-flex mb-3">
                            <span class="text-dark-100 flex-root font-weight-bold font-size-h6">স্থায়ী ঠিকানাঃ</span>
                            <span class="text-dark flex-root font-weight-bolder font-size-h6">{{$user_address->permanent_address}}</span>
                        </div>
                    @endif
                    

                    <div class="d-flex mb-3">
                        <span class="text-dark-100 flex-root font-weight-bold font-size-h6">ইমেইল এড্রেসঃ</span>
                        <span class="text-dark flex-root font-weight-bolder font-size-h6">{{ Auth::user()->email }}</span>
                    </div>
                    {{-- <div class="d-flex mb-3">
                        <span class="text-dark-100 flex-root font-weight-bold font-size-h6">প্রোফাইল ইমেজঃ</span>
                        <span class="text-dark flex-root font-weight-bolder font-size-h6">
                            @if (Auth::user()->profile_pic != null )
                                <img class="img-fluid" src="{{ url('/') }}/uploads/profile/{{  Auth::user()->profile_pic  }}" width="200"
                                    height="200">
                            @else
                                <img src="{{ url('/') }}/uploads/profile/default.jpg" width="200" height="200">
                            @endif
    
                        </span>
                       
                    </div> --}}
                    {{-- <div class="d-flex mb-3">
                        <span class="text-dark-100 flex-root font-weight-bold font-size-h6">স্বাক্ষরঃ</span>
                        <span class="text-dark flex-root font-weight-bolder font-size-h6">
                            @if ($userManagement->signature != null && $userManagement->doptor_user_flag == 1)
                                <img class="img-fluid" src="{{ $userManagement->signature }}" width="300"
                                    height="50">
                            @else
                                <span class="text-dark-100 flex-root font-weight-bold font-size-h6"></span>
                            @endif
                        </span>
                        
                    </div> --}}
                    <!--  <div class="d-flex mb-3">
                     <span class="text-dark-100 flex-root font-weight-bold font-size-h6">স্ট্যাটাসঃ</span>
                     <span class="text-dark flex-root font-weight-bolder font-size-h6"></span>
                  </div> -->
                </div>
                {{-- @endforeach --}}
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

{{-- Scripts Section Related Page--}}
@section('scripts')
<script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{ asset('js/pages/crud/datatables/advanced/multiple-controls.js') }}"></script>
<!--end::Page Scripts-->
@endsection


