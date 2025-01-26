<div class="row">
    <div class="col-12 col-offset-9">
        <ul class="icon_card_top_row">
            {{-- <li>
                <a href="">
                    <i class="fas fa-play"></i>
                    <span>নির্দেশিকা</span>
                </a>
            </li>
            <li>
                <a href="">
                    <i class="fas fa-phone-alt"></i>
                    <span>কল সেন্টার সাপোর্ট</span>
                </a>
            </li> --}}
            {{-- @if (in_array(globalUserInfo()->role_id, [35]) && globalUserInfo()->is_cdap_user == 1)
                <li>
                    <div id="mygov-sso-widget"></div>
                </li>
            @endif --}}
        </ul>



    </div>
</div>

@if (globalUserInfo()->citizen_type_id==2 || globalUserInfo()->citizen_type_id==1)
    <button id="general_case_btn" class="btn general_case_btn" style="border: 2px solid gray; background-color:#ffffff">সাধারণ মামলা</button>
    <button id="appeal_case_btn" class="btn appeal_case_btn" style="border: 2px solid #bdbdbd"> আপিল মামলা</button>
@endif
<br><br>
<div id="general_case" class="row general_case">
    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
        <a
            href="{{route('gcc.citizen.appeal.all_case')}}">
            <div class="card card-custom bg-danger cardCustomBG bg-hover-state-danger card-stretch gutter-b">
                <div class="card-body" style="">
                    <div class="align-items-center justify-content-between card-spacer flex-grow-1">
                        <span class="symbol symbol-50 symbol-light-danger  mr-2">
                            <span>
                                <img src="{{ asset('icons/icons8-law-90.png') }}" alt="">
                            </span>
                            <span class="text-light Count ml-5">{{ en2bn($total_case_gcc_citizen) }}</span>
                        </span>
                        <div class="text-left icn-card-label">
                            <span class="text-white mt-5 font-size-h3">মোট মামলা</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>


    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
        <a
            href="{{route('gcc.citizen.appeal.running_case')}}">
            <div class="card card-custom bg-success cardCustomBG bg-hover-state-success card-stretch gutter-b">
                <div class="card-body" style="">
                    <div class="align-items-center justify-content-between card-spacer flex-grow-1">
                        <span class="symbol symbol-50 symbol-light-success  mr-2">
                            <span>
                                <img src="{{ asset('icons/icons8-processing-64.png') }}" alt="">
                            </span>
                        </span>
                        <span class="text-light  Count ml-5">{{ en2bn($running_case_gcc_citizen) }}</span>
                        <div class="text-left icn-card-label">
                            <span class="text-white mt-2 font-size-h3" style="margin-top: 42px !important;">চলমান
                                মামলা</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
        <a
            href="{{route('gcc.citizen.appeal.pending_case')}}">
            <div class="card card-custom bg-primary cardCustomBG bg-hover-state-primary card-stretch gutter-b">
                <div class="card-body" style="">
                    <div class="align-items-center justify-content-between card-spacer flex-grow-1">
                        <span class="symbol symbol-50 symbol-light-primary  mr-2">
                            <span>
                                <img src="{{ asset('icons/icons8-hourglass-100.png') }}" alt="">
                            </span>
                        </span>
                        <span class="text-light  Count ml-5">{{ en2bn($pending_case_gcc_citizen) }}</span>
                        <div class="text-left icn-card-label">
                            <span class="text-white mt-2 font-size-h3">গ্রহণের জন্য অপেক্ষমান</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>


    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
        <a href="{{route('gcc.citizen.appeal.complete_case')}}">
            <div class="card card-custom bg-success cardCustomBG bg-hover-state-success card-stretch gutter-b">
                <div class="card-body" style="">
                    <div class="align-items-center justify-content-between card-spacer flex-grow-1">
                        <span class="symbol symbol-50 symbol-light-success  mr-2">
                            <span>
                                <img src="{{ asset('icons/icons8-task-completed-100.png') }}" alt="">
                            </span>
                        </span>
                        <span class="text-light Count">{{ en2bn($completed_case_gcc_citizen) }}</span>
                        <div class="text-left icn-card-label">
                            <span class="text-white mt-2 font-size-h3">নিষ্পত্তিকৃত মামলা</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    
</div>

<div id="appeal_case" class="row appeal_case" style="display: none;">
    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
        <a
            href="{{route('gcc.citizen.case.for.appeal.all_case') }}">
            <div class="card card-custom bg-danger cardCustomBG bg-hover-state-danger card-stretch gutter-b">
                <div class="card-body" style="">
                    <div class="align-items-center justify-content-between card-spacer flex-grow-1">
                        <span class="symbol symbol-50 symbol-light-danger  mr-2">
                            <span>
                                <img src="{{ asset('icons/icons8-law-90.png') }}" alt="">
                            </span>
                            <span class="text-light Count ml-5">{{ en2bn($total_appeal_case_gcc_citizen) }}</span>
                        </span>
                        <div class="text-left icn-card-label">
                            <span class="text-white mt-5 font-size-h3">মোট আপিল মামলা</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>


    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
        <a
            href="{{route('gcc.citizen.case.for.appeal.running_case') }}">
            <div class="card card-custom bg-success cardCustomBG bg-hover-state-success card-stretch gutter-b">
                <div class="card-body" style="">
                    <div class="align-items-center justify-content-between card-spacer flex-grow-1">
                        <span class="symbol symbol-50 symbol-light-success  mr-2">
                            <span>
                                <img src="{{ asset('icons/icons8-processing-64.png') }}" alt="">
                            </span>
                        </span>
                        <span class="text-light  Count ml-5">{{ en2bn($running_appeal_case_gcc_citizen) }}</span>
                        <div class="text-left icn-card-label">
                            <span class="text-white mt-2 font-size-h3" style="margin-top: 42px !important;">চলমান আপিল
                                মামলা</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
        <a
            href="{{route('gcc.citizen.case.for.appeal.pending_case') }}">
            <div class="card card-custom bg-primary cardCustomBG bg-hover-state-primary card-stretch gutter-b">
                <div class="card-body" style="">
                    <div class="align-items-center justify-content-between card-spacer flex-grow-1">
                        <span class="symbol symbol-50 symbol-light-primary  mr-2">
                            <span>
                                <img src="{{ asset('icons/icons8-hourglass-100.png') }}" alt="">
                            </span>
                        </span>
                        <span class="text-light  Count ml-5">{{ en2bn($pending_appeal_case_gcc_citizen) }}</span>
                        <div class="text-left icn-card-label">
                            <span class="text-white mt-2 font-size-h3">গ্রহণের জন্য অপেক্ষমান আপিল</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>


    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
        <a href="{{route('gcc.citizen.case.for.appeal.complete_case') }}">
            <div class="card card-custom bg-success cardCustomBG bg-hover-state-success card-stretch gutter-b">
                <div class="card-body" style="">
                    <div class="align-items-center justify-content-between card-spacer flex-grow-1">
                        <span class="symbol symbol-50 symbol-light-success  mr-2">
                            <span>
                                <img src="{{ asset('icons/icons8-task-completed-100.png') }}" alt="">
                            </span>
                        </span>
                        <span class="text-light Count">{{ en2bn($completed_appeal_case_gcc_citizen) }}</span>
                        <div class="text-left icn-card-label">
                            <span class="text-white mt-2 font-size-h3">নিষ্পত্তিকৃত আপিল মামলা</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    
</div>


<script>
    document.getElementById('general_case_btn').addEventListener('click', function() {
        // Show the general case row
        document.getElementById('general_case').style.display = 'flex';
        document.getElementById('appeal_case').style.display = 'none';

        // Change button colors
        this.style.border = '2px solid gray';
        this.style.backgroundColor = '#ffffff';
        document.getElementById('appeal_case_btn').style.border = '2px solid #bdbdbd';
        document.getElementById('appeal_case_btn').style.backgroundColor = '';
    });

    document.getElementById('appeal_case_btn').addEventListener('click', function() {
        // Show the appeal case row
        document.getElementById('appeal_case').style.display = 'flex';
        document.getElementById('general_case').style.display = 'none';

        // Change button colors
        this.style.border = '2px solid gray';
        this.style.backgroundColor = '#ffffff';
        document.getElementById('general_case_btn').style.border = '2px solid #bdbdbd';
        document.getElementById('general_case_btn').style.backgroundColor = '';
    });
</script>

