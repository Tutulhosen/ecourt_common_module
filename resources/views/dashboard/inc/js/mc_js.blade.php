
<script>

    var citizen_fine_graph = {
        init: function(search_data) {

            $('#fine_loading').show();
            $('#hero-bar-fine').html('');

            var citizen_fine = Morris.Bar({
                element: 'hero-bar-fine',
                data: [{
                    location: 'Sample',
                    jorimana: 0
                }],
                xkey: 'location',
                ykeys: ['jorimana'],
                labels: ['জরিমানা'],
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
        graphFineVSCase: function(citizen_fine, search_data) {
            var response = [
                [{
                        location: "Dhaka",
                        jorimana: 50
                    },
                    {
                        location: "Chittagong",
                        jorimana: 30
                    }
                ],
                {
                    start_date: "2024-01-01",
                    end_date: "2024-12-31"
                },
                "2024"
            ];

            $('#fine_loading').hide();

            citizen_fine.setData(response[0]);
            $("#fine_label").text(' ' + response[2] + '- (' + response[1].start_date + ' → ' + response[1]
                .end_date + ')');
        }
    };

    $(document).ready(function() {
        var search_data = {};
        citizen_fine_graph.init(search_data);
    });
</script>
<script src="{{ asset('/mobile_court/javascripts/lib/custom_c.js') }}"></script>
<script src="{{ asset('/mobile_court/javascripts/source/dashboard/monthly-report.js') }}"></script> 
<script src="{{ asset('/mobile_court/js/jquery.alerts.js') }}"></script>
<script src="{{ asset('/mobile_court/js/jquery.aCollapTable.js') }}"></script>
<script src="{{ asset('/mobile_court/js/jquery-ui-1.11.0.min.js') }}"></script>
<script src="{{ asset('/mobile_court/javascripts/source/dashboard/dashboard.js') }}"></script>
<script src="{{ asset('/mobile_court/javascripts/source/dashboard/dashboard_statistics_citizen_complain.js') }}"></script>
<script src="{{ asset('/mobile_court/javascripts/source/dashboard/dashboard_statistics_case.js') }}"></script>
<script src="{{ asset('/mobile_court/js/select2.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.2.7/raphael.min.js"></script>
<script src="{{ asset('/mobile_court/javascripts/source/dashboard/citizen_complain.js') }}"></script>
<script src="{{ asset('/mobile_court/javascripts/source/dashboard/citizen_fine_graph.js') }}"></script>
<script src="{{ asset('/mobile_court/javascripts/source/dashboard/location_vs_case.js') }}"></script>
<script src="{{ asset('/mobile_court/javascripts/source/dashboard/law_vs_case.js') }}"></script>
<script src="{{ asset('/mobile_court/javascripts/source/dashboard/loading_plugin/loading.js') }}"></script>