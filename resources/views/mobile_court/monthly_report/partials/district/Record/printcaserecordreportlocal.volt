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
        /*div   {page-break-inside:avoid; page-break-after:always}*/
        /*thead { display:table-header-group; page-break-after:always}*/
        tfoot { display:table-footer-group }
    }

</style>
<div id="printcaserecordreport" class="content_form_potrait">
    {#{{ stylesheet_link('css/protibedon.css') }}#}
    <div style="page-break-after: avoid;height: 100px" class="form_top_title">
        <table style="width: 100%">
            <tr>
                <td colspan="3" class="centertext"><span id="caserecord_allmonthreg_name">allmonthreg_name</span></td>
            </tr>
            <tr>
                {#<td> <h3><?php echo $this->bangladate->get_bangla_monthbymumber(3)?> </h3></td>#}
                <td colspan="3" class="centertext"><span id="caserecord_month_year">month_year</span></td>
            </tr>
        </table>
    </div>


    <table class="newfont" id='caserecord_monthlyregister_table' border="1" style="border-collapse:collapse;" cellpadding="2px"
           cellspacing="2px" width="100%">
        <tr>
            <td class="centertext" style="width: 5%">ক্রম</td>
            <td class="centertext" style="width: 15%">জেলা</td>
            <td class="centertext" style="width: 15%"> কেস রেকর্ড পর্যালোচনা প্রমাপ</td>
            <td class="centertext" style="width: 15%">কেস রেকর্ড পর্যালোচনা সংখ্যা</td>
            <td class="centertext" style="width: 40%">প্রমাপ অর্জন</td>
            <td class="centertext" style="width: 10%">মন্তব্য</td>
        </tr>
    </table>
</div>


<script>
    function pcr_setParams(data) {

        document.getElementById("caserecord_allmonthreg_name").innerHTML = data.name;
        document.getElementById("caserecord_month_year").innerHTML = data.month_year;

        var myTable = document.getElementById("caserecord_monthlyregister_table");
        var rowCount = myTable.rows.length;
        for (var x = rowCount - 1; x > 1; x--) {
            myTable.deleteRow(x);
        }

        var slno = 0;
        var rowcount = 0;
        var divname = "";
        var zillaname = "";
        var grandtotal = 0;
        var totaltext = 'মোট';
        var comment1 = 'হয়েছে';

        var noofRow = data.result.length;

        $(data.result).each(function (index, element) {
            rowcount++;

            var count = element['caserecord_count'] - 1 ;
            if (count >= 1) {
                comment1 = 'হয়েছে';
            } else {
                comment1 = 'হয়নি';
                count = 0;
            }

            if(rowcount == 38 )
            {
                $('#caserecord_monthlyregister_table').append(
                        '<tr>' +
                                '<td colspan="6"> <div style="page-break-after:always;height:0"></div></td>' +
                                '</tr>' +
                                '<tr style="height: 40px"><td colspan="6"></td></tr> ' +
                                '<tr>' +
                                '<td class="centertext" style="width: 5%">ক্রম</td>' +
                                '<td class="centertext" style="width: 15%">জেলা</td>' +
                                '<td class="centertext" style="width: 20%"> কেস রেকর্ড পর্যালোচনা প্রমাপ</td> ' +
                                '<td class="centertext" style="width: 20%">কেস রেকর্ড পর্যালোচনা সংখ্যা</td> ' +
                                '<td class="centertext" style="width: 40%">প্রমাপ অর্জন</td>' +
                                '<td class="centertext" style="width: 10%">মন্তব্য</td>' +
                                '</tr>');
            }

            if (element['comment1'] == "1") {
                comment1 = 'হয়েছে';
            } else {
                comment1 = 'হয়নি';
            }

            if (divname == element['divname']) {
                if (divname == element['divname']) {
                    if (rowcount == noofRow) {
                        totaltext = 'সর্বমোট';
                    }
                    if (zillaname == element['zillaname']) {

                        $('#caserecord_monthlyregister_table').append(
                                '<tr>' +
                                        '<td class="centertext"> ' + " " + '</td>' +
                                        '<td > ' + totaltext + '</td>' +
                                        '<td class="centertext"> ' + element['caserecord_promap'] + '</td>' +
                                        '<td class="centertext"> ' + element['caserecord_count'] + '</td>' +
                                        '<td class="centertext"> ' + "-" + '</td>' +
                                        '<td class="centertext"> ' + "-" + '</td>' +
                                        '</tr>');
                    } else {
                        slno++;
                        $('#caserecord_monthlyregister_table').append(
                                '<tr>' +
                                        '<td class="centertext" > ' + slno + '</td>' +
                                        '<td  > ' + element['zillaname'] + '</td>' +
                                        '<td class="centertext" > ' + element['caserecord_promap'] + '</td>' +
                                        '<td class="centertext" > ' +  count + '</td>' +
                                        '<td class="centertext" > ' + comment1 + '</td>' +
                                        '<td class="centertext"> ' + "-" + '</td>' +
                                        '</tr>');
                        zillaname = element['zillaname'];
                    }
                }

            } else {
                slno++;
                $('#caserecord_monthlyregister_table').append(
                        '<tr>' +
                                '<td class="centertext" colspan="13" > ' + element['divname'] + " বিভাগ" + '</td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td class="centertext"> ' + slno + '</td>' +
                                '<td> ' + element['zillaname'] + '</td>' +
                                '<td class="centertext"> ' + element['caserecord_promap'] + '</td>' +
                                '<td class="centertext"> ' + count + '</td>' +
                                '<td class="centertext"> ' + comment1 + '</td>' +
                                '<td class="centertext"> ' + "-" + '</td>' +
                                '</tr>');
                divname = element['divname'];
                zillaname = element['zillaname'];
                if (noofRow == 3) {  // only zilla
                    return false;
                }
            }
        })
    }
</script>

