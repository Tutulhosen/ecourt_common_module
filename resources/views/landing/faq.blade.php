<section class="">
    <div class="w-full grid grid-cols-1 my-auto mb-8 md:grid-cols-2 xl:gap-14 md:gap-5">
        <div class="px-16" x-data="{ activeIndex: 0 }">
            <h3 class="text-center">সাধারণ জিজ্ঞাসাসমূহ</h3>

            <!-- First FAQ -->
            <div style="box-shadow: 4px 4px 6px rgba(0, 0, 0, 0.15), -4px -4px 6px rgba(0, 0, 0, 0.15);"
                class="mt-5" >
                <h2>
                    <button type="button"
                        class="flex items-center justify-between w-full text-md py-2 px-5"
                        @click="activeIndex = activeIndex === 0 ? null : 0" :aria-expanded="activeIndex === 0"
                        aria-controls="faq-text-0"
                        :class="activeIndex === 0 ? 'bg-[#008841] text-white' : 'bg-white'"
                        >
                        <span>রেজিস্ট্রেশন ব্যতীত সেবার আবেদন করা যাবে কি না?</span>
                        <svg class="fill-current shrink-0 ml-8" width="16" height="16" xmlns="http://www.w3.org/2000/svg">
                            <rect y="7" width="16" height="2" rx="1"
                                class="transform origin-center transition duration-200 ease-out"
                                :class="{ '!rotate-180': activeIndex === 0 }" />
                            <rect y="7" width="16" height="2" rx="1"
                                class="transform origin-center rotate-90 transition duration-200 ease-out"
                                :class="{ '!rotate-180': activeIndex === 0 }" />
                        </svg>
                    </button>
                </h2>
                <div id="faq-text-0" role="region" aria-labelledby="faq-title-0"
                    class="grid text-sm text-slate-600 overflow-hidden transition-all duration-300 ease-in-out"
                    :class="activeIndex === 0 ? 'grid-rows-[1fr] opacity-100' : 'grid-rows-[0fr] opacity-0'">
                    <div class="overflow-hidden">
                        <p class="p-3 text-justify px-5">
                            বিচারপ্রার্থীদের হাতের মুঠোয় সকল মামলার তথ্য প্রদানের লক্ষ্য নিয়ে স্মার্ট বিচার বিভাগ গঠনের প্রত্যয়ে ই-কার্যতালিকা প্রস্তুত করা হয়েছে। স্বচ্ছ, জবাবদিহিমূলক, উদ্ভাবনী ও জনমুখী বিচার বিভাগ প্রতিষ্ঠা এবং নাগরিকের অধিকার নিশ্চিতের লক্ষ্যে আইন ও বিচার বিভাগ এবং এটুআই প্রোগ্রামের নেতৃত্ব ও তত্বাবধায়নে এই ই-কার্যতালিকা প্রস্তুত করা হয়েছে।
                        </p>
                    </div>
                </div>
            </div>

            <!-- Second FAQ -->
            <div style="box-shadow: 4px 4px 6px rgba(0, 0, 0, 0.15), -4px -4px 6px rgba(0, 0, 0, 0.15);"
                class="mt-1" >
                <h2>
                    <button type="button"
                        class="flex items-center justify-between w-full text-md py-2 px-5"
                        @click="activeIndex = activeIndex === 1 ? null : 1" :aria-expanded="activeIndex === 1"
                        aria-controls="faq-text-1"
                        :class="activeIndex === 1 ? 'bg-[#008841] text-white' : 'bg-white'"
                        >
                        <span>অনলাইনে মামলার দেয়া হলে কি তা সংশ্লিষ্ট কোর্ট অন্তর্ভুক্ত হবে?</span>
                        <svg class="fill-current shrink-0 ml-8" width="16" height="16" xmlns="http://www.w3.org/2000/svg">
                            <rect y="7" width="16" height="2" rx="1"
                                class="transform origin-center transition duration-200 ease-out"
                                :class="{ '!rotate-180': activeIndex === 1 }" />
                            <rect y="7" width="16" height="2" rx="1"
                                class="transform origin-center rotate-90 transition duration-200 ease-out"
                                :class="{ '!rotate-180': activeIndex === 1 }" />
                        </svg>
                    </button>
                </h2>
                <div id="faq-text-1" role="region" aria-labelledby="faq-title-1"
                    class="grid text-sm text-slate-600 overflow-hidden transition-all duration-300 ease-in-out"
                    :class="activeIndex === 1 ? 'grid-rows-[1fr] opacity-100' : 'grid-rows-[0fr] opacity-0'">
                    <div class="overflow-hidden">
                        <p class="p-3 text-justify px-5">
                            বিচারপ্রার্থীদের হাতের মুঠোয় সকল মামলার তথ্য প্রদানের লক্ষ্য নিয়ে স্মার্ট বিচার বিভাগ গঠনের প্রত্যয়ে ই-কার্যতালিকা প্রস্তুত করা হয়েছে। স্বচ্ছ, জবাবদিহিমূলক, উদ্ভাবনী ও জনমুখী বিচার বিভাগ প্রতিষ্ঠা এবং নাগরিকের অধিকার নিশ্চিতের লক্ষ্যে আইন ও বিচার বিভাগ এবং এটুআই প্রোগ্রামের নেতৃত্ব ও তত্বাবধায়নে এই ই-কার্যতালিকা প্রস্তুত করা হয়েছে।
                        </p>
                    </div>
                </div>
            </div>
            <div style="box-shadow: 4px 4px 6px rgba(0, 0, 0, 0.15), -4px -4px 6px rgba(0, 0, 0, 0.15);"
                class="mt-1" >
                <h2>
                    <button type="button"
                        class="flex items-center justify-between w-full text-md py-2 px-5"
                        @click="activeIndex = activeIndex === 2 ? null : 2" :aria-expanded="activeIndex === 2"
                        aria-controls="faq-text-1"
                        :class="activeIndex === 2 ? 'bg-[#008841] text-white' : 'bg-white'"
                        >
                        <span>প্রোফাইল থেকে কী সুবিধা পাওয়া যাবে?</span>
                        <svg class="fill-current shrink-0 ml-8" width="16" height="16" xmlns="http://www.w3.org/2000/svg">
                            <rect y="7" width="16" height="2" rx="1"
                                class="transform origin-center transition duration-200 ease-out"
                                :class="{ '!rotate-180': activeIndex === 2 }" />
                            <rect y="7" width="16" height="2" rx="1"
                                class="transform origin-center rotate-90 transition duration-200 ease-out"
                                :class="{ '!rotate-180': activeIndex === 2 }" />
                        </svg>
                    </button>
                </h2>
                <div id="faq-text-1" role="region" aria-labelledby="faq-title-1"
                    class="grid text-sm text-slate-600 overflow-hidden transition-all duration-300 ease-in-out"
                    :class="activeIndex === 2 ? 'grid-rows-[1fr] opacity-100' : 'grid-rows-[0fr] opacity-0'">
                    <div class="overflow-hidden">
                        <p class="p-3 text-justify px-5">
                            বিচারপ্রার্থীদের হাতের মুঠোয় সকল মামলার তথ্য প্রদানের লক্ষ্য নিয়ে স্মার্ট বিচার বিভাগ গঠনের প্রত্যয়ে ই-কার্যতালিকা প্রস্তুত করা হয়েছে। স্বচ্ছ, জবাবদিহিমূলক, উদ্ভাবনী ও জনমুখী বিচার বিভাগ প্রতিষ্ঠা এবং নাগরিকের অধিকার নিশ্চিতের লক্ষ্যে আইন ও বিচার বিভাগ এবং এটুআই প্রোগ্রামের নেতৃত্ব ও তত্বাবধায়নে এই ই-কার্যতালিকা প্রস্তুত করা হয়েছে।
                        </p>
                    </div>
                </div>
            </div>
            <div style="box-shadow: 4px 4px 6px rgba(0, 0, 0, 0.15), -4px -4px 6px rgba(0, 0, 0, 0.15);"
                class="mt-1" >
                <h2>
                    <button type="button"
                        class="flex items-center justify-between w-full text-md py-2 px-5"
                        @click="activeIndex = activeIndex === 3 ? null : 3" :aria-expanded="activeIndex === 3"
                        aria-controls="faq-text-1"
                        :class="activeIndex === 3 ? 'bg-[#008841] text-white' : 'bg-white'"
                        >
                        <span>অনলাইনে মামলার দেয়া হলে কি তা সংশ্লিষ্ট কোর্ট অন্তর্ভুক্ত হবে?</span>
                        <svg class="fill-current shrink-0 ml-8" width="16" height="16" xmlns="http://www.w3.org/2000/svg">
                            <rect y="7" width="16" height="2" rx="1"
                                class="transform origin-center transition duration-200 ease-out"
                                :class="{ '!rotate-180': activeIndex === 3 }" />
                            <rect y="7" width="16" height="2" rx="1"
                                class="transform origin-center rotate-90 transition duration-200 ease-out"
                                :class="{ '!rotate-180': activeIndex === 3 }" />
                        </svg>
                    </button>
                </h2>
                <div id="faq-text-1" role="region" aria-labelledby="faq-title-1"
                    class="grid text-sm text-slate-600 overflow-hidden transition-all duration-300 ease-in-out"
                    :class="activeIndex === 3 ? 'grid-rows-[1fr] opacity-100' : 'grid-rows-[0fr] opacity-0'">
                    <div class="overflow-hidden">
                        <p class="p-3 text-justify px-5">
                            বিচারপ্রার্থীদের হাতের মুঠোয় সকল মামলার তথ্য প্রদানের লক্ষ্য নিয়ে স্মার্ট বিচার বিভাগ গঠনের প্রত্যয়ে ই-কার্যতালিকা প্রস্তুত করা হয়েছে। স্বচ্ছ, জবাবদিহিমূলক, উদ্ভাবনী ও জনমুখী বিচার বিভাগ প্রতিষ্ঠা এবং নাগরিকের অধিকার নিশ্চিতের লক্ষ্যে আইন ও বিচার বিভাগ এবং এটুআই প্রোগ্রামের নেতৃত্ব ও তত্বাবধায়নে এই ই-কার্যতালিকা প্রস্তুত করা হয়েছে।
                        </p>
                    </div>
                </div>
            </div>

            <!-- Add additional FAQs as needed, following the same pattern -->
        </div>

        <div class="w-full h-[85%] flex justify-center items-center mt-4">
            <img class="max-w-full max-h-full object-contain" src="{{ asset('landing_page/images/faq/one.png') }}"
                alt="header image">
        </div>
    </div>
</section>
