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
                            <h3 >সার্টিফাইড কপি যুক্ত করুন </h3>
                        </div>
                    </div>
                 
                    <div class="row justify-content-center mt-5 mb-10 px-8 mb-lg-15 px-lg-10">
                        <div class="col-xl-12 col-xxl-7">
                            <!--begin::Form Wizard-->
                            <form id="appealCase" action="{{route('gcc.citizen.attached.certify.copy.submit')}}" class="form" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                {{-- <form class="form" id="kt_projects_add_form"> --}}
                                <!--begin::Step 1-->
                                <input type="hidden" id="appeal_id" name="appeal_id" value="{{$appeal_id}}">
                                <input type="hidden" id="court_id" name="court_id" value="{{$court_id}}">
                                <fieldset class="pb-5 create_cause" data-wizard-type="step-content"
                                    data-wizard-state="current">

                                   
                                  
                                    <div class="form-group">
                                        <label for="court_fee_amount" class="control-label"><span
                                                style="color:#FF0000">*
                                            </span>ফাইল যুক্ত করুন</label>
                                        <div class="input-group">
                                            <input type="file" name="" id=""
                                                class="form-control form-control-sm " value="" >
                                        
                                        </div>
                                    </div>
                                

                                    {{-- @include('courtFee') --}}
                                </fieldset>
                                    <button type="submit"
                                    class="btn btn-success font-weight-bolder text-uppercase px-9 py-4"> যুক্ত করুন</button>
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
        $(".payment").on('click',function(event){
            // alert('hi');
            $(".payment").removeClass("active");
            // console.log(event.target.id);
           $("#"+event.target.id).addClass("active");
            var  formURL="/payment-process";
            var fd = new FormData();
            var courtFee = 20;
            var interestRate = 0;
            var totalLoanAmount = 0;
            var totalLoanAmountText = '';
            var transaction_no = '';
            var court_id = $("#court_id").val();
    
            fd.append("courtFee", courtFee);
            fd.append("totalLoanAmount", totalLoanAmount);
            fd.append("totalLoanAmountText", totalLoanAmountText);
            fd.append("interestRate", interestRate);
            fd.append("court_id", court_id);
            fd.append("payment_type",1);
            fd.append("transaction_no",transaction_no);
            
            
            Swal.fire({
                title: "",
                text: "আপনি কি ওয়ালেটের মাধ্যমে আপনার কোর্ট ফি 20 টাকা জমা করতে চান??",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "না",
                confirmButtonText: "হ্যাঁ"
            }).then((result) => {
                
                
                if (result.isConfirmed) {
                $.ajax({
                    url: formURL,
                    // headers: {
                    // 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    // },
                    type: "POST",
                    data: fd,
                    enctype: "multipart/form-data",
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                    },
                    success: function(r) {
                        console.log(r);
                        // return false;
                        window.location.href =r;
                      
                    },
                    error: function() {}
                });
            }
                // $.ajax({
                //     url: formURL,
                //     crossDomain: true,
                //     data:,
                //     success: function(data, textStatus, jqXHR) {
                //         if (typeof successCallbackFunction === "function") {
                //             successCallbackFunction(data,Msg);
                //         }
                //     },
                // });

            });
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