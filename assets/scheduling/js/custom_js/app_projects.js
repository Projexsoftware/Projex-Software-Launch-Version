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



$.validator.addMethod('uniqueProject', function(value) {
			
         var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'projects/verify_name',
                type: 'post',
			    data:{name: value},
	}); 

    if(result.responseText == '0') return true; else return false;

    } , "Please enter a unique name");

    $.validator.addMethod('uniqueEditProject', function(value) {
	    var id = $('#project_id').val();		
        var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'projects/verify_name',
                type: 'post',
			    data:{name: value, id:id},
	  }); 

         if(result.responseText == '0') return true; else return false;

             } , "Please enter a unique name");

    $(document).ready(function() {
        setFormValidation('#ProjectForm');
        setFormValidation('#EditProjectForm');
        setFormValidation('#DocumentForm');
    });

    var previous ="";
    var previous_text ="";

    $('#project_manager').on('shown.bs.select', function() {
    previous = $(this).val();
    previous_text = $("#project_manager option[value='"+previous+"']").text();
    });

    $('body').on('blur','.project_start_date',function(){
     var start_date = $('#start_date').val();
     $('#end_date').val(start_date);
    });
    

    /*$('body').on('change','.select_project_team',function(){
     var project_manager = $('#project_manager').val();
     var editor = $('#editor').val();
     var viewer = $('#viewer').val();
     if(project_manager!=""){
       $('.project_team_error').text("");
       if(previous.length>1){
         var previous_array = previous.toString().split(",");
         var previous_text_array = previous_text.toString().split(",");
         for(var i=0;i<previous_array.length;i++){
                if ( $("#editor option[value='"+previous_array[i]+"']").length == 0 && previous_array[i]!=project_manager && previous_array[i]!="" && previous_array[i]!=viewer){
       $("#editor").append('<option value="'+previous_array[i]+'">'+previous_text_array[i]+'</option>');
       }
       if ( $("#viewer option[value='"+previous_array[i]+"']").length == 0 && previous_array[i]!=editor && previous_array[i]!=project_manager && previous_array[i]!=""){
       $("#viewer").append('<option value="'+previous_array[i]+'">'+previous_text_array[i]+'</option>');
       }
     }
         }
         else{
       if ( $("#editor option[value='"+previous+"']").length == 0 && previous!=project_manager && previous!="" && previous!=viewer){
       $("#editor").append('<option value="'+previous+'">'+previous_text+'</option>');
       }
       if ( $("#viewer option[value='"+previous+"']").length == 0 && previous!=editor && previous!=project_manager && previous!=""){
       $("#viewer").append('<option value="'+previous+'">'+previous_text+'</option>');
       }
       }
       $("#editor option[value='"+project_manager+"']").remove();
       $("#viewer option[value='"+project_manager+"']").remove(); 
     }
     $('.selectpicker').selectpicker('refresh');
 });*/

    var previous1 ="";
    var previous_text1 ="";

    $('#members').on('shown.bs.select', function() {
    previous1 = $(this).val();
    previous_text1 = $("#members option[value='"+previous1+"']").text();
    });

    $('body').on('change','.select_members_team',function(){
     var leaders = $('#leaders').val();
     var members = $('#members').val();
     var guest = $('#guest').val();
      if(members!="" && members.length==1){
       $('.project_team_error').text("");
       if(previous1.length>1){
         var previous_array1 = previous1.toString().split(",");
         for(var i=0;i<previous_array1.length;i++){
         var previous_text_array1 = $("#members option[value='"+previous1[i]+"']").text();
         if ( $("#leaders option[value='"+previous_array1[i]+"']").length == 0 && previous_array1[i]!=members && previous_array1[i]!=guest && previous_array1[i]!=""){
       $("#leaders").append('<option value="'+previous_array1[i]+'">'+previous_text_array1+'</option>');
       }
       if ( $("#guest option[value='"+previous_array1[i]+"']").length == 0 && previous_array1[i]!=members && previous_array1[i]!=leaders && previous_array1[i]!=""){
       $("#guest").append('<option value="'+previous_array1[i]+'">'+previous_text_array1+'</option>');
       }
       }
       }
       else{
       if ( $("#leaders option[value='"+previous1+"']").length == 0 && previous1!=members && previous1!=leaders && previous1!=""){
       $("#leaders").append('<option value="'+previous1+'">'+previous_text1+'</option>');
       }
       if ( $("#guest option[value='"+previous1+"']").length == 0 && previous1!=members && previous1!=leaders && previous1!=""){
       $("#guest").append('<option value="'+previous1+'">'+previous_text1+'</option>');
       }
       }
       $("#leaders option[value='"+members+"']").remove();
       $("#guest option[value='"+members+"']").remove(); 
     }
     else{
       var members1 = $('#members').val();
       var members_array = members1.toString().split(",");
       if(previous1.length>1){
         var previous_array1 = previous1.toString().split(",");
         for(var i=0;i<previous_array1.length;i++){
         var previous_text_array1 = $("#members option[value='"+previous1[i]+"']").text();
         if ( $("#leaders option[value='"+previous_array1[i]+"']").length == 0 && previous_array1[i]!=members && previous_array1[i]!=guest && previous_array1[i]!=""){
       $("#leaders").append('<option value="'+previous_array1[i]+'">'+previous_text_array1+'</option>');
       }
       if ( $("#guest option[value='"+previous_array1[i]+"']").length == 0 && previous_array1[i]!=members && previous_array1[i]!=leaders && previous_array1[i]!=""){
       $("#guest").append('<option value="'+previous_array1[i]+'">'+previous_text_array1+'</option>');
       }
       }
}
       else{
       if ( $("#leaders option[value='"+previous1+"']").length == 0 && previous1!=members && previous1!=leaders && previous1!=""){
       $("#leaders").append('<option value="'+previous1+'">'+previous_text1+'</option>');
       }
       if ( $("#guest option[value='"+previous1+"']").length == 0 && previous1!=members && previous1!=leaders && previous1!=""){
       $("#guest").append('<option value="'+previous1+'">'+previous_text1+'</option>');
       }
       }
       for(var i=0;i<members_array.length;i++){
         $("#leaders option[value='"+members_array[i]+"']").remove();
         $("#guest option[value='"+members_array[i]+"']").remove();
        }

     }

     $('.selectpicker').selectpicker('refresh');
 });



    var previous2 ="";
    var previous_text2 ="";

    $('#guest').on('shown.bs.select', function() {
    previous2 = $(this).val();
    previous_text2 = $("#guest option[value='"+previous2+"']").text();
    });

 $('body').on('change','.select_guest_team',function(){
     var leaders = $('#leaders').val();
     var members = $('#members').val();
     var guest = $('#guest').val();
      if(guest!="" && guest.length==1){
       $('.project_team_error').text("");
       if(previous2.length>1){
         var previous_array2 = previous2.toString().split(",");
         for(var i=0;i<previous_array2.length;i++){
         var previous_text_array2 = $("#guest option[value='"+previous2[i]+"']").text();
         if ( $("#leaders option[value='"+previous_array2[i]+"']").length == 0 && previous_array2[i]!=members && previous_array2[i]!=guest && previous_array2[i]!=""){
       $("#leaders").append('<option value="'+previous_array2[i]+'">'+previous_text_array2+'</option>');
       }
       if ( $("#members option[value='"+previous_array2[i]+"']").length == 0 && previous_array2[i]!=guest && previous_array2[i]!=leaders && previous_array2[i]!=""){
       $("#members").append('<option value="'+previous_array2[i]+'">'+previous_text_array2+'</option>');
       }
       }
       }
       else{
       if ( $("#leaders option[value='"+previous2+"']").length == 0 && previous2!=members && previous2!=leaders && previous2!=""){
       $("#leaders").append('<option value="'+previous2+'">'+previous_text2+'</option>');
       }
       if ( $("#members option[value='"+previous2+"']").length == 0 && previous2!=members && previous2!=leaders && previous2!=""){
       $("#members").append('<option value="'+previous2+'">'+previous_text2+'</option>');
       }
       }
       $("#leaders option[value='"+guest+"']").remove();
       $("#members option[value='"+guest+"']").remove(); 
     }
     else{
     
       var guest_array = guest.toString().split(",");
       if(previous2.length>1){
         var previous_array2 = previous2.toString().split(",");
         for(var i=0;i<previous_array2.length;i++){
         var previous_text_array2 = $("#guest option[value='"+previous2[i]+"']").text();
         if ( $("#leaders option[value='"+previous_array2[i]+"']").length == 0 && previous_array2[i]!=members && previous_array2[i]!=guest && previous_array2[i]!=""){
       $("#leaders").append('<option value="'+previous_array2[i]+'">'+previous_text_array2+'</option>');
       }
       if ( $("#members option[value='"+previous_array2[i]+"']").length == 0 && previous_array2[i]!=guest && previous_array2[i]!=leaders && previous_array2[i]!=""){
       $("#members").append('<option value="'+previous_array2[i]+'">'+previous_text_array2+'</option>');
       }
       }
}
       else{
       if ( $("#leaders option[value='"+previous2+"']").length == 0 && previous2!=members && previous2!=leaders && previous2!=""){
       $("#leaders").append('<option value="'+previous2+'">'+previous_text2+'</option>');
       }
       if ( $("#members option[value='"+previous2+"']").length == 0 && previous2!=members && previous2!=leaders && previous2!=""){
       $("#members").append('<option value="'+previous2+'">'+previous_text2+'</option>');
       }
       }
       for(var i=0;i<guest_array.length;i++){
         $("#leaders option[value='"+guest_array[i]+"']").remove();
         $("#members option[value='"+guest_array[i]+"']").remove();
        }

     }

     
     $('.selectpicker').selectpicker('refresh');
 });

 // for leaders

     var previous3 ="";
    var previous_text3 ="";

    $('#leaders').on('shown.bs.select', function() {
    previous3 = $(this).val();
    previous_text3 = $("#leaders option[value='"+previous3+"']").text();
    });

 $('body').on('change','.select_leaders_team',function(){
     var members = $('#members').val();
     var leaders = $('#leaders').val();
     var guest = $('#guest').val();
      if(leaders!="" && leaders.length==1){
       $('.project_team_error').text("");
       if(previous3.length>1){
         var previous_array3 = previous3.toString().split(",");
         for(var i=0;i<previous_array3.length;i++){
         var previous_text_array1 = $("#leaders option[value='"+previous3[i]+"']").text();
         if ( $("#members option[value='"+previous_array3[i]+"']").length == 0 && previous_array3[i]!=leaders && previous_array3[i]!=guest && previous_array3[i]!=""){
       $("#members").append('<option value="'+previous_array3[i]+'">'+previous_text_array1+'</option>');
       }
       if ( $("#guest option[value='"+previous_array3[i]+"']").length == 0 && previous_array3[i]!=leaders && previous_array3[i]!=members && previous_array3[i]!=""){
       $("#guest").append('<option value="'+previous_array3[i]+'">'+previous_text_array1+'</option>');
       }
       }
       }
       else{
       if ( $("#members option[value='"+previous3+"']").length == 0 && previous3!=leaders && previous3!=members && previous3!=""){
       $("#members").append('<option value="'+previous3+'">'+previous_text3+'</option>');
       }
       if ( $("#guest option[value='"+previous3+"']").length == 0 && previous3!=leaders && previous3!=members && previous3!=""){
       $("#guest").append('<option value="'+previous3+'">'+previous_text3+'</option>');
       }
       }
       $("#members option[value='"+leaders+"']").remove();
       $("#guest option[value='"+leaders+"']").remove(); 
     }
     else{
       var leaders1 = $('#leaders').val();
       var leaders_array = leaders1.toString().split(",");
       if(previous3.length>1){
         var previous_array3 = previous3.toString().split(",");
         for(var i=0;i<previous_array3.length;i++){
         var previous_text_array1 = $("#leaders option[value='"+previous3[i]+"']").text();
         if ( $("#members option[value='"+previous_array3[i]+"']").length == 0 && previous_array3[i]!=leaders && previous_array3[i]!=guest && previous_array3[i]!=""){
       $("#members").append('<option value="'+previous_array3[i]+'">'+previous_text_array1+'</option>');
       }
       if ( $("#guest option[value='"+previous_array3[i]+"']").length == 0 && previous_array3[i]!=leaders && previous_array3[i]!=members && previous_array3[i]!=""){
       $("#guest").append('<option value="'+previous_array3[i]+'">'+previous_text_array1+'</option>');
       }
       }
}
       else{
       if ( $("#members option[value='"+previous3+"']").length == 0 && previous3!=leaders && previous3!=members && previous3!=""){
       $("#members").append('<option value="'+previous3+'">'+previous_text3+'</option>');
       }
       if ( $("#guest option[value='"+previous3+"']").length == 0 && previous3!=leaders && previous3!=members && previous3!=""){
       $("#guest").append('<option value="'+previous3+'">'+previous_text3+'</option>');
       }
       }
       for(var i=0;i<leaders_array.length;i++){
         $("#members option[value='"+leaders_array[i]+"']").remove();
         $("#guest option[value='"+leaders_array[i]+"']").remove();
        }

     }

     $('.selectpicker').selectpicker('refresh');
 });
  
 $('.list_type').click(function(){
    var task_type = $(this).attr("task_type");
    $("#task_type").val(task_type);
    $("#calendar_task_type").val(task_type);
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

 $('body').on('click','.edit_task',function(){
    var rowno = $(this).attr("rowno");
    setFormValidation('#EditTaskForm'+rowno);
    if($("#TaskForm").valid()){
          var data = $('#EditTaskForm'+rowno).serialize();
          
          $(".edit_task").attr("disabled", true);
          $.ajax({
                type:'POST',
                url:base_url+'projects/update_project_item',
                data: data,
                success:function(result){
                    $('#EditTaskForm'+rowno)[0].reset();
                    $(".selectpicker").val('default');
                    $(".selectpicker").selectpicker("refresh");
                    $(".edit_task").attr("disabled", false);
                    $(".project_end_date").text(result);
                    $("#editTaskModal"+rowno+" .close").click();
                     swal({
                        title: "Task Updated!",
                        text: "",
                        timer: 2000,
                        showConfirmButton: false,
                        type: "success"
                       }).catch(swal.noop);
                    get_project_items(); 
                }
             });  
          }
          else{
             $('#EditTaskForm'+rowno).validate();
          }
 });
function get_stage_status(project_id, stage_id){
    var item_count =$(".stage_"+stage_id).attr("item_count");
    $.ajax({
                type:'POST',
                url:base_url+'projects/get_stage_status',
                data: {project_id:project_id,stage_id:stage_id,item_count:item_count},
                success:function(result){
                    $(".stage_"+stage_id).html(result);
                }
             });
}
function get_project_items(){
          var project_id = $("#original_project_id").val();
          
          $.ajax({
                type:'POST',
                url:base_url+'projects/get_project_items',
                data: {project_id:project_id},
                success:function(result){
                    $(".project_items").html(result);
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
     var project_id = $("#original_project_id").val();
     $.ajax({
                type:'POST',
                url:base_url+'projects/sort_stages',
                data: {stages:stages,project_id:project_id},
                success:function(result){
                }
             });
   }
});
                }
             }); 
}

$('.add_new_task').click(function(){
    setFormValidation('#TaskForm');
    if($("#TaskForm").valid()){
          var data = $("#TaskForm").serialize();
          $(".add_new_task").attr("disabled", true);
          $.ajax({
                type:'POST',
                url:base_url+'projects/add_new_project_item',
                data: data,
                success:function(result){
                    $("#TaskForm")[0].reset();
                    $(".selectpicker").val('default');
                    $(".selectpicker").selectpicker("refresh");
                    $(".add_new_task").attr("disabled", false);
                    $(".project_end_date").text(result);
                    $("#addTaskModal .close").click();
                    demo.showSwal('auto-close-success');
                    get_project_items();
                }
             });  
          }
          else{
             $("#TaskForm").validate();
          }
 });

$(document).on('click','.remove_task',function(){
          var project_id = $("#original_project_id").val();
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
                   url:base_url+'projects/remove_task',
                   data: {project_id:project_id,item_id:item_id},
                   success:function(result){
                       swal({
                          title: "Task Deleted!",
                          text: "",
                          type: 'success',
                          confirmButtonClass: "btn btn-success",
                          buttonsStyling: false
                       });
                       $(".project_items").html(result);
                       get_project_items();
                       demo.initFormExtendedDatetimepickers();
                    }
                }); 		
            });
});

function update_checklist(rowno){
var project_id = $("#original_project_id").val();
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
var total_items = $("#total_checklist"+rowno).val();
var total_checklist_count = total_items - checklist_count;
          $.ajax({
                type:'POST',
                url:base_url+'projects/update_task_checklist',
                data: {task_id:rowno,checklist:checklist,status:status},
                success:function(result){
                    demo.showSwal('auto-close');
                    $(".checklist_count"+rowno).text(total_checklist_count); 
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
 
                    get_stage_status(project_id, stage_id);
                     
                }
             }); 
}

function change_view(selected_view, other_view){

if ($('#'+selected_view).prop('checked')==true){

    load_calendar();
    $("#list_view_container").toggle();
    $("#calendar_view_container").toggle();
    get_project_items(); 
    $('#'+other_view).prop('checked', false);
}
else{
   load_calendar();
   $("#list_view_container").toggle();
   $("#calendar_view_container").toggle();
   $('#'+selected_view).prop('checked', false);
   get_project_items(); 
   $('#'+other_view).prop('checked', true);
}
}

$(document).on('click','.add_new_checklist',function(){
         var rowno = $(this).attr("rowno");
         $.validator.addMethod('uniqueChecklist', function(value) {
	 var item_id = $("#checklistForm"+rowno+" #checklist_item_id").val();			
         var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'projects/verify_checklist',
                type: 'post',
			    data:{name: value, item_id:item_id},
	}); 

    if(result.responseText == '0') return true; else return false;

    } , "Please enter a unique checklist");
          
          
          setFormValidation('#checklistForm'+rowno);
          if($('#checklistForm'+rowno).valid()){
          var project_id = $("#original_project_id").val();
          var item_id = $("#checklistForm"+rowno+" #checklist_item_id").val();
          var checklist = $("#new_checklist"+rowno).val();
          var stage_id = $("#stage_id"+rowno).val();
          $.ajax({
                type:'POST',
                url:base_url+'projects/add_new_checklist',
                data: {item_id:item_id,checklist:checklist,project_id:project_id,rowno:rowno},
                success:function(result){
                       demo.showSwal('auto-close-new-checklist');
                       $(".checklist_container"+rowno).html(result);
                       $("#checklistForm"+rowno)[0].reset();
                       get_stage_status(project_id, stage_id);
                       $("#addChecklistModal"+rowno).modal("show");
                     
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
                url:base_url+'projects/add_new_note',
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
                       demo.initFormExtendedDatetimepickers();
                       $("#NotesForm"+rowno)[0].reset();
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
                   url:base_url+'projects/remove_note',
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
          var project_id = $("#original_project_id").val();
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
                   url:base_url+'projects/remove_checklist',
                   data: {id:id,project_id:project_id,rowno:rowno},
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
                       
                       get_stage_status(project_id, stage_id);
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
                url: base_url+'projects/upload_file', 
                type: "POST",            
                data: new FormData(this), 
                contentType: false,       
                cache: false,             
                processData:false,
                beforeSend: function(){
                    $("#btn-upload"+rowno).text("Please Wait File is Uploading....");
                    $("#btn-upload"+rowno).attr("disabled", "true");
                },
                success: function(result){
                    $("#btn-upload"+rowno).text("Upload");
                    $("#btn-upload"+rowno).attr("disabled", "false");
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
          var project_id = $("#original_project_id").val();
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
                   url:base_url+'projects/remove_file',
                   data: {id:id,project_id:project_id,rowno:rowno},
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
    var project_id = $("#original_project_id").val();

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
                url: base_url+'projects/upload_image', 
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
          var project_id = $("#original_project_id").val();
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
                   url:base_url+'projects/remove_image',
                   data: {id:id,project_id:project_id,rowno:rowno},
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
                url:base_url+'projects/add_new_reminder',
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
                   url:base_url+'projects/remove_reminder',
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

//Add From Template 

$(document).on('change','.add_from_template',function(){
          var template_id = $(this).val();
          var project_id = $("#original_project_id").val();
          var template_name = $("#template_id option:selected").text();
          if(template_id!=""){
          $.ajax({
                type:'POST',
                url:base_url+'projects/add_from_template',
                data: {template_id:template_id,project_id:project_id},
                success:function(result){
                       swal({
                        title: template_name+"'s Template Items Imported!",
                        text: "",
                        timer: 2000,
                        showConfirmButton: false,
                        type: "success"
                       }).catch(swal.noop);
                       $("#template_id").val('default');
                       $("#template_id").selectpicker("refresh");
                       get_project_items(); 
                }
             }); 
           }
});

//Add From Template 

$(document).on('change','.add_from_project',function(){
          var import_project_id = $(this).val();
          var project_id = $("#original_project_id").val();
          var project_name = $("#import_project_id option:selected").text();
          if(import_project_id!=""){
          $.ajax({
                type:'POST',
                url:base_url+'projects/add_from_project',
                data: {import_project_id:import_project_id,project_id:project_id},
                success:function(result){
                       swal({
                        title: project_name +"'s Project Items Imported!",
                        text: "",
                        timer: 2000,
                        showConfirmButton: false,
                        type: "success"
                       }).catch(swal.noop);
                       $("#import_project_id").val('default');
                       $("#import_project_id").selectpicker("refresh");
                       get_project_items(); 
                }
             }); 
           }
});


$(document).on('click','.add_project_team',function(){
var project_manager = $("#project_manager").val();
var editor = $("#editor").val();
var viewer= $("#viewer").val();
if(project_manager!="" || editor!="" || viewer!=""){
     $('.project_team_error').text("");
     var project_id = $("#original_project_id").val();
     $("#project_team_project_id").val(project_id);

     $.ajax({
                type:'POST',
                url:base_url+'projects/add_project_team',
                data: $('#ProjectTeamForm').serialize(),
                success:function(result){
                       swal({
                        title: "Project Team Added!",
                        text: "",
                        timer: 2000,
                        showConfirmButton: false,
                        type: "success"
                       }).catch(swal.noop);
                       $(".project_team_container").html(result);
                       $(".selectpicker").val('default');
                       $(".selectpicker").selectpicker("refresh");
                       $("#addProjectTeamModal").modal("hide");
                       $(".modal-open").css("overflow", "scroll");
                       
                }
             }); 
}
else{
  $('.project_team_error').text("Please select atleast one project team");
}
});

$(document).on('click','.remove_project_team',function(){
          var id = $(this).attr("id");
          var project_id = $("#original_project_id").val();
          
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
                   url:base_url+'projects/remove_project_team',
                   data: {id:id,project_id:project_id},
                   success:function(result){
                       swal({
                        title: "Project Team Deleted!",
                        text: "",
                        timer: 2000,
                        showConfirmButton: false,
                        type: "success"
                       }).catch(swal.noop);
                       
                       $(".project_team_container").html(result);
                       $(".selectpicker").val('default');
                       $(".selectpicker").selectpicker("refresh");
                      
                    }
                }); 		
            });
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

$(document).on('submit','.upload_project_document',function(e){
    
    
    e.preventDefault();
    
    var document_file = $('#document_file').val();

    if(document_file!=""){  
    $('.document_error').text("");  
    $.ajax({
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                
                    xhr.upload.addEventListener("progress", function(evt) {
                      if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        percentComplete = parseInt(percentComplete * 100);
                        $("#progressDocumentBar").text(percentComplete+"%");
                        $("#progressDocumentBar").css("width", percentComplete+"%");
                          }
                        }, false);
                    
                        return xhr;
                },
                url: base_url+'projects/upload_document', 
                type: "POST",            
                data: new FormData(this), 
                contentType: false,       
                cache: false,             
                processData:false,
                beforeSend: function(){
                    $("#btn-upload-document").text("Uploading....");
                    $("#btn-upload-document").attr("disabled", "true");
                },
                success: function(result){
                    $("#btn-upload-document").text("Add");
                    $("#btn-upload-document").removeAttr("disabled");
                    $("#progressDocumentBar").text("0%");
                    $("#progressDocumentBar").css("width", "0%");
                    $("#DocumentForm")[0].reset();
                    swal({
                        title: "Document Added!",
                        text: "",
                        timer: 2000,
                        showConfirmButton: false,
                        type: "success"
                    }).catch(swal.noop);
                     
                    $("#document_container").html(result);
                    $("#addDocumentModal").modal("hide");
                }
     });
    }
    else{
     $('.document_error').text("Please select document");
    }
});
$(document).on('click','.remove_document',function(){
          var id = $(this).attr("id");
          var project_id = $("#original_project_id").val();
          
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
                   url:base_url+'projects/remove_document',
                   data: {id:id,project_id:project_id},
                   success:function(result){
                       swal({
                        title: "Document Deleted!",
                        text: "",
                        timer: 2000,
                        showConfirmButton: false,
                        type: "success"
                       }).catch(swal.noop);
                       $("#document_container").html(result);
                    }
                }); 		
            });
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
                url:base_url+'projects/sort_item',
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
     var project_id = $("#original_project_id").val();  
     $.ajax({
                type:'POST',
                url:base_url+'projects/sort_stages',
                data: {stages:stages,project_id:project_id},
                success:function(result){
                }
             });
   }
});

$(document).on('click','.invite_project_team',function(){
          var id = $(this).attr("id");
          var project_id = $("#original_project_id").val();
          
          swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Yes, Send it!',
                buttonsStyling: false
            }).then(function() {
                
                $.ajax({
                   type:'POST',
                   url:base_url+'projects/invite_project_team',
                   data: {id:id,project_id:project_id},
                   success:function(result){
                       swal({
                        title: "Invitation Sent!",
                        text: "",
                        timer: 2000,
                        showConfirmButton: false,
                        type: "success"
                       }).catch(swal.noop);
                       
                       $(".project_team_container").html(result);
                       $(".selectpicker").val('default');
                       $(".selectpicker").selectpicker("refresh");
                      
                    }
                }); 		
            });
});

function set_privacy(id, item_id, type){
if ($("#privacy_settings"+id).prop('checked')==true){
var privacy_settings = 0;
var privacy_name="Private";
}
else{
var privacy_settings = 1;
var privacy_name="Public";
}
$.ajax({
                url: base_url+'projects/set_privacy', 
                type: "POST",            
                data: {privacy_settings:privacy_settings,id:id,item_id:item_id,type:type}, 
                success: function(result){
                    swal({
                        title: type+" Privacy has been set to "+privacy_name+"!",
                        text: "",
                        timer: 2000,
                        showConfirmButton: false,
                        type: "success"
                       }).catch(swal.noop);
                       if(item_id>0){
                       $("#add"+type+"Modal"+item_id).modal("show");
                       }
                }
     });
}

$(document).on('click','.add_new_user',function(){
          var rowno = $(this).attr("rowno");
          $.validator.addMethod('uniqueEmail', function(value) {
	      var task_id = $('#task_id'+rowno).val();
          $("#UserForm"+rowno+" #user_task_id").val(task_id);			
          var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'users/verify_email',
                type: 'post',
			    data:{email: value},
	}); 

    if(result.responseText == '0') return true; else return false;

    } , "User already exists");
          setFormValidation('#UserForm'+rowno);
          if($('#UserForm'+rowno).valid()){
          $.ajax({
                type:'POST',
                url:base_url+'projects/add_new_user',
                data: $('#UserForm'+rowno).serialize(),
                success:function(result){
                       swal({
                        title: "User Added!",
                        text: "",
                        timer: 2000,
                        showConfirmButton: false,
                        type: "success"
                       }).catch(swal.noop);
                       $("#user_container"+rowno).html(result);
                       $(".leaders_users_container").load(base_url+"projects/get_all_users/leaders");
                       $(".members_users_container").load(base_url+"projects/get_all_users/members");
                       $(".guest_users_container").load(base_url+"projects/get_all_users/guest");
                       $('.selectpicker').selectpicker('refresh');
                       demo.initFormExtendedDatetimepickers();
                       $("#UserForm"+rowno)[0].reset();
                       //$(".add_user_btn"+rowno).click();
                }
             }); 
           }
           else{
            $('#UserForm'+rowno).validate();
           }

});	

$(document).on('change','.assign_to_user',function(){
          var rowno = $(this).attr("rowno");
          if($('#assign_to_user_'+rowno).val()!=""){
          var user_id  = $('#assign_to_user_'+rowno).val();
          $.ajax({
                type:'POST',
                url:base_url+'projects/assign_task_to_user',
                data: {user_id:user_id,item_id:rowno},
                success:function(result){
                       swal({
                        title: "Task Assigned!",
                        text: "",
                        timer: 2000,
                        showConfirmButton: false,
                        type: "success"
                       }).catch(swal.noop);
                }
             }); 
          }

});	






