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
<div id="printpunishmentregister" class="content_form">
    <div class="form_top_title" style="margin-left: 5px">
        <table style="width: 100%;text-align: center">
            <tr>
                <td colspan="4"><h3 class="form_top_title">  <span id="ppreg_name">ppreg_name</span></h3></td>
            </tr>
            <tr>
                <td  style="width: 100% ;text-align: left">অফিসঃ জেলা প্রশাসকের কার্যালয়,<span id="ppreg_officename">ppreg_officename </span> &nbsp; । &nbsp;</td>
            </tr>
            <tr style="width: 50%;text-align: center">
                <td style="width: 10px " align="left">মামলার তারিখঃ <span id="adm_pun_startdate" align="left">startdate</span> <span id="adm_pun_enddate" align="left">enddate</span></td>
            </tr>
        </table>
    </div>
    <table id='punishmemt_info_adm'  border="1" style="border-collapse:collapse;" cellpadding="2px" cellspacing="2px" width="100%">
        <th style="width: 2%">ক্র.নম্বর</th>
        <th style="width: 5%">মামলার তারিখ</th>
        <th style="width: 7%">মামলার নম্বর </th>
        <th style="width: 12%">আদালতের নাম </th>
        <th style="width: 11%">আসামির নাম ও ঠিকানা</th>
        <th style="width: 20%">আইনের শিরোনাম</th>
        <th style="width: 20%">অপরাধের বিবরণ</th>
        <th style="width: 18%">দণ্ড</th>
        <th style="width: 20%">জরিমানা আদায়ের রশিদ নম্বর</th>
        <th style="width: 20%">পরবর্তী আদেশ </th>
        <th style="width: 5%">মন্তব্য</th>

    </table>
</div>
<script>
    function ppreg_setParams(data){


        document.getElementById("ppreg_name").innerHTML= data.name;
        document.getElementById("ppreg_officename").innerHTML=   data.zilla_name;


        var start_date = $('#start_date').val().split("/");
        document.getElementById("adm_pun_startdate").innerHTML= start_date[2] + "-" + start_date[0] + "-" + start_date[1];

        var end_date = $('#end_date').val();



        if(end_date !=''){
            end_date = $('#end_date').val().split("/");
            document.getElementById("adm_pun_enddate").innerHTML= "&nbsp; হতে &nbsp; " +  end_date[2] + "-" + end_date[1] + "-" + end_date[0];
        }else{
            end_date = gettodaydate().split("/");
            document.getElementById("adm_pun_enddate").innerHTML= "&nbsp; হতে &nbsp; " + end_date[2] + "-" + end_date[1] + "-" + end_date[0];
        }


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

    function gettodaydate(){
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0!

        var yyyy = today.getFullYear();
        if(dd<10){
            dd='0'+dd
        }
        if(mm<10){
            mm='0'+mm
        }
        var today = dd+'/'+mm+'/'+yyyy;
        return  today;
    }
</script>
