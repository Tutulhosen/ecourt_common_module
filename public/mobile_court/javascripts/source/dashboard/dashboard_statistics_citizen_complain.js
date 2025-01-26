var dashboard_statistics_citizen_complain = {

    init: function () {
        $('#criminal_info').loading();
        dashboard_statistics_citizen_complain.getCriminalInfo();
    },
    getCriminalInfo: function (search_data) {
        $.ajax({
            data: search_data,
            type: "POST",
            dataType: 'json',
            url: "../dashboard/ajaxDashboardCriminalInformation" ,// This is the URL to the API

            success:function (response) {
                $('#criminal_info').loading('stop');
                // When the response to the AJAX request comes back render the chart with new data
                $("#accepted").text(response[0].accepted);
                $("#ignore").text(response[0].ignore);
                $("#total").text(response[0].total);
                $("#unchange").text(response[0].unchange);
                // $("#block3_label").text(' '+response[2]+'- ('+response[1].start_date+' → '+response[1].end_date+')');

                if(search_data){
                    $("#acceptedComplain").attr("href",'/dashboard/showAcceptedComplain'+search_data);
                    $("#ignoreComplain").attr("href",'/dashboard/showIgnoreComplain'+search_data);
                    $("#pendingComplain").attr("href",'/dashboard/showPendingComplain'+search_data);
                }

            },
            error:function () {
                $('#criminal_info').loading('stop');
                alert("অপরাধের তথ্য ব্লকে ত্রুটি ঘটেছে");
            }
        });

    }

};

$(document).ready(function() {
    dashboard_statistics_citizen_complain.init();
});
