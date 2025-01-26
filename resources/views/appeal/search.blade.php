
<form class="form-inline" method="POST" action="{{route('gcc.closed_list.search')}}">

    @csrf

    <div class="container">
       <div class="row">
          <div class="col-lg-3 mb-5">
             <input type="text" name="date_start" id="date_start" class="w-100 form-control common_datepicker" placeholder="তারিখ হতে" autocomplete="off">
          </div>
          <div class="col-lg-3 mb-5">
             <input type="text" name="date_end" id="date_end" class="w-100 form-control common_datepicker" placeholder="তারিখ পর্যন্ত" autocomplete="off">
          </div>
          <div class="col-lg-3">
                <input type="text" class="form-control w-100" id="case_no" name="case_no" placeholder="মামলা নং" value="">
          </div>
          <div class="col-lg-3 ">
             <button type="submit" class="btn btn-success font-weight-bolder mb-2 ml-2" id="search_btn">অনুসন্ধান করুন</button>
          </div>
       </div>
    </div>
 
</form>
 

 