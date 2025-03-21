    $.validator.addMethod('checkPassword', function(value) {
			
         var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'change_password/verify_password',
                type: 'post',
			    data:{password: value},
	}); 

    if(result.responseText == '0') return true; else return false;

    } , "Old Password is incorrect");
    
    $.validator.addMethod('validUrl', function(value, element) {
    var url = $.validator.methods.url.bind(this);
    return url(value, element) || url('http://' + value, element);
  }, 'Please enter a valid URL');
  
    // Custom validator for the month field (01-12)
    $.validator.addMethod("month", function(value, element) {
        return this.optional(element) || /^(0[1-9]|1[0-2])$/.test(value); // Matches MM (01 to 12)
    }, "Please enter a valid month (01-12).");

    // Custom validator for the year field (must be the current year or future years)
    $.validator.addMethod("year", function(value, element) {
        var currentYear = new Date().getFullYear();
        return this.optional(element) || /^(20[2-9][0-9]|[2-9][0-9]{3})$/.test(value) && parseInt(value) >= currentYear;
    }, "Please enter a valid year (current or future year).");
    
    // Custom validation method for CVC (3 digits for most cards, 4 digits for Amex)
    $.validator.addMethod("cvc", function(value, element) {
        // Regular expression for CVC
        // Matches:
        // - 3 digits for Visa, MasterCard, Discover (e.g., 123)
        // - 4 digits for American Express (e.g., 1234)
        return this.optional(element) || /^(?:\d{3}|\d{4})$/.test(value);
    }, "Please enter a valid CVC (3 digits for most cards or 4 digits for Amex).");



    $(document).ready(function() {
        setFormValidation('#ProfileForm');
        setFormValidation('#PasswordForm');
        setFormValidation('#XeroSettingsForm');
        setFormValidation('#PaymentSettingsForm');
    });
	
	