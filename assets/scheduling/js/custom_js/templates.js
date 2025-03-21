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


$.validator.addMethod('uniqueTemplate', function(value) {
			
         var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'templates/verify_name',
                type: 'post',
			    data:{name: value},
	}); 

    if(result.responseText == '0') return true; else return false;

    } , "Please enter a unique name");

    $(document).ready(function() {
        setFormValidation('#TemplateForm');
    });

$('.add_new_task').click(function(){
    setFormValidation('#TaskForm');
    if($("#TaskForm").valid()){
          var data = $("#TaskForm").serialize();
          $(".add_new_task").attr("disabled", true);
          $.ajax({
                type:'POST',
                url:base_url+'templates/add_new_template_item',
                data: data,
                success:function(result){
                    $("#TaskForm")[0].reset();
                    $(".selectpicker").val('default');
                    $(".selectpicker").selectpicker("refresh");
                    $(".add_new_task").attr("disabled", false);
                    $("#addTaskModal .close").click();
                    demo.showSwal('auto-close-success');
                    get_template_items(); 
                }
             });  
          }
          else{
             $("#TaskForm").validate();
          }
 });
function get_stage_status(template_id, stage_id){
    var item_count =$(".stage_"+stage_id).attr("item_count");
    $.ajax({
                type:'POST',
                url:base_url+'templates/get_stage_status',
                data: {template_id:template_id,stage_id:stage_id,item_count:item_count},
                success:function(result){
                    $(".stage_"+stage_id).html(result);
                }
             });
}
function get_template_items(){
          var template_id = $("#template_id").val();
          $.ajax({
                type:'POST',
                url:base_url+'templates/get_template_items',
                data: {template_id:template_id},
                success:function(result){
                    $(".template_items").html(result);
                    $('.selectpicker').selectpicker();
                    //Helper function to keep table row from collapsing when being sorted
	var fixHelperModified = function(e, tr) {
		var $originals = tr.children();
		var $helper = tr.clone();
		$helper.children().each(function(index)
		{
		  $(this).width($originals.eq(index).width())
		});
		return $helper;
	};

	//Make diagnosis table sortable
	$(".sortable_table tbody").sortable({
    	helper: fixHelperModified,
		stop: function(event,ui) {
                 var table_id = $(this).parent("table").attr("id");
                 renumber_table('#'+table_id)}
	}).disableSelection();
                    demo.initFormExtendedDatetimepickers();

                $("#accordionStages").sortable({
   handle: ".panel-heading",
   cursor: "move",
   opacity: 0.5,
   stop : function(event, ui){
      $("#sortable_stages").val(
         
            $("#accordionStages").sortable(
               'toArray',
               {
                  attribute : 'id'
               }
            
         )
      );
     var stages = $("#sortable_stages").val(); 
     var template_id = $("#template_id").val();  
     $.ajax({
                type:'POST',
                url:base_url+'templates/sort_stages',
                data: {stages:stages,template_id:template_id},
                success:function(result){
                }
             });
   }
});
                }
             }); 
}

$(document).on('click','.remove_task',function(){
          var template_id = $("#template_id").val();
          var item_id = $(this).attr("rowno");
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
                $.ajax({
                   type:'POST',
                   url:base_url+'templates/remove_task',
                   data: {template_id:template_id,item_id:item_id},
                   success:function(result){
                       swal({
                          title: "Task Deleted!",
                          text: "",
                          type: 'success',
                          confirmButtonClass: "btn btn-success",
                          buttonsStyling: false
                       });
                       $(".template_items").html(result);
                       demo.initFormExtendedDatetimepickers();
                    }
                }); 		
            });
});

function update_checklist(rowno){

var template_id = $("#template_id").val();
var stage_id = $("#stage_id"+rowno).val();

var total_checkboxes = $("input[name='checklist"+rowno+"']").length;
var checklist = [];
$("input[name='checklist"+rowno+"']:checked").each( function () {
       checklist.push($(this).val());
   });
var checklist_count = checklist.length;
var status = "";
if(total_checkboxes == checklist_count){
 status = 2;
}
else if(total_checkboxes > checklist_count && checklist_count>0 && total_checkboxes>0){
 status = 1;
}
else if(checklist_count==0){
 status = 0;
}

          $.ajax({
                type:'POST',
                url:base_url+'templates/update_task_checklist',
                data: {task_id:rowno,checklist:checklist,status:status},
                success:function(result){
                    demo.showSwal('auto-close');
                    $(".checklist_count"+rowno).text(checklist_count); 
                    if(status == 0){
                       $("#status"+rowno).html("<span class='label label-danger'>Not Done</span>"); 
                    }
                    else if(status == 1){
                       $("#status"+rowno).html("<span class='label label-warning'>Partially Done</span>"); 
                    }
                    else if(status == 2){
                       $("#status"+rowno).html("<span class='label label-success'>Complete</span>"); 
                    }
                    $("#task_status"+rowno).val(status);

                    get_stage_status(template_id, stage_id);
                     
                }
             }); 
}

function change_view(selected_view, other_view){

if ($('#'+selected_view).prop('checked')==true){
    demo.initFullCalendar();
    $("#list_view_container").toggle();
    $("#calendar_view_container").toggle();
    $(".fc-month-button").click();
    $('#'+other_view).prop('checked', false);
}
else{
   demo.initFullCalendar();
   $("#list_view_container").toggle();
   $("#calendar_view_container").toggle();
   $(".fc-month-button").click();
   $('#'+selected_view).prop('checked', false);
   $('#'+other_view).prop('checked', true);
}
}

$(document).on('click','.add_new_checklist',function(){
         var rowno = $(this).attr("rowno");
         $.validator.addMethod('uniqueChecklist', function(value) {
	 var item_id = $("#checklistForm"+rowno+" #checklist_item_id").val();			
         var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'templates/verify_checklist',
                type: 'post',
			    data:{name: value, item_id:item_id},
	}); 

    if(result.responseText == '0') return true; else return false;

    } , "Please enter a unique checklist");
          
          
          setFormValidation('#checklistForm'+rowno);
          if($('#checklistForm'+rowno).valid()){
          var template_id = $("#template_id").val();
          var item_id = $("#checklistForm"+rowno+" #checklist_item_id").val();
          var checklist = $("#new_checklist"+rowno).val();
          var stage_id = $("#stage_id"+rowno).val();
          $.ajax({
                type:'POST',
                url:base_url+'templates/add_new_checklist',
                data: {item_id:item_id,checklist:checklist,template_id:template_id,rowno:rowno},
                success:function(result){
                       demo.showSwal('auto-close-new-checklist');
                       $(".checklist_container"+rowno).html(result);
                       $("#checklistForm"+rowno)[0].reset();
                       get_stage_status(template_id, stage_id);
                       $(".add_checklist_btn"+rowno).click();
                     
                }
             }); 
           }
           else{
            $('#checklistForm'+rowno).validate();
           }

});


$(document).on('click','.add_new_note',function(){
          var rowno = $(this).attr("rowno");
          setFormValidation('#NotesForm'+rowno);
          if($('#NotesForm'+rowno).valid()){
          $.ajax({
                type:'POST',
                url:base_url+'templates/add_new_note',
                data: $('#NotesForm'+rowno).serialize(),
                success:function(result){
                       swal({
                        title: "Note Added!",
                        text: "",
                        timer: 2000,
                        showConfirmButton: false,
                        type: "success"
                       }).catch(swal.noop);
                       $("#notes_container"+rowno).html(result);
                       $("#NotesForm"+rowno)[0].reset();
                       demo.initFormExtendedDatetimepickers();
                       $(".add_note_btn"+rowno).click();
                }
             }); 
           }
           else{
            $('#NotesForm'+rowno).validate();
           }

});	


$(document).on('click','.remove_note',function(){
          var id = $(this).attr("id");
          var rowno = $(this).attr("rowno");
          
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
                
                $.ajax({
                   type:'POST',
                   url:base_url+'templates/remove_note',
                   data: {id:id},
                   success:function(result){
                       swal({
                        title: "Note Deleted!",
                        text: "",
                        timer: 2000,
                        showConfirmButton: false,
                        type: "success"
                       }).catch(swal.noop);
                       
                       $("#notes_container"+rowno).html(result);
                       demo.initFormExtendedDatetimepickers();
                       $(".add_note_btn"+rowno).click();
                    }
                }); 		
            });
});

$(document).on('click','.close',function(){
$(".modal-backdrop").css("display", "none");
});
$(document).on('click','body',function(){
$(".modal-backdrop").css("display", "none");
});
$(document).on('click','.remove_checklist',function(){
          var id = $(this).attr("id");
          var template_id = $("#template_id").val();
          var rowno = $(this).attr("rowno");
          var stage_id = $("#stage_id"+rowno).val();
          
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
                
                $.ajax({
                   type:'POST',
                   url:base_url+'templates/remove_checklist',
                   data: {id:id,template_id:template_id,rowno:rowno},
                   success:function(result){
                       swal({
                        title: "Checklist Deleted!",
                        text: "",
                        timer: 2000,
                        showConfirmButton: false,
                        type: "success"
                       }).catch(swal.noop);
                       $(".checklist_container"+rowno).html(result);
                       $("#checklistForm"+rowno)[0].reset();
                       $("#addChecklistModal"+rowno).modal("show");
                       get_stage_status(template_id, stage_id);
                    }
                }); 		
            });
});
$(document).on('submit','.upload_task_file',function(e){
    
    
    e.preventDefault();

    var rowno = $(this).attr("rowno");     
    var task_file = $('#task_file'+rowno).val();

    if(task_file!=""){  
    $('.file_error'+rowno).text("");  
    $.ajax({
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                
                    xhr.upload.addEventListener("progress", function(evt) {
                      if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        percentComplete = parseInt(percentComplete * 100);
                        $("#progressFileBar"+rowno).text(percentComplete+"%");
                        $("#progressFileBar"+rowno).css("width", percentComplete+"%");
                          }
                        }, false);
                    
                        return xhr;
                },
                url: base_url+'templates/upload_file', 
                type: "POST",            
                data: new FormData(this), 
                contentType: false,       
                cache: false,             
                processData:false,
                beforeSend: function(){
                    $("#btn-upload").text("Please Wait File is Uploading....");
                    $("#btn-upload").attr("disabled", "true");
                    
                },
                success: function(result){
                    $("#btn-upload").text("Upload");
                    $("#btn-upload").attr("disabled", "false");
                    $("#progressFileBar"+rowno).text("0%");
                    $("#progressFileBar"+rowno).css("width", "0%");
                    swal({
                        title: "File Uploaded!",
                        text: "",
                        timer: 2000,
                        showConfirmButton: false,
                        type: "success"
                       }).catch(swal.noop);
                       $("#files_container"+rowno).html(result);
                       $("#addFileModal"+rowno).modal("show");
                }
     });
    }
    else{
     $('.file_error'+rowno).text("Please select file");
    }
});

$(document).on('click','.remove_file',function(){
          var id = $(this).attr("id");
          var template_id = $("#template_id").val();
          var rowno = $(this).attr("rowno");
          
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
                
                $.ajax({
                   type:'POST',
                   url:base_url+'templates/remove_file',
                   data: {id:id,template_id:template_id,rowno:rowno},
                   success:function(result){
                       swal({
                        title: "File Deleted!",
                        text: "",
                        timer: 2000,
                        showConfirmButton: false,
                        type: "success"
                       }).catch(swal.noop);
                       $("#files_container"+rowno).html(result);
                       $("#addFileModal"+rowno).modal("show");
                    }
                }); 		
            });
});

$(document).on('submit','.upload_task_image',function(e){
    
    
    e.preventDefault();

    var rowno = $(this).attr("rowno");     
    var task_image = $('#task_image'+rowno).val();
    var image_description = $('#image_description'+rowno).val();

    if(task_image!="" && image_description!=""){  
    $('.image_error'+rowno).text("");  
    $('.image_description_error'+rowno).text(""); 
    
    $.ajax({
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                
                    xhr.upload.addEventListener("progress", function(evt) {
                      if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        percentComplete = parseInt(percentComplete * 100);
                        $("#progressBar"+rowno).text(percentComplete+"%");
                        $("#progressBar"+rowno).css("width", percentComplete+"%");
                          }
                        }, false);
                    
                        return xhr;
                },
                
                url: base_url+'templates/upload_image', 
                type: "POST",            
                data: new FormData(this), 
                contentType: false,       
                cache: false,             
                processData:false,
                beforeSend: function(){
                    $("#btn-upload-image"+rowno).text("Please Wait Image is Uploading....");
                    $("#btn-upload-image"+rowno).attr("disabled", "true");
                    
                },
                success: function(result){
                    $("#btn-upload-image"+rowno).text("Upload");
                    $("#btn-upload-image"+rowno).attr("disabled", "false");
                    $("#progressBar"+rowno).text("0%");
                    $("#progressBar"+rowno).css("width", "0%");
                    swal({
                        title: "Image Uploaded!",
                        text: "",
                        timer: 2000,
                        showConfirmButton: false,
                        type: "success"
                       }).catch(swal.noop);
                       $("#images_container"+rowno).html(result);
                       $("#addImageModal"+rowno).modal("show");
                }
     });
    }
    else{
     if(task_image==""){
     $('.image_error'+rowno).text("Please select image");
     }
     else{
        $('.image_error'+rowno).text("");
     }
     if(image_description==""){
     $('.image_description_error'+rowno).text("The Image Description is required"); 
     }
     else{
         $('.image_title_error'+rowno).text("");
     }
    }
});

$(document).on('click','.remove_image',function(){
          var id = $(this).attr("id");
          var template_id = $("#template_id").val();
          var rowno = $(this).attr("rowno");
          
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
                
                $.ajax({
                   type:'POST',
                   url:base_url+'templates/remove_image',
                   data: {id:id,template_id:template_id,rowno:rowno},
                   success:function(result){
                       swal({
                        title: "Image Deleted!",
                        text: "",
                        timer: 2000,
                        showConfirmButton: false,
                        type: "success"
                       }).catch(swal.noop);
                       $("#images_container"+rowno).html(result);
                       $("#addImageModal"+rowno).modal("show");
                    }
                }); 		
            });
});



//Reminders Script

$(document).on('click','.add_new_reminder',function(){
          var rowno = $(this).attr("rowno");
          $.validator.addMethod('uniqueEmail', function(value) {
	  var task_id = $('#task_id'+rowno).val();
          $("#RemindersForm"+rowno+" #reminder_task_id").val(task_id);		
          var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'reminder_users/verify_email',
                type: 'post',
			    data:{email: value, task_id:task_id},
	}); 

    if(result.responseText == '0') return true; else return false;

    } , "Please enter a unique reminder email");

	  setFormValidation('#RemindersForm'+rowno);

          if($('#RemindersForm'+rowno).valid()){
          $.ajax({
                type:'POST',
                url:base_url+'templates/add_new_reminder',
                data: $('#RemindersForm'+rowno).serialize(),
                success:function(result){
                       swal({
                        title: "Reminder Added!",
                        text: "",
                        timer: 2000,
                        showConfirmButton: false,
                        type: "success"
                       }).catch(swal.noop);
                       $("#reminders_container"+rowno).html(result);
                       $('.selectpicker').selectpicker();
                       demo.initFormExtendedDatetimepickers();
                       $("#RemindersForm"+rowno)[0].reset();
                       $(".add_reminder_btn"+rowno).click();
                }
             }); 
           }
           else{
            $('#RemindersForm'+rowno).validate();
           }

});	


$(document).on('click','.remove_reminder',function(){
          var id = $(this).attr("id");
          var rowno = $(this).attr("rowno");
          
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
                
                $.ajax({
                   type:'POST',
                   url:base_url+'templates/remove_reminder',
                   data: {id:id},
                   success:function(result){
                       swal({
                        title: "Reminder Deleted!",
                        text: "",
                        timer: 2000,
                        showConfirmButton: false,
                        type: "success"
                       }).catch(swal.noop);
                       
                       $("#reminders_container"+rowno).html(result);
                       $('.selectpicker').selectpicker();
                       demo.initFormExtendedDatetimepickers();
                       $(".add_reminder_btn"+rowno).click();
                    }
                }); 		
            });
});

$('.list_type').click(function(){
    var task_type = $(this).attr("task_type");
    $("#task_type").val(task_type);
    $(".task_dropdown").toggle();
    $(".task_textfield").toggle();
 });

$(document).on('click','.reminder_list_type',function(){
    var reminder_type = $(this).attr("reminder_type");
    var form_id = $(this).parent("div").parent("form").attr("id");
    $("#"+form_id+" #reminder_type").val(reminder_type);
    $(".reminder_dropdown").toggle();
    $(".reminder_textfield").toggle();
 });

$(document).on('change','#message_id',function(){
        var id = $(this).val();
        var container_id = $(this).attr("rowno");
        if(id!=0){
        $.ajax({
                   type:'POST',
                   url:base_url+'projects/get_reminder_message',
                   data: {id:id},
                   beforeSend: function(){
                     $(".message_"+container_id).val('');
                },
                   success:function(result){
                       $(".message_"+container_id).val(result);
                      
                    }
                }); 
        }
        else{
            $(".message_"+container_id).val('');
        }	
});

$(document).on('change','#remindertype',function(){
  var reminder_type = $(this).val();
  var form_id = $(this).parent("div").parent("div").parent("form").attr("id");
  if(reminder_type == 0){
      $("#"+form_id+" .no_of_days_container").hide();
  }
  else{
     $("#"+form_id+" .no_of_days_container").show();
  }
});

$(document).ready(function() {
    //Helper function to keep table row from collapsing when being sorted
	var fixHelperModified = function(e, tr) {
		var $originals = tr.children();
		var $helper = tr.clone();
		$helper.children().each(function(index)
		{
		  $(this).width($originals.eq(index).width())
		});
		return $helper;
	};

	//Make diagnosis table sortable
	$(".sortable_table tbody").sortable({
    	helper: fixHelperModified,
		stop: function(event,ui) {
                 var table_id = $(this).parent("table").attr("id");
                 renumber_table('#'+table_id)}
	}).disableSelection();

});
function renumber_table(tableID) {
	$(tableID + " tr").each(function() {
                var id = $(this).attr("rowno");
		count = $(this).parent().children().index($(this)) + 1;
		$(this).find('.priority').html(count);
                $.ajax({
                type:'POST',
                url:base_url+'templates/sort_item',
                data: {priority:count,id:id},
                success:function(result){
                }
             });
	});
}
$("#accordionStages").sortable({
   handle: ".panel-heading",
   cursor: "move",
   opacity: 0.5,
   stop : function(event, ui){
      $("#sortable_stages").val(
         
            $("#accordionStages").sortable(
               'toArray',
               {
                  attribute : 'id'
               }
            
         )
      );
     var stages = $("#sortable_stages").val(); 
     var template_id = $("#template_id").val();  
     $.ajax({
                type:'POST',
                url:base_url+'templates/sort_stages',
                data: {stages:stages,template_id:template_id},
                success:function(result){
                }
             });
   }
});