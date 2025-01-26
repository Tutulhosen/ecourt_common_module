var reportList={

    init:function () {

    },
    getReportList:function (reportType) {
        var URL = "/monthly_report/getMisReportList";
        $.ajax({ url: URL, type: 'POST', dataType: 'json',
            success: function (response) {
           console.log('mon reort ', response)
                if(reportType==1){
                    $('#commentChk').hide();
                    $('#previousDate').show();
                    
                    reportList.populateGraphContryDropDown(response.countryReportList);
                }else if(reportType==2){
                    $('#commentChk').show();
                    $('#previousDate').hide();
                    reportList.populateDivZillaDropDown(response.divisionReportList);
                }else if(reportType==3){
                    $('#commentChk').show();
                    $('#previousDate').hide();
                    reportList.populateDivZillaDropDown(response.zillaReportList);
                }else if(reportType==4){
                    $('#commentChk').hide();
                    $('#previousDate').show();
                    reportList.populateGraphContryDropDown(response.graphReportList);
                }

            },
            error: function () {
                alert("ত্রুটি", "অবহতিকরণ বার্তা");
            }
        });
    },
    populateGraphContryDropDown:function (reportList) {
        var dropDownId='#reportList';
        var emptyMessage='প্রতিবেদন নির্বাচন করুন...';
        $(dropDownId).html('');
        // Add the empty option with the empty message
        $(dropDownId).append('<option value="">' + emptyMessage + '</option>');

        // Check result isnt empty
        if(reportList != ''){
            // Loop through each of the results and append the option to the dropdown
            $.each(reportList, function(i, x) {
                $(dropDownId).append('<option value="' + x.ID + '">' + x.ReportName + '</option>');

            });

        }
        $("#reportList").select2("val","");


    },
    populateDivZillaDropDown:function (reportList) {
        var dropDownId='#reportList';
        var emptyMessage='প্রতিবেদন নির্বাচন করুন...';
        $(dropDownId).html('');
        // Add the empty option with the empty message
        $(dropDownId).append('<option value="">' + emptyMessage + '</option>');

        if(reportList != ''){
            // Loop through each of the results and append the option to the dropdown
            $.each(reportList, function(i, x) {
                $(dropDownId).append('<option value="' + x.id + '">' + x.name + '</option>');

            });

        }
        $("#reportList").select2("val","");


    }

};
$(document).ready(function () {
    reportList.init();
});
