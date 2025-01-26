var showFile = {

    init: function () {

    },

    operationExecute: function(id, criminal,selectVal) {

        $(".newhead").empty();
        $(".newbody").empty();

        var suomotu = document.getElementById("is_suomotu").value;

        var select = selectVal;
        var criminalId = criminal;

        if (select == "") {
            document.getElementById("txtHint").innerHTML = "";
            return;
        }
        else {
            //আদেশনামা
            if (select == "4") {
                $("#oper").val(select);
                var url = base_path + "/mobile/showTableByProsecution?form_id=" + select + "&id=" + id;
                $.ajax({

                    url: url,
                    type: 'POST',
                    success:function (data) {
                        if (data) {
                            if (data.table.length > 0) {
                                if (data.form_number == 41) {
                                    set_table(data.table);
                                    var html_content = $('#orderSheet_punishment_table').html();

                                    newwindow = window.open();
                                    newdocument = newwindow.document;
                                    newdocument.write(html_content);
                                    newdocument.close();

                                    newwindow.print();
                                    return false;
                                }
                            } else {
                                message_show("আদেশ প্রদান সম্পূর্ণ হয়নি ।");
                            }

                        }
                    },
                    error:function () {},
                    complete:function () {}
                });
            } else {

                $("#oper").val(select);
                var url = base_path + "/mobile/showFormByProsecution?form_id=" + select + "&id=" + id + "&suomotu=" + suomotu;
                $.ajax({

                    url: url,
                    type: 'POST',
                    success:function (data) {
                        if (data) {
                            if (data.form_number == 7){//jimmanama
                                if(data.caseInfo.prosecution.is_sizeddispose == 1 ){
                                    osjimmader_setParamsForPunishment(data.caseInfo.prosecution);
                                    osjimmader_setParamsFormagistraten(data.caseInfo.magistrateInfo);
                                    osjimmader_setParamsForProsecution(data.caseInfo.prosecution);
                                    osjimmader_setParamsForjobdescription(data.caseInfo.magistrateInfo);
                                    osjimmader_setParamsForSizedList(data.caseInfo.seizurelist);


                                    var html_content = $('#jimmader').html();

                                    newwindow = window.open();
                                    newdocument = newwindow.document;
                                    newdocument.write(html_content);
                                    newdocument.close();

                                    newwindow.print();
                                    return false;
                                }
                                else {

                                    message_show(" জিম্মানামা নাই। ");

                                }
                            }
                            else if (data.form_number == 1) {
                                var html_contentt="";
                                if(data.caseInfo.prosecution.hasCriminal==1){
                                    //for previous case
                                    if(data.caseInfo.lawsBrokenListWithProsecutor){
                                        p_setcrimieDescriptionWC(data.caseInfo.prosecution,data.caseInfo.criminalDetails,data.caseInfo.prosecutionLocationName,data.caseInfo.lawsBrokenListWithProsecutor,data.caseInfo.lawsBrokenListWithProsecutor);
                                        p_setParamsForcriminalWC(data.caseInfo.criminalDetails,data.caseInfo.lawsBrokenListWithProsecutor);
                                    }else{
                                        p_setcrimieDescriptionWC(data.caseInfo.prosecution,data.caseInfo.criminalDetails,data.caseInfo.prosecutionLocationName,data.caseInfo.lawsBrokenList,data.caseInfo.lawsBrokenList);
                                        p_setParamsForcriminalWC(data.caseInfo.criminalDetails,data.caseInfo.lawsBrokenList);
                                    }

                                    p_setParamsForProsecution(data.caseInfo.prosecution);

                                    p_setParamsForSizedList(data.caseInfo.seizurelist);
                                    p_setParamsForjobdescription(data.caseInfo.magistrateInfo);
                                    p_setParamsFormagistraten(data.caseInfo.magistrateInfo);
                                    p_setParamsForLocation(data.caseInfo.prosecutionLocationName);
                                    p_setParamsForProsecutor(data.caseInfo.prosecutorInfo);
                                    html_contentt = $('#prosecution').html();

                                }else{
                                    p_setcrimieDescriptionWOC(data.caseInfo.prosecution,data.caseInfo.criminalDetails,data.caseInfo.prosecutionLocationName,data.caseInfo.lawsBrokenListWithProsecutor,data.caseInfo.lawsBrokenListWithProsecutor);
                                    p_setParamsForProsecutionWOC(data.caseInfo.prosecution);
                                    p_setParamsForcriminalWOC(data.caseInfo.criminalDetails,data.caseInfo.lawsBrokenListWithProsecutor);
                                    p_setParamsForSizedListWOC(data.caseInfo.seizurelist);
                                    p_setParamsForjobdescriptionWOC(data.caseInfo.magistrateInfo);
                                    p_setParamsFormagistratenWOC(data.caseInfo.magistrateInfo);
                                    p_setParamsForLocationWOC(data.caseInfo.prosecutionLocationName);

                                    p_setParamsForProsecutorWOC(data.caseInfo.prosecutorInfo);
                                    html_contentt = $('#complainSubmitReportWithOutCriminal').html();
                                }
                                newwindow = window.open();
                                newdocument = newwindow.document;
                                newdocument.write(html_contentt);
                                newdocument.close();

                                newwindow.print();
                                return false;

                            }
                            else if (data.form_number == 20) {//complaint

                                if (data.caseInfo.prosecution.is_approved == 0) {
                                    message_show("অভিযোগ গঠন হয়নি ।");
                                } else {
                                    var location=data.caseInfo.prosecutionLocationName.underZillaLocation+','+data.caseInfo.prosecutionLocationName.zillaName;
                                    c_agree_crimieDescription(data.caseInfo.prosecution,data.caseInfo.criminalDetails,location,data.caseInfo.lawsBrokenList);
    //                                c_agree_setParamsForProsecution(data.prosecution);
                                    c_agree_setParamsForcriminal(data.caseInfo.criminalDetails,criminalId);
                                    c_agree_setParamsForjobdescription(data.caseInfo.magistrateInfo);
                                    c_agree_setParamsFormagistraten(data.caseInfo.magistrateInfo);
    //                                c_agree_setParamsForLocation(data.pro_locationdetails);

                                    //$('#complain').modal('show');

                                    ///////////////////////////
                                    var html_content = $('#complain_agree').html();

                                    newwindow = window.open();
                                    newdocument = newwindow.document;
                                    newdocument.write(html_content);
                                    newdocument.close();

                                    newwindow.print();
                                    return false;
                                }

                                ////////////////////////////
                            }
                            else if (data.form_number == 21) {
                                if (data.prosecution.is_approved == 0) {
                                    message_show("অভিযোগ গঠন হয়নি ।");

                                } else {
                                    c_disagree_setParamsForProsecution(data.prosecution);
                                    c_disagree_setParamsForcriminal(data.criminal);
                                    c_disagree_setParamsForjobdescription(data.jobdescription);
                                    c_disagree_setParamsFormagistraten(data.magistrate);
                                    c_disagree_setParamsForLocation(data.pro_location);


                                    //$('#complain').modal('show');

                                    ///////////////////////////
                                    var html_content = $('#complain_disagree').html();

                                    newwindow = window.open();
                                    newdocument = newwindow.document;
                                    newdocument.write(html_content);
                                    newdocument.close();

                                    newwindow.print();
                                    return false;
                                }
                                ////////////////////////////
                            }
                            else if (data.form_number == 30) {//confession

                                if (data.caseInfo.criminalConfession.length > 0) {

                                    cc_yes_setParamsForcriminalConfession(data.caseInfo.criminalConfession, criminalId);
                                    cc_yes_setParamsForcriminal(data.caseInfo.criminalDetails, criminalId);

                                    cc_yes_setParamsForjobdescription(data.caseInfo.magistrateInfo,data.caseInfo.prosecutionLocationName);
                                    cc_yes_setParamsFormagistraten(data.caseInfo.magistrateInfo);
                                    cc_yes_setParamsForProsecution(data.caseInfo.prosecution);
                                    //$('#criminalConfession').modal('show');

                                    var html_content = $('#criminalConfession_yes').html();

                                    newwindow = window.open();
                                    newdocument = newwindow.document;
                                    newdocument.write(html_content);
                                    newdocument.close();

                                    newwindow.print();
                                    return false;
                                } else {
                                    message_show("অভিযুক্ত ব্যক্তির বক্তব্য নাই");
                                }

                            }
                            else if (data.form_number == 31) {
                                cc_no_setParamsForcriminalConfession(data.criminalConfession);
                                cc_no_setParamsForcriminal(data.criminal);
                                cc_no_setParamsForjobdescription(data.jobdescription);
                                cc_no_setParamsFormagistraten(data.magistrate);
                                cc_no_setParamsForProsecution(data.prosecution);
                                //$('#criminalConfession').modal('show');

                                var html_content = $('#criminalConfession_no').html();

                                newwindow = window.open();
                                newdocument = newwindow.document;
                                newdocument.write(html_content);
                                newdocument.close();

                                newwindow.print();
                                return false;
                            }
                            else if (data.form_number == 41) {

                                os_setParamsForProsecution(data.prosecution);
                                os_setParamsFormagistrate(data.magistrate);
                                os_setParamsForjobdescription(data.jobdescription);
                                os_setParamsForcriminal(data.criminal);
                                os_setParamsForprosecutor(data.prosecutor);
                                os_setParamsForPunishment(data.punishment);
                                os_setParamsForcriminalConfession(data.criminalConfession);
                                os_setParamsForSizedList(data.seizurelist);
                                os_setParamsForLocation(data.pro_location);
                                os_setParamsForJail(data.jail);

                                //$('#orderSheet').modal('show');

                                ///////////////////////////
                                var html_content = $('#orderSheet_punishment').html();

                                newwindow = window.open();
                                newdocument = newwindow.document;
                                newdocument.write(html_content);
                                newdocument.close();

                                newwindow.print();
                                return false;
                                ////////////////////////////
                            }
                            else if (data.form_number == 42) {

                                osRelease_setParamsForProsecution(data.prosecution);
                                osRelease_setParamsFormagistrate(data.magistrate);
                                osRelease_setParamsForjobdescription(data.jobdescription);
                                osRelease_setParamsForcriminal(data.criminal);
                                osRelease_setParamsForprosecutor(data.prosecutor);
                                osRelease_setParamsForPunishment(data.punishment);
                                osRelease_setParamsForcriminalConfession(data.criminalConfession);
                                osRelease_setParamsForSizedList(data.seizurelist);

                                //$('#orderSheet').modal('show');

                                ///////////////////////////
                                var html_content = $('#orderSheet_release').html();

                                newwindow = window.open();
                                newdocument = newwindow.document;
                                newdocument.write(html_content);
                                newdocument.close();

                                newwindow.print();
                                return false;
                                ////////////////////////////
                            }
                            else if (data.form_number == 43) {

                                osTocourt_setParamsForProsecution(data.prosecution);
                                osTocourt_setParamsFormagistrate(data.magistrate);
                                osTocourt_setParamsForjobdescription(data.jobdescription);
                                osTocourt_setParamsForcriminal(data.criminal);
                                osTocourt_setParamsForprosecutor(data.prosecutor);
                                osTocourt_setParamsForPunishment(data.punishment);
                                osTocourt_setParamsForcriminalConfession(data.criminalConfession);
                                osTocourt_setParamsForSizedList(data.seizurelist);

                                //$('#orderSheet').modal('show');

                                ///////////////////////////
                                var html_content = $('#orderSheet_tocourt').html();

                                newwindow = window.open();
                                newdocument = newwindow.document;
                                newdocument.write(html_content);
                                newdocument.close();

                                newwindow.print();
                                return false;
                                ////////////////////////////
                            }
                            else if (data.form_number == 44) {

                                osDeposition_setParamsForProsecution(data.prosecution);
                                osDeposition_setParamsFormagistrate(data.magistrate);
                                osDeposition_setParamsForjobdescription(data.jobdescription);
                                osDeposition_setParamsForcriminal(data.criminal);
                                osDeposition_setParamsForprosecutor(data.prosecutor);
                                osDeposition_setParamsForPunishment(data.punishment);
                                osDeposition_setParamsForcriminalConfession(data.criminalConfession);
                                osDeposition_setParamsForSizedList(data.seizurelist);

                                //$('#orderSheet').modal('show');

                                ///////////////////////////
                                var html_content = $('#orderSheet_deposition').html();

                                newwindow = window.open();
                                newdocument = newwindow.document;
                                newdocument.write(html_content);
                                newdocument.close();

                                newwindow.print();
                                return false;
                                ////////////////////////////
                            }

                            else if (data.form_number == 5) { //seizureListReport
                                if (data.caseInfo.seizurelist) {

                                    prepareReport(data.caseInfo);

                                    var html_content = $('#sizedList').html();

                                    newwindow = window.open();
                                    newdocument = newwindow.document;
                                    newdocument.write(html_content);
                                    newdocument.close();

                                    newwindow.print();
                                    return false;
                                } else {
                                    message_show("জব্দ তালিকা নাই");
                                }

                            }
                            else if (data.form_number == 6) {//jail
                                if (data.jailInfo.length > 0) {
                                    if (data.caseInfo.criminalDetails.length > 0) {
                                        var flag = one_jw_setParamsForcriminal(data.caseInfo.criminalDetails,criminalId,data.jailInfo,data.caseInfo.prosecution);
                                        if(flag){
                                            one_jw_setParamsForProsecution(data.caseInfo.prosecution);
                                            //one_jw_setParamsForPunishment(data.punishment, 0);
                                            one_jw_setParamsForjobdescription(data.caseInfo.magistrateInfo,data.caseInfo.prosecutionLocationName);

                                            one_jw_setParamsFormagistraten(data.caseInfo.magistrateInfo);
                                            one_jw_setParamsForJail(data.jailInfo,criminalId);
                                            one_jw_setParamsForLaw(data.jailInfo,criminalId);

                                            var html_content = $('#jellWarrentall').html();


                                            newwindow = window.open();
                                            newdocument = newwindow.document;
                                            newdocument.write(html_content);
                                            newdocument.close();

                                            newwindow.print();
                                            return false;
                                        }else{
                                            message_show("কয়েদী  পরোয়ানা  নাই");
                                        }

                                    }
                                    return false;
                                }
                                else {
                                    message_show("কয়েদী  পরোয়ানা  নাই");
                                }
                            }else if (data.form_number == 8) {
                                if(data.jailInfo.length > 0) {
                                    handover_setParamsForcriminal(data.caseInfo.criminalDetails,data.jailInfo,criminalId,data.caseInfo.prosecution);
                                    handover_setParamsForjobdescription(data.caseInfo.magistrateInfo,data.caseInfo.prosecutionLocationName);
                                    handover_setParamsFormagistraten(data.caseInfo.magistrateInfo);

                                    ///////////////////////////
                                    var html_content = $('#handoverform').html();

                                    newwindow = window.open();
                                    newdocument = newwindow.document;
                                    newdocument.write(html_content);
                                    newdocument.close();

                                    newwindow.print();
                                    return false;
                                } else {
                                    message_show("সোপর্দের পরোয়ানা  নাই");
                                }
                            }else
                            {
                                message_show("তথ্য নাই ");
                            }


                        }
                    },
                    error:function () {},
                    complete:function () {}
                });
            }

        }
    },
};


$(document).ready(function () {

});


