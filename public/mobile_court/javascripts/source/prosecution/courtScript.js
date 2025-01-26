/**
 * Created by DOEL PC on 5/21/14.
 */

$(document).ready(function(){

    // full calender
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();
    var event = '';
    var calendar = $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        selectable: true,
        selectHelper: true,

        select: function(start, end, allDay) {
            endtime = $.fullCalendar.formatDate(end,'h:mm tt');
            starttime = $.fullCalendar.formatDate(start,'ddd, MMM d');
            var mywhen = starttime ;
            $('#createEventModal #apptStartTime1').val(start);
            $('#createEventModal #apptEndTime1').val(end);
            $('#createEventModal #apptAllDay1').val(allDay);
            $('#createEventModal #when1').text(mywhen);
            $('#createEventModal').modal('show');
        },
        //openModal("' + event.title + '","' + event.description + '","' + event.url + '","' + event.start + '","' + event.end + '"
        editable: true,
        eventDrop: function(event, delta) {
            var start = $.fullCalendar.formatDate(event.start, "yyyy-MM-dd HH:mm:ss");
            var end = $.fullCalendar.formatDate(event.end, "yyyy-MM-dd HH:mm:ss");
            $.ajax({
                url: base_path + "/court/update_events",
                data: 'title='+ event.title+'&start='+ $.fullCalendar.formatDate(start, "yyyy/MM/dd") +'&end='+ end +'&id='+ event.id ,
                type: "POST",
                success: function(json) {
                    alert("Updated Successfully");
                }
            });
        },
        eventResize: function(event) {
            var start = $.fullCalendar.formatDate(event.start, "yyyy-MM-dd HH:mm:ss");
            var end = $.fullCalendar.formatDate(event.end, "yyyy-MM-dd HH:mm:ss");
            $.ajax({
                url: base_path + "/court/update_events",
                data: 'title='+ event.title+'&start='+ $.fullCalendar.formatDate(start, "yyyy/MM/dd") +'&end='+ end +'&id='+ event.id ,
                type: "POST",
                success: function(json) {

                    $.alert("Updated Successfully","সর্তকীকরণ  ম্যাসেজ");
                }
            });

        },
        eventClick: function(event) {
            $('#operationalEventModal #court_heading2').val(event.title);
            $('#operationalEventModal #apptStartTime2').val(event.start);
            if(event.status == '1'){
                document.forms["deleteForm"]["status21"].checked=true;
            }
            else if(event.status == '2'){
                document.forms["deleteForm"]["status22"].checked=true;
            }
            else{ // 0
                document.forms["deleteForm"]["status20"].checked=true;
            }

            $('#operationalEventModal #id2').val(event.id);

            var mywhen = $.fullCalendar.formatDate(event.start, "yyyy-MM-dd");
            $('#operationalEventModal #when2').text(mywhen);

            $('#operationalEventModal').modal('show');
        },

        events: function (start, end, callback) {
            $.ajax({
                url: base_path +  "/court/testnew",
                dataType: 'json',

                success: function (doc) {
                    var events = [];
                    $.each(doc, function (key, val) {
                        events.push({
                            id: val.id,
                            title : val.title,
                            start: val.start,
                            editable: false,
                            status: val.status,
                            className: val.className
                        });
                    });

                    callback(events);
                }
            });

        }/* ,
        eventColor: '#378006' */
    });

    $('#updateButton').on('click', function(e){
        // We don't want this to act as a link so cancel the link action
        e.preventDefault();

        $("#operationalEventModal").modal('hide');

        var  title =   $('#operationalEventModal #court_heading2').val();
        var  apptStartTime =   new Date($('#operationalEventModal #apptStartTime2').val());
        var  status =   '';
        var len = document.deleteForm.status.length;
        for (i = 0; i < len; i++) {

            if ( document.deleteForm.status[i].checked ) {

                status = document.deleteForm.status[i].value;
                break;

            }

        }
        var  id =   $('#operationalEventModal #id2').val();

        var start = $.fullCalendar.formatDate(apptStartTime, "yyyy-MM-dd");
        $.ajax({
            url: base_path + "/court/update_events",
            data: "&id=" + id +"&title=" + title +"&status=" + status +"&start=" + start,
            type: "POST",
            success: function(json) {
                $('#message').val(json);
                $("#messageModal").modal('show');
            }
        });
        $('#calendar').fullCalendar( 'refetchEvents' );

    });

    $('#deleteButton').on('click', function(e){
        // We don't want this to act as a link so cancel the link action
        e.preventDefault();
        $("#operationalEventModal").modal('hide');
        var  id =   $('#operationalEventModal #id2').val();
//        jAlert(id);
        $.ajax({
            type: "POST",
            url: base_path + "/court/delete_events",
            data: "&id=" + id,
            success: function(json) {
                // $.alert(json.msg,"সর্তকীকরণ  ম্যাসেজ");
                $('#message').val(json.msg);
                $("#messageModal").modal('show');
            }
        });
        $('#calendar').fullCalendar('removeEvents', id);
    });

    $('#submitButton').on('click', function(e){
        // We don't want this to act as a link so cancel the link action
        e.preventDefault();

        doSubmit();
    });
    $('#closeButton').on('click', function(e){
        window.location.reload();
    });
    function doSubmit(){


        $("#createEventModal").modal('hide');


        var  title =   $('#createEventModal #court_heading1').val();
        var  apptStartTime =   new Date($('#createEventModal #apptStartTime1').val());
        var  status =   '';
        var len = document.createForm.status.length;
        for (i = 0; i < len; i++) {

            if ( document.createForm.status[i].checked ) {

                status = document.createForm.status[i].value;
                break;

            }

        }
        var  id =   $('#operationalEventModal #id2').val();

        var start = $.fullCalendar.formatDate(apptStartTime, "yyyy-MM-dd");


        if (title) {
            $.ajax({
                url: base_path + "/court/create_events",
                data: "&title=" + title +"&status=" + status +"&start=" + start,
                type: "POST",
                success: function(json) {
                    $('#createEventModal #id1').val();
                    $('#createEventModal #title1').val();
                    $('#message').val(json);
                    $("#messageModal").modal('show');
                }
            });
            $('#calendar').fullCalendar( 'refetchEvents' );

        }else{
            //jAlert("কোর্টের শিরোনাম লিখুন ।" ,"সর্তকীকরণ  ম্যাসেজ");
            $.alert("কোর্টের শিরোনাম লিখুন ।" ,"সর্তকীকরণ  ম্যাসেজ");
        }

    }


});