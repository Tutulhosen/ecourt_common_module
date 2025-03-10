<div class="pb-5" data-wizard-type="step-content" id="second_person">
    <fieldset>
        <legend class="font-weight-bold text-dark"><strong
                style="font-size: 20px !important">ঋণগ্রহীতার তথ্য (১)</strong></legend>


        <div class="row">
            <div class="col-md-12">
                <div class="text-dark font-weight-bold">
                    <label for="">জাতীয় পরিচয়পত্র যাচাই : </label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input required type="text" {{-- id="applicantCiNID_1" --}}
                        class="form-control check_nid_number_0" data-row-index='0'
                        placeholder="উদাহরণ- 19825624603112948" id="defaulter_nid_input_0"
                        onclick="addDatePicker(this.id)">
                    <span id="res_applicant_1"></span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <div class="input-group">
                        <input required type="text" id="defaulter_dob_input_0"
                            placeholder="জন্ম তারিখ (জাতীয় পরিচয়পত্র অনুযায়ী , বছর/মাস/দিন ) "
                            {{-- id="dob" --}} class="form-control common_datepicker_1"
                            autocomplete="off" data-row-index='0'>

                    </div>
                </div>
            </div>
           
            <div class="col-md-4">
                <div class="form-group">
                    <input type="button" id="defaulter_nid_0" data-row-index='0'
                        class="btn btn-primary check_nid_button"
                        onclick="NIDCHECK(this.id)" value="  যাচাই করুন">
                </div>
            </div>
        </div>



        <input type="hidden" id="defaulterCount" value="1">

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="applicantName_1" class="control-label"><span
                            style="color:#FF0000">*</span>ঋণগ্রহীতার নাম</label>
                    <input name="defaulter[name][0]" id="defaulterName_1"
                        class="form-control name-group nid_data_pull_warning_old">
                    <input type="hidden" name="defaulter[type][]" class="form-control "
                        value="2">
                    <input type="hidden" name="defaulter[id][]" id="defaulterId_1"
                        class="form-control " value="">
                    <input type="hidden" name="defaulter[thana][]" id="defaulterThana_1"
                        class="form-control " value="">
                    <input type="hidden" name="defaulter[upazilla][]"
                        id="defaulterUpazilla_1" class="form-control " value="">
                    <input type="hidden" name="defaulter[age][]" id="defaulterAge_1"
                        class="form-control " value="">
                    {{-- <input type="hidden" name="defaulter[organization_id][]"
                        id="defaulterOrganizationId_1" class="form-control "
                        value="">
                    <input type="hidden" name="defaulter[organization]"
                        id="defaulterOrganization_1" class="form-control "
                        value="">
                    <input type="hidden" name="defaulter[designation]"
                        id="defaulterDesignation_1" class="form-control " value=""> --}}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="defaulterPhn_1" class="control-label"><span
                            style="color:#FF0000">* </span>মোবাইল</label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text"
                                style="padding-bottom: 0px !important;">+88</span></div>
                        <input name="defaulter[phn][0]" id="defaulterPhn_1"
                            class="form-control " value=""
                            placeholder="ইংরেজিতে দিতে হবে">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="defaulterNid_1" class="control-label "><span
                            style="color:#FF0000"></span>জাতীয় পরিচয়পত্র</label>
                    <input name="defaulter[nid][0]" type="text" id="defaulterNid_1"
                        class="form-control nid_data_pull_warning_old nid_important"
                        value="">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label"><span
                            style="color:#FF0000">*</span>লিঙ্গ</label><br>
                    <select class="form-control" name="defaulter[gender][0]">

                        <option value="MALE"> পুরুষ </option>
                        <option value="FEMALE"> নারী </option>
                    </select>
                </div>
                
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="defaulterFather_1" class="control-label "><span
                            style="color:#FF0000">*</span>পিতার নাম</label>
                    <input name="defaulter[father][0]" id="defaulterFather_1"
                        class="form-control nid_data_pull_warning_old" value="">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="applicantMother_1" class="control-label"><span
                            style="color:#FF0000">*</span>মাতার নাম</label>
                    <input name="defaulter[mother][0]" id="defaulterMother_1"
                        class="form-control nid_data_pull_warning_old" value="">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="defaulterdesignation_1" class="control-label "><span
                            style="color:#FF0000">*</span>পদবি / পেশা</label>
                    <input name="defaulter[designation][0]" id="defaulterdesignation_1"
                        class="form-control nid_data_pull_warning_old" value="">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="applicantorganization_1" class="control-label"><span
                            style="color:#FF0000"></span>প্রতিষ্ঠানের নাম(যদি থাকে)</label>
                    <input name="defaulter[organization][0]" id="defaulterorganization_1"
                        class="form-control nid_data_pull_warning_old" value="">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="defaulterPresentAddree_1"><span style="color:#FF0000">*
                        </span>বর্তমান ঠিকানা</label>
                    <textarea id="defaulterPresentAddree_1" name="defaulter[presentAddress][0]" rows="5"
                        class="form-control element-block blank nid_data_pull_warning_old" aria-describedby="note-error"
                        aria-invalid="false"></textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="defaulterEmail_1">ইমেইল</label>
                    <input type="email" name="defaulter[email][0]"
                        id="defaulterEmail_1" class="form-control " value="">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="defaulterPermanentAddree_1"><span style="color:#FF0000">*
                        </span>স্থায়ী ঠিকানা</label>
                    <textarea id="defaulterPermanentAddree_1" name="defaulter[PermanentAddress][0]" rows="5"
                        class="form-control element-block blank nid_data_pull_warning_old" aria-describedby="note-error"
                        aria-invalid="false"></textarea>
                </div>
            </div>
           
        </div>
    </fieldset>

    <!-- Template -->
    <fieldset id="defaulterTemplate" style="display: none; margin-top: 30px;">
        <legend class="font-weight-bold text-dark"><strong
                style="font-size: 20px !important" data-name="defaulter.info">২য় পক্ষ
                (1)</strong></legend>

        <div class="row">
            <div class="col-md-12">
                <div class="text-dark font-weight-bold">
                    <label for="">জাতীয় পরিচয়পত্র যাচাই : </label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input required type="text" {{-- id="applicantCiNID_1" --}}
                        class="form-control" placeholder="উদাহরণ- 19825624603112948"
                        data-name="defaulter.NIDNumber" onclick="addDatePicker(this.id)">
                    <span id="res_applicant_1"></span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <div class="input-group">
                        <input required type="text" id="applicantDob_1"
                            data-name="defaulter.DOBNumber"
                            placeholder="জন্ম তারিখ (জাতীয় পরিচয়পত্র অনুযায়ী , বছর/মাস/দিন ) "
                            {{-- id="dob" --}} class="form-control common_datepicker_1"
                            autocomplete="off">
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <div class="input-group">
                        <input type="button" data-name="defaulter.NIDCheckButton"
                            class="btn btn-primary check_nid_button" value="  যাচাই করুন"
                            onclick="NIDCHECK(this.id)">
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label"><span style="color:#FF0000">*</span>
                        ঋণগ্রহীতার নাম</label>
                    <input type="text" data-name="defaulter.name"
                        class="form-control nid_data_pull_warning_old">
                    <input type="hidden" data-name="defaulter.type" value="2">
                    <input type="hidden" data-name="defaulter.id">
                    <input type="hidden" data-name="defaulter.thana">
                    <input type="hidden" data-name="defaulter.upazilla">
                    <input type="hidden" data-name="defaulter.age">

                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="defaulterPhn_1" class="control-label"><span
                            style="color:#FF0000">* </span>মোবাইল</label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text"
                                style="padding-bottom: 0px !important;">+88</span></div>
                        <input data-name="defaulter.phn" class="input-reset form-control "
                            placeholder="ইংরেজিতে দিতে হবে">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label"><span style="color:#FF0000"></span>জাতীয়
                        পরিচয় পত্র</label>
                    <input data-name="defaulter.nid" type="text"
                        class="input-reset form-control nid_data_pull_warning_old nid_important"
                        >
                </div>
            </div>
           
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label"><span
                            style="color:#FF0000">*</span>লিঙ্গ</label><br>
                    <select class="form-control" data-name="defaulter.gender">

                        <option value="MALE"> পুরুষ </option>
                        <option value="FEMALE"> নারী </option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label"><span style="color:#FF0000">*</span>পিতার
                        নাম</label>
                    <input data-name="defaulter.father"
                        class="input-reset form-control nid_data_pull_warning_old">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label"><span style="color:#FF0000">*</span>মাতার
                        নাম</label>
                    <input data-name="defaulter.mother"
                        class="input-reset form-control nid_data_pull_warning_old">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label"><span style="color:#FF0000">*</span>পদবি / পেশা</label>
                    <input data-name="defaulter.designation"
                        class="input-reset form-control nid_data_pull_warning_old">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label"><span style="color:#FF0000"></span>
                        প্রতিষ্ঠানের নাম(যদি থাকে)</label>
                    <input data-name="defaulter.organization"
                        class="input-reset form-control nid_data_pull_warning_old">
                </div>
            </div>
        </div>

        

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label><span style="color:#FF0000">* </span>বর্তমান ঠিকানা</label>
                    <textarea data-name="defaulter.presentAddress" rows="5"
                        class="input-reset form-control element-block blank nid_data_pull_warning_old"></textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="defaulterEmail_1"><span
                            style="color:#FF0000"></span>ইমেইল</label>
                    <input type="email" data-name="defaulter.email"
                        class="input-reset form-control">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label><span style="color:#FF0000">* </span>স্থায়ী ঠিকানা</label>
                    <textarea data-name="defaulter.PermanentAddress" rows="5"
                        class="input-reset form-control element-block blank nid_data_pull_warning_old"></textarea>
                </div>
            </div>
           
        </div>

    </fieldset>

    <div>
        <div class="col-md-12" style="float: right; margin-bottom: 25px;">
            <button id="RemoveDefaulter" type="button" class="btn btn-danger"
                value="0" style="float: right;">বাতিল</button>
            <button id="defaulterAdd" type="button" class="btn btn-success"
                value="0" style="float: right; margin-right: 10px;"> ২য় পক্ষ যোগ করুন
            </button>
        </div>
    </div>
    <div class="clearfix"></div>
</div>