        <div class="row">
            <input type="hidden" value="{{ $id }}" name="appeal_id">
            <input type="hidden" value="2" id="payment_type" name="payment_type">
            <input type="hidden" value="{{$loan_amount}}" id="loan_amount" name="loan_amount">
            <input type="hidden" value="{{$interestRate}}" id="interestRate" name="interestRate">

            <!-- <div class="col-md-4"> -->
                <div style="paymentgateway">
                
                    <img src="{{ asset('uploads/ekpaypayment.png') }}"  class="img-response payment" style="border-radius:20px;width:200px;margin-right: 10px;" id="ekpay">

                </div>
            <!-- </div> -->
            <!-- <div class="col-md-4"> -->
                <div style="paymentgateway">
                
                    <img src="{{ asset('uploads/blankimage.png') }}"  class="img-response payment" style="border-radius:20px;width: 200px;" id="blank">
                
                </div>
            <!-- </div> -->
        </div>

        <script>
         $(".payment").on('click',function(event){
          
          $(".payment").removeClass("active");
          console.log(event.target.id);
          // if(event.target.id=='ekpay'){
          //  $('#payment_type').val(1);
          // }else{
          //     $('#payment_type').val(2);
          // }
         $("#"+event.target.id).addClass("active");
          // var  formURL="/payment-process";
          // var fd = new FormData();
          var courtFee = 20;
          // var interestRate = $("#interestRate").val();
          // var totalLoanAmount = $("#totalLoanAmount").val();
          // var totalLoanAmountText = $("#totalLoanAmountText").val();
          // var transaction_no = $("#transaction_no").val();
          // var court_id = $("#court_id").val();
  
          // fd.append("courtFee", courtFee);
          // fd.append("totalLoanAmount", totalLoanAmount);
          // fd.append("totalLoanAmountText", totalLoanAmountText);
          // fd.append("interestRate", interestRate);
          // fd.append("court_id", court_id);
          // fd.append("payment_type",1);
          // fd.append("transaction_no",transaction_no);
          
          
          // Swal.fire({
          //     title: "",
          //     text: "আপনি কি ওয়ালেটের মাধ্যমে আপনার কোর্ট ফি 20 টাকা জমা করতে চান??",
          //     icon: "warning",
          //     showCancelButton: true,
          //     confirmButtonColor: "#3085d6",
          //     cancelButtonColor: "#d33",
          //     cancelButtonText: "না",
          //     confirmButtonText: "হ্যাঁ"
          // }).then((result) => {
          //     if (result.isConfirmed) {
          //     $.ajax({
          //         url: formURL,
          //         // headers: {
          //         // 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          //         // },
          //         type: "POST",
          //         data: fd,
          //         enctype: "multipart/form-data",
          //         processData: false,
          //         contentType: false,
          //         beforeSend: function () {
          //         },
          //         success: function(r) {
          //             console.log(r);
          //             // return false;
          //             window.location.href =r;
                    
          //         },
          //         error: function() {}
          //     });
          // }
             

          // });
      }); 
        </script>