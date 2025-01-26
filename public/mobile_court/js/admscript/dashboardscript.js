/**
 * Created by DOEL PC on 4/28/14.
 */

var newwindow = null;
$(document).ready(function () {

});

function zillastatistic() {

    var divid = $('#divid').val();
    var zillaid = $('#zillaId').val();
    var start_time = $('#date-zilla-s1').val();
    var end_time = $('#date-zilla-e1').val();


    var url = base_path + "/profile_adm/showzillastatistic?divid=" + divid + "&zillaid=" + zillaid + "&end_time=" + end_time  + "&start_time=" + start_time;
    $.post(url, function (data) {
    })
        .success(function (data) {
            console.log(data);
            if (data) {
                var executed_court = data[0].executed_court;
                var no_case = data[0].complete_case;
//                var complete_case = data[0].complete_case ;
//                var incomplete_case = data[0].incomplete_case ; executed_court
                var criminal = data[0].criminal_no;
                var fine = data[0].fine;


                document.getElementById("executed_court").innerHTML = executed_court;
                document.getElementById("no_case_total").innerHTML = no_case;
                document.getElementById("fine").innerHTML = fine;
                document.getElementById("criminal_no").innerHTML = criminal;
            }
        })
        .error(function () {
        })
        .complete(function () {
        });
}


function dcstatistic() {
    var divid = $('#divid').val();
    var zillaid = $('#zillaId').val();
    var start_time = $('#date-dc-s1').val();
    var end_time = $('#date-dc-e1').val();


    var url = base_path + "/profile_adm/showdcstatistic?divid=" + divid + "&zillaid=" + zillaid + "&end_time=" + end_time + "&end_time=" + end_time + "&start_time=" + start_time;
    $.post(url, function (data) {
    })
        .success(function (data) {
            console.log(data);
            if (data) {
                var executed_court = data[0].executed_court;
                var no_case = data[0].no_case;
                var complete_case = data[0].complete_case;
                var incomplete_case = data[0].incomplete_case;

                document.getElementById("executed_court_dc").innerHTML = executed_court;
                document.getElementById("no_case_dc").innerHTML = no_case;
//                document.getElementById("complete_case_dc").innerHTML= complete_case;
//                document.getElementById("incomplete_case_dc").innerHTML= incomplete_case;
            }
        })
        .error(function () {
        })
        .complete(function () {
        });
}

function zillacitizencomplain() {
    var divid = $('#divid').val();
    var zillaid = $('#zillaId').val();
    var start_time = $('#date-zilla-s2').val();
    var end_time = $('#date-zilla-e2').val();


    var url = base_path + "/profile_adm/showzillacitizencomplain?divid=" + divid + "&zillaid=" + zillaid + "&end_time=" + end_time + "&end_time=" + end_time + "&start_time=" + start_time;
    $.post(url, function (data) {
    })
        .success(function (data) {
            console.log(data);
            if (data) {
                var total = data[0].total;
                var accepted = data[0].accepted;
                var ignore = data[0].ignore;
                var unchange = data[0].unchange;

                document.getElementById("total").innerHTML = total;
                document.getElementById("accepted").innerHTML = accepted;
                document.getElementById("ignore").innerHTML = ignore;
                document.getElementById("unchange").innerHTML = unchange;
            }
        })
        .error(function () {
        })
        .complete(function () {
        });
}


function dccitizencomplain() {
    var divid = $('#divid').val();
    var zillaid = $('#zillaId').val();
    var start_time = $('#date-dc-s1').val();
    var end_time = $('#date-dc-e1').val();


    var url = base_path + "/profile_adm/showdccitizencomplain?divid=" + divid + "&zillaid=" + zillaid + "&end_time=" + end_time + "&end_time=" + end_time + "&start_time=" + start_time;
    $.post(url, function (data) {
    })
        .success(function (data) {
            console.log(data);
            if (data) {
                var total = data[0].total;
                var accepted = data[0].accepted;
                var ignore = data[0].ignore;
                var unchange = data[0].unchange;

                document.getElementById("total_dc").innerHTML = total;
                document.getElementById("accepted_dc").innerHTML = accepted;
                document.getElementById("ignore_dc").innerHTML = ignore;
                document.getElementById("unchange_dc").innerHTML = unchange;
            }
        })
        .error(function () {
        })
        .complete(function () {
        });
}

function upazillainfo() {

    var divid = $('#divid').val();
    var zillaid = $('#zillaId').val();
    var upazillaid = $('#upazila').val();
    var start_time = $('#date-upz-s1').val();
    var end_time = $('#date-upz-e1').val();

    var upazillaname = $("select[name='upazila'] option:selected").text();

//    message_show("dsfsf");

    document.getElementById("upazillaname").innerHTML = upazillaname;


    if (upazillaid == '') {
        message_show("উপজেলা নির্বাচন করুন ।");
        return
    }


    var url = base_path + "/profile_adm/showupozillainfo?divid=" + divid + "&zillaid=" + zillaid + "&upazillaId=" + upazillaid + "&end_time=" + end_time + "&end_time=" + end_time + "&start_time=" + start_time;
    $.post(url, function (data) {
    })
        .success(function (data) {
            console.log(data);
            if (data) {


                var total_zilla = data[0].total;
                var accepted_zilla = data[0].accepted;
                var ignore_zilla = data[0].ignore;
                var unchange_zilla = data[0].unchange;

                var criminal_no_upa = data[0].criminal_no_upa;
                var fine_upa = data[0].fine_upa;

                var executed_court_zilla = data[0].executed_court;
                var no_case_zilla = data[0].no_case;


                document.getElementById("total_zilla").innerHTML = total_zilla;
                document.getElementById("accepted_zilla").innerHTML = accepted_zilla;
                document.getElementById("ignore_zilla").innerHTML = ignore_zilla;
                document.getElementById("unchange_zilla").innerHTML = unchange_zilla;


                document.getElementById("executed_court_zilla").innerHTML = executed_court_zilla;
                document.getElementById("no_case_zilla").innerHTML = no_case_zilla;

                document.getElementById("criminal_no_upa").innerHTML = criminal_no_upa;
                document.getElementById("fine_upa").innerHTML = fine_upa;






                $("#dcofficeinfo").fadeOut();
                $("#upazillainfo").fadeIn();
            }
        })
        .error(function () {
        })
        .complete(function () {
        });

}


function printrdailyegister() {

    var url = base_path + "/profile_adm/showregister";
    $.post(url, function (data) {
    })
        .success(function (data) {
            if (data) {
                setParams(data);
                var html_content = $('#printRegister').html();

                newwindow = window.open();
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

function printcitizencomplainregister() {

    var url = base_path + "/profile_adm/showregister";
    $.post(url, function (data) {
    })
        .success(function (data) {
            if (data) {
                setParams(data);
                var html_content = $('#printRegister').html();

                newwindow = window.open();
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

function printmonthlyStatisticregister() {

    var url = base_path + "/profile_adm/showregister";
    $.post(url, function (data) {
    })
        .success(function (data) {
            if (data) {
                setParams(data);
                var html_content = $('#printRegister').html();

                newwindow = window.open();
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


function printacceptedregister() {

    var url = base_path + "/profile_adm/showregister";
    $.post(url, function (data) {
    })
        .success(function (data) {
            if (data) {
                setParams(data);
                var html_content = $('#printRegister').html();

                newwindow = window.open();
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


function printrpinishmerntegister() {

    var url = base_path + "/profile_adm/showregister";
    $.post(url, function (data) {
    })
        .success(function (data) {
            if (data) {
                setParams(data);
                var html_content = $('#printRegister').html();

                newwindow = window.open();
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


function printremonthlycourtgister() {

    var url = base_path + "/profile_adm/showregister";
    $.post(url, function (data) {
    })
        .success(function (data) {
            if (data) {
                setParams(data);
                var html_content = $('#printRegister').html();

                newwindow = window.open();
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


function printmonthlyreportregister() {

    var url = base_path + "/profile_adm/showregister";
    $.post(url, function (data) {
    })
        .success(function (data) {
            if (data) {
                setParams(data);
                var html_content = $('#printRegister').html();

                newwindow = window.open();
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


function printregister() {

    var url = base_path + "/profile_adm/showregister";
    $.post(url, function (data) {
    })
        .success(function (data) {
            if (data) {
                setParams(data);
                var html_content = $('#printRegister').html();

                newwindow = window.open();
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


function hidezilladiv() {
    $("#dcofficeinfo").fadeIn();
    $("#upazillainfo").fadeOut();
}


function printcitizencomplainregister() {

    var url = base_path + "/profile_adm/showcitizencomplainregister";
    $.post(url, function (data) {
    })
        .success(function (data) {
            if (data) {
                setParams_forcitizen(data);
                var html_content = "";
                html_content = $('#register_print_complain').html();
                console.log(html_content);

                newwindow = window.open();
                newwindow.document.write('<title>নাগরিক অভিযোগ </title>');
                newdocument = newwindow.document;
                newdocument.write(html_content);

                newwindow.print();
                return false;
            }
        })
        .error(function () {
        })
        .complete(function () {
        });

}
