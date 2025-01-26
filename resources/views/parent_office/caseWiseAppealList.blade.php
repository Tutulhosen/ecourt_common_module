@extends('layout.app')

@section('content')

    <style>
        .blink {
            animation: blinker 1.5s linear infinite;
            color: red;
            font-family: sans-serif;
        }

        @keyframes blinker {
            50% {
                opacity: 0;
            }
        }
    </style>

    <!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header flex-wrap py-5">
            <div class="card-title">
                <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>
            </div>
        </div>
        <div class="card-body overflow-auto">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    {{ $message }}
                </div>
            @endif
            @if ($message = Session::get('error'))
                <div class="alert alert-alert">
                    {{ $message }}
                </div>
            @endif

            {{-- @include('appeal.search') --}}
            @php
                $trial_date = date('Y-m-d', strtotime(now()));
                $trial_time = date('H:i:s', strtotime(now()));
                $today = date('Y-m-d', strtotime(now()));
                $today_time = date('H:i:s', strtotime(now()));
            @endphp

            <table class="table table-hover mb-6 font-size-h5">
                <thead class="thead-customStyle font-size-h6">
                    <tr>
                        <th scope="col">ক্রমিক নং</th>
                        <th scope="col">মামলার অবস্থা</th>
                        <th scope="col">মামলা নম্বর</th>
                        <th scope="col">আবেদনকারীর নাম</th>
                        <th scope="col">ম্যানুয়াল মামলা নম্বর</th>
                        <th scope="col">পরবর্তী তারিখ</th>
                        <th scope="col">শুনানির সময়</th>
                        <th scope="col" width="70">পদক্ষেপ </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($paginatedResults as $key => $row)
                        @if ($row['appeal_status'] == 'CLOSED')
                            @php
                                $finalOrderDate = date_create($row['final_order_publish_date']);
                                $today = date_create(date('Y-m-d', strtotime(now())));
                                $diff = date_diff($finalOrderDate, $today);
                                $difference = $diff->format('%a');
                            @endphp
                        @endif
                        @php
                            if (date('a', strtotime($row['next_date_trial_time'])) == 'am') {
                                $time = 'সকাল';
                            } else {
                                $time = 'বিকাল';
                            }
                        @endphp

                        <tr>
                            <td scope="row" class="tg-bn">{{ en2bn($loop->index + 1) }}.</td>
                            <td>{{ appeal_status_bng($row['appeal_status']) }}</td> {{-- Helper Function for Bangla Status --}}
                            <td>{{ $row['case_no'] }}</td>
                            <td>{{ isset($row['citizen_name']) ? $row['citizen_name'] : '-' }}</td>
                            <td>{{ $row['manual_case_no'] }}</td>

                            @if ($row['appeal_status'] == 'ON_TRIAL' || $row['appeal_status'] == 'ON_TRIAL_DM')
                                <td>{{ $row['next_date'] == '1970-01-01' ? '-' : en2bn($row['next_date']) }}</td>
                            @else
                                <td class="text-center"> -- </td>
                            @endif
                            <td>
                                @if ($row['appeal_status'] == 'ON_TRIAL' || $row['appeal_status'] == 'ON_TRIAL_DM')
                                    @if (date('a', strtotime($row['next_date_trial_time'])) == 'am' && $row['next_date'] != '1970-01-01')
                                        সকাল
                                    @elseif(date('a', strtotime($row['next_date_trial_time'])) == 'pm' && $row['next_date'] != '1970-01-01')
                                        বিকাল
                                    @else
                                    @endif
                                @endif

                                @if ($row['appeal_status'] == 'ON_TRIAL' || $row['appeal_status'] == 'ON_TRIAL_DM')
                                    {{ isset($row['next_date_trial_time']) ? en2bn(date('h:i', strtotime($row['next_date_trial_time']))) : '-' }}
                                @else
                                    {{ '--' }}
                                @endif
                            </td>
                            <td>
                                <div class="btn-group float-right">
                                    <button class="btn btn-primary font-weight-bold btn-sm dropdown-toggle" type="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">পদক্ষেপ </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="{{ route('gcc.parent.office.appeal.appealView', encrypt($row['id'])) }}">বিস্তারিত তথ্য</a>
                                        <a class="dropdown-item"
                                            href="{{ route('gcc.parent.office.appeal.case.traking', encrypt($row['id'])) }}">মামলা ট্র্যাকিং</a>

                                        @if ($row['next_date'] == $today && $row['next_date_trial_time'] <= $today_time && $row['is_hearing_required'] == 1)
                                            <a class="dropdown-item blink" href="" style="color: red;" target="_blank">অনলাইন শুনানি</a>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-center">
                {!! $paginatedResults->links('pagination::bootstrap-4') !!}
            </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
            integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            $('.case_modal_loader').on('click', function() {
                $('#hidden_id_paste').val($(this).data('id'));
                $('#case_modal').modal('show');
            })

            function ReportFormSubmit(id) {
                console.log(id);
                let kharij_reason = $("#kharij_reason").val();
                let hide_case_id = $("#hidden_id_paste").val();
                let _token = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    type: 'POST',
                    url: "",
                    data: {
                        kharij_reason: kharij_reason,
                        hide_case_id: hide_case_id,
                        _token: _token
                    },
                    success: (data) => {
                        toastr.success(data.success, "Success");
                        $('.modal').modal('hide');
                        location.reload();
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            }
        </script>
    @endsection

    @section('styles')
    @endsection

    @section('scripts')
    @endsection
