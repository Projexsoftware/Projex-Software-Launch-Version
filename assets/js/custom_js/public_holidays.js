 $.validator.addMethod('uniqueTitle', function(value) {
			
         var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'scheduling/public_holidays/verify_public_holiday',
                type: 'post',
			    data:{title: value},
	}); 

    if(result.responseText == '0') return true; else return false;

    } , "Public Holiday already exists");
	
	$.validator.addMethod('uniqueEditTitle', function(value) {
	    var id = $('#public_holiday_id').val();		
        var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'scheduling/public_holidays/verify_public_holiday',
                type: 'post',
			    data:{title: value, id:id},
	  }); 

         if(result.responseText == '0') return true; else return false;

             } , "Public Holiday already exists");


    $(document).ready(function() {
        setFormValidation('#PublicHolidayForm');
    });