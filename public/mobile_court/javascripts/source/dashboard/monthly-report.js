/**
 * Created by sarker.pranab on 5/18/2017.
 */

var mr = {

    init: function() {
        var d = new Date();
        mr.fetchMonthlyReport(d.getFullYear(), (d.getMonth()+1), d.getMonth());
    },
    toBangla: function (str) {
        //check if the `str` is not string
        if (!isNaN(str)) {
            //if not string make it string forcefully
            str = String(str);
        }

        //start try catch block
        try {
            //keep the bangla numbers to an array
            var convert = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
            //now split the provided string into array by each character
            var splitArray = str.split("");
            //declare a empty string
            var newString = "";
            //run a loop upto the length of the string array
            for (i = 0; i < splitArray.length; i++) {

                //check if current array element if not number
                if (isNaN(splitArray [i])) {
                    //if not number then place it as it is
                    newString += splitArray [i];
                } else {
                    //if number then get same numbered element from the bangla array
                    newString += convert[splitArray [i]];
                }
            }
            //return the newly converted number
            return newString;
        }
        catch (err) {
            //if any error occured while convertion return the original string
            return str;
        }
        //by default return original number/string
        return str;
    },

    fetchMonthlyReport: function (year, currentMonth, previousMonth) {

        var requestURL = "../monthly_report/dashboard/report?year=" + year + "&currentMonth=" + currentMonth + "&previousMonth="+ previousMonth;
        // var requestURL = "/dashboard/monthlyReport?year=" + year + "&currentMonth=" + currentMonth + "&previousMonth=" + previousMonth;
       
        $.ajax({
            method: "GET",
            url: requestURL,
            contentType: "text/html,application/xhtml+xml,application/xml",
            dataType: 'json',
        success:function (data, textStatus, jqXHR) {
            if(data && data.length > 0) {
                
                var reportData = mr.prepareReportData(data);
                console.log('sdsd',reportData);
                mr.renderReportTable(reportData);
            }
        }
        });
    },

    prepareZillaList: function (locationList) {

        var zillas = {};

        $.each(locationList, function(i, x) {

            if(!zillas[x.ZillaName]) {
                zillas[x.ZillaName] = {};
                zillas[x.ZillaName].id = "zilla-" + x.ZillaID;
                zillas[x.ZillaName].parentid = "div-" + x.DivisionID;
                zillas[x.ZillaName].parentname = x.DivisionName;
                zillas[x.ZillaName].areaname = x.ZillaName;
                zillas[x.ZillaName].Locations = [];
            }

            if(!zillas[x.ZillaName].PCourtCount) {
                zillas[x.ZillaName].PCourtCount = 0;
            }
            zillas[x.ZillaName].PCourtCount = parseInt(zillas[x.ZillaName].PCourtCount ) + parseInt(x.PCourtCount ? x.PCourtCount : 0);

            if(!zillas[x.ZillaName].CCourtCount) {
                zillas[x.ZillaName].CCourtCount = 0;
            }
            zillas[x.ZillaName].CCourtCount = parseInt(zillas[x.ZillaName].CCourtCount ) + parseInt(x.CCourtCount ? x.CCourtCount : 0);

            if(!zillas[x.ZillaName].PCaseCount) {
                zillas[x.ZillaName].PCaseCount = 0;
            }
            zillas[x.ZillaName].PCaseCount = parseInt(zillas[x.ZillaName].PCaseCount ) + parseInt(x.PCaseCount ? x.PCaseCount : 0);

            if(!zillas[x.ZillaName].CCaseCount) {
                zillas[x.ZillaName].CCaseCount = 0;
            }
            zillas[x.ZillaName].CCaseCount = parseInt(zillas[x.ZillaName].CCaseCount ) + parseInt(x.CCaseCount ? x.CCaseCount : 0);


            if(!zillas[x.ZillaName].PFineCount) {
                zillas[x.ZillaName].PFineCount = 0;
            }
            zillas[x.ZillaName].PFineCount = parseInt(zillas[x.ZillaName].PFineCount ) + parseInt(x.PFineCount ? x.PFineCount : 0);

            if(!zillas[x.ZillaName].CFineCount) {
                zillas[x.ZillaName].CFineCount = 0;
            }
            zillas[x.ZillaName].CFineCount = parseInt(zillas[x.ZillaName].CFineCount ) + parseInt(x.CFineCount ? x.CFineCount : 0);

            if(!zillas[x.ZillaName].PCriminalCount) {
                zillas[x.ZillaName].PCriminalCount = 0;
            }
            zillas[x.ZillaName].PCriminalCount = parseInt(zillas[x.ZillaName].PCriminalCount ) + parseInt(x.PCriminalCount ? x.PCriminalCount : 0);

            if(!zillas[x.ZillaName].CCriminalCount) {
                zillas[x.ZillaName].CCriminalCount = 0;
            }
            zillas[x.ZillaName].CCriminalCount = parseInt(zillas[x.ZillaName].CCriminalCount ) + parseInt(x.CCriminalCount ? x.CCriminalCount : 0);

            if(!zillas[x.ZillaName].PJailCount) {
                zillas[x.ZillaName].PJailCount = 0;
            }
            zillas[x.ZillaName].PJailCount = parseInt(zillas[x.ZillaName].PJailCount ) + parseInt(x.PJailCount ? x.PJailCount : 0);

            if(!zillas[x.ZillaName].CJailCount) {
                zillas[x.ZillaName].CJailCount = 0;
            }
            zillas[x.ZillaName].CJailCount = parseInt(zillas[x.ZillaName].CJailCount ) + parseInt(x.CJailCount ? x.CJailCount : 0);


            x.id = "location-" + x.LocationID;
            x.parentid = "zilla-" + x.ZillaID;
            x.parentname = x.ZillaName;
            x.areaname = x.LocationName;
            zillas[x.ZillaName].Locations.push(x);

        });

        return zillas;

    },

    prepareDivisionList: function (zillaList) {

        var divisions = {};

        $.each(zillaList, function(i, x) {

            if(!divisions[x.parentname]) {
                divisions[x.parentname] = {};
                divisions[x.parentname].id = x.parentid;
                divisions[x.parentname].parentid = "";
                divisions[x.parentname].areaname = x.parentname;
                divisions[x.parentname].zillas = [];
            }

            if(!divisions[x.parentname].PCourtCount) {
                divisions[x.parentname].PCourtCount = 0;
            }
            divisions[x.parentname].PCourtCount = parseInt(divisions[x.parentname].PCourtCount ) + parseInt(x.PCourtCount ? x.PCourtCount : 0);

            if(!divisions[x.parentname].CCourtCount) {
                divisions[x.parentname].CCourtCount = 0;
            }
            divisions[x.parentname].CCourtCount = parseInt(divisions[x.parentname].CCourtCount ) + parseInt(x.CCourtCount ? x.CCourtCount : 0);

            if(!divisions[x.parentname].PCaseCount) {
                divisions[x.parentname].PCaseCount = 0;
            }
            divisions[x.parentname].PCaseCount = parseInt(divisions[x.parentname].PCaseCount ) + parseInt(x.PCaseCount ? x.PCaseCount : 0);

            if(!divisions[x.parentname].CCaseCount) {
                divisions[x.parentname].CCaseCount = 0;
            }
            divisions[x.parentname].CCaseCount = parseInt(divisions[x.parentname].CCaseCount ) + parseInt(x.CCaseCount ? x.CCaseCount : 0);

            if(!divisions[x.parentname].PFineCount) {
                divisions[x.parentname].PFineCount = 0;
            }
            divisions[x.parentname].PFineCount = parseInt(divisions[x.parentname].PFineCount ) + parseInt(x.PFineCount ? x.PFineCount : 0);

            if(!divisions[x.parentname].CFineCount) {
                divisions[x.parentname].CFineCount = 0;
            }
            divisions[x.parentname].CFineCount = parseInt(divisions[x.parentname].CFineCount ) + parseInt(x.CFineCount ? x.CFineCount : 0);

            if(!divisions[x.parentname].PCriminalCount) {
                divisions[x.parentname].PCriminalCount = 0;
            }
            divisions[x.parentname].PCriminalCount = parseInt(divisions[x.parentname].PCriminalCount ) + parseInt(x.PCriminalCount ? x.PCriminalCount : 0);

            if(!divisions[x.parentname].CCriminalCount) {
                divisions[x.parentname].CCriminalCount = 0;
            }
            divisions[x.parentname].CCriminalCount = parseInt(divisions[x.parentname].CCriminalCount ) + parseInt(x.CCriminalCount ? x.CCriminalCount : 0);

            if(!divisions[x.parentname].PJailCount) {
                divisions[x.parentname].PJailCount = 0;
            }
            divisions[x.parentname].PJailCount = parseInt(divisions[x.parentname].PJailCount ) + parseInt(x.PJailCount ? x.PJailCount : 0);

            if(!divisions[x.parentname].CJailCount) {
                divisions[x.parentname].CJailCount = 0;
            }
            divisions[x.parentname].CJailCount = parseInt(divisions[x.parentname].CJailCount ) + parseInt(x.CJailCount ? x.CJailCount : 0);

            divisions[x.parentname].zillas.push(x);

        });

        return divisions;

    },

    prepareReportData: function (rawData) {
        // var zillaList = mr.prepareZillaList(rawData);
        // var divisions = mr.prepareDivisionList(zillaList);
        // return reportData;
        return mr.prepareDivisionList(mr.prepareZillaList(rawData));
    },

    renderReportTable: function (reportData) {
        if (reportData) {
            $.each(reportData, function (i, dData) {
                mr.renderTableRow(dData);
                if (dData.zillas && dData.zillas.length > 0) {
                    $.each(dData.zillas, function (y, zillaData) {
                        mr.renderTableRow(zillaData);
                        if (zillaData.Locations && zillaData.Locations.length > 0) {
                            $.each(zillaData.Locations, function (z, upazillaData) {
                                if(upazillaData.LocationID !== "-1") {
                                    mr.renderTableRow(upazillaData);
                                }
                            });
                        }
                    });
                }

            });
        }

    dashboard.collupsableTable();
        var user_prfoile = $('#user_prfoile').val();
        if((user_prfoile == 'ADM')||(user_prfoile == 'DM' )){
           // $("#tab table tbody tr:nth-child(2) td a").click();
            $("tr.act-tr-collapsed td a").click();
            $("#tab table tbody tr:nth-child(2) td:nth-child(1) ").append(' জেলা (সর্বমোট)');
            var dataID = $("tr.act-tr-level-0").attr('data-id');
            var dataIdAry = dataID.split("-");
            if(dataIdAry[0]=='div'){
                $("tr.act-tr-level-0").css('display','none');
            }
        }else if(user_prfoile == 'Divisional Commissioner'){
            $("#tab table tbody tr:first-child td a").click();
            $("#tab table tbody tr:first-child td:first-child ").append(' বিভাগ (সর্বমোট)');
        }
        // $("#tab table tbody tr:first-child").removeClass("act-tr-collapsed");
        // $("#tab table tbody tr:first-child").addClass("act-tr-expanded");
    },

    renderTableRow: function (rowData) {
        var row = "<tr data-id='" + rowData.id + "' data-parent='" + rowData.parentid + "'>";
        row += "<td>" + rowData.areaname + "</td>";
        row += "<td>" + mr.toBangla(rowData.CCourtCount) + "</td>";
        row += "<td>" + mr.toBangla(rowData.PCourtCount) + "</td>";
        row += "<td>" + mr.toBangla(rowData.CCaseCount) + "</td>";
        row += "<td>" + mr.toBangla(rowData.PCaseCount) + "</td>";
        row += "<td>" + mr.toBangla(rowData.CFineCount) + "</td>";
        row += "<td>" + mr.toBangla(rowData.PFineCount) + "</td>";
        row += "<td>" + mr.toBangla(rowData.CCriminalCount) + "</td>";
        row += "<td>" + mr.toBangla(rowData.PCriminalCount) + "</td>";
        row += "<td>" + mr.toBangla(rowData.CJailCount) + "</td>";
        row += "<td>" + mr.toBangla(rowData.PJailCount) + "</td>";
        row += "</tr>";
        $("#tbdMonthlyReport").append(row);
    },


};

$(document).ready(function() {
    mr.init();
});