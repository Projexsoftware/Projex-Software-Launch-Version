 $.validator.addMethod('uniqueChecklist', function(value) {
	 var task_id = $('#task_id').val();			
         var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'checklists/verify_checklist',
                type: 'post',
			    data:{name: value, task_id:task_id},
	}); 

    if(result.responseText == '0') return true; else return false;

    } , "Please enter a unique checklist");
	
	$.validator.addMethod('uniqueEditChecklist', function(value) {
	    var id = $('#checklist_id').val();	
            var task_id = $('#task_id').val();	
            var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'checklists/verify_checklist',
                type: 'post',
			    data:{name: value, id:id, task_id:task_id},
	  }); 

         if(result.responseText == '0') return true; else return false;

             } , "Please enter a unique checklist");


    $(document).ready(function() {
        setFormValidation('#ChecklistForm');
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
            $(wrapper).append('<div class="form-group label-floating"><label class="control-label">Checklist</label><input class="form-control more_checklist" type="text" name="name[]" id="name'+x+'" value=""/><div class="form-footer text-right"><button type="button" class="btn btn-sm btn-danger btn-fill remove_field" style="margin:0px;">Remove</button></div></div>'); //add input box
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
