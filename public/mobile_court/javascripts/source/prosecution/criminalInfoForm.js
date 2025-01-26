var criminal = {

    regex: /^(.+?)(\d+)$/i,
    cloneIndex: $(".criminalInfo").length,
    cloneCriminalForm: $('#addCriminalBlock .criminalInfo:first').clone(),

    init: function () {
       
        $("#withCriminal").css("display","block");
        $(".selectDropdown").select2();
        // $(document).on('click', $("#do_address_0"), function () {
        //     doParmanentAddress(this.value,0);
        // });
        // $('#iLEFT_THUMB_0').click(function () {
        //     fingurePrint.captureFP_criminal(1,0);
        // });
        // $('#iRIGHT_THUMB_0').click(function () {
        //     fingurePrint.captureFP_criminal(3,0);
        // });
        // $('#checkfingureprint_0').click(function () {
        //     fingurePrint.signaturetest(0);
        // });
    },

    populateModel: function () {

        var model = {};
        model.prosecutionID = $('#txtProsecutionID').val();
        model.selectMagistrateId=$('#selectMagistrateId').val();
        model.selectMagistrateCourtId=$('.selectMagistrateCourtId').val();
        model.criminals = [];

        $('.criminalInfo').each(function (index, criminalContainer) {
            model.criminals.push(criminal.getCriminalInfo(index, criminalContainer));
        });

        return model;
    },

    getCriminalInfo: function (index, criminalContainer) {
        var criminal = {};
        criminal.criminalID = $('#criminal_id_' + index).val();
        // criminal.fingerprintID = $('#fingerprint_id_' + index).val();
        //fingure print section
        criminal.LEFT_THUMB_BMP=$('#criminal_LEFT_THUMB_BMP_' + index).val();
        criminal.RIGHT_THUMB_BMP=$('#criminal_RIGHT_THUMB_BMP_' + index).val();
        criminal.LEFT_THUMB=$('#criminal_LEFT_THUMB_' + index).val();
        criminal.RIGHT_THUMB=$('#criminal_RIGHT_THUMB_' + index).val();
        criminal.m_user_type=$('#criminal_m_user_type_' + index).val();
        criminal.m_user_id=$('#criminal_m_user_id_' + index).val();
        criminal.repeat_crime=$('#criminal_repeat_crime_' + index).val();

        criminal.name = $('#criminal_name_' + index).val();
        criminal.custodian_name = $('#criminal_custodian_name_' + index).val();
        criminal.custodian_type = $('#custodian_type_' + index).val();
        criminal.mother_name = $('#mother_name_' + index).val();
        criminal.national_id = $('#national_id_' + index).val();
        criminal.email = $('#email_' + index).val();
        criminal.age = $('#age_' + index).val();
        criminal.gender = $('#gender_' + index).val();
        criminal.mobile_no = $('#mobile_no_' + index).val();
        criminal.occupation = $('#occupation_' + index).val();
        criminal.organization_name = $('#organization_name_' + index).val();
        criminal.trade_no = $('#trade_no_' + index).val();
        criminal.divid = $('#' + eMobileLocation.ddlDivision + index).val();
        criminal.zillaId = $('#' + eMobileLocation.ddlZilla + index).val();

        var type = eMobileLocation.getLocationType(index);
        criminal.locationtype = type;
        if (type === eMobileLocation.locationType.Upazilla) {
            criminal.upazilaid = $('#' + eMobileLocation.ddlUpazilla + index).val();
        }
        if (type === eMobileLocation.locationType.CityCorporation) {
            criminal.geo_citycorporation_id = $('#' + eMobileLocation.ddlCityCorporation + index).val();
        }
        if (type === eMobileLocation.locationType.Metropolitan) {
            criminal.geo_metropolitan_id = $('#' + eMobileLocation.ddlMetropolitan + index).val();
            criminal.geo_thana_id = $('#' + eMobileLocation.ddlThana + index).val();
        }

        criminal.permanent_address = $('#permanent_address_' + index).val();
        criminal.do_address = $('#do_address_' + index).val();
        criminal.present_address = $('#present_address_' + index).val();
        
        return criminal;
    },

    save: function () {
        if(!validator.validateFields("#suomotcourtcriminalform")){
             alert("সকল তথ্য সঠিক ভাবে দেওয়া হয়নি। ","অবহতিকরণ বার্তা");
            return false;
        }
        var model = criminal.populateModel();
        var url = '/prosecution/createProsecutionCriminalBymagistrate';
 
        // $.confirm({
        //     resizable: false,
        //     height: 250,
        //     width: 400,
        //     modal: true,
        //     title: "আসামির তথ্য",
        //     titleClass: "modal-header",
        //     content: "ফরমটি সংরক্ষণ করতে চান ?",
        //     buttons: {
        //         "না": function () {
        //             // $(this).dialog("close");
        //         },
        //         "হ্যাঁ": function () {
        //             $.ajax({
        //                 url: url,
        //                 type: 'POST',
        //                 dataType: 'json',
        //                 data: {'data': model},
        //                 mimeType: "multipart/form-data",
        //                 success: function (response, textStatus, jqXHR) {
        //                     if (response.flag == 'true') {

        //                         $.alert("অভিযুক্তের তথ্য সংরক্ষণ করা হয়েছে। ", "অবহতিকরণ বার্তা");

        //                         // Disable Magistrate select Section for (With Prosecutor)
        //                         if(response.caseInfo.prosecution.is_suomotu == 0 ){
        //                             // Disable Magistrate select Section for (With Prosecutor)
        //                             magistrateForm.setMagistrateInfo(response.caseInfo.magistrateInfo);
        //                             //set magistrate divid and zillaid
        //                             eMobileLocation.populateLocation(999, response.caseInfo.prosecution.location_type, response.caseInfo.prosecution.divid, response.caseInfo.prosecution.zillaId, response.caseInfo.prosecution.upazilaId,response.caseInfo.prosecution.geo_citycorporation_id,response.caseInfo.prosecution.geo_metropolitan_id,response.caseInfo.prosecution.geo_thana_id);
        //                             //disable divid and zillaid
        //                             complaintForm.disableDivisionZillaWithProsecutor();
        //                             $("#withOutProsecutor").html('');
        //                         }else {
        //                             $("#withProsecutor").html('');
        //                             $("#withCriminal").removeClass("hidden");
        //                         }

        //                         // Set prosecution Id
        //                         $('#txtProsecutionID').val(response.caseInfo.prosecution.id);

        //                         // Generate Case Number list
        //                         $('.case_no').html(response.case_no);
        //                         $('#case_no').val(response.case_no);
        //                         // Set criminal confession from with info
        //                         // criminal.setConfessionDiv(response.caseInfo.criminalDetails);

        //                         // Set criminal form info in Tab-6
        //                         complaintForm.setCriminalDiv(response.caseInfo.criminalDetails);

        //                         // Set Criminal Id
        //                         criminal.setCriminalId(response.caseInfo.criminalDetails);

        //                         // Set tab index
        //                         prosecutionInit.setTabIndex(response.step);

        //                     } else {
        //                         $.alert("তথ্য অসম্পূর্ন থাকায় আবেদনটি গ্রহণ করা হয়নি ।  পূনরায় চেষ্টা করুন ।  ", "ধন্যবাদ");
        //                     }
        //                 },
        //                 error: function (jqXHR, textStatus, errorThrown) {
        //                     $.alert("অভিযুক্তের তথ্য সংরক্ষণ হয়নি। ", "অবহতিকরণ বার্তা");
        //                 }
        //             });
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
                    url: url,
                    type: 'POST',
                    dataType: 'json',
                    data: {'data': model},
                    mimeType: "multipart/form-data",
                    success: function (response, textStatus, jqXHR) {

                     
                      console.log(response.selectMagistrateCourtId)
                 
                       


                        if (response.flag == 'true') {

                            Swal.fire({
                                title: "অবহতিকরণ বার্তা!",
                                text: "অভিযুক্তের তথ্য সংরক্ষণ করা হয়েছে। ",
                                icon: "success"
                            });
                            
                            $('.selectMagistrateCourtId').val(response.selectMagistrateCourtId);
                            // Disable Magistrate select Section for (With Prosecutor)
                            if(response.caseInfo.prosecution.is_suomotu == 0 ){
                                // console.log( response.caseInfo.prosecution.divid);
                                // Disable Magistrate select Section for (With Prosecutor)
                                magistrateForm.setMagistrateInfo(response.caseInfo.magistrateInfo);
                                magistrateForm.showMagistrate(response.caseInfo.magistrateInfo.zillaId);
                                
                                //set magistrate divid and zillaid
                                eMobileLocation.populateLocation(999, response.caseInfo.prosecution.location_type, response.caseInfo.prosecution.divid, response.caseInfo.prosecution.zillaId, response.caseInfo.prosecution.upazilaId,response.caseInfo.prosecution.geo_citycorporation_id,response.caseInfo.prosecution.geo_metropolitan_id,response.caseInfo.prosecution.geo_thana_id);
                                //disable divid and zillaid
                                complaintForm.disableDivisionZillaWithProsecutor();
                                $("#withOutProsecutor").html('');
                            }else {
                                $("#withProsecutor").html('');
                                $("#withCriminal").removeClass("hidden");
                            }
                      
                            // Set prosecution Id
                            $('#txtProsecutionID').val(response.caseInfo.prosecution.id);

                            // // Generate Case Number list
                            $('.case_no').html(response.case_no);
                            $('#case_no').val(response.case_no);
                            // Set criminal confession from with info
                          
                            // criminal.setConfessionDiv(response.caseInfo.criminalDetails);

                
                            // Set criminal form info in Tab-6
                            complaintForm.setCriminalDiv(response.caseInfo.criminalDetails);

                            // Set Criminal Id
                            criminal.setCriminalId(response.caseInfo.criminalDetails);
                        
                            // Set tab index
                            prosecutionInit.setTabIndex(response.step);

                        } else {
                             alert("তথ্য অসম্পূর্ন থাকায় আবেদনটি গ্রহণ করা হয়নি ।  পূনরায় চেষ্টা করুন ।  ", "ধন্যবাদ");
                        }


                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                         alert("অভিযুক্তের তথ্য সংরক্ষণ হয়নি। ", "অবহতিকরণ বার্তা");
                    }
                });
             

           
            }
          });
        // save
    },

    setCriminalId:function (criminalDetails) {
        var myStringArray = criminalDetails;
        var arrayLength = myStringArray.length;
        for (var i = 0; i < arrayLength; i++) {
            $("#criminal_id_" + i).val(myStringArray[i].id);
        }

    },

    toggleDiv: function (e) {

        e.next('.panel-body').toggle();
        if (e.children().find('i').hasClass('fa-minus')) {
            e.children().find('i').removeClass('fa-minus').addClass('fa-plus');
        }
        else {
            e.find('i').removeClass('fa-plus').addClass('fa-minus');
        }
    },

    addMoreCriminalInfo: function (initiateFalg) {

        var cloneCriminal = criminal.cloneCriminalForm.clone(true);
        
        var cloneIndex = criminal.cloneIndex;
        var regex = criminal.regex;
        var section = cloneCriminal.find('input:text,input:checkbox, input:radio,input:hidden, select, table,div,textarea,a,img,button')
            .each(function () {
                var id = this.id || "";
                var name = this.name || "";
                var classval = this.className || "";
                // Set New Name value
                var newName = name.replace(/criminal[^]\d+]/, 'criminal[' + [cloneIndex] + ']');
                this.name = newName;
                //Set Location Class Value
                var newclass = classval.replace(/optLocationType0/, 'optLocationType' + [cloneIndex]);
                this.className = newclass;
                // Set new Id
                var match = id.match(regex) || [];
                if (match.length == 3) {
                    this.id = match[1] + (cloneIndex);
                }
            })
            .end()
            .appendTo('#addCriminalBlock');
            $(".selectDropdown").select2();
        // edit section Checking
        if(initiateFalg){
            eMobileLocation.init(cloneIndex);
        }

        $('.numOfcriminal:last').html(1 + cloneIndex);
        $('.numOfcFinger:last').html(1 + cloneIndex);
        $('.criminal_info_block:last').attr('id', 'criminalNo' + 1 + cloneIndex);
        $('#do_address_' + (cloneIndex)).click(function () {
            doParmanentAddress(this.value, (cloneIndex));
        });
        // $('#iLEFT_THUMB_' + (cloneIndex)).click(function () {
        //     fingurePrint.captureFP_criminal(1,cloneIndex);
        // });
        // $('#iRIGHT_THUMB_' + (cloneIndex)).click(function () {
        //     fingurePrint.captureFP_criminal(3,cloneIndex);
        // });
        // $('#checkfingureprint_' + (cloneIndex)).click(function () {
        //     fingurePrint.signaturetest(cloneIndex);
        // });
        criminal.cloneIndex++;
        return false;
    },

    setCriminalForm: function (criminaldetails) {

        var myStringArray = criminaldetails;
        var arrayLength = myStringArray.length;
        for (var i = 0; i < arrayLength; i++) {
            var j = i;
            $("#criminal_id_" + j).val(myStringArray[i].id);
            $("#criminal_name_" + j).val(myStringArray[i].name_bng);
            $("#criminal_custodian_name_" + j).val(myStringArray[i].custodian_name);
            $("#occupation_" + j).val(myStringArray[i].occupation);
            $("#present_address_" + j).val(myStringArray[i].present_address);
            $("#permanent_address_" + j).val(myStringArray[i].permanent_address);
            $("#locationtype" + j).val(myStringArray[i].location_type);
            $("#mobile_no_" + j).val(myStringArray[i].mobile_no);
            $("#age_" + j).val(myStringArray[i].age);
            $("#email_" + j).val(myStringArray[i].email);
            $("#national_id_" + j).val(myStringArray[i].national_id);
            $("#mother_name_" + j).val(myStringArray[i].mother_name);
            $("#criminal_repeat_crime_" + j).val(1);
            // $("#criminal_m_user_id_" + j).val(reply.data[0]["UserId"]);
            // $("#criminal_m_user_type_" + j).val(reply.data[0]["UserType"]);
            if(myStringArray[i].imprint1 ){
                document.getElementById("iLEFT_THUMB_" + j).src = "data:image/bmp;base64,"+myStringArray[i].imprint1;
            }
            if(myStringArray[i].imprint2){
                document.getElementById("iRIGHT_THUMB_" + j).src = "data:image/bmp;base64,"+myStringArray[i].imprint2;
            }

            if (myStringArray[i].do_address == 1) {
                $("#do_address_" + j).attr('checked', true);
            }

            $("#gender_" + j).val(myStringArray[i].gender);
            $("#custodian_type_" + j).val(myStringArray[i].custodian_type);

            $("#organization_name_" + j).val(myStringArray[i].organization_name);
            $("#trade_no_" + j).val(myStringArray[i].trade_no);

            var locationType = myStringArray[i].location_type;
            var divId = myStringArray[i].divid;
            var zillaId = myStringArray[i].zillaId;
            var upazilaId = myStringArray[i].upazilaid;
            var citycorporationId = myStringArray[i].geo_citycorporation_id;
            var metropolitanId = myStringArray[i].geo_metropolitan_id;
            var thanaId = myStringArray[i].geo_thana_id;


            eMobileLocation.populateLocation(j, locationType, divId, zillaId, upazilaId, citycorporationId, metropolitanId, thanaId);
        }

    }
};

$(document).ready(function () {
    criminal.init();
});


