<!-- court fee  with eakpay payment  -->
<div class="row">
    <div class="col-md-12">

       <div class="form-group">
          <h1 style="background-color: #008841;color: #fff;padding: 2px 10px;">কোর্ট ফি প্রদান করুন</h1>
       </div>
       
    </div>
    <div class="col-md-4">
       <div style="paymentgateway ">
      
         <img src="{{ asset('uploads/ekpaypayment.png') }}"  class="img-response payment" style="border-radius: 20px;" id="ekpay">

        </div>
    </div>
    <div class="col-md-4">
       <div style="paymentgateway">
      
         <img src="{{ asset('uploads/blankimage.png') }}"  class="img-response payment" style="border-radius: 20px;" id="blank">
       
        </div>
    </div>
   
</div>
<br><br>
<div class="row">
    <div class='col-sm-4'>
    
        
        <div class="form-group">
            <label for="court_fee_amount" class="control-label"><span
                    style="color:#FF0000">*
                </span>কোর্ট ফি</label>
            <div class="input-group">
                <input type="text" name="court_fee_amount" id="court_fee_amount"
                    class="form-control form-control-sm " value="{{(!empty($court_fee)?$court_fee:'')}}" >
            
            </div>
        </div>
    </div>
</div>