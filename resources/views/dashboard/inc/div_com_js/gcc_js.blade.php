<script type="text/javascript">
    // Create the chart
    Highcharts.chart('container', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'বিভাগ ও জেলা ভিত্তিক মামলা'
        },
        subtitle: {
            text: 'মামলা'
        },
        accessibility: {
            announceNewData: {
                enabled: true
            }
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'Number of Case'
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y}'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> of total<br/>'
        },

        series: [{
            name: "Division",
            colorByPoint: true,
            data: <?= json_encode($divisiondata) ?>
        }],

        drilldown: {
            series: <?= json_encode($dis_upa_data) ?>
        }
    });

    jQuery(document).ready(function() {

        case_status_statistic();
        payment_statistic();
        case_pie_chart();

        // District Dropdown
        jQuery('select[name="gcc_district"]').on('change', function() {
            var dataID = jQuery(this).val();
            jQuery("#gcc_upazila_id").after('<div class="loadersmall"></div>');
            jQuery.ajax({
                url: '{{ url('/') }}/generalCertificate/case/dropdownlist/getdependentupazila/' +
                    dataID,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    jQuery('select[name="gcc_upazila"]').html(
                        '<div class="loadersmall"></div>');
                    jQuery('select[name="gcc_upazila"]').html(
                        '<option value="">-- নির্বাচন করুন --</option>');
                    jQuery.each(data, function(key, value) {
                        jQuery('select[name="gcc_upazila"]').append('<option value="' +
                            key + '">' + value + '</option>');
                    });
                    jQuery('.loadersmall').remove();
                }
            });
           
        });

    });

    // Case Status Statistics
    function case_status_statistic() {

        let division = $("#gcc_division_id").val();
        let district = $("#gcc_district_id").val();
        let upazila = $("#gcc_upazila_id").val();
        let dateFrom = $("#gcc_date_from").val();
        let dateTo = $("#gcc_date_to").val();
        let _token = $('meta[name="csrf-token"]').attr('content');
        // console.log(division);

        // Loader
        $('.report-case-status').addClass('spinner');

        // AJAX Request
        $.ajax({
            url: "/dashboard/ajax-case-status",
            type: "POST",
            data: {
                division: division,
                district: district,
                upazila: upazila,
                dateFrom: dateFrom,
                dateTo: dateTo,
                _token: _token
            },
            success: function(response) {

                if (response) {
                    console.log('response come here e', response)
                    $('#ON_TRIAL').html(response.data['ON_TRIAL']);
                    $('#SEND_TO_GCO').html(response.data['SEND_TO_GCO']);
                    $('#SEND_TO_ASST_GCO').html(response.data['SEND_TO_ASST_GCO']);
                    $('#SEND_TO_DC').html(response.data['SEND_TO_DC']);
                    $('#SEND_TO_NBR_CM').html(response.data['SEND_TO_NBR_CM']);
                    $('#CLOSED').html(response.data['CLOSED']);
                    $('#REJECTED').html(response.data['REJECTED']);
                    $('#ON_TRIAL_DC').html(response.data['ON_TRIAL_DC']);
                    $('#ON_TRIAL_DIV_COM').html(response.data['ON_TRIAL_DIV_COM']);
                    $('#ON_TRIAL_NBR_CM').html(response.data['ON_TRIAL_NBR_CM']);

                    $('#caseStatusMsg').text(response.msg).show();
                    // $("#ajaxform")[0].reset();
                    // $('.spinner').hide();
                    $('.report-case-status').removeClass('spinner');

                }
            },
            error: function(error) {
                console.log(error);
                // $('#nameError').text(response.responseJSON.errors.division);
            }
        });
    }

    function payment_statistic() {
        // console.log('submitted!');
        // Variable
        let division = $("#gcc_division_id").val();
        let district = $("#gcc_district_id").val();
        let upazila = $("#gcc_upazila_id").val();
        let dateFrom = $("#gcc_date_from").val();
        let dateTo = $("#gcc_date_to").val();
        let _token = $('meta[name="csrf-token"]').attr('content');
        // console.log(division);

        // Loader
        $('.report-payment').addClass('spinner');

        // AJAX Request
        $.ajax({
            url: "/dashboard/ajax-payment-report",
            type: "POST",
            data: {
                division: division,
                district: district,
                upazila: upazila,
                dateFrom: dateFrom,
                dateTo: dateTo,
                _token: _token
            },
            success: function(response) {
                console.log('tujos', response)
                if (response) {
                    $('#result_table').html(response.data);

                    $('#paymentMsg').text(response.msg).show();
                    // $("#ajaxform")[0].reset();
                    // $('.spinner').hide();
                    $('.report-payment').removeClass('spinner');

                }
            },
            error: function(error) {
                console.log(error);
                // $('#nameError').text(response.responseJSON.errors.division);
            }
        });
    }
    // Google Chart
    google.charts.load('current', {
        'packages': ['bar', 'corechart']
    });
    google.charts.setOnLoadCallback();

    // Case Pie Chart
    function case_pie_chart() {
        // Variable
        let division = $("#gcc_division_id").val();
        let district = $("#gcc_district_id").val();
        let upazila = $("#gcc_upazila_id").val();
        let dateFrom = $("#gcc_date_from").val();
        let dateTo = $("#gcc_date_to").val();
        let _token = $('meta[name="csrf-token"]').attr('content');
        var title = "hello";
        var year = "2022";
        var temp_title = title + ' ' + year + '';

        // Loader
        $('.case-piechart').addClass('spinner');

        // Reqpuest
        $.ajax({
            url: "/dashboard/ajax-crpc-pie-chart",
            method: "POST",
            data: {
                division: division,
                district: district,
                upazila: upazila,
                dateFrom: dateFrom,
                dateTo: dateTo,
                _token: _token
            },
            dataType: "JSON",
            success: function(response) {
                console.log('pie chart response', response)
                if (!response.data) {
                    document.getElementById('piechart_3d').innerHTML =
                        '<p style="margin-left: 178px;margin-top: 134px;font-size: 30px;"> কোন  তথ্য পাওয়া যায় নাই</p>';
                } else {
                    // Generate random case counts for each CRPC category
                    const totalReceived = response.data.totalReceived;
                    // const onadayKrito = response.data.totalClaimed - totalReceived;
                    // console.log(onadayKrito, response.data.totalClaimed)
                    var crpcData = [
                        ['arthoAdaay', 'arthoAdaay Count'],
                        ['আদায়কৃত অর্থ ', totalReceived],
                        ['মোট অর্থ', response.data.totalClaimed],

                    ];

                    // Convert the data to a DataTable
                    var data = google.visualization.arrayToDataTable(crpcData);

                    // Function to generate random integer between min and max (inclusive)
                    function getRandomInt(min, max) {
                        return Math.floor(Math.random() * (max - min + 1)) + min;
                    }
                    var options = {
                        // title: 'My Daily Activities',
                        is3D: true,
                    };

                    var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
                    console.log('chart', chart)
                    chart.draw(data, options);
                }


                $('.case-piechart').removeClass('spinner');
            }
        });
    }
</script>
