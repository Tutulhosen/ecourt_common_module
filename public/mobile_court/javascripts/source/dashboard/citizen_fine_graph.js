/**
 * Created by sarker.pranab on 5/18/2017.
 */
var citizen_fine_graph = {

    init: function (search_data) {
        $('#fine_loading').loading();
        $('#hero-bar-fine').html('');
        var citizen_fine = Morris.Bar({
            element: 'hero-bar-fine',
            data: [0, 0], // Set initial data (ideally you would provide an array of default data)
            xkey: 'location', // Set the key for X-axis
            ykeys: ['jorimana'], // Set the key for Y-axis
            labels: ['জরিমানা'], // Set the label when bar is rolled over
            resize: true,
            stacked: true,
            barRatio: 0.6,
            xLabelMargin: 0.5,
            hideHover: 'auto',
            barColors: ["#b062a4"],
            xLabelAngle: 45

        });
        citizen_fine_graph.graphFineVSCase(citizen_fine, search_data);
    },
    graphFineVSCase: function (citizen_fine, search_data) {
        console.log(search_data);
        $.ajax({
            data: search_data,
            type: "POST",
            dataType: 'json',
            url: "../dashboard/ajaxDataFineVSCase" ,// This is the URL to the API

            success:function (response) {
                $('#fine_loading').loading('stop');
                // When the response to the AJAX request comes back render the chart with new data
                citizen_fine.setData(response[0]);
                $("#fine_label").text(' '+response[2]+'- ('+response[1].start_date+' → '+response[1].end_date+')');
            },
            error:function () {
                $('#fine_loading').loading('stop');
                alert("জরিমানা চার্টে ত্রুটি ঘটেছে");
            }
        });

    }

};

$(document).ready(function() {
    citizen_fine_graph.init();
});
