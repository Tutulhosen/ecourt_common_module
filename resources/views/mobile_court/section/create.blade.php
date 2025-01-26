@extends('layout.app')
{{-- @dd($data) --}}

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form class="" method="POST" action="{{ route('mc.section.store') }}">
        @csrf
        <div class="card card-default" style="margin-bottom: 20px">
            <div class="p-2" style="background: #F9F9F9; border:1px solid #cfc9c9;  height: 50px;">
                <h2 class="card-title">ধারা</h2>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label style="background: #008841; color: white; width:100%" class="control-label"><span
                                    style="color:#FF0000"></span>আইন</label>
                            <select name="law_id" id="lawSelect" class="form-control law_type">
                                {{-- <option value="1">মোবাইল কোর্ট</option>
                                    <option value="2">জেনারেল সার্টিফিকেট কোর্ট</option>
                                    <option value="3">এক্সিকিউটিভ ম্যাজিস্ট্রেট কোর্ট</option> --}}
                                <option value="">নির্বাচন করুন</option>
                                @foreach ($laws as $law)
                                    <option data-details="{{ $law->title }}" value="{{ $law->id }}">
                                        {{ $law->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- form-group -->
                    </div>
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label style="background: #008841; color: white; width:100%" class="control-label"><span
                                    style="color:#FF0000"></span>শিরোনাম</label>
                            <input name="sec_title" style="width: 100%; height: 40px" type="text" id="shironaamInput">

                        </div>
                        <!-- form-group -->
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label style="background: #008841; color: white; width:100%" class="control-label"><span
                                    style="color:#FF0000"></span> ধারার বর্ণনা</label>
                            <textarea name="sec_description" id="" style="width: 100%" rows="5"></textarea>

                        </div>
                        <!-- form-group -->
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label style="background: #008841; color: white; width:100%" class="control-label"><span
                                    style="color:#FF0000"></span> ধারা নম্বর</label>
                            <input name="sec_number" placeholder="শুধুমাত্র সংখ্যাটি লিখুন "
                                style="width: 100%; height: 40px" type="text">

                            </br><span style="color:#FF0000">যেমন - ৬(১) / ৬ক/(২)</span>
                        </div>
                        <!-- form-group -->
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label style="background: #008841; color: white; width:100%" class="control-label"><span
                                    style="color:#FF0000"></span> অপরাধের বর্ণনা </label>
                            <textarea name="punishment_des" id="" style="width: 100%" rows="5"></textarea>
                        </div>
                        <!-- form-group -->
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label style="background: #008841; color: white; width:100%" class="control-label"><span
                                    style="color:#FF0000"></span> শাস্তির ধারা নম্বর</label>
                            <input name="punishment_sec_number" placeholder="শুধুমাত্র সংখ্যাটি লিখুন "
                                style="width: 100%; height: 40px" type="text">

                            </br><span style="color:#FF0000">যেমন - ৬(১) / ৬ক/(২)</span>

                        </div>
                        <!-- form-group -->
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label style="background: #008841; color: white; width:100%" class="control-label"><span
                                    style="color:#FF0000"></span> সর্বোচ্চ শাস্তি </label>
                            <select style="width: 80px" id="max_jail_year" class="input high_punisment_time"">
                                <option id="" value="00">00</option>
                                <option id="1" value="01">01</option>
                                <option id="2" value="02">02</option>
                                <option id="3" value="03">03</option>
                                <option id="4" value="04">04</option>
                                <option id="5" value="05">05</option>
                                <option id="6" value="06">06</option>
                                <option id="7" value="07">07</option>
                                <option id="8" value="08">08</option>
                                <option id="9" value="09">09</option>
                                <option id="10" value="10">10</option>
                            </select>
                            বছর
                            <select style="width: 80px" id="max_jail_month" class="input high_punisment_time" ">
                                    <option id="" value="00">00</option>
                                    <option id="1" value="01">01</option>
                                    <option id="2" value="02">02</option>
                                    <option id="3" value="03">03</option>
                                    <option id="4" value="04">04</option>
                                    <option id="5" value="05">05</option>
                                    <option id="6" value="06">06</option>
                                    <option id="7" value="07">07</option>
                                    <option id="8" value="08">08</option>
                                    <option id="9" value="09">09</option>
                                    <option id="10" value="10">10</option>
                                    <option id="11" value="11">11</option>
                                </select>
                                মাস
                                <select style="width: 80px" id="max_jail_day"
                                    class="input high_punisment_time" >
                                    <option id="" value="00">00</option>
                                    <option id="1" value="01">01</option>
                                    <option id="2" value="02">02</option>
                                    <option id="3" value="03">03</option>
                                    <option id="4" value="04">04</option>
                                    <option id="5" value="05">05</option>
                                    <option id="6" value="06">06</option>
                                    <option id="7" value="07">07</option>
                                    <option id="8" value="08">08</option>
                                    <option id="9" value="09">09</option>
                                    <option id="10" value="10">10</option>
                                    <option id="11" value="11">11</option>
                                    <option id="12" value="12">12</option>
                                    <option id="13" value="13">13</option>
                                    <option id="14" value="14">14</option>
                                    <option id="15" value="15">15</option>
                                    <option id="16" value="16">16</option>
                                    <option id="17" value="17">17</option>
                                    <option id="18" value="18">18</option>
                                    <option id="19" value="19">19</option>
                                    <option id="20" value="20">20</option>
                                    <option id="21" value="21">21</option>
                                    <option id="22" value="22">22</option>
                                    <option id="23" value="23">23</option>
                                    <option id="24" value="24">24</option>
                                    <option id="25" value="25">25</option>
                                    <option id="26" value="26">26</option>
                                    <option id="27" value="27">27</option>
                                    <option id="28" value="28">28</option>
                                    <option id="29" value="29">29</option>
                                </select>
                                দিন
                            </div>
                            <input name="max_jell" id="max_jell" style="width: 40%; height: 40px" type="text">

                            <!-- form-group -->
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label style="background: #008841; color: white; width:100%" class="control-label"><span
                                        style="color:#FF0000"></span> সর্বনিম্ন শাস্তি </label>
                                <select style="width: 80px" id="min_jail_year"
                                    class="input low_punisment_time"">
                                <option id="" value="00">00</option>
                                <option id="1" value="01">01</option>
                                <option id="2" value="02">02</option>
                                <option id="3" value="03">03</option>
                                <option id="4" value="04">04</option>
                                <option id="5" value="05">05</option>
                                <option id="6" value="06">06</option>
                                <option id="7" value="07">07</option>
                                <option id="8" value="08">08</option>
                                <option id="9" value="09">09</option>
                                <option id="10" value="10">10</option>
                            </select>
                            বছর
                            <select style="width: 80px" id="min_jail_month" class="input low_punisment_time"">
                                <option id="" value="00">00</option>
                                <option id="1" value="01">01</option>
                                <option id="2" value="02">02</option>
                                <option id="3" value="03">03</option>
                                <option id="4" value="04">04</option>
                                <option id="5" value="05">05</option>
                                <option id="6" value="06">06</option>
                                <option id="7" value="07">07</option>
                                <option id="8" value="08">08</option>
                                <option id="9" value="09">09</option>
                                <option id="10" value="10">10</option>
                                <option id="11" value="11">11</option>
                            </select>
                            মাস
                            <select style="width: 80px" id="min_jail_day" class="input low_punisment_time"">

                                <option id="" value="00">00</option>
                                <option id="1" value="01">01</option>
                                <option id="2" value="02">02</option>
                                <option id="3" value="03">03</option>
                                <option id="4" value="04">04</option>
                                <option id="5" value="05">05</option>
                                <option id="6" value="06">06</option>
                                <option id="7" value="07">07</option>
                                <option id="8" value="08">08</option>
                                <option id="9" value="09">09</option>
                                <option id="10" value="10">10</option>
                                <option id="11" value="11">11</option>
                                <option id="12" value="12">12</option>
                                <option id="13" value="13">13</option>
                                <option id="14" value="14">14</option>
                                <option id="15" value="15">15</option>
                                <option id="16" value="16">16</option>
                                <option id="17" value="17">17</option>
                                <option id="18" value="18">18</option>
                                <option id="19" value="19">19</option>
                                <option id="20" value="20">20</option>
                                <option id="21" value="21">21</option>
                                <option id="22" value="22">22</option>
                                <option id="23" value="23">23</option>
                                <option id="24" value="24">24</option>
                                <option id="25" value="25">25</option>
                                <option id="26" value="26">26</option>
                                <option id="27" value="27">27</option>
                                <option id="28" value="28">28</option>
                                <option id="29" value="29">29</option>
                            </select>
                            দিন
                        </div>
                        <input name="min_jell" id="min_jell" style="width: 50%; height: 40px" type="text">

                        <!-- form-group -->
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">

                        </div>
                        <!-- form-group -->
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">

                        </div>
                        <!-- form-group -->
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label style="background: #008841; color: white; width:100%" class="control-label"><span
                                    style="color:#FF0000"></span> সর্বোচ্চ জরিমানা </label>
                            <input name="max_fine" style="width: 40%; height: 40px" type="text">

                        </div>
                        <!-- form-group -->
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label style="background: #008841; color: white; width:100%" class="control-label"><span
                                    style="color:#FF0000"></span> সর্বনিম্ন জরিমানা </label>
                            <input name="min_fine" style="width: 40%; height: 40px" type="text">

                        </div>
                        <!-- form-group -->
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label style="background: #008841; color: white; width:100%" class="control-label"><span
                                    style="color:#FF0000"></span> পুনরায় অপরাধের শাস্তি -
                                জেল</label>
                            <input name="next_jail" style="width: 40%; height: 40px" type="text">

                        </div>
                        <!-- form-group -->
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label style="background: #008841; color: white; width:100%" class="control-label"><span
                                    style="color:#FF0000"></span> পুনরায় অপরাধের শাস্তি
                                -জরিমানা</label>
                            <input name="next_fine" style="width: 40%; height: 40px" type="text">

                        </div>
                        <!-- form-group -->
                    </div>
                </div>


                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label style="background: #008841; color: white; width:100%" class="control-label"><span
                                    style="color:#FF0000"></span>শাস্তির ধরন</label>
                            <select name="punishment_type" id="" class="form-control court_type">
                                <option value="">নির্বাচন করুন</option>

                                @foreach ($punishment_type as $type)
                                    <option value="{{ $type->id }}">{{ $type->description }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label style="background: #008841; color: white; width:100%" class="control-label"><span
                                    style="color:#FF0000"></span>মন্তব্য</label>
                            <textarea name="extra_punishment" id="" style="width: 100%" rows="6"></textarea>

                        </div>
                        <!-- form-group -->
                    </div>

                </div>

                <div class="panel-footer">
                    <div class="pull-right">
                        <button class="btn btn-success" type="submit"><i class="glyphicon glyphicon-ok"></i>
                            সংরক্ষণ</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

{{-- table_new --}}

@section('scripts')
    <script>
        jQuery(document).ready(function() {
            jQuery("#law_id").select2();
        });

        function selectPunishmentDiv(select) {

            if (select == "") {
                //document.getElementById("txtHint").innerHTML="";
                return;
            } else {

                if (select == "1") {
                    $("#jellWarrentDiv").fadeIn();

                    $("#fineDiv").fadeOut();
                    $("#jellWarrentandfineDiv").fadeOut();

                    loadSelectOption("max_");
                    loadSelectOption("min_");
                } else if (select == "2") {
                    $("#fineDiv").fadeIn();

                    $("#jellWarrentDiv").fadeOut();
                    $("#jellWarrentandfineDiv").fadeOut();

                } else if (select == "3") {
                    $("#jellWarrentandfineDiv").fadeIn();
                    loadSelectOption2("max_");
                    loadSelectOption2("min_");

                    loadSelectOption_rep("max_");
                    loadSelectOption_rep("min_");


                    $("#jellWarrentDiv").fadeOut();
                    $("#fineDiv").fadeOut();
                } else {

                    $("#jellWarrentDiv").fadeOut();
                    $("#fineDiv").fadeOut();
                    $("#jellWarrentandfineDiv").fadeOut();
                }
            }
        }

        function loadSelectOption(type) {
            //        alert("dd");
            var year = document.getElementById(type + "jail_year");
            for (var i = 1; i <= 29; i++) {
                opt = document.createElement("option");
                opt.value = i;
                opt.text = i;
                year.appendChild(opt);
            }
            var month = document.getElementById(type + "jail_month");
            for (var i = 1; i <= 11; i++) {
                opt = document.createElement("option");
                opt.value = i;
                opt.text = i;
                month.appendChild(opt);
            }


            var day = document.getElementById(type + "jail_day");
            for (var i = 1; i <= 31; i++) {
                opt = document.createElement("option");
                opt.value = i;
                opt.text = i;
                day.appendChild(opt);
            }
        }


        function loadSelectOption2(type) {
            //        alert("dd");
            var year = document.getElementById(type + "jail_year2");
            for (var i = 1; i <= 29; i++) {
                opt = document.createElement("option");
                opt.value = i;
                opt.text = i;
                year.appendChild(opt);
            }
            var month = document.getElementById(type + "jail_month2");
            for (var i = 1; i <= 11; i++) {
                opt = document.createElement("option");
                opt.value = i;
                opt.text = i;
                month.appendChild(opt);
            }


            var day = document.getElementById(type + "jail_day2");
            for (var i = 1; i <= 31; i++) {
                opt = document.createElement("option");
                opt.value = i;
                opt.text = i;
                day.appendChild(opt);
            }
        }


        function loadSelectOption_rep(type) {
            //        alert("dd");
            var year = document.getElementById(type + "repjail_year");
            for (var i = 1; i <= 29; i++) {
                opt = document.createElement("option");
                opt.value = i;
                opt.text = i;
                year.appendChild(opt);
            }
            var month = document.getElementById(type + "repjail_month");
            for (var i = 1; i <= 11; i++) {
                opt = document.createElement("option");
                opt.value = i;
                opt.text = i;
                month.appendChild(opt);
            }


            var day = document.getElementById(type + "repjail_day");
            for (var i = 1; i <= 31; i++) {
                opt = document.createElement("option");
                opt.value = i;
                opt.text = i;
                day.appendChild(opt);
            }
        }

        function setSection(select) {

            var s1 = document.getElementById(select);
            var res = s1.options[s1.selectedIndex].text;
            $("#sec_title").val(res);
        }

        function showLaw(select) {

            if (select == "") {
                return
            }

            var url = base_path + "/section/getLawByCategoryId?ld=" + select;
            $.post(url, function(data) {})
                .success(function(data) {
                    if (data.length > 0) {
                        var sel_id = "#law_id";

                        $(sel_id).find("option:gt(0)").remove();
                        $(sel_id).find("option:first").text("Loading...");

                        $(sel_id).find("option:first").text("");
                        for (var i = 0; i < data.length; i++) {
                            $("<option/>").attr("value", data[i].id).text(data[i].name).appendTo($(sel_id));
                        }
                    }
                })
                .error(function() {})
                .complete(function() {});
        }

        function showDurationNew(select, setId, type) {
            if (select == "") {

                return
            }

            var duration = "#" + setId; // maximum jail

            var year = document.getElementById(type + "_jail_year");
            var selectedValueYear = year.options[year.selectedIndex].value;

            var month = document.getElementById(type + "_jail_month");
            var selectedValueMonth = month.options[month.selectedIndex].value;

            var day = document.getElementById(type + "_jail_day");
            var selectedValueDay = day.options[day.selectedIndex].value;

            $(duration).val(selectedValueYear + " বছর " + selectedValueMonth + " মাস " + selectedValueDay + " দিন ");

        }

        function showDurationNew2(select, setId, type) {
            if (select == "") {

                return
            }

            var duration = "#" + setId;

            var year = document.getElementById(type + "_jail_year2");
            var selectedValueYear = year.options[year.selectedIndex].value;

            var month = document.getElementById(type + "_jail_month2");
            var selectedValueMonth = month.options[month.selectedIndex].value;

            var day = document.getElementById(type + "_jail_day2");
            var selectedValueDay = day.options[day.selectedIndex].value;

            $(duration).val(selectedValueYear + " বছর " + selectedValueMonth + " মাস " + selectedValueDay + " দিন ");

        }

        function showDurationNewRep(select, setId, type) {
            if (select == "") {

                return
            }

            var duration = "#" + setId;

            var year = document.getElementById(type + "_repjail_year");
            var selectedValueYear = year.options[year.selectedIndex].value;

            var month = document.getElementById(type + "_repjail_year");
            var selectedValueMonth = month.options[month.selectedIndex].value;

            var day = document.getElementById(type + "_repjail_year");
            var selectedValueDay = day.options[day.selectedIndex].value;

            $(duration).val(selectedValueYear + " বছর " + selectedValueMonth + " মাস " + selectedValueDay + " দিন ");

        }
        jQuery(document).ready(function() {
            $('.law_type').on('change', function() {
                const lawDetails = $(this).find(":selected").data(
                    'details');
                $('#shironaamInput').val(lawDetails);
            });

            $('.high_punisment_time').on('change', function() {
                const maxYear = $('#max_jail_year').val();
                const maxMonth = $('#max_jail_month').val();
                const maxDay = $('#max_jail_day').val();
                const fullText = `${maxYear} বছর ${maxMonth} মাস ${maxDay} দিন`
                $('#max_jell').val(fullText);
            })
            $('.low_punisment_time').on('change', function() {
                const minYear = $('#min_jail_year').val();
                const minMonth = $('#min_jail_month').val();
                const minDay = $('#min_jail_day').val();
                const fullText = `${minYear} বছর ${minMonth} মাস ${minDay} দিন`
                $('#min_jell').val(fullText);
            })

        })
    </script>
@endsection
