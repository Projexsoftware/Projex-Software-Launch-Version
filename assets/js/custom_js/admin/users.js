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
        setFormValidation('#ProfileForm');
        setFormValidation('#PasswordForm');
    });
	
	