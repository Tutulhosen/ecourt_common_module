/**
 * Created by DOEL PC on 4/28/14.
 */


var jsonSelectedattachment = {};
var selectedattachment = [];
var selectedcase = [];

var oTablereqexistAttachment;
var oTablereqAttachment;
var oTablereqcase;
var oTablepro;
var oTablereq;
var oTablecitz;
var magistrate_table;
var criminal_table;
var winPop = false;


$(document).ready(function(){
    //datatables

    /* Formating function for row details */
    function fnFormatDetailsexistAttachment ( nTr )
    {
        var aData = oTablereqexistAttachment.fnGetData( nTr );
        var json;
        var complain ="";


        try {
            json = eval( aData[5]);
        } catch (exception) {
            //It's advisable to always catch an exception since eval() is a javascript executor...
            json = null;
        }

        if (json) {
            //this is json
            complain = jQuery.parseJSON( aData[5] );
        }else{
            complain =  aData[5];
        }

        var sOut = '<table width="100%" cellpadding="5" cellspacing="0" border="1" style="padding-left:2px;">';
        sOut += '<tr><td>অভিযোগকারী</td><td>মোবাইল </td><td>অভিযোগের তারিখ</td></tr>';
        sOut += '<tr><td>'+aData[3]+'</td><td>'+aData[4]+'</td><td>'+aData[2]+'</td></tr>';
        sOut += '<tr><td colspan="3">বিস্তারিত অভিযোগ</td></tr>';
        sOut += '<tr><td colspan="3">'+aData[5]+'</td></tr>';
        sOut += '</table>';

        return sOut;
    }

    oTablereqexistAttachment = $('#existattachmentrequisition').dataTable( {
        "bProcessing": true,
        "bServerSide": true,
        "bFilter" : false,
        "sAjaxSource":"/magistrate/existattachmentrequisitionlist",
        "rowCallback": function( row, data, displayIndex ) {
            if ( $.inArray(data.DT_RowId, selectedattachment) !== -1 ) {
                $(row).addClass('selected');

            }
        },
        "aoColumns": [
            { "sTitle": "", "sClass": "right", "sWidth": "50px","bSortable": false },
            { "sTitle": "অভিযোগ " , "sClass": "left", "sWidth": "200px"  },
            { "sTitle": "অভিযোগের তারিখ  ", "sClass": "right", "sWidth": "100px"   },
            { "sTitle": "অভিযোগকারী  ",  "sClass": "left", "sWidth": "100px" },
            { "sTitle": "মোবাইল ",  "sClass": "left", "sWidth": "100px" ,"bVisible" : false },
            { "sTitle": "বিস্তারিত অভিযোগ",  "sClass": "right", "sWidth": "300px" ,"bVisible" : false },
            { "sTitle": "তথ্য প্রাপ্তির  তারিখ",  "sClass": "right", "sWidth": "300px" }
        ],
        "aaSorting": [[0, 'desc']],
        "iDisplayStart":0,
//        "iDisplayLength":3,
        "bLengthChange": false

        });

    $('#existattachmentrequisition tbody').on('click', 'tr', function () {
        var id = this.id;
        var index = $.inArray(id, selectedattachment);

        if ( index === -1 ) {
            selectedattachment.push( id );
        } else {
            selectedattachment.splice( index, 1 );
        }
        $(this).toggleClass('selected');
    } );



    $('#existattachmentrequisition tbody').on( 'click','td img', function () {
        var nTr = $(this).parents('tr')[0];
        if ( oTablereqexistAttachment.fnIsOpen(nTr) )
        {
            /* This row is already open - close it */
            this.src =  "/mobile_court/images/details_open.png";
            oTablereqexistAttachment.fnClose( nTr );
        }
        else
        {
            /* Open this row */
            this.src = "/mobile_court/images/details_close.png";
            oTablereqexistAttachment.fnOpen( nTr, fnFormatDetailsexistAttachment(nTr), 'details' );
        }
    } );

    /*
     AttachmentRequisition
     */

    /* Formating function for row details */
    function fnFormatDetailsAttachment ( nTr )
    {
        var aData = oTablereqAttachment.fnGetData( nTr );
        var json;
        var complain ="";


        try {
            json = eval( aData[5]);
        } catch (exception) {
            //It's advisable to always catch an exception since eval() is a javascript executor...
            json = null;
        }

        if (json) {
            //this is json
            complain = jQuery.parseJSON( aData[5] );
        }else{
            complain =  aData[5];
        }

        var sOut = '<table width="100%" cellpadding="5" cellspacing="0" border="1" style="padding-left:2px;">';
        sOut += '<tr><td>অভিযোগকারী</td><td>মোবাইল</td><td>অভিযোগের তারিখ </td></tr>';
        sOut += '<tr><td>'+aData[3]+'</td><td>'+aData[4]+'</td><td>'+aData[2]+'</td></tr>';
        sOut += '<tr><td colspan="3">বিস্তারিত অভিযোগ</td></tr>';
        sOut += '<tr><td colspan="3">'+aData[5]+'</td></tr>';
        sOut += '</table>';

        return sOut;
    }

    oTablereqAttachment = $('#attachmentrequisition').dataTable( {
        bServerSide: true,
        bProcessing: true,
        "bFilter" : false,
        "bSort": true, //sorting for columns
        "bScrollInfinite": true, //using this takes away ddl of selection
        "pagingType": "full_numbers",
        crossDomain: true,
        "sServerMethod": "POST",
       // "bFilter" : false,
        "sAjaxSource":"/magistrate/attachmentrequisitionlist",
        "rowCallback": function( row, data, displayIndex ) {
            if ( $.inArray(data.DT_RowId, selectedattachment) !== -1 ) {
                $(row).addClass('selected');

            }
        },
        "aoColumns": [
            { "sTitle": "", "sClass": "right", "sWidth": "50px","bSortable": false },
            { "sTitle": "অভিযোগ" , "sClass": "left", "sWidth": "200px"  },
            { "sTitle": "অভিযোগের তারিখ ", "sClass": "right", "sWidth": "100px"   },
            { "sTitle": "অভিযোগকারী",  "sClass": "left", "sWidth": "100px" },
            { "sTitle": "মোবাইল",  "sClass": "left", "sWidth": "100px" ,"bVisible" : false },
            { "sTitle": "বিস্তারিত অভিযোগ",  "sClass": "right", "sWidth": "300px" ,"bVisible" : false },
            { "sTitle": "তথ্য প্রাপ্তির   তারিখ ",  "sClass": "right", "sWidth": "300px" }
        ],
        "aaSorting": [[0, 'desc']],
        "iDisplayStart":0,
//        "iDisplayLength":3,
        "bLengthChange": false

    } );

    $('#attachmentrequisition tbody').on('click', 'tr', function () {
        var id = this.id;
//        var sData = oTablereqAttachment.fnGetData( this );
//        alert(sData['subject']);
//        console.log(sData['subject']);
        var index = $.inArray(id, selectedattachment);

        if ( index === -1 ) {
//            var data = {"id" :id,"subject":sData['subject']};
            selectedattachment.push(id);
        } else {
            selectedattachment.splice( index, 1 );
        }
        $(this).toggleClass('selected');

    } );



    $('#attachmentrequisition tbody').on( 'click','td img', function () {
        var nTr = $(this).parents('tr')[0];
        if ( oTablereqAttachment.fnIsOpen(nTr) )
        {
            /* This row is already open - close it */
            this.src =  "/mobile_court/images/details_open.png";
            oTablereqAttachment.fnClose( nTr );
        }
        else
        {
            /* Open this row */
            this.src = "/mobile_court/images/details_close.png";
            oTablereqAttachment.fnOpen( nTr, fnFormatDetailsAttachment(nTr), 'details' );
        }
    } );

    /*
     Case
     */

    /* Formating function for row details */
    function fnFormatDetailscase ( nTr )
    {

        var aData = oTablereqcase.fnGetData( nTr );
        var json;
        var complain ="";


        try {
            json = eval( aData[7]);
        } catch (exception) {
            //It's advisable to always catch an exception since eval() is a javascript executor...
            json = null;
        }

        if (json) {
            //this is json
            complain = jQuery.parseJSON( aData[7] );
        }else{
            complain =  aData[7];
        }

        var sOut = '<table width="100%"  cellpadding="5" cellspacing="0" border="1" style="padding-left:2px;">';
        sOut += '<tr><td>মামলার নম্বর</td><td>প্রসিকিউটর</td><td>মামলার তারিখ</td></tr>';
        sOut += '<tr><td>'+aData[3]+'</td><td>'+aData[4]+'</td><td>'+aData[2]+'</td></tr>';
        sOut += '<tr><td>ঘটনাস্থল</td><td>অভিযোগ</td><td>অপরাধের বর্ণনা</td></tr>';
        sOut += '<tr><td>'+aData[5]+'</td><td>'+aData[6]+'</td><td>'+complain+'</td></tr>';
        sOut += '</table>';

        return sOut;
    }

    oTablereqcase = $('#caselist').dataTable( {
        "bProcessing": true,
        "bServerSide": true,
        "bFilter" : true,
        crossDomain: true,
        "sAjaxSource": "/magistrate/attachmentcaselist",
        "rowCallback": function( row, data, displayIndex ) {
            if ( $.inArray(data.DT_RowId, selectedcase) !== -1 ) {
                $(row).addClass('selected');

            }
        },
        "aoColumns": [
            { "sTitle": "", "sClass": "right", "sWidth": "50px","bSortable": false },
            { "sTitle": "", "sClass": "left", "sWidth": "50px" ,"bVisible" : false },
            { "sTitle": "id", "sClass": "left", "sWidth": "50px" ,"bVisible" : false },
            { "sTitle": "নম্বর" , "sClass": "left", "sWidth": "300px"  },
            { "sTitle": "প্রসিকিউটর", "sClass": "right", "sWidth": "100px",  "bVisible" : false  },
            { "sTitle": "তারিখ",  "sClass": "left", "sWidth": "200px" },
            { "sTitle": "ঘটনাস্থল",  "sClass": "left", "sWidth": "100px","bVisible" : false  },
            { "sTitle": "অভিযোগ",  "sClass": "right", "sWidth": "250px","sHeight": "50px" ,"bVisible" : false   },
            { "sTitle": "hints",  "sClass": "right", "sWidth": "300px" ,"bVisible" : false}
        ],


        "aaSorting": [[1, 'desc']],
        "iDisplayStart":0,
        "iDisplayLength":3,
        "bLengthChange": false,
        "oLanguage": {
            "sSearch":"অনুসন্ধান(মামলা  নম্বর ) : "
        }

    } );

    $('#caselist tbody').on('click', 'tr', function () {
        var id = this.id;
        var index = $.inArray(id, selectedcase);

        //alert("index"+ index);

        if ( index === -1 ) {
           selectedcase.pop(); //remove all
           selectedcase.push( id ); // insert last selected
        } else {
            selectedcase.splice( index, 1 );
        }
        //$(this).toggleClass('selected');

        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            oTablereqcase.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    } );

//    $('#caselist tbody').on( 'click', 'tr', function () {
//        if ( $(this).hasClass('selected') ) {
//            $(this).removeClass('selected');
//        }
//        else {
//            oTablereqcase.$('tr.selected').removeClass('selected');
//            $(this).addClass('selected');
//        }
//    } );

    $('#caselist tbody').on( 'click','td img', function () {
        var nTr = $(this).parents('tr')[0];
        if ( oTablereqcase.fnIsOpen(nTr) )
        {
            /* This row is already open - close it */
            this.src = "/mobile_court/images/details_open.png";
            oTablereqcase.fnClose( nTr );
        }
        else
        {
            /* Open this row */
            this.src = "/mobile_court/images/details_close.png";
            oTablereqcase.fnOpen( nTr, fnFormatDetailscase(nTr), 'details' );
        }
    } );

    /*
     ProsecutionforDashboard
     */

    /* Formating function for row details */
    function fnFormatDetailsPro ( nTr )
    {
        var aData = oTablepro.fnGetData( nTr );

        var json;
        var complain ="";


        try {
            json = eval(aData[6]);
        } catch (exception) {
            //It's advisable to always catch an exception since eval() is a javascript executor...
            json = null;
        }

        if (json) {
            //this is json
            complain = jQuery.parseJSON( aData[6] );
        }else{
            complain = aData[6];
        }

        var sOut = '<table width="100%"  cellpadding="5" cellspacing="0" border="1" style="padding-left:2px;">';
        sOut += '<tr ><td colspan="5">অভিযোগ</td></tr>';
        sOut += '<tr><td colspan="5">'+complain+'</td></tr>';
        sOut += '</table>';

        return sOut;
    }

    oTablepro = $('#example').dataTable( {
        "bProcessing": true,
        "bServerSide": true,
        "bFilter" : false,
        crossDomain: true,
        "sAjaxSource":  "/magistrate/searchProsecutionforDashboard",
        "aoColumns": [
            { "sTitle": "", "sClass": "right", "sWidth": "50px","bSortable": false },
            { "sTitle": "", "sClass": "left", "sWidth": "50px" ,"bVisible" : false },
            { "sTitle": "নম্বর" , "sClass": "left", "sWidth": "200px"  },
            { "sTitle": "প্রসিকিউটর", "sClass": "right", "sWidth": "100px"   },
            { "sTitle": "তারিখ",  "sClass": "left", "sWidth": "100px" },
            { "sTitle": "ঘটনাস্থল",  "sClass": "left", "sWidth": "100px" },
            { "sTitle": "অভিযোগ",  "sClass": "right", "sWidth": "300px","bVisible" : false },
            { "sTitle": "hints",  "sClass": "right", "sWidth": "300px" ,"bVisible" : false}
        ],
        "aaSorting": [[0, 'desc']],
        "iDisplayStart":0,
        "iDisplayLength":5,
        "bLengthChange": false
//        "sDom": 'T<"clear">lfrtip'

    } );



    $('#example tbody').on( 'click','td img', function () {
        var nTr = $(this).parents('tr')[0];
        if ( oTablepro.fnIsOpen(nTr) )
            {
            /* This row is already open - close it */
            this.src =  "/mobile_court/images/details_open.png";
            oTablepro.fnClose( nTr );
        }
        else
        {
            /* Open this row */
            this.src =  "/mobile_court/images/details_close.png";
            oTablepro.fnOpen( nTr, fnFormatDetailsPro(nTr), 'details' );
        }
    } );

//requisition

    /* Formating function for row details */
    function fnFormatDetailsReq ( nTr )
    {
        var aData = oTablereq.fnGetData( nTr );

        var json;
        var complain ="";


        try {
            json = eval(aData[5]);
        } catch (exception) {
            //It's advisable to always catch an exception since eval() is a javascript executor...
            json = null;
        }

        if (json) {
            //this is json
            complain = jQuery.parseJSON( aData[5] );
        }else{
            complain = aData[5];
        }

        var sOut = '<table width="100%"  cellpadding="5" cellspacing="0" border="1" style="padding-left:2px;">';
        sOut += '<tr><td>মামলার নম্বর</td><td>মামলার তারিখ</td></tr>';
        sOut += '<tr><td>'+aData[2]+'</td><td>'+aData[3]+'</td></tr>';
        sOut += '<tr><td>ঘটনাস্থল</td><td>অভিযোগ</td></tr>';
        sOut += '<tr><td>'+aData[4]+'</td><td>'+complain+'</td></tr>';
        sOut += '</table>';

        return sOut;
    }

    oTablereq = $('#requisition').dataTable( {
        "bProcessing": true,
        "bServerSide": true,
        "bFilter" : false,
        crossDomain: true,
        "sAjaxSource":  "/magistrate/searchRequisitionforDashboard",
        "aoColumns": [
            { "sClass": "center", "bSortable": false },
            null,
            null,
            { "sClass": "center" },
            { "sClass": "center" }
        ],
        "aaSorting": [[1, 'asc']],
        "iDisplayStart":0,
        "iDisplayLength":3,
        "bLengthChange": false
//        "sDom": 'T<"clear">lfrtip'
    } );

    $('#requisition tbody').on( 'click','td img', function () {
        var nTr = $(this).parents('tr')[0];
        if ( oTablereq.fnIsOpen(nTr) )
        {
            /* This row is already open - close it */
            this.src =  "/mobile_court/images/details_open.png";
            oTablereq.fnClose( nTr );
        }
        else
        {
            /* Open this row */
            this.src =  "/mobile_court/images/details_close.png";
            oTablereq.fnOpen( nTr, fnFormatDetailsReq(nTr), 'details' );
        }
    } );



    /* Formating function for row details */
    function fnFormatDetailsCitz ( nTr )
    {
        var acitzData = oTablecitz.fnGetData( nTr );
//        alert(acitzData);

        var json;
        var complain ="";


        try {
            json = eval( acitzData[7]);
        } catch (exception) {
            //It's advisable to always catch an exception since eval() is a javascript executor...
            json = null;
        }

        if (json) {
            //this is json
            complain = jQuery.parseJSON( acitzData[7] );
        }else{
            complain =  acitzData[7];
        }

        var sOut = '<table class="table table-bordered " width="100%"  cellpadding="5" cellspacing="0" border="1" style="padding-left:2px;">';
        sOut += '<tbody>';
        sOut += '<tr><td>অভিযোগ আইডি</td><td>অভিযোগের তারিখ</td></tr>';
        sOut += '<tr><td>'+acitzData[1]+'</td><td>'+acitzData[2]+'</td></tr>';
        sOut += '<tr><td>ঘটনাস্থল</td><td>অভিযোগকারী</td></tr>';
        sOut += '<tr><td>'+acitzData[4]+'</td><td>'+acitzData[3]+'</td></tr>';
        sOut += '<tr><td colspan="2">অভিযোগের বিবরণ</td></tr>';
        sOut += '<tr><td colspan="2">'+acitzData[7]+'</td></tr>';
        sOut += '<tr><td colspan="2">কার্যক্রম গ্রহণের সময়সীমা</td></tr>';
        sOut += '<tr><td colspan="2">'+acitzData[5]+'</td></tr>';
        sOut += '</tbody>';
        sOut += '</table>';
        return sOut;
    }

//citizen

    oTablecitz = $('#citizen').dataTable( {
        "bProcessing": true,
        "bServerSide": true,
        "bFilter" : false,
        crossDomain: true,
        "sAjaxSource":  "/magistrate/searchCitizenComplinforDashboard",
        "aoColumns": [
            { "sTitle": "", "sClass": "right", "sWidth": "50px","bSortable": false },
            { "sTitle": "অভিযোগ আইডি" , "sClass": "left", "sWidth": "200px"  },
            { "sTitle": "তারিখ", "sClass": "right", "sWidth": "100px"   },
            { "sTitle": "অভিযোগকারী",  "sClass": "left", "sWidth": "100px" },
            { "sTitle": "ঘটনাস্থল",  "sClass": "left", "sWidth": "100px" },
            { "sTitle": "কার্যক্রম গ্রহণের সময়সীমা",  "sClass": "right", "sWidth": "300px" },
            { "sTitle": "অভিযোগ",  "sClass": "right", "sWidth": "300px" }
        ],
        "aaSorting": [[1, 'asc']],
        "iDisplayStart":0,
        "iDisplayLength":3,
        "bLengthChange": false
//        "sDom": 'T<"clear">lfrtip'
    } );

    $('#citizen tbody').on( 'click','td img', function () {
        var nTr = $(this).parents('tr')[0];
        if ( oTablecitz.fnIsOpen(nTr) )
        {
            /* This row is already open - close it */
            this.src =  "/mobile_court/images/details_open.png";
            oTablecitz.fnClose( nTr );
        }
        else
        {
            /* Open this row */
            this.src =  "/mobile_court/images/details_close.png";
            oTablecitz.fnOpen( nTr, fnFormatDetailsCitz(nTr), 'details' );
        }
    } );
    $('#newsubmit').click( function () {
//        console.log(JSON.stringify(selectedattachment));
        sRequisition_ids = selectedattachment.join(','); //Join the elements of an array into a string:
//        sRequisition_ids = JSON.stringify(selectedattachment);
        sSelectedcase_ids = selectedcase.join(',');
        $.ajax({
            type: "POST",
            url:  "/magistrate/saverequisitionattachment",
            dataType: 'json',
            data: { "requisition_ids": sRequisition_ids,"prosecution_ids": sSelectedcase_ids },
            success: function(data, textStatus, jqXHR) {
                console.log(data, textStatus);
              
            //    alert("সফলভাবে সংরক্ষণ ","অবহতিকরন বার্তা");
               Swal.fire({
                title:'অবহতিকরন বার্তা',// "অবহতিকরণ বার্তা!",
                text: data.message,
                icon: "success"
                 });
                oTablereqAttachment.fnDraw();
                var baseUrl = document.location.origin;
                window.location.href = baseUrl+'/magistrate/newattachmentrequisition';
//                oTablecitz.ajax.reload();
            }
        });
    });

    $('#existsubmit').click( function () {
        sRequisition_ids = selectedattachment.join(',');
        sSelectedcase_ids = selectedcase.join(',');
        $.ajax({
            type: "POST",
            url:  "/magistrate/updaterequisitionattachment",
            dataType: 'json',
            crossDomain: true,
            data: {"requisition_ids": sRequisition_ids,"prosecution_ids": sSelectedcase_ids },
            success: function(data, textStatus, jqXHR) {
                console.log(data, textStatus);
                alert(data);
                // oTablereq.fnrel();
            }
        });
    });
    // datatables

});

function printcitizencomplain(){

    var url =  "/magistrate/searchCitizenComplinforDashboard2";
    $.post(url, function(data) {
    })
        .success(function(data) {
            if(data)
            {
                    setParamsforComplainList(data);
                    var html_content = $('#previewcitizencomplain').html();

                    newwindow=window.open();
                    newdocument=newwindow.document;
                    newwindow.document.write('<title>নাগরিক অভিযোগ </title>');
                    newdocument.write(html_content);
                    newdocument.close();

                    newwindow.print();
                    return false;
            }
        })
        .error(function() {
        })
        .complete(function() {
        });

}

$(function() {
    magistrate_table = $('#magistrate_table').dataTable( {
        bServerSide: true,
        bProcessing: true,
        "bFilter" : false,
        "bLengthChange": false,
        "bSort": true, //sorting for columns
        "bScrollInfinite": true, //using this takes away ddl of selection
        "sServerMethod": "POST",
        crossDomain: true,
        "sAjaxSource":  "/magistrate/getDataForTracker",
        "fnServerParams": function ( aoData ) {
            aoData.push( {"name": "case_no", "value": $('#intext2').val()});
            aoData.push( {"name": "complain_no", "value": $('#intext').val()} );
        }
    } );
});

function redrawTable() {
    magistrate_table.fnDraw();
}
function ifCaseNumber(obj){

    switch(obj) {
        case "is_case" :
            document.forms[0].elements["intext"].disabled=true;
            document.forms[0].elements["intext2"].disabled=false;
            $('input[type=text]').each(function(){ $(this).val(''); });

            break;
        case "is_compID" :
            document.forms[0].elements["intext"].disabled=false;
            document.forms[0].elements["intext2"].disabled=true;
            $('input[type=text]').each(function(){ $(this).val(''); });
            break;
    }

}
    $(function() {

//        alert("sdfsdf");
        var divid = $('#division').val() ;
        var zillaid = $('#zilla').val() ;
        var upazillaid = $('#upazila').val();
        var name_bng = $('#name_bng').val() ;
        var mobile = $('#mobile').val() ;



        criminal_table = $('#criminal_table').dataTable( {
            bServerSide: true,
            bProcessing: true,
            "bFilter" : false,
            "bLengthChange": false,
//            "bJQueryUI": true, //enables user interface
            "bSort": true, //sorting for columns
            "bScrollInfinite": true, //using this takes away ddl of selection
            //"pagingType": "full_numbers",
            "sServerMethod": "POST",
            crossDomain: true,
            "sAjaxSource":  "/magistrate/getDataForCriminalTracker",
            "fnServerParams": function ( aoData ) {
                aoData.push( {"name": "name_bng", "value": $('#name_bng').val()});
                aoData.push( {"name": "division", "value": $('#division').val()});
                aoData.push( {"name": "zilla", "value": $('#zilla').val()} );
                aoData.push( {"name": "upazila", "value": $('#upazila').val()});
                aoData.push( {"name": "mobile", "value": $('#mobile').val()} );
            }
        } );
    });

function redrawCriminalTable() {

    var divid = $('#division').val() ;
    var zillaid = $('#zilla').val() ;
    var upazillaid = $('#upazila').val();
    var name_bng = $('#name_bng').val() ;
    var mobile = $('#mobile').val() ;

    if(name_bng !="" || mobile !=""  ){
        if(name_bng !=""){
            if(zillaid ==""){
                alert("স্থান নির্বাচন করুন");
                return
            }
        }
        criminal_table.fnDraw();
    }else if(name_bng =="" && mobile =="")
    {
        alert("নাম অথবা স্থান নির্বাচন করুন");
        return
    }else{
            alert("আবার চেষ্টা করুন");
        }
    }

function showComplain(id){

    $('#id').val(id);
    $('#complainInfo').modal('show');
}

//    //Callback handler for form submit event
$("#saveComplain").submit(function(e)
{
    var formObj = $(this);
    var formURL =   "/magistrate/saveFeedback";
    var formData = new FormData(this);

    alert("sada");
//    console.log(formData);
    $.ajax({
        url: formURL,
        type: 'POST',
        data:  formData,
        dataType: 'json',
        mimeType:"multipart/form-data",
        contentType: false,
        cache: false,
        processData:false,
        beforeSend:function(){
        },
        success: function(response, textStatus, jqXHR)
        {

            if(response.flag == 'true'){

                //$('#successprosecution').modal('show');
                alert(response.message);
                clearForm();
            }else{
                alert("sada");
            }
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
        }
    });
    e.preventDefault(); //Prevent Default action.
    // e.unbind();

    return false;
});


function printregister() {

    var url =   "/magistrate/showregister";
    $.post(url, function (data) {
    })
        .success(function (data) {
            if (data) {
                setParams(data);
                var html_content = $('#printRegister').html();

                newwindow = window.open();
                newwindow.document.write('<title>নাগরিক অভিযোগ </title>');

                newdocument = newwindow.document;

                newdocument.write(html_content);
                newdocument.close();

                newwindow.print();
                return false;
            }
        })
        .error(function () {
        })
        .complete(function () {
        });

}



