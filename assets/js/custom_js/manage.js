function checkType(component_type){
   
    if(component_type=="Import CSV"){
        $(".csv_container").show();
        $(".adding_component_container").hide();
    }
    else{
       $(".csv_container").hide();
       $(".adding_component_container").show();
    }
    
}
   $.validator.addMethod('uniqueEmail', function(value) {
			
         var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'manage/verify_client_email',
                type: 'post',
			    data:{email: value},
	}); 

    if(result.responseText == '0') return true; else return false;

    } , "Please enter a unique email");
	
	$.validator.addMethod('uniqueEditEmail', function(value) {
	    var id = $('#client_id').val();		
        var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'manage/verify_client_email',
                type: 'post',
			    data:{email: value, id:id},
	  }); 

         if(result.responseText == '0') return true; else return false;

             } , "Please enter a unique email");

    $.validator.addMethod('uniqueProject', function(value) {
			
         var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'manage/verify_project',
                type: 'post',
			    data:{name: value},
	}); 

    if(result.responseText == '0') return true; else return false;

    } , "Please enter a unique project");
	
	$.validator.addMethod('uniqueEditProject', function(value) {
	    var id = $('#project_id').val();		
        var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'manage/verify_project',
                type: 'post',
			    data:{name: value, id:id},
	  }); 

         if(result.responseText == '0') return true; else return false;

             } , "Please enter a unique project");
             
    //Supplier
    
    $.validator.addMethod('uniqueSupplier', function(value) {
			
         var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'manage/verify_supplier_email',
                type: 'post',
			    data:{email: value},
	}); 

    if(result.responseText == '0') return true; else return false;

    } , "Please enter a unique email");
	
	$.validator.addMethod('uniqueEditSupplierEmail', function(value) {
	    var id = $('#supplier_id').val();		
        var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'manage/verify_supplier_email',
                type: 'post',
			    data:{email: value, id:id},
	  }); 

         if(result.responseText == '0') return true; else return false;

             } , "Please enter a unique email");

    $.validator.addMethod('uniqueSupplier', function(value) {
			
         var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'manage/verify_supplier',
                type: 'post',
			    data:{name: value},
	}); 

    if(result.responseText == '0') return true; else return false;

    } , "Please enter a unique supplier");
	
	$.validator.addMethod('uniqueEditSupplier', function(value) {
	    var id = $('#supplier_id').val();		
        var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'manage/verify_supplier',
                type: 'post',
			    data:{name: value, id:id},
	  }); 

         if(result.responseText == '0') return true; else return false;

             } , "Please enter a unique supplier");
             
    $.validator.addMethod('uniqueComponent', function(value) {
		var supplier_id = $('#supplier_id').val();
         var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'manage/verify_component',
                type: 'post',
			    data:{name: value, supplier_id:supplier_id},
	}); 

    if(result.responseText == '0') return true; else return false;

    } , "Please enter a unique component");
	
	$.validator.addMethod('uniqueEditComponent', function(value) {
	    var id = $('#component_id').val();	
	    var supplier_id = $('#supplier_id').val();
        var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'manage/verify_component',
                type: 'post',
			    data:{name: value, id:id, supplier_id:supplier_id},
	  }); 

         if(result.responseText == '0') return true; else return false;

             } , "Please enter a unique component");
             
    $.validator.addMethod('validUrl', function(value, element) {
    var url = $.validator.methods.url.bind(this);
    return url(value, element) || url('http://' + value, element);
  }, 'Please enter a valid URL');
             
    $(document).ready(function() {
        setFormValidation('#ClientForm');
        setFormValidation('#ProjectForm');
        setFormValidation('#SupplierForm');
        setFormValidation('#ComponentForm');
        setFormValidation('#ComponentCSVForm');
    });
    
    
    $.validator.addMethod('uniqueClient', function(value) {
                 var result = $.ajax({ 
                                      
        			    async:false, 
                        url:base_url+"manage/verify_client_email",
                        type: 'post',
        			    data:{email: value},
        	}); 
        
            if(result.responseText == '0') return true; else return false;
        
            } , "Client Already Exists");
     
    
    $('body').on('click','.add_client_btn',function(){
            if($("#AddClientForm").valid()){
                var formdata = $("#AddClientForm").serialize();
                $.ajax({
                url: base_url+"manage/add_new_client/",
                type: 'post',
                data: formdata,
				beforeSend: function() {
                    $(".add_client_btn").val("Please Wait....."); 
                    $(".add_client_btn").attr("disabled", true); 
                },
                success: function (result) {
                    $("#client_id").html(result);
                    $("#AddClientForm")[0].reset();
                    swal({
                           title: 'Done!',
                           text: 'New Client Added sucessfully',
                           type: 'success',
                           confirmButtonClass: "btn btn-success",
                           buttonsStyling: false
                        });
                    $(".add_client_btn").val("Add Client"); 
                    $(".add_client_btn").attr("disabled", false);
                    $('.selectpicker').selectpicker('refresh');
                    $(".control-label").css("top", "-7px");
                    $("#addNewClient .close").click();
                    
                }
            });
            }
            else{
               $("#AddClientForm").validate();
            }
    });
    
    $('body').on('click','.hide_client_list',function(){
        $(".add_new_client").show();
        $(".client_list").hide();
    });
    
    $('body').on('click','.show_client_list',function(){
        $(".add_new_client").hide();
        $(".client_list").show();
    });
    
	
	//Specification Section
    
    $(document).on('submit','.upload_specification_document',function(e){
    e.preventDefault();

         
    var specification_file = $('#specification_file').val();

    if(specification_file!=""){  
    $('.specification_file_error').text("");  
    $.ajax({
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                
                    xhr.upload.addEventListener("progress", function(evt) {
                      if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        percentComplete = parseInt(percentComplete * 100);
                        $("#progressFileBarSpecification").text(percentComplete+"%");
                        $("#progressFileBarSpecification").css("width", percentComplete+"%");
                          }
                        }, false);
                    
                        return xhr;
                },
                url: base_url+'manage/upload_document', 
                type: "POST",            
                data: new FormData(this), 
                contentType: false,       
                cache: false,             
                processData:false,
                beforeSend: function(){
                    $("#btn-specification").text("Please Wait Document is Uploading....");
                    $("#btn-specification").attr("disabled", "true");
                },
                success: function(result){
                    $("#btn-specification").text("Upload");
                    $("#progressFileBarSpecification").text("0%");
                    $("#progressFileBarSpecification").css("width", "0%");
                    $("#btn-specification").attr("disabled", false);
                    swal({
                           title: 'Uploaded Successfully!',
                           text: 'Specification Document Uploaded.',
                           type: 'success',
                           confirmButtonClass: "btn btn-success",
                           buttonsStyling: false
                           });
                    $(".upload_specification").toggle();
                    $(".upload_specification_document")[0].reset();
                    $(".specification_container").html('<a target="_Blank" href="'+base_url+'assets/component_documents/specification/'+result+'">'+result+'</a><span rowno="'+'" id="'+result+'" class="remove_specification_file btn btn-icon btn-simple btn-sm btn-danger material-icons">close</span>');
                    $("#specification").val(result);
                     $('#specificationModal').modal('hide');
                }
     });
    }
    else{
     $('.specification_file_error').text("Please select file");
    }
});

    $(document).on('click','.remove_specification_file',function(){
              var filename = $(this).attr("id");
              
              var type = "specification";
              
              swal({
                title: 'Are you sure you want to delete this document?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Yes, delete it!',
                buttonsStyling: false
            }).then(function() {
                    
                    $.ajax({
                       type:'POST',
                       url:base_url+'manage/remove_file',
                       data: {filename:filename,type:type},
                       success:function(result){
                           $(".upload_specification").toggle();
                           $(".specification_container").html("");
                           $("#specification").val("");
                           swal({
                           title: 'Deleted!',
                           text: 'Specification Document Deleted.',
                           type: 'success',
                           confirmButtonClass: "btn btn-success",
                           buttonsStyling: false
                           });
                        }
                    }); 		
               });
    });
    
    //Warranty Section
    
    $(document).on('submit','.upload_warranty_document',function(e){
    e.preventDefault();

         
    var warranty_file = $('#warranty_file').val();

    if(warranty_file!=""){  
    $('.warranty_file_error').text("");  
    $.ajax({
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                
                    xhr.upload.addEventListener("progress", function(evt) {
                      if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        percentComplete = parseInt(percentComplete * 100);
                        $("#progressFileBarWarranty").text(percentComplete+"%");
                        $("#progressFileBarWarranty").css("width", percentComplete+"%");
                          }
                        }, false);
                    
                        return xhr;
                },
                url: base_url+'manage/upload_document', 
                type: "POST",            
                data: new FormData(this), 
                contentType: false,       
                cache: false,             
                processData:false,
                beforeSend: function(){
                    $("#btn-warranty").text("Please Wait Document is Uploading....");
                    $("#btn-warranty").attr("disabled", "true");
                },
                success: function(result){
                    $("#btn-warranty").text("Upload");
                    $("#progressFileBarWarranty").text("0%");
                    $("#progressFileBarWarranty").css("width", "0%");
                    $("#btn-warranty").attr("disabled", false);
                    swal({
                           title: 'Uploaded Successfully!',
                           text: 'Warranty Document Uploaded.',
                           type: 'success',
                           confirmButtonClass: "btn btn-success",
                           buttonsStyling: false
                           });
                    $(".upload_warranty").toggle();
                    $(".upload_warranty_document")[0].reset();
                    $(".warranty_container").html('<a target="_Blank" href="'+base_url+'assets/component_documents/warranty/'+result+'">'+result+'</a><span rowno="'+'" id="'+result+'" class="remove_warranty_file btn btn-icon btn-simple btn-sm btn-danger material-icons">close</span>');
                    $("#warranty").val(result);
                     $('#warrantyModal').modal('hide');
                }
     });
    }
    else{
     $('.warranty_file_error').text("Please select file");
    }
});

    $(document).on('click','.remove_warranty_file',function(){
              var filename = $(this).attr("id");
              
              var type = "warranty";
              
              swal({
                title: 'Are you sure you want to delete this document?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Yes, delete it!',
                buttonsStyling: false
            }).then(function() {
                    
                    $.ajax({
                       type:'POST',
                       url:base_url+'manage/remove_file',
                       data: {filename:filename,type:type},
                       success:function(result){
                           $(".upload_warranty").toggle();
                           $(".warranty_container").html("");
                           $("#warranty").val("");
                           swal({
                           title: 'Deleted!',
                           text: 'Warranty Document Deleted.',
                           type: 'success',
                           confirmButtonClass: "btn btn-success",
                           buttonsStyling: false
                           });
                        }
                    }); 		
               });
    });
    
    //Maintenance Section
    
    $(document).on('submit','.upload_maintenance_document',function(e){
    e.preventDefault();

         
    var maintenance_file = $('#maintenance_file').val();

    if(maintenance_file!=""){  
    $('.maintenance_file_error').text("");  
    $.ajax({
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                
                    xhr.upload.addEventListener("progress", function(evt) {
                      if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        percentComplete = parseInt(percentComplete * 100);
                        $("#progressFileBarMaintenance").text(percentComplete+"%");
                        $("#progressFileBarMaintenance").css("width", percentComplete+"%");
                          }
                        }, false);
                    
                        return xhr;
                },
                url: base_url+'manage/upload_document', 
                type: "POST",            
                data: new FormData(this), 
                contentType: false,       
                cache: false,             
                processData:false,
                beforeSend: function(){
                    $("#btn-maintenance").text("Please Wait Document is Uploading....");
                    $("#btn-maintenance").attr("disabled", "true");
                },
                success: function(result){
                    $("#btn-maintenance").text("Upload");
                    $("#progressFileBarMaintenance").text("0%");
                    $("#progressFileBarMaintenance").css("width", "0%");
                    swal({
                           title: 'Uploaded Successfully!',
                           text: 'Maintenance Document Uploaded.',
                           type: 'success',
                           confirmButtonClass: "btn btn-success",
                           buttonsStyling: false
                           });
                    $("#btn-maintenance").attr("disabled", false);
                    $(".upload_maintenance").toggle();
                    $(".upload_maintenance_document")[0].reset();
                    $(".maintenance_container").html('<a target="_Blank" href="'+base_url+'assets/component_documents/maintenance/'+result+'">'+result+'</a><span rowno="'+'" id="'+result+'" class="remove_maintenance_file btn btn-icon btn-simple btn-sm btn-danger material-icons">close</span>');
                    $("#maintenance").val(result);
                     $('#maintenanceModal').modal('hide');
                }
     });
    }
    else{
     $('.maintenance_file_error').text("Please select file");
    }
});

    $(document).on('click','.remove_maintenance_file',function(){
              var filename = $(this).attr("id");
              
              var type = "maintenance";
              
             swal({
                title: 'Are you sure you want to delete this document?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Yes, delete it!',
                buttonsStyling: false
            }).then(function() {
                    
                    $.ajax({
                       type:'POST',
                       url:base_url+'manage/remove_file',
                       data: {filename:filename,type:type},
                       success:function(result){
                           $(".upload_maintenance").toggle();
                           $(".maintenance_container").html("");
                            $("#maintenance").val("");
                           swal({
                           title: 'Deleted!',
                           text: 'Maintenance Document Deleted.',
                           type: 'success',
                           confirmButtonClass: "btn btn-success",
                           buttonsStyling: false
                           });
                        }
                    }); 		
            });
    });
    
    //Installation Section
    
    $(document).on('submit','.upload_installation_document',function(e){
    e.preventDefault();

         
    var installation_file = $('#installation_file').val();

    if(installation_file!=""){  
    $('.installation_file_error').text("");  
    $.ajax({
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                
                    xhr.upload.addEventListener("progress", function(evt) {
                      if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        percentComplete = parseInt(percentComplete * 100);
                        $("#progressFileBarInstallation").text(percentComplete+"%");
                        $("#progressFileBarInstallation").css("width", percentComplete+"%");
                          }
                        }, false);
                    
                        return xhr;
                },
                url: base_url+'manage/upload_document', 
                type: "POST",            
                data: new FormData(this), 
                contentType: false,       
                cache: false,             
                processData:false,
                beforeSend: function(){
                    $("#btn-installation").text("Please Wait Document is Uploading....");
                    $("#btn-installation").attr("disabled", "true");
                },
                success: function(result){
                    $("#btn-installation").text("Upload");
                    $("#progressFileBarInstallation").text("0%");
                    $("#progressFileBarInstallation").css("width", "0%");
                    $("#btn-installation").attr("disabled", false);
                    swal({
                           title: 'Uploaded Successfully',
                           text: 'Installation Document Uploaded.',
                           type: 'success',
                           confirmButtonClass: "btn btn-success",
                           buttonsStyling: false
                           });
                    $(".upload_installation").toggle();
                    $(".upload_installation_document")[0].reset();
                    $(".installation_container").html('<a target="_Blank" href="'+base_url+'assets/component_documents/installation/'+result+'">'+result+'</a><span rowno="'+'" id="'+result+'" class="remove_installation_file btn btn-icon btn-simple btn-sm btn-danger"><i class="material-icons">close</span>');
                    $("#installation").val(result);
                     $('#installationModal').modal('hide');
                }
     });
    }
    else{
     $('.installation_file_error').text("Please select file");
    }
});
    
    $(document).on('click','.remove_installation_file',function(){
              var filename = $(this).attr("id");
              
              var type = "installation";
              
              
              swal({
                title: 'Are you sure you want to delete this document?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Yes, delete it!',
                buttonsStyling: false
            }).then(function() {
                    
                    $.ajax({
                       type:'POST',
                       url:base_url+'manage/remove_file',
                       data: {filename:filename,type:type},
                       success:function(result){
                           $(".upload_installation").toggle();
                           $(".installation_container").html("");
                           $("#installation").val("");
                           swal({
                           title: 'Installation Document Deleted!',
                           text: 'Your record has been deleted.',
                           type: 'success',
                           confirmButtonClass: "btn btn-success",
                           buttonsStyling: false
                           });	
                        }
                    }); 		
               });
    });
    
    $(document).on('blur','.checklistitem',function(){
              
              var checklist = $(this).val();
              if(checklist!=""){
                  $(this).val("");
                  var checklist_input = $("#checklist").val();
                  $("#checklist").val(checklist_input+checklist+",");
                  $(".checklist_container").append('<p class="no-padding" checklist="'+checklist+'">'+checklist+'<span rowno="'+'" class="remove_checklist btn btn-icon btn-simple btn-sm btn-danger material-icons">close</span></p>');
                  swal({
                        title: 'Your Checklist Item(s) have been created.',
                        text: 'To save the Checklist Item(s), click ADD before exiting this page.',
                        type: 'success',
                        confirmButtonClass: "btn btn-success",
                        buttonsStyling: false
                    });
              }
                        
    });
    
    $(document).on('blur','.updatechecklistitem',function(){
              
              var checklist = $(this).val();
             
              if(checklist!=""){
                  $(this).val("");
                  var checklist_input = $("#checklist").val();
                  $("#checklist").val(checklist_input+checklist+",");
                  $(".checklist_container").append('<p class="no-padding" checklist="'+checklist+'">'+checklist+'<span rowno="'+'" class="remove_updated_checklist btn btn-icon btn-simple btn-sm btn-danger material-icons">close</span></p>');
                  swal({
                        title: 'Your Checklist Item(s) have been created.',
                        text: 'To save the Checklist Item(s), click UPDATE before exiting this page.',
                        type: 'success',
                        confirmButtonClass: "btn btn-success",
                        buttonsStyling: false
                    });
              }
                        
    });
    
    $(document).on('click','.remove_checklist',function(){
        
        var current = $(this);
        swal({
                title: 'Are you sure you want to delete this checklist?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Yes, delete it!',
                buttonsStyling: false
            }).then(function() {
                    var checklist_input = $("#checklist").val();
                    var remove_checklist = current.parent("p").attr("checklist")+",";
                    var checklists = checklist_input.replace(String(remove_checklist),"");
                    $("#checklist").val(checklists);
                    current.parent("p").remove();
                    swal({
                           title: 'Your Checklist Item has been deleted!',
                           text: 'Your record has been deleted. Please click ADD before exiting this page',
                           type: 'success',
                           confirmButtonClass: "btn btn-success",
                           buttonsStyling: false
                    });	
        });
    });
    
    $(document).on('click','.remove_updated_checklist',function(){
        var current = $(this);
        var id = $(this).attr("id");
        swal({
                title: 'Are you sure you want to delete this checklist?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Yes, delete it!',
                buttonsStyling: false
            }).then(function() {
                    var checklist_input = $("#checklist").val();
                    if(id){
                        var remove_checklist = $(".checklist_item"+id).parent("p").attr("checklist")+",";
                        var checklists = checklist_input.replace(String(remove_checklist),"");
                        $("#checklist").val(checklists);
                        $(".checklist_item"+id).parent("p").remove();
                    }
                    else{
                        var remove_checklist = current.parent("p").attr("checklist")+",";
                        var checklists = checklist_input.replace(String(remove_checklist),"");
                        $("#checklist").val(checklists);
                        current.parent("p").remove();
                    }
                    swal({
                           title: 'Your Checklist Item has been deleted!',
                           text: 'Your record has been deleted. Please click UPDATE before exiting this page',
                           type: 'success',
                           confirmButtonClass: "btn btn-success",
                           buttonsStyling: false
                    });	
        });
    });
   
    
    
	