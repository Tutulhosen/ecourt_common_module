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
                <td colspan="4"><h3 class="form_top_title">  <span id="plbreg_name">ppreg_name</span></h3></td>
            </tr>
            <tr style="width: 50%;text-align: center">
                <td style="width: 10px " align="left">অফিসঃ জেলা প্রশাসকের কার্যালয়,<span id="plbreg_officename"
                                                                                          align="left">ppreg_officename</span>&nbsp;
                    । &nbsp;</td>
            </tr>
            <tr style="width: 50%;text-align: center">
                <td style="width: 10px " align="left">মামলার তারিখঃ <span id="adm_startdate" align="left">startdate</span> <span id="adm_enddate" align="left">enddate</span></td>
            </tr>
        </table>
    </div>
    <table id='lawbasedregister_info_mag' border="1" style="border-collapse:collapse;" cellpadding="2px"
           cellspacing="2px" width="100%">
    <th style="width: 2%">ক্র.নম্বর</th>
        <th style="width: 5%">মামলার তারিখ</th>
        <th style="width: 7%">মামলার নম্বর </th>
        <th style="width: 5%">আদালতের নাম </th>
        <th style="width: 20%">ধারার নম্বর</th>
        <th style="width: 20%">অপরাধের বর্ণনা</th>
        <th style="width: 20%">আদেশ </th>
    </table>
</div>
<script>
    function mag_plbreg_setParams(data) {
        document.getElementById("plbreg_name").innerHTML= data.name;
        document.getElementById("plbreg_officename").innerHTML=   data.zilla_name;



        var start_date = $('#start_date').val().split("/");
        document.getElementById("adm_startdate").innerHTML= start_date[2] + "-" + start_date[0] + "-" + start_date[1];

        var end_date = $('#end_date').val();



        if(end_date !=''){
            end_date = $('#end_date').val().split("/");
            document.getElementById("adm_enddate").innerHTML= "&nbsp; হতে &nbsp; " +  end_date[2] + "-" + end_date[1] + "-" + end_date[0];
        }else{
            end_date = gettodaydate().split("/");
            document.getElementById("adm_enddate").innerHTML= "&nbsp; হতে &nbsp; " + end_date[2] + "-" + end_date[1] + "-" + end_date[0];
        }


        var myTable = document.getElementById("lawbasedregister_info_mag");
        var rowCount = myTable.rows.length;
        for (var x=rowCount-1; x>0; x--) {
            myTable.deleteRow(x);
        }

        var slno = 0;
        var law_id = "";
        var lawid1 = "";
        var zillaname = "";
        var noofRow = data.result.length;

        $(data.result).each(function(index, element){
//          alert(JSON.stringify(element));
            slno++;
            var str_array = element['law_id'].split(',');
            if(str_array.length > 1 )
            {
                lawid1 = str_array[0];
            }else{
                lawid1 = element['law_id'];
            }

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

            if(law_id == lawid1){
                $('#lawbasedregister_info_mag').append(
                        '<tr>' +
                                '<td style="width: 2%">' + slno + '</td>' +
                                '<td style="width: 5%">' + element['pdate'] + '</td>' +
                                '<td style="width: 7%"> ' + element['case_no']+'</td>'  +
                                '<td style="width: 5%"> ' + element['name_eng']+'</td>'  +
                                '<td style="width: 20%"> ' + element['sec_number'] + '</td>' +
                                '<td style="width: 11%"> ' + description+ '</td>' +
                                '<td style="width: 20%"> ' + element['order_detail']  + '</td>'  +
                        '</tr>');
            }else{
                $('#lawbasedregister_info_mag').append(
                        '<tr>' +
                                '<td colspan="13" style="text-align: left"> ' + "আইনঃ &nbsp;"+element['title']  + '</td>'  +
                        '</tr>' +
                        '<tr>' +
                                '<td style="width: 2%">' + slno + '</td>' +
                                '<td style="width: 5%">' + element['pdate'] + '</td>' +
                                '<td style="width: 7%"> ' + element['case_no']+'</td>'  +
                                '<td style="width: 5%"> ' + element['name_eng']+'</td>'  +
                                '<td style="width: 20%"> ' + element['sec_number'] + '</td>' +
                                '<td style="width: 11%"> ' + description + '</td>' +
                                '<td style="width: 20%"> ' + element['order_detail']  + '</td>'  +
                        '</tr>');
                law_id = lawid1;
            }
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

