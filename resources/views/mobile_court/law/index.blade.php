@extends('layout.app')
{{-- @extends('layout.default') --}}

@section('content')
    <!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header flex-wrap py-5">
            <div class="card-title">
                <h3 class="card-title h2 font-weight-bolder">{{-- {{ $page_title }} --}}</h3>
            </div>
            <div class="card-toolbar">
                <a href="{{ route('mc.law.create') }}" class="btn btn-sm btn-success font-weight-bolder">
                    <i class="la la-plus"></i>নতুন আইন এন্ট্রি
                </a>
            </div>
        </div>
        <div class="card-body">
            {{-- @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    {{ $message }}
                </div>
            @endif --}}
            {{-- <form class="form-inline" method="GET">
                <div class="container">
                   <div class="row">
                      <div class="col-lg-3 mb-5">
                         <input type="text" name="search_short_order_name" class="w-100 form-control" placeholder="জিসিও এর আদেশ" autocomplete="off">
                      </div>
                      <div class="col-lg-3 col-lg-2 text-right">
                     </div>
                     <div class="col-lg-3 col-lg-2 text-right">
                    </div>
                      <div class="col-lg-3 col-lg-2 text-right">
                         <button type="submit" class="btn btn-success font-weight-bolder mb-2 ml-2">অনুসন্ধান করুন</button>
                      </div>
                   </div>
                </div>
             
             </form> --}}
            <table class="table table-hover mb-6 font-size-h6" id="example">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" width="100">আইন নম্বর</th>
                        <th scope="col" width="100">শিরোনাম</th>
                        <th scope="col" width="100">বর্ণনা</th>
                        <th scope="col" width="100" >মূল আইনের লিঙ্ক</th>
                        <th scope="col" width="100" >অপারেশান</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @dd($laws) --}}
                    @php $i = 1; @endphp
                    @foreach ($laws as $key => $row)
                        {{-- @php
                            if ($row->status == 1) {
                                $status = '<span class="label label-inline label-light-primary font-weight-bold">এনাবল</span>';
                            } else {
                                $status = '<span class="label label-inline label-light-danger font-weight-bold">ডিসএবল</span>';
                            }
                        @endphp --}}
                        <tr>
                            <td scope="row" class="tg-bn">{{ en2bn($key + 1) }}.</td>
                            <td>{{ en2bn($row->title) }}</td>
                            <td>{{ $row->description }}</td>
                            {{-- <td>
                                @php
                                    $law_type = DB::table('mc_law_type')->where('id', '=', $row->law_type_id)->first();
                                @endphp
                                {{$law_type?$law_type->name: "No type found"}}
                            </td> --}}
                            <td><a href="{{$row->bd_law_link}}" target="_blank">বিস্তারিত আইন</a></td>
                            {{-- <td><?= $status ?></td> --}}
                            <td>
                                {{-- <a href="{{ route('mc.law.create', $row->id) }}"
                                    class="btn btn-warning btn-shadow btn-sm font-weight-bold pt-1 pb-1"></a> --}}
                                <a href="{{ route('mc.law.edit', $row->id) }}"
                                    class="btn btn-success btn-shadow btn-sm font-weight-bold pt-1 pb-1">পরিবর্তন করুন</a>
                            </td>
                        </tr>
                        @php $i++; @endphp
                    @endforeach
                </tbody>
            </table>

           

        </div>
        <!--end::Card-->
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
