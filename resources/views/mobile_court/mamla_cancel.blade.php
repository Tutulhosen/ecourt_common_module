
@extends('layout.app')

@section('content')

<div class="row">

<div class="col-md-12">
 
</div>
    <div class="col-1"></div>
    <div class="col-10">
        
        <div class="card " style="margin-bottom:20px">
            <div class="card-header smx">
                <h2 class="card-title"> মামলা বাতিল</h2>
            </div>
            <div class="card-body  cpv">
                {{-- Start the Form --}}
                <form method="post" name="casedeleteform" id="casedeleteform" action="#">
                    @csrf {{-- CSRF Token --}}
                    <div class="form-group">
                        <label class="control-label">মামলা নম্বর</label>
                        <input type="text" name="case_no" id="case_no" class="input form-control" value="{{ old('case_no') }}">
                    </div>
                    <div class="text-right">
                        <button class="btn btn-success" type="submit"><i class="fa fa-check"></i> মামলা বাতিল </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-1"></div>
</div>


@endsection

@section('scripts')
<script>
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

</script>

<script>
    $("#casedeleteform").submit(function (e) {
        e.preventDefault(); // Prevent the default form submission
        var case_no =$('#case_no').val();
        if (!case_no) {
            toastr.error('মামলা নাম্বার দিন । ', 'Error', {
                closeButton: true,
                progressBar: true,
                positionClass: 'toast-top-right'
            });
            return;
        }


        var formObj = $(this);
        var formURL =  "/cancel/mamla/from/admin";
        var formData = new FormData(this);
        Swal.fire({
            title: "মামলা",
            text: "মামলা বাতিল  করতে চান ?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            cancelButtonText: "না",
            confirmButtonText: "হ্যাঁ"
          }).then((result) => {
            if (result.isConfirmed) {
                    $.ajax({
                        url: formURL,
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            if (response.status==false) {
                                    Swal.fire({
                                    title: "অবহতিকরণ বার্তা!",
                                    text: response.message,
                                    icon: "error"
                                });
                            }
                            if (response.status==true) {
                                    Swal.fire({
                                    title: "অবহতিকরণ বার্তা!",
                                    text: response.message,
                                    icon: "success"
                                });
                            }
                            
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            // Handle errors
                            console.error('Error:', textStatus, errorThrown);
                        }
                    });
               
            }
          });   
    });
</script>

    
@endsection