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

<div id="printcountrymblreport" class="content_form_potrait">
    
    <div class="form_top_title">
        <table style="width: 100%">
            <tr>
                <td colspan="3" class="centertext"><span id="report_name_mbl">allmonthreg_name</span></td>
            </tr>

        </table>
    </div>


    <table id='countryMblReportTable' border="1" style="border-collapse:collapse;" cellpadding="2px"
           cellspacing="2px" width="100%">
        <tr>
            <td class="centertext" style="width: 9%">মাসের নাম</td>
            <td class="centertext" style="width: 9%">মোবাইল কোর্ট পরিচালনার লক্ষ্যমাত্রা</td>
            <td class="centertext" style="width: 9%">মোবাইল কোর্ট পরিচালনার সংখ্যা</td>
            <td class="centertext" style="width: 9%">দায়েরকৃত মামলার সংখ্যা</td>
            <td class="centertext" style="width: 9%">আদায়কৃত জরিমানা ( টাকা )</td>
            <td class="centertext" style="width: 9%">অর্জিত লক্ষ্যমাত্রা</td>
        </tr>
    </table>
</div>

