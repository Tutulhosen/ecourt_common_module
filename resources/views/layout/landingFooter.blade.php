<footer class="py-5 bg-gray-100">
    <div class="flex justify-center">
        <div class="grid md:grid-cols-4 gap-24">

            <!-- Important Information Section -->
            <div class="mt-5">
                <h3 class="mb-3 text-gray-800">গুরুত্বপূর্ণ তথ্য</h3>
                <div class="flex items-center mb-2">
                    <div class="w-6 h-6 bg-gray-200 flex justify-center items-center rounded-full mr-4">
                        <i class="fa-regular fa-list-alt text-[#8950fc]"></i>
                    </div>
                    <a href="#" class="hover:text-blue-500 text-sm">গোপনীয়তার নীতিমালা</a>
                </div>
            </div>

            <!-- Important Links Section -->
            <div class="mt-5">
                <h3 class="text-gray-800 mb-3">গুরুত্বপূর্ণ লিঙ্ক</h3>
                <div class="flex items-center mb-2">
                    <div class="w-5 h-5 bg-gray-200 flex justify-center items-center rounded-full mr-4">
                        <img src="{{ asset('images/bd_gov.png') }}" class="h-full" alt="">
                    </div>
                    <a href="https://bangladesh.gov.bd/index.php" target="_blank" class=" text-gray-700 hover:text-blue-500 text-sm">জাতীয় তথ্য বাতায়ন</a>
                </div>
                <div class="flex items-center mb-2">
                    <div class="w-5 h-5 bg-gray-200 flex justify-center items-center rounded-full mr-4">
                        <img src="{{ asset('images/bd_gov.png') }}" class="h-full" alt="">
                    </div>
                    <a href="http://www.cabinet.gov.bd/" target="_blank" class=" text-gray-700 hover:text-blue-500 text-sm">মন্ত্রিপরিষদ বিভাগ</a>
                </div>
                <div class="flex items-center mb-2">
                    <div class="w-5 h-5 bg-gray-200 flex justify-center items-center rounded-full mr-4">
                        <img src="{{ asset('images/a2ilogo-final.png') }}" class="h-full" alt="">
                    </div>
                    <a href="https://a2i.gov.bd/" target="_blank" class=" text-gray-700 hover:text-blue-500 text-sm">এটুআই</a>
                </div>
            </div>

            <!-- Social Media Section -->
            <div class="mt-5">
                <h3 class="text-gray-800 mb-3">সামাজিক যোগাযোগ</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <div class="flex items-center mb-2">
                            <div class="w-6 h-6 bg-gray-200 flex justify-center items-center rounded-full mr-4">
                                <i class="fab fa-facebook text-[#8950fc]" ></i>
                            </div>
                            <a href="https://www.facebook.com/Ecourtbd" target="_blank" class=" text-gray-700 hover:text-blue-500 text-sm">ফেসবুক</a>
                        </div>
                        <div class="flex items-center mb-2">
                            <div class="w-6 h-6 bg-gray-200 flex justify-center items-center rounded-full mr-4">
                                <i class="fab fa-youtube text-[#8950fc]" ></i>
                            </div>
                            <a href="https://youtube.com/channel/UCfN6060uxEIITJVH-dnsb9A" target="_blank" class=" text-gray-700 hover:text-red-500 text-sm">ইউটিউব</a>
                        </div>
                        <div class="flex items-center mb-2">
                            <div class="w-6 h-6 bg-gray-200 flex justify-center items-center rounded-full mr-4">
                                <i class="fas fa-envelope text-[#8950fc]" ></i>
                            </div>
                            <a href="mailto:a2iecourt@gmail.com" target="_blank" class=" text-gray-700 hover:text-blue-500 text-sm">ইমেইল</a>
                        </div>
                        <div class="flex items-center mb-2">
                            <div class="w-6 h-6 bg-gray-200 flex justify-center items-center rounded-full mr-4">
                                <i class="fab fa-twitter text-[#8950fc]" ></i>
                            </div>
                            <a href="https://twitter.com/ecourtbd" target="_blank" class=" text-gray-700 hover:text-blue-500 text-sm">টুইটার</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Partners Section -->
            <div class="mt-5">
                <h3 class="text-gray-800 mb-3">পরিকল্পনা ও বাস্তবায়নে</h3>
                <div class="flex items-center mb-5">
                    <a href="https://a2i.gov.bd/" target="_blank" class="mr-5"><img src="{{ asset('images/a2i.png') }}" class="w-12" alt=""></a>
                    <a href="https://www.mygov.bd/" target="_blank"><img src="{{ asset('images/bd_gov.png') }}" class="w-11" alt=""></a>
                </div>
                <h3 class="text-gray-800 mb-3">কারিগরি সহায়তায়</h3>
                <div class="flex items-center">
                    <a href="https://mysoftheaven.com/" target="_blank"><img src="{{ asset('assets/images/auto.png') }}" class="w-32" alt=""></a>
                </div>
            </div>

        </div>
    </div>
</footer>

<!-- Copyright Section -->
<div class="py-2 flex justify-center">
    <div class="container mx-auto text-center">
        <p class="text-md">Copyright © {{ date('Y', strtotime(now())) }} All Rights Reserved To
            <a href="https://a2i.gov.bd" target="_blank" class="text-blue-500 hover:underline">a2i</a>,
            Government of the People's Republic of Bangladesh
        </p>
    </div>
</div>
