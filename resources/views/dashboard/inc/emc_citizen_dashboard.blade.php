
<div id="emcDashboard" class="citizen_dashboard" style="display:none;">
    <h4 class="dashboard_title">এক্সিকিউটিভ ম্যাজিস্ট্রেট কোর্ট ড্যাশবোর্ড</h4>
    @include('dashboard.inc.user_icon_card')
    {{-- @include('dashboard.inc.user_appeal_icon_card') --}}
    @if (!empty($payment_notice->appeal_id_array))
        <div class="row">

                <div class="col-xl-8">
                
                        <div class="">
                            <div class="toast-header py-3">
                                <i class="text-primary icon fas fas fa-bell m"></i>
                                <strong class="ml-2 mr-auto">পদক্ষেপ নিতে হবে এমন মামলাসমূহ</strong>
                                @if(!empty($payment_notice->total_count))
                                <span class="badge badge-danger">{{$payment_notice->total_count}}</span>
                                @else
                                <span class="badge badge-danger">0</span>
                                @endif
                            </div>
                            <?php 
                            // dd($payment_notice->appeal_id_array);
                            ?>
                            <a href="{{ route('paynotice', ['payment_notice' => !empty($payment_notice->appeal_id_array) ? $payment_notice->appeal_id_array : '']) }}">
                                <div class="toast-body bg-light">
                                    আপনার প্রসেস ফি প্রদান করুন
                                    <span class="badge badge-danger ml-5">{{ (!empty($payment_notice->total_count) ? $payment_notice->total_count : 0) }}</span>
                                </div>
                            </a>

                        
                        </div>
                
                </div>
                
        </div>
    @endif
    @include('dashboard.inc.cause_list.citizen_cause_list')
</div>