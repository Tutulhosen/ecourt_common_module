/**
 * Created by DOEL PC on 4/28/14.
 */

$(document).ready(function(){

    $("#magistrate_id").select2();
    $('#estimated_date').datepicker({ dateFormat:'yy/mm/dd' });

} );

function printComplain() {

    var complain_id = $('#complain_id').val();
    var divname = $('#divname').val();
    var zillaname = $('#zillaname').val();
    var upazilaname = $('#upazilaname').val();
    var url ="/requisition/getComplainforPrint?id="+complain_id;
    $.ajax({
        url: url,
        type: 'POST',
        success: function (data) {
            console.log(data);
            if (data) {
                setParams(data, divname, zillaname, upazilaname);
                var html_content = $('#printComplain').html();

                newwindow = window.open();
                newwindow.document.write('<title>অভিযোগ </title>');
                newdocument = newwindow.document;
                newdocument.write(html_content);
                newdocument.close();

                newwindow.print();
                return false;
            }
        },
        error: function () {
        },
        complete: function () {
        }
    });

}
function printComplainFromList(complain_id,div,zilla,upazilla) {

    var url = "/requisition/getComplainforPrint?id="+complain_id;
    $.ajax({url:url,type: 'POST',
        success:function (data) {
            if (data) {
                setParams(data,div,zilla,upazilla);

                var html_content = $('#printComplain').html();


                newwindow = window.open();
                newdocument = newwindow.document;
                newwindow.document.write('<title>অভিযোগ </title>');
                newdocument.write(html_content);
                newdocument.close();

                newwindow.print();
                return false;
            }
        },
        error:function () {
        },
        complete:function () {
        }
    });

}

