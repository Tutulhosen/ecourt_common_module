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
<div id="printprosecutionreport" class="content_form">
    <div class="form_top_title">
        <table style="width: 100%">
            <tr>
                <td colspan="3"><h3 class="form_top_title">  <span id="ppr_name">ppr_name</span></h3></td>
            </tr>
            <tr>
                <td>জেলার নামঃ </td>
                <td><span id="ppr_officename">ppr_officename</span></td>
                <td><?php //echo $this->bangladate->get_bangla_month()?></td>
            </tr>
            <tr>
                <td>প্রসিকিউটরের নাম ও ঠিকানাঃ</td>
                <td colspan="2"><span id="ppr_prosecutorinfo">ppr_prosecutorinfo</span></td>
            </tr>
        </table>
    </div>

    <table id='prosecutionreport'  border="1" style="border-collapse:collapse;" cellpadding="2px" cellspacing="2px" width="100%">
        <th style="width: 2%" >ক্র.নম্বর</th>
        <th style="width: 18%">আইনের শিরোনাম ও ধারা </th>
        <th style="width: 20%">অপরাধের বিবরণ</th>
        <th style="width: 15%">আসামির নাম ও ঠিকানা</th>
        <th style="width: 5%" >মামলার তারিখ</th>
        <th style="width: 13%">মামলার নম্বর </th>
        <th style="width: 10%">দণ্ডের বিবরণ</th>
        <th style="width: 12%">আদালতের নাম </th>
    </table>
</div>
<script>
    function ppr_setParams(data){
        document.getElementById("ppr_name").innerHTML= data.name;
        document.getElementById("ppr_officename").innerHTML= data.zilla_name;

        var myTable = document.getElementById("prosecutionreport");
        var rowCount = myTable.rows.length;
        for (var x=rowCount-1; x>0; x--) {
            myTable.deleteRow(x);
        }
        var i = 0;
        $(data.result).each(function(index, element){
//           alert(JSON.stringify(element));
            i++;
            if(i == 1){
                document.getElementById("ppr_prosecutorinfo").innerHTML= element['pro_name'];
            }



            var obj = JSON.parse(element['crime_description']);
            var string = "";
            var j = 0;
            $.each(obj, function (i, fb) {
                j = i +1 ;
                string +=  "(" + j +  ")" +  fb
            });



            $('#prosecutionreport').append(
                    '<tr>' +
                            '<td style="width: 2%" > ' + i + '</td>' +
                            '<td style="width: 18%">   '+  element['law_section_number']+'</td>'  +
                            '<td style="width: 20%">   '+  string + '</td>' +
                            '<td style="width: 15%">   '+  element['criminal_details'] +'</td>'  +
                            '<td style="width: 5%" >  '+  element['pdate'] + '</td>' +
                            '<td style="width: 13%">  '+  element['case_no'] + '</td>' +
                            '<td style="width: 10%">   '+  element['order_detail'] + '</td>'  +
                            '<td style="width: 12%">   '+  element['mag_name'] + '</td>'  +
                            '</tr>');
        })
    }


</script>
