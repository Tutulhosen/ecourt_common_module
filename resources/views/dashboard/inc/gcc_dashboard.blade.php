<div class="gcc_dashboard dashboard active">
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
                <div class="card-body" style="padding: 10px">
                    {{-- <p class="font-weight-boldest text-center h5 text-success" id="caseStatusMsg"></p> --}}
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item font-weight-bolder h6"
                            style="margin-left: 12px; display: flex; justify-content: space-between; align-items: center;">
                            <!-- Left Content -->
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <i class="fas fa-gavel icon-lg text-danger"></i>
                                <p style="margin: 2px;">জেনারেল সার্টিফিকেট অফিসারের আদালতে বিচারাধীন মামলা</p>
                            </div>
                            <!-- Right Content -->
                            <div class="mb-1">
                                <span class="label label-inline label-danger font-weight-bold h6"
                                    id="ON_TRIAL">0</span>
                            </div>
                        </li>

                        {{-- <li class="list-group-item font-weight-bolder h6" style="margin-left:12px"><i
                                class="fas fa-gavel icon-lg text-danger mr-3"></i>অতিরিক্ত জেলা প্রশাসক (রাজস্ব) এর
                            আদালতে বিচারাধীন আপীল মামলা
                            <span class="label label-inline label-danger font-weight-bold float-right h6"
                                id="ON_TRIAL_DC">0</span>
                        </li> --}}

                        <li class="list-group-item font-weight-bolder h6"
                            style="margin-left: 12px; display: flex; justify-content: space-between; align-items: center;">
                            <!-- Left Content -->
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <i class="fas fa-gavel icon-lg text-danger"></i>
                                <p style="margin: 2px;">অতিরিক্ত জেলা প্রশাসক (রাজস্ব) এর
                                    আদালতে বিচারাধীন আপীল মামলা</p>
                            </div>
                            <!-- Right Content -->
                            <div class="mb-1">
                                <span class="label label-inline label-danger font-weight-bold h6"
                                    id="ON_TRIAL_DC">0</span>
                            </div>
                        </li>

                        {{--  <li class="list-group-item font-weight-bolder h6"
                            style="margin-left: 12px; display: flex; justify-content: space-between; align-items: center;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <i class="fas fa-gavel icon-lg text-danger"></i>
                                <p style="margin: 2px;">অতিরিক্ত বিভাগীয় কমিশনার (রাজস্ব) এর আদালতে বিচারাধীন
                                    আপীল মামলা</p>
                            </div>
                            <div class="mb-1">
                                <span class="label label-inline label-danger font-weight-bold h6"
                                    id="ON_TRIAL_DIV_COM">0</span>
                            </div>
                        </li> --}}

                        <li class="list-group-item font-weight-bolder h6"
                            style="margin-left: 12px; display: flex; justify-content: space-between; align-items: center;">
                            <!-- Left Content -->
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <i class="fas fa-gavel icon-lg text-danger"></i>
                                <p style="margin: 2px;">অতিরিক্ত বিভাগীয় কমিশনার (রাজস্ব) এর আদালতে বিচারাধীন
                                    আপীল মামলা</p>
                            </div>
                            <!-- Right Content -->
                            <div class="mb-1">
                                <span class="label label-inline label-danger font-weight-bold h6"
                                    id="ON_TRIAL_DIV_COM">0</span>
                            </div>
                        </li>
                        {{--  <li class="list-group-item font-weight-bolder h6" style="margin-left:12px"><i
                                class="fas fa-gavel icon-lg text-danger mr-3"></i>ভূমি আপীল বোর্ড চেয়ারম্যানের আদালতে
                            বিচারাধীন আপীল মামলা
                            <span class="label label-inline label-danger font-weight-bold float-right h6"
                                id="ON_TRIAL_LAB_CM">0</span>
                        </li> --}}
                        <li class="list-group-item font-weight-bolder h6"
                            style="margin-left: 12px; display: flex; justify-content: space-between; align-items: center;">
                            <!-- Left Content -->
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <i class="fas fa-gavel icon-lg text-danger"></i>
                                <p style="margin: 2px;">ভূমি আপীল বোর্ড চেয়ারম্যানের আদালতে
                                    বিচারাধীন আপীল মামলা</p>
                            </div>
                            <!-- Right Content -->
                            <div class="mb-1">
                                <span class="label label-inline label-danger font-weight-bold h6"
                                    id="ON_TRIAL_LAB_CM">0</span>
                            </div>
                        </li>

                        {{-- 
                        <li class="list-group-item font-weight-bolder h6" style="margin-left:12px"><i
                                class="fas fa-gavel icon-lg text-danger mr-3"></i>সার্টিফিকেট অফিসারের আদালতে গ্রহনের
                            জন্য অপেক্ষমান রিকুইজিশন
                            <span class="label label-inline label-danger font-weight-bold float-right h6"
                                id="SEND_TO_GCO">0</span>
                        </li> --}}

                        <li class="list-group-item font-weight-bolder h6"
                            style="margin-left: 12px; display: flex; justify-content: space-between; align-items: center;">
                            <!-- Left Content -->
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <i class="fas fa-gavel icon-lg text-danger"></i>
                                <p style="margin: 2px;">সার্টিফিকেট অফিসারের আদালতে গ্রহনের
                                    জন্য অপেক্ষমান রিকুইজিশন</p>
                            </div>
                            <!-- Right Content -->
                            <div class="mb-1">
                                <span class="label label-inline label-danger font-weight-bold h6"
                                    id="SEND_TO_GCO">0</span>
                            </div>
                        </li>


                        {{--   <li class="list-group-item font-weight-bolder h6" style="margin-left:12px"><i
                                class="fas fa-gavel icon-lg text-danger mr-3"></i>সার্টিফিকেট সহকারীর গ্রহনের জন্য
                            অপেক্ষমান রিকুইজিশন
                            <span class="label label-inline label-danger font-weight-bold float-right h6"
                                id="SEND_TO_ASST_GCO">0</span>
                        </li> --}}
                        <li class="list-group-item font-weight-bolder h6"
                            style="margin-left: 12px; display: flex; justify-content: space-between; align-items: center;">
                            <!-- Left Content -->
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <i class="fas fa-gavel icon-lg text-danger"></i>
                                <p style="margin: 2px;">সার্টিফিকেট সহকারীর গ্রহনের জন্য
                                    অপেক্ষমান রিকুইজিশন</p>
                            </div>
                            <!-- Right Content -->
                            <div class="mb-1">
                                <span class="label label-inline label-danger font-weight-bold h6"
                                    id="SEND_TO_ASST_GCO">0</span>
                            </div>
                        </li>
                        {{-- <li class="list-group-item font-weight-bolder h6" style="margin-left:12px"><i
                                class="fas fa-gavel icon-lg text-danger mr-3"></i>ভূমি আপীল বোর্ড চেয়ারম্যানের আদালতে
                            নিষ্পত্তিকৃত আপীল মামলা
                            <span class="label label-inline label-danger font-weight-bold float-right h6"
                                id="SEND_TO_DC">0</span>
                        </li> --}}

                        <li class="list-group-item font-weight-bolder h6"
                            style="margin-left: 12px; display: flex; justify-content: space-between; align-items: center;">
                            <!-- Left Content -->
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <i class="fas fa-gavel icon-lg text-danger"></i>
                                <p style="margin: 2px;">ভূমি আপীল বোর্ড চেয়ারম্যানের আদালতে
                                    নিষ্পত্তিকৃত আপীল মামলা</p>
                            </div>
                            <!-- Right Content -->
                            <div class="mb-1">
                                <span class="label label-inline label-danger font-weight-bold h6"
                                    id="SEND_TO_DC">0</span>
                            </div>
                        </li>

                        <li class="list-group-item font-weight-bolder h6"
                            style="margin-left: 12px; display: flex; justify-content: space-between; align-items: center;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <i class="fas fa-gavel icon-lg text-danger"></i>
                                <p style="margin: 2px;">অতিরিক্ত বিভাগীয় কমিশনার (রাজস্ব) এর আদালতে নিষ্পত্তিকৃত
                                    আপীল মামলা</p>
                            </div>
                            <div class="mb-1">
                                <span class="label label-inline label-danger font-weight-bold h6"
                                    id="SEND_TO_DIV_COM">0</span>
                            </div>
                        </li>
                        <li class="list-group-item font-weight-bolder h6 " style="margin-left:12px"><i
                                class="fas fa-gavel icon-lg text-danger mr-3"></i>অতিরিক্ত জেলা প্রশাসক (রাজস্ব) এর
                            আদালতে নিষ্পত্তিকৃত আপীল মামলা
                            <span class="label label-inline label-danger font-weight-bold float-right h6"
                                id="SEND_TO_DC">0</span>
                        </li>
                        <li class="list-group-item font-weight-bolder h6" style="margin-left:12px"><i
                                class="fas fa-gavel icon-lg text-danger mr-3"></i>জেনারেল সার্টিফিকেট আদালতে
                            নিষ্পত্তিকৃত মোট মামলা
                            <span class="label label-inline label-danger font-weight-bold float-right h6"
                                id="CLOSED">0</span>
                        </li>
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
                <div class="card-body" style="padding: 15px">
                    <p class="font-weight-boldest text-center h5" style="color: green" id="paymentMsg"></p>
                    <div id="result_table"></div>
                </div>

            </div>
        </div>
    </div>
    <br>
    <div class="row">

        <div class="col-md-6">
            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title ">
                        <h3 class="card-label font-weight-bolder text-dark h3">অর্থ আদায়ের পাই চার্ট </h3>
                    </div>
                    <div class="card-toolbar">
                        <button class="case-piechart btn btn-success spinner spinner-darker-white spinner-left"
                            onclick="case_pie_chart()">অনুসন্ধান করুন</button>
                    </div>
                </div>
                <div class="card-body">
                    <div style="width: 100%;">
                        <div id="piechart_3d" style="width: 100%;"></div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-lg-6">
            <div class="card card-custom card-stretch gutter-b">
                <figure class="highcharts-figure" style="width: 100%;">
                    <div id="container"></div>
                </figure>
            </div>
        </div>
    </div>

</div>
