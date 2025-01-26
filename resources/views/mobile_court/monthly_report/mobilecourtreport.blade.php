@extends('layout.app')

@section('content')
<style>
    fieldset.scheduler-border {
        border: 1px groove #ddd !important;
        /*padding: 0 0 0 1.4em !important;*/
        margin: 0 0 1.5em 0 !important;
        -webkit-box-shadow: 0px 0px 0px 0px #000;
        box-shadow: 0px 0px 0px 0px #000;
    }

    legend.scheduler-border {
        font-size: 16px !important;
        font-weight: bold !important;
        text-align: left !important;
        width: auto;
        margin: 0 10px;
        border-bottom: none;
    }
</style>
@if (session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif
@if (session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif
<style>
    /* Custom styling for the fieldset */
    .scheduler-border {
        border: 1px solid #007bff;
        /* Customize the border color */
        padding: 15px;
        /* Add padding to the fieldset */
        border-radius: 5px;
        /* Optional: add rounded corners */
    }

    .scheduler-border legend {
        width: auto;
        /* Allow legend to shrink to fit content */
        padding: 0 10px;
        /* Add padding to legend */
        font-weight: bold;
        /* Make legend text bold */
    }
</style>
<form method="post" autocomplete="off">
    @csrf
    <?php //echo $this->getContent(); 
    ?>
    <?php //echo $this->tag->hiddenField("id") 
    ?>
    <input type="hidden" id="id" name="id" value="">
    <input type="hidden" id="report_type_id" name="report_type_id" value="1" />

    <div class="card panel-default">
        <div class="card-header smx">
            <h4 class="card-title">মোবাইল কোর্টের মাসিক প্রতিবেদন দাখিল </h4>
        </div>
        <div class="card-body cpv ">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">প্রতিবেদন দাখিলের সময়</label>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                            <input type="text" class="form-control" placeholder="mm-yyyy" id="report_date"
                                name="report_date"
                                required="true" />
                        </div>
                    </div>
                </div>

                <div id="reportdiv" style="display: none;margin-top: 40px;">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label">মোবাইল কোর্টের সংখ্যা</label>
                                <?php //echo $this->tag->textField(array("court_total",'class' => "input form-control" ))
                                ?>
                                <input type="text" id="court_total" name="court_total" class="input form-control">
                                <!-- <input type="text" id="case_total" name="case_total" class="input form-control" onmouseout="showManualEntryTotalCase(this.value)"> -->
                            </div>
                        </div>

                        <div class="col-sm-5">
                            <div class="form-group">
                                <label class="control-label">প্রমাপ </label>
                                <?php
                                // echo $this->tag->textField(array("promap",'class' => "input form-control" ,'readonly' =>
                                // "readonly"))
                                ?>
                                <!-- <input type="text" id="case_manual" name="case_manual" class="input form-control" readonly="readonly">
                                  -->
                                  <input type="text" id="promap" name="promap" class="input form-control" readonly="readonly">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label">উপজেলা</label>
                                <?php
                                // echo $this->tag->textField(array("upozila",'class' => "input
                                // form-control",'readonly' =>
                                // "readonly"))
                                ?>
                                <input type="text" id="upozila" name="upozila" class="input
                             form-control" readonly="readonly">
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label">মোট মামলার সংখ্যা</label>

                                <?php
                                // echo $this->tag->textField(array("case_total",'class' => "input form-control"
                                // ,'onmouseout' => "showManualEntryTotalCase(this.value)"))
                                ?>
                                <input type="text" id="case_total" name="case_total" class="input form-control" onmouseout="showManualEntryTotalCase(this.value)">
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label class="control-label">ম্যানুয়ালি পরিচালিত মামলার সংখ্যা </label>

                                <?php
                                //  echo $this->tag->textField(array("case_manual",'class' => "input form-control"
                                // ,'readonly' => "readonly"))
                                ?>
                                <input type="text" id="case_manual" name="case_manual" class="input form-control" readonly="readonly">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label">সিস্টেম পরিচালিত মামলার সংখ্যা</label>

                                <?php
                                // echo $this->tag->textField(array("case_system",'class' => "input form-control"
                                // ,'readonly' => "readonly")) 
                                ?>
                                <input type="text" id="case_system" name="case_system" class="input form-control" readonly="readonly">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label">মোট আদায়কৃত জরিমানা (টাকা)</label>
                                <?php
                                // echo $this->tag->textField(array("fine_total",'class' => "input form-control"
                                // ,'onmouseout' => "showManualEntryTotalFine(this.value)"))
                                ?>
                                <input type="text" id="fine_total" name="fine_total" class="input form-control" onmouseout="showManualEntryTotalFine(this.value)">
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label class="control-label">ম্যানুয়ালি আদায়কৃত অর্থ (টাকা)</label>
                                <?php
                                // echo $this->tag->textField(array("fine_manual",'class' => "input form-control"
                                // ,'readonly' => "readonly")) 
                                ?>
                                <input type="text" id="fine_manual" name="fine_manual" class="input form-control" readonly="readonly">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label">সিস্টেমে এন্ট্রিকৃত জরিমানা (টাকা)</label>
                                <?php
                                // echo $this->tag->textField(array("fine_system",'class' => "input form-control"
                                // ,'readonly' => "readonly"))
                                ?>
                                <input type="text" id="fine_system" name="fine_system" class="input form-control" readonly="readonly">
                            </div>
                        </div>

                    </div>
                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border">মোট আসামির সংখ্যা</legend>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label">মোট আসামির সংখ্যা </label>
                                    <?php 
                                    // echo $this->tag->textField(array("criminal_total",'class' => "input
                                    // form-control",'onmouseout' => "showManualEntryTotalcriminal(this.value)"
                                    // )) 
                                    ?>
                                    <input type="text" id="criminal_total" name="criminal_total" class="input
                                    form-control" onmouseout="showManualEntryTotalcriminal(this.value)">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label">ম্যানুয়ালি পরিচালিত মামলায় আসামির সংখ্যা </label>
                                    <?php 
                                    // echo $this->tag->textField(array("criminal_manual",'class' => "input
                                    // form-control"
                                    // ,'readonly' => "readonly"))
                                    ?>
                                    <input type="text" id="criminal_manual" name="criminal_manual" class="input
                                    form-control" readonly="readonly">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label">সিস্টেমে এন্ট্রিকৃত আসামির সংখ্যা </label>
                                    <?php 
                                    // echo $this->tag->textField(array("criminal_system",'class' => "input
                                    // form-control"
                                    // ,'readonly' => "readonly")) 
                                    ?>
                                    <input type="text" id="criminal_system" name="criminal_system" class="input
                                    form-control" readonly="readonly">
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border">কারাদণ্ড প্রাপ্ত আসামির সংখ্যা</legend>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="control-label">মোট কারাদণ্ড প্রাপ্ত আসামির সংখ্যা </label>
                                    <?php
                                    // echo $this->tag->textField(array("lockup_criminal_total",'class' => "input
                                    // form-control",'onmouseout' => "showManualEntryTotalcriminalJail(this.value)"
                                    // )) 
                                    ?>
                                    <input type="text" id="lockup_criminal_total" name="lockup_criminal_total" class="input
                                form-control" onmouseout="showManualEntryTotalcriminalJail(this.value)">
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label class="control-label">ম্যানুয়ালি পরিচালিত মামলায় কারাদণ্ড প্রাপ্ত আসামির
                                        সংখ্যা </label>
                                    <?php
                                    // echo $this->tag->textField(array("lockup_criminal_manual",'class' => "input
                                    // form-control"
                                    // ,'readonly' => "readonly"))
                                    ?>
                                    <input type="text" id="lockup_criminal_manual" name="lockup_criminal_manual" class="input
                                 form-control" readonly="readonly">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label">সিস্টেমে এন্ট্রিকৃত কারাদণ্ড প্রাপ্ত আসামির
                                        সংখ্যা </label>
                                    <?php
                                    // echo $this->tag->textField(array("lockup_criminal_system",'class' => "input
                                    // form-control"
                                    // ,'readonly' => "readonly")) 
                                    ?>
                                    <input type="text" id="lockup_criminal_system" name="lockup_criminal_system" class="input
                                form-control" readonly="readonly">
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">মন্তব্য</label>
                                <?php
                                // echo $this->tag->textArea(array("comment2", "cols" => 50, "rows" =>4 ,'class' =>
                                // "input form-control"))
                                ?>
                                <textarea id="comment2" name="comment2" class="input form-control" cols="50" rows="4" spellcheck="false"></textarea>
                            </div>
                        </div>
                    </div>
                    <div id="adm_comment" class="row hidden" >
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">এ ডি এম - এর মন্তব্য</label>
                                <p class="form-control" id="comment_from_adm"></p>
                            </div>
                        </div>
                    </div>




                    <!-- form-group -->
                    <div class="panel-footer">
                        <?php
                        // echo $this->tag->linkTo(array("home/index", "প্রথম পাতা" ,'class' => 'btn btn-mideum
                        // btn-info'))
                        ?>
                        <div class="pull-right">
                            <button class="btn btn-success mr5" onmouseover=onMouseOverMblReportSubmit(this.value); type="submit" id="btn_submit">সংরক্ষণ করুন</button>
                        </div>
                    </div>
                    <!-- panel-footer -->
                </div>
            </div>
        </div>
    </div>
</form>

<div id="messageModal">
    @include('message.partials.message')
</div>
@endsection

@section('scripts')
{{-- stylesheet_link('vendors/datepicker.css') --}}
{{-- javascript_include("vendors/bootstrap-datepicker.js") --}}


<script src="{{ asset('/mobile_court/javascripts/source/report/common.js') }}"></script>

<script>
    // var chec = $('#report_date').datepicker({
    //     format: "mm-yyyy",
    //     viewMode: "months",
    //     minViewMode: "months",
    //     changeMonth: true,
    //     changeYear: true
    // }).on('changeDate', function(ev) {
    //     chec.hide();
    // }).data('datepicker');

    function onMouseOverMblReportSubmit(sel) {
        showManualEntryTotalCase(sel);
        showManualEntryTotalFine(sel);
        showManualEntryTotalcriminal(sel);
        showManualEntryTotalcriminalJail(sel);
    }


    function showManualEntryTotalCase(totalNumCase) {
        var case_manual = "#case_manual";

        var case_total = document.getElementById("case_total");
        var total_system = document.getElementById("case_system");
        if (case_total.value) {
            if (checkOnlyNumber(case_total.value)) {
                var caseTotalEng = ben_to_en_number_conversion(case_total.value);
                var caseTotalSystemEng = ben_to_en_number_conversion(total_system.value);

                var case_manual_str = parseInt(caseTotalEng) - parseInt(caseTotalSystemEng);
                $(case_total).val(caseTotalEng);
                $(case_manual).val(case_manual_str);
            } else {
                $(case_total).val("");
                $(case_manual).val("");

                $.alert('শুধুমাত্র সংখ্যায় হবে!', 'সর্তকিকরন ম্যাসেজ');
            }

        }

    }

    function showManualEntryTotalFine(totalFine) {

        var totalfine = "#fine_total";
        var fine_manual = "#fine_manual";
        var fine_system = "#fine_system";

        var fine_total_in = document.getElementById("fine_total");
        var fine_system_in = document.getElementById("fine_system");
        if (fine_total_in.value) {
            if (checkOnlyNumber(fine_total_in.value)) {
                var fine_totalinEng = ben_to_en_number_conversion(fine_total_in.value);
                var fine_systeminEng = ben_to_en_number_conversion(fine_system_in.value);


                var manualfine_str = parseInt(fine_totalinEng) - parseInt(fine_systeminEng);
                $(fine_manual).val(manualfine_str);
                $(fine_total_in).val(fine_totalinEng);
            } else {
                $(fine_total_in).val("");
                $(fine_manual).val("");
                $.alert('শুধুমাত্র সংখ্যায় হবে!', 'সর্তকিকরন ম্যাসেজ');
            }

        }

    }

    function showManualEntryTotalcriminal(totalFine) {
        var totalcriminal = "#criminal_total";

        var criminal_manual = "#criminal_manual";
        var criminal_system = "#criminal_system";

        var criminal_total_in = document.getElementById("criminal_total");
        var criminal_system_in = document.getElementById("criminal_system");
        if (criminal_total_in.value) {
            if (checkOnlyNumber(criminal_total_in.value)) {
                var criminal_totalinEng = ben_to_en_number_conversion(criminal_total_in.value);
                var criminal_systeminEng = ben_to_en_number_conversion(criminal_system_in.value);


                var manualcriminal_str = parseInt(criminal_totalinEng) - parseInt(criminal_systeminEng);
                $(criminal_manual).val(manualcriminal_str);
                $(totalcriminal).val(criminal_totalinEng);
            } else {
                $(criminal_manual).val("");
                $(criminal_total_in).val("");
                $.alert('শুধুমাত্র সংখ্যায় হবে!', 'সর্তকিকরন ম্যাসেজ');
            }

        }


    }

    function showManualEntryTotalcriminalJail(totalFine) {
        var totalcriminal = "#lockup_criminal_total";


        var lockup_criminal_manual = "#lockup_criminal_manual";
        var lockup_criminal_system = "#lockup_criminal_system";

        var lockup_criminal_total_in = document.getElementById("lockup_criminal_total");
        var lockup_criminal_system_in = document.getElementById("lockup_criminal_system");

        if (lockup_criminal_total_in.value) {
            if (checkOnlyNumber(lockup_criminal_total_in.value)) {
                var lockup_criminal_totalinEng = ben_to_en_number_conversion(lockup_criminal_total_in.value);
                var lockup_criminal_systeminEng = ben_to_en_number_conversion(lockup_criminal_system_in.value);


                var manualcriminal_str = parseInt(lockup_criminal_totalinEng) - parseInt(lockup_criminal_systeminEng);

                $(lockup_criminal_manual).val(manualcriminal_str);
                $(lockup_criminal_total_in).val(lockup_criminal_totalinEng);

            } else {
                $(lockup_criminal_manual).val("");
                $(lockup_criminal_total_in).val("");
                $.alert('শুধুমাত্র সংখ্যায় হবে!', 'সর্তকিকরন ম্যাসেজ');
            }

        }



    }




    //previous Function
    function showTotalcase(sel) {
        var totalcase = "#case_total";
        var case_manual = document.getElementById("case_manual");
        var case_system = document.getElementById("case_system");

        var totalcase_str = parseInt(case_manual.value) + parseInt(case_system.value);
        $(totalcase).val(totalcase_str);
    }

    function showTotalfine(sel) {
        var totalfine = "#fine_total";
        var fine_manual = "#fine_manual";
        var fine_system = "#fine_system";

        var fine_manual_in = document.getElementById("fine_manual");
        var fine_system_in = document.getElementById("fine_system");

        //        var fine_manualinEng  =  ben_to_en_number_conversion(fine_manual_in.value);
        //        var fine_systeminEng  =  ben_to_en_number_conversion(fine_system_in.value);


        $(fine_manual).val(fine_manualinEng);
        $(fine_system).val(fine_systeminEng);

        var totalfine_str = parseInt(fine_manual_in) + parseInt(fine_system_in);
        $(totalfine).val(totalfine_str);
    }

    function showTotalcriminal(sel) {
        var totalcriminal = "#criminal_total";

        var criminal_manual = "#criminal_manual";
        var criminal_system = "#criminal_system";

        var criminal_manual_in = document.getElementById("criminal_manual");
        var criminal_system_in = document.getElementById("criminal_system");


        var criminal_manualinEng = ben_to_en_number_conversion(criminal_manual_in.value);
        var criminal_systeminEng = ben_to_en_number_conversion(criminal_system_in.value);


        $(criminal_manual).val(criminal_manualinEng);
        $(criminal_system).val(criminal_systeminEng);

        var totalcriminal_str = parseInt(criminal_manualinEng) + parseInt(criminal_systeminEng);
        $(totalcriminal).val(totalcriminal_str);
    }

    function showTotallockupcriminal(sel) {
        var totalcriminal = "#lockup_criminal_total";


        var lockup_criminal_manual = "#lockup_criminal_manual";
        var lockup_criminal_system = "#lockup_criminal_system";

        var lockup_criminal_manual_in = document.getElementById("lockup_criminal_manual");
        var lockup_criminal_system_in = document.getElementById("lockup_criminal_system");


        var lockup_criminal_manualinEng = ben_to_en_number_conversion(lockup_criminal_manual_in.value);
        var lockup_criminal_systeminEng = ben_to_en_number_conversion(lockup_criminal_system_in.value);


        $(lockup_criminal_manual).val(lockup_criminal_manualinEng);
        $(lockup_criminal_system).val(lockup_criminal_systeminEng);


        var totalcriminal_str = parseInt(lockup_criminal_manualinEng) + parseInt(lockup_criminal_systeminEng);

        $(totalcriminal).val(totalcriminal_str);
    }


    function ben_to_en_number_conversion(ben_number) {
        var eng_number = '';
        for (var i = 0; i < ben_number.length; i++) {
            if (ben_number[i] == "০" || ben_number[i] == "0") eng_number = eng_number + '0';
            if (ben_number[i] == "১" || ben_number[i] == "1") eng_number = eng_number + '1';
            if (ben_number[i] == "২" || ben_number[i] == "2") eng_number = eng_number + '2';
            if (ben_number[i] == "৩" || ben_number[i] == "3") eng_number = eng_number + '3';
            if (ben_number[i] == "৪" || ben_number[i] == "4") eng_number = eng_number + '4';
            if (ben_number[i] == "৫" || ben_number[i] == "5") eng_number = eng_number + '5';
            if (ben_number[i] == "৬" || ben_number[i] == "6") eng_number = eng_number + '6';
            if (ben_number[i] == "৭" || ben_number[i] == "7") eng_number = eng_number + '7';
            if (ben_number[i] == "৮" || ben_number[i] == "8") eng_number = eng_number + '8';
            if (ben_number[i] == "৯" || ben_number[i] == "9") eng_number = eng_number + '9';
        }
        return eng_number;
    }
</script>
@endsection