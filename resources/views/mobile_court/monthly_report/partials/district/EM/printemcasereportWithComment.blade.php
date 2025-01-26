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

<div id="printemcasereportWithComment" class="content_form_potrait">
   
    <div style="page-break-after: avoid;" class="form_top_title">
        <table style="width: 100%">
            <tr>
                <td colspan="3" class="centertext"><span id="cmt_em_allmonthreg_name">allmonthreg_name</span></td>
            </tr>
            <tr>
                <td colspan="3" class="centertext"><span id="cmt_em_month_year">month_year</span></td>
            </tr>
        </table>
    </div>


    <table class="newfont"  id='cmt_em_monthlyregister_table' border="1" style="border-collapse:collapse;" cellpadding="2px"
           cellspacing="2px" width="100%">
        <tr>
            <td class="centertext" style="width: 4%" ROWSPAN=2>ক্রম</td>
            <td class="centertext" style="width: 10%" ROWSPAN=2>জেলা</td>
            <td class="centertext" style="width: 6%" ROWSPAN=2>পুর্ববর্তী মাসের মামলার জের</td>
            <td class="centertext" style="width: 6%" ROWSPAN=2>দায়েরকৃত মামলার সংখ্যা</td>
            <td class="centertext" style="width: 6%" ROWSPAN=2>মোট মামলার সংখ্যা</td>
            <td class="centertext" style="width: 6%" ROWSPAN=2>নিষ্পত্তিকৃত মামলার সংখ্যা</td>
            <td class="centertext" style="width: 6%" ROWSPAN=2> অনিষ্পন্ন মামলার সংখ্যা</td>
            <td class="centertext" style="width: 36%;" colspan="3">অনিষ্পন্ন মামলার সংখ্যা</td>
            <td class="centertext" style="width: 3%" ROWSPAN=2>প্রমাপ</br>(%)</td>
            <td class="centertext" style="width: 3%" ROWSPAN=2>অর্জন</br>(%)</td>
            <td class="centertext" style="width: 8%" ROWSPAN=2>প্রমাপ অর্জন</td>
            <td class="centertext" style="width: 32%" ROWSPAN=2>মন্তব্য</td>
        </tr>
        <tr>
            <td class="centertext" style="width: 9%">০১ বছরের ঊর্ধ্বে মামলা</td>
            <td class="centertext" style="width: 9%">০২ বছরের ঊর্ধ্বে মামলা</td>
            <td class="centertext" style="width: 9%">০৩ বছর বা তদূর্ধ্ব মামলা</td>
        </tr>
    </table>
  
</div>


<script>
    function pemc_setParamsWithComment(data) {

        document.getElementById("cmt_em_allmonthreg_name").innerHTML = data.name;
        document.getElementById("cmt_em_month_year").innerHTML = data.month_year;

//        document.getElementById("allmonthreg_officename").innerHTML= data.zilla_name;
//        document.getElementById("allmonthreg_mag_name").innerHTML = data.mag_name? data.mag_name : "" ;

        var myTable = document.getElementById("cmt_em_monthlyregister_table");
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
            if(rowcount == 38 )
            {
                $('#cmt_em_monthlyregister_table').append(
                        '<tr>' +
                                '<td colspan="15"> <div style="page-break-after:always;height: 10px"></div></td>' +
                                '</tr>' +
                                '<tr>' +
                                '<tr> ' +
                                '<tr style="height: 45px"><td colspan="15"></td></tr> ' +
                                '<td class="centertext" style="width: 4%" ROWSPAN=2>ক্রম</td>' +
                                '<td class="centertext" style="width: 10%" ROWSPAN=2>জেলা</td>' +
                                '<td class="centertext" style="width: 6%" ROWSPAN=2>পুর্ববর্তী মাসের মামলার জের</td> ' +
                                '<td class="centertext" style="width: 6%" ROWSPAN=2>দায়েরকৃত মামলার সংখ্যা</td> ' +
                                '<td class="centertext" style="width: 6%" ROWSPAN=2>মোট মামলার সংখ্যা</td> ' +
                                '<td class="centertext" style="width: 6%" ROWSPAN=2>নিষ্পত্তিকৃত মামলার সংখ্যা</td> ' +
                                '<td class="centertext" style="width: 6%" ROWSPAN=2> অনিষ্পন্ন মামলার সংখ্যা</td> ' +
                                '<td class="centertext" style="width: 36%;" colspan="3">অনিষ্পন্ন মামলার সংখ্যা</td> ' +
                                '<td class="centertext" style="width: 3%" ROWSPAN=2>প্রমাপ</br>(%)</td> ' +
                                '<td class="centertext" style="width: 3%" ROWSPAN=2>অর্জন</br>(%)</td> ' +
                                '<td class="centertext" style="width: 8%" ROWSPAN=2>প্রমাপ অর্জন</td> ' +
                                '<td class="centertext" style="width: 32%" ROWSPAN=2>মন্তব্য</td> ' +
                                '</tr> ' +
                                '<tr> ' +
                                '<td class="centertext" style="width: 9%">০১ বছরের ঊর্ধ্বে মামলা</td> ' +
                                '<td class="centertext" style="width: 9%">০২ বছরের ঊর্ধ্বে মামলা</td> ' +
                                '<td class="centertext" style="width: 9%">০৩ বছর বা তদূর্ধ্ব মামলা</td> ' +
                                '</tr>');
            }
            if (element['comment1'] == "1") {
                comment1 = 'হয়েছে';
            } else {
                comment1 = 'হয়নি';
            }

            if (index == 28) {
                $('#cmt_em_monthlyregister_table').append(
                );
            }

            if (divname == element['divname']) {
                if (divname == element['divname']) {
                    if (rowcount == noofRow) {
                        totaltext = 'সর্বমোট';
                    }
                    if (zillaname == element['zillaname']) {
                        $('#cmt_em_monthlyregister_table').append(
                                '<tr>' +
                                        '<td class="centertext"> ' + " " + '</td>' +
                                        '<td > ' + totaltext + '</td>' +
                                        '<td class="centertext"> ' + element['pre_case_incomplete'] + '</td>' +
                                        '<td class="centertext"> ' + element['case_submit'] + '</td>' +
                                        '<td class="centertext"> ' + element['case_total'] + '</td>' +
                                        '<td class="centertext"> ' + element['case_complete'] + '</td>' +
                                        '<td class="centertext"> ' + element['case_incomplete'] + '</td>' +
                                        '<td class="centertext"> ' + element['case_above1year'] + '</td>' +
                                        '<td class="centertext"> ' + element['case_above2year'] + '</td>' +
                                        '<td class="centertext"> ' + element['case_above3year'] + '</td>' +
                                        '<td class="centertext"> ' + "-" + '</td>' +
                                        '<td class="centertext"> ' + "-" + '</td>' +
                                        '<td class="centertext"> ' + "-" + '</td>' +
                                        '<td class="centertext"> ' + "-" + '</td>' +
                                        '</tr>');
                    } else {
                        slno++;
                        $('#cmt_em_monthlyregister_table').append(
                                '<tr>' +
                                        '<td class="centertext"> ' + slno + '</td>' +
                                        '<td > ' + element['zillaname'] + '</td>' +
                                        '<td class="centertext" > ' + element['pre_case_incomplete'] + '</td>' +
                                        '<td class="centertext" > ' + element['case_submit'] + '</td>' +
                                        '<td class="centertext" > ' + element['case_total'] + '</td>' +
                                        '<td class="centertext" > ' + element['case_complete'] + '</td>' +
                                        '<td class="centertext"> ' + element['case_incomplete'] + '</td>' +
                                        '<td class="centertext"> ' + element['case_above1year'] + '</td>' +
                                        '<td class="centertext"> ' + element['case_above2year'] + '</td>' +
                                        '<td class="centertext"> ' + element['case_above3year'] + '</td>' +
                                        '<td class="centertext" > ' + element['promap'] + '</td>' +
                                        '<td class="centertext" > ' + element['promap_achive'] + '</td>' +
                                        '<td class="centertext" > ' + comment1 + '</td>' +
                                        '<td class="centertext" > ' + element['comment2'] + '</td>' +
                                        '</tr>');
                        zillaname = element['zillaname'];
                    }
                }

            } else {
                slno++;
                $('#cmt_em_monthlyregister_table').append(
                        '<tr>' +
                                '<td class="centertext" colspan="13" > ' + element['divname'] + " বিভাগ" + '</td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td class="centertext"> ' + slno + '</td>' +
                                '<td > ' + element['zillaname'] + '</td>' +
                                '<td class="centertext" > ' + element['pre_case_incomplete'] + '</td>' +
                                '<td class="centertext" > ' + element['case_submit'] + '</td>' +
                                '<td class="centertext" > ' + element['case_total'] + '</td>' +
                                '<td class="centertext" > ' + element['case_complete'] + '</td>' +
                                '<td class="centertext"> ' + element['case_incomplete'] + '</td>' +
                                '<td class="centertext"> ' + element['case_above1year'] + '</td>' +
                                '<td class="centertext"> ' + element['case_above2year'] + '</td>' +
                                '<td class="centertext"> ' + element['case_above3year'] + '</td>' +
                                '<td class="centertext" > ' + element['promap'] + '</td>' +
                                '<td class="centertext" > ' + element['promap_achive'] + '</td>' +
                                '<td class="centertext" > ' + comment1 + '</td>' +
                                '<td class="centertext" > ' + element['comment2'] + '</td>' +
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

