var initDataFromProsecutor = {

    init: function () {
        $("#case_no_sr").tooltip();
        var prosecutionID = $("#txtProsecutionID").val();
        initDataFromProsecutor.populateUI(prosecutionID);
    },

    /**
     * load/initialize controls and populate with existing values
     * @param prosecutionID
     */
    populateUI: function (prosecutionID) {

        if (prosecutionID) {
            initDataFromProsecutor.setLawInfoByProsecution(prosecutionID);
            // load existing record
        }
    },


    save: function () {
        var formObj = $('#creatComplainFormId');
        var prosecutionId = $('#txtProsecutionID').val();
        var formData = new FormData(formObj[0]);
        formData.append( 'prosecutionId', prosecutionId);
        var formURL ="/prosecution/createComplain";

        Swal.fire({
            title: "অভিযোগ গঠণ",
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
                    dataType: 'json',
                    data: formData,
                    mimeType: "multipart/form-data",
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (response, textStatus, jqXHR) {
                        if (response.flag == 'true') {
                            var baseUrl = document.location.origin;
                            window.location.href = baseUrl+'/prosecution/searchComplain/';
                            // $.alert("অভিযোগ দায়ের সফলভাবে সম্পন্ন হয়েছে। </br> মামলা নম্বর:"+response.case_no, "ধন্যবাদ");
                        }else if(response.flag == 'false'){
                            alert(response.message, "অবহতিকরণ বার্তা");
                        } else {
                           alert("তথ্য অসম্পূর্ন থাকায় আবেদনটি গ্রহণ করা হয়নি ।  পূনরায় চেষ্টা করুন ।  ", "ধন্যবাদ");
                        }

                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                         alert("অভিযোগ গঠন সম্পন্ন হয়নি ।  পূনরায় চেষ্টা করুন ।  ", "অবহতিকরণ বার্তা");
                    }
                });


            }
        });
        // $.confirm({
        //     resizable: false,
        //     height: 250,
        //     width: 400,
        //     modal: true,
        //     title: "অভিযোগ গঠণ",
        //     titleClass: "modal-header",
        //     type: "orange",
        //     content: "ফরমটি সংরক্ষণ করতে চান ?",
        //     buttons: {
        //         "না": function () {
        //             // $(this).dialog("close");
        //         },
        //         "হ্যাঁ": function () {
        //             $.ajax({
        //                 url: formURL,
        //                 type: 'POST',
        //                 dataType: 'json',
        //                 data: formData,
        //                 mimeType: "multipart/form-data",
        //                 contentType: false,
        //                 cache: false,
        //                 processData: false,
        //                 success: function (response, textStatus, jqXHR) {
        //                     if (response.flag == 'true') {
        //                         var baseUrl = document.location.origin;
        //                         window.location.href = baseUrl+'/prosecution/searchComplain/';
        //                         // $.alert("অভিযোগ দায়ের সফলভাবে সম্পন্ন হয়েছে। </br> মামলা নম্বর:"+response.case_no, "ধন্যবাদ");
        //                     }else if(response.flag == 'false'){
        //                         $.alert(response.message, "অবহতিকরণ বার্তা");
        //                     } else {
        //                         $.alert("তথ্য অসম্পূর্ন থাকায় আবেদনটি গ্রহণ করা হয়নি ।  পূনরায় চেষ্টা করুন ।  ", "ধন্যবাদ");
        //                     }

        //                 },
        //                 error: function (jqXHR, textStatus, errorThrown) {
        //                     $.alert("অভিযোগ গঠন সম্পন্ন হয়নি ।  পূনরায় চেষ্টা করুন ।  ", "অবহতিকরণ বার্তা");
        //                 }
        //             });

        //         }
        //     }
        // });
        // save
    },

    setLawInfoByProsecution: function (prosecutionID) {
        var URL = "/prosecution/getCaseInfoByProsecutionId";
        $.ajax({ url: URL, type: 'POST', dataType: 'json', data: {'prosecutionId': prosecutionID},
            success: function (response) {
                if (response.flag == 'true') {
                    // console.log(response.caseInfo.lawsBrokenListWithProsecutor);
                    complaintForm.setLawAndSectionInfo(response.caseInfo.lawsBrokenListWithProsecutor);
                    initDataFromProsecutor.setCaseInfoNewComplainPage(response.caseInfo);

                    if(response.caseInfo.fileContent.ChargeFame.length > 0)
                    {
                        initDataFromProsecutor.setChargeFameFile(response.caseInfo.fileContent.ChargeFame);
                    }
                    $('#case_no').val(response.case_no);
                }else{
                    $.alert("ত্রুটি", "অবহতিকরণ বার্তা");
                }

            },
            error: function () {
                $.alert("ত্রুটি", "অবহতিকরণ বার্তা");
            }
        });
    },
    setCaseInfoNewComplainPage:function (caseInfo) {
        var criminalInfo="";
        var noOfcrm=0;

        $('#noCase').text("মামলা নম্বরঃ "+caseInfo.prosecution.case_no);
        $('#placeCase').text("ঘটনাস্থালঃ "+caseInfo.prosecution.location);
        $('#dateCase').text("তারিখঃ "+caseInfo.prosecution.date+"  সময়ঃ "+caseInfo.prosecution.time);

        $('#NameMagistrate').text("নামঃ "+caseInfo.magistrateInfo.name_eng);
        $('#OfficeMagistrate').text("অফিসঃ "+caseInfo.magistrateInfo.location_str);

        if(caseInfo.seizurelist){
            $('#siezureNotExistChk').hide();
        }else{
            $('#seizureExist').hide();
        }

        if(caseInfo.criminalDetails){
            for (var i=0;i<caseInfo.criminalDetails.length;i++){
                noOfcrm=i+1;
                criminalInfo+='<div class="panel-group" id="accordion">' +
                    '<div class="panel panel-info-head">' +
                    '<div class="panel-heading newhead" style="font-family: NIKOSHBAN">   ' + noOfcrm + ' নম্বর আসামির তথ্য' +
                    '<a  class="panel-title p-3" data-toggle="collapse" data-parent="#accordion" href="#collapse' + i + '">' +'ক্লিক করুন' +

                    '</a>' +
                    '</div>' +
                    '<div id="collapse' + i + '" class="accordion-body collapse">' +
                    '<div class="panel-body cpv mb-3 mt-3"><div class="row">' +
                    '<div class="col-sm-4">' +
                    'নামঃ&nbsp;' + caseInfo.criminalDetails[i].name_bng +
                    '</div>' +
                    '<div class="col-sm-4">' + caseInfo.criminalDetails[i].custodian_type +'র নামঃ&nbsp;' + caseInfo.criminalDetails[i].custodian_name +
                    '</div>' +
                    '<div class="col-sm-4">' +'মাতার নামঃ&nbsp;' +caseInfo.criminalDetails[i].mother_name +
                    '</div></div>' +
                    '</div>' +
                    ' </div>' +
                    '</div>' +
                    '</div>';
            }
            $('#criminalInformation').append(criminalInfo);
        }



    },

    setChargeFameFile: function (file) {
        var listItem = '';
        for (var i = 0; i<file.length; i++)
        {
            var fileId = file[i].FileID;
            if(file[i].FileType =='IMAGE') {
                listItem += '<div class="col-xs-3 col-sm-3 col-md-3 col-lg-2 thumbnail" >' +
                    '<button type="button" class="img-button close" onclick="initDataFromProsecutor.deleteFile(this,' + fileId + ')">' +
                    '<span aria-hidden="true">&times;</span>' +
                    '</button>' +
                    '<div class="img-label">' + file[i].FileType + '</div>' +
                    '<img class="img-responsive multi-image" src="/ecourt/' + file[i].FilePath + '' + file[i].FileName + '">' +
                    '</div>';
            }
            else{
                listItem += '<div class="col-xs-3 col-sm-3 col-md-3 col-lg-2 thumbnail" >' +
                    '<button type="button" class="img-button close" onclick="initDataFromProsecutor.deleteFile(this,' + fileId + ')">' +
                    '<span aria-hidden="true">&times;</span>' +
                    '</button>' +
                    '<div class="img-label">' + file[i].FileType + '</div>' +
                    '<img class="img-responsive multi-image" src="/doc.png">' +
                    '</div>';
            }
        }
        var lable = '<label class="control-label"> সংযুক্ত ফাইল</label>';
        $('#chargeFameAttachemntLable').append(lable);
        var container = '<div id="divImageListContainer" class="docs-pictures clearfix col-md-12">'+listItem+'</div>';
        $('#chargeFameAttachedFile').append(container);
    },


    deleteFile: function (event,fileId) {
        var data = fileId;
        var formURL = base_path +"/prosecution/deleteFileByFileID";
        $.confirm({
            resizable: false,
            height: 250,
            width: 400,
            modal: true,
            title: "  ফাইল  ডিলিট ",
            titleClass: "modal-header",
            content: "  ফাইলটি   ডিলিট  করতে চান  ?",
            buttons: {
                "না": function () {
                    // $(this).dialog("close");
                },
                "হ্যাঁ": function () {
                    $.ajax({
                        url: formURL, type: 'POST', data: {'fileID': data},
                        success: function (response) {
                            $.alert("ছবি ডিলিট সম্পন্ন হয়েছে ।", "ধন্যবাদ");
                            event.parentElement.remove();
                            // location.reload();
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            $.alert("ছবি ডিলিট সম্পন্ন হয়নি । পূনরায় চেষ্টা করুন ।", "অবহতিকরণ বার্তা");
                        }
                    });
                }
            }
        });
        return false;
    },

    printSeizureListReport:function()
    {
        var prosecutionId = $("#txtProsecutionID").val();
        var url = "/prosecution/showFormByProsecution?prosecutionId=" + prosecutionId;
        $.ajax({
            url: url,
            success: function (data) {
                if (data) {
                    if (data.seizurelist.length > 0) {
                        initDataFromProsecutor.setSeizureDataForReportGeneration(data);
                        var reportContent = $('#sizedList').html();
                        newwindow = window.open();
                        newdocument = newwindow.document;
                        newdocument.write(reportContent);
                        newdocument.close();

                        newwindow.print();
                        return false;
                    }
                }
            },
            error: function () {
            },
            complete: function () {
            }
        });
    },
    lawSectionConcatenation:function (lawsBrokenList) {
        var seizureLawSectionDescription="";
        var additionalText=" এবং ";
        var arrayLength=lawsBrokenList.length;

        for(var i=0;i<arrayLength;i++){
            if(arrayLength==(i+1)){
                additionalText="";
            }
            seizureLawSectionDescription+=lawsBrokenList[i].sec_description+" যা "+lawsBrokenList[i].sec_title+" -এর "+lawsBrokenList[i].sec_number+" ধারার লঙ্ঘন ও "+lawsBrokenList[i].sec_number+" ধারায় দণ্ডনীয় অপরাধ"+additionalText;

        }
        return seizureLawSectionDescription;
    },
    setSeizureDataForReportGeneration:function (caseInfo) {

        $('#caseNo').text(caseInfo.prosecution.case_no);
        $('#seizureDate').text(caseInfo.prosecution.date);
        $('#seizureDate').text(caseInfo.prosecution.date);
        $('#seizureDateAnother').text(caseInfo.prosecution.date);
        $('#seizureTime').text(initDataFromProsecutor.convertTimeToBangla(caseInfo.prosecution.time));
        $('#seizurePlace').text(caseInfo.prosecution.location);
        $('#seizureLawSectionDescription').text(initDataFromProsecutor.lawSectionConcatenation(caseInfo.lawsBrokenListWithProsecutor));
        //witness data populate
        $('#witness1Name').text(caseInfo.prosecution.witness1_name);
        $('#witness1FatherName').text(caseInfo.prosecution.witness1_custodian_name);
        $('#witness1Address').text(caseInfo.prosecution.witness1_address);

        $('#witness2Name').text(caseInfo.prosecution.witness2_name);
        $('#witness2FatherName').text(caseInfo.prosecution.witness2_custodian_name);
        $('#witness2Address').text(caseInfo.prosecution.witness2_address);
        //prosecutor data population
        $('#prosecutorName').text(caseInfo.prosecutorInfo[0].name_eng);
        $('#prosecutorDesignation').text(caseInfo.prosecutorInfo[0].designation_bng);
        $('#prosecutorOffice').text(caseInfo.prosecutorInfo[0].office_address);

        $('#prosecutionDate').text(caseInfo.prosecution.date);
        $('#magistrateName').text(caseInfo.magistrateInfo.name_eng);
        $('#magistrateDesignation').text(caseInfo.magistrateInfo.designation_bng);

        //set seizurelist info
        $("#seizuretable").find("tr:not(:first)").remove();
        $.each(caseInfo.seizurelist, function (i, item) {
            j = i + 1;
            $('#seizuretable').append(
                '<tr><td> ' + j + '</td>' +
                '<td> ' + item.stuff_description + '</td>' +
                '<td> ' + item.stuff_weight + '</td>' +
                '<td> ' + item.apx_value + '</td>' +
                '<td> ' + item.seizureitem_type_group + '</td>' +
                '</tr>');
        });


        if(caseInfo.prosecution.hasCriminal==1){
            $("#criminalInfoDiv").css("display","block");
            //set criminal info
            //$('#criminalInfo').empty();
            $("#criminalInfo").find("tr:not(:first)").remove();
            $.each(caseInfo.criminalDetails, function (i, criminal) {
                //criminal fingureprint/signature
                var criminalFingurePrint="";
                var imprint1 = criminal.imprint1 ? criminal.imprint1 : "";
                if (imprint1) {
                    criminalFingurePrint += '<img id=criminalImprint1 style="width:32%;"' +
                        'src=data:image/jpeg;base64,' + imprint1 +
                        '>';
                }
                j = i + 1;
                $('#criminalInfo').append(
                    '<tr><td> ' + j + '</td>' +
                    '<td> ' + criminal.name_bng + '</td>' +
                    '<td> ' + criminal.custodian_name + '</td>' +
                    '<td class="centertext"> ' + criminal.age + '</td>' +
                    '<td> ' + criminal.occupation + '</td>' +
                    '<td> ' + criminal.permanent_address + '</td>' +
                    '<td class="centertext"> ' + criminalFingurePrint + '</td>' +
                    '</tr>'
                );
            });
        }



        //Set Fingureprint/signature
        //witness fingureprint
        var witness1Fp = caseInfo.prosecution.witness1_imprint1 ? caseInfo.prosecution.witness1_imprint1 : "";
        var  witness2Fp= caseInfo.prosecution.witness2_imprint1 ? caseInfo.prosecution.witness2_imprint1 : "";
        if (witness1Fp) {
            var html_witness1_imprrint1 = "";
            html_witness1_imprrint1 += '<img id=sz_wt1_witness1_imprint1 width="12%" height="12%" style="padding-left: 15px"' +
                'src=data:image/jpeg;base64,' + witness1Fp +
                '>';

            $("#witness1Fp").append(html_witness1_imprrint1);
        }
        if (witness2Fp) {
            var html_witness2_imprrint1 = "";
            html_witness2_imprrint1 += '<img id=sz_wt2_witness2_imprint1 width="12%" height="12%" style="padding-left: 15px"' +
                'src=data:image/jpeg;base64,' + witness2Fp +
                '>';

            $("#witness2Fp").append(html_witness2_imprrint1);
        }
        //magistrate signature
        if (caseInfo.magistrateInfo.signature) {

            var path = "";
            var magistrateSignature = "";
            if (base_path != "") {
                path = base_path + '/public/upload/signature/';
            } else {
                path = '/upload/signature/';
            }
            magistrateSignature += '<img class="thumbnail" id=s_m_imprint1 ' +
                'src=' + path + caseInfo.magistrateInfo.signature +
                '>';
        }
        $("#magistrateSignature ").append(magistrateSignature);
        $("#MagistrateOfficeAddress ").text(caseInfo.magistrateInfo.location_str);
        $("#MagistrateLocation ").text(","+caseInfo.magistrateInfo.location_details);

    },
    convertTimeToBangla:function(time_in) {

        // Check correct time format and split into components
        var time = time_in.toString ().match (/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time_in];
        if (time.length > 1) { // If time format correct
            time = time.slice (1);  // Remove full string match value
            time[5] = +time[0] < 12 ? 'পূর্বাহ্ন  ' : 'মধ্যহ্ন'; // Set AM/PM
            time[0] = +time[0] % 12 || 12; // Adjust hours
        }
        return time[5] + "  " + time[0] + ":" + time[2] + " ঘটিকায়" ;
    }

};

$(document).ready(function () {
    initDataFromProsecutor.init();
});


