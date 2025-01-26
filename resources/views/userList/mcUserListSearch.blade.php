@extends('layout.app')


@section('content')
    {{-- @section('styles') --}}
    <style>
        .pagination {
            display: flex;
            justify-content: center;
        }

        .pagination li {
            margin: 0 5px;
            list-style-type: none;
            display: inline-block;
        }

        .pagination a {
            text-decoration: none;
            padding: 5px 10px;
            border: 1px solid #ccc;
            color: #333;
        }

        .pagination .active a {
            background-color: #007bff;
            color: #fff;
        }
    </style>

    <style type="text/css">
        fieldset {
            border: 1px solid #ddd !important;
            margin: 0;
            xmin-width: 0;
            padding: 10px;
            position: relative;
            border-radius: 4px;
            background-color: #d5f7d5;
            padding-left: 10px !important;
        }

        fieldset .form-label {
            color: black;
        }

        legend {
            font-size: 14px;
            font-weight: 500;
            width: 45%;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px 5px 5px 10px;
            background-color: #5cb85c;
        }

        .list-group-flush>.list-group-item {
            padding-left: 0;
        }

        .btn-active {
            background-color: #28a745 !important;
            border-color: #28a745 !important;
        }

        .btn-active.active {
            background-color: #416e4b !important;
            border-color: #416e4b !important;
        }

        .dashboard {
            display: none;
        }

        .dashboard.active {
            display: block;
        }

        table,
        tr,
        td {
            padding-top: 20px !important;  
            padding-bottom: 10px !important;
            line-height: 1 !important;
            border-collapse: collapse;
    
        }
    </style>
    {{-- @endsection --}}
    <!--begin::Card-->
    <div class="card" style="margin-bottom: 20px">
        <div class="card-header" style="font-size: 20px">
            ইউজারের তথ্য (মোবাইল কোর্ট)
        </div>
        <div class="card-body">

            <fieldset class="mb-6">
                <legend style="color: white; font-size: 16px">ফিল্টারিং ফিল্ড সমূহ</legend>
                <form action="{{ route('mc.user.list.search') }}" method="get">
        
                    <div class="form-group row">
                        <div class="col-lg-3 mb-5">
                            <select name="division" class="form-control form-control-sm" id="division">
                                <option value="">-বিভাগ নির্বাচন করুন-</option>
                                @foreach ($divisions as $value)
                                    <option value="{{$value->id}}">{{$value->division_name_bn}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3 mb-5">
                            <select name="district" id="district" class="form-control form-control-sm">
                                <option value="">-জেলা নির্বাচন করুন-</option>
                            </select>
                        </div>
                        <div class="col-lg-3 mb-5">
                            <select name="upazila" id="upazila" class="form-control form-control-sm">
                                <option value="">-উপজেলা নির্বাচন করুন-</option>
                            </select>
                        </div>
                        <div class="col-lg-3 mb-5">
                            <select name="role" id="role" class="form-control form-control-sm">
                                <option value="">-পদবী নির্বাচন করুন-</option>
                                @foreach ($mc_role as $item)
                                    <option value="{{$item->id}}">{{$item->role_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3 mb-5">
                            <input type="text" class="form-control" id="user_name" name="user_name" placeholder="দপ্তর আইডি">
                        </div>
                        <div class="col-lg-3 mb-5">
                            <input type="text" class="form-control" id="mobile_no" name="mobile_no" placeholder="মোবাইল নম্বর">
                        </div>
                        
                        <div class="col-lg-3 mb-5">
                            <button type="submit" class="btn btn-success font-weight-bolder mb-2 ml-2 search">অনুসন্ধান
                                করুন</button>
                        </div>
                    </div>
                </form>
            </fieldset>
            <table class="table table-hover mb-6 font-size-h5">
                <thead class="thead-light font-size-h6">
                    <tr>
                        <th class="" scope="col" width="30">#</th>
                        <th class="" scope="col">নাম </th>
                        <th class="" scope="col">মোবাইল </th>
                        <th class="" scope="col">ইমেইল</th>
                        <th class="" scope="col">পদবী</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($all_mc_user))
                        @php
                        $i = 0;
                        @endphp
                        @foreach ($all_mc_user as $row)
                            <tr style="padding:0%" style="display: flex;  justify-content: space-between">
                                <td scope="row" class="tg-bn ">
                                    {{ en2bn(++$i) }}.</td>
                                <td class="">{{ $row->name }}</td>
                                <td class="">{{ $row->mobile_no }}</td>
                                <td class="">{{ $row->email }}</td>
                                <td class="">{{ McRoleName($row->role_id) }}</td>
                                
                            </tr>
                        @endforeach
                    @else
                        <h3>কোন তথ্য পাওয়া যায়নি</h3>
                    @endif
                   
                </tbody>
            </table>

            <div class="d-flex justify-content-center pt-5">
                <ul class="pagination">
                    {{-- {{ $all_office_bangladesh->links() }} --}}
                    {!! $all_mc_user->links('pagination::bootstrap-4') !!}

                </ul>
            </div>
        </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (Session::has('withError'))
        <script>
            Swal.fire(
                'তথ্য পাওয়া যায় নাই'
            )
        </script>
    @endif



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
 
                    $.ajax({
                        url: '/get-upazilas/' + dis_id,  
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            $('#upazila').empty(); 
                            $('#upazila').append('<option value="">-- উপজেলা নির্বাচন করুন --</option>'); 
    
                            // Loop through the response and add the options dynamically
                            $.each(response, function(key, upazila) {
                                $('#upazila').append('<option value="'+ upazila.id +'">'+ upazila.upazila_name_bn +'</option>');
                            });
                        },
                        error: function() {
                            alert('Error retrieving upazila list');
                        }
                    });
                } else {
                    
                }
            });
    
    
        });
    </script>
@endsection
