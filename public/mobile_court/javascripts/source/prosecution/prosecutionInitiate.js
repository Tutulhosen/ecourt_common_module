var prosecutionInit = {
    init: function () {
 
        $("#case_no_sr").tooltip();
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            e.target // newly activated tab
            e.relatedTarget // previous active tab
            $(".selectDropdown").select2();
        });
        var prosecutionID = $("#txtProsecutionID").val();
        prosecutionInit.populateUI(prosecutionID);
    },

    /**
     * load/initialize controls and populate with existing values
     * @param prosecutionID
     */
    populateUI: function (prosecutionID) {
        
        if (prosecutionID) {
            prosecutionInit.setCaseInfoDataByProsecution(prosecutionID);
            // load existing record
        } else {
            // init location for new entry in criminal Form (First Div)
            eMobileLocation.init(0);
            // init location for Complaint form
            eMobileLocation.init(999);
            // init law section for Complaint Form
            lawSelector.init(1, null, null);
        }
    },
    setCaseInfoDataByProsecution: function (prosecutionID) {
        var allResponse = complaintForm.getCaseInfoDataByProsecution(prosecutionID);
        var response = allResponse.caseInfo;
        if(response){
            if(response.prosecution.is_suomotu==0){
                $("#withOutProsecutor").html('');

                if(response.prosecution.case_status>3){
                    prosecutionInit.moveToFirstTabProsecutor();
                }else {
                    prosecutionInit.setTabIndex(response.prosecution.case_status);
                }
                //Disable Magistrate select Section for (With Prosecutor)
                if(response.magistrateInfo){
                    magistrateForm.setMagistrateInfo(response.magistrateInfo);
                }

                if(response.prosecution.case_status <= 3){
                    //set magistrate divid and zillaid
               
                    eMobileLocation.populateLocation(999, response.prosecution.location_type, response.prosecution.divid, response.prosecution.zillaId, response.prosecution.upazilaId,response.prosecution.geo_citycorporation_id,response.prosecution.geo_metropolitan_id,response.prosecution.geo_thana_id);
                    lawSelector.init(1, null, null);
                }
                //disable divid and zillaid
                complaintForm.disableDivisionZillaWithProsecutor();

                //populate lawsBrokenListWithProsecutor info
                if(response.lawsBrokenListWithProsecutor){
                    // Set Complaint Information
                    complaintForm.setComplaintInformation(response.lawsBrokenListWithProsecutor,response.prosecution);
                }
            }else {
              
                $("#withProsecutor").html('');

                if(response.prosecution.case_status <= 3){
                    // setting Complaint form location
                    eMobileLocation.init(999);
                    // init law section for Complaint Form
                    lawSelector.init(1, null, null);
                }

                if(response.lawsBrokenList){
                    // Set Complaint Information
                    complaintForm.setComplaintInformation(response.lawsBrokenList,response.prosecution);
                    // Set Law Information In Tab-6
                    complaintForm.setLawDiv(response.lawsBrokenList);
                    // Set criminal confession from with info
                    if(response.prosecution.hasCriminal==1){
                        complaintForm.setCriminalConfessionDiv(response.lawsBrokenList,response.criminalDetails,response.criminalConfession, response.criminalConfessionsByLaws);
                    }
                }
                // Set seizure List information
                if(response.seizurelist){
                    seizureForm.setSeizureListData(response.seizurelist);
                }
                // Set seizure order Context in Tab-6
                if(response.seizureOrderContext != ''){
                    complaintForm.seizureOrder=response.seizureOrderContext;
                    $('#seizure_order').val(response.seizureOrderContext);
                    $('#is_sizurelist').removeClass("hidden");
                    ordersheetForm.seizure_order_val=$('#seizure_order').val();
                }
            }

            // Load Criminal Info Form
            if(response.prosecution.hasCriminal==1) {
                for (var j = 1; j < response.criminalDetails.length; j++) {
                    criminal.addMoreCriminalInfo(false);
                }
            }
            // Set Case Number
            $('.case_no').html(allResponse.case_no);
            $('#case_no').val(allResponse.case_no);

            // Set Witness Information
            witnessInfoForm.setWitnessesInfo(response.prosecution);
            // Set tab index
            prosecutionInit.setTabIndex(response.prosecution.case_status);

            // Set Criminals information
            if(response.prosecution.hasCriminal==1) {
                $("#withCriminal").removeClass("hidden");
                criminal.setCriminalForm(response.criminalDetails);
                // Set criminal form info in Tab-6
                complaintForm.setCriminalDiv(response.criminalDetails);
            }

            if(response.fileContent.ChargeFame.length > 0)
            {
                prosecutionInit.setChargeFameFile(response.fileContent.ChargeFame);
            }
            if(response.fileContent.CriminalConfession .length > 0)
            {
                prosecutionInit.setCriminalConfessionFile(response.fileContent.CriminalConfession );
            }
            if(response.fileContent.OrderSheet.length > 0)
            {
                prosecutionInit.setOrderSheetFile(response.fileContent.OrderSheet);
            }
        }
    },
    setChargeFameFile: function (file) {
        var listItem = '';
        for (var i = 0; i<file.length; i++)
        {
            var fileId = file[i].FileID;
            if(file[i].FileType =='IMAGE') {
                listItem += '<div class="col-xs-3 col-sm-3 col-md-3 col-lg-2 thumbnail" >' +
                    '<button type="button" class="img-button close" onclick="prosecutionInit.deleteFile(this,' + fileId + ')">' +
                    '<span aria-hidden="true">&times;</span>' +
                    '</button>' +
                    '<div class="img-label">' + file[i].FileType + '</div>' +
                    '<img class="img-responsive multi-image" src="/ecourt/' + file[i].FilePath + '' + file[i].FileName + '">' +
                    '</div>';
            }
            else{
                listItem += '<div class="col-xs-3 col-sm-3 col-md-3 col-lg-2 thumbnail" >' +
                    '<button type="button" class="img-button close" onclick="prosecutionInit.deleteFile(this,' + fileId + ')">' +
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
    setCriminalConfessionFile: function (file) {
        var listItem = '';
        for (var i = 0; i<file.length; i++)
        {
            var fileId = file[i].FileID;
            if(file[i].FileType =='IMAGE') {
                listItem += '<div class="col-xs-3 col-sm-3 col-md-3 col-lg-2 thumbnail" >' +
                    '<button type="button" class="img-button close" onclick="prosecutionInit.deleteFile(this,' + fileId + ')">' +
                    '<span aria-hidden="true">&times;</span>' +
                    '</button>' +
                    '<div class="img-label">' + file[i].FileType + '</div>' +
                    '<img class="img-responsive multi-image" src="/ecourt/' + file[i].FilePath + '' + file[i].FileName + '">' +
                    '</div>';
            }else{
                listItem += '<div class="col-xs-3 col-sm-3 col-md-3 col-lg-2 thumbnail" >' +
                    '<button type="button" class="img-button close" onclick="prosecutionInit.deleteFile(this,' + fileId + ')">' +
                    '<span aria-hidden="true">&times;</span>' +
                    '</button>' +
                    '<div class="img-label">' + file[i].FileType + '</div>' +
                    '<img class="img-responsive multi-image" src="/doc.png">' +
                    '</div>';
            }
        }
        var lable = '<label class="control-label"> সংযুক্ত ফাইল</label>';
        $('#criminalConfessionAttachemntLable').append(lable);
        var container = '<div id="divImageListContainer" class="docs-pictures clearfix">'+listItem+'</div>';
        $('#criminalConfessionAttachedFile').append(container);
    },
    setOrderSheetFile: function (file) {
        var listItem = '';
        for (var i = 0; i<file.length; i++)
        {
            var fileId = file[i].FileID;
            if(file[i].FileType =='IMAGE') {
                listItem += '<div class="col-xs-3 col-sm-3 col-md-3 col-lg-2 thumbnail" >' +
                    '<button type="button" class="img-button close" onclick="prosecutionInit.deleteFile(this,' + fileId + ')">' +
                    '<span aria-hidden="true">&times;</span>' +
                    '</button>' +
                    '<div class="img-label">' + file[i].FileType + '</div>' +
                    '<img class="img-responsive multi-image" src="/ecourt/' + file[i].FilePath + '' + file[i].FileName + '">' +
                    '</div>';
            }
            else{
                listItem += '<div class="col-xs-3 col-sm-3 col-md-3 col-lg-2 thumbnail" >' +
                    '<button type="button" class="img-button close" onclick="prosecutionInit.deleteFile(this,' + fileId + ')">' +
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

    setTabIndex: function (step) {
        if (step == 2) { // witness
            $('#tab-2 a').tab('show');
        } else if (step == 3) {  // charge frame
            $('#tab-3 a').tab('show');
        } else if (step == 4) {  // sezure list
            $('#tab-4 a').tab('show');
        } else if (step == 5) {  // confession
            $('#tab-5 a').tab('show');
        } else { // order sheet
            $('#tab-6 a').tab('show');
        }
    },
    moveToFirstTabProsecutor:function () {
        $("#tab-0 a").tab('show');
    }
};

$(document).ready(function () {
    prosecutionInit.init();
});
