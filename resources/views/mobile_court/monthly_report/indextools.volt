{#<!-- DatePicker  -->#}

<?php echo $this->getContent(); ?>
{{ stylesheet_link('vendors/datepicker.css') }}
{{ javascript_include("vendors/bootstrap-datepicker.js") }}

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

{{ javascript_include("js/report/reportscript.js") }}


<div class="mainwrapper">
    <div class="contentpanel">
        <div class="divSpace">
        </div>
        <div class="panel panel-default">
            <div class="panel-body cpv ">
                <div class="row" style="margin-left: 1px">
                    <div class="col-md-12">
                        <div class="panel panel-success-alt">
                            <div class="panel-heading panel-heading-dashboard">
                                <h3 class="panel-title-dashboard">
                                    অনুসন্ধানের উপাত্তসমূহ
                                </h3>
                            </div>
                            <!-- panel-heading -->
                            <div class="panel-body cpv ">
                                {#<div class="list-group-item">#}
                                <form method="post" action="{{ url("report/showReport") }}"
                                      autocomplete="off"  target="_blank" style="font-family: NIKOSHBAN">
                                    <table class="table" border="0" cellpadding="0" cellspacing="0" style="width: 100%">
                                        <tr>
                                            <td>

                                                <?php echo $this->tag->select(array(
                                                "reportlist",
                                                $reportlist,
                                                "using" => array("id", "name"),
                                                "useDummy" => true,
                                                "useEmpty" => true,
                                                'class' => "input",
                                                'onChange' =>""
                                                )) ?>
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
                                    <button class="btn btn-primary mr5" type="submit" id="saveComplain"
                                            onclick="">
                                        প্রতিবেদন অনুসন্ধান
                                    </button>
                                    {#</div>#}
                                </form>
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


