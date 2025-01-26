@extends('layout.app')

@section('content')
    <div class="card card-default" style="margin-bottom: 20px">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card-body">
            <form method="POST" action="{{ route('mc.law.update', $law->id) }}" autocomplete="off">
                @csrf
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="" style="background: #008841; padding:10px; text-align: center; color: white">আইন
                            /বিধিমালা </h4>
                    </div>
                </div>
                {{-- @dd($law )  --}}
                <div class="row mt-5">
                    <div class="col-sm-4">
                        <div class="form-group" style="width:100%">
                            <label style="background: #008841; color: white; width:100%" class="control-label"><span
                                    style="color:#FF0000"></span> শিরোনাম</label>
                            <input name="title" style="width: 100%; height: 40px" type="text"
                                value="{{ $law->title }}">
                        </div>
                        <!-- form-group -->
                    </div>
                    <!-- col-sm-3 -->
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label " style="background: #008841; color: white; width:100%"><span
                                    style="color:#FF0000"></span> নম্বর</label>
                            <input name="law_no" style="width: 100%; height: 40px" type="text"
                                value="{{ en2bn($law->law_no) }}">
                        </div>
                        <!-- form-group -->
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group flex flex-row">
                            <label class="control-label" style="background: #008841; color: white; width:100%"><span
                                    style="color:#FF0000"></span>বিধিমালা হলে ক্লিক করুন </label>

                            <input type="checkbox" id="is_rules" name="is_rules" {{ $law->is_rules ? 'checked' : '' }} />
                        </div>
                        <!-- form-group -->
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label style="background: #008841; color: white; width:100%" class="control-label"><span
                                    style="color:#FF0000"></span> বর্ণনা</label>
                            <textarea name="description" id="" cols="60" rows="5">{{ $law->description }}</textarea>
                        </div>
                        <!-- form-group -->
                    </div>
                </div>
                <div class="row">

                    <div class="col-sm-12">
                        <div class="form-group">
                            <label style="background: #008841; color: white; width:100%" class="control-label"><span
                                    style="color:#FF0000"></span> মূল আইনের লিঙ্ক</label>
                            <p>যেমনঃ মোবাইল কোর্ট আইন, ২০০৯ - সম্পর্কে জানতে লিখুন </p>
                            <p>http://bdlaws.minlaw.gov.bd/bangla_pdf_part.php?act_name=&vol=&id=1025</p>
                            <input type="text" style="width: 60%; height: 40px" name="bd_law_link"
                                value="{{ $law->bd_law_link }}">
                        </div>
                        <!-- form-group -->
                    </div>
                    <div class="row" style="margin: 20px 0">
                        <div class="col-md-12">
                            <label class="control-label" style="font-weight: bold; font-size: 17px"><span
                                    class="text-danger">*</span>স্ট্যাটাস</label>
                            <div class="radio-inline">
                                <label class="radio">
                                    <input type="radio" name="delete_status" value="1"
                                        <?= $law->delete_status == 1 ? 'checked' : '' ?> />
                                    <span></span>এনাবল</label>
                                <label class="radio text-danger">
                                    <input type="radio" name="delete_status" value="0"
                                        <?= $law->delete_status == 0 ? 'checked' : '' ?> />
                                    <span></span>ডিসএবল</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-start">
                    {{-- {{ submit_button("সংরক্ষণ করুন", "class": "btn btn-success") }} --}}
                    <button class="btn btn-success">পরিবর্তন করুন</button>
                </div>
                {{--  <div class="row">
                    <div class="col-sm-4">
                    </div>
                    <div class="col-sm-4">
                        <div class="flex justify-start">
                            <button class="btn btn-success">সংরক্ষণ করুন</button>
                        </div>
                    </div>
                    <div class="col-sm-4">
                    </div>
                </div> --}}

            </form>
        </div>
        <div class="panel-footer panel-footer-thin">
        </div>
    </div>
@endsection
