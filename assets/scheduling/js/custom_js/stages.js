 $.validator.addMethod('uniqueStage', function(value) {
			
         var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'stages/verify_stage',
                type: 'post',
			    data:{name: value},
	}); 

    if(result.responseText == '0') return true; else return false;

    } , "Please enter a unique stage");
	
	$.validator.addMethod('uniqueEditStage', function(value) {
	    var id = $('#stage_id').val();		
        var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'stages/verify_stage',
                type: 'post',
			    data:{name: value, id:id},
	  }); 

         if(result.responseText == '0') return true; else return false;

             } , "Please enter a unique stage");


    $(document).ready(function() {
        setFormValidation('#StageForm');
    });