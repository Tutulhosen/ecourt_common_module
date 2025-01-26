<section id="case-count-section" class="container w-full mx-auto">
    <div class="antialiased flex py-5 justify-evenly space-x-16 items-center text-center text-white bg-[#0DA047]">
        <!-- Mobile Court Total Cases -->
        <div class="flex items-center justify-center gap-3">
            <div>
                <p class="text-sm">মোবাইল কোর্টে মোট মামলার সংখ্যা</p>
                <span class="text-2xl font-bold text-white" 
                      x-data="animation('{{ $mc_total_cases }}')" 
                      x-init="initializeAnimation()"
                      x-text="counter">
                    ০
                </span>
            </div>
        </div>

        <!-- General Certificate Court Total Cases -->
        <div class="flex items-center justify-center gap-3">
            <div>
                <p class="text-sm">জেনারেল সার্টিফিকেট কোর্টে মোট মামলার সংখ্যা</p>
                <span class="text-2xl font-bold text-white" 
                      x-data="animation('{{ $gcc_total_cases }}')" 
                      x-init="initializeAnimation()"
                      x-text="counter">
                    ০
                </span>
            </div>
        </div>

        <!-- Executive Magistrate Court Total Cases -->
        <div class="flex items-center justify-center gap-3">
            <div>
                <p class="text-sm">এক্সিকিউটিভ ম্যাজিস্ট্রেট কোর্টে মোট মামলার সংখ্যা</p>
                <span class="text-2xl font-bold text-white" 
                      x-data="animation('{{ $emc_total_cases }}')" 
                      x-init="initializeAnimation()"
                      x-text="counter">
                    ০
                </span>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('animation', (finalValue) => ({
            counter: '০',
            isAnimated: false,
            initializeAnimation() {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting && !this.isAnimated) {
                            this.animate();
                            this.isAnimated = true; 
                        }
                    });
                });

                // Observe the parent section
                observer.observe(document.getElementById('case-count-section'));
            },
            animate() {
                const duration = 2000; 
                const frameDuration = 16; 
                const totalFrames = duration / frameDuration; 

                const banglaNumbers = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
                const englishToBangla = (num) => num.toString().split('').map(n => banglaNumbers[n]).join('');

                const increment = Math.ceil(finalValue / totalFrames); 
                let currentValue = 0;

                const interval = setInterval(() => {
                    currentValue = Math.min(currentValue + increment, finalValue);
                    this.counter = englishToBangla(currentValue);
                    if (currentValue >= finalValue) {
                        clearInterval(interval);
                    }
                }, frameDuration);
            }
        }));
    });
</script>
