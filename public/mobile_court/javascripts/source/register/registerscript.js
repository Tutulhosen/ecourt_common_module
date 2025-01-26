/**
 * Created by sarker.pranab on 5/18/2017.
 */
// var table = $('#data_table').DataTable();  //Data table initializing
var register = {

    init: function () {
        jQuery("#reportlist").select2();
        jQuery("#lawlist").select2();
       // jQuery("#division").select2();
       // jQuery('#zilla').select2();
        

        jQuery("#start_date,#end_date").datepicker();
        var user_prfoile = $('#user_prfoile').val(); //alert(user_prfoile);
        if((user_prfoile == 'Divisional Commissioner')||(user_prfoile == 'JS' )){
            jQuery("#zilla").select2();
            jQuery('#division').select2();
            //$('#zilla').select2();
        }
        /* Make Searchable 'Auto Complete' */
        $('#upazila').select2();

        $('#GeoCityCorporations').select2();
        $('#GeoMetropolitan').select2();
        $('#GeoThanas').select2();
        $('#graph').select2();

        var zillaid = $('#zilla').val();
        if(zillaid!=''){
            showupozilladiv();
        }
        $('#startdate,#enddate').datepicker({dateFormat: 'yy/mm/dd'});


    },

    getSelectedValues: function () {
        var reportID = $('#reportlist').val() ;
      
        var divid = $('#division').val()?$('#division').val():'';
      
        var zillaid = $('#zilla').val()?$('#zilla').val():'';
        var upozilaid = $('#upazila').val()?$('#upazila').val():'';
       
        var GeoCityCorporations = $('#GeoCityCorporations').val()?$('#GeoCityCorporations').val():'';
   
        var GeoMetropolitan = $('#GeoMetropolitan').val()?$('#GeoMetropolitan').val():'';

        var GeoThanas = $('#GeoThanas').val()?$('#GeoThanas').val():'';
        console.log(GeoThanas);
        if((GeoMetropolitan == '') && (GeoThanas!='')){
            message_show("অনুগ্রহ করে মেট্রোপলিটন নির্বাচন করুন ।");
            die;
        }
        if((GeoMetropolitan != '') && (GeoThanas=='')){
            message_show("অনুগ্রহ করে থানা নির্বাচন করুন ।");
            die;
        }

        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();

        //If user not selected start date
        if(start_date == ''){
            message_show("অনুগ্রহ করে তারিখ নির্বাচন করুন ।");
            return
        }

        return {
            reportID: reportID,
            divid: divid,
            zillaid: zillaid,
            upozilaid: upozilaid,
            GeoCityCorporations: GeoCityCorporations,
            GeoMetropolitan: GeoMetropolitan,
            GeoThanas: GeoThanas,
            start_date: start_date,
            end_date: end_date
        };
    },

    getFormatedString: function (__ret) {
        return "&divisionid=" + __ret.divid + "&zillaid=" + __ret.zillaid + "&upozilaid=" + __ret.upozilaid + "&GeoCityCorporations=" + __ret.GeoCityCorporations + "&GeoMetropolitan=" + __ret.GeoMetropolitan + "&GeoThanas=" + __ret.GeoThanas + "&start_date=" + __ret.start_date + "&end_date=" + __ret.end_date+"&reportID="+__ret.reportID;
    },

    printtabledetails:function (table_print)
    {
        // $("#data_table").clone().appendTo("#cloneTble").modal('show');
        //var mywindow = window.open('', 'PRINT', 'height=auto,width=auto');
        var mywindow = window.open('', '_blank');
        var regiClass = $("#classOfRegi").val();

        $(".dataTables_scrollHead").css('overflow','visible'); 
        $(".dataTables_scrollBody").css('overflow','visible'); 

        var registerTitle =$('#nameOfRegi').val();
        var officeAddress = $('#office_address').val();
        var sDate = $('#start_date').val();
            sDate = sDate.split("/");
        var startDate = sDate[2]+'-'+sDate[0]+'-'+sDate[1];

        var eDate = $('#end_date').val();
           
        if(eDate){
            eDate = eDate.split("/");
            var endDate = eDate[2]+'-'+eDate[0]+'-'+eDate[1];    
        }else{
            var endDate = new Date().toJSON().slice(0,10);
        }

        mywindow.document.write('<html><head><link rel="stylesheet" type="text/css" href="../../css/registerList/registerNewPrint.css" /><title>' + registerTitle + '</title>');


        mywindow.document.write('</head><body class="print-page'+ ' '+regiClass+'">');
       // mywindow.document.write('<h3>' + registerTitle  + '</h3>');
        mywindow.document.write('<p id="regiTitle">' + registerTitle  + '</p>');
        mywindow.document.write('<p id="uOffice">' + officeAddress  + ' </p>');
        mywindow.document.write('<p id="searchDate">মামলার তারিখঃ &nbsp;' + startDate  + '&nbsp; হতে &nbsp;'+ endDate +'&nbsp;। </p>');
        mywindow.document.write(document.getElementById("table_print").innerHTML);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10*/
        setTimeout(function(){mywindow.print();}, 2000);  //necessary for chrome

        $(".dataTables_scrollHead").css('overflow','hidden'); 

        $(".dataTables_scrollBody").css('overflow','auto'); 

        return true;
    },

    setLabelAndComunOfTable:function(data) {
    $("#data_table").append(
        '<thead>' +
        '<tr>' +
        '<th>ক্রম</th>' +
        '</tr>' +
        '</thead>'
    );

   // alert(data.registerLabelList.length);
    var totalCol = data.registerLabelList.length;
    if(totalCol%2==0){
        var halfCol = totalCol/2;
    }else{
        var halfCol = totalCol/2;
        halfCol = Math.ceil(halfCol);
    }

  // alert(halfCol);

    $.each(data.registerLabelList, function (i, x) {

        if(i==halfCol){
             $("#register_column_fields").append("<br/>");
        }

        $("#register_column_fields").append(
            '<label class="toggle-vis btn-sm btn-default regiSelectLabel"><input name="regiLabelchk" type="checkbox" id="r_'+(i+1)+'" class="regiLabelList" data-column="' + (i + 1) + '" value="'+x.label+'" checked />'+x.label+'</label>'
        );

        $("#data_table thead tr").append(
            '<th>' + x.label + '</th>'
        );
    });

    },

    showRegister: function () {

        $("#register_column_fields").empty();
        $('#data_table').empty();
        $('#table_print').css('display','block');
        $("#register_column_label").css("display", "block");
        document.getElementById("register_column_label").classList.remove("hidden");

        $("#data_table thead tr").empty();

        if ($.fn.DataTable.isDataTable("#data_table")) { //alert(111);
            table.destroy();
            $('#data_table thead tr').empty();
            $('#data_table').empty();
            $("#regiDataLoder").css("display", "none");
        }else{

        }

        var __ret = this.getSelectedValues();

        console.log('talbe --ret', __ret)

        //If user not selected any register
        if(!__ret.reportID){
            message_show("অনুগ্রহ করে রেজিস্টার নির্বাচন করুন ।");
            die;
        }
        var search_data = this.getFormatedString(__ret);


        if (__ret.reportID=='1'){
            var radioArray = document.getElementsByName("complainstatus");
            var value = "";

            for (i = 0; i < radioArray.length; i++) {
                if (radioArray[i].checked) {
                    value = radioArray[i].value;
                    break
                }
            }
            var complainStatus = value;
            var search_data = "&divisionid=" + __ret.divid + "&zillaid=" + __ret.zillaid + "&upozilaid=" + __ret.upozilaid + "&GeoCityCorporations=" + __ret.GeoCityCorporations + "&GeoMetropolitan=" + __ret.GeoMetropolitan + "&GeoThanas=" + __ret.GeoThanas + "&start_date=" + __ret.start_date + "&end_date=" + __ret.end_date+"&reportID="+__ret.reportID + "&complainstatus=" + complainStatus;

            nagorikOvijogRegistere.nagorikOvijogTable(search_data);
            $('#classOfRegi').val('nagorikOvijogTable');
        }
        else if(__ret.reportID=='6'){
            prosecutionRegistere.prosecutionTable(search_data);
            $('#classOfRegi').val('prosecutionTable');
        }

        else if(__ret.reportID=='2'){

            dailyRegister.dailyTable(search_data);
            $('#classOfRegi').val('dailyTable');
        }

        else if(__ret.reportID=='3'){

            punishmentJailRegister.punishmentJailTable(search_data);
            $('#classOfRegi').val('punishmentJailTable');
        }

        else if(__ret.reportID=='7'){

            mobileCourtRegister.mobileCourtTable(search_data);
            $('#classOfRegi').val('mobileCourtTable');
        }

        else if(__ret.reportID=='10'){

            punishmentFineRegister.punishmentFineTable(search_data);
            $('#classOfRegi').val('punishmentFineTable');
        }
        else if(__ret.reportID=='8'){

            var lawID = $('#lawlist').val() ;
            var search_data = "&divisionid=" + __ret.divid + "&zillaid=" + __ret.zillaid + "&upozilaid=" + __ret.upozilaid + "&GeoCityCorporations=" + __ret.GeoCityCorporations + "&GeoMetropolitan=" + __ret.GeoMetropolitan + "&GeoThanas=" + __ret.GeoThanas + "&start_date=" + __ret.start_date + "&end_date=" + __ret.end_date+"&reportID="+__ret.reportID + "&lawID=" + lawID;
            lawBasedRegistere.lawBasedTable(search_data);
            $('#classOfRegi').val('lawBasedTable');

        }
    },

    showcomplainStatus:function (sel) {
      
    $("#register_column_fields").html("");
    if ($.fn.DataTable.isDataTable("#data_table")) { //alert(111);
        table.destroy();
        $('#data_table thead tr').empty();
        $('#data_table').empty();
        $("#regiDataLoder").css("display", "none");
        $("#register_column_label").css("display", "none");
    }else{

    }

    document.getElementById("end_date").disabled = false;
    if (sel == '1') {//নাগরিক অভিযোগের
        $("#reporttype").fadeIn(); 
         $("#lawtype").fadeOut();

    }else if(sel == '8'){
       
        $("#lawtype").fadeIn();
        $("#reporttype").fadeOut();
    } else {
        $("#reporttype").fadeOut();
        $("#lawtype").fadeOut();

        if (sel == '2') {
            document.getElementById("end_date").disabled = true;
        }
        return true;
    }
    }


};

$(document).ready(function() {
    register.init();

});
