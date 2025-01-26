function toBangla (str)
{
    //check if the `str` is not string
    if(!isNaN(str)){
        //if not string make it string forcefully
        str = String(str);
    }

    //start try catch block
    try {
        //keep the bangla numbers to an array
        var convert = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];
        //now split the provided string into array by each character
        var splitArray = str.split("");
        //declare a empty string
        var newString = "";
        //run a loop upto the length of the string array
        for (i = 0; i < splitArray.length; i++) {

            //check if current array element if not number
            if(isNaN(splitArray [i])){
                //if not number then place it as it is
                newString += splitArray [i];
            }else{
                //if number then get same numbered element from the bangla array
                newString += convert[splitArray [i]];
            }
        }
        //return the newly converted number
        return newString;
    }
    catch(err) {
        //if any error occured while convertion return the original string
        return str;
    }
    //by default return original number/string
    return str;
}