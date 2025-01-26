var admStatus = {
    init:function () {
        $('#dataTable').dataTable();
    },

    changeStatus:function (e, f) {
        var admID = e ;
        var admStatus = '';
        if ($(f).is(':checked')) {
            $(f).next("span").html('Active');
            admStatus = 'Checked';
        } else {
            $(f).next("span").html('Inactive');
            admStatus = 'Unchecked';
        }

        var formData = new FormData();
        formData.append('admID', admID);
        formData.append('admStatus', admStatus);

        console.log(admStatus);

        $.ajax({
            url:"editAdmStatus",
            method:"post",
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,

            success:function () {

            }
        })
    },
};

$(document).ready(function () {
    admStatus.init();
});
