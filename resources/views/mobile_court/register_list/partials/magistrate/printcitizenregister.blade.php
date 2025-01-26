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
<div id="citizenregister" class="content_form">
    <div class="form_top_title">
        <table style="width: 100%">
            <tr>
                <td colspan="3"><h3 class="form_top_title">  <span id="magpcr_name">magpcr_name</span></h3></td>
            </tr>
            <tr>
                <td>এক্সিকিউটিভ  ম্যজিস্ট্রেট    <span id="magpcr_mag_name">magpcr_mag_name</span>এর আদালত ,
                <span id="magpcr_officename">magpcr_officename</span></td>
            </tr>
            <tr>
                <td align="left">অভিযোগের তারিখঃ <span id="mag_magpcr_startdate" align="left">startdate</span> <span
                            id="mag_magpcr_enddate" align="left">enddate</span></td>
            </tr>

        </table>
    </div>
    <table id='complain_info_mag'  border="1" style="border-collapse:collapse;" cellpadding="2px" cellspacing="2px" width="100%">
        <th style="width: 20px">ক্র.নম্বর</th>
        <th style="width: 120px">অভিযোগের তারিখ</th>
        <th style="width: 120px">অভিযোগ আইডি </th>
        <th style="width: 100px">অভিযোগকারী</th>
        <th style="width: 100px">ঘটনার তারিখ  </th>
        <th style="width: 100px">ঘটনাস্থল</th>
        <th style="width: 100px">অভিযোগের বিবরণ</th>
        <th style="width: 100px"> সর্বশেষ অবস্থা </th>
        <th style="width: 100px">কার্যক্রম গ্রহণের তারিখ</th>
    </table>

</div>
<script>
    function magpcr_setParams(data){


        document.getElementById("magpcr_name").innerHTML= data.name;
        document.getElementById("magpcr_officename").innerHTML= data.zilla_name;
        document.getElementById("magpcr_mag_name").innerHTML = data.mag_name? data.mag_name : "" ;

        var start_date = $('#start_date').val().split("/");
        document.getElementById("mag_magpcr_startdate").innerHTML = start_date[2] + "-" + start_date[0] + "-" + start_date[1];

        var end_date = $('#end_date').val();


        if (end_date != '') {
            end_date = $('#end_date').val().split("/");
            document.getElementById("mag_magpcr_enddate").innerHTML = "&nbsp; হতে &nbsp; " + end_date[2] + "-" + end_date[1] + "-" + end_date[0];
        } else {
            end_date = gettodaydate().split("/");
            document.getElementById("mag_magpcr_enddate").innerHTML = "&nbsp; হতে &nbsp; " + end_date[2] + "-" + end_date[1] + "-" + end_date[0];
        }




        var myTable = document.getElementById("complain_info_mag");
        var rowCount = myTable.rows.length;
        for (var x=rowCount-1; x>0; x--) {
            myTable.deleteRow(x);
        }
        var i = 0;
        $(data.result).each(function(index, element){
//           alert(JSON.stringify(element));
            i++;
            var estimated_date = element['estimated_date'] ? element['estimated_date'] : "" ;
            $('#complain_info_mag').append(
                    '<tr>' +
                            '<td > ' + i + '</td>' +
                            '<td > ' + element['cdate'] + '</td>' +
                            '<td> '+element['user_idno']+'</td>'  +
                            '<td> '+element['name_bng']+ '</td>' +
                            '<td> '+element['idate'] +'</td>'  +
                            '<td > ' + element['location'] + '</td>' +
                            '<td> '+element['complain_details'] + '</td>'  +
                            '<td> '+element['complain_status'] + '</td>'  +
                            '<td> '+ estimated_date + '</td>'  +
                            '</tr>');
        })
    }

    function gettodaydate() {
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0!

        var yyyy = today.getFullYear();
        if (dd < 10) {
            dd = '0' + dd
        }
        if (mm < 10) {
            mm = '0' + mm
        }
        var today = dd + '/' + mm + '/' + yyyy;
        return  today;
    }

</script>
