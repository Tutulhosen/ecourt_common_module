<div class="emc_dashboard dashboard">
    <div class="row">
        <div class="col-lg-6">
            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title ">
                        <h3 class="card-label font-weight-bolder text-dark h3">অভিযোগের ধরণভিত্তিক মামলার পরিসংখ্যান
                        </h3>
                    </div>
                    <div class="card-toolbar">
                        <button class="report-crpc btn btn-success spinner spinner-darker-white spinner-left"
                            onclick="crpc_statistic()">অনুসন্ধান করুন</button>
                    </div>
                </div>
                <div class="card-body">
                    <!-- <div class="spinner spinner-danger spinner-lg"></div> -->
                    <!-- <div class="loadersmall" style="display: none;">dfds</div> -->
                    <p class="font-weight-boldest text-center h5 text-success" id="crpcMsg"></p>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item font-weight-bolder h6"> <i
                                class="fas fa-folder-open icon-lg text-danger mr-2"></i> বেআইনীভাবে আটক
                            <span class="label label-inline label-danger font-weight-bold float-right h6"
                                id="crpc100">0</span>
                        </li>
                        <li class="list-group-item font-weight-bolder h6"><i
                                class="fas fa-folder-open icon-lg text-danger mr-2"></i> শান্তি ভঙ্গ
                            <span class="label label-inline label-danger font-weight-bold float-right h6"
                                id="crpc107">0</span>
                        </li>
                        <li class="list-group-item font-weight-bolder h6"><i
                                class="fas fa-folder-open icon-lg text-danger mr-2"></i> রাষ্ট্রদ্রোহিতামূলক বিষয় প্রচার
                            <span class="label label-inline label-danger font-weight-bold float-right h6"
                                id="crpc108">0</span>
                        </li>
                        <li class="list-group-item font-weight-bolder h6"><i
                                class="fas fa-folder-open icon-lg text-danger mr-2"></i> ভবঘুরে ও সন্দেহভাজন ব্যক্তি
                            কর্তৃক উপস্থিতি গোপন ও অপরাধ
                            <span class="label label-inline label-danger font-weight-bold float-right h6"
                                id="crpc109">0</span>
                        </li>
                        <li class="list-group-item font-weight-bolder h6"><i
                                class="fas fa-folder-open icon-lg text-danger mr-2"></i> অভ্যাসগত অপরাধী কর্তৃক অপরাধ
                            সংঘটন
                            <span class="label label-inline label-danger font-weight-bold float-right h6"
                                id="crpc110">0</span>
                        </li>
                        <li class="list-group-item font-weight-bolder h6"><i
                                class="fas fa-folder-open icon-lg text-danger mr-2"></i> মানুষের জীবন ,স্বাস্থ্য বা
                            নিরাপত্তার প্রতি বিপদ বা দাঙ্গা-হাঙ্গামার সম্ভাবনা সৃষ্টিকারী অপরাধ সংঘটন
                            <span class="label label-inline label-danger font-weight-bold float-right h5"
                                id="crpc144">0</span>
                        </li>
                        <li class="list-group-item font-weight-bolder h6"><i
                                class="fas fa-folder-open icon-lg text-danger mr-2"></i> স্থাবর সম্পত্তি বিষয়ক বিরোধের
                            ফলে শান্তি ভঙ্গ
                            <span class="label label-inline label-danger font-weight-bold float-right h6"
                                id="crpc145">0</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title ">
                        <h3 class="card-label font-weight-bolder text-dark h3">আদালত ভিত্তিক মামলার পরিসংখ্যান</h3>
                    </div>
                    <div class="card-toolbar">
                        <button class="emc_report-case-status btn btn-success spinner spinner-darker-white spinner-left"
                            onclick="emc_case_status_statistic()">অনুসন্ধান করুন</button>
                    </div>
                </div>
                <div class="card-body">
                    <p class="font-weight-boldest text-center h5 text-success" id="emc_caseStatusMsg"></p>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item font-weight-bolder h6"> <i
                                class="fas fa-gavel icon-lg text-danger mr-3"></i> এক্সিকিউটিভ ম্যাজিস্ট্রেটের আদালতে
                            বিচারাধীন
                            <span class="label label-inline label-danger font-weight-bold float-right h6"
                                id="EMC_ON_TRIAL">0</span>
                        </li>
                        <li class="list-group-item font-weight-bolder h6"><i
                                class="fas fa-gavel icon-lg text-danger mr-3"></i>অতিরিক্ত জেলা ম্যাজিস্ট্রেটের আদালতে
                            বিচারাধীন
                            <span class="label label-inline label-danger font-weight-bold float-right h6"
                                id="EMC_ON_TRIAL_DM">0</span>
                        </li>
                        <li class="list-group-item font-weight-bolder h6"><i
                                class="fas fa-gavel icon-lg text-danger mr-3"></i> গ্রহণের জন্য অপেক্ষমান (ইএম কোর্ট)
                            <span class="label label-inline label-danger font-weight-bold float-right h6"
                                id="EMC_SEND_TO_EM">0</span>
                        </li>
                        <li class="list-group-item font-weight-bolder h6"><i
                                class="fas fa-gavel icon-lg text-danger mr-3"></i> গ্রহণের জন্য অপেক্ষমান (এডিএম কোর্ট)
                            <span class="label label-inline label-danger font-weight-bold float-right h6"
                                id="EMC_SEND_TO_ADM">0</span>
                        </li>
                        <li class="list-group-item font-weight-bolder h6"><i
                                class="fas fa-gavel icon-lg text-danger mr-3"></i>নিষ্পত্তিকৃত মামলা
                            <span class="label label-inline label-danger font-weight-bold float-right h6"
                                id="EMC_CLOSED">0</span>
                        </li>

                    </ul>
                </div>

            </div>
        </div>
    </div> <!-- /row -->

    <br><br>

    <div class="row">

        <div class="col-lg-6 mb-12">
            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title ">
                        <h3 class="card-label font-weight-bolder text-dark h3">ফৌজদারি কার্যবিধি আইনের মামলার পাই চার্ট </h3>
                    </div>
                    <div class="card-toolbar">
                        <button class="emc_case-piechart btn btn-success spinner spinner-darker-white spinner-left"
                            onclick="emc_case_pie_chart()">অনুসন্ধান করুন</button>
                    </div>
                </div>
                <div class="card-body" style="margin-top: 245px;">
                    <div id="emc_piechart_3d" style="width: 400px; height: 300px;"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card card-custom">
                <div class="card-body">
                    <figure class="highcharts-figure">
                        <div id="containerDrilldown"></div>
                    </figure>
                </div>
            </div>
        </div>
    </div>

    <br><br>

    
</div>