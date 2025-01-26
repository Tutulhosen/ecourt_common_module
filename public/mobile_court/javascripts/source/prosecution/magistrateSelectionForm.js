var magistrateForm={
    init:function () {
      
    },

    showMagistrate:function(select){
        
        if (select=="")
        {
            return;
        }
        else{

            var url = "/magistrate/getMagistrate?zillaid="+select;
            // get_select_data(select,url,magistrate);

            $.ajax({url:url,type:'POST',

                success:function(data) {
                    var sel_id = "#magistrate" ;
                    if(data.length>0)
                    {


                        $(sel_id).find("option:gt(0)").remove();
                        $(sel_id).find("option:first").text("বাছাই করুন ...");

                        //$(sel_id).find("option:first").text("");
                        for (var i = 0; i < data.length; i++)
                        {
                            $("<option/>").attr("value", data[i].id).text(data[i].name_eng).appendTo($(sel_id));
                        }
                    }else{
                        $(sel_id).find("option:gt(0)").remove();
                        $(sel_id).find("option:first").text("বাছাই করুন ...");

                    }
                },
                error:function() {
                },
                complete:function() {
                }
            });
        }
    },

    showScheduleByMagistrateId:function(select){
        // alert(select)
    // $('#prosecutionform').find('.wizard .next').addClass('hide');
        if (select=="")
        {
            return;
        }
        else{
           
            var url ="/court/getScheduleByMagistrateId/"+select;
            // console.log(url);
            // return false;
            $.ajax({url:url,type:'POST',

                success:function(data) {

                    if(data.length>0){
                        $('#schedulemsg').val(data[0].msg);
                        $('.selectMagistrateCourtId').val(data[0].court_id);
                        if(data[0].court_id !=""){
                            $("#court_id").val(data[0].court_id);
                            $("#magistrate_id").val(select);
                            $("#magistrate_witness_id").val(select);
                            $("#magistrate_criminal_id").val(select);
                            $("#magistrate_crime_id").val(select);

                            $("#prosecutiondiv").fadeIn();
                            document.getElementById("nextpage").style.display="block";
                        }
                        else{
                            $("#prosecutiondiv").fadeOut();
                            document.getElementById("nextpage").style.display="none";
                        }

                    }else{
                        $('#schedulemsg').val("");
                    }
                    //$('#prosecutionform').find('.wizard .next').removeClass('hide');
                },
                error:function() {
                },
                complete:function() {
                }
            });
        }
    },

    nextTab:function () {

        if(!validator.validateFields("#courtselectform")){
            alert("সকল তথ্য সঠিক ভাবে দেওয়া হয়নি। ","অবহতিকরণ বার্তা");
           return false;
       }
        var magistrateSelect=$("#magistrate").val();
 
        $("#selectMagistrateId").val(magistrateSelect);


        $("#tab-1 a").tab('show');

        // $(".tab-pane").removeClass("active");
        // $(".nav-tabs li").removeClass("active");
        // $("#tab1-2").addClass("active");
        // $(".nav-tabs li:eq(1)").addClass("active");

    },

    setMagistrateInfo:function(magistrateInfo){
        console.log(magistrateInfo);
        $('#zilla').val(magistrateInfo.zillaId).change();
        $('#magistrate').val(magistrateInfo.magistrate_id);
        $('#selectMagistrateId').val(magistrateInfo.magistrate_id);
        //
        $('#zilla').attr('disabled', 'disabled');
        $('#magistrate').attr('disabled', 'disabled');
    }


};
$(document).ready(function () {
    magistrateForm.init();

});