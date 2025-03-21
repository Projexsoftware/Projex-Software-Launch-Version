<!--   Core JS Files   -->
<script src="<?php echo JS;?>jquery-3.2.1.min.js" type="text/javascript"></script>
<script src="<?php echo JS;?>bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo JS;?>material.min.js" type="text/javascript"></script>
<script src="<?php echo JS;?>perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
<!-- Library for adding dinamically elements -->
<script src="<?php echo JS;?>arrive.min.js" type="text/javascript"></script>
<!-- Forms Validations Plugin -->
<script src="<?php echo JS;?>jquery.validate.min.js"></script>
<!-- Promise Library for SweetAlert2 working on IE -->
<script src="<?php echo JS;?>es6-promise-auto.min.js"></script>
<!--  Plugin for Date Time Picker and Full Calendar Plugin-->
<script src="<?php echo JS;?>moment.min.js"></script>
<!--  Charts Plugin, full documentation here: https://gionkunz.github.io/chartist-js/ -->
<script src="<?php echo JS;?>chartist.min.js"></script>
<!--  Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
<script src="<?php echo JS;?>jquery.bootstrap-wizard.js"></script>
<!--  Notifications Plugin, full documentation here: http://bootstrap-notify.remabledesigns.com/    -->
<script src="<?php echo JS;?>bootstrap-notify.js"></script>
<!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
<script src="<?php echo JS;?>bootstrap-datetimepicker.js"></script>
<!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
<script src="<?php echo JS;?>jquery-jvectormap.js"></script>
<!-- Sliders Plugin, full documentation here: https://refreshless.com/nouislider/ -->
<script src="<?php echo JS;?>nouislider.min.js"></script>
<!--  Google Maps Plugin    -->
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
<!--  Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
<script src="<?php echo JS;?>jquery.select-bootstrap.js"></script>
<!--  DataTables.net Plugin, full documentation here: https://datatables.net/    -->
<script src="<?php echo JS;?>jquery.datatables.js"></script>
<!-- Sweet Alert 2 plugin, full documentation here: https://limonte.github.io/sweetalert2/ -->
<script src="<?php echo JS;?>sweetalert2.js"></script>
<!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
<script src="<?php echo JS;?>jasny-bootstrap.min.js"></script>
<!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
<script src="<?php echo JS;?>fullcalendar.min.js"></script>
<!-- Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
<script src="<?php echo JS;?>jquery.tagsinput.js"></script>
<!-- Material Dashboard javascript methods -->
<script src="<?php echo JS;?>material-dashboard.js?v=1.2.0"></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="<?php echo JS;?>demo.js"></script>
<script type="text/javascript">
    $().ready(function() {
        demo.checkFullPageBackgroundImage();

        setTimeout(function() {
            // after 1000 ms we add the class animated to the login/register card
            $('.card').removeClass('card-hidden');
        }, 700)
    });
</script>
<script type="text/javascript">
    function setFormValidation(id) {
        $(id).validate({
            errorPlacement: function(error, element) {
                if(element.attr('name')=="accept"){
				    error.insertAfter(".form-check-label");
				}
				else{
                  error.insertAfter(element);
				}
                $(element).closest('div').addClass('has-error');
            }
        });
    }

    $.validator.addMethod('checkEmail', function(value) {
			
         var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'forgot/verify_email',
                type: 'post',
			    data:{email: value},
	}); 

    if(result.responseText == '0') return true; else return false;

    } , "This account is not registered with us, please try again!");
    
    $.validator.addMethod('uniqueEmail', function(value) {
			
         var result = $.ajax({ 
                              
			    async:false, 
                url:'<?php echo SURL;?>register/verify_email',
                type: 'post',
			    data:{email: value},
	}); 
	if(result.responseText == '0') return true; else return false;

    } , "This account is already registered with us, please try with another email!");
	
	$.validator.addMethod('uniqueCompany', function(value) {
			
         var result = $.ajax({ 
                              
			    async:false, 
                url:'<?php echo SURL;?>register/verify_company',
                type: 'post',
			    data:{company: value},
	}); 

    if(result.responseText == '0') return true; else return false;

    } , "This company is already registered with us, please try with another company name!");
	
    $.validator.addMethod("lettersonly", function(value, element) {
    return this.optional(element) || /^[a-z\s]+$/i.test(value);
    }, "Only alphabetical characters");

    $(document).ready(function() {
        setFormValidation('#LoginForm');
        setFormValidation('#RegisterForm');
        setFormValidation('#ForgotForm');
    });
</script>