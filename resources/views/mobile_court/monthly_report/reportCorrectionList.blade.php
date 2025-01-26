@extends('layout.app')

@section('content')

@if (session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif
@if (session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

<style>
    td {
        text-align: center;
    }
</style>
<div class="card panel-default">
    <div class="card-header smx">
        <h2 class="card-title"> প্রতিবেদন সংশোধনের তালিকা</h2>
    </div>
    <div class="card-body cpv">
      
    @if ($reportlist->isNotEmpty())
        @foreach($reportlist as $it)
        
           @if ($loop->first)
                <table class="table table-bordered table-striped table-info mb30" align="center">
                <thead>
                <tr>
                    <th>নম্বর</th>
                    <th>প্রতিবেদনের নাম</th>
                    <th> সাল</th>
                    <th> মাস</th>
                    <th> দাখিলের তারিখ</th>
                    <th>এ ডি এম - এর মন্তব্য</th>
                    <th>কার্যক্রম</th>
                </tr>
                </thead>
                <tbody>
            @endif
            <tr>
                <td> {{ $it->index }}</td>
                <td>
                    @if($it->report_type_id == 1)
                        মোবাইল কোর্টের মাসিক প্রতিবেদন
                    @elseif ($it->report_type_id ==2)
                        মোবাইল কোর্টের আপিল মামলার তথ্য
                    @elseif ($it->report_type_id ==3)
                        অতিরিক্ত জেলা ম্যাজিস্ট্রেট আদালতের  মামলার তথ্য
                    @elseif ($it->report_type_id ==4)
                        এক্সিকিউটিভ ম্যাজিস্ট্রেট আদালতের মামলার তথ্য
                    @elseif ($it->report_type_id ==5)
                        এক্সিকিউটিভ ম্যাজিস্ট্রেটের আদালত পরিদর্শন
                    @elseif ( $it->report_type_id ==6 )
                        মোবাইল কোর্ট কেস রেকর্ড পর্যালোচনা
                    @endif
                </td>
                <td>{{ $it->report_year }} </td>
                <td>
                    @if($it->report_month == 1)
                        জানুয়ারী
                    @elseif ($it->report_month ==2)
                        ফেব্রুয়ারী
                    @elseif ($it->report_month ==3)
                        মার্চ
                    @elseif ($it->report_month ==4)
                        এপ্রিল
                    @elseif ($it->report_month ==5)
                        মে
                    @elseif ($it->report_month ==6)
                        জুন
                    @elseif ($it->report_month ==7 )
                        জুলাই
                    @elseif ($it->report_month ==8)
                        আগস্ট
                    @elseif ($it->report_month ==9 )
                        সেপ্টেম্বর
                    @elseif ($it->report_month ==10 )
                        অক্টোবর
                    @elseif ($it->report_month ==11 )
                        নভেম্বর
                    @elseif ($it->report_month ==12 )
                        ডিসেম্বর
                    @endif
                </td>
                <td>{{ $it->system_triger_date }} </td>
                <td>{{ $it->comment_from_adm }} </td>
                <td>
                    @if ($it->report_type_id == 1 )
                    <a href="{{ route('m.mobilecourtreport', ['date' => $it->report_month . '-' . $it->report_year, 'report_type_id' => $it->report_type_id]) }}" class="btn btn-primary">
                        <i class="fa fa-angle-left"></i>  দেখুন
                    </a>
                        {{-- link_to("monthly_report/mobilecourtreport?date=" ~ $it->report_month ~ "-" ~ $it->report_year ~ "&report_type_id="~$it->report_type_id, '<i class="fa fa-angle-left"></i>  দেখুন', "class": "btn btn-primary") --}}
                    @elseif ($it->report_type_id == 2)
                    <a href="{{ route('m.appealcasereport', ['date' => $it->report_month . '-' . $it->report_year, 'report_type_id' => $it->report_type_id]) }}" class="btn btn-primary">
                        <i class="fa fa-angle-left"></i>  দেখুন
                    </a>
                        {{-- link_to("monthly_report/appealcasereport?date=" ~ $it->report_month ~ "-" ~ $it->report_year ~ "&report_type_id="~$it->report_type_id, '<i class="fa fa-angle-left"></i>  দেখুন', "class": "btn btn-primary") --}}
                    @elseif ($it->report_type_id ==3 )
                    <a href="{{ route('m.admcasereport', ['date' => $it->report_month . '-' . $it->report_year, 'report_type_id' => $it->report_type_id]) }}" class="btn btn-primary">
                        <i class="fa fa-angle-left"></i>  দেখুন
                    </a>
                    {{-- link_to("monthly_report/admcasereport?date=" ~ $it->report_month ~ "-" ~ $it->report_year ~ "&report_type_id="~$it->report_type_id, '<i class="fa fa-angle-left"></i>  দেখুন', "class": "btn btn-primary") --}}
                    @elseif ($it->report_type_id ==4 )
                    <a href="{{ route('m.emcasereport', ['date' => $it->report_month . '-' . $it->report_year, 'report_type_id' => $it->report_type_id]) }}" class="btn btn-primary">
                        <i class="fa fa-angle-left"></i>  দেখুন
                    </a>
                        {{-- link_to("monthly_report/emcasereport?date=" ~ $it->report_month ~ "-" ~ $it->report_year ~ "&report_type_id="~$it->report_type_id, '<i class="fa fa-angle-left"></i>  দেখুন', "class": "btn btn-primary") --}}
                    @elseif ($it->report_type_id ==5 )
                    <a href="{{ route('m.courtvisitreport', ['date' => $it->report_month . '-' . $it->report_year, 'report_type_id' => $it->report_type_id]) }}" class="btn btn-primary">
                        <i class="fa fa-angle-left"></i>  দেখুন
                    </a>
                        {{-- link_to("monthly_report/courtvisitreport?date=" ~ $it->report_month ~ "-" ~ $it->report_year ~ "&report_type_id="~$it->report_type_id, '<i class="fa fa-angle-left"></i>  দেখুন', "class": "btn btn-primary") --}}
                    @elseif ($it->report_type_id ==6 )
                    <a href="{{ route('m.caserecordreport', ['date' => $it->report_month . '-' . $it->report_year, 'report_type_id' => $it->report_type_id]) }}" class="btn btn-primary">
                        <i class="fa fa-angle-left"></i>  দেখুন
                    </a>
                        {{-- link_to("monthly_report/caserecordreport?date=" ~ $it->report_month ~ "-" ~ $it->report_year ~ "&report_type_id="~$it->report_type_id, '<i class="fa fa-angle-left"></i>  দেখুন', "class": "btn btn-primary") --}}
                    @endif
                </td>
            </tr>

            @if ($loop->last)
                    </tbody>
                </table>
            @endif
         @endforeach
        @else
            <p style="text-align: center">
                কোন প্রতিবেদন নেই সংশোধনের জন্য
            </p>
        @endif
       
    </div>
    <!-- panel-body -->
</div>
@endsection
