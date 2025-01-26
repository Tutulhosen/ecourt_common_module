<section>
    <h4 class="px-5 text-3xl text-center " style="color: #0BA14A">ডিজিটাল ই- কোর্টে আপনাকে স্বাগতম</h4>
    <div class="flex flex-col md:flex-row justify-evenly gap-5 space-y-4 md:space-y-0 my-6">

        <a href="{{ route('cause_list') }}"
            class="h4 text-center text-dark hover:text-[#0BA14A] font-weight-bold font-size-h4 mb-3">
            <div style="height: 200px; width: 200px; box-shadow: 0 4px 6px rgba(11, 161, 74, 0.3);"
                class="flex flex-col items-center justify-center border border-gray-200 rounded transform transition-transform duration-300 hover:scale-105 hover:bg-gray-100">
                <img height="100" width="100" src="{{ asset('landing_page/images/digital/one.png') }}" />
                <span class="mt-2">কজ লিস্ট</span>
            </div>
        </a>

        <a href="{{ route('investigator.verify') }}" class="hover:text-[#0BA14A]">
            <div style="height: 200px; width: 200px; box-shadow: 0 4px 6px rgba(11, 161, 74, 0.3);"
                class="flex flex-col items-center justify-center border border-gray-200 rounded transform transition-transform duration-300 hover:scale-105 hover:bg-gray-100">
                <img height="150" width="150" src="{{ asset('landing_page/images/digital/two.png') }}" />
                <span>তদন্ত প্রতিবেদন</span>
            </div>
        </a>
      

       {{--  <a href="" class="hover:text-[#0BA14A]">
            <div style="height: 200px; width: 200px; box-shadow: 0 4px 6px rgba(11, 161, 74, 0.3);"
                class="flex hover:text-[#0BA14A] flex-col items-center justify-center border border-gray-200 rounded transform transition-transform duration-300 hover:scale-105 hover:bg-gray-100">
                <img height="140" width="140" src="https://emctraining.ecourt.gov.bd/images/support.png" />
                <span class="mt-2">সাপোর্ট সেন্টার</span>
            </div>
        </a>
 --}}
        <a href="{{ URL('https://www.youtube.com/channel/UCfN6060uxEIITJVH-dnsb9A') }}" class="hover:text-[#0BA14A]"
            target="_blank">
            <div style="height: 200px; width: 200px; box-shadow: 0 4px 6px rgba(11, 161, 74, 0.3);"
                class="flex hover:text-[#0BA14A] flex-col items-center justify-center border border-gray-200 rounded transform transition-transform duration-300 hover:scale-105 hover:bg-gray-100">
                <img height="130" width="130" src="{{ asset('landing_page/images/digital/four.png') }}" />
                <span class="mt-3">টিউটিরিয়াল</span>
            </div>
        </a>
        <a href="{{ route('support.center') }}" class="hover:text-[#0BA14A]">
            <div style="height: 200px; width: 200px; box-shadow: 0 4px 6px rgba(11, 161, 74, 0.3);"
                class="flex flex-col items-center justify-center border border-gray-200 rounded transform transition-transform duration-300 hover:scale-105 hover:bg-gray-100">
                <img height="100" width="100" src="{{asset('images/support.png')}}" />
                <span class="mt-1">সাপোর্ট সেন্টার</span>
            </div>
        </a>
    </div>
</section>
