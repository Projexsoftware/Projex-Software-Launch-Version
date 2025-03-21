 $.validator.addMethod('uniqueRole', function(value) {
			
         var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'roles/verify_role',
                type: 'post',
			    data:{role_title: value},
	}); 

    if(result.responseText == '0') return true; else return false;

    } , "Please enter a unique role");
	
	$.validator.addMethod('uniqueEditRole', function(value) {
	    var id = $('#role_id').val();		
        var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'roles/verify_role',
                type: 'post',
			    data:{role_title: value, id:id},
	  }); 

         if(result.responseText == '0') return true; else return false;

             } , "Please enter a unique role");


    $(document).ready(function() {
        setFormValidation('#RoleForm');
    });
    
    function checkbox_item(id){
        if($("#"+id ).prop( "checked" )==false){
          console.log($(".child_"+id));
          $(".child_"+id).prop( "checked", false );            
        }
        else{
            $(".child_"+id).prop( "checked", true );
        }
  }