/**
 * Created by sarker.pranab on 5/18/2017.
 */
var location_vs_case = {

    init: function (search_data) {
        $('#case_loc_loading').loading();
        $('#hero-bar-location').html('');
        chart_location = Morris.Bar({
            element: 'hero-bar-location',
            data: [0, 0], // Set initial data (ideally you would provide an array of default data)
            xkey: 'location', // Set the key for X-axis
            ykeys: ['মামলা'], // Set the key for Y-axis
            labels: ['মামলা'], // Set the label when bar is rolled over
            resize: true,
            stacked: true,
            barRatio: 0.6,
            xLabelMargin: 0.5,
            hideHover: 'auto',
            barColors: ["#0B53BA"],
            xLabelAngle: 45

        });
        location_vs_case.graphLocationVSCase(chart_location, search_data);
    },
    graphLocationVSCase: function (chart_location, search_data) {
        $.ajax({
            data: search_data,
            type: "POST",
            dataType: 'json',
            url: "../dashboard/ajaxDataLocationVSCase", // This is the URL to the API

            success:function (response) {
                $('#case_loc_loading').loading('stop');
                // When the response to the AJAX request comes back render the chart with new data
                chart_location.setData(response[0]);
                $("#case_label").text(' '+response[2]+'- ('+response[1].start_date+' → '+response[1].end_date+')');
            },
            error:function () {
                $('#case_loc_loading').loading('stop');
                alert("স্থানভিত্তিক মামলার তথ্য চার্টে ত্রুটি ঘটেছে");
            }
        });

    }

};

$(document).ready(function() {
    location_vs_case.init();
});
