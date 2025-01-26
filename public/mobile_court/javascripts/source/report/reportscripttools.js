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

    var chec2 = $('#report_date2').datepicker({
        format: "mm-yyyy",
        viewMode: "months",
        minViewMode: "months",
        changeMonth: true,
        changeYear: true
    }).on('changeDate', function(ev) {
        chec2.hide();
    }).data('datepicker');







//    graphCourtForCountry();
//    graphCaseForCountry();
//    graphFineForCountry();
//    graphAppealForCountry();
//    graphEmForCountry();
//    graphAdmForCountry();


});

function showGraph(){
    var graphID = $('#graphlist').val() ;
    var report_date = $('#report_date').val() ;
    var report_date2 = $('#report_date2').val() ;

    if(report_date ==""){
        alert("মাস নির্বাচন করুন ।");
        return false;
    }

//    if(graphID == '1'){
//        graphCourtForCountry();
//    }else if(graphID == '2'){
//        graphCaseForCountry();
//    }else if(graphID == '3'){
//        graphFineForCountry();
//    }else if(graphID == '4'){
//        graphAppealForCountry();
//    }else if(graphID == '5'){
//        graphEmForCountry();
//    }else if(graphID == '6'){
//        graphAdmForCountry();
//    } else{
//        alert("Please select a Graph ");
//    }

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
        alert("Please select a Graph ");
    }

}

//
//
//function showReport(){
//
//    var reportID = $('#reportlist').val() ;
//    var graphID = $('#graphlist').val() ;
//    var report_date = $('#report_date').val() ;
//    var report_date2 = $('#report_date2').val() ;
//
//
//
////
////    if(report_date ==""){
////        message_show("মাস নির্বাচন করুন ।");
////        return false;
////    }
//
//    if(reportID == '1'){
//        var url =  base_path + "/report/printmobilecourtreport?report_date="+report_date+"&reportID="+reportID+"&report_date2="+report_date2;
//
//        $.post(url, function(data) {
//        })
//            .success(function(data) {
//                if(data.result.length == 0){
//                    alert("No Data Found");
//                }
//            })
//            .error(function() {
//            })
//            .complete(function() {
//            });
//
//    }else if(reportID == '2'){
//        var url =  base_path + "/monthly_report/printappealcasereport?report_date="+report_date+"&reportID="+reportID+"&report_date2="+report_date2;
//
//        $.post(url, function(data) {
//        })
//            .success(function(data) {
//                if(data.result.length == 0){
//                    alert("No Data Found");
//                }
//
//            })
//            .error(function() {
//            })
//            .complete(function() {
//            });
//    }else if(reportID == '3'){
//        var url =  base_path + "/monthly_report/printadmcasereport?report_date="+report_date+"&reportID="+reportID+"&report_date2="+report_date2;
//
//        $.post(url, function(data) {
//        })
//            .success(function(data) {
//                if(data.result.length == 0){
//                    alert("No Data Found");
//                }
//            })
//            .error(function() {
//            })
//            .complete(function() {
//            });
//    }else if(reportID == '4'){
//        var url =  base_path + "/monthly_report/printemcasereport?report_date="+report_date+"&reportID="+reportID+"&report_date2="+report_date2;
//
//
//        $.post(url, function(data) {
//        })
//            .success(function(data) {
//                if(data.result.length == 0){
//                    alert("No Data Found");
//                }
//            })
//            .error(function() {
//            })
//            .complete(function() {
//            });
//    }else if(reportID == '5'){
//        var url =  base_path + "/monthly_report/printcourtvisitreport?report_date="+report_date+"&reportID="+reportID+"&report_date2="+report_date2;
//        $.post(url, function(data) {
//        })
//            .success(function(data) {
//                if(data.result.length == 0){
//                    alert("No Data Found");
//                }
//            })
//            .error(function() {
//            })
//            .complete(function() {
//            });
//    }else if(reportID == '6'){
//        var url =  base_path + "/monthly_report/printcaserecordreport?report_date="+report_date+"&reportID="+reportID+"&report_date2="+report_date2;
//
//        $.post(url, function(data) {
//        })
//            .success(function(data) {
//                if(data.result.length == 0){
//                    alert("No Data Found");
//                }
//            })
//            .error(function() {
//            })
//            .complete(function() {
//            });
//    }
//    else{
//        alert("Please select a report ");
//    }
//}

function graphCourt() {

    var report_date = $('#report_date').val() ;
    var report_date2 = $('#report_date2').val() ;
    $.ajax({
        type: "GET",
        dataType: 'json',
        url: "../monthly_report/ajaxDataCourt?report_date="+report_date+"&report_date2="+report_date2 // This is the URL to the API
    })
        .done(function (response) {
            // When the response to the AJAX request comes back render the chart with new data
//                    console.log(response);
            if(response[0].length > 0){
                $('#displaydiv').empty();
                var divtemp =  "";
                divtemp += '<div class="row" style="margin-left: 1px"  >' +
                    '<div class="col-md-12">' +
                    '<div class="panel  panel-default">' +
                    '<div class="panel-heading panel-heading-dashboard">' +
                    '<h3 class="panel-title-dashboard">' +
                    'মাসভিত্তিক মোট মোবাইল কোর্টের সংখ্যা ' +
                    '</h3>' +
                    '</div>' +
                    '<div class="panel-body cpv padding15">' +
                    '<div id="hero-bar-court-js" style="width:100%;height:200px"></div>' +
                    '</div>' +
                    '<div class="panel-footer panel-footer-thin">' +
                    '</div>' +
                    '</div>' +
                    '</div>';

                jQuery('#displaydiv').append(divtemp);

                chart_Court = Morris.Bar({
                    element: 'hero-bar-court-js',
                    data: [0, 0], // Set initial data (ideally you would provide an array of default data)
                    xkey: 'location', // Set the key for X-axis
                    ykeys: yData, // Set the key for Y-axis
                    labels: yData, // Set the label when bar is rolled over
                    resize: true,
                    barRatio: 0.6,
                    xLabelMargin: 0.5,
                    axes: true,
                    barColors: ['#CC3399','#000099', '#FF6600' ,'#0033FF']

                });

                var data = response[0][0]['yData'];
                yData.length = 0;
                for (var i = 0; i < data.length; i++) {
                    yData.push(data[i]);
                }
                chart_Court.setData(response[0]);

            }
        })
        .fail(function () {
            alert("error occured");
        });
}
function graphCase() {
    var report_date = $('#report_date').val() ;
    var report_date2 = $('#report_date2').val() ;

    $.ajax({
        type: "GET",
        dataType: 'json',
        url: "../monthly_report/ajaxDataCase?report_date="+report_date+"&report_date2="+report_date2 // This is the URL to the API
    })
        .done(function (response) {
            // When the response to the AJAX request comes back render the chart with new data
//                    console.log(response);
            $('#displaydiv').empty();
            var divtemp =  "";
            divtemp += '<div class="row" style="margin-left: 1px"  >' +
                '<div class="col-md-12">' +
                '<div class="panel  panel-default">' +
                '<div class="panel-heading panel-heading-dashboard">' +
                '<h3 class="panel-title-dashboard">' +
                '  মাসভিত্তিক মোট মোবাইল কোর্টের মামলার সংখ্যা' +
                '</h3>' +
                '</div>' +
                '<div class="panel-body cpv padding15">' +
                '<div id="hero-bar-case-js" style="width:100%;height:200px"></div>' +
                '</div>' +
                '<div class="panel-footer panel-footer-thin">' +
                '</div>' +
                '</div>' +
                '</div>';

            jQuery('#displaydiv').append(divtemp);

            chart_Case = Morris.Bar({
                element: 'hero-bar-case-js',
                axes: true,
                data: [0, 0], // Set initial data (ideally you would provide an array of default data)
                xkey: 'location', // Set the key for X-axis
                ykeys: yData, // Set the key for Y-axis
                labels: yData, // Set the label when bar is rolled over
                resize: true,
                barRatio: 0.6,
                xLabelMargin: 0.5,
                hideHover: 'auto',
                barColors: ['#CC3399', '#006400', '#FF6600','#0033FF'],
                gridEnabled:false

            });

            if(response[0].length > 0){
                var data = response[0][0]['yData'];
                yData.length = 0;
                for (var i = 0; i < data.length; i++) {
                    yData.push(data[i]);
                }
                chart_Case.setData(response[0]);
            }
        })
        .fail(function () {
            alert("error occured");
        });
}

function graphFine() {
    var report_date = $('#report_date').val() ;
    var report_date2 = $('#report_date2').val() ;
    $.ajax({
        type: "GET",
        dataType: 'json',
        url: "../monthly_report/ajaxDataFine?report_date="+report_date+"&report_date2="+report_date2 // This is the URL to the API
    })
        .done(function (response) {
            // When the response to the AJAX request comes back render the chart with new data
//                    console.log(response);
            if(response[0].length > 0){

                $('#displaydiv').empty();
                var divtemp =  "";
                divtemp += '<div class="row" style="margin-left: 1px"  >' +
                    '<div class="col-md-12">' +
                    '<div class="panel  panel-default">' +
                    '<div class="panel-heading panel-heading-dashboard">' +
                    '<h3 class="panel-title-dashboard">' +
                    ' মাসভিত্তিক মোবাইল কোর্টে আদায়কৃত অর্থের পরিমাণ(টাকায়)' +
                    '</h3>' +
                    '</div>' +
                    '<div class="panel-body cpv padding15">' +
                    '<div id="hero-bar-fine-js" style="width:100%;height:200px"></div>' +
                    '</div>' +
                    '<div class="panel-footer panel-footer-thin">' +
                    '</div>' +
                    '</div>' +
                    '</div>';

                jQuery('#displaydiv').append(divtemp);

                chart_Fine = Morris.Bar({
                    element: 'hero-bar-fine-js',
                    axes: true,
                    data: [0, 0], // Set initial data (ideally you would provide an array of default data)
                    xkey: 'location', // Set the key for X-axis
                    ykeys: yData, // Set the key for Y-axis
                    labels: yData, // Set the label when bar is rolled over
                    resize: true,
                    barRatio: 0.6,
                    xLabelMargin: 0.5,
                    hideHover: 'auto',
                    barColors: ['#CC3399','#000099', '#FF6600' ,'#0033FF'],
                    gridEnabled:false

                });

                var data = response[0][0]['yData'];
                yData.length = 0;
                for (var i = 0; i < data.length; i++) {
                    yData.push(data[i]);
                }
                chart_Fine.setData(response[0]);
            }
        })
        .fail(function () {
            alert("error occured");
        });
}

function graphAppeal() {
    var report_date = $('#report_date').val() ;
    var report_date2 = $('#report_date2').val() ;
    $.ajax({
        type: "GET",
        dataType: 'json',
        url: "../monthly_report/ajaxDataAppeal?report_date="+report_date+"&report_date2="+report_date2 // This is the URL to the API
    })
        .done(function (response) {
            // When the response to the AJAX request comes back render the chart with new data
//                    console.log(response);
            if(response[0].length > 0){
                $('#displaydiv').empty();
                var divtemp =  "";
                divtemp += '<div class="row" style="margin-left: 1px"  >' +
                    '<div class="col-md-12">' +
                    '<div class="panel  panel-default">' +
                    '<div class="panel-heading panel-heading-dashboard">' +
                    '<h3 class="panel-title-dashboard">' +
                    'মোবাইল কোর্ট আইনের আওতায় দায়েরকৃত আপিল মামলার বিবরণ '  +
                    '<span style="font: NIKOSHBAN" id="appealreportmonth"></span>' +
                    '</h3>' +
                    '</div>' +
                    '<div class="panel-body cpv padding15">' +
                    '<div id="hero-bar-appeal-js" style="width:100%;height:200px"></div>' +
                    '</div>' +
                    '<div class="panel-footer panel-footer-thin">' +
                    '</div>' +
                    '</div>' +
                    '</div>';

                jQuery('#displaydiv').append(divtemp);

                chart_Appeal = Morris.Bar({
                    element: 'hero-bar-appeal-js',
                    axes: true,
                    data: [0, 0], // Set initial data (ideally you would provide an array of default data)
                    xkey: 'location', // Set the key for X-axis
                    ykeys: ['জের','দায়েরকৃত','নিস্পন্ন','অনিস্পন্ন'], // Set the key for Y-axis
                    labels: ['জের','দায়েরকৃত','নিস্পন্ন','অনিস্পন্ন'], // Set the label when bar is rolled over
                    resize: true,
                    barRatio: 0.6,
                    xLabelMargin: 0.5,
                    hideHover: 'auto',
                    barColors: ['#CC3399','#0033FF' , '#FF6600', '#006400','#0033FF'],
                    gridEnabled:false

                });

                chart_Appeal.setData(response[0]);
                document.getElementById("appealreportmonth").innerHTML= response[0][0]['reportmonth'];
            }
        })
        .fail(function () {
            alert("error occured");
        });
}

function graphEm() {
    var report_date = $('#report_date').val() ;
    var report_date2 = $('#report_date2').val() ;
    $.ajax({
        type: "GET",
        dataType: 'json',
        url: "../monthly_report/ajaxDataEm?report_date="+report_date+"&report_date2="+report_date2  // This is the URL to the API
    })
        .done(function (response) {
            // When the response to the AJAX request comes back render the chart with new data
//                    console.log(response);
            if(response[0].length > 0){

                $('#displaydiv').empty();
                var divtemp =  "";
                divtemp += '<div class="row" style="margin-left: 1px"  >' +
                    '<div class="col-md-12">' +
                    '<div class="panel  panel-default">' +
                    '<div class="panel-heading panel-heading-dashboard">' +
                    '<h3 class="panel-title-dashboard">' +
                    ' এক্সিকিউটিভ  ম্যাজিস্ট্রেট আদালতে ফৌ. কা. এর আওতাধীন মামলার তথ্য'  +
                    '<span id="emreportmonth"></span>' +
                    '</h3>' +
                    '</div>' +
                    '<div class="panel-body cpv padding15">' +
                    '<div id="hero-bar-em-js" style="width:100%;height:200px"></div>' +
                    '</div>' +
                    '<div class="panel-footer panel-footer-thin">' +
                    '</div>' +
                    '</div>' +
                    '</div>';

                jQuery('#displaydiv').append(divtemp);

                chart_Em = Morris.Bar({
                    element: 'hero-bar-em-js',
                    axes: true,
                    data: [0, 0], // Set initial data (ideally you would provide an array of default data)
                    xkey: 'location', // Set the key for X-axis
                    ykeys: ['জের','দায়েরকৃত','নিস্পন্ন','অনিস্পন্ন'], // Set the key for Y-axis
                    labels: ['জের','দায়েরকৃত','নিস্পন্ন','অনিস্পন্ন'], // Set the label when bar is rolled over
                    resize: true,
                    barRatio: 0.6,
                    xLabelMargin: 0.5,
                    hideHover: 'auto',
                    barColors: ['#CC3399','#0033FF' , '#FF6600', '#000099'],
                    gridEnabled:false

                });

                chart_Em.setData(response[0]);
                document.getElementById("emreportmonth").innerHTML= response[0][0]['reportmonth'];
            }
        })
        .fail(function () {
            alert("error occured");
        });
}

function graphAdm() {
    var report_date = $('#report_date').val() ;
    var report_date2 = $('#report_date2').val() ;
    $.ajax({
        type: "GET",
        dataType: 'json',
        url: "../monthly_report/ajaxDataAdm?report_date="+report_date+"&report_date2="+report_date2 // This is the URL to the API
    })
        .done(function (response) {
            // When the response to the AJAX request comes back render the chart with new data
//                    console.log(response);
            if(response[0].length > 0){
                $('#displaydiv').empty();
                var divtemp =  "";
                divtemp += '<div class="row" style="margin-left: 1px"  >' +
                    '<div class="col-md-12">' +
                    '<div class="panel  panel-default">' +
                    '<div class="panel-heading panel-heading-dashboard">' +
                    '<h3 class="panel-title-dashboard">' +
                    'অতিরিক্ত জেলা ম্যাজিস্ট্রেট আদালতে ফৌ. কা. এর আওতাধীন মামলার তথ্য '  +
                    '<span id="admreportmonth"></span>' +
                    '</h3>' +
                    '</div>' +
                    '<div class="panel-body cpv padding15">' +
                    '<div id="hero-bar-adm-js" style="width:100%;height:200px"></div>' +
                    '</div>' +
                    '<div class="panel-footer panel-footer-thin">' +
                    '</div>' +
                    '</div>' +
                    '</div>';

                jQuery('#displaydiv').append(divtemp);


                chart_Adm = Morris.Bar({
                    element: 'hero-bar-adm-js',
                    axes: true,
                    data: [0, 0], // Set initial data (ideally you would provide an array of default data)
                    xkey: 'location', // Set the key for X-axis
                    ykeys: ['জের','দায়েরকৃত','নিস্পন্ন','অনিস্পন্ন'], // Set the key for Y-axis
                    labels: ['জের','দায়েরকৃত','নিস্পন্ন','অনিস্পন্ন'], // Set the label when bar is rolled over
                    resize: true,
                    barRatio: 0.6,
                    xLabelMargin: 0.5,
                    hideHover: 'auto',
                    barColors: ['#CC3399','#0033FF' , '#FF6600', '#000099'],
                    gridEnabled:false

                });

                chart_Adm.setData(response[0]);
                document.getElementById("admreportmonth").innerHTML= response[0][0]['reportmonth'];
            }
        })
        .fail(function () {
            alert("error occured");
        });
}

