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
                <a href="{{ route('mc_sottogolpo.create') }}" class="btn btn-sm btn-success font-weight-bolder">
                    <i class="la la-plus"></i>নতুন গল্প এন্ট্রি
                </a>
            </div>
        </div>
        <div class="card-body">
            
            <table class="table table-hover mb-6 font-size-h6">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" width="30">#</th>
                        <th scope="col">নাম</th>
                        <th scope="col">ইমেজ</th>
                        <th scope="col" width="100">স্ট্যাটাস</th>
                        <th scope="col" width="150">অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @dd($golpos) --}}
                    @php $i = 1; @endphp
                    @foreach ($golpos as $key => $row)
             
                        @php
                            if ($row->status == 1) {
                                $status = '<span class="label label-inline label-light-primary font-weight-bold">এনাবল</span>';
                            } else {
                                $status = '<span class="label label-inline label-light-danger font-weight-bold">ডিসএবল</span>';
                            }
                        @endphp
                        <tr>
                            <td scope="row" class="tg-bn">{{ en2bn($key + 1) }}.</td>
                            <td>{{ en2bn($row->title) }}</td>
                            <td>
                                @if (!empty($row->story_pic))
                                    <img src="{{ asset('mobile_court/uploads/golpo/' . $row->story_pic) }}" alt="Story Image" width="50" height="50">
                                @else
                                    ফাইল সংযুক্তি নেই
                                @endif
                            </td>
                            <td><?= $status ?></td>
                            <td>
                                <a href="{{ route('mc_sottogolpo.edit', $row->id) }}"
                                    class="btn btn-success btn-shadow btn-sm font-weight-bold pt-1 pb-1">সংশোধন</a>
                            </td>
                        </tr>
                        @php $i++; @endphp
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-center">

                {{-- {!! $shortDecision->links('pagination::bootstrap-4') !!} --}}
            </div>

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
    @endsection
