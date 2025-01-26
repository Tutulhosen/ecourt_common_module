var  seizureForm ={
    init:function () {
        if($("#isSuomotu").val() == 0){
            seizureForm.setSeizureListInfoDataByProsecution($("#txtProsecutionID").val());
        }
    },
    save:function () {
        if(!validator.validateFields("#seizureform")){
             alert("সকল তথ্য সঠিক ভাবে দেওয়া হয়নি। ","অবহতিকরণ বার্তা");
            return false;
        }
        var formObj = $('#seizureform');

        // if (!$(formObj).valid()) {
        //     return false;
        // }
        var prosecutionId = $('#txtProsecutionID').val();
        var formURL = "/prosecution/savelist";
        var formData = new FormData(formObj[0]);
        formData.append( 'prosecutionId', prosecutionId);

        // $.confirm({
        //     resizable: false,
        //     height: 250,
        //     width: 400,
        //     modal: true,
        //     title: "জব্দতালিকা",
        //     titleClass: "modal-header",
        //     content: "ফরমটি সংরক্ষণ করতে চান ?",
        //     buttons: {
        //         "না": function () {
        //             // $(this).dialog("close");
        //         },
        //         "হ্যাঁ": function () {

                    Swal.fire({
                        title: "জব্দতালিকা",
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
                                success: function (response, textStatus, jqXHR) {
                                  

                                     console.log(response);
                                    if (response.flag == 'true') {

                                       
                                        Swal.fire({
                                            title: "অবহতিকরণ বার্তা!",
                                            text: "জব্দতালিকা  সফলভাবে সংরক্ষণ করা হয়েছে । ",
                                            icon: "success"
                                        });

                                        // Set tab index
                                        if(response.prosecutionInfo.is_suomotu==1){
                                            // Set seizure order Context in Tab-6
                                            if(response.seizureOrderContext){
                                                complaintForm.seizureOrder=response.seizureOrderContext;
                                                $('#seizure_order').val(response.seizureOrderContext);
                                                $('#is_sizurelist').removeClass("hidden");
                                            }
                                            prosecutionInit.setTabIndex(response.step);
                                        }else {
                                          
                                            var baseUrl = document.location.origin;
                                            window.location.href = baseUrl+'/prosecution/createsizedList/';
                                        }


                                    } else {
                                        $.alert("জব্দতালিকা সংরক্ষণ করা হয় নি ।","অবহতিকরণ বার্তা");
                                    }
                                }
                            });

                        }
                });
               
               
        //         }
        //     }
        // });
    },
    addSeizureListRow:function () {
    
        var counter_no_bng = new Array("০", "১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯");
        var table = $("#seizureListTable");
        var rows = $("#seizureListTable .row").length - 1;
        var counter = rows + 1;

        var counter_count = rows + 1;

        var deci_count = 0;
        var unit_count = -1;
        var unit_place = "";
        var deci_place = "";

        var counter_number_bng = "";

        if (parseInt(counter_count / 10) >= 1) {
            for (x=1; parseInt(counter_count / (10 * x)) >= 1; x++) {
                deci_count++;
            }
        }

        unit_count = counter_count % 10;
        if (unit_count == 9) {
            deci_count = 1;
            unit_count = -1;
        }

        deci_place = counter_no_bng[deci_count];
        if (deci_count == 0) {
            deci_place = "";
        }
        unit_place = counter_no_bng[(unit_count+1)];

        counter_number_bng = "" + deci_place + "" + unit_place;

        var rowTemplate = '<div class="row">' +
            '<div class="col-sm-1">' +
            '<div class="form-group">' +
            '<span>'+counter_number_bng+'</span>' +
            '</div>' +
            '</div>' +
            '<div class="col-sm-2">' +
            '<div class="form-group">' +
            '<input class="form-control" name="seizure[' + counter + '][1]" id="seizure_' + counter + '_1"  value="" type="text" />' +
            '</div>' +
            '</div>' +
            '<div class="col-sm-2">' +
            '<div class="form-group">' +
            '<input class="form-control" name="seizure[' + counter + '][2]"  id="seizure_' + counter + '_2"   value="" type="text" />' +
            '</div>' +
            '</div>' +
            '<div class="col-sm-2">' +
            '<div class="form-group">' +
            '<input class="form-control" name="seizure[' + counter + '][3]" id="seizure_' + counter + '_3"  value="" type="text" placeholder="শুধুমাত্র সংখ্যাটি লিখুন "/>' +
            '</div>' +
            '</div>' +
            '	    <div class="col-sm-3">' +
            '			<select class="form-control" name="seizure['+(counter)+'][4]"  id="seizure_' + counter + '_4"  >' +
            '			<option>বাছাই করুন...</option>' +
            '			</select>' +
            '		</div>' +
            '<div class="col-sm-2">' +
            '<div class="form-group">' +
            '<input class="form-control" name="seizure[' + counter + '][5]"  id="seizure_' + counter + '_5"   value=""  type="text" />' +
            '</div>' +
            '</div>' +
            '<div class="col-sm-1">' +
            '<div class="form-group">' +
            '<input type="button" value="-" onclick="seizureForm.removeRow('+ counter +');" id="delete_' + counter + '" class="btn btn-danger" />' +
            '</div>' +
            '</div>' +
            '</div>';


        table.append(rowTemplate);
        $("#delete_" + (counter-1)).hide();

        $('#seizure_'+ (counter)+'_4').html($('#dd_seizure').html());
      
    },
    removeRow:function (rowIndex) {
        $("#seizureListTable .row").eq(rowIndex).remove();
        if (rowIndex > 1) {
            $("#delete_" + (rowIndex-1)).show();
        }
    },
    setSeizureListData:function (seizureListArray) {
        
        for(var i=0;i<seizureListArray.length;i++){
            $('#seizure_'+i+'_1').val(seizureListArray[i]['stuff_description']);
            $('#seizure_'+i+'_2').val(seizureListArray[i]['stuff_weight']);
            $('#seizure_'+i+'_3').val(seizureListArray[i]['apx_value']);
            $('#seizure_'+i+'_4').val(seizureListArray[i]['seizureitem_type_id']).change();
            $('#seizure_'+i+'_5').val(seizureListArray[i]['hints']);
            if(seizureListArray.length > i+1){
                seizureForm.addSeizureListRow();
            }

        }

    },
    setSeizureListInfoDataByProsecution: function (prosecutionID) {
        var URL = "/prosecution/getCaseInfoByProsecutionId";
        $.ajax({ url: URL, type: 'POST', dataType: 'json', data: {'prosecutionId': prosecutionID},
            success: function (response) {
                // Set Case Number
                $('.case_no').html(response.caseInfo.prosecution.case_no);

                // Set seizure List information
                if(response.caseInfo.seizurelist){
                    seizureForm.setSeizureListData(response.caseInfo.seizurelist);
                }

            },
            error: function () {
                $.alert("ত্রুটি", "অবহতিকরণ বার্তা");
            }
        });
    }
};

$(document).ready(function() {
    seizureForm.init();
});

