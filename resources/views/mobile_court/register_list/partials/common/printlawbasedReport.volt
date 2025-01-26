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

<meta charset="utf-8">
<div id="printlawbasedReport" class="content_form">
    <div class="form_top_title" style="margin-left: 5px">
        <table style="width: 100%;text-align: center">
            <tr>
                <td colspan="4"><h3 class="form_top_title">  <span id="ppreg_name">ppreg_name</span></h3></td>
            </tr>
            <tr style="width: 50%;text-align: center">
                <td style="width: 10px " align="left">জেলার নামঃ   <span id="ppreg_officename" align="left">ppreg_officename</span></td>
            </tr>
            <tr style="width: 50%;text-align: center">
                <td style="width: 10px " align="left">মাসঃ <?php echo $this->bangladate->get_bangla_month()?></td>
            </tr>
        </table>
    </div>
    <table id='punishmemt_info_adm'  border="1" style="border-collapse:collapse;" cellpadding="2px" cellspacing="2px" width="100%">
        <th style="width: 2%">ক্র.নম্বর</th>
        <th style="width: 5%">মামলার তারিখ</th>
        <th style="width: 7%">মামলার নম্বর </th>
        <th style="width: 5%">আদালতের নাম </th>
        <th style="width: 11%">আসামির নাম ও ঠিকানা</th>
        <th style="width: 20%">আইনের শিরোনাম</th>
        <th style="width: 25%">অপরাধের বিবরণ</th>
        <th style="width: 20%">দণ্ড</th>
        <th style="width: 20%">জরিমানা আদায়ের রশিদ নম্বর</th>
        <th style="width: 20%">পরবর্তী আদেশ </th>
        <th style="width: 5%">মন্তব্য</th>
        {#<th style="width: 100px">দণ্ডের বিবরণ</th>#}

    </table>
</div>
<script>
    function ppreg_setParams(data){


        document.getElementById("ppreg_name").innerHTML= data.name;
        document.getElementById("ppreg_officename").innerHTML=   data.zilla_name;



        var myTable = document.getElementById("punishmemt_info_adm");
        var rowCount = myTable.rows.length;
        for (var x=rowCount-1; x>0; x--) {
            myTable.deleteRow(x);
        }



        var i = 0;
        $(data.result).each(function(index, element){

            var json;
            var description ="";


            try {
                json = eval(element['crime_description']);
            } catch (exception) {
                //It's advisable to always catch an exception since eval() is a javascript executor...
                json = null;
            }

            if (json) {
                //this is json
                description = jQuery.parseJSON( element['crime_description'] );
            }else{
                description = element['crime_description'];
            }

//           alert(JSON.stringify(element));
            i++;
//            var estimated_date = element['estimated_date'] ? element['estimated_date'] : "" ;
            var receipt_no =  element['receipt_no']? 'রশিদ নম্বর-' + element['receipt_no'] : "" ;
            $('#punishmemt_info_adm').append(
                    '<tr>' +
                            '<td style="width: 2%">' + i + '</td>' +
                            '<td style="width: 5%">' + element['pdate'] + '</td>' +
                            '<td style="width: 7%"> ' + element['case_no']+'</td>'  +
                            '<td style="width: 5%"> ' + element['name_eng']+'</td>'  +
                            '<td style="width: 11%"> ' + element['criminal_details']+ '</td>' +
                            '<td style="width: 20%"> ' + element['law_section_description'] + '</td>' +
                            '<td style="width: 25%"> ' + description +'</td>'  +
                            '<td style="width: 20%"> ' + element['order_detail']  + '</td>'  +
                            '<td style="width: 20%"> ' + receipt_no +'</td>'  +
                            '<td style="width: 20%"> ' + "" +  '</td>'  +
                            '<td style="width: 5%"> ' + "-----" + '</td>'  +
//                          '<td> ' + element['fine'] + element['warrent_detail'] + element['rep_warrent_detail'] +'</td>'  +
                            '</tr>');
        })
    }
</script>
