var ordersheetForm = {

    seizureOrderText:'',
    //regular case modal order text box
    jail_type: '',
    seizure_order_val:'' ,
    seizure_order_replace_parameter: 'দায়িত্বপ্রাপ্ত ব্যাক্তি',
    numOfLaw:0,

    //
    /*sendToPoliceOrderText:'',
    sendToPoliceOrderTextReplaceParameter:'দায়িত্বপ্রাপ্ত ব্যাক্তি',*/
   


    init: function () {
        ordersheetForm.getOrderListByProsecutionId();
    },

    // working section

    showseizureorder: function (value) {
        var seizure_order = "#seizure_order";
        var jimmader_name_val = document.getElementById("jimmader_name").value;
        var jimmader_custodian_name_val = document.getElementById("jimmader_custodian_name").value;
        var jimmader_details_val = document.getElementById("jimmader_details").value;
        ordersheetForm.seizure_order_val =$('#seizure_order').val();
        var seizure_order_str =
            (jimmader_name_val ? "জনাব " + jimmader_name_val : "") +
            (jimmader_custodian_name_val ? " ,পদবী : " + jimmader_custodian_name_val : "") +
            (jimmader_details_val ? " , ঠিকানা :" + jimmader_details_val : "");

        var res = ordersheetForm.seizure_order_val.replace(new RegExp(ordersheetForm.seizure_order_replace_parameter,'gi'), seizure_order_str);
        ordersheetForm.seizure_order_replace_parameter = seizure_order_str;
        $(seizure_order).val(res);
    },

    showPunishmentSheet: function (flag) {

        var orderTemplateText='';
        var lawIdStr = ordersheetForm.getSelectedChkboxLaw();
        var cdiminal_ids_str = ordersheetForm.getSelectedChkboxCriminal();

       

        if (cdiminal_ids_str.length == 0 && lawIdStr.length == 0) {
            
            // alert("আসামি এবং আইন নির্বাচন করুন", 'সর্তকিকরন ম্যাসেজ')
            Swal.fire({
                title: "সর্তকিকরন ম্যাসেজ",
                text: "আসামি এবং আইন নির্বাচন করুন",
                icon: "error"
            });
        }
        else if (cdiminal_ids_str.length == 0) {
            
            // alert("আসামি নির্বাচন করুন", 'সর্তকিকরন ম্যাসেজ')
            Swal.fire({
                title: "সর্তকিকরন ম্যাসেজ",
                text: "আসামি নির্বাচন করুন",
                icon: "error"
            });
        }
        else if (lawIdStr.length == 0) {
            
            // alert("আইন নির্বাচন করুন", 'সর্তকিকরন ম্যাসেজ')
            Swal.fire({
                title: "সর্তকিকরন ম্যাসেজ",
                text: "আইন নির্বাচন করুন",
                icon: "error"
            });

        }
        else {

            ordersheetForm.isOrderExistForCriminalAgainstLaw(flag,lawIdStr);
            /*if (flag == 1) {
                ordersheetForm.setPunishmentTemplete(lawIdStr);
            }
            else if (flag == 2) {
                //ordersheetForm.setGlobalSendToOrderText(cdiminal_ids_str,lawIdStr);
                ordersheetForm.setRegularCaseTemplate(lawIdStr);
            }else {
                ordersheetForm.saveReleaseForm();
            }*/
            //Release case Modal
            /*else {
                orderTemplateText=ordersheetForm.releaseCaseOrderTextGeneration(lawIdStr,cdiminal_ids_str);
                ordersheetForm.setReleaseTemplate(lawIdStr,orderTemplateText);
            }*/

        }
    },

    //Get Selected CheckBox(Law)
    getSelectedChkboxLaw: function () {
        var lawChkBoxId = document.querySelectorAll('input[name="law[]"]:checked');

        var lawIds = [];

        for (var x = 0, l = lawChkBoxId.length; x < l; x++) {
            lawIds.push({
                'LawsBrokenID': lawChkBoxId[x].value,
                'secDescription': lawChkBoxId[x].getAttribute('secDescription'),
                "lawTitle": lawChkBoxId[x].title,
                "secNumber": lawChkBoxId[x].getAttribute('secNumber')
            });
        }
        return lawIds;

    },

    //Get Selected CheckBox(Criminal)
    getSelectedChkboxCriminal: function () {

        var criminalChkBoxId = document.querySelectorAll('input[name="criminal[]"]:checked');

        var crimIds = [];

        for (var x = 0, l = criminalChkBoxId.length; x < l; x++) {
            crimIds.push({
                'id':criminalChkBoxId[x].value,
                "criminalName": criminalChkBoxId[x].getAttribute('criminalName')
            });
        }

        return crimIds;
    },

    //For Regular Case
    setRegularCaseTemplate: function (law_modal) {

        $('#regularcase_modal').modal('show');
        $(".modal_regularcase").empty();

        var div = $("#modal_regularcase");
        var template = "";
        var index=0;

        template += '<div class="panel-group" id="accordion_suo"> ' +
            '<div class="panel panel-info-head"> ';

        for (var i = 0; i < law_modal.length; i++) {
            index = i + 1;
            template += '<input class="input form-control" name="law_oreder[' + index + '][lawsBrokenID]" id="lawsBrokenID_' + index + '" value=' + law_modal[i].LawsBrokenID + '   type="hidden"/> ';
            template +=
                '<div class="panel-heading newhead"> ' +
                '<a style="font-family: NIKOSHBAN" class="collapsed panel-title " data-toggle="collapse"  data-parent="#accordion_suo" href="#collapse_suo' + index + '">' + index + 'নম্বর অপরাধের জন্য শাস্তি [ধারার বর্ণনা:' + law_modal[i].secDescription + ']' +
                '</a>' +
                '</div>';

        }
        template += '<div class="panel-body cpv"> ' +
            '<div class="row"> ' +
            '<div class="col-md-12"> ' +
            '<div class="form-group"> ' +
            '<label class="control-label textmid">কারাদণ্ড</label> ' +
            '<input type="radio" onclick="ordersheetForm.populateDropDownOrNameField(this.value)" name="law_order_send_to" value="THANA" required="true" ' +
            '/>থানায় প্রেরণ     ' +
            '<input type="radio" onclick="ordersheetForm.populateDropDownOrNameField(this.value)" name="law_order_send_to" checked value="HIGHCOURT" required="true"' +
            '/> উচ্চ আদালতে প্রেরণ' +
            '</div> ' +
            '</div> ' +
            '</div> ';

        template += '<div class="row"> ' +
            '            <div class="col-md-6" id="resposibleSection">' +
            '<div class="form-group"> ' +
            '         <label class="control-label textmid">নাম </label>' +
            '                <textarea id="regular_case_responsible_name" class="required" name="law_order[0][regular_case_responsible_name]"' +
            '                       class="input form-control" cols="45" rows="2">চিফ জুডিশিয়াল ম্যাজিস্ট্রেট</textarea> ' +
            '      </div>'+
            '            </div> ' +
            '            <div class="col-md-6">' +
            '                <div class="form-group"> ' +
            '                    <label class="control-label textmid"> ঠিকানা </label>' +
            '                    <textarea id="responsible_address" class="required" name="law_order[0][responsible_address]"' +
            '                       class="input form-control" cols="45" rows="2" ></textarea> ' +
            '                    </div>' +
            '                </div> ' +
            '            </div>' +
            '      </div>';
        div.append(template);
        //ordersheetForm.regularCaseSendToHighCourtOrderTextGeneration();

    },


    //For Punishment Case
    setPunishmentTemplete: function (law_modal) {

        $(".ordertemp_suo").empty();

        var rowTemplate = "";
        var law_modal_no = 0;

        var div = $("#ordertemp_suo");
        var index = 1;
        for (var i = 0; i < law_modal.length; i++) {

            index = i + 1;
            rowTemplate += '<input class="input form-control" name="law_oreder[' + index + '][lawsBrokenID]" id="lawsBrokenID_' + index + '" value=' + law_modal[i].LawsBrokenID + '   type="hidden"/> ';

            rowTemplate +=
                '<div class="panel-group" id="accordion_suo"> ' +
                '<div class="panel panel-info-head"> ' +
                '<div class="panel-heading newhead"> ' +
                '<a style="font-family: NIKOSHBAN" class="collapsed panel-title " data-toggle="collapse"  data-parent="#accordion_suo" href="#collapse_suo' + index + '">' + index + 'নম্বর অপরাধের জন্য শাস্তি [ধারার বর্ণনা:' + law_modal[i].secDescription + '] (ক্লিক করুন)' +
                '</a>' +
                '</div>';

            if (i == 0) {
                rowTemplate += '<div id="collapse_suo' + index + '" class="accordion-body collapse in">';
            }
            else {
                rowTemplate += '<div id="collapse_suo' + index + '" class="accordion-body collapse">';
            }

            rowTemplate += '<div class="panel-body cpv"> ' +
                '<div class="row"> ' +
                '<div class="col-md-12"> ' +
                '<div class="form-group"> ' +
                '<label class="control-label textmid">কারাদণ্ড</label> ' +
                '<input class="warrent_type' + index + '" type="radio" name="law_oreder[' + index + '][warrent_type]" value="1" ' +
                'onclick="ordersheetForm.showJailType(' + index + ')"/> সশ্রম' +
                '<input class="warrent_type' + index + '" type="radio" name="law_oreder[' + index + '][warrent_type]" value="2" checked ' +
                'onclick="ordersheetForm.showJailType(' + index + ')"/> বিনাশ্রম' +
                '</div> ' +
                '</div> ' +
                '</div> ' +
                '<div class="row"> ' +
                '<div class="col-md-3"> ' +
                '<div class="form-group"> ' +
                '<label class="control-label">বছর</label> ' +
                '<select style="width:100%" id="warrent_year_' + index + '" ' +
                'name="law_oreder[' + index + '][warrent_year]" class="input" ' +
                'onchange="ordersheetForm.showDuration(' + index + ',this.value)"> ' +
                '<option id="0" value="00">00</option> ' +
                '<option id="1" value="01">01</option> ' +
                '<option id="2" value="02">02</option> ' +
                '</select> ' +
                '</div> ' +
                '</div> ' +
                '<div class="col-md-3"> ' +
                '<div class="form-group"> ' +
                '<label class="control-label">মাস</label> ' +
                '<select style="width:100%" id="warrent_month_' + index + '" ' +
                'name="law_oreder[' + index + '][warrent_month]" class="input" ' +
                'onchange="ordersheetForm.showDuration(' + index + ',this.value)"> ' +
                '<option  value="00">00</option> ' +
                '<option  value="01">01</option> ' +
                '<option  value="02">02</option>' +
                '<option  value="03">03</option>' +
                '<option  value="04">04</option>' +
                '<option  value="05">05</option>' +
                '<option  value="06">06</option>' +
                '<option  value="07">07</option>' +
                '<option  value="08">08</option>' +
                '<option  value="09">09</option>' +
                '<option  value="10">10</option>' +
                '<option  value="11">11</option>' +
                '</select> ' +
                '</div> ' +
                '</div> ' +
                '<div class="col-md-3"> ' +
                '<div class="form-group"> ' +
                '<label class="control-label">দিন</label> ' +
                '<select style="width:100%" id="warrent_day_' + index + '" ' +
                'name="law_oreder[' + index + '][warrent_day]" class="input" ' +
                'onchange="ordersheetForm.showDuration(' + index + ',this.value)"> ' +
                '<option id="" value="00">00</option> ' +
                '<option id="1" value="01">01</option>' +
                '<option id="2" value="02">02</option>' +
                '<option id="3" value="03">03</option>' +
                '<option id="4" value="04">04</option>' +
                '<option id="5" value="05">05</option>' +
                '<option id="6" value="06">06</option>' +
                '<option id="7" value="07">07</option>' +
                '<option id="8" value="08">08</option>' +
                '<option id="9" value="09">09</option>' +
                '<option id="10" value="10">10</option>' +
                '<option id="11" value="11">11</option>' +
                '<option id="12" value="12">12</option>' +
                '<option id="13" value="13">13</option>' +
                '<option id="14" value="14">14</option>' +
                '<option id="15" value="15">15</option>' +
                '<option id="16" value="16">16</option>' +
                '<option id="17" value="17">17</option>' +
                '<option id="18" value="18">18</option>' +
                '<option id="19" value="19">19</option>' +
                '<option id="20" value="20">20</option>' +
                '<option id="21" value="21">21</option>' +
                '<option id="22" value="22">22</option>' +
                '<option id="23" value="23">23</option>' +
                '<option id="24" value="24">24</option>' +
                '<option id="25" value="25">25</option>' +
                '<option id="26" value="26">26</option>' +
                '<option id="27" value="27">27</option>' +
                '<option id="28" value="28">29</option>' +
                '</select>    ' +
                '</div> ' +
                '</div> ' +
                '<div class="col-md-3"> ' +
                '<div class="form-group"> ' +
                '<label class="control-label">কারাদণ্ড</label> ' +
                '<input type="text" id="law_order_' + index + '_warrent_duration" ' +
                'name="law_oreder[' + index + '][warrent_duration]" class="input form-control" readonly="readonly"/> ' +
                '</div>' +
                '</div>' +
                '</div>' +
                '<div class="row"> ' +
                '<div class="col-md-3"> ' +
                '<div class="form-group"> ' +
                '<label class="control-label">অর্থদণ্ড (অংকে)</label> ' +
                '<input type="text" id="law_order_' + index + '_fine" name="law_oreder[' + index + '][fine]" ' +
                'class="input form-control" onchange="ordersheetForm.showFine(' + index + ',this.value)"/> ' +
                '</div> ' +
                '</div> ' +
                '<div class="col-md-9"> ' +
                '<div class="form-group"> ' +
                '<label class="control-label">অর্থদণ্ড</label> ' +
                '<input type="text" id="law_order_' + index + '_fine_in_word" name="law_oreder[' + index + '][fine_in_word]" ' +
                'class="input form-control" readonly="readonly"/> ' +
                '</div> ' +
                '</div> ' +
                '</div> ' +
                '<div class="row"> ' +
                '<div class="col-md-12"> ' +
                '<div class="form-group"> ' +
                '<label class="control-label textmid">আদেশ </label> ' +
                '<textarea id="law_order_' + index + '_order_detail" name="law_oreder[' + index + '][order_detail]" ' +
                'class="input form-control" cols="50" rows="2" readonly="readonly"></textarea> ' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>';
        }


        rowTemplate +=
            '<div class="row"> ' +
            '<div class="col-md-12"> ' +
            '<div class="form-group"> ' +
            '<label class="control-label textmid">অর্থদণ্ড অনাদায়ে কারাদণ্ড</label> ' +
            '</div>' +
            '</div>' +
            '</div>' +
            '<div class="row"> ' +
            '<div class="col-md-4"> ' +
            '<div class="form-group"> ' +
            '<label class="control-label">মাস</label> ' +
            '<select style="width:100%" id="rep_warrent_month" ' +
            'name="rep_warrent_month" class="input" ' +
            'onchange="ordersheetForm.showRepDuration(1,this.value)"> ' +
            '<option id="" value="">00</option> ' +
            '<option id="1" value="01">01</option> ' +
            '<option id="2" value="02">02</option> ' +
            '<option id="3" value="03">03</option> ' +
            '</select> ' +
            '</div> ' +
            '</div> ' +
            '<div class="col-md-4"> ' +
            '<div class="form-group"> ' +
            '<label class="control-label">দিন</label> ' +
            '<select style="width:100%" id="rep_warrent_day" ' +
            'name="rep_warrent_day" class="input" ' +
            'onchange="ordersheetForm.showRepDuration(1,this.value)"> ' +
            '<option id="" value="">00</option>    ' +
            '<option id="1" value="01">01</option>' +
            '<option id="2" value="02">02</option>' +
            '<option id="3" value="03">03</option>' +
            '<option id="4" value="04">04</option>' +
            '<option id="5" value="05">05</option>' +
            '<option id="6" value="06">06</option>' +
            '<option id="7" value="07">07</option>' +
            '<option id="8" value="08">08</option>' +
            '<option id="9" value="09">09</option>' +
            '<option id="10" value="10">10</option>' +
            '<option id="11" value="11">11</option>' +
            '<option id="12" value="12">12</option>' +
            '<option id="13" value="13">13</option>' +
            '<option id="14" value="14">14</option>' +
            '<option id="15" value="15">15</option>' +
            '<option id="16" value="16">16</option>' +
            '<option id="17" value="17">17</option>' +
            '<option id="18" value="18">18</option>' +
            '<option id="19" value="19">19</option>' +
            '<option id="20" value="20">20</option>' +
            '<option id="21" value="21">21</option>' +
            '<option id="22" value="22">22</option>' +
            '<option id="23" value="23">23</option>' +
            '<option id="24" value="24">24</option>' +
            '<option id="25" value="25">25</option>' +
            '<option id="26" value="26">26</option>' +
            '<option id="27" value="27">27</option>' +
            '<option id="28" value="28">28</option>' +
            '<option id="29" value="29">29</option>' +
            '</select> ' +
            '</div> ' +
            '</div> ' +
            '<div class="col-md-4"> ' +
            '<div class="form-group"> ' +
            '<label class="control-label">অনাদায়ে কারাদণ্ড </label> ' +
            '<input type="text" id="rep_warrent_duration" ' +
            'name="rep_warrent_duration" class="input form-control" ' +
            'readonly="readonly"/> ' +
            '</div> ' +
            '</div> ' +
            '</div> ' +
            '<div class="row"> ' +
            '<div class="col-md-4"> ' +
            '<div class="form-group"> ' +
            '<label class="control-label">রশিদ নম্বর (যদি থাকে)</label> ' +
            '</div> ' +
            '</div> ' +
            '<div class="col-md-4"> ' +
            '<div class="form-group"> ' +
            '<input onchange="ordersheetForm.convertRoshidNoToBangla()" type="text" id="receipt_no" name="receipt_no" ' +
            'class="input form-control"  " /> ' +
            '</div> ' +
            '</div> ' +
            '</div> ';

        div.append(rowTemplate);
        $("#nooflaw").val(law_modal_no);
        ordersheetForm.clearLawModalForm(law_modal_no);
        $('#punishment_suo').modal('show');

        for(var i=1;i<=law_modal.length;i++){
            ordersheetForm.showJailType(i);
        }
        ordersheetForm.numOfLaw=0;
        ordersheetForm.numOfLaw=law_modal.length;

        document.getElementById('jail_details').style.display = 'none';
        $('#jail_id').removeClass("required");

    },

    //To clear Law Modal
    clearLawModalForm: function (nolaw) {
        for (var i = 0; i < nolaw; i++) {
            $("rep_warrent_month_" + i).val("");
            $("rep_warrent_day_" + i).val("");
            $("law_order_" + i + "_fine_in_word").val("");
            $("warrent_day_" + i).val("");
            $("warrent_month_" + i).val("");
            $("warrent_year_" + i).val("");
            $("receipt_no_" + i).val("");
        }
        receipt_no_global = '';

    },

    showDuration: function (law_number, select) {

        var order_str = ["", "", ""];
        var warrent_str = ["", "", ""];
        var duration = "#law_order_" + law_number + "_warrent_duration";
        var order_details = document.getElementById("law_order_" + law_number + "_order_detail");

        var year = document.getElementById("warrent_year_" + law_number);
        var selectedValueYear = year.options[year.selectedIndex].value;

        var month = document.getElementById("warrent_month_" + law_number);
        var selectedValueMonth = month.options[month.selectedIndex].value;

        var day = document.getElementById("warrent_day_" + law_number);
        var selectedValueDay = day.options[day.selectedIndex].value;

        var war_year = "warrent_year_" + law_number;
        var war_month = "warrent_month_" + law_number;
        var war_day = "warrent_day_" + law_number;

        var m = document.getElementById(war_month).selectedIndex;
        var d = document.getElementById(war_day).selectedIndex;

        if ((m > 0) || (d > 0)) {
            if (selectedValueYear == "02") {
                $(duration).val("");
                $(order_details).val("");
                document.getElementById(war_month).selectedIndex = "0";
                document.getElementById(war_day).selectedIndex = "0";
                warrent_str[0] = selectedValueYear + " বছর ";
               
                alert('সর্বোচ্চ দুই বছর নির্বাচন করা যাবে।', 'সর্তকিকরন ম্যাসেজ');
                return false;
            }
        }

        if (select == "00") {
            $(duration).val("");
            $(order_details).val("");
            document.getElementById(war_year).selectedIndex = "0";
            document.getElementById(war_month).selectedIndex = "0";
            document.getElementById(war_day).selectedIndex = "0";
            if(!$('#rep_warrent_duration').val()){
                document.getElementById('jail_details').style.display = 'none';
            }
            $('#jail_id').removeClass("required");
            return
        }


        if (selectedValueYear != "00") {
            warrent_str[0] = bangla.toBangla(selectedValueYear) + " বছর ";
        } else {
            warrent_str[0] = "";
        }
        if (selectedValueMonth != "00") {
            warrent_str[1] = bangla.toBangla(selectedValueMonth) + " মাস ";
        } else {
            warrent_str[1] = "";
        }
        if (selectedValueDay != "00") {
            warrent_str[2] = bangla.toBangla(selectedValueDay) + " দিন ";
        } else {
            warrent_str[2] = "";
        }

        var duration_str = warrent_str[0] + warrent_str[1] + warrent_str[2];

        order_str[0] = duration_str + ordersheetForm.jail_type;
        order_str[1] = document.getElementById("law_order_" + law_number + "_fine_in_word").value;
        //order_str[2] = document.getElementById("rep_warrent_duration").value;

        $(duration).val(order_str[0]);
        $(order_details).val(order_str[0] + "  " + order_str[1]);

        if (duration_str.length > 0) {
            document.getElementById('jail_details').style.display = 'block';
            $('#jail_id').addClass("required");
        } else {
            document.getElementById('jail_details').style.display = 'none';
            $('#jail_id').removeClass("required");
        }

        return true;
    },

    convertRoshidNoToBangla: function () {
        $('#jail_id').val('').trigger('change');
        $('#jail_id').removeClass("required");
        var roshidNo = $("#receipt_no").val();
        var ValidationExpression = "^[0-9]*(০|১|২|৩|৪|৫|৬|৭|৮|৯|)*$";

        if (roshidNo.match(ValidationExpression)) {
            $("#receipt_no").val(ordersheetForm.en_to_ben_number_conversion(roshidNo));
        }
        else {
            $("#receipt_no").val("");

            alert(' রশিদ  নম্বর শুধুমাত্র সংখ্যায় হবে!', 'সর্তকিকরন ম্যাসেজ');
        }
    },

    convertNumberToWords: function (amount) {
        var Words = ['', 'এক', 'দুই', 'তিন', 'চার', 'পাঁচ', 'ছয়', 'সাত', 'আট', 'নয়', 'দশ',
            'এগার', 'বার', 'তের', 'চৌদ্দ', 'পনের', 'ষোল', 'সতের', 'আঠার', 'ঊনিশ', 'বিশ',
            'একুশ', 'বাইশ', 'তেইশ', 'চব্বিশ', 'পঁচিশ', 'ছাব্বিশ', 'সাতাশ', 'আঠাশ', 'ঊনত্রিশ', 'ত্রিশ',
            'একত্রিশ', 'বত্রিশ', 'তেত্রিশ', 'চৌত্রিশ', 'পঁয়ত্রিশ', 'ছত্রিশ', 'সাঁইত্রিশ', 'আটত্রিশ', 'ঊনচল্লিশ', 'চল্লিশ',
            'একচল্লিশ', 'বিয়াল্লিশ', 'তেতাল্লিশ', 'চুয়াল্লিশ', 'পঁয়তাল্লিশ', 'ছেচল্লিশ', 'সাতচল্লিশ', 'আটচল্লিশ', 'ঊনপঞ্চাশ', 'পঞ্চাশ',
            'একান্ন', 'বায়ান্ন', 'তিপ্পান্ন', 'চুয়ান্ন', 'পঞ্চান্ন', 'ছাপ্পান্ন', 'সাতান্ন', 'আটান্ন', 'ঊনষাট', 'ষাট',
            'একষট্টি', 'বাষট্টি', 'তেষট্টি', 'চৌষট্টি', 'পঁয়ষট্টি', 'ছেষট্টি', 'সাতষট্টি', 'আটষট্টি', 'ঊনসত্তর', 'সত্তর',
            'একাতর', 'বাহাত্তর', 'তিয়াত্তর', 'চুয়াত্তর', 'পঁচাত্তর', 'ছিয়াত্তর', 'সাতাত্তর', 'আটাত্তর', 'ঊনআশি', 'আশি',
            'একাশি', 'বিরাশি', 'তিরাশি', 'চুরাশি', 'পঁচাশি', 'ছিয়াশি', 'সাতাশি', 'আটাশি', 'ঊননব্বই', 'নব্বই',
            'একানব্বই', 'বিরানব্বই', 'তিরানব্বই', 'চুরানব্বই', 'পঁচানব্বই', 'ছিয়ানব্বই', 'সাতানব্বই', 'আটানব্বই', 'নিরানব্বই'];

        amount = amount.toString();
        var atemp = amount.split(".");
        var before_word = "";
        var after_word = "";
        var before_number = atemp[0];
        if(before_number !== "0") {
            before_word = ordersheetForm.toWord(before_number, Words);
        }
        if(atemp.length === 2) {
            var after_number = atemp[1];
            after_word = ordersheetForm.toWord(after_number, Words);
            if(before_word !== "") {
                before_word += ' দশমিক '+ after_word;
            } else {
                before_word += 'দশমিক '+after_word;
            }
        }
        return before_word;
    },

    toWord: function(number, words) {
        var n_length = number.length;
        var words_string = "";

        if (n_length <= 9) {
            var n_array = new Array(0, 0, 0, 0, 0, 0, 0, 0, 0);
            var received_n_array = new Array();
            for (var i = 0; i < n_length; i++) {
                received_n_array[i] = number.substr(i, 1);
            }
            for (var i = 9 - n_length, j = 0; i < 9; i++, j++) {
                n_array[i] = received_n_array[j];
            }
            for (var i = 0, j = 1; i < 9; i++, j++) {
                if (i == 0 || i == 2 || i == 4 || i == 7) {
                    if (n_array[i] == 1) {
                        n_array[j] = 10 + parseInt(n_array[j]);
                        n_array[i] = 0;
                    } else if(n_array[i] == 2) {
                        n_array[j] = 20 + parseInt(n_array[j]);
                        n_array[i] = 0;
                    } else if(n_array[i] == 3) {
                        n_array[j] = 30 + parseInt(n_array[j]);
                        n_array[i] = 0;
                    } else if(n_array[i] == 4) {
                        n_array[j] = 40 + parseInt(n_array[j]);
                        n_array[i] = 0;
                    } else if(n_array[i] == 5) {
                        n_array[j] = 50 + parseInt(n_array[j]);
                        n_array[i] = 0;
                    } else if(n_array[i] == 6) {
                        n_array[j] = 60 + parseInt(n_array[j]);
                        n_array[i] = 0;
                    } else if(n_array[i] == 7) {
                        n_array[j] = 70 + parseInt(n_array[j]);
                        n_array[i] = 0;
                    } else if(n_array[i] == 8) {
                        n_array[j] = 80 + parseInt(n_array[j]);
                        n_array[i] = 0;
                    } else if(n_array[i] == 9) {
                        n_array[j] = 90 + parseInt(n_array[j]);
                        n_array[i] = 0;
                    }
                }
            }

            var value = "";
            for (var i = 0; i < 9; i++) {
                value = n_array[i];
                if (value != 0) {
                    words_string += words[value] + "";
                }
                if ((i == 1 && value != 0) || (i == 0 && value != 0 && n_array[i + 1] == 0)) {
                    words_string += " কোটি ";
                }
                if ((i == 3 && value != 0) || (i == 2 && value != 0 && n_array[i + 1] == 0)) {
                    words_string += " লাখ ";
                }
                if ((i == 5 && value != 0) || (i == 4 && value != 0 && n_array[i + 1] == 0)) {
                    words_string += " হাজার ";
                } else if (i == 6 && value != 0) {
                    words_string += "শ ";
                }
            }

            words_string = words_string.split("  ").join(" ");

        }
        return words_string;
    },


    showFine: function (law_number, select) {

        var order_str = ["", "", ""];
        var fine_in_word = "#law_order_" + law_number + "_fine_in_word";
        var fine = $("#law_order_" + law_number + "_fine");
        var order_details = $("#law_order_" + law_number + "_order_detail");
        var finevalue = fine.val();
        var ValidationExpression = "^[0-9]*(০|১|২|৩|৪|৫|৬|৭|৮|৯|)*$";
        if (finevalue.match(ValidationExpression)) {
            $(fine).val(ordersheetForm.ben_to_en_number_conversion(finevalue));
            var ToWordValue = ordersheetForm.convertNumberToWords($(fine).val());
            if (select == "") {
                order_str[1] = "";
                $(fine_in_word).val("");
                $(order_details).val(order_str[0] + order_str[1] + order_str[2]);
                return
            } else {

            }


            order_str[0] = $("#law_order_" + law_number + "_warrent_duration").val();
            //order_str[2] = $("#rep_warrent_duration").val();
            if (order_str[0] == "") {
                order_str[1] = " " + bangla.toBangla($(fine).val()) + " ("+ToWordValue+") টাকা অর্থদণ্ড ";
            } else {
                order_str[1] = "  এবং  " + bangla.toBangla($(fine).val()) + " ("+ToWordValue+") টাকা অর্থদণ্ড ";
            }


            $(fine_in_word).val(order_str[1]);
            $(order_details).val(order_str[0] + "  " + order_str[1]);
        }
        else {
            $(fine).val("");
            $(fine_in_word).val("");
            $(order_details).val("");

            alert('অর্থদণ্ড শুধুমাত্র সংখ্যায় হবে!', 'সর্তকিকরন ম্যাসেজ');
        }


        //    fine_global
//    if(order_str[1] !='' ){
//        fine_global = true ;
//    }


    },

    showJailType: function (law_number) {
        var radioArray = document.getElementsByName("law_oreder[" + law_number + "][warrent_type]");
        var value = "";


        for (i = 0; i < radioArray.length; i++) {
            if (radioArray[i].checked) {
                value = radioArray[i].value;
                break
            }
        }

        if (value == 1) {
            ordersheetForm.jail_type = "সশ্রম  কারাদণ্ড";
        } else {
            ordersheetForm.jail_type = "বিনাশ্রম  কারাদণ্ড";
        }
        $("#warrent_year_"+law_number).val("00");
        $("#warrent_month_"+law_number).val("00");
        $("#warrent_day_"+law_number).val("00");


        $("#rep_warrent_month").val("00");
        $("#rep_warrent_day").val("00");
        var duration = "#law_order_" + law_number + "_warrent_duration";
        var rep_duration = "#rep_warrent_duration";
        var order_details = document.getElementById("law_order_" + law_number + "_order_detail");
        $(duration).val("");
        $(rep_duration).val("");
        $(order_details).val("");

    },

    showRepDuration: function (law_number, select) {

        var order_str = ["", "", ""];
        var warrent_str = ["", ""];

        var selectedValueMonth = "";
        var selectedValueDay = "";

        var duration = "#rep_warrent_duration";
        var isJailWarent=ordersheetForm.isJailDurationSelected();
    //    var order_details = document.getElementById("law_order_" + law_number + "_order_detail");
        //var draft_order_details = document.getElementById("law_order_" + law_number + "_draft_order_detail");

        var receipt_no = document.getElementById("receipt_no");

        if (select == '') {
            $(duration).val("");
       //     $(order_details).val("");
            $(receipt_no).val(receipt_no_global);
            if(isJailWarent=='false'){
                document.getElementById('jail_details').style.display = 'none';
            }
            return
        }

        var month = document.getElementById("rep_warrent_month").value;
        if (month) {
            selectedValueMonth = $('#rep_warrent_month').val();
            // $(receipt_no).val("");
        }

        var day = document.getElementById("rep_warrent_day").value;
        if (day) {
            selectedValueDay = $('#rep_warrent_day').val();;
            //   $(receipt_no).val("");
        }

        var month = document.getElementById("rep_warrent_month");
       // selectedValueMonth = $('#rep_warrent_month').val();

        var war_month = "rep_warrent_month";
        var war_day = "rep_warrent_day";

        var m = document.getElementById(war_month).value;
        var d = document.getElementById(war_day).value;

        if (d > 0) {
            if (selectedValueMonth == "03") {
                $(duration).val("");
    //            $(order_details).val("");
                document.getElementById(war_day).selectedIndex = "0";

                alert('সর্বোচ্চ  তিন মাস   নির্বাচন করা যাবে।', 'সর্তকিকরন ম্যাসেজ');
                return false;
            }
        }

        if (select == "00") {
            $(duration).val("");
         //   $(order_details).val("");
            document.getElementById(war_month).selectedIndex = "0";
            document.getElementById(war_day).selectedIndex = "0";
            if(isJailWarent=='false'){
                document.getElementById('jail_details').style.display = 'none';
                $('#jail_id').removeClass("required");

            }

            return
        }

        if (select == "03" && selectedValueMonth == "03") {

            order_str[0] = "";
            order_str[1] = "";
            order_str[2] = "";
            warrent_str[0] = "";
            warrent_str[1] = "";
            warrent_str[2] = "";
            $(duration).val("");
           // $(order_details).val("");
            selectedValueDay = "";
            $("#rep_warrent_day").val("00");

        } else {
        }


        var m_str = selectedValueMonth ? " মাস " : "";
        var d_str = selectedValueDay ? " দিন " : "";

        var duration_str = bangla.toBangla(selectedValueMonth) + m_str + bangla.toBangla(selectedValueDay) + d_str;

       // order_str[0] = document.getElementById("law_order_" + law_number + "_warrent_duration").value;
       // order_str[1] = document.getElementById("law_order_" + law_number + "_fine_in_word").value;
        order_str[2] = duration_str + "বিনাশ্রম  কারাদণ্ড";

        $(duration).val(order_str[2]);
       // $(order_details).val(order_str[0] + order_str[1] + " অনাদায়ে " + order_str[2]);


        if (duration_str.length > 0) {
            document.getElementById('jail_details').style.display = 'block';
        }
        // } else {
        //     document.getElementById('jail_details').style.display = 'none';
        // }


    },

    ben_to_en_number_conversion: function (ben_number) {
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
    },
    en_to_ben_number_conversion: function (ben_number) {
        var eng_number = '';
        for (var i = 0; i < ben_number.length; i++) {
            if (ben_number[i] == "০" || ben_number[i] == "0") eng_number = eng_number + '০';
            if (ben_number[i] == "১" || ben_number[i] == "1") eng_number = eng_number + '১';
            if (ben_number[i] == "২" || ben_number[i] == "2") eng_number = eng_number + '২';
            if (ben_number[i] == "৩" || ben_number[i] == "3") eng_number = eng_number + '৩';
            if (ben_number[i] == "৪" || ben_number[i] == "4") eng_number = eng_number + '৪';
            if (ben_number[i] == "৫" || ben_number[i] == "5") eng_number = eng_number + '৫';
            if (ben_number[i] == "৬" || ben_number[i] == "6") eng_number = eng_number + '৬';
            if (ben_number[i] == "৭" || ben_number[i] == "7") eng_number = eng_number + '৭';
            if (ben_number[i] == "৮" || ben_number[i] == "8") eng_number = eng_number + '৮';
            if (ben_number[i] == "৯" || ben_number[i] == "9") eng_number = eng_number + '৯';
        }
        return eng_number;
    },

    savePunishmentForm: function (){

        if(!validator.validateFields("#saveOrderBylawform_suo")){
           
            alert("সকল তথ্য পূরণ হয়নি। ","অবহতিকরণ বার্তা");
            return false;
        }

        // var formURL =   "/mobile-court/prosecution/saveOrderBylaw";
        // var data = ordersheetForm.populatePunishmentModel();
        // $.ajax({
        //     url: formURL,
        //     type: 'POST',
        //     dataType: 'json',
        //     data: {'data': data.punishment},
        //     mimeType: "multipart/form-data",
        //     success: function (response, textStatus, jqXHR) {
        //         if (response.flag == 'true') {
        //             if(!response.msgExistOrder){
                        
        //                 alert("শাস্তি প্রদান করা হয়েছে", "অবহতিকরণ বার্তা");
        //             }else {
                       
        //                 alert(response.msgExistOrder, "অবহতিকরণ বার্তা");
        //             }
        //             $('#punishment_suo').modal('hide');
        //             ordersheetForm.getOrderListByProsecutionId();
        //         } else {
                    
        //             alert("তথ্য অসম্পূর্ন থাকায়  শাস্তি গ্রহণ করা হয়নি ।  পূনরায় চেষ্টা করুন ।  ", "ধন্যবাদ");
        //         }
        //     },
        //     error: function (jqXHR, textStatus, errorThrown) {
                
        //         alert(" ত্রুটি। ", "অবহতিকরণ বার্তা");
        //     }
        // });

        var formURL =   "/prosecution/saveOrderBylaw";
        var data = ordersheetForm.populatePunishmentModel();
        Swal.fire({
            title: "",
            text: "ফরমটি সংরক্ষণ করতে চান ?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            cancelButtonText: "না",
            confirmButtonText: "হ্যাঁ"
        }).then((result) => {
              $.ajax({
                    url: formURL,
                    type: 'POST',
                    dataType: 'json',
                    data: {'data': data.punishment},
                    mimeType: "multipart/form-data",
                  beforeSend:function(){
                  },
                  success: function(response, textStatus, jqXHR)
                  {
                    if (response.flag == 'true') {
                        if(!response.msgExistOrder){
                            
                            // alert("শাস্তি প্রদান করা হয়েছে", "অবহতিকরণ বার্তা");
                            Swal.fire({
                                title: "অবহতিকরণ বার্তা",
                                text: 'শাস্তি প্রদান করা হয়েছে',
                                icon: "success"
                            });
                        }else {
                           
                            // alert(response.msgExistOrder, "অবহতিকরণ বার্তা");
                            Swal.fire({
                                title: "অবহতিকরণ বার্তা",
                                text: response.msgExistOrder,
                                icon: "success"
                            });
                        }
                        $('#punishment_suo').modal('hide');
                        ordersheetForm.getOrderListByProsecutionId();
                    } else {
                        
                        Swal.fire({
                            title: "ধন্যবাদ",
                            text: "তথ্য অসম্পূর্ন থাকায়  শাস্তি গ্রহণ করা হয়নি ।  পূনরায় চেষ্টা করুন ।  ",
                            icon: "success"
                        });
                        // alert("তথ্য অসম্পূর্ন থাকায়  শাস্তি গ্রহণ করা হয়নি ।  পূনরায় চেষ্টা করুন ।  ", "ধন্যবাদ");
                    }
                  },
                  error: function(jqXHR, textStatus, errorThrown)
                  {
                    //   alert("অভিযোগ গঠন সম্পন্ন হয়নি ।  পূনরায় চেষ্টা করুন ।  ", "অবহতিকরণ বার্তা");
                    Swal.fire({
                        title: "অবহতিকরণ বার্তা",
                        text: "পূনরায় চেষ্টা করুন ।  ",
                        icon: "success"
                    });
                  }
              });
    
         });


    },
    saveRegularCaseForm: function () {
        if(!validator.validateFields("#saveRegularCaseForm")){
            
            // alert("সকল তথ্য পূরণ হয়নি। ","অবহতিকরণ বার্তা");
            Swal.fire({
                title: "অবহতিকরণ বার্তা",
                text: 'সকল তথ্য পূরণ হয়নি।',
                icon: "error"
            });
            return false;
        }

        var formURL =  "/prosecution/saveOrderBylaw";
        var data = ordersheetForm.populateRegularCaseInfoModel();
        $.ajax({
            url: formURL,
            type: 'POST',
            dataType: 'json',
            data: {'data': data.punishment},
            mimeType: "multipart/form-data",
            success: function (response, textStatus, jqXHR) {
                if (response.flag == 'true') {
                    if(!response.msgExistOrder){
                        // alert(" নিয়মিত মামলা দায়ের করা হয়েছে ", "অবহতিকরণ বার্তা");
                        Swal.fire({
                            title: "অবহতিকরণ বার্তা",
                            text: 'নিয়মিত মামলা দায়ের করা হয়েছে।',
                            icon: "success"
                        });
                        
                    }else {
                        // alert(response.msgExistOrder, "অবহতিকরণ বার্তা");
                        Swal.fire({
                            title: "অবহতিকরণ বার্তা",
                            text: response.msgExistOrder,
                            icon: "error"
                        });
                    }
                    $('#regularcase_modal').modal('hide');
                    ordersheetForm.getOrderListByProsecutionId();
                } else {
                //    alert("তথ্য অসম্পূর্ন থাকায়  শাস্তি গ্রহণ করা হয়নি ।  পূনরায় চেষ্টা করুন ।  ", "ধন্যবাদ");
              

                   Swal.fire({
                    title: "ধন্যবাদ",
                    text: '"তথ্য অসম্পূর্ন থাকায়  শাস্তি গ্রহণ করা হয়নি ।  পূনরায় চেষ্টা করুন । ',
                    icon: "error"
                });
              
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // alert(" ত্রুটি। ", "অবহতিকরণ বার্তা");

                Swal.fire({
                    title: "অবহতিকরণ বার্তা",
                    text: "পূনরায় চেষ্টা করুন । ",
                    icon: "error"
                });
            }
        });


    },
    isOrderExistForCriminalAgainstLaw:function(orderFlag,lawIdStr){
        var formURL =  "/punishment/isPunishmentExist";
        var data = ordersheetForm.populateOrderCheckModel();

        $.ajax({
            url: formURL,
            type: 'POST',
            dataType: 'json',
            data: {'data': data.punishment},
            mimeType: "multipart/form-data",
            success: function (response, textStatus, jqXHR) {
                if (response.flag == 'true') {
                    if(response.msgExistOrder){
                        //  alert(response.msgExistOrder, "অবহতিকরণ বার্তা");
                         Swal.fire({
                            title: "অবহতিকরণ বার্তা",
                            text: response.msgExistOrder,
                            icon: "error"
                        });
                    }
                } else {
                    if (orderFlag == 1) {
                        ordersheetForm.setPunishmentTemplete(lawIdStr);
                    }
                    else if (orderFlag == 2) {
                        //ordersheetForm.setGlobalSendToOrderText(cdiminal_ids_str,lawIdStr);
                        ordersheetForm.setRegularCaseTemplate(lawIdStr);
                    }else {
                        ordersheetForm.saveReleaseForm();
                    }
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // alert(" ত্রুটি। ", "অবহতিকরণ বার্তা");

                Swal.fire({
                    title: "অবহতিকরণ বার্তা",
                    text: 'পূনরায় চেষ্টা করুন । ',
                    icon: "error"
                });




            }
        });

    },
    saveReleaseForm: function () {
        var formURL = "/prosecution/saveOrderBylaw";
        var data = ordersheetForm.populateReleaseInfoModel();

        $.ajax({
            url: formURL,
            type: 'POST',
            dataType: 'json',
            data: {'data': data.punishment},
            mimeType: "multipart/form-data",
            success: function (response, textStatus, jqXHR) {
                if (response.flag == 'true') {
                    if(!response.msgExistOrder){
                        //  alert(" অব্যাহতি প্রদান করা হয়েছে ", "অবহতিকরণ বার্তা");
                         Swal.fire({
                            title: "অবহতিকরণ বার্তা",
                            text: 'অব্যাহতি প্রদান করা হয়েছে  । ',
                            icon: "success"
                        });
        
                    }else {
                        //  alert(response.msgExistOrder, "অবহতিকরণ বার্তা");
                         Swal.fire({
                            title: "অবহতিকরণ বার্তা",
                            text: response.msgExistOrder,
                            icon: "error"
                        });
                    }
                    ordersheetForm.getOrderListByProsecutionId();
                } else {
                    //  alert("তথ্য অসম্পূর্ন থাকায়  শাস্তি গ্রহণ করা হয়নি ।  পূনরায় চেষ্টা করুন ।  ", "ধন্যবাদ");
             
                     Swal.fire({
                        title: "ধন্যবাদ",
                        text: 'তথ্য অসম্পূর্ন থাকায়  শাস্তি গ্রহণ করা হয়নি ।  পূনরায় চেষ্টা করুন ।  ',
                        icon: "error"
                    });
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                //  alert(" ত্রুটি। ", "অবহতিকরণ বার্তা");
                 Swal.fire({
                    title: "ধন্যবাদ",
                    text: 'পূনরায় চেষ্টা করুন ।  ',
                    icon: "error"
                });
            }
        });
    },

    populateOrderCheckModel:function () {
        var model = {};
        model.punishment = [];
        var prosecutionID = $('#txtProsecutionID').val();

        var cdiminal_ids_array = ordersheetForm.getSelectedChkboxCriminal();
        var lawIdStr = ordersheetForm.getSelectedChkboxLaw();

        for(var i=0;i<cdiminal_ids_array.length;i++){
            for(var j=1;j<=lawIdStr.length;j++) {
                model.punishment.push(ordersheetForm.getReleaseInfo(j, cdiminal_ids_array[i].id,lawIdStr[j-1].LawsBrokenID,prosecutionID));
            }
        }
        return model;
    },
    populateReleaseInfoModel: function () {

        var model = {};
        model.punishment = [];
        var prosecutionID = $('#txtProsecutionID').val();

        var cdiminal_ids_array = ordersheetForm.getSelectedChkboxCriminal();
        var lawIdStr = ordersheetForm.getSelectedChkboxLaw();

        for(var i=0;i<cdiminal_ids_array.length;i++){
            for(var j=1;j<=lawIdStr.length;j++) {
                model.punishment.push(ordersheetForm.getReleaseInfo(j, cdiminal_ids_array[i].id,lawIdStr[j-1].LawsBrokenID,prosecutionID));
            }
        }
        return model;
    },
    populateRegularCaseInfoModel: function () {

        var model = {};
        model.punishment = [];
        var prosecutionID = $('#txtProsecutionID').val();

        var cdiminal_ids_array = ordersheetForm.getSelectedChkboxCriminal();
        var lawIdStr = ordersheetForm.getSelectedChkboxLaw();

        for(var i=0;i<cdiminal_ids_array.length;i++){
            for(var j=1;j<=lawIdStr.length;j++) {
                model.punishment.push(ordersheetForm.getRegularCaseInfo(j, cdiminal_ids_array[i].id,prosecutionID));
            }
        }
        return model;
    },
    populatePunishmentModel: function () {

        var model = {};
        model.punishment = [];
        var prosecutionID = $('#txtProsecutionID').val();

        var cdiminal_ids_array = ordersheetForm.getSelectedChkboxCriminal();
        var lawIdStr = ordersheetForm.getSelectedChkboxLaw();

        for(var i=0;i<cdiminal_ids_array.length;i++){
            for(var j=1;j<=lawIdStr.length;j++) {
                model.punishment.push(ordersheetForm.getPunishmentInfo(j, cdiminal_ids_array[i].id,prosecutionID));
            }
        }
        return model;
    },

    getPunishmentInfo: function (index, criminalId, prosecutionId) {
        var punishmentInfo = {};
        punishmentInfo.punishment_type = 'PUNISHMENT';
        punishmentInfo.prosecution_id = prosecutionId;
        punishmentInfo.laws_broken_id = $('#lawsBrokenID_' + index).val();
        punishmentInfo.criminal_id = criminalId;
        //punishmentInfo.orderJustificationText = $('#law_order_' + index + 'draft_order_detail').val();
        punishmentInfo.order_detail = $('#law_order_' + index + '_order_detail').val();

        punishmentInfo.fine_in_word = $('#law_order_' + index + '_fine_in_word').val();
        punishmentInfo.fine = $('#law_order_' + index + '_fine').val();
        punishmentInfo.warrent_duration = $('#law_order_' + index + '_warrent_duration').val();
        punishmentInfo.warrent_detail = $('#warrent_year_' + index).val() + '-' + $('#warrent_month_' + index).val()+'-'+ $('#warrent_day_' + index).val(); // need Calculation


        var warent_type = $('input[name="law_oreder['+index+'][warrent_type]"]:checked').val();
        if(warent_type == 2){
            var warent_type_text = 'বিনাশ্রম';
        }else if(warent_type == 1){
            var warent_type_text = 'সশ্রম';
        };
        punishmentInfo.warrent_type = warent_type;
        punishmentInfo.warrent_type_text = warent_type_text;

        punishmentInfo.rep_warrent_duration = $('#rep_warrent_duration').val();
        punishmentInfo.rep_warrent_detail = $('#rep_warrent_month').val() + '-' + $('#rep_warrent_day').val(); // need Calculation
        punishmentInfo.rep_warrent_type = 2;
        punishmentInfo.rep_warrent_type_text = 'বিনাশ্রম';

        punishmentInfo.receipt_no = $('#receipt_no').val();

        /*
        if warrent_duration and rep_warrent_duration ==null or empty then jail id and jail name also be empty
         */
        if((punishmentInfo.warrent_duration != null && punishmentInfo.warrent_duration != '')
            || (punishmentInfo.rep_warrent_duration !=null && punishmentInfo.rep_warrent_duration != '')){
            punishmentInfo.punishmentJailID = $('#jail_id').val();
            punishmentInfo.punishmentJailName = $("#jail_id>option:selected").html(); // need calculation
        }else {
            punishmentInfo.punishmentJailID = null;
            punishmentInfo.punishmentJailName = '';
        }

        punishmentInfo.exe_jail_type = $('.exe_jail_type').val();

        return punishmentInfo;
    },
    getCriminalLawInfoFromUI:function (index, criminalId,lawBrokenId, prosecutionId) {
        var Info = {};
        Info.prosecution_id = prosecutionId;
        Info.laws_broken_id =lawBrokenId ;
        Info.criminal_id = criminalId;
        //releaseInfo.order_detail = $('#release_case_order_detail').val();

        return Info;
    },
    getReleaseInfo: function (index, criminalId,lawBrokenId, prosecutionId) {

        var releaseInfo = {};
        releaseInfo.punishment_type = 'RELEASE';
        releaseInfo.prosecution_id = prosecutionId;
        releaseInfo.laws_broken_id =lawBrokenId ;
        releaseInfo.criminal_id = criminalId;
        //releaseInfo.order_detail = $('#release_case_order_detail').val();

        return releaseInfo;
    },
    getRegularCaseInfo: function (index, criminalId, prosecutionId) {
        var regularCaseInfo = {};
        regularCaseInfo.punishment_type = 'REGULARCASE';
        regularCaseInfo.prosecution_id = prosecutionId;
        regularCaseInfo.laws_broken_id = $('#lawsBrokenID_' + index).val();
        regularCaseInfo.criminal_id = criminalId;
        //regularCaseInfo.order_detail = $('#regular_case_order_detail').val();

        var regular_case_type_name = $('input[name="law_order_send_to"]:checked').val();
        if(regular_case_type_name == 'THANA'){
            regularCaseInfo.responsibleThanaID = $('#thanaList').val();
            regularCaseInfo.responsibleDepartmentName = $("#thanaList>option:selected").html();
        }else if(regular_case_type_name == 'HIGHCOURT'){
            regularCaseInfo.responsibleDepartmentName = $('#regular_case_responsible_name').val();
        };

        regularCaseInfo.regular_case_type_name = regular_case_type_name;
        regularCaseInfo.responsibleAdalotAddress = $('#responsible_address').val();

        return regularCaseInfo;
    },

    populateDropDownOrNameField:function (radioButtonValue) {

        $('#resposibleSection').empty();
        var template='';
        if(radioButtonValue=='THANA'){
            var URL =  "/geo_thanas/getThanaByUsersZillaId";
            $.ajax({ url: URL, type: 'POST', dataType: 'json',
                success: function (response) {
                    template=ordersheetForm.populateThanaDropDown(response);
                    $('#resposibleSection').append(template);

                    // //set regularCaseOrderSampleText to order text area field
                    // $('#regular_case_order_detail').val(ordersheetForm.sendToPoliceOrderText);

                },
                error: function () {
                     alert("ত্রুটি", "অবহতিকরণ বার্তা");
                }
            });
        }
        else {
            //set regularHighCourtOrderText sample text to order text area field
            // ordersheetForm.regularCaseSendToHighCourtOrderTextGeneration();
            template='<div class="form-group"> ' +
                '         <label class="control-label textmid">নাম </label>' +
                '                <textarea class="required" id="regular_case_responsible_name" name="law_order[0][regular_case_responsible_name]"' +
                '                 class="input form-control" cols="45" rows="2">চিফ জুডিশিয়াল ম্যাজিস্ট্রেট</textarea> ' +
                '      </div>';
            $('#resposibleSection').append(template);
        }

    },
    populateThanaDropDown:function (thanaList) {
        var template="";
        var selectOptions='';
        template='<div class="form-group"> ' +
            '         <label class="control-label textmid">থানা </label>' +
            '           <select class="thanaList required" id="thanaList" required="true">' ;


        selectOptions+='<option value="">' + 'বাছাই করুন...' + '</option>';
        // Check result isnt empty
        if(thanaList.length>0){
            for(var i=0;i<thanaList.length;i++){
                selectOptions+='<option value="' + thanaList[i].id + '">' + thanaList[i].name + '</option>';
            }
        }

        template+=selectOptions+ '</select></div> ';
        return template;

    },
    getOrderListByProsecutionId:function () {
        var parameter = {};
        parameter.prosecution_id=$('#txtProsecutionID').val();
        var formURL = "/mobile-court/punishment/getOrderListByProsecutionId";
        $.ajax({
            url: formURL,
            type: 'POST',
            dataType: 'json',
            data: {'data': parameter},
            mimeType: "multipart/form-data",
            success: function (response, textStatus, jqXHR) {
                if (response.flag == 'true') {
                    ordersheetForm.populateOrderList(response.punishmentList);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                 alert(" ত্রুটি। ", "অবহতিকরণ বার্তা");
            }
        });
    },
    populateOrderList:function (orderList) {

        
        $("#punishmentDetailList").empty();
        var totalNumOfOrder = orderList.length;
        var div = $("#punishmentDetailList");
        var rowTemplate = "";


        rowTemplate = '<div class="row">' +
            '<div class="col-md-12">' +
            '<div class="form-group">' +
            '<table class="table table-bordered table-striped" align="center" width="100%">' +
            '<thead>' +
            '<tr>' +
            '<th>ক্রম</th>' +
            '<th>আসামি</th>' +
            '<th>আইন ও ধারা</th>' +
            '<th>আদেশের ধরন</th>' +
            '<th>কার্যক্রম</th>' +
            '</tr>' +
            '</thead>' +
            '<tbody>';
        var temp = "";
        var orderTypeBng='';

        for (var i = 0; i < totalNumOfOrder; i++) {
            orderTypeBng=ordersheetForm.getBngOrderType(orderList[i].orderType);
            temp+='<tr>'+
                    '<td>' + (i+1) + '</td> ' +
                    '<td>' + orderList[i].criminalName + '</td> ' +
                    '<td>' + orderList[i].lawAndSection  + '</td> ' +
                    '<td>' + orderTypeBng  + '</td> ' +
                    '<td><a class="btn btn-danger btn-mideum" href="#" onclick="ordersheetForm.deleteOrderByOrderId('+orderList[i].orderId+'); return false"> বাতিল </a></td></tr> ' ;



        }
        rowTemplate += temp + '</tbody> ' +
            '</table> ' +
            '</div> ' +
            '</div> ' +
            '</div> ';
        div.append(rowTemplate);

    },
    getBngOrderType:function (orderType) {
        var orderTypeBng='';
        if(orderType=='PUNISHMENT'){
            orderTypeBng='শাস্তি';
        }else if(orderType=='REGULARCASE'){
            orderTypeBng='নিয়মিত মামলা'
        }else {
            orderTypeBng='অব্যাহতি';
        }
        return orderTypeBng;
    },

    deleteOrderByOrderId: function (orderId) {
        var prosecution_id = $('#txtProsecutionID').val();
        var formURL = "/mobile-court/punishment/deleteOrder";
        $.ajax({
            url: formURL,
            type: 'POST',
            dataType: 'json',
            data: {'orderId': orderId,'prosecutionId':prosecution_id},
            mimeType: "multipart/form-data",
            success: function (response, textStatus, jqXHR) {
                if (response.flag == 'true') {
                    $.alert(" অর্ডার টি বাতিল করা হয়েছে ", "অবহতিকরণ বার্তা");
                    ordersheetForm.getOrderListByProsecutionId();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(" ত্রুটি। ", "অবহতিকরণ বার্তা");
            }
        });
    },
    previewOrderSheet:function () {
        
        if(!validator.validateFields("#ordersheetformsuomoto")){
            return false;
        }
        var prosecutionID=$('#txtProsecutionID').val();
        var seizureInfoFilled = ordersheetForm.checkSeizureResponsibleInfo();
        var allCriminalPunished = ordersheetForm.isAllCriminalGetPunished(prosecutionID);

        if(seizureInfoFilled == true && allCriminalPunished==true){
            var model = ordersheetForm.populateJimmaderInfoModel();
            var formObj = $('#ordersheetformsuomoto');
            var formURL =  "/mobile-court/punishment/saveJimmaderInformation";
            var formData = new FormData(formObj[0]);
            formData.append( 'modelData', JSON.stringify(model));

            $.ajax({
                url: formURL,
                type: 'POST',
                data: formData,
                dataType: 'json',
                mimeType: "multipart/form-data",
                contentType: false,
                cache: false,
                processData: false,

                success: function (response, textStatus, jqXHR) {
                    if(response.flag=='true'){
                        window.location = '/mobile-court/punishment/previewOrderSheet?prosecutionId=' + prosecutionID;
                    }else {
                         alert(" ত্রুটি। ", "অবহতিকরণ বার্তা");
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(" ত্রুটি। ", "অবহতিকরণ বার্তা");
                }
            });

        }
    },
    checkSeizureResponsibleInfo:function () {
        if(!$('#is_sizurelist').hasClass('hidden')){
            var flag=false;
            if(complaintForm.seizureOrder){
                if($('#jimmader_name').val()!='' && $('#jimmader_custodian_name').val()!='' && $('#jimmader_details').val()!=''){
                    flag=true;
                }else {
                    
                    alert("জিম্মাদারের তথ্য দিন ", "অবহিতকরণ বার্তা");
                }
            }
            return flag;
        }else return true;

    },
    isAllCriminalGetPunished:function (prosecutionID) {
        var response = complaintForm.getCaseInfoDataByProsecution(prosecutionID);
        var flag=false;
        if(response.caseInfo.prosecution.hasCriminal > 0){
            var numberOfCriminal=response.caseInfo.criminalDetails.length;
            var numberOfLaw=response.lawsBroken.lawsBrokenList.length;
            var numOfPunishment=response.caseInfo.punishmentSelect.length;
            if(numberOfCriminal*numberOfLaw==numOfPunishment){
                flag=true;
            }else {

                alert("সকল আসামি কে শাস্তি প্রদান করা হয় নি ", "অবহিতকরণ বার্তা");
            }
        }else {
            flag=true;
        }
        return flag;
    },
    populateJimmaderInfoModel: function () {
        var model = [];
        model.push({
            'prosecutionid':$('#txtProsecutionID').val(),
            "jimmaderName": $('#jimmader_name').val(),
            "jimmaderDesignation": $('#jimmader_custodian_name').val(),
            "jimmaderLocation": $('#jimmader_details').val(),
            "seizure_order": $('#seizure_order').val()
        });
        return model;
    },
    isJailDurationSelected:function () {
        var flag='false';
        for(var i=1;i<=ordersheetForm.numOfLaw;i++){
            if($('#warrent_year_'+i).val()!='00' ||$('#warrent_month_'+i).val()!='00'||$('#warrent_day_'+i).val()!='00'){
                flag='true';
                break;
            }
        }
        return flag;
    }


};

$(document).ready(function () {
    ordersheetForm.init();
});


