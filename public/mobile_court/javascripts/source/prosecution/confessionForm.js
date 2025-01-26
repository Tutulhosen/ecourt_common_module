var confessionFrom={

    init:function () {
  
    },
  
    getConfessionInfo: function () {
          var confession = {};
  
        confession.prosecutionID = $('#txtProsecutionID').val();
        confession.criminalConfessionDetails = [];
  
        $('.confessiondiv').each(function (i, x) {
            confession.criminalConfessionDetails.push(confessionFrom.getCriminalInfo(x));
        });
          return confession;
      },
  
      getCriminalInfo:function(confessiondiv){
          var criminal = {};
  
          criminal.criminalID = $($(confessiondiv).find('.criminalID')[0]).val();
          criminal.confession = $($(confessiondiv).find('.confession')[0]).val();
  
          criminal.brokenLaws = [];
          $(confessiondiv).find('.trLawsBroken').each(function (i, trLawsBroken) {
              brokenLaw = {};
              brokenLaw.lawsBrokenID = $(trLawsBroken).attr('lawsBrokenID');
              var confession = 0;
              $(trLawsBroken).find('.chkConfession').each(function (j, chkConfession) {
                  if(this.checked) {
                      confession = $(this).hasClass('chkConfessionYes') ? 1 : 0;
                  }
              });
              brokenLaw.confessed = confession;
              criminal.brokenLaws.push(brokenLaw);
          });
  
          return criminal;
      },
  
  
    save:function () {
        if(!validator.validateFields("#confessionform")){
             alert("সকল তথ্য সঠিক ভাবে দেওয়া হয়নি। ","অবহতিকরণ বার্তা");
            return false;
        }
  
        var model = confessionFrom.getConfessionInfo();
        var formObj = $('#confessionform');
        // if(!$(formObj).valid()) {
        //     return false;
        // }
        var formURL = "/prosecution/saveCriminalConfessionSuomotu";
        var formData = new FormData(formObj[0]);
        formData.append( 'modelData', JSON.stringify(model));
  
      //   $.confirm({
      //       resizable: false,
      //       height: 250,
      //       width: 400,
      //       modal: true,
      //       title: "জবানবন্দি",
      //       titleClass: "modal-header",
      //       content: "ফরমটি সংরক্ষণ করতে চান ?",
      //       buttons: {
      //           "না": function () {
      //               // $(this).dialog("close");
      //           },
      //           "হ্যাঁ": function () {
                  
      //               $.ajax({
      //                   url: formURL,
      //                   type: 'POST',
      //                   data: formData,
      //                   dataType: 'json',
      //                   mimeType: "multipart/form-data",
      //                   contentType: false,
      //                   cache: false,
      //                   processData: false,
      //                   beforeSend:function(){
      //                   },
      //                   success: function(response, textStatus, jqXHR)
      //                   {
      //                       if(response.flag == 'true'){
  
      //                           if(response.isSuomoto==0){
      //                               var baseUrl = document.location.origin;
      //                               window.location.href = baseUrl+'/prosecution/searchComplain/';
      //                           }else {
      //                               $.alert("আসামির সাক্ষ্য গ্রহণ করা হয়েছে । ","অবহতিকরণ বার্তা");
      //                               $(window).scrollTop(0);
      //                               prosecutionInit.setTabIndex(response.step);
      //                           }
  
      //                       }else{
      //                           $.alert("তথ্য অসম্পূর্ন থাকায় আবেদনটি গ্রহণ করা হয়নি ।  পূনরায় চেষ্টা করুন ।  ", "ধন্যবাদ");
      //                       }
      //                   },
      //                   error: function(jqXHR, textStatus, errorThrown)
      //                   {
      //                       $.alert("অভিযোগ গঠন সম্পন্ন হয়নি ।  পূনরায় চেষ্টা করুন ।  ", "অবহতিকরণ বার্তা");
      //                   }
      //               });
      //           }
      //       }
      //   });
    
      Swal.fire({
          title: "জবানবন্দি",
          text: "ফরমটি সংরক্ষণ করতে চান ?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          cancelButtonText: "না",
          confirmButtonText: "হ্যাঁ"
      }).then((result) => {
            $.ajax({
                url: formURL,
                type: 'POST',
                data: formData,
                dataType: 'json',
                mimeType: "multipart/form-data",
                contentType: false,
                cache: false,
                processData: false,
                beforeSend:function(){
                },
                success: function(response, textStatus, jqXHR)
                {
                  // prosecutionInit.setTabIndex(response.step);
                  if(response.flag == 'true'){
  
                      if(response.isSuomoto==0){
                          var baseUrl = document.location.origin;
                          window.location.href = baseUrl+'/prosecution/searchComplain/';
                      }else {
                          //  alert("আসামির সাক্ষ্য গ্রহণ করা হয়েছে । ","অবহতিকরণ বার্তা");
                           Swal.fire({
                              title: "অবহতিকরণ বার্তা!",
                              text: "আসামির সাক্ষ্য গ্রহণ করা হয়েছে ।",
                              icon: "success"
                          });
                          $(window).scrollTop(0);
                          prosecutionInit.setTabIndex(response.step);
                      }
  
                  }else{
                      Swal.fire({
                          title: "ধন্যবাদ!",
                          text: "তথ্য অসম্পূর্ন থাকায় আবেদনটি গ্রহণ করা হয়নি ।  পূনরায় চেষ্টা করুন ।  ",
                          icon: "success"
                      });
  
                      // alert("তথ্য অসম্পূর্ন থাকায় আবেদনটি গ্রহণ করা হয়নি ।  পূনরায় চেষ্টা করুন ।  ", "ধন্যবাদ");
                  }
                },
                error: function(jqXHR, textStatus, errorThrown)
                {
                  //   alert("অভিযোগ গঠন সম্পন্ন হয়নি ।  পূনরায় চেষ্টা করুন ।  ", "অবহতিকরণ বার্তা");
                  Swal.fire({
                      title: "অবহতিকরণ বার্তা",
                      text: "অভিযোগ গঠন সম্পন্ন হয়নি ।  পূনরায় চেষ্টা করুন ।  ",
                      icon: "success"
                  });
                }
            });
  
       });
  
  
     }
  };
  
  $(document).ready(function () {
      confessionFrom.init();
  
  });