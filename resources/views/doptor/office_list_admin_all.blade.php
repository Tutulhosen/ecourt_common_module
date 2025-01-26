@extends('layout.app')

@php
    if (isset($_GET['ministry'])) {
        $selected_ministry = $_GET['ministry'];
    } else {
        $selected_ministry = ' ';
    }
    if (isset($_GET['custom_office_layer'])) {
        $selected_custom_office_layer = $_GET['custom_office_layer'];
    } else {
        $selected_custom_office_layer = ' ';
    }
    if (isset($_GET['division'])) {
        $selected_division = $_GET['division'];
    } else {
        $selected_division = ' ';
    }
    if (isset($_GET['district'])) {
        $selected_district = $_GET['district'];
    } else {
        $selected_district = ' ';
    }
    if (isset($_GET['upazila'])) {
        $selected_upazila = $_GET['upazila'];
    } else {
        $selected_upazila = ' ';
    }
@endphp

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
        .select2-container .select2-selection--single {
            height: 40px !important;
            color: black !important;
            font-weight: bold !important;
            font-size: 16px !important;
            display: flex; /* Ensures alignment */
            align-items: center; /* Vertically centers text */
        }

        
    </style>
    {{-- @endsection --}}
    <!--begin::Card-->
    <div class="card">
        <div class="card-header" style="font-size: 20px">
            অফিস নির্বাচন করুন
        </div>
        <div class="card-body">
            <div style="display: none">
                <p>অফিস সিস্টেমে লোড করুন</p>
                <div class="btn-group">
                    <a href="#" class="btn load_office btn-primary m-2" data-lavel="2">বিভাগ</a>
                    <a href="#" class="btn load_office btn-primary m-2" data-lavel="3">জেলা</a>
                    <a href="#" class="btn load_office btn-primary m-2" data-lavel="4">উপজেলা</a>
                </div>
            </div>



            <fieldset class="mb-6">
                <legend style="color: white; font-size: 16px">ফিল্টারিং ফিল্ড সমূহ</legend>
                <form action="{{ route('admin.doptor.management.import.offices.search') }}" method="get">

                    <div class="form-group row">
                        

                        <div class="col-lg-3 mb-5">
                            <select name="custom_office_layer" class="form-control form-control-sm" id="custom_office_layer" style="width: 10px">
                                <option value="">-কাস্টম অফিস লেয়ার-</option>
                                @foreach ($custom_office_layer as $value)
                                    <option value="{{ $value->layer_level }}" @if ($selected_custom_office_layer == $value->layer_level) selected @endif>
                                        {{ $value->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <?php 
                            if (!empty($custom_office_2nd_layer)) {
                               $display='';
                            }else{
                                $display='none';
                            }
                            if (!empty($custom_office_2nd_layer_doptor)) {
                               $display2='';
                            }else{
                                $display2='none';
                            }
                        ?>
                        <div class="col-lg-3 mb-5" style="display: {{$display}}">
                            <select name="custom_office_2nd_layer" class="form-control form-control-sm" id="custom_office_2nd_layer" style="width: 10px">
                                <option value="">-কাস্টম অফিস লেয়ার-</option>
                                @if (!empty($custom_office_2nd_layer))
                                    @foreach ($custom_office_2nd_layer_data as $item)
                                        <?php
                                            if ($item->customlayerid==$custom_office_2nd_layer) {
                                                $selected='selected';
                                            } else {
                                                $selected='';
                                            }
                                            
                                        ?>
                                        <option value="{{$item->customlayerid}}" {{$selected}}>{{$item->nameBn}}</option>
                                    @endforeach
                                @endif
                               
                            </select>
                        </div>
                        
                        <div class="col-lg-3 mb-5" style="display: {{$display2}}">
                            <select name="custom_office_2nd_layer_doptor" class="form-control form-control-sm" id="custom_office_2nd_layer_doptor" style="width: 10px">
                                <option value="">-দপ্তর / অধিদপ্তরের ধরন-</option>
                                @if (!empty($custom_office_2nd_layer_doptor))
                                @foreach ($custom_office_2nd_layer_doptor_data as $item)
                                    <?php
                                        if ($item->custom_id==$custom_office_2nd_layer_doptor) {
                                            $selected='selected';
                                        } else {
                                            $selected='';
                                        }
                                        
                                    ?>
                                    <option value="{{$item->custom_id}}" {{$selected}}>{{$item->office_name_bng}}</option>
                                @endforeach
                            @endif
                            </select>
                        </div>
                        
                        <div class="col-lg-3 mb-5">
                            <select name="division" class="form-control form-control-sm" id="division_id">
                                <option value="">-বিভাগ নির্বাচন করুন-</option>
                                @foreach ($divisions as $value)
                                    <option value="{{ $value->id }}" @if ($selected_division == $value->id) selected @endif>
                                        {{ $value->division_name_bng }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3 mb-5">
                            <select name="district" id="district_id" class="form-control form-control-sm">
                                <option value="">-জেলা নির্বাচন করুন-</option>
                            </select>
                        </div>
                        <div class="col-lg-3 mb-5">
                            <select name="upazila" id="upazila_id" class="form-control form-control-sm">
                                <option value="">-উপজেলা নির্বাচন করুন-</option>
                            </select>
                        </div>
                        <div class="col-lg-3 mb-5">
                            <input type="text" class="form-control" placeholder="অফিসের নাম" value="{{ request('office_name') }}"  name="office_name" id="office_name">
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
                        <th class="text-center" scope="col" width="30">#</th>

                        <th class="text-center" scope="col">বিভাগ</th>
                        <th class="text-center" scope="col">জেলা</th>
                        <th class="text-center" scope="col">উপজেলা</th>
                        <th class="text-center" scope="col">অফিস</th>
                        <th class="text-center" scope="col" width="70">অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 0;
                    @endphp
                    @foreach ($all_office_bangladesh as $row)
                        <tr style="padding:0%" style="display: flex; align-items: center; justify-content: space-between">
                            <td scope="row" class="tg-bn text-center align-middle">
                                {{ en2bn(++$i) }}.</td>
                            <td class="text-center align-middle">{{ $row->division_name_bng }}</td>
                            <td class="text-center align-middle">{{ $row->district_name_bng }}</td>
                            <td class="text-center align-middle">{{ $row->upazila_name_bng }}</td>
                            <td class="text-center align-middle">{{ $row->office_name_bng }}</td>
                            <td class="text-center align-middle">
                                <a class="btn btn-primary" style="padding: 4px"
                                    href="{{ route('admin.doptor.management.user_list.segmented.all', [
                                        'office_id' => encrypt($row->office_id),
                                        'court_type_id' => 1,
                                    ]) }}">প্রবেশ</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-center pt-5">
                <ul class="pagination">
                    {{-- {{ $all_office_bangladesh->links() }} --}}
                    {!! $all_office_bangladesh->links('pagination::bootstrap-4') !!}

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

    @if (request()->get('district'))
        <script>
            var disID = {{ request()->get('district') }};
        </script>
    @else
        <script>
            var disID = 0;
        </script>
    @endif
    @if (request()->get('upazila'))
        <script>
            var upID = {{ request()->get('upazila') }};
        </script>
    @else
        <script>
            var upID = 0;
        </script>
    @endif


    <script type="text/javascript">
        jQuery(document).ready(function() {


            jQuery('select[name="division"]').on('change', function() {

                var dataID = jQuery(this).val();

                jQuery("#district_id").after('<div class="loadersmall"></div>');

                if (dataID) {
                    jQuery.ajax({
                        url: '{{ url('/') }}/admin/doptor/management/dropdownlist/getdependentdistrict/' +
                            dataID,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            jQuery('select[name="district"]').html(
                                '<div class="loadersmall"></div>');

                            jQuery('select[name="district"]').html(
                                '<option value="">-- জেলা নির্বাচন করুন --</option>');
                            jQuery.each(data, function(key, value) {
                                jQuery('select[name="district"]').append(
                                    '<option value="' + key +
                                    '">' + value + '</option>');
                            });
                            jQuery('.loadersmall').remove();
                        }
                    });
                } else {
                    $('select[name="district"]').empty();
                }
            });



            // Dependable Upazila List
            jQuery('select[name="district"]').on('change', function() {
                var dataID = jQuery(this).val();

                jQuery("#upazila_id").after('<div class="loadersmall"></div>');

                if (dataID) {
                    jQuery.ajax({
                        url: '{{ url('/') }}/admin/doptor/management/dropdownlist/getdependentupazila/' +
                            dataID,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            jQuery('select[name="upazila"]').html(
                                '<div class="loadersmall"></div>');

                            jQuery('select[name="upazila"]').html(
                                '<option value="">--উপজেলা নির্বাচন করুন --</option>');
                            jQuery.each(data, function(key, value) {
                                jQuery('select[name="upazila"]').append(
                                    '<option value="' + key +
                                    '">' + value + '</option>');
                            });
                            jQuery('.loadersmall').remove();
                        }
                    });
                } else {
                    $('select[name="upazila"]').empty();
                }
            });


            var divID = $('#division_id').find(":selected").val();





            jQuery("#district_id").after('<div class="loadersmall"></div>');

            if (divID != ' ') {
                jQuery.ajax({
                    url: '{{ url('/') }}/admin/doptor/management/dropdownlist/getdependentdistrict/' +
                        divID,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        jQuery('select[name="district"]').html(
                            '<div class="loadersmall"></div>');

                        jQuery('select[name="district"]').html(
                            '<option value="">-- জেলা নির্বাচন করুন --</option>');
                        jQuery.each(data, function(key, value) {
                            if (disID == key) {
                                var selected = 'selected';
                            } else {
                                var selected = ' ';
                            }
                            jQuery('select[name="district"]').append(
                                '<option value="' + key +
                                '"' + selected + '>' + value + '</option>');
                        });
                        jQuery('.loadersmall').remove();
                    }
                });
            } else {
                $('select[name="district"]').empty();
            }



            if (typeof disID !== "undefined") {
                jQuery.ajax({
                    url: '{{ url('/') }}/admin/doptor/management/dropdownlist/getdependentupazila/' +
                        disID,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        jQuery('select[name="upazila"]').html(
                            '<div class="loadersmall"></div>');

                        jQuery('select[name="upazila"]').html(
                            '<option value="">--উপজেলা নির্বাচন করুন --</option>');
                        jQuery.each(data, function(key, value) {
                            if (upID == key) {
                                var selected = 'selected';
                            } else {
                                var selected = ' ';
                            }
                            jQuery('select[name="upazila"]').append(
                                '<option value="' + key +
                                '"' + selected + '>' + value + '</option>');
                        });
                        jQuery('.loadersmall').remove();
                    }
                });

            } else {
                $('select[name="upazila"]').empty();
            }

           



        })
    </script>

    <script>
        $(document).ready(function () {
            $('#custom_office_layer').select2({
                placeholder: "-কাস্টম অফিস লেয়ার নির্বাচন করুন-", 
                allowClear: true, 
                width: '100%' 
            });
            $('#custom_office_2nd_layer').select2({
                placeholder: "-কাস্টম অফিস লেয়ার নির্বাচন করুন-", 
                allowClear: true, 
                width: '100%' 
            });
            $('#custom_office_2nd_layer_doptor').select2({
                placeholder: "-দপ্তর / অধিদপ্তরের ধরন-", 
                allowClear: true, 
                width: '100%' 
            });
            $('#ministry_id').select2({
                placeholder: "-মন্ত্রণালয় নির্বাচন করুন-", 
                allowClear: true, 
                width: '100%' 
            });
            $('#custom_office_layer').on('change', function(){
                let custom_office_layer = $(this).find(":selected").val();
                if (custom_office_layer == 3) {
                    $('#custom_office_2nd_layer').parent().show(); 
                } else {
                    $('#custom_office_2nd_layer').parent().hide(); 
                }
                if (custom_office_layer == 4 || custom_office_layer == 5 || custom_office_layer == 6 || custom_office_layer == 7) {
                    $('#custom_office_2nd_layer_doptor').parent().show(); 
                } else {
                    $('#custom_office_2nd_layer_doptor').parent().hide(); 
                }

         

                $.ajax({
                    url: '{{ url('/') }}/admin/doptor/management/dropdownlist/getdependentlayer/' + custom_office_layer,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        if (data.level==3) {
                            let selectElement = $('#custom_office_2nd_layer');
        
                            // Clear previous options except the placeholder
                            selectElement.find('option:not(:first)').remove();
   
                            
                            // Append new options from the AJAX response
                            $.each(data.doptor_office, function(index, item) {
                                selectElement.append(
                                    `<option value="${item.customlayerid}">${item.nameBn}</option>`
                                );
                            });
                        }
                        if (data.level==4 || data.level==5 || data.level==6 || data.level==7) {
                            let selectElementDoptor = $('#custom_office_2nd_layer_doptor');
        
                            // Clear previous options except the placeholder
                            selectElementDoptor.find('option:not(:first)').remove();
             
                            
                            // Append new options from the AJAX response
                            $.each(data.doptor_office, function(index, item) {
                                selectElementDoptor.append(
                                    `<option value="${item.custom_id}">${item.office_name_bng}</option>`
                                );
                            });
                        }
                        
                        
                    }
                });

                
            } );
        });

    </script>
    <script>
        $('.load_office').on('click', function(e) {
            e.preventDefault();
            var lavel = $(this).data('lavel');

            var formdata = new FormData();

            swal.showLoading();

            $.ajax({
                url: '{{ route('admin.doptor.management.import.offices') }}',
                method: 'post',
                data: {
                    office_lavel: lavel,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    Swal.close();
                    if (response.success == 'error') {
                        Swal.fire({
                            icon: 'error',
                            text: response.message,

                        })
                    } else if (response.success == 'success') {

                        Swal.fire({
                            icon: 'success',
                            text: response.message,

                        })
                    }
                    location.reload();
                }
            });

        })
    </script>
@endsection
