<meta charset="utf-8">
<style>

    table.fixed {
        table-layout: fixed;
    }

    table.fixed td {
        overflow: hidden;
        font-size: 18px !important;
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

    .content_form_height {
        /*min-height: 842px;  792px // 596 */
        min-height: 1654px;

    }

    .form_top_title {
        font-size: 24px;
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
    }

    h4 {
        text-align: center;
    }

    h5 {
        text-align: center;
    }

    h6 {
        text-align: center;
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
</style>
<div id="register_print_adm" class="content_form">
    <div class="form_top_title">
        <table style="width: 100%">
            <tr>
                <td colspan="3"><h3 class="form_top_title">  <span id="pcr_name">pcr_name</span></h3></td>
            </tr>
            <tr>
                <td>জেলার নামঃ </td>
                <td><h3 ><span id="pcr_officename">pcr_officename</span></h3></td>
                <td> <h3><?php //echo $this->bangladate->get_bangla_month()?> </h3></td>
            </tr>
            <tr>
                <td>প্রসিকিউটরের নাম ও ঠিকানাঃ</td>
                <td colspan="2"></td>
            </tr>
        </table>
    </div>

    <table id='scores_adm'  border="1" style="border-collapse:collapse;" cellpadding="2px" cellspacing="2px" width="100%">
        <th style="width: 20px">ক্র.নম্বর</th>
        <th style="width: 100px">আইনের শিরোনাম ও ধারা </th>
        <th style="width: 100px">অপরাধের বিবরণ</th>
        <th style="width: 100px">আসামির নাম ও ঠিকানা</th>
        <th style="width: 120px">মামলার তারিখ</th>
        <th style="width: 120px">মামলার নম্বর </th>
        <th style="width: 100px">দণ্ডের বিবরণ</th>
        <th style="width: 100px">আদালতের নাম </th>
        </table>

</div>
<script>
    function ppf_setParams(data){
        $(data.result).each(function(index, element){
           // alert(JSON.stringify(element));
         $('#scores_adm').append(
                '<tr><td> '+element['case_no']+ '</td>' +
                '<td> '+element['prosecutor_name']+',' +element['prosecutor_details']+'</td>'  +
                '<td> '+element['name_eng'] + '</td>'  +
                '<td> '+element['c_date']+ '</td>'  +
                '<td> '+element['crm_name'] + ','+element['permanent_address'] +'</td>'  +
                '<td> '+element['law_section_description'] +"ধারা"+'</td>'  +
                '<td> '+element['order_detail'] +'</td>'  +
                 '</tr>');
        })

    }


</script>
