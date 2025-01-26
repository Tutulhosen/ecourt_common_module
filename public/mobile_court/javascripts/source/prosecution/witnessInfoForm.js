var witnessInfoForm=  {
    init:function () {
        
    },

    getWitnessesInfo: function () {
        var witnesses = {};

        witnesses.prosecutionID = $('#txtProsecutionID').val();
        //finger print
        witnesses.witness1_LEFT_THUMB_BMP = $('#witness1_LEFT_THUMB_BMP').val();
        witnesses.witness1_RIGHT_THUMB_BMP = $('#witness1_RIGHT_THUMB_BMP').val();
        witnesses.witness1_repeat_crime = $('#witness1_repeat_crime').val();
        witnesses.witness1_LEFT_THUMB = $('#witness1_LEFT_THUMB').val();
        witnesses.witness1_RIGHT_THUMB = $('#witness1_RIGHT_THUMB').val();

        witnesses.witness2_LEFT_THUMB_BMP = $('#witness2_LEFT_THUMB_BMP').val();
        witnesses.witness2_RIGHT_THUMB_BMP = $('#witness2_RIGHT_THUMB_BMP').val();
        witnesses.witness2_repeat_crime = $('#witness2_repeat_crime').val();
        witnesses.witness2_LEFT_THUMB = $('#witness2_LEFT_THUMB').val();
        witnesses.witness2_LEFT_THUMB = $('#witness2_LEFT_THUMB').val();


        witnesses.witness1_name = $('#witness1_name').val();
        witnesses.witness1_custodian_name = $('#witness1_custodian_name').val();
        witnesses.witness1_mobile_no = $('#witness1_mobile_no').val();
        witnesses.witness1_mother_name = $('#witness1_mother_name').val();
        witnesses.witness1_age = $('#witness1_age').val();
        witnesses.witness1_nationalid = $('#witness1_nationalid').val();
        witnesses.witness1_address = $('#witness1_address').val();

        witnesses.witness2_name = $('#witness2_name').val();
        witnesses.witness2_custodian_name = $('#witness2_custodian_name').val();
        witnesses.witness2_mobile_no = $('#witness2_mobile_no').val();
        witnesses.witness2_mother_name = $('#witness2_mother_name').val();
        witnesses.witness2_age = $('#witness2_age').val();
        witnesses.witness2_nationalid = $('#witness2_nationalid').val();
        witnesses.witness2_address = $('#witness2_address').val();

        return witnesses;
    },
    setWitnessesInfo: function (witnesses) {

        // $('#txtProsecutionID').val(witnesses.prosecutionID);

         $('#witness1_name').val(witnesses.witness1_name);
         $('#witness1_custodian_name').val(witnesses.witness1_custodian_name);
         $('#witness1_mobile_no').val(witnesses.witness1_mobile_no);
         $('#witness1_mother_name').val(witnesses.witness1_mother_name);
         $('#witness1_age').val(witnesses.witness1_age);
         $('#witness1_nationalid').val(witnesses.witness1_nationalid);
         $('#witness1_address').val(witnesses.witness1_address);

         $('#witness2_name').val(witnesses.witness2_name);
         $('#witness2_custodian_name').val(witnesses.witness2_custodian_name);
         $('#witness2_mobile_no').val(witnesses.witness2_mobile_no);
         $('#witness2_mother_name').val(witnesses.witness2_mother_name);
         $('#witness2_age').val(witnesses.witness2_age);
         $('#witness2_nationalid').val(witnesses.witness2_nationalid);
         $('#witness2_address').val(witnesses.witness2_address);
         if(witnesses.witness1_imprint1){
             document.getElementById("iLEFT_THUMB_W_1").src = "data:image/bmp;base64,"+witnesses.witness1_imprint1;
             document.getElementById("iRIGHT_THUMB_W_1").src = "data:image/bmp;base64,"+witnesses.witness1_imprint2;
         }
         if(witnesses.witness2_imprint1){
             document.getElementById("iLEFT_THUMB_W_2").src = "data:image/bmp;base64,"+witnesses.witness2_imprint1;
             document.getElementById("iRIGHT_THUMB_W_2").src = "data:image/bmp;base64,"+witnesses.witness2_imprint2;
         }




    },

    save:function () {
        if(!validator.validateFields("#suomotcourtwitnessform")){
             alert("সকল তথ্য সঠিক ভাবে দেওয়া হয়নি। ","অবহতিকরণ বার্তা");
            return false;
        }
        var model = witnessInfoForm.getWitnessesInfo();

        model.prosecutionID = $('#txtProsecutionID').val();
        model.selectMagistrateId=$('#selectMagistrateId').val();
        model.selectMagistrateCourtId=$('.selectMagistrateCourtId').val();

        var formURL = "/prosecution/createProsecutionWitness";

        // $.confirm({
            // resizable: false,
            // height: 250,
            // width: 400,
            // modal: true,
            // title: "সাক্ষীর তথ্য",
            // titleClass: "modal-header",
            // content: "ফরমটি সংরক্ষণ করতে চান ?",
            // buttons: {
            //     "না": function () {
            //         // $(this).dialog("close");
            //     },
            //     "হ্যাঁ": function () {
                    // $.ajax({
                    //     url: formURL,
                    //     type: 'POST',
                    //     data: {'data': model},
                    //     dataType: 'json',
                    //     mimeType: "multipart/form-data",
                    //     beforeSend: function () {
                    //     },
                    //     success: function (response, textStatus, jqXHR) {
                    //         if (response.flag == true) {
                    //             $.alert("সাক্ষীর তথ্য সংরক্ষণ করা হয়েছে । ","অবহতিকরণ বার্তা");
                    //             // Set prosecution Id
                    //             $('#txtProsecutionID').val(response.prosecutionId);
                    //             // Set tab index
                    //             prosecutionInit.setTabIndex(response.step);
                    //             //Only for prosecution with prosecutor without criminal
                    //             if(response.prosecution.is_suomotu==0 && response.prosecution.hasCriminal==0){

                    //                 // Disable Magistrate select Section for (With Prosecutor)
                    //                 magistrateForm.setMagistrateInfo(response.magistrateInfo);
                    //                 //set magistrate divid and zillaid
                    //                 eMobileLocation.populateLocation(999, response.prosecution.location_type, response.prosecution.divid, response.prosecution.zillaId, response.prosecution.upazilaId,response.prosecution.geo_citycorporation_id,response.prosecution.geo_metropolitan_id,response.prosecution.geo_thana_id);
                    //                 //disable divid and zillaid
                    //                 complaintForm.disableDivisionZillaWithProsecutor();
                    //             }
                    //             if(response.prosecution.is_suomotu==0){
                    //                 $("#withOutProsecutor").html('');
                    //             }else{
                    //                 $("#withProsecutor").html('');
                    //                 $('.case_no').html(response.case_no);
                    //                 $('#case_no').val(response.case_no);
                    //             }

                    //         } else {
                    //             $.alert("তথ্য অসম্পূর্ন থাকায় আবেদনটি গ্রহণ করা হয়নি ।  পূনরায় চেষ্টা করুন ।  ", "ধন্যবাদ");
                    //         }
                    //     },
                    //     error: function (jqXHR, textStatus, errorThrown) {
                    //         $.alert("সাক্ষীর তথ্য সংরক্ষণ হয়নি। ", "অবহতিকরণ বার্তা");
                    //     }
                    // });
            //     }
            // }
        // });

        Swal.fire({
            title: "সাক্ষীর তথ্য",
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
                    data: {'data': model},
                    dataType: 'json',
                    mimeType: "multipart/form-data",
                    beforeSend: function () {
                    },
                    success: function (response, textStatus, jqXHR) {
                      
                        console.log( response.prosecutionId);
                        if (response.flag == true) {
                            $('.selectMagistrateCourtId').val(response.selectMagistrateCourtId);
                            Swal.fire({
                                title: "অবহতিকরণ বার্তা!",
                                text: "অভিযুক্তের তথ্য সংরক্ষণ করা হয়েছে। ",
                                icon: "success"
                            });

                            $('#txtProsecutionID').val(response.prosecutionId);
                            // Set tab index
                            prosecutionInit.setTabIndex(response.step);
                        

                            if(response.prosecution.is_suomotu==0 && response.prosecution.hasCriminal==0){
                               console.log('laksdjflk');
                                // Disable Magistrate select Section for (With Prosecutor)
                                magistrateForm.setMagistrateInfo(response.magistrateInfo);
                                //set magistrate divid and zillaid
                                eMobileLocation.populateLocation(999, response.prosecution.location_type, response.prosecution.divid, response.prosecution.zillaId, response.prosecution.upazilaId,response.prosecution.geo_citycorporation_id,response.prosecution.geo_metropolitan_id,response.prosecution.geo_thana_id);
                                //disable divid and zillaid
                                complaintForm.disableDivisionZillaWithProsecutor();
                            }
                            if(response.prosecution.is_suomotu==0){
                                $("#withOutProsecutor").html('');
                            }else{
                                $("#withProsecutor").html('');
                                $('.case_no').html(response.case_no);
                                $('#case_no').val(response.case_no);
                            }

                        } else {
                            Swal.fire({
                                title: "ধন্যবাদ",
                                text: "তথ্য অসম্পূর্ন থাকায় আবেদনটি গ্রহণ করা হয়নি ।  পূনরায় চেষ্টা করুন ।  ",
                                icon: "success"
                            });
                            // $.alert("তথ্য অসম্পূর্ন থাকায় আবেদনটি গ্রহণ করা হয়নি ।  পূনরায় চেষ্টা করুন ।  ", "ধন্যবাদ");
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        Swal.fire({
                            title: "অবহতিকরণ বার্তা",
                            text: "সাক্ষীর তথ্য সংরক্ষণ হয়নি। ",
                            icon: "success"
                        });
                       
                    }
                });

            }
        });

    }
};
$(document).ready(function() {
    witnessInfoForm.init();
});