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
<div id="printmobilecourtreportWithComment" class="content_form_potrait">

    <div style="page-break-after: avoid;" class="form_top_title">
        <table style="width: 100%">
            <tr>
                <td colspan="3" class="centertext"><span
                            id="cmt_mobile_allmonthreg_name">allmonthreg_name</span></td>
            </tr>
            <tr>
              
                <td colspan="3" class="centertext"><span id="cmt_mobile_month_year">month_year</span></td>
            </tr>
        </table>
    </div>


    <table class="newfont"   id='cmt_mobile_monthlyregister_table' border="1" style="border-collapse:collapse;" cellpadding="2px"
           cellspacing="2px" width="100%">

        <tr>
            <td class="centertext" style="width: 5%" ROWSPAN=3>ক্রম</td>
            <td class="centertext" style="width: 5%" ROWSPAN=3>জেলা</td>
            <td class="centertext" style="width: 5%" ROWSPAN=3>উপজেলার সংখ্যা</td>
            <td class="centertext" style="width: 5%" ROWSPAN=3>প্রমাপ</td>
            <td class="centertext" colspan="2" ROWSPAN=2 style="width: 10%">মোবাইল কোর্টের সংখ্যা</td>
            <td class="centertext" colspan="2" ROWSPAN=2 style="width: 10%">মামলার সংখ্যা</td>
            <td class="centertext" colspan="2" ROWSPAN=2 style="width: 18%">আদায়কৃত অর্থ (টাকায়)</td>
            <td class="centertext" colspan="4" style="width: 30%">আসামির সংখ্যা</td>
            <td class="centertext" style="width: 12%" ROWSPAN=3>প্রমাপ অর্জন</td>
            <td class="centertext" style="width: 12%" ROWSPAN=3>মন্তব্য</td>
        </tr>
        <tr>
            <td class="centertext" colspan="2" style="width: 10%">মোট</td>
            <td class="centertext" colspan="2" style="width: 10%">কারাদণ্ড প্রাপ্ত</td>

        </tr>
        <tr>

            <td class="centertext" style="width: 5%">বর্তমান মাস</td>
            <td class="centertext" style="width: 5%">পূর্বের মাস</td>

            <td class="centertext" style="width: 5%">বর্তমান মাস</td>
            <td class="centertext" style="width: 5%">পূর্বের মাস</td>
            <td class="centertext" style="width: 9%">বর্তমান মাস</td>
            <td class="centertext" style="width: 9%">পূর্বের মাস</td>

            <td class="centertext" style="width: 5%">বর্তমান মাস</td>
            <td class="centertext" style="width: 5%">পূর্বের মাস</td>
            <td class="centertext" style="width: 5%">বর্তমান মাস</td>
            <td class="centertext" style="width: 5%">পূর্বের মাস</td>
        </tr>

    </table>
</div>


<script>
    function pmc_setHeaderParamswithcomment(connmentID,winprint){
        var myTable = document.getElementById("cmt_mobile_monthlyregister_table");
        if(winprint > 1)
        {
            myTable = document.getElementById("cmt_mobile_monthlyregister_table");
            var rowCount = myTable.rows.length;
            for (var x = rowCount-1; x >= 0  ; x--) {
                myTable.deleteRow(x);
            }
        }

        $('#cmt_mobile_monthlyregister_table').append(
                '<tr> ' +
                '<td class="centertext" style="width: 5%" ROWSPAN=3>ক্রম</td> ' +
                '<td class="centertext" style="width: 5%" ROWSPAN=3>জেলা</td> ' +
                '<td class="centertext" style="width: 5%" ROWSPAN=3>উপজেলার সংখ্যা</td> ' +
                '<td class="centertext" style="width: 5%" ROWSPAN=3>প্রমাপ</td> ' +
                '<td class="centertext" colspan="2" ROWSPAN=2 style="width: 10%">মোবাইল কোর্টের সংখ্যা</td> ' +
                '<td class="centertext" colspan="2" ROWSPAN=2 style="width: 10%">মামলার সংখ্যা</td> ' +
                '<td class="centertext" colspan="2" ROWSPAN=2 style="width: 18%">আদাআদায়কৃত অর্থাকায়)</td> ' +
                '<td class="centertext" colspan="4" style="width: 30%">আসামির সংখ্যা</td> ' +
                '<td class="centertext" style="width: 12%" ROWSPAN=3>প্রমাপ অর্জন</td> ' +
                '<td class="centertext" style="width: 12%" ROWSPAN=3>মন্তব্য</td> ' +
                '</tr> ' +
                '<tr> ' +
                '<td class="centertext" colspan="2" style="width: 10%">মোট</td> ' +
                '<td class="centertext" colspan="2" style="width: 10%">কারাদণ্ড প্রাপ্ত</td> ' +
                '</tr> ' +
                '<tr> ' +
                '<td class="centertext" style="width: 5%">বর্তমান মাস</td> ' +
                '<td class="centertext" style="width: 5%">পূর্বের মাস</td> ' +
                '<td class="centertext" style="width: 5%">বর্তমান মাস</td> ' +
                '<td class="centertext" style="width: 5%">পূর্বের মাস</td> ' +
                '<td class="centertext" style="width: 9%">বর্তমান মাস</td> ' +
                '<td class="centertext" style="width: 9%">পূর্বের মাস</td> ' +
                '<td class="centertext" style="width: 5%">বর্তমান মাস</td> ' +
                '<td class="centertext" style="width: 5%">পূর্বের মাস</td> ' +
                '<td class="centertext" style="width: 5%">বর্তমান মাস</td> ' +
                '<td class="centertext" style="width: 5%">পূর্বের মাস</td> ' +
                '</tr> '
        );

        rowCount = myTable.rows.length;
    }
    function pmc_setParamsWithComment(data,comment) {
//         alert("comment" + comment);

        document.getElementById("cmt_mobile_allmonthreg_name").innerHTML = data.name;
        document.getElementById("cmt_mobile_month_year").innerHTML = data.month_year;


        var myTable = document.getElementById("cmt_mobile_monthlyregister_table");
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
            if(rowcount == 37)
            {
                $('#cmt_mobile_monthlyregister_table').append(
                                '<tr>' +
                                '<td colspan="15"> <div style="page-break-after:always;max-height: 1px"></div></td>' +
                                '</tr>' +
                                '<tr>' +
								'<tr style="height: 45px"><td colspan="15"></td></tr><tr> ' +
                                '<td class="centertext" style="width: 5%" ROWSPAN=3>ক্রম</td>' +
                                '<td class="centertext" style="width: 5%" ROWSPAN=3>জেলা</td>' +
                                '<td class="centertext" style="width: 5%" ROWSPAN=3>উপজেলার সংখ্যা</td>' +
                                '<td class="centertext" style="width: 5%" ROWSPAN=3>প্রমাপ</td>' +
                                '<td class="centertext" colspan="2" ROWSPAN=2 style="width: 10%">মোবাইল কোর্টের সংখ্যা</td> ' +
                                '<td class="centertext" colspan="2" ROWSPAN=2 style="width: 10%">মামলার সংখ্যা</td> ' +
                                '<td class="centertext" colspan="2" ROWSPAN=2 style="width: 18%">আদায়কৃত জরিমানা (টাকায়)</td> ' +
                                '<td class="centertext" colspan="4" style="width: 30%">আসামির সংখ্যা</td> ' +
                                '<td class="centertext" style="width: 12%" ROWSPAN=3>প্রমাপ অর্জন</td> ' +
                                 '<td class="centertext" style="width: 12%" ROWSPAN=3>মন্তব্য</td> ' +
                                '<tr> ' +
                                '<td class="centertext" colspan="2" style="width: 10%">মোট</td> ' +
                                '<td class="centertext" colspan="2" style="width: 10%">কারাদণ্ড প্রাপ্ত</td> ' +
                                '</tr> ' +
                                '<tr> ' +
                                '<td class="centertext" style="width: 5%">বর্তমান মাস</td> ' +
                                '<td class="centertext" style="width: 5%">পূর্বের মাস</td>  ' +
                                '<td class="centertext" style="width: 5%">বর্তমান মাস</td> ' +
                                '<td class="centertext" style="width: 5%">পূর্বের মাস</td> ' +
                                '<td class="centertext" style="width: 9%">বর্তমান মাস</td> ' +
                                '<td class="centertext" style="width: 9%">পূর্বের মাস</td> ' +
                                '<td class="centertext" style="width: 5%">বর্তমান মাস</td> ' +
                                '<td class="centertext" style="width: 5%">পূর্বের মাস</td> ' +
                                '<td class="centertext" style="width: 5%">বর্তমান মাস</td> ' +
                                '<td class="centertext" style="width: 5%">পূর্বের মাস</td> ' +
                                '</tr>');
            }
           //           alert(JSON.stringify(element));
            if (divname == element['divname']) {

                if (rowcount == noofRow) {
                    totaltext = 'সর্বমোট';
                }
                if (zillaname == element['zillaname']) {
                    $('#cmt_mobile_monthlyregister_table').append(
                            '<tr>' +
                                    '<td> ' + "" + '</td>' +
                                    '<td> ' + totaltext + '</td>' +
                                    '<td class="centertext"> ' + element['upozila'] + '</td>' +
                                    '<td class="centertext"> ' + element['promap'] + '</td>' +
                                    '<td class="centertext"> ' + element['court_total2'] + '</td>' +
                                    '<td class="centertext"> ' + element['court_total1'] + '</td>' +
                                    '<td class="centertext"> ' + element['case_total2'] + '</td>' +
                                    '<td class="centertext"> ' + element['case_total1'] + '</td>' +
                                    '<td class="centertext"> ' + element['fine_total2'] + '</td>' +
                                    '<td class="centertext"> ' + element['fine_total1'] + '</td>' +
                                    '<td class="centertext"> ' + element['criminal_total2'] + '</td>' +
                                    '<td class="centertext"> ' + element['criminal_total1'] + '</td>' +
                                    '<td class="centertext"> ' + element['lockup_criminal_total2'] + '</td>' +
                                    '<td class="centertext"> ' + element['lockup_criminal_total1'] + '</td>' +
                                    '<td class="centertext"> ' + "-" + '</td>' +
                                    '<td class="centertext"> ' +  "-" + '</td>' + str );


                } else {
                    slno++;
                    $('#cmt_mobile_monthlyregister_table').append(
                            '<tr>' +
                                    '<td class="centertext"> ' + slno + '</td>' +
                                    '<td> ' + element['zillaname'] + '</td>' +
                                    '<td class="centertext"> ' + element['upozila'] + '</td>' +
                                    '<td class="centertext"> ' + element['promap'] + '</td>' +
                                    '<td class="centertext"> ' + element['court_total2'] + '</td>' +
                                    '<td class="centertext"> ' + element['court_total1'] + '</td>' +
                                    '<td class="centertext"> ' + element['case_total2'] + '</td>' +
                                    '<td class="centertext"> ' + element['case_total1'] + '</td>' +
                                    '<td class="centertext"> ' + element['fine_total2'] + '</td>' +
                                    '<td class="centertext"> ' + element['fine_total1'] + '</td>' +
                                    '<td class="centertext"> ' + element['criminal_total2'] + '</td>' +
                                    '<td class="centertext"> ' + element['criminal_total1'] + '</td>' +
                                    '<td class="centertext"> ' + element['lockup_criminal_total2'] + '</td>' +
                                    '<td class="centertext"> ' + element['lockup_criminal_total1'] + '</td>' +
                                    '<td class="centertext"> ' + promapachive + '</td>' +
                                    '<td class="centertext"> ' +  element['comment2'] + '</td>' +
                                    str );


                    zillaname = element['zillaname'];
                }
            } else {
                slno++;
                grandtotal = 0;
                var str = "";

                $('#cmt_mobile_monthlyregister_table').append(
                        '<tr>' +
                                '<td class="centertext" colspan="15" > ' + element['divname'] + " বিভাগ" + '</td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td class="centertext"> ' + slno + '</td>' +
                                '<td> ' + element['zillaname'] + '</td>' +
                                '<td class="centertext"> ' + element['upozila'] + '</td>' +
                                '<td class="centertext"> ' + element['promap'] + '</td>' +
                                '<td class="centertext"> ' + element['court_total2'] + '</td>' +
                                '<td class="centertext"> ' + element['court_total1'] + '</td>' +
                                '<td class="centertext"> ' + element['case_total2'] + '</td>' +
                                '<td class="centertext"> ' + element['case_total1'] + '</td>' +
                                '<td class="centertext"> ' + element['fine_total2'] + '</td>' +
                                '<td class="centertext"> ' + element['fine_total1'] + '</td>' +
                                '<td class="centertext"> ' + element['criminal_total2'] + '</td>' +
                                '<td class="centertext"> ' + element['criminal_total1'] + '</td>' +
                                '<td class="centertext"> ' + element['lockup_criminal_total2'] + '</td>' +
                                '<td class="centertext"> ' + element['lockup_criminal_total1'] + '</td>' +
                                '<td class="centertext"> ' + promapachive + '</td>' +
                                '<td class="centertext"> ' +  element['comment2'] + '</td>' + str);

                divname = element['divname'];
                zillaname = element['zillaname'];
                if (noofRow == 3) {  // only zilla
                    return false;
                }
            }
        })
    }


</script>


