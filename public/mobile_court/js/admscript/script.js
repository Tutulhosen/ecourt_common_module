/**
 * Created by DOEL PC on 4/28/14.
 */

var my_table;

$(document).ready(function(){

    jQuery("#magistrate_id").select2({minimumResultsForSearch : -1});
 
    $(".confirm").confirm();

    my_table = $('#my_table').dataTable( {

        bServerSide: true,
        bProcessing: true,
        "bFilter" : false,
        "bLengthChange": false,
        "bJQueryUI": true, //enables user interface
        "bSort": true, //sorting for columns
        "bScrollInfinite": true, //using this takes away ddl of selection
        "pagingType": "full_numbers",
        "sServerMethod": "POST",
        "aaSorting": [[0, 'desc']],
        "iDisplayStart":0,
        "bLengthChange": false,
        "sAjaxSource":"../profile_adm/getDataForTracker",
        "fnServerParams": function ( aoData ) {
            aoData.push( { "name": "magistrate", "value": $('#magistrate').val() });
            aoData.push( {"name": "case_no", "value": $('#intext2').val()});
            aoData.push( {"name": "complain_no", "value": $('#intext').val()} );
            aoData.push( {"name": "start_date", "value": $('#date').val()} );
            aoData.push( {"name": "end_date", "value": $('#date2').val()} );
        }
    } );

        document.forms[0].elements["intext2"].disabled=true;
        document.forms[0].elements["intext"].disabled=true;
        $('input[type=text]').each(function(){ $(this).val(''); });
        $('#magistrate').val('0');

    $('#my_table tbody tr').each( function() {
        var sTitle;
        var nTds = $('td', this);
        var sBrowser = $(nTds[1]).text();
        var sGrade = $(nTds[4]).text();



        this.setAttribute( 'title', sGrade );
    } );

    /* Apply the tooltips */
    $('#my_table tbody tr[title]').tooltip( {
        "delay": 0,
        "track": true,
        "fade": 250
    } );
    /* Init DataTables */
    $('#my_table').dataTable();

} );
//$(function() {
//    my_table = $('#my_table').dataTable( {
//        bServerSide: true,
//        bProcessing: true,
//        "bFilter" : false,
//        "bLengthChange": false,
//        "bJQueryUI": true, //enables user interface
//        "bSort": true, //sorting for columns
//        "bScrollInfinite": true, //using this takes away ddl of selection
//        "pagingType": "full_numbers",
//        "sServerMethod": "POST",
//        "sAjaxSource": "/profile_adm/getDataForTracker",
//        "fnServerParams": function ( aoData ) {
//            aoData.push( { "name": "magistrate", "value": $('#magistrate').val() });
//            aoData.push( {"name": "case_no", "value": $('#intext2').val()});
//            aoData.push( {"name": "complain_no", "value": $('#intext').val()} );
//        },
//        "aoColumns": [
//            { "sTitle": "s", "sClass": "right", "sWidth": "50px","bSortable": false },
//            { "sTitle": "অভিযোগ " , "sClass": "left", "sWidth": "200px"  },
//            { "sTitle": "অভিযোগের তারিখ ", "sClass": "right", "sWidth": "100px"   },
//            { "sTitle": "অভিযোগকারী ",  "sClass": "left", "sWidth": "100px" },
//            { "sTitle": "মোবাইল ",  "sClass": "left", "sWidth": "100px" ,"bVisible" : false },
//            { "sTitle": "বিস্তারিত অভিযোগ",  "sClass": "right", "sWidth": "300px" ,"bVisible" : false },
//            { "sTitle": "রিকুইজিশনের তারিখ ",  "sClass": "right", "sWidth": "300px" }
//        ],
//        'fnCreatedCell': function(nTd, sData, oData, iRow, iCol) {
//            nTd.title = 'Some more information';
//        }
//    } );
//});

function redrawTable() {
    my_table.fnDraw();
}
function showComplainInformation(compalinId) {
    //alert(compalinId);
    if (compalinId == "") {
        return;
    }
    else {
        var url = base_path + "/citizen_complain/getCitizen_complainById?id=" + compalinId;
        $.ajax({
            url: url, type: 'POST',
            success: function (data) {
                console.log(data);
                if (data.length > 0) {
                    var name = "#name";
                    var cmp_mobile = "#cmp_mobile";
                    var email = "#email";

                    var cmp_subject = "#cmp_subject";
                    var cmp_details = "#cmp_details";
                    var cmp_user_idno = "#cmp_user_idno";
                    var cmp_divname = "#cmp_divname";
                    var cmp_zillaname = "#cmp_zillaname";
                    var cmp_upazilaname = "#cmp_upazilaname";
                    var cmp_location = "#cmp_location";

                    $(name).val(data[0].name);
                    $(cmp_mobile).val(data[0].mobile);
                    $(cmp_subject).val(data[0].subject);
                    $(cmp_details).val(data[0].complain_details);
                    $(cmp_user_idno).val(data[0].compId);
                    $(cmp_divname).val(data[0].divname);
                    $(cmp_zillaname).val(data[0].zillaname);
                    $(cmp_upazilaname).val(data[0].upazilaname);
                    $(cmp_location).val(data[0].location);
                    $('#admdetailsInfo').modal('show');

                }
            },
            error: function () {
            },
            complete: function () {
            }
        });
    }
}



function ifCaseNumber(obj){

    switch(obj) {
        case "is_magistrate" :
            document.forms[0].elements["intext"].disabled=true;
            document.forms[0].elements["intext2"].disabled=true;
            $('input[type=text]').each(function(){ $(this).val(''); });
            break;
        case "is_case" :
            document.forms[0].elements["intext"].disabled=true;
            document.forms[0].elements["intext2"].disabled=false;
            $('input[type=text]').each(function(){ $(this).val(''); });
            $('#magistrate').val('0');

            break;
        case "is_compID" :
            document.forms[0].elements["intext"].disabled=false;
            document.forms[0].elements["intext2"].disabled=true;
            $('input[type=text]').each(function(){ $(this).val(''); });
            $('#magistrate').val('0');
            break;
    }
}


function editRequisition(magistrate_id,requisition_id){

    if(magistrate_id!='' && requisition_id!=''){
        Swal.fire({
            title: "ম্যাজিস্ট্রেট  পরিবর্তন",
            text: "আপনি কি এ ব্যাপারে নিশ্চিত ?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            cancelButtonText: "না",
            confirmButtonText: "হ্যাঁ"
          }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url:"../requisition/changeMagistrate",
                    type: "POST",
                    dataType: 'JSON',
                    data: {
                        'id': requisition_id,
                        'magistrate_id': magistrate_id
                    },
                    success: function (result) {

                        Swal.fire({
                            title: result[0].msg,
                            text: "অবহতিকরন বার্তা",
                            icon: "success",
                            showCancelButton: false,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            cancelButtonText: "না",
                            confirmButtonText: "বন্ধ করুন"
                          });
                        // $.confirm({
                        //     resizable: false,
                        //     height:200,
                        //     modal: true,
                        //     title: " অবহতিকরন বার্তা",
                        //     titleClass: "modal-header",
                        //     content: result[0].msg,
                        //     buttons: {
                        //         " বন্ধ করুন": function() {
                        //             location.reload();
                        //         }
                        //     }
                        // });

                    },
                    error: function (request, status, error) {
                        alert(error);

                    }
                });
            }
        }); 
        // $.confirm({
        //     resizable: false,
        //     height:200,
        //     modal: true,
        //     title: " ম্যাজিস্ট্রেট  পরিবর্তন ",
        //     titleClass: "modal-header",
        //     content: "আপনি কি এ ব্যাপারে নিশ্চিত ?",
        //     buttons: {
        //         "হ্যাঁ": function() {
        //             $.ajax({
        //                 url:"../requisition/changeMagistrate",
        //                 type: "POST",
        //                 dataType: 'JSON',
        //                 data: {
        //                     'id': requisition_id,
        //                     'magistrate_id': magistrate_id
        //                 },
        //                 success: function (result) {
        //                     $.confirm({
        //                         resizable: false,
        //                         height:200,
        //                         modal: true,
        //                         title: " অবহতিকরন বার্তা",
        //                         titleClass: "modal-header",
        //                         content: result[0].msg,
        //                         buttons: {
        //                             " বন্ধ করুন": function() {
        //                                 location.reload();
        //                             }
        //                         }
        //                     });

        //                 },
        //                 error: function (request, status, error) {
        //                     alert(error);

        //                 }
        //             });
        //         },
        //         "বাতিল": function() {

        //         }
        //     }
        // });
    }
}






