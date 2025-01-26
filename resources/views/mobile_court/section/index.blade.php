@extends('layout.app')
{{-- @extends('layout.default') --}}

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <!--begin::Card-->
    <div class="card card-custom" style="margin-bottom: 20px">
        <div class="card-header flex-wrap py-5">
            <div class="card-title">
                <h3 class="card-title h2 font-weight-bolder">{{-- {{ $page_title }} --}}</h3>
            </div>
            <div class="card-toolbar">
                <a href="{{ route('mc.section.create') }}" class="btn btn-sm btn-success font-weight-bolder">
                    <i class="la la-plus"></i>নতুন ধারা এন্ট্রি
                </a>
            </div>
        </div>
        <div class="card-body">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    {{ $message }}
                </div>
            @endif

            <table class="table table-hover mb-6 font-size-h6" id="example">
                <thead class="thead-light">
                    <tr style="text-align: center">
                        <th scope="col" width='100'>শিরোনাম</th>
                        <th scope="col" width='100'>শাস্তির ধারা নাম্বার</th>
                        <th scope="col" width="100">ধারার বর্ণনা</th>
                        <th scope="col" width="100">অপরাধের বর্ণনা</th>
                        <th scope="col" width="100">শাস্তির বিবরণ</th>
                        <th scope="col" width="100">অপারেশান</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($sections as $key => $row)
                        <tr>
                            <td>{{ en2bn($row->sec_title) }}</td>
                            <td>
                                {{ $row->punishment_sec_number }}
                            </td>
                            <td>{{ $row->sec_description }}</td>
                            <td>{{ $row->punishment_des }}</td>
                            <td>
                                <table class="table table-bordered"
                                    style="text-align: center; border-collapse: collapse; width: 100%;">
                                    <tr>
                                        <td style="font-weight: bold; width: 25%;">-</td>
                                        <td style="font-weight: bold; width: 37.5%;">কয়েদ</td>
                                        <td style="font-weight: bold; width: 37.5%;">জরিমানা</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold;">সর্বোচ্চ</td>
                                        <td>{{ $row->max_jell ?? '-' }}</td>
                                        <td>{{ $row->max_fine ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold;">সর্বনিম্ন</td>
                                        <td>{{ $row->min_jell ?? '-' }}</td>
                                        <td>{{ $row->min_fine ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold;">পুনরায় অপরাধের শাস্তি</td>
                                        <td>{{ $row->next_jail ?? '-' }}</td>
                                        <td>{{ $row->next_fine ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold;">শাস্তির ধরন</td>
                                        <td colspan="2">{{ $row->punishment_type_des ?? '-' }}</td>
                                    </tr>
                                </table>

                            </td>
                            <td>
                                <a href="{{ route('mc.section.edit', $row->id) }}"
                                    class="btn btn-success btn-shadow btn-sm font-weight-bold pt-1 pb-1">সংশোধন</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-center">

                {{-- {!! $sections->links('pagination::bootstrap-4') !!} --}}
            </div>

        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <!--end::Card-->
@endsection


@section('styles')
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Page Vendors Styles-->
@endsection

@section('scripts')
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('js/pages/crud/datatables/advanced/multiple-controls.js') }}"></script>
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
