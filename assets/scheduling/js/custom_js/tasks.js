 $.validator.addMethod('uniqueTask', function(value) {
			
         var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'tasks/verify_task',
                type: 'post',
			    data:{name: value},
	}); 

    if(result.responseText == '0') return true; else return false;

    } , "Please enter a unique task");
	
	$.validator.addMethod('uniqueEditTask', function(value) {
	    var id = $('#task_id').val();		
        var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'tasks/verify_task',
                type: 'post',
			    data:{name: value, id:id},
	  }); 

         if(result.responseText == '0') return true; else return false;

             } , "Please enter a unique task");


    $(document).ready(function() {
        setFormValidation('#TaskForm');
    });