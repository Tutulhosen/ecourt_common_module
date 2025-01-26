@extends('layout.app')

@section('content')

 <!--begin::Row-->
 <div class="row">

<div class="col-md-12">
    <!--begin::Card-->
    <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>
            <div class="card-toolbar">
    
            </div>
        </div>
        <!--begin::Form-->
        <form action="{{ url('emc-pdf-gereate') }}" class="form" method="POST" target="_blank">
            @csrf
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                @if (globalUserInfo()->role_id == 2 || globalUserInfo()->role_id == 25 || globalUserInfo()->role_id == 8)
                    <section>
                        <fieldset class="mb-6">
                            <legend>ফিল্টারিং ফিল্ড সমূহ</legend>

                            <div class="form-group row">
                                <div class="col-lg-3 mb-5">
                                    <select name="division" class="form-control form-control-sm">
                                        <option value="">-বিভাগ নির্বাচন করুন-</option>
                                        @foreach ($divisions as $value)
                                            <option value="{{ $value->id }}"> {{ $value->division_name_bn }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-3 mb-5">
                                    <select name="district" id="district_id" class="form-control form-control-sm">
                                        <option value="">-জেলা নির্বাচন করুন-</option>
                                    </select>
                                </div>

                                <div class="col-lg-3 mb-5">
                                    <input type="text" name="date_start"
                                        class="form-control form-control-sm common_datepicker"
                                        placeholder="তারিখ হতে" autocomplete="off">
                                </div>
                                <div class="col-lg-3 mb-5">
                                    <input type="text" name="date_end"
                                        class="form-control form-control-sm common_datepicker"
                                        placeholder="তারিখ পর্যন্ত" autocomplete="off">
                                </div>

                            

                            

                            </div>
                        </fieldset>
                    </section>
                @endif
                @if (globalUserInfo()->role_id == 34)
                    <fieldset class="mb-6">
                        <legend>ফিল্টারিং ফিল্ড সমূহ</legend>

                        <div class="form-group row">

                            <div>
                                <div id="userDivisionName" data-user-division-name="{{ $user_division_name }}">
                                </div>
                                <div id="userDivisionId" data-user-division-id="{{ $user_division_id }}"></div>
                            </div>
                            
                            <div class="col-lg-3 mb-5">
                                <!-- <label>জেলা <span class="text-danger">*</span></label> -->
                                <select name="district" id="district_id" class="form-control form-control-sm">
                                    <option value="">-জেলা নির্বাচন করুন-</option>
                                </select>
                            </div>

                            <div class="col-lg-3 mb-5">
                                <input type="text" name="date_start"
                                    class="form-control form-control-sm common_datepicker" placeholder="তারিখ হতে"
                                    autocomplete="off">
                            </div>
                            <div class="col-lg-3 mb-5">
                                <input type="text" name="date_end"
                                    class="form-control form-control-sm common_datepicker"
                                    placeholder="তারিখ পর্যন্ত" autocomplete="off">
                            </div>

                        </div>
                    </fieldset>
                @endif

                
                @if (globalUserInfo()->role_id == 2 || globalUserInfo()->role_id == 25 || globalUserInfo()->role_id == 8)
                    <div class="row">
                        <fieldset class="col-lg-5 mb-6 " style="margin-right: 20px">
                            <legend style="width: 200px">ফৌজদারী কার্যবিধি আইনের বিভিন্ন আদালতের মামলা সংক্রান্ত তথ্য</legend>
                
                            <button type="submit" name="btnsubmit" value="pdf_num_division"
                                class="btn btn-success btn-cons margin-top"> বিভাগ ভিত্তিক</button>
                            <button type="submit" name="btnsubmit" value="pdf_num_district"
                                onclick="return validFunc1()" class="btn btn-success btn-cons margin-top"> জেলা
                                ভিত্তিক</button>
            
                            <button type="submit" name="btnsubmit" value="pdf_num_upazila"
                                onclick="return validFunc2()" class="btn btn-success btn-cons margin-top"> উপজেলা
                                ভিত্তিক</button>
                        </fieldset>

                        <fieldset class="col-lg-5 mb-6 ml-1 ">
                            <legend >ফৌজদারী কার্যবিধি আইনের বিভিন্ন ধারার মামলার তথ্য</legend>

                            <button type="submit" name="btnsubmit" value="pdf_crpc_division"
                                class="btn btn-success btn-cons margin-top"> বিভাগ ভিত্তিক</button>
                            <button type="submit" name="btnsubmit" value="pdf_crpc_district"
                                onclick="return validFunc1()" class="btn btn-success btn-cons margin-top"> জেলা
                                ভিত্তিক</button>

                            <button type="submit" name="btnsubmit" value="pdf_crpc_upazila"
                                onclick="return validFunc2()" class="btn btn-success btn-cons margin-top"> উপজেলা
                                ভিত্তিক</button>
                        </fieldset>
                    </div>
                @endif

                @if (globalUserInfo()->role_id == 34)
                    <div class="row">
                        <fieldset class="col-lg-5 mb-6 " style="margin-right: 20px">
                            <legend style="width: 200px">ফৌজদারী কার্যবিধি আইনের বিভিন্ন আদালতের মামলা সংক্রান্ত তথ্য</legend>
                
                            <button type="submit" name="btnsubmit" value="pdf_num_district"
                                onclick="return validFunc1()" class="btn btn-success btn-cons margin-top"> জেলা
                                ভিত্তিক</button>
            
                            <button type="submit" name="btnsubmit" value="pdf_num_upazila"
                                onclick="return validFunc2()" class="btn btn-success btn-cons margin-top"> উপজেলা
                                ভিত্তিক</button>
                        </fieldset>

                        <fieldset class="col-lg-5 mb-6 ml-1 ">
                            <legend >ফৌজদারী কার্যবিধি আইনের বিভিন্ন ধারার মামলার তথ্য</legend>

                            <button type="submit" name="btnsubmit" value="pdf_crpc_district"
                                onclick="return validFunc1()" class="btn btn-success btn-cons margin-top"> জেলা
                                ভিত্তিক</button>

                            <button type="submit" name="btnsubmit" value="pdf_crpc_upazila"
                                onclick="return validFunc2()" class="btn btn-success btn-cons margin-top"> উপজেলা
                                ভিত্তিক</button>
                        </fieldset>
                    </div>
                @endif

                <div class="row">
                       

                    <fieldset class="col-lg-6 mb-6 ml-1 ">
                        <legend>এক্সিকিউটিভ ম্যাজিস্ট্রেট আদালতের চলমান মামলার তথ্য</legend>
                        <button type="submit" name="btnsubmit" value="pdf_case"
                            class="btn btn-success btn-cons margin-top"> মামলার তালিকা</button>
                       
                    </fieldset>
                </div>

            </div>
            <!--end::Card-body-->

    

        </form>
        <!--end::Form-->
    </div>
    <!--end::Card-->
</div>

</div>
<!--end::Row-->
@endsection

{{-- Includable CSS Related Page --}}
@section('styles')
    <!--end::Page Vendors Styles-->
@endsection
{{-- Scripts Section Related Page --}}
@section('scripts')
    <script src="{{ asset('js/pages/crud/forms/widgets/bootstrap-datepicker.js') }}"></script>
    <script>
        // common datepicker
        $('.common_datepicker').datepicker({
            format: "dd/mm/yyyy",
            todayHighlight: true,
            orientation: "bottom left"
        });
    </script>

    <script type="text/javascript">
        jQuery(document).ready(function() { 

            // Dependable District List
            jQuery('select[name="division"]').on('change', function() {
                var dataID = jQuery(this).val();

                jQuery("#district_id").after('<div class="loadersmall"></div>');

                if (dataID) {
                    jQuery.ajax({
                        url: '{{ url('/') }}/generalCertificate/case/dropdownlist/getdependentdistrict/' +
                            dataID,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            jQuery('select[name="district"]').html(
                                '<div class="loadersmall"></div>');

                            jQuery('select[name="district"]').html(
                                '<option value="">-- নির্বাচন করুন --</option>');
                            jQuery.each(data, function(key, value) {
                                jQuery('select[name="district"]').append(
                                    '<option value="' + key + '">' + value +
                                    '</option>');
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
                        url: '{{ url('/') }}/generalCertificate/case/dropdownlist/getdependentupazila/' +
                            dataID,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            jQuery('select[name="upazila"]').html(
                                '<div class="loadersmall"></div>');

                            jQuery('select[name="upazila"]').html(
                                '<option value="">-- নির্বাচন করুন --</option>');
                            jQuery.each(data, function(key, value) {
                                jQuery('select[name="upazila"]').append(
                                    '<option value="' + key + '">' + value +
                                    '</option>');
                            });
                            jQuery('.loadersmall').remove();
                        }
                    });
                } else {
                    $('select[name="upazila"]').empty();
                }
            });

            const user_division_name = $('#userDivisionName').data('userDivisionName');
            const user_division_id = $('#userDivisionId').data('userDivisionId');
            // console.log($('#userDivisionId'))
            if (user_division_id) {
                jQuery.ajax({
                    url: '{{ url('/') }}/generalCertificate/case/dropdownlist/getdependentdistrict/' +
                        user_division_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        jQuery('select[name="district"]').html(
                            '<div class="loadersmall"></div>');

                        jQuery('select[name="district"]').html(
                            '<option value="">-- নির্বাচন করুন --</option>');
                        jQuery.each(data, function(key, value) {
                            jQuery('select[name="district"]').append(
                                '<option value="' + key + '">' + value +
                                '</option>');
                        });
                        jQuery('.loadersmall').remove();
                    }
                });
            } else {
                $('select[name="district"]').empty();
            }
       
        });
    </script>
    <!--end::Page Scripts-->
@endsection