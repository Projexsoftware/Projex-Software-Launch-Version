<?php 
  $project_role = get_user_project_role($project_id, $this->session->userdata("user_id"));
  $current_role = $project_role['team_role'];
  if($current_role==""){
    $current_role = 1;
  }
?>
<div id="workSpace" <?php if($is_full_screen==true){ ?>class="ganttFullScreen"<?php } ?> style="padding:0px; overflow-y:auto; overflow-x:hidden;border:1px solid #e5e5e5;margin:0 5px"></div>

<div id="gantEditorTemplates" style="display:none;">
<div class="__template__" type="GANTBUTTONS">
  <!--
  <div class="ganttButtonBar noprint">
    <div class="buttons">
      <button onclick="$('#workSpace').trigger('expandAll.gantt');return false;" class="button textual icon " title="EXPAND_ALL"><span class="teamworkIcon">6</span></button>
      <button onclick="$('#workSpace').trigger('collapseAll.gantt'); return false;" class="button textual icon " title="COLLAPSE_ALL"><span class="teamworkIcon">5</span></button>

    <span class="ganttButtonSeparator"></span>
      <button onclick="$('#workSpace').trigger('zoomMinus.gantt'); return false;" class="button textual icon " title="zoom out"><span class="teamworkIcon">)</span></button>
      <button onclick="$('#workSpace').trigger('zoomPlus.gantt');return false;" class="button textual icon " title="zoom in"><span class="teamworkIcon">(</span></button>
     <span class="ganttButtonSeparator requireCanWrite requireCanDelete"></span>
      <button onclick="$('#workSpace').trigger('deleteFocused.gantt');return false;" class="button textual icon delete requireCanWrite" title="Elimina"><span class="teamworkIcon">&cent;</span></button>
    <span class="ganttButtonSeparator"></span>
    <button onclick="$('#workSpace').trigger('moveUpCurrentTask.gantt');return false;" class="button textual icon requireCanWrite requireCanMoveUpDown" title="move up"><span class="teamworkIcon">k</span></button>
    <button onclick="$('#workSpace').trigger('moveDownCurrentTask.gantt');return false;" class="button textual icon requireCanWrite requireCanMoveUpDown" title="move down"><span class="teamworkIcon">j</span></button>
    <span class="ganttButtonSeparator"></span>
    <button class="button textual icon print_ganttchart" title="Print"><span class="teamworkIcon">p</span></button>
    <span class="ganttButtonSeparator"></span>
    <button onclick="ge2.gantt.showCriticalPath=!ge2.gantt.showCriticalPath; ge2.redraw();return false;" class="button textual icon requireCanSeeCriticalPath" title="CRITICAL_PATH"><span class="teamworkIcon">&pound;</span></button>
    <span class="ganttButtonSeparator requireCanSeeCriticalPath"></span>
      <button onclick="ge2.splitter.resize(.1);return false;" class="button textual icon" ><span class="teamworkIcon">F</span></button>
      <button onclick="ge2.splitter.resize(50);return false;" class="button textual icon" ><span class="teamworkIcon splitter_btn">O</span></button>
      <button onclick="ge2.splitter.resize(100);return false;" class="button textual icon"><span class="teamworkIcon">R</span></button>
      <span class="ganttButtonSeparator"></span>
      <button onclick="$('#workSpace').trigger('fullScreen.gantt');return false;" class="button textual icon" title="FULLSCREEN" id="fullscrbtn"><span class="teamworkIcon"><?php if($is_full_screen==true){?>€<?php } else{?>@<?php } ?></span></button>
      <?php if($current_role==1 || $current_role==2){ ?>
      <input type="button" id="saveGanttBtn" class="btn btn-success btn-sm pull-right" value="Save" onclick="saveGanttOnServer();" style="margin-right:15px;margin-top:6px;padding: 8px 20px;">
      <?php } ?>
      <input type="button" class="btn btn-info btn-sm showEntireProject pull-right noprint" value="Show Entire Project" style="padding: 8px 20px;margin-right:15px;margin-top:6px;">
                                                
    </div>

    <div>
      </div>
  </div>
  -->
</div>

<div class="__template__" type="TASKSEDITHEAD"><!--
  <table class="gdfTable" cellspacing="0" cellpadding="0">
    <thead>
    <tr style="height:40px">
      <th class="gdfColHeader" style="width:25px; border-right: none"></th>
      <th class="gdfColHeader" style="width:35px;"></th>
      <th class="gdfColHeader gdfResizable" style="width:300px;">Name</th>
      <th class="gdfColHeader"  align="center" style="width:17px;" title="Start date is a milestone."><span class="teamworkIcon" style="font-size: 8px;">^</span></th>
      <th class="gdfColHeader gdfResizable" style="width:80px;">Start</th>
      <th class="gdfColHeader"  align="center" style="width:17px;" title="End date is a milestone."><span class="teamworkIcon" style="font-size: 8px;">^</span></th>
      <th class="gdfColHeader gdfResizable" style="width:80px;">End</th>
      <th class="gdfColHeader gdfResizable" style="width:100px!important;">Duration</th>
      <th class="gdfColHeader gdfResizable requireCanSeeDep" style="width:276px;display:none;">Dep.</th>
      <th class="gdfColHeader gdfResizable" style="width:200px; text-align: left; padding-left: 10px;">Assign</th>
    </tr>
    </thead>
  </table>
  --></div>

<div class="__template__" type="TASKROW"><!--
  <tr id="tid_(#=obj.id#)" taskId="(#=obj.id#)" class="taskEditRow (#=obj.isParent()?'isParent':''#) (#=obj.collapsed?'collapsed':''#)" level="(#=level#)">
    <th class="gdfCell edit" align="right" style="cursor:pointer;"><span class="taskRowIndex">(#=obj.getRow()+1#)</span><span class="teamworkIcon" style="font-size:12px;">e</span></th>
    <td class="gdfCell noClip" align="center"><div class="taskStatus cvcColorSquare" status="(#=obj.status#)"></div></td>
    <td class="gdfCell indentCell" style="padding-left:(#=obj.level*10+18#)px;">
      <div class="exp-controller" align="center"></div>
      <input type="text" name="name" value="(#=obj.name#)" placeholder="name">
    </td>
    <td class="gdfCell" align="center"><input type="checkbox" name="startIsMilestone"></td>
    <td class="gdfCell"><input type="text" name="start"  value="" class=""></td>
    <td class="gdfCell" align="center"><input type="checkbox" name="endIsMilestone"></td>
    <td class="gdfCell"><input type="text" name="end" value="" class=""></td>
    <td class="gdfCell"><input type="text" name="duration" autocomplete="off" value="(#=obj.duration#)"></td>
    <td class="gdfCell requireCanSeeDep" style = "display:none;"><input type="text" name="depends" autocomplete="off" value="(#=obj.depends#)" (#=obj.hasExternalDep?"readonly":""#)></td>
    <td class="gdfCell taskAssigs">(#=obj.getAssigsString()#)</td>
  </tr>
  --></div>

<div class="__template__" type="TASKEMPTYROW"><!--
  <tr class="taskEditRow emptyRow" >
    <th class="gdfCell" align="right"></th>
    <td class="gdfCell noClip" align="center"></td>
    <td class="gdfCell"></td>
    <td class="gdfCell"></td>
    <td class="gdfCell"></td>
    <td class="gdfCell"></td>
    <td class="gdfCell"></td>
    <td class="gdfCell"></td>
    <td class="gdfCell requireCanSeeDep"></td>
    <td class="gdfCell"></td>
  </tr>
  --></div>

<div class="__template__" type="TASKBAR"><!--
  <div class="taskBox taskBoxDiv" taskId="(#=obj.id#)" >
    <div class="layout (#=obj.hasExternalDep?'extDep':''#)">
      <div class="taskStatus" status="(#=obj.status#)"></div>
      <div class="taskProgress" style="width:(#=obj.progress>100?100:obj.progress#)%; background-color:(#=obj.progress>100?'red':'rgb(153,255,51);'#);"></div>
      <div class="milestone (#=obj.startIsMilestone?'active':''#)" ></div>

      <div class="taskLabel"></div>
      <div class="milestone end (#=obj.endIsMilestone?'active':''#)" ></div>
    </div>
  </div>
  --></div>


<div class="__template__" type="CHANGE_STATUS"><!--
    <div class="taskStatusBox">
    <div class="taskStatus cvcColorSquare" status="STATUS_ACTIVE" title="Active"></div>
    <div class="taskStatus cvcColorSquare" status="STATUS_DONE" title="Completed"></div>
    <div class="taskStatus cvcColorSquare" status="STATUS_FAILED" title="Failed"></div>
    <div class="taskStatus cvcColorSquare" status="STATUS_SUSPENDED" title="Suspended"></div>
    <div class="taskStatus cvcColorSquare" status="STATUS_WAITING" title="Waiting" style="display: none;"></div>
    <div class="taskStatus cvcColorSquare" status="STATUS_UNDEFINED" title="Undefined"></div>
    </div>
  --></div>




<div class="__template__" type="TASK_EDITOR"><!--
  <div class="ganttTaskEditor">
    <h2 class="taskData">Task editor</h2>
  </div>
  --></div>

<div class="__template__" type="ASSIGNMENT_EDITOR"><!--
  <div class="ganttAssignmentEditor">
  </div>
--></div>


<div class="__template__" type="ASSIGNMENT_ROW"><!--
  <tr taskId="(#=obj.task.id#)" assId="(#=obj.assig.id#)" class="assigEditRow" >
    <td ><select name="resourceId"  class="formElements" (#=obj.assig.id.indexOf("tmp_")==0?"":"disabled"#) ></select></td>
    <td align="center"><span class="teamworkIcon delAssig del" style="cursor: pointer">d</span></td>
  </tr>
 --></div>



<div class="__template__" type="RESOURCE_EDITOR"><!--
  <div class="resourceEditor" style="padding: 5px;">

    <h2>Project team</h2>
    <table  cellspacing="1" cellpadding="0" width="100%" id="resourcesTable">
      <tr>
        <th style="width:100px;">name</th>
        <th style="width:30px;" id="addResource"><span class="teamworkIcon" style="cursor: pointer">+</span></th>
      </tr>
    </table>

    <div style="text-align: right; padding-top: 20px"><button id="resSaveButton" class="button big">Save</button></div>
  </div>
  --></div>



<div class="__template__" type="RESOURCE_ROW"><!--
  <tr resId="(#=obj.id#)" class="resRow" >
    <td ><input type="text" name="name" value="(#=obj.name#)" style="width:100%;" class="formElements"></td>
    <td align="center"><span class="teamworkIcon delRes del" style="cursor: pointer">d</span></td>
  </tr>
  --></div>


</div>
<?php 
if($is_full_screen==true){ ?>
    <script type="text/javascript">
        $(function() {
          $('.navbar-absolute').css('display', 'none');
        });
        var date_range = $("#daterange").val();
    var full_date_range = $("#full_project_daterange").val();
    if(date_range!=full_date_range){
        $(".showEntireProject").attr("disabled", false);
    }
    else{
        $(".showEntireProject").attr("disabled", true);
    }
    
    </script>
<?php } ?>
<script type="text/javascript">

  function loadI18n(){
    GanttMaster.messages = {
      "CANNOT_WRITE":"No permission to change the following task:",
      "CHANGE_OUT_OF_SCOPE":"Project update not possible as you lack rights for updating a parent project.",
      "START_IS_MILESTONE":"Start date is a milestone.",
      "END_IS_MILESTONE":"End date is a milestone.",
      "TASK_HAS_CONSTRAINTS":"Task has constraints.",
      "GANTT_ERROR_DEPENDS_ON_OPEN_TASK":"Error: there is a dependency on an open task.",
      "GANTT_ERROR_DESCENDANT_OF_CLOSED_TASK":"Error: due to a descendant of a closed task.",
      "TASK_HAS_EXTERNAL_DEPS":"This task has external dependencies.",
      "GANNT_ERROR_LOADING_DATA_TASK_REMOVED":"GANNT_ERROR_LOADING_DATA_TASK_REMOVED",
      "CIRCULAR_REFERENCE":"Circular reference.",
      "CANNOT_DEPENDS_ON_ANCESTORS":"Cannot depend on ancestors.",
      "INVALID_DATE_FORMAT":"The data inserted are invalid for the field format.",
      "GANTT_ERROR_LOADING_DATA_TASK_REMOVED":"An error has occurred while loading the data. A task has been trashed.",
      "CANNOT_CLOSE_TASK_IF_OPEN_ISSUE":"Cannot close a task with open issues",
      "TASK_MOVE_INCONSISTENT_LEVEL":"You cannot exchange tasks of different depth.",
      "CANNOT_MOVE_TASK":"CANNOT_MOVE_TASK",
      "PLEASE_SAVE_PROJECT":"PLEASE_SAVE_PROJECT",
      "GANTT_SEMESTER":"Semester",
      "GANTT_SEMESTER_SHORT":"s.",
      "GANTT_QUARTER":"Quarter",
      "GANTT_QUARTER_SHORT":"q.",
      "GANTT_WEEK":"Week",
      "GANTT_WEEK_SHORT":"w."
    };
  }

$(document).on("change", "#load-file", function() {
  var uploadedFile = $("#load-file").prop("files")[0];
  upload(uploadedFile);
});

function isHoliday(date) {
  var friIsHoly =false;
  var satIsHoly =true;
  var sunIsHoly =true;

  var pad = function (val) {
    val = "0" + val;
    return val.substr(val.length - 2);
  };

  var holidays = "##";

  var ymd = "#" + date.getFullYear() + "_" + pad(date.getMonth() + 1) + "_" + pad(date.getDate()) + "#";
  var date_format = pad(date.getDate())+"/"+pad(date.getMonth() + 1) +"/"+date.getFullYear();
  var md = "#" + pad(date.getMonth() + 1) + "_" + pad(date.getDate()) + "#";
  var day = date.getDay();
  
  var publicHolidays = [];
  publicHolidays = <?php echo get_public_holidays();?>;
  if(publicHolidays.indexOf(date_format)>-1){
     return true
  }
  return (day == 5 && friIsHoly) || (day == 6 && satIsHoly) || (day == 0 && sunIsHoly) || holidays.indexOf(ymd) > -1 || holidays.indexOf(md) > -1;
  
                   
  
}

$('body').on('click','.showEntireProject',function(){
    var project_id = $("#original_project_id").val();
    var date_range = $("#full_project_daterange").val();
    $("#daterange").val(date_range);
    date_range = date_range.split("/").join("-");
    $.ajax({
                type:'POST',
                url:base_url+'scheduling/projects/set_daterange',
                data: {date_range:date_range, project_id:project_id},
                success:function(result){
                     $(".workSpace_container").html(result);
                     
                }
    }); 
});


$('body').on('click','.view_ganttchart',function(){
    var project_id = $("#original_project_id").val();
    var date_range = $("#daterange").val();
    var full_date_range = $("#full_project_daterange").val();
    if(date_range!=full_date_range){
        $(".showEntireProject").attr("disabled", false);
    }
    else{
        $(".showEntireProject").attr("disabled", true);
    }
    date_range = date_range.split("/").join("-");
    $.ajax({
                type:'POST',
                url:base_url+'scheduling/projects/set_daterange',
                data: {date_range:date_range, project_id:project_id},
                success:function(result){
                     $(".workSpace_container").html(result);
                     
                }
    }); 
});

var ge2;
$(function() {
  var canWrite=true; //this is the default for test purposes

  // here starts gantt initialization
  ge2 = new GanttMaster();
  ge2.set100OnClose=true;
  ge2.canSeeDep=true;

  ge2.shrinkParent=true;

  ge2.init($("#workSpace"));
  loadI18n(); //overwrite with localized ones

  //in order to force compute the best-fitting zoom level
  delete ge2.gantt.zoom;

  var project=loadFromLocalStorage2();

  if (!project.canWrite)
    $(".ganttButtonBar button.requireWrite").attr("disabled","true");

  ge2.loadProject(project);
  ge2.checkpoint(); //empty the undo stack

  //initializeHistoryManagement(ge.tasks[0].id);
  
   $(".gdfTable").removeClass("table");
});

function loadFromLocalStorage2(daterange="") {
  var ret;
  //if not found create a new example task
  if (!ret || !ret.tasks || ret.tasks.length == 0){
    ret=getProjectTasks2(daterange);
  }
  return ret;
}

function getProjectTasks2(daterange=""){

    ret= {"tasks":  <?php echo get_gantt_tasks($project_id); ?>, "selectedRow": "", "deletedTaskIds": [],
   "resources": <?php echo getResources();?>,
      "roles":  [], "canWrite":    true, "canDelete":true, "canWriteOnParent": true, canAdd:true, canSeeDep:true}


    //actualize data
    /*var offset=new Date().getTime()-ret.tasks[0].start;
    for (var i=0;i<ret.tasks.length;i++) {
      ret.tasks[i].start = ret.tasks[i].start + offset;
    }*/
  return ret;
}


function assignTaskToUser() {
   if($("#assignUserForm").valid()){
   var project_id = $("#original_project_id").val();
   var item_id = $("#currentTaskId").val();
   var user_id = $("#currentUserId").val();
        $.ajax({
                type:'POST',
                url:base_url+'scheduling/projects/assignTaskToUser',
                data: {item_id:item_id,user_id:user_id},
                beforeSend: function() {
                  $('#assignTaskBtn').val("Saving in Progress");
                  $('#assignTaskBtn').attr("disabled",true); 
                },
                success:function(result){
                    $('#assignTaskBtn').val("Save"); 
                    $('#assignTaskBtn').attr("disabled",false); 
                    $( ".workSpace_container" ).load( base_url+"scheduling/projects/load_gantt_chart/"+project_id );
                    $(".popUpClose").click();
                }
             });
   }
   else{
       $("#assignUserForm").validate();
   }
}

function saveGanttOnServer() {

  //this is a simulation: save data to the local storage or to the textarea
  //saveInLocalStorage();
  var prj = ge2.saveProject();
  var project_id = $("#original_project_id").val();
        $.ajax({
                type:'POST',
                url:base_url+'scheduling/projects/update_project_tasks',
                data: {prj:JSON.stringify(prj),project_id:project_id},
                beforeSend: function() {
                  $('#saveGanttBtn').val("Saving in Progress");
                  $('#saveGanttBtn').attr("disabled",true); 
                },
                success:function(result){
                    $('#saveGanttBtn').val("Save"); 
                    $('#saveGanttBtn').attr("disabled",false); 
                    var projectDates = result.split("|");
                    
                    $(".project_start_date").text(projectDates[0]);
                    $(".project_end_date").text(projectDates[1]);
                  
                    $("#daterange").val(projectDates[0]+" - "+projectDates[1]);
        
                     /*swal({
                        title: "Task Duration Updated!",
                        text: "",
                        timer: 2000,
                        showConfirmButton: false,
                        type: "success"
                    }).catch(swal.noop);*/
                    
                    //$( ".workSpace_container" ).load( base_url+"projects/load_gantt_chart/"+project_id );
                    }
             });
}

</script>

