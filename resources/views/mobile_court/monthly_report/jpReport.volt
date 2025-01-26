{{ content() }}

<style>
    label {
        background-color: #4c81db;
    }
    table.fixed {
        table-layout: auto;
    }


    table.newfont td {
        font-size: 14px !important;
    }

    table.fixed td {
        overflow: hidden;
        font-size: 14px !important;
    }

    div.smallhightspace {
        height: 15px;
    }

    .underline {
        text-decoration: underline;
    }

    div.bighightspace {
        height: 40px;
    }

    .content_form {
        /*min-height: 842px;  792px // 596 */
        width: 1200px;
        margin-left: auto;
        margin-right: auto;
        border: 1px dotted gray;
        font-family: nikoshBan;
    }

    .content_form_potrait {
        /*min-height: 842px;  792px // 596 */
        width: 792px;
        margin-left: auto;
        margin-right: auto;
        border: 1px dotted gray;
        font-size: 14px !important;
        font-family: nikoshBan !important;
    }

    .content_form_height {
        /*min-height: 842px;  792px // 596 */
        min-height: 1654px;

    }

    .form_top_title {
        font-size: 18px;
    }

    {
        margin-top: -18px
    ;
    }

    p {
        text-align: justify !important;
    }

    p.p_indent {
        text-indent: 10px;
    }

    h3 {
        text-align: center;
        font-size: 18px;
    }

    h3.top_title_2nd {
        margin-top: -18px;
    }

    h4.bottom_margin {
        margin-bottom: -18px;
    }

    .clear_div {
        clear: both;
        width: 100%;
        height: 20px;
    }

    br {
        line-height: 5px;
    }

    td.centertext {
        text-align: center;
    }

    div.bighightspace {
        height: 40px;
    }

    h1 {
        page-break-before: always;
    }


    @media print
    {
        table {page-break-inside:auto}
        /*div   {page-break-inside:avoid; page-break-after:always}*/
        /*thead { display:table-header-group; page-break-after:always}*/
        tfoot { display:table-footer-group }
    }

</style>
<?php echo $this->getContent(); ?>
{{ stylesheet_link('vendors/datepicker.css') }}
{{ javascript_include("vendors/bootstrap-datepicker.js") }}
{{ javascript_include("js/report/reportscript.js") }}
{{ javascript_include("js/jquery.canvasjs.min.js") }}
{{ javascript_include("assets/scripts.js") }}
{{ stylesheet_link('css/select2.css') }}
{{ javascript_include("js/select2.min.js") }}
{{ javascript_include("js/monthly_report/english_to_bangla.js") }}
{{ javascript_include("js/monthly_report/country_based_report.js") }}
{{ javascript_include("js/monthly_report/demoMonthlyReport.js") }}

<div class="panel panel-default">
    <div class="panel-heading smx">
        <h4 class="panel-title"> জনপ্রশাসন মন্ত্রণালয়ের কর্মরত কর্মকর্তাগণের মাসিক প্রতিবেদন </h4>
    </div>
    <div class="panel-body p-15 cpv">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <div class="clearfix">
                        <label class="control-label">প্রতিবেদনের ধরন </label>
                        <div class="form-group">
                            <select id="reportType" name="reportType" class="input" style="width: 100% !important;">
                                <option value="">প্রতিবেদনের বিষয় নির্বাচন করুন...</option>
                                <option value="1">বি সি এস ( প্রশাসন ) ক্যাডারের  বিভাগ পর্যায়ে কর্মরত কর্মকর্তাগণের তথ্য</option>
                                <option value="2">বি সি এস ( প্রশাসন ) ক্যাডারের  জেলা  পর্যায়ে কর্মরত কর্মকর্তাগণের তথ্য</option>
                                {#<option value="3">বিসিএস (প্রশাসনের) ক্যাডারের মাঠ পর্যায়ে কর্মরত#}
                                    {#সহকারী কমিশনার(ভুমি) / সহকারী কমিশনারগনের#}
                                    {#বিভাগভিত্তিক তথ্য </option>#}
                                <option value="4"> {#জেলা ভিত্তিক #}বি সি এস  (প্রশাসন) ক্যাডারভুক্ত কর্মকর্তা এবং উপ-সচিব ও তদুর্ধ পদে অন্যান্য ক্যাডার থেকে আগত পরিচিতি নম্বরধারী কর্মকর্তাগণের তালিকা</option>
                                <option value="5">{#জেলা ভিত্তিক#} বি সি এস  (প্রশাসন) ক্যাডারের  কর্মকর্তাদের প্রতিবেদন</option>
                                {#<option value="6">জেলা প্রশাসকের কার্যালয়ে নিযুক্ত শিক্ষানবিস সহকারী কমিশনারগনের জন্য কর্মকালীন প্রশিক্ষণের অগ্রগতি ও মূল্যায়ন সম্পর্কিতপ্রতিবেদন </option>#}
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <label class="control-label">বিভাগ </label>
                <?php echo $this->tag->select(array(
                "division",
                $division,
                "using" => array("divid", "divname"),
                'useEmpty' => true,
                'emptyText' => 'বিভাগ বাছাই করুন',
                'emptyValue' => '',
                'style' => 'width:100%',
                'class' => "input",
                'onchange' => "showZilla(this.value,'zilla')"
                )) ?>
                <p for="fruits" class="error text-danger"></p>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <label class="control-label">জেলা </label>
                <?php echo $this->tag->select(array(
                "zilla",
                $zilla,
                "using" => array("zillaid", "zillaname"),
                'useEmpty' => true,
                'emptyText' => 'জেলা বাছাই করুন',
                'emptyValue' => '',
                'class' => "input",
                'style' => 'width:100%',
                'onchange'=>"showupozilladiv()"
                )) ?>
                <p for="fruits" class="error text-danger"></p>
            </div>

            {#<div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                    <label class="control-label">বিবেচ্য মাস</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                        <input type="text" class="form-control" placeholder="মাস  নির্বাচন করুন ..."  id="report_date2" name="report_date2" />
                    </div>
                </div>
            </div>#}
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <div class="form-group">

                </div>
            </div>
        </div>
    </div>
    <div class="panel-footer">
        <button class="btn btn-primary" type="submit" id="saveComplain" onclick="demoReport.showReport()">অনুসন্ধান</button>
        <a style="float: right" href="#" onclick="demoReport.printReport()" id="printButtonForRegi" class="btn btn-success btn-sm m-0 m-bottom-5">
            <span class="glyphicon glyphicon-print"></span>  প্রিন্ট
        </a>
        {#<button onclick="register.printtabledetails()" class="btn btn-success pull-right">#}
        {#<span class="glyphicon glyphicon-print"></span> Print#}
        {#</button>#}
    </div>


    <div class="panel-body p-15 cpv">

        <div id="printDemoReport">
            <style>
                @media print {
                    .content_form {
                        border: 0px dotted;
                    }

                    .content_form_potrait {
                        border: 0px dotted;
                    }
                    table { page-break-inside:auto; font-size: 12px;}
                    tr    { page-break-inside:avoid; page-break-after:auto }
                }
            </style>
            {#{{ stylesheet_link('css/protibedon.css') }}#}
            <div class="form_top_title">
                <table style="width: 100%">
                    <tr>
                        <td style="padding: 10px; font-size: larger" colspan="3" class="centertext"><b><span id="report_name_mbl"> প্রতিবেদনের  নাম </span></b></td>
                    </tr>
                </table>
            </div>
            <div class="form_top_title">

            </div>

            <table id='demoReportTable' border="1" style="border-collapse:collapse;" cellpadding="2px"
                   cellspacing="2px" width="100%">

            </table>
        </div>

    </div>

    <div style="margin-top: 150px;" class="modal fade bd-example-modal-lg" data-backdrop="static" data-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div class="modal-content" style="padding: 10px;">
                <span id="loadingModalBlock">সমগ্র দেশের  তথ্য প্রদর্শিত হচ্ছে ...</span>
            </div>
        </div>
    </div>
</div>


