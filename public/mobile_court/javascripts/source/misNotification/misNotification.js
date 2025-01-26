var misNotification = {
    init: function () {
        let levelValue =$('#levelValue').val();
        if(levelValue==1){
            $('#levelTitle').html('প্রথম লেভেল নোটিফিকেশন কনফিগারেশন');
            misNotification.getNotificationsData(levelValue).done(function (response,textStatus,jqXHR) {
                misNotification.populateConfigData(response);
            })
        }else if (levelValue==2){
            $('#levelTitle').html('দ্বিতীয় লেভেল নোটিফিকেশন কনফিগারেশন');
            misNotification.getNotificationsData(levelValue).done(function (response,textStatus,jqXHR) {
                misNotification.populateConfigData(response);
            })
        }else if (levelValue==3){
            $('#levelTitle').html('তৃতীয় লেভেল নোটিফিকেশন কনফিগারেশন');
            $('.notificationProfileClass').addClass('hidden');
            misNotification.getNotificationsData(levelValue).done(function (response,textStatus,jqXHR) {
                misNotification.populateConfigData(response);
            })
        }
    },
    getNotificationsData: function (levelValue) {
        var url = '/misnotification/getNotificationsData/' + levelValue;
        return $.ajax({url: url, dataType: 'json'});
    },
    populateConfigData: function (data) {
        console.log(data);
        $('#notificationId').val(data.id);
        $('#notificationLevelType').val(data.notificationLevelType);
        $('#notificationDate').val(data.notificationDate);
        $('#notificationBody').val(data.notificationBody);
        $.each(data.profileId , function(index, val) {
            // console.log(data.profileId);
            if(val=='8'){
                $('#notificationProfile2').prop('checked', true);
            }
            else if(val=='34'){
                $('#notificationProfile1').prop('checked', true);
            }
            else if(val=='38'){
                $('#notificationProfile3').prop('checked', true);
            }
            else if(val=='37'){
                $('#notificationProfile4').prop('checked', true);
            }
            else if(val=='27'){
                $('#notificationProfile5').prop('checked', true);
            }
        });
    },
    saveNotificationConfiguredData: function () {

                                        
        // if(!validator.validateFields("#suomotcourtcriminalform")){
        //     $.alert("সকল তথ্য সঠিক ভাবে দেওয়া হয়নি। ","অবহতিকরণ বার্তা");
        //     return false;
        // }
        var model = misNotification.populateModel();
        console.log(model);    
        // return false;                        
        var formURL = "/misnotification/createNotificationsData";
        $.ajax({
            url: formURL,
            type: 'POST',
            dataType: 'json',
            data: {'data': model},
            success: function (response, textStatus, jqXHR) {
                if (response == true) {
                     alert("তথ্য সংরক্ষণ করা হয়েছে। ", "ধন্যবাদ");
                } else {
                     alert(response, "অবহতিকরণ বার্তা");
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("তথ্য সংরক্ষণ হয়নি। ", "অবহতিকরণ বার্তা");
            }
        });
    },
    populateModel: function () {

        var model = {};
    
        model.id = $('#notificationId').val();
        model.notificationDate=$('#notificationDate').val();
        model.notificationBody=$('#notificationBody').val();
        model.levelValue = $('#levelValue').val();
        model.notificationLevelTypeString=$('#notificationLevelType').val();
        model.profilesId = [];
       
        $('.notificationProfile:checked').each(function(i){
            model.profilesId[i] = $(this).val();
        });
       

        return model;
    },
};
$(document).ready(function () {
    misNotification.init();
});