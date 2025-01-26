

{{-- @dd(Auth::user())/   --}}
<div class="row">
    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
        <a
            href="{{ Auth::user()->citizen_type_id == 1 ? route('emc.citizen.case.for.all.appeal.case') : route('gcc.pp.citizen.appeal.all_case') }}">
            <div class="card card-custom bg-danger cardCustomBG bg-hover-state-danger card-stretch gutter-b">
                <div class="card-body" style="">
                    <div class="align-items-center justify-content-between card-spacer flex-grow-1">
                        <span class="symbol symbol-50 symbol-light-danger  mr-2">
                            <span>
                                <img src="{{ asset('icons/icons8-law-90.png') }}" alt="">
                            </span>
                            <span class="text-light Count ml-5">{{ en2bn($total_appeal_case) }}</span>
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
            href="{{ Auth::user()->citizen_type_id == 1 ? route('emc.citizen.case.for.running.appeal.case') : route('gcc.pp.citizen.appeal.running_case') }}">
            <div class="card card-custom bg-success cardCustomBG bg-hover-state-success card-stretch gutter-b">
                <div class="card-body" style="">
                    <div class="align-items-center justify-content-between card-spacer flex-grow-1">
                        <span class="symbol symbol-50 symbol-light-success  mr-2">
                            <span>
                                <img src="{{ asset('icons/icons8-processing-64.png') }}" alt="">
                            </span>
                        </span>
                        <span class="text-light  Count ml-5">{{ en2bn($running_appeal_case) }}</span>
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
            href="{{ Auth::user()->citizen_type_id == 1 ? route('emc.citizen.case.for.pending.appeal.case') : route('gcc.pp.citizen.appeal.pending_case') }}">
            <div class="card card-custom bg-primary cardCustomBG bg-hover-state-primary card-stretch gutter-b">
                <div class="card-body" style="">
                    <div class="align-items-center justify-content-between card-spacer flex-grow-1">
                        <span class="symbol symbol-50 symbol-light-primary  mr-2">
                            <span>
                                <img src="{{ asset('icons/icons8-hourglass-100.png') }}" alt="">
                            </span>
                        </span>
                        <span class="text-light  Count ml-5">{{ en2bn($pending_appeal_case) }}</span>
                        <div class="text-left icn-card-label">
                            <span class="text-white mt-2 font-size-h3">গ্রহণের জন্য অপেক্ষমান আপিল</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>


    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
        <a href="{{ Auth::user()->citizen_type_id == 1 ? route('emc.citizen.case.for.complete.appeal.case') : route('gcc.pp.citizen.appeal.complete_case') }}">
            <div class="card card-custom bg-success cardCustomBG bg-hover-state-success card-stretch gutter-b">
                <div class="card-body" style="">
                    <div class="align-items-center justify-content-between card-spacer flex-grow-1">
                        <span class="symbol symbol-50 symbol-light-success  mr-2">
                            <span>
                                <img src="{{ asset('icons/icons8-task-completed-100.png') }}" alt="">
                            </span>
                        </span>
                        <span class="text-light Count">{{ en2bn($completed_appeal_case) }}</span>
                        <div class="text-left icn-card-label">
                            <span class="text-white mt-2 font-size-h3">নিষ্পত্তিকৃত আপিল মামলা </span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    
</div>

