@extends('layout.app')

@section('content')
@if (session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif
@if (session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

<form method="post" autocomplete="off">
@csrf
<input type="hidden" id="id" name="id" value="">
<input type="hidden" id="report_type_id" name="report_type_id" value="3"/>

<div class="card panel-default">
    <div class="card-header smx">
        <h4 class="card-title">
            অতিরিক্ত জেলা ম্যাজিস্ট্রেট আদালতের ফৌজদারি কার্যবিধির আওতাধীন মামলার বিবরণ
        </h4>
    </div>
    <div class="card-body cpv ">
        <div class="col-md-12">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="control-label">প্রতিবেদন দাখিলের সময়</label>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                        <input type="text" class="form-control" placeholder="mm-yyyy" id="report_date"
                               name="report_date"
                               required="true"/>
                    </div>
                </div>
            </div>
            <div id="reportdiv" style="display: none;margin-top:40px">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="control-label">প্রমাপ </label>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <?php 
                            // echo $this->tag->textField(array("promap" ,'class' => "input form-control"
                            // ,'readonly' => "readonly"))
                            ?>
                            <input type="text" id="promap" name="promap" class="input form-control" readonly="readonly">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="control-label">অর্জন (%)</label>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <?php 
                            // echo $this->tag->textField(array("promap_achive" ,'class' => "input form-control"
                            // ,'readonly' => "readonly"))
                            ?>
                            <input type="text" id="promap_achive" name="promap_achive" class="input form-control" readonly="readonly">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="control-label">প্রমাপ অর্জন হয়েছে কিনা</label>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <span id="promap_achive_text"></span>
                            <input type="hidden" id="comment1" name="comment1" value="0">
                            <?php //echo $this->tag->hiddenField("comment1") ?>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="control-label">
                                পুর্ববর্তী মাসের মামলার জের</label>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <span id=""></span>
                            <input type="text" id="pre_case_incomplete" name="pre_case_incomplete" class="input
                            form-control" readonly="readonly">
                            <?php 
                            // echo $this->tag->textField(array("pre_case_incomplete" ,'class' => "input
                            // form-control" ,'readonly' => "readonly"))
                            ?>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="control-label">বর্তমান মাসের অনিষ্পন্ন মামলা</label>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                        <input type="text" id="case_incomplete" name="case_incomplete" class="input
                        form-control" readonly="readonly">
                            <?php 
                            // echo $this->tag->textField(array("case_incomplete" ,'class' => "input
                            // form-control"
                            // ,'readonly' => "readonly"))
                            ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="control-label">দায়েরকৃত মামলার সংখ্যা</label>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                        <input type="text" id="case_submit" name="case_submit" class="input form-control" required="1" onmouseout="showTotalcase(this.value)">
                            <?php 
                            // echo $this->tag->textField(array("case_submit",'required' => true ,'class' =>
                            // "input form-control" ,'onmouseout'
                            // => "showTotalcase(this.value)"))
                             ?>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="control-label">০১ বছরের ঊর্ধ্বে অনিষ্পন্ন মামলা</label>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                        <input type="number" id="case_above1year" name="case_above1year" class="input
                        form-control">
                            <?php 
                            // echo $this->tag->numericField(array("case_above1year" ,'class' => "input
                            // form-control"))
                            ?>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="control-label">মোট মামলার সংখ্যা</label>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                        <input type="text" id="case_total" name="case_total" class="input form-control" readonly="readonly">
                            <?php 
                            // echo $this->tag->textField(array("case_total" ,'class' => "input form-control"
                            // ,'readonly' => "readonly"))
                            ?>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="control-label">০২ বছরের ঊর্ধ্বে অনিষ্পন্ন মামলা</label>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                        <input type="number" id="case_above2year" name="case_above2year" class="input
                        form-control">
                            <?php 
                            // echo $this->tag->numericField(array("case_above2year" ,'class' => "input
                            // form-control"
                            // ))
                            ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="control-label">নিষ্পত্তিকৃত মামলার সংখ্যা</label>

                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                        <input type="text" id="case_complete" name="case_complete" class="input form-control" required="1" onmouseout="showTotalcompletecase(this.value)">
                            <?php 
                            // echo $this->tag->textField(array("case_complete",'class' => "input form-control"
                            // ,'required' => true , 'onmouseout' => "showTotalcompletecase(this.value)")) 
                            ?>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="control-label">০৩ বছর বা তদূর্ধ্ব অনিষ্পন্ন মামলা</label>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                        <input type="number" id="case_above3year" name="case_above3year" class="input
                        form-control">
                            <?php 
                            // echo $this->tag->numericField(array("case_above3year" ,'class' => "input
                            // form-control"))
                            ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">মন্তব্য</label>
                            <?php 
                            // echo $this->tag->textArea(array("comment2", "cols" => 50, "rows" =>4 ,'class' =>
                            // "input form-control")) 
                            ?>
                            <textarea id="comment2" name="comment2" class="input form-control" cols="50" rows="4"></textarea>
                        </div>
                    </div>
                </div>
                <div id="adm_comment" class="row hidden d-none">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">এ ডি এম - এর মন্তব্য</label>
                            <p class="form-control" id="comment_from_adm"></p>
                        </div>
                    </div>
                </div>

                <!-- form-group -->
                <div class="panel-footer">
                     
                    <div class="pull-right">
                        <button class="btn btn-success mr5" onmouseover=onMouseOverAdmAppealReportSubmit(this.value); type="submit" id="btn_submit">সংরক্ষণ করুন</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>

<div id="messageModal">
@include('message.partials.message')
</div>
@endsection

@section('scripts')

<script src="{{ asset('/mobile_court/javascripts/source/report/common.js') }}"></script>
@endsection
