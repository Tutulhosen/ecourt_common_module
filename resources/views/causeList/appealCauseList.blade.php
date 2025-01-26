@extends('layout.app')

@section('style')
@endsection

@section('landing')

<style>

        fieldset {
            border: 1px solid #ddd !important;
            margin: 0;
            xmin-width: 0;
            padding: 10px;
            position: relative;
            border-radius: 4px;
            background-color: #d5f7d5;
            padding-left: 10px !important;
        }

        fieldset .form-label {
            color: black;
        }

        legend {
            font-size: 14px;
            font-weight: bold;
            width: 45%;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px 5px 5px 10px;
            background-color: #5cb85c;
        }
</style>
<style type="text/css">
        .btn-active {
            background-color: #28a745 !important; 
            border-color: #28a745 !important;
        }
        .btn-active.active {
            background-color: #0bb7af !important; 
            border-color: #0bb7af !important;
        }
        .caselist {
            display: none; 
        }
        .caselist.active {
            display: block; 
        }
    </style>
<div class="container">
    <!--begin::Card-->
    <div class="card card-custom" style="margin: 20px">

        <div class="card-body overflow-auto">
            <?php 
                if (!empty($_GET['court_type_id'])) {
                    $court_type_id_from_url=$_GET['court_type_id'];
                } else {
                    $court_type_id_from_url=' ';
                }
                    
            ?>
            <input type="hidden" class="court_id_from_url" value="{{$court_type_id_from_url}}">
      

        <div class="row court_type" style="text-align: center">
            <div class="col-md-6"><button class="btn btn-success btn-lg court_type_button btn-active active">জেনারেল সার্টিফিকেট কোর্ট</button></div>
            <div class="col-md-6"><button class="btn btn-success btn-lg court_type_button btn-active">এক্সিকিউটিভ ম্যাজিস্ট্রেট কোর্ট</button></div>
          
        </div>

        <div class="gcc_causelist caselist active">
            <fieldset class="mb-6 mt-10" style="background-image: url({{ asset('images/causlist.png') }})">
                    <!-- <legend >ফিল্টারিং ফিল্ড সমূহ</legend> -->
                    @include('causeList.inc.search')
            </fieldset>
            <table class="table mb-6 font-size-h5 mt-10">
            <thead class="thead-customStyle2 font-size-h6 text-center">
                    <tr>
                        <h1 class="text-center mt-15" style="color: #371c7e; font-weight: 600;">জেনারেল সার্টিফিকেট আদালত
                        </h1>
                        <h2 class="text-center" style="color: #371c7e; font-weight: 600">দৈনিক কার্যতালিকা</h2>
                        @if ($division_name != null)
                            <h5 style="color: #371c7e;" class="text-center">বিভাগঃ {{ $division_name }} </h5>
                        @endif
                        @if ($district_name != null)
                            <h5 style="color: #371c7e;" class="text-center">জেলাঃ {{ $district_name }} </h5>
                        @endif
                        @if ($court_name != null)
                            <h5 style="color: #371c7e;" class="text-center">আদালতঃ {{ $court_name }} </h5>
                        @endif
                        @if ($dateFrom == $dateTo)
                            <h5 style="color: #371c7e;" class="text-center mb-6">তারিখঃ {{ en2bn($dateFrom) }}
                                খ্রিঃ</h5>
                        @else
                            <h3 style="color: #371c7e;" class="text-center mb-6">তারিখঃ {{ en2bn($dateFrom) }}
                                হতে {{ en2bn($dateTo) }} খ্রিঃ</h3>
                        @endif
                    </tr>
                </thead>
                    <thead class="thead-customStyle2 font-size-h6 text-center">
                        <tr>
                            <th scope="col">ক্রমিক নং</th>
                            <th scope="col">মামলা নম্বর</th>
                            <th scope="col">পক্ষ </th>
                            <!-- <th scope="col">অ্যাডভোকেট </th> -->
                            <th scope="col" width="100">পরবর্তী তারিখ</th>
                            <th scope="col">সর্বশেষ আদেশ</th>
                        </tr>
                    </thead>
    
                
                    @if (!empty($cose_list))

                    @forelse($cose_list as $key=>$value)
                  
                        <tbody>
                            <tr>
                                <td scope="row" class="text-center">{{ en2bn($key + 1) }}</td>
                                <td class="text-center">{{ en2bn($value['citizen_info']['case_no']) }}</td>
                                <td class="text-center">
                                    {{ isset($value['citizen_info']['applicant_name']) ? $value['citizen_info']['applicant_name'] : '-' }}
                                    <br> <b>vs</b><br>
                                    {{ isset($value['citizen_info']['defaulter_name']) ? $value['citizen_info']['defaulter_name'] : '-' }}
                                </td>

                                @if ($value['citizen_info']['appeal_status'] == 'ON_TRIAL' || $value['citizen_info']['appeal_status'] == 'ON_TRIAL_DM')
                                    @if (date('Y-m-d', strtotime(now())) == $value['citizen_info']['next_date'])
                                        <td class="blink_me text-danger">
                                            <span>*</span>{{ en2bn($value['citizen_info']['next_date']) }}<span>*</span>
                                        </td>
                                    @else
                                        <td>{{ en2bn($value['citizen_info']['next_date']) }}</td>
                                    @endif
                                @else
                                    <td class="text-danger">
                                        {{ appeal_status_bng($value['citizen_info']['appeal_status']) }}</td>
                                @endif
                                @if (isset($value['notes']['manual_decision_name']))
                                    <td class="text-center">
                                        {{ $value['notes']['manual_decision_name'] }}
                                    </td>
                                @else
                                    <td class="text-center">
                                        {{ isset($value['notes']['short_order_name']) ? $value['notes']['short_order_name'] : ' ' }}
                                    </td>
                                @endif
                                {{-- @include('dashboard.citizen._lastorder') --}}
                            </tr>
                        </tbody>

                    @empty
                        <p>কোনো তথ্য খুঁজে পাওয়া যায় নি </p>
                    @endforelse
                    @endif

                    
            
                </table>
                
            </div>

        {{-- emc caselist  --}}
        <div class="emc_causelist caselist">
            <fieldset class="mb-6 mt-10" style="background-image: url({{ asset('images/causlist.png') }}); padding-top: 26px">
                
                @include('causeList.inc.search_emc')
            </fieldset>
            <table class="table mb-6 font-size-h5 mt-10">
                <thead class="thead-customStyle2 font-size-h6 text-center">
                    <tr>
                        <h1 class="text-center mt-15" style="color: #371c7e; font-weight: 600;">নির্বাহী
                            ম্যাজিস্ট্রেট আদালত</h1>
                        <h2 class="text-center" style="color: #371c7e; font-weight: 600">দৈনিক কার্যতালিকা</h2>
                        @if ($division_name != null)
                            <h5 style="color: #371c7e;" class="text-center">বিভাগঃ {{ $division_name }} </h5>
                        @endif
                        @if ($district_name != null)
                            <h5 style="color: #371c7e;" class="text-center">জেলাঃ {{ $district_name }} </h5>
                        @endif
                        @if ($court_name != null)
                            <h5 style="color: #371c7e;" class="text-center">আদালতঃ {{ $court_name }} </h5>
                        @endif
                        @if ($dateFrom == $dateTo)
                            <h5 style="color: #371c7e;" class="text-center mb-6">তারিখঃ {{ en2bn($dateFrom) }}
                                খ্রিঃ</h5>
                        @else
                            <h3 style="color: #371c7e;" class="text-center mb-6">তারিখঃ {{ en2bn($dateFrom) }}
                                হতে {{ en2bn($dateTo) }} খ্রিঃ</h3>
                        @endif
                    </tr>
                </thead>
                <thead class="thead-customStyle2 font-size-h6 text-center">
                    <tr>
                        <th scope="col">ক্রমিক নং</th>
                        <th scope="col">মামলা নম্বর</th>
                        <th scope="col">পক্ষ </th>
                        <!-- <th scope="col">অ্যাডভোকেট </th> -->
                        <th scope="col" width="100">পরবর্তী তারিখ</th>
                        <th scope="col">সর্বশেষ আদেশ</th>
                    </tr>
                </thead>
                
                @if (!empty($appeal))
                    @forelse($appeal as $key=>$value)
                        <tbody>
                            <tr>
                                <td scope="row" class="text-center">{{ en2bn($key + 1) }}</td>
                                <td class="text-center">{{ en2bn($value['citizen_info']['case_no']) }}</td>
                                <td class="text-center">
                                    {{ isset($value['citizen_info']['applicant_name']) ? $value['citizen_info']['applicant_name'] : '-' }}
                                    <br> <b>vs</b><br>
                                    {{ isset($value['citizen_info']['defaulter_name']) ? $value['citizen_info']['defaulter_name'] : '-' }}
                                </td>

                                @if ($value['citizen_info']['appeal_status'] == 'ON_TRIAL' || $value['citizen_info']['appeal_status'] == 'ON_TRIAL_DM')
                                    @if (date('Y-m-d', strtotime(now())) == $value['citizen_info']['next_date'])
                                        <td class="blink_me text-danger">
                                            <span>*</span>{{ en2bn($value['citizen_info']['next_date']) }}<span>*</span>
                                        </td>
                                    @else
                                        <td>{{ en2bn($value['citizen_info']['next_date']) }}</td>
                                    @endif
                                @else
                                    <td class="text-danger">
                                        {{ appeal_status_bng($value['citizen_info']['appeal_status']) }}</td>
                                @endif
                                <td class="text-center">
                                    {{ isset($value['notes']->short_order_name) ? $value['notes']->short_order_name : ' ' }}

                                </td>
                                {{-- @include('dashboard.citizen._lastorder') --}}
                            </tr>
                        </tbody>

                    @empty
                        <p>কোনো তথ্য খুঁজে পাওয়া যায় নি </p>
                    @endforelse
                @endif
            </table>
        </div>

        {{-- mobile court caselist  --}}
        <div class="mc_causelist caselist">
            <h1 style="text-align:center"> COMMING SOON </h1>
        </div>

        </div>
    </div>
</div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('.court_type_button');
        const dashboards = document.querySelectorAll('.caselist');
        const court_type_id_from_url= $('.court_id_from_url').val();
        
        
        function setActiveButtonAndDashboard(buttonIndex) {
            // Remove active class from all buttons and hide all dashboards
            buttons.forEach((btn, index) => {
                btn.classList.remove('active');
                dashboards[index].classList.remove('active');
            });

            // Add active class to the clicked button and corresponding dashboard
            buttons[buttonIndex].classList.add('active');
            dashboards[buttonIndex].classList.add('active');
        }
        
        // Set default active button and dashboard (first one)
        setActiveButtonAndDashboard(0);
        if (court_type_id_from_url==2) {
            
            setActiveButtonAndDashboard(0);
        }
        if (court_type_id_from_url==3) {
            
            setActiveButtonAndDashboard(1);
        }
        // Add event listeners to each button to toggle active state
        buttons.forEach((button, index) => {
            
            button.addEventListener('click', function() {
                setActiveButtonAndDashboard(index);
            });
        });
    });

</script>
<script>

 
       jQuery(document).ready(function (){
            window.onload = function(){
                var dataID = jQuery('select[name="division"]').val();
                var courtID = jQuery('select[name="district"]').val();
                if(dataID){
                    jQuery.ajax({
                    url : '{{url("/")}}/generalCertificate/case/dropdownlist/getdependentdistrict/' +dataID,
                    type : "GET",
                    dataType : "json",
                    success:function(data){
                        jQuery('select[name="district"]').html('<div class="loadersmall"></div>');
                        jQuery('select[name="district"]').html('<option value="">-- নির্বাচন করুন --</option>');
                        jQuery.each(data, function(key,value){
                            var option = $('<option></option>').attr('value', key).text(value);
                            if (key == courtID) {
                                option.attr('selected', 'selected');
                            }
                            $('select[name="district"]').append(option);
     
                            
                        });
                        jQuery('.loadersmall').remove();
                    
                    }
                    });
                    // Upazila Dropdown
                    // Load Court
                        var courtID = jQuery('select[name="district"]').val();
                        var court = jQuery('select[name="court"]').val();
                        jQuery.ajax({
                            url : '{{url("/")}}/generalCertificate/case/dropdownlist/getdependentcourt/' +courtID,
                            type : "GET",
                            dataType : "json",
                            success:function(data)
                            {
                                jQuery('select[name="court"]').html('<div class="loadersmall"></div>');
                                jQuery('select[name="court"]').html('<option value="">-- নির্বাচন করুন --</option>');
                                
                                jQuery.each(data, function(key,value){
   
                                    jQuery('select[name="court"]').append('<option value="'+ key +'" >'+ value +'</option>');
                                });
                                jQuery('.loadersmall').remove();
                            }
                        });
                    
               }
            }
        });
   jQuery(document).ready(function (){
  
    // District Dropdown
    jQuery('select[name="division"]').on('change',function(){
       var dataID = jQuery(this).val();
       jQuery("#district_id").after('<div class="loadersmall"></div>');
       if(dataID){
    
          jQuery.ajax({
             url : '{{url("/")}}/generalCertificate/case/dropdownlist/getdependentdistrict/' +dataID,
             type : "GET",
             dataType : "json",
             success:function(data)
             {
                jQuery('select[name="district"]').html('<div class="loadersmall"></div>');

                jQuery('select[name="district"]').html('<option value="">-- নির্বাচন করুন --</option>');
                jQuery.each(data, function(key,value){
                    jQuery('select[name="district"]').append('<option value="'+ key +'">'+ value +'</option>');
                });
                jQuery('.loadersmall').remove();
               
             }
          });
       }
       else
       {
          $('select[name="district"]').empty();
       }
    });
    
    // Upazila Dropdown
    jQuery('select[name="district"]').on('change',function(){

       jQuery("#upazila_id").after('<div class="loadersmall"></div>');

    // Load Court
    var courtID = jQuery(this).val();

       jQuery.ajax({
          url : '{{url("/")}}/generalCertificate/case/dropdownlist/getdependentcourt/' +courtID,
          type : "GET",
          dataType : "json",
          success:function(data)
          {
             jQuery('select[name="court"]').html('<div class="loadersmall"></div>');
             jQuery('select[name="court"]').html('<option value="">-- নির্বাচন করুন --</option>');
             jQuery.each(data, function(key,value){
                jQuery('select[name="court"]').append('<option value="'+ key +'">'+ value +'</option>');
             });
             jQuery('.loadersmall').remove();
          }
       });
    
 });


 });

 jQuery(document).ready(function ()
   {
      // District Dropdown
      jQuery('select[name="emc_division"]').on('change',function(){
         var dataID = jQuery(this).val();

         jQuery("#emc_district_id").after('<div class="loadersmall"></div>');
   
         if(dataID){
          
            jQuery.ajax({
               url : '{{url("/")}}/generalCertificate/case/dropdownlist/getdependentdistrict/' +dataID,
               type : "GET",
               dataType : "json",
               success:function(data)
               {
                  jQuery('select[name="emc_district"]').html('<div class="loadersmall"></div>');

                  jQuery('select[name="emc_district"]').html('<option value="">-- নির্বাচন করুন --</option>');
                  jQuery.each(data, function(key,value){
                     jQuery('select[name="emc_district"]').append('<option value="'+ key +'">'+ value +'</option>');
                  });
                  jQuery('.loadersmall').remove();
               }
            });
         }
         else
         {
            $('select[name="emc_district"]').empty();
         }
      });
   // Upazila Dropdown
   jQuery('select[name="emc_district"]').on('change',function(){
      var dataID = jQuery(this).val();
      jQuery("#upazila_id").after('<div class="loadersmall"></div>');
    
      // Load Court
      var courtID = jQuery(this).val();
      jQuery("#emc_court_id").after('<div class="loadersmall"></div>');

         jQuery.ajax({
            url : '{{url("/")}}/generalCertificate/court/dropdownlist/getdependentcourt/' +courtID,
            type : "GET",
            dataType : "json",
            success:function(data)
            {
                console.log(data);
               jQuery('select[name="emc_court"]').html('<div class="loadersmall"></div>');
            
               jQuery('select[name="emc_court"]').html('<option value="">-- নির্বাচন করুন --</option>');
               jQuery.each(data, function(key,value){
                  jQuery('select[name="emc_court"]').append('<option value="'+ key +'">'+ value +'</option>');
               });
               jQuery('.loadersmall').remove();
              
            }
         });
      
   });

 $("#emc_case_no").keyup(function(){
     var amount = $("#case_no").val();
     $("#case_no").val(NumToBangla.replaceNumbers(amount));
 });
});
</script>
@endsection





