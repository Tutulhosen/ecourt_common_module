@extends('layout.app')


@section('content')
    <!--begin::Card-->
    <div class="card py-5">
        <div class="row">
            <div class="col-md-6">
                {{-- <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h2>{{ $page_title }}</h2>
                    </div>
                    
                </div> --}}
            </div>
            <div class="col-md-3"></div>
            <div class="col-md-3">

                <label for="">
                    <h3>কোর্টের ধরণ নির্বাচন করুন</h3>
                </label>
                <div style="margin-right: 50px">
                    <select name="" id="" class="form-control court_type" >

                        <option value="1" <?php if ($_GET['court_type_id'] == 1) {
                            echo 'selected';
                        } ?>>মোবাইল কোর্ট</option>
                        <option value="2" <?php if ($_GET['court_type_id'] == 2) {
                            echo 'selected';
                        } ?>>জেনারেল সার্টিফিকেট কোর্ট</option>
                        <option value="3"<?php if ($_GET['court_type_id'] == 3) {
                            echo 'selected';
                        } ?>>এক্সিকিউটিভ ম্যাজিস্ট্রেট কোর্ট</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label text-center">
                    ব্যবহারকারীর ফিচার নির্বাচন করুন
                </h3>
            </div>
        </div>
        <div class="alert alert-danger" style="display: none" role="alert" id="role_permission_select_alert">
            অনুগ্রহ করে রোল নির্বাচন করুন
        </div>
        <div class="p-5">

            <form action="" id="role_permisssion_form">
                @csrf

                <div class="form-group mb-2 mr-2">
                    <select style=" display: <?php if ($_GET['court_type_id'] == 1) {
                        echo 'show';
                    } else {
                        echo 'none';
                    }
                    ?>" name="role_id" class="form-control role_id"
                        id="role_id_1">
                        <option value="0">-রোল নির্বাচন করুন-</option>
                        @foreach ($mc_role as $roles)
                            <option value="{{ $roles->id }}">{{ $roles->role_name }}
                            </option>
                        @endforeach
                    </select>
                    <select style=" display: <?php if ($_GET['court_type_id'] == 2) {
                        echo 'show';
                    } else {
                        echo 'none';
                    }
                    ?>" name="role_id" class="form-control role_id"
                        id="role_id_2">
                        <option value="0">-রোল নির্বাচন করুন-</option>
                        @foreach ($gcc_role as $roles)
                            <option value="{{ $roles->id }}">{{ $roles->role_name }}
                            </option>
                        @endforeach
                    </select>
                    <select style=" display: <?php if ($_GET['court_type_id'] == 3) {
                        echo 'show';
                    } else {
                        echo 'none';
                    }
                    ?>" name="role_id" class="form-control role_id"
                        id="role_id_3">
                        <option value="0">-রোল নির্বাচন করুন-</option>
                        @foreach ($emc_role as $roles)
                            <option value="{{ $roles->id }}">{{ $roles->role_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="perssion_list">
                    <table class="table table-hover mb-6 font-size-h6">
                        <thead class="thead-light">
                            <tr>
                                <!-- <th scope="col" width="30">#</th> -->
                                <th scope="col" class="text-center" width="10%">
                                    সিলেক্ট করুণ
                                </th>
                                <th scope="col" class="text-center"> নাম</th>
                                <!-- <th scope="col" class="text-center">permission details</th> -->
                            </tr>
                        </thead>
                        <tbody style="text-align:center; display: <?php if ($_GET['court_type_id'] == 1) {
                            echo 'show';
                        } else {
                            echo 'none';
                        }
                        ?>">


                            @foreach ($mc_permission as $permissions)
                                <?php
                                ?>
                                <tr>
                                    <td class="text-center">
                                        <div class="checkbox-inline d-flex justify-content-center align-items-center">
                                            <label class="checkbox">
                                                <input type="checkbox" name="role_permisson[]"
                                                       value="{{ $permissions->id }}"
                                                       class="role_permission_check" />
                                                <span></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>{{ $permissions->name }}</td>
                                    <!-- <td>{{ $permissions->details }}</td> -->

                                </tr>
                            @endforeach
                        </tbody>
                        <tbody style="text-align:center; display: <?php if ($_GET['court_type_id'] == 2) {
                            echo 'show';
                        } else {
                            echo 'none';
                        }
                        ?>">


                            @foreach ($gcc_permission as $permissions)
                                <?php
                                ?>
                                <tr>
                                    <td>
                                        <div class="checkbox-inline d-flex justify-content-center align-items-center">
                                            <label class="checkbox">
                                                <input type="checkbox" name="role_permisson[]"
                                                    value="{{ $permissions->id }}"
                                                    class="role_permission_check" /><span></span>
                                        </div>
                                    </td>
                                    <td>{{ $permissions->name }}</td>
                                    <!-- <td>{{ $permissions->details }}</td> -->

                                </tr>
                            @endforeach

                        </tbody>
                        <tbody style="text-align:center; display: <?php if ($_GET['court_type_id'] == 3) {
                            echo 'show';
                        } else {
                            echo 'none';
                        }
                        ?>">


                            @foreach ($emc_permission as $permissions)
                                <?php
                                ?>
                                <tr>
                                    <td>
                                        <div class="checkbox-inline d-flex justify-content-center align-items-center">
                                            <label class="checkbox">
                                                <input type="checkbox" name="role_permisson[]"
                                                    value="{{ $permissions->id }}"
                                                    class="role_permission_check" /><span></span>
                                        </div>
                                    </td>
                                    <td>{{ $permissions->name }}</td>
                                    {{-- <!-- <td>{{ $permissions->details }}</td> --> --}}
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    {{-- <hr> --}}
                </div>
                <div class="text-center" style="width:110%">

                    <button type="submit" class="btn btn-success">নিশ্চিত করুন</button>
                </div>
            </form>
        </div>
    </div>

    <!--end::Card-->



    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $('.court_type').on('change', function() {

            var court_id = $(this).find(":selected").val();


            // Get the current URL
            var currentUrl = window.location.href;

            // Update the URL parameter
            var updatedUrl = updateQueryStringParameter(currentUrl, 'court_type_id', court_id);

            // Redirect to the updated URL
            window.location.href = updatedUrl;

        })

        function updateQueryStringParameter(uri, key, value) {
            var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
            var separator = uri.indexOf('?') !== -1 ? "&" : "?";
            if (uri.match(re)) {
                return uri.replace(re, '$1' + key + "=" + value + '$2');
            } else {
                return uri + separator + key + "=" + value;
            }
        }

        $('.role_id').on('change', function() {

            swal.showLoading();
            $('.perssion_list').empty();

            let court_type = $('.court_type').find(":selected").val();
            let role_id = $('#role_id_' + court_type + ' :selected').val();

            $.ajax({
                url: '{{ route('role-permission.show_permission') }}',
                method: 'post',
                data: {
                    court_type: court_type,
                    role_id: role_id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status == 'success') {
                        Swal.close();
                        $('.perssion_list').html(response.html);

                    }
                }
            });
        })


        $("#role_permisssion_form").on('submit', function(event) {
            event.preventDefault();
            let court_type = $('.court_type').find(":selected").val();
            let role_id = $('#role_id_' + court_type + ' :selected').val();

            var i = 0;
            var arr = [];
            $('.role_permission_check:checked').each(function() {
                arr[i++] = $(this).val();
            });

            var permission = true;
            if ($('#role_id_' + court_type + ' :selected').val() == 0) {
                permission = false;
                Swal.fire(
                    "রোল নির্বাচন করুন"
                )
            }

            if (permission) {

                $.ajax({
                    url: '{{ route('role-permission.store') }}',
                    method: 'post',
                    data: {

                        court_type_id: court_type,
                        role_id: role_id,
                        permission_arr: arr,
                        _token: '{{ csrf_token() }}',
                    },

                    success: function(response) {
                        if (response.status == 'error') {

                            Swal.fire(
                                'সফলভাবে সাবমিট করা হয়েছে',
                            )
                        }
                        if (response.status == 'role_set_error') {
                            Swal.fire(
                                'Failed to set role-permission!!!',
                            )
                        }
                        if (response.status == 'success') {

                            Swal.fire(
                                'সফলভাবে সাবমিট করা হয়েছে',

                            )
                        }
                    }
                });
            }

        })
    </script>
@endsection


{{-- Includable CSS Related Page --}}
@section('styles')
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Page Vendors Styles-->
@endsection

{{-- Scripts Section Related Page --}}
@section('scripts')
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('js/pages/crud/datatables/advanced/multiple-controls.js') }}"></script>
    <!--end::Page Scripts-->
@endsection
