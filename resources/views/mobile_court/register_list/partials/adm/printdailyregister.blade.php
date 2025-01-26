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

    .content_form_potrait {
        /*min-height: 842px;  792px // 596 */
        /*width: 792px;*/
        /*margin-left: auto;*/
        /*margin-right: auto;*/
        /*border: 1px dotted gray;*/
        /*font-size: 18px!important;*/
        /*font-family: nikoshBan!important;*/
        width: 595px;
        margin-left: auto;
        margin-right: auto;
        border: 1px dotted gray;
        font-family: nikoshBan;
        text-align: justify;
        text-justify: inter-word;
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
<meta charset="utf-8">
<div id="printdailyregister" class="content_form">
    <div class="form_top_title">
        {#<h3>  প্রাত্যহিক রেজিস্টার  , <?php //echo $this->bangladate->get_bangla_month()?> </h3>#}
        {#<h3 class="top_title_2nd"></h3>#}

        <table class="fixed" style="width:100% ;text-align: center">
            <tr>
                <td><h3 class="form_top_title">  <span id="ppr_name">ppr_name</span></h3></td>
            </tr>
            <tr>
                <td  style="width: 100% ;text-align: left">অফিসঃ জেলা প্রশাসকের কার্যালয়,<span id="ppr_officename">ppr_officename</span> &nbsp; । &nbsp;</td>
            </tr>
            <tr>
                <td style="width: 100% ;text-align: left">মামলার তারিখঃ  <span id="startdate">startdate &nbsp;।</span></td>
            </tr>
        </table>

    </div>

    <table id='dailyregister_adm'  border="1" style="border-collapse:collapse;" cellpadding="2px" cellspacing="2px" width="100%">
        <th style="width: 20px">ক্র.নম্বর</th>
        <th style="width: 100px">মামলার নম্বর</th>
        <th style="width: 100px">প্রসিকিউটরের নাম ও ঠিকানা </th>
        <th style="width: 100px">আদালতের নাম </th>
        <th style="width: 100px"> আসামির নাম ,ঠিকানা</th>
        <th style="width: 100px"> সংশ্লিষ্ট আইন </th>
        <th style="width: 100px">দণ্ডের  বিবরণ</th>
    </table>
</div>
<script>
    function pdr_setParams(data){

        document.getElementById("ppr_name").innerHTML= data.name;
        document.getElementById("ppr_officename").innerHTML=  data.zilla_name;


        var start_date = $('#start_date').val().split("/");
        document.getElementById("startdate").innerHTML= start_date[2] + "-" + start_date[0] + "-" + start_date[1];


        var myTable = document.getElementById("dailyregister_adm");
        var rowCount = myTable.rows.length;
        for (var x=rowCount-1; x>0; x--) {
            myTable.deleteRow(x);
        }
        var i = 0;

        $(data.result).each(function(index, element){
         i++;
//            alert(JSON.stringify(element));
            $('#dailyregister_adm').append(
                    '<tr>' +
                            '<td style="width: 2%"> ' + i + '</td>' +
                            '<td> ' + element['case_no'] + '</td>' +
                            '<td> '+element['prosecutor_name']+',' +element['prosecutor_details']+'</td>'  +
                            '<td> '+element['name_eng'] + '</td>'  +
//                            '<td> '+element['c_date']+ '</td>'  +
                            '<td> '+element['crm_name'] + ','+element['permanent_address'] +'</td>'  +
                            '<td> '+element['law_section_description'] +"ধারা"+'</td>'  +
                            '<td> '+element['order_detail'] +'</td>'  +
                            '</tr>');
        })

    }


</script>

<style>

    table.fixed { table-layout:fixed; }
    table.fixed td { overflow: hidden;
        font-size: 18px!important;}


    div.smallhightspace{
        height : 15px;
    }

    .underline {
        text-decoration: underline;
    }

    div.bighightspace{
        height : 40px;
    }

    .content_form
    {
        /*min-height: 842px;  792px // 596 */
        width: 1200px;
        margin-left: auto;
        margin-right: auto;
        border: 1px dotted gray;
        font-family: nikoshBan;
    }

    .content_form_potrait
    {
        /*min-height: 842px;  792px // 596 */
        width: 792px;
        margin-left: auto;
        margin-right: auto;
        border: 1px dotted gray;
        font-size: 24px!important;
        font-family: nikoshBan!important;
    }

    .content_form_height
    {
        /*min-height: 842px;  792px // 596 */
        min-height: 1654px;

    }

    .form_top_title
    {
        font-size: 24px;
    }
    {
        margin-top: -18px;
    }

    @media print {
        .content_form {
            border: 0px dotted;
        }

        .content_form_potrait {
            border: 0px dotted;
        }
    }

    p
    {
        text-align: justify!important;
    }

    p.p_indent
    {
        text-indent: 10px;
    }

    h3
    {
        text-align: center;
    }

    h3.top_title_2nd
    {
        margin-top: -18px;
    }

    h4.bottom_margin
    {
        margin-bottom: -18px;
    }

    .clear_div
    {
        clear: both;
        width: 100%;
        height: 20px;
    }
    br
    {
        line-height:5px;
    }
</style>
