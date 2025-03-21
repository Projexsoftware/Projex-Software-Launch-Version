 $.validator.addMethod('uniqueEmail', function(value) {
	 var task_id = $('#task_id').val();			
         var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'scheduling/reminder_users/verify_email',
                type: 'post',
			    data:{email: value, task_id:task_id},
	}); 

    if(result.responseText == '0') return true; else return false;

    } , "Please enter a unique reminder email");
	
	$.validator.addMethod('uniqueEditEmail', function(value) {
	    var id = $('#reminder_id').val();	
            var task_id = $('#task_id').val();	
            var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'scheduling/reminder_users/verify_email',
                type: 'post',
			    data:{email: value, id:id, task_id:task_id},
	  }); 

         if(result.responseText == '0') return true; else return false;

             } , "Please enter a unique reminder email");


    $(document).ready(function() {
        setFormValidation('#ReminderForm');
    });