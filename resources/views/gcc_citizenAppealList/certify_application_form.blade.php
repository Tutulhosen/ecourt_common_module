@extends('dashboard.inc.emc.layouts.app')

@section('content')

<style>
    body {
        background-color: rgb(239, 243, 247);
    }
    .table-responsive{
        position: relative;
    }
    .table-responsive::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('https://upload.wikimedia.org/wikipedia/commons/thumb/a/a3/Emblem_of_the_Government_of_the_People%27s_Republic_of_Bangladesh.svg/480px-Emblem_of_the_Government_of_the_People%27s_Republic_of_Bangladesh.svg.png');
        background-size: 400px;
        /* Adjust the size as needed */
        background-position: center;
        background-repeat: no-repeat;
        opacity: 0.06;
        /* Adjust the opacity of the background image */
        z-index: -1;
    }

    .signature {
        border-top: 1px solid black;
        margin-top: 30px;
        padding-top: 10px;
        height: 50px;
    }

    table {
        border-collapse: collapse; /* Ensures borders collapse properly */
        width: 100%;
    }

    th, td {
        border: 1px solid black; /* Adds border to table headers and cells */
        padding: 8px;
    }

    thead tr {
        border: 2px solid black; /* Adds border line after each row in thead */
    }
</style>

<div class="container mt-5" style="color: black;">
    <div class="row justify-content-between align-items-center mb-4">
        <div class="col-md-3 text-center p-3 " style="border: 1px solid black">
            <small>এখানে বিশ টাকা মূল্যের কোর্ট ফি স্ট্যাম্প সংযুক্ত করুন</small>
        </div>
        <div class="col-md-6 text-center">
            <h4>জেলা রেকর্ডরুম</h4>
            <p>{{court_id_to_name($list->court_id)}}</p>
            <h6>নকল প্রাপ্তির জন্য আবেদন</h6>
            <p>আবেদন নং: {{en2bn($list->certify_id)}}</p>
        </div>
        <div class="col-md-3 text-center d-flex flex-column" style="height: 150px; border: 1px solid black">
            <div class="mt-auto signature">অনুলিপিকারকের নাম</div>
        </div>
    </div>

    <!-- Form Table -->
    <form>
        <div class="table-responsive">
            <table class="table text-center align-middle" style="height: 500px; width: 100%;">
                <thead class="table" >

                    <tr>
                        <th width="10">১</th>
                        <th width="20">২</th>
                        <th width="40">৩</th>
                        <th width="10">৪</th>
                        <th width="10">৫</th>
                        <th width="10">৬</th>
                        <th width="10">৭</th>
                        <th width="10">৮</th>
                        <th width="10">৯</th>
                    </tr>
                    <tr>
                        <th>ক্রমিক নং ও তারিখ</th>
                        <th>আবেদনকারীর নাম, ঠিকানা ও মোবাইল নম্বরসহ বিবরণ</th>
                        <th>যে রেকর্ডের নকল প্রয়োজন তার সংক্ষেপ বিবরণ</th>
                        <th>সংশ্লিষ্ট মামলা বা কার্যধারার নথির নম্বর</th>
                        <th>সংযুক্ত স্ট্যাম্প শীট (ফোলিও/ কার্টিজ পেপারের) সংখ্যা</th>
                        <th>সংযুক্ত কোর্ট ফি স্ট্যাম্প</th>
                        <th>যাচিত কাগজপত্র প্রাপ্তির জন্য সম্ভাব্য বাক্তি / দপ্তর</th>
                        <th>নকল সরবরাহের সম্ভাব্য তারিখ ও সময়</th>
                        <th>মন্তব্য (নকল কেন প্রয়োজন তা উল্লেখ করতে হবে)</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>১</td>
                        <td>
                            নামঃ {{ en2bn($list->applicent_name) }}, <br>
                            মোবাইলঃ {{ $list->applicent_phn }} <br>
                           বর্তমান ঠিকানাঃ {{ $list->applicent_p_address }} <br>
                           স্থায়ী ঠিকানাঃ {{ $list->applicent_per_address }}
                        </td>
                        <td></td>
                        <td>{{ en2bn($list->case_no) }}</td>
                        <td>{{ $list->total_page ?? ' ' }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Signature Section -->
        <div class="text-center mt-5" style="display: flex; justify-content: space-between; padding: 0 50px;">
            <div class="col-md-3 p-2 text-center  d-flex flex-column" style="height: 150px; border: 1px solid black;">
                <div class="mt-auto signature">আবেদন গ্রহণকারীর  নাম</div>
            </div>
            <div class="col-md-3 p-2 text-center  d-flex flex-column" style="height: 150px; border: 1px solid black;">
                <div class="mt-auto signature">অনুলিপিকারকের নাম</div>
            </div>
            <div class="col-md-3 p-2 text-center  d-flex flex-column" style="height: 150px; border: 1px solid black;">
                <div class="mt-auto signature">রেকর্ডকিপারের স্বাক্ষর</div>
            </div>
        </div>

    </form>
</div>
@endsection

   
