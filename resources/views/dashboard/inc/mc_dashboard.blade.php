<div class="mc_dashboard dashboard d-full">
<style>
    .chartSubText {
        font-size: 18px !important;
        color: green !important;
    }
    #block2_label, #block3_label {
        color: green !important;
    }
   
    
</style>
        <div class="divSpace"></div>
        <div class="card  panel-primary">
            <div class="card-body cpv cpv96">
                <div class="row m-bottom-30">
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        <div class="panel panel-success-alt">
                            <div class="panel-heading panel-heading-dashboard">
                                <h3 class="panel-title-dashboard" style="font-weight: bold">অনুসন্ধানের উপাত্তসমূহ</h3>
                            </div><!-- panel-heading -->
                            <div class="panel-body cpv cpv-fixed-height nopadding">

                              
                                 <?php if($roleID== 38 or $roleID== 37){ ?>
                                    <input class="hidden"  id="zilla" value="{{ $zillaId }}" type="hidden" > <br/>
                                <?php } ?>
                               
                               
                                
                                <?php 
                                
                                  if ($roleID ==34){  
                                   //'Divisional Commissioner'?>

                                    <div class="form-group clearfix m-top-5">
                                        <div class="col-sm-12" >
                                            <label class="col-sm-12 control-label">জেলা </label>
                                            <select id="zilla" name="zilla" class="input form-control" style="width:100%" onchange="showupozilladiv()" tabindex="-1" title="">
                                                <option value="">জেলা বাছাই করুন</option>
                                                <?php foreach($zilla as $zillalis){?>
                                                    <option value="{{ $zillalis->id }}">{{ $zillalis->district_name_bn }}</option>
                                                <?php }?>
                                            </select>
                                          

                                            <label for="fruits" class="error"></label>
                                        </div>
                                    </div>

                                <?php } ?>

                                <?php 
                                if ($roleID == 2 || $roleID ==8 || $roleID ==25){ ?>

                                     <div class="clearfix form-group m-top-5">
                                        <div class="row"> 
                                            <div class="col-xs-12 col-sm-6 col-md-6 ">
                                                <label class="control-label">বিভাগ </label>
                                                <select id="division" name="division" class="input form-control" style="width:100%" onchange="showZilla(this.value,'zilla')" tabindex="-1" title="">
                                                    <option value="">বিভাগ বাছাই করুন</option>
                                                    <?php foreach($division as $divlist){?>
                                                        <option value="<?php echo $divlist->id ?>">{{ $divlist->division_name_bn }}</option>

                                                    <?php }?>
                                                </select>
                                             
                                                <label for="fruits" class="error"></label>
                                            </div>
                                            <div class="col-xs-12 col-sm-6 col-md-6 ">
                                                <label class="control-label">জেলা </label>
                                                <select id="zilla" name="zilla" class="input form-control" style="width:100%" onchange="showupozilladiv()" tabindex="-1" title="">
                                                    <option value="">জেলা বাছাই করুন</option>
                                                </select>
                                              
                                                <label for="fruits" class="error"></label>
                                            </div>
                                        </div>
                                    </div> 

                                
                                <?php } ?>
                               
                                <div class="check-local clearfix m-bottom-10">
                                    <div class="col-xs-12 d-inline-block  check-upazila">
                                        <label class="btn btn-sm btn-default active  ">
                                            <input class="custom_radio" type="radio" id="locationtype" name="formtype" value="1" checked="checked"
                                                   onclick="showupozilladiv()" style="float: left;"/> <span class="place-label" style="font-size: 12px; color: black; margin: 0px; margin-top: 5px">উপজেলা</span>
                                        </label>
                                    </div>
                                    <div class="col-xs-12 d-inline-block check-city">
                                        <label class="btn btn-sm btn-default active  ">
                                            <input class="custom_radio" type="radio" id="locationtype" name="formtype" value="2"
                                                   onclick="showcitycorporationdiv()" style="float: left;"/> <span class="place-label" style="font-size: 12px; color: black">সিটি কর্পোরেশন</span>
                                        </label>
                                    </div>
                                    <div class="col-xs-12 d-inline-block check-metro">
                                        <label class="btn btn-sm btn-default active ">
                                            <input class="custom_radio" type="radio" id="locationtype" name="formtype" value="3"
                                                   onclick="showmetropolotandiv()" style="float: left;" /> <span class="place-label" style="font-size: 12px; color: black">মেট্রোপলিটন</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="clearfix">
                                    <div id="upoziladiv" style="display: none" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <label class="control-label"><span style="color:#FF0000"></span> উপজেলা</label>
                                            <select name="upazila" class="input  select2-offscreen" style="width:100%" id="upazila">
                                                <option value="">{{ __('বাছাই করুন...') }}</option>
                                                @foreach($upazila as $item)
                                                    <option value="{{ $item->id }}">{{ $item->upazila_name_bn }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div id="citycorporationdiv" style="display: none" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <label class="control-label"><span style="color:#FF0000"></span> সিটি কর্পোরেশন </label>
                                            <select name="GeoCityCorporations" id="GeoCityCorporations" class="input select2-offscreen" style="width:100%">
                                                <option value="">{{ __('বাছাই করুন...') }}</option>
                                               
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix" id="metropolitandiv" style="display: none">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <label class="control-label"><span style="color:#FF0000"></span>মেট্রোপলিটন </label>
                                            <select name="GeoMetropolitan" id="GeoMetropolitan" class="input select2-offscreen " style="width:100%" onchange="showThanas(this.value, 'GeoThanas')">
                                                <option value="">{{ __('বাছাই করুন...') }}</option>
                                              
                                            </select>
                                        </div>
                                        <!-- form-group -->
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <label class="control-label"><span style="color:#FF0000"></span>থানা </label>
                                            <select name="GeoThanas" class="input select2-offscreen" id="GeoThanas" style="width:100%">
                                                <option value="">{{ __('বাছাই করুন...') }}</option>
                                               
                                            </select>
                                        </div>
                                        <!-- form-group -->
                                    </div>
                                </div>

                                <div class="clearfix m-bottom-15">
                                    <div class="col-xs-12 col-sm-6 col-md-12 col-lg-12">
                                        <div class="form-group">
                                        <label class="control-label">প্রথম তারিখ</label>
                                        <input class="input-sm form-control" style="width: 100%" name="startdate"
                                               id="startdate" value=""
                                               type="text"/>

                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-12 col-lg-12">
                                        <div class="form-group">
                                        <label class="control-label">শেষ তারিখ</label>
                                        <input class="input-sm form-control" style="width: 100%" name="enddate"
                                               id="enddate" value=""
                                               type="text"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                        <label class="control-label">গ্রাফ নির্বাচন করুন </label>
                                        <select data-placeholder="Choose One" class="input" tabindex="-1" title="" name="graph" id="graph" style="width: 100%">
                                            <option value="">বাছাই করুন...</option>
                                            <option value="1">  অপরাধের তথ্য</option>
                                            <option value="2">স্থান ভিত্তিক মামলা</option>
                                            <option value="3">  জরিমানা</option>
                                            <option value="4">মামলার ধরন ও আইন</option>
                                        </select>
                                        <label for="fruits" class="error"></label>
                                        </div>
                                    </div>
                                </div>

                              

                            </div><!-- panel-body -->

                            <div class="panel-footer">
                                <button class="btn btn-medium btn-success ml-5" type="submit" id="saveComplain"
                                        onclick="dashboard.searchGraphInformation()">গ্রাফ অনুসন্ধান
                                </button>
                            </div><!-- panel-footer -->
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-4" id="dcofficeinfo">
                        <div class="panel  panel-warning-alt">
                            <div class="panel-heading panel-heading-dashboard">
                                <h3 class="panel-title-dashboard" style="font-weight: bold">
                                    মামলার পরিসংখ্যান
                                </h3>
                            </div>
                            <div id="case_statistics" class="loading-div">
                            <div class="panel-body cpv cpv-fixed-height padding15">
                                <p id="block2_label"></p>
                                <div class="list-group m-bottom-0">
                                    <div class="list-group-item">
                                    <i class="fas fa-gavel icon-lg text-danger mr-3"></i>
                                        মোট পরিচালিত কোর্ট
                                        <span class="badge  label  label-danger font-weight-bold" id="executed_court_dc">232</span>
                                    </div>

                                    <div class="list-group-item">
                                    <i class="fas fa-gavel icon-lg text-danger mr-3"></i>
                                        মোট মামলার সংখ্যা
                                        <span class="badge  label  label-danger font-weight-bold" id="no_case_dc">0</span>
                                    </div>

                                    <div class="list-group-item">
                                      <i class="fas fa-gavel icon-lg text-danger mr-3"></i>
                                        আদায়কৃত অর্থ
                                        <span class="badge  label  label-danger font-weight-bold" id="fine_dc">0</span>
                                    </div>

                                    <div class="list-group-item">
                                      <i class="fas fa-gavel icon-lg text-danger mr-3"></i>
                                        মোট আসামির সংখ্যা
                                        <span class="badge  label  label-danger font-weight-bold" id="criminal_no_dc">0</span>
                                    </div>

                                    <div class="list-group-item">
                                       <i class="fas fa-gavel icon-lg text-danger mr-3"></i>
                                        কারাদণ্ড প্রাপ্ত আসামির সংখ্যা
                                        <span class="badge  label  label-danger font-weight-bold" id="jail_criminal_no_dc">0</span>
                                    </div>


                                    <?php if ($roleID == '37' or $roleID =='38' ){
                                     ?>
                                    <div class="list-group-item">
                                        <a id="linkShowMagistrateList" href="<?php echo url('dashboard/showMagistrateList')?>">
                                        <i class="fas fa-gavel icon-lg text-danger mr-3"></i> এক্সিকিউটিভ ম্যাজিস্ট্রেটের সংখ্যা
                                        </a><span class="badge  label  label-danger font-weight-bold" id="no_magistrate">0</span>
                                    </div>
                                    <?php }else{ ?>
                                    <div class="list-group-item">
                                      <i class="fas fa-gavel icon-lg text-danger mr-3"></i>
                                       
                                        এক্সিকিউটিভ ম্যাজিস্ট্রেটের সংখ্যা
                                        <span class="badge  label  label-danger font-weight-bold" id="no_magistrate">0</span>
                                    </div>
                                    <?php } ?>


                                    <?php
                                    if ($roleID == '37' or $roleID == '38' ){
                                    ?>
                                    <div class="list-group-item">
                                        <a id="linkShowProsecutorList" href="<?php echo url('dashboard/showProsecutorList');?>">
                                        <i class="fas fa-gavel icon-lg text-danger mr-3"></i>
                                        মোট প্রসিকিউটরের সংখ্যা
                                        </a>
                                        <span class="badge  label  label-danger font-weight-bold" id="no_prosecutor">0</span>
                                    </div>
                                    <?php } ?>
                                  
                                </div>
                            </div>
                            </div>
                            <!-- panel-body cpv -->
                            <div class="panel-footer">
                                <input class="btn btn-medium btn-success" value="পরিসংখ্যান অনুসন্ধান"
                                       onclick="dashboard.caseStatisticsBlock()"
                                       type="button" id="btn-upz"/>
                            </div>
                            <!-- panel-footer -->
                            <!-- panel -->
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <div class="panel  panel-danger-alt">
                            <div class="panel-heading panel-heading-dashboard ">
                                <h3 class="panel-title-dashboard" style="font-weight: bold">
                                    অপরাধের তথ্য
                                </h3>
                            </div>
                            <div id="criminal_info" class="loading-div">
                            <!-- panel-heading -->
                            <div class="panel-body cpv cpv-fixed-height padding15">
                                <p id="block3_label"></p>
                                <div class="list-group m-bottom-0">
                                    <div class="list-group-item">
                                       
                                        মোট অপরাধের তথ্য
                                        <span class="badge  label  label-danger font-weight-bold" id="total">0</span>
                                    </div>

                                    <a id="acceptedComplain" href="<?php  url('dashboard/showAcceptedComplain');?>"
                                       class="list-group-item">
                                       
                                        গ্রহণকৃত অভিযোগ সংখ্যা
                                        <span class="badge  label  label-danger font-weight-bold" id="accepted">0</span>
                                    </a>
                                    <a id="ignoreComplain" href="<?php url('dashboard/showIgnoreComplain')?>"
                                       class="list-group-item">
                                      
                                        বাতিলকৃত অভিযোগ সংখ্যা
                                        <span class="badge  label  label-danger font-weight-bold" id="ignore">0</span>
                                    </a>
                                    <a id="pendingComplain" href="<?php  url('dashboard/showPendingComplain')?>"
                                       class="list-group-item">
                                     
                                        অপেক্ষমান অভিযোগের সংখ্যা
                                        <span class="badge  label  label-danger font-weight-bold" id="unchange">0</span>
                                    </a>
                                   
                                </div>
                            </div>
                            <!-- panel-body cpv -->
                            </div>
                            <div class="panel-footer">
                                <input class="btn btn-medium btn-success" value="পরিসংখ্যান অনুসন্ধান" type="button"
                                       onclick="dashboard.citizenComplainStatisticsBlock()" id="btn-zilla-c"/>
                            </div>
                            <!-- panel-footer -->
                        </div>
                        <!-- panel -->
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="panel panel-default">
                            <div id="fine_loading" class="loading-div">
                            <div class="panel-heading panel-heading-dashboard">
                                <h3 class="panel-title-dashboard ml-5 mt-5">
                                    জরিমানা: <span class="label_design chartSubText" id="fine_label"></span>
                                </h3>
                            </div>
                            <div class="panel-body cpv padding15">
                                <div id="hero-bar-fine" style="width:100%;height:200px"></div>
                            </div>
                            <div class="panel-footer panel-footer-thin">
                                <div class="col-sm-12 ">
                                </div>
                            </div>
                            </div>
                            <!-- panel-footer -->
                        </div>
                    </div>
                    <div class="clearfix m-bottom-15 visible-xs-block visible-sm-block"></div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 p-bottom-10">
                        <div class="panel panel-default">
                            <div id="case_loc_loading" class="loading-div">
                            <div class="panel-heading panel-heading-dashboard">
                                <h3 class="panel-title-dashboard">
                                    স্থানভিত্তিক মামলার তথ্য: <span class="label_design chartSubText" id="case_label"></span>
                                </h3>
                            </div>
                            <div class="panel-body cpv padding15">
                                <div id="basicFlotLegend" class="flotLegend1">
                                    <div id="hero-bar-location" style="width:100%;height:200px"></div>
                                </div>
                            </div>
                            <div class="panel-footer panel-footer-thin">
                                <div class="col-sm-12 ">
                                </div>
                            </div>
                            </div>
                            <!-- panel-footer -->
                        </div>
                    </div>
                </div>
                <div class="clearfix m-bottom-15 visible-xs-block visible-sm-block"></div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="panel panel-default">
                            <div id="citizen_complain_graph_loading" class="loading-div">
                            <div class="panel-heading panel-heading-dashboard">
                                <h3 class="panel-title-dashboard">
                                    অপরাধের তথ্য: <span class="label_design chartSubText" id="crime_label"></span>
                                </h3>
                            </div>
                            <div class="panel-body cpv padding15">
                                <div id="hero-bar-citizen" style="width:100%;height:200px"></div>
                            </div>
                            <div class="panel-footer panel-footer-thin">
                                <div class="col-sm-12 ">
                                </div>
                            </div>
                            </div>
                            <!-- panel-footer -->
                        </div>
                    </div>
                    <div class="clearfix m-bottom-15 visible-xs-block visible-sm-block"></div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="panel panel-default">
                            <div id="case_type_graph_loading" class="loading-div">
                            <div class="panel-heading panel-heading-dashboard">
                                <h3 class="panel-title-dashboard">
                                    অপরাধের ধরন অনুসারে মামলার তথ্য: <span class="label_design chartSubText" id="law_label"></span>
                                </h3>
                            </div>
                            <div class="panel-body cpv padding15">
                                <div id="hero-bar-crimetype" style="width:100%;height:200px"></div>
                            </div>
                            <div class="panel-footer panel-footer-thin">
                                <div class="col-sm-12 ">
                                </div>
                            </div>
                            </div>
                            <!-- panel-footer -->
                        </div>
                    </div>
                </div>

                <div class="row">
                    <input id="user_prfoile" value="{{ $roleID }}" type="hidden">
                    <div class="col-sm-12" id="tab">
                        <table class="collaptable table table-bordered table-hover">
                            <thead style="background-color: #008841; color: white;">
                                <tr>
                                    <th class="centertext" style="width: 10%" ROWSPAN=3>
                                        <?php
                                            if ($roleID == '37' or $roleID == '38'){
                                            echo 'উপজেলা';
                                            }elseif ($roleID == 34) {
                                            echo 'জেলা';
                                            }elseif ($roleID == 2 || $roleID == 8 || $roleID == 25){
                                            echo 'বিভাগ';
                                            }
                                        ?>
                                    </th>
                                    <th class="centertext" colspan="2" ROWSPAN=2 style="width: 10%">মোবাইল কোর্টের সংখ্যা</th>
                                    <th class="centertext" colspan="2" ROWSPAN=2 style="width: 10%">মামলার সংখ্যা</th>
                                    <th class="centertext" colspan="2" ROWSPAN=2 style="width: 18%">আদায়কৃত অর্থ (টাকায়)</th>
                                    <th class="centertext" colspan="4" style="width: 30%">আসামির সংখ্যা</th>
                                </tr>
                                <tr>
                                    <th class="centertext" colspan="2" style="width: 10%">মোট</th>
                                    <th class="centertext" colspan="2" style="width: 10%">কারাদণ্ড প্রাপ্ত</th>
                                </tr>
                                <tr>
                                    <th class="centertext" style="width: 5%">বর্তমান মাস</th>
                                    <th class="centertext" style="width: 5%">পূর্বের মাস</th>
                                    <th class="centertext" style="width: 5%">বর্তমান মাস</th>
                                    <th class="centertext" style="width: 5%">পূর্বের মাস</th>
                                    <th class="centertext" style="width: 9%">বর্তমান মাস</th>
                                    <th class="centertext" style="width: 9%">পূর্বের মাস</th>
                                    <th class="centertext" style="width: 5%">বর্তমান মাস</th>
                                    <th class="centertext" style="width: 5%">পূর্বের মাস</th>
                                    <th class="centertext" style="width: 5%">বর্তমান মাস</th>
                                    <th class="centertext" style="width: 5%">পূর্বের মাস</th>
                                </tr>
                            </thead>
                            <tbody id="tbdMonthlyReport" >

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

</div>