/**
 * Created by DOEL PC on 4/28/14.
 */

var chart_Court_divcom = null;
var chart_Case_divcom = null;
var chart_Fine_divcom = null;
var chart_Appeal_divcom = null;
var chart_Em_divcom = null;
var chart_Adm_divcom = null;

var yData = [];
var xData = [];

$(document).ready(function(){


    var chec = $('#report_date').datepicker({
        format: "mm-yyyy",
        viewMode: "months",
        minViewMode: "months",
        changeMonth: true,
        changeYear: true
    }).on('changeDate', function(ev) {
        chec.hide();
    }).data('datepicker');


    chart_Court_divcom = Morris.Bar({
        element: 'hero-bar-court-divcom',
        data: [0, 0], // Set initial data (ideally you would provide an array of default data)
        xkey: 'zillaname', // Set the key for X-axis
        ykeys: yData, // Set the key for Y-axis
        labels: yData, // Set the label when bar is rolled over
        resize: true,
        barRatio: 0.6,
        xLabelMargin: 0.5,
//        hideHover: 'auto',
        xLabelAngle: 45,
        axes: true,
        barColors: ['#CC3399','#000099', '#FF6600' ,'#0033FF']

    });

    chart_Case_divcom = Morris.Bar({
        element: 'hero-bar-case-divcom',
        axes: true,
        data: [0, 0], // Set initial data (ideally you would provide an array of default data)
        xkey: 'zillaname', // Set the key for X-axis
        ykeys: yData, // Set the key for Y-axis
        labels: yData, // Set the label when bar is rolled over
        resize: true,
        barRatio: 0.6,
        xLabelMargin: 0.5,
        hideHover: 'auto',
        xLabelAngle: 45,
        barColors: ['#CC3399', '#006400', '#FF6600','#0033FF'],
        gridEnabled:false

    });
    chart_Fine_divcom = Morris.Bar({
        element: 'hero-bar-fine-divcom',
        axes: true,
        data: [0, 0], // Set initial data (ideally you would provide an array of default data)
        xkey: 'zillaname', // Set the key for X-axis
        ykeys: yData, // Set the key for Y-axis
        labels: yData, // Set the label when bar is rolled over
        resize: true,
        barRatio: 0.6,
        xLabelMargin: 0.5,
        hideHover: 'auto',
        xLabelAngle: 45,
        barColors: ['#CC3399','#000099', '#FF6600' ,'#0033FF'],
        gridEnabled:false

    });

    chart_Appeal_divcom = Morris.Bar({
        element: 'hero-bar-appeal-divcom',
        axes: true,
        data: [0, 0], // Set initial data (ideally you would provide an array of default data)
        xkey: 'zillaname', // Set the key for X-axis
        ykeys: ['জের','দায়েরকৃত','নিস্পন্ন','অনিস্পন্ন'], // Set the key for Y-axis
        labels: ['জের','দায়েরকৃত','নিস্পন্ন','অনিস্পন্ন'], // Set the label when bar is rolled over
        resize: true,
        barRatio: 0.6,
        xLabelMargin: 0.5,
        hideHover: 'auto',
        xLabelAngle: 45,
        barColors: ['#CC3399','#0033FF' , '#FF6600', '#006400','#0033FF'],
        gridEnabled:false

    });
    chart_Em_divcom = Morris.Bar({
        element: 'hero-bar-em-divcom',
        axes: true,
        data: [0, 0], // Set initial data (ideally you would provide an array of default data)
        xkey: 'zillaname', // Set the key for X-axis
        ykeys: ['জের','দায়েরকৃত','নিস্পন্ন','অনিস্পন্ন'], // Set the key for Y-axis
        labels: ['জের','দায়েরকৃত','নিস্পন্ন','অনিস্পন্ন'], // Set the label when bar is rolled over
        resize: true,
        barRatio: 0.6,
        xLabelMargin: 0.5,
        hideHover: 'auto',
        xLabelAngle: 45,
        barColors: ['#CC3399','#0033FF' , '#FF6600', '#000099'],
        gridEnabled:false

    });
    chart_Adm_divcom = Morris.Bar({
        element: 'hero-bar-adm-divcom',
        axes: true,
        data: [0, 0], // Set initial data (ideally you would provide an array of default data)
        xkey: 'zillaname', // Set the key for X-axis
        ykeys: ['জের','দায়েরকৃত','নিস্পন্ন','অনিস্পন্ন'], // Set the key for Y-axis
        labels: ['জের','দায়েরকৃত','নিস্পন্ন','অনিস্পন্ন'], // Set the label when bar is rolled over
        resize: true,
        barRatio: 0.6,
        xLabelMargin: 0.5,
        hideHover: 'auto',
        xLabelAngle: 45,
        barColors: ['#CC3399','#0033FF' , '#FF6600', '#000099'],
        gridEnabled:false

    });
    graphCourtForDivision();
    graphCaseForDivision();
    graphFineForDivision();
    graphAppealForDivision();
    graphEmForDivision();
    graphAdmForDivision();


});

function showGraph(){
    var graphID = $('#graphlist').val() ;
    var report_date = $('#report_date').val() ;

    if(report_date ==""){
        alert("মাস নির্বাচন করুন ।");
        return false;
    }

    if(graphID == '1'){
        graphCourtForDivision();
    }else if(graphID == '2'){
        graphCaseForDivision();
    }else if(graphID == '3'){
        graphFineForDivision();
    }else if(graphID == '4'){
        graphAppealForDivision();
    }else if(graphID == '5'){
        graphEmForDivision();
    }else if(graphID == '6'){
        graphAdmForDivision();
    } else{
        alert("Please select a Graph ");
    }


}

function showReport(){

    var reportID = $('#reportlist').val() ;
    var graphID = $('#graphlist').val() ;
    var report_date = $('#report_date').val() ;

    if(report_date ==""){
        alert("মাস নির্বাচন করুন ।");
        return false;
    }

    if(reportID == '1'){
        var url =  base_path + "/monthly_report/printmobilecourtreport?report_date="+report_date+"&reportID="+reportID;

        $.post(url, function(data) {
        })
            .success(function(data) {
                if(data.result.length == 0){
                    alert("No Data Found");
                }
                else
                {
                    pmc_setParams(data);

                    var html_content = $('#printmobilecourtreport').html();

                    newwindow=window.open();
                    newdocument=newwindow.document;
                    newwindow.document.write('<title>প্রতিবেদন </title>');
                    newdocument.write(html_content);
                    newdocument.close();

                    newwindow.print();
                    return false;
                }
            })
            .error(function() {
            })
            .complete(function() {
            });

    }else if(reportID == '2'){
        var url =  base_path + "/monthly_report/printappealcasereport?report_date="+report_date+"&reportID="+reportID;

        $.post(url, function(data) {
        })
            .success(function(data) {
                if(data.result.length == 0){
                    alert("No Data Found");
                }
                else
                {
                    pac_setParams(data);

                    var html_content = $('#printappealcasereport').html();

                    newwindow=window.open();
                    newdocument=newwindow.document;
                    newwindow.document.write('<title>প্রতিবেদন </title>');
                    newdocument.write(html_content);
                    newdocument.close();

                    newwindow.print();
                    return false;
                }
            })
            .error(function() {
            })
            .complete(function() {
            });
    }else if(reportID == '3'){
        var url =  base_path + "/monthly_report/printadmcasereport?report_date="+report_date+"&reportID="+reportID;

        $.post(url, function(data) {
        })
            .success(function(data) {
                if(data.result.length == 0){
                    alert("No Data Found");
                }
                else
                  {

                    padmc_setParams(data);

                    var html_content = $('#printadmcasereport').html();

                    newwindow=window.open();
                    newdocument=newwindow.document;
                    newwindow.document.write('<title>প্রতিবেদন </title>');
                    newdocument.write(html_content);
                    newdocument.close();

                    newwindow.print();
                    return false;
                }
            })
            .error(function() {
            })
            .complete(function() {
            });
    }else if(reportID == '4'){
        var url =  base_path + "/monthly_report/printemcasereport?report_date="+report_date+"&reportID="+reportID;


        $.post(url, function(data) {
        })
            .success(function(data) {
                if(data.result.length == 0){
                    alert("No Data Found");
                }
                else
                {

                    pemc_setParams(data);
                    var html_content = $('#printemcasereport').html();
                    newwindow=window.open();
                    newdocument=newwindow.document;
                    newwindow.document.write('<title>প্রতিবেদন </title>');
                    newdocument.write(html_content);
                    newdocument.close();

                    newwindow.print();
                    return false;

                }
            })
            .error(function() {
            })
            .complete(function() {
            });
    }else if(reportID == '5'){
        var url =  base_path + "/monthly_report/printcourtvisitreport?report_date="+report_date+"&reportID="+reportID;
        $.post(url, function(data) {
        })
            .success(function(data) {
                if(data.result.length == 0){
                    alert("No Data Found");
                }
                else
                {
                    pcv_setParams(data);

                    var html_content = $('#printcourtvisitreport').html();

                    newwindow=window.open();
                    newdocument=newwindow.document;
                    newwindow.document.write('<title>প্রতিবেদন </title>');
                    newdocument.write(html_content);
                    newdocument.close();

                    newwindow.print();
                    return false;
                }
            })
            .error(function() {
            })
            .complete(function() {
            });
    }else if(reportID == '6'){
        var url =  base_path + "/monthly_report/printcaserecordreport?report_date="+report_date+"&reportID="+reportID;

        $.post(url, function(data) {
        })
            .success(function(data) {
                if(data.result.length == 0){
                    alert("No Data Found");
                }
                else
                {
                    pcr_setParams(data);
                    var html_content = $('#printcaserecordreport').html();

                    newwindow=window.open();
                    newdocument=newwindow.document;
                    newwindow.document.write('<title>প্রতিবেদন </title>');
                    newdocument.write(html_content);
                    newdocument.close();

                    newwindow.print();
                    return false;
                }
            })
            .error(function() {
            })
            .complete(function() {
            });
    }
    else{
        alert("Please select a report ");
    }
}

function graphCourtForDivision() {

    var report_date = $('#report_date').val() ;


    $.ajax({
        type: "GET",
        dataType: 'json',
        url: "../monthly_report/ajaxDataCourtForDivision?report_date="+report_date // This is the URL to the API
    })
        .done(function (response) {
            // When the response to the AJAX request comes back render the chart with new data
//                    console.log(response);
            if(response[0].length > 0){

                var data = response[0][0]['yData'];
                yData.length = 0;
                for (var i = 0; i < data.length; i++) {
                    yData.push(data[i]);
                }
                chart_Court_divcom.setData(response[0]);
            }
        })
        .fail(function () {
            alert("error occured");
        });
}
function graphCaseForDivision() {
    var report_date = $('#report_date').val() ;
    $.ajax({
        type: "GET",
        dataType: 'json',
        url: "../monthly_report/ajaxDataCaseForDivision?report_date="+report_date // This is the URL to the API
    })
        .done(function (response) {
            // When the response to the AJAX request comes back render the chart with new data
//                    console.log(response);
            if(response[0].length > 0){
                var data = response[0][0]['yData'];
                yData.length = 0;
                for (var i = 0; i < data.length; i++) {
                    yData.push(data[i]);
                }
                chart_Case_divcom.setData(response[0]);
            }
        })
        .fail(function () {
            alert("error occured");
        });
}

function graphFineForDivision() {
    var report_date = $('#report_date').val() ;
    $.ajax({
        type: "GET",
        dataType: 'json',
        url: "../monthly_report/ajaxDataFineForDivision?report_date="+report_date // This is the URL to the API
    })
        .done(function (response) {
            // When the response to the AJAX request comes back render the chart with new data
//                    console.log(response);
            if(response[0].length > 0){
                var data = response[0][0]['yData'];
                yData.length = 0;
                for (var i = 0; i < data.length; i++) {
                    yData.push(data[i]);
                }
                chart_Fine_divcom.setData(response[0]);
            }
        })
        .fail(function () {
            alert("error occured");
        });
}

function graphAppealForDivision() {
    var report_date = $('#report_date').val() ;
    $.ajax({
        type: "GET",
        dataType: 'json',
        url: "../monthly_report/ajaxDataAppealForDivision?report_date="+report_date // This is the URL to the API
    })
        .done(function (response) {
            // When the response to the AJAX request comes back render the chart with new data
//                    console.log(response);
            if(response[0].length > 0){
                chart_Appeal_divcom.setData(response[0]);
                document.getElementById("appealreportmonth_divcom").innerHTML= response[0][0]['reportmonth'];
            }
        })
        .fail(function () {
            alert("error occured");
        });
}

function graphEmForDivision() {
    var report_date = $('#report_date').val() ;
    $.ajax({
        type: "GET",
        dataType: 'json',
        url: "../monthly_report/ajaxDataEmForDivision?report_date="+report_date// This is the URL to the API
    })
        .done(function (response) {
            // When the response to the AJAX request comes back render the chart with new data
//                    console.log(response);
            if(response[0].length > 0){
                chart_Em_divcom.setData(response[0]);
                document.getElementById("emreportmonth_divcom").innerHTML= response[0][0]['reportmonth'];
            }
        })
        .fail(function () {
            alert("error occured");
        });
}

function graphAdmForDivision() {
    var report_date = $('#report_date').val() ;
    $.ajax({
        type: "GET",
        dataType: 'json',
        url: "../monthly_report/ajaxDataAdmForDivision?report_date="+report_date // This is the URL to the API
    })
        .done(function (response) {
            // When the response to the AJAX request comes back render the chart with new data
//                    console.log(response);
            if(response[0].length > 0){
                chart_Adm_divcom.setData(response[0]);
                document.getElementById("admreportmonth_divcom").innerHTML= response[0][0]['reportmonth'];
            }
        })
        .fail(function () {
            alert("error occured");
        });
}

