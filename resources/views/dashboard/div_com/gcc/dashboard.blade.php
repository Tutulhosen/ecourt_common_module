<div class="mc_dashboard dashboard">
    {{-- <h3>Gcc dashboard</h3> --}}
    {{-- @section('content') --}}
        {{-- @include('dashboard.inc.icon_card_appeal') --}}
        {{-- @include('dashboard.citizen.cause_list') --}}

        <form action="javascript:void(0)" class="form" method="POST">
            @csrf
            <fieldset class="mb-6">
                <legend>ফিল্টারিং ফিল্ড</legend>

                <div class="row">
                    <div class="col-md-4  mb-5">
                        <!-- <label>জেলা <span class="text-danger">*</span></label> -->
                        <select name="gcc_district" id="gcc_district_id" class="form-control form-control-sm">
                            <option value="">-জেলা নির্বাচন-</option>
                            @foreach ($districts as $value)
                                <option value="{{ $value->id }}"> {{ $value->district_name_bn }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4  mb-5">
                        <!-- <label>উপজেলা </label> -->
                        <select name="gcc_upazila" id="gcc_upazila_id" class="form-control form-control-sm">
                            <option value="">-উপজেলা নির্বাচন-</option>
                        </select>
                    </div>
                    <div class="col-md-4  mb-5">
                        <input type="text" name="gcc_date_from" id="gcc_date_from"
                            class="form-control form-control-sm common_datepicker" placeholder="তারিখ হতে"
                            autocomplete="off">
                    </div>
                    <div class="col-md-4  mb-5">
                        <input type="text" name="gcc_date_to" id="gcc_date_to"
                            class="form-control form-control-sm common_datepicker" placeholder="তারিখ পর্যন্ত"
                            autocomplete="off">
                    </div>
                </div>
            </fieldset>
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-custom">
                        <div class="card-header">
                            <div class="card-title ">
                                <h3 class="card-label font-weight-bolder text-dark h3">আদালত ভিত্তিক মামলার পরিসংখ্যান</h3>
                            </div>
                            <div class="card-toolbar">
                                <button class="report-case-status btn btn-success spinner spinner-darker-white spinner-left"
                                    onclick="case_status_statistic()">অনুসন্ধান করুন</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="font-weight-boldest text-center h5 text-success" id="caseStatusMsg"></p>
                            <ul class="navi navi-border navi-hover navi-active">
                                <li class="navi-item">
                                    <a class="navi-link" href="#">
                                        <span class="navi-icon"><i class="fas fa-gavel icon-lg text-danger mr-3"></i></span>
                                        <div class="navi-text">
                                            <span class="d-block font-weight-bolder font-weight-bold h6 pt-2">জেনারেল
                                                সার্টিফিকেট অফিসারের আদালতে বিচারাধীন মামলা</span>
                                        </div>
                                        <span class="navi-label">
                                            <span class="label label-xl label-danger h6" id="ON_TRIAL">0</span>
                                        </span>
                                    </a>
                                </li>
                                <li class="navi-item">
                                    <a class="navi-link" href="#">
                                        <span class="navi-icon"><i class="fas fa-gavel icon-lg text-danger mr-3"></i></span>
                                        <div class="navi-text">
                                            <span class="d-block font-weight-bolder font-weight-bold h6 pt-2">অতিরিক্ত জেলা
                                                প্রশাসক (রাজস্ব) এর আদালতে বিচারাধীন আপীল মামলা</span>
                                        </div>
                                        <span class="navi-label">
                                            <span class="label label-xl label-danger h6" id="ON_TRIAL_DC">0</span>
                                        </span>
                                    </a>
                                </li>
                                <li class="navi-item">
                                    <a class="navi-link" href="#">
                                        <span class="navi-icon"><i class="fas fa-gavel icon-lg text-danger mr-3"></i></span>
                                        <div class="navi-text">
                                            <span class="d-block font-weight-bolder font-weight-bold h6 pt-2">অতিরিক্ত
                                                বিভাগীয় কমিশনার (রাজস্ব) এর আদালতে বিচারাধীন আপীল মামলা</span>
                                        </div>
                                        <span class="navi-label">
                                            <span class="label label-xl label-danger h6" id="ON_TRIAL_DIV_COM">0</span>
                                        </span>
                                    </a>
                                </li>
                                <li class="navi-item">
                                    <a class="navi-link" href="#">
                                        <span class="navi-icon"><i class="fas fa-gavel icon-lg text-danger mr-3"></i></span>
                                        <div class="navi-text">
                                            <span class="d-block font-weight-bolder font-weight-bold h6 pt-2">সার্টিফিকেট
                                                অফিসারের আদালতে গ্রহনের জন্য অপেক্ষমান রিকুইজিশন</span>
                                        </div>
                                        <span class="navi-label">
                                            <span class="label label-xl label-danger h6" id="SEND_TO_GCO">0</span>
                                        </span>
                                    </a>
                                </li>
                                <li class="navi-item">
                                    <a class="navi-link" href="#">
                                        <span class="navi-icon"><i class="fas fa-gavel icon-lg text-danger mr-3"></i></span>
                                        <div class="navi-text">
                                            <span class="d-block font-weight-bolder font-weight-bold h6 pt-2">সার্টিফিকেট
                                                সহকারীর গ্রহনের জন্য অপেক্ষমান রিকুইজিশন</span>
                                        </div>
                                        <span class="navi-label">
                                            <span class="label label-xl label-danger h6" id="SEND_TO_ASST_GCO">0</span>
                                        </span>
                                    </a>
                                </li>
                                <li class="navi-item">
                                    <a class="navi-link" href="#">
                                        <span class="navi-icon"><i class="fas fa-gavel icon-lg text-danger mr-3"></i></span>
                                        <div class="navi-text">
                                            <span class="d-block font-weight-bolder font-weight-bold h6 pt-2">অতিরিক্ত
                                                বিভাগীয় কমিশনার (রাজস্ব) এর আদালতে নিষ্পত্তিকৃত আপীল মামলা</span>
                                        </div>
                                        <span class="navi-label">
                                            <span class="label label-xl label-danger h6" id="SEND_TO_DC">0</span>
                                        </span>
                                    </a>
                                </li>
                                <li class="navi-item">
                                    <a class="navi-link" href="#">
                                        <span class="navi-icon"><i
                                                class="fas fa-gavel icon-lg text-danger mr-3"></i></span>
                                        <div class="navi-text">
                                            <span class="d-block font-weight-bolder font-weight-bold h6 pt-2">অতিরিক্ত জেলা
                                                প্রশাসক (রাজস্ব) এর আদালতে নিষ্পত্তিকৃত আপীল মামলা</span>
                                        </div>
                                        <span class="navi-label">
                                            <span class="label label-xl label-danger h6" id="SEND_TO_DC">0</span>
                                        </span>
                                    </a>
                                </li>

                                {{--   <li class="list-group-item font-weight-bolder h6"><i
                                    class="fas fa-gavel icon-lg text-danger mt-3"></i>অতিরিক্ত বিভাগীয় কমিশনারের (রাজস্ব) আদালতে নিষ্পত্তিকৃত আপীল মামলা
                                <span class="label label-inline label-danger font-weight-bold float-right h6"
                                    id="SEND_TO_DIV_COM">0</span>
                            </li> --}}
                                {{-- <li class="list-group-item font-weight-bolder h6" style=" "><i
                                    class="fas fa-gavel icon-lg text-danger mr-3"></i>অতিরিক্ত জেলা প্রশাসকের (রাজস্ব) আদালতে নিষ্পত্তিকৃত আপীল মামলা
                                <span class="label label-inline label-danger font-weight-bold float-right h6"
                                    id="SEND_TO_DC">0</span>
                            </li> --}}
                                <!-- <li class="navi-item">
                                    <a class="navi-link" href="#">
                                        <span class="navi-icon"><i class="fas fa-gavel icon-lg text-danger mr-3"></i></span>
                                        <div class="navi-text">
                                            <span class="d-block font-weight-bolder font-weight-bold h6 pt-2">বিভাগীয় কমিশনার
                                                মহোদয়ের গ্রহণের জন্য অপেক্ষমান মামলা</span>
                                        </div>
                                        <span class="navi-label">
                                            <span class="label label-xl label-danger h6" id="SEND_TO_DIV_COM">0</span>
                                        </span>
                                    </a>
                                </li> -->
                                <!-- <li class="navi-item">
                                    <a class="navi-link" href="#">
                                        <span class="navi-icon"><i class="fas fa-gavel icon-lg text-danger mr-3"></i></span>
                                        <div class="navi-text">
                                            <span class="d-block font-weight-bolder font-weight-bold h6 pt-2">এলএবি চেয়ারম্যান
                                                মহোদয়ের গ্রহণের জন্য অপেক্ষমান মামলা</span>
                                        </div>
                                        <span class="navi-label">
                                            <span class="label label-xl label-danger h6" id="SEND_TO_NBR_CM">0</span>
                                        </span>
                                    </a>
                                </li> -->
                                <li class="navi-item">
                                    <a class="navi-link" href="#">
                                        <span class="navi-icon"><i
                                                class="fas fa-gavel icon-lg text-danger mr-3"></i></span>
                                        <div class="navi-text">
                                            <span class="d-block font-weight-bolder font-weight-bold h6 pt-2">জেনারেল
                                                সার্টিফিকেট আদালতে নিষ্পত্তিকৃত মোট মামলা</span>
                                        </div>
                                        <span class="navi-label">
                                            <span class="label label-xl label-danger h6" id="CLOSED">0</span>
                                        </span>
                                    </a>
                                </li>
                                <!-- <li class="navi-item">
                                    <a class="navi-link" href="#">
                                        <span class="navi-icon"><i class="fas fa-gavel icon-lg text-danger mr-3"></i></span>
                                        <div class="navi-text">
                                            <span class="d-block font-weight-bolder font-weight-bold h6 pt-2">খারিজকৃত
                                                মামলা</span>
                                        </div>
                                        <span class="navi-label">
                                            <span class="label label-xl label-danger h6" id="REJECTED">0</span>
                                        </span>
                                    </a>
                                </li> -->
                            </ul>
                        </div>

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-custom">
                        <div class="card-header">
                            <div class="card-title ">
                                <h3 class="card-label font-weight-bolder text-dark h3">অর্থ আদায়</h3>
                            </div>
                            <div class="card-toolbar">
                                <button class="report-payment btn btn-success spinner spinner-darker-white spinner-left"
                                    onclick="payment_statistic()">অনুসন্ধান করুন</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="font-weight-boldest text-center h5 text-success" id="paymentMsg"></p>
                            <div id="result_table"></div>
                        </div>

                    </div>
                </div>
            </div> <!-- /row -->
        </form>


        <style type="text/css">
            /*highchart css*/

            .highcharts-figure,
            .highcharts-data-table table {
                /*min-width: 310px; */
                /*max-width: 1000px;*/
                /*margin: 1em auto;*/
            }

            #container {
                /*height: 400px;*/
            }

            .highcharts-data-table table {
                font-family: Verdana, sans-serif;
                border-collapse: collapse;
                border: 1px solid #EBEBEB;
                margin: 10px auto;
                text-align: center;
                width: 100%;
                /*max-width: 500px;*/
            }

            .highcharts-data-table caption {
                padding: 1em 0;
                font-size: 1.2em;
                color: #555;
            }

            .highcharts-data-table th {
                font-weight: 600;
                padding: 0.5em;
            }

            .highcharts-data-table td,
            .highcharts-data-table th,
            .highcharts-data-table caption {
                padding: 0.5em;
            }

            .highcharts-data-table thead tr,
            .highcharts-data-table tr:nth-child(even) {
                background: #f8f8f8;
            }

            .highcharts-data-table tr:hover {
                background: #f1f7ff;
            }


            /*Pie chart*/
            .highcharts-figure,
            .highcharts-data-table table {
                min-width: 320px;
                max-width: 1030px;
                margin: 1em auto;
            }

            .highcharts-data-table table {
                font-family: Verdana, sans-serif;
                border-collapse: collapse;
                border: 1px solid #EBEBEB;
                margin: 10px auto;
                text-align: center;
                width: 100%;
                max-width: 500px;
            }

            .highcharts-data-table caption {
                padding: 1em 0;
                font-size: 1.2em;
                color: #555;
            }

            .highcharts-data-table th {
                font-weight: 600;
                padding: 0.5em;
            }

            .highcharts-data-table td,
            .highcharts-data-table th,
            .highcharts-data-table caption {
                padding: 0.5em;
            }

            .highcharts-data-table thead tr,
            .highcharts-data-table tr:nth-child(even) {
                background: #f8f8f8;
            }

            .highcharts-data-table tr:hover {
                background: #f1f7ff;
            }


            input[type="number"] {
                min-width: 50px;
            }
        </style>

        <style type="text/css">
            fieldset {
                border: 1px solid #ddd !important;
                margin: 0;
                xmin-width: 0;
                padding: 10px;
                position: relative;
                border-radius: 4px;
                background-color: #d5f7d5;
                padding-left: 10px !important;
            }

            fieldset .form-label {
                color: black;
            }

            legend {
                font-size: 14px;
                font-weight: bold;
                width: 45%;
                border: 1px solid #ddd;
                border-radius: 4px;
                padding: 5px 5px 5px 10px;
                background-color: #5cb85c;
            }

            .list-group-flush>.list-group-item {
                padding-left: 0;
            }
        </style>

        <div class="row">
            <div class="col-xl-12">
                <div class="card card-custom card-stretch gutter-b">
                    <figure class="highcharts-figure" style="width: 100%">
                        <div id="container"></div>
                    </figure>
                </div>
            </div>
        </div>
    {{-- @endsection --}}
</div>
