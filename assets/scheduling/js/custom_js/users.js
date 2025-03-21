 $.validator.addMethod('uniqueEmail', function(value) {
			
         var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'users/verify_email',
                type: 'post',
			    data:{email: value},
	}); 

    if(result.responseText == '0') return true; else return false;

    } , "Please enter a unique email");
	
	$.validator.addMethod('uniqueEditEmail', function(value) {
	    var id = $('#user_id').val();		
        var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'users/verify_email',
                type: 'post',
			    data:{email: value, id:id},
	  }); 

         if(result.responseText == '0') return true; else return false;

             } , "Please enter a unique email");

    $.validator.addMethod('checkPassword', function(value) {
			
         var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'change_password/verify_password',
                type: 'post',
			    data:{password: value},
	}); 

    if(result.responseText == '0') return true; else return false;

    } , "Old Password is incorrect");

    $(document).ready(function() {
        setFormValidation('#UserForm');
        setFormValidation('#ProfileForm');
        setFormValidation('#PasswordForm');
    });
	
	