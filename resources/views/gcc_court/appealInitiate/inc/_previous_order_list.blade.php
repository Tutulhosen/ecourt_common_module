<fieldset class="mb-8 p-7" style="background: none;">
                            <legend>আদেশের তালিকা </legend>
                            <div class="panel panel-info radius-none ">
                                <div id="accordion" role="tablist" aria-multiselectable="true" class="panel-group notesDiv">
                                    <section class="panel panel-primary nomineeInfo" id="nomineeInfo">
                                        <div class="accordion accordion-solid accordion-toggle-plus" id="accordionExample3">
                                           
                                                <div id="cloneNomenee" class="card">
                                                    <div class="card-header" id="headingOne3">
                                                        <div class=" bg-gray-300 card-title h4 "
                                                            data-toggle="collapse"
                                                            data-target="#collapseOne3">
                                                            <span
                                                                id="spannCount"></span>&nbsp;
                                                            তারিখ এর আদেশ
                                                        </div>
                                                    </div>
                                                    <div id="collapseOne3"
                                                        class="collapse "
                                                        data-parent="#accordionExample3">
                                                        <div class="card-body border-secondary">
                                                            <div class="clearfix ">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <h4 class="text-right">সার্টিফিকেট সহকারী কর্তৃক গৃহীত ব্যবস্থা ,
                                                                            
                                                                        </h4>
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div
                                                                                    class="bg-gray-100 rounded-md rounded-right-0">
                                                                                    <div class="p-4 h5">
                                                                                        </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        @if (!empty($item['certificate_asst_files_files']))
                                                                            <div class="row">
                                                                                <fieldset
                                                                                    class="col-md-12 border-0 bg-white">
                                                                                    @forelse (json_decode($item['certificate_asst_files_files'],true) as $key => $row)
                                                                                        <div class="form-group mb-2"
                                                                                            id="">
                                                                                            <div class="input-group">
                                                                                                <div
                                                                                                    class="input-group-prepend">
                                                                                                    <button
                                                                                                        class="btn bg-success-o-75"
                                                                                                        type="button">{{ en2bn(++$key) . ' - নম্বর :' }}</button>
                                                                                                </div>
                                                                                                <input readonly
                                                                                                    type="text"
                                                                                                    class="form-control-md form-control "
                                                                                                    value="{{ $row['file_category'] ?? '' }}" />
                                                                                                <div
                                                                                                    class="input-group-append">
                                                                                                    <a href="{{ asset($row['file_path'] . $row['file_name']) }}"
                                                                                                        target="_blank"
                                                                                                        class="btn btn-sm btn-success font-size-h5 float-left">
                                                                                                        <i
                                                                                                            class="fa fas fa-file-pdf"></i>
                                                                                                        <b>দেখুন</b>
                                                                                                    </a>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    @empty
                                                                                    @endforelse
                                                                                </fieldset>
                                                                            </div>
                                                                        @endif

                                                                    </div>
                                                                      @php
                                                                        if(globalUserInfo()->role_id == 28 || globalUserInfo()->role_id == 27)
                                                                        {
                                                                            $em_text='জিসিও';
                                                                        }elseif(globalUserInfo()->role_id == 39 || globalUserInfo()->role_id == 38)
                                                                        {
                                                                            $em_text='অতিরিক্ত জেলা ম্যাজিস্ট্রেট এর';
                                                                        } 
                                                                        @endphp

                                                                        <div class="col-md-12 mt-3">
                                                                            <h4 class="text-right"> আদেশ
                                                                                , 
                                                                                
                                                                            </h4>
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <div
                                                                                        class="bg-gray-100 rounded-md rounded-right-0">
                                                                                        <div class="p-4 h5">
                                                                                            
                                                                                           
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            @if (!empty($item['gcc_files']))
                                                                            <div class="row">
                                                                                <fieldset
                                                                                    class="col-md-12 border-0 bg-white">
                                                                                    @forelse (json_decode($item['gcc_files'],true) as $key => $row)
                                                                                        <div class="form-group mb-2"
                                                                                            id="">
                                                                                            <div class="input-group">
                                                                                                <div
                                                                                                    class="input-group-prepend">
                                                                                                    <button
                                                                                                        class="btn bg-success-o-75"
                                                                                                        type="button">{{ en2bn(++$key) . ' - নম্বর :' }}</button>
                                                                                                </div>
                                                                                                <input readonly
                                                                                                    type="text"
                                                                                                    class="form-control-md form-control "
                                                                                                    value="{{ $row['file_category'] ?? '' }}" />
                                                                                                <div
                                                                                                    class="input-group-append">
                                                                                                    <a href="{{ asset($row['file_path'] . $row['file_name']) }}"
                                                                                                        target="_blank"
                                                                                                        class="btn btn-sm btn-success font-size-h5 float-left">
                                                                                                        <i
                                                                                                            class="fa fas fa-file-pdf"></i>
                                                                                                        <b>দেখুন</b>
                                                                                                    </a>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    @empty
                                                                                    @endforelse
                                                                                </fieldset>
                                                                            </div>

                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                         
                                          
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </fieldset>