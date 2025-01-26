/**
 * Created by DOEL PC on 4/28/14.
 */




$(document).ready(function(){

//    //Callback handler for form submit event
    $("#saveComplainForm").submit(function(e){

        var formObj = $(this);
        var formURL ="/magistrate/saveFeedback";
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
            },
            success: function(response, textStatus, jqXHR)
            {
                console.log(response);
                // return false;
                if(response)
                {
                    if(response.flag == 'true'){
                    //    $.alert("save successfully");
                       Swal.fire({
                        title:'',// "অবহতিকরণ বার্তা!",
                        text: response.message,
                        icon: "success"
                         });
                        clearModallForm();
                        $('#complainInfo').modal('hide');
                        var baseUrl = document.location.origin;
                        window.location.href = baseUrl+'/magistrate/complainVarification';

                    }else{
                        // $.alert("error");
                        Swal.fire({
                            title:'',// "অবহতিকরণ বার্তা!",
                            text: "error ।",
                            icon: "success"
                        });
                        $('#complainInfo').modal('hide');
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

function clearModallForm(){
    $('#feedback').val("");
    $('.radio-input').prop('checked', false);
}

function showComplain(id){



    $('#id').val(id);
    $('#complainInfo').modal('show');

    if(id == "" ){

        return
    }
    var url ="/citizen_complain/getCitizen_complainByReqId?reqid="+id;
    $.ajax({
        url: url,
        type: 'POST',
        success:function(data) {

            if(data.length>0)
            {
                var name = "#name" ;
                var cmp_mobile = "#cmp_mobile" ;
                var email = "#email" ;

                var cmp_subject = "#cmp_subject" ;
                var cmp_details = "#cmp_details" ;

                $(name).val(data[0].name);
                $(cmp_mobile).val(data[0].mobile);
                $(cmp_subject).val(data[0].subject);
                $(cmp_details).val(data[0].complain_details);

            }
        },
        error:function() {
        },
        complete:function() {
        }
    });
}



