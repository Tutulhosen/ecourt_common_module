const monthNames = {
    '01': "জানুয়ারী ", '1': "জানুয়ারী ", '02': "ফেব্রুয়ারী ", '2': "ফেব্রুয়ারী ", '03': "মার্চ ", '3': "মার্চ ", '04': "এপ্রিল ", '4': "এপ্রিল ", '05': "মে ", '5': "মে ", '06': "জুন ", '6': "জুন ",
    '07': "জুলাই ", '7': "জুলাই ", '08': "অগাস্ট ", '8': "অগাস্ট ", '09': "সেপ্টেম্বর ", '9': "সেপ্টেম্বর ", '10': "অক্টোবর ", '11': "নভেম্বর ", '12': "ডিসেম্বর "
};
let approvedReportList = {
    init: function () {
        $("#reportList").select2("val", "");
    },
    getReportDetails: function () {
        let reportID = $('#reportList').val();
        let report_date = $('#report_date').val();
        approvedReportList.getReportsData(reportID, report_date).done(function (response, textStatus, jqXHR) {
            if (response.length > 0) {

                console.log(response, 'mamala batil response')
                approvedReportList.populateReportTable(response);
            }
            else alert("তথ্য নাই", "অবহতিকরণ বার্তা");
        })
    },
    getReportsData: function (reportID, report_date) {
        var url = '/misnotification/getReportsData?reportId=' + reportID + '&reportDate=' + report_date;
        return $.ajax({ url: url, dataType: 'json' });
    },
    setTableName: function () {
        $('#ReportTable').empty();
        let report_date = $('#report_date').val();
        let splitData = report_date.split("-");

        $("#report_name_mbl").html($('#reportList option:selected').text());
        $("#report_name_mbl").append("<br>" + monthNames[splitData[0]] + "," + toBangla(splitData[1]));
    },
    disapproveReport: function (reportId) {
        if (reportId) {
            var url = "/misnotification/setReportDataUnapproved?reportId=" + reportId;
            /* $.confirm({
                resizable: false,
                height: 250,
                width: 400,
                modal: true,
                title: "অনুমোদন বাতিল",
                titleClass: "modal-header",
                content: "অনুমোদন বাতিল করতে চান ?",
                buttons: {
                    "না": function () {
                        // $(this).dialog("close");
                    },
                    "হ্যাঁ": function () {
                        $.ajax({
                            url: url, type: 'POST', dataType: 'json',
                            success: function (response) {

                                console.log('mamla batil consle')
                                if(response == true){
                                    alert("অনুমোদন সফল ভাবে বাতিল করা হয়েছে । ", "অবহতিকরণ বার্তা");
                                }
                                else $.alert("ত্রুটি", "অবহতিকরণ বার্তা");
                                $('#approveButtonId_'+reportId).html('-');
                            },
                            error: function () {
                                alert("ত্রুটি", "অবহতিকরণ বার্তা");
                            }
                        });
                    }
                }
            }); */
            Swal.fire({
                title: "অনুমোদন বাতিল",
                text: "অনুমোদন বাতিল করতে চান ?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "না",
                confirmButtonText: "হ্যাঁ"
            }).then((result) => {
                console.log('result', result)
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'json',
                        cache: false,
                        beforeSend: function () {
                            // Optional: any action before sending the request
                        },
                        success: function (response, textStatus, jqXHR) {

                            if (response.status === 'success') {
                                Swal.fire({
                                    title: "অনুমোদন বাতিল",
                                    text: "অনুমোদন সফল ভাবে বাতিল করা হয়েছে।",
                                    icon: "success"
                                });
                            }else{
                                Swal.fire({
                                    title: "অবহতিকরণ বার্তা",
                                    text: "অনুমোদন বাতিল সম্পন্ন হয়নি। পূনরায় চেষ্টা করুন।",
                                    icon: "error"
                                });
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            console.log({ jqXHR, textStatus, errorThrown });
                            Swal.fire({
                                title: "অবহতিকরণ বার্তা",
                                text: "অভিযোগ গঠন সম্পন্ন হয়নি ।  পূনরায় চেষ্টা করুন ।",
                                icon: "error"
                            });
                        }
                    });

                }

            });
        } else {
            $.alert("ত্রুটি", "অবহতিকরণ বার্তা");
        }
    },
    populateReportTable: function (response) {
        console.log(response);
        approvedReportList.setTableName();
        $('#ReportTable').append(
            '<tr>' +
            '<td style="text-align: center;font-weight: bold;width: 3%;">ক্রমিক নং</td>' +
            '<td style="text-align: center;font-weight: bold;width: 8%;">বিভাগ </td>' +
            '<td style="text-align: center;font-weight: bold;width: 8%;">জেলা</td>' +
            '<td style="text-align: center;font-weight: bold;width: 8%;">প্রতিবেদন সাল</td>' +
            '<td style="text-align: center;font-weight: bold;width: 8%;">প্রতিবেদন  মাস</td>' +
            '<td style="text-align: center;font-weight: bold;width: 8%;">প্রমাপ</td>' +
            '<td style="text-align: center;font-weight: bold;width: 8%;">অনুমোদিত</td>' +
            '<td style="text-align: center;font-weight: bold;width: 8%;">কার্যকলাপ</td>' +
            '</tr>');

        // for (var key in response) {
        let approveFlag = '-';
        let actionButton = '-';
        let promap = '-';
        $(response).each(function (index, element) {
            if (element.comment1_str) {
                promap = element.comment1_str;
            }
            else {
                promap = '-';
            }
            if (element.is_approved == '1') {
                approveFlag = 'অনুমোদিত';
                actionButton = '<button class="btn btn-xs btn-danger" type="submit"  onclick="approvedReportList.disapproveReport(' + element.id + ')">অনুমোদন বাতিল </button>'
            }
            else {
                approveFlag = 'অনুমোদিত  না';
                actionButton = '-';
            }
            $('#ReportTable').append(
                '<tr>' +
                '<td style="text-align: center;"> ' + toBangla(index + 1) + '</td>' +
                '<td style="text-align: center;"> ' + element.divname + '</td>' +
                '<td style="text-align: center;"> ' + element.zillaname + '</td>' +
                '<td style="text-align: center;"> ' + element.report_year + '</td>' +
                '<td style="text-align: center;"> ' + monthNames[element.report_month] + '</td>' +
                '<td style="text-align: center;"> ' + promap + '</td>' +
                '<td style="text-align: center;"> ' + approveFlag + '</td>' +
                '<td style="text-align: center;" id="approveButtonId_' + element.id + '"> ' + actionButton + '</td>' +

                '</tr>');

        })
    }
};
$(document).ready(function () {
    approvedReportList.init();
});