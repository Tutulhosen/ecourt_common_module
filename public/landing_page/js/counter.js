function animation() {
    return {
      counter: '০', // Initial counter set to Bengali '0'
      animate(finalCount) {
        const banglaDigits = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯']; // Array for Bengali digits
        
        let time = 1500; // Time in milliseconds
        let interval = 9;
        let step = Math.floor(finalCount * interval / time);
        let currentCount = 0;
  
        let timer = setInterval(() => {
          currentCount += step;
  
          // Convert the current count to Bengali digits
          this.counter = this.convertToBangla(currentCount);
  
          if (currentCount >= finalCount) {
            this.counter = this.convertToBangla(finalCount); // Set the final count
            clearInterval(timer);
            timer = null;
          }
        }, interval);
      },
  
      // Convert number to Bengali digits
      convertToBangla(number) {
        let banglaNumber = '';
        const banglaDigits = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
        
        number.toString().split('').forEach(digit => {
          banglaNumber += banglaDigits[parseInt(digit)];
        });
        
        return banglaNumber;
      }
    };
  }
  
  console.log(window.scrollY)