var dashboard_statistics_case = {

    init: function () {
        $('#case_statistics').loading();
        dashboard_statistics_case.getCaseInfo();
    },
 
    getCaseInfo: function (search_data) {
     
        $.ajax({
            data: search_data,
            type: "POST",
            dataType: 'json',
            url: "../dashboard/ajaxdashboardCaseStatistics", // This is the URL to the API

            success:function (response) {
                // console.log(response);
                // return false;
                $('#case_statistics').loading('stop');
                // When the response to the AJAX request comes back render the chart with new data
                $("#executed_court_dc").text(response[0].executed_court);
                $("#no_case_dc").text(response[0].no_case);
                $("#fine_dc").text(response[0].fine);
                $("#criminal_no_dc").text(response[0].criminal_no);
                $("#jail_criminal_no_dc").text(response[0].jail_criminal_no);
                $("#no_magistrate").text(response[0].magistrate_no);
                $("#no_prosecutor").text(response[0].prosecutor_no);
                $("#block2_label").text(' '+response[2]+'- ('+response[1].start_date+' → '+response[1].end_date+')');

                if(search_data){
                    $("#linkShowMagistrateList").attr("href",'/dashboard/showMagistrateList'+search_data);
                    $("#linkShowProsecutorList").attr("href",'/dashboard/showProsecutorList'+search_data);
                }
            },
            error:function () {
                $('#case_statistics').loading('stop');
                alert("মামলার পরিসংখ্যান ব্লকে ত্রুটি ঘটেছে");
            }
        });

    }

};

$(document).ready(function() {
    dashboard_statistics_case.init();
});
