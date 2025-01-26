base_path = "";
buttonpressed ="";
//if (window.location.host.localeCompare('ecourt.gov.bd') == 0) {
//
//    base_path = "";
//}

var criminal = new Array();

$(document).ready(function(){


    $('#proxyuser').click( function () {

        var select = proxyuserform.magistrate.options[proxyuserform.magistrate.options.selectedIndex].value

        if(select =='')
        {
            alert("please select magistrate name");
            return false;
        }
    });
});

function  myFunction(){
    var chart = new Highcharts.Chart({

        chart: {
            renderTo: 'container',
            type: 'scatter'
        },

        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },

        tooltip: {
            shared: false,
            useHTML: true,
            footerFormat: '</table> <span>"new text"</span>',
            valueDecimals: 2
        },

        plotOptions: {
            scatter: {
                tooltip: {
                    headerFormat: '<small>{point.key}</small><table>',
                    pointFormat: '<tr><td style="color: {series.color}">{series.name}: </td>' +
                    '<td style="text-align: right"><b>{point.y} EUR</b></td></tr>'
                }
            }
        },


        series: [{
            name: 'Short',
            data: [29.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]
        }, {
            name: 'Long named series',
            data: [129.9, 171.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 195.6, 154.4].reverse()
        }]

    });
}

function searchFlights() {
    var select1 = document.getElementById("office_id");
    var selected1 = [];
    for (var i = 0; i < select1.length; i++) {
        if (select1.options[i].selected) selected1.push(select1.options[i].value);
    }
}
function clearForm() {

    $('#name_bng').val("");
    $('#name_eng').val("");
    $('#mobile').val("");
    $('#email').val("");
    $('#file').val("");
    $('#citizen_address').val("");
    $('#subject').val("");
    $('#date').val("");
    $('#location').val("");
    $('#complain_details').val("");
    $('#authority_check').val("");
    $('#national_idno').val("");
    $('#division').val('0');
    $('#zilla').val('0');
    $('#upazila').val('0');

    $("#catrgory_id").dynatree("getTree").reload();
}

function authorityCheck(obj){

    if($('#authority_check').is(":checked"))
        $("#catrgory_id").fadeIn();
    else
        $("#catrgory_id").fadeOut();

}

function checkGlobal(obj)
{
    if($('#global_power').is(":checked"))
        $("#location").fadeOut();
    else

        $("#location").fadeIn();


}

function checkMagistrateType(obj){

    if($('#magistrate_type_id').is(":checked"))
        $("#organization").fadeIn();
    else
        $("#organization").fadeOut();


}

function checkComplain(obj){

    if($('#self_complain').is(":checked"))
        $("#location").fadeOut();
    else

        $("#location").fadeIn();

}

function zillainfo(){

    var zilla = $('#zilla').val() ;
    if (zilla=="")
    {
        $.alert(" জেলা নির্বাচন করুণ ।","অবহিতকরণ বার্তা");
        return false;
    }

}

function showmetropolotandiv(){
    var zilla = $('#zilla').val() ;
    if (zilla=="")
    {
        $.alert(" জেলা নির্বাচন করুন ।","অবহিতকরণ বার্তা");
        return false;
    }else{
        $('#upazila').val('');
        $('#GeoCityCorporations').val('');
        showMetropolitan(zilla,"GeoMetropolitan");
        $("#citycorporationdiv").fadeOut();
        $("#metropolitandiv").fadeIn();
        $("#upoziladiv").fadeOut();
        return true;
    }


}
function showcitycorporationdiv(){
    var zilla = $('#zilla').val() ;
    if (zilla=="")
    {
        $.alert(" জেলা নির্বাচন করুন ।","অবহিতকরণ বার্তা");
        return false;
    }else{
        $('#upazila').val('');
        $('#GeoMetropolitan').val('');
        $('#GeoThanas').val('');
        showCityCorporation(zilla,"GeoCityCorporations");
        $("#citycorporationdiv").fadeIn();
        $("#metropolitandiv").fadeOut();
        $("#upoziladiv").fadeOut();
        return true;
    }

}
function showupozilladiv(){

    var zilla = $('#zilla').val() ;
    if (zilla=="")
    {
        $.alert(" জেলা নির্বাচন করুন ।","অবহিতকরণ বার্তা");
        return false;
    }else{
        $('#GeoCityCorporations').val('');
        $('#GeoMetropolitan').val('');
        $('#GeoThanas').val('');

        showUpazila(zilla,"upazila");
        $("#citycorporationdiv").fadeOut();
        $("#metropolitandiv").fadeOut();
        $("#upoziladiv").fadeIn();
        return true;
    }

}
//for criminal info page suomoto
function showmetropolotandiv_criminal(){
    var zilla = $('#criminal_zilla').val() ;
    if (zilla=="")
    {
        $.alert(" জেলা নির্বাচন করুন ।","অবহিতকরণ বার্তা");
        return false;
    }else{

        showMetropolitan(zilla,"criminal_GeoMetropolitan");
        $("#citycorporationdiv").fadeOut();
        $("#metropolitandiv").fadeIn();
        $("#upoziladiv").fadeOut();
        return true;
    }


}
function showcitycorporationdiv_criminal(){
    var zilla = $('#criminal_zilla').val() ;
    if (zilla=="")
    {
        $.alert(" জেলা নির্বাচন করুন ।","অবহিতকরণ বার্তা");
        return false;
    }else{
        showCityCorporation(zilla,"criminal_GeoCityCorporations");
        $("#citycorporationdiv").fadeIn();
        $("#metropolitandiv").fadeOut();
        $("#upoziladiv").fadeOut();
        return true;
    }

}
function showupozilladiv_criminal(){
    var zilla = $('.criminal_zilla').val() ;
    if (zilla=="")
    {
        $.alert(" জেলা নির্বাচন করুন gggg।","অবহিতকরণ বার্তা");
        return false;
    }else{
        showUpazila(zilla,"criminal_upazila");
        $("#citycorporationdiv").fadeOut();
        $("#metropolitandiv").fadeOut();
        $("#upoziladiv").fadeIn();
        return true;
    }

}
//

//tab3-2(Ovijog ghoton)
function showmetropolotandiv_pro_sub(){
    var zilla = $('#zilla').val() ;
    if (zilla=="")
    {
        $.alert(" জেলা নির্বাচন করুন ।","অবহিতকরণ বার্তা");
        return false;
    }else{

        showMetropolitan(zilla,"GeoMetropolitan");
        $("#citycorporationdiv_pro_sub").fadeOut();
        $("#metropolitandiv_pro_sub").fadeIn();
        $("#upoziladiv_pro_sub").fadeOut();
        return true;
    }


}
function showcitycorporationdiv_pro_sub(){
    var zilla = $('#zilla').val() ;
    if (zilla=="")
    {
        $.alert(" জেলা নির্বাচন করুন ।","অবহিতকরণ বার্তা");
        return false;
    }else{
        showCityCorporation(zilla,"GeoCityCorporations");
        $("#citycorporationdiv_pro_sub").fadeIn();
        $("#metropolitandiv_pro_sub").fadeOut();
        $("#upoziladiv_pro_sub").fadeOut();
        return true;
    }

}
function showupozilladiv_pro_sub(){


    var zilla = $('#zilla').val() ;
    if (zilla=="")
    {
        $.alert(" জেলা নির্বাচন করুন ।","অবহিতকরণ বার্তা");
        return false;
    }else{
        showUpazila(zilla,"upazila");
        $("#citycorporationdiv_pro_sub").fadeOut();
        $("#metropolitandiv_pro_sub").fadeOut();
        $("#upoziladiv_pro_sub").fadeIn();
        return true;
    }

}
/////////////////////////////////////////////////////

function showmetropolotandiv_pro(criminal){

    var zilla = $('#criminal_zilla_'+ criminal).val() ;
    if (zilla=="")
    {
        $.alert(" জেলা নির্বাচন করুন ।","অবহিতকরণ বার্তা");
        return false;
    }else{

        var GeoMetropolitanID = "criminal_GeoMetropolitan_" + criminal;
        showMetropolitan(zilla,GeoMetropolitanID);

        $("#metropolitandiv_" +criminal).fadeIn();
        $("#upoziladiv_" +criminal).fadeOut();
        $("#citycorporationdiv_" +criminal).fadeOut();
        return true;
    }
}
function showcitycorporationdiv_pro(criminal){
//    alert("sdad");
    var zilla = $('#criminal_zilla_'+ criminal).val() ;
    if (zilla=="")
    {
        $.alert(" জেলা নির্বাচন করুন ।","অবহিতকরণ বার্তা");
        return false;
    }else{

        var GeoCityCorporationsID = "criminal_GeoCityCorporations_" + criminal;
        showCityCorporation(zilla,GeoCityCorporationsID);

        $("#metropolitandiv_" +criminal).fadeOut();
        $("#upoziladiv_" +criminal).fadeOut();
        $("#citycorporationdiv_" +criminal).fadeIn();
        return true;
    }

}
function showupozilladiv_pro(criminal){

    var zilla = $('#criminal_zilla_'+ criminal).val() ;

    if (zilla=="")
    {
        $.alert(" জেলা নির্বাচন করুন ।","অবহিতকরণ বার্তা");
        return false;
    }else{

        var upozilaID = "criminal_upazila_" + criminal;
        showUpazila(zilla,upozilaID);
        $("#citycorporationdiv_" +criminal).fadeOut();
        $("#metropolitandiv_" +criminal).fadeOut();
        $("#upoziladiv_" +criminal ).fadeIn();
        return true;
    }

}


function showUpazila(select,upazila)
{

    if (select=="")
    {
        document.getElementById("txtHint").innerHTML="";
        return false;
    }
    else{
        var url = base_path + "/job_description/getUpazila?ld="+select;
        get_select_data(select,url,upazila);
    }

}


function showThanas(select,thanas)
{

    if (select=="")
    {
        document.getElementById("txtHint").innerHTML="";
        return;
    }
    else{
        var url = "/geo_thanas/getthanas?ld="+select;
        get_select_data(select,url,thanas);

    }

}

function showMetropolitan(select,metro)
{

    var url = "/geo_metropolitan/getmetropolitan?ld="+select;
    get_select_data(select,url,metro);


}

function showCityCorporation(select,citycorp)
{
   
    var url ="/geo_city_corporations/getCityCorporation?ld="+select;
    get_select_data(select,url,citycorp);


}

function showUpazilaDinamicField(select,upazila)
{
    if (select=="")
    {
        return;
    }
    else{
        var url = base_path +"/job_description/getUpazila?ld="+select;
        $.ajax({
            url: url, type: 'POST',
            success: function (data) {
                if (data.length > 0) {
                    var dates = '<option value="0">বাছাই করুন...</option>';

                    for (var i = 0; i < data.length; i++) {
                        dates += '<option value=' + data[i].id + 'data-toggle="tooltip" data-placement="right" title="Tooltip on right"' + '>' + data[i].name + '</option>';
                    }


                    $(".criminal_upazilla" + upazila).append(dates);
                } else {
                    empty_select_list(select, upazila);
                }
            },
            error: function () {
            },
            complete: function () {
            }
        });

    }
}

function showUpazilaDinamicField(select,upazila) {
    if (select == "") {
        return;
    }
    else {
        var url = base_path + "/job_description/getUpazila?ld=" + select;
        $.ajax({
            type: "POST",
            url: url,
            success: function (data) {
                if (data.length > 0) {
                    var dates = '<option value="0">বাছাই করুন...</option>';

                    for (var i = 0; i < data.length; i++) {
                        dates += '<option value=' + data[i].id + 'data-toggle="tooltip" data-placement="right" title="Tooltip on right"' + '>' + data[i].name + '</option>';
                    }


                    $(".criminal_upazilla" + upazila).append(dates);
                } else {
                    empty_select_list(select, upazila);
                }
            },
            error: function () {
            },
            complete: function () {
            }
        });
    }
}


function showZilla(divID, zillaEL, callback)
{
    // $(".criminal_zilla").select2("val", "");
    // $("#zilla").select2("val","");
    /*if (divID=="")
    {
        return;
    }
    else{

        var url = base_path + "/job_description/getzilla?ld="+divID;
        get_select_data(divID, url, zilla);
    }*/

    var url = base_path + "/job_description/getzilla?ld="+divID;
    if (divID) {
        get_select_data(divID, url, zillaEL, callback);
    }
}

//tab1-2
function resetSubSectionOfLoaction()
{
    $("#criminal_upazila,#criminal_GeoCityCorporations,#criminal_GeoMetropolitan,#criminal_GeoThanas").select2("val", "");
    $("#criminal_upazila,#criminal_GeoCityCorporations,#criminal_GeoMetropolitan,#criminal_GeoThanas").find("option:gt(0)").remove();

}

//
function proSubresetSubSectionOfLocation()
{
    $("#upazila,#GeoCityCorporations,#GeoMetropolitan,#GeoThanas").select2("val","");
    $("#upazila,#GeoCityCorporations,#GeoMetropolitan,#GeoThanas").find("option:gt(0)").remove();

}

function get_select_data(divID, url, zillaEL, callback)
{

    $.ajax({
        type: "post",
        url: url,
        success: function (data) {
            if(data.length > 0) {
                build_select_list(divID, data, zillaEL, callback);
            } else {
                empty_select_list(divID, zillaEL);
            }
        }
    });

}

function build_select_list(select, data, selectEL, callback){


    var sel_id = "#" + selectEL;
    $(sel_id).find("option:gt(0)").remove();
    $(sel_id).find("option:first").text("Loading...");

    $(sel_id).find("option:first").text("বাছাই করুন...");

    for (var i = 0; i < data.length; i++) {
        $("<option/>").attr("value", data[i].id).text(data[i].name).appendTo($(sel_id));
    }

    if(callback && typeof callback === "function") {
        callback();
    }

    $(sel_id +" option[value='99']").remove();

}

//function build_select_list(select, data,ID){
//
//    var dates = '<option value="0">বাছাই করুন...</option>';
//
//    for (var i = 0; i < data.length; i++) {
//        dates += '<option value=' + data[i].id + '>' +  data[i].name + '</option>';
//    }
//
//    $(".criminal_zilla" + ID).append(dates);
//
//}



function empty_select_list(select,ID){


    var sel_id = "#" + ID;

    $(sel_id).find("option:gt(0)").remove();
    $(sel_id).find("option:first").text("Loading...");

    $(sel_id).find("option:first").text("বাছাই করুন...");

}
function showMagistrate(select){
    if (select=="")
    {
        return;
    }
    else{

        var url = base_path + "/magistrate/getMagistrate?zillaid="+select;
        // get_select_data(select,url,magistrate);

        $.ajax({url:url,type:'POST',

            success:function(data) {
                var sel_id = "#magistrate" ;
                if(data.length>0)
                {


                    $(sel_id).find("option:gt(0)").remove();
                    $(sel_id).find("option:first").text("বাছাই করুন ...");

                    //$(sel_id).find("option:first").text("");
                    for (var i = 0; i < data.length; i++)
                    {
                        $("<option/>").attr("value", data[i].id).text(data[i].name_eng).appendTo($(sel_id));
                    }
                }else{
                    $(sel_id).find("option:gt(0)").remove();
                    $(sel_id).find("option:first").text("বাছাই করুন ...");

                }
            },
            error:function() {
            },
            complete:function() {
            }
        });
    }
}

function showScheduleByMagistrateId(select){
    // $('#prosecutionform').find('.wizard .next').addClass('hide');
    if (select=="")
    {
        return;
    }
    else{

        var url = base_path +  "/court/getScheduleByMagistrateId?ld="+select;
        $.ajax({url:url,type:'POST',

            success:function(data) {
                if(data.length>0)
                {
                    $('#schedulemsg').val(data[0].msg);
                    if(data[0].court_id !=""){
                        $("#court_id").val(data[0].court_id);
                        $("#magistrate_id").val(select);
                        $("#magistrate_witness_id").val(select);
                        $("#magistrate_criminal_id").val(select);
                        $("#magistrate_crime_id").val(select);

                        $("#prosecutiondiv").fadeIn();
                        document.getElementById("nextpage").style.display="block";
                    }
                    else{
                        $("#prosecutiondiv").fadeOut();
                        document.getElementById("nextpage").style.display="none";
                    }

                }else{
                    $('#schedulemsg').val("");
                }
                //$('#prosecutionform').find('.wizard .next').removeClass('hide');
            },
            error:function() {
            },
            complete:function() {
            }
        });
    }
}

//
//function showScheduleByMagistrateId(select){
//    if (select=="")
//    {
//        return;
//    }
//    else{
//
//        var url = base_path +  "/court/getScheduleByMagistrateId?ld="+select;
//        $.post(url, function(data) {
//        })
//            .success(function(data) {
//                var sel_id = "#court_id" ;
//                if(data.length>0)
//                {
//
//
//                    $(sel_id).find("option:gt(0)").remove();
//                    $(sel_id).find("option:first").text("বাছাই করুন ...");
//
//                    //$(sel_id).find("option:first").text("");
//                    for (var i = 0; i < data.length; i++)
//                    {
//                        $("<option/>").attr("value", data[i].id).text(data[i].name).appendTo($(sel_id));
//                    }
//                }else{
//                    $(sel_id).find("option:gt(0)").remove();
//                    $(sel_id).find("option:first").text("বাছাই করুন ...");
//
//                    //$(sel_id).find("option:first").text("");
//                }
//            })
//            .error(function() {
//            })
//            .complete(function() {
//            });
//    }
//}

function showRequisition(select)
{
    var path = "<?php echo $this->url->get('requisition/getRequisitionByCourtId') ?>";


    if (select=="")
    {
        document.getElementById("txtHint").innerHTML="";
        return;
    }
    else{

        var url = base_path +  "/requisition/getRequisitionByCourtId?ld="+select;
        $.ajax({
            url: url, type: 'POST',
            success: function (data) {
                var sel_id = "#requisition_id";
                if (data.length > 0) {


                    $(sel_id).find("option:gt(0)").remove();
                    $(sel_id).find("option:first").text("বাছাই করুন ...");

                    //$(sel_id).find("option:first").text("");
                    for (var i = 0; i < data.length; i++) {
                        $("<option/>").attr("value", data[i].id).text(data[i].name).appendTo($(sel_id));
                    }
                } else {
                    $(sel_id).find("option:gt(0)").remove();
                    $(sel_id).find("option:first").text("বাছাই করুন ...");

                    //$(sel_id).find("option:first").text("");
                }
            },
            error: function () {
            },
            complete: function () {
            }
        });

        // xsssss
        showCourt(select);
    }
}


function showSection(select)
{
    var path = "<?php echo $this->url->get('prosecution/getSectionByLawId') ?>";


    if (select=="")
    {
        document.getElementById("txtHint").innerHTML="";
        return;
    }
    else{

        var url = base_path  + "/prosecution/getSectionByLawId?ld="+select;
        $.ajax({
            url: url, type: 'POST',
            success: function (data) {
                var sel_id = "#section_id_1_1";
                if (data.length > 0) {
                    $(sel_id).find("option:gt(0)").remove();
                    $(sel_id).find("option:first").text("Loading...");

                    $(sel_id).find("option:first").text("");
                    for (var i = 0; i < data.length; i++) {
                        $("<option/>").attr("value", data[i].id).text(data[i].sec_title).appendTo($(sel_id));
                    }
                } else {
                    $(sel_id).find("option:gt(0)").remove();
                    $(sel_id).find("option:first").text("বাছাই করুন ...");
                }
            },
            error: function () {
            },
            complete: function () {
            }
        });
    }
}



function showPunismentDescription(select,index)
{


    if (select=="")
    {
        document.getElementById("txtHint").innerHTML="";
        return;
    }
    else{
        // 28/04/2016
        var crime_description = "#crime_description_"+index  ;
        var section_description = "#section_description_"+index  ;

        var url = base_path + "/section/getPunishmentBySectionId?ld="+select;
        $.ajax({
            url: url, type: 'POST',
            success: function (data) {
                if (data.length > 0) {
                    $(crime_description).val((data[0].name).trim());
                    $(section_description).val((data[0].sectiondes).trim());

                }
            },
            error: function () {
            },
            complete: function () {
            }
        });
    }
}
//complain_submit
function showPunismentDescription_complainsubmit(select,index)
{


    if (select=="")
    {
        document.getElementById("txtHint").innerHTML="";
        return;
    }
    else{
        // 28/04/2016
        var crime_description = "#crime_description";
        var section_description = "#section_description"  ;

        var url = base_path + "/section/getPunishmentBySectionId?ld="+select;
        $.ajax({
            url: url, type: 'POST',
            success: function (data) {
                if (data.length > 0) {
                    $(crime_description).val((data[0].name).trim());
                    $(section_description).val((data[0].sectiondes).trim());

                }
            },
            error: function () {
            },
            complete: function () {
            }
        });
    }
}


function hidecriminalStatus() {
    $("#criminalno").fadeOut();
    return true;
}

function showcriminalStatus(sel) {
    if (sel == '2' || sel == '3' || sel == '6' || sel == "8") {
        $("#criminalno").fadeIn();
        document.getElementById('criminalname').style.display = 'block';
    } else {
        $("#criminalno").fadeOut();
        document.getElementById('criminalname').style.display = 'block';
        return true;
    }
}




function operationExecute(id) {
 
    $(".newhead").empty();
    $(".newbody").empty();


    var radioArray = document.getElementsByName("formtype");
    var suomotu = document.getElementById("is_suomotu").value;
    var value = "";

    for (i=0; i < radioArray.length; i++){
        if (radioArray[i].checked){
            value = radioArray[i].value;
            break
        }
    }
    var select = value;
    var criminalId = "";

    if(select == "2" || select == "3" || select == "6" || select == "8"){
        var radioArray_criminal = document.getElementsByName("criminalname");

        for (i=0; i < radioArray_criminal.length; i++){
            if (radioArray_criminal[i].checked){
                criminalId = radioArray_criminal[i].value;
                break
            }
        }

        if(criminalId =='')
        {
            message_show("আসামি নির্বাচন করুন । ");
            return false;
        }
    }else{
        $("#criminalname").fadeOut();
    }

    if (select == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    }else {
        //আদেশনামা
        if (select == "4") {
            $("#oper").val(select);
            var url = base_path + "/prosecution/showTableByProsecution?form_id=" + select + "&id=" + id;
            $.ajax({

                url: url,
                type: 'POST',
                success:function (data) {
                    if (data) {
                        if (data.table.length > 0) {
                            if (data.form_number == 41) {
                                set_table(data.table);
                                var html_content = $('#orderSheet_punishment_table').html();

                                newwindow = window.open();
                                newdocument = newwindow.document;
                                newdocument.write(html_content);
                                newdocument.close();

                                newwindow.print();
                                return false;
                            }
                        } else {
                            message_show("আদেশ প্রদান সম্পূর্ণ হয়নি ।");
                        }

                    }
                },
                error:function () {},
                complete:function () {}
            });
        } else {

            $("#oper").val(select);
            var url = "/prosecution/showFormByProsecution?form_id=" + select + "&id=" + id + "&suomotu=" + suomotu;
            $.ajax({

                url: url,
                type: 'POST',
                success:function (data) {
                   
                    if (data) {
                        if (data.form_number == 7){//jimmanama
                            if(data.caseInfo.prosecution.is_sizeddispose == 1 ){
                                osjimmader_setParamsForPunishment(data.caseInfo.prosecution);
                                osjimmader_setParamsFormagistraten(data.caseInfo.magistrateInfo);
                                osjimmader_setParamsForProsecution(data.caseInfo.prosecution);
                                osjimmader_setParamsForjobdescription(data.caseInfo.magistrateInfo);
                                osjimmader_setParamsForSizedList(data.caseInfo.seizurelist);


                                var html_content = $('#jimmader').html();

                                newwindow = window.open();
                                newdocument = newwindow.document;
                                newdocument.write(html_content);
                                newdocument.close();

                                newwindow.print();
                                return false;
                            }
                            else {

                                message_show(" জিম্মানামা নাই। ");

                            }
                        }else if (data.form_number == 1) {
                            var html_contentt="";
                            if(data.caseInfo.prosecution.hasCriminal==1){
                                //for previous case
                                if(data.caseInfo.lawsBrokenListWithProsecutor){
                                    p_setcrimieDescriptionWC(data.caseInfo.prosecution,data.caseInfo.criminalDetails,data.caseInfo.prosecutionLocationName,data.caseInfo.lawsBrokenListWithProsecutor,data.caseInfo.lawsBrokenListWithProsecutor);
                                    p_setParamsForcriminalWC(data.caseInfo.criminalDetails,data.caseInfo.lawsBrokenListWithProsecutor);
                                }else{
                                    p_setcrimieDescriptionWC(data.caseInfo.prosecution,data.caseInfo.criminalDetails,data.caseInfo.prosecutionLocationName,data.caseInfo.lawsBrokenList,data.caseInfo.lawsBrokenList);
                                    p_setParamsForcriminalWC(data.caseInfo.criminalDetails,data.caseInfo.lawsBrokenList);
                                }

                                p_setParamsForProsecution(data.caseInfo.prosecution);

                                p_setParamsForSizedList(data.caseInfo.seizurelist);
                                p_setParamsForjobdescription(data.caseInfo.magistrateInfo);
                                p_setParamsFormagistraten(data.caseInfo.magistrateInfo);
                                p_setParamsForLocation(data.caseInfo.prosecutionLocationName);
                                p_setParamsForProsecutor(data.caseInfo.prosecutorInfo);
                                html_contentt = $('#prosecution').html();

                            }else{
                                p_setcrimieDescriptionWOC(data.caseInfo.prosecution,data.caseInfo.criminalDetails,data.caseInfo.prosecutionLocationName,data.caseInfo.lawsBrokenListWithProsecutor,data.caseInfo.lawsBrokenListWithProsecutor);
                                p_setParamsForProsecutionWOC(data.caseInfo.prosecution);
                                p_setParamsForcriminalWOC(data.caseInfo.criminalDetails,data.caseInfo.lawsBrokenListWithProsecutor);
                                p_setParamsForSizedListWOC(data.caseInfo.seizurelist);
                                p_setParamsForjobdescriptionWOC(data.caseInfo.magistrateInfo);
                                p_setParamsFormagistratenWOC(data.caseInfo.magistrateInfo);
                                p_setParamsForLocationWOC(data.caseInfo.prosecutionLocationName);

                                p_setParamsForProsecutorWOC(data.caseInfo.prosecutorInfo);
                                html_contentt = $('#complainSubmitReportWithOutCriminal').html();
                            }
                            newwindow = window.open();
                            newdocument = newwindow.document;
                            newdocument.write(html_contentt);
                            newdocument.close();

                            newwindow.print();
                            return false;

                        }else if (data.form_number == 20) {//complaint

                            if (data.caseInfo.prosecution.is_approved == 0) {
                                message_show("অভিযোগ গঠন হয়নি ।");
                            } else {
                                var location=data.caseInfo.prosecutionLocationName.underZillaLocation+','+data.caseInfo.prosecutionLocationName.zillaName;
                           
                                c_agree_crimieDescription(data.caseInfo.prosecution,data.caseInfo.criminalDetails,location,data.caseInfo.lawsBrokenList);
//                                c_agree_setParamsForProsecution(data.prosecution);
                                c_agree_setParamsForcriminal(data.caseInfo.criminalDetails,criminalId);
                                c_agree_setParamsForjobdescription(data.caseInfo.magistrateInfo);
                                c_agree_setParamsFormagistraten(data.caseInfo.magistrateInfo);
//                                c_agree_setParamsForLocation(data.pro_locationdetails);

                                //$('#complain').modal('show');

                                ///////////////////////////
                                var html_content = $('#complain_agree').html();

                                newwindow = window.open();
                                newdocument = newwindow.document;
                                newdocument.write(html_content);
                                newdocument.close();

                                newwindow.print();
                                return false;
                            }

                            ////////////////////////////
                        }else if (data.form_number == 21) {
                            if (data.prosecution.is_approved == 0) {
                                message_show("অভিযোগ গঠন হয়নি ।");

                            } else {
                                c_disagree_setParamsForProsecution(data.prosecution);
                                c_disagree_setParamsForcriminal(data.criminal);
                                c_disagree_setParamsForjobdescription(data.jobdescription);
                                c_disagree_setParamsFormagistraten(data.magistrate);
                                c_disagree_setParamsForLocation(data.pro_location);


                                //$('#complain').modal('show');

                                ///////////////////////////
                                var html_content = $('#complain_disagree').html();

                                newwindow = window.open();
                                newdocument = newwindow.document;
                                newdocument.write(html_content);
                                newdocument.close();

                                newwindow.print();
                                return false;
                            }
                            ////////////////////////////
                        }else if (data.form_number == 30) {//confession

                            if (data.caseInfo.criminalConfession.length > 0) {

                                cc_yes_setParamsForcriminalConfession(data.caseInfo.criminalConfession, criminalId);
                                cc_yes_setParamsForcriminal(data.caseInfo.criminalDetails, criminalId);

                                cc_yes_setParamsForjobdescription(data.caseInfo.magistrateInfo,data.caseInfo.prosecutionLocationName);
                                cc_yes_setParamsFormagistraten(data.caseInfo.magistrateInfo);
                                cc_yes_setParamsForProsecution(data.caseInfo.prosecution);
                                //$('#criminalConfession').modal('show');

                                var html_content = $('#criminalConfession_yes').html();

                                newwindow = window.open();
                                newdocument = newwindow.document;
                                newdocument.write(html_content);
                                newdocument.close();

                                newwindow.print();
                                return false;
                            } else {
                                message_show("অভিযুক্ত ব্যক্তির বক্তব্য নাই");
                            }

                        }else if (data.form_number == 31) {
                            cc_no_setParamsForcriminalConfession(data.criminalConfession);
                            cc_no_setParamsForcriminal(data.criminal);
                            cc_no_setParamsForjobdescription(data.jobdescription);
                            cc_no_setParamsFormagistraten(data.magistrate);
                            cc_no_setParamsForProsecution(data.prosecution);
                            //$('#criminalConfession').modal('show');

                            var html_content = $('#criminalConfession_no').html();

                            newwindow = window.open();
                            newdocument = newwindow.document;
                            newdocument.write(html_content);
                            newdocument.close();

                            newwindow.print();
                            return false;
                        }else if (data.form_number == 41) {

                            os_setParamsForProsecution(data.prosecution);
                            os_setParamsFormagistrate(data.magistrate);
                            os_setParamsForjobdescription(data.jobdescription);
                            os_setParamsForcriminal(data.criminal);
                            os_setParamsForprosecutor(data.prosecutor);
                            os_setParamsForPunishment(data.punishment);
                            os_setParamsForcriminalConfession(data.criminalConfession);
                            os_setParamsForSizedList(data.seizurelist);
                            os_setParamsForLocation(data.pro_location);
                            os_setParamsForJail(data.jail);

                            //$('#orderSheet').modal('show');

                            ///////////////////////////
                            var html_content = $('#orderSheet_punishment').html();

                            newwindow = window.open();
                            newdocument = newwindow.document;
                            newdocument.write(html_content);
                            newdocument.close();

                            newwindow.print();
                            return false;
                            ////////////////////////////
                        }else if (data.form_number == 42) {

                            osRelease_setParamsForProsecution(data.prosecution);
                            osRelease_setParamsFormagistrate(data.magistrate);
                            osRelease_setParamsForjobdescription(data.jobdescription);
                            osRelease_setParamsForcriminal(data.criminal);
                            osRelease_setParamsForprosecutor(data.prosecutor);
                            osRelease_setParamsForPunishment(data.punishment);
                            osRelease_setParamsForcriminalConfession(data.criminalConfession);
                            osRelease_setParamsForSizedList(data.seizurelist);

                            //$('#orderSheet').modal('show');

                            ///////////////////////////
                            var html_content = $('#orderSheet_release').html();

                            newwindow = window.open();
                            newdocument = newwindow.document;
                            newdocument.write(html_content);
                            newdocument.close();

                            newwindow.print();
                            return false;
                            ////////////////////////////
                        }else if (data.form_number == 43) {

                            osTocourt_setParamsForProsecution(data.prosecution);
                            osTocourt_setParamsFormagistrate(data.magistrate);
                            osTocourt_setParamsForjobdescription(data.jobdescription);
                            osTocourt_setParamsForcriminal(data.criminal);
                            osTocourt_setParamsForprosecutor(data.prosecutor);
                            osTocourt_setParamsForPunishment(data.punishment);
                            osTocourt_setParamsForcriminalConfession(data.criminalConfession);
                            osTocourt_setParamsForSizedList(data.seizurelist);

                            //$('#orderSheet').modal('show');

                            ///////////////////////////
                            var html_content = $('#orderSheet_tocourt').html();

                            newwindow = window.open();
                            newdocument = newwindow.document;
                            newdocument.write(html_content);
                            newdocument.close();

                            newwindow.print();
                            return false;
                            ////////////////////////////
                        }else if (data.form_number == 44) {

                            osDeposition_setParamsForProsecution(data.prosecution);
                            osDeposition_setParamsFormagistrate(data.magistrate);
                            osDeposition_setParamsForjobdescription(data.jobdescription);
                            osDeposition_setParamsForcriminal(data.criminal);
                            osDeposition_setParamsForprosecutor(data.prosecutor);
                            osDeposition_setParamsForPunishment(data.punishment);
                            osDeposition_setParamsForcriminalConfession(data.criminalConfession);
                            osDeposition_setParamsForSizedList(data.seizurelist);

                            //$('#orderSheet').modal('show');

                            ///////////////////////////
                            var html_content = $('#orderSheet_deposition').html();

                            newwindow = window.open();
                            newdocument = newwindow.document;
                            newdocument.write(html_content);
                            newdocument.close();

                            newwindow.print();
                            return false;
                            ////////////////////////////
                        }else if (data.form_number == 5) { //seizureListReport
                            if (data.caseInfo.seizurelist) {
                                
                                prepareReport(data.caseInfo);

                                var html_content = $('#sizedList').html();

                                newwindow = window.open();
                                newdocument = newwindow.document;
                                newdocument.write(html_content);
                                newdocument.close();

                                newwindow.print();
                                return false;
                            } else {
                                message_show("জব্দ তালিকা নাই");
                            }

                        }else if (data.form_number == 6) {//jail
                        
                            if (data.jailInfo.length > 0) {
                                if (data.caseInfo.criminalDetails.length > 0) {
                                    var flag = one_jw_setParamsForcriminal(data.caseInfo.criminalDetails,criminalId,data.jailInfo,data.caseInfo.prosecution);
                                    if(flag){
                                        one_jw_setParamsForProsecution(data.caseInfo.prosecution);
                                        //one_jw_setParamsForPunishment(data.punishment, 0);
                                        one_jw_setParamsForjobdescription(data.caseInfo.magistrateInfo,data.caseInfo.prosecutionLocationName);

                                        one_jw_setParamsFormagistraten(data.caseInfo.magistrateInfo);
                                        one_jw_setParamsForJail(data.jailInfo,criminalId);
                                        one_jw_setParamsForLaw(data.jailInfo,criminalId);

                                        var html_content = $('#jellWarrentall').html();


                                        newwindow = window.open();
                                        newdocument = newwindow.document;
                                        newdocument.write(html_content);
                                        newdocument.close();

                                        newwindow.print();
                                        return false;
                                    }else{
                                        message_show("কয়েদী  পরোয়ানা  নাই");
                                    }

                                }
                                return false;
                            }
                            else {
                                message_show("কয়েদী  পরোয়ানা  নাই");
                            }
                        }else if (data.form_number == 8) {
                            if(data.jailInfo.length > 0) {
                                handover_setParamsForcriminal(data.caseInfo.criminalDetails,data.jailInfo,criminalId,data.caseInfo.prosecution);
                                handover_setParamsForjobdescription(data.caseInfo.magistrateInfo,data.caseInfo.prosecutionLocationName);
                                handover_setParamsFormagistraten(data.caseInfo.magistrateInfo);

                                ///////////////////////////
                                var html_content = $('#handoverform').html();

                                newwindow = window.open();
                                newdocument = newwindow.document;
                                newdocument.write(html_content);
                                newdocument.close();

                                newwindow.print();
                                return false;
                            } else {
                                message_show("সোপর্দের পরোয়ানা  নাই");
                            }
                        }else
                        {
                            message_show("তথ্য নাই ");
                        }


                    }
                },
                error:function () {},
                complete:function () {}
            });
        }

    }
}

function checkJailWarrent(selectCriminal,jailInformation) {
    var flag=false;
    var jailcriminal=0;
    for(var i=0;i<jailInfo.length;i++){
        if(jailInfo[i].criminal_id==criminalID){
            flag=true;
        }
    }
    return flag;
}




function setParamsForOrderSheet(data){
    $.each(data, function(i, item)
    {
        $('#bookId7').val(item.id);
    });
}

/**
 * Gets whether all the options are selected
 * @param {jQuery} $el
 * @returns {bool}
 */
function multiselect_selected($el) {
    var ret = true;
    $('option', $el).each(function(element) {
        if (!!!$(this).prop('selected')) {
            ret = false;
        }
    });
    return ret;
}
/**
 * Selects all the options
 * @param {jQuery} $el
 * @returns {undefined}
 */
function multiselect_selectAll($el) {
    $('option', $el).each(function(element) {
        $el.multiselect('select', $(this).val());
    });
}
/**
 * Deselects all the options
 * @param {jQuery} $el
 * @returns {undefined}
 */
function multiselect_deselectAll($el) {
    $('option', $el).each(function(element) {
        $el.multiselect('deselect', $(this).val());
    });
}
/**
 * Clears all the selected options
 * @param {jQuery} $el
 * @returns {undefined}
 */
function multiselect_toggle($el, $btn) {
    if (multiselect_selected($el)) {
        multiselect_deselectAll($el);
        $btn.text("Select All");
    }
    else {
        multiselect_selectAll($el);
        $btn.text("Deselect All");
    }
}



function selectNextDiv(select)
{

    if (select=="")
    {
        //document.getElementById("txtHint").innerHTML="";
        return;
    }
    else{

        if(select == "1" )
        {
            $("#selfDiv").fadeIn();

            $("#otherReqDiv").fadeOut();
            $("#reqDiv").fadeOut();
        }
        else if(select == "2")
        {
            $("#otherReqDiv").fadeIn();

            $("#reqDiv").fadeOut();
            $("#selfDiv").fadeOut();

        }
        else if(select == "3" ){
            $("#reqDiv").fadeIn();
            getAllRequisitionForDiv();

            $("#selfDiv").fadeOut();
            $("#otherReqDiv").fadeOut();
        }
        else
        {

            $("#selfDiv").fadeOut();
            $("#otherReqDiv").fadeOut();
            $("#reqDiv").fadeOut();
        }
    }
}

function showCourt(select){
    // var path = "<?php echo $this->url->get('prosecution/getSectionByLawId') ?>";


    if (select=="")
    {
        document.getElementById("txtHint").innerHTML="";
        return;
    }
    else{

        var url = base_path + "/court/getCourtById?ld="+select;
        $.ajax({
            url: url,
            type: 'POST',
            success:function(data) {
                if(data.length>0)
                {
                    var date = "#date" ;
                    var time = "#time" ;
                    var title = "#title" ;
                    var division = "#division" ;
                    var zilla = "#zilla" ;
                    var upazila = "#upazila" ;
                    var location_str = "#location_str" ;

                    $(date).val(data[0].date);
                    $(title).val(data[0].title);
                    $(time).val(data[0].time);
                    $(location_str).val(data[0].location_str);



                    $('#division').val(data[0].divid);

                    var zilla_id = "#zilla" ;
                    $(upazila_id).find("option:gt(0)").remove();
                    for (var i = 0; i < data.length; i++)
                    {
                        $("<option/>").attr("value", data[i].zillaid).text(data[i].zillaname).appendTo($(zilla_id));
                    }
                    $('#zilla').val(data[0].zillaid);

                    var upazila_id = "#upazila" ;
                    $(upazila_id).find("option:gt(0)").remove();

                    for (var i = 0; i < data.length; i++)
                    {
                        $("<option/>").attr("value", data[i].upazilaid).text(data[i].upazilaname).appendTo($(upazila_id));
                    }
                    $('#upazila').val(data[0].upazilaid);
                }
            },
            error:function() {
            },
            complete:function() {
            }
        });
    }
}

function getAllRequisitionForDiv(){

    var divid = $('#division').val() ;
    var zillaid = $('#zilla').val() ;
    var upazilaid = $('#upazila').val() ;

//    alert("Please Select Location");

//    alert($('#division').val());

    if(divid == "" || zillaid == "" || upazilaid == ""){
        alert("Please Select Location");
        return
    }

    var url = base_path + "/requisition/getRequisitionByLocation?divid="+divid+"&zillaid="+zillaid+"&upazilaid="+upazilaid;
    $.ajax({
        url: url,
        type: 'POST',
        success:function(data) {
            if(data.length>0)
            {
                var sel_id = "#requisition_id" ;

                $(sel_id).find("option:gt(0)").remove();
                $(sel_id).find("option:first").text("Loading...");

                $(sel_id).find("option:first").text("");
                for (var i = 0; i < data.length; i++)
                {
                    $("<option/>").attr("value", data[i].id).text(data[i].subject).appendTo($(sel_id));
                }
            }
        },
        error:function() {
        },
        complete:function() {
        }
    });
}



function showComplain(select){



    if(select == "" ){

        return
    }

    var url = base_path + "/citizen_complain/getCitizen_complainByReqId?reqid="+select;
    $.ajax({
        url: url,
        type: 'POST',
        success:function(data) {
            if(data.length>0)
            {
                var name = "#name" ;
                var cmp_mobile = "#cmp_mobile" ;
                var email = "#email" ;

                var cmp_subject = "#cmp_subject" ;
                var cmp_details = "#cmp_details" ;

                $(name).val(data[0].name);
                $(cmp_mobile).val(data[0].mobile);
                $(cmp_subject).val(data[0].subject);
                $(cmcourtselectform_details).val(data[0].complain_details);

            }
        },
        error:function() {
        },
        complete:function() {
        }
    });
}

function tConvert_Global(time_in) {

    // Check correct time format and split into components
    var time = time_in.toString ().match (/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time_in];

    if (time.length > 1) { // If time format correct
        time = time.slice (1);  // Remove full string match value
        time[5] = +time[0] < 12 ? 'পূর্বাহ্ন  ' : 'মধ্যহ্ন'; // Set AM/PM
        time[0] = +time[0] % 12 || 12; // Adjust hours
    }

    return time[5] + "  " + time[0] + ":" + time[2] + " ঘটিকায়" ;
}

//criminal checkbox selected
function doParmanentAddress_criminal(val) {


    if ($('#do_address').is(":checked")) {

        var prmanent_address = $("#permanent_address" ).val();
        var thana_address = $("#criminal_GeoThanas").val(); // thana
        var metropolitan_address = $("#criminal_GeoMetropolitan").val(); // thana
        var city_address = $("#criminal_GeoCityCorporations").val(); // city
        var zilla_address = $('#criminal_zilla').val();
        var upozilla_address = $('#criminal_upazila').val();
        var upozilla_name = 'criminal[' + criminal + '][upazila]';


        var upozillaID = 'criminal_upazila';
        var upozillaoptionName ="";
        var zilla_ID  = 'criminal_zilla';
        var zillaoptionName ="";
        var city_ID = 'criminal_GeoCityCorporations';
        var cityoptionName ="";

        var metropolitan_ID = 'criminal_GeoMetropolitan'; // thana
        var metropolitanoptionName ="";

        var thana_ID = 'criminal_GeoThanas'; // thana
        var thanaoptionName ="";

        var optionValue ="";

        var expertise_chosen = false;
        var expertiseObj = document.getElementById(upozillaID);
        for (var i = 1; i < expertiseObj.length; i++) {
            if (expertiseObj.options[i].selected == true) {
                expertise_chosen = true;
                upozillaoptionName = ", " +  expertiseObj.options[i].text;

                optionValue = expertiseObj.options.length;
                break;
            }
        }

        expertise_chosen = false;
        expertiseObj = document.getElementById(zilla_ID);
        for (var i = 1; i < expertiseObj.length; i++) {
            if (expertiseObj.options[i].selected == true) {
                expertise_chosen = true;
                zillaoptionName = ", " +  expertiseObj.options[i].text;

                optionValue = expertiseObj.options.length;
                break;
            }
        }

        expertise_chosen = false;
        expertiseObj = document.getElementById(city_ID);
        for (var i = 1; i < expertiseObj.length; i++) {
            if (expertiseObj.options[i].selected == true) {
                expertise_chosen = true;
                cityoptionName = ", " +  expertiseObj.options[i].text;

                optionValue = expertiseObj.options.length;
                break;
            }
        }

        expertise_chosen = false;
        expertiseObj = document.getElementById(metropolitan_ID);
        for (var i = 1; i < expertiseObj.length; i++) {
            if (expertiseObj.options[i].selected == true) {
                expertise_chosen = true;
                metropolitanoptionName = ", " + expertiseObj.options[i].text;

                optionValue = expertiseObj.options.length;
                break;
            }
        }

        expertise_chosen = false;
        expertiseObj = document.getElementById(thana_ID);
        for (var i = 1; i < expertiseObj.length; i++) {
            if (expertiseObj.options[i].selected == true) {
                expertise_chosen = true;
                thanaoptionName = ", " + expertiseObj.options[i].text;

                optionValue = expertiseObj.options.length;
                break;
            }
        }

        var location = prmanent_address +  upozillaoptionName +  cityoptionName + thanaoptionName +   metropolitanoptionName + zillaoptionName;
        $("#present_address").val(location);
    }
    else {
        $("#present_address").val("");
    }


}

// updated 29-0
function doParmanentAddress(val, criminal) {

    if ($('#do_address_' + criminal).is(":checked")) {
        var prmanent_address = $("#permanent_address_" + criminal).val();

        var upozillaID = 'ddlUpazilla' + criminal;
        var upozillaoptionName ="";

        var zilla_ID  = 'ddlZilla' + criminal;
        var zillaoptionName ="";

        var thana_ID = 'ddlThana' + criminal; // thana
        var thanaoptionName ="";

        var optionValue ="";

        var expertise_chosen = false;
        var expertiseObj = document.getElementById(upozillaID);
        for (var i = 1; i < expertiseObj.length; i++) {
            if (expertiseObj.options[i].selected == true) {
                expertise_chosen = true;
                upozillaoptionName = ", " +  expertiseObj.options[i].text;

                optionValue = expertiseObj.options.length;
                break;
            }
        }

        expertise_chosen = false;
        expertiseObj = document.getElementById(zilla_ID);
        for (var i = 1; i < expertiseObj.length; i++) {
            if (expertiseObj.options[i].selected == true) {
                expertise_chosen = true;
                zillaoptionName = ", " +  expertiseObj.options[i].text;

                optionValue = expertiseObj.options.length;
                break;
            }
        }

        expertise_chosen = false;
        expertiseObj = document.getElementById(thana_ID);
        for (var i = 1; i < expertiseObj.length; i++) {
            if (expertiseObj.options[i].selected == true) {
                expertise_chosen = true;
                thanaoptionName = ", " + expertiseObj.options[i].text;

                optionValue = expertiseObj.options.length;
                break;
            }
        }
        var location = prmanent_address +  upozillaoptionName  + thanaoptionName + zillaoptionName;
        $("#present_address_" + criminal).val(location);
    }
    else {
        $("#present_address_" + criminal).val("");
    }

}

function pad_with_zeroes(number, length) {

    var my_string = '' + number;
    while (my_string.length < length) {
        my_string = '0' + my_string;
    }

    return my_string;

}


// function showupozilladiv_pro(item_index,selected_value,elementid_to_populate,elementindex_to_display){
//
//     alert("test 1  -- " + selected_value);
//
//     if( typeof(selected_value) == "undefined"){
//         selected_value = $('#criminal_zilla_'+item_index).val() ;
//         elementid_to_populate = "criminal_upazila_"+item_index;
//         elementindex_to_display= "";
//     }
//     if (selected_value=="")
//     {
//         jAlert(" জেলা নির্বাচন করুন ।","অবহিতকরণ বার্তা");
//         return false;
//     }else{
//
//         showUpazila_pro(selected_value,elementid_to_populate,elementindex_to_display);
//         $("#citycorporationdiv_"+item_index).fadeOut();
//         $("#metropolitandiv_"+item_index).fadeOut();
//         $("#upoziladiv_"+item_index).fadeIn();
//         return true;
//     }
//
// }

function showUpazila_pro(selected_value,elementid_to_populate,elementindex_to_display)
{

    if (selected_value=="")
    {
        document.getElementById("txtHint").innerHTML="";
        return false;
    }
    else{
        var url = base_path + "/job_description/getUpazila?ld="+selected_value;
        get_select_data_pro(selected_value,url,elementid_to_populate,elementindex_to_display);
    }

}

function showZilla_pro(selected_value,elementid_to_populate,elementindex_to_display)
{

    if (selected_value=="")
    {
        return;
    }
    else{

        var url = base_path + "/job_description/getzilla?ld="+selected_value;
        get_select_data_pro(selected_value,url,elementid_to_populate,elementindex_to_display);
    }
}

function get_select_data_pro(select,url,ID,selectedindex)
{
    $.ajax({
        url: url,
        type: 'POST',
        success:function(data) {
            if(data.length>0)
            {
                build_select_list_pro(select,data,ID);
            }else{
                empty_select_list_pro(select,ID);
            }
        },
        error:function() {
        },
        complete:function() {
            if (selectedindex!="")
            {
                var sel_id = "#" + ID;
                $(sel_id).select2().select2('val',selectedindex);
            }

        }
    });
}

function build_select_list_pro(select, data,ID){


    var sel_id = "#" + ID;
    $(sel_id).find("option:gt(0)").remove();
    $(sel_id).find("option:first").text("Loading...");

    $(sel_id).find("option:first").text("বাছাই করুন...");

    for (var i = 0; i < data.length; i++) {
        $("<option/>").attr("value", data[i].id).text(data[i].name).appendTo($(sel_id));
    }

    $(sel_id +" option[value='99']").remove();

}


function empty_select_list_pro(select,ID){


    var sel_id = "#" + ID;

    $(sel_id).find("option:gt(0)").remove();
    $(sel_id).find("option:first").text("Loading...");

    $(sel_id).find("option:first").text("বাছাই করুন...");

}