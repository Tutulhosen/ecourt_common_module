<script type="text/javascript">

    Highcharts.chart('containerDrilldown', {
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
            pointFormat: '<span style="color:red">{point.name}</span>: <b>{point.y}</b> of total<br/>'
        },

        series: [{
            name: "Division",
            colorByPoint: true,
            data: <?= json_encode($emcdivisiondata) ?>
        }],

        drilldown: {
            series: <?= json_encode($emc_dis_upa_data) ?>
        }
    });


    // CRPC Statistics 
    function crpc_statistic() {
        // console.log('submitted!');
        // Variable
        let division = $("#division_id").val();
        let district = $("#district_id").val();
        let upazila = $("#upazila_id").val();
        let dateFrom = $("#date_from").val();
        let dateTo = $("#date_to").val();
        let _token = $('meta[name="csrf-token"]').attr('content');
        // console.log(division);

        // Loader
        $('.report-crpc').addClass('spinner');

        // AJAX Request
        $.ajax({
            url: "{{ route('emc.dashboard.crpc-report') }}",
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
                // console.log(response);
                if (response) {
                    $('#crpc100').html(response.data[100]);
                    $('#crpc107').html(response.data[107]);
                    $('#crpc108').html(response.data[108]);
                    $('#crpc109').html(response.data[109]);
                    $('#crpc110').html(response.data[110]);
                    $('#crpc144').html(response.data[144]);
                    $('#crpc145').html(response.data[145]);

                    $('#crpcMsg').text(response.msg).show();
                    // $("#ajaxform")[0].reset();
                    // $('.spinner').hide();
                    $('.report-crpc').removeClass('spinner');

                }
            },
            error: function(error) {
                console.log(error);
                $('#nameError').text(response.responseJSON.errors.division);
            }
        });
    }


    // Case Status Statistics 
    function emc_case_status_statistic() {
        // console.log('submitted!');
        // Variable
        let division = $("#division_id").val();
        let district = $("#district_id").val();
        let upazila = $("#upazila_id").val();
        let dateFrom = $("#date_from").val();
        let dateTo = $("#date_to").val();
        let _token = $('meta[name="csrf-token"]').attr('content');
        // console.log(division);

        // Loader
        $('.emc_report-case-status').addClass('spinner');

        // AJAX Request
        $.ajax({
            url: "{{ route('emc.dashboard.case-status-report') }}",
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
                console.log(response);
                if (response) {
                    // console.log(response.data['ON_TRIAL']);
                    $('#EMC_ON_TRIAL').html(response.data['ON_TRIAL']);
                    $('#EMC_ON_TRIAL_DM').html(response.data['ON_TRIAL_DM']);
                    $('#EMC_SEND_TO_EM').html(response.data['SEND_TO_EM']);
                    $('#EMC_SEND_TO_ADM').html(response.data['SEND_TO_ADM']);
                    $('#EMC_CLOSED').html(response.data['CLOSED']);
                    $('#EMC_REJECTED').html(response.data['REJECTED']);

                    $('#emc_caseStatusMsg').text(response.msg).show();
                    // $("#ajaxform")[0].reset();
                    // $('.spinner').hide();
                    $('.emc_report-case-status').removeClass('spinner');

                }
            },
            error: function(error) {
                console.log(error);
                $('#nameError').text(response.responseJSON.errors.division);
            }
        });
    }


    // Case Pie Chart
    function emc_case_pie_chart() {
        // Variable

        let division = $("#division_id").val();
        let district = $("#district_id").val();
        let upazila = $("#upazila_id").val();
        let dateFrom = $("#date_from").val();
        let dateTo = $("#date_to").val();
        let _token = $('meta[name="csrf-token"]').attr('content');


        var title = "hello";
        var year = "2022";
        var temp_title = title + ' ' + year + '';

        // Loader
        $('.emc_case-piechart').addClass('spinner');

        // Reqpuest
        $.ajax({
            url: "{{ route('emc.dashboard.crpc-pie-chart') }}",
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
                if (!response.data) {
                    document.getElementById('piechart_3d').innerHTML =
                        '<p style="margin-left: 178px;margin-top: 134px;font-size: 30px;"> কোন অভিযোগের তথ্য পাওয়া যায় নাই</p>';
                } else {
                    var data = google.visualization.arrayToDataTable([
                        ['CRPC', 'Case Count'],
                        ['CRPC 100', response.data[100]],
                        ['CRPC 107', response.data[107]],
                        ['CRPC 108', response.data[108]],
                        ['CRPC 109', response.data[109]],
                        ['CRPC 110', response.data[110]],
                        ['CRPC 144', response.data[144]],
                        ['CRPC 145', response.data[145]]
                    ]);

                    var options = {
                        // title: 'My Daily Activities',
                        is3D: true,
                    };

                    var chart = new google.visualization.PieChart(document.getElementById('emc_piechart_3d'));
                    chart.draw(data, options);
                }


                $('.emc_case-piechart').removeClass('spinner');
            }
        });
    }

   


    // Statistics 3
    function case_statistics_area() {
        // Variable
        let division = $("#division_id").val();
        let district = $("#district_id").val();
        let upazila = $("#upazila_id").val();
        let dateFrom = $("#date_from").val();
        let dateTo = $("#date_to").val();
        let _token = $('meta[name="csrf-token"]').attr('content');

        var title = "hello";
        var year = "2022";
        var temp_title = title + ' ' + year + '';

        // Loader
        $('.case-statistics-area').addClass('spinner');

        // Reqpuest
        $.ajax({
            url: "",
            method: "POST",
            data: {
                division: division,
                district: district,
                upazila: upazila,
                dateFrom: dateFrom,
                dateTo: dateTo,
                _token: _token
            },
            success: function(res) {
                // console.log(data);
                var data = [
                    ['Opening Move', 'মামলা'],
                    ["বরিশাল", res.data['বরিশাল']],
                    ["চট্টগ্রাম", res.data['চট্টগ্রাম']],
                    ["ঢাকা", res.data['ঢাকা']],
                    ["খুলনা", res.data['খুলনা']],
                    ["রাজশাহী", res.data['রাজশাহী']],
                    ['রংপুর', res.data['রংপুর']],
                    ["সিলেট", res.data['সিলেট']],
                    ["ময়মনসিংহ", res.data['ময়মনসিংহ']],
                ];

                drawMonthwiseChart(data, temp_title);
                $('.case-statistics-area').removeClass('spinner');
            }
        });
    }


    function drawMonthwiseChart(chart_data, chart_main_title) {
        var data = new google.visualization.arrayToDataTable(chart_data);

        var options = {
            title: 'মামলার ধরন',
            // width: 900,
            height: 300,
            legend: {
                position: 'none'
            },
            bars: 'veriticle', // Required for Material Bar Charts.
            axes: {
                x: {
                    0: {
                        side: 'bottom',
                        label: 'মামলার ধরন'
                    } // Top x-axis.
                }
            },
            bar: {
                groupWidth: "90%"
            }
        };

        var chart = new google.charts.Bar(document.getElementById('case_type_div'));
        chart.draw(data, options);


       
    }

    

</script>