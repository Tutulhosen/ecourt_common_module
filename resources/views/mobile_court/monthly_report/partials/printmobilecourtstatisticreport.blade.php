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
<div id="printmobilecourtstatisticreport" class="content_form_potrait">
   
    <div style="page-break-after: avoid;" class="form_top_title">
        <table style="width: 100%">
            <tr>
                <td colspan="3" class="centertext"><span
                            id="mobile_court_report_name">allmonthreg_name</span></td>
            </tr>
            <tr>
              
                <td colspan="3" class="centertext"><span id="mobile_court_report_month_year">month_year</span></td>
            </tr>
        </table>
    </div>


    <table class="newfont"   id='mobile_courtstatistic_table' border="1" style="border-collapse:collapse;" cellpadding="2px"
           cellspacing="2px" width="100%">
        <tr>
            <td class="centertext" style="width: 5%" >ক্রম</td>
            <td class="centertext" style="width: 15%" >জেলা</td>
            <td class="centertext" style="width: 15%" >মোট মোবাইল কোর্টের সংখ্যা</td>
            <td class="centertext" style="width: 15%" >মোট মামলার সংখ্যা</td>
            <td class="centertext" style="width: 15%" >ম্যানুয়ালি পরিচালিত মামলার সংখ্যা</td>
            <td class="centertext" style="width: 18%" >ই-মোবাইল কোর্ট সিস্টেমে নিষ্পত্তিকৃত মামলার সংখ্যা</td>
            <td class="centertext" style="width: 17%" >ই-মোবাইল কোর্টে নিষ্পত্তিকৃত মামলার %</td>
        </tr>
    </table>
</div>

<script>
    function p_mobilecourtstatistic_setParams(data) {

        document.getElementById("mobile_court_report_name").innerHTML = data.name;
        document.getElementById("mobile_court_report_month_year").innerHTML = data.month_year;


        var myTable = document.getElementById("mobile_courtstatistic_table");
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
        var casepercent = "";


        $(data.result).each(function (index, element) {

            if(element['case_total'] != 0){
                casepercent = element['case_system'] / element['case_total'] * 100;
                casepercent = casepercent.toFixed(2);
            }else{
                casepercent = 0 ;
            }
            rowcount++;
            if(rowcount == 37)
            {
                $('#mobile_courtstatistic_table').append(
                        '<tr>' +
                                '<td colspan="15"> <div style="page-break-after:always;max-height: 1px"></div></td>' +
                                '</tr>' +
                                '<tr>' +
                                '<tr style="height: 45px"><td colspan="15"></td></tr> ' +
                                '<td class="centertext" style="width: 5%"  >ক্রম</td>' +
                                '<td class="centertext" style="width: 15%"  >জেলা</td>' +
                                '<td class="centertext" style="width: 15%"  >মোট মোবাইল কোর্টের সংখ্যা</td>' +
                                '<td class="centertext" style="width: 15%"  >মোট মামলার সংখ্যা</td>' +
                                '<td class="centertext" style="width: 15%"  >ম্যানুয়ালি পরিচালিত মামলার সংখ্যা</td>' +
                                '<td class="centertext" style="width: 18%"  >ই-মোবাইল কোর্ট সিস্টেমে নিষ্পত্তিকৃত মামলার সংখ্যা</td>' +
                                '<td class="centertext" style="width: 17%"  >ই-মোবাইল কোর্টে নিষ্পত্তিকৃত মামলার %</td>' +
                                '</tr> ' +
                                '</tr>');
            }
            //           alert(JSON.stringify(element));
            if (divname == element['divname']) {

                if (rowcount == noofRow) {
                    totaltext = 'সর্বমোট';
                }



                if (zillaname == element['zillaname']) {
                    $('#mobile_courtstatistic_table').append(
                            '<tr>' +
                                    '<td> ' + "" + '</td>' +
                                    '<td> ' + totaltext + '</td>' +
                                    '<td class="centertext"> ' + element['court_total'] + '</td>' +
                                    '<td class="centertext"> ' + element['case_total'] + '</td>' +
                                    '<td class="centertext"> ' + element['case_manual'] + '</td>' +
                                    '<td class="centertext"> ' + element['case_system'] + '</td>' +
                                    '<td class="centertext"> ' + casepercent + '</td>' +
                                    '</tr>');
                } else {
                    slno++;
                    $('#mobile_courtstatistic_table').append(
                            '<tr>' +
                                    '<td class="centertext"> ' + slno + '</td>' +
                                    '<td> ' + element['zillaname'] + '</td>' +
                                    '<td class="centertext"> ' + element['court_total'] + '</td>' +
                                    '<td class="centertext"> ' + element['case_total'] + '</td>' +
                                    '<td class="centertext"> ' + element['case_manual'] + '</td>' +
                                    '<td class="centertext"> ' + element['case_system'] + '</td>' +
                                    '<td class="centertext"> ' + casepercent + '</td>' +
                                    '</tr>');
                    zillaname = element['zillaname'];
                }
            } else {
                slno++;
                grandtotal = 0;
                $('#mobile_courtstatistic_table').append(
                        '<tr>' +
                                '<td class="centertext" colspan="15" > ' + element['divname'] + " বিভাগ" + '</td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td class="centertext"> ' + slno + '</td>' +
                                '<td> ' + element['zillaname'] + '</td>' +
                                '<td class="centertext"> ' + element['court_total'] + '</td>' +
                                '<td class="centertext"> ' + element['case_total'] + '</td>' +
                                '<td class="centertext"> ' + element['case_manual'] + '</td>' +
                                '<td class="centertext"> ' + element['case_system'] + '</td>' +
                                '<td class="centertext"> ' + casepercent + '</td>' +
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


