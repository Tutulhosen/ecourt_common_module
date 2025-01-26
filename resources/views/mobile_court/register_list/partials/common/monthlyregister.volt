
<style>
    .content_form_potrait
    {
        /*min-height: 842px;  792px // 596 */
        width: 792px;
        margin-left: auto;
        margin-right: auto;
        border: 1px dotted gray;
        font-size: 18px!important;
        font-family: nikoshBan!important;
    }
</style>
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
<div id="monthlyregister" class="content_form_potrait">
    <div class="form_top_title">
        <table style="width: 100%">
            <tr>
                <td colspan="3"><h3 class="form_top_title">  <span id="allmonthreg_name">allmonthreg_name</span></h3></td>
            </tr>
            <tr>
                {#<td> <h3><?php echo $this->bangladate->get_bangla_monthbymumber(3)?> </h3></td>#}
                <td> <h3><span id="month_year">month_year</span> </h3></td>
            </tr>
        </table>
    </div>


    <table id='monthlyregister_table'  border="1" style="border-collapse:collapse;" cellpadding="2px" cellspacing="2px" width="100%">
        <th style="width: 10px">জেলা</th>
        <th style="width: 10px">উপজেলার সংখ্যা</th>
        <th style="width: 10px">প্রমাপ</th>
        <th colspan="2" style="width: 15px">মোবাইল  কোর্টের সংখ্যা </th>
        <th colspan="2" style="width: 15px">মামলার সংখ্যা</th>
        <th colspan="2" style="width: 15px">আদায়কৃত অর্থ (টাকায়)</th>
        <th colspan="2" style="width: 15px">আসামির সংখ্যা </th>
        <th style="width: 10px">মন্তব্য</th>

        <tr>
            <td style="width: 10px"></td>
            <td style="width: 10px"></td>
            <td style="width: 10px"></td>
            <td style="width: 7px">বর্তমান মাস</td>
            <td style="width: 8px">পূর্বের মাস</td>
            <td style="width: 7px">বর্তমান মাস</td>
            <td style="width: 8px">পূর্বের মাস</td>
            <td style="width: 7px">বর্তমান মাস</td>
            <td style="width: 8px">পূর্বের মাস</td>
            <td style="width: 7px">বর্তমান মাস</td>
            <td style="width: 8px">পূর্বের মাস</td>
            <td style="width: 10px"></td>
        </tr>
    </table>
</div>


<script>
    function allmonthreg_setParams(data){

//        alert("ddd");

        document.getElementById("allmonthreg_name").innerHTML= data.name;
        document.getElementById("month_year").innerHTML= data.month_year;

//        document.getElementById("allmonthreg_officename").innerHTML= data.zilla_name;
//        document.getElementById("allmonthreg_mag_name").innerHTML = data.mag_name? data.mag_name : "" ;

        var myTable = document.getElementById("monthlyregister_table");
        var rowCount = myTable.rows.length;
        for (var x=rowCount-1; x>1; x--) {
            myTable.deleteRow(x);
        }
        var i = 0;
        $(data.result).each(function(index, element){
//           alert(JSON.stringify(element));
            i++;
            $('#monthlyregister_table').append(
                    '<tr>' +
                            '<td> ' + element['zillaname'] + '</td>' +
                            '<td> ' + element['upozila']+'</td>'  +
                            '<td> ' + element['promap']+ '</td>' +
                            '<td> ' + element['court_total2'] + '</td>'  +
                            '<td> ' + element['court_total1'] + '</td>'  +
                            '<td> ' + element['case_total2']  + '</td>'  +
                            '<td> ' + element['case_total1'] + '</td>' +
                            '<td> ' + element['fine_total2'] + '</td>'  +
                            '<td> ' + element['fine_total1'] + '</td>'  +
                            '<td> ' + element['criminal_total2'] + '</td>'  +
                            '<td> ' + element['criminal_total1'] + '</td>'  +
                            '<td> ' + "-" + '</td>'  +
                            '</tr>');
        })
    }
</script>
