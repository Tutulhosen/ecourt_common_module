/**
 * Created by DOEL PC on 4/28/14.
 */

var chart_Court = null;
var chart_Case = null;
var chart_Fine = null;
var chart_Appeal = null;
var chart_Em = null;
var chart_Adm = null;

var yData = [];
var xData = [];
var winprint = 0;

$(document).ready(function(){
    winprint = 0;

    jQuery("#reportlist,#graphlist,#reportlistdiv,#countrywisereportid,#reportType,#reportList").select2();

    var chec = $('#report_date').datepicker({
        format: "mm-yyyy",
        viewMode: "months",
        minViewMode: "months",
        changeMonth: true,
        changeYear: true
    }).on('changeDate', function(ev) {
        chec.hide();
    }).data('datepicker');

    var chec2 = $('#report_date2').datepicker({
        format: "mm-yyyy",
        viewMode: "months",
        minViewMode: "months",
        changeMonth: true,
        changeYear: true
    }).on('changeDate', function(ev) {
        chec2.hide();
    }).data('datepicker');


});

function showGraph(){
    var graphID = $('#reportList').val() ;
    var report_date = $('#report_date').val() ;
    var report_date2 = $('#report_date2').val() ;

    if(report_date ==""){
        message_show("মাস নির্বাচন করুন ।");
        return false;
    }


    if(graphID == '1'){
        graphCourt();
    }else if(graphID == '2'){
        graphCase();
    }else if(graphID == '3'){
        graphFine();
    }else if(graphID == '4'){
        graphAppeal();
    }else if(graphID == '5'){
        graphEm();
    }else if(graphID == '6'){
        graphAdm();
    } else{
        message_show("গ্রাফের বিষয় নির্বাচন করুন ।");
    }

}



function showReporttools(){
   //alert("fff");
    var url =  base_path + "/report/printmobilecourtreport";

    $.post(url, function(data) {
    })
        .success(function(data) {
        })
        .error(function() {
        })
        .complete(function() {
        });
}

function reportSelection(){
 
    var reportType = $('#reportType').val() ;
 
    if(reportType==1){
        showCountryWiseReportFunction();
    }else if(reportType==2){
        showReport();
    }else if(reportType==3){
        showZillaReport();
    }else if(reportType==4){
        showGraph();
    }
}


function showZillaReport() {

    var reportID = $('#reportList').val() ;
    var report_date = $('#report_date').val() ;

    var connmentID = 1;
    var radioArray_comment  = document.getElementsByName("optradio");

    for (var i=0; i < radioArray_comment.length; i++){
        if (radioArray_comment[i].checked){
            connmentID = radioArray_comment[i].value;
            break
        }
    }


    if(report_date ==""){
        message_show("মাস নির্বাচন করুন ।");
        return false;
    }

    if (reportID != '') {
        zillabasedreport(report_date, reportID,connmentID);
        winprint++;
    } else {
        message_show("প্রতিবেদন নির্বাচন করুন । ");
    }
}

//countrywise Mis report show
function showCountryWiseReportFunction() {

    var countryReportId = $('#reportList').val();
    var presentDate = $('#report_date').val() ;
    var previousDate = $('#report_date2').val() ;

    if(presentDate ==""){
        message_show("বিবেচ্য মাস/বছর নির্বাচন করুন ।");
        return false;
    }
    if(previousDate ==""){
        message_show("পূর্ববর্তী মাস/বছর নির্বাচন করুন ।");
        return false;
    }

    if (countryReportId != '') {
       // message_show(" yes");
        countryBasedReport(presentDate,previousDate,countryReportId);
    } else {
        message_show("প্রতিবেদন নির্বাচন করুন । ");
    }

}



function showReport() {

    var divreportID = $('#reportList').val();
    var report_date = $('#report_date').val();


    var connmentID = 1;
    var radioArray_comment  = document.getElementsByName("optradio");

    for (var i=0; i < radioArray_comment.length; i++){
        if (radioArray_comment[i].checked){
            connmentID = radioArray_comment[i].value;
            break
        }
    }

    if (report_date == "") {
        message_show("মাস নির্বাচন করুন ।");
        return false;
    }

    if (divreportID != '') {
        divisionbasedreport(report_date, divreportID,connmentID);
        winprint++;
    } else {
        message_show("প্রতিবেদন নির্বাচন করুন । ");
    }
}

//Country wise report
function countryBasedReport(presentDate,previousDate,reportId) {

    var url = "/monthly_report/printcountrymobilecourtreport?presentDate=" + presentDate + "&previousDate=" + previousDate +"&reportId=" +reportId;

    $.ajax({
        url: url,
        type: 'POST',
        success: function (data) {
            if (data.resultSet.length == 0) {
                message_show("তথ্য নাই ।   ।");
            }else {
                var html_content ="";

                // Condition check
                //1=mobilecourt report,2=appeal report,3=adm report,4=em report
                if(reportId=='1'){
                    mis_report.set_data_mbl(data);
                    html_content = $('#printcountrymobilecourtreport').html();
                }else {
                    mis_report.set_data_others_report(data);
                    html_content = $('#printcountryothersreport').html();

                }

                newwindow = window.open();
                newdocument = newwindow.document;
                newwindow.document.write();
                newdocument.write(html_content);
                newdocument.close();

                newwindow.print();
                return false;
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $.alert("Error", "অবহতিকরণ বার্তা");
        }
    });


}

function zillabasedreport(report_date, reportID,connmentID) {
 
    if(reportID == '1'){
        var url = "/monthly_report/printmobilecourtreport?report_date="+report_date+"&reportID="+reportID;

        $.ajax({
            url: url,
            type: 'POST',
            success: function (data) {
                
                if(data.result.length == 0){
                    message_show("তথ্য নাই  ।");
                }else{
                 
                    var html_content = "";
                    if(connmentID == 1){
                         
                        pmc_setParams(data,connmentID);
                        html_content = $('#printmobilecourtreport').html();

                    }else{
//                        pmc_setHeaderParamsWithComment(connmentID,winprint);
                        pmc_setParamsWithComment(data,connmentID);
                        html_content = $('#printmobilecourtreportWithComment').html();
                    }

                    newwindow=window.open();
                    newdocument=newwindow.document;
                    newwindow.document.write( );
                    newdocument.write(html_content);
                    newdocument.close();

                    newwindow.print();
                    return false;
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $.alert("Error", "অবহতিকরণ বার্তা");
            }
        });

    }else if(reportID == '2'){
        var url = "/monthly_report/printappealcasereport?report_date="+report_date+"&reportID="+reportID;

        $.ajax({
            url: url,
            type: 'POST',
            success: function (data) {
                if(data.result.length == 0){
                    message_show("তথ্য নাই । ");
                }
                else
                {
                    var html_content ="";
                    if(connmentID == 1){
                        pac_setParams(data,connmentID);
                        html_content = $('#printappealcasereport').html();
                    }else{
                        pac_setParamsWithComment(data,connmentID);
                        html_content = $('#printappealcasereportWithComment').html();
                    }

                    newwindow=window.open();
                    newdocument=newwindow.document;
                    newwindow.document.write( );
                    newdocument.write(html_content);
                    newdocument.close();

                    newwindow.print();
                    return false;
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $.alert("Error", "অবহতিকরণ বার্তা");
            }
        });
    }else if(reportID == '3'){
        var url =   "/monthly_report/printadmcasereport?report_date="+report_date+"&reportID="+reportID;

        $.ajax({
            url: url,
            type: 'POST',
            success: function (data) {
                if(data.result.length == 0){
                    message_show("তথ্য নাই । ");
                }
                else {

                    var html_content ="";
                    if(connmentID == 1){
                        padmc_setParams(data,connmentID);
                        html_content = $('#printadmcasereport').html();
                    }else{
                        padmc_setParamsWithComment(data,connmentID);
                        html_content = $('#printadmcasereportWithComment').html();
                    }

                    newwindow=window.open();
                    newdocument=newwindow.document;
                    newwindow.document.write( );
                    newdocument.write(html_content);
                    newwindow.print();
                    newdocument.close();


                    return false;
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $.alert("Error", "অবহতিকরণ বার্তা");
            }
        });

    }else if(reportID == '4'){
        var url = "/monthly_report/printemcasereport?report_date="+report_date+"&reportID="+reportID;

        $.ajax({
            url: url,
            type: 'POST',
            success: function (data) {
                if(data.result.length == 0){
                    message_show("তথ্য নাই । ");
                }else{


                    var html_content ="";
                    if(connmentID == 1){
                        pemc_setParams(data,connmentID);
                        html_content = $('#printemcasereport').html();
                    }else{
                        pemc_setParamsWithComment(data,connmentID);
                        html_content = $('#printemcasereportWithComment').html();
                    }


                    newwindow=window.open();
                    newdocument=newwindow.document;
                    newwindow.document.write( );
                    newdocument.write(html_content);
                    newdocument.close();

                    newwindow.print();
                    return false;

                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $.alert("Error", "অবহতিকরণ বার্তা");
            }
        });
    }else if(reportID == '5'){
        var url =  "/monthly_report/printcourtvisitreport?report_date="+report_date+"&reportID="+reportID;

        $.ajax({
            url: url,
            type: 'POST',
            success: function (data) {
                if(data.result.length == 0){
                    message_show("তথ্য নাই । ");
                }else{
                    var html_content ="";
                    if(connmentID == 1){
                        pcv_setParams(data,connmentID);
                        html_content = $('#printcourtvisitreport').html();
                    }else{
                        pcv_setParamsWithComment(data,connmentID);
                        html_content = $('#printcourtvisitreportWithComment').html();
                    }

                    newwindow=window.open();
                    newdocument=newwindow.document;
                    newwindow.document.write( );
                    newdocument.write(html_content);
                    newdocument.close();

                    newwindow.print();
                    return false;
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $.alert("Error", "অবহতিকরণ বার্তা");
            }
        });


    }else if(reportID == '6'){
        var url =  "/monthly_report/printcaserecordreport?report_date="+report_date+"&reportID="+reportID;

        $.ajax({
            url: url,
            type: 'POST',
            success: function (data) {
                if(data.result.length == 0){
                    message_show("তথ্য নাই । ");
                }else{


                    var html_content ="";
                    if(connmentID == 1){
                        pcr_setParams(data,connmentID);
                        html_content = $('#printcaserecordreport').html();
                    }else{
                        pcr_setParamsWithComment(data,connmentID);
                        html_content = $('#printcaserecordreportWithComment').html();
                    }


                    newwindow=window.open();
                    newdocument=newwindow.document;
                    newwindow.document.write( );
                    newdocument.write(html_content);
                    newdocument.close();

                    newwindow.print();
                    return false;
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $.alert("Error", "অবহতিকরণ বার্তা");
            }
        });

    }else if(reportID == '7'){
        var url ="/monthly_report/printapprovedreport?report_date="+report_date+"&reportID="+reportID;

        $.ajax({
            url: url,
            type: 'POST',
            success: function (data) {
                console.log(data);
                if(data.result.length == 0){
                    message_show("তথ্য নাই । ");
                }else{

//                    p_approvedrep_setParams(data);

                    var html_content ="";
                    if(connmentID == 1){
                        p_approvedrep_setParams(data,connmentID);
                        html_content = $('#printapprovedreport').html();
                    }else{
                        p_approvedrep_setParamsWithComment(data,connmentID);
                        html_content = $('#printapprovedreportWithComment').html();
                    }

                    newwindow=window.open();
                    newdocument=newwindow.document;
                    newwindow.document.write( );
                    newdocument.write(html_content);
                    newdocument.close();

                    newwindow.print();
                    return false;
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $.alert("Error", "অবহতিকরণ বার্তা");
            }
        });

    }else if(reportID == '8'){
        var url ="/monthly_report/printmobilecourtstatisticreport?report_date="+report_date+"&reportID="+reportID;

        $.ajax({
            url: url,
            type: 'POST',
            success: function (data) {
                if(data.result.length == 0){
                    message_show("তথ্য নাই । ");
                }
                else
                {
                    p_mobilecourtstatistic_setParams(data);
                    var html_content = $('#printmobilecourtstatisticreport').html();

                    newwindow=window.open();
                    newdocument=newwindow.document;
                    newwindow.document.write( );
                    newdocument.write(html_content);
                    newdocument.close();

                    newwindow.print();
                    return false;
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $.alert("Error", "অবহতিকরণ বার্তা");
            }
        });
    }
}
function divisionbasedreport(report_date, reportID, connmentID) {

    if (reportID == '1') {
        var url ="/monthly_report/printdivmobilecourtreport?report_date=" + report_date + "&reportID=" + reportID;
     
        $.ajax({
            url: url,
            type: 'POST',
            success: function (data) {
        
                if (data.result.length == 0) {
                    message_show("তথ্য নাই ।   ।");
                }else {
                  

//                    pdivmc_setHeaderParams(connmentID,winprint);
//                    pdivmc_setParams(data,connmentID);
//                    var html_content = $('#printdivmobilecourtreport').html();

                    var html_content ="";
                    if(connmentID == 1){
                        pdivmc_setParams(data);
                        html_content = $('#printdivmobilecourtreport').html();
                    }else{
                        pdivmc_setParamsWithComment(data);
                        html_content = $('#printdivmobilecourtreportWithComment').html();
                    }


                    newwindow = window.open();
                    newdocument = newwindow.document;
                    newwindow.document.write();
                    newdocument.write(html_content);
                    newdocument.close();

                    newwindow.print();
                    return false;
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $.alert("Error", "অবহতিকরণ বার্তা");
            }
        });

    } else if (reportID == '2') {
        var url = "/monthly_report/printdivappealcasereport?report_date=" + report_date + "&reportID=" + reportID;


        $.ajax({
            url: url,
            type: 'POST',
            success: function (data) {
                
                if (data.result.length == 0) {
                    message_show("তথ্য নাই । ");
                }else {
                    console.log(connmentID);
                    var html_content ="";
                    if(connmentID == 1){
                        pdivappealc_setParams(data );
                        html_content = $('#printdivappealcasereport').html();
                    }else{
                        pdivappealc_setParamsWithComment(data );
                        html_content = $('#printdivappealcasereportWithComment').html();
                    }


                    newwindow = window.open();
                    newdocument = newwindow.document;
                    newwindow.document.write();
                    newdocument.write(html_content);
                    newdocument.close();

                    newwindow.print();
                    return false;
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $.alert("Error", "অবহতিকরণ বার্তা");
            }
        });

    } else if (reportID == '3') {
        var url ="/monthly_report/printdivadmcasereport?report_date=" + report_date + "&reportID=" + reportID;

        $.ajax({
            url: url,
            type: 'POST',
            success: function (data) {
                if (data.result.length == 0) {
                    message_show("তথ্য নাই । ");
                }else {

                    var html_content ="";
                    if(connmentID == 1){
                        pdivadmc_setParams(data);
                        html_content = $('#printdivadmcasereport').html();
                    }else{
                        pdivadmc_setParamsWithComment(data);
                        html_content = $('#printdivadmcasereportWithComment').html();
                    }


                    newwindow = window.open();
                    newdocument = newwindow.document;
                    newwindow.document.write();
                    newdocument.write(html_content);
                    newdocument.close();

                    newwindow.print();
                    return false;
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $.alert("Error", "অবহতিকরণ বার্তা");
            }
        });
    } else if (reportID == '4') {
        var url ="/monthly_report/printdivemcasereport?report_date=" + report_date + "&reportID=" + reportID;

        $.ajax({
            url: url,
            type: 'POST',
            success: function (data) {
                if (data.result.length == 0) {
                    message_show("তথ্য নাই । ");
                }else {

                    var html_content ="";
                    if(connmentID == 1){
                        pdivemc_setParams(data );
                        html_content = $('#printdivemcasereport').html();
                    }else{
                        pdivemc_setParamsWithComment(data);
                        html_content = $('#printdivemcasereportWithComment').html();
                    }


                    newwindow = window.open();
                    newdocument = newwindow.document;
                    newwindow.document.write();
                    newdocument.write(html_content);
                    newdocument.close();

                    newwindow.print();
                    return false;

                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $.alert("Error", "অবহতিকরণ বার্তা");
            }
        });


    }else if (reportID == '8') {
        var url ="/monthly_report/printdivapprovedreport?report_date=" + report_date + "&reportID=" + reportID;

        $.ajax({
            url: url,
            type: 'POST',
            success: function (data) {
                if (data.result.length == 0) {
                    message_show("তথ্য নাই । ");
                }else {
                    var html_content ="";
                    if(connmentID == 1){
                        p_divapprovedrep_setParams(data );
                        html_content = $('#printdivapprovedreport').html();
                    }else{
                        pdivemc_setParamsWithComment(data );
                        html_content = $('#printdivemcasereportWithComment').html();
                    }


                    newwindow = window.open();
                    newdocument = newwindow.document;
                    newwindow.document.write();
                    newdocument.write(html_content);
                    newdocument.close();

                    newwindow.print();
                    return false;

                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $.alert("Error", "অবহতিকরণ বার্তা");
            }
        });

    }
}

function graphCourt() {

    var report_date = $('#report_date').val() ;
    var report_date2 = $('#report_date2').val() ;
    $.ajax({
        type: "GET",
        dataType: 'json',
        url: "../monthly_report/ajaxDataCourt?report_date="+report_date+"&report_date2="+report_date2 ,// This is the URL to the API

        success:function (response) {
            console.log(response[0].length );
            
            if(response[0].length > 0){
                $('#displaydiv').empty();
                var divtemp =  "";
                divtemp += '<div style="margin-left: 1px">' +
                    '<div class="clearfix">' +
                    '<div class="panel  panel-default">' +
                    // '<div class="panel-heading panel-heading-dashboard">' +
//                    '<h3 class="panel-title-dashboard">' +
//                    'মাসভিত্তিক মোবাইল কোর্ট পরিচালনার প্রমাপ ও সংখ্যা (বিভাগভিত্তিক)' +
//                    '</h3>' +
//                     '</div>' +
                    '<div class="panel-body cpv padding15">' +
                    '<div id="hero-bar-court-js" style="width:100%;height:200px"></div>' +
                    '</div>' +
                    // '<div class="panel-footer panel-footer-thin">' +
                    // '</div>' +
                    '</div>' +
                    '</div>';

                jQuery('#displaydiv').append(divtemp);
                var data = response[0];

                legendTextData1 = "";
                legendTextData2 = "";
                legendTextData3 = "";
                var legendText1 = response[0][0]['yData'];
                legendTextData1 = legendText1[0]; // promap
                legendTextData2 = legendText1[1];  // current month
                legendTextData3 = legendText1[2];  // next or pre   month
                var dataPoints1 = [];
                var dataPoints2 = [];
                var dataPoints3 = [];

                for (var k = 0; k <= data.length - 1; k++) {
                    dataPoints1.push({label: data[k].location, y: parseInt(data[k][legendTextData1]), legendText: legendTextData1});
                    dataPoints2.push({label: data[k].location, y: parseInt(data[k][legendTextData2]), legendText: legendTextData2});
                    dataPoints3.push({label: data[k].location, y: parseInt(data[k][legendTextData3]), legendText: legendTextData3});
                }

                CanvasJS.addColorSet("greenShades",
                    [//colorSet Array

                        "#CC3399",
                        "#006400",
                        "#FF6600",
                        "#0033FF",
                        "#90EE90"
                    ]);

                chart_Court = new CanvasJS.Chart("hero-bar-court-js",
                    {
                        backgroundColor: "#FFFFFF",
                        exportEnabled: true,
                        exportFileName: "Graph",
                        zoomEnabled: true,
                        toolTip: {
                            enabled: true,       //disable here
                            animationEnabled: true //disable here
                        },
                        dataPointMaxWidth: 100,
                        title: {
                            text: 'মাসভিত্তিক মোবাইল কোর্ট পরিচালনার প্রমাপ ও সংখ্যা (বিভাগভিত্তিক)' + getMonthName(report_date),
                            fontWeight: "normal",
                            fontColor: "#000000",
                            fontfamily: "verdana",
                            fontSize: 25,
                            padding: 10
                        },
                        colorSet: "greenShades",
                        axisX: {
                            labelFontSize: 16
                        },
                        axisY: {
                            interval: 500
                        },
                        legend: {
                            fontSize: 16,
                            fontFamily: "verdana",
                            fontColor: "#000000",
                            verticalAlign: "bottom",
                            itemMaxWidth: 200
                        },

                        data: [
                            {
                                type: "column",
                                showInLegend: true,
                                legendText: legendTextData1,
                                dataPoints: dataPoints1
                            },
                            {
                                type: "column",
                                showInLegend: true,
                                legendText: legendTextData2,
                                dataPoints: dataPoints2
                            },
                            {
                                type: "column",
                                showInLegend: true,
                                legendText: legendTextData3,
                                dataPoints: dataPoints3
                            }

                        ]
                    });
                chart_Court.render();

            }else{
                alert("দুক্ষিত, ডাটা পাওয়া যায়নি");
            }
        },
        error: function () {
            $.alert("Error", "অবহতিকরণ বার্তা");
        }
    });
}
function graphCase() {
    var report_date = $('#report_date').val() ;
    var report_date2 = $('#report_date2').val() ;

    $.ajax({
        type: "GET",
        dataType: 'json',
        url: "../monthly_report/ajaxDataCase?report_date="+report_date+"&report_date2="+report_date2, // This is the URL to the API

        success:function (response) {
            // When the response to the AJAX request comes back render the chart with new data
//                    console.log(response);
            $('#displaydiv').empty();
            var divtemp =  "";
            divtemp += '<div class="row" style="margin-left: 1px"  >' +
                '<div class="col-md-12">' +
                '<div class="panel  panel-default">' +
                '<div class="panel-heading panel-heading-dashboard">' +
//                '<h3 class="panel-title-dashboard">' +
//                '  মাসভিত্তিক মোট মোবাইল কোর্টের মামলার সংখ্যা' +
//                '</h3>' +
                '</div>' +
                '<div class="panel-body cpv padding15">' +
                '<div id="hero-bar-case-js" style="width:100%;height:200px"></div>' +
                '</div>' +
                '<div class="panel-footer panel-footer-thin">' +
                '</div>' +
                '</div>' +
                '</div>';

            jQuery('#displaydiv').append(divtemp);

            var data = response[0];

            legendTextData1 = "";
            legendTextData2 = "";
            var legendText1 = response[0][0]['yData'];
            legendTextData1 = legendText1[0];
            legendTextData2 = legendText1[1];
            var dataPoints1 = [];
            var dataPoints2 = [];

            for (var k = 0; k <= data.length - 1; k++) {
                dataPoints1.push({label: data[k].location, y: parseInt(data[k][legendTextData1]), legendText: legendTextData1});
                dataPoints2.push({label: data[k].location, y: parseInt(data[k][legendTextData2]), legendText: legendTextData2});
            }


            CanvasJS.addColorSet("greenShades",
                [//colorSet Array

                    "#CC3399",
                    "#006400",
                    "#FF6600",
                    "#0033FF",
                    "#90EE90"
                ]);

            chart_Case = new CanvasJS.Chart("hero-bar-case-js",
                {
                    backgroundColor: "#FFFFFF",
                    exportEnabled: true,
                    exportFileName: "Graph",
                    zoomEnabled: true,
                    toolTip: {
                        enabled: true,       //disable here
                        animationEnabled: true //disable here
                    },
                    dataPointMaxWidth: 100,
                    title: {
                        text: ' মাসভিত্তিক মোট মোবাইল কোর্টের মামলার সংখ্যা' + getMonthName(report_date),
                        fontWeight: "normal",
                        fontColor: "#000000",
                        fontfamily: "verdana",
                        fontSize: 25,
                        padding: 10
                    },
                    colorSet: "greenShades",
                    axisX: {
                        labelFontSize: 16
                    },
                    axisY: {
                        interval: 1000
                    },
                    legend: {
                        fontSize: 16,
                        fontFamily: "verdana",
                        fontColor: "#000000",
                        verticalAlign: "bottom",
                        itemMaxWidth: 150
                    },

                    data: [
                        {
                            type: "column",
                            showInLegend: true,
                            legendText: legendTextData1,
                            dataPoints: dataPoints1
                        },
                        {
                            type: "column",
                            showInLegend: true,
                            legendText: legendTextData2,
                            dataPoints: dataPoints2
                        }

                    ]
                });
            chart_Case.render();
        },
        error:function () {
            message_show("error occured");
        }
    });
}

function graphFine() {
    var report_date = $('#report_date').val() ;
    var report_date2 = $('#report_date2').val() ;
    $.ajax({
        type: "GET",
        dataType: 'json',
        url: "../monthly_report/ajaxDataFine?report_date="+report_date+"&report_date2="+report_date2, // This is the URL to the API
        success:function (response) {
            // When the response to the AJAX request comes back render the chart with new data
//                    console.log(response);
            if(response[0].length > 0){

                $('#displaydiv').empty();
                var divtemp =  "";
                divtemp += '<div class="row" style="margin-left: 1px"  >' +
                    '<div class="col-md-12">' +
                    '<div class="panel  panel-default">' +
                    '<div class="panel-heading panel-heading-dashboard">' +
//                    '<h3 class="panel-title-dashboard">' +
//                    ' মাসভিত্তিক মোবাইল কোর্টে আদায়কৃত অর্থের পরিমাণ(টাকায়)' +
//                    '</h3>' +
                    '</div>' +
                    '<div class="panel-body cpv padding15">' +
                    '<div id="hero-bar-fine-js" style="width:100%;height:200px"></div>' +
                    '</div>' +
                    '<div class="panel-footer panel-footer-thin">' +
                    '</div>' +
                    '</div>' +
                    '</div>';

                jQuery('#displaydiv').append(divtemp);


                var data = response[0];

                legendTextData1 = "";
                legendTextData2 = "";
                var legendText1 = response[0][0]['yData'];
                legendTextData1 = legendText1[0];
                legendTextData2 = legendText1[1];
                var dataPoints1 = [];
                var dataPoints2 = [];

                for (var k = 0; k <= data.length - 1; k++) {
                    dataPoints1.push({label: data[k].location, y: parseInt(data[k][legendTextData1]), legendText: legendTextData1});
                    dataPoints2.push({label: data[k].location, y: parseInt(data[k][legendTextData2]), legendText: legendTextData2});

                }


                CanvasJS.addColorSet("greenShades",
                    [//colorSet Array

                        "#CC3399",
                        "#006400",
                        "#FF6600",
                        "#0033FF",
                        "#90EE90"
                    ]);

                chart_Fine = new CanvasJS.Chart("hero-bar-fine-js",
                    {
                        backgroundColor: "#FFFFFF",
                        exportEnabled: true,
                        exportFileName: "Graph",
                        zoomEnabled: true,
                        toolTip: {
                            enabled: true,       //disable here
                            animationEnabled: true //disable here
                        },
                        dataPointMaxWidth: 20,
                        title: {
                            text: ' মাসভিত্তিক মোবাইল কোর্টে আদায়কৃত জরিমানার পরিমাণ(টাকায়)' + getMonthName(report_date),
                            fontWeight: "normal",
                            fontColor: "#000000",
                            fontfamily: "verdana",
                            fontSize: 25,
                            padding: 10
                        },
                        colorSet: "greenShades",
                        axisX: {
                            labelFontSize: 16
                        },
                        legend: {
                            fontSize: 16,
                            fontFamily: "verdana",
                            fontColor: "#000000",
                            verticalAlign: "bottom",
                            itemMaxWidth: 150
                        },

                        data: [
                            {
                                type: "column",
                                showInLegend: true,
                                legendText: legendTextData1,
                                dataPoints: dataPoints1
                            },
                            {
                                type: "column",
                                showInLegend: true,
                                legendText: legendTextData2,
                                dataPoints: dataPoints2
                            }

                        ]
                    });
                chart_Fine.render();

            }
        },
        error:function () {
            message_show("error occured");
        }
    });
}

function graphAppeal() {
    var report_date = $('#report_date').val() ;
    var report_date2 = $('#report_date2').val() ;
    $.ajax({
        type: "GET",
        dataType: 'json',
        url: "../monthly_report/ajaxDataAppeal?report_date="+report_date+"&report_date2="+report_date2, // This is the URL to the API

        success:function (response) {
            // When the response to the AJAX request comes back render the chart with new data
//                    console.log(response);
            if(response[0].length > 0){
                $('#displaydiv').empty();
                var divtemp =  "";
                divtemp += '<div class="row" style="margin-left: 1px"  >' +
                    '<div class="col-md-12">' +
                    '<div class="panel  panel-default">' +
                    '<div class="panel-heading panel-heading-dashboard">' +
                    '</div>' +
                    '<div class="panel-body cpv padding15">' +
                    '<div id="hero-bar-appeal-js" style="width:100%;height:200px"></div>' +
                    '</div>' +
                    '<div class="panel-footer panel-footer-thin">' +
                    '</div>' +
                    '</div>' +
                    '</div>';

                jQuery('#displaydiv').append(divtemp);

                var data = response[0];

                legendTextData1 = "";
                legendTextData2 = "";
                legendTextData3 = "";
                legendTextData4 = "";
                var legendText1 = response[0][0]['yData'];
                legendTextData1 = legendText1[0];
                legendTextData2 = legendText1[1];
                legendTextData3 = legendText1[2];
                legendTextData4 = legendText1[3];
                var dataPoints1 = [];
                var dataPoints2 = [];
                var dataPoints3 = [];
                var dataPoints4 = [];


                for (var i = 0; i <= data.length - 1; i++) {
                    dataPoints1.push({label: data[i].location, y: parseInt(data[i][legendTextData1]), legendText: legendTextData1});
                    dataPoints2.push({label: data[i].location, y: parseInt(data[i][legendTextData2]), legendText: legendTextData2});
                    dataPoints3.push({label: data[i].location, y: parseInt(data[i][legendTextData3]), legendText: legendTextData3});
                    dataPoints4.push({label: data[i].location, y: parseInt(data[i][legendTextData4]), legendText: legendTextData4});

                }

                CanvasJS.addColorSet("greenShades",
                    [//colorSet Array

                        "#CC3399",
                        "#006400",
                        "#FF6600",
                        "#0033FF",
                        "#90EE90"
                    ]);

                chart_Appeal = new CanvasJS.Chart("hero-bar-appeal-js",
                    {
                        backgroundColor: "#FFFFFF",
                        exportEnabled: true,
                        exportFileName: "Graph",
                        zoomEnabled: true,
                        toolTip: {
                            enabled: true,       //disable here
                            animationEnabled: true //disable here
                        },
                        dataPointMaxWidth: 100,
                        title: {
                            text: 'মোবাইল কোর্ট আইনের আওতায় দায়েরকৃত আপিল মামলার বিবরণ ' + getMonthName(report_date),
                            fontWeight: "normal",
                            fontColor: "#000000",
                            fontfamily: "verdana",
                            fontSize: 25,
                            padding: 10
                        },
                        colorSet: "greenShades",
                        axisX: {
                            labelFontSize: 16
                        },
                        legend: {
                            fontSize: 16,
                            fontFamily: "verdana",
                            fontColor: "#000000",
                            verticalAlign: "bottom",
                            itemMaxWidth: 150
                        },

                        data: [
                            {
                                type: "column",
                                showInLegend: true,
                                legendText: legendTextData1,
                                dataPoints: dataPoints1
                            },
                            {
                                type: "column",
                                showInLegend: true,
                                legendText: legendTextData2,
                                dataPoints: dataPoints2
                            },
                            {
                                type: "column",
                                showInLegend: true,
                                legendText: legendTextData3,
                                dataPoints: dataPoints3
                            },
                            {
                                type: "column",
                                showInLegend: true,
                                legendText: legendTextData4,
                                dataPoints: dataPoints4
                            }

                        ]
                    });
                chart_Appeal.render();
            }
        },
        error:function () {
            message_show("error occured");
        }
    });
}

function graphEm() {
    var report_date = $('#report_date').val() ;
    var report_date2 = $('#report_date2').val() ;
    $.ajax({
        type: "GET",
        dataType: 'json',
        url: "../monthly_report/ajaxDataEm?report_date="+report_date+"&report_date2="+report_date2,  // This is the URL to the API

        success:function (response) {
            // When the response to the AJAX request comes back render the chart with new data
//                    console.log(response);
            if(response[0].length > 0){

                $('#displaydiv').empty();
                var divtemp =  "";
                divtemp += '<div class="row" style="margin-left: 1px"  >' +
                    '<div class="col-md-12">' +
                    '<div class="panel  panel-default">' +
                    '<div class="panel-heading panel-heading-dashboard">' +
//                    '<h3 class="panel-title-dashboard">' +
//                    ' এক্সিকিউটিভ  ম্যাজিস্ট্রেট আদালতে ফৌ. কা. এর আওতাধীন মামলার তথ্য'  +
//                    '<span id="emreportmonth"></span>' +
//                    '</h3>' +
                    '</div>' +
                    '<div class="panel-body cpv padding15">' +
                    '<div id="hero-bar-em-js" style="width:100%;height:200px"></div>' +
                    '</div>' +
                    '<div class="panel-footer panel-footer-thin">' +
                    '</div>' +
                    '</div>' +
                    '</div>';

                jQuery('#displaydiv').append(divtemp);


                var data = response[0];


                legendTextData1 = "";
                legendTextData2 = "";
                legendTextData3 = "";
                legendTextData4 = "";
                titleText = 'এক্সিকিউটিভ  ম্যাজিস্ট্রেট আদালতে ফৌ. কা. এর আওতাধীন মামলার তথ্য' + getMonthName(report_date);
                var legendText1 = response[0][0]['yData'];
                legendTextData1 = legendText1[0];
                legendTextData2 = legendText1[1];
                legendTextData3 = legendText1[2];
                legendTextData4 = legendText1[3];
                var dataPoints1 = [];
                var dataPoints2 = [];
                var dataPoints3 = [];
                var dataPoints4 = [];


                for (var i = 0; i <= data.length - 1; i++) {
                    dataPoints1.push({label: data[i].location, y: parseInt(data[i][legendTextData1]), legendText: legendTextData1});
                    dataPoints2.push({label: data[i].location, y: parseInt(data[i][legendTextData2]), legendText: legendTextData2});
                    dataPoints3.push({label: data[i].location, y: parseInt(data[i][legendTextData3]), legendText: legendTextData3});
                    dataPoints4.push({label: data[i].location, y: parseInt(data[i][legendTextData4]), legendText: legendTextData4});

                }


                CanvasJS.addColorSet("greenShades",
                    [//colorSet Array

                        "#CC3399",
                        "#006400",
                        "#FF6600",
                        "#0033FF",
                        "#90EE90"
                    ]);

                chart_Em = new CanvasJS.Chart("hero-bar-em-js",
                    {
                        backgroundColor: "#FFFFFF",
                        exportEnabled: true,
                        exportFileName: "Graph",
                        zoomEnabled: true,
                        toolTip: {
                            enabled: true,       //disable here
                            animationEnabled: true //disable here
                        },
                        dataPointMaxWidth: 100,
                        title: {
                            text: titleText,
                            fontWeight: "normal",
                            fontColor: "#000000",
                            fontfamily: "verdana",
                            fontSize: 25,
                            padding: 10
                        },
                        colorSet: "greenShades",
                        axisX: {
                            labelFontSize: 16
                        },
                        legend: {
                            fontSize: 16,
                            fontFamily: "verdana",
                            fontColor: "#000000",
                            verticalAlign: "bottom",
                            itemMaxWidth: 150
                        },

                        data: [
                            {
                                type: "column",
                                showInLegend: true,
                                legendText: legendTextData1,
                                dataPoints: dataPoints1
                            },
                            {
                                type: "column",
                                showInLegend: true,
                                legendText: legendTextData2,
                                dataPoints: dataPoints2
                            },
                            {
                                type: "column",
                                showInLegend: true,
                                legendText: legendTextData3,
                                dataPoints: dataPoints3
                            },
                            {
                                type: "column",
                                showInLegend: true,
                                legendText: legendTextData4,
                                dataPoints: dataPoints4
                            }

                        ]
                    });
                chart_Em.render();
            }
        },
        error:function () {
            message_show("error occured");
        }
    });
}

function graphAdm() {
    var report_date = $('#report_date').val() ;
    var report_date2 = $('#report_date2').val() ;
//    alert("ada");
    $.ajax({
        type: "GET",
        dataType: 'json',
        url: "../monthly_report/ajaxDataAdm?report_date="+report_date+"&report_date2="+report_date2, // This is the URL to the API

        success:function (response) {
            // When the response to the AJAX request comes back render the chart with new data
//                    console.log(response);
            if(response[0].length > 0){
                $('#displaydiv').empty();
                var divtemp =  "";
                divtemp += '<div class="row" style="margin-left: 1px"  >' +
                    '<div class="col-md-12">' +
                    '<div class="panel  panel-default">' +
                    '<div class="panel-heading panel-heading-dashboard">' +
//                    '<h3 class="panel-title-dashboard">' +
//                    'অতিরিক্ত জেলা ম্যাজিস্ট্রেট আদালতে ফৌ. কা. এর আওতাধীন মামলার তথ্য '  +
//                    '<span id="admreportmonth"></span>' +
//                    '</h3>' +
                    '</div>' +
                    '<div class="panel-body cpv padding15">' +
                    '<div id="hero-bar-adm-js" style="width:100%;height:200px"></div>' +
                    '</div>' +
                    '<div class="panel-footer panel-footer-thin">' +
                    '</div>' +
                    '</div>' +
                    '</div>';

                jQuery('#displaydiv').append(divtemp);
                var data = response[0];

                legendTextData1 = "";
                legendTextData2 = "";
                legendTextData3 = "";
                legendTextData4 = "";
                var legendText1 = response[0][0]['yData'];
                legendTextData1 = legendText1[0];
                legendTextData2 = legendText1[1];
                legendTextData3 = legendText1[2];
                legendTextData4 = legendText1[3];
                var dataPoints1 = [];
                var dataPoints2 = [];
                var dataPoints3 = [];
                var dataPoints4 = [];


                for (var i = 0; i <= data.length - 1; i++) {
                    dataPoints1.push({label: data[i].location, y: parseInt(data[i][legendTextData1]), legendText: legendTextData1});
                    dataPoints2.push({label: data[i].location, y: parseInt(data[i][legendTextData2]), legendText: legendTextData2});
                    dataPoints3.push({label: data[i].location, y: parseInt(data[i][legendTextData3]), legendText: legendTextData3});
                    dataPoints4.push({label: data[i].location, y: parseInt(data[i][legendTextData4]), legendText: legendTextData4});

                }


                CanvasJS.addColorSet("greenShades",
                    [//colorSet Array

                        "#CC3399",
                        "#006400",
                        "#FF6600",
                        "#0033FF",
                        "#90EE90"
                    ]);

                chart_Adm = new CanvasJS.Chart("hero-bar-adm-js",
                    {
                        backgroundColor: "#FFFFFF",
                        exportEnabled: true,
                        exportFileName: "Graph",
                        zoomEnabled: true,
                        toolTip: {
                            enabled: true,       //disable here
                            animationEnabled: true //disable here
                        },
                        dataPointMaxWidth: 100,
                        title: {
                            text: 'অতিরিক্ত জেলা ম্যাজিস্ট্রেট আদালতে ফৌ. কা. এর আওতাধীন মামলার তথ্য ' + getMonthName(report_date),
                            fontWeight: "normal",
                            fontColor: "#000000",
                            fontfamily: "verdana",
                            fontSize: 25,
                            padding: 10
                        },
                        colorSet: "greenShades",
                        axisX: {
                            labelFontSize: 16
                        },
                        legend: {
                            fontSize: 16,
                            fontFamily: "verdana",
                            fontColor: "#000000",
                            verticalAlign: "bottom",
                            itemMaxWidth: 150
                        },

                        data: [
                            {
                                type: "column",
                                showInLegend: true,
                                legendText: legendTextData1,
                                dataPoints: dataPoints1
                            },
                            {
                                type: "column",
                                showInLegend: true,
                                legendText: legendTextData2,
                                dataPoints: dataPoints2
                            },
                            {
                                type: "column",
                                showInLegend: true,
                                legendText: legendTextData3,
                                dataPoints: dataPoints3
                            },
                            {
                                type: "column",
                                showInLegend: true,
                                legendText: legendTextData4,
                                dataPoints: dataPoints4
                            }

                        ]
                    });
                chart_Adm.render();
            }
        },
        error:function () {
            message_show(" error occured ");
        }
    });
}


function getMonthName(date) {
    var convertedMonth = "";

    var dateArray = date.split("-");
    var month = "";


    month = dateArray[0].replace(/^0+/, '');

    var bangDATE = ['জানুয়ারী', 'ফেব্রুয়ারী', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 'জুলাই', 'আগস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর'];
    convertedMonth = bangDATE[month - 1];
    return " ," + convertedMonth + " " + replaceNumbers(dateArray[1]);


}

function replaceNumbers(input) {


    var digits = ("" + input).split("");

    var bn_digits = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];

    return  bn_digits[digits[0]] + bn_digits[digits[1]] + bn_digits[digits[2]] + bn_digits[digits[3]];
}


function deleteCell(tablenName,col_no1,col_no2,deltr) {

    var table  = document.getElementById(tablenName);
    var rows = table.getElementsByTagName('tr');


    var removecell1 = col_no1-1;
    var removecell2 = col_no2-1;

//    alert("col_no1 - " + col_no1);
//    alert("col_no2  - " + col_no2);
//    alert("rows.length - " + rows.length);

    for (var row=0; row<rows.length;row++) {
//        alert(JSON.stringify(rows[row]));
        if(row == 2){
//            alert(JSON.stringify(rows[row]));
            rows[row].deleteCell(removecell1);
        }else if(row > deltr)
            rows[row].deleteCell(removecell2);
    }
}

