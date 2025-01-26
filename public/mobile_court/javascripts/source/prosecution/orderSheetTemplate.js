var orderTemplate = {
    criminalTextBng: "",
    accusedTextBng: "",
    personP: "",
    personP_r: "",
    personP_r2: " ",
    reciptNo: null,
    init: function () {
        var prosecutionId = $("#ProsecutionID").val();
        var formURL = "/punishment/getOrderSheetInfo";
        var allCriminalPunished = null;
        var header = "";
        var tableBody = "";
        $.ajax({
            url: formURL,
            type: "POST",
            dataType: "json",
            data: { data: prosecutionId },
            mimeType: "multipart/form-data",
            success: function (response, textStatus, jqXHR) {
                if (response.flag == "true") {
                    //hasCriminal=1[with criminal],hasCriminal=0[without criminal]
                    header = orderTemplate.getOrderSheetHeader(response);

                    if (response.info.caseInfo.prosecution.hasCriminal == 1) {
                        orderTemplate.numberOfcriminalText(
                            response.info.caseInfo.criminalDetails
                        );
                        tableBody =
                            orderTemplate.getOrderSheetTableBody(response);
                        console.log(tableBody);
                    } else {
                        tableBody =
                            orderTemplate.getOrderSheetTableBodyWithOutCriminal(
                                response
                            );
                    }

                    $("#newhead").append(header);
                    $("#newbody").append(tableBody);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $.alert(" ত্রুটি। ", "অবহতিকরণ বার্তা");
            },
        });
    },
    getOrderSheetHeader: function (prosecutionInfo) {
        var criminalString = "";
        if (prosecutionInfo.info.caseInfo.prosecution.hasCriminal == 1) {
            criminalString = orderTemplate.criminalStringGeneration(
                prosecutionInfo.info.caseInfo.criminalDetails
            );
        }
        var header =
            '<p class="form-bd" style="text-align: left;">বাংলাদেশ ফরম নম্বর - ৩৮৯০ <br>' +
            "        সুপ্রীম কোর্ট (হাইকোর্ট বিভাগ) ক্রিমিনাল ফরম নম্বর (এম) ১০৬</p>" +
            '        <h2 style="text-align: center;">এক্সিকিউটিভ ম্যাজিস্ট্রেটের রেকর্ডের জন্য আদেশনামা</h2>' +
            '        <p style="text-align: center;">' +
            "            জনাব" +
            "            <span>" +
            prosecutionInfo.info.caseInfo.magistrateInfo.name_eng +
            ",&nbsp;" +
            prosecutionInfo.info.caseInfo.magistrateInfo.designation_bng +
            ",&nbsp;</span><span>" +
            prosecutionInfo.info.caseInfo.magistrateInfo.location_str +
            ",&nbsp;</span><span> " +
            prosecutionInfo.info.caseInfo.magistrateInfo.location_details +
            "-এর আদালত।<br>" +
            "                                    বিবিধ  মামলা নম্বর-&nbsp;<span>" +
            prosecutionInfo.info.caseInfo.prosecution.case_no +
            "&nbsp;তারিখ:<span>&nbsp;" +
            orderTemplate.formatDate(
                prosecutionInfo.info.caseInfo.prosecution.date
            ) +
            "।&nbsp;" +
            "                                </span></span></span></p>" +
            '        <div id="dependent">' +
            '        <span style="margin-left: 80px;">' +
            "            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; রাষ্ট্র &nbsp; বনাম</span>" +
            '            <span style="margin-right: 40px;">&nbsp;' +
            "                                 &nbsp;" +
            "                                <span>" +
            criminalString +
            "</span>" +
            "                                    </span></div>" +
            "    </div>";
        return header;
    },
    getOrderSheetTableBody: function (prosecutionInfo) {
        var seizureOrderContextText = "";
        var seizureListText = "";
        var tableBody = "";
        var tableBodyContent = "";
        var finePaymentOrder = "";

        var orderSheetFirstPara =
            orderTemplate.ordersheetFirstParaGeneration(prosecutionInfo);
        var lawsBrokenForCriminal =
            orderTemplate.lawsBrokenForCrimeTextGeneration(
                prosecutionInfo.info.caseInfo.lawsBrokenList
            );
        var complaintTextBlock =
            orderTemplate.complaintTextGeneration(prosecutionInfo);
        var confessionTextBlock =
            orderTemplate.confessionTextGeneration(prosecutionInfo);
        var orderTextBlock = orderTemplate.orderTextGeneration(
            prosecutionInfo.info.orderList,
            orderTemplate.formatDate(
                prosecutionInfo.info.caseInfo.prosecution.date
            )
        );
        //check seizure list
        if (prosecutionInfo.info.caseInfo.seizurelist) {
            seizureListText =
                '<div class="para" >' +
                orderTemplate.seizureTextGenerationForOrderSheet(
                    prosecutionInfo.info.caseInfo
                ) +
                "</div>";
            seizureOrderContextText =
                '<div class="para" ><span contenteditable="false" class="noneditable">' +
                prosecutionInfo.info.caseInfo.prosecution.dispose_detail +
                "</span></div>";
        }
        if (orderTemplate.reciptNo) {
            finePaymentOrder =
                '<div class="para" ><span contenteditable="true" class="editable">  আদায়কৃত অর্থ পরবর্তী কার্যদিবসের মধ্যে সরকারি কোষাগারে চালানের মাধ্যমে জমা প্রদানের জন্য বেঞ্চ সহকারীকে বলা হলো ।</span></div>';
        }
        tableBodyContent =
            orderSheetFirstPara +
            lawsBrokenForCriminal +
            seizureListText +
            complaintTextBlock +
            confessionTextBlock +
            orderTextBlock +
            seizureOrderContextText +
            finePaymentOrder;
        tableBody = orderTemplate.tableBody(prosecutionInfo, tableBodyContent);

        return tableBody;
    },
    getOrderSheetTableBodyWithOutCriminal: function (prosecutionInfo) {
        var tableBody = "";
        var seizureOrderContextText = "";
        var seizureListText = "";
        var tableBodyContent = "";
        var prosecutorText = "";
        if (prosecutionInfo.info.caseInfo.prosecutorInfo.length > 0) {
            prosecutorText =
                orderTemplate.prosecutorInfoTextGenerationWithOutCriminal(
                    prosecutionInfo.info.caseInfo
                );
        }
        //check seizure list
        if (prosecutionInfo.info.caseInfo.seizurelist) {
            seizureListText =
                '<div class=\'para\'><span contenteditable="true" class="editable"> ঘটনাস্থল থেকে - </span><span contenteditable="false" class="noneditable">' +
                orderTemplate.seizureListTextGeneration(
                    prosecutionInfo.info.caseInfo.seizurelist
                ) +
                '</span><span contenteditable="true" class="editable"> ,দুই&nbsp; (০২)  জন সাক্ষীর উপস্থিতিতে জব্দ করে জব্দনামা তৈরি করে তাতে সাক্ষীদ্বয়ের স্বাক্ষর গ্রহণ করি  ।</span></div>';
            seizureOrderContextText =
                '<div class=\'para\'><span contenteditable="false" class="noneditable">' +
                prosecutionInfo.info.caseInfo.prosecution.dispose_detail +
                "</span></div>";
        }
        var lawsBrokenForCriminal =
            orderTemplate.lawsBrokenForCrimeTextGeneration(
                prosecutionInfo.info.caseInfo.lawsBrokenList
            );
        tableBodyContent =
            '<div ><span contenteditable="false" class="noneditable">আজ ' +
            prosecutionInfo.info.caseInfo.prosecution.date +
            " তারিখ " +
            prosecutionInfo.info.caseInfo.prosecutionLocationName.zillaName +
            " জেলার " +
            prosecutionInfo.info.caseInfo.prosecutionLocationName
                .underZillaLocation +
            " এর " +
            prosecutionInfo.info.caseInfo.prosecution.location +
            " স্থানে মোবাইল কোর্ট পরিচালনাকালে " +
            prosecutionInfo.info.caseInfo.prosecutionTimeInBangla +
            " ঘটিকায় </span><span contenteditable='true' class=\"editable\">অপরাধ সংগঠিত হয় । </span> </div>" +
            prosecutorText +
            "" +
            ' <div class=\'para\'><span contenteditable="true" class="editable">ঘটনার সংক্ষিপ্ত বিবরণ এই যে, </span>' +
            '<span contenteditable="false" class="noneditable">' +
            " " +
            prosecutionInfo.info.caseInfo.prosecution.location +
            " স্থানে " +
            '<span contenteditable="true" class="editable">' +
            lawsBrokenForCriminal +
            ' <span contenteditable="true" class="editable">কোন ব্যক্তি আটক নয় , আসামি পলাতক । তাই অভিযোগ গঠন করা গেল না ।</span></div>' +
            seizureListText +
            seizureOrderContextText;

        tableBody = orderTemplate.tableBody(prosecutionInfo, tableBodyContent);
        return tableBody;
    },
    tableBody: function (prosecutionInfo, tableBodyContent) {
        var tableBody = "";
        var magistrateSignature = "";
        var magistrateSignaturePortion = "";

        //magistrate signature
        // var path = "";
        // if(base_path !=""){
        //     path = base_path + '/public/ecourt/Mobile/Signature/IMAGE/' ;
        // }else{
        //     path = '/ecourt/Mobile/Signature/IMAGE/' ;
        // }

        // if( prosecutionInfo.info.caseInfo.magistrateInfo.signature){
        //     magistrateSignature=path + prosecutionInfo.info.caseInfo.magistrateInfo.signature;

        //     magistrateSignaturePortion="<img width=\"50%\" class=\"thumbnail\" id=\"c_agree_m_imprint1\" src=\""+magistrateSignature+"\">";
        // }

        tableBody =
            '        <table cellspacing="0" cellpadding="0" border="1" width="100%">' +
            "            <tbody>" +
            "            <tr>" +
            '                <td valign="middle" width="5%" align="center"> আদেশের ক্রম</td>' +
            '                <td valign="middle" width="10%" align="center"> তারিখ</td>' +
            '                <td valign="middle" width="75%" align="center"> আদেশ</td>' +
            '                <td valign="middle" width="10%" align="center"> স্বাক্ষর</td>' +
            "            </tr>" +
            "            <tr>" +
            '                <td valign="top" align="center">' +
            '                    <span class="underline" ;=""> ১</span><br>' +
            "                </td>" +
            '                <td valign="top" align="center">' +
            "                    " +
            orderTemplate.formatDate(
                prosecutionInfo.info.caseInfo.prosecution.date
            ) +
            "" +
            "                </td>" +
            '                <td style="padding:5px; text-align : justify;">' +
            tableBodyContent +
            '                    <table contenteditable="false" border="0" width="100%" align="center">' +
            "                        <tbody>" +
            "                        <tr>" +
            '                            <td width="30%">' +
            "                                (সিলমোহর)" +
            "                            </td>" +
            '                            <td width="70%" align="center">' +
            "                                <span>&nbsp;" +
            orderTemplate.formatDate(
                prosecutionInfo.info.caseInfo.prosecution.date
            ) +
            "</span>" +
            "                            </td>" +
            "                        </tr>" +
            "                        <tr>" +
            '                            <td width="30%">' +
            "                            </td>" +
            '                            <td width="50%" align="center">' +
            "                                <span>" +
            " " +
            "</span>" +
            "                            </td>" +
            "                        </tr>" +
            "                        <tr>" +
            '                            <td width="30%">' +
            "                            </td>" +
            '                            <td width="70%" align="center">' +
            "                                <span>" +
            prosecutionInfo.info.caseInfo.magistrateInfo.name_eng +
            "</span>" +
            "                            </td>" +
            "                        </tr>" +
            "                        <tr>" +
            '                            <td width="30%">' +
            "                            </td>" +
            '                            <td width="70%" align="center">' +
            "                                <span>" +
            prosecutionInfo.info.caseInfo.magistrateInfo.designation_bng +
            "</span>" +
            "                            </td>" +
            "                        </tr>" +
            "                        <tr>" +
            '                            <td width="30%">' +
            "                            </td>" +
            '                            <td width="70%" align="center">' +
            "                                <span>" +
            prosecutionInfo.info.caseInfo.magistrateInfo.location_str +
            "," +
            "" +
            "</span>" +
            "                            </td>" +
            "                        </tr>" +
            "                        </tbody>" +
            "                    </table>" +
            "                </td>" +
            "                <td>" +
            "                </td>" +
            "            </tr>" +
            "            </tbody>" +
            "        </table>";
        return tableBody;
    },
    saveOrdersheet: function () {
        $(".editable").attr("contenteditable", false);
        $(".editable").removeClass();
        $(".noneditable").removeClass();
        var header = $("#newhead").html();
        var tableBody = $("#newbody").html();
        var formURL = "/punishment/saveOrderSheet";
        var prosecutionId = $("#ProsecutionID").val();
        $.ajax({
            url: formURL,
            type: "POST",
            dataType: "json",
            data: {
                header: header,
                tableBody: tableBody,
                prosecutionId: prosecutionId,
            },
            mimeType: "multipart/form-data",
            success: function (response, textStatus, jqXHR) {
                if (response.flag == "true") {
                    var urlnew = "/dashboard/";
                    window.location = urlnew;
                    //window.location = '/punishment/previewOrderSheet?prosecutionId=' + prosecutionID;
                } else {
                    $.alert(" ত্রুটি। ", "অবহতিকরণ বার্তা");
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $.alert(" ত্রুটি। ", "অবহতিকরণ বার্তা");
            },
        });
    },
    criminalStringGeneration: function (criminalInfo) {
        var criminalString = "";
        var additionalComma = ",";
        for (var i = 0; i < criminalInfo.length; i++) {
            //handle comma for 1 criminal or last number of criminal
            if (criminalInfo.length == i + 1) {
                additionalComma = "";
            }
            criminalString += criminalInfo[i].name_bng + additionalComma;
        }
        return criminalString;
    },
    ordersheetFirstParaGeneration: function (prosecutionInfo) {
        var prosecutorText = "";
        var criminalAllbio = orderTemplate.criminalFullBioStringGeneration(
            prosecutionInfo.info.caseInfo.criminalDetails
        );

        //if prosecution With prosecutor
        // if(prosecutionInfo.info.caseInfo.prosecutorInfo.length>0){
        //     prosecutorText=orderTemplate.prosecutorInfoTextGeneration(prosecutionInfo.info.caseInfo);
        // }

        var para =
            '<div ><span contenteditable="false" class="noneditable">আজ ' +
            orderTemplate.formatDate(
                prosecutionInfo.info.caseInfo.prosecution.date
            ) +
            " তারিখ " +
            prosecutionInfo.info.caseInfo.prosecutionLocationName.zillaName +
            " জেলার " +
            prosecutionInfo.info.caseInfo.prosecutionLocationName
                .underZillaLocation +
            " এর " +
            prosecutionInfo.info.caseInfo.prosecution.location +
            " স্থানে মোবাইল কোর্ট পরিচালনাকালে " +
            prosecutionInfo.info.caseInfo.prosecutionTimeInBangla +
            " ঘটিকায় " +
            criminalAllbio +
            '</span><span contenteditable="true" class="editable"> কর্তৃক অপরাধ সংঘটনের সময় হাতে নাতে ধৃত হন ।</span>' +
            prosecutorText +
            '</div><div class=\'para\'> <span contenteditable="true" class="editable"> ঘটনার সংক্ষিপ্ত বিবরণ এই যে, </span>' +
            '<span contenteditable="false" class="noneditable">' +
            orderTemplate.criminalStringGeneration(
                prosecutionInfo.info.caseInfo.criminalDetails
            ) +
            " " +
            prosecutionInfo.info.caseInfo.prosecution.location +
            " স্থানে ";

        return para;
    },
    criminalFullBioStringGeneration: function (criminalInfo) {
        var text = "";
        for (var i = 0; i < criminalInfo.length; i++) {
            text +=
                criminalInfo[i].name_bng +
                " , " +
                criminalInfo[i].custodian_type +
                ": " +
                criminalInfo[i].custodian_name +
                " , বয়স: " +
                criminalInfo[i].age +
                ", ঠিকানা: " +
                criminalInfo[i].present_address +
                ",";
        }
        return text;
    },
    lawsBrokenForCrimeTextGeneration: function (lawsBrokenList) {
        var text = "";
        for (var i = 0; i < lawsBrokenList.length; i++) {
            text +=
                '</span><span contenteditable="true" class="editable">' +
                lawsBrokenList[i].Description +
                '</span><span contenteditable="false" class="noneditable"> যা ' +
                lawsBrokenList[i].sec_title +
                "-এর " +
                lawsBrokenList[i].sec_number +
                " ধারার লঙ্ঘন ও " +
                lawsBrokenList[i].punishment_sec_number +
                " ধারায় দণ্ডনীয় অপরাধ ।</span>";
        }
        text += "</div>";
        return text;
    },
    prosecutorInfoTextGeneration: function (prosecution) {
        var criminalText = orderTemplate.accusedTextBng;

        var text =
            '<span contenteditable="false" class="noneditable">' +
            criminalText +
            "&nbsp;বিরুদ্ধে&nbsp;জনাব&nbsp;" +
            prosecution.prosecutorInfo[0].name_eng +
            "," +
            prosecution.prosecutorInfo[0].designation_bng +
            "," +
            prosecution.prosecutorInfo[0].zillaname +
            " লিখিতভাবে অভিযোগ দায়ের করেন।</span>";
        return text;
    },
    prosecutorInfoTextGenerationWithOutCriminal: function (prosecution) {
        var text =
            '<div class=\'para\'> <span contenteditable="false" class="noneditable">জনাব&nbsp;' +
            prosecution.prosecutorInfo[0].name_eng +
            "," +
            prosecution.prosecutorInfo[0].designation_bng +
            "," +
            prosecution.prosecutorInfo[0].zillaname +
            '</span><span contenteditable="true" class="editable"> লিখিতভাবে অভিযোগ দায়ের করেন।</span></div>';
        return text;
    },
    seizureTextGenerationForOrderSheet: function (prosecution) {
        var text =
            '<span contenteditable="true" class="editable">' +
            orderTemplate.accusedTextBng +
            ' হেফাজত থেকে </span><span contenteditable="false" class="noneditable">' +
            orderTemplate.seizureListTextGeneration(prosecution.seizurelist) +
            '</span><span contenteditable="true" class="editable">,দুই&nbsp; (০২)  জন সাক্ষীর উপস্থিতিতে জব্দ করে জব্দনামা তৈরি করে তাতে সাক্ষীদ্বয়ের স্বাক্ষর গ্রহণ করি এবং ' +
            orderTemplate.criminalTextBng +
            "- কে  স্বাক্ষর দিতে বললে জব্দনামায় " +
            orderTemplate.$personP_r2 +
            " স্বাক্ষর প্রদান করেন ।</span>";

        return text;
    },
    seizureListTextGeneration: function (seizureList) {
        var text = "";
        var banglaLetter = ["ক)", " খ)", " গ)", " ঘ)", " ঙ)", " চ)"];
        for (var i = 0; i < seizureList.length; i++) {
            text += banglaLetter[i] + seizureList[i].stuff_description;
        }
        return text;
    },
    numberOfcriminalText: function (criminalList) {
        if (criminalList.length > 1) {
            orderTemplate.criminalTextBng = "আসামিগণ";
            orderTemplate.accusedTextBng = "অভিযুক্তগণের";
            orderTemplate.personP = "তাদের";
            orderTemplate.$personP_r = "তারা";
            orderTemplate.$personP_r2 = "তারাও";
        } else {
            orderTemplate.criminalTextBng = "আসামি";
            orderTemplate.accusedTextBng = "অভিযুক্তের";
            orderTemplate.personP = "তাকে";
            orderTemplate.$personP_r = "তার";
            orderTemplate.$personP_r2 = "তিনিও";
        }
    },
    complaintTextGeneration: function (prosecution) {
        var text = "";
        text =
            '<div class=\'para\'><span contenteditable="true" class="editable">উক্ত অপরাধ আমার</span><span contenteditable="false" class="noneditable"> ' +
            prosecution.info.caseInfo.prosecution.occurrence_type_text +
            '</span><span contenteditable="true" class="editable"> হওয়ায় ঘটনাস্থল থেকে ' +
            orderTemplate.criminalTextBng +
            "কে তৎক্ষণাৎ আটক করি,&nbsp;মোবাইল কোর্ট আইন, ২০০৯–এর ৬(১) ধারা মোতাবেক অপরাধ আমলে গ্রহণ করে ৭(১) ধারার বিধানমতে&nbsp;" +
            orderTemplate.criminalTextBng +
            " " +
            orderTemplate.criminalStringGeneration(
                prosecution.info.caseInfo.criminalDetails
            ) +
            " এর বিরুদ্ধে &nbsp;অভিযোগ গঠন করি । উক্ত অভিযোগ " +
            orderTemplate.personP +
            " পড়ে ও ব্যাখ্যা করে শোনানো হলো এবং " +
            orderTemplate.personP_r +
            " দোষ স্বীকার করেন কিনা জিজ্ঞাসা করা হলে " +
            orderTemplate.criminalTextBng +
            "-</span></div>";
        return text;
    },
    confessionTextGeneration: function (prosecution) {
        var text = "";
        var response = prosecution.info.punishmentConfessionByLaw;
        for (var i = 0; i < response.length; i++) {
            text +=
                '<div class="para"><span contenteditable="false" class="noneditable">' +
                response[i].name_bng +
                "- এর বিরুদ্ধে আনীত " +
                response[i].lawWiseConfessionText +
                " ।তিনি বলেন যে," +
                response[i].description +
                "</span></div>";
        }
        return text;
    },
    orderTextGeneration: function (punishment, date) {
        var text = "";
        var additionalText = "";
        var finePaymentText = "";
        var punishmentJailText = "";
        var repWarrentText = "";

        for (var i = 0; i < punishment.length; i++) {
            console.log(punishment[i]);
            var accuse = " অভিযুক্তের";
            var accusePerson = "অভিযুক্ত ব্যক্তিকে";
            var pronoun = "তার";
            var criminal = "আসামি";
            var fineAndJailText = "";
            var warrentDurationText = "";
            var fineText = "";
            if (punishment[i].CriminalName.indexOf(",") > -1) {
                accuse = "অভিযুক্তদের";
                accusePerson = "অভিযুক্ত ব্যক্তিদের";
                pronoun = " তাদের";
                criminal = " আসামিগন ";
            }
            if (punishment[i].orderType == "PUNISHMENT") {
                if (punishment[i].rep_warrent_duration) {
                    repWarrentText =
                        '<span contenteditable="false" class="noneditable"> অনাদায়ে ' +
                        punishment[i].rep_warrent_duration +
                        '</span><span contenteditable="true" class="editable"> প্রদান করা হলো। </span>';
                } else {
                    repWarrentText =
                        '<span contenteditable="true" class="editable">প্রদান করা হলো।</span>';
                }

                if (punishment[i].receiptNo) {
                    finePaymentText =
                        '<span contenteditable="true" class="editable">' +
                        criminal +
                        ' অর্থদণ্ড নগদ পরিশোধ করেন, যার রশিদ নম্বর- </span><span contenteditable="false" class="noneditable">' +
                        punishment[i].receiptNo +
                        " ,তারিখ- " +
                        date +
                        "।</span>";
                    orderTemplate.reciptNo = punishment[i].receiptNo;
                }
                if (punishment[i].punishmentJailID) {
                    punishmentJailText =
                        '<span contenteditable="true" class="editable"> সাজা পরোয়ানামূলে আসামি </span><span contenteditable="false" class="noneditable">' +
                        punishment[i].CriminalName +
                        " কে " +
                        punishment[i].punishmentJailName +
                        '</span><span contenteditable="true" class="editable">-এ প্রেরণ করা হোক। </span>';
                }
                fineAndJailText = punishment[i].DistinctOrder;
                // if(punishment[i].warrentDuration){
                //     warrentDurationText=punishment[i].warrentDuration+" " ;
                // }
                //
                // if(punishment[i].orderTotalFine){
                //     fineText=bangla.toBangla(punishment[i].orderTotalFine)+" টাকা অর্থদণ্ড ";
                // }
                //
                // if(warrentDurationText && fineText){
                //     fineAndJailText=warrentDurationText+" এবং "+fineText;
                // }else {
                //     fineAndJailText=warrentDurationText+fineText;
                // }

                additionalText =
                    '<span contenteditable="true" class="editable"> ' +
                    orderTemplate.personP +
                    ' মোবাইল কোর্ট আইন, ২০০৯-এর ৭(২) ধারার বিধানমতে, </span><span contenteditable="false" class="noneditable">' +
                    punishment[i].lawAndSectionPunishment +
                    " " +
                    fineAndJailText +
                    "</span>" +
                    repWarrentText +
                    finePaymentText +
                    punishmentJailText;
            } else if (punishment[i].orderType == "REGULARCASE") {
                additionalText =
                    '<span contenteditable="true" class="editable">' +
                    pronoun +
                    " ও উপস্থিত সাক্ষীগনের বক্তব্য পর্যালোচনা করা হল। বর্ণিতাবস্থায় , মোবাইল কোর্ট আইন , ২০০৯- এর ৭(৪) ধারার বিধানমতে " +
                    accusePerson +
                    '</span> <span contenteditable="false" class="noneditable">' +
                    punishment[i].lawAndSectionDharaHote +
                    punishment[i].DistinctOrder +
                    "</span>";
            } else {
                additionalText =
                    '<span contenteditable="true" class="editable">' +
                    pronoun +
                    " ও উপস্থিত সাক্ষীগনের বক্তব্য পর্যালোচনা করা হল। পর্যালোচনায় দেখা যায় যে , " +
                    accuse +
                    " বক্তব্যে সত্যতা রয়েছে । " +
                    accuse +
                    " বিরুদ্ধে গঠিত অভিযোগ অস্বীকার করায় ও ব্যখ্যা সন্তোষজনক হওয়ায় মোবাইল কোর্ট আইন ,২০০৯-এর ৭(৩) ধারার বিধানমতে " +
                    accusePerson +
                    ' </span><span contenteditable="false" class="noneditable"> ' +
                    punishment[i].lawAndSectionDharaHote +
                    punishment[i].DistinctOrder +
                    "।</span>";
            }
            text +=
                '<div class=\'para\'> <span contenteditable="false" class="noneditable">' +
                punishment[i].CriminalName +
                "- এর বিরুদ্ধে আনীত " +
                punishment[i].lawAndSectionConfession +
                ",  </span>" +
                additionalText +
                "</div>";
        }
        return text;
    },
    formatDate: function (input) {
        var datePart = input.match(/\d+/g),
            year = bangla.toBangla(datePart[0]), // get only two digits
            month = bangla.toBangla(datePart[1]),
            day = bangla.toBangla(datePart[2]);

        return day + "-" + month + "-" + year;
    },
};

$(document).ready(function () {
    orderTemplate.init();
});
