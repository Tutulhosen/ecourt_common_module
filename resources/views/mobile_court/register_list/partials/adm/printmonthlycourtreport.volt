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
<div id="printmonthlycourtrerpot" class="content_form">
    <div class="form_top_title">
        {#<h3>    অপরাধের তথ্য ,  <?php echo date(" F , Y " ,time());?> </h3>#}
        <h3>   অপরাধের তথ্য , <?php echo $this->bangladate->get_bangla_month()?> </h3>
        <h3 class="top_title_2nd"></h3>
    </div>
    <table id='monthlycourtrerpot_info_adm'  border="1" style="border-collapse:collapse;" cellpadding="2px" cellspacing="2px" width="100%">
        <thead>
        <tr>
        <th style="width: 2%">ক্র.নম্বর</th>
        <th style="width: 120px">মাসের নাম</th>
        <th style="width: 100px">মামলার সংখ্যা</th>
        <th style="width: 100px">মোট  দণ্ডপ্রাপ্ত আসামির সংখ্যা</th>
        <th colspan="2" style="width: 100px">দন্ডের প্রকার</th>
        <th style="width: 100px"> মন্তব্য</th>
        </tr>
        <tr>
            <th style="width: 20px"></th>
            <th style="width: 20px"></th>
            <th style="width: 20px"></th>
            <th style="width: 20px"></th>
            <th style="width: 20px">আসামি্র সংখ্যা</th>
            <th style="width: 20px">জরিমানার পরিমাণ</th>
            <th style="width: 20px"></th>
        </tr>
        </thead>

    </table>
</div>
<script>
    function pmcr_setParams(data){
       // $('#complain_info_adm').html("");
        var myTable = document.getElementById("monthlycourtrerpot_info_adm");
        var rowCount = myTable.rows.length;
        for (var x=rowCount-1; x>0; x--) {
            myTable.deleteRow(x);
        }
        var i = 0;
        $(data.result).each(function(index, element){
//           alert(JSON.stringify(element));
            i++;
            var estimated_date = element['estimated_date'] ? element['estimated_date'] : "" ;
            $('#monthlycourtrerpot_info_adm').append(
                    '<tr>' +
                            '<td > ' + i + '</td>' +
                            '<td> '+element['user_idno']+ ','  +element['cdate']+'</td>'  +
                            '<td> '+element['name_bng']+ '</td>' +
                            '<td> '+element['idate']+',' +element['location']+'</td>'  +
                            '<td> '+element['complain_details'] + '</td>'  +
                            '<td> '+element['complain_status'] + '</td>'  +
                            '<td> '+ estimated_date + '</td>'  +
                            '<td> '+element['mag_name'] + '</td>'  +
                            '</tr>');
        })

    }
</script>
