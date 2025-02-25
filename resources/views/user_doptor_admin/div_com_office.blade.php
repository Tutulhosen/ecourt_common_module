@extends('layout.app')

@section('content')
    <!--begin::Card-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">

    <div class="card">

        <div class="card-header flex-wrap py-5">
            <div class="card-title">
                <h2>{{ $page_title }}</h2>
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
                        <input type="hidden" name="court_type_id" value="<?= $_GET['court_type_id'] ?>">
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
                        <td>স্ট্যাটাস</td>
                    </tr>
                </thead>
                <tbody>

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
                            <td>
                                <select name="role_select" class="role_select form-control form-control-sm"
                                    class="form-control form-control-sm" id="{{ $increment }}">

                                    <option value="0">কোন রোল দেওয়া হয় নাই</option>

                                    @foreach ($available_role as $available_role_single)
                                        @php
                                            $selected = ' ';
                                            if (
                                                $available_role_single->id == $value['role_id'] &&
                                                $value['doptor_user_active'] == 1
                                            ) {
                                                $selected = 'selected';
                                            }
                                        @endphp
                                        <option value="{{ $available_role_single->id }}" {{ $selected }}>
                                            {{ $available_role_single->role_name }}</option>
                                    @endforeach

                                </select>
                            </td>
                            <td>
                                @foreach ($available_role as $available_role_single)
                                    @if ($available_role_single->id == $value['role_id'] && $value['doptor_user_active'] == 1)
                                        <button
                                            class="btn-sm btn btn-primary role_name_{{ $increment }}">{{ $available_role_single->role_name }}
                                            এনাবেল</button>
                                    @else
                                        <button class="btn-sm btn btn-danger role_name_{{ $increment }}">কোন রোল দেয়া
                                            হয় নাই ডিজেবেল</button>
                                    @endif
                                @endforeach

                            </td>
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
        $('.role_select').on('change', function() {


            const id = $(this).attr('id');

            swal.showLoading();

            var formdata = new FormData();

            $.ajax({
                url: '{{ route('admin.doptor.management.divisional.commissioner.create') }}',
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
                    role_id: $(this).find('option:selected').val(),
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
                        if (response.role_name == 'No_role') {
                            $('.role_name_' + id).html('বিভাগীয় কমিশনার ডিজেবল');
                            $('.role_name_' + id).removeClass('btn-primary');
                            $('.role_name_' + id).addClass('btn-danger');
                        } else {
                            let texthtml = response.role_name + ' এনাবেল';
                            $('.role_name_' + id).html(texthtml);
                            $('.role_name_' + id).removeClass('btn-danger');
                            $('.role_name_' + id).addClass('btn-primary');
                        }
                    }
                }
            });

        });
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
