/**
 * Created by sarker.pranab on 5/18/2017.
 */
var citizen_complain = {

    init: function (search_data) {
        $('#citizen_complain_graph_loading').loading();
        $('#hero-bar-citizen').html('');
        var chart_complain = Morris.Bar({
            element: 'hero-bar-citizen',
            data: [0, 0], // Set initial data (ideally you would provide an array of default data)
            xkey: 'label', // Set the key for X-axis
            ykeys: ['value'], // Set the key for Y-axis
            labels: ['অভিযোগ'], // Set the label when bar is rolled over
            resize: true,
            stacked: true,
            barRatio: 0.6,
            xLabelMargin: 0.5,
            hideHover: 'auto',
            //barColors: ["#b062a4"],
            xLabelAngle: 45,
            barColors:function (row, series, type) {
                if(row.label == "গ্রহণকৃত") return "#b062a4";
                else if(row.label == "বাতিলকৃত") return "#de2632";
                else if(row.label == "অপেক্ষমান") return "#b0aa27";
                else if(row.label == "নিস্পন্ন") return "#16fe3e";
            },

        });
        citizen_complain.graphCitizenComplain(chart_complain, search_data);
    },
    graphCitizenComplain: function (chart_complain, search_data) {
   
        $.ajax({
            data: search_data,
            type: "POST",
            dataType: 'json',
            url: "../dashboard/ajaxCitizen", // This is the URL to the API

            success:function (response) {
                // console.log(response);
                $('#citizen_complain_graph_loading').loading('stop');
                chart_complain.setData(response[0]);
                $("#crime_label").text(' '+response[2]+'- ('+response[1].start_date+' → '+response[1].end_date+')');

            },
            error:function () {
                $('#citizen_complain_graph_loading').loading('stop');
                alert("অপরাধের তথ্য গ্রাফে ত্রুটি ঘটেছে");
            }
        });
    }

};

$(document).ready(function() {
    citizen_complain.init();
});
