var confessionFromProsecutor={

    init:function () {
        var prosecutionID = $("#txtProsecutionID").val();
        confessionFromProsecutor.getCaseInformationByProsecutionIdWithProsecutor(prosecutionID);
    },
    getCaseInformationByProsecutionIdWithProsecutor:function (prosecutionId) {
        var URL =  "/prosecution/getCaseInfoByProsecutionId";
        $.ajax({ url: URL, type: 'POST', dataType: 'json', data: {'prosecutionId': prosecutionId},
            success: function (response) {
                confessionFromProsecutor.setConfessionDivWithProsecutor(response.caseInfo);
            },
            error: function () {
                $.alert("ত্রুটি", "অবহতিকরণ বার্তা");
            }
        });

    },
    setConfessionDivWithProsecutor:function (caseInfo) {
        console.log(caseInfo);
        $('.case_no').html(caseInfo.prosecution.case_no);
        $('#magistrateName').val(caseInfo.magistrateInfo.name_eng);
        $('#magistrateOffice').val(caseInfo.magistrateInfo.location_str);
        $('#magistrateDesignation').val(caseInfo.magistrateInfo.designation_bng);

        complaintForm.setCriminalConfessionDiv(caseInfo.lawsBrokenList,caseInfo.criminalDetails,caseInfo.criminalConfession, caseInfo.criminalConfessionsByLaws);
    }

};

$(document).ready(function () {
    confessionFromProsecutor.init();
});