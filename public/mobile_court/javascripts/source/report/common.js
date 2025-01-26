/**
 * Created by DOEL PC on 4/28/14.
 */



jQuery(document).ready(function () {

    function urlParam(name) {
        var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
        if (results==null){
            return null;
        }
        else{
            return decodeURI(results[1]) || 0;
        }
    }

    var checkout = $('#report_date').datepicker({
        format: "mm-yyyy",
        viewMode: "months",
        minViewMode: "months",
        changeMonth: true,
        changeYear: true
    }).on('changeDate',function (ev) {
        checkout.hide();

        if(urlParam('date')!=null){
            $('#report_date').val(urlParam('date'));
            $('#report_type_id').val(urlParam('report_type_id'));
        }

        var date = ''+$('#report_date').val();
        var report_type_id = $('#report_type_id').val();

        var url ="/monthly_report/getdata?date=" + date + "&report_type_id=" + report_type_id;
        $.ajax({
            url: url,
            type: 'POST',
            success: function (data) {

                // console.log(data);
                // return false;
                //promap upozila promap_achive_type
                if (data.length > 0) {
                    if (data[0].flag != "NO") {
                        if(report_type_id == 5 || report_type_id == 6){
                            if (data[0].flagCA =="yes"){
                                message_show("তথ্য অনুমোদিত ।  তথ্য পরিবর্তন করা যাবে না । ");
                                $("#reportdiv").fadeOut();
                            }else {
                                populateMonthlyReportData(data);
                            }
                        }else {
                            
                            if (data[0].flagCA=="yes"){
                                message_show("তথ্য অনুমোদিত ।  তথ্য পরিবর্তন করা যাবে না । ");
                            }else if(data[0].flagPA=="NO"){
                                message_show("পূর্ববর্তী মাসের তথ্য অনুমোদিত হয়নি।");
                            }else if(data[0].flagP=="NO"){
                                message_show("পূর্ববর্তী মাসের তথ্য নাই ।");
                            }else{
                                message_show("তথ্য এন্ট্রি/পরিবর্তন  করা যাবে না । ");
                            }
                            $("#reportdiv").fadeOut();
                        }

                    } else {
                        populateMonthlyReportData(data);

                    }

                    if( report_type_id == 2 || report_type_id == 3 || report_type_id == 4){
                        if (data[0].comment1 == "1") {
//                            alert(report_type_id  + "*******" + data[0].comment1 );
                            document.getElementById("promap_achive_text").innerHTML = "প্রমাপ অর্জিত হয়েছে";
                            $("#comment1").val("1");
                        } else {
                            document.getElementById("promap_achive_text").innerHTML = " প্রমাপ অর্জিত হয়নি";
                            $("#comment1").val("0");
                        }
                    }

                } else {
                    message_show("NO..........");
                    $("#reportdiv").fadeOut();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error", "অবহতিকরণ বার্তা");
            }
        });
    }).data('datepicker');

    if(urlParam('date')!=null){
        var element = document.getElementById('report_date');
        var event = new Event('changeDate');
        element.dispatchEvent(event);
    }

});

function populateMonthlyReportData(data) {
     
    $("#reportdiv").fadeIn();
    $('#id').val(data[0].id);
    $('#upozila').val(data[0].upozila);
    $('#promap').val(data[0].promap);
    $('#promap_achive').val(data[0].promap_achive);
    $('#pre_case_incomplete').val(data[0].pre_case_incomplete);
    $('#case_incomplete').val(data[0].case_incomplete);
    //                       $('#case_total').val(data[0].case_total);
    $('#case_complete').val(data[0].case_complete);
    $('#case_submit').val(data[0].case_submit);
    $('#case_above1year').val(data[0].case_above1year);
    $('#case_above2year').val(data[0].case_above2year);
    $('#case_above3year').val(data[0].case_above3year);
    $('#visit_promap').val(data[0].visit_promap);
    $('#caserecord_promap').val(data[0].caserecord_promap);
    $('#caserecord_count').val(data[0].caserecord_count);
    $('#comment2').val(data[0].comment2);
    if(data[0].comment_from_adm != null ){
        $('#adm_comment').removeClass("hidden");
        $('#comment_from_adm').html(data[0].comment_from_adm);
    }



    //$('#criminal_manual').val(data[0].criminal_manual);
    $('#criminal_system').val(data[0].criminal_system);
    //$('#criminal_total').val(data[0].criminal_total);
    // $('#lockup_criminal_manual').val(data[0].lockup_criminal_manual);
    $('#lockup_criminal_system').val(data[0].lockup_criminal_system);
    // $('#lockup_criminal_total').val(data[0].lockup_criminal_total);
    //$('#fine_manual').val(data[0].fine_manual);
    $('#fine_system').val(data[0].fine_system);
    //$('#fine_total').val(data[0].fine_total);
    $('#court_manual').val(data[0].court_manual);
    $('#court_system').val(data[0].court_system);
    $('#court_total').val(data[0].court_total);
    //$('#case_manual').val(data[0].case_manual);
    $('#case_system').val(data[0].case_system);

    //new added mobile court monthly report
    $('#case_total').val(data[0].case_total);
    $('#fine_total').val(data[0].fine_total);
    $('#criminal_total').val(data[0].criminal_total);
    $('#lockup_criminal_total').val(data[0].lockup_criminal_total);

    // courtvisitreport
    $('#visit_count').val(data[0].visit_count);

    //caseRecord report
    $('#caserecord_count').val(data[0].caserecord_count);
}

function onMouseOverAdmAppealReportSubmit(sel) {
    showTotalcase(sel);
    showTotalcompletecase(sel);

}

function checkOnlyNumber(value){
    var ValidationExpression = "^[0-9]*(০|১|২|৩|৪|৫|৬|৭|৮|৯|)*$";
    var flag=false;
    if (value.match(ValidationExpression)) {
        flag=true;
    }

    return flag;
}


function showTotalcase(sel) {

    var totalcase = "#case_total";

    var pre_case_incomplete = document.getElementById("pre_case_incomplete");
    var case_submit_new = document.getElementById("case_submit");

    var case_submitValue = case_submit_new.value;
    if(checkOnlyNumber(case_submitValue)){
        var case_submit = ben_to_en_number_conversion(case_submitValue);
        if(case_submit){
            var totalcase_str = parseInt(pre_case_incomplete.value) + parseInt(case_submit);
            $(totalcase).val(totalcase_str);
            $(case_submit_new).val(null);
            $(case_submit_new).val(case_submit);
        }

    }else{
        $(totalcase).val("");
        $(case_submit_new).val("");
        $.alert('শুধুমাত্র সংখ্যায় হবে!', 'সর্তকিকরন ম্যাসেজ');
    }

}

function setFocus(id) {
    document.getElementById(id).focus();
}

function showTotalcompletecase(sel) {
    var case_incomplete = "#case_incomplete";
    var case_total = document.getElementById("case_total");
    var case_complete_new = document.getElementById("case_complete");
    var pre_case_incomplete = document.getElementById("pre_case_incomplete");

    var case_completeValue = case_complete_new.value;
    if(checkOnlyNumber(case_completeValue)){
        var case_complete = ben_to_en_number_conversion(case_completeValue);
        $(case_complete_new).val(case_complete);


        if (parseInt(case_complete) > parseInt(case_total.value)) {
            message_show("নিষ্পত্তিকৃত মামলার সংখ্যা মোট মামলার সংখ্যার বেশী ।");
            $(case_complete_new).val("");
            return false;
        }

        var promap_achive = "#promap_achive";
        var promap = document.getElementById("promap");

        if(case_complete){
            $(case_incomplete).val(parseInt(case_total.value) - parseInt(case_complete));
            var jer_value = 0;
            if (pre_case_incomplete.value == 0) {
                jer_value = case_total.value;
            } else {
                jer_value = pre_case_incomplete.value;
            }

            var proAchive = Math.round((parseInt(case_complete) * 100) / parseInt(jer_value));
            $(promap_achive).val(proAchive);

            var is_achive = proAchive - promap.value;

            if (is_achive >= 0) {
                document.getElementById("promap_achive_text").innerHTML = "প্রমাপ অর্জিত হয়েছে";
                $("#comment1").val("1");
            } else {
                document.getElementById("promap_achive_text").innerHTML = " প্রমাপ অর্জিত হয়নি";
                $("#comment1").val("2");
            }
        }


    }else{
        $(case_incomplete).val("");
        $(case_complete_new).val("");
        $.alert('শুধুমাত্র সংখ্যায় হবে!', 'সর্তকিকরন ম্যাসেজ');
    }

    return true;

}

function ben_to_en_number_conversion(ben_number) {
    var eng_number = '';
    for (var i = 0; i < ben_number.length; i++)
    {   if (ben_number[i] == "০" || ben_number[i] == "0" ) eng_number = eng_number + '0';
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
// document.addEventListener('keypress', (event) => {
//     event.preventDefault();
// });

//Bind this keypress function to all of the input tags
$("input").keypress(function (evt) {
//Deterime where our character code is coming from within the event
    var charCode = evt.charCode || evt.keyCode;
    if (charCode  == 13) { //Enter key's keycode
        return false;
    }
});