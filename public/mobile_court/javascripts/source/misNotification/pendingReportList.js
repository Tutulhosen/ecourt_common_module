let pendingReportList = {
    init: function () {
        $("#reportList").select2("val", "");
    },

    getReportDetails: function () {
        let reportID = $('#reportList').val();
        let report_date = $('#report_date').val();
        let valid = pendingReportList.validateReportInput(reportID, report_date);
        if (valid == true) {
            if(reportID == '1'){
                pendingReportList.reportOneTableDataPopulate(reportID,report_date);
            }else if(reportID == '2'){
                pendingReportList.reportTwoTableDataPopulate(reportID,report_date);
            }else if(reportID == '3'){
                pendingReportList.reportThreeTableDataPopulate(reportID,report_date);
            }else if(reportID == '4'){
                pendingReportList.reportFourTableDataPopulate(reportID,report_date);
            }else if(reportID == '5'){
                pendingReportList.reportFiveTableDataPopulate(reportID,report_date);
            }else if(reportID == '6'){
                pendingReportList.reportSixTableDataPopulate(reportID,report_date);
            }
        }
        else {
            return false;
        }
    },

    populateTableHeading: function (data) {
        pendingReportList.setTableName(data.month_year);
        $('#ReportTable').append(
            '<tr>' +
            '<td style="text-align: center;font-weight: bold;width: 2%;"> ক্রমিক নং</td>' +
            '<td style="text-align: center;font-weight: bold;width: 15%;">জেলার নাম</td>' +
            '<td style="text-align: center;font-weight: bold;width: 4%;"> প্রতিবেদন দাখিল </td>' +
            '<td style="text-align: center;font-weight: bold;width: 4%;">প্রমাপ অর্জন</td>' +
            '<td style="text-align: center;font-weight: bold;width: 4%;">বার্তা কার্যকলাপ</td>' +
            '</tr>');


    },
    sendMessage:function () {
        $('#exampleModal').modal('hide');
        var model = {};
        model.notificationBody=$('#message-text').val();
        model.divId=$('#divId').val();
        model.zillaId=$('#zillaId').val();
        model.profilesId = [];

        $('.notificationProfile:checked').each(function(i){
            model.profilesId[i] = $(this).val();
        });
        console.log(model)

        var formURL = "/misnotification/sendLevelThreeMessage";
        $.ajax({
            url: formURL,
            type: 'POST',
            dataType: 'json',
            data: {'data': model},
            success: function (response, textStatus, jqXHR) {
                console.log('se level msg', response)
                if (response == true) {
                    // alert(" বার্তা  প্রেরণ করা হয়েছে। ", "অবহতিকরণ বার্তা");
                    Swal.fire({
                        title: "অবহতিকরণ বার্তা",
                        text: "বার্তা প্রেরণ করা হয়েছে।",
                        icon: "success"
                    });
                } else {
                    // alert("তথ্য অসম্পূর্ন।  পূনরায় চেষ্টা করুন ।  ", "ধন্যবাদ");
                    Swal.fire({
                        title: "ধন্যবাদ",
                        text: "তথ্য অসম্পূর্ন। পূনরায় চেষ্টা করুন।",
                        icon: "error"
                    });
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // alert("বার্তা  প্রেরণ হয়নি। ", "অবহতিকরণ বার্তা");
                Swal.fire({
                    title: "ধন্যবাদ",
                    text: "বার্তা  প্রেরণ হয়নি।",
                    icon: "error"
                });
            }
        });
    },
    showMessagePopup:function (divId,zillaId) {
        $('#divId').val(divId);
        $('#zillaId').val(zillaId);
        $('#exampleModal').modal('show');
        // Getting Level_3 Message data
        misNotification.getNotificationsData(3).done(function (response,textStatus,jqXHR) {
            $('#message-text').val(response.notificationBody);
        })
    },
    reportSixTableDataPopulate:function (reportID,report_date) {
        let url = "/misnotification/printcaserecordreport?report_date=" + report_date + "&reportID=" + reportID;
        $.ajax({
            url: url,
            type: 'POST',
            success: function (data) {
                console.log(data);
                pendingReportList.populateTableHeading(data);
                if (data.result.length == 0) {
                    message_show("তথ্য নাই  ।");
                }
                else {
                    var myTable = document.getElementById("ReportTable");
                    var rowCount = myTable.rows.length;
                    for (var x = rowCount - 1; x > 1; x--) {
                        myTable.deleteRow(x);
                    }
                    var slno = 0;
                    var rowcount = 0;
                    var divname = "";
                    var zillaname = "";
                    var comment1 = 'হয়েছে';
                    var noofRow = data.result.length;
                    let reportEntry = "-";
                    let messageButton = "-";
                    $(data.result).each(function (index, element) {
                        rowcount++;
                        let divId= element['divid'];
                        let zillaId= element['zillaid'];
                        if (element['comment1'] == "1") {
                            comment1 = 'হয়েছে';
                        } else {
                            comment1 = 'হয়নি';
                        }
                        if(element['caserecord_count'] > 0){
                            reportEntry = 'দাখিল হয়েছে';
                            messageButton = '-';
                        }else{
                            reportEntry = 'দাখিল  হয়নি';
                            messageButton = '<button class="btn btn-xs btn-primary" onclick="pendingReportList.showMessagePopup('+divId+','+zillaId+')">বার্তা  প্রেরণ </button>'
                        }
                        if (divname == element['divname']) {
                            slno++;
                            $('#ReportTable').append(
                                '<tr>' +
                                '<td class="centertext"> ' + slno + '</td>' +
                                '<td class="centertext" > ' + element['zillaname'] + '</td>' +
                                '<td class="centertext" > ' + reportEntry + '</td>' +
                                '<td class="centertext" > ' + comment1 + '</td>' +
                                '<td class="centertext"> ' + messageButton + '</td>' +
                                '</tr>');
                            zillaname = element['zillaname'];


                        } else {
                            slno++;
                            $('#ReportTable').append(
                                '<tr>' +
                                '<td class="centertext" colspan="15" > ' + element['divname'] + " বিভাগ" + '</td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td class="centertext"> ' + slno + '</td>' +
                                '<td class="centertext" > ' + element['zillaname'] + '</td>' +
                                '<td class="centertext" > ' + reportEntry + '</td>' +
                                '<td class="centertext" > ' + comment1 + '</td>' +
                                '<td class="centertext"> ' + messageButton + '</td>' +
                                '</tr>');
                            divname = element['divname'];
                            zillaname = element['zillaname'];
                            if (noofRow == 3) {  // only zilla
                                return false;
                            }
                        }
                    })
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $.alert("Error", "অবহতিকরণ বার্তা");
            }
        });
    },
    reportFiveTableDataPopulate:function (reportID,report_date) {
        let url = "/misnotification/printcourtvisitreport?report_date=" + report_date + "&reportID=" + reportID;
        $.ajax({
            url: url,
            type: 'POST',
            success: function (data) {
                console.log(data);
                pendingReportList.populateTableHeading(data);
                if (data.result.length == 0) {
                    message_show("তথ্য নাই  ।");
                }
                else {
                    var myTable = document.getElementById("ReportTable");
                    var rowCount = myTable.rows.length;
                    for (var x = rowCount - 1; x > 1; x--) {
                        myTable.deleteRow(x);
                    }
                    var slno = 0;
                    var rowcount = 0;
                    var divname = "";
                    var zillaname = "";
                    var comment1 = 'হয়েছে';
                    var noofRow = data.result.length;
                    let reportEntry = "-";
                    let messageButton = "-";
                    $(data.result).each(function (index, element) {
                        rowcount++;
                        let divId= element['divid'];
                        let zillaId= element['zillaid'];
                        if (element['comment1'] == "1") {
                            comment1 = 'হয়েছে';
                        } else {
                            comment1 = 'হয়নি';
                        }
                        if(element['visit_count'] > 0){
                            reportEntry = 'দাখিল হয়েছে';
                            messageButton = '-';
                        }else{
                            reportEntry = 'দাখিল  হয়নি';
                            messageButton = '<button class="btn btn-xs btn-primary" onclick="pendingReportList.showMessagePopup('+divId+','+zillaId+')">বার্তা  প্রেরণ </button>'
                        }
                        if (divname == element['divname']) {
                            slno++;
                            $('#ReportTable').append(
                                '<tr>' +
                                '<td class="centertext"> ' + slno + '</td>' +
                                '<td class="centertext" > ' + element['zillaname'] + '</td>' +
                                '<td class="centertext" > ' + reportEntry + '</td>' +
                                '<td class="centertext" > ' + comment1 + '</td>' +
                                '<td class="centertext"> ' + messageButton + '</td>' +
                                '</tr>');
                            zillaname = element['zillaname'];


                        } else {
                            slno++;
                            $('#ReportTable').append(
                                '<tr>' +
                                '<td class="centertext" colspan="15" > ' + element['divname'] + " বিভাগ" + '</td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td class="centertext"> ' + slno + '</td>' +
                                '<td class="centertext" > ' + element['zillaname'] + '</td>' +
                                '<td class="centertext" > ' + reportEntry + '</td>' +
                                '<td class="centertext" > ' + comment1 + '</td>' +
                                '<td class="centertext"> ' + messageButton + '</td>' +
                                '</tr>');
                            divname = element['divname'];
                            zillaname = element['zillaname'];
                            if (noofRow == 3) {  // only zilla
                                return false;
                            }
                        }
                    })
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $.alert("Error", "অবহতিকরণ বার্তা");
            }
        });
    },
    reportFourTableDataPopulate:function (reportID,report_date) {
        let url = "/misnotification/printemcasereport?report_date=" + report_date + "&reportID=" + reportID;
        $.ajax({
            url: url,
            type: 'POST',
            success: function (data) {
                console.log(data);
                pendingReportList.populateTableHeading(data);
                if (data.result.length == 0) {
                    message_show("তথ্য নাই  ।");
                }
                else {
                    var myTable = document.getElementById("ReportTable");
                    var rowCount = myTable.rows.length;
                    for (var x = rowCount - 1; x > 1; x--) {
                        myTable.deleteRow(x);
                    }
                    var slno = 0;
                    var rowcount = 0;
                    var divname = "";
                    var zillaname = "";
                    var comment1 = 'হয়েছে';
                    var noofRow = data.result.length;
                    let reportEntry = "-";
                    let messageButton = "-";
                    $(data.result).each(function (index, element) {
                        rowcount++;
                        let divId= element['divid'];
                        let zillaId= element['zillaid'];
                        if (element['comment1'] == "1") {
                            comment1 = 'হয়েছে';
                        } else {
                            comment1 = 'হয়নি';
                        }
                        if(element['case_submit'] > 0){
                            reportEntry = 'দাখিল হয়েছে';
                            messageButton = '-';
                        }else{
                            reportEntry = 'দাখিল  হয়নি';
                            messageButton = '<button class="btn btn-xs btn-primary" onclick="pendingReportList.showMessagePopup('+divId+','+zillaId+')">বার্তা  প্রেরণ </button>'
                        }
                        if (divname == element['divname']) {
                            slno++;
                            $('#ReportTable').append(
                                '<tr>' +
                                '<td class="centertext"> ' + slno + '</td>' +
                                '<td class="centertext" > ' + element['zillaname'] + '</td>' +
                                '<td class="centertext" > ' + reportEntry + '</td>' +
                                '<td class="centertext" > ' + comment1 + '</td>' +
                                '<td class="centertext"> ' + messageButton + '</td>' +
                                '</tr>');
                            zillaname = element['zillaname'];


                        } else {
                            slno++;
                            $('#ReportTable').append(
                                '<tr>' +
                                '<td class="centertext" colspan="15" > ' + element['divname'] + " বিভাগ" + '</td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td class="centertext"> ' + slno + '</td>' +
                                '<td class="centertext" > ' + element['zillaname'] + '</td>' +
                                '<td class="centertext" > ' + reportEntry + '</td>' +
                                '<td class="centertext" > ' + comment1 + '</td>' +
                                '<td class="centertext"> ' + messageButton + '</td>' +
                                '</tr>');
                            divname = element['divname'];
                            zillaname = element['zillaname'];
                            if (noofRow == 3) {  // only zilla
                                return false;
                            }
                        }
                    })
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $.alert("Error", "অবহতিকরণ বার্তা");
            }
        });
    },
    reportThreeTableDataPopulate:function (reportID,report_date) {
        let url = "/misnotification/printadmcasereport?report_date=" + report_date + "&reportID=" + reportID;
        $.ajax({
            url: url,
            type: 'POST',
            success: function (data) {
                console.log(data);
                pendingReportList.populateTableHeading(data);
                if (data.result.length == 0) {
                    message_show("তথ্য নাই  ।");
                }
                else {
                    var myTable = document.getElementById("ReportTable");
                    var rowCount = myTable.rows.length;
                    for (var x = rowCount - 1; x > 1; x--) {
                        myTable.deleteRow(x);
                    }
                    var slno = 0;
                    var rowcount = 0;
                    var divname = "";
                    var zillaname = "";
                    var comment1 = 'হয়েছে';
                    var noofRow = data.result.length;
                    let reportEntry = "-";
                    let messageButton = "-";
                    $(data.result).each(function (index, element) {
                        rowcount++;
                        let divId= element['divid'];
                        let zillaId= element['zillaid'];
                        if (element['comment1'] == "1") {
                            comment1 = 'হয়েছে';
                        } else {
                            comment1 = 'হয়নি';
                        }
                        if(element['case_submit'] > 0){
                            reportEntry = 'দাখিল হয়েছে';
                            messageButton = '-';
                        }else{
                            reportEntry = 'দাখিল  হয়নি';
                            messageButton = '<button class="btn btn-xs btn-primary" onclick="pendingReportList.showMessagePopup('+divId+','+zillaId+')">বার্তা  প্রেরণ </button>'
                        }
                        if (divname == element['divname']) {
                            slno++;
                            $('#ReportTable').append(
                                '<tr>' +
                                '<td class="centertext"> ' + slno + '</td>' +
                                '<td class="centertext" > ' + element['zillaname'] + '</td>' +
                                '<td class="centertext" > ' + reportEntry + '</td>' +
                                '<td class="centertext" > ' + comment1 + '</td>' +
                                '<td class="centertext"> ' + messageButton + '</td>' +
                                '</tr>');
                            zillaname = element['zillaname'];


                        } else {
                            slno++;
                            $('#ReportTable').append(
                                '<tr>' +
                                '<td class="centertext" colspan="15" > ' + element['divname'] + " বিভাগ" + '</td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td class="centertext"> ' + slno + '</td>' +
                                '<td class="centertext" > ' + element['zillaname'] + '</td>' +
                                '<td class="centertext" > ' + reportEntry + '</td>' +
                                '<td class="centertext" > ' + comment1 + '</td>' +
                                '<td class="centertext"> ' + messageButton + '</td>' +
                                '</tr>');
                            divname = element['divname'];
                            zillaname = element['zillaname'];
                            if (noofRow == 3) {  // only zilla
                                return false;
                            }
                        }
                    })
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $.alert("Error", "অবহতিকরণ বার্তা");
            }
        });
    },
    reportTwoTableDataPopulate:function (reportID,report_date) {
        let url = "/misnotification/printappealcasereport?report_date=" + report_date + "&reportID=" + reportID;
        $.ajax({
            url: url,
            type: 'POST',
            success: function (data) {
                console.log(data);
                pendingReportList.populateTableHeading(data);
                if (data.result.length == 0) {
                    message_show("তথ্য নাই  ।");
                }
                else {
                    var myTable = document.getElementById("ReportTable");
                    var rowCount = myTable.rows.length;
                    for (var x = rowCount - 1; x > 1; x--) {
                        myTable.deleteRow(x);
                    }
                    var slno = 0;
                    var rowcount = 0;
                    var divname = "";
                    var zillaname = "";
                    var comment1 = 'হয়েছে';
                    var noofRow = data.result.length;
                    let reportEntry = "-";
                    let messageButton = "-";
                    $(data.result).each(function (index, element) {
//           alert(JSON.stringify(element));
                        rowcount++;
                        let divId= element['divid'];
                        let zillaId= element['zillaid'];
                        if (element['comment1'] == "1") {
                            comment1 = 'হয়েছে';
                        } else {
                            comment1 = 'হয়নি';
                        }
                        if(element['case_submit'] > 0){
                            reportEntry = 'দাখিল হয়েছে';
                            messageButton = '-';
                        }else{
                            reportEntry = 'দাখিল  হয়নি';
                            messageButton = '<button class="btn btn-xs btn-primary" onclick="pendingReportList.showMessagePopup('+divId+','+zillaId+')">বার্তা  প্রেরণ </button>'
                        }

                        if (divname == element['divname']) {
                            slno++;
                            $('#ReportTable').append(
                                '<tr>' +
                                '<td class="centertext" > ' + slno + '</td>' +
                                '<td class="centertext"> ' + element['zillaname'] + '</td>' +
                                '<td class="centertext"> ' + reportEntry + '</td>' +
                                '<td class="centertext" > ' + comment1 + '</td>' +
                                '<td class="centertext"> ' + messageButton + '</td>' +
                                '</tr>');
                            zillaname = element['zillaname'];

                        } else {
                            slno++;
                            $('#ReportTable').append(
                                '<tr>' +
                                '<td class="centertext" colspan="14" > ' + element['divname'] + " বিভাগ" + '</td>' +
                                '</tr>' +
                                '<tr >' +
                                '<td class="centertext"> ' + slno + '</td>' +
                                '<td class="centertext"> ' + element['zillaname'] + '</td>' +
                                '<td class="centertext"> ' + reportEntry + '</td>' +
                                '<td class="centertext" > ' + comment1 + '</td>' +
                                '<td class="centertext"> ' + messageButton + '</td>' +
                                '</tr>');
                            divname = element['divname'];
                            zillaname = element['zillaname'];
                            if (noofRow == 3) {  // only zilla
                                return false;
                            }
                        }
                    })
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $.alert("Error", "অবহতিকরণ বার্তা");
            }
        });


    },
    reportOneTableDataPopulate:function (reportID, report_date) {
  
        let url = "/misnotification/printmobilecourtreport?report_date=" + report_date + "&reportID=" + reportID;
        $.ajax({
            url: url,
            type: 'POST',
            success: function (data) {
                // console.log(data.result.length);
                // return false;
                pendingReportList.populateTableHeading(data);
                if (data.result.length == 0) {
                    message_show("তথ্য নাই  ।");
                }
                else {
                    let myTable = document.getElementById("ReportTable");
                    let rowCount = myTable.rows.length;

                    for (let x = rowCount - 1; x > 2; x--) {
                        myTable.deleteRow(x);
                    }

                    let slno = 0;
                    let rowcount = 0;
                    let divname = "";
                    let zillaname = "";
                    let grandtotal = 0;
                    let noofRow = data.result.length;
                    let promapachive = "-";
                    let reportEntry = "-";
                    let messageButton = "-";
                    $(data.result).each(function (index, element) {
                        let divId= element['divid'];
                        let zillaId= element['zillaid'];
                        if(element['case_total2'] > 0){
                            reportEntry = 'দাখিল হয়েছে';
                            messageButton = '-';
                        }else{
                            reportEntry = 'দাখিল  হয়নি';
                            messageButton = '<button class="btn btn-xs btn-primary" onclick="pendingReportList.showMessagePopup('+divId+','+zillaId+')">বার্তা  প্রেরণ </button>'
                        }
                        rowcount++;
                        if(element['court_total2'] == 0){
                            promapachive = "হয়নি" ;
                        }else{
                            promapachive = (element['court_total2'] - element['promap'] >= 0 ?"হয়েছে" :"হয়নি") ;
                        }
                        if (divname == element['divname']) {

                            slno++;
                            $('#ReportTable').append(
                                '<tr>' +
                                '<td class="centertext"> ' + slno + '</td>' +
                                '<td class="centertext"> ' + element['zillaname'] + '</td>' +
                                '<td class="centertext"> ' + reportEntry + '</td>' +
                                '<td class="centertext"> ' + promapachive + '</td>' +
                                '<td class="centertext"> ' +  messageButton + '</td>');


                            zillaname = element['zillaname'];
                        } else {
                            slno++;
                            grandtotal = 0;

                            $('#ReportTable').append(
                                '<tr>' +
                                '<td class="centertext" colspan="15" > ' + element['divname'] + " বিভাগ" + '</td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td class="centertext"> ' + slno + '</td>' +
                                '<td class="centertext"> ' + element['zillaname'] + '</td>' +
                                '<td class="centertext"> ' + reportEntry + '</td>' +
                                '<td class="centertext"> ' + promapachive + '</td>' +
                                '<td class="centertext"> ' +  messageButton + '</td>');

                            divname = element['divname'];
                            zillaname = element['zillaname'];
                            if (noofRow == 3) {  // only zilla
                                return false;
                            }
                        }
                    })
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $.alert("Error", "অবহতিকরণ বার্তা");
            }
        });
    },
    setTableName:function (month_year) {
        $('#ReportTable').empty();
        $("#report_name_mbl").html($('#reportList option:selected').text());
        $("#report_name_mbl").append("<br>"+month_year);
    },

    validateReportInput: function (reportID, report_date) {
        if (reportID == '') {
             alert("প্রতিবেদন নির্বাচন করুন । ", "অবহতিকরণ বার্তা");
            return false;
        }
        if (report_date == "") {
             alert("মাস নির্বাচন করুন ।", "অবহতিকরণ বার্তা");
            return false;
        }
        return true;
    }
};
$(document).ready(function () {
    pendingReportList.init();
});