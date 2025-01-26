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
<div id="citizenregister" class="content_form">
    <div class="form_top_title">
        <table style="width: 100% ">
            <tr >
                <td style="width: 100%"><h3 class="form_top_title">  <span id="magpmr_name">magpmr_name</span></h3></td>
            </tr>
           
            <tr>
                <td>এক্সিকিউটিভ  ম্যজিস্ট্রেট    <span id="magpmr_mag_name">magpmr_mag_name</span>&nbsp;এর আদালত ,
                    <span id="magpmr_officename">magpmr_officename</span> &nbsp; । &nbsp;</td>
            </tr>
            <tr style="width: 50%;text-align: center">
                <td style="width: 10px " align="left">মামলার তারিখঃ <span id="mag_magpmr_startdate" align="left">startdate</span> <span id="mag_magpmr_enddate" align="left">enddate</span></td>
            </tr>
        </table>
    </div>
    <table id='monthlyReg_info_mag'  border="1" style="border-collapse:collapse;" cellpadding="2px" cellspacing="2px" width="100%">
        <th style="width: 2%" >ক্র.নম্বর</th>
        <th style="width: 5%" >মামলার তারিখ</th>
        <th style="width: 12%">মামলার নম্বর </th>
        <th style="width: 12%">প্রসিকিউটরের নাম ও ঠিকানা</th>
        <th style="width: 19%">আইনের শিরোনাম ও ধারার নম্বর</th>
        <th style="width: 12%">আসামির নাম ও ঠিকানা</th>
        <th style="width: 24%">দণ্ডের বিবরণ</th>
        <th style="width: 14%">জরিমানা আদায়ের রশিদ নম্বর</th>
    </table>


</div>
<script>
    function magpmcr_setParams(data){


        document.getElementById("magpmr_name").innerHTML= data.name;
        document.getElementById("magpmr_officename").innerHTML= data.zilla_name;
        document.getElementById("magpmr_mag_name").innerHTML = data.mag_name? data.mag_name : "" ;

        var myTable = document.getElementById("monthlyReg_info_mag");
        var rowCount = myTable.rows.length;
        for (var x=rowCount-1; x>0; x--) {
            myTable.deleteRow(x);
        }
        var i = 0;
        $(data.result).each(function(index, element){
//           alert(JSON.stringify(element));
            i++;

           var pro_name = element['is_suomotu']== 0 ? element['pro_name'] : "" ;
           var receipt_no =  element['receipt_no']? 'রশিদ নম্বর-' + element['receipt_no'] : "" ;



            var start_date = $('#start_date').val().split("/");
            document.getElementById("mag_magpmr_startdate").innerHTML = start_date[2] + "-" + start_date[0] + "-" + start_date[1];

            var end_date = $('#end_date').val();


            if (end_date != '') {
                end_date = $('#end_date').val().split("/");
                document.getElementById("mag_magpmr_enddate").innerHTML = "&nbsp; হতে &nbsp; " + end_date[2] + "-" + end_date[1] + "-" + end_date[0];
            } else {
                end_date = gettodaydate().split("/");
                document.getElementById("mag_magpmr_enddate").innerHTML = "&nbsp; হতে &nbsp; " + end_date[2] + "-" + end_date[1] + "-" + end_date[0];
            }


            $('#monthlyReg_info_mag').append(
                    '<tr>' +
                            '<td style="width: 2%" >' + i + '</td>' +
                            '<td style="width: 5%" >' + element['pdate'] + '</td>' +
                            '<td style="width: 12%"> ' + element['case_no']+'</td>'  +
                            '<td style="width: 12%"> '+ pro_name + '</td>'  +
                            '<td style="width: 19%"> ' + element['law_punishment_sec_number'] + '</td>' +
                            '<td style="width: 12%"> ' + element['criminal_details']+ '</td>' +
                            '<td style="width: 24%"> ' + element['order_detail'] + '</td>'  +
                            '<td style="width: 14%"> ' + receipt_no +'</td>'  +
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
