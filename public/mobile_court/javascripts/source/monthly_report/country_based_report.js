var mis_report={
    init: function () {

    },
    set_data_mbl:function (data) {
        document.getElementById("report_name_mbl").innerHTML = data.reportName;
        var myTable = document.getElementById("countryMblReportTable");
        var rowCount = myTable.rows.length;
        for (var x = rowCount - 1; x > 0; x--) {
            myTable.deleteRow(x);
        }

        var rowcount = 0;
        var monthYr="";

        $(data.resultSet).each(function (index, element) {
            monthYr=element['cMonth']+"/"+toBangla(element['report_year']);


            rowcount++;
            $('#countryMblReportTable').append(
                '<tr>' +
                '<td class="centertext"> ' + monthYr + '</td>' +
                '<td class="centertext"> ' + toBangla(element['promapTotal']) + '</td>' +
                '<td class="centertext"> ' + toBangla(element['courtTotal']) + '</td>' +
                '<td class="centertext"> ' + toBangla(element['caseTotal']) + '</td>' +
                '<td class="centertext"> ' + toBangla(element['fineTotal']) + '</td>' +
                '<td class="centertext"> ' + toBangla(element['promapPercentage']) + '</td>' +
                '</tr>');

        })
        $(data.totResult).each(function (index, element) {


            $('#countryMblReportTable').append(
                '<tr>' +
                '<td class="centertext"> ' +"মোট"  + '</td>' +
                '<td class="centertext"> ' + toBangla(element['TOTALPROMAP']) + '</td>' +
                '<td class="centertext"> ' + toBangla(element['TOTALCOURT']) + '</td>' +
                '<td class="centertext"> ' + toBangla(element['TOTALCASE']) + '</td>' +
                '<td class="centertext"> ' + toBangla(element['TOTALFINE']) + '</td>' +
                '<td class="centertext"> ' + toBangla(element['avgPromapPercentage']) + '</td>' +
                '</tr>');
        })

    },
    set_data_others_report:function (data) {

        document.getElementById("report_name").innerHTML = data.reportName;

        var myTable = document.getElementById("countryOthersReportTable");
        var rowCount = myTable.rows.length;
        for (var x = rowCount - 1; x > 0; x--) {
            myTable.deleteRow(x);
        }

        var rowcount = 0;
        var monthYr="";

        $(data.resultSet).each(function (index, element) {
            monthYr=element['cMonth']+"/"+toBangla(element['report_year']);
            rowcount++;
            $('#countryOthersReportTable').append(
                '<tr>' +
                '<td class="centertext"> ' + monthYr + '</td>' +
                '<td class="centertext"> ' + toBangla(element['caseSubmitTotal']) + '</td>' +
                '<td class="centertext"> ' + toBangla(element['caseTotal']) + '</td>' +
                '<td class="centertext"> ' + toBangla(element['caseCompleteTotal']) + '</td>' +
                '<td class="centertext"> ' + toBangla(element['caseIncompleteTotal']) + '</td>' +
                '</tr>');

        })
        $(data.totResult).each(function (index, element) {
            $('#countryOthersReportTable').append(
                '<tr>' +
                '<td class="centertext"> ' +"মোট"  + '</td>' +
                '<td class="centertext"> ' + toBangla(element['totalCaseSubmit']) + '</td>' +
                '<td class="centertext"> ' + toBangla(element['totalCase']) + '</td>' +
                '<td class="centertext"> ' + toBangla(element['totalCaseComplete']) + '</td>' +
                '<td class="centertext"> ' + toBangla(element['totalCaseIncomplete']) + '</td>' +
                '</tr>');
        })

    },

};
$(document).ready(function () {
    mis_report.init();
});