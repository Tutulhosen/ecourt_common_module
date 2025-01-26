<?php use Illuminate\Support\Facades\Session;?>
@extends('dashboard.inc.emc.layouts.app')

<!-- begin::Styles the pages -->
@push('head')
    <link href="{{ asset('assets/css/pages/wizard/wizard-1.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/pages/tachyons.min.css') }}" rel="stylesheet" type="text/css" />
@endpush
<!-- end::Styles the pages -->

@section('content')
<style>
 .payment.active {
    border: 2px solid #008841;
}
</style>
<?php 
 
if(empty($_GET['data']['transaction_no'])){
    $transaction_no='';
}else{
    $transaction_no= $_GET['data']['transaction_no'];
}
if(empty($_GET['data']['payment_id'])){
    $payment_id='';
}else{
    $payment_id= $_GET['data']['payment_id'];
}
if(empty($_GET['data']['court_fee'])){
    $court_fee='';
}else{
    $court_fee= $_GET['data']['court_fee'];
}
//  echo "<pre>";
//  print_r();
//  echo "</pre>";
        $val=Session::get('key');
        // $transaction_no=  (!empty($_GET['data']['transaction_no'])?$_GET['data']['transaction_no']:'');
        //  print_r($val['payment_court_id']);
    ?>

    

    <!--begin::Row-->
    <div class="row">
        @if (Session::has('Errormassage'))
            <div class="alert alert-danger text-center">
                {{ Session::get('Errormassage') }}
            </div>
        @endif
        <div class="col-md-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b example example-compact">
                <div class="card-header">
                    <h3 class="card-title h2 font-weight-bolder" style="padding-top: 30px;"> </h3>
                    <div class="card-toolbar">
                        <!-- <div class="example-tools justify-content-center">
                                <span class="example-toggle" data-toggle="tooltip" title="View code"></span>
                                <span class="example-copy" data-toggle="tooltip" title="Copy code"></span>
                            </div> -->
                    </div>
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

                <!--begin::Form-->
                <!--begin::Entry-->
                <style>
                    .wizard.wizard-1 .wizard-nav .wizard-steps .wizard-step .wizard-label .wizard-title {
                        color: #7e8299;
                        font-size: 1.5rem;
                        font-weight: 700;
                    }
                </style>
                <div class="wizard wizard-1" id="appealWizard" data-wizard-state="step-first" data-wizard-clickable="true">
                    <div class="card" style="width: 50%; margin:auto; text-align:center; font-weight:bold; color:red">
                        <div class="card-body">
                            <h3 >সার্টিফাইড কপির আবেদনের জন্য আপনাকে ২০ টাকা কোর্ট ফি প্রদান করতে হবে । </h3>
                        </div>
                    </div>
                    
                 
                    <div class="row justify-content-center mt-5 mb-10 px-8 mb-lg-15 px-lg-10">
                        <div class="col-xl-12 col-xxl-7">
                            <!--begin::Form Wizard-->
                            <form id="appealCase" action="{{route('gcc.citizen.court.fee.submit')}}" class="form" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                {{-- <form class="form" id="kt_projects_add_form"> --}}
                                <!--begin::Step 1-->
                                <input type="hidden" id="appeal_id" name="appeal_id" value="{{$appeal_id}}">
                                <input type="hidden" id="court_id" name="court_id" value="{{$court_id}}">
                                <fieldset class="pb-5 create_cause" data-wizard-type="step-content-1"
                                    data-wizard-state="current">
                                  
                                    <div class="row">
                                        <div class='col-sm-4'>
                                        
                                            
                                            <div class="form-group">
                                                <label for="court_fee_amount" class="control-label"><span
                                                        style="color:#FF0000">*
                                                    </span>কোর্ট ফি</label>
                                                <div class="input-group">
                                                    <input type="text" name="court_fee_amount" id="court_fee_amount"
                                                        class="form-control form-control-sm " value="{{(!empty($court_fee)?$court_fee:'')}}" >
                                                
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                

                                    {{-- @include('courtFeeAppeal') --}}
                                </fieldset><br>
                                <div class="" style=" text-align:center; font-weight:bold; color:black">
                                    <div class="">
                                        <h1 >আবেদন পত্র </h1>
                                    </div>
                                </div>
                                <fieldset class="pb-5 create_cause" data-wizard-type="step-content-2"
                                    data-wizard-state="current">
                                  
                                    <div class="row">
                                        <div class="col-md-6">
                                            
                                            <div class="form-group">
                                                <label for="applicantPhn_1" class="control-label"><span
                                                        style="color:#FF0000">* </span>মামলা নম্বর</label>
                                                <div class="input-group">
                                                    
                                                    <input name="case_no" id="case_no"
                                                        class="form-control form-control-sm"
                                                        value="{{$case_no }}"
                                                        placeholder="" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='col-sm-6'>
                                        
                                            
                                            <div class="form-group">
                                                <label for="applicent_name" class="control-label"><span
                                                        style="color:#FF0000">*
                                                    </span> আবেদনকারীর নাম</label>
                                                <div class="input-group">
                                                    <input type="text" name="applicent_name" id="applicent_name"
                                                        class="form-control form-control-sm " value="{{Auth::user()->name}}" >
                                                
                                                </div>
                                            </div>
                                        </div>

                                        
                                    </div>
                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="applicantNid_1" class="control-label"><span
                                                        style="color:#FF0000">*</span>জাতীয় পরিচয় পত্র</label>
                                                <input name="nid" type="text" id="nid"
                                                    class="form-control form-control-sm"
                                                    value="{{ globalUserInfo()->citizen_nid }}" readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                           
                                            <div class="form-group">
                                                <label for="applicantPhn_1" class="control-label"><span
                                                        style="color:#FF0000">* </span>মোবাইল</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span
                                                            class="input-group-text">+88</span></div>
                                                    <input name="applicant_phn" id="applicant_phn"
                                                        class="form-control form-control-sm"
                                                        value="{{ globalUserInfo()->mobile_no }}"
                                                        readonly>
                                                </div>
                                            </div>
                                        </div>

                                        
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><span style="color:#FF0000"> </span>বর্তমান  ঠিকানা</label>
                                                <textarea name="p_address" rows="4" class="form-control element-block blank"
                                                    aria-describedby="note-error" aria-invalid="false" ></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><span style="color:#FF0000"> </span>স্থায়ী  ঠিকানা</label>
                                                <textarea name="per_address" rows="4" class="form-control element-block blank"
                                                    aria-describedby="note-error" aria-invalid="false" ></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label><span style="color:#FF0000">* </span>বিবরণ</label>
                                                <textarea name="description" rows="10" class="form-control element-block blank"
                                                    aria-describedby="note-error" aria-invalid="false">মহোদয়,
মামলার আদেশের সহি মোহরের নকল প্রদান করলে বাধীত হব ।</textarea>
                                            </div>
                                            
                                        </div>
                                        
                                    </div>
                                

                                    {{-- @include('courtFeeAppeal') --}}
                                </fieldset>
                                <br>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-success font-weight-bolder text-uppercase px-9 py-4 next_btn" >প্রেরণ করুন</button>
                                </div>
                            </form>
                            <!--end::Form Wizard-->
                        </div>
                    </div>
                    <!--end::Wizard Body-->
                </div>
                <!--end::Entry-->
            </div>
        </div>

    </div>

   
@endsection
@section('styles')
@endsection

@section('scripts')
    <script>
        $('#court_fee_amount').on('keyup', function(){
            let amount = $(this).val();
            if (amount >= 20) {
                // Enable the button
                $('.btn-success').prop('disabled', false);
            } else {
                // Keep the button disabled if the condition is not met
                $('.btn-success').prop('disabled', true);
            }
        }); 
    </script>
    <script src="{{ asset('js/number2banglaWord.js') }}"></script>
    @include('gcc_court.citizenAppealInitiate.appealCreate_Js')
@endsection

<!-- begin::Styles the pages -->
@push('footer')
    {{-- <script src="{{ asset('js/es6-shim.min.js') }}"></script> --}}
    <script src="{{ asset('js/appeal/Tachyons.min.js') }}"></script>
    <script src="{{ asset('js/appeal/appealCreateValidate.js') }}"></script>
@endpush
<!-- end::Styles the pages -->