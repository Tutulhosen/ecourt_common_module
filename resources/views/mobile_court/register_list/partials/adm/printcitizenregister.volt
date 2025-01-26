{#{{ stylesheet_link('css/report.css') }}#}

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
<div id="printcitizenregister" class="content_form">
    <div class="form_top_title" style="margin-left: 2px">
        <table class="fixed" style="width:100% ;text-align: center">
            <tr>
                <td><h3 class="form_top_title">  <span id="pcr_name">pcr_name</span></h3></td>
            </tr>
            <tr >
                <td align="left">অফিসঃ জেলা প্রশাসকের কার্যালয়,<span id="pcr_officename" align="left">pcr_officename </span> &nbsp; । &nbsp;</td>
            </tr>
            <tr >
                <td  align="left">অভিযোগের তারিখঃ <span id="adm_pcr_startdate" align="left">startdate</span> <span id="adm_pcr_enddate" align="left">enddate</span></td>
            </tr>
        </table>
    </div>
    <table id='complain_info_adm' class="fixed" border="1" style="border-collapse:collapse;" cellpadding="2px" cellspacing="2px" width="100%">
        <th style="width: 3%">ক্র.নম্বর</th>
        <th style="width: 8%">অভিযোগের তারিখ</th>
        <th style="width: 12%">অভিযোগ আইডি </th>
        <th style="width: 7%">অভিযোগকারী</th>
        <th style=" width: 8%">ঘটনার তারিখ  </th>
        <th style="width: 12%">ঘটনাস্থল</th>
        <th style="width: 30%">অভিযোগের বিবরণ</th>
        <th style="width: 5%">সর্বশেষ অবস্থা </th>
        <th style="width: 8%">কার্যক্রম গ্রহণের তারিখ</th>
        <th style="width: 8%">আদালতের নাম </th>
    </table>
</div>
<script>
    function pcr_setParams(data){


        document.getElementById("pcr_name").innerHTML= data.name;
        document.getElementById("pcr_officename").innerHTML=  data.zilla_name;




        var start_date = $('#start_date').val().split("/");
        document.getElementById("adm_pcr_startdate").innerHTML= start_date[2] + "-" + start_date[0] + "-" + start_date[1];

        var end_date = $('#end_date').val();



        if(end_date !=''){
            end_date = $('#end_date').val().split("/");
            document.getElementById("adm_pcr_enddate").innerHTML= "&nbsp; হতে &nbsp; " +  end_date[2] + "-" + end_date[1] + "-" + end_date[0];
        }else{
            end_date = gettodaydate().split("/");
            document.getElementById("adm_pcr_enddate").innerHTML= "&nbsp; হতে &nbsp; " + end_date[2] + "-" + end_date[1] + "-" + end_date[0];
        }


        var myTable = document.getElementById("complain_info_adm");
        var rowCount = myTable.rows.length;
        for (var x=rowCount-1; x>0; x--) {
            myTable.deleteRow(x);
        }
        var i = 0;
        $(data.result).each(function(index, element){
//           alert(JSON.stringify(element));
            i++;
            var estimated_date = element['estimated_date'] ? element['estimated_date'] : "" ;
            $('#complain_info_adm').append(
                    '<tr>' +
                            '<td style="width: 2%"> ' + i + '</td>' +
                            '<td style="width: 5%"> ' + element['cdate'] + '</td>' +
                            '<td style="width: 5%"> '+element['user_idno']+'</td>'  +
                            '<td style="width: 3%"> '+element['name_bng']+ '</td>' +
                            '<td style="width: 5%"> '+element['idate'] +'</td>'  +
                            '<td style="width: 11%"> ' + element['location'] + '</td>' +
                            '<td style="width: 30%"> '+element['complain_details'] + '</td>'  +
                            '<td style="width: 5%"> '+element['complain_status'] + '</td>'  +
                            '<td style="width: 5%"> '+ estimated_date + '</td>'  +
                            '<td style="width: 5%"> '+element['mag_name'] + '</td>'  +
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
