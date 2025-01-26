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
<div id="printdivapprovedreport" class="content_form_potrait">
    <div class="form_top_title">
        <table style="width: 100%">
            <tr>
                <td colspan="3" class="centertext"><span
                            id="divapprove_allmonthreg_name">allmonthreg_name</span></td>
            </tr>
            <tr>
               
                <td colspan="3" class="centertext"><span id="divapprove_month_year">month_year</span></td>
            </tr>
        </table>
    </div>


    <table id='divapprovedreport_table' border="1" style="border-collapse:collapse;" cellpadding="2px"
           cellspacing="2px" width="100%">
        <tr>
            <td class="centertext" style="width: 5%">জেলা</td>
            <td class="centertext" style="width: 5%" >মোবাইল কোর্টের মাসিক প্রতিবেদন</td>
            <td class="centertext" style="width: 5%" >মোবাইল কোর্টের আপিল মামলার তথ্য</td>
            <td class="centertext" style="width: 5%" >অতিরিক্ত জেলা ম্যাজিস্ট্রেট আদালতের  মামলার তথ্য  </td>
            <td class="centertext" style="width: 5%" >এক্সিকিউটিভ ম্যাজিস্ট্রেট আদালতের মামলার তথ্য</td>
            <td class="centertext" style="width: 5%" >এক্সিকিউটিভ ম্যাজিস্ট্রেটের আদালত পরিদর্শন</td>
            <td class="centertext" style="width: 5%" >মোবাইল কোর্ট কেস রেকর্ড পর্যালোচনা</td>
        </tr>

    </table>
</div>


<script>
    function p_divapprovedrep_setParams(data) {
      
  
        document.getElementById("divapprove_allmonthreg_name").innerHTML = data.name;
        document.getElementById("divapprove_month_year").innerHTML = data.month_year;


        var myTable = document.getElementById("divapprovedreport_table");
        var rowCount = myTable.rows.length;
        for (var x = rowCount - 1; x > 0; x--) {
            myTable.deleteRow(x);
        }
        var slno = 0;
        var rowcount = 0;
        var divname = "";
        var zillaname = "";
        var rep_no1 = "x";
        var rep_no2 = "x";
        var rep_no3 = "x";
        var rep_no4 = "x";
        var rep_no5 = "x";
        var rep_no6 = "x";

        var noofRow = data.result.length;
        $(data.result).each(function (index, element) {
            rowcount++;

        if(element['report_type_id'] == 1){
            rep_no1 = "v";
        }else if(element['report_type_id'] == 2){
            rep_no2 = "v";
        }else if(element['report_type_id'] == 3){
            rep_no3 = "v";
        } else if(element['report_type_id'] == 4){
            rep_no4 = "v";
        } else if(element['report_type_id'] == 5){
            rep_no5 = "v";
        }else if(element['report_type_id'] == 6){
            rep_no6 = "v";
        }
            zillaname = element['zillaname'];
            $('#divapprovedreport_table').append(
                    '<tr>' +
                            '<td class="centertext"> ' + zillaname + '</td>' +
                            '<td class="centertext"> ' + rep_no1 + '</td>' +
                            '<td class="centertext"> ' + rep_no2 + '</td>' +
                            '<td class="centertext"> ' + rep_no3 + '</td>' +
                            '<td class="centertext"> ' + rep_no4 + '</td>' +
                            '<td class="centertext"> ' + rep_no5 + '</td>' +
                            '<td class="centertext"> ' + rep_no6 + '</td>' +
                            '</tr>');
        });
    }
</script>


