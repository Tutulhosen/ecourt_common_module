{#<!-- DatePicker  -->#}


<?php echo $this->getContent(); ?>
{{ stylesheet_link('vendors/datepicker.css') }}
{{ javascript_include("vendors/bootstrap-datepicker.js") }}
{{ javascript_include("js/report/reportscript.js") }}


{#graph#}

{#{{ stylesheet_link('css/bootstrap-responsive.min.css') }}#}
{#{{ stylesheet_link('vendors/morris/morris.css') }}#}
{#{{ stylesheet_link('vendors/jGrowl/jquery.jgrowl.css') }}#}
{#{{ stylesheet_link('assets/styles.css') }}#}



{#{{ javascript_include("vendors/modernizr-2.6.2-respond-1.1.0.min.js") }}#}
{#{{ javascript_include("vendors/jquery.knob.js") }}#}
{#{{ javascript_include("vendors/raphael-min.js") }}#}
{#{{ javascript_include("vendors/morris/morris.js") }}#}
{#{{ javascript_include("vendors/flot/jquery.flot.js") }}#}
{#{{ javascript_include("vendors/flot/jquery.flot.categories.js") }}#}
{#{{ javascript_include("vendors/flot/jquery.flot.pie.js") }}#}
{#{{ javascript_include("vendors/flot/jquery.flot.time.js") }}#}
{#{{ javascript_include("vendors/flot/jquery.flot.stack.js") }}#}
{#{{ javascript_include("vendors/flot/jquery.flot.resize.js") }}#}
{#{{ javascript_include("assets/scripts.js") }}#}



{#<script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>#}
{#<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>#}
{#<script src="http://cdn.oesmith.co.uk/morris-0.4.1.min.js"></script>#}


<div class="mainwrapper">
    <div class="contentpanel">
        <div class="divSpace">
        </div>
        <div class="panel panel-default">
            <div class="panel-body cpv ">
                <div class="row" style="margin-left: 1px">
                    <div class="col-md-4">
                        <div class="panel  panel-default">
                            <div class="panel-heading panel-heading-dashboard">
                                <h3 class="panel-title-dashboard">
                                    মাসভিত্তিক মোট মোবাইল কোর্টের সংখ্যা
                                </h3>
                            </div>
                            <!-- panel-heading -->
                            <div class="panel-body cpv padding15">
                                <div id="hero-bar-court-js" style="width:100%;height:200px"></div>
                            </div>
                            <!-- panel-body cpv -->
                            <div class="panel-footer panel-footer-thin">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="panel  panel-default">
                            <div class="panel-heading panel-heading-dashboard">
                                <h3 class="panel-title-dashboard">
                                    এক্সিকিউটিভ ম্যাজিস্ট্রেট আদালতে ফৌ. কা. এর আওতাধীন মামলার তথ্য
                                </h3>
                            </div>
                            <!-- panel-heading -->
                            <div class="panel-body cpv padding15">
                                <div id="hero-bar-em-js" style="width:100%;height:200px; "></div>
                            </div>
                            <!-- panel-body cpv -->
                            <div class="panel-footer panel-footer-thin">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="panel panel-success-alt">
                            <div class="panel-heading panel-heading-dashboard">
                                <h3 class="panel-title-dashboard">
                                    অনুসন্ধানের উপাত্তসমূহ
                                </h3>
                            </div>
                            <!-- panel-heading -->
                            <div class="panel-body cpv ">
                                {#<div class="list-group-item">#}
                                <table class="table" border="0" cellpadding="0" cellspacing="0" style="width: 100%">
                                    <tr>
                                        <td>
                                            {#<label class="control-label">গ্রাফের বিষয়  নির্বাচন করুন</label>#}
                                            <select id="reportlist" name="reportlist" class="input"
                                                    style="width: 100% !important;" useDummy="1" onChange="">
                                                <option value="">প্রতিবেদন নির্বাচন করুন ...</option>
                                                <option value="1">মোবাইল কোর্টের মাসিক প্রতিবেদন</option>
                                                <option value="2">মোবাইল কোর্টের আপিল মামলার তথ্য</option>
                                                <option value="3">ADM কোর্টের মামলার তথ্য</option>
                                                <option value="4">EM কোর্টের মামলার তথ্য</option>
                                                <option value="5">এক্সিকিউটিভ ম্যাজিস্ট্রেটের আদালত পরিদর্শন</option>
                                                <option value="6">মোবাইল কোর্ট কেস রেকর্ড পর্যালোচনা</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select id="graphlist" name="graphlist" class="input"
                                                    style="width: 100% !important;" useDummy="1" onChange="">
                                                <option value="">গ্রাফের বিষয় নির্বাচন করুন...</option>
                                                <option value="1">মোবাইল কোর্টের সংখ্যা</option>
                                                <option value="2">মোবাইল কোর্টের মামলার সংখ্যা</option>
                                                <option value="3">মোবাইল কোর্টে আদায়কৃত অর্থের পরিমাণ(টাকায়)</option>
                                                <option value="4">মোবাইল কোর্ট আইনের আওতায় দায়েরকৃত আপিল মামলার বিবরণ
                                                </option>
                                                <option value="4">এক্সিকিউটিভ ম্যাজিস্ট্রেট আদালতে ফৌ. কা. এর আওতাধীন
                                                    মামলার তথ্য
                                                </option>
                                                <option value="5">অতিরিক্ত জেলা ম্যাজিস্ট্রেট আদালতে ফৌ. কা. এর আওতাধীন
                                                    মামলার তথ্য
                                                </option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="control-label">মাস নির্বাচন করুন ...</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i
                                                            class="glyphicon glyphicon-calendar"></i></span>
                                                <input type="text" class="form-control" placeholder="mm-yyyy"
                                                       id="report_date" name="report_date"
                                                       required="true"/>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                <button class="btn btn-primary mr5" type="submit" id="saveComplain"
                                        onclick="showReport()">
                                    অনুসন্ধান
                                </button>
                                {#</div>#}
                            </div>
                            <!-- panel-body cpv -->
                            <div class="panel-footer panel-footer-thin">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="divSpace">
                </div>
                <!-- first row -->
                <div class="row" style="margin-left: 1px">
                    <div class="col-md-6">
                        <div class="panel  panel-default">
                            <div class="panel-heading panel-heading-dashboard">
                                <h3 class="panel-title-dashboard">
                                    মাসভিত্তিক মোট মোবাইল কোর্টের মামলার সংখ্যা
                                </h3>
                            </div>
                            <!-- panel-heading -->
                            <div class="panel-body cpv padding15">
                                <div id="hero-bar-case-js" class="morris-chart" style="width:100%;height:200px"></div>
                            </div>
                            <!-- panel-body cpv -->
                            <div class="panel-footer panel-footer-thin">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel  panel-default">
                            <div class="panel-heading panel-heading-dashboard">
                                <h3 class="panel-title-dashboard">
                                    বিজ্ঞ অতিরিক্ত জেলা ম্যাজিস্ট্রেট আদালতে ফৌ. কা. এর আওতাধীন মামলার তথ্য
                                </h3>
                            </div>
                            <!-- panel-heading -->
                            <div class="panel-body cpv padding15">
                                <div id="hero-bar-adm-js" style="width:100%;height:200px"></div>
                            </div>
                            <!-- panel-body cpv -->
                            <div class="panel-footer panel-footer-thin">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="divSpace">
                </div>
                <!-- 2nd row -->
                <div class="row" style="margin-left: 1px">
                    <div class="col-md-6">
                        <div class="panel  panel-default">
                            <div class="panel-heading panel-heading-dashboard">
                                <h3 class="panel-title-dashboard">
                                    মাসভিত্তিক মোবাইল কোর্টে আদায়কৃত জরিমানার পরিমাণ(টাকায়)
                                </h3>
                            </div>
                            <!-- panel-heading -->
                            <div class="panel-body cpv padding15">
                                <div id="hero-bar-fine-js" style="width:100%;height:200px"></div>
                            </div>
                            <!-- panel-body cpv -->
                            <div class="panel-footer panel-footer-thin">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading panel-heading-dashboard">
                                <h3 class="panel-title-dashboard">
                                    মোবাইল কোর্ট আইনের আওতায় দায়েরকৃত আপিল মামলার বিবরণ
                                </h3>
                            </div>
                            <!-- panel-heading -->
                            <div class="panel-body cpv padding15">
                                <div id="hero-bar-appeal-js" style="width:100%;height:200px"></div>
                            </div>
                            <!-- panel-body cpv -->
                            <div class="panel-footer panel-footer-thin">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer panel-footer-thin" style="width: 100%">

                </div>
            </div>
        </div>
    </div>
</div>
<div id="printmobilecourtreport" style="display: none; ">
    {{ partial("monthly_report/partials/printmobilecourtreport") }}
</div>

<div id="printappealcasereport" style="display: none; ">
    {{ partial("monthly_report/partials/printappealcasereport") }}
</div>

<div id="printadmcasereport" style="display: none; ">
    {{ partial("monthly_report/partials/printadmcasereport") }}
</div>

<div id="printemcasereport" style="display: none; ">
    {{ partial("monthly_report/partials/printemcasereport") }}
</div>
<div id="printcourtvisitreport" style="display: none; ">
    {{ partial("monthly_report/partials/printcourtvisitreport") }}
</div>
<div id="printcaserecordreport" style="display: none; ">
    {{ partial("monthly_report/partials/printcaserecordreport") }}
</div>


<script>


jQuery(document).ready(function () {


    var chec = $('#report_date').datepicker({
        format: "mm-yyyy",
        viewMode: "months",
        minViewMode: "months",
        changeMonth: true,
        changeYear: true
    }).on('changeDate',function (ev) {
        chec.hide();
    }).data('datepicker');


//        $("#hero-bar-court-js").CanvasJSChart({
//            title: {
//                text: "Top Companies By Revenue - 2013"
//            },
//            axisY: {
//                title: "In Billions (USD)"
//            },
//            data: [
//                {
//                    type: "bar",
//                    toolTipContent: "{label}: US$ {y} billion",
//                    dataPoints: [
//                        { label: "Apple",             y: 198  },
//                        { label: "Toyota",            y: 250.1},
//                        { label: "ConocoPhillips",    y: 248  },
//                        { label: "Chevron",           y: 270.1},
//                        { label: "Sinopec",           y: 290.5},
//                        { label: "Vitol",             y: 320.2},
//                        { label: "British Petroleum", y: 410  },
//                        { label: "WalMart",           y: 464  },
//                        { label: "Royal Dutch Shell", y: 492  },
//                        { label: "Exxon Mobil",       y: 502.3}
//                    ]
//                }
//            ]
//        });


    chart_Court = Morris.Bar({
        element: 'hero-bar-court-jsabc',
        data: [0, 0], // Set initial data (ideally you would provide an array of default data)
        xkey: 'divname', // Set the key for X-axis
        ykeys: yData, // Set the key for Y-axis
        labels: yData, // Set the label when bar is rolled over
        resize: true,
        barRatio: 0.6,
        xLabelMargin: 0.5,
        hideHover: 'auto',
//            xLabelAngle: 45,
        axes: true,
        barColors: ['#CC3399', '#FF6600', '#FFFF00', '#0033FF'],

    });

    chart_Case = Morris.Bar({
        element: 'hero-bar-case-js',
        axes: true,
        data: [0, 0], // Set initial data (ideally you would provide an array of default data)
        xkey: 'divname', // Set the key for X-axis
        ykeys: yData, // Set the key for Y-axis
        labels: yData, // Set the label when bar is rolled over
        resize: true,
        barRatio: 0.6,
        xLabelMargin: 0.5,
        hideHover: 'auto',
        barColors: ['#CC3399', '#FF6600', '#FFFF00', '#0033FF'],
        gridEnabled: false

    });
    chart_Fine = Morris.Bar({
        element: 'hero-bar-fine-js',
        axes: true,
        data: [0, 0], // Set initial data (ideally you would provide an array of default data)
        xkey: 'divname', // Set the key for X-axis
        ykeys: yData, // Set the key for Y-axis
        labels: yData, // Set the label when bar is rolled over
        resize: true,
        barRatio: 0.6,
        xLabelMargin: 0.5,
        hideHover: 'auto',
        barColors: ['#CC3399', '#FF6600', '#FFFF00', '#0033FF'],
        gridEnabled: false

    });

    chart_Appeal = Morris.Bar({
        element: 'hero-bar-appeal-js',
        axes: true,
        data: [0, 0], // Set initial data (ideally you would provide an array of default data)
        xkey: 'divname', // Set the key for X-axis
        ykeys: ['জের', 'দায়েরকৃত', 'নিষ্পন্ন', 'অনিষ্পন্ন'], // Set the key for Y-axis
        labels: ['জের', 'দায়েরকৃত', 'নিষ্পন্ন', 'অনিষ্পন্ন'], // Set the label when bar is rolled over
        resize: true,
        barRatio: 0.6,
        xLabelMargin: 0.5,
        hideHover: 'auto',
        barColors: ['#CC3399', '#FF6600', '#FFFF00', '#0033FF'],
        gridEnabled: false

    });
    chart_Em = Morris.Bar({
        element: 'hero-bar-em-js',
        axes: true,
        data: [0, 0], // Set initial data (ideally you would provide an array of default data)
        xkey: 'divname', // Set the key for X-axis
        ykeys: ['জের', 'দায়েরকৃত', 'নিষ্পন্ন', 'অনিষ্পন্ন'], // Set the key for Y-axis
        labels: ['জের', 'দায়েরকৃত', 'নিষ্পন্ন', 'অনিষ্পন্ন'], // Set the label when bar is rolled over
        resize: true,
        barRatio: 0.6,
        xLabelMargin: 0.5,
        hideHover: 'auto',
        barColors: ['#CC3399', '#FF6600', '#FFFF00', '#0033FF'],
        gridEnabled: false

    });
    chart_Adm = Morris.Bar({
        element: 'hero-bar-adm-js',
        axes: true,
        data: [0, 0], // Set initial data (ideally you would provide an array of default data)
        xkey: 'divname', // Set the key for X-axis
        ykeys: ['জের', 'দায়েরকৃত', 'নিষ্পন্ন', 'অনিষ্পন্ন'], // Set the key for Y-axis
        labels: ['জের', 'দায়েরকৃত', 'নিষ্পন্ন', 'অনিষ্পন্ন'], // Set the label when bar is rolled over
        resize: true,
        barRatio: 0.6,
        xLabelMargin: 0.5,
        hideHover: 'auto',
        barColors: ['#CC3399', '#FF6600', '#FFFF00', '#0033FF'],
        gridEnabled: false

    });
//        graphCourtForCountry();
//        graphCaseForCountry();
//        graphFineForCountry();
//        graphAppealForCountry();
//        graphEmForCountry();
//        graphAdmForCountry();

});

function graphCourtForCountry() {

    var report_date = $('#report_date').val();


    $.ajax({
        type: "GET",
        dataType: 'json',
        url: "../monthly_report/ajaxDataCourtForCountry?report_date=" + report_date // This is the URL to the API
    })
            .done(function (response) {
                // When the response to the AJAX request comes back render the chart with new data
//                    console.log(response);
                if (response[0].length > 0) {

                    var data = response[0][0]['yData'];
                    for (var i = 0; i < data.length; i++) {
                        yData.push(data[i]);
                    }
                    chart_Court.setData(response[0]);
                }
            })
            .fail(function () {
                alert("error occured");
            });
}
function graphCaseForCountry() {
    $.ajax({
        type: "GET",
        dataType: 'json',
        url: "../monthly_report/ajaxDataCaseForCountry" // This is the URL to the API
    })
            .done(function (response) {
                // When the response to the AJAX request comes back render the chart with new data
//                    console.log(response);
                if (response[0].length > 0) {
                    chart_Case.setData(response[0]);
                }
            })
            .fail(function () {
                alert("error occured");
            });
}

function graphFineForCountry() {
    $.ajax({
        type: "GET",
        dataType: 'json',
        url: "../monthly_report/ajaxDataFineForCountry" // This is the URL to the API
    })
            .done(function (response) {
                // When the response to the AJAX request comes back render the chart with new data
//                    console.log(response);
                if (response[0].length > 0) {
                    chart_Fine.setData(response[0]);
                }
            })
            .fail(function () {
                alert("error occured");
            });
}

function graphAppealForCountry() {
    $.ajax({
        type: "GET",
        dataType: 'json',
        url: "../monthly_report/ajaxDataAppealForCountry" // This is the URL to the API
    })
            .done(function (response) {
                // When the response to the AJAX request comes back render the chart with new data
//                    console.log(response);
                if (response[0].length > 0) {
                    chart_Appeal.setData(response[0]);
                }
            })
            .fail(function () {
                alert("error occured");
            });
}

function graphEmForCountry() {
    $.ajax({
        type: "GET",
        dataType: 'json',
        url: "../monthly_report/ajaxDataEmForCountry" // This is the URL to the API
    })
            .done(function (response) {
                // When the response to the AJAX request comes back render the chart with new data
//                    console.log(response);
                if (response[0].length > 0) {
                    chart_Em.setData(response[0]);
                }
            })
            .fail(function () {
                alert("error occured");
            });
}

function graphAdmForCountry() {
    $.ajax({
        type: "GET",
        dataType: 'json',
        url: "../monthly_report/ajaxDataAdmForCountry" // This is the URL to the API
    })
            .done(function (response) {
                // When the response to the AJAX request comes back render the chart with new data
//                    console.log(response);
                if (response[0].length > 0) {
                    chart_Adm.setData(response[0]);
                }
            })
            .fail(function () {
                alert("error occured");
            });
}
</script>

