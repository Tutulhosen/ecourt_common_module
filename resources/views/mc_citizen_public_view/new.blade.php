@extends('layout.app')
@section('content')
    @if (session('success'))
        {{-- <div class="alert alert-success">
            {{ session('success') }}
        </div> --}}
        <div id="successcomplain_print" class="content_form">
            <div class="form_top_title">
                <h3></h3>
                <h3 style="color: red;">
                    অভিযোগ আইডি <span id='c_message'>{{ session('success') }}</span> <br /> </h3>

                <h3 style="color:#008841;"> অনুগ্রহ করে আইডিটি সংরক্ষণ করুন , পরবর্তীতে আপনার দায়েরকৃত অভিযোগের অবস্থা জানার
                    জন্য
                    আইডিটি ব্যবহার করতে পারবেন । <br />
                    সহযোগিতার জন্য ধন্যবাদ ।

                </h3>
            </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="container" style="margin-top: 50px">
        <h3 style="font-weight: 600">অপরাধের তথ্য অনুসন্ধান করুন</h3>
        <div class="d-flex justify-content-center align-items-center">
            <div class="input-group" style=";">
                <input id="caseNumber" type="text" class="form-control" placeholder="মামলা নাম্বার দিন"
                    aria-label="Search">
            </div>
        </div>
        <div class="text-center mt-3">
            <button id="searchButton" class="btn btn-success btn-sm" type="button"
                style="background-color:#008841;">অনুসন্ধান করুন</button>
        </div>
    </div>

    <form action="{{ route('em_citizen_public_view.create') }}" id="multiform" name="multiform" method="post"
        enctype="multipart/form-data">
        @csrf
        <?php //echo $this->tag->form(array("citizen_public_view/create", "method" => "post" ,"name" => "multiform" ,"id" => "multiform" ,"enctype" => "multipart/form-data"))
        ?>
        <?php //echo $this->getContent();
        ?>
        {{--
{{ stylesheet_link('css/jquery.alerts.css') }}
{{ javascript_include("js/jquery.alerts.js") }}
--}}
        <style>
            /* .btn {
                                                                                            font-size: 18px;
                                                                                        } */

            .clearfix.multiRowContainer {
                display: flex;
            }

            /* .btn {
                    border: 2px solid gray;
                    color: gray;
                    background-color: white;

                    border-radius: 8px;
                    font-size: 20px;
                    font-weight: bold;
                } */
        </style>
        <div class="card panel-default" style="margin:20px">
            <div class="card-header smx" style="background-color:#008841; color: #FFF;margin:5px">
                <h2 class="panel-title" style="text-align: center;font-size: 24px">অপরাধ সম্পর্কিত তথ্য</h2>
                <p style="text-align: center;color: #FFF ;"><span style="color:#FF0000">*</span> চিহ্নিত ঘর অবশ্যই পূরণ করতে
                    হবে (আপনার তথ্য সম্পূর্ণরূপে গোপন রাখা হবে)।</p>
            </div>
            <div class="card-body cpv" style="padding:30px;">
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="well well-sm text-center"
                            style="background-color:#008841;     color:#fff;padding: 10px;">
                            আপনার তথ্য</h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label class="control-label"><span style="color:#FF0000">*</span><strong>নাম</strong></label>
                            <input type="text" name="name_bng" class="form-control" required="true" />
                        </div>
                        <!-- form-group -->
                    </div>
                    <!-- col-sm-6 -->

                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label class="control-label"><span style="color:#FF0000">*</span><strong>মোবাইল</strong></label>
                            <input type="text" id="mobile" name="mobile" class="input form-control" required="true">
                            <?php //echo $this->tag->textField(array("mobile",'class' => "input form-control", "required" => "true" ));
                            ?>
                        </div>
                        <!-- form-group -->
                    </div>
                    <!-- col-sm-6 -->
                </div>
                <!-- row -->

                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label class="control-label"><strong>জাতীয় পরিচয় পত্র নন্বর</strong> </label>
                            <input type="text" id="national_idno" name="national_idno" class="input form-control">
                            <?php //echo $this->tag->textField(array("national_idno",'class' => "input form-control"))
                            ?>
                        </div>
                        <!-- form-group -->
                    </div>
                    <!-- col-sm-6 -->

                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label class="control-label"><strong>ই-মেইল(ইংরেজিতে লিখুন)</strong></label>
                            <input type="email" id="email" name="email" class="input form-control">
                            <?php //echo $this->tag->emailField(array("email",'class' => "input form-control"))
                            ?>
                        </div>
                        <!-- form-group -->
                    </div>
                    <!-- col-sm-6 -->
                </div>
                <!-- row -->

                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label class="control-label"><span style="color:#FF0000">*</span><strong>ঠিকানা</strong></label>
                            <?php
                            // echo $this->tag->textArea(array("citizen_address", "cols" => 50, "rows" => 3 ,'class ' => "input
                            // form-control", "required" => "true"));
                            ?>
                            <textarea id="citizen_address" name="citizen_address" cols="50" rows="3"
                                class="input
                form-control" required="true" spellcheck="false"></textarea>
                        </div>
                        <!-- form-group -->
                    </div>
                    <!-- col-sm-6 -->

                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 mt-3">
                        <div class="form-group">
                            <label class="control-label"><span style="color:#FF0000">*</span><strong>নারী / পুরুষ
                                </strong></label>

                            <div class="rdio rdio-primary">
                                <input type="radio" name="gender" value="নারী" id="radioPrimaryW" required="true" />
                                <label for="radioPrimaryW"><strong>নারী</strong></label>
                            </div>
                            <div class="rdio rdio-primary">
                                <input type="radio" name="gender" value="পুরুষ" id="radioPrimaryM" />
                                <label for="radioPrimaryM"><strong>পুরুষ</strong></label>
                            </div>

                        </div>
                        <!-- form-group -->
                    </div>
                    <!-- col-sm-6 -->
                </div>
                <!-- row -->

                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="well well-sm" style="background-color:#008841; color:#fff;padding: 10px;">
                            <strong>অভিযোগের
                                বিবরণ</strong>
                        </h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label class="control-label"><span style="color:#FF0000">*</span><strong>অভিযোগের
                                    বিষয়</strong></label>

                            <select id="CaseType" name="CaseType" required="true" onchange="showSubjectdiv(this.value)"
                                tabindex="-1" title="" class="select2-offscreen form-control">
                                <option value="">বাছাই করুন...</option>
                                <option value="1">অন্যান্য</option>
                                <option value="2">মাদক</option>
                                <option value="3">পরিবেশ</option>
                                <option value="4">মৎস্য</option>
                                <option value="5">ইভটিজিং</option>
                                <option value="6">বাল্য বিবাহ</option>
                                <option value="7">দ্রব্য মূল্য </option>
                                <option value="8">ভূমি ও জলাশয়</option>
                                <option value="9">পরিবহন ও যোগাযোগ</option>
                                <option value="10">ঔষধ ও চিকিৎসা</option>
                                <option value="11">শিক্ষা সংক্রান্ত </option>
                                <option value="12">নিম্নমানের খাদ্য ও প্রসাধনী </option>
                                <option value="13">বীজ ও সার</option>
                                <option value="14">নির্বাচন</option>
                                <option value="15">স্বাস্থ্য সংক্রান্ত</option>
                                <option value="18">লাইসেন্স সংক্রান্ত</option>
                                <option value="19">ভেজাল</option>
                                <option value="20">দূষিত খাদ্য</option>
                                <option value="21">অগ্নি প্রতিরোধ </option>
                                <option value="22">বিদ্যুৎ সংক্রান্ত</option>
                                <option value="25">পাটজাত দ্রব্য</option>
                                <option value="26">মেয়াদ উত্তীর্ণ পণ্য</option>
                                <option value="29">ওজনে কম</option>
                                <option value="32">প্যাকেটজাত পণ্য</option>
                                <option value="35">এসিড-সংক্রান্ত</option>
                                <option value="38">ধুমপান</option>
                                <option value="41">দুষিত রক্ত</option>
                                <option value="44">ভোজ্যতেল</option>
                                <option value="47"> জুয়া</option>
                                <option value="50">আয়োডিন বিষয়ক</option>
                                <option value="53">ইট প্রস্তুত ও ভাটা স্থাপন</option>
                            </select>
                            <?php
                            // echo $this->tag->select(array(
                            // "CaseType",
                            // $CaseType,
                            // "using" => array("id", "details"),
                            // 'useEmpty' => true,
                            // 'emptyText' => 'বাছাই করুন...',
                            // 'emptyValue' => '',
                            // "required" => "true",
                            // 'onchange' => "showSubjectdiv(this.value)"
                            // ))
                            ?>
                        </div>
                        <!-- form-group -->
                    </div>
                    <!-- col-sm-6 -->

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label"><span style="color:#FF0000">*</span><strong>ঘটনার তারিখ
                                </strong></label>

                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                <input type="text" class="form-control" placeholder="yyyy/mm/dd" id="complain_date"
                                    name="complain_date" required="true" />
                            </div>
                            <!-- input-group -->
                        </div>
                        <!-- form-group -->
                    </div>
                    <!-- col-sm-6 -->

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label"><span style="color:#FF0000">*</span><strong>ঘটনার সময়
                                </strong></label>

                            <div class="input-group mb15">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>

                                <div class="bootstrap-timepicker"><input id="timepicker4" name="time" type="text"
                                        class="input form-control" required="true" /></div>
                            </div>
                            <!-- input-group -->
                        </div>
                        <!-- form-group -->
                    </div>
                    <!-- col-sm-6 -->
                </div>
                <!-- row -->

                <div class="row" id="subjectdiv" style="display: none">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label"><span style="color:#FF0000">*</span> <strong>অভিযোগের বিষয়
                                    লিখুন</strong></label>
                            <?php //echo $this->tag->textField(array("subject",'class' => "input form-control" , "required" => "true"))
                            ?>
                            <input type="text" id="subject" name="subject" class="input form-control"
                                required="true">
                        </div>
                        <!-- form-group -->
                    </div>
                    <!-- col-sm-6 -->
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label"><span style="color:#FF0000">*</span><strong> ঘটনার
                                    বিবরণ</strong></label>
                            <?php
                            // echo $this->tag->textArea(array("complain_details", "cols" => 50, "rows" => 4 ,'class' => "input
                            // form-control", "required" => "true"))
                            ?>
                            <textarea id="complain_details" name="complain_details" class="input
                form-control" cols="50"
                                rows="4" required="true"></textarea>
                        </div>
                        <!-- form-group -->
                    </div>
                    <!-- col-sm-6 -->
                </div>

                <!-- <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label class="control-label"><strong>অভিযোগ সংক্রান্ত প্রমাণাদি সংযুক্ত করুন (যদি
                                                            থাকে)</strong></label>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="form-group">
                                                                <div class="panel panel-danger-alt">
                                                                    <div class="panel-body cpv p-15 photoContainer">
                                                                        <button type="button" class="btn btn-success multifileupload">
                                                                            <span>+</span>
                                                                        </button>
                                                                        <hr>
                                                                        <div class="panel panel-danger-alt">
                                                                            <div class="docs-toggles"></div>
                                                                            <div class="docs-galley photoView">


                                                                            </div>
                                                                            <div class="docs-buttons" role="group"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                    

                                                </div>
                                               
                                            </div>
                                          
                                        </div> -->
                <div class="form-group" id="chargeFameAttachemntLable"></div>
                <div class="panel panel-danger-alt">
                    <div class="form-group">
                        <div class="panel panel-danger-alt">
                            <div class="row" id="chargeFameAttachedFile">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="attachment-section">
                    <h4 class="well well-sm" style="background-color:#008841; color:#fff; padding: 10px;">
                        সংযুক্তি</h4>
                    {{-- <h5 class="mb-3" style="font-weight: bold;"></h5> --}}
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="bg-light">
                                <tr>
                                    <th class="align-middle" style="width: 50%;">অভিযোগ গঠন ফরমের স্ক্যানকৃত ছবি সংযুক্ত
                                        করুন (যদি থাকে)</th>
                                    <th class="d-flex justify-content-end" style="width: 100%;">
                                        <button type="button"
                                            class="btn btn-outline-success p-1 rounded-circle addRowBtn"
                                            style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                                            +
                                        </button>
                                    </th>
                                </tr>

                            </thead>
                            <tbody class="attachmentTableBody">
                                <!-- Dynamic rows will be appended here -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- row -->

                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="well well-sm" style="background-color:#008841; color:#fff;padding: 10px;">ঘটনাস্থলের
                            বিবরণ </h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label"><span
                                    style="color:#FF0000">*</span><strong>বিভাগ</strong></label>
                            <select id="division" name="division" required="true"
                                onchange="showZilla(this.value,'zilla')" tabindex="-1" title=""
                                class="select2-offscreen form-control">
                                <option value="">বাছাই করুন...</option>
                                <?php foreach($division as $div){?>
                                <option value="<?php echo $div->id; ?>"><?php echo $div->division_name_bn; ?></option>
                                <?php } ?>
                            </select>
                            <?php
                            // echo $this->tag->select(array(
                            // "division",
                            // $division,
                            // "using" => array("divid", "divname"),
                            // 'useEmpty' => true,
                            // 'emptyText' => 'বাছাই করুন...',
                            // 'emptyValue' => '',
                            // "required" => "true",
                            // 'onchange' => "showZilla(this.value,'zilla')"
                            // ))
                            ?>
                        </div>
                        <!-- form-group -->
                    </div>
                    <!-- col-sm-6 -->

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label"><span style="color:#FF0000">*</span><strong>জেলা</strong></label>
                            <select id="zilla" name="zilla" required="true"
                                onchange="showUpazila(this.value,'upazila')" tabindex="-1" title=""
                                class="select2-offscreen form-control">
                                <option value="">বাছাই করুন...</option>
                            </select>
                            <?php
                            // echo $this->tag->select(array(
                            // "zilla",
                            // $zilla,
                            // "using" => array("zillaid", "zillaname"),
                            // 'useEmpty' => true,
                            // 'emptyText' => 'বাছাই করুন...',
                            // "required" => "true",
                            // 'emptyValue' => '',
                            // 'onchange' => "showUpazila(this.value,'upazila')"
                            // ))
                            ?>
                        </div>
                        <!-- form-group -->
                    </div>
                    <!-- col-sm-6 -->
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label class="control-label"><span style="color:#FF0000">*</span> <strong>উপজেলা / সিটি
                                    কর্পোরেশন / মেট্রোপলিটন </strong></label>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 check-upazila">
                                    <label class="btn btn-default btn-block active"
                                        style="display: flex; align-items:center justify-content:center; gap:10px">
                                        <input type="radio" id="locationtype" name="formtype" value="1"
                                            required="true" onchange="showupozilladiv()" /><small
                                            style="color: black; font-weight: 500">উপজেলা</small>
                                    </label>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 check-city">
                                    <label class="btn btn-default btn-block active"
                                        style="display: flex; align-items:center justify-content:center; gap:10px">
                                        <input type="radio" id="locationtype" name="formtype" value="2"
                                            onclick="showcitycorporationdiv()" /><small
                                            style="color: black; font-weight: 500">সিটি কর্পোরেশন</small>
                                    </label>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 check-metro">
                                    <label class="btn btn-default btn-block active"
                                        style="display: flex; align-items:center justify-content:center; gap:10px">
                                        <input type="radio" id="locationtype" name="formtype" value="3"
                                            onclick="showmetropolotandiv()" /><small
                                            style="color: black; font-weight: 500">মেট্রোপলিটন</small>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> -->
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label class="control-label"><span style="color:#FF0000">*</span>
                                <strong>ঘটনাস্থল</strong></label>
                            <?php //echo $this->tag->textField(array("location",'class' => "input form-control", "required" => "true"))
                            ?>
                            <input type="text" id="location" name="location" class="input form-control"
                                required="true">
                        </div>
                        <!-- form-group -->
                    </div>
                    <div id="upoziladiv" style="display: none" class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label class="control-label"><span
                                    style="color:#FF0000"></span><strong>উপজেলা</strong></label>
                            <select id="upazila" name="upazila" tabindex="-1" class="select2-hidden-accessible"
                                aria-hidden="true">
                                <option value="">বাছাই করুন...</option>
                            </select>
                            <?php
                            
                            // echo $this->tag->select(array(
                            // "upazila",
                            // $upazila,
                            // "using" => array("upazilaid", "upazilaname"),
                            // 'useEmpty' => true,
                            // 'emptyText' => 'বাছাই করুন...',
                            // 'emptyValue' => ''
                            // ))
                            ?>
                        </div>
                    </div>
                    <div id="citycorporationdiv" style="display: none" class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label class="control-label"><span style="color:#FF0000"></span> <strong>সিটি কর্পোরেশন
                                </strong></label>
                            <select id="GeoCityCorporations" name="GeoCityCorporations" tabindex="-1"
                                class="select2-hidden-accessible" aria-hidden="true">
                                <option value="">বাছাই করুন...</option>
                            </select>
                            <?php
                            // echo $this->tag->select(array(
                            // "GeoCityCorporations",
                            // $GeoCityCorporations,
                            // "using" => array("id", "city_corporation_name_bng"),
                            // 'useEmpty' => true,
                            // 'emptyText' => 'বাছাই করুন...',
                            // 'emptyValue' => ''
                            // ))
                            ?>
                        </div>
                    </div>

                    <div id="metropolitandiv" style="display: none" class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label"><span style="color:#FF0000"></span><strong>মেট্রোপলিটন
                                    </strong></label>
                                <select id="GeoMetropolitan" name="GeoMetropolitan"
                                    onchange="showThanas(this.value,'GeoThanas')" tabindex="-1"
                                    class="select2-offscreen" aria-hidden="true">
                                    <option value="">বাছাই করুন...</option>
                                </select>
                                <?php
                                // echo $this->tag->select(array(
                                // "GeoMetropolitan",
                                // $GeoMetropolitan,
                                // "using" => array("id", "metropolitan_name_bng"),
                                // 'useEmpty' => true,
                                // 'emptyText' => 'বাছাই করুন...',
                                // 'emptyValue' => '',
                                // 'onchange' => "showThanas(this.value,'GeoThanas')"
                                // ))
                                ?>
                            </div>
                            <!-- form-group -->
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label"><span style="color:#FF0000"></span><strong>থানা
                                    </strong></label>
                                <select id="GeoThanas" name="GeoThanas" tabindex="-1" class=" select2-offscreen"
                                    aria-hidden="true">
                                    <option value="">বাছাই করুন...</option>
                                </select>
                                <?php
                                // echo $this->tag->select(array(
                                // "GeoThanas",
                                // $GeoThanas,
                                // "using" => array("id", "thana_name_bng"),
                                // 'useEmpty' => true,
                                // 'emptyText' => 'বাছাই করুন...',
                                // 'emptyValue' => ''
                                // ))
                                ?>
                            </div>
                            <!-- form-group -->
                        </div>
                    </div>
                </div>

                {{-- <div class="clearfix">
        <div class="col-sm-12">
            <div class="form-group">
                <label class="control-label"><span style="color:#FF0000">*</span> <strong>(ছবিতে প্রাপ্ত কোডটি ইংরেজিতে লিখুন)</strong>
                </label>
        
                <div class="captcha_image">
                    <img id="siimage" style="border: 1px solid #000; margin-right: 15px"
                        src="{{ url.getBaseUri() }}securimage/securimage_show.php?sid=<?php echo md5(uniqid()); ?> "
                        alt="CAPTCHA Image" align="left"/>
                  <a id="captchaimage"  tabindex="-1" style="border-style: none;" href="#" title="Refresh Image"
                    onclick="">
                        <img src="../refresh.png" alt="Reload Image" height="32" width="32" onclick="this.blur()"
                            align="bottom" border="0"/> 
                    </a>
                </div>
            </div>
            <!-- form-group -->
        </div>
        <!-- col-sm-6 -->
    </div> --}}
                <!-- row -->
                <!-- <div class="clearfix">
                                                                                                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                                                                    <div class="form-group">
                                                                                                        <input type="text" id="ct_captcha" name="ct_captcha" size="12" maxlength="16" required="true"
                                                                                                            class="form-control" placeholder="উপরের কোডটি লিখুন "/>
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                           
                                                                                            </div> -->
                <!-- row -->

            </div>
            <!-- panel-body -->

            <div class="panel-footer" style="padding: 30px">

                <div class="float-right">
                    <button class="btn btn-success btn-md text-white" type="submit"
                        style="padding: 0.739rem 1; font-size: 0.875rem; border-radius: 0.25rem; background-color:#008841;;">
                        প্রেরণ করুন
                    </button>
                </div>

            </div>
            <!-- panel-footer -->
        </div><!-- panel -->
    </form>


    <div id="successcomplain" class="modal fade" style="display: none; ">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <a class="close" data-dismiss="modal">×</a>
                    <h1>ধন্যবাদ</h1>
                </div>
                <div class="modal-body">
                    <h3>
                        আপনার অভিযোগটি জেলা ম্যাজিস্ট্রেটের নিকট সফলভাবে প্রেরণ করা হয়েছে।
                    </h3>

                    <div class="modal-body" style="height: 200px; overflow: auto;">
                        {{-- partial("citizen_public_view/partials/message") --}}
                    </div>

                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-success" onclick="print_content('successcomplain')">প্রিন্ট</a>
                    <a href="#" class="btn btn-mideum" data-dismiss="modal">সমাপ্ত</a>
                </div>
            </div>
        </div>
    </div>

    <div id="error" class="modal fade" style="display: none; ">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <a class="close" data-dismiss="modal">×</a>

                    <h3>ধন্যবাদ</h3>
                </div>
                <div class="modal-body">
                    <h1>
                        তথ্য অসম্পূর্ন থাকায় আবেদনটি গ্রহণ করা হয়নি ।
                    </h1>

                    <h3 style="color: red;">
                        <input type="text" name="bookId2" id="bookId2" value="" readonly /> <br />
                    </h3>
                    <br />

                    <h3 style="color: green;">
                        পূনরায় চেষ্টা করুন ।
                    </h3>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-mideum" data-dismiss="modal">সমাপ্ত</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('mobile_court/javascripts/source/content/multiFileUpload.js') }}"></script>
    <!-- <script src="{{ asset('mobile_court/js/jquery-ui-1.11.0.min.js') }}"></script> -->

    <!-- <link rel="stylesheet" type="text/css" href="{{ asset('mobile_court/cssmc/jquery-ui-1.11.0.min.css') }}" /> -->
    <link rel="stylesheet" type="text/css" href="{{ asset('mobile_court/cssmc/select2.css') }}" />
    <!-- <link rel="stylesheet" type="text/css" href="{{ asset('mobile_court/cssmc/bootstrap-timepicker.min.css') }}" /> -->
    <script src="{{ asset('mobile_court/js/select2.min.js') }}"></script>
    <!-- <script src="{{ asset('mobile_court/js/bootstrap-timepicker.min.js') }}"></script>
                                                                                        <script src="{{ asset('mobile_court/js/jquery-ui-1.10.3.min.js') }}"></script> -->
    <script src="{{ asset('mobile_court/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('mobile_court/js/citizen_complain/citizen_script.js') }}"></script>
    <script>
        function showZilla(divID, zillaEL, callback) {
            var url = "/job_description/getzilla?ld=" + divID;
            if (divID) {
                get_select_data(divID, url, zillaEL, callback);
            }
        }

        function get_select_data(divID, url, zillaEL, callback) {
            $.ajax({
                type: "post",
                url: url,
                success: function(data) {
                    console.log('from mc new', data)
                    if (data.length > 0) {
                        build_select_list(divID, data, zillaEL, callback);
                    } else {
                        empty_select_list(divID, zillaEL);
                    }
                }
            });
        }

        function build_select_list(select, data, selectEL, callback) {
            var sel_id = "#" + selectEL;
            $(sel_id).find("option:gt(0)").remove();
            $(sel_id).find("option:first").text("Loading...");
            $(sel_id).find("option:first").text("বাছাই করুন...");
            for (var i = 0; i < data.length; i++) {
                $("<option/>").attr("value", data[i].id).text(data[i].name).appendTo($(sel_id));
            }
            if (callback && typeof callback === "function") {
                callback();
            }
            $(sel_id + " option[value='99']").remove();

        }

        function empty_select_list(select, ID) {
            var sel_id = "#" + ID;
            $(sel_id).find("option:gt(0)").remove();
            $(sel_id).find("option:first").text("Loading...");
            $(sel_id).find("option:first").text("বাছাই করুন...");
        }


        function showupozilladiv() {

            var zilla = $('#zilla').val();
            if (zilla == "") {
                $.alert(" জেলা নির্বাচন করুন ।", "অবহিতকরণ বার্তা");
                return false;
            } else {
                $('#GeoCityCorporations').val('');
                $('#GeoMetropolitan').val('');
                $('#GeoThanas').val('');

                showUpazila(zilla, "upazila");
                $("#citycorporationdiv").fadeOut();
                $("#metropolitandiv").fadeOut();
                $("#upoziladiv").fadeIn();
                return true;
            }

        }

        function showUpazila(select, upazila) {

            if (select == "") {
                document.getElementById("txtHint").innerHTML = "";
                return false;
            } else {
                var url = "/job_description/getUpazila?ld=" + select;
                get_select_data(select, url, upazila);
            }

        }

        function showcitycorporationdiv() {
            var zilla = $('#zilla').val();
            if (zilla == "") {
                $.alert(" জেলা নির্বাচন করুন ।", "অবহিতকরণ বার্তা");
                return false;
            } else {
                $('#upazila').val('');
                $('#GeoMetropolitan').val('');
                $('#GeoThanas').val('');
                showCityCorporation(zilla, "GeoCityCorporations");
                $("#citycorporationdiv").fadeIn();
                $("#metropolitandiv").fadeOut();
                $("#upoziladiv").fadeOut();
                return true;
            }

        }

        function showCityCorporation(select, citycorp) {
            var url = "/geo_city_corporations/getCityCorporation?ld=" + select;
            get_select_data(select, url, citycorp);
        }

        function showmetropolotandiv() {
            var zilla = $('#zilla').val();
            if (zilla == "") {
                $.alert(" জেলা নির্বাচন করুন ।", "অবহিতকরণ বার্তা");
                return false;
            } else {
                $('#upazila').val('');
                $('#GeoCityCorporations').val('');
                showMetropolitan(zilla, "GeoMetropolitan");
                $("#citycorporationdiv").fadeOut();
                $("#metropolitandiv").fadeIn();
                $("#upoziladiv").fadeOut();
                return true;
            }


        }

        function showMetropolitan(select, metro) {
            var url = "/geo_metropolitan/getmetropolitan?ld=" + select;
            get_select_data(select, url, metro);

        }

        function showThanas(select, thanas) {

            if (select == "") {
                document.getElementById("txtHint").innerHTML = "";
                return;
            } else {
                var url = "/geo_thanas/getthanas?ld=" + select;
                get_select_data(select, url, thanas);

            }

        }
    </script>

    {{--
{{ javascript_include("javascripts/source/content/multiFileUpload.js") }}
{{ javascript_include("js/jquery-ui-1.11.0.min.js") }}
{{ stylesheet_link('css/jquery-ui-1.11.0.min.css') }}

{{ stylesheet_link('css/select2.css') }}
{{ stylesheet_link('css/bootstrap-timepicker.min.css') }}

{{ javascript_include("js/select2.min.js") }}
{{ javascript_include("js/bootstrap-timepicker.min.js") }}
{{ javascript_include("js/jquery-ui-1.10.3.min.js") }}

{#{ javascript_include("js/jquery.validate.min.js") }#}

{{ javascript_include("js/citizen_complain/citizen_script.js") }}

                --}}

    <script>
        function print_content(type) {
            var html_content = $('#' + type + "_print").html();

            newwindow = window.open();
            newdocument = newwindow.document;
            newdocument.write('<div id="' + type + '_print" class="content_form">' + html_content + '</div>');
            newdocument.close();

            newwindow.print();
            return false;
        }

        jQuery(document).ready(function() {
            jQuery('#timepicker4').timepicker({
                defaultTime: false
            });
            jQuery("#division, #zilla, #upazila,#CaseType,#GeoCityCorporations,#GeoMetropolitan,#GeoThanas")
                .select2({
                    minimumResultsForSearch: -1
                });
            jQuery('#complain_date').datepicker({
                dateFormat: 'yy/mm/dd'
            });

            jQuery("#template .delete").click(function(e) {
                e.preventDefault();

                return false;
            });
        });
    </script>
    <script>
        function showSubjectdiv(selID) {

            var CaseTypeID = 'CaseType';
            var expertiseObj = document.getElementById(CaseTypeID);

            var casevalue = "";
            var optionValue = "";

            for (var i = 1; i < expertiseObj.length; i++) {
                if (expertiseObj.options[i].selected == true) {
                    casevalue = expertiseObj.options[i].text;
                    optionValue = expertiseObj.options.length;
                    break;
                }
            }

            if (selID != "1") {
                $('#subject').val(casevalue);
                $("#subjectdiv").fadeOut();
                return false;
            } else {
                $("#subjectdiv").fadeIn();
                return true;
            }

        }
    </script>
    <script>
        $(document).ready(function() {
            $('#searchButton').click(function() {
                swal.showLoading();

                const caseNumber = $('#caseNumber').val();
                if (!caseNumber) {
                    Swal.fire({
                        icon: 'error',
                        text: 'Please enter a valid case number.',

                    })
                    return
                }
                $.ajax({
                    url: '{{ route('em_citizen_public_view.search') }}',
                    method: 'post',
                    data: {
                        caseNumber: caseNumber,
                    },
                    success: function(response) {

                        Swal.close();
                        if (response.status == false) {
                            Swal.fire({
                                icon: 'error',
                                text: response.message,

                            })
                        } else if (response.status == true) {
                            Swal.fire({
                                icon: 'success',
                                text: response.message,

                            })
                        }
                    }
                });

            });
        });

        /*  if (mc_role_id == 27) {
                            swal.showLoading();
                            $.ajax({
                                url: '{{ route('admin.doptor.management.mc.acgm.create') }}',
                                method: 'post',
                                data: {
                                    office_name_bn: $('#' + 'office_name_bn_' + id).val(),
                                    office_name_en: $('#' + 'office_name_en_' + id).val(),
                                    unit_name_bn: $('#' + 'unit_name_bn_' + id).val(),
                                    unit_name_en: $('#' + 'unit_name_en_' + id).val(),
                                    designation_bng: $('#' + 'designation_bng_' + id).val(),
                                    office_id: $('#' + 'office_id_' + id).val(),
                                    username: $('#' + 'username_' + id).val(),
                                    employee_name_bng: $('#' + 'employee_name_bng_' + id).val(),
                                    court_id: $(this).find('option:selected').val(),
                                    court_type_id: court_type_id,
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(response) {
                                    console.log(response);
                                    Swal.close();
                                    if (response.success == 'error') {
                                        Swal.fire({
                                            icon: 'error',
                                            text: response.message,

                                        })
                                    } else if (response.success == 'success') {
                                        
                                        Swal.fire({
                                            icon: 'success',
                                            text: response.message,

                                        })
                                        if (response.court_name == 'No_court') {
                                            $('.court_name_' + id).html('কোন আদালত দেয়া হয় নাই ডিজেবেল');
                                            $('.court_name_' + id).removeClass('btn-primary');
                                            $('.court_name_' + id).addClass('btn-danger');
                                        } else {
                                            let texthtml = response.court_name + ' এনাবেল';
                                            $('.court_name_' + id).html(texthtml);
                                            $('.court_name_' + id).removeClass('btn-danger');
                                            $('.court_name_' + id).addClass('btn-primary');
                                        }
                                    }
                                }
                            });
                        }
         */
    </script>
@endsection
