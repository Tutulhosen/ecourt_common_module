var demoReport={

    init:function () {

    },
    showReport:function () {
        var reportType= $('#reportType').val();
        var division= $('#division').val();
        var district= $('#zilla').val();
        var divisionvalue = $('#division option:selected').val();
        var zillaValue = $('#zilla option:selected').val();
        if(divisionvalue === ''){
            $('#loadingModalBlock').html('সমগ্র দেশের  তথ্য প্রদর্শিত হচ্ছে ...');
        }else if(zillaValue === ''){
            $('#loadingModalBlock').html('বিভাগ ভিত্তিক তথ্য প্রদর্শিত হচ্ছে ...');
        }else{
            $('#loadingModalBlock').html('জেলা ভিত্তিক তথ্য প্রদর্শিত হচ্ছে ...');
        }

        $('.modal').modal('show');


        if(reportType) {
            var url = base_path + "/monthly_report/getReportData?reportType="+reportType+"&division="+division+"&district="+district;
            $.ajax({
                url: url, type: 'POST', dataType: 'json',
                success: function (response) {
                    $('.modal').modal('hide');
                    console.log(response.filled);
                    if(reportType=='1' || reportType=='2'){
                        demoReport.populateTablePostCount(response);
                    }
                    else if(reportType=='4'){
                        demoReport.populateTablePostDescriptionReport4(response.filled);
                    }else if(reportType =='5'){
                        demoReport.populateTablePostDescriptionReport5(response.filled);
                    }
                },
                error: function () {
                    $('.modal').modal('hide');
                    $.alert("সাময়িক ত্রুটি, পুনরায় চেষ্টা করুন", "অবহতিকরণ বার্তা");
                }
            });
        }else {
            $.alert("তথ্য নাই", "অবহতিকরণ বার্তা");
        }

    },
    printReport:function () {
        // w=window.open();
        // w.document.write($('#printDemoReport').html());
        // w.print();
        // w.close();
        newwindow = window.open();
        newdocument = newwindow.document;
        newwindow.document.write();
        newdocument.write($('#printDemoReport').html());
        newdocument.close();

        newwindow.print();
    },
    dataReset: function () {
        $('#demoReportTable').empty();
    },
    populateTablePostCount:function (response) {
        this.dataReset();
        var reportName = $('#reportType option:selected').text();
        $("#report_name_mbl").html(reportName);
        var currentDate = new Date();
        const monthNames = ["জানুয়ারী ", "ফেব্রুয়ারী ", "মার্চ ", "এপ্রিল ", "মে ", "জুন ",
            "জুলাই ", "অগাস্ট ", "সেপ্টেম্বর ", "অক্টোবর ", "নভেম্বর ", "ডিসেম্বর "
        ];
        var reportNamePrefix=demoReport.getReportNamePrefix();
        $("#report_name_mbl").append(":"+"<br>"+reportNamePrefix+" মাসের নামঃ "+monthNames[currentDate.getMonth()]+", "+toBangla(currentDate.getFullYear()));
        var index=1;
        var totalPost=0;
        var totalOccupiedPost=0;
        var totalBlankPost=0;

        $('#demoReportTable').append(
            '<tr>' +
            '<td style="text-align: center;font-weight: bold;width: 2%;"> ক্রমিক নং</td>' +
            '<td style="padding-left: 10px;font-weight: bold;width: 15%;">পদের  নাম</td>' +
            '<td style="text-align: center;font-weight: bold;width: 4%;"> মঞ্জুরীকৃত পদ</td>' +
            '<td style="text-align: center;font-weight: bold;width: 4%;">কর্মরত</td>' +
            '<td style="text-align: center;font-weight: bold;width: 4%;">শুন্য</td>' +
            '<td style="text-align: center;font-weight: bold;width: 15%;">মন্তব্য </td>' +
            '</tr>');

        for (var key in response) {
            var blankPost=(response[key].total - response[key].active);
            $('#demoReportTable').append(
                '<tr>' +
                '<td style="text-align: center;"> ' + toBangla(index) + '</td>' +
                '<td style="padding-left: 10px;"> ' + key + '</td>' +
                '<td style="text-align: center;"> ' + toBangla(response[key].total) + '</td>' +
                '<td style="text-align: center;"> ' + toBangla(response[key].active) + '</td>' +
                '<td style="text-align: center;"> ' + toBangla(blankPost) + '</td>' +
                '<td contenteditable style="text-align: center;"> </td>' +
                '</tr>');
            index++;
            totalPost=totalPost+response[key].total;
            totalOccupiedPost=totalOccupiedPost+response[key].active;
            totalBlankPost=totalBlankPost+blankPost;
        }
        $('#demoReportTable').append(
            '<tr>' +
            '<td style="text-align: center;"> </td>' +
            '<td style="padding-left: 10px;"> মোট=</td>' +
            '<td style="text-align: center;"> ' + toBangla(totalPost) + '</td>' +
            '<td style="text-align: center;"> ' + toBangla(totalOccupiedPost) + '</td>' +
            '<td style="text-align: center;"> ' + toBangla(totalBlankPost) + '</td>' +
            '<td contenteditable style="text-align: center;"> </td>' +
            '</tr>');


    },
    getReportNamePrefix:function () {
        var divisionname = $('#division option:selected').text();
        var zillaname = $('#zilla option:selected').text();
        var divisionvalue = $('#division option:selected').val();
        var zillaValue = $('#zilla option:selected').val();
        if(divisionvalue === ''){
            return '( সমগ্র বাংলাদেশ )';
        }else if(zillaValue === ''){
            return "( "+divisionname+" বিভাগ )";
        }else{
            return "( "+zillaname+" জেলা )";
        }
    },
    populateTablePostDescriptionReport4:function (response) {
        var reportNamePrefix=demoReport.getReportNamePrefix();
        var currentDate = new Date();
        const monthNames = ["জানুয়ারী ", "ফেব্রুয়ারী ", "মার্চ ", "এপ্রিল ", "মে ", "জুন ",
            "জুলাই ", "অগাস্ট ", "সেপ্টেম্বর ", "অক্টোবর ", "নভেম্বর ", "ডিসেম্বর "
        ];
        $("#report_name_mbl").html(reportNamePrefix+ "  " +monthNames[currentDate.getMonth()]+","+toBangla(currentDate.getFullYear())+" এর বি সি এস  (প্রশাসন) ক্যাডারভুক্ত কর্মকর্তা এবং উপ-সচিব ও তদুর্ধ পদে অন্যান্য ক্যাডার থেকে আগত পরিচিতি নম্বরধারী কর্মকর্তাগণের তালিকা");
        this.dataReset();

        var index=1;
        $('#demoReportTable').append(
            '<tr>' +
            '<td style="text-align: center;font-weight: bold;width: 3%;"> ক্রমিক নং</td>' +
            '<td style="text-align: center;font-weight: bold;width: 8%;">কর্মকর্তার পরিচিতি নং </td>' +
            '<td style="text-align: center;font-weight: bold;width: 8%;"> কর্মকর্তার নাম </td>' +
            '<td style="text-align: center;font-weight: bold;width: 8%;"> পদবি  </td>' +
            '<td style="text-align: center;font-weight: bold;width: 8%;">আদেশের তারিখ </td>' +
            '<td style="text-align: center;font-weight: bold;width: 8%;">বর্তমান কর্মস্থলে যোগদানের তারিখ </td>' +
            '<td style="text-align: center;font-weight: bold;width: 8%;">পূর্বতন কর্মস্থল হতে অব্যাহতির তারিখ </td>' +
            '<td style="text-align: center;font-weight: bold;width: 8%;">জন্ম তারিখ  </td>' +
            '<td style="text-align: center;font-weight: bold;width: 8%;">ক্ষমতা </td>' +
            '<td style="text-align: center;font-weight: bold;width: 8%;">অব্যাহত পূর্ববর্তী কর্মস্থলের নাম ও যোগদানের তারিখ </td>' +
            '<td style="text-align: center;font-weight: bold;width: 5%;">টেলিফোন নম্বর / মোবাইল নম্বর    </td>' +
            '</tr>');

        for (var key in response) {
            $('#demoReportTable').append(
                '<tr>' +
                '<td style="text-align: center;"> ' + toBangla(index) + '</td>' +
                '<td style="text-align: center;"> ' + toBangla(response[key].identity_no) + '</td>' +
                '<td style="text-align: center;"> ' + response[key].name_bng + '</td>' +
                '<td style="text-align: center;"> ' + response[key].designation_bng + '</td>' +
                '<td style="text-align: center;"> </td>' +
                '<td style="text-align: center;"> ' + toBangla(this.getFormatedDate(response[key].joining_date)) + '</td>' +
                '<td style="text-align: center;"> ' + toBangla(this.getFormatedDate(response[key].last_office_date)) + '</td>' +
                '<td style="text-align: center;"> ' + toBangla(this.getFormatedDate(response[key].date_of_birth)) + '</td>' +
                '<td style="text-align: center;"> </td>' +
                '<td style="text-align: center;"> ' + response[key].previous_office_info + '</td>' +
                '<td style="text-align: center;"> ' + toBangla(response[key].phone_number) + '</td>' +
                '</tr>');
            index++;

        }


    },
    getFormatedDate: function (datestamp) {
        var currentDate = new Date(datestamp);

        var date = currentDate.getDate();
        var month = currentDate.getMonth(); //Be careful! January is 0 not 1
        var year = currentDate.getFullYear();

        var dateString = date + "/" + (month + 1) + "/" + year;
        return dateString;
    },
    populateTablePostDescriptionReport5:function (response) {
        var currentDate = new Date();
        const monthNames = ["জানুয়ারী ", "ফেব্রুয়ারী ", "মার্চ ", "এপ্রিল ", "মে ", "জুন ",
            "জুলাই ", "অগাস্ট ", "সেপ্টেম্বর ", "অক্টোবর ", "নভেম্বর ", "ডিসেম্বর "
        ];
        var reportNamePrefix=demoReport.getReportNamePrefix();
        $("#report_name_mbl").html(reportNamePrefix+ "  " +monthNames[currentDate.getMonth()]+","+toBangla(currentDate.getFullYear()) +" এর  বি সি এস  (প্রশাসন) ক্যাডারের  কর্মকর্তাদের প্রতিবেদন");

        this.dataReset();
        var index=1;
        $('#demoReportTable').append(
            '<tr>' +
            '<col>' +
            '<colgroup span="2"></colgroup>' +
            '<td style="text-align: center;font-weight: bold;width: 2%;"rowspan="2"> ক্রমিক নং</td>' +
            '<td style="text-align: center;font-weight: bold;width: 9%;"rowspan="2"> পদের  নাম  </td>' +
            '<td style="text-align: center;font-weight: bold;width: 9%;"rowspan="2"> কর্মকর্তার নাম </td>' +
            '<td style="text-align: center;font-weight: bold;width: 3%;"rowspan="2">পরিচিতি নং </td>' +
            '<td style="text-align: center;font-weight: bold;width: 8%;"rowspan="2"> বর্তমান  কর্মস্থল </td>' +
            '<td style="text-align: center;font-weight: bold;width: 6%;"rowspan="2">বর্তমান কর্মস্থলে যোগদানের তারিখ </td>' +
            '<td style="text-align: center;font-weight: bold;width: 5%;"rowspan="2">ক্ষমতা </td>' +
            '<td style="text-align: center;font-weight: bold;width: 8%;"rowspan="2"> ক্যাডারে যোগদানের তারিখ  </td>' +
            '<td style="text-align: center;font-weight: bold;width: 7%;"rowspan="2"> নিজ  জেলা </td>' +
            '<td style="text-align: center;font-weight: bold;width: 12%;"rowspan="2">পূর্বতন কর্মস্থল</td>' +
            '<td style="text-align: center;font-weight: bold;width: 4%;"rowspan="2">জন্ম তারিখ  </td>' +
            '<td style="text-align: center;font-weight: bold;width: 8%;"rowspan="2">টেলিফোন নম্বর/মোবাইল নম্বর    </td>' +
            '<td  style="text-align: center;font-weight: bold;width: 12%;" colspan="4" scope="colgroup">প্রশিক্ষণ </td>' +
            '</tr>'+
            '<tr>'+
            '<th scope="col">বুনিয়াদি</th>'+
            '<th scope="col">সেটেলমেন্ট</th>'+
            '<th scope="col">আইন</th>'+
            '<th scope="col">বি এম এ</th>'+
            '</tr>');

        for (var key in response) {

            $('#demoReportTable').append(
                '<tr>' +
                '<td style="text-align: center;"> ' + toBangla(index) + '</td>' +
                '<td style="text-align: center;"> ' + response[key].designation_bng+ '</td>' +
                '<td style="text-align: center;"> ' + response[key].name_bng + '</td>' +
                '<td style="text-align: center;"> ' + toBangla(response[key].identity_no)+ '</td>' +
                '<td style="text-align: center;"> </td>' +
                '<td style="text-align: center;"> ' + toBangla(this.getFormatedDate(response[key].joining_date)) + '</td>' +
                '<td style="text-align: center;"> </td>' +
                '<td style="text-align: center;"> </td>' +
                '<td style="text-align: center;"> </td>' +
                '<td style="text-align: center;"> ' + response[key].previous_office_info + '</td>' +
                '<td style="text-align: center;"> ' + toBangla(this.getFormatedDate(response[key].date_of_birth)) + '</td>' +

                '<td style="text-align: center;word-break: break-word;"> ' + toBangla(response[key].phone_number) + '</td>' +
                '<td>--</td>' +
                '<td>--</td>' +
                '<td>--</td>' +
                '<td>--</td>' +
                '</tr>');
            index++;

        }


    },


};
$(document).ready(function () {
    demoReport.init();
});
