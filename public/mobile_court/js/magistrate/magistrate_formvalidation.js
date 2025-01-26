/**
 * Created by DOEL PC on 5/26/14.
 */
$(document).ready(function(){
//
//    (function($) {
//        $("#magistrateform").validate({
//            rules: {
//                mobile: {required: true,
//                maxlength: 11},
//                division: {required: true},
//                national_id: {
//                    required: true,
//                    maxlength: 17
//                },
//                email: {required: true},
//                name_eng: {required: true},
//                name_bng: {required: true},
//                date_of_birth: {required: true},
//                permanent_address: {required: true},
//                present_address: {required: true},
//                service_id: {required: true}
//            },
//            messages: {
//                example5: "Just check the box<h5 class='text-error'>You aren't going to read the EULA</h5>",
//                national_id: {
//                    maxlength: jQuery.format("Max {17} digits allowed!")
//                },
//                email: {
//                    maxlength: jQuery.format("invalid email address")
//                }
//            },
//            tooltip_options: {
//                national_id: {placement:'top',html:true}
//            },
//            onkeyup: false,
//            debug:true
//        });
//    })(jQuery);

//    $(".resize").vjustify();
//    $("div.buttonSubmit").hoverClass("buttonSubmitHover");
//    $("#mobile_no").mask("99999999999");
//    $("#national_id").mask("9999 99 9 99 99 999999");
//    $("#witness1_mobile_no").mask("99999999999");
//    $("#witness2_mobile_no").mask("99999999999");
//    $("#witness1_nationalid").mask("9999 99 9 99 99 999999");
//    $("#witness2_nationalid").mask("9999 99 9 99 99 999999");

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

    var h2s = $('.accordion>h2').click(function () {
        //fade in/out info
        if($(this).find( ".info" ).is(":visible") ){
            $(this).find( ".info" ).css( "color" ,"#323232").fadeOut();
            h2s.not(this).find( ".info" ).fadeIn();
        }else{
            $(this).find( ".info" ).fadeIn();
            h2s.not(this).find( ".info" ).fadeIn();
        }

        //expand div
        h2s.not(this).removeClass('active');
        $(this).toggleClass('active');
        //hide div
        divs.not($(this).next()).slideUp();
        $(this).next().slideToggle();

        // return false; //Prevent the browser jump to the

    });

    //    //Callback handler for form submit event
    $("#magistrateform").submit(function(e)
    {
        var formObj = $(this);
        var formURL = base_path +  "/admin_panel/createmagistrate";
        var formData = new FormData(this);


        console.log(formData);
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
            },
            success: function(response, textStatus, jqXHR)
            {
                if(response.flag == 'true'){
                    $.confirm({
                        title: 'ধন্যবাদ!',
                        content: 'ম্যাজিস্ট্রেটের প্রোফাইল সফলভাবে সংরক্ষণ করা হয়েছে ।',
                        buttons: {
                            ok: function () {
                                location.reload();
                            }
                        }
                    });
//                    clearForm();
                }else{
                    alert(response.message);
//                    $('#error').modal('show');
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

function clearForm(){


    $('#mobile').val("");
    $('#national_id').val("");
    $('#email').val("");
    $('#name_eng').val("");
    $('#name_bng').val("");
    $('#date_of_birth').val("");
    $('#permanent_address').val("");
    $('#present_address').val("");
    $('#zilla').val("");
    $('#designation_bng').val("");
    $('#phone').val("");
    $('#service_id').val("");
}

