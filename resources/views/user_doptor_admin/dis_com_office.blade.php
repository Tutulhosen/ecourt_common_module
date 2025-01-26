@extends('layout.app')

@section('content')
    <!--begin::Card-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">

    <div class="card">
        <div class="row">
            <div class="col-md-6">
                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h2>{{ $page_title }}</h2>
                    </div>
                    
                </div>
            </div>
            <div class="col-md-3"></div>
            <div class="col-md-3" style="padding: 20px">
                <label for=""><h3>কোর্টের ধরণ নির্বাচন করুন</h3></label>
                <select name="" id="" class="form-control court_type">
                    
                    <option value="1" <?php if ($_GET['court_type_id']==1) {
                       echo "selected";
                    }?>>মোবাইল কোর্ট</option>
                    <option value="2" <?php if ($_GET['court_type_id']==2) {
                        echo "selected";
                     }?>>জেনারেল সার্টিফিকেট কোর্ট</option>
                    <option value="3"<?php if ($_GET['court_type_id']==3) {
                        echo "selected";
                     }?>>এক্সিকিউটিভ ম্যাজিস্ট্রেট কোর্ট</option>
                     
                </select>
            </div>
        </div>
        

        


        <div class="card-body">


            @php
                
                if (isset($_GET['search_key'])) {
                    $case_no = $_GET['search_key'];
                   
                } else {
                    $case_no = null;
                    
                }
            @endphp
            
            <form class="form-inline" method="GET"
                action="{{ route('admin.doptor.management.search.all.members', ['office_id' => encrypt($office_id)]) }}">
                <div class="container mb-4">
                    <div class="row">
                        <div class="col-md-3">
                            <input type="text" class="form-control " name="search_key" placeholder="নাম, নথি আইডি, পদবী"
                                value="{{ $case_no }}" required>
                        </div>
                        <input type="hidden" name="court_type_id" value="<?= $_GET['court_type_id']?>">
                        <div class="col-md-2 mt-1">
                            <button type="submit" class="btn btn-success font-weight-bolder mb-2 ml-2">অনুসন্ধান
                                করুন</button>
                        </div>
                    </div>
                </div>
            </form>



            <input type="hidden" name="" id="office_id_hidden" value="{{ $office_id }}">
            <table class="table table-striped table-hover" id="example" width="100%">
                <thead>

                    <tr>
                        <td>ক্রম</td>
                        <td>নাম</td>
                        <td>পদবী</td>
                        <td>পদবী ইংরেজি</td>
                        <td>রোল</td>
                        <td>আদালত নির্বাচন</td>
                        <td>স্ট্যাটাস</td>
                    </tr>
                </thead>
                <tbody>
                    {{-- @dd($list_of_all) --}}

                    @php $increment=1; @endphp
                    @foreach ($list_of_all as $value)
                        <tr>
                            <input type="hidden" name="" id="office_name_bn_{{ $increment }}"
                                value="{{ $value['office_name_bn'] }}">
                            <input type="hidden" name="" id="office_name_en_{{ $increment }}"
                                value="{{ $value['office_name_en'] }}">
                            <input type="hidden" name="" id="unit_name_bn_{{ $increment }}"
                                value="{{ $value['unit_name_bn'] }}">
                            <input type="hidden" name="" id="unit_name_en_{{ $increment }}"
                                value="{{ $value['unit_name_en'] }}">
                            <input type="hidden" name="" id="designation_bng_{{ $increment }}"
                                value="{{ $value['designation_bng'] }}">
                            <input type="hidden" name="" id="office_id_{{ $increment }}"
                                value="{{ $value['office_id'] }}">
                            <input type="hidden" name="" id="username_{{ $increment }}"
                                value="{{ $value['username'] }}">
                            <input type="hidden" name="" id="employee_name_bng_{{ $increment }}"
                                value="{{ $value['employee_name_bng'] }}">

                            <td>{{ $increment }}</td>

                            <td><input type="text" class="form-control" value="{{ $value['employee_name_bng'] }}"
                                    readonly>
                            </td>
                            <td><input type="text" class="form-control" value="{{ $value['designation_bng'] }}"
                                    readonly>
                            </td>
                            <td><input type="text" class="form-control" value="{{ $value['designation_eng'] }}"
                                    readonly>
                            </td>

                            {{-- available role  --}}

                            {{-- mobile court  --}}
                            @if ($_GET['court_type_id']==1)
                                <td  class="mobile_court_role">
                                    <select name="role_select" class="role_select_mc form-control form-control-sm"
                                        class="form-control form-control-sm" id="mc_role_id_{{ $increment }}">

                                        <option value="0">কোন রোল দেওয়া হয় নাই</option>

                                        @foreach ($available_mc_role as $available_role_single)
                                            @php
                                                $selected=' ';
                                                if ($available_role_single->id == $value['role_id'] && $value['court_type_id']==1) {
                                                    $selected='selected';
                                                }
                                            @endphp
                                            <option value="{{ $available_role_single->id }}" {{ $selected }}>
                                                {{ $available_role_single->role_name }}</option>
                                        @endforeach

                                    </select>
                                </td>
                            @endif
                            

                            {{-- gcc court  --}}
                            @if ($_GET['court_type_id']==2)
                                <td class="gcc_court_role">
                                    <select name="role_select" class="role_select_gcc form-control form-control-sm"
                                        class="form-control form-control-sm" id="gcc_role_id_{{ $increment }}">

                                        <option value="0">কোন রোল দেওয়া হয় নাই</option>

                                        @foreach ($available_gcc_role as $available_role_single)
                                        
                                            @php
                                            
                                                $selected=' ';
                                                if ($available_role_single->id == $value['role_id'] && $value['court_type_id']==2) {
                                                    $selected='selected';
                                                }
                                            @endphp
                                            <option value="{{ $available_role_single->id }}" {{ $selected }}>
                                                {{ $available_role_single->role_name }}</option>
                                        @endforeach

                                    </select>
                                </td>
                            @endif
                            

                            {{-- emc court  --}}
                            @if ($_GET['court_type_id']==3)
                                <td class="emc_court_role">
                                    <select name="role_select" class="role_select_emc form-control form-control-sm"
                                        class="form-control form-control-sm" id="emc_role_id_{{ $increment }}">

                                        <option value="0">কোন রোল দেওয়া হয় নাই</option>

                                        @foreach ($available_emc_role as $available_role_single)
                                            @php
                                                $selected=' ';
                                                if ($available_role_single->id == $value['role_id'] && $value['court_type_id']==3) {
                                                    $selected='selected';
                                                }
                                            @endphp
                                            <option value="{{ $available_role_single->id }}" {{ $selected }}>
                                                {{ $available_role_single->role_name }}</option>
                                        @endforeach

                                    </select>
                                </td>
                            @endif
                            

                            {{-- available court  --}}
                            @if ($_GET['court_type_id']==1)
                                <td  class="mobile_court">
                                    <select name="court_select" class="court_select form-control form-control-sm"
                                    class="form-control form-control-sm" id="{{ $increment }}">

                                    <option value="0">কোন আদালত দেওয়া হয় নাই</option>
                                

                                    @foreach ($available_mc_court as $available_court_single)
                                        @php
                                            $selected=' ';
                                            if ($available_court_single->id == $value['court_id']) {
                                                $selected='selected';
                                            }
                                        @endphp
                                        <option value="{{ $available_court_single->id }}" {{ $selected }}>
                                            {{ $available_court_single->court_name }}</option>
                                    @endforeach
                                    </select>
                                </td>
                            @endif
                            @if ($_GET['court_type_id']==2)
                                <td class="gcc_court">    
                                    <select name="court_select" class="court_select form-control form-control-sm"
                                        class="form-control form-control-sm" id="{{ $increment }}">

                                        <option value="0">কোন আদালত দেওয়া হয় নাই</option>
                                    

                                        @foreach ($available_gcc_court as $available_court_single)
                                            @php
                                                $selected=' ';
                                                if ($available_court_single->id == $value['court_id']) {
                                                    $selected='selected';
                                                }
                                            @endphp
                                            <option value="{{ $available_court_single->id }}" {{ $selected }}>
                                                {{ $available_court_single->court_name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            @endif
                            @if ($_GET['court_type_id']==3)
                                <td class="emc_court">
                                    <select name="court_select" class="court_select form-control form-control-sm"
                                        class="form-control form-control-sm" id="{{ $increment }}">

                                        <option value="0">কোন আদালত দেওয়া হয় নাই</option>
                    

                                        @foreach ($available_emc_court as $available_court_single)
                                            @php
                                                $selected=' ';
                                                if ($available_court_single->id == $value['court_id']) {
                                                    $selected='selected';
                                                }
                                            @endphp
                                            <option value="{{ $available_court_single->id }}" {{ $selected }}>
                                                {{ $available_court_single->court_name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            @endif
                            

                            {{-- available court  --}}
                            @if ($_GET['court_type_id']==1)
                                <td class="mobile_court_btn">
                                    @foreach ($available_mc_court as $available_court_single)
                                        @if ($available_court_single->id == $value['court_id'])
                                            <button
                                                class="btn-sm btn btn-primary court_name_{{ $increment }}">{{ $available_court_single->court_name }}
                                                এনাবেল</button>
                                        @else
                                            <button class="btn-sm btn btn-danger court_name_{{ $increment }}">কোন আদালত দেয়া
                                                হয়
                                                নাই ডিজেবেল</button>
                                        @endif
                                    @endforeach

                                    {{-- <button class="btn-sm btn btn-danger court_name_{{ $increment }}">কোন আদালত দেয়া
                                        হয়
                                        নাই ডিজেবেল</button> --}}

                                </td>
                            @endif
                            
                            @if ($_GET['court_type_id']==2)
                                <td class="gcc_court_btn">
                                    @foreach ($available_gcc_court as $available_court_single)
                                        @if ($available_court_single->id == $value['court_id'])
                                            <button
                                                class="btn-sm btn btn-primary court_name_{{ $increment }}">{{ $available_court_single->court_name }}
                                                এনাবেল</button>
                                        @else
                                            <button class="btn-sm btn btn-danger court_name_{{ $increment }}">কোন আদালত দেয়া
                                                হয়
                                                নাই ডিজেবেল</button>
                                        @endif
                                    @endforeach

                                </td>
                            @endif
                            
                            @if ($_GET['court_type_id']==3)
                                <td >
                                    @php $court_ids=[]; @endphp
                                        @foreach ($available_emc_court as $available_court_single)
                                            @php  array_push($court_ids,$available_court_single->id); @endphp
                                        @endforeach

                                        @if (in_array($value['court_id'], $court_ids))
                                            @php
                                                $court_name_showing='';
                                                foreach ($available_emc_court as $available_court_single) {
                                                    if ($available_court_single->id == $value['court_id']) {
                                                        $court_name_showing = $available_court_single->court_name;
                                                    }
                                                }
                                            @endphp
                                            <button
                                                class="btn-sm btn btn-primary court_name_{{ $increment }}">{{ $court_name_showing }}
                                                এনাবেল</button>
                                        @else
                                            <button class="btn-sm btn btn-danger court_name_{{ $increment }}">কোন আদালত
                                                দেয়া হয় নাই ডিজেবেল</button>
                                        @endif

                                </td>
                            @endif
                           
                            
                        </tr>
                        @php $increment++; @endphp
                    @endforeach

                </tbody>
            </table>

            <div>
            </div>
        </div>
    </div>
    <!--end::Card-->


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        $('.court_select').on('change', function() {


            const id = $(this).attr('id');
            let court_type_id = $('.court_type').find(":selected").val();

           
            

            var formdata = new FormData();
            //for gcc court
            if (court_type_id==2) {
                
                let gcc_role_id = $('#gcc_role_id_' + id).val();
           
      
                if (gcc_role_id == 27) {
                    swal.showLoading();
                    $.ajax({
                        url: '{{ route('admin.doptor.management.gco.dc.create') }}',
                        method: 'post',
                        data: {
                            office_name_bn: $('#' + 'office_name_bn_' + id).val(),
                            office_name_en: $('#' + 'office_name_en_' + id).val(),
                            unit_name_bn: $('#' + 'unit_name_bn_' + id).val(),
                            unit_name_en: $('#' + 'unit_name_en_' + id).val(),
                            designation_bng: $('#' + 'designation_bng_' + id).val(),
                            office_id: $('#' + 'office_id_' + id).val(),
                            username: $('#' + 'username_' + id).val(),
                            employee_name_bng: $('#' + 'employee_name_bng_' + id).val(),
                            court_id: $(this).find('option:selected').val(),
                            court_type_id: court_type_id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            console.log(response);
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
                                if (response.court_name == 'No_court') {
                                    $('.court_name_' + id).html('কোন আদালত দেয়া হয় নাই ডিজেবেল');
                                    $('.court_name_' + id).removeClass('btn-primary');
                                    $('.court_name_' + id).addClass('btn-danger');
                                } else {
                                    let texthtml = response.court_name + ' এনাবেল';
                                    $('.court_name_' + id).html(texthtml);
                                    $('.court_name_' + id).removeClass('btn-danger');
                                    $('.court_name_' + id).addClass('btn-primary');
                                }
                            }
                        }
                    });
                }
                else if (gcc_role_id == 0) {
                 Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'রোল নির্বাচন করুন',

                 })
                } 
                else if (gcc_role_id == 28) {

                    swal.showLoading();
                    $.ajax({
                        url: '{{ route('admin.doptor.management.certificate.assistent.create.dc') }}',
                        method: 'post',
                        data: {
                            office_name_bn: $('#' + 'office_name_bn_' + id).val(),
                            office_name_en: $('#' + 'office_name_en_' + id).val(),
                            unit_name_bn: $('#' + 'unit_name_bn_' + id).val(),
                            unit_name_en: $('#' + 'unit_name_en_' + id).val(),
                            designation_bng: $('#' + 'designation_bng_' + id).val(),
                            office_id: $('#' + 'office_id_' + id).val(),
                            username: $('#' + 'username_' + id).val(),
                            employee_name_bng: $('#' + 'employee_name_bng_' + id).val(),
                            court_id: $(this).find('option:selected').val(),
                            court_type_id: court_type_id,
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
                                if (response.court_name == 'No_court') {
                                    $('.court_name_' + id).html('কোন আদালত দেয়া হয় নাই ডিজেবেল');
                                    $('.court_name_' + id).removeClass('btn-primary');
                                    $('.court_name_' + id).addClass('btn-danger');
                                } else {
                                    let texthtml = response.court_name + ' এনাবেল';
                                    $('.court_name_' + id).html(texthtml);
                                    $('.court_name_' + id).removeClass('btn-danger');
                                    $('.court_name_' + id).addClass('btn-primary');
                                }
                            }
                        }
                    });

                }

                else if(gcc_role_id == 6)
                {
                    swal.showLoading();
                    $.ajax({
                        url: '{{ route('admin.doptor.management.dictrict.commissioner.create') }}',
                        method: 'post',
                        data: {
                            office_name_bn: $('#' + 'office_name_bn_' + id).val(),
                            office_name_en: $('#' + 'office_name_en_' + id).val(),
                            unit_name_bn: $('#' + 'unit_name_bn_' + id).val(),
                            unit_name_en: $('#' + 'unit_name_en_' + id).val(),
                            designation_bng: $('#' + 'designation_bng_' + id).val(),
                            office_id: $('#' + 'office_id_' + id).val(),
                            username: $('#' + 'username_' + id).val(),
                            employee_name_bng: $('#' + 'employee_name_bng_' + id).val(),
                            court_id: $(this).find('option:selected').val(),
                            court_type_id:court_type_id,
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
                                if (response.court_name == 'No_court') {
                                    $('.court_name_' + id).html('কোন আদালত দেয়া হয় নাই ডিজেবেল');
                                    $('.court_name_' + id).removeClass('btn-primary');
                                    $('.court_name_' + id).addClass('btn-danger');
                                } else {
                                    let texthtml = response.court_name + ' এনাবেল';
                                    $('.court_name_' + id).html(texthtml);
                                    $('.court_name_' + id).removeClass('btn-danger');
                                    $('.court_name_' + id).addClass('btn-primary');
                                }
                            }
                        }
                    });
                }
                else if(gcc_role_id == 9)
                {
                    swal.showLoading();
                    $.ajax({
                        url: '{{ route('admin.doptor.management.pasker.dictrict.commissioner.create') }}',
                        method: 'post',
                        data: {
                            office_name_bn: $('#' + 'office_name_bn_' + id).val(),
                            office_name_en: $('#' + 'office_name_en_' + id).val(),
                            unit_name_bn: $('#' + 'unit_name_bn_' + id).val(),
                            unit_name_en: $('#' + 'unit_name_en_' + id).val(),
                            designation_bng: $('#' + 'designation_bng_' + id).val(),
                            office_id: $('#' + 'office_id_' + id).val(),
                            username: $('#' + 'username_' + id).val(),
                            employee_name_bng: $('#' + 'employee_name_bng_' + id).val(),
                            court_id: $(this).find('option:selected').val(),
                            court_type_id:court_type_id,
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
                                if (response.court_name == 'No_court') {
                                    $('.court_name_' + id).html('কোন আদালত দেয়া হয় নাই ডিজেবেল');
                                    $('.court_name_' + id).removeClass('btn-primary');
                                    $('.court_name_' + id).addClass('btn-danger');
                                } else {
                                    let texthtml = response.court_name + ' এনাবেল';
                                    $('.court_name_' + id).html(texthtml);
                                    $('.court_name_' + id).removeClass('btn-danger');
                                    $('.court_name_' + id).addClass('btn-primary');
                                }
                            }
                        }
                    });
                }
                else if(gcc_role_id == 7)
                {
                    console.log('come here for adc')
                    swal.showLoading();
                    $.ajax({
                        url: '{{ route('admin.doptor.management.aditional.dictrict.commissioner.create') }}',
                        method: 'post',
                        data: {
                            office_name_bn: $('#' + 'office_name_bn_' + id).val(),
                            office_name_en: $('#' + 'office_name_en_' + id).val(),
                            unit_name_bn: $('#' + 'unit_name_bn_' + id).val(),
                            unit_name_en: $('#' + 'unit_name_en_' + id).val(),
                            designation_bng: $('#' + 'designation_bng_' + id).val(),
                            office_id: $('#' + 'office_id_' + id).val(),
                            username: $('#' + 'username_' + id).val(),
                            employee_name_bng: $('#' + 'employee_name_bng_' + id).val(),
                            court_id: $(this).find('option:selected').val(),
                            court_type_id: court_type_id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            // return false;
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
                                if (response.court_name == 'No_court') {
                                    $('.court_name_' + id).html('কোন আদালত দেয়া হয় নাই ডিজেবেল');
                                    $('.court_name_' + id).removeClass('btn-primary');
                                    $('.court_name_' + id).addClass('btn-danger');
                                } else {
                                    let texthtml = response.court_name + ' এনাবেল';
                                    $('.court_name_' + id).html(texthtml);
                                    $('.court_name_' + id).removeClass('btn-danger');
                                    $('.court_name_' + id).addClass('btn-primary');
                                }
                            }
                        }
                    });
                }
                else if(gcc_role_id == 10)
                {
                    // console.log('come here for adc pasker')
                    swal.showLoading();
        
                    $.ajax({
                        url: '{{ route('admin.doptor.management.aditional.dictrict.commissioner.pasker.create') }}',
                        method: 'post',
                        data: {
                            office_name_bn: $('#' + 'office_name_bn_' + id).val(),
                            office_name_en: $('#' + 'office_name_en_' + id).val(),
                            unit_name_bn: $('#' + 'unit_name_bn_' + id).val(),
                            unit_name_en: $('#' + 'unit_name_en_' + id).val(),
                            designation_bng: $('#' + 'designation_bng_' + id).val(),
                            office_id: $('#' + 'office_id_' + id).val(),
                            username: $('#' + 'username_' + id).val(),
                            employee_name_bng: $('#' + 'employee_name_bng_' + id).val(),
                            court_id: $(this).find('option:selected').val(),
                            court_type_id: court_type_id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            // return false;
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
                                if (response.court_name == 'No_court') {
                                    $('.court_name_' + id).html('কোন আদালত দেয়া হয় নাই ডিজেবেল');
                                    $('.court_name_' + id).removeClass('btn-primary');
                                    $('.court_name_' + id).addClass('btn-danger');
                                } else {
                                    let texthtml = response.court_name + ' এনাবেল';
                                    $('.court_name_' + id).html(texthtml);
                                    $('.court_name_' + id).removeClass('btn-danger');
                                    $('.court_name_' + id).addClass('btn-primary');
                                }
                            }
                        }
                    });
                }
                else if(gcc_role_id == 11)
                {
                    // console.log('come here for adc pasker')
                    swal.showLoading();
        
                    $.ajax({
                        url: '{{ route('admin.doptor.management.deputy.collector.create') }}',
                        method: 'post',
                        data: {
                            office_name_bn: $('#' + 'office_name_bn_' + id).val(),
                            office_name_en: $('#' + 'office_name_en_' + id).val(),
                            unit_name_bn: $('#' + 'unit_name_bn_' + id).val(),
                            unit_name_en: $('#' + 'unit_name_en_' + id).val(),
                            designation_bng: $('#' + 'designation_bng_' + id).val(),
                            office_id: $('#' + 'office_id_' + id).val(),
                            username: $('#' + 'username_' + id).val(),
                            employee_name_bng: $('#' + 'employee_name_bng_' + id).val(),
                            court_id: $(this).find('option:selected').val(),
                            court_type_id: court_type_id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            // return false;
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
                                if (response.court_name == 'No_court') {
                                    $('.court_name_' + id).html('কোন আদালত দেয়া হয় নাই ডিজেবেল');
                                    $('.court_name_' + id).removeClass('btn-primary');
                                    $('.court_name_' + id).addClass('btn-danger');
                                } else {
                                    let texthtml = response.court_name + ' এনাবেল';
                                    $('.court_name_' + id).html(texthtml);
                                    $('.court_name_' + id).removeClass('btn-danger');
                                    $('.court_name_' + id).addClass('btn-primary');
                                }
                            }
                        }
                    });
                }
                else if(gcc_role_id == 12)
                {
                    // console.log('come here for adc pasker')
                    swal.showLoading();
        
                    $.ajax({
                        url: '{{ route('admin.doptor.management.record.keeper.create') }}',
                        method: 'post',
                        data: {
                            office_name_bn: $('#' + 'office_name_bn_' + id).val(),
                            office_name_en: $('#' + 'office_name_en_' + id).val(),
                            unit_name_bn: $('#' + 'unit_name_bn_' + id).val(),
                            unit_name_en: $('#' + 'unit_name_en_' + id).val(),
                            designation_bng: $('#' + 'designation_bng_' + id).val(),
                            office_id: $('#' + 'office_id_' + id).val(),
                            username: $('#' + 'username_' + id).val(),
                            employee_name_bng: $('#' + 'employee_name_bng_' + id).val(),
                            court_id: $(this).find('option:selected').val(),
                            court_type_id: court_type_id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            // return false;
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
                                if (response.court_name == 'No_court') {
                                    $('.court_name_' + id).html('কোন আদালত দেয়া হয় নাই ডিজেবেল');
                                    $('.court_name_' + id).removeClass('btn-primary');
                                    $('.court_name_' + id).addClass('btn-danger');
                                } else {
                                    let texthtml = response.court_name + ' এনাবেল';
                                    $('.court_name_' + id).html(texthtml);
                                    $('.court_name_' + id).removeClass('btn-danger');
                                    $('.court_name_' + id).addClass('btn-primary');
                                }
                            }
                        }
                    });
                }
            }

            //for emc court
            if (court_type_id==3) {
                
                let emc_role_id = $('#emc_role_id_' + id).val();

                if (emc_role_id == 37) {
                    swal.showLoading();
                    $.ajax({
                        url: '{{ route('admin.doptor.management.emc.dm.create') }}',
                        method: 'post',
                        data: {
                            office_name_bn: $('#' + 'office_name_bn_' + id).val(),
                            office_name_en: $('#' + 'office_name_en_' + id).val(),
                            unit_name_bn: $('#' + 'unit_name_bn_' + id).val(),
                            unit_name_en: $('#' + 'unit_name_en_' + id).val(),
                            designation_bng: $('#' + 'designation_bng_' + id).val(),
                            office_id: $('#' + 'office_id_' + id).val(),
                            username: $('#' + 'username_' + id).val(),
                            employee_name_bng: $('#' + 'employee_name_bng_' + id).val(),
                            court_id: $(this).find('option:selected').val(),
                            court_type_id: court_type_id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            console.log(response);
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
                                if (response.court_name == 'No_court') {
                                    $('.court_name_' + id).html('কোন আদালত দেয়া হয় নাই ডিজেবেল');
                                    $('.court_name_' + id).removeClass('btn-primary');
                                    $('.court_name_' + id).addClass('btn-danger');
                                } else {
                                    let texthtml = response.court_name + ' এনাবেল';
                                    $('.court_name_' + id).html(texthtml);
                                    $('.court_name_' + id).removeClass('btn-danger');
                                    $('.court_name_' + id).addClass('btn-primary');
                                }
                            }
                        }
                    });
                }
                else if (emc_role_id == 0) {
                 Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'রোল নির্বাচন করুন',

                 })
                } 
                else if (emc_role_id == 38) {
                    swal.showLoading();
                    $.ajax({
                        url: '{{ route('admin.doptor.management.emc.adm.create') }}',
                        method: 'post',
                        data: {
                            office_name_bn: $('#' + 'office_name_bn_' + id).val(),
                            office_name_en: $('#' + 'office_name_en_' + id).val(),
                            unit_name_bn: $('#' + 'unit_name_bn_' + id).val(),
                            unit_name_en: $('#' + 'unit_name_en_' + id).val(),
                            designation_bng: $('#' + 'designation_bng_' + id).val(),
                            office_id: $('#' + 'office_id_' + id).val(),
                            username: $('#' + 'username_' + id).val(),
                            employee_name_bng: $('#' + 'employee_name_bng_' + id).val(),
                            court_id: $(this).find('option:selected').val(),
                            court_type_id: court_type_id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            console.log(response);
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
                                if (response.court_name == 'No_court') {
                                    $('.court_name_' + id).html('কোন আদালত দেয়া হয় নাই ডিজেবেল');
                                    $('.court_name_' + id).removeClass('btn-primary');
                                    $('.court_name_' + id).addClass('btn-danger');
                                } else {
                                    let texthtml = response.court_name + ' এনাবেল';
                                    $('.court_name_' + id).html(texthtml);
                                    $('.court_name_' + id).removeClass('btn-danger');
                                    $('.court_name_' + id).addClass('btn-primary');
                                }
                            }
                        }
                    });
                }
                else if (emc_role_id == 39) {
                    swal.showLoading();
                    $.ajax({
                        url: '{{ route('admin.doptor.management.emc.adm.pasker.create') }}',
                        method: 'post',
                        data: {
                            office_name_bn: $('#' + 'office_name_bn_' + id).val(),
                            office_name_en: $('#' + 'office_name_en_' + id).val(),
                            unit_name_bn: $('#' + 'unit_name_bn_' + id).val(),
                            unit_name_en: $('#' + 'unit_name_en_' + id).val(),
                            designation_bng: $('#' + 'designation_bng_' + id).val(),
                            office_id: $('#' + 'office_id_' + id).val(),
                            username: $('#' + 'username_' + id).val(),
                            employee_name_bng: $('#' + 'employee_name_bng_' + id).val(),
                            court_id: $(this).find('option:selected').val(),
                            court_type_id: court_type_id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            console.log(response);
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
                                if (response.court_name == 'No_court') {
                                    $('.court_name_' + id).html('কোন আদালত দেয়া হয় নাই ডিজেবেল');
                                    $('.court_name_' + id).removeClass('btn-primary');
                                    $('.court_name_' + id).addClass('btn-danger');
                                } else {
                                    let texthtml = response.court_name + ' এনাবেল';
                                    $('.court_name_' + id).html(texthtml);
                                    $('.court_name_' + id).removeClass('btn-danger');
                                    $('.court_name_' + id).addClass('btn-primary');
                                }
                            }
                        }
                    });
                }
                else if (emc_role_id == 27) {
                    swal.showLoading();
                    $.ajax({
                        url: '{{ route('admin.doptor.management.emc.em.create') }}',
                        method: 'post',
                        data: {
                            office_name_bn: $('#' + 'office_name_bn_' + id).val(),
                            office_name_en: $('#' + 'office_name_en_' + id).val(),
                            unit_name_bn: $('#' + 'unit_name_bn_' + id).val(),
                            unit_name_en: $('#' + 'unit_name_en_' + id).val(),
                            designation_bng: $('#' + 'designation_bng_' + id).val(),
                            office_id: $('#' + 'office_id_' + id).val(),
                            username: $('#' + 'username_' + id).val(),
                            employee_name_bng: $('#' + 'employee_name_bng_' + id).val(),
                            court_id: $(this).find('option:selected').val(),
                            court_type_id: court_type_id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            console.log(response);
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
                                if (response.court_name == 'No_court') {
                                    $('.court_name_' + id).html('কোন আদালত দেয়া হয় নাই ডিজেবেল');
                                    $('.court_name_' + id).removeClass('btn-primary');
                                    $('.court_name_' + id).addClass('btn-danger');
                                } else {
                                    let texthtml = response.court_name + ' এনাবেল';
                                    $('.court_name_' + id).html(texthtml);
                                    $('.court_name_' + id).removeClass('btn-danger');
                                    $('.court_name_' + id).addClass('btn-primary');
                                }
                            }
                        }
                    });
                }
                else if (emc_role_id == 28) {
                    swal.showLoading();
                    $.ajax({
                        url: '{{ route('admin.doptor.management.emc.em.pasker.create') }}',
                        method: 'post',
                        data: {
                            office_name_bn: $('#' + 'office_name_bn_' + id).val(),
                            office_name_en: $('#' + 'office_name_en_' + id).val(),
                            unit_name_bn: $('#' + 'unit_name_bn_' + id).val(),
                            unit_name_en: $('#' + 'unit_name_en_' + id).val(),
                            designation_bng: $('#' + 'designation_bng_' + id).val(),
                            office_id: $('#' + 'office_id_' + id).val(),
                            username: $('#' + 'username_' + id).val(),
                            employee_name_bng: $('#' + 'employee_name_bng_' + id).val(),
                            court_id: $(this).find('option:selected').val(),
                            court_type_id: court_type_id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            console.log(response);
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
                                if (response.court_name == 'No_court') {
                                    $('.court_name_' + id).html('কোন আদালত দেয়া হয় নাই ডিজেবেল');
                                    $('.court_name_' + id).removeClass('btn-primary');
                                    $('.court_name_' + id).addClass('btn-danger');
                                } else {
                                    let texthtml = response.court_name + ' এনাবেল';
                                    $('.court_name_' + id).html(texthtml);
                                    $('.court_name_' + id).removeClass('btn-danger');
                                    $('.court_name_' + id).addClass('btn-primary');
                                }
                            }
                        }
                    });
                }

                
            }

            //for mc court
            if (court_type_id==1) {
                
                let mc_role_id = $('#mc_role_id_' + id).val();
               

                if (mc_role_id == 37) {
                    swal.showLoading();
                    $.ajax({
                        url: '{{ route('admin.doptor.management.mc.dm.create') }}',
                        method: 'post',
                        data: {
                            office_name_bn: $('#' + 'office_name_bn_' + id).val(),
                            office_name_en: $('#' + 'office_name_en_' + id).val(),
                            unit_name_bn: $('#' + 'unit_name_bn_' + id).val(),
                            unit_name_en: $('#' + 'unit_name_en_' + id).val(),
                            designation_bng: $('#' + 'designation_bng_' + id).val(),
                            office_id: $('#' + 'office_id_' + id).val(),
                            username: $('#' + 'username_' + id).val(),
                            employee_name_bng: $('#' + 'employee_name_bng_' + id).val(),
                            court_id: $(this).find('option:selected').val(),
                            court_type_id: court_type_id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            console.log(response);
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
                                if (response.court_name == 'No_court') {
                                    $('.court_name_' + id).html('কোন আদালত দেয়া হয় নাই ডিজেবেল');
                                    $('.court_name_' + id).removeClass('btn-primary');
                                    $('.court_name_' + id).addClass('btn-danger');
                                } else {
                                    let texthtml = response.court_name + ' এনাবেল';
                                    $('.court_name_' + id).html(texthtml);
                                    $('.court_name_' + id).removeClass('btn-danger');
                                    $('.court_name_' + id).addClass('btn-primary');
                                }
                            }
                        }
                    });
                }

                if (mc_role_id == 38) {
                    swal.showLoading();
                    $.ajax({
                        url: '{{ route('admin.doptor.management.mc.adm.create') }}',
                        method: 'post',
                        data: {
                            office_name_bn: $('#' + 'office_name_bn_' + id).val(),
                            office_name_en: $('#' + 'office_name_en_' + id).val(),
                            unit_name_bn: $('#' + 'unit_name_bn_' + id).val(),
                            unit_name_en: $('#' + 'unit_name_en_' + id).val(),
                            designation_bng: $('#' + 'designation_bng_' + id).val(),
                            office_id: $('#' + 'office_id_' + id).val(),
                            username: $('#' + 'username_' + id).val(),
                            employee_name_bng: $('#' + 'employee_name_bng_' + id).val(),
                            court_id: $(this).find('option:selected').val(),
                            court_type_id: court_type_id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            console.log(response);
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
                                if (response.court_name == 'No_court') {
                                    $('.court_name_' + id).html('কোন আদালত দেয়া হয় নাই ডিজেবেল');
                                    $('.court_name_' + id).removeClass('btn-primary');
                                    $('.court_name_' + id).addClass('btn-danger');
                                } else {
                                    let texthtml = response.court_name + ' এনাবেল';
                                    $('.court_name_' + id).html(texthtml);
                                    $('.court_name_' + id).removeClass('btn-danger');
                                    $('.court_name_' + id).addClass('btn-primary');
                                }
                            }
                        }
                    });
                }
                if (mc_role_id == 0) {
                 Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'রোল নির্বাচন করুন',

                 })
                } 
                if (mc_role_id == 27) {
                    swal.showLoading();
                    $.ajax({
                        url: '{{ route('admin.doptor.management.mc.acgm.create') }}',
                        method: 'post',
                        data: {
                            office_name_bn: $('#' + 'office_name_bn_' + id).val(),
                            office_name_en: $('#' + 'office_name_en_' + id).val(),
                            unit_name_bn: $('#' + 'unit_name_bn_' + id).val(),
                            unit_name_en: $('#' + 'unit_name_en_' + id).val(),
                            designation_bng: $('#' + 'designation_bng_' + id).val(),
                            office_id: $('#' + 'office_id_' + id).val(),
                            username: $('#' + 'username_' + id).val(),
                            employee_name_bng: $('#' + 'employee_name_bng_' + id).val(),
                            court_id: $(this).find('option:selected').val(),
                            court_type_id: court_type_id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            console.log(response);
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
                                if (response.court_name == 'No_court') {
                                    $('.court_name_' + id).html('কোন আদালত দেয়া হয় নাই ডিজেবেল');
                                    $('.court_name_' + id).removeClass('btn-primary');
                                    $('.court_name_' + id).addClass('btn-danger');
                                } else {
                                    let texthtml = response.court_name + ' এনাবেল';
                                    $('.court_name_' + id).html(texthtml);
                                    $('.court_name_' + id).removeClass('btn-danger');
                                    $('.court_name_' + id).addClass('btn-primary');
                                }
                            }
                        }
                    });
                }

                if (mc_role_id == 26) {
                    swal.showLoading();
                    $.ajax({
                        url: '{{ route('admin.doptor.management.mc.em.create') }}',
                        method: 'post',
                        data: {
                            office_name_bn: $('#' + 'office_name_bn_' + id).val(),
                            office_name_en: $('#' + 'office_name_en_' + id).val(),
                            unit_name_bn: $('#' + 'unit_name_bn_' + id).val(),
                            unit_name_en: $('#' + 'unit_name_en_' + id).val(),
                            designation_bng: $('#' + 'designation_bng_' + id).val(),
                            office_id: $('#' + 'office_id_' + id).val(),
                            username: $('#' + 'username_' + id).val(),
                            employee_name_bng: $('#' + 'employee_name_bng_' + id).val(),
                            court_id: $(this).find('option:selected').val(),
                            court_type_id: court_type_id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            console.log(response);
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
                                if (response.court_name == 'No_court') {
                                    $('.court_name_' + id).html('কোন আদালত দেয়া হয় নাই ডিজেবেল');
                                    $('.court_name_' + id).removeClass('btn-primary');
                                    $('.court_name_' + id).addClass('btn-danger');
                                } else {
                                    let texthtml = response.court_name + ' এনাবেল';
                                    $('.court_name_' + id).html(texthtml);
                                    $('.court_name_' + id).removeClass('btn-danger');
                                    $('.court_name_' + id).addClass('btn-primary');
                                }
                            }
                        }
                    });
                }

                if (mc_role_id == 25) {
                    swal.showLoading();
                    $.ajax({
                        url: '{{ route('admin.doptor.management.mc.pasker.create') }}',
                        method: 'post',
                        data: {
                            office_name_bn: $('#' + 'office_name_bn_' + id).val(),
                            office_name_en: $('#' + 'office_name_en_' + id).val(),
                            unit_name_bn: $('#' + 'unit_name_bn_' + id).val(),
                            unit_name_en: $('#' + 'unit_name_en_' + id).val(),
                            designation_bng: $('#' + 'designation_bng_' + id).val(),
                            office_id: $('#' + 'office_id_' + id).val(),
                            username: $('#' + 'username_' + id).val(),
                            employee_name_bng: $('#' + 'employee_name_bng_' + id).val(),
                            court_id: $(this).find('option:selected').val(),
                            court_type_id: court_type_id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            console.log(response);
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
                                if (response.court_name == 'No_court') {
                                    $('.court_name_' + id).html('কোন আদালত দেয়া হয় নাই ডিজেবেল');
                                    $('.court_name_' + id).removeClass('btn-primary');
                                    $('.court_name_' + id).addClass('btn-danger');
                                } else {
                                    let texthtml = response.court_name + ' এনাবেল';
                                    $('.court_name_' + id).html(texthtml);
                                    $('.court_name_' + id).removeClass('btn-danger');
                                    $('.court_name_' + id).addClass('btn-primary');
                                }
                            }
                        }
                    });
                }

                
            }
            

        });

        $('.court_type').on('change', function(){
       
            var court_id = $(this).find(":selected").val();
          
        
            // Get the current URL
            var currentUrl = window.location.href;
        
            // Update the URL parameter
            var updatedUrl = updateQueryStringParameter(currentUrl, 'court_type_id', court_id);
     
            // Redirect to the updated URL
            window.location.href = updatedUrl;



            // if (court_id==1) {
            //     $('.gcc_court').hide();
            //     $('.emc_court').hide();
            //     $('.mobile_court').show();
            //     $('.gcc_court_role').hide();
            //     $('.emc_court_role').hide();
            //     $('.mobile_court_role').show();
            //     $('.gcc_court_btn').hide();
            //     $('.emc_court_btn').hide();
            //     $('.mobile_court_btn').show();
            // }
            // if (court_id==2) {
            //     $('.gcc_court').show();
            //     $('.emc_court').hide();
            //     $('.mobile_court').hide();
            //     $('.gcc_court_role').show();
            //     $('.emc_court_role').hide();
            //     $('.mobile_court_role').hide();
            //     $('.gcc_court_btn').show();
            //     $('.emc_court_btn').hide();
            //     $('.mobile_court_btn').hide();
            // }
            // if (court_id==3) {
            //     $('.gcc_court_role').hide();
            //     $('.emc_court_role').show();
            //     $('.mobile_court_role').hide();
            //     $('.gcc_court').hide();
            //     $('.emc_court').show();
            //     $('.mobile_court').hide();
            //     $('.gcc_court_btn').hide();
            //     $('.emc_court_btn').show();
            //     $('.mobile_court_btn').hide();
                
            // }
        })
        function updateQueryStringParameter(uri, key, value) {
            var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
            var separator = uri.indexOf('?') !== -1 ? "&" : "?";
            if (uri.match(re)) {
                return uri.replace(re, '$1' + key + "=" + value + '$2');
            }
            else {
                return uri + separator + key + "=" + value;
            }
        }
    </script>
@endsection

@section('styles')
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Page Vendors Styles-->
@endsection

{{-- Scripts Section Related Page --}}
@section('scripts')
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('js/pages/crud/datatables/advanced/multiple-controls.js') }}"></script>
    <!--end::Page Scripts-->
    <script>
        $(document).ready(function() {



            var myTable = $('#example').DataTable({
                ordering: false,
                searching: false,
                dom: '<"top"i>rt<"bottom"flp><"clear">',

            });

            



        });
    </script>
@endsection
