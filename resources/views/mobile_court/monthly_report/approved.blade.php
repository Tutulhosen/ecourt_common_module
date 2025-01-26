@extends('layout.app')

@section('content')

@if (session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif
@if (session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif
<style>
    

.panel-info-head .card-header {
    background-color: #70BDCD;
    padding: 10px 12px !important;
}
#accordion a {
    color: #FFF;
    /* text-shadow: 1px 1px #000; */
}
.card-group .panel-info-head {
    padding: 8px;
}
.panel-info-head .card-header .card-title {
    font-size: 20px;
    text-align: left;
}
</style>
<div class="card panel-default">
    <div class="card-header smx ">
        <h2 class="card-title">প্রতিবেদন (    {{ $report_month }} )</h2>
    </div>

    <div class="card-body cpv">
        @foreach ($reportlist as $index => $item)
        <div class="card-group" id="accordion">
            @if ($item->report_type_id == 1)
            <div class="card panel-info-head">
                <div class="card-header">

                    <a class="card-title" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                        মোবাইল কোর্টের মাসিক প্রতিবেদন
                    </a>

                </div>
                <div id="collapseOne" class="accordion-body collapse">
                    <div class="card-body cpv">
                        <table class="table table-bordered table-striped table-info mb30" align="center">
                            <tr>
                                
                                <td class="centertext">উপজেলার সংখ্যা</td>
                                <td class="centertext" >প্রমাপ</td>
                                <td class="centertext" >মোবাইল কোর্টের সংখ্যা</td>
                                <td class="centertext" >মামলার সংখ্যা</td>
                                <td class="centertext" >আদায়কৃত অর্থ (টাকায়)</td>
                                <td class="centertext" >আসামির সংখ্যা</td>
                                
                            </tr>
                            <tbody>
                        <tr>
                            <td>{{ $item->upozila  }}</td>
                            <td>{{ $item->promap }}</td>
                            <td>{{ $item->court_total }}</td>
                            <td>{{ $item->case_total }}</td>
                            <td>{{ $item->fine_total }}</td>
                          
                            <td>{{ $item->criminal_total}}</td>
                        </tr>
                           <tr>
                      
                               @if ($item->is_approved == 1)
                               <td colspan="15"> প্রতিবেদনটি অনুমোদিত হয়েছে ।</td>
                               @elseif( $item->is_approved == 2 )
                               <td colspan="15"> প্রতিবেদনটি  সংশোধনের  জন্য  ফেরত  পাঠানো  হয়েছে ।</td>
                               @elseif( $item->is_approved != 2 )
                                   <td >
                                    {{-- link_to("monthly_report/approvedreport/" ~ item.id, '<i class="icon-pencil"></i> অনুমোদন', "class": "btn  btn-primary") --}}
                                   <a href="{{ route('m.approvedreport',$item->id) }}" class="btn  btn-primary"><i class="icon-pencil"></i>অনুমোদন</a>
                                   </td>
                                   <td>
                                       <button class="btn  btn-danger" title="এ সি জে এম  সংশোধন করুন" type="button" onclick="commentModalOpen( <?php echo $item->id;?>)">সংশোধন</button>
                                   </td>
                                @endif 
                           </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
            @if ($item->report_type_id == 2)
            <div class="card panel-info-head">
                <div class="card-header">

                    <a class="card-title collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                        মোবাইল কোর্টের আপিল মামলার তথ্য
                    </a>

                </div>
                <div id="collapseTwo" class="accordion-body collapse">
                    <div class="card-body cpv">
                        <table class="table table-bordered table-striped table-info mb30" align="center">
                        <tr>

                            <td class="centertext" ROWSPAN=2>পুর্ববর্তী মাসের মামলার জের</td>
                            <td class="centertext" ROWSPAN=2>দায়েরকৃত মামলার সংখ্যা</td>
                            <td class="centertext" ROWSPAN=2>মোট মামলার সংখ্যা</td>
                            <td class="centertext" ROWSPAN=2>নিষ্পত্তিকৃত মামলার সংখ্যা</td>
                            <td class="centertext" ROWSPAN=2> অনিষ্পন্ন মামলার সংখ্যা</td>
                            <td class="centertext" style="width: 36%;" colspan="3">অনিষ্পন্ন মামলার সংখ্যা</td>
                            <td class="centertext" ROWSPAN=2>প্রমাপ(%)</td>
                            <td class="centertext" ROWSPAN=2>অর্জন(%)</td>
                        </tr>
                            <tr>
                                <td class="centertext" style="width: 9%">০১ বছরের ঊর্ধ্বে মামলা</td>
                                <td class="centertext" style="width: 9%">০২ বছরের ঊর্ধ্বে মামলা</td>
                                <td class="centertext" style="width: 9%">০৩ বছর বা তদূর্ধ্ব মামলা</td>
                            </tr>
                            <tbody>
                            <tr>

                                <td>{{ $item->pre_case_incomplete  }}</td>
                                <td>{{ $item->case_submit }}</td>
                                <td>{{ $item->case_total }}</td>
                                <td>{{ $item->case_complete}}</td>
                                <td>{{ $item->case_incomplete }}</td>
                                <td>{{ $item->case_above1year }}</td>
                                <td>{{ $item->case_above2year }}</td>
                                <td>{{ $item->case_above3year }}</td>
                                <td>{{ $item->promap }}</td>
                                <td>{{ $item->promap_achive }}</td>
                            </tr>
                            <tr>
                                @if($item->is_approved == 1)
                                    <td colspan="7"> প্রতিবেদনটি অনুমোদিত হয়েছে ।</td>
                                @elseif($item->is_approved == 2 )
                                    <td colspan="15"> প্রতিবেদনটি  সংশোধনের  জন্য  ফেরত  পাঠানো  হয়েছে ।</td>
                                @elseif($item->is_approved != 2)
                                    <td >
                                    {{-- link_to("monthly_report/approvedreport/" ~ item.id, '<i class="icon-pencil"></i> অনুমোদন', "class": "btn  btn-primary") --}}
                                        <a href="{{ route('m.approvedreport',$item->id) }}" class="btn  btn-primary"><i class="icon-pencil"></i>অনুমোদন</a>
                                    </td>
                                    <td>
                                        <button class="btn  btn-danger" title="এ সি জে এম  সংশোধন করুন" type="button" onclick="commentModalOpen(<?php echo  $item->id;?>)">সংশোধন</button>
                                    </td>
                                @endif
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
            @if ($item->report_type_id == 3)
            <div class="card panel-info-head">
                <div class="card-header">
                    <a class="card-title collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                        অতিরিক্ত জেলা ম্যাজিস্ট্রেট আদালতের  মামলার তথ্য
                    </a>

                </div>
                <div id="collapseThree" class="accordion-body collapse">
                    <div class="card-body cpv">
                        <table class="table table-bordered  table-info mb30" align="center">
                            <tr>
                                <td class="centertext" style="width: 6%" ROWSPAN=2>পুর্ববর্তী মাসের মামলার জের</td>
                                <td class="centertext" style="width: 6%" ROWSPAN=2>দায়েরকৃত মামলার সংখ্যা</td>
                                <td class="centertext" style="width: 6%" ROWSPAN=2>মোট মামলার সংখ্যা</td>
                                <td class="centertext" style="width: 6%" ROWSPAN=2>নিষ্পত্তিকৃত মামলার সংখ্যা</td>
                                <td class="centertext" style="width: 6%" ROWSPAN=2> অনিষ্পন্ন মামলার সংখ্যা</td>
                                <td class="centertext" style="width: 36%;" colspan="3">অনিষ্পন্ন মামলার সংখ্যা</td>
                                <td class="centertext" style="width: 3%" ROWSPAN=2>প্রমাপ</br>(%)</td>
                                <td class="centertext" style="width: 3%" ROWSPAN=2>অর্জন</br>(%)</td>
                            </tr>
                            <tr>
                                <td class="centertext" style="width: 9%">০১ বছরের ঊর্ধ্বে মামলা</td>
                                <td class="centertext" style="width: 9%">০২ বছরের ঊর্ধ্বে মামলা</td>
                                <td class="centertext" style="width: 9%">০৩ বছর বা তদূর্ধ্ব মামলা</td>
                            </tr>
                            <tbody>
                            <tr>
                                <td>{{ $item->pre_case_incomplete  }}</td>
                                <td>{{ $item->case_submit }}</td>
                                <td>{{ $item->case_total }}</td>
                                <td>{{ $item->case_complete}}</td>
                                <td>{{ $item->case_incomplete }}</td>
                                <td>{{ $item->case_above1year }}</td>
                                <td>{{ $item->case_above2year }}</td>
                                <td>{{ $item->case_above3year }}</td>
                                <td>{{ $item->promap }}</td>
                                <td>{{ $item->promap_achive }}</td>
                            </tr>
                            <tr>
                                @if($item->is_approved == 1)
                                    <td colspan="7"> প্রতিবেদনটি অনুমোদিত হয়েছে ।</td>
                                @elseif($item->is_approved == 2)
                                    <td colspan="15"> প্রতিবেদনটি  সংশোধনের  জন্য  ফেরত  পাঠানো  হয়েছে ।</td>
                                @elseif($item->is_approved != 2)
                                    <td >
                                        {{-- link_to("monthly_report/approvedreport/" ~ item.id, '<i class="icon-pencil"></i> অনুমোদন', "class": "btn  btn-primary") --}} 
                                       <a href="{{ route('m.approvedreport',$item->id) }}" class="btn  btn-primary"><i class="icon-pencil"></i>অনুমোদন</a>
                                    </td>
                                    <td>
                                        <button class="btn  btn-danger" title="এ সি জে এম  সংশোধন করুন" type="button" onclick="commentModalOpen(<?php echo $item->id ?>)">সংশোধন</button>
                                    </td>
                                @endif
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
            @if ($item->report_type_id == 4)
            <div class="card panel-info-head">
                <div class="card-header">

                    <a class="card-title collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
                        এক্সিকিউটিভ ম্যাজিস্ট্রেট আদালতের মামলার তথ্য
                    </a>

                </div>
                <div id="collapseFour" class="accordion-body collapse">
                    <table class="table table-bordered  table-info mb30" align="center">
                        <tr>
                            <td class="centertext" style="width: 6%" ROWSPAN=2>পুর্ববর্তী মাসের মামলার জের</td>
                            <td class="centertext" style="width: 6%" ROWSPAN=2>দায়েরকৃত মামলার সংখ্যা</td>
                            <td class="centertext" style="width: 6%" ROWSPAN=2>মোট মামলার সংখ্যা</td>
                            <td class="centertext" style="width: 6%" ROWSPAN=2>নিষ্পত্তিকৃত মামলার সংখ্যা</td>
                            <td class="centertext" style="width: 6%" ROWSPAN=2> অনিষ্পন্ন মামলার সংখ্যা</td>
                            <td class="centertext" style="width: 36%;" colspan="3">অনিষ্পন্ন মামলার সংখ্যা</td>
                            <td class="centertext" style="width: 3%" ROWSPAN=2>প্রমাপ</br>(%)</td>
                            <td class="centertext" style="width: 3%" ROWSPAN=2>অর্জন</br>(%)</td>
                        </tr>
                        <tr>
                            <td class="centertext" style="width: 9%">০১ বছরের ঊর্ধ্বে মামলা</td>
                            <td class="centertext" style="width: 9%">০২ বছরের ঊর্ধ্বে মামলা</td>
                            <td class="centertext" style="width: 9%">০৩ বছর বা তদূর্ধ্ব মামলা</td>
                        </tr>
                        <tbody>
                        <tr>
                            <td>{{ $item->pre_case_incomplete  }}</td>
                            <td>{{ $item->case_submit }}</td>
                            <td>{{ $item->case_total }}</td>
                            <td>{{ $item->case_complete}}</td>
                            <td>{{ $item->case_incomplete }}</td>
                            <td>{{ $item->case_above1year }}</td>
                            <td>{{ $item->case_above2year }}</td>
                            <td>{{ $item->case_above3year }}</td>
                            <td>{{ $item->promap }}</td>
                            <td>{{ $item->promap_achive }}</td>
                        </tr>
                        <tr>
                            @if($item->is_approved == 1)
                                <td colspan="7"> প্রতিবেদনটি অনুমোদিত হয়েছে ।</td>
                            @elseif( $item->is_approved == 2)
                                <td colspan="15"> প্রতিবেদনটি  সংশোধনের  জন্য  ফেরত  পাঠানো  হয়েছে ।</td>
                            @elseif($item->is_approved != 2 )
                                <td >
                                    {{-- link_to("monthly_report/approvedreport/" ~ $item->id, '<i class="icon-pencil"></i> অনুমোদন', "class": "btn  btn-primary") --}}
                                    <a href="{{ route('m.approvedreport',$item->id) }}" class="btn  btn-primary"><i class="icon-pencil"></i>অনুমোদন</a>
                                </td>
                                <td>
                                    <button class="btn  btn-danger" title="এ সি জে এম  সংশোধন করুন" type="button" onclick="commentModalOpen(<?php echo $item->id;?>)">সংশোধন</button>
                                </td>
                             @endif
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
         
            @if ($item->report_type_id == 5)
            <div class="card panel-info-head">
                <div class="card-header">

                    <a class="card-title collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFive">
                        এক্সিকিউটিভ ম্যাজিস্ট্রেটের আদালত পরিদর্শন
                    </a>

                </div>
                <div id="collapseFive" class="accordion-body collapse">
                    <div class="card-body cpv">
                        <table class="table table-bordered  table-info mb30" align="center">
                            <tr>
                                <td class="centertext" style="width: 15%">পরিদর্শন প্রমাপ</td>
                                <td class="centertext" style="width: 15%">পরিদর্শন সংখ্যা</td>
                                <td class="centertext" style="width: 40%">প্রমাপ অর্জন</td>
                            </tr>
                            <tbody>
                            <tr>
                                <td>{{ $item->visit_promap  }}</td>
                                <td>{{ $item->visit_count }}</td>
                                <td>{{ $item->comment1}}</td>
                            </tr>
                            <tr>
                                @if($item->is_approved == 1)
                                    <td colspan="7"> প্রতিবেদনটি অনুমোদিত হয়েছে ।</td>
                                @elseif($item->is_approved != 2)
                                    <td >
                                         {{-- link_to("monthly_report/approvedreport/" ~ $item->.id, '<i class="icon-pencil"></i> অনুমোদন', "class": "btn  btn-primary") --}}
                                        <a href="{{ route('m.approvedreport',$item->id) }}" class="btn  btn-primary"><i class="icon-pencil"></i>অনুমোদন</a>
                                    </td>
                                    <td>
                                        <button class="btn  btn-danger" title="এ সি জে এম  সংশোধন করুন" type="button" onclick="commentModalOpen(<?php echo $item->id;?>)">সংশোধন</button>
                                    </td>
                                 @endif
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
           
            @if ($item->report_type_id == 6)
            <div class="card panel-info-head">
                <div class="card-header">

                    <a class="card-title collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseSix">
                         মোবাইল কোর্ট কেস রেকর্ড পর্যালোচনা
                    </a>

                </div>
                <div id="collapseSix" class="accordion-body collapse">
                    <div class="card-body cpv">
                        <table class="table table-bordered  table-info mb30" align="center">
                            <tr>
                                <td class="centertext" style="width: 15%"> কেস রেকর্ড পর্যালোচনা প্রমাপ</td>
                                <td class="centertext" style="width: 15%">কেস রেকর্ড পর্যালোচনা সংখ্যা</td>
                                <td class="centertext" style="width: 40%">প্রমাপ অর্জন</td>
                            </tr>
                            <tbody>
                            <tr>
                                <td>{{ $item->caserecord_promap  }}</td>
                                <td>{{ $item->caserecord_count }}</td>
                                <td>{{ $item->comment1 }}</td>
                            </tr>
                            <tr>
                                @if($item->is_approved == 1)
                                    <td colspan="7"> প্রতিবেদনটি অনুমোদিত হয়েছে ।</td>
                                @elseif($item->is_approved == 2)
                                    <td colspan="15"> প্রতিবেদনটি  সংশোধনের  জন্য  ফেরত  পাঠানো  হয়েছে ।</td>
                                @elseif($item->is_approved != 2)
                                    <td >
                                    <a href="{{ route('m.approvedreport',$item->id) }}" class="btn  btn-primary"><i class="icon-pencil"></i>অনুমোদন</a>
                                        {{-- link_to("monthly_report/approvedreport/" ~ $item->id, '<i class="icon-pencil"></i> অনুমোদন', "class": "btn  btn-primary") --}} 
                                    </td>
                                    <td>
                                        <button class="btn  btn-danger" title="এ সি জে এম  সংশোধন করুন" type="button" onclick="commentModalOpen(<?php echo $item->id;?>)">সংশোধন</button>
                                    </td>
                                @endif
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

        </div>
        @endforeach

    </div>
    <div class="card-footer">
        
    </div>
</div>
<div class="modal fade" style="padding-top: 10%;border: black" id="loadingModal" data-focus="true" data-keyboard="false" data-backdrop="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">অবহিতকরন বার্তা</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <img src="images/loading.gif">
                            দয়া করে কিছুক্ষণ অপেক্ষা করুন
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">মন্তব্য লিখুন</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden"  id="reportId" value=""/>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label"><span style="color:#FF0000">*</span>মন্তব্য</label>
                            <textarea class="input form-control"  required rows="5" id="comment_from_adm">এ সি জে এম প্রতিবেদন সংশোধন পূর্বক পুনরায় দাখিল করুন । </textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"> বাতিল</button>
                <button type="button" onclick="reportCancel()" class="btn btn-primary"> সংরক্ষণ</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')

<script>
    function commentModalOpen(id) {
        $('#reportId').val(id);
        $('#exampleModal').modal('show')
    }
    function reportCancel() {
        $('#exampleModal').modal('hide');
        // $('#loadingModal').modal('show');
        var model = {};
        model.comment_from_adm = $('#comment_from_adm').val();
        model.reportId = $('#reportId').val();
        var url = "/monthly_report/cancelReport";

        Swal.fire({
            title: "সংশোধনের জন্য প্রেরণ করতে চান",
            text: "আপনি কি এ ব্যাপারে নিশ্চিত ?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            cancelButtonText: "না",
            confirmButtonText: "হ্যাঁ"
          }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'json',
                    data: {'data': model},
                    success: function (result) {
                        $('#loadingModal').modal('hide');
                        if (result.flag == 'true') {
                        Swal.fire({
                            title:'প্রতিবেদনটি সফলভাবে সংশোধনের জন্য ফেরত পাঠানো হয়েছে।',
                            text: "ধন্যবাদ",
                            icon: "success",
                            showCancelButton: false,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            cancelButtonText: "না",
                            confirmButtonText: "বন্ধ করুন"
                          }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload();  // This reloads the page when "বন্ধ করুন" is clicked
                                }
                           });
                     
                        }
                    },
                    error: function (request, status, error) {
                        alert("সাময়িক ত্রুটি", "অবহতিকরণ বার্তা");

                    }
                });
            }
        }); 
        // $.ajax({
        //     url: url,
        //     type: 'POST',
        //     dataType: 'json',
        //     data: {'data': model},
        //     success: function (data) {
        //         $('#loadingModal').modal('hide');
        //         if (data.flag == 'true') {
                 
        //             $.confirm({
        //                 resizable: false,
        //                 height: 200,
        //                 width: 600,
        //                 modal: true,
        //                 title: "ধন্যবাদ",
        //                 titleClass: "modal-header",
        //                 content: " প্রতিবেদনটি সফলভাবে সংশোধনের জন্য ফেরত পাঠানো হয়েছে।",
        //                 buttons: {
        //                     "বন্ধ করুন": function () {
        //                         window.location.reload();
        //                     }
        //                 }
        //             });

        //         }
        //     },
        //     error: function (jqXHR, textStatus, errorThrown) {
        //         $.alert("সাময়িক ত্রুটি", "অবহতিকরণ বার্তা");
        //     }
        // });
    }
</script>
@endsection



