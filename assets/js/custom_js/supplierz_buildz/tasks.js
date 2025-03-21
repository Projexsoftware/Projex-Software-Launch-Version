 $.validator.addMethod('uniqueTask', function(value) {
			
         var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'supplierz_buildz/tasks/verify_task',
                type: 'post',
			    data:{name: value},
	}); 

    if(result.responseText == '0') return true; else return false;

    } , "Please enter a unique task");
	
	$.validator.addMethod('uniqueEditTask', function(value) {
	    var id = $('#task_id').val();		
        var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'supplierz_buildz/tasks/verify_task',
                type: 'post',
			    data:{name: value, id:id},
	  }); 

         if(result.responseText == '0') return true; else return false;

             } , "Please enter a unique task");


    $(document).ready(function() {
        setFormValidation('#TaskForm');
    });
    
    $(document).ready(function() {
        var max_fields      = 10; //maximum input boxes allowed
        var wrapper         = $(".input_fields_wrap"); //Fields wrapper
        var add_button      = $(".add_field_button"); //Add button ID
        
        var x = 1; //initlal text box count
        $(add_button).click(function(e){ //on add input button click
            e.preventDefault();
            if(x < max_fields){ //max input box allowed
                x++; //text box increment
                $(wrapper).append('<div class="form-group label-floating"><label class="control-label">Checklist</label><input class="form-control more_checklist" type="text" name="checklists[]" id="checklist'+x+'" value=""/><div class="form-footer text-right"><button type="button" class="btn btn-sm btn-danger btn-fill remove_field" style="margin:10px 0px;">Remove</button></div></div>'); //add input box
            }
        });
        
        $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
           e.preventDefault(); 
           $(this).parent('div').parent('div').remove(); x--;
        })
    });
    $(document).on('change','.more_checklist',function(){
        var arr = [];
        var id = $(this).attr("id");
        $(".more_checklist:not(#"+id+")").each(function() {
             arr.push($(this).val()); 
        });
        if ($.inArray($(this).val(), arr) !== -1)
        {
            swal({
                          title: "Checklist Duplicated Found!",
                          text: "",
                          type: 'error',
                          confirmButtonClass: "btn btn-danger",
                          buttonsStyling: false
                       });
            $(".add_new_checklist").attr("disabled", true);
        }
        else{
             $(".add_new_checklist").attr("disabled", false);
       }
    });  