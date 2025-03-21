
function checkType(component_type){
   
    if(component_type=="Import CSV"){
        $("#csv_container").show();
        $("#newcomponentdiv").hide();
        $(".existing_pricebook").hide(); 
    }
    else if(component_type=="Existing Price Book"){
        $(".existing_pricebook").show();
        $("#newcomponentdiv").show();
        $(".newcomponents_container").hide();
        $("#csv_container").hide();
    }
    else{
       $("#csv_container").hide();
       $("#newcomponentdiv").show();
       $(".newcomponents_container").show();
       $(".existing_pricebook").hide(); 
       $('.filterSupplierzComponent').select2({
		placeholder: "Select Component",
		templateResult: formatComponent,
		ajax: {
		  type:'post',
		  url: base_url+"ajax/filterSupplierzComponents",
		  data: function (params) {
			return {
			  searchTerm: params.term // search term
			};
		   },
			  dataType: 'json',
			},
			
	});
    }
    
}
function addRow() {
     var last_row = $('#impnewitems tbody tr:last-child()').attr('tr_val');
    
     if (last_row === undefined) {
        last_row = 1;
     }
     else{
         last_row++;
     }
     
     $.ajax({
                url: base_url+'supplierz/add_new_component', 
                type: "POST",            
                data: {last_row:last_row}, 
                beforeSend: function(){
                    $(".loader").show();
                },
                success: function(result){
                    $(".loader").hide();
                    $('#impnewitems tbody').append(result);
                    $('.selectComponent').select2({
                		placeholder: "Select Component",
                		templateResult: formatComponent,
                		ajax: {
                		  type:'post',
                		  url: base_url+"ajax/components",
                		  data: function (params) {
                			return {
                			  searchTerm: params.term // search term
                			};
                		   },
                			  dataType: 'json',
                			},
                			
                	});
                    $('.selectpicker').selectpicker('refresh');
                    showcolumn('optional');
                    }
     });
     }


function removeRow(row_no){
    $('.pb'+row_no).remove();
}

 $('body').on('click','.remove_component',function(){
     var row_no = $(this).attr("rowno");
      $('.pb'+row_no).remove();
 });



    $.validator.addMethod('uniquePriceBook', function(value) {
			
         var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'supplierz/verify_price_book',
                type: 'post',
			    data:{name: value},
	}); 

    if(result.responseText == '0') return true; else return false;

    } , "Price Book already exists");
    
    
    $.validator.addMethod('uniqueCostingName', function(value) {
			
         var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'supplierz/verify_costing_name',
                type: 'post',
			    data:{name: value},
	}); 

    if(result.responseText == '0') return true; else return false;

    } , "Project Costing already exists");
    
     $.validator.addMethod('uniqueEditCostingName', function(value) {
		 var id = $('#costing_id').val();	
         var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'supplierz/verify_costing_name',
                type: 'post',
			    data:{name: value, id: id},
	}); 

    if(result.responseText == '0') return true; else return false;

    } , "Project Costing already exists");
    
    
    $.validator.addMethod('validUrl', function(value, element) {
    var url = $.validator.methods.url.bind(this);
    return url(value, element) || url('http://' + value, element);
  }, 'Please enter a valid URL');
           
    
   $.validator.addMethod('uniqueEditPriceBook', function(value) {
	        var id = $('#price_book_id').val();	
            var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'supplierz/verify_price_book',
                type: 'post',
			    data:{name: value, id:id},
	  }); 

    if(result.responseText == '0') return true; else return false;

    } , "Price Book already exists");
    
    $.validator.addMethod('uniqueTemplate', function(value) {
			
         var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'supplierz/verify_template',
                type: 'post',
			    data:{name: value},
	}); 

    if(result.responseText == '0') return true; else return false;

    } , "Please enter a unique template name");
	
	$.validator.addMethod('uniqueEditTemplate', function(value) {
	    var id = $('#template_id').val();		
        var result = $.ajax({ 
			    async:false, 
                url:base_url + 'supplierz/verify_template',
                type: 'post',
			    data:{name: value, id:id},
	  }); 

         if(result.responseText == '0') return true; else return false;

             } , "Please enter a unique template name");
             
    $.validator.addMethod('uniqueProject', function(value) {
			
         var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'supplierz/verify_project',
                type: 'post',
			    data:{name: value},
	}); 

    if(result.responseText == '0') return true; else return false;

    } , "Please enter a unique designz name");
	
	$.validator.addMethod('uniqueEditProject', function(value) {
	    var id = $('#designz_id').val();		
        var result = $.ajax({ 
			    async:false, 
                url:base_url + 'supplierz/verify_project',
                type: 'post',
			    data:{name: value, id:id},
	  }); 

         if(result.responseText == '0') return true; else return false;

             } , "Please enter a unique designz name");
             
    $.validator.addMethod('uniquePart', function(value) {
			
         var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'supplierz/verify_part',
                type: 'post',
			    data:{name: value},
	}); 

    if(result.responseText == '0') return true; else return false;

    } , "Please enter a unique part");
    
    $.validator.addMethod('uniqueSupplier', function(value) {
			
         var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'supplierz/verify_supplier_email',
                type: 'post',
			    data:{email: value},
	}); 

    if(result.responseText == '0') return true; else return false;

    } , "Please enter a unique email");
	
	$.validator.addMethod('uniqueEditSupplierEmail', function(value) {
	    var id = $('#supplier_id').val();		
        var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'supplierz/verify_supplier_email',
                type: 'post',
			    data:{email: value, id:id},
	  }); 

         if(result.responseText == '0') return true; else return false;

             } , "Please enter a unique email");

    $.validator.addMethod('uniqueSupplier', function(value) {
			
         var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'supplierz/verify_supplier',
                type: 'post',
			    data:{name: value},
	}); 

    if(result.responseText == '0') return true; else return false;

    } , "Please enter a unique supplier");
	
	$.validator.addMethod('uniqueEditSupplier', function(value) {
	    var id = $('#supplier_id').val();		
        var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'supplierz/verify_supplier',
                type: 'post',
			    data:{name: value, id:id},
	  }); 

         if(result.responseText == '0') return true; else return false;

             } , "Please enter a unique supplier");

    
 $(document).ready(function() {
        setFormValidation('#PriceBookForm');
        setFormValidation('#AllocateForm');
        setFormValidation('#TemplateForm');
        setFormValidation('#ComponentForm');
        setFormValidation('#ComponentCSVForm');
        setFormValidation('#SupplierForm');
        setFormValidation('#DesignzForm');
        setFormValidation('#ProjectCostingForm');
        setFormValidation('#ProjectCostingCSVForm');
        calculate();
        
        $('[data-toggle="tooltip"]').tooltip();
            
        $("#PriceBookForm").submit(function(e){
                if($("#PriceBookForm").valid()){
                    var row_count =  $('#impnewitems').find('tbody').find('tr').length;
                    if(row_count>0){
                     
                    }
                    else{
                        swal({
                               title: 'Error!',
                               text: 'Please add atleast one component.',
                               type: 'error',
                               confirmButtonClass: "btn btn-success",
                               buttonsStyling: false
                               });
                        e.preventDefault(e);
                    }
                }
                else{
                     setFormValidation('#PriceBookForm');
                }
                
        });
    });
    
    function componentval(th) {
        value = $(th).val();
        row_no = $(th).attr('rno');
        $.post(base_url+"supplierz/getComponentDetails", {value: value})
                .done(function (data) {
                    var str = data;
                    var obj = jQuery.parseJSON(str);
                    $('#uomfield' + row_no).val(obj.component_uom);
					var ucost_field= parseFloat(obj.component_sale_price);
                    $('#ucostfield' + row_no).val(ucost_field.toFixed(2));
                }, "json");
    }
    
    function getcomponentinfo(th) {
        value = $("#componentfield"+th).val();
        row_no = th;
        $.post(base_url+"supplierz/getSupplierzComponentDetails", {value: value})
                .done(function (data) {
                    var str = data;
                    var obj = jQuery.parseJSON(str);
                    if(obj.image!=""){
                    $(".preview_component_image"+row_no+" > img").attr("src", base_url+"assets/components/thumbnail/"+obj.image);
                    }
                    else{
                        $(".preview_component_image"+row_no+" > img").attr("src", base_url+"assets/img/image_placeholder.jpg");
                    }
                    $("#componentnamefield"+row_no).val(obj.component_name);
                    $("#component_category"+row_no).val(obj.component_category);
                    $('#component_des' + row_no).val(obj.component_des);
                    $("#component_img"+row_no).val(obj.image);
                    $('#uomfield' + row_no).val(obj.component_uom);
					var ucost_field= parseFloat(obj.component_uc);
                    $('#ucostfield' + row_no).val(ucost_field.toFixed(2));
                    $('#marginfield' + row_no).val("0");
                    $('#marginlinefield' + row_no).val("0.00");
                    $('#linetotalfield' + row_no).val(ucost_field.toFixed(2));
                    $('#order_unit_cost' + row_no).val(ucost_field.toFixed(2));
                    if(obj.specification!="" && obj.specification!=null){
                        $(".specification_container"+row_no).html('<a target="_Blank" href="'+base_url+'assets/component_documents/specification/'+obj.specification+'">'+obj.specification+'</a>');
                        $("#specification"+row_no).val(obj.specification);
                    }
                    if(obj.warranty!="" && obj.warranty!=null){
                        $(".warranty_container"+row_no).html('<a target="_Blank" href="'+base_url+'assets/component_documents/warranty/'+obj.warranty+'">'+obj.warranty+'</a>');
                        $("#warranty"+row_no).val(obj.warranty);
                    }
                    if(obj.maintenance!="" && obj.maintenance!=null){
                        $(".maintenance_container"+row_no).html('<a target="_Blank" href="'+base_url+'assets/component_documents/maintenance/'+obj.maintenance+'">'+obj.maintenance+'</a>');
                        $("#maintenance"+row_no).val(obj.maintenance);
                    }
                    if(obj.installation!="" && obj.installation!=null){
                        $(".installation_container"+row_no).html('<a target="_Blank" href="'+base_url+'assets/component_documents/installation/'+obj.installation+'">'+obj.installation+'</a>');
                        $("#installation"+row_no).val(obj.installation);
                    }
                    if(obj.checklists!="" && obj.checklists!=null){
                        $(".checklist_container"+row_no).html(obj.checklists);
                        $("#checklist"+row_no).val(obj.checklists);
                    }
                    $('.selectpicker').selectpicker('refresh');
                }, "json");
    }
    
    function update_component_unit_cost(){
        $('#componentCostModal').modal('hide'); 
        var rno = $('#update_rno').val();
        var component_id = $('#update_component_id').val();
        var unit_cost = $('#update_invoice_unit_cost').val();
         $.ajax({
                    url: base_url+'supplierz/update_component_unit_cost/',
                    type: 'post',
                    data: {component_id: component_id,unit_cost:unit_cost},
                    beforeSend: function() {
                      //$('#loading-overlay').show();
                    },
                    success: function (result) {
                        
                           var rowno = $('#update_rno').val();
                           $('#componentfield'+rowno).select2({
                        		placeholder: "Select Component",
                        		templateResult: formatComponent,
                        		ajax: {
                        		  type:'post',
                        		  url: base_url+"ajax/components",
                        		  data: function (params) {
                        			return {
                        			  searchTerm: params.term // search term
                        			};
                        		   },
                        			  dataType: 'json',
                        			},
                        			
                        	});
                        	var existing_text = $("#select2-componentfield"+rowno+"-container").text();
                        	var existing_text_array = existing_text.split("|");
                        	var updated_text = existing_text.replace(existing_text_array[1], $('#ucostfield'+rowno).val()+")");
                        	$("#select2-componentfield"+rowno+"-container").text(updated_text);
                            swal({
                                 title: 'Updated Successfully!',
                                 text: 'Component Price Updated.',
                                 type: 'success',
                                 confirmButtonClass: "btn btn-success",
                                 buttonsStyling: false
                           });
                           
                    }
                });
    }
    
    $('.search-component-field').on('keyup', function (e) {
        var keyword = $(this).val();
            $.ajax({
                url: base_url+'supplierz/filter_price_book_components/',
                type: 'post',
                data: {keyword: keyword},
                beforeSend: function() {
                    $('#loading-overlay').show();
                },
                success: function (result) {
                    $('#loading-overlay').hide();
                    $(".pricebook-components-list").html(result);
                    showcolumn("optional");
                }
            });
    });
    
    $('.search-component-field').on('keydown', function (e) {
        var keyword = $(this).val();
            $.ajax({
                url: base_url+'supplierz/filter_price_book_components/',
                type: 'post',
                data: {keyword: keyword},
                beforeSend: function() {
                    $('#loading-overlay').show();
                },
                success: function (result) {
                    $('#loading-overlay').hide();
                    $(".pricebook-components-list").html(result);
                    showcolumn("optional");
                }
            });
    });
    
    $('.import-file-button').on('click', function (e) {
        if($("#PriceBookCSVForm").valid()){
            let files = new FormData(), // you can consider this as 'data bag'
            url = base_url+'supplierz/import_component_by_csv';
            var fileName = $('#importcsv')[0].files;
            files.append('importcsv', fileName[0]); // append selected file to the bag named 'file'
            var lastrow = $("table#impnewitems tbody tr:last-child()").attr('tr_val');
            if (lastrow == 'undefined' || lastrow==undefined) {
                lastrow = 0;
            }
            else{
            lastrow = parseInt(lastrow)+1;
            }
            files.append('last_row', lastrow);
        
            $.ajax({
                type: 'post',
                url: url,
                processData: false,
                contentType: false,
                data: files,
                beforeSend: function() {
                    $('.loader').show();
                },
                success: function (response) {
                    if(response == "Only CSV files are allowed."){
                        $(".import_file_error").show();
                        $(".import_file_error").html("Only CSV files are allowed.");
                    }
                    else if(response == "File format is wrong. Please upload correct file."){
                        $(".import_file_error").show();
                        $(".import_file_error").html("File format is wrong. Please upload correct file.");
                    }
                    else{
                        $('.loader').hide();
                        $('html,body').animate({
                        scrollTop: $("#impnewitems").offset().top},
                        'slow');
                        $('table#impnewitems tbody').append(response); 
                        $('.selectpicker').selectpicker('refresh');
                        $("#PriceBookCSVForm")[0].reset();
                    }
                    
                },
                error: function (err) {
                    console.log(err);
                }
            });
        }
        else{
            setFormValidation("#PriceBookCSVForm");
        }
    });
    
    function changeQTYType(th) {

        var fieldno = $(th).attr('qtype_number');

        if (th.value.toLowerCase() == "manual") {
           $(".formula_btn"+fieldno).addClass("disabled");
           $(".formula_btn"+fieldno).attr("href", "");
           $("#manualqty"+fieldno).attr("required", true);
        }
        else {
           $(".formula_btn"+fieldno).removeClass("disabled");
           $("#manualqty"+fieldno).removeAttr("required");
        }
    }
    
   $('body').on('click','.upload_specification',function(){
      var rowno = $(this).attr("rowno"); 
      $('#specificationModal').modal('show');
      $(".upload_specification_document").attr("rowno", rowno);
    });
    
    $('body').on('click','.upload_warranty',function(){
      var rowno = $(this).attr("rowno");
      $('#warrantyModal').modal('show');
      $(".upload_warranty_document").attr("rowno", rowno);
    });
    
    $('body').on('click','.upload_maintenance',function(){
      var rowno = $(this).attr("rowno");
      $('#maintenanceModal').modal('show');
      $(".upload_maintenance_document").attr("rowno", rowno);
    });
    
    $('body').on('click','.upload_installation',function(){
      var rowno = $(this).attr("rowno");
      $('#installationModal').modal('show');
      $(".upload_installation_document").attr("rowno", rowno);
    });
    
    //Specification Section
    
    $(document).on('submit','.upload_specification_document',function(e){
    e.preventDefault();

    var rowno = $(this).attr("rowno");     
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
                url: base_url+'supplierz/upload_document', 
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
                    $(".upload_specification"+rowno).toggle();
                    $(".upload_specification_document")[0].reset();
                    $(".specification_container"+rowno).html('<a target="_Blank" href="'+base_url+'assets/price_books/component_documents/specification/'+result+'">'+result+'</a><span rowno="'+rowno+'" id="'+result+'" class="remove_specification_file btn btn-icon btn-simple btn-danger material-icons">close</span>');
                    $("#specification"+rowno).val(result);
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
              var rowno = $(this).attr("rowno");
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
                       url:base_url+'supplierz/remove_file',
                       data: {filename:filename,rowno:rowno,type:type},
                       success:function(result){
                           $(".upload_specification"+rowno).toggle();
                           $(".specification_container"+rowno).html("");
                           $("#specification"+rowno).val("");
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

    var rowno = $(this).attr("rowno");     
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
                url: base_url+'supplierz/upload_document', 
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
                    $(".upload_warranty"+rowno).toggle();
                    $(".upload_warranty_document")[0].reset();
                    $(".warranty_container"+rowno).html('<a target="_Blank" href="'+base_url+'assets/price_books/component_documents/warranty/'+result+'">'+result+'</a><span rowno="'+rowno+'" id="'+result+'" class="remove_warranty_file btn btn-icon btn-simple btn-danger material-icons">close</span>');
                    $("#warranty"+rowno).val(result);
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
              var rowno = $(this).attr("rowno");
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
                       url:base_url+'supplierz/remove_file',
                       data: {filename:filename,rowno:rowno,type:type},
                       success:function(result){
                           $(".upload_warranty"+rowno).toggle();
                           $(".warranty_container"+rowno).html("");
                           $("#warranty"+rowno).val("");
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

    var rowno = $(this).attr("rowno");     
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
                url: base_url+'supplierz/upload_document', 
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
                    $(".upload_maintenance"+rowno).toggle();
                    $(".upload_maintenance_document")[0].reset();
                    $(".maintenance_container"+rowno).html('<a target="_Blank" href="'+base_url+'assets/price_books/component_documents/maintenance/'+result+'">'+result+'</a><span rowno="'+rowno+'" id="'+result+'" class="remove_maintenance_file btn btn-icon btn-simple btn-danger material-icons">close</span>');
                    $("#maintenance"+rowno).val(result);
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
              var rowno = $(this).attr("rowno");
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
                       url:base_url+'supplierz/remove_file',
                       data: {filename:filename,rowno:rowno,type:type},
                       success:function(result){
                           $(".upload_maintenance"+rowno).toggle();
                           $(".maintenance_container"+rowno).html("");
                            $("#maintenance"+rowno).val("");
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

    var rowno = $(this).attr("rowno");     
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
                url: base_url+'supplierz/upload_document', 
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
                    $(".upload_installation"+rowno).toggle();
                    $(".upload_installation_document")[0].reset();
                    $(".installation_container"+rowno).html('<a target="_Blank" href="'+base_url+'assets/price_books/component_documents/installation/'+result+'">'+result+'</a><span rowno="'+rowno+'" id="'+result+'" class="remove_installation_file btn btn-icon btn-simple btn-danger"><i class="material-icons">close</span>');
                    $("#installation"+rowno).val(result);
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
              var rowno = $(this).attr("rowno");
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
                       url:base_url+'supplierz/remove_file',
                       data: {filename:filename,rowno:rowno,type:type},
                       success:function(result){
                           $(".upload_installation"+rowno).toggle();
                           $(".installation_container"+rowno).html("");
                           $("#installation"+rowno).val("");
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
              var rowno = $(this).attr("rowno");
              var checklist = $(this).val();
              if(checklist!=""){
                  $(this).val("");
                  var checklist_input = $("#checklist"+rowno).val();
                  $("#checklist"+rowno).val(checklist_input+checklist+",");
                  $(".checklist_container"+rowno).append('<p class="no-padding" checklist="'+checklist+'">'+checklist+'<span rowno="'+rowno+'" class="remove_checklist btn btn-icon btn-simple btn-danger"><i class="material-icons">close</i></span></p>');
                  swal({
                           title: 'Checklist Created!',
                           text: 'Your record has been created.',
                           type: 'success',
                           confirmButtonClass: "btn btn-success",
                           buttonsStyling: false
                    })	
              }
                        
    });
    
    $(document).on('click','.remove_checklist',function(){
        var rowno = $(this).attr("rowno");
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
                    var checklist_input = $("#checklist"+rowno).val();
                    var remove_checklist = $(current).parent("p").attr("checklist")+",";
                    var checklists = checklist_input.replace(String(remove_checklist),"");
                    $("#checklist"+rowno).val(checklists);
                    $(current).parent("p").remove();
                    swal({
                           title: 'Checklist Deleted!',
                           text: 'Your record has been deleted.',
                           type: 'success',
                           confirmButtonClass: "btn btn-success",
                           buttonsStyling: false
                    });	
        });
    });
    
    function showcolumn(type) {
        var column = $("#column_"+type).is(":checked");

         if(column){
            $("."+type+"_column").show();
            } else {
                $("."+type+"_column").hide();
            }
    }
    
    $(document).on('change','#existing_price_book',function(){
              var price_book_id = $(this).val();
              if(price_book_id!=""){
              var last_row = $('#impnewitems >tbody >tr').length;
                    $.ajax({
                       type:'POST',
                       url:base_url+'supplierz/populate_components_by_price_book',
                       data: {price_book_id:price_book_id,last_row:last_row},
                       beforeSend: function() {
                          $('.loader').show();
                        },
                       success: function (result) {
                        $('.loader').hide();
                        response = jQuery.parseJSON(result);
                        $('table#impnewitems tbody').append(response.rData);
                        $('.selectComponent').select2({
                		placeholder: "Select Component",
                		templateResult: formatComponent,
                		ajax: {
                		  type:'post',
                		  url: base_url+"ajax/components",
                		  data: function (params) {
                			return {
                			  searchTerm: params.term // search term
                			};
                		   },
                			  dataType: 'json',
                			},
                			
                	});
                    $('.selectpicker').selectpicker('refresh');
                    showcolumn('optional');
                        swal({
                           title: 'Components Imported by Existing Price Book successfully!',
                           text: 'Your record has been imported.',
                           type: 'success',
                           confirmButtonClass: "btn btn-success",
                           buttonsStyling: false
                           });
                        }
                    }); 		
            }
            else{
            }
    });
    
    $(document).on('click','.btn-accept-request',function(){
              var id = $(this).attr("id");
              swal({
                title: 'Are you sure you want to accept this request?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Yes, accept it!',
                buttonsStyling: false
            }).then(function() {
                    
                    $.ajax({
                       type:'POST',
                       url:base_url+'supplierz/accept_request',
                       data: {id:id},
                       success:function(result){
                           $(".priceBookRequests").html(result);
                           swal({
                           title: 'Accepted!',
                           text: 'Price book request has been accepted.',
                           type: 'success',
                           confirmButtonClass: "btn btn-success",
                           buttonsStyling: false
                           }).catch(swal.noop);
                           $('#priceBookDatatables').dataTable( {
                				"pagingType": "full_numbers",
                                "lengthMenu": [
                                    [10, 25, 50, -1],
                                    [10, 25, 50, "All"]
                                ],
                                destroy: true,
                                responsive: true,
                                language: {
                                    search: "_INPUT_",
                                    searchPlaceholder: "Search records",
                                }
            			    });
                        }
                    }); 		
               });
    });
    
    $(document).on('click','.btn-decline-request',function(){
              var id = $(this).attr("id");
              swal({
                title: 'Are you sure you want to decline this request?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Yes, decline it!',
                buttonsStyling: false
            }).then(function() {
                    
                    $.ajax({
                       type:'POST',
                       url:base_url+'supplierz/decline_request',
                       data: {id:id},
                       success:function(result){
                           $(".priceBookRequests").html(result);
                           swal({
                           title: 'Declined!',
                           text: 'Price book request has been declined.',
                           type: 'success',
                           confirmButtonClass: "btn btn-success",
                           buttonsStyling: false
                           }).catch(swal.noop);
                           $('#priceBookDatatables').dataTable( {
                				"pagingType": "full_numbers",
                                "lengthMenu": [
                                    [10, 25, 50, -1],
                                    [10, 25, 50, "All"]
                                ],
                                destroy: true,
                                responsive: true,
                                language: {
                                    search: "_INPUT_",
                                    searchPlaceholder: "Search records",
                                }
            			    });
                        }
                    }); 		
               });
    });
    
    
    $("#parts_form").submit(function(e){
        e.preventDefault();
        var form = this;
        swal({
                title: 'Are you sure you want to confirm and return?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Yes, confirm and return it!',
                buttonsStyling: false
            }).then(function() {
              form.submit();
            });
    });
    
    $('body').on('click', '.deleterow', function () {

        var row = $(this).attr('rno');
        swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Yes, delete it!',
                buttonsStyling: false
            }).then(function() {
                
                        $("#trnumber"+row).remove();
						
						swal({
                           title: 'Deleted!',
                           text: 'Your record has been deleted.',
                           type: 'success',
                           confirmButtonClass: "btn btn-success",
                           buttonsStyling: false
                        })	
				
            });
    });

    function addMore(val, type='') {
        var lastrow = $("table#partstable tbody tr:last-child()").attr('tr_val');

        if (lastrow == undefined || lastrow=="") {
            lastrow = 0;
        }
        else{
            lastrow = parseInt(lastrow)+1;
        }
        
        var url = "supplierz/populate_new_template_row";
        if(type != ""){
            url = "supplierz/populate_new_costing_row";
        }

        $.ajax({
            url: base_url+url,
            type: 'post',
            data: {next_row: lastrow},
            beforeSend: function() {
              $('.loader').show();
            },
            success: function (result) {
                $('.loader').hide();
                $('table#partstable tbody').append(result);
                if(type != ""){
                     setFormValidation('#ProjectCostingForm');
                }
                else{
                   setFormValidation('#TemplateForm');
                }
                $('.selectpicker').selectpicker('refresh');
                $('[data-toggle="tooltip"]').tooltip();
                $('.selectSupplierzStage').select2({
            		placeholder: "Select Stage",
            		ajax: {
            		  type:'post',
            		  url: base_url+"ajax/getSupplierzStages",
            		  data: function (params) {
            			return {
            			  searchTerm: params.term // search term
            			};
            		   },
            			  dataType: 'json',
            			},
            			
            	});
                $('.selectSupplierzComponent').select2({
						placeholder: "Select Component",
						templateResult: formatComponent,
						ajax: {
						  type:'post',
						  url: base_url+"ajax/getSupplierzComponents",
						  data: function (params) {
							return {
							  searchTerm: params.term // search term
							};
						   },
							  dataType: 'json',
							},
							
					});
            }
        });

    }

    function getTemplatingbyTemplate(id) {
        var todid = "0";
        $(".tod_rows").each(function () {
            todid = todid + ",'" + $(this).attr('tod_id') + "'";


        });
        var lstrow = ($("table tbody tr").length)-1;
        
        if (lstrow == undefined) {
            lstrow = 0;
        }
        else{
            lstrow = parseInt(lstrow)+parseInt(1);
        }

        $.ajax({
            url: base_url+"supplierz/get_templating_by_template/"+id,
            type: 'POST',
            datatype: 'json',
            data: {id: id, last_row: lstrow, todid: todid},
            beforeSend: function() {
              $('.loader').show();
            },
            success: function (result) {
                $('.loader').hide();
                //response = $.parseJSON(result);
                response = result;
                $('table#partstable tbody').append(response.rData);
                setFormValidation('#TemplateForm');
                $('.selectSupplierzStage').select2({
            		placeholder: "Select Stage",
            		ajax: {
            		  type:'post',
            		  url: base_url+"ajax/getSupplierzStages",
            		  data: function (params) {
            			return {
            			  searchTerm: params.term // search term
            			};
            		   },
            			  dataType: 'json',
            			},
            			
            	});
                $('.selectSupplierzComponent').select2({
						placeholder: "Select Component",
						templateResult: formatComponent,
						ajax: {
						  type:'post',
						  url: base_url+"ajax/getSupplierzComponents",
						  data: function (params) {
							return {
							  searchTerm: params.term // search term
							};
						   },
							  dataType: 'json',
							},
							
					});
				$('.selectpicker').selectpicker('refresh');
				$('[data-toggle="tooltip"]').tooltip();
					 
            }
        });


    }
    
    function getProjectCostingbyTemplate(id) {
        var todid = "0";
        $(".tod_rows").each(function () {
            todid = todid + ",'" + $(this).attr('tod_id') + "'";


        });
        var lstrow = ($("table tbody tr").length)-1;
        
        if (lstrow == undefined) {
            lstrow = 0;
        }
        else{
            lstrow = parseInt(lstrow)+parseInt(1);
        }

        $.ajax({
            url: base_url+"supplierz/get_project_costing_by_template/"+id,
            type: 'POST',
            datatype: 'json',
            data: {id: id, last_row: lstrow, todid: todid},
            beforeSend: function() {
              $('.loader').show();
            },
            success: function (result) {
                $('.loader').hide();
                //response = $.parseJSON(result);
                response = result;
                $('table#partstable tbody').append(response.rData);
                setFormValidation('#ProjectCostingForm');
                calculate();
                $('.selectSupplierzStage').select2({
            		placeholder: "Select Stage",
            		ajax: {
            		  type:'post',
            		  url: base_url+"ajax/getSupplierzStages",
            		  data: function (params) {
            			return {
            			  searchTerm: params.term // search term
            			};
            		   },
            			  dataType: 'json',
            			},
            			
            	});
                $('.selectSupplierzComponent').select2({
						placeholder: "Select Component",
						templateResult: formatComponent,
						ajax: {
						  type:'post',
						  url: base_url+"ajax/getSupplierzComponents",
						  data: function (params) {
							return {
							  searchTerm: params.term // search term
							};
						   },
							  dataType: 'json',
							},
							
					});
				$('.selectpicker').selectpicker('refresh');
				$('[data-toggle="tooltip"]').tooltip();
					 
            }
        });


    }
    
    function getProjectCostingbyEditTemplate(id){
        
        $("#add-more-row").show();
        
        var todid = "0";
        $(".tod_rows").each(function () {
            todid = todid + ",'" + $(this).attr('tod_id') + "'";
    
    
        });
    
        var lastrow = $(".partstable:last tbody tr:last-child()").attr('tr_val');
    
        if (lastrow == 'undefined' || lastrow==undefined) {
            lastrow = 0;
        }
        else{
        lastrow = parseInt(lastrow)+1;
        }
        
        var lastrow2 = $("table#add-more-row tbody tr:last-child()").attr('tr_val');
        if (lastrow2 == 'undefined' || lastrow2==undefined) {
            lastrow2 = 0;
        }
        else{
        lastrow = parseInt(lastrow2)+1;
        }
        
        var project_id = $("#current_project_id").val();
        var is_takeoffdata_exists = $("#is_takeoffdata_exists").val();
        
        $.ajax({
        url: base_url+'supplierz/get_project_costing_by_template/'+ id,
        type: 'POST',
        datatype: 'json',
        data: {id: id, last_row: lastrow, todid: todid, project_id:project_id,is_takeoffdata_exists:is_takeoffdata_exists},
        beforeSend: function() {
              $('.loader').show();
        },
        success: function (result) {
            $('.loader').hide();
            //response = $.parseJSON(result);
            response = result;
            $('table#add-more-row tbody').append(response.rData);
            $('.panel-default .panel-collapse').collapse('show');
            if(is_takeoffdata_exists==0){
              $('#table-for-tod').html(response.tData);
              $("#is_takeoffdata_exists").val(1);
            }
            else{
              $(response.tData).insertAfter(".last_takeoff_data");
            }
            $(".tod_rows").each(function () {
            var tdText = $(this).attr("tod_id");
        
            $(".tod_rows")
                .filter(function () { 
                    return tdText == $(this).attr("tod_id"); 
                })
                .not(":first")
                .remove();
            });
            var takeoffdatas = "";
            $(".tod_rows").each(function () {
                takeoffdatas = takeoffdatas+$(this).attr('tod_id')+",";
            });
            $("#takeoffdatas").val(takeoffdatas);
            $('.selectpicker').selectpicker('refresh');
            $('.selectSupplierzStage').select2({
            		placeholder: "Select Stage",
            		ajax: {
            		  type:'post',
            		  url: base_url+"ajax/getSupplierzStages",
            		  data: function (params) {
            			return {
            			  searchTerm: params.term // search term
            			};
            		   },
            			  dataType: 'json',
            			},
            			
            	});
            $('.selectSupplierzComponent').select2({
						placeholder: "Select Component",
						templateResult: formatComponent,
						ajax: {
						  type:'post',
						  url: base_url+"ajax/getSupplierzComponents",
						  data: function (params) {
							return {
							  searchTerm: params.term // search term
							};
						   },
							  dataType: 'json',
							},
							
					});
			setFormValidation('#ProjectCostingForm');
            calculate();
        }
    });
        
    }
    
    function getProjectCostingbyCosting(id) {
        var todid = "0";
        $(".tod_rows").each(function () {
            todid = todid + ",'" + $(this).attr('tod_id') + "'";


        });
        var lstrow = ($("table tbody tr").length)-1;
        
        if (lstrow == undefined) {
            lstrow = 0;
        }
        else{
            lstrow = parseInt(lstrow)+parseInt(1);
        }

        $.ajax({
            url: base_url+"supplierz/get_previous_project_costing/"+id,
            type: 'POST',
            datatype: 'json',
            data: {id: id, last_row: lstrow, todid: todid},
            beforeSend: function() {
              $('.loader').show();
            },
            success: function (result) {
                $('.loader').hide();
                //response = $.parseJSON(result);
                response = result;
                $('table#partstable tbody').append(response.rData);
                setFormValidation('#ProjectCostingForm');
                calculate();
                $('.selectSupplierzStage').select2({
            		placeholder: "Select Stage",
            		ajax: {
            		  type:'post',
            		  url: base_url+"ajax/getSupplierzStages",
            		  data: function (params) {
            			return {
            			  searchTerm: params.term // search term
            			};
            		   },
            			  dataType: 'json',
            			},
            			
            	});
                $('.selectSupplierzComponent').select2({
						placeholder: "Select Component",
						templateResult: formatComponent,
						ajax: {
						  type:'post',
						  url: base_url+"ajax/getSupplierzComponents",
						  data: function (params) {
							return {
							  searchTerm: params.term // search term
							};
						   },
							  dataType: 'json',
							},
							
					});
				$('.selectpicker').selectpicker('refresh');
				$('[data-toggle="tooltip"]').tooltip();
					 
            }
        });


    }
    
    function getProjectCostingbyEditCosting(id) {
    
        $("#add-more-row").show();
        var lastrow = $(".partstable:last tbody tr:last-child()").attr('tr_val');
    
        if (lastrow == 'undefined' || lastrow==undefined) {
            lastrow = 0;
        }
        else{
        lastrow = parseInt(lastrow)+1;
        }
        
        var lastrow2 = $("table#add-more-row tbody tr:last-child()").attr('tr_val');
        if (lastrow2 == 'undefined' || lastrow2==undefined) {
            lastrow2 = 0;
        }
        else{
        lastrow = parseInt(lastrow2)+1;
        }
        

    $.ajax({
        url: base_url+'supplierz/get_previous_project_costing',
        method: 'post',
        datatype: 'json',
        data: {id: id, last_row: lastrow},
        beforeSend: function() {
              $('.loader').show();
        },
        success: function (result) {
            //response = jQuery.parseJSON(result);
            $('.loader').hide();
            response = result;
            $('table#add-more-row tbody').append(response.rData);
            $('.panel-default .panel-collapse').collapse('show');
            $('.selectpicker').selectpicker('refresh');
            $('.selectSupplierzComponent').select2({
						placeholder: "Select Component",
						templateResult: formatComponent,
						ajax: {
						  type:'post',
						  url: base_url+"ajax/components",
						  data: function (params) {
							return {
							  searchTerm: params.term // search term
							};
						   },
							  dataType: 'json',
							},
							
					});
			$('.selectSupplierzStage').select2({
						placeholder: "Select Stage",
						ajax: {
						  type:'post',
						  url: base_url+"ajax/stages",
						  data: function (params) {
							return {
							  searchTerm: params.term // search term
							};
						   },
							  dataType: 'json',
							},
							
					 });
			calculate();

        }
    });

}

    function getTemplateByProjectCosting(id) {
        var todid = "0";
        $(".tod_rows").each(function () {
            todid = todid + ",'" + $(this).attr('tod_id') + "'";


        });
        var lstrow = ($("table tbody tr").length)-1;
        
        if (lstrow == undefined) {
            lstrow = 0;
        }
        else{
            lstrow = parseInt(lstrow)+parseInt(1);
        }

        $.ajax({
            url: base_url+"supplierz/get_templating_by_project_costing/"+id,
            type: 'POST',
            datatype: 'json',
            data: {id: id, last_row: lstrow, todid: todid},
            beforeSend: function() {
              $('.loader').show();
            },
            success: function (result) {
                $('.loader').hide();
                //response = $.parseJSON(result);
                response = result;
                $('table#partstable tbody').append(response.rData);
                setFormValidation('#ProjectCostingForm');
                calculate();
                $('.selectSupplierzStage').select2({
            		placeholder: "Select Stage",
            		ajax: {
            		  type:'post',
            		  url: base_url+"ajax/getSupplierzStages",
            		  data: function (params) {
            			return {
            			  searchTerm: params.term // search term
            			};
            		   },
            			  dataType: 'json',
            			},
            			
            	});
                $('.selectSupplierzComponent').select2({
						placeholder: "Select Component",
						templateResult: formatComponent,
						ajax: {
						  type:'post',
						  url: base_url+"ajax/getSupplierzComponents",
						  data: function (params) {
							return {
							  searchTerm: params.term // search term
							};
						   },
							  dataType: 'json',
							},
							
					});
				$('.selectpicker').selectpicker('refresh');
				$('[data-toggle="tooltip"]').tooltip();
					 
            }
        });


    }
    
    function getTemplateCostingbyEditProjectCosting(id) {
    
        $("#add-more-row").show();
        var lastrow = $(".partstable:last tbody tr:last-child()").attr('tr_val');
    
        if (lastrow == 'undefined' || lastrow==undefined) {
            lastrow = 0;
        }
        else{
        lastrow = parseInt(lastrow)+1;
        }
        
        var lastrow2 = $("table#add-more-row tbody tr:last-child()").attr('tr_val');
        if (lastrow2 == 'undefined' || lastrow2==undefined) {
            lastrow2 = 0;
        }
        else{
        lastrow = parseInt(lastrow2)+1;
        }
        

    $.ajax({
        url: base_url+'supplierz/get_templating_by_project_costing',
        method: 'post',
        datatype: 'json',
        data: {id: id, last_row: lastrow},
        beforeSend: function() {
              $('.loader').show();
        },
        success: function (result) {
            alert("jkjk");
            //response = jQuery.parseJSON(result);
            $('.loader').hide();
            response = result;
            $('table#add-more-row tbody').append(response.rData);
            $('.panel-default .panel-collapse').collapse('show');
            $('.selectpicker').selectpicker('refresh');
            $('.selectSupplierzComponent').select2({
						placeholder: "Select Component",
						templateResult: formatComponent,
						ajax: {
						  type:'post',
						  url: base_url+"ajax/components",
						  data: function (params) {
							return {
							  searchTerm: params.term // search term
							};
						   },
							  dataType: 'json',
							},
							
					});
			$('.selectSupplierzStage').select2({
						placeholder: "Select Stage",
						ajax: {
						  type:'post',
						  url: base_url+"ajax/stages",
						  data: function (params) {
							return {
							  searchTerm: params.term // search term
							};
						   },
							  dataType: 'json',
							},
							
					 });
			calculate();

        }
    });

}
    
    $("#ProjectCostingForm1").submit(function(e){
        e.preventDefault();
        var form = this;
        if($(this).valid()){
            var lstrow = $('#partstable > tbody').find('tr').length;
            var newItemRow = $('#add-more-row > tbody').find('tr').length;
            var project_costing_type = $("#project_costing_type").val();
            if (lstrow > 0 || newItemRow>0) {
                form.submit();
            }
            else {
                swal({
                    title: 'Error!',
                    text: 'Add at least one part to save this costing.',
                    type: 'error',
                    confirmButtonClass: "btn btn-success",
                    buttonsStyling: false
                    })
                return false;
            }
        }
        else{
            setFormValidation("#ProjectCostingForm");
        }
    });
    
    function reinitializeTabs() {
        // Destroy existing tabs
        $('.nav-pills li a').off('click');
    
        // Reinitialize tabs
        $('.nav-pills li a').on('click', function(e) {
            var id = $(this).attr("tab-id");
            $('.tab-pane').removeClass('show active'); // Reset all tab-panes
            $(".tab-pane#"+id).addClass('active');
        });
    }
    
    function modelid(title) {
        $('#modelnumber').val(title);
        var rowno = title.split("_");
        sereal_count = 0;
        $('.addoperator').val('').css('display', 'none');
        $('.addnumber').val('').css('display', 'none');
        $('.addtakeOffData').val('').css('display', 'none');
        $("#addformulavalue").html("");
        $('#formulainput').text('');
        $('#formulatext').text('');
        $('#formulavalue').text('');
        $('.remove_operator').hide();
        $('.remove_number').hide();
        $('.remove_takeoff').hide();
        $('.formula-created').hide();
        $('#is_rounded').prop("checked", false); 
        
        var formula = $("#formulaqty"+title).val();
		  if(formula==0 || formula==""){
				$('#modelnumber').val(title);
				$('#modelforrow').val(rowno[2]);
				$('#simpleModal').modal('show');
		  }
		  else{
			var part_id = $("#tpl_part_id"+rowno[2]).val();
			var formula_qty = $('#formulaqty'+title).val();
			var formula_text = $('#formulatext'+title).val();
			var is_rounded = $('#is_rounded'+title).val();
			$.ajax({
			url: base_url+'supplierz/edit_formula/',
			type: 'post',
			data: {part_id: part_id,formula_qty:formula_qty,formula_text,formula_text,is_rounded:is_rounded},
			beforeSend: function() {
					  $('.loader').show();
					},
					success: function (result) {
					   $('.loader').hide();
					   $('.update-modal-container').html(result);
					   $('#updatemodelnumber').val(title);
					   $('#updatemodelforrow').val(rowno);
					   $('#updateFormulaModal').modal('show');
					   reinitializeTabs();
					   $('.selectpicker').selectpicker('refresh');
					   var formula = $(".updateoperator").length;
                       var formula_2 = $(".updatetakeOffData").length;
                        
                       var formula_3 = $(".updatenumber").length;
                        
                       var total_inputs = (formula + formula_2 + formula_3 );
					   sereal_count = total_inputs;
					 }
				   });

		  }
    }
    function menulQuantity(title) {

        $('#viewquanity' + title).text('');
        $('#formula' + title).val('');
        $('#formulaqty' + title).val('');
        $('#formulatext' + title).val('');
    }
    
    function GetFormula() {
        if (sereal_count == 0) {
            $(".formula-error").show();
            return false;
        }
        $(".formula-error").hide();
        $(".formula-created").show();
        $('#formulainput').text('');
        $('#formulavalue').text('');
        $('#formulatext').text('');
        var partid = $('#modelnumber').val();
        var formula = $("#addformulavalue .addoperator").length;
        var formula_2 = $("#addformulavalue .addtakeOffData").length;
        
        var formula_3 = $("#addformulavalue .addnumber").length;
        
        var total_inputs = (formula + formula_2 + formula_3 );
        var k = 1;
		var i=0;
        var my_formula = '';
        var my_formula_values = '';
        var my_formula_text = '';
		var selected_ids = new Array();
		var todid = 0;
        for (k; k <= total_inputs; k++) {
            var current_selector = '[my-check="sereal'+k+'"]';

            if ($(current_selector).attr('name') == 'operator') {
                var current_value = $(current_selector).val();
                var current_formula_value = $(current_selector).val();
                var current_formula_text = $(current_selector).find("option:selected").val();
            }
            else if ($(current_selector).attr('name') == 'takeoffdata') {
                 var current_value = "|"+$(current_selector).val();
                 var current_formula_value = $(current_selector).find("option:selected").attr("title");
    			 selected_ids[i]= $(current_selector).find("option:selected").val();
    			 var tod_id = $(current_selector).find("option:selected").attr("tod_id");
    			 todid = todid+",'"+tod_id+"'";
    			 i++;
    			 var current_formula_text = $(current_selector).find("option:selected").text();
            }
            else {
                var current_value = $(current_selector).val();
                var current_formula_value = $(current_selector).val();
                var current_formula_text = $(current_selector).val();
				 
            }
            
            my_formula_text+= current_formula_text;
            my_formula_values+= current_formula_value;
            my_formula+= current_value;
            my_formula+= ',';
        }
        //if (formula == 0) {
            
            //$('#formula' + partid).val($('#takeoffdata').find("option:selected").attr("title"));

        //}
        //else {
            
            $("#formulainput").append(my_formula);
            $("#formulavalue").append(my_formula_values);
            $("#formulatext").append("Formula : "+my_formula_text);

            
            $('#formula' + partid).val($('#formulainput').text());

            // $('#formulaqty' + partid).val($('#formulavalue').text());
            $('#formulaqty' + partid).val($('#formulainput').text());
            $('#formulatext' + partid).val($('#formulatext').text());
            $('#is_rounded' + partid).val($('#is_rounded').val());
            $('#my_id' + partid).html($('#formulatext').text());
            //$('#my_id_stage_' + partid).html($('#formulatext').text());
            var rowNo = partid.split("_");
            $('.calculatedFormula'+rowNo[2]).attr("data-container", "body");
            $('.calculatedFormula'+rowNo[2]).attr("data-toggle", "tooltip");
            $('.calculatedFormula'+rowNo[2]).attr("data-original-title", $('#formulatext').text());
            $('[data-toggle="tooltip"]').tooltip();


        //}
    } //end GetFormula


    var removeTakeoff = $(".addformula").length;

    if (removeTakeoff == 2)
    {
        $(".removeTakeoffDiv").hide();
    }
    function removeTakeoffDiv() {
        var addformula = $(".addformula").length;
        if (addformula > 1)
        {
            $("#addformula" + addformula).remove();
        }
        if (addformula == 2)
        {
            $(".removeTakeoffDiv").hide();
        }
    }
	
	function remove_operator() {
        sereal_count = new Number(sereal_count - 1);
        var addformula = $(".addoperator").length;
        if (addformula > 1)
        {
            $("#addoperator" + addformula).remove();
        }
        if (addformula == 2)
        {
            $(".remove_operator").hide();
        }
        
        reset_sereal_count();

    }
	
	function remove_takeoff() {
        sereal_count = new Number(sereal_count - 1);
        var addformula = $(".addtakeOffData").length;
        addformula--;
        if (addformula > 0)
        {
            $("#addtakeOffData" + addformula).remove();
        }
        if (addformula == 1)
        {
            $(".remove_takeoff").hide();
        }
        
        reset_sereal_count();

    }
    
    function remove_number() {
        sereal_count = new Number(sereal_count - 1);
        var addformula = $(".addnumber").length;
        if (addformula > 1)
        {
            $("#addnumber" + addformula).remove();
        }
        if (addformula == 2)
        {
            $(".remove_number").hide();
        }
        reset_sereal_count();

    }
	
	function addMoreoperators() {
        $(".remove_operator").show();
        sereal_count = new Number(sereal_count + 1);
        var num = $('.addoperator').length;
        var newNum = new Number(num + 1);
        var newElem = $('#addoperator0').clone().attr('id', 'addoperator' + newNum).appendTo("div#addformulavalue");
        $('#addoperator' + newNum + ' ' +'select').attr('my-check', 'sereal'+sereal_count);
        $('#addoperator' + newNum + ' ' +'select').addClass('formula_field');
        
        $('div #addoperator' + newNum + ' #operator' + num).attr('id', 'operator' + newNum);
        $('#addoperator' + newNum).show();
    }
	
	function addMoreTakeoff() {
        
        // Show the remove button
        $(".remove_takeoff").show();
        
        // Increment the serial count
        sereal_count = Number(sereal_count + 1);
        
        // Get the current count of .addtakeOffData elements
        var num = $('#addformulavalue .addtakeOffData').length;
        var newNum = num + 1;
         
        // Clone the element and update attributes
        var newElem = $('#addtakeOffData0').clone().attr('id', 'addtakeOffData' + newNum);
        newElem.find('label').attr('for', 'takeoffdata' + newNum);
        newElem.find('select').attr('my-check', 'sereal' + sereal_count);
        newElem.find('select').attr('id', 'takeoffdata' + newNum);
        newElem.find('select').addClass('selectpicker');
        newElem.find('select').attr('data-live-search', 'true');
        newElem.find('select').attr('data-style', 'select-with-transition');
        
        // Append the cloned element to the container
        newElem.appendTo("#addformulavalue");
        
        // Re-initialize the selectpicker after cloning
        newElem.find('select').selectpicker();
        
        
        newElem.find('#takeoffdata'+newNum).addClass('formula_field');
    
        // Show the newly cloned element
        newElem.show();

    }
   
    function addMoreNumber() {
        $(".remove_number").show();
        sereal_count = new Number(sereal_count + 1);
        var num = $('.addnumber').length;
        if (num == 1) {
            var test_num = '';
        }
        else {
            test_num = new Number(num - 1);
        }
        var newNum = new Number(num + 1);
        var newElem = $('#addnumber0').clone().attr('id', 'addnumber' + newNum).appendTo("div#addformulavalue");
        $('#addnumber' + newNum + ' ' +'input').attr('my-check', 'sereal'+sereal_count);
        $('[my-check="sereal'+sereal_count+'"]').val('');
        $('#addnumber' + newNum + ' ' +'input').addClass('formula_field');
        $('div #addnumber' + newNum + ' #takeoffdata_number' + test_num).attr('id', 'takeoffdata_number' + num);
        $('#addnumber' + newNum).show();
    }
    
    function update_addMoreoperators() {
  $(".remove_operator").show();
  sereal_count = new Number(sereal_count + 1);
  var num = $('.updateoperator').length;
  if (num == 0) {
    var test_num = '';
  }
  else {
    test_num = new Number(num - 1);
  }
  var newNum = new Number(num + 1);
  var newElem = $('#updateoperator0').clone().attr('id', 'updateoperator' + newNum).appendTo("div#updateformulavalue");
  $('#updateoperator' + newNum).attr('class', 'updateoperator');
  $('#updateoperator' + newNum + ' ' +'select').attr('my-check', 'updatesereal'+sereal_count);
  $('#updateoperator' + newNum + ' ' +'select').addClass('formula_field');
  $('div #updateoperator' + newNum + ' ' +'select').attr('id', 'operator' + newNum);
  $('div #updateoperator' + newNum + ' #operator' + newNum).addClass("formula_field");
  $('#updateoperator' + newNum).show();
}

    function update_addMoreTakeoff() {
        // Show the remove button
        $(".remove_takeoff").show();
        
        // Increment the serial count
        sereal_count = Number(sereal_count + 1);
        
        // Get the current count of .addtakeOffData elements
        var num = $('.updatetakeOffData').length;
        var newNum = num + 1;
         
        // Clone the element and update attributes
        var newElem = $('#updatetakeOffData0').clone().attr('id', 'updatetakeOffData' + newNum);
        newElem.addClass('updatetakeOffData');
        newElem.find('label').attr('for', 'takeoffdata' + newNum);
        newElem.find('select').attr('my-check', 'updatesereal' + sereal_count);
        newElem.find('select').attr('id', 'takeoffdata' + newNum);
        newElem.find('select').addClass('selectpicker');
        newElem.find('select').attr('data-live-search', 'true');
        newElem.find('select').attr('data-style', 'select-with-transition');
        
        // Append the cloned element to the container
        newElem.appendTo("#updateformulavalue");
        
        // Re-initialize the selectpicker after cloning
        newElem.find('select').selectpicker();
        
        newElem.find('#takeoffdata'+newNum).addClass('formula_field');
    
        // Show the newly cloned element
        newElem.show();
    }

    function update_addMoreNumber() {
  $(".remove_number").show();
  sereal_count = new Number(sereal_count + 1);
  var num = $('.updatenumber').length;
  if (num == 0) {
    var test_num = '';
  }
  else {
    test_num = new Number(num - 1);
  }
  var newNum = new Number(num + 1);
  var newElem = $('#updatenumber0').clone().attr('id', 'updatenumber' + newNum).appendTo("div#updateformulavalue");
  $('#updatenumber' + newNum).attr('class', 'updatenumber');
  $('#updatenumber' + newNum + ' ' +'input').attr('my-check', 'updatesereal'+sereal_count);
  $('#updatenumber' + newNum + ' ' +'input').addClass('formula_field');
  $('[my-check="sereal'+sereal_count+'"]').val('');
  $('div#updatenumber' + newNum + ' ' +'input').attr('id', 'takeoffdata_number' + newNum);
  $('div#updatenumber' + newNum + ' #takeoffdata_number' + newNum).addClass("formula_field");
  $('#updatenumber' + newNum).show();
}

    function reset_sereal_count(){
          var i = 1;
          $(".bootstrap-select").removeClass("formula_field").removeAttr("my-check");
          $('.formula_field').each(function() {
          $( this ).attr('my-check', 'sereal'+i);
          i++;
          });
    }

    function update_popup_remove_operator() {
      sereal_count = new Number(sereal_count - 1);
      var addformula = $(".updateoperator").length;
      if (addformula > 0)
      {
        $("#updateoperator" + addformula).remove();
      }
      if (addformula == 1)
      {
        $(".remove_operator").hide();
      }
      
      var i = 1;
      $( ".formula_field" ).each(function() {
      $( this ).attr('my-check', 'updatesereal'+i);
      i++;
      });
    
    }
    
    function update_popup_remove_takeoff() {
      sereal_count = new Number(sereal_count - 1);
      var addformula = $(".updatetakeOffData").length;
      if (addformula > 0)
      {
        $("#updatetakeOffData" + addformula).remove();
      }
      if (addformula == 1)
      {
        $(".remove_takeoff").hide();
      }
      $(".bootstrap-select").removeClass("formula_field").removeAttr("my-check");
      var i = 1;
      $( ".formula_field" ).each(function() {
      $( this ).attr('my-check', 'updatesereal'+i);
      i++;
      });
    
    }
    
    function update_popup_remove_number() {
      sereal_count = new Number(sereal_count - 1);
      var addformula = $(".updatenumber").length;
      if (addformula > 0)
      {
        $("#updatenumber" + addformula).remove();
      }
      if (addformula == 1)
      {
        $(".remove_number").hide();
      }
      
      var i = 1;
      $( ".formula_field" ).each(function() {
      $( this ).attr('my-check', 'updatesereal'+i);
      i++;
      });
    
    }

    function GetUpdateFormula() {
      if (sereal_count == 0) {
        $(".formula-error").show();
        return false;
      }
      $(".formula-error").hide();
      $(".formula-created").show();
      $('#updateformulainput').text('');
      $('#updateformula').text('');
      $('#updateformulatext').text('');
      var partid = $('#updatemodelnumber').val();
      var formula = $(".updateoperator").length;
      var formula_2 = $(".updatetakeOffData").length;
      var formula_3 = $(".updatenumber").length;
        
        var total_inputs = (formula + formula_2 + formula_3 );
        var k = 1;
        var i=0;
        var my_formula = '';
        var my_formula_values = '';
        var my_formula_text = '';
        var selected_ids = new Array();
        var todid = 0;

        for (k; k <= total_inputs; k++) {
          var current_selector = '[my-check="updatesereal'+k+'"]';
          if ($(current_selector).attr('name') == 'takeoffdata') {
           var current_value = "|"+$(current_selector).val();
         }
         else{
          var current_value = $(current_selector).val();
        }

        if ($(current_selector).attr('name') == 'operator') {
          var current_formula_value = $(current_selector).val();
        }
        else if ($(current_selector).attr('name') == 'takeoffdata') {
          var current_formula_value = $(current_selector).find("option:selected").attr("title");
          selected_ids[i]= $(current_selector).find("option:selected").val();
          var tod_id = $(current_selector).find("option:selected").attr("tod_id");
          todid = todid+",'"+tod_id+"'";
          i++;
        }
        else {
          var current_formula_value = $(current_selector).val();

        }
        if ($(current_selector).attr('name') == 'operator') {
          var current_formula_text = $(current_selector).find("option:selected").val();
        }
        else if ($(current_selector).attr('name') == 'takeoffdata_number') {
          var current_formula_text = $(current_selector).val();
        }
        else{
         var current_formula_text = $(current_selector).find("option:selected").text();
       }
       my_formula_text+= current_formula_text;
       my_formula_values+= current_formula_value;
            my_formula+= current_value;
            my_formula+= ',';
          }
          /*if (formula == 0) {

            $('#formula' + partid).val($('#takeoffdata').find("option:selected").attr("title"));

          }
          else {*/
            $("#updateformulainput").append(my_formula);
            $("#updateformula").append(my_formula_values);
            $("#updateformulatext").append("Formula : "+my_formula_text);
			$(".existing_formula").hide();
            
            $('#formula' + partid).val($('#updateformulainput').text());

            // $('#formulaqty' + partid).val($('#formulavalue').text());
            $('#formulaqty' + partid).val($('#updateformulainput').text());
            $('#formulatext' + partid).val($('#updateformulatext').text());
			var is_rounded = 0;
			if($('#is_rounded_update').prop("checked") == true){
				is_rounded = 1;
			}
			$('#is_rounded' + partid).val(is_rounded);
            $('#my_id' + partid).html($('#updateformulatext').text());
            var rowNo = partid.split("_");
            $('.calculatedFormula'+rowNo[2]).removeAttr("data-container");
            $('.calculatedFormula'+rowNo[2]).removeAttr("data-toggle");
            $('.calculatedFormula'+rowNo[2]).removeAttr("data-original-title");
            $('.calculatedFormula'+rowNo[2]).attr("data-container", "body");
            $('.calculatedFormula'+rowNo[2]).attr("data-toggle", "tooltip");
            $('.calculatedFormula'+rowNo[2]).attr("data-original-title", $('#updateformulatext').text());
            $('[data-toggle="tooltip"]').tooltip();
          //}
    }
    
    $(document).on('click','.btn-accept-template-request',function(){
              var id = $(this).attr("id");
              swal({
                title: 'Are you sure you want to accept this request?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Yes, accept it!',
                buttonsStyling: false
            }).then(function() {
                    
                    $.ajax({
                       type:'POST',
                       url:base_url+'supplierz/accept_template_request',
                       data: {id:id},
                       success:function(result){
                           $(".templateRequests").html(result);
                           swal({
                           title: 'Accepted!',
                           text: 'Template request has been accepted.',
                           type: 'success',
                           confirmButtonClass: "btn btn-success",
                           buttonsStyling: false
                           }).catch(swal.noop);
                           $('#templateRequestDatatables').dataTable( {
                				"pagingType": "full_numbers",
                                "lengthMenu": [
                                    [10, 25, 50, -1],
                                    [10, 25, 50, "All"]
                                ],
                                destroy: true,
                                responsive: true,
                                language: {
                                    search: "_INPUT_",
                                    searchPlaceholder: "Search records",
                                }
            			    });
                        }
                    }); 		
               });
    });
    
    $(document).on('click','.btn-decline-template-request',function(){
              var id = $(this).attr("id");
              swal({
                title: 'Are you sure you want to decline this request?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Yes, decline it!',
                buttonsStyling: false
            }).then(function() {
                    
                    $.ajax({
                       type:'POST',
                       url:base_url+'supplierz/decline_template_request',
                       data: {id:id},
                       success:function(result){
                           $(".templateRequests").html(result);
                           swal({
                           title: 'Declined!',
                           text: 'Template request has been declined.',
                           type: 'success',
                           confirmButtonClass: "btn btn-success",
                           buttonsStyling: false
                           }).catch(swal.noop);
                           $('#templateRequestDatatables').dataTable( {
                				"pagingType": "full_numbers",
                                "lengthMenu": [
                                    [10, 25, 50, -1],
                                    [10, 25, 50, "All"]
                                ],
                                destroy: true,
                                responsive: true,
                                language: {
                                    search: "_INPUT_",
                                    searchPlaceholder: "Search records",
                                }
            			    });
                        }
                    }); 		
               });
    });
    
    function calculateTotal(rowno) {

    var ucost = $("#ucostfield" + rowno).val();
    if(parseFloat(ucost)<0){
        swal({
            title: 'Incorrect Currency Value!',
            text: 'Please enter positive value only.',
            type: 'warning',
            confirmButtonClass: "btn btn-warning",
            buttonsStyling: false
        })
       ucost = 0;
    }
    
    if(parseFloat($("#order_unit_cost"+rowno).val()).toFixed(2)==$("#order_unit_cost"+rowno).val()){
          var order_cost = $("#order_unit_cost"+rowno).val();
    }
    else{
      
        var order_cost = parseFloat($("#order_unit_cost"+rowno).val()).toFixed(2);
    }
  
    var unit_cost = $("#ucostfield"+rowno).val();
    var component_id = $("#componentfield"+rowno).val();
    
    if(order_cost!=unit_cost && order_cost!="0.00"){
        $("#componentCostModal #update_component_id").val(component_id);
        $("#componentCostModal #update_invoice_unit_cost").val(unit_cost);
        $("#componentCostModal #invoice_unit_cost").val(unit_cost);
        $("#componentCostModal #current_unit_cost").val(order_cost);
        $("#update_rno").val(rowno);
        $('#componentCostModal').modal('show'); 
    }

    $("#ucostfield" + rowno).val(parseFloat(ucost).toFixed(2));
    var margin_total = parseFloat($("#marginlinefield" + rowno).val());
    if (isNaN(ucost)) {
        ucost = 0;
    } else {
        ucost = ucost;
    }

    var margin = parseFloat($("#marginfield"+rowno).val());
    if (isNaN(margin)) {
        margin = 0;
    }
    var marginline = (margin / 100) * ucost;
   
    var vtotal = parseFloat(marginline) + parseFloat(ucost) + parseFloat(margin_total);
    if (isNaN(vtotal)) {
        vtotal = 0;
    }
    $('#linetotalfield' + rowno).val(parseFloat(vtotal).toFixed(2));
}

    $('body').on('click', '.include_in_price_book', function(){
        var include_in_price_book = $(this).prop("checked") == true ? 1 : 0;
        var id = $(this).val();
        var current = $(this);
        if(include_in_price_book == 0){
            swal({
                title: 'Are you sure?',
                text: "This component is in use, unchecking will delete this item from pricebook and templates. Do you wish to proceed?",
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
                url:base_url+'supplierz/include_component_in_price_book',
                data: {id:id,include_in_price_book:include_in_price_book},
                success:function(result){
                    if(include_in_price_book == 1){
                      //window.location.href = base_url+'supplierz/price_books';
                      swal({
                           title: 'Component Successfully Added!',
                           text: 'The selected component has been successfully included in the Price Book. You can now review or modify its details.',
                           type: 'success',
                           confirmButtonClass: "btn btn-success",
                           buttonsStyling: false
                        });
                    }
                    else{
                        swal({
                           title: 'Component Successfully Removed!',
                           text: 'The selected component has been excluded from your Price Book. You can add it back anytime if needed.',
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
                url:base_url+'supplierz/include_component_in_price_book',
                data: {id:id,include_in_price_book:include_in_price_book},
                success:function(result){
                    if(include_in_price_book == 1){
                      //window.location.href = base_url+'supplierz/price_books';
                      swal({
                           title: 'Component Successfully Added!',
                           text: 'The selected component has been successfully included in the Price Book. You can now review or modify its details.',
                           type: 'success',
                           confirmButtonClass: "btn btn-success",
                           buttonsStyling: false
                        });
                    }
                    else{
                        swal({
                           title: 'Component Successfully Removed!',
                           text: 'The selected component has been excluded from your Price Book. You can add it back anytime if needed.',
                           type: 'success',
                           confirmButtonClass: "btn btn-success",
                           buttonsStyling: false
                        });	
                    }
                }
        }); 
        }
   });
   
    $('body').on('click', '.exclude_from_price_book', function(){
        var include_in_price_book = $(this).prop("checked") == true ? 1 : 0;
        var current = $(this);
        if(include_in_price_book == 0){
            swal({
                title: 'Are you sure?',
                text: "This component is in use, unchecking will delete this item from pricebook and templates. Do you wish to proceed?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                buttonsStyling: false
            }).then(function() {
                $(current).closest("td").parent("tr").remove();  
            }, function(dismiss) {
                if (dismiss === 'cancel') {
                    $(current).prop("checked", true);
                }
            });
        }
        else{
          $(current).closest("td").parent("tr").remove(); 
        }
   });
   
    $('body').on('click', '.price_book_shared', function(){
        var price_book_shared = $(this).prop("checked") == true ? 1 : 0;
        var user_id = $(this).val();
        $.ajax({
                type:'POST',
                url:base_url+'supplierz/allocate_price_book_to_builderz',
                data: {user_id:user_id,price_book_shared:price_book_shared},
                success:function(result){
                    if(price_book_shared == 1){
                      swal({
                           title: 'Price Book Access Update',
                           text: 'Price Book Access Update: A Builderz User Has Been Added.',
                           type: 'success',
                           confirmButtonClass: "btn btn-success",
                           buttonsStyling: false
                        });
                    }
                    else{
                        swal({
                           title: 'Price Book Access Update',
                           text: 'Price Book Access Update: A Builderz User Has Been Removed.',
                           type: 'error',
                           confirmButtonClass: "btn btn-danger",
                           buttonsStyling: false
                        });	
                    }
                }
        }); 
        
   });
   
$('body').on('click', '.available_for_builderz', function(){
        var available_for_builderz = $(this).prop("checked") == true ? 1 : 0;
        var id = $(this).val();
        var current = $(this);
        if(available_for_builderz == 0){
            swal({
                title: 'Are you sure?',
                text: "This designz is in use, unchecking will hide this designz from Builderz users. Do you wish to proceed?",
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
                url:base_url+'supplierz/available_for_builderz',
                data: {id:id,available_for_builderz:available_for_builderz},
                success:function(result){
                    if(available_for_builderz == 1){
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
                           text: 'The selected designz will not be available for Builderz users. You can add it back anytime if needed.',
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
                url:base_url+'supplierz/available_for_builderz',
                data: {id:id,available_for_builderz:available_for_builderz},
                success:function(result){
                    if(available_for_builderz == 1){
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
                           text: 'The selected designz will not be available for Builderz users. You can add it back anytime if needed.',
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
    
    var myDropzone = new Dropzone("#imagesDropzone", {
        url: base_url+"/supplierz/upload_designz_files/image", // File upload URL
        autoProcessQueue: true, // Automatically upload the file when added
        /*maxFiles: 5, // Allow up to 5 files*/
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
                    dz.emit("thumbnail", mockFile, base_url+'assets/designz_uploads/thumbnail/' + file.file_name); // Path to image
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
        url: base_url+"/supplierz/upload_designz_files/plan", // File upload URL
        autoProcessQueue: true, // Automatically upload the file when added
        /*maxFiles: 5, // Allow up to 5 files*/
        maxFilesize: 10, // Max file size in MB
        addRemoveLinks: true, // Show remove link on the file thumbnail
        /*parallelUploads: 5, // Number of parallel uploads*/
        init: function () {
            var dz = this;
            
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
                    dz.emit("thumbnail", mockFile, base_url+'assets/designz_uploads/thumbnail/' + file.file_name); // Path to image
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
            
            dz.on("removedfile", function(file) {
                
            });
    
            // Handle errors during the file upload
            dz.on("error", function (file, errorMessage) {
                console.log("Error while uploading file: ", errorMessage);
            });
        }
    });
}

$('.import-template-button').on('click', function (e) {
        if($("#TemplateCSVForm").valid()){
            let files = new FormData(), // you can consider this as 'data bag'
            url = base_url+'supplierz/import_template_by_csv';
            var fileName = $('#importcsv')[0].files;
            files.append('importcsv', fileName[0]); // append selected file to the bag named 'file'
            var lastrow = $("table#partstable tbody tr:last-child()").attr('tr_val');
            if (lastrow == 'undefined' || lastrow==undefined) {
                lastrow = 0;
            }
            else{
            lastrow = parseInt(lastrow)+1;
            }
            files.append('last_row', lastrow);
        
            $.ajax({
                type: 'post',
                url: url,
                processData: false,
                contentType: false,
                data: files,
                beforeSend: function() {
                    $('.loader').show();
                },
                success: function (response) {
                    if(response == "Only CSV files are allowed."){
                        $(".import_file_error").show();
                        $(".import_file_error").html("Only CSV files are allowed.");
                    }
                    else if(response == "File format is wrong. Please upload correct file."){
                        $(".import_file_error").show();
                        $(".import_file_error").html("File format is wrong. Please upload correct file.");
                    }
                    else{
                        $('.loader').hide();
                        $('table#partstable tbody').append(response); 
                        $('.selectpicker').selectpicker('refresh');
                        calculate();
                        $("#TemplateCSVForm")[0].reset();
                    }
                    
                },
                error: function (err) {
                    console.log(err);
                }
            });
        }
        else{
            setFormValidation("#TemplateCSVForm");
        }
    });
    

$(document).on('click','.set_as_thumbnail',function(){
    var image = $(this).val();
    $("#thumbnail").attr("src", base_url+"assets/designz_uploads/thumbnail/"+image);
});


$(document).on('click','.set_plan_as_thumbnail',function(){
    var image = $(this).val();
    $("#plan_thumbnail").attr("src", base_url+"assets/designz_uploads/thumbnail/"+image);
});


    function calcuate_costing_totals() {
        var psubtotal1 = $("#total_cost").val();
        var linemargins = $("#line_margins").val();
    
        var oh_margin = isNaN($("#overhead_margin").val()) ? 0 : $("#overhead_margin").val();
        var p_margin = isNaN($("#profit_margin").val()) ? 0 : $("#profit_margin").val();
        var c_tax = isNaN($("#costing_tax").val()) ? 0 : $("#costing_tax").val();
        //var psubtotal2 = isNaN($("#total_cost2").val()) ? 0 : $("#total_cost2").val();
        //var psubtotal3 = isNaN($("#total_cost3").val()) ? 0 : $("#total_cost3").val();
    
        var ppercent = (parseFloat(p_margin) / 100) * parseFloat(psubtotal1);
        $(".calculatedProfitMargin").text(ppercent.toFixed(2));
        var profitMarginSubtotal = parseFloat(linemargins) + ppercent;
        $("#profitMarginSubtotal").val(profitMarginSubtotal.toFixed(2));
        $(".profitMarginSubtotal").text(profitMarginSubtotal.toFixed(2));
        
        var profitMarginSubtotalValue = $("#profitMarginSubtotal").val();
        var opercent = (parseFloat(oh_margin) / 100) * parseFloat(psubtotal1);
        $(".calculatedOverheadMargin").text(opercent.toFixed(2));
        var overheadMarginSubtotal = parseFloat(profitMarginSubtotalValue) + opercent;
        $("#overheadMarginSubtotal").val(overheadMarginSubtotal.toFixed(2));
        $(".overheadMarginSubtotal").text(overheadMarginSubtotal.toFixed(2));
        $("#total_cost2").val(overheadMarginSubtotal.toFixed(2));
        
        var overheadMarginSubtotalValue = $("#overheadMarginSubtotal").val();
    
        var tax_percent = (parseFloat(c_tax) / 100) * overheadMarginSubtotalValue;
        var gstSubtotal = parseFloat(tax_percent) + parseFloat(overheadMarginSubtotalValue);
        $(".calculatedGST").text(tax_percent.toFixed(2));
        $(".gstSubtotal").text(gstSubtotal.toFixed(2));
        $("#gstSubtotal").val(gstSubtotal.toFixed(2));
        $("#total_cost3").val(gstSubtotal.toFixed(2));
        var contractPrice = (parseFloat(gstSubtotal)+parseFloat($("#price_rounding").val())).toFixed(2);
        $(".priceRoundingSubtotal").text(contractPrice);
        $("#priceRoundingSubtotal").val(contractPrice);
        $("#contract_price").val(contractPrice);
    }
    
    function addMorePart(val) {
        $("#add-more-row").show();
        var lastrow = $(".partstable:last tbody tr:last-child()").attr('tr_val');
    
        if (lastrow == 'undefined' || lastrow==undefined) {
            lastrow = 0;
        }
        else{
        lastrow = parseInt(lastrow)+1;
        }
        
        var lastrow2 = $("table#add-more-row tbody tr:last-child()").attr('tr_val');
        if (lastrow2 == 'undefined' || lastrow2==undefined) {
            lastrow2 = 0;
        }
        else{
        lastrow = parseInt(lastrow2)+1;
        }
        
        $.ajax({
            url: base_url+"supplierz/populate_new_costing_row",
            type: 'post',
            data: {next_row: lastrow},
            beforeSend: function() {
              $('.loader').show();
            },
            success: function (result) {
                $('.loader').hide();
                $('table#add-more-row tbody').append(result);
                $('.panel-default .panel-collapse').collapse('show');
                setFormValidation('#ProjectCostingForm');
                $('.selectpicker').selectpicker('refresh');
                $('[data-toggle="tooltip"]').tooltip();
                $('.selectSupplierzStage').select2({
            		placeholder: "Select Stage",
            		ajax: {
            		  type:'post',
            		  url: base_url+"ajax/getSupplierzStages",
            		  data: function (params) {
            			return {
            			  searchTerm: params.term // search term
            			};
            		   },
            			  dataType: 'json',
            			},
            			
            	});
                $('.selectSupplierzComponent').select2({
						placeholder: "Select Component",
						templateResult: formatComponent,
						ajax: {
						  type:'post',
						  url: base_url+"ajax/getSupplierzComponents",
						  data: function (params) {
							return {
							  searchTerm: params.term // search term
							};
						   },
							  dataType: 'json',
							},
							
					});
            }
        });

    }

    
    $('body').on('change', '.roundme', function () {
      var s6=$("#total_cost3").val();
      var s7=$("#price_rounding").val();
      var s8 = parseFloat(s6)+parseFloat(s7);
      $("#contract_price").val(s8.toFixed(2));
      $(".priceRoundingSubtotal").text(s8.toFixed(2));
      $("#priceRoundingSubtotal").val(s8.toFixed(2));
    });
    
    $('body').on('change', '.profitMargin', function () {
        var totalProfitMargin = 0.00;
        $(".profitMargin").each(function () {
            totalProfitMargin = parseFloat(totalProfitMargin) + parseFloat($(this).val());
        });
        $(".sumOfMargins").text(parseFloat(totalProfitMargin).toFixed(2));
        var projectSubtotal = $("#total_cost").val();
        var totalLineMargins = parseFloat(projectSubtotal) + parseFloat(totalProfitMargin);
        $("#line_margins").val(parseFloat(totalLineMargins).toFixed(2));
        $(".totalLineMargins").text(parseFloat(totalLineMargins).toFixed(2));
        calcuate_costing_totals();
    });
    
    function calculateTotal(rowno) {
    var mqty = $("#manualqty" + rowno).val();
    var ucost = $("#ucostfield" + rowno).val();
    
    if(mqty!="" && ucost!=""){
        if(parseFloat(mqty)<0){
            	swal({
                    title: 'Incorrect Quantity!',
                    text: 'Please enter correct quantity.',
                    type: 'warning',
                    confirmButtonClass: "btn btn-warning",
                    buttonsStyling: false
                })	
            $("#manualqty" + rowno).val(0);
            mqty = 0;
        }
        if(parseFloat(ucost)<0){
            swal({
                title: 'Incorrect Currency Value!',
                text: 'Please enter positive value only.',
                type: 'warning',
                confirmButtonClass: "btn btn-warning",
                buttonsStyling: false
            })
           ucost = 0;
        }
    
        if(parseFloat($("#order_unit_cost"+rowno).val()).toFixed(2)==$("#order_unit_cost"+rowno).val()){
              var order_cost = $("#order_unit_cost"+rowno).val();
        }
        else{
          
            var order_cost = parseFloat($("#order_unit_cost"+rowno).val()).toFixed(2);
        }
  
        var unit_cost = $("#ucostfield"+rowno).val();
        var component_id = $("#componentfield"+rowno).val();
        
        if(order_cost!=unit_cost && order_cost!="0.00"){
            $("#componentCostModal #update_component_id").val(component_id);
            $("#componentCostModal #update_invoice_unit_cost").val(unit_cost);
            $("#componentCostModal #invoice_unit_cost").val(unit_cost);
            $("#componentCostModal #current_unit_cost").val(order_cost);
            $('#componentCostModal').modal('show'); 
        }
    
        $("#ucostfield" + rowno).val(parseFloat(ucost).toFixed(2));
        var line_total = parseFloat($("#linetotal" + rowno).val());
    
        if (isNaN(mqty)) {
            mqty = 0;
        } else {
            mqty = mqty;
        }
        if (isNaN(ucost)) {
            ucost = 0;
        } else {
            ucost = ucost;
        }

        var row_total = mqty * ucost;
    
        $('#linetotalfield' + rowno).val(row_total.toFixed(2));
    
        var margin = parseFloat($("#marginfield" + rowno).val());
        if (isNaN(margin)) {
            margin = 0;
        }
        var marginline = (margin / 100) * row_total;
        var vtotal = marginline + row_total;
        if (isNaN(vtotal)) {
            vtotal = 0;
        }
        $('#margin_linefield' + rowno).val(parseFloat(vtotal).toFixed(2));
        calculate();
    }
}

    function update_component_unit_cost(){
        $('#componentCostModal').modal('hide'); 
        var rno = $('#update_rno').val();
        var component_id = $('#update_component_id').val();
        var unit_cost = $('#update_invoice_unit_cost').val();
         $.ajax({
                    url: base_url+'project_costing/update_component_unit_cost/',
                    type: 'post',
                    data: {component_id: component_id,unit_cost:unit_cost},
                    beforeSend: function() {
                      //$('#loading-overlay').show();
                    },
                    success: function (result) {
                        //$('#loading-overlay').hide();
                    }
                });

        
    }

    $("body").on('click', '.removeallbtn', function () {
    
    swal({
                title: 'Are you sure you want to delete all rows?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Yes, delete it!',
                buttonsStyling: false
            }).then(function() {
                
                        $('table#partstable tbody').html('');
                        calculate();
						
						swal({
                           title: 'Deleted!',
                           text: 'Your record has been deleted.',
                           type: 'success',
                           confirmButtonClass: "btn btn-success",
                           buttonsStyling: false
                        })	
				
            });
});

    function validateForm() {
        var lstrow = $('#partstable > tbody').find('tr').length;
        var newItemRow = $('#add-more-row > tbody').find('tr').length;
        var project_costing_type = $("#project_costing_type").val();
        if (lstrow > 0 || newItemRow>0) {
            return true;
        }
        else {
            swal({
                title: 'Error!',
                text: 'Add at least one part to save this costing.',
                type: 'error',
                confirmButtonClass: "btn btn-success",
                buttonsStyling: false
                })
            return false;
        }
    }
    
    function calculate() {
        var total = 0;
        var val = 0;
        var vstotaol = 0;
        
        $(".qty").each(function () {
    
            var id = $(this).attr('id');
            var stage = $(this).attr('rno');
            var cost = $('#trnumber' + stage + ' #ucostfield' + stage).val();
            var qty = $(this).val();
            var newtotal = parseFloat(qty) * parseFloat(cost);
            var psubtoal = $('#linetotalfield' + stage).val();
            total += newtotal;
            vstotaol = parseFloat(vstotaol) + parseFloat(psubtoal);
            
            //Calculate Stage Subtotal
            var stage_id = $("#stagefield"+stage).val();
            var stage_subtotal = 0;
                
                /*$(".line_margin_"+stage_id).each(function () {
                    stage_subtotal =parseFloat(stage_subtotal)+parseFloat($(this).val());
                });
                $(".sub_total_"+stage_id).text("Stage Sub-total : "+parseFloat(stage_subtotal).toFixed(2));*/  
            });
            
            if (isNaN(vstotaol) || vstotaol == '') {
                $("#total_cost").val(0);
                $(".projectSubtotal").text("0.00");
            }
    
            else {
                $("#total_cost").val(vstotaol.toFixed(2));
                $(".projectSubtotal").text(vstotaol.toFixed(2));
            }
            
        var totalProfitMargin = 0.00;
        
        $(".profitMargin").each(function () {
            totalProfitMargin = parseFloat(totalProfitMargin) + parseFloat($(this).val());
        });
        
        $(".sumOfMargins").text(parseFloat(totalProfitMargin).toFixed(2));
        var projectSubtotal = $("#total_cost").val();
        var totalLineMargins = parseFloat(projectSubtotal) + parseFloat(totalProfitMargin);
        $(".totalLineMargins").text(parseFloat(totalLineMargins).toFixed(2));
        $("#line_margins").val(parseFloat(totalLineMargins).toFixed(2));
        
        calcuate_costing_totals();
    }
   
    
    $('body').on('change', '.cal-on-change', function () {
        calcuate_costing_totals();
    });
    
    $('.edit-import-file-button').on('click', function (e) {
        if($("#ProjectCostingCSVForm").valid()){
            let files = new FormData(), // you can consider this as 'data bag'
            url = base_url+'supplierz/import_component_in_project_costing_by_csv';
            var fileName = $('#importcsv')[0].files;
            files.append('importcsv', fileName[0]); // append selected file to the bag named 'file'
            $("#add-more-row").show();
            var lastrow = $(".partstable:last tbody tr:last-child()").attr('tr_val');
            if (lastrow == 'undefined' || lastrow==undefined) {
                lastrow = 0;
            }
            else{
            lastrow = parseInt(lastrow)+1;
            }
            
            var lastrow2 = $("table#add-more-row tbody tr:last-child()").attr('tr_val');
            if (lastrow2 == 'undefined' || lastrow2==undefined) {
                lastrow2 = 0;
            }
            else{
            lastrow = parseInt(lastrow2)+1;
            }
            files.append('last_row', lastrow);
        
            $.ajax({
                type: 'post',
                url: url,
                processData: false,
                contentType: false,
                data: files,
                beforeSend: function() {
                    $('.loader').show();
                },
                success: function (response) {
                    if(response == "Only CSV files are allowed."){
                        $(".import_file_error").show();
                        $(".import_file_error").html("Only CSV files are allowed.");
                    }
                    else if(response == "File format is wrong. Please upload correct file."){
                        $(".import_file_error").show();
                        $(".import_file_error").html("File format is wrong. Please upload correct file.");
                    }
                    else{
                        $('.loader').hide();
                        $('table#add-more-row tbody').append(response); 
                        calculate();
                        $('.selectpicker').selectpicker('refresh');
                        $("#ProjectCostingCSVForm")[0].reset();
                    }
                    
                },
                error: function (err) {
                    console.log(err);
                }
            });
        }
        else{
            setFormValidation("#ProjectCostingCSVForm");
        }
    });
    
    $('.import-components-file-button').on('click', function (e) {
        if($("#ProjectCostingCSVForm").valid()){
            let files = new FormData(), // you can consider this as 'data bag'
            url = base_url+'supplierz/import_component_in_project_costing_by_csv';
            var fileName = $('#importcsv')[0].files;
            files.append('importcsv', fileName[0]); // append selected file to the bag named 'file'
            var lastrow = $("table#partstable tbody tr:last-child()").attr('tr_val');
            if (lastrow == 'undefined' || lastrow==undefined) {
                lastrow = 0;
            }
            else{
            lastrow = parseInt(lastrow)+1;
            }
            files.append('last_row', lastrow);
        
            $.ajax({
                type: 'post',
                url: url,
                processData: false,
                contentType: false,
                data: files,
                beforeSend: function() {
                    $('.loader').show();
                },
                success: function (response) {
                    if(response == "Only CSV files are allowed."){
                        $(".import_file_error").show();
                        $(".import_file_error").html("Only CSV files are allowed.");
                    }
                    else if(response == "File format is wrong. Please upload correct file."){
                        $(".import_file_error").show();
                        $(".import_file_error").html("File format is wrong. Please upload correct file.");
                    }
                    else{
                        $('.loader').hide();
                        $('table#partstable tbody').append(response); 
                        calculate();
                        $('.selectpicker').selectpicker('refresh');
                        $("#ProjectCostingCSVForm")[0].reset();
                    }
                    
                },
                error: function (err) {
                    console.log(err);
                }
            });
        }
        else{
            setFormValidation("#ProjectCostingCSVForm");
        }
    });
    
    function CalculateTakeoffData() {
        $(".formulaqtty").each(function () {
            var id = $(this).attr('id');
            var rno = $(this).attr('rno');
            var formula = $("#formulaqty_stage_" + rno).val();
            if(formula!=""){
            var n = 0;
            var number = 0;
            var newf = formula.replace(/,/g, '');
            var pattern = /[0-9]+/g;
            //var pattern = /[a-z]+/g;
            var matches = newf.match(pattern);
			var d3 = formula;
            for(var i=0;i<matches.length;i++){
				var d2 = parseFloat($("#toffdata" + (matches[i])).val());
				d3 = d3.replace("|"+matches[i]+",", d2);
			}
			d3 = d3.replace(/,/g, '');
			
            number = nerdamer(d3).evaluate();
            
			if (isNaN(number)) {
                number = 0;
            }
            var is_rounded = $("#is_rounded_stage_" + rno).val();
            
            
            if(isFloat(number)){
				if(is_rounded==1){
				     $("#manualqty" + rno).val(Math.ceil(number));
				}
				else{
				     $("#manualqty" + rno).val(parseFloat(number).toFixed(2));
				}
			}
            else{
                if(is_rounded==1){
				   $("#manualqty" + rno).val(Math.ceil(eval(number.toString())));
                }
                else{
                    $("#manualqty" + rno).val(parseFloat(eval(number.toString())).toFixed(2));
                }
			}
            }
        });
        calculateLineTotal();
    }
    
    function isFloat(n){
    return Number(n) === n && n % 1 !== 0;
    }
    function  calculateLineTotal() {
    $(".qty").each(function () {
        var id = $(this).attr('id');
        var rno = $(this).attr('rno');
        var formula = $("#formulaqty_stage_" + rno).val();


        var qty = $("#manualqty" + rno).val();
    
        var ucost = $("#ucostfield" + rno).val();
        $("#ucostfield" + rno).val(parseFloat(ucost).toFixed(2));
        var total = parseFloat(qty) * parseFloat(ucost);
        if (isNaN(total)) {
            total = 0;
        }
        $("#linetotalfield" + rno).val(total.toFixed(2));

        var margin = parseFloat($("#marginfield" + rno).val());
        if (isNaN(margin)) {
            margin = 0;
        }
        var marginline = (margin / 100) * total;
        var vtotal = marginline + total;
        if (isNaN(vtotal)) {
            vtotal = 0;
        }
        $('#margin_linefield'+rno).val(parseFloat(vtotal).toFixed(2));
    });
    calculate();
}

$.validator.addMethod('uniqueTakeoffdata', function(value) {
			
         var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'setup/verify_takeoffdata',
                type: 'post',
			    data:{name: value},
	}); 

    if(result.responseText == '0') return true; else return false;

    } , "Please enter a unique take off data");
    

$(document).on('click','.add-takeoffdata-btn',function(){
    
    if($("#TakeoffdataForm").valid()){
    var data = $("#TakeoffdataForm").serialize();
    
    $.ajax({
        type:'POST',
        url:base_url+'supplierz/add_new_takeoffdata_process',
        data: data,
        success:function(result){
            if(result.status == 'success'){
                 $('#takeoffdata0').html(result.data);
                 var takeoffdataCount = $("#addformulavalue .addtakeOffData").length;
                 if(takeoffdataCount){
                     for(i=1;i<=takeoffdataCount;i++){
                        var currentVal = $('#takeoffdata'+i).val();
                        $('#takeoffdata'+i).html(result.data);
                        $('#takeoffdata'+i).val(currentVal);
                     }
                 }
                 $('.selectpicker').selectpicker('refresh');
                 $("#TakeoffdataForm")[0].reset();
                 swal({
                           title: 'Added',
                           text: 'New Take Off Data Successfully Added!',
                           type: 'success',
                           confirmButtonClass: "btn btn-success",
                           buttonsStyling: false
                        });
            }
            else{
                swal({
                    title: 'Error!',
                    text: result.message,
                    type: 'error',
                    confirmButtonClass: "btn btn-success",
                    buttonsStyling: false
                });
            }
        }
    }); 
    
    }
    else{
        $("#TakeoffdataForm").validate();
    }
});

$(document).on('click','.add-takeoffdataBtn',function(){
    
    if($("#updateTakeoffdataForm").valid()){
    var data = $("#updateTakeoffdataForm").serialize();
    
    $.ajax({
        type:'POST',
        url:base_url+'supplierz/add_new_takeoffdata_process',
        data: data,
        success:function(result){
            if(result.status == 'success'){
                 $('#takeoffdata0').html(result.data);
                 var updateTakeOffDataCount = $(".updatetakeOffData").length;
                 if(updateTakeOffDataCount){
                     for(i=1;i<=updateTakeOffDataCount;i++){
                        var currentVal = $('#takeoffdata'+i).val();
                        $('#takeoffdata'+i).html(result.data);
                        $('#takeoffdata'+i).val(currentVal);
                     }
                 }
                 $('.selectpicker').selectpicker('refresh');
                 $("#updateTakeoffdataForm")[0].reset();
                 swal({
                           title: 'Added',
                           text: 'New Take Off Data Successfully Added!',
                           type: 'success',
                           confirmButtonClass: "btn btn-success",
                           buttonsStyling: false
                        });
            }
            else{
                swal({
                    title: 'Error!',
                    text: result.message,
                    type: 'error',
                    confirmButtonClass: "btn btn-success",
                    buttonsStyling: false
                });
            }
        }
    }); 
    
    }
    else{
        $("#updateTakeoffdataForm").validate();
    }
});


    function testFormula(mode) {
            if($("#testFormulaForm"+mode).valid()){
                var formula = computedFormula;
                if(formula!=""){
                    var n = 0;
                    var number = 0;
                    var newf = formula.replace(/,/g, '');
                    var pattern = /[0-9]+/g;
                    var matches = newf.match(pattern);
        			var d3 = formula;
                    for(var i=0;i<matches.length;i++){
        				var d2 = parseFloat($("#takeOffData"+mode+matches[i]).val());
        				d3 = d3.replace("|"+matches[i]+",", d2);
        			}
        			d3 = d3.replace(/,/g, '');
                    number = nerdamer(d3).evaluate();
                    
        			if (isNaN(number)) {
                        number = 0;
                    }
                    var is_rounded = $("#is_rounded").val();
            
                    if(isFloat(number)){
        				if(is_rounded==1){
        				     $("#computedFormula"+mode).text(Math.ceil(number));
        				}
        				else{
        				     $("#computedFormula"+mode).text(parseFloat(number).toFixed(2));
        				}
            		}
                    else{
                            if(is_rounded==1){
            				   $("#computedFormula"+mode).text(Math.ceil(eval(number.toString())));
                            }
                            else{
                                $("#computedFormula"+mode).text(parseFloat(eval(number.toString())).toFixed(2));
                            }
            	    }
                }
        }
        else{
            $("#testFormulaForm"+mode).validate();
        }
    }
    
    function isFloat(n){
       return Number(n) === n && n % 1 !== 0;
    }
    
    var computedFormula = "";
    
    $('body').on('click','#testFormulaTab',function(){
        var mode = $(this).attr("mode");
        if(mode == "Add"){
        var formula = $("#addformulavalue .addoperator").length;
        var formula_2 = $("#addformulavalue .addtakeOffData").length;
        var formula_3 = $("#addformulavalue .addnumber").length;
        }
        else{
            var formula = $(".updateoperator").length;
            var formula_2 = $(".updatetakeOffData").length;
            var formula_3 = $(".updatenumber").length;
        
            var total_inputs = (formula + formula_2 + formula_3 );
        }
        
        var total_inputs = (formula + formula_2 + formula_3 );
        var k = 1;
        var my_formula_text = '';
        var my_formula_value = '';
        var takeoffdata_inputs = '';
		var selected_ids = new Array();
		var todid = 0;
        for (k; k <= total_inputs; k++) {
            var current_selector = (mode == "Add")?'[my-check="sereal'+k+'"]':'[my-check="updatesereal'+k+'"]';

            if ($(current_selector).attr('name') == 'operator') {
                var current_formula_value = $(current_selector).val()+",";
                var current_formula_text = $(current_selector).find("option:selected").val();
                var takeOffDataRow = "";
            }
            else if ($(current_selector).attr('name') == 'takeoffdata') {
                 var current_formula_value = "|"+$(current_selector).val()+",";
    			 var current_formula_text = $(current_selector).find("option:selected").text();
    			 var takeOffDataRow = '<tr tod_id="'+$(current_selector).val()+'"><td style="width:250px;">'+current_formula_text+'<strong class="text-danger"> *</strong></td><td><input class="form-control" type="text" name="takeOffData'+mode+$(current_selector).val()+'" id="takeOffData'+mode+$(current_selector).val()+'" placeholder ="Enter Value" value="" required> </td></tr>';
            }
            else {
                var current_formula_value = $(current_selector).val()+",";
                var current_formula_text = $(current_selector).val();
                var takeOffDataRow = "";
				 
            }
            
            my_formula_text+= current_formula_text;
            my_formula_value+= current_formula_value;
            takeoffdata_inputs+=takeOffDataRow;
        }
    
        computedFormula = my_formula_value;
        
        
        $("#computedFormula"+mode).html('<font color="red">No Results Found!</font>');
            
        if(my_formula_text == ""){
            $("#computedFormulaText"+mode).text("");
            $('#testFormulaForm'+mode+' tr:not(:last)').remove();
            $("#testFormulaForm"+mode+" .actionRow").hide();
        }
        else{
            $("#computedFormulaText"+mode).text("").append("Formula : "+my_formula_text);
            $('#testFormulaForm'+mode+' tr:not(:last)').remove();
            $("#testFormulaForm"+mode+" .actionRow").before(takeoffdata_inputs);
            $("#testFormulaForm"+mode+" .actionRow").show();
        }
    });