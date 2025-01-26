var populateProsecutionData={

    init:function () {
        var prosecutionID = $("#txtProsecutionID").val();
        populateProsecutionData.getAllProsecutionData(prosecutionID);
    },
    getAllProsecutionData:function (prosecutionId) {
        var URL =  "/prosecution/getCaseInfoByProsecutionId";
        $.ajax({ url: URL, type: 'POST', dataType: 'json', data: {'prosecutionId': prosecutionId},
            success: function (response) {
              
                if(response.caseInfo.fileContent.AllFile.length > 0)
                {
                    populateProsecutionData.setAllViewFile(response.caseInfo.fileContent.AllFile);
                }

                if(response.caseInfo.fileContent.OrderSheet.length > 0)
                {
                    populateProsecutionData.setOrderSheetFile(response.caseInfo.fileContent.OrderSheet);
                }

                // Set Case Number
                $('.case_no').html(response.caseInfo.prosecution.case_no);
                $('#caseNo').text("মামলা : "+response.caseInfo.prosecution.case_no);

                if(response.caseInfo.lawsBrokenList){
                    // Set Law Information In Tab-6
                    complaintForm.setLawDiv(response.caseInfo.lawsBrokenList);

                }
                // Set seizure order Context in Tab-6
                if(response.caseInfo.seizureOrderContext!=''){
                    complaintForm.seizureOrder=response.caseInfo.seizureOrderContext;
                    $('#seizure_order').val(response.caseInfo.seizureOrderContext);
                    $('#is_sizurelist').removeClass("hidden");
                    ordersheetForm.seizure_order_val=$('#seizure_order').val();
                }
                populateProsecutionData.populateAllData(response.caseInfo);

                if(response.caseInfo.prosecution.hasCriminal == 1){
                    $("#withCriminal").removeClass("hidden");
                    complaintForm.setCriminalDiv(response.caseInfo.criminalDetails);
                    populateProsecutionData.populateCriminalData(response.caseInfo);
                }else{
                    $('#prosecutionType').text("( আসামি ছাড়া )");
                    $("#criminalInfo").css("display","none");
                    $("#criminalConfess").css("display","none");
                }

            },
            error: function () {
                 alert("ত্রুটি", "অবহতিকরণ বার্তা");
            }
        });

    },
    setAllViewFile: function (file) {
        var listItem = '';
        for (var i = 0; i<file.length; i++)
        {
            var fileId = file[i].FileID;
            if(file[i].FileType =='IMAGE'){
                listItem += '<div class="col-xs-3 col-sm-3 col-md-3 col-lg-2 thumbnail" >' +
                    '<button type="button" class="img-button close" onclick="populateProsecutionData.deleteFile(this,' + fileId + ')">' +
                    '<span aria-hidden="true">&times;</span>' +
                    '</button>' +
                    '<div class="img-label">'+ file[i].FileType +'</div>'+
                    '<img class="img-responsive multi-image" src="/ecourt/'+file[i].FilePath+''+file[i].FileName+'">' +
                    '</div>';
            }
            else {
                listItem += '<div class="col-xs-3 col-sm-3 col-md-3 col-lg-2 thumbnail" >' +
                    '<button type="button" class="img-button close" onclick="populateProsecutionData.deleteFile(this,' + fileId + ')">' +
                    '<span aria-hidden="true">&times;</span>' +
                    '</button>' +
                    '<div class="img-label">'+ file[i].FileType +'</div>'+
                    '<img class="img-responsive multi-image" src="/doc.png">' +
                    '</div>';
            }

        }
        var lable = '<div class="form-group">' +
            '<label class="control-label"> সংযুক্ত ফাইল</label>' +
            '</div>';
        $('#accordionAttachemnt').prepend(lable);

        var container = '<div id="divImageListContainer" class="docs-pictures clearfix">'+listItem+'</div>';
        $('#allFileView').append(container);
    },


    setOrderSheetFile: function (file) {
        var listItem = '';
        for (var i = 0; i<file.length; i++)
        {
            var fileId = file[i].FileID;
            if(file[i].FileType =='IMAGE') {
                listItem += '<div class="col-xs-3 col-sm-3 col-md-3 col-lg-2 thumbnail" >' +
                    '<button type="button" class="img-button close" onclick="populateProsecutionData.deleteFile(this,' + fileId + ')">' +
                    '<span aria-hidden="true">&times;</span>' +
                    '</button>' +
                    '<div class="img-label">' + file[i].FileType + '</div>' +
                    '<img class="img-responsive multi-image" src="/ecourt/' + file[i].FilePath + '' + file[i].FileName + '">' +
                    '</div>';
            }
            else {
                listItem += '<div class="col-xs-3 col-sm-3 col-md-3 col-lg-2 thumbnail" >' +
                    '<button type="button" class="img-button close" onclick="populateProsecutionData.deleteFile(this,' + fileId + ')">' +
                    '<span aria-hidden="true">&times;</span>' +
                    '</button>' +
                    '<div class="img-label">' + file[i].FileType + '</div>' +
                    '<img class="img-responsive multi-image" src="/doc.png">' +
                    '</div>';
            }
        }
        var lable = '<label class="control-label"> সংযুক্ত ফাইল</label>';
        $('#orderSheetAttachemntLable').append(lable);
        var container = '<div id="divImageListContainer" class="docs-pictures clearfix">'+listItem+'</div>';
        $('#orderSheetAttachedFile').append(container);
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
    populateAllData:function (caseInfo) {

    
        var confessionDiv="";
        var seizureDiv="";
        var lawTitleGroup="";
        var sectionGroup="";
  
        //prosecutor info populate
        // $('#prosecutorName').text(caseInfo.prosecutorInfo[0].name_eng);
        $('#prosecutorName').text(caseInfo.prosecutorInfo.name_eng);
        $('#complaintDate').text(caseInfo.prosecution.date);
        $('#complaintPlace').text(caseInfo.prosecution.location);

        //law sec populate
        for(var i=0;i<caseInfo.lawsBrokenList.length;i++){
            lawTitleGroup+="-"+caseInfo.lawsBrokenList[i].sec_title;
            sectionGroup+=" *ধারাঃ "+caseInfo.lawsBrokenList[i].sec_number+" ,বিবরণ :"+caseInfo.lawsBrokenList[i].sec_description;
        }
        $('#lawTitle').text(lawTitleGroup);
        $('#lawSection').text(sectionGroup);

        //seizureList data populate
        if(caseInfo.seizurelist){
            for(var i=0;i<caseInfo.seizurelist.length;i++){
                seizureDiv+='<tr>' +
                    '<td  align="left">' +caseInfo.seizurelist[i].stuff_description+
                    '</td>' +
                    '<td  align="left">' +caseInfo.seizurelist[i].stuff_weight+
                    '</td>' +
                    '<td align="left">' +caseInfo.seizurelist[i].location+
                    '</td>' +
                    '<td align="left">' +caseInfo.seizurelist[i].seizureitem_type_group+
                    '</td>' +
                    '</tr>';
            }
            $('#seizureTable').append(seizureDiv);
        }else {
            $('#seizureTable').hide();
            $('#alterTextForSeizureList').show();
        }

    },
    populateCriminalData:function (caseInfo) {
        var criminalDiv="";
        //criminal info populate
        for(var i=0;i<caseInfo.criminalDetails.length;i++){
            criminalDiv+='<tr>' +
                '<td  align="left" >' +caseInfo.criminalDetails[i].name_bng+
                '</td>' +
                '<td  align="left" >' +caseInfo.criminalDetails[i].custodian_type+caseInfo.criminalDetails[i].custodian_name+
                '</td>' +
                '<td  align="left" >' +caseInfo.criminalDetails[i].mother_name+
                '</td>' +
                '<td  align="left"  >' +caseInfo.criminalDetails[i].present_address+
                '</td>' +
                '</tr>'
        }
        $('#criminalInfoTable').append(criminalDiv);

        //confession data populate
        complaintForm.setCriminalConfessionDiv(caseInfo.lawsBrokenList,caseInfo.criminalDetails,caseInfo.criminalConfession, caseInfo.criminalConfessionsByLaws);


    }

};

$(document).ready(function () {
    populateProsecutionData.init();
});