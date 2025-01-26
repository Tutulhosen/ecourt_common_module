/**
 * Created by DOEL PC on 5/18/14.
 */
$(document).ready(function(){

//    Recaptcha.create("6Lfv3e8SAAAAACxAaNv7WqTmAuP81htL-ER65yiU", 'recaptcha_div', {
//        theme: "clean",
//        callback: Recaptcha.focus_response_field
//    });

    $('#timepicker4').timepicker({
        minuteStep: 5
    });


    $.fn.vjustify = function() {
        var maxHeight=0;
        $(".resize").css("height","auto");
        this.each(function(){
            if (this.offsetHeight > maxHeight) {
                maxHeight = this.offsetHeight;
            }
        });
        this.each(function(){
            $(this).height(maxHeight);
            if (this.offsetHeight > maxHeight) {
                $(this).height((maxHeight-(this.offsetHeight-maxHeight)));
            }
        });
    };


    $.fn.hoverClass = function(classname) {
        return this.hover(function() {
            $(this).addClass(classname);
        }, function() {
            $(this).removeClass(classname);
        });
    };
    //Callback handler for form submit event
    $("#multiform").submit(function(e)
    {

        var formObj = $(this);
        //var formURL = formObj.attr("action");
        var formURL = base_path + "/citizen_public_view/create";
        var formData = new FormData(this);

        $.ajax({
            url: formURL,
            type: 'POST',
            data:  formData,
            dataType: 'json',
            mimeType:"multipart/form-data",
            contentType: false,
            cache: false,
            processData:false,
            beforeSend:function(){
//                Recaptcha.create("6Lfv3e8SAAAAACxAaNv7WqTmAuP81htL-ER65yiU", 'recaptcha_div', {
//                    theme: "clean",
//                    callback: Recaptcha.focus_response_field
//                });
            },
            success: function(response, textStatus, jqXHR)
            {
                // var jsonObject = JSON.parse(response);
                if(response)
                {
                    if(response.flag == 'true'){
//                        $('#bookId').val(response.message);
                        setdata(response.message);

                        //clearForm();

//                        alert("asda");

//                        Recaptcha.reload();
                        $("#division").select2("val", "");
                        $("#zilla").select2("val", "");
                        $("#upazila").select2("val", "");
                        $("#CaseType").select2("val", "");

                        //                        $('#captchaimage').click();
                        document.getElementById('captchaimage').click();


                        $("#citycorporationdiv").fadeOut();
                        $("#metropolitandiv").fadeOut();
                        $("#upoziladiv").fadeOut();

                        $("#multiform")[0].reset();
                        $('#successcomplain').modal('show');

                    }else{
                        $('#bookId2').val(response.message);

                        // Recaptcha.reload();
                        $('#error').modal('show');
                        //clearForm();
                    }
                }

            },
            error: function(jqXHR, textStatus, errorThrown)
            {
            }
        });
        e.preventDefault(); //Prevent Default action.
        // e.unbind();

        return false;
    });

});

function captchaReload(){

}


function clearFileInputField(tagId) {
    document.getElementById(tagId).innerHTML =
        document.getElementById(tagId).innerHTML;
}

//function NESS_banglaToEnglishNumber($unicodeNumber) {
//    $englishNumber = mb_convert_encoding($unicodeNumber,"HTML-ENTITIES","UTF-8");
//    $englishNumber = str_replace('&#2534;', '0', $englishNumber);
//    $englishNumber = str_replace('&#2535;', '1', $englishNumber);
//    $englishNumber = str_replace('&#2536;', '2', $englishNumber);
//    $englishNumber = str_replace('&#2537;', '3', $englishNumber);
//    $englishNumber = str_replace('&#2538;', '4', $englishNumber);
//    $englishNumber = str_replace('&#2539;', '5', $englishNumber);
//    $englishNumber = str_replace('&#2540;', '6', $englishNumber);
//    $englishNumber = str_replace('&#2541;', '7', $englishNumber);
//    $englishNumber = str_replace('&#2542;', '8', $englishNumber);
//    $englishNumber = str_replace('&#2543;', '9', $englishNumber);
//    return $englishNumber; }
//
//function NESS_englishToBengaliNumber($Number) {
//    for($i=0;$i<strlen($Number);$i++)
//    { switch(substr($Number,$i,1))
//    { case '0': $unicodeNumber.= str_replace('0', '&#2534;', substr($Number,$i,1));
//            break; case '1': $unicodeNumber.= str_replace('1', '&#2535;', substr($Number,$i,1));
//            break; case '2': $unicodeNumber.= str_replace('2', '&#2536;', substr($Number,$i,1));
//            break; case '3': $unicodeNumber.= str_replace('3', '&#2537;', substr($Number,$i,1));
//            break; case '4': $unicodeNumber.= str_replace('4', '&#2538;', substr($Number,$i,1));
//            break; case '5': $unicodeNumber.= str_replace('5', '&#2539;', substr($Number,$i,1));
//            break; case '6': $unicodeNumber.= str_replace('6', '&#2540;', substr($Number,$i,1));
//            break; case '7': $unicodeNumber.= str_replace('7', '&#2541;', substr($Number,$i,1));
//            break; case '8': $unicodeNumber.= str_replace('8', '&#2542;', substr($Number,$i,1));
//            break; case '9': $unicodeNumber.= str_replace('9', '&#2543;', substr($Number,$i,1));
//            break; default: $unicodeNumber.= substr($Number,$i,1); } }
//    return $unicodeNumber;
//}

function banglaToEnglish(obj) {
    var banglaNumber=obj.value;
    var mobileNo = new String(banglaNumber);
    var englishNumber=new String() ;
    for(var i=0;i<mobileNo.length;i++)
    { if(mobileNo.charCodeAt(i)==2534) englishNumber=englishNumber+0;
    else if(mobileNo.charCodeAt(i)==2535) englishNumber=englishNumber+1;
    else if(mobileNo.charCodeAt(i)==2536) englishNumber=englishNumber+2;
    else if(mobileNo.charCodeAt(i)==2537) englishNumber=englishNumber+3;
    else if(mobileNo.charCodeAt(i)==2538) englishNumber=englishNumber+4;
    else if(mobileNo.charCodeAt(i)==2539) englishNumber=englishNumber+5;
    else if(mobileNo.charCodeAt(i)==2540) englishNumber=englishNumber+6;
    else if(mobileNo.charCodeAt(i)==2541) englishNumber=englishNumber+7;
    else if(mobileNo.charCodeAt(i)==2542) englishNumber=englishNumber+8;
    else if(mobileNo.charCodeAt(i)==2543) englishNumber=englishNumber+9; }
    if(englishNumber=="")
    {
        englishNumber=banglaNumber;
    }
    return englishNumber;
}