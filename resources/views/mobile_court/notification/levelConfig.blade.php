
@extends('layout.app')

@section('content')
<style>

  .custom-control-label::before {

    background-color: transparent;
}
. .custom-control-label::before {
    border-radius: transparent;
}
.notificationProfile{
    margin: 3.5px !important;
}

</style>
<div class="divSpace"></div>

<div class="card panel-default" style="margin-bottom: 20px">
    <div class="card-header smx">
        <h2 class="card-title" id="levelTitle"> লেভেল নোটিফিকেশন কনফিগারেশন </h2>
        <input type="hidden" id="levelValue" value=<?php echo $_GET['level'];?>>
        <input type="hidden" id="notificationId">
        <input type="hidden" id="notificationLevelType">
    </div>
    <div class="card-body cpv">
        <div class="row">
            <div class="col-sm-6 notificationProfileClass">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="control-label"><span style="color:#FF0000">*</span>তারিখ</label>
                        
                        <select type="text" class="form-control" id="notificationDate" name="notificationDate"
                                required="true">
                            <option value="">  নোটিফিকেশন  পাঠানোর  তারিখ  নির্বাচন  করুন </option>
                        <?php foreach (range(1,15) as $number){echo '<option value='.$number.'> প্রতি  মাসের '.$number.'  তারিখ</option>';}?>
                        </select>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="control-label"><span style="color:#FF0000">*</span>নিযুক্ত ব্যক্তির তালিকা</label>
                        <div class="col-sm-12">
                            
                            <div class="custom-control ">
                                <!-- 4 -->
                                <input value="34" type="checkbox" class="notificationProfile" id="notificationProfile1">
                                <label class="custom-control-label" for="notificationProfile1">বিভাগীয় কমিশনার</label>
                            </div>
                            <div class="custom-control ">
                                <!-- 5 -->
                                <input value="8" type="checkbox" class="notificationProfile" id="notificationProfile2">
                                <label class="custom-control-label" for="notificationProfile2">মুখ্য সচিব</label>
                            </div>
                            <div class="custom-control ">
                            <!-- 7 -->
                                <input value="38" type="checkbox" class="notificationProfile" id="notificationProfile3">
                                <label class="custom-control-label" for="notificationProfile3">অতিরিক্ত জেলা ম্যাজিস্ট্রেট</label>
                            </div>
                            <div class="custom-control ">
                            <!-- 14 -->
                                <input value="37" type="checkbox" class="notificationProfile" id="notificationProfile4">
                                <label class="custom-control-label" for="notificationProfile4">জেলা প্রশাসক</label>
                            </div>
                            <div class="custom-control ">
                            <!-- 15 -->
                                <input value="27" type="checkbox" class="notificationProfile" id="notificationProfile5">
                                <label class="custom-control-label" for="notificationProfile5">সহকারী কমিশনার - জুডিসিয়াল মুন্সিখানা (এসি-জেএম)
                                </label>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <!-- col-sm-3 -->
                <div class="form-group">
                    <label class="control-label"><span style="color:#FF0000">*</span>নোটিফিকেশন বার্তাংশ</label>
                    <textarea style="height:150px;" maxlength="160" class="form-control" id="notificationBody" name="notificationBody"
                              required="true"></textarea>
                </div>
                <!-- form-group -->
            </div>
        </div>



    </div>
 
    <input type="hidden" id="id" name="id">
    <!-- panel-body -->
    <div class="card-footer">
        
        <div class="pull-right float-right">
            <button onclick="misNotification.saveNotificationConfiguredData()" class="btn btn-success" type="submit"><i class="glyphicon glyphicon-ok"></i> সংরক্ষণ</button>
        </div>
    </div>
    <!-- panel-footer -->
</div><!-- panel -->
@endsection
@section('scripts')
<script>
    document.getElementById('notificationProfile4').addEventListener('click', function() {
    console.log('Checkbox clicked. Checked state:', this.checked);
    });
    document.getElementById('notificationProfile5').addEventListener('click', function() {
    console.log('Checkbox clicked. Checked state:', this.checked);
    });
    document.getElementById('notificationProfile3').addEventListener('click', function() {
    console.log('Checkbox clicked. Checked state:', this.checked);
    });
    document.getElementById('notificationProfile2').addEventListener('click', function() {
    console.log('Checkbox clicked. Checked state:', this.checked);
    });
    document.getElementById('notificationProfile1').addEventListener('click', function() {
    console.log('Checkbox clicked. Checked state:', this.checked);
    });
</script>
<script src="{{ asset('/mobile_court/javascripts/source/misNotification/misNotification.js') }}"></script>
@endsection