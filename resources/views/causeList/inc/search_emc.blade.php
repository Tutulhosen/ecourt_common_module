@php
    
    if (!empty($_GET['emc_date_start'])) {
        $date_start = $_GET['emc_date_start'];
    } else {
        $date_start = '';
    }
    
    if (!empty($_GET['emc_date_end'])) {
        $date_end = $_GET['emc_date_end'];
    } else {
        $date_end = '';
    }
    if(!empty($_GET['emc_district']))
    {
      $district_info=DB::table('district')->where('id',$_GET['emc_district'])->get();
    }
    if(!empty($_GET['emc_court']))
    {
      $court_info=DB::table('court')->where('id',$_GET['emc_court'])->get();
    }
    if(!empty($_GET['emc_case_no']))
    {
      $case_no=$_GET['emc_case_no'];
    }else
    {
      $case_no='';
    }
@endphp
<form class="form-inline" method="GET" id="landin_page_causelist_search_form">
<input type="hidden" value="3" name="court_type_id" id="emc_court_type_id">
    <input type="hidden" value="" name="emc_offset" id="landin_page_causelist_search_form_offset">

    <div class="container">
        <div class="row">
            <div class="col-lg-2 mb-5">
                <select name="emc_division" class="form-control form-control w-100">
                    <option value="">বিভাগ নির্বাচন করুন-</option>
                    <?php
                   foreach ($divisions as $value)
                   {
                     if(!empty($_GET['emc_division'])&&($_GET['emc_division']==$value->id))
                     {
                        $selected='selected';
                     }
                     else {
                        $selected=' ';
                     }
                     ?>

                    <option value="{{ $value->id }}" <?= $selected ?>> {{ $value->division_name_bn }} </option>
                    <?php
                   }
               
                 ?>
                </select>
            </div>
            <div class="col-lg-2 mb-5">
                <!-- <label>জেলা <span class="text-danger">*</span></label> -->
                <select name="emc_district" id="emc_district_id" class="form-control form-control w-100">
                    <option value="">জেলা নির্বাচন করুন-</option>
                    <?php
                    if(!empty($district_info))
                    {
                     foreach ($district_info as $value)
                   {
                     
                     ?>
                    <option value="{{ $value->id }}" selected> {{ $value->district_name_bn }} </option>
                    <?php
                   }
                    }

                 ?>
                </select>
            </div>
            <div class="col-lg-2 mb-5">
                <select name="emc_court" id="emc_court_id" class="form-control form-control w-100">
                    <option value="">আদালত নির্বাচন করুন-</option>
                    <?php
                    if(!empty($court_info))
                    {
                     foreach ($court_info as $value)
                   {
                     
                     ?>
                    <option value="{{ $value->id }}" selected> {{ $value->court_name }} </option>
                    <?php
                   }
                    }

                 ?>
                </select>
            </div>
            <div class="col-lg-2 mb-5">
               <input type="text" name="emc_case_no" class="w-100 form-control"
                   placeholder="মামলা নম্বর" autocomplete="off" value="<?= $case_no ?>">
           </div>
            <div class="col-lg-2 mb-5">
                <input type="text" name="emc_date_start" class="w-100 form-control common_datepicker"
                    placeholder="তারিখ হতে" autocomplete="off" value="<?= $date_start ?>">
            </div>
            <div class="col-lg-2 mb-5">
                <input type="text" name="emc_date_end" class="w-100 form-control common_datepicker"
                    placeholder="তারিখ পর্যন্ত" autocomplete="off" value="<?= $date_end ?>">
            </div>
            <div class="col-lg-2 text-left">
                <button type="submit" class="btn btn-info font-weight-bolder mb-2 ml-2">অনুসন্ধান করুন</button>
            </div>
        </div>
    </div>

</form>

@section('scripts')
    <script src="{{ asset('js/pages/crud/forms/widgets/bootstrap-datepicker.js') }}"></script>
    <script>
        // common datepicker
        $('.common_datepicker').datepicker({
            format: "dd/mm/yyyy",
            todayHighlight: true,
            orientation: "bottom left"
        });
    </script>



<script type="text/javascript">
 

//=====================Num2Bangla====================//
   var NumToBangla = {
      replaceNumbers: function(input) {
           var numbers = {
               0: '০',
               1: '১',
               2: '২',
               3: '৩',
               4: '৪',
               5: '৫',
               6: '৬',
               7: '৭',
               8: '৮',
               9: '৯'
           };
           var output = [];
           for (var i = 0; i < input.length; ++i) {
               if (numbers.hasOwnProperty(input[i])) {
                   output.push(numbers[input[i]]);
               } else {
                   output.push(input[i]);
               }
           }
           return output.join('');
      }
   }
//=====================//Num2Bangla====================//
 </script>

  
@endsection
