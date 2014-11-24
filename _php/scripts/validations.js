//allow onlyNumbers
function allowOnlyNumbers(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57) || charCode ==13 || charCode == 8 || charCode == 127 )
            return false;

         return true;
      }
	  
//allow alphabets
function allowOnlyAlpha(evt)
      {
      	 var charCode = (evt.which) ? evt.which : event.keyCode
         if ((charCode >= 65 && charCode <= 95 ) || (charCode >= 97 && charCode <= 122 ) || charCode == 32 || charCode == 13 || charCode ==8 || charCode == 127)
            return true;
		
		return false;
      }
//allow alphabets and numbers
function allowOnlyAlphaNumeric(evt)
      {
      	 var charCode = (evt.which) ? evt.which : event.keyCode
         if ((charCode >= 65 && charCode <= 95 ) || (charCode >= 97 && charCode <= 122 )|| (charCode >= 48 && charCode <= 57) || charCode == 32 || charCode == 13 || charCode == 8 || charCode == 127)
            return true;
		
		return false;
      }

