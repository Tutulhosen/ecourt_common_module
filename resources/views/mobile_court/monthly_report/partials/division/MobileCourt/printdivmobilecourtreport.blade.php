<style>

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
        width: 1200px;
        margin-left: auto;
        margin-right: auto;
        border: 1px dotted gray;
        font-family: nikoshBan;
    }

    .content_form_potrait {
        width: 792px;
        margin-left: auto;
        margin-right: auto;
        border: 1px dotted gray;
        font-size: 14px !important;
        font-family: nikoshBan !important;
    }

    .content_form_height {
        min-height: 1654px;

    }

    .form_top_title {
        font-size: 18px;
    }

    {
        margin-top: -18px
    ;
    }

    @media print {
        .content_form {
            border: 0px dotted;
        }

        .content_form_potrait {
            border: 0px dotted;
        }
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
        tfoot { display:table-footer-group }
    }

</style>

<div id="printdivmobilecourtreport" class="content_form_potrait">
  
    <div class="form_top_title">
        <table style="width: 100%">
            <tr>
                <td colspan="3" class="centertext"><span
                            id="div_mobile_allmonthreg_name">allmonthreg_name</span></td>
            </tr>
            <tr>
                <td colspan="3" class="centertext"><span id="div_mobile_month_year">month_year</span></td>
            </tr>
        </table>
    </div>


    <table id='div_mobile_monthlyregister_table' border="1" style="border-collapse:collapse;" cellpadding="2px"
           cellspacing="2px" width="100%">
        <tr>
            <td class="centertext" style="width: 10px" ROWSPAN=3>বিভাগের নাম</td>
            <td class="centertext" colspan="2" ROWSPAN=2 style="width: 15px">আদালত পরিচালনার সংখ্যা</td>
            <td class="centertext" colspan="2" ROWSPAN=2 style="width: 15px">মামলার সংখ্যা</td>
            <td class="centertext" colspan="2" ROWSPAN=2 style="width: 15px">জরিমানার পরিমাণ (টাকায়)</td>
            <td class="centertext" colspan="4" style="width: 15px">আসামির সংখ্যা</td>
            <td class="centertext" style="width: 10px" ROWSPAN=3>প্রমাপ অর্জন</td>
        </tr>
        <tr>
            <td class="centertext" colspan="2" style="width: 7px">মোট</td>
            <td class="centertext" colspan="2" style="width: 8px">কারাদণ্ড প্রাপ্ত</td>
        </tr>

        <tr>
            <td class="centertext" style="width: 8px">পূর্বের মাস</td>
            <td class="centertext" style="width: 7px">বিবেচ্য মাস</td>
            <td class="centertext" style="width: 8px">পূর্বের মাস</td>
            <td class="centertext" style="width: 7px">বিবেচ্য মাস</td>
            <td class="centertext" style="width: 8px">পূর্বের মাস</td>
            <td class="centertext" style="width: 7px">বিবেচ্য মাস</td>
            <td class="centertext" style="width: 8px">পূর্বের মাস</td>
            <td class="centertext" style="width: 7px">বিবেচ্য মাস</td>
            <td class="centertext" style="width: 8px">পূর্বের মাস</td>
            <td class="centertext" style="width: 7px">বিবেচ্য মাস</td>
        </tr>
    </table>
</div>


<script>
    function pdivmc_setParams(data) {

        document.getElementById("div_mobile_allmonthreg_name").innerHTML = data.name;
        document.getElementById("div_mobile_month_year").innerHTML = data.month_year;


        var myTable = document.getElementById("div_mobile_monthlyregister_table");
        var rowCount = myTable.rows.length;
        for (var x = rowCount - 1; x > 2; x--) {
            myTable.deleteRow(x);
        }
        var slno = 0;
        var rowcount = 0;
        var divname = "";
        var zillaname = "";
        var grandtotal = 0;
        var totaltext = 'মোট';
        var noofRow = data.result.length;
        var promapachive = "-";
        $(data.result).each(function (index, element) {
            rowcount++;
            if(element['court_total2'] == 0){
                promapachive = "হয়নি" ;
            }else{
                promapachive = (element['court_total2'] - element['promap'] >= 0 ?"হয়েছে" :"হয়নি") ;
            }
            if (divname == element['divname']) {
                totaltext = 'সর্বমোট';
                $('#div_mobile_monthlyregister_table').append(
                        '<tr>' +
                                '<td class="centertext"> ' + totaltext + '</td>' +
                                '<td class="centertext"> ' + element['court_total1'] + '</td>' +
                                '<td class="centertext"> ' + element['court_total2'] + '</td>' +
                                '<td class="centertext"> ' + element['case_total1'] + '</td>' +
                                '<td class="centertext"> ' + element['case_total2'] + '</td>' +
                                '<td class="centertext"> ' + element['fine_total1'] + '</td>' +
                                '<td class="centertext"> ' + element['fine_total2'] + '</td>' +
                                '<td class="centertext"> ' + element['criminal_total1'] + '</td>' +
                                '<td class="centertext"> ' + element['criminal_total2'] + '</td>' +
                                '<td class="centertext"> ' + element['lockup_criminal_total1'] + '</td>' +
                                '<td class="centertext"> ' + element['lockup_criminal_total2'] + '</td>' +
                                '<td class="centertext"> ' + promapachive + '</td>' +
                                '</tr>');
            } else {
                slno++;
                grandtotal = 0;
                $('#div_mobile_monthlyregister_table').append(
                        '<tr>' +
                                '<td > ' + element['divname'] + '</td>' +
                                '<td class="centertext"> ' + element['court_total1'] + '</td>' +
                                '<td class="centertext"> ' + element['court_total2'] + '</td>' +
                                '<td class="centertext"> ' + element['case_total1'] + '</td>' +
                                '<td class="centertext"> ' + element['case_total2'] + '</td>' +
                                '<td class="centertext"> ' + element['fine_total1'] + '</td>' +
                                '<td class="centertext"> ' + element['fine_total2'] + '</td>' +
                                '<td class="centertext"> ' + element['criminal_total1'] + '</td>' +
                                '<td class="centertext"> ' + element['criminal_total2'] + '</td>' +
                                '<td class="centertext"> ' + element['lockup_criminal_total1'] + '</td>' +
                                '<td class="centertext"> ' + element['lockup_criminal_total2'] + '</td>' +
                                '<td class="centertext"> ' +  promapachive + '</td>' +
                                '</tr>');
                divname = element['divname'];
            }
        })
    }
</script>


