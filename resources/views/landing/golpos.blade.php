<section>
    <h4 class="px-5 py-7 text-2xl text-center font-semibold" style="color: #1E433D">সাম্প্রতিক আপডেট</h4>
    <div class="container my-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mx-auto w-full">
        <!-- Iterate through the first three items in the data array and generate a card for each item -->


        @foreach ($sottogolpos->take(3) as $item)
            <div class="w-full border">
                <!-- Show image if it exists -->
                {{-- <img src="{{ asset('images/book.png') }}" alt="Girl in a jacket" width="100%" height="250">
     --}}

                @if (!empty($item->story_pic))
                    <img src="{{ asset('mobile_court/uploads/golpo/' . $item->story_pic) }}" alt="Story Image"
                        width="50" height="50">
                @else
                <img src="{{ asset('images/book.png') }}" alt="Girl in a jacket" width="100%" height="250">
                @endif
                <div class="p-4">
                    <div class="text-md mb-2 flex items-center gap-3">
                        <p>
                            <svg width="20" height="21" viewBox="0 0 20 21" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10 0.8125C4.64844 0.8125 0.3125 5.14844 0.3125 10.5C0.3125 15.8516 4.64844 20.1875 10 20.1875C15.3516 20.1875 19.6875 15.8516 19.6875 10.5C19.6875 5.14844 15.3516 0.8125 10 0.8125ZM10 18.3125C5.68359 18.3125 2.1875 14.8164 2.1875 10.5C2.1875 6.18359 5.68359 2.6875 10 2.6875C14.3164 2.6875 17.8125 6.18359 17.8125 10.5C17.8125 14.8164 14.3164 18.3125 10 18.3125ZM12.4141 14.2344L9.09766 11.8242C8.97656 11.7344 8.90625 11.5938 8.90625 11.4453V5.03125C8.90625 4.77344 9.11719 4.5625 9.375 4.5625H10.625C10.8828 4.5625 11.0938 4.77344 11.0938 5.03125V10.5664L13.7031 12.4648C13.9141 12.6172 13.957 12.9102 13.8047 13.1211L13.0703 14.1328C12.918 14.3398 12.625 14.3867 12.4141 14.2344Z"
                                    fill="#198754" />
                            </svg>

                        </p>
                        <p>
                            {{ $item->created_date ?? 'No Date Available' }}
                        </p>

                    </div>
                    <!-- Details -->
                    <p class="text-sm text-gray-700 mb-4">
                        {{ \Illuminate\Support\Str::limit(strip_tags($item->details), 200) }}</p>

                    <!-- Date -->

                    <!-- Read More Button -->
                    <a href="{{ route('home.singleGolpo', ['id' => $item->id]) }}"
                        class="py-2 inline-block mt-4 rounded flex items-center gap-3">
                        <span class="text-[#008841] underline text-sm">সম্পূর্ণ পড়ুন</span>
                        <span>
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M10.5865 3.92175C10.2618 3.59713 9.73555 3.59713 9.41093 3.92175C9.08653 4.24615 9.08629 4.77205 9.41041 5.09675L13.4737 9.16732H4.16536C3.70513 9.16732 3.33203 9.54041 3.33203 10.0007C3.33203 10.4609 3.70513 10.834 4.16536 10.834H13.4737L9.41041 14.9046C9.08629 15.2293 9.08653 15.7551 9.41093 16.0796C9.73555 16.4042 10.2618 16.4042 10.5865 16.0796L16.6654 10.0007L10.5865 3.92175Z"
                                    fill="#198754" />
                                <mask id="mask0_1692_212" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="3"
                                    y="3" width="14" height="14">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M10.5865 3.92175C10.2618 3.59713 9.73555 3.59713 9.41093 3.92175C9.08653 4.24615 9.08629 4.77205 9.41041 5.09675L13.4737 9.16732H4.16536C3.70513 9.16732 3.33203 9.54041 3.33203 10.0007C3.33203 10.4609 3.70513 10.834 4.16536 10.834H13.4737L9.41041 14.9046C9.08629 15.2293 9.08653 15.7551 9.41093 16.0796C9.73555 16.4042 10.2618 16.4042 10.5865 16.0796L16.6654 10.0007L10.5865 3.92175Z"
                                        fill="white" />
                                </mask>
                                <g mask="url(#mask0_1692_212)">
                                    <rect width="20" height="20" fill="#198754" />
                                </g>
                            </svg>
                        </span>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
    <a href="{{ route('home.allGolpos') }}">
        <div class="text-center py-5">
            <button
                class="inline-flex justify-center items-center rounded-md border border-[#00984F] shadow-sm px-5 bg-[#00984F] text-sm font-medium text-white hover:bg-[#00984F] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-[#00984F] focus:ring-yellow-500 py-[6px] gap-3 ">

                <span>আরও</span>
            </button>
        </div>
    </a>
</section>
