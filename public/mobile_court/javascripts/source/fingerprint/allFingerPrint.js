var fingurePrint={
    init: function () {
        
    },
    isValidURL: function (url) {
        var isValid = false;
        $.ajax({
            url: url,
            type: "get",
            async: false,
            dataType: "json",
            success: function(data) {
                isValid = true;
            },
            error: function(){
                isValid = false;
            }
        });
        return isValid;
    },


    call_ajaxfunctionforDatafp_url: function (elememnt_id ,element_id_2,elememnt_id_form,fp_url) {
        $.ajax(fp_url)
            .done(function(fingerprint_data) {

                if(fingerprint_data.error) {
                    alert(fingerprint_data.error);
                }
                else {

                    var  element_id_bmpImage  =  element_id_2 + "_BMP";

                    //Id that Display image at form
                    document.getElementById(elememnt_id).src = "data:image/bmp;base64," + fingerprint_data.imageBase64;
                    document.getElementById(elememnt_id).value = fingerprint_data.ISOTemplateBase64;
                    //Id that Contain Value of  template which  save in matching db
                    //Value of bmp to save in app db
                    document.getElementById(element_id_2).value = fingerprint_data.imageBase64;
//            //Form id that contain template image use  for Search
//            document.getElementById(elememnt_id_form).value = fingerprint_data.fp_data;
                    //Form id that contain template image use  for Search
                    document.getElementById(elememnt_id_form).value = fingerprint_data.fp_data;
                }
            })
            .fail(function( jqXHR, textStatus, errorThrown ) {
                //ERROR could not get Fingerprint
                var json=jqXHR.responseJSON;
                var fp_error= json && json.hasOwnProperty("error") ? json.error : "Error Occurred." ;
                alert(fp_error);//HANDLE ERROR HERE
            });
    },
    call_ajaxfunctionforDatafp_urlWitness:function (elememnt_id ,element_id_2,elememnt_id_form,fp_url) {
        $.ajax(fp_url)
            .done(function(fingerprint_data) {

                if(fingerprint_data.error) {
                    alert(fingerprint_data.error);
                }
                else {

                    //Id that Display image at form
                    document.getElementById(elememnt_id).src = "data:image/bmp;base64," + fingerprint_data.imageBase64;
                    document.getElementById(elememnt_id).value = fingerprint_data.ISOTemplateBase64;
                    //Id that Contain Value of  template which  save in matching db
                    document.getElementById(element_id_2).value = fingerprint_data.fp_data;
//            //Form id that contain template image use  for Search
//            document.getElementById(elememnt_id_form).value = fingerprint_data.fp_data;
                    //Form id that contain template image use  for Search
                    //Value of bmp to save in app db
                    document.getElementById(elememnt_id_form).value = fingerprint_data.imageBase64;
                }
            })
            .fail(function( jqXHR, textStatus, errorThrown ) {
                //ERROR could not get Fingerprint
                var json=jqXHR.responseJSON;
                var fp_error= json && json.hasOwnProperty("error") ? json.error : "Error Occurred." ;
                alert(fp_error);//HANDLE ERROR HERE
            });
    },
    captureFP_criminal: function(finguretype,criminal_no) {

    // Id that Display image at form  : elememnt_id  // iLEFT_THUMB_1
    // Id that Contain Value of template which  save in matching db  : element_id_2  //criminal_1LEFT_THUMB
    // Form id that contain template image use  for Search  : elememnt_id_form   // LEFT_THUMB1

    var elememnt_id = "";
    var element_id_2 = "";
    var elememnt_id_form = "";

    if(finguretype == 1){
        elememnt_id   = "iLEFT_THUMB_"+criminal_no ;
        element_id_2  =  "criminal_LEFT_THUMB_BMP_"+criminal_no;
        elememnt_id_form = "criminal_LEFT_THUMB_" +criminal_no ;
    }else if(finguretype == 2){
        elememnt_id  = "iLEFT_INDEX_"+criminal_no;
        element_id_2  = "criminal_"+criminal_no+"LEFT_INDEX";
        elememnt_id_form = "LEFT_INDEX1_"+criminal_no ;
    }else if(finguretype == 3){
        elememnt_id  = "iRIGHT_THUMB_"+criminal_no;
        element_id_2  = "criminal_RIGHT_THUMB_BMP_"+criminal_no;
        elememnt_id_form = "criminal_RIGHT_THUMB_"+criminal_no ;
    }else if(finguretype == 4){
        elememnt_id  = "iRIGHT_INDEX_"+criminal_no;
        element_id_2  = "criminal_"+criminal_no+"RIGHT_INDEX";
        elememnt_id_form = "RIGHT_INDEX1"+criminal_no ;
    }

    var fp_url="http://localhost:9000";
    var flag = fingurePrint.isValidURL(fp_url);

    if(flag){
        // CallSGIFPGetDatalt(elememnt_id ,element_id_2,elememnt_id_form,uri, SuccessFunclt, ErrorFunclt);
        fingurePrint.call_ajaxfunctionforDatafp_url(elememnt_id ,element_id_2,elememnt_id_form,fp_url);
    }else{
        uri = "http://localhost:8000";
        //CallSGIFPGetDatalt(elememnt_id ,element_id_2,elememnt_id_form,uri,SuccessFunclt, ErrorFunclt);
        fingurePrint.call_ajaxfunctionforDatafp_url(elememnt_id ,element_id_2,elememnt_id_form,fp_url);
    }

},
    captureFP_witness: function (finguretype,witness_no) {
        // Id that Display image at form  : elememnt_id  // iLEFT_THUMB_W_1
        // Id that Contain Value of template which  save in matching db  : element_id_2  // witness_1_LEFT_THUMB
        // Form id that contain template image use  for Search  : elememnt_id_form   //   witnessLEFT_THUMB1_W1

        var elememnt_id = "";
        var element_id_2 = "";
        var elememnt_id_form = "";

        if(finguretype == 1){
            elememnt_id   = "iLEFT_THUMB_W_"+witness_no ;
            element_id_2  =  "witness"+witness_no+"_LEFT_THUMB";
            elememnt_id_form = "witness"+ witness_no+"_LEFT_THUMB_BMP" ;

            // alert(elememnt_id_form);
        }else if(finguretype == 2){
            elememnt_id  = "iLEFT_INDEX_W_"+witness_no;
            element_id_2  = "witness"+witness_no+"_LEFT_INDEX";
            elememnt_id_form = "witnessLEFT_INDEX1_W" + witness_no;
        }else if(finguretype == 3){
            elememnt_id  = "iRIGHT_THUMB_W_"+witness_no;
            element_id_2  = "witness"+witness_no+"_RIGHT_THUMB";
            elememnt_id_form = "witness"+ witness_no+"_RIGHT_THUMB_BMP" ;
            // alert(elememnt_id_form);
        }else if(finguretype == 4){
            elememnt_id  = "iRIGHT_INDEX_W_"+witness_no;
            element_id_2  = "witness"+witness_no+"_RIGHT_INDEX";
            elememnt_id_form = "witnessRIGHT_INDEX1_W" + witness_no;
        }
        var fp_url="http://localhost:9000";
        var flag = fingurePrint.isValidURL(fp_url);

        if(flag){
            // CallSGIFPGetDatalt(elememnt_id ,element_id_2,elememnt_id_form,uri, SuccessFunclt, ErrorFunclt);
            fingurePrint.call_ajaxfunctionforDatafp_urlWitness(elememnt_id ,element_id_2,elememnt_id_form,fp_url);
        }else{
            uri = "http://localhost:8000";
            //CallSGIFPGetDatalt(elememnt_id ,element_id_2,elememnt_id_form,uri,SuccessFunclt, ErrorFunclt);
            fingurePrint.call_ajaxfunctionforDatafp_urlWitness(elememnt_id ,element_id_2,elememnt_id_form,fp_url);
        }
    },
    witness1_formFormSubmit: function() {


        var url1 = 'https://gateway.secugenbangladesh.com/api/v1/SearchFp';
        var url2 = base_path + "/criminal/getCriminalById";
        //            submitSearchForm_witness1(url1,url2);

        var variable11 = 0;
        var variable21 = 0;


        var LeftThumb = $("#witness1_LEFT_THUMB").val();
        var RightThumb = $("#witness1_RIGHT_THUMB").val();

        //        alert(LeftThumb);
        //        alert(RightThumb);



        var dtarray = [];
        if (typeof(LeftThumb) !== 'undefined' && LeftThumb != "") {
            dtarray.push({"FingerName": "Leftthumb", "FpTemplate": LeftThumb});
        }
        if (typeof(RightThumb) !== 'undefined' && RightThumb != "") {
            dtarray.push({"FingerName": "Rightthumb", "FpTemplate": RightThumb});
        }

        var dt = {
            "Fingerprints": dtarray
        };

        dt=JSON.stringify(dt);

        $.ajax({
            "type"        : "POST",
            "url"         : url1,
            "contentType" : "application/json; charset=utf-8",
            "headers"     : { "api_key": "123" },
            "cache"       : false,
            "data"        : dt,
            "dataType"    : "json",
            success: function (reply) {
                if (reply.data[0]["IsMatched"]) {
                    // $('#witness1_m_user_type').val(reply.data[0]["UserType"]);
                    // $('#witness1_m_user_id').val(reply.data[0]["UserId"]);
                    $('#witness1_repeat_crime').val(2);
                    $.alert("তথ্য আছে  । ", 'অবহিতকরণ বার্তা');

                } else {
                    $.alert("তথ্য পাওয়া যায়নি।", 'অবহিতকরণ বার্তা');
                }
            }
        });
    },

    witness2_formFormSubmit: function() {

//        alert("test witness 2");
        var url1 = 'https://gateway.secugenbangladesh.com/api/v1/SearchFp';
    //        var url2 = base_path + "/criminal/getCriminalById";
    //            submitSearchForm_witness2(url1,url2);
        var variable11 = 0;
        var variable21 = 0;

        var LeftThumb = $("#witness2_LEFT_THUMB").val();
        var RightThumb = $("#witness2_RIGHT_THUMB").val();


        var dtarray = [];
        if (typeof(LeftThumb) !== 'undefined' && LeftThumb != "") {
            dtarray.push({"FingerName": "Leftthumb", "FpTemplate": LeftThumb});
        }
        if (typeof(RightThumb) !== 'undefined' && RightThumb != "") {
            dtarray.push({"FingerName": "Rightthumb", "FpTemplate": RightThumb});
        }

        var dt = {
            "Fingerprints": dtarray
        };



        dt=JSON.stringify(dt);
    //            console.warn(dt);
        $.ajax({
            "type"        : "POST",
            "url"         : url1,
            "contentType" : "application/json; charset=utf-8",
            "headers"     : { "api_key": "123" },
            "cache"       : false,
            "data"        : dt,
            "dataType"    : "json",
            success: function (reply) {
                if (reply.data[0]["IsMatched"]) {
                    // $('#witness2_m_user_type').val(reply.data[0]["UserType"]);
                    // $('#witness2_m_user_id').val(reply.data[0]["UserId"]);
                    $('#witness2_repeat_crime').val(2);

                    $.alert("তথ্য আছে  । ", 'অবহিতকরণ বার্তা');

                } else {
                    $.alert("তথ্য পাওয়া যায়নি।", 'অবহিতকরণ বার্তা');
                }
            }
        });

    },
    signaturetest: function(id2) {
        var url1 = 'https://gateway.secugenbangladesh.com/api/v1/SearchFp';
        var url2 = base_path + "/criminal/getCriminalById";
        var variable11 = 0;
        var variable21 = 0;
        var criminalID  = 0;

        var  criminal_no =  id2;

        var LeftThumb = $("#criminal_LEFT_THUMB_"+criminal_no).val();
        var RightThumb = $("#criminal_RIGHT_THUMB_"+criminal_no).val();

        var dtarray = [];
        if (typeof(LeftThumb) !== 'undefined' && LeftThumb != "") {
            dtarray.push({"FingerName": "Leftthumb", "FpTemplate": LeftThumb});
        }
        if (typeof(RightThumb) !== 'undefined' && RightThumb != "") {
            dtarray.push({"FingerName": "Rightthumb", "FpTemplate": RightThumb});
        }
        var dt = {
            "Fingerprints": dtarray
        };

        dt=JSON.stringify(dt);
        $.ajax({
            "type"        : "POST",
            "url"         : url1,
            "contentType" : "application/json; charset=utf-8",
            "headers"     : { "api_key": "123" },
            "cache"       : false,
            "data"        : dt,
            "dataType"    : "json",
            success: function (reply) {

                criminalID = reply.data[0]["UserId" + "type "  +  reply.data[0]["UserType"]];
                if (reply.data[0]["IsMatched"]) {
                    if(reply.data[0]["UserType"] == 1){

                        $.ajax({
                            type: 'POST',
                            url: url2,
                            cache: false,
                            data: {variable1: reply.data[0]["IsMatched"], ld: reply.data[0]["UserId"]},
                            dataType: 'json',
                            success: function (data2) {
                                if(data2.flag[0] == 'true'){
                                    console.warn(data2.criminal);
                                    // alert("test");
                                    var myStringArray = data2.criminal;
                                    criminal.setCriminalForm(myStringArray);
    //                                 var arrayLength = myStringArray.length;
    //                                 for (var i = 0; i < arrayLength; i++) {
    // //                                        var j =  i +1 ;
    //                                     var j =  criminal_no ;
    //                                     //alert(myStringArray[i].criminal_name);
    //                                     $("#criminal_id_"+j).val(myStringArray[i].id);
    //                                     $("#criminal_name_"+j).val(myStringArray[i].criminal_name);
    //                                     $("#criminal_custodian_name_"+j).val(myStringArray[i].criminal_custodian_name);
    //                                     $("#occupation_"+j).val(myStringArray[i].occupation);
    //                                     $("#criminal_zilla_"+j).val(myStringArray[i].criminal_zilla);
    //                                     $("#organization_name_"+j).val(myStringArray[i].organization_name);
    //                                     $("#trade_no_"+j).val(myStringArray[i].trade_no);
    //                                     $("#present_address_"+j).val(myStringArray[i].present_address);
    //                                     $("#permanent_address_"+j).val(myStringArray[i].permanent_address);
    //                                     $("#criminal_GeoThanas_"+j).val(myStringArray[i].criminal_GeoThanas);
    //                                     $("#criminal_GeoMetropolitan_"+j).val(myStringArray[i].criminal_GeoMetropolitan);
    //                                     $("#criminal_GeoCityCorporations_"+j).val(myStringArray[i].criminal_GeoCityCorporations);
    //                                     $("#criminal_upazila_"+j).val(myStringArray[i].criminal_upazila);
    //                                     $("#locationtype"+j).val(myStringArray[i].locationtype);
    //                                     $("#mobile_no_"+j).val(myStringArray[i].mobile_no);
    //                                     $("#gender_"+j).val(myStringArray[i].gender);
    //                                     $("#age_"+j).val(myStringArray[i].age);
    //                                     $("#email_"+j).val(myStringArray[i].email);
    //                                     $("#national_id_"+j).val(myStringArray[i].national_id);
    //                                     $("#mother_name_"+j).val(myStringArray[i].mother_name);
    //                                     $("#custodian_type_"+j).val(myStringArray[i].custodian_type);
    //                                     $("#criminal_repeat_crime_"+j).val(2);
    //                                     $("#criminal_m_user_id_"+j).val(reply.data[0]["UserId"]);
    //                                     $("#criminal_m_user_type_"+j).val(reply.data[0]["UserType"]);
    //                                     $("#iLEFT_THUMB_"+j).val(myStringArray[i].iLEFT_THUMB);
    //                                     $("#iRIGHT_THUMB_"+j).val(myStringArray[i].iRIGHT_THUMB);
                                        //Do something

                                    $.alert("তথ্য আছে।", 'অবহিতকরণ বার্তা');
                                }else {
                                    $.alert("তথ্য পাওয়া যায়নি।", 'অবহিতকরণ বার্তা');
                                }
                            }
                        });
                    }
                    else{
                        $("#criminal_repeat_crime_"+id2).val(1);
                        $("#criminal_m_user_id_"+id2).val(reply.data[0]["UserId"]);
                        $("#criminal_m_user_type_"+id2).val(reply.data[0]["UserType"]);

                        $.alert("তথ্য আছে। ইতঃপূর্বে তিনি একজন সাক্ষী ছিলেন।", 'অবহিতকরণ বার্তা');
                    }
                } else {
                    $.alert("তথ্য পাওয়া যায়নি।", 'অবহিতকরণ বার্তা');
                }
            }
        });
    }

};
$(document).ready(function () {
    fingurePrint.init();
});