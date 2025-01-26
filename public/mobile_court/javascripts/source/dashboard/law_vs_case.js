/**
 * Created by sarker.pranab on 5/18/2017.
 */
var law_vs_case = {

    init: function (search_data) {
        $('#case_type_graph_loading').loading();
        $('#hero-bar-crimetype').html('');
        var yData = [];
        var chart_law = Morris.Bar({
            element: 'hero-bar-crimetype',
            data: [], labels: yData, xkey: 'crime', ykeys: yData,
            resize: true, stacked: true, barRatio: 0.6, xLabelMargin: 0.5, hideHover: 'auto',xLabelAngle: 45,
            barColors: ['#029834', '#EF2939', '#F57900', '#0B62A4', '#8A2BE2', '#F9966B', '#F9966B', '#F9B7FF', '#7A92A3']
        });

        law_vs_case.graphLawVSCase(chart_law, search_data, yData);

    },

    graphLawVSCase: function (chart_law, search_data, yData) {

        // create the xhr request object
        var xhrRequest = $.ajax({ data: search_data, type: "POST", dataType: 'json', url: "../dashboard/ajaxDataLawVSCase",

        // handle success case
        success:function (response) {
            console.log(response);
            $('#case_type_graph_loading').loading('stop');
            if (response && response.length > 0) {
                var result = law_vs_case.prepareData(response[0]);
                var data = result.data;
                yData.push.apply(yData, result.labels);
                chart_law.setData(data);
                $("#law_label").text(' '+response[2]+'- ('+response[1].start_date+' → '+response[1].end_date+')');
            }
            if(response[0].length <= 0){
                chart_law.setData([{crime:"তথ্য নাই"}]);
            }
        },

        // handle error case
        error:function () {
            $('#case_type_graph_loading').loading('stop');
            alert("অপরাধের ধরন অনুসারে মামলার তথ্য চার্টে ত্রুটি ঘটেছে");
        }
        });

    },

    prepareData: function (rawData) {

        var labels = {};
        var dataEL = {};

        var resultset = [];
        var labelArray = [];

        // process the chart data elements
        $.each(rawData, function(i, x) {
            if(!dataEL[x.crime]) {
                dataEL[x.crime] = {};
            }
            dataEL[x.crime]["crime"] = x.crime;
            dataEL[x.crime][x.Lname] = parseInt(x.caseCount);
            labels[x.Lname] = 1;
        });

        // prepare data set to fit in the graph api
        $.each(dataEL, function(i, x) {
            resultset.push(x);
        });

        // extract the labels
        $.each(labels, function(i, x) {
            labelArray.push(i);
        });

        // return result
        return {"data": resultset, "labels": labelArray};
    }


};

$(document).ready(function() {
    law_vs_case.init();
});
