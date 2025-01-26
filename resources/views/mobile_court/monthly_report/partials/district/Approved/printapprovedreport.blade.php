<div id="printapprovedreport" class="content_form_potrait">
    {{-- stylesheet_link('css/protibedon.css') --}}
    <div class="form_top_title">
        <table style="width: 100%">
            <tr>
                <td colspan="3" class="centertext"><span
                            id="approve_allmonthreg_name">allmonthreg_name</span></td>
            </tr>
            <tr>
            
                <td colspan="3" class="centertext"><span id="approve_month_year">month_year</span></td>
            </tr>
        </table>
    </div>


    <table id='approvedreport_table' border="1" style="border-collapse:collapse;" cellpadding="2px"
           cellspacing="2px" width="100%">
        <tr>
            <td class="centertext" style="width: 5%">জেলা</td>
            <td class="centertext" style="width: 5%" >মোবাইল কোর্টের মাসিক প্রতিবেদন</td>
            <td class="centertext" style="width: 5%" >মোবাইল কোর্টের আপিল মামলার তথ্য</td>
            <td class="centertext" style="width: 5%" >অতিরিক্ত জেলা ম্যাজিস্ট্রেট আদালতের  মামলার তথ্য  </td>
            <td class="centertext" style="width: 5%" >এক্সিকিউটিভ ম্যাজিস্ট্রেট আদালতের মামলার তথ্য</td>
            <td class="centertext" style="width: 5%" >এক্সিকিউটিভ ম্যাজিস্ট্রেটের আদালত পরিদর্শন</td>
            <td class="centertext" style="width: 5%" >মোবাইল কোর্ট কেস রেকর্ড পর্যালোচনা</td>
        </tr>

    </table>
</div>


<script>
    function p_approvedrep_setParams(data) {

        document.getElementById("approve_allmonthreg_name").innerHTML = data.name;
        document.getElementById("approve_month_year").innerHTML = data.month_year;


        var myTable = document.getElementById("approvedreport_table");
        var rowCount = myTable.rows.length;
        for (var x = rowCount - 1; x > 2; x--) {
            myTable.deleteRow(x);
        }
        var slno = 0;
        var rowcount = 0;
        var divname = "";
        var zillaname = "";
        var rep_no1 = "x";
        var rep_no2 = "x";
        var rep_no3 = "x";
        var rep_no4 = "x";
        var rep_no5 = "x";
        var rep_no6 = "x";

        var noofRow = data.result.length;
        $(data.result).each(function (index, element) {
            rowcount++;
        rep_no1 = "x";
        rep_no2 = "x";
        rep_no3 = "x";
        rep_no4 = "x";
        rep_no5 = "x";
        rep_no6 = "x";
        if(element['re1'] == 1){
                rep_no1 = "v";
        } if(element['re2'] == 1){
                rep_no2 = "v";
        }if(element['re3'] == 1){
            rep_no3 = "v";
        } if(element['re4'] == 1){
            rep_no4 = "v";
        } if(element['re5'] == 1){
            rep_no5 = "v";
        }if(element['re6'] == 1){
            rep_no6 = "v";
        }
            $('#approvedreport_table').append(
                    '<tr>' +
                            '<td class="centertext"> ' + element['zillaname'] + '</td>' +
                            '<td class="centertext"> ' + rep_no1 + '</td>' +
                            '<td class="centertext"> ' + rep_no2 + '</td>' +
                            '<td class="centertext"> ' + rep_no3 + '</td>' +
                            '<td class="centertext"> ' + rep_no4 + '</td>' +
                            '<td class="centertext"> ' + rep_no5 + '</td>' +
                            '<td class="centertext"> ' + rep_no6 + '</td>' +
                            '</tr>');
        });




    }
</script>


