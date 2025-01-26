{#<!-- DatePicker  -->#}


<?php echo $this->getContent(); ?>
{{ stylesheet_link('vendors/datepicker.css') }}
{{ javascript_include("vendors/bootstrap-datepicker.js") }}
{{ javascript_include("js/report/reportscriptdivcom.js") }}


{#graph#}

{{ stylesheet_link('css/bootstrap-responsive.min.css') }}
{{ stylesheet_link('vendors/morris/morris.css') }}
{{ stylesheet_link('vendors/jGrowl/jquery.jgrowl.css') }}
{{ stylesheet_link('assets/styles.css') }}



{{ javascript_include("vendors/modernizr-2.6.2-respond-1.1.0.min.js") }}
{{ javascript_include("vendors/jquery.knob.js") }}
{{ javascript_include("vendors/raphael-min.js") }}
{{ javascript_include("vendors/morris/morris.js") }}
{{ javascript_include("vendors/flot/jquery.flot.js") }}
{{ javascript_include("vendors/flot/jquery.flot.categories.js") }}
{{ javascript_include("vendors/flot/jquery.flot.pie.js") }}
{{ javascript_include("vendors/flot/jquery.flot.time.js") }}
{{ javascript_include("vendors/flot/jquery.flot.stack.js") }}
{{ javascript_include("vendors/flot/jquery.flot.resize.js") }}
{{ javascript_include("assets/scripts.js") }}


<div class="mainwrapper">
<div class="contentpanel">
<div class="divSpace">
</div>
<div class="panel panel-default">
<div class="panel-body cpv ">
<div class="row" style="margin-left: 1px">
    <div class="col-md-12">
        <div class="panel panel-success-alt">
            {#<div class="panel">#}
            <h3>
                {{ divname }} বিভাগ
            </h3>
            {#</div>#}
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
                                    style="width: 70% !important;" useDummy="1" onChange="">
                                <option value="">প্রতিবেদন নির্বাচন করুন ...</option>
                                <option value="1">মোবাইল কোর্টের মাসিক প্রতিবেদন</option>
                                <option value="2">মোবাইল কোর্টের আপিল মামলার প্রতিবেদন</option>
                                <option value="3">ADM কোর্টের মামলার প্রতিবেদন</option>
                                <option value="4">এক্সি. ম্যাজিস্ট্রেট কোর্টের মামলার প্রতিবেদন</option>
                                <option value="5">এক্সি. ম্যাজিস্ট্রেটের কোর্ট পরিদির্শন প্রতিবেদন
                                </option>
                                <option value="6">মোবাইল কোর্টের কেস রেকর্ড পর্যালোচনা প্রতিবেদন
                                </option>
                            </select>
                        </td>
                        <td>
                            <select id="graphlist" name="graphlist" class="input"
                                    style="width: 70% !important;" useDummy="1" onChange="">
                                <option value="">গ্রাফের বিষয় নির্বাচন করুন...</option>
                                <option value="1">মোবাইল কোর্টের সংখ্যা</option>
                                <option value="2">মোবাইল কোর্টের মামলার সংখ্যা</option>
                                <option value="3">মোবাইল কোর্টে আদায়কৃত অর্থের পরিমাণ(টাকায়)</option>
                                <option value="4">মোবাইল কোর্ট আইনের আওতায় দায়েরকৃত আপিল মামলার বিবরণ
                                </option>
                                <option value="5">এক্সিকিউটিভ ম্যাজিস্ট্রেট আদালতে ফৌ. কা. এর আওতাধীন
                                    মামলার তথ্য
                                </option>
                                <option value="6"> অতিরিক্ত জেলা ম্যাজিস্ট্রেট আদালতে ফৌ. কা. এর
                                    আওতাধীন মামলার তথ্য
                                </option>
                            </select>
                        </td>
                        <td>
                            <div class="input-group">
                                                <span class="input-group-addon"><i
                                                            class="glyphicon glyphicon-calendar"></i></span>
                                <input type="text" class="form-control"
                                       placeholder="মাস  নির্বাচন করুন ..." id="report_date"
                                       name="report_date"
                                       required="true"/>
                            </div>
                        </td>

                    </tr>

                </table>
            </div>

        </div>
        <div class="row" style="margin-left: 1px">
            <div class="col-md-3">
            </div>
            <div class="col-md-3">
                <button class="btn btn-primary mr5" type="submit" id="saveComplain"
                        onclick="showReport()">
                    প্রতিবেদন অনুসন্ধান
                </button>
            </div>
            <div class="col-md-3">
                <button class="btn btn-primary mr5" type="submit" id="showgraph" onclick="showGraph()">
                    গ্রাফ অনুসন্ধান
                </button>
            </div>
            <div class="col-md-3">
            </div>
        </div>
        <!-- panel-body cpv -->
        <div class="panel-footer panel-footer-thin">
        </div>
    </div>
</div>
<div class="divSpace">
</div>
<div class="row" style="margin-left: 1px">
    <div class="col-md-6">
        <div class="panel  panel-default">
            <div class="panel-heading panel-heading-dashboard">
                <h3 class="panel-title-dashboard">
                    মাসভিত্তিক মোট মোবাইল কোর্টের সংখ্যা
                </h3>
            </div>
            <!-- panel-heading -->
            <div class="panel-body cpv padding15">
                <div id="hero-bar-court-divcom" style="width:100%;height:200px"></div>
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
                    মাসভিত্তিক মোট মোবাইল কোর্টের মামলার সংখ্যা
                </h3>
            </div>
            <!-- panel-heading -->
            <div class="panel-body cpv padding15">
                <div id="hero-bar-case-divcom" class="morris-chart"
                     style="width:100%;height:200px"></div>
            </div>
            <!-- panel-body cpv -->
            <div class="panel-footer panel-footer-thin">
            </div>
        </div>
    </div>
    {#<div class="col-md-4">#}
    {##}
    {#</div>#}
</div>
<div class="divSpace">
</div>
<!-- first row -->
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
                <div id="hero-bar-fine-divcom" style="width:100%;height:200px"></div>
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
                    বিজ্ঞ অতিরিক্ত জেলা ম্যাজিস্ট্রেট আদালতে ফৌ. কা. এর আওতাধীন মামলার তথ্য <span
                            id="admreportmonth"></span>
                </h3>
            </div>
            <!-- panel-heading -->
            <div class="panel-body cpv padding15">
                <div id="hero-bar-adm-divcom" style="width:100%;height:200px"></div>
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
                    এক্সিকিউটিভ ম্যাজিস্ট্রেট আদালতে ফৌ. কা. এর আওতাধীন মামলার তথ্য<span
                            id="emreportmonth"></span>
                </h3>
            </div>
            <!-- panel-heading -->
            <div class="panel-body cpv padding15">
                <div id="hero-bar-em-divcom" style="width:100%;height:200px; "></div>
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
                    মোবাইল কোর্ট আইনের আওতায় দায়েরকৃত আপিল মামলার বিবরণ <span
                            id="appealreportmonth"></span>
                </h3>
            </div>
            <!-- panel-heading -->
            <div class="panel-body cpv padding15">
                <div id="hero-bar-appeal-divcom" style="width:100%;height:200px"></div>
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


