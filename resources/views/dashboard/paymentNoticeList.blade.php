@extends('layout.app')
 @yield('style')

 @section('content')
 <style>
 .payment.active {
    border: 2px solid #008841;
}
</style>
 <div class="card card-custom">
        <div class="card-header flex-wrap py-5">
            <div class="card-title">
                <h3 class="card-title h2 font-weight-bolder"></h3>
            </div>
          
        </div>
        <div class="card-body overflow-auto">

            
            
            <table class="table table-hover mb-6 font-size-h5">
                <thead class="thead-customStyle font-size-h6">
                    <tr>
                        <th scope="col">ক্রমিক নং</th>
                        
                        <th scope="col">মামলা নম্বর</th>
                        <th scope="col">অফিসের নাম</th>
                        <th scope="col">আবেদনকারীর নাম</th>
                        <th scope="col">পদক্ষেপ</th>
                        
                       {{--
                        <th scope="col">মামলার অবস্থা</th>
                        <th scope="col">আবেদনকারীর নাম</th>
                        <th scope="col">ম্যানুয়াল মামলা নম্বর</th>

                        <th scope="col">পরবর্তী তারিখ</th>
                        <th scope="col">শুনানির সময়</th>
                        <th scope="col" width="70">পদক্ষেপ </th> --}}
                    </tr>
                </thead>
                <tbody>
                    @if($payment_notice)
                      
                    @foreach($payment_notice as $notice)
                   
                    <tr>
                        <td>{{ en2bn($loop->index+1) }}.</td>
                        <td>{{ $notice['case_no'] }}</td>
                        <td>{{ $notice['office_name'] }}</td>
                        <td>{{ $notice['citizen_name'] }}</td>
                        <td>
                            <!-- <button class="btn btn-primary">প্রসেস ফি</button>  -->
                            <button type="button" onclick="processFee(<?php echo $notice['appeal_id'] ?>,<?php echo $notice['loan_amount'] ?>,<?php echo $notice['interestRate'] ?>)" class="btn btn-primary" data-toggle="modal" >
                            প্রসেস ফি
                            </button>
                    
                        </td>
                      
                    </tr>



                    @endforeach


                    @endif
                
                </tbody>
            </table>
        </div>

<div class="modal fade" id="payment_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">প্রসেস ফি</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="" action="{{ route('process_fee') }}" class="form" method="POST"
        enctype="multipart/form-data">
          @csrf
      <div class="modal-body payment_select_details">
   
       
        
   

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>
@endsection
@section('scripts')
<script>
 function processFee(id,loan_amount,interestRate) {

    var url = '/makepaymentmodal';
    $.ajax({
        url: url,
        type: "POST",
        data: {
            id:id ,
            loan_amount:loan_amount ,
            interestRate:interestRate
        },
        success: function(data) {
            //  console.log(data);
            $('.payment_select_details').html(data);
            $('#payment_modal').modal('show');

        },
        error: function(xhr) {
            alert('failed!');
        }
    });
}



      
    </script>
 @endsection