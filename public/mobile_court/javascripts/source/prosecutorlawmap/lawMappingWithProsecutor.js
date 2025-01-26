var lawMap= {
    init: function () {
        var prosecutorId=$('#prosecutorId').val();
        if(prosecutorId){
            lawMap.getPreviousSelectedLawByProsecutorId(prosecutorId);
        }
    },
    addLaw:function () {
        var lawId = $("#ddlLaw1").val();
        var lawTitle = $("#ddlLaw1>option:selected").html();
        var isAvailable=lawMap.isLawAvailableInSelectedList(lawId);
        if(isAvailable=="false"){
            lawMap.appendLawInTable(lawId,lawTitle);
        }else {
            $.alert("এই আইনটি ইতিমধ্যেই যুক্ত করা হয়েছে ।","অবহতিকরণ বার্তা");
        }

    },
    initiateRowIndex: function () {
        $(".row-id").each(function (i) {
            $(this).text(i + 1);
        });
    },
    removeLaw:function (row) {
        // remove closest tr from table
        row.closest('tr').remove();
        // initiate row index
        this.initiateRowIndex();
    },
    getPreviousSelectedLawByProsecutorId:function (prosecutorId){
        var URL = "/law/getLawListByProsecutorId";
        $.ajax({ url: URL, type: 'POST', dataType: 'json', data: {'prosecutorId': prosecutorId},
            success: function (response) {
                lawMap.populateLawList(response);
            },
            error: function () {
                $.alert("ত্রুটি", "অবহতিকরণ বার্তা");
            }
        });
    },
    populateLawList:function (lawList) {
        for(var i=0;i<lawList.length;i++){
            var lawId=lawList[i].id;
            var lawTitle=lawList[i].name;
            lawMap.appendLawInTable(lawId,lawTitle);
        }

    },
    appendLawInTable:function (lawId,lawTitle) {
        $("#selectedLawTable tbody").append(' <tr>' +
            '                                <th scope="row" class="row-id"></th>' +
            '                                <td>'+ lawTitle +'</td>' +
            '                                <td><input name="lawid[]" type="hidden" value="'+ lawId +'"><button type="button" class="btn btn-danger" onclick="lawMap.removeLaw(this)"> বাতিল </button></td>' +
            '                              </tr>');
        // initiate row index
        this.initiateRowIndex();
    },
    isLawAvailableInSelectedList:function(singleLawId){
        var selectedLawlist=document.querySelectorAll('input[name="lawid[]"]');
        var flag="false";
        if(selectedLawlist){
            for (var i=0;i<selectedLawlist.length;i++){
                if(selectedLawlist[i].value==singleLawId){
                    flag="true";
                    break;
                }
            }
        }
        return flag;
    },
    selectAllLaw:function () {
        var URL = base_path + "/law/getLaw";
        $.ajax({ url: URL, type: 'POST', dataType: 'json',
            success: function (response) {
                $("#selectedLawTable tbody").empty();
                lawMap.populateLawList(response);

            },
            error: function () {
                $.alert("ত্রুটি", "অবহতিকরণ বার্তা");
            }
        });
    },
    removeAllLaw:function () {
        $("#selectedLawTable tbody").empty();
    }
};

$(document).ready(function() {
    lawMap.init();
});