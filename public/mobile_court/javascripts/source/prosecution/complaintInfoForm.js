var complaintForm = {
    seizureOrder:null,
    init: function () {

        // অভিযোগ গঠন button submission
        $('.suodate').datepicker();
        $('.suo_timepickersuomoto').timepicker({
            minuteStep: 1,
            secondStep: 5,
            showMeridian: false
        });
    },

    save: function () {
        
        console.log(validator);
        if(!validator.validateFields("#suomotcourtform")){
            alert("সকল তথ্য সঠিক ভাবে দেওয়া হয়নি। ","অবহতিকরণ বার্তা");
            return false;
        }
        var formObj = $('#suomotcourtform');

        var prosecutionId = $('#txtProsecutionID').val();
        var formURL = "/prosecution/createProsecution";
        var formData = new FormData(formObj[0]);
        formData.append( 'prosecutionId', prosecutionId);

        // $.confirm({
        //     resizable: false,
        //     height: 250,
        //     width: 400,
        //     modal: true,
        //     title: "অভিযোগ গঠণ",
        //     titleClass: "modal-header",
        //     content: "ফরমটি সংরক্ষণ করতে চান ?",
        //     buttons: {
        //         "না": function () {
        //             // $(this).dialog("close");
        //         },
        //         "হ্যাঁ": function () {
                    // $.ajax({
                    //     url: formURL,
                    //     type: 'POST',
                    //     data: formData,
                    //     dataType: 'json',
                    //     mimeType: "multipart/form-data",
                    //     contentType: false,
                    //     cache: false,
                    //     processData: false,
                    //     beforeSend: function () {
                    //     },
                    //     success: function (response) {
                    //         if (response.flag == 'true') {

                    //             if(response.isSuomoto==1){
                    //                 // Show Successful Message
                    //                 $('#successprosecution').modal('show');
                    //                 p_setdata(response.case_no);
                    //                 // Set tab index
                    //                 prosecutionInit.setTabIndex(response.step);
                    //                 complaintForm.setLawDiv(response.caseInfo.lawsBrokenList);
                    //                 if(response.caseInfo.prosecution.hasCriminal==1) {

                    //                     complaintForm.setCriminalConfessionDiv(response.caseInfo.lawsBrokenList, response.caseInfo.criminalDetails, response.caseInfo.criminalConfession, response.caseInfo.criminalConfessionsByLaws);
                    //                 }else{
                    //                     // Set Case Number
                    //                     $('.case_no').html(response.case_no);
                    //                     $('#case_no').val(response.case_no);
                    //                 }
                    //                 $('.case_no').html(response.case_no);
                    //             }
                    //             else {
                    //                 $.alert("অভিযোগ দায়ের সফলভাবে সম্পন্ন হয়েছে। ", "ধন্যবাদ");
                    //                 //with prosecutor move to magistrate choose tab
                    //                 prosecutionInit.moveToFirstTabProsecutor();
                    //             }
                    //             // $('#str_prosecution_id').val(response.prosecution_id);
                    //             $('#no_criminal').val(response.no_criminal);
                    //             $('#no_criminal_punish').val(response.no_criminal_punish);


                    //         }else if(response.flag == 'false'){
                    //             $.alert(response.message, "অবহতিকরণ বার্তা");
                    //         }else {
                    //             $.alert("তথ্য অসম্পূর্ন থাকায় আবেদনটি গ্রহণ করা হয়নি ।  পূনরায় চেষ্টা করুন ।  ", "ধন্যবাদ");
                    //         }
                    //     },
                    //     error: function (jqXHR, textStatus, errorThrown) {
                    //         $.alert("অভিযোগ গঠন সম্পন্ন হয়নি ।  পূনরায় চেষ্টা করুন ।  ", "অবহতিকরণ বার্তা");
                    //     }
                    // });
        //         }
        //     }
        // });


        Swal.fire({
            title: "আসামির তথ্য",
            text: "ফরমটি সংরক্ষণ করতে চান ?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            cancelButtonText: "না",
            confirmButtonText: "হ্যাঁ"
          }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: formURL,
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    mimeType: "multipart/form-data",
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function () {
                    },
                    success: function (response) {
                     
                        if (response.flag == 'true') {
                            if(response.isSuomoto==1){
                                $('#successprosecution').modal('show');
                                    p_setdata(response.case_no);
                                    // Set tab index
                                prosecutionInit.setTabIndex(response.step);
                           
                                complaintForm.setLawDiv(response.caseInfo.lawsBrokenList);
                                if(response.caseInfo.prosecution.hasCriminal==1) {

                                    complaintForm.setCriminalConfessionDiv(response.caseInfo.lawsBrokenList, response.caseInfo.criminalDetails, response.caseInfo.criminalConfession, response.caseInfo.criminalConfessionsByLaws);
                                }else{
                                    // Set Case Number
                                    $('.case_no').html(response.case_no);
                                    $('#case_no').val(response.case_no);
                                }
                                $('.case_no').html(response.case_no);
                            }else {
                                // alert("", "ধন্যবাদ");
                                Swal.fire({
                                    title: "ধন্যবাদ",
                                    text: "অভিযোগ দায়ের সফলভাবে সম্পন্ন হয়েছে। ",
                                    icon: "success"
                                });
                           
                                //with prosecutor move to magistrate choose tab
                                prosecutionInit.moveToFirstTabProsecutor();
                            }
                            $('#no_criminal').val(response.no_criminal);
                            $('#no_criminal_punish').val(response.no_criminal_punish);

                        }else if(response.flag == 'false'){
                                 alert(response.message, "অবহতিকরণ বার্তা");
                        }else {
                                 alert("তথ্য অসম্পূর্ন থাকায় আবেদনটি গ্রহণ করা হয়নি ।  পূনরায় চেষ্টা করুন ।  ", "ধন্যবাদ");
                        }
                        // if (response.flag == 'true') {
                        //     prosecutionInit.setTabIndex(response.step);
                        //     // if(response.isSuomoto==1){
                        //     //     // Show Successful Message
                        //     //     $('#successprosecution').modal('show');
                        //     //     p_setdata(response.case_no);
                        //     //     // Set tab index
                        //     //     prosecutionInit.setTabIndex(response.step);
                        //     //     complaintForm.setLawDiv(response.caseInfo.lawsBrokenList);
                        //     //     if(response.caseInfo.prosecution.hasCriminal==1) {

                        //     //         complaintForm.setCriminalConfessionDiv(response.caseInfo.lawsBrokenList, response.caseInfo.criminalDetails, response.caseInfo.criminalConfession, response.caseInfo.criminalConfessionsByLaws);
                        //     //     }else{
                        //     //         // Set Case Number
                        //     //         $('.case_no').html(response.case_no);
                        //     //         $('#case_no').val(response.case_no);
                        //     //     }
                        //     //     $('.case_no').html(response.case_no);
                        //     // }
                        //     // else {
                        //     //     $.alert("অভিযোগ দায়ের সফলভাবে সম্পন্ন হয়েছে। ", "ধন্যবাদ");
                        //     //     //with prosecutor move to magistrate choose tab
                        //     //     prosecutionInit.moveToFirstTabProsecutor();
                        //     // }
                        //     // $('#str_prosecution_id').val(response.prosecution_id);
                        //     $('#no_criminal').val(response.no_criminal);
                        //     $('#no_criminal_punish').val(response.no_criminal_punish);


                        // }else if(response.flag == 'false'){
                        //      alert(response.message, "অবহতিকরণ বার্তা");
                        // }else {
                        //      alert("তথ্য অসম্পূর্ন থাকায় আবেদনটি গ্রহণ করা হয়নি ।  পূনরায় চেষ্টা করুন ।  ", "ধন্যবাদ");
                        // }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                         alert("অভিযোগ গঠন সম্পন্ন হয়নি ।  পূনরায় চেষ্টা করুন ।  ", "অবহতিকরণ বার্তা");
                    }
                });
            }
        });
    },


    setLawAndSectionInfo: function (lawsBrokenList) {

        for (var i = 1; i <= lawsBrokenList.length; i++) {
            $('#txtPunishmentDesc' + i).val(lawsBrokenList[i-1].sec_number);
            $('#txtCrimeDesc' + i).val(lawsBrokenList[i-1].Description);

            lawSelector.init(i, lawsBrokenList[i - 1].LawID, lawsBrokenList[i - 1].SectionID);
            if (i < lawsBrokenList.length) {
                complaintForm.addNewLaw(false);
            }
        }
    },
    ben_to_en_number_conversion: function (ben_number) {
        var eng_number = '';
        for (var i = 0; i < ben_number.length; i++) {
            if (ben_number[i] == "০" || ben_number[i] == "0") eng_number = eng_number + '0';
            if (ben_number[i] == "১" || ben_number[i] == "1") eng_number = eng_number + '1';
            if (ben_number[i] == "২" || ben_number[i] == "2") eng_number = eng_number + '2';
            if (ben_number[i] == "৩" || ben_number[i] == "3") eng_number = eng_number + '3';
            if (ben_number[i] == "৪" || ben_number[i] == "4") eng_number = eng_number + '4';
            if (ben_number[i] == "৫" || ben_number[i] == "5") eng_number = eng_number + '5';
            if (ben_number[i] == "৬" || ben_number[i] == "6") eng_number = eng_number + '6';
            if (ben_number[i] == "৭" || ben_number[i] == "7") eng_number = eng_number + '7';
            if (ben_number[i] == "৮" || ben_number[i] == "8") eng_number = eng_number + '8';
            if (ben_number[i] == "৯" || ben_number[i] == "9") eng_number = eng_number + '9';
        }
        return eng_number;
    },
    setCaseNumberValue : function () {
        var serialNumber = $('#case_no_sr').val();
        var ValidationExpression = "^[0-9]*(০|১|২|৩|৪|৫|৬|৭|৮|৯|)*$";
        if (serialNumber.match(ValidationExpression)) {
            if(serialNumber.length == 4){
                $('#case_no_sr').val(complaintForm.ben_to_en_number_conversion(serialNumber));
                var caseNumber = $('#case_no').val();
                var caseArray = caseNumber.split('.');
                caseArray[3] = complaintForm.ben_to_en_number_conversion(serialNumber);
                caseNumber = caseArray.join('.');
                $('#case_no').val(caseNumber);
                prosecutionId = $('#txtProsecutionID').val();

                if(prosecutionId != ''){
                    var url = base_path + "/prosecution/checkCaseNumberDuplicacy";
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: {
                            'prosecutionId': prosecutionId,
                            'caseNo': caseNumber,

                        },
                        success: function (data) {
                            if (data.flag == 'true') {
                                $('#case_no_sr').val("");
                                alert('এই মামলা নম্বর দিয়ে ইতিমধ্যেই একটি মামলা দাখিল হয়ছে।', 'সর্তকিকরন ম্যাসেজ');
                            }
                        }
                    });
                }
            }else {
                $('#case_no_sr').val("");
                 alert('মামলা নম্বরের সিরিয়াল চার সংখ্যার হতে হবে!', 'সর্তকিকরন ম্যাসেজ');
            }
        }
        else {
            $('#case_no_sr').val("");
             alert('মামলা নম্বরের সিরিয়াল শুধুমাত্র সংখ্যায় হবে!', 'সর্তকিকরন ম্যাসেজ');
        }
    },
    setCriminalDiv: function (criminal) {
        $("#criminaltemplete").empty();
        var criminal_no = criminal.length;
        var div = $("#criminaltemplete");
        var rowTemplate = "";


        rowTemplate = '<div class="row">' +
            '<div class="col-md-12">' +
            '<div class="form-group">' +
            '<table class="table table-bordered table-striped" align="center" width="100%">' +
            '<thead>' +
            '<tr>' +
            '<th></th>' +
            '<th>নাম</th>' +
            '<th>পিতা / স্বামীর নাম</th>' +
            '<th>পূর্বের অপরাধ</th>' +
            '</tr>' +
            '</thead>' +
            '<tbody>';
        var temp = "";

        for (var i = 0; i < criminal_no; i++) {
            var name = "" + criminal[i].name_bng + "";
            var cus_name = "[" + criminal[i].custodian_type + "] " + criminal[i].custodian_name + "";
            temp += '<tr>' +
                '<td><input class="criminalcheckbox" type="checkbox" criminalName="'+criminal[i].name_bng+'" value= " ' + criminal[i].id + '" name="criminal[]"></td> ' +
                '<td>' + name + '</td> ' +
                '<td>' + cus_name + '</td> ';
            temp += '<td align="center"><a class="btn btn-success btn-mideum" href="#" onclick="complaintForm.showCriminalPreviousCrimeInformation(' + criminal[i].id + '); return false"> দেখুন</a></td> ' +
                '</tr> ';

            // if (criminal[i].no_of_crime == 2) {
            //     temp += '<td align="center"><a class="btn btn-success btn-mideum" href="#" onclick="showCriminalInformation(' + criminal[i].id + '); return false"> দেখুন</a></td> ' +
            //         '</tr> ';
            // } else {
            //     temp += '<td></td> ' +
            //         '</tr> ';
            // }

        }
        rowTemplate += temp + '</tbody> ' +
            '</table> ' +
            '</div> ' +
            '</div> ' +
            '</div> ';
        div.append(rowTemplate);
    },
    setComplaintInformation: function (lawsBrokenList, prosecutionInfo) {

        var locationType = prosecutionInfo.location_type;
        var divId = prosecutionInfo.divid;
        var zillaId = prosecutionInfo.zillaId;
        var upazilaId = prosecutionInfo.upazilaid;
        var citycorporationId = prosecutionInfo.geo_citycorporation_id;
        var metropolitanId = prosecutionInfo.geo_metropolitan_id;
        var thanaId = prosecutionInfo.geo_thana_id;

        // init law section for Complaint Form
        this.setLawAndSectionInfo(lawsBrokenList);

        // init location section
        eMobileLocation.populateLocation(999,locationType, divId,zillaId,upazilaId,citycorporationId,metropolitanId,thanaId);

        $("#suodate").val(prosecutionInfo.date);
        $("#suo_timepickersuomoto").val(prosecutionInfo.time);
        $("#location").val(prosecutionInfo.location);
        // $("#case_no").val(prosecutionInfo.caseno);
        $(".incidentType").val(prosecutionInfo.occurrence_type);
        $("#case_type1").val(prosecutionInfo.case_type1).change();
        $("#case_type2").val(prosecutionInfo.case_type2).change();
        $("#hints").val(prosecutionInfo.hints);

        //With prosecutor division and zilla(magistrate) fixed
        if(prosecutionInfo.is_suomotu==0){
          
            complaintForm.disableDivisionZillaWithProsecutor();
        }

    },
    disableDivisionZillaWithProsecutor:function () {
        // $(".selectDropdown").select2();
        $('#ddlDivision999').attr('disabled', 'disabled');
        $('#ddlZilla999').attr('disabled', 'disabled');
    },

    setCriminalConfessionDiv:function(lawWithSection, criminalInfo, criminalConfession, criminalConfessionsByLaws){
    
        var rowTemplate = "";
        var criminalConfessionDescription='';


        for (var i = 0; i < criminalInfo.length; i++) {

            var splitArray =[];

            if (typeof criminalConfessionsByLaws != 'undefined'){

                for (var j = 0; j < criminalConfessionsByLaws.length; j++) {
                    if(criminalConfessionsByLaws[j].criminalId == criminalInfo[i].id){
                        splitArray.push(criminalConfessionsByLaws[j].isConfessed);
                    }
                }
            }

            //check criminal confession is undefined
            if (typeof criminalConfession != 'undefined'){
                criminalConfessionDescription=criminalConfession[i].description;
            }else{
                $('.chkConfessionYes').each(function () {
                    this.checked = true;
                });
            }

            rowTemplate = "";
            var noOfcrm = i + 1;
            var id = criminalInfo[i].id;

            rowTemplate =
                '<div class="panel-group confessiondiv" id="accordion"> ' +
                '<div class="panel panel-info-head"> ' +
                '<div class="panel-heading newhead"> ' +
                '<a style="font-family: NIKOSHBAN;font-weight: 600;" class="panel-title" data-toggle="collapse" data-parent="#accordion" href="#collapse' + i + '">' + noOfcrm + 'নম্বর আসামির বক্তব্য  (ক্লিক করুন)' +
                '</a>' +
                '</div>';

            if (i == 0) {
                rowTemplate += '<div id="collapse' + i + '" class="accordion-body collapse in">';
            }
            else {
                rowTemplate += '<div id="collapse' + i + '" class="accordion-body collapse">';
            }

            rowTemplate += '<div class="panel-body cpv">' +
                '<div class="row"> ' +
                '<div class="col-sm-4"> ' +
                'নামঃ&nbsp;' + criminalInfo[i].name_bng +
                '</div> ' +
                '<div class="col-sm-4"> ' +
                'পিতা/স্বামী নামঃ&nbsp;' + criminalInfo[i].custodian_name +
                '</div> ' +
                '<div class="col-sm-4"> ' +
                'মাতার নামঃ&nbsp;' + criminalInfo[i].mother_name +
                '</div> ' +
                '</div> ' +
                '<div class="row"> ' +
                '<div class="col-sm-4"> ' +
                'বয়সঃ&nbsp;' + criminalInfo[i].age +
                '</div> ' +
                '<div class="col-sm-4"> ' +
                'পেশাঃ&nbsp;' + criminalInfo[i].occupation +
                '</div> ' +
                '<div class="col-sm-4"> ' +
                'ঠিকানাঃ&nbsp;' + criminalInfo[i].present_address +
                '</div> ' +
                '</div> ' +
                '<div class="row">' +
                '<div class="col-md-12 ">' +
                '<table class=" table-bordered table-striped" align="center" width="100%">' +
                '<thead>' +
                '<tr>' +
                '<th>লঙ্ঘিত আইন ও ধারা:&nbsp;</th>' +
                '<th>আসামির স্বীকারোক্তি:&nbsp;</th>' +
                '</tr>' +
                '</thead>' +
                '<tbody class="brokenlawDiv">';

            var lawTemplate="";
            for (var k = 0; k < lawWithSection.length; k++) {

                var chkyes = "";
                var chkNo ="";

                if(splitArray[k]==1){
                    chkyes ="checked";
                    chkNo="";
                }else if(splitArray[k]==0){
                    chkyes ="";
                    chkNo="checked";
                }else{
                    chkyes ="checked";
                    chkNo="";
                }

              lawTemplate +=
                        '<tr class="trLawsBroken"  lawsBrokenID="' + lawWithSection[k].LawsBrokenID + '">' +
                        '<td >' + lawWithSection[k].sec_title + ', ' + lawWithSection[k].sec_number + '</td>' +
                        '<td>' +
                        '<input type="radio" class="chkConfession chkConfessionYes"  '+chkyes+' name="confessionChk-' + id + '-' + k + '" value="1" />হ্যাঁ ' +
                        '<input type="radio" class="chkConfession chkConfessionNo" '+chkNo+' name="confessionChk-' + id + '-' + k + '" value="0" />না' +
                        '</td>' +
                        '</tr>';
            };

            rowTemplate +=lawTemplate;

        rowTemplate +=  '</tbody>' +
                '</table>'+
                '</div>' +
                '</div>' +
                '<div class="row"> ' +
                '<div class="col-md-12"> ' +
                '<div class="form-group"> ' +
                '<label class="control-label textmid">আসামির জবানবন্দি  বর্ণনা করুন</label > ' +
                '<input class="input form-control criminalID required" name="criminal[' + i + ']['+id +']" id="criminalid_'+i+'"  value= ' + id + ' type="hidden"/> ' +
                '<textarea id="description_' + i + '" name="criminal[' + i + '][description]"  class="input form-control confession required" cols="50" rows="2" required="true">' +
                criminalConfessionDescription+
                '</textarea> ' +
                '</div> ' +
                '</div> ' +
                '</div> ' +
                '</div> ' +
                '</div> ' +
                '</div> ';

             $('#confessiondiv').append(rowTemplate);


        }

        // $('.chkConfessionYes').each(function () {
        //     this.checked = true;
        // });

    },

    setLawDiv: function (law) {
        
        $("#lawtemplete").empty();
        console.log(law);
        var law_num=law.length;
        var div=$("#lawtemplete");
        var rowTemplate = "";
        rowTemplate ='<div class="row">' +
            '<div class="col-md-12">' +
            '<div class="form-group">' +
            '<table class="table table-bordered table-striped" align="center" width="100%">' +
            '<thead>' +
            '<tr>' +
            '<th></th>' +
            '<th>শিরোনাম</th>' +
            '<th>বিস্তারিত</th>' +
            '</tr>' +
            '</thead>' +
            '<tbody>' ;
        var   temp = ""  ;
        for (var i = 0; i < law_num; i++) {
            var law_title = law[i].sec_title;

            complaintForm.setParamsForLawModal(law[i]);

            temp +=     '<tr>' +
                '<td><input class="lawcheckbox" type="checkbox" secNumber="'+law[i].sec_number+'" secDescription="'+law[i].sec_description+'" title=" '+ law_title + '" value= " ' + law[i].LawsBrokenID + '" name="law[]"></td> ' +
                '<td>'+law_title+','+law[i].sec_number+'</td> '+
                '<td><a class="btn btn-success btn-mideum" href="#" onclick="complaintForm.showLawModal(' + law[i].LawID + '); return false"> দেখুন</a></td></tr>';

        }
        rowTemplate +=   temp + '</tbody> ' +
            '</table> ' +
            '</div> ' +
            '</div> ' +
            '</div> ' ;
        div.append(rowTemplate);

    },

    showLawModal:function (id){
    var lawInfoId='#lawInfo_'+id;
    $(lawInfoId).modal('show');
    },

    setParamsForLawModal: function (data){

        var element=data;
        var link = element['bd_law_link'] ? '<a tabindex="-1" target="_blank" href='+ element['bd_law_link'] + '> বিস্তারিত আইন </a> ' : "" ;
        var template="";
        template+='<div id="lawInfo_'+element.LawID+'" class="modal fade" style="display: none;">' +
            '    <div class="modal-dialog modal-lg">' +
            '        <div class="modal-content">' +
            '            <div class="modal-header" style="background: #006d34;color: #fff;">' +
            '                <h3>ধন্যবাদ</h3>' +
            '                <a class="close" data-dismiss="modal">×</a>' +
            '            </div>' +
            '            <div class="modal-body">' +
            '                <table class="table table-bordered table-striped" id="lawmodal_'+element.LawID+'" align="center" width="100%">' +
            '                    <caption class="caption-custom">আইন , ধারা ও শাস্তির বিবরণ</caption>' +
            '                    <thead>' +
            '                    <tr>' +
            '                        <th style="width: 10%;">শিরোনাম</th>' +
            '                        <th style="width: 20%;">ধারার বর্ণনা</th>' +
            '                        <th style="width: 20%;">অপরাধের বর্ণনা</th>' +
            '                        <th style="width: 10%;">মূল আইনের লিঙ্ক</th>' +
            '                        <th style="width:40% ">বিস্তারিত</th>' +
            '                    </tr>' +
            '                   <tr>' +
            '                   <td> '+element['sec_title']+ '</td>'  +
            '                   <td> '+"ধারার নম্বর:" +element['sec_number']+ '<br/>'  +
            "ধারার   বর্ণনা:" +element['sec_description']+ '</td>'  +
            '                   <td> '+ " শাস্তির ধারা  নম্বর :"+element['punishment_sec_number']+ '<br/>'  +
            element['punishment_des']+ '</td>'  +
            '                   <td> '+link+ '</td>'  +
            '                   <td> <b class="font-color">শাস্তির ধরন : </b> '+element['punishment_type_des']+ '<br/>'  +
            '                   <b class="font-color">কয়েদ :  </b><br/> সর্বোচ্চ-&nbsp;' + element['max_jell'] + '&nbsp;,সর্বনিম্ন-&nbsp;' +
            element['min_jell']+
            '                   <b class="font-color"> জরিমানা :  </b><br/> সর্বোচ্চ-&nbsp;'+element['max_fine']+
            '                   &nbsp;,সর্বনিম্ন-&nbsp;'+element['min_fine']+ '<b class="font-color">পুনরায় অপরাধের শাস্তি  :  </b><br/>'  +
            '                   কয়েদ-&nbsp;'+element['next_jail']+ '&nbsp;,জরিমানা-&nbsp;'  +
            element['next_fine']+ '</td>' +
            '                   </tr>'+
            '                   </thead>' +
            '                </table>' +
            '            </div>' +
            '            <div class="modal-footer">' +
            '                <a href="#" class="btn btn-mideum" data-dismiss="modal">সমাপ্ত</a>' +
            '            </div>' +
            '        </div>' +
            '    </div>' +
            '</div>';
        $('#modal_law').append(template);

    },

    addNewLaw: function (initiateFlag) {
      
        var rowNum = $(".criminal_laws").length;  // law no
        var crm_id = "#c-lawdiv_" + rowNum;
        var nextRowNum = rowNum + 1;  // law no

        var ddsel =
            '<div class="form-group criminal_laws" id="c-lawdiv_' + nextRowNum + '">' +
            '<div class="form-group">' +
            '<label class="col-sm-2"><span style="color:#FF0000">*</span>আইন</label>' +
            '<div class="col-sm-10">' +
            '<select required="true" class="required form-control" id="ddlLaw' + nextRowNum + '" name="brokenLaws[' + nextRowNum + '][law_id]"' + ' >';

        var ddopt = '<option value="">বাছাই করুন...</option>';
        var ddselc = '</select></div></div><div class="form-group"><label class="col-sm-2"><span style="color:#FF0000">*</span>ধারা</label><div class="col-sm-10">';

        var row = "";

        var url = "/law/getLaw";

        var row_temp = ddsel + ddopt + ddselc +
            '<select required="true" class="form-control" id="ddlSection' + nextRowNum + '" name="brokenLaws[' + nextRowNum + '][section_id]"  usedummy="1"></select></div></div>' +
            '<div class="form-group"> ' +
            '<label class="col-sm-2"><span style="color:#FF0000"></span>শাস্তির ধারা </label> ' +
            '<div class="col-sm-10"> ' +
            '<textarea id="txtPunishmentDesc' + nextRowNum + '" name="brokenLaws[' + nextRowNum + '][section_description]" class="required input form-control" cols="50" rows="1"  readonly = "readonly" ></textarea>	 ' +
            '</div> ' +
            '</div> ' +
            '<div class="form-group"> ' +
            '<label class="col-sm-2"><span style="color:#FF0000">*</span>অপরাধের বিবরণ </label> ' +
            '<div class="col-sm-10"> ' +
            '<textarea id="txtCrimeDesc' + nextRowNum + '" name="brokenLaws[' + nextRowNum + '][crime_description]" class="required input form-control" cols="50" rows="4" required="true"></textarea>	 ' +
            '</div> ' +
            '</div> ' +
            '<div class="col-sm-6">' +
            '<button type="button" class="btn btn-small btn-warning" name="remoove_' + nextRowNum + '" id="c_r_button_' + nextRowNum + '" onclick="complaintForm.removeLaw(' + nextRowNum + ');"><i class="glyphicon glyphicon-ban-circle"></i><span>বাতিল</span></button>&nbsp;' +
            '<button type="button" class="btn btn-small btn-primary" name="c-L" id="c_a_button_' + nextRowNum + '" onclick="complaintForm.addNewLaw(true);"><i class="glyphicon glyphicon-plus"></i><span>আরেকটি</span></button></div></div>';
        $(crm_id).after(row_temp);

        $('#c_a_button_' + rowNum).hide();
        $('#c_r_button_' + rowNum).hide();

        $('#law_id_' + nextRowNum).select2();
        $('#section_id_' + nextRowNum).select2();

        if(initiateFlag){
            lawSelector.init(nextRowNum,null,null);
        }
    },

    removeLaw: function (rnum) {
        var st1 = '#c-lawdiv_' + rnum;
        $(st1).remove();

        $('#c_a_button_' + (rnum - 1)).show();

        if ($('#c_r_button_' + (rnum - 1))) {
            $('#c_r_button_' + (rnum - 1)).show();
        }
    },

    showNewSection: function (select, rowNum) {

        if (select == "") {
            document.getElementById("txtHint").innerHTML = "";
            return;
        }
        else {

            var url ="/section/getSectionByLawId?ld=" + select;
            $.ajax({
                type: "POST",
                url: url,
                success: function (data) {
                    var sel_id = "#section_id_" + rowNum;
                    //alert(sel_id);
                    if (data.length > 0) {
                        $(sel_id).find("option:gt(0)").remove();
                        $(sel_id).find("option:first").text("Loading...");

                        $(sel_id).find("option:first").text("");
                        for (var i = 0; i < data.length; i++) {
                            $("<option/>").attr("value", data[i].id).text(data[i].sec_description).appendTo($(sel_id));
                        }
                    } else {
                        $(sel_id).find("option:gt(0)").remove();
                        $(sel_id).find("option:first").text("বাছাই করুন ...");
                    }
                }
            });

        }
    },

    setPunismentDescription: function (select, index) {
        if (select == "") {
            document.getElementById("txtHint").innerHTML = "";
            return;
        }
        else {
            // 28/04/2016
            var crime_description = "#crime_description_" + index;
            var section_description = "#section_description_" + index;

            var url = "/section/getPunishmentBySectionId?ld=" + select;

            $.ajax({
                type: "POST",
                url: url,
                success: function (data) {
                    if (data.length > 0) {
                        $(crime_description).val((data[0].name).trim());
                        $(section_description).val((data[0].sectiondes).trim());

                    }
                }
            });
        }
    },
    getCaseInfoDataByProsecution: function (prosecutionID) {
    
        var data = '';
        var URL = "/prosecution/getCaseInfoByProsecutionId";
        $.ajax({ url: URL, 
            type: 'POST', 
            dataType: 'json', 
            data: {'prosecutionId': prosecutionID},
            async: false,
            success: function (response) {
                data = response;
            },
            error: function () {
               
                alert("ত্রুটি", "অবহতিকরণ বার্তা");
            }
        });
        return data;
    },
    showCriminalPreviousCrimeInformation:function (criminalId) {

        var prosecutionId=$("#txtProsecutionID").val();
        var URL = "/criminal/getCriminalPreviousCrimeDetails";
        $.ajax({ url: URL, type: 'POST', dataType: 'json', data: {'prosecutionId': prosecutionId,'criminalId': criminalId},async: false,
            success: function (response) {
            console.log(response);
                complaintForm.populateCriminalPreviousCrimeDetailModal(response);
            },
            error: function () {
                
                alert("ত্রুটি", "অবহতিকরণ বার্তা");
            }
        });
    },
    populateCriminalPreviousCrimeDetailModal:function (crimeDetail) {
        var modal='';
        var crimeText='';
        if(crimeDetail.length>0){
            for(var i=0;i<crimeDetail.length;i++){
                crimeText+="<div class='form-control' style='background-color: #dbe8d3; margin: 5px;' ><p><b>ঘটনার তারিখ:</b> "+ crimeDetail[i].date +"</p><p><b>মামলা নম্বর:</b> "+crimeDetail[i].case_no +" &nbsp;</p><p style='margin-left: 30px'>"+crimeDetail[i].subject+"</p></div>";
            }
        }
        else {
            crimeText=" পূর্বের কোনো  অপরাধ নেই ";
        }

        modal+='<div id="previousCrime"  class="modal fade" style="display: none;">' +
        '    <div class="modal-dialog modal-lg">' +
        '        <div class="modal-content">' +
        '            <div class="modal-header" style="    background: #006d34;color: #fff;">' +
        '                <h3>পূর্বের অপরাধের বিবরণ </h3>' +
        '                <a class="close" data-dismiss="modal">×</a>' +
        '            </div>' +
                ' <div class="modal-body">'+crimeText+'</div>'+
        '            <div class="modal-footer">' +
        '                <a href="#" class="btn btn-mideum" data-dismiss="modal">সমাপ্ত</a>' +
        '            </div>' +
        '        </div>' +
        '    </div>' +
        '</div>';
        $('#previousCrimeModal').append(modal);
        $('#previousCrime').modal('show');
    }


};
$(document).ready(function () {
   complaintForm.init();
});