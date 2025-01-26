
@extends('layout.app')

@section('content')
<style>
    .magistrate_list_container {
        display: flex;
        flex-wrap: wrap; /* Ensures responsiveness on smaller screens */
        gap: 20px; /* Optional: adds space between the dropdowns */
    }
    
    .magistrate_list {
        flex: 1; /* Makes each dropdown take up equal space */
        min-width: 200px; /* Ensures the dropdown doesn't get too small on small screens */
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }
</style>
<div class="row">

<div class="col-md-12">
 
</div>
    <div class="col-1"></div>
    <div class="col-10">
        <div class="card" style="margin-bottom:20px">
            <div class="card-body">
                <h1 style="text-align: center">অধিক্ষেত্র নির্ধারণ করুন</h1>
                <form action="{{ route('jurisdiction.store') }}" method="POST" id="case_mapping_form">
                    @csrf
                    <div class="magistrate_list_container">
                        <div class="magistrate_list">
                            <div class="form-group">
                                <label for="">বিভাগ নির্বাচন করুনঃ</label>
                                <select name="division" id="division" class="form-control">
                                    <option value="">--নির্বাচন করুন--</option>
                                    @foreach ($division as $item)
                                        <option value="{{$item->id}}">{{$item->division_name_bn}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="magistrate_list">
                            <div class="form-group">
                                <label for="">জেলা নির্বাচন করুনঃ</label>
                                <select name="district" id="district" class="form-control">
                                    <option value="">--নির্বাচন করুন--</option>
                                </select>
                            </div>
                        </div>
                        <div class="magistrate_list">
                            <div class="form-group">
                                <label for="">ইউজার নির্বাচন করুনঃ</label>
                                <select name="user_select" id="user_select" class="form-control">
                                    <option value="">--নির্বাচন করুন--</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    
                    
                   
                    <div class="upzill_list" style="display: none">
                        <label style="font-weight: bold; font-size:18px" for="">উপজেলা নির্বাচন করুনঃ</label>
                        <table class="table table-hover mb-6 font-size-h6">
                            <thead class="thead-light">
                                <tr>
                                    <!-- <th scope="col" width="30">#</th> -->
                                    <th scope="col">
                                        সিলেক্ট করুণ
                                    </th>
                                    <th scope="col">উপজেলার নাম</th>
        
                                </tr>
                            </thead>
                            <tbody>
                               
                            </tbody>
                            
                        </table>
                    </div>
                    <div class="text-center ss" style="display: none">
                        <button type="button" id="submitBtn" class="btn btn-success">নিশ্চিত করুন</button>
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
    $(document).ready(function() {
        $('#division').on('change', function() {
            let div_id = $(this).val();
            
            if (div_id) {
                $.ajax({
                    url: '/get-districts/' + div_id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        $('#district').empty(); 
                        $('#district').append('<option value="">-- জেলা নির্বাচন করুন --</option>'); 

                        // Loop through the response and add the options dynamically
                        $.each(response, function(key, district) {
                            $('#district').append('<option value="'+ district.id +'">'+ district.district_name_bn +'</option>');
                        });
                    },
                    error: function() {
                        alert('Error retrieving district list');
                    }
                });
            } else {
                $('#district').empty(); // Clear the district dropdown if no division is selected
                $('#district').append('<option value="">-- জেলা নির্বাচন করুন --</option>');
            }
        });

        $('#district').on('change', function() {
            let dis_id = $(this).val();
            
            if (dis_id) {
                // Fetch Users
                $.ajax({
                    url: '/get-user/' + dis_id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        $('#user_select').empty(); 
                        $('#user_select').append('<option value="">-- ইউজার নির্বাচন করুন --</option>'); 

                        $.each(response, function(key, users) {
                            $('#user_select').append('<option value="'+ users.username +'">'+ users.name +' , '+users.role_name+'</option>');
                        });
                    },
                    error: function() {
                        alert('Error retrieving user list');
                    }
                });

                // Fetch Upazilas
                $.ajax({
                    url: '/get-upazilas/' + dis_id,  // Define a route to get upazilas for the district
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        $('.upzill_list').show();
                        $('.ss').show();
                        // Clear the existing upazila checkboxes
                        $('.check_upzilla').prop('checked', false);
                        $('tbody').empty(); // Clear the current list

                        // Append the new upazila checkboxes
                        $.each(response, function(key, upazila) {
                            $('tbody').append(`
                                <tr>
                                    <td>
                                        <div class="checkbox-inline">
                                            <label class="checkbox">
                                                <input type="checkbox" name="upzilla_mapping[]" value="${upazila.id}" class="check_upzilla" />
                                                <span></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>${upazila.upazila_name_bn}</td>
                                </tr>
                            `);
                        });
                    },
                    error: function() {
                        alert('Error retrieving upazila list');
                    }
                });
            } else {
                $('#user_select').empty(); // Clear the user dropdown if no district is selected
                $('#user_select').append('<option value="">-- ইউজার নির্বাচন করুন  --</option>');
            }
        });


        $('#submitBtn').on('click', function(e) {
            e.preventDefault();

            var user_select= $('#user_select').val();
            var selectedValues = $('input[name="upzilla_mapping[]"]:checked').map(function () {
                return $(this).val();
            }).get();
    
            if (user_select== "") {
                toastr.error('ইউজার নির্বাচন করুন', 'Error');
                return false;
            }
            if (selectedValues== "") {
                toastr.error('উপজেলা নির্বাচন করুন', 'Error');
                return false;
            }
            var formData = $('#case_mapping_form').serialize(); 

            $.ajax({
                url: "{{ route('jurisdiction.store') }}", 
                type: 'POST',
                data: formData,
                success: function(response) {
                    
                    if (response.success) {
                        toastr.success('সফলভাবে সংরক্ষন হয়েছে!', 'Success');
                    } else {
                        toastr.error('ইউজার নির্বাচন করুন', 'Error');
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    toastr.error('An error occurred. Please try again.', 'Error');
                }
            });
        });
       
        $('#user_select').on('change', function(){
            let username = $(this).val();
            // alert(username);
            $.ajax({
                url: "{{ route('check.user.permission') }}", 
                type: 'GET',
                data: { 'username': username },
                success: function(response) {
                    // Uncheck all checkboxes initially
                    $('.check_upzilla').prop('checked', false);

                    // If there are upazilas in upa_id_arr, check the corresponding checkboxes
                    if (response.upa_id_arr.length > 0) {
                        response.upa_id_arr.forEach(function(id) {
                            $('input[value="'+id+'"].check_upzilla').prop('checked', true);
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    toastr.error('An error occurred while fetching the user data.', 'Error');
                }
            });
        });

    });
</script>

    
@endsection