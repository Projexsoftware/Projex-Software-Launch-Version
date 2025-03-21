$(".checkbox").css("z-index", 30);
$.validator.addMethod('uniqueProject', function(value) {
			
         var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'designz/verify_project',
                type: 'post',
			    data:{name: value},
	}); 

    if(result.responseText == '0') return true; else return false;

    } , "Please enter a unique designz name");
	
	$.validator.addMethod('uniqueEditProject', function(value) {
	    var id = $('#designz_id').val();		
        var result = $.ajax({ 
			    async:false, 
                url:base_url + 'designz/verify_project',
                type: 'post',
			    data:{name: value, id:id},
	  }); 

         if(result.responseText == '0') return true; else return false;

             } , "Please enter a unique designz name");
             
$.validator.addMethod('uniqueBuilderzDesignzName', function(value) {
			
         var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'designz/verify_builderz_designz_name',
                type: 'post',
			    data:{name: value},
	}); 

    if(result.responseText == '0') return true; else return false;

    } , "Please enter a unique builderz designz name");
	
	$.validator.addMethod('uniqueEditBuilderzDesignzName', function(value) {
	    var id = $('#designz_id').val();		
        var result = $.ajax({ 
			    async:false, 
                url:base_url + 'designz/verify_builderz_designz_name',
                type: 'post',
			    data:{name: value, id:id},
	  }); 

         if(result.responseText == '0') return true; else return false;

             } , "Please enter a unique builderz designz name");
    
$(document).ready(function() {
        setFormValidation('#DesignzForm');
});


$('body').on('click', '.show_at_client_interface', function(){
        var show_at_client_interface = $(this).prop("checked") == true ? 1 : 0;
        var designz_type = $(this).attr("designz_type");
        var id = $(this).val();
        var current = $(this);
        if(show_at_client_interface == 0){
            swal({
                title: 'Are you sure?',
                text: "This designz is in use, unchecking will hide this designz from Builderz users client interface. Do you wish to proceed?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                buttonsStyling: false
            }).then(function() {
                $.ajax({
                type:'POST',
                url:base_url+'designz/show_at_client_interface',
                data: {id:id,show_at_client_interface:show_at_client_interface,designz_type:designz_type},
                success:function(result){
                    if(show_at_client_interface == 1){
                      swal({
                           title: 'Designz Successfully Added!',
                           text: 'The selected designz will be available for Builderz users.',
                           type: 'success',
                           confirmButtonClass: "btn btn-success",
                           buttonsStyling: false
                        });
                    }
                    else{
                        swal({
                           title: 'Designz Successfully Removed!',
                           text: 'The selected designz will not be available for Builderz users client interface. You can add it back anytime if needed.',
                           type: 'success',
                           confirmButtonClass: "btn btn-success",
                           buttonsStyling: false
                        });	
                    }
                }
        }); 
            }, function(dismiss) {
                if (dismiss === 'cancel') {
                    $(current).prop("checked", true);
                }
            });
        }
        else{
           $.ajax({
                type:'POST',
                url:base_url+'designz/show_at_client_interface',
                data: {id:id,show_at_client_interface:show_at_client_interface,designz_type:designz_type},
                success:function(result){
                    if(show_at_client_interface == 1){
                      swal({
                           title: 'Designz Successfully Added!',
                           text: 'The selected designz will be available for Builderz users client interface.',
                           type: 'success',
                           confirmButtonClass: "btn btn-success",
                           buttonsStyling: false
                        });
                    }
                    else{
                        swal({
                           title: 'Designz Successfully Removed!',
                           text: 'The selected designz will not be available for Builderz users client interface. You can add it back anytime if needed.',
                           type: 'success',
                           confirmButtonClass: "btn btn-success",
                           buttonsStyling: false
                        });	
                    }
                }
        });
        }
   });


if($("#imagesDropzone").length){
    Dropzone.autoDiscover = false; // Disable auto discover
    
    var uploadedFiles = []; // To store the uploaded file data
    
    var selectedFiles = [];
    
    var myDropzone = new Dropzone("#imagesDropzone", {
        url: base_url+"/designz/upload_designz_files/image", // File upload URL
        autoProcessQueue: true, // Automatically upload the file when added
        //clickable:typeof isClickable !== 'undefined' && isClickable==0?false:true,
        maxFilesize: 10, // Max file size in MB
        addRemoveLinks: true, // Show remove link on the file thumbnail
        acceptedFiles: "image/*",
        init: function () {
            var dz = this;
            if (typeof uploadedImages !== 'undefined') {
                uploadedImages.forEach(function (file) {
                    var mockFile = {
                        id:file.id,
                        name: file.file_name, // Name of the file from database
                        accepted: true,
                        type: file.file_type,
                        set_as_thumbnail:file.set_as_thumbnail,
                    };
    
                    // Manually add file to Dropzone
                    dz.emit("addedfile", mockFile);
                    /*if(typeof isClickable !== 'undefined' && isClickable==0){
                         dz.emit("thumbnail", mockFile, base_url+'assets/designz_uploads/thumbnail/' + file.file_name); // Path to image
                    }
                    else{
                        dz.emit("thumbnail", mockFile, base_url+'assets/builderz_designz_uploads/thumbnail/' + file.file_name); // Path to image
                    }*/
                    dz.emit("thumbnail", mockFile, base_url+'assets/'+file.uploaded_path+'/thumbnail/' + file.file_name);
                    dz.emit("complete", mockFile);
    
                    // Push the file to Dropzone's internal files array to avoid auto-removal
                    dz.files.push(mockFile);
                });
            }
            if (typeof uploadedBuilderzImages !== 'undefined') {
                uploadedBuilderzImages.forEach(function (file) {
                    var mockFile = {
                        id:file.id,
                        name: file.file_name, // Name of the file from database
                        accepted: true,
                        type: file.file_type,
                        set_as_thumbnail:file.set_as_thumbnail,
                    };
    
                    // Manually add file to Dropzone
                    dz.emit("addedfile", mockFile);
                    /*if(typeof isClickable !== 'undefined' && isClickable==0){
                         dz.emit("thumbnail", mockFile, base_url+'assets/designz_uploads/thumbnail/' + file.file_name); // Path to image
                    }
                    else{
                        dz.emit("thumbnail", mockFile, base_url+'assets/builderz_designz_uploads/thumbnail/' + file.file_name); // Path to image
                    }*/
                    dz.emit("thumbnail", mockFile, base_url+'assets/'+file.uploaded_path+'/thumbnail/' + file.file_name);
                    dz.emit("complete", mockFile);
    
                    // Push the file to Dropzone's internal files array to avoid auto-removal
                    dz.files.push(mockFile);
                    uploadedFiles.push({ name: file.file_name, id: file.id, type: file.file_type, designz_upload_type: file.designz_upload_type }); // Push file data into the uploadedFiles array
                     // Push file data into the uploadedFiles array
                    $("#uploadedFiles").val(JSON.stringify(uploadedFiles));
                });
            }
            // Handle the successful upload of files
            dz.on("success", function (file, response) {
                // You can add response data to `uploadedFiles`
                uploadedFiles.push({ name: file.upload.filename, id: file.id, type: file.type, designz_upload_type: "image" }); // Push file data into the uploadedFiles array
                $("#uploadedFiles").val(JSON.stringify(uploadedFiles));
            });
    
            // Handle errors during the file upload
            dz.on("error", function (file, errorMessage) {
                console.log("Error while uploading file: ", errorMessage);
            });
        }
    });
    
    var myDropzone = new Dropzone("#plansDropzone", {
        url: base_url+"/designz/upload_designz_files/plan", // File upload URL
        autoProcessQueue: true, // Automatically upload the file when added
        clickable:typeof isClickable !== 'undefined' && isClickable==0?false:true,
        maxFilesize: 10, // Max file size in MB
        addRemoveLinks: true, // Show remove link on the file thumbnail
        init: function () {
            var dz = this;
            if(typeof isClickable !== 'undefined' && isClickable==0){
                $(".set_as_thumbnail").attr("disabled", true);
            }
            if (typeof uploadedPlans !== 'undefined') {
                uploadedPlans.forEach(function (file) {
                    var mockFile = {
                        id:file.id,
                        name: file.file_name, // Name of the file from database
                        accepted: true,
                        type: file.file_type,
                        set_as_thumbnail:file.set_as_thumbnail,
                    };
    
                    // Manually add file to Dropzone
                    dz.emit("addedfile", mockFile);
                    
                    if (file.file_type.startsWith('image/')) {
                             dz.emit("thumbnail", mockFile, base_url+'assets/'+file.uploaded_path+'/thumbnail/' + file.file_name); // Path to image
                    }
                    else{
                        
                        const thumbnailElement = mockFile.previewElement.querySelector(".dz-size");
                        thumbnailElement.innerHTML = 3;
                    }
                    
                    dz.emit("complete", mockFile);
    
                    // Push the file to Dropzone's internal files array to avoid auto-removal
                    dz.files.push(mockFile);
                });
            }
            if (typeof uploadedBuilderzPlans !== 'undefined') {
                uploadedBuilderzPlans.forEach(function (file) {
                    var mockFile = {
                        id:file.id,
                        name: file.file_name, // Name of the file from database
                        accepted: true,
                        type: file.file_type,
                        set_as_thumbnail:file.set_as_thumbnail,
                    };
    
                    // Manually add file to Dropzone
                    dz.emit("addedfile", mockFile);
                    
                    if (file.file_type.startsWith('image/')) {
                             dz.emit("thumbnail", mockFile, base_url+'assets/'+file.uploaded_path+'/thumbnail/' + file.file_name); // Path to image
                    }
                    else{
                        
                        const thumbnailElement = mockFile.previewElement.querySelector(".dz-size");
                        thumbnailElement.innerHTML = 3;
                    }
                    
                    dz.emit("complete", mockFile);
    
                    // Push the file to Dropzone's internal files array to avoid auto-removal
                    dz.files.push(mockFile);
                    uploadedFiles.push({ name: file.file_name, id: file.id, type: file.file_type, designz_upload_type: file.designz_upload_type }); // Push file data into the uploadedFiles array
                    $("#uploadedFiles").val(JSON.stringify(uploadedFiles));
                });
            }
            
            // Handle the successful upload of files
            dz.on("success", function (file, response) {
                // You can add response data to `uploadedFiles`
                uploadedFiles.push({ name: file.upload.filename, id: file.upload.filename, type:file.type, designz_upload_type: "plan" }); // Push file data into the uploadedFiles array
                $("#uploadedFiles").val(JSON.stringify(uploadedFiles));
            });
    
            // Handle errors during the file upload
            dz.on("error", function (file, errorMessage) {
                console.log("Error while uploading file: ", errorMessage);
            });
        }
    });
}

$(document).ready(function() {
            // Click event to enable editing
            $('.editable').on('click', function() {
                var id = $(this).attr("data-designz-id");
                var currentText = $(this).text(); // Get the current text
                $(this).hide(); // Hide the paragraph

                // Create an input field with the current text
                var inputField = $('<input type="text" />').val(currentText);
                
                // Append the input field to the DOM
                $(this).after(inputField);
                inputField.focus(); // Focus on the input field

                // Event to save the changes on blur
                inputField.on('blur', function() {
                    var newText = $(this).val(); // Get the new text
                    $('#editable-'+id).text(newText); // Update the paragraph text
                    $.ajax({
                        type:'POST',
                        url:base_url+'designz/update_designz_name',
                        data: {id:id,name:newText},
                        success:function(result){
                            
                        }
                    }); 
                    $(this).remove(); // Remove the input field
                    $('#editable-'+id).show(); // Show the paragraph again
                });

                // Save changes on pressing Enter key
                inputField.on('keypress', function(e) {
                    if (e.which === 13) { // Enter key
                        $(this).blur(); // Trigger blur event to save changes
                    }
                });
            });
        });

$(document).on('click','.set_as_thumbnail',function(){
    var image = $(this).val();
    $("#thumbnail").attr("src", base_url+"assets/builderz_designz_uploads/thumbnail/"+image);
});


$(document).on('click','.set_plan_as_thumbnail',function(){
    var image = $(this).val();
    $("#plan_thumbnail").attr("src", base_url+"assets/builderz_designz_uploads/thumbnail/"+image);
});

$(document).on('click','.display_image',function(){
    var image = $(this).val();
    var file_type = $(this).attr("file-type");
    selectedFiles.push({ name: image, id: image, type:file_type, designz_upload_type: "image" }); // Push file data into the uploadedFiles array
    $("#selectedFiles").val(JSON.stringify(selectedFiles));
    
});

$(document).on('click','.display_plan_image',function(){
    var image = $(this).val();
    var file_type = $(this).attr("file-type");
    selectedFiles.push({ name: image, id: image, type:file_type, designz_upload_type: "plan" }); // Push file data into the uploadedFiles array
    $("#selectedFiles").val(JSON.stringify(selectedFiles));
    
});