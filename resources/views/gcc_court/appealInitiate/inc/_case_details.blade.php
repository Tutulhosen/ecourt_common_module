
<div role="tabpanel" aria-labelledby="regTab0" class="tab-pane fade show  active " id="regTab_0">
    <div class="panel panel-info radius-none">
        <div class="panel-body">
            <div class="clearfix">
                <div class="row">
                    <div class="col-md-6">
                    </div>
                    <div class="col-md-6 " id="prevCaseDiv">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="previouscaseNo" class="control-label">পূর্ববর্তী মামলা
                                    নম্বর</label>
                                <input type="text" name="previouscaseNo" id="previouscaseNo"
                                    class="form-control form-control-sm" value="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="caseNo" class="control-label">মামলা নম্বর</label>
                            <input name="caseNo" id="caseNo" class="form-control form-control-sm"
                                value="{{ $appeal->case_no ?? '' }}" readonly />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>আবেদনের তারিখ <span class="text-danger">*</span></label>
                            <input type="text" name="caseDate" id="case_date"
                                value=""
                                class="form-control form-control-sm" placeholder="দিন/মাস/তারিখ" autocomplete="off"
                                readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="lawSection" class="control-label">সংশ্লিষ্ট আইন ও ধারা</label>
                            <input name="lawSection" id="lawSection" class="form-control form-control-sm"
                                value="{{ $appeal->law_section ?? '' }}" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{-- @dd($appeal) --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="totalLoanAmount" class="control-label"><span style="color:#FF0000">*
                                </span>দাবিকৃত অর্থের পরিমাণ</label>
                            <input type="text" name="totalLoanAmount" id="totalLoanAmount"
                                class="form-control form-control-sm" value="="
                                readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="totalLoanAmountText" class="control-label">দাবিকৃত অর্থের পরিমাণ
                                (কথায়)</label>
                            <input readonly="readonly" type="text" name="totalLoanAmountText"
                                id="totalLoanAmountText" class="form-control form-control-sm"
                                value="{{ $appeal->loan_amount_text ?? '' }}" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="totalLoanAmount" class="control-label"><span style="color:#FF0000">
                                </span>জেলা</label>
                            <input type="text" name="district_name" id="district_name"
                                class="form-control form-control-sm" value="{{ $appeal->district_name ?? '-'}}"
                                readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="totalLoanAmountText" class="control-label">উপজেলা</label>
                            <input readonly="readonly" type="text" name="upazila_name"
                                id="upazila_name" class="form-control form-control-sm"
                                value="{{ $appeal->upazila_name ?? '' }}" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="totalLoanAmount" class="control-label"><span style="color:#FF0000">
                                </span>প্রাতিষ্ঠানের নাম</label>
                                
                            <input type="text" name="office_name" id="office_name"
                                class="form-control form-control-sm" value="{{ $appeal->office_name ?? '-' }}"
                                readonly>
                               
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="totalLoanAmountText" class="control-label">প্রাতিষ্ঠানের আইডি (রাউটিং নং )</label>
                            <input readonly="readonly" type="text" name="organization_routing_id"
                                id="organization_routing_id" class="form-control form-control-sm"
                                value="{{ $org_info->organization_routing_id ?? '' }}" readonly>
                        </div>
                    </div>
                    
                </div>
                <div class="row">
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="totalLoanAmount" class="control-label"><span style="color:#FF0000">
                                </span>প্রাতিষ্ঠানের ঠিকানা</label>
                            <input type="text" name="organization_physical_address" id="organization_physical_address"
                                class="form-control form-control-sm" value="{{$org_info->organization_physical_address ?? '-' }}"
                                readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="totalLoanAmountText" class="control-label">প্রাতিষ্ঠানের ধরণ</label>
                            <input readonly="readonly" type="text" name="applicant_type"
                                id="applicant_type" class="form-control form-control-sm"
                                value="{{ $appeal->applicant_type ?? '' }}" readonly>
                        </div>
                    </div>
                    
                </div>
             
                <div class="row" id="is_varified_org">
                    <div class="col-md-12">
                        <div class="alert alert-danger">
                            
                            <a target="_blank" class="text-white" href="">Please Verify The Office!</a>
                            
                        </div>
                        
                    </div>
                </div>
                <input type="hidden" name="is_varified_org" value="0">
   
                    <input type="hidden" name="is_varified_org" value="1">
                
            </div>
        </div>
    </div>
</div>
