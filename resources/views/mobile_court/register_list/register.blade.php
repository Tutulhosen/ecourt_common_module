@extends('layout.app')

@section('content')
    <style>
        .hidden {
            display: none !important;
        }

        label>span {
            font-size: 13px;
            color: red;
            /* margin: 3px; */
        }
        .select2-container .select2-selection--single{
            height: 46px !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow{
            top: 13px !important;
        }
    </style>
    <div class="row">

        <div class="col-md-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b example example-compact">
                <div class="card-header">
                    <h3 class="card-title h2 font-weight-bolder">অনুসন্ধানের উপাত্তসমূহ</h3>
                </div>

                <div class="panel panel-default">
                    <div id="messageModal">
                        {{-- partial("message/partials/message") --}}
                    </div>
                    <div class="panel-heading smx">
                        <h4 class="panel-title"></h4>
                    </div>
                    <div class="card-body p-10 cpv">
                        <div class="row">
                            <div class="col-md-6">
                                <input class="hidden" type="hidden" id="user_prfoile" value="{{ $profile }}">

                                <?php if($roleID== '37' or $roleID== '38'){ ?>
                                <input class="hidden" id="zilla" value="{{ $zillaId }}">
                                <?php } ?>

                                <?php 
                            if ($roleID == 34){ //'Divisional Commissioner' ?>

                                <div class="form-group clearfix">
                                    <div class="col-sm-12">
                                        <label class="col-sm-12 control-label">জেলা </label>
                                        <select id="zilla" name="zilla" class="input select2-offscreen"
                                            style="width:100%" onchange="showupozilladiv()" tabindex="-1" title="">
                                            <option value="">জেলা বাছাই করুন</option>
                                            <?php foreach($zilla as $zillalist){?>
                                            <option value="<?php echo $zillalist->id; ?>"><?php echo $zillalist->district_name_bn; ?></option>
                                            <?php } ?>

                                        </select>
                                        <?php
                                        // echo $this->tag->select(array(
                                        // "zilla",
                                        // $zilla,
                                        // "using" => array("zillaid", "zillaname"),
                                        // 'useEmpty' => true,
                                        // 'emptyText' => 'জেলা বাছাই করুন',
                                        // 'emptyValue' => '',
                                        // 'class' => "input form-control",
                                        // 'style' => 'width:100%',
                                        // 'onchange'=>"showupozilladiv()"
                                        // ))
                                        ?>
                                        <label for="fruits" class="error"></label>
                                    </div>
                                </div>

                                <?php } ?>

                                <?php  if ( $roleID == 8 || $roleID == 2 ){ ?>

                                <div class="row form-group m-top-5">
                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <label class="control-label">বিভাগ </label>
                                        <select id="division" name="division" class="input form-control" style="width:100%"
                                            onchange="showZilla(this.value,'zilla')" tabindex="-1" title="">
                                            <option value="">বিভাগ বাছাই করুন</option>
                                            <?php foreach($division as $dvlist){?>
                                            <option value="<?php echo $dvlist->id; ?>"><?php echo $dvlist->name; ?></option>
                                            <?php } ?>

                                        </select>
                                        <?php
                                        // echo $this->tag->select(array(
                                        // "division",
                                        // $division,
                                        // "using" => array("divid", "divname"),
                                        // 'useEmpty' => true,
                                        // 'emptyText' => 'বিভাগ বাছাই করুন',
                                        // 'emptyValue' => '',
                                        // 'style' => 'width:100%',
                                        // 'class' => "input",
                                        // 'onchange' => "showZilla(this.value,'zilla')"
                                        // ))
                                        ?>
                                        <p for="fruits" class="error text-danger"></p>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <label class="control-label">জেলা </label>
                                        <select id="zilla" name="zilla" class="input form-control" style="width:100%"
                                            onchange="showupozilladiv()" tabindex="-1" title="">
                                            <option value="">বাছাই করুন...</option>

                                        </select>
                                        <?php
                                        // echo $this->tag->select(array(
                                        // "zilla",
                                        // $zilla,
                                        // "using" => array("zillaid", "zillaname"),
                                        // 'useEmpty' => true,
                                        // 'emptyText' => 'জেলা বাছাই করুন',
                                        // 'emptyValue' => '',
                                        // 'class' => "input",
                                        // 'style' => 'width:100%',
                                        // 'onchange'=>"showupozilladiv()"
                                        // ))
                                        ?>
                                        <p for="fruits" class="error text-danger"></p>
                                    </div>
                                </div>

                                <?php } ?>
                                <!-- ($profile == 'JS') or ($profile == 'Divisional Commissioner') or -->
                                <?php if ($roleID ==2 || $roleID == 8 || $roleID == 37 ||  $roleID== 38){ ?>

                                <div class="row m-bottom-15">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                        <label class="btn btn-default active btn-block text-left"
                                            style="border: 1px solid rgb(189, 189, 189); display: flex; gap: 5px; align-items: center">
                                            <input class="custom_radio pull-left" type="radio" id="locationtype"
                                                name="formtype" value="1" checked="checked"
                                                onclick="showupozilladiv()" /><span style="color: black" class="mt-1">উপজেলা</span>
                                        </label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 check-city">
                                        <label class="btn btn-default active btn-block text-left"
                                            style="border: 1px solid rgb(189, 189, 189); display: flex; gap: 5px; align-items: center">
                                            <input class="custom_radio pull-left" type="radio" id="locationtype"
                                                name="formtype" value="2" onclick="showcitycorporationdiv()" />
                                            <span style="color: black" class="mt-1">সিটি কর্পোরেশন</span>
                                        </label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                        <label class="btn btn-default active btn-block text-left"
                                            style="border: 1px solid rgb(189, 189, 189); display: flex; gap: 5px; align-items: center">
                                            <input class="custom_radio pull-left" type="radio" id="locationtype"
                                                name="formtype" value="3" onclick="showmetropolotandiv()" />
                                            <span style="color: black">মেট্রোপলিটন</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div id="upoziladiv" style="display: none"
                                        class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <label class="control-label"><span class="text-error"></span> উপজেলা</label>
                                            <select name="upazila" id="upazila" class="input" style="width:100%">
                                                <option value="">{{ __('বাছাই করুন...') }}</option>
                                                @foreach ($upazila as $item)
                                                    <option value="{{ $item->id }}">{{ $item->upazila_name_bn }}
                                                    </option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>
                                    <div id="citycorporationdiv" style="display: none"
                                        class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <label class="control-label"><span class="text-error"></span> সিটি কর্পোরেশন
                                            </label>
                                            <select id="GeoCityCorporations" name="GeoCityCorporations"
                                                class="input select2-offscreen" style="width:100%" tabindex="-1"
                                                title="">
                                                <option value="">বাছাই করুন...</option>
                                            </select>
                                            <?php
                                            // echo $this->tag->select(array(
                                            // "GeoCityCorporations",
                                            // $geoCityCorporations,
                                            // "using" => array("id", "city_corporation_name_bng"),
                                            // 'useEmpty' => true,
                                            // 'emptyText' => 'বাছাই করুন...',
                                            // 'class' => "input",
                                            // 'style' => 'width:100%',
                                            // 'emptyValue' => ''
                                            // ))
                                            ?>


                                        </div>
                                    </div>
                                </div>

                                <div class="row" id="metropolitandiv" style="display: none">
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label"><span class="text-error"></span>মেট্রোপলিটন
                                            </label>
                                            <select id="GeoMetropolitan" name="GeoMetropolitan"
                                                class="input select2-offscreen" style="width:100%"
                                                onchange="showThanas(this.value,'GeoThanas')" tabindex="-1"
                                                title="">
                                                <option value="">বাছাই করুন...</option>
                                            </select>
                                            <?php
                                            // echo $this->tag->select(array(
                                            // "GeoMetropolitan",
                                            // $geoMetropolitan,
                                            // "using" => array("id", "metropolitan_name_bng"),
                                            // 'useEmpty' => true,
                                            // 'emptyText' => 'বাছাই করুন...',
                                            // 'class' => "input",
                                            // 'style' => 'width:100%',
                                            // 'emptyValue' => '',
                                            // 'onchange' => "showThanas(this.value,'GeoThanas')"
                                            // ))
                                            ?>
                                        </div>

                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label"><span class="text-error"></span>থানা </label>
                                            <select id="GeoThanas" name="GeoThanas" class="input select2-offscreen"
                                                style="width:100%" tabindex="-1" title="">
                                                <option value="">বাছাই করুন...</option>
                                            </select>

                                            <?php
                                            // echo $this->tag->select(array(
                                            // "GeoThanas",
                                            // $geoThanas,
                                            // "using" => array("id", "thana_name_bng"),
                                            // 'useEmpty' => true,
                                            // 'emptyText' => 'বাছাই করুন...',
                                            // 'class' => "input",
                                            // 'style' => 'width:100%',
                                            // 'emptyValue' => ''
                                            // ))
                                            ?>
                                        </div>

                                    </div>
                                </div>

                                <?php } ?>



                                <div class="form-group">
                                    <label class="control-label">তারিখ </label>
                                    <div class="row">
                                        <div class="col-sm-6 m-bottom-15">
                                            <input class="input form-control" name="start_date" id="start_date"
                                                value="" type="text" required="true"
                                                placeholder="প্রথম তারিখ" />
                                        </div>
                                        <div class="col-sm-6">
                                            <input class="input form-control" name="end_date" id="end_date"
                                                value="" type="text" placeholder="শেষ তারিখ" />
                                        </div>
                                    </div>
                                </div>
                                <!-- form-group -->
                                <input type="hidden" id="office_address" name="office_address"
                                    value="<?php echo $office_address; ?>">
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">রেজিস্টার </label>

                                    <select id="reportlist" name="reportlist"
                                        class="input form-control select2-offscreen" style="width:100%"
                                        onchange="register.showcomplainStatus(this.value)" tabindex="-1" title="">
                                        <option value="">{{ __('রেজিস্টার বাছাই করুন..') }}</option>
                                        <?php foreach($reportlist as $list){?>
                                        <option value="<?php echo $list->id; ?>">{{ $list->name }}</option>
                                        <?php } ?>

                                    </select>

                                    <p class="error text-danger"></p>
                                </div>

                                <!-- form-group -->
                                <div class="form-group" id="lawtype" style="display: none">
                                    <div class="form-group">
                                        <label class="control-label">আইনের শিরোনাম</label>
                                        <div>
                                            <select id="lawlist" name="lawlist" class="input select2-offscreen"
                                                style="width:100%" tabindex="-1" title="">
                                                <option value="">আইনের শিরোনাম বাছাই করুন..</option>
                                                <?php foreach($lawlist as $law){?>
                                                <option value="<?php echo $law->id; ?>"><?php echo $law->title; ?></option>
                                                <?php } ?>
                                            </select>
                                            <?php
                                            // echo $this->tag->select(array(
                                            // "lawlist",
                                            // $lawlist,
                                            // "using" => array("id", "title"),
                                            // 'useEmpty' => true,
                                            // 'emptyText' => 'আইনের শিরোনাম বাছাই করুন..',
                                            // 'emptyValue' => '',
                                            // 'style' => 'width:100%',
                                            // 'class' => "input",
                                            // ))
                                            ?>
                                            <p class="error text-danger"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" id="reporttype" style="display: none; color: rgb(0, 0, 0)">
                                    <div class="form-group">
                                        <label class="control-label">অভিযোগের অবস্থা </label>
                                        <div class="row reg-complain-status">
                                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3 mb-2">
                                                <label
                                                    class="btn btn-outline-secondary w-100 d-flex align-items-center justify-content-start">
                                                    <input type="radio" id="initial" name="complainstatus"
                                                        value="0" class="mr-2" />
                                                    <span style="color: black; font-weight: 400">অপেক্ষমান</span>
                                                </label>
                                            </div>
                                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3 mb-2">
                                                <label
                                                    class="btn btn-outline-secondary w-100 d-flex align-items-center justify-content-start">
                                                    <input type="radio" id="accepted" name="complainstatus"
                                                        value="1" class="mr-2" />

                                                    <span style="color: black; font-weight: 400">গ্রহণকৃত</span>
                                                </label>
                                            </div>
                                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3 mb-2">
                                                <label
                                                    class="btn btn-outline-secondary w-100 d-flex align-items-center justify-content-start">
                                                    <input type="radio" id="ignore" name="complainstatus"
                                                        value="2" class="mr-2" />

                                                    <span style="color: black; font-weight: 400"
                                                        class="mt-1">বাতিল</span>

                                                </label>
                                            </div>
                                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3 mb-2">
                                                <label
                                                    class="btn btn-outline-secondary w-100 d-flex align-items-center justify-content-start">
                                                    <input type="radio" id="all" name="complainstatus"
                                                        value="3" checked class="mr-2" />
                                                    <span style="color: black; font-weight: 400" class="mt-1">সকল</span>


                                                </label>
                                            </div>
                                        </div>

                                        <p class="error text-danger"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-success" type="submit" id="saveComplain"
                            onclick="register.showRegister()">অনুসন্ধান</button>

                        {{-- Uncomment the button below if you need it in the future --}}
                        {{-- <button onclick="register.printtabledetails()" class="btn btn-success pull-right">
                        <span class="glyphicon glyphicon-print"></span> Print
                    </button> --}}
                    </div>
                    <!-- panel-footer -->
                </div>
                <div class="panel panel-default">
                    <div class="panel-body cpv ">
                        <div class="col-md-12">
                            <div class="form-group hidden" id="register_column_label">
                                <div class="col-md-12 text-right">
                                    <a href="#" onclick="register.printtabledetails()" id="printButtonForRegi"
                                        class="btn btn-success btn-sm m-0 m-bottom-5">
                                        <span class="glyphicon glyphicon-print"></span> Print
                                    </a>
                                </div>
                                <div class="col-md-12">
                                    <label class="register-report-title">রেজিস্টার এর তথ্য নির্বাচন করুন</label>

                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <div id="register_column_fields">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div id="table_print" class="" style="">
                                        <div id="regiDataLoder" style="display:none;"><img class="dataLoderimg"
                                                id="" alt="Processing..." src="/images/loading.gif"
                                                height="" width="" />Loading...
                                        </div>
                                        <table id="data_table" class="table table-bordered" cellspacing="0"
                                            width="100%">

                                        </table>
                                        <input type='hidden' id='nameOfRegi' value='' />
                                        <input type='hidden' id='classOfRegi' value='' />
                                    </div>
                                </div>
                            </div>
                            <div id="cloneTble">

                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <?php $roleID = globalUserInfo()->role_id; ?>
    {{-- @if (auth()->user()->getProfile() == 'ADM' || auth()->user()->getProfile() == 'DM' || auth()->user()->getProfile() == 'DC') --}}
    @if ($roleID == 37 || ($roleID = 38))
        <div id="printcitizenregister" style="display: none;">
            @include('mobile_court.register_list.partials.adm.printcitizenregister')
        </div>

        <div id="printdailyregister" style="display: none;">
            @include('mobile_court.register_list.partials.adm.printdailyregister')
        </div>

        <div id="printpunishmentregister" style="display: none;">
            @include('mobile_court.register_list.partials.adm.printpunishmentregister')
        </div>

        <div id="printmonthlystatisticsregister" style="display: none;">
            @include('mobile_court.register_list.partials.adm.printmonthlystatisticsregister')
        </div>

        <div id="printlawbasedReport" style="display: none;">
            @include('mobile_court.register_list.partials.adm.printlawbasedReport')
        </div>
    @endif

    @if ($roleID == 26)
        {{-- @if auth()->user()->getProfile() == 'Magistrate' --}}

        <div id="printlawbasedReport" style="display: none;">
            @include('mobile_court.register_list.partials.magistrate.printlawbasedReport')
        </div>

        <div id="printcitizenregister" style="display: none;">
            @include('mobile_court.register_list.partials.magistrate.printcitizenregister')
        </div>

        <div id="printmonthlystatisticsregister" style="display: none;">
            @include('mobile_court.register_list.partials.magistrate.printmonthlystatisticsregister')
        </div>
    @endif
    {{-- @endif --}}

    {{-- @if auth()->user()->getProfile() == 'Divisional Commissioner'

    <div id="printmonthlystatisticsregister" style="display: none;">
        @include('mobile_court.register_list.partials.division.printmonthlystatisticsregister')
    </div>

    <div id="printcitizenregister" style="display: none;">
        @include('mobile_court.register_list.partials.division.printcitizenregister')
    </div>

@endif --}}
    @if ($roleID == 25)
        {{-- @if auth()->user()->getProfile() == 'Prosecutor' --}}

        <div id="printprosecutionform" style="display: none;">
            @include('mobile_court.register_list.partials.prosecutor.printprosecutionform')
        </div>

        <div id="printprosecutionreport" style="display: none;">
            @include('mobile_court.register_list.partials.prosecutor.printprosecutionreport')
        </div>

        <div id="printlawbasedReport" style="display: none;">
            @include('mobile_court.register_list.partials.adm.printlawbasedReport')
        </div>
    @endif

    <div id="messageModal">
        @include('mobile_court.message.partials.message')
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('mobile_court/javascripts/lib/custom_c.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('/mobile_court/cssmc/registerList/registerCheckBox.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/mobile_court/cssmc/registerList/registerNewPrint.css') }}" />
    <link rel="stylesheet" type="text/css"
        href="{{ asset('/mobile_court/javascripts/source/register/DataTables-1.10.15/media/css/jquery.dataTables.css') }}" />
    <link rel="stylesheet" type="text/css"
        href="{{ asset('/mobile_court/javascripts/source/register/DataTables-1.10.15/extensions/RowGroup/css/rowGroup.dataTables.css') }}" />


    <script type="text/javascript"
        src="{{ asset('/mobile_court/javascripts/source/register/DataTables-1.10.15/media/js/jquery.dataTables.js') }}">
    </script>
    <script type="text/javascript"
        src="{{ asset('/mobile_court/javascripts/source/register/DataTables-1.10.15/extensions/Responsive/js/dataTables.responsive.js') }}">
    </script>
    <script type="text/javascript"
        src="{{ asset('/mobile_court/javascripts/source/register/DataTables-1.10.15/extensions/RowGroup/js/dataTables.rowGroup.js') }}">
    </script>
    <script src="{{ asset('/mobile_court/javascripts/source/register/registerscript.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/mobile_court/javascripts/source/register/nagorikOvijogRegister.js') }}">
    </script>
    <script type="text/javascript"
        src="{{ asset('/mobile_court/javascripts/source/register/prosecutionRelatedRegister.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/mobile_court/javascripts/source/register/dailyRegister.js') }}">
    </script>
    <script type="text/javascript"
        src="{{ asset('/mobile_court/javascripts/source/register/punishmentJailRegister.js') }}"></script>
    <script type="text/javascript"
        src="{{ asset('/mobile_court/javascripts/source/register/punishmentFineRegister.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/mobile_court/javascripts/source/register/mobileCourtRegister.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('/mobile_court/javascripts/source/register/lawbasedregister.js') }}">
    </script>
@endsection
