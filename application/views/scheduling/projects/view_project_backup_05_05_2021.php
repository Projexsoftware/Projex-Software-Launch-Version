<style>
#dp{
    margin-top:170px;
}
.gantt_default_corner div:nth-child(4){
    display:none;
}
.swal2-modal h2{
  line-height:35px;
}
.no-border{
  border:0px!important;
  cursor:pointer;
  min-width:30px;
  padding:12px 0px!important;
}
.fc-fullproject-view .ps-scrollbar-y-rail{
  display:none;
}
.fc-fullproject-view .fc-scroller{
   overflow-x:auto!important;
   overflow-y:hidden!important;
}
.fc-body .fc-resource-area .fc-cell-content {
    font-size: 12px;
    position: relative;
    padding-top: 3px;
    padding-bottom: 3px;
}
.fc-fullproject-view .fc-divider div, .fc-fullproject-view .fc-rows td.fc-widget-content div{
  height: 25px!important;
}
.fc-fullproject-view .fc-rows td.fc-widget-content .fc-content{
  height:15px!important;
}
.right-border{
 border-bottom: 1px solid transparent!important;
 border-right: 1px solid #EEEEEE!important;
 cursor:pointer;
 min-width:30px;
 padding:12px 0px!important;
}
.off_days{
  background-color:#ddd;
}
.card .card-image {
    height: 60%;
    position: relative;
    overflow: hidden;
    margin-left: 0px; 
    margin-right: 15px;
    margin-top: 15px;
    border-radius: 6px;
    z-index: 3;
    box-shadow: 0 10px 30px -12px rgba(0, 0, 0, 0.42), 0 4px 25px 0px rgba(0, 0, 0, 0.12), 0 8px 10px -5px rgba(0, 0, 0, 0.2);
}
.no_of_days_container{
  display:none;
}
.project_team_error{
   color:red;
}
.checkbox{
   width:auto!important;
}
.timeline-body p{
   word-wrap: break-word;
}
.remove_checklist {
    margin: 0 0 0 25px;
    text-align: right;
    padding: 0 0 0 0;
}
ul{
  list-style:none;
}
ul li{
  padding-bottom:10px;
}
.table-responsive {
overflow-y:hidden;
}
.list_container .btn, .list_container{
   padding-left: 0px!important;
   padding-right: 10px!important;
   padding-top: 0px!important;
   padding-bottom: 0px!important;
}
.project_edit_btn{
   padding-left: 7px!important;
   padding-right: 7px!important;
   padding-top: 7px!important;
   padding-bottom: 7px!important;
   margin-left:10px!important;
}
#ProjectTeamForm .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn){
   width:80%;
}
.task_actions{
  padding:3px;
  display:inline;
}
.ui-sortable tr {
	cursor:pointer;
}
</style>
<?php 
  $project_role = get_user_project_role($project_edit['id'], $this->session->userdata("admin_id"));
  $current_role = $project_role['team_role'];
  if($current_role==""){
    $current_role = 1;
  }
  
?>
<input type="hidden" id="original_project_id" name="original_project_id" value="<?php echo $project_edit['id'];?>">

<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="col-md-6">
                                    <h4 class="card-title"><?php echo $project_edit['name'];?><?php if(($current_role==1 || $current_role==2) && $this->session->userdata('admin_role_id')!=3){ ?><a rel="tooltip" href="<?php echo SURL;?>projects/update_project/<?php echo $project_edit['id'];?>" class="btn btn-success project_edit_btn" data-original-title="Update Project" title="Update Project"><i class="material-icons">edit</i></a><?php } ?></h4>
                                    <div class="card-image">
                                    <img src="<?php if($project_edit['image']!="") { echo PROJECT_IMG.$project_edit['image']; } else{ echo IMG.'image_placeholder.jpg'; }?>" class="img" />
                                    </div>
                                    </div>
                                    <div class="col-md-3 col-md-offset-3">
                                    <h5 class="card-title">Switch Views</h5>
                                            <div class="togglebutton">
                                                <label>
                                                    <input id="list_view" name="list_view" type="checkbox" checked onclick="change_view('list_view','calendar_view');"> List View
                                                </label>
                                            </div>
                                            <div class="togglebutton">
                                                <label>
                                                    <input id="calendar_view" name="calendar_view" type="checkbox" onclick="change_view('calendar_view','list_view');"> Schedule View
                                                </label>
                                            </div>
                                   </div>
                                </div>
                                <div class="card-content">
                                <div class="col-md-12">
                                <div class="panel-group col-md-4" id="accordion" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingProjectTeam">
                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion2" href="#projectDescription" aria-controls="projectDescription">
                                                    <h4 class="panel-title">
                                                        Project Description
                                                        <i class="material-icons">keyboard_arrow_down</i>
                                                    </h4>
                                                </a>
                                            </div>
                                            <div id="projectDescription" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingProjectDescription">
                                                <div class="panel-body">
                                                    <?php echo $project_edit['description'];?>
                                                </div>
                                            </div>
                                        
                                        </div>
									</div>
									<div class="panel-group col-md-8" id="accordion2" role="tablist" aria-multiselectable="true">
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingProjectName">
                                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#projectName" aria-expanded="false" aria-controls="projectName">
                                                    <h4 class="panel-title">
                                                        Project Documents
                                                        <i class="material-icons">keyboard_arrow_down</i>
                                                    </h4>
                                                </a>
                                            </div>
                                            <div id="projectName" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingProjectName">
                                                <div class="panel-body">
                                                  <?php if($current_role==1 || $current_role==2){ ?>
                                                  <a class="btn btn-rose" data-toggle="modal" data-target="#addDocumentModal"><i class="material-icons">attach_file</i> Add Document</a>
                                                  <?php } ?>
                                                  <div id="document_container">
                                                     <?php 
$project_documents = get_project_documents($project_edit['id'], $current_role);

if(count($project_documents)>0){ echo "<ul class='list_container'>"; foreach($project_documents as $document){ ?>
                                                       <li> <span class="btn btn-simple btn-icon"><i class="material-icons">insert_drive_file</i></span> <?php echo $document['document_original_name'];?><?php if($current_role==1 || $current_role==2){ ?><span id="<?php echo $document['id'];?>" class="remove_document pull-right btn btn-simple btn-danger btn-icon"><i class="material-icons">close</i></span><span class="pull-right btn btn-simple btn-icon">|</span><?php } ?><a class="pull-right btn btn-success btn-simple btn-icon" href="<?php echo TASK_PATH.'documents/'.$document['document'];?>" target="_Blank"><i class="material-icons">file_download</i></a><?php if($current_role==1 || $current_role==2){ ?>
                                        <div class="togglebutton pull-right privacy_toggle">
                                                <label class="text-default">
                                                  <input id="privacy_settings<?php echo $document['id'];?>" name="privacy_settings" type="checkbox" <?php if($document['privacy_settings']==0){ ?> checked <?php } ?> onclick="set_privacy(<?php echo $document['id'];?>, 0, 'Document');" >Private
                                                </label>
                                        </div>
                                        <?php } ?></li>
                                                        <?php } echo "</ul>";} ?>
                                                  </div>
                                                </div>
                                            </div>
                                    </div>
                                 </div>
                                 </div>
								 <div class="col-md-12">
                               
								<div class="panel-group col-md-4" id="accordion3" role="tablist" aria-multiselectable="true">
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingProjectDates">
                                                <a role="button" data-toggle="collapse" data-parent="#accordion3" href="#projectDates" aria-controls="projectDates">
                                                    <h4 class="panel-title">
                                                        Project Dates
                                                        <i class="material-icons">keyboard_arrow_down</i>
                                                    </h4>
                                                </a>
                                            </div>
                                            <div id="projectDates" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingProjectDates">
                                                <div class="panel-body">
                                                   <p><b>Start Date :</b> <?php echo date("d/m/Y", strtotime($project_edit['start_date']));?></p>
                                                   <p><b>End Date :</b> <span class="project_end_date"><?php echo date("d/m/Y", strtotime($project_edit['end_date']));?></span></p>
                                                </div>
                                            </div>
                                        </div>
								</div>
								<div class="panel-group col-md-8" id="accordion4" role="tablist" aria-multiselectable="true">
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingProjectTeam">
                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion4" href="#projectTeam" aria-controls="projectTeam">
                                                    <h4 class="panel-title">
                                                        Project Team
                                                        <i class="material-icons">keyboard_arrow_down</i>
                                                    </h4>
                                                </a>
                                            </div>
                                            <div id="projectTeam" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingProjectTeam">
                                                <div class="panel-body project_team_container">
                                                 <?php if(($current_role==1 || $current_role==2) && $this->session->userdata('admin_role_id')!=3){ ?><a class="btn btn-info" data-toggle="modal" data-target="#addProjectTeamModal"><i class="material-icons">supervisor_account</i> Edit Project Team</a><?php } ?>
                                                	
                                                       <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <?php $team = get_project_team($project_edit['id']); ?>
                                                <?php 
                                                 $project_team = array();
                                                 foreach($team as $val){ 
                                                 $project_team[] = $val['team_id'];
                                                 if($val['team_role']==1){
                                                    $team_role = "Project Manager";
                                                 }
                                                 else if($val['team_role']==2){
                                                    $team_role = "Project Leader";
                                                 }
                                                 else if($val['team_role']==3){
                                                    $team_role = "Project Member";
                                                 }
                                                 else{
                                                    $team_role = "Project Guest";
                                                 }

                                                 if($val['is_invitation_send']==1){
                                                   $invitation_status = "<span class='label label-warning'>Sent</span>"; }
                                                 else if($val['is_invitation_send']==2){
                                                   $invitation_status = "<span class='label label-success'>Joined</span>"; }
                                                 else{
                                                   $invitation_status = "<span class='label label-danger'>Not Sent Yet</span>";
                                                 }
                                                ?>
                                                <tr>
                                                    <td><b><?php echo $team_role;?></b></td>
                                                    <td><?php echo $val['first_name']." ".$val['last_name'];?></td>
                                                    <?php if(($current_role==1 || $current_role==2) && $this->session->userdata('admin_role_id')!=3){ ?><td><?php if($val['team_role']!=1){ ?><center><?php echo $invitation_status;?></center><?php } ?></td>
                                                    <?php if($val['team_role']!=1){ ?><td width="30px"><?php if($val['is_invitation_send']==0){ ?> <button id="<?php echo $val['id'];?>" class="btn btn-xs btn-success invite_project_team pull-right">
                                        <span class="btn-label">
                                            <i class="material-icons">email</i>
                                        </span>
                                        Invite
                                    </button><?php } ?><button id="<?php echo $val['id'];?>" class="btn btn-xs btn-danger remove_project_team pull-right">
                                        <span class="btn-label">
                                            <i class="material-icons">delete</i>
                                        </span>
                                        Delete
                                    </button></td><?php } else { ?><td style="padding:30px;">&nbsp;</td><?php } }?>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
<?php if(($current_role==1 || $current_role==2) && $this->session->userdata('admin_role_id')!=3){ ?>
                                     <!-- New Project Team modal -->
                                            <div class="modal fade" id="addProjectTeamModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-notice">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
<h5 class="modal-title" id="myModalLabel">Edit Project Team</h5>                                                        </div>
                                                        <div class="modal-body">
                                        <div class="task_response"></div>             
					<form id="ProjectTeamForm" method="post">
                                        <input type="hidden" id="project_team_project_id" name="project_team_project_id" value="<?php echo $project_edit['id'];?>">
                                        <div class="project_team_error error"></div>
                                        <div class="form-group label-floating">
                                            <button class="btn btn-simple btn-github" style="font-size:16px;padding-left:0px;">
                                                <i class="fa fa-users"></i> Project Team
                                            <div class="ripple-container"></div></button>
                                                <div class="leaders_users_container">
                                                    <select id="leaders" name="leaders[]" class="selectpicker select_leaders_team" data-style="select-with-transition" multiple title="Choose Leaders">
                                                                <?php if(count($users)>0){
                                                                foreach($users as $val){
                                                                if(!(in_array($val['id'], $project_team))){
                                                                ?>
                                                                <option value="<?php echo $val['id'];?>"><?php echo $val['first_name']." ".$val['last_name'];?></option>
                                                                <?php } } }?>
                                                    </select>
                                                </div>
                                            <?php echo form_error('leaders', '<div class="custom_error">', '</div>'); ?>
					                    </div>
                                        <div class="form-group label-floating">
                                            <div class="members_users_container">
                                                <select id="members" name="members[]" class="selectpicker select_members_team" data-style="select-with-transition" multiple title="Choose Members">
                                                        <?php if(count($users)>0){
                                                        foreach($users as $val){
                                                        if(!(in_array($val['id'], $project_team))){
                                                        ?>
                                                        <option value="<?php echo $val['id'];?>"><?php echo $val['first_name']." ".$val['last_name'];?></option>
                                                        <?php } } }?>
                                                </select>
                                            </div>
                                            <?php echo form_error('members', '<div class="custom_error">', '</div>'); ?>
					</div>	
                                        <div class="form-group label-floating">
                                            <div class="guest_users_container">
                                                <select id="guest" name="guest[]" class="selectpicker select_guest_team" data-style="select-with-transition" multiple title="Choose Guest">
                                                        <?php if(count($users)>0){
                                                        foreach($users as $val){
                                                        if(!(in_array($val['id'], $project_team))){
                                                        ?>
                                                        <option value="<?php echo $val['id'];?>"><?php echo $val['first_name']." ".$val['last_name'];?></option>
                                                        <?php } } }?>
                                                </select>
                                            </div>
                                            <?php echo form_error('guest', '<div class="custom_error">', '</div>'); ?>
					</div>		
                                        <div class="form-footer text-right">
                                            <button type="button" class="btn btn-rose btn-fill add_project_team">Update</button>
                                        </div>
                                    
                                        </form>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end new project team modal -->
<?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            
							</div>
                        </div>
                       
                        </div>
                    </div>
                    </div>
                    <div id="list_view_container" class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="rose">
                                    <i class="material-icons">list</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title" style="display:inline;">List View</h4> 
                                    <?php if ($this->session->userdata('admin_role_id')!=3) { ?>
<?php if($current_role==1 || $current_role==2){ ?>
                                        <a style="margin-top:0px;" class="btn btn-info pull-right" data-toggle="modal" data-target="#addTaskModal"><i class="material-icons">assignment</i> Add Task</a>

<!-- New Task modal -->
                                            <div class="modal fade" id="addTaskModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-notice">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
<h5 class="modal-title" id="myModalLabel">Add Task</h5>                                                        </div>
                                                        <div class="modal-body">
                                        <div class="task_response"></div>             
					<form id="TaskForm" method="post">
                                        <input type="hidden" id="task_type" name="task_type" value="0">
                                        <input type="hidden" id="project_id" name="project_id" value="<?php echo $project_edit['id'];?>">
                                        <div class="form-group label-floating">
                                            <select id="stage_id" name="stage_id" required="true" class="selectpicker" data-style="select-with-transition" title="Choose Stage">
                                                        
                                                        <?php if(count($stages)>0){
                                                        foreach($stages as $val){
                                                        ?>
                                                        <option value="<?php echo $val['id'];?>"><?php echo $val['name'];?></option>
                                                        <?php } } ?>
                                                    </select>
                                            <?php echo form_error('stage_id', '<div class="custom_error">', '</div>'); ?>
					</div>
                                        <div class="form-group label-floating task_dropdown">
                                            <select id="task_id" name="task_id" required="true" class="selectpicker" data-style="select-with-transition" title="Choose Task">
                                                        
                                                        <?php if(count($tasks)>0){
                                                        foreach($tasks as $val){
                                                        ?>
                                                        <option value="<?php echo $val['id'];?>"><?php echo $val['name'];?></option>
                                                        <?php } } ?>
                                                    </select>
                                                    <button task_type="1" type="button" class="btn btn-danger btn-xs pull-right list_type">Hide List</button>
                                            <?php echo form_error('task_id', '<div class="custom_error">', '</div>'); ?>
					</div>
                                        <div class="form-group label-floating task_textfield" style="display:none;">
                                            <input class="form-control" type="text" name="task_name" id="task_name" required="true" uniqueTask="true" value="<?php echo set_value('task_name')?>" placeholder="New Task"/>
                                                    <button task_type="0" type="button" class="btn btn-danger btn-xs pull-right list_type">Show List</button>
                                            <?php echo form_error('task_id', '<div class="custom_error">', '</div>'); ?>
					</div>
                                        
                                        <div class="form-group label-floating">
                                            
                                            <input class="form-control datepickerinput" type="text" name="start_date" id="start_date" required="true" value="<?php echo date("d/m/Y", strtotime($project_edit['start_date']));?>" placeholder="Start Date"/>
                                            <?php echo form_error('start_date', '<div class="custom_error">', '</div>'); ?>
					</div>
                                        <div class="form-group label-floating">
                                            
                                            <input class="form-control datepickerinput" type="text" name="end_date" id="end_date" required="true" value="<?php echo set_value('end_date')?>" placeholder="End Date"/>
                                            <?php echo form_error('end_date', '<div class="custom_error">', '</div>'); ?>
					</div>
                                        <div class="form-footer text-right">
                                            <button type="button" class="btn btn-rose btn-fill add_new_task">Add</button>
                                        </div>
                                    
                                        </form>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end new task modal -->
                                       
                                        
                                     						

                                     <?php } } ?>
                                    <div class="toolbar">
                                     
                                        <?php
										if ($this->session->flashdata('err_message')) {
											?>
											<div class="alert alert-danger">
												<?php echo $this->session->flashdata('err_message'); ?>
											</div>
											<?php
										}

										if ($this->session->flashdata('ok_message')) {
											?>
											<div class="alert alert-success alert-dismissable">
												<?php echo $this->session->flashdata('ok_message'); ?>
											</div>
											<?php
										}
										?>
									</div>
                            <div class="row ">
                                <div class="col-md-12 project_items">
<div class="panel-group col-md-12" id="accordionStages" role="tablist" aria-multiselectable="true">
<input type="hidden" id="sortable_stages" class="form-control"/>
                                <?php
                                  if(count($project_stages)>0){
                                  foreach($project_stages as $val){
                                ?>
                                        

                                        <div id="<?php echo $val['stage_id'];?>" class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingTaskItem<?php echo $val['stage_id'];?>">
                                                <a role="button" data-toggle="collapse" data-parent="#accordionStages" href="#taskItem<?php echo $val['stage_id'];?>" aria-controls="taskItem<?php echo $val['stage_id'];?>">
                                                    <h4 class="panel-title">
                                                        <?php echo $val['stage_name'];?><div style="display:inline" class="stage_<?php echo $val['stage_id'];?>" item_count="<?php echo count(get_project_item_by_stage($val['stage_id'], $project_edit['id']));?>">&nbsp;&nbsp;&nbsp;&nbsp;
<?php 
$stage_status = get_stage_status($project_edit['id'], $val['stage_id'], count(get_project_item_by_stage($val['stage_id'], $project_edit['id'])));
if($stage_status == 0){ ?>                        
<span class="label label-danger">Not Done</span>
<?php } else if($stage_status == 1){ ?>
<span class="label label-warning">Partially Done</span>
<?php } else { ?>
<span class="label label-success">Complete</span>
<?php } ?>
</div>
                                                        <i class="material-icons">keyboard_arrow_down</i>
                                                    </h4>
                                                </a>
                                            </div>
                                            <div id="taskItem<?php echo $val['stage_id'];?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTaskItem<?php echo $val['stage_id'];?>">
                                             <div class="panel-body">
                                               <div class="table-responsive table-<?php echo $val['stage_id'];?>">
                                                 <table id="table_<?php echo $val['stage_id'];?>" class="table sortable_table">
                                                   <tbody>
                                                      <?php 
                                                      $project_items = get_project_item_by_stage($val['stage_id'], $project_edit['id']);

                                                      $i=1;
                                                      foreach($project_items as $item){
                                                      ?>
                                                         <tr rowno="<?php echo $item['id'];?>">
<input class="form-control" type="hidden" name="task_id<?php echo $item['id'];?>" id="task_id<?php echo $item['id'];?>" value="<?php echo $item['task_id'];?>"/>
<input class="form-control" type="hidden" name="stage_id<?php echo $item['id'];?>" id="stage_id<?php echo $item['id'];?>" value="<?php echo $item['stage_id'];?>"/>
<td class="priority"><?php echo $i;?></td>
                                                           <td><?php echo date("d/m/Y", strtotime($item['start_date']));?></td>
                                                           <td><?php echo $item['task_name'];?></td>
                                                           <td>
                                                             <?php include("application/views/projects/task_items/users.php");?>
                                                           </td>
                                                           <td>
                                            <?php include("application/views/projects/task_items/checklist.php");?>
                                                           </td>
                                                           <td>
                                            <?php include("application/views/projects/task_items/notes.php");?>
                                                           </td>
                                                           <td>
                                            <?php include("application/views/projects/task_items/files.php");?>
                                                           </td>
                                                            <td>
                                            <?php include("application/views/projects/task_items/images.php");?>
                                                           </td>
                                            <?php if($current_role==1 || $current_role==2){ ?>
                                                           <td>
                                           <?php $reminder_users = get_task_reminder_users($item['task_id']);?>
                                           <?php include("application/views/projects/task_items/reminders.php");?>
                                                           </td>
                                            <?php } ?>
                                                           <td><div id="status<?php echo $item['id'];?>"><?php if($item['status']==0){?> <span class="label label-danger">Not Done</span> <?php } else if($item['status']==1     ){ ?> <span class="label label-warning">Partially Done</span><?php } else{ ?><span class="label label-success">Complete</span> <?php } ?></div></td>
                                                           <?php if($current_role==1 || $current_role==2){ ?><td><a rowno="<?php echo $item['id'];?>" class="task_actions btn btn-simple btn-warning btn-icon edit" data-toggle="modal" data-target="#editTaskModal<?php echo $item['id'];?>"><i class="material-icons">edit</i></a><a rowno="<?php echo $item['id'];?>" class="task_actions remove_task btn btn-simple btn-danger btn-icon"><i class="material-icons">delete</i></a>
<!-- Edit Task modal -->
                                            <div class="modal fade" id="editTaskModal<?php echo $item['id'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-notice">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
<h5 class="modal-title" id="myModalLabel">Edit <?php echo $item['task_name'];?> Task</h5>                                                        </div>
                                                        <div class="modal-body">        
					<form id="EditTaskForm<?php echo $item['id'];?>" method="post">
                                        <input type="hidden" name="task_item_id" value="<?php echo $item['id'];?>">
                                        <input type="hidden" name="project_item_id" value="<?php echo $item['project_id'];?>">
                                        <div class="form-group label-floating">
                                            
                                            <input class="form-control datepickerinput" type="text" name="start_date" id="start_date" required="true" value="<?php echo date("d/m/Y", strtotime($item['start_date']));?>" placeholder="Start Date"/>
                                            <?php echo form_error('start_date', '<div class="custom_error">', '</div>'); ?>
					</div>
                                        <div class="form-group label-floating">
                                            
                                            <input class="form-control datepickerinput" type="text" name="end_date" id="end_date" required="true" value="<?php echo date("d/m/Y", strtotime($item['end_date']));?>" placeholder="End Date"/>
                                            <?php echo form_error('end_date', '<div class="custom_error">', '</div>'); ?>
					</div>
                                        <div class="form-footer text-right">
                                            <button type="button" class="btn btn-rose btn-fill edit_task" rowno="<?php echo $item['id'];?>">Update</button>
                                        </div>
                                    
                                        </form>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end edit task modal -->
                                            </td>
<?php } ?>
                                                         </tr>
                                                      <?php $i++; } ?>
                                                    </tbody>
                                                   </table>
                                                 </div>
                                              </div>
                                           </div>
                                        </div>
                                <?php } 
                                   }
                                ?>
                                </div>
				</div>
                             </div>
                             <!-- end of table -->

                                </div>
                                <!-- end content-->
                            </div>
                            <!--  end card  -->
                        </div>
<?php if($current_role==1 || $current_role==2){ ?>


                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-content">
                                     <div class="panel-group" id="accordionTemplate" role="tablist" aria-multiselectable="true">
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingOneTemplate">
                                                <a role="button" data-toggle="collapse" data-parent="#accordionTemplate" href="#collapseOneTemplate" aria-controls="collapseOneTemplate">
                                                    <h4 class="panel-title">
                                                        Import Items Section
                                                        <i class="material-icons">keyboard_arrow_down</i>
                                                    </h4>
                                                </a>
                                            </div>
                                            <div id="collapseOneTemplate" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOneTemplate">
                                                <div class="panel-body">
                                                    <div class="col-lg-5 col-md-4 col-sm-3">
                                                    <select class="selectpicker add_from_template" data-style="btn btn-primary btn-round" title="Choose Template" id="template_id">                 
                                                    <?php if(count($templates)>0){ foreach($templates as $tem){ ?>                                       
                                                    <option value="<?php echo $tem['id'];?>"><?php echo $tem['name'];?></option>
                                                    <?php } }?>
                                                    </select>
                                                </div>
                                                <div class="col-lg-5 col-md-4 col-sm-3">
                                                    <select class="selectpicker add_from_project" data-style="btn btn-primary btn-round" title="Choose Project" id="import_project_id">                 
                                                    <?php if(count($projects)>0){ foreach($projects as $project){ ?>                                       
                                                    <option value="<?php echo $project['id'];?>"><?php echo $project['name'];?></option>
                                                    <?php } }?>
                                                    </select>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                 </div>
                            </div>
                        </div>
                        <!-- end col-md-12 -->
<?php } ?>
                    </div>
                    <!-- end row -->
                    
                    <div id="calendar_view_container" class="row" style="display:none;">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="rose">
                                    <i class="material-icons">schedule</i>
                                </div>
                                <div class="card-content" class="ps-child gantt_container">
                                    <h4 class="card-title">Project Schedule</h4>
                                    <!--<div class="pull-right">
                                    <button class="btn btn-sm btn-rose" onclick="chart.zoomIn();"><i class="material-icons">zoom_in</i></button> <button class="btn btn-rose btn-sm" onclick="chart.zoomOut();"><i class="material-icons">zoom_out</i></button>
                                    <button class="btn btn-rose btn-sm" onclick="chart.fitAll();">Fit All</button> <button class="btn btn-rose btn-sm" onclick="chart.zoomTo('day', 1, 'last-date');">Zoom to last day</button> <button class="btn btn-rose btn-sm" onclick="chart.collapseAll();">Collapse All</button> <button class="btn btn-rose btn-sm" onclick="chart.expandAll();">Expand All</button> <button class="btn btn-rose btn-sm" onclick="chart.print();"><i class="material-icons">print</i></button>
                                    <button class="btn btn-rose btn-sm" onclick="fullscreen();"><i class="material-icons">fullscreen</i></button>
                                    <p></p>
                                    </div>-->
                                    <div class="col-md-12">
                                            <h4><i class="material-icons" style="vertical-align:top;">date_range</i> Date Range Section</h4>
                                            <div class="form-group label-floating">
                                                <input type="text" class="form-control pull-left" name="daterange" id="daterange" value="<?php echo date("d/m/Y", strtotime($project_edit['start_date']));?> - <?php echo date("d/m/Y", strtotime($project_edit['end_date']));?>"/>
                                                <input type="button" class="btn btn-rose btn-sm pull-right view_ganttchart" value="View" style="padding: 8px 20px;">
                                            </div>
                                            <div class="loader">
                                           <center>
                                               <img class="loading-image" src="<?php echo IMG;?>search.gif" alt="loading.." style="width:300px;">
                                           </center>
                                    </div>
                                    </div>
                                    <p></p>
                                    <div id="dp"></div>
                                    <div id="dp1"></div>
                                     
                                    
                                    
                                </div>
                                
                            </div>
                        </div>
                    </div>
<?php if($current_role==1 || $current_role==2){ ?>
<!-- New Task modal -->
                                            <div class="modal fade" id="addTaskCalendarModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-notice">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
<h5 class="modal-title" id="myModalLabel">Add Task</h5>                                                        </div>
                                                        <div class="modal-body">
                                        <div class="task_response"></div>             
					<form id="TaskCalendarForm" method="post">
                                        <input type="hidden" id="calendar_task_type" name="task_type" value="0">
                                        <input type="hidden" id="calendar_project_id" name="project_id" value="<?php echo $project_edit['id'];?>">
                                        <div class="form-group label-floating">
                                            <select id="calendar_stage_id" name="stage_id" required="true" class="selectpicker" data-style="select-with-transition" title="Choose Stage">
                                                        
                                                        <?php if(count($stages)>0){
                                                        foreach($stages as $val){
                                                        ?>
                                                        <option value="<?php echo $val['id'];?>"><?php echo $val['name'];?></option>
                                                        <?php } } ?>
                                                    </select>
                                            <?php echo form_error('stage_id', '<div class="custom_error">', '</div>'); ?>
					</div>
                                        <div class="form-group label-floating task_dropdown">
                                            <select id="calendar_task_id" name="task_id" required="true" class="selectpicker" data-style="select-with-transition" title="Choose Task">
                                                        
                                                        <?php if(count($tasks)>0){
                                                        foreach($tasks as $val){
                                                        ?>
                                                        <option value="<?php echo $val['id'];?>"><?php echo $val['name'];?></option>
                                                        <?php } } ?>
                                                    </select>
                                                    <button task_type="1" type="button" class="btn btn-danger btn-xs pull-right list_type">Hide List</button>
                                            <?php echo form_error('task_id', '<div class="custom_error">', '</div>'); ?>
					</div>
                                        <div class="form-group label-floating task_textfield" style="display:none;">
                                            <input class="form-control" type="text" name="task_name" id="calendar_task_name" required="true" uniqueTask="true" value="<?php echo set_value('task_name')?>" placeholder="New Task"/>
                                                    <button task_type="0" type="button" class="btn btn-danger btn-xs pull-right list_type">Show List</button>
                                            <?php echo form_error('task_id', '<div class="custom_error">', '</div>'); ?>
					</div>
                                        
                                        <div class="form-group label-floating">
                                            
                                            <input class="form-control datepickerinput start_date_calendar" type="text" name="start_date" id="start_date" required="true" value="<?php echo date("d/m/Y", strtotime($project_edit['start_date']));?>" placeholder="Start Date"/>
                                            <?php echo form_error('start_date', '<div class="custom_error">', '</div>'); ?>
					</div>
                                        <div class="form-group label-floating">
                                            
                                            <input class="form-control datepickerinput" type="text" name="end_date" id="end_date" required="true" value="<?php echo set_value('end_date')?>" placeholder="End Date"/>
                                            <?php echo form_error('end_date', '<div class="custom_error">', '</div>'); ?>
					</div>
                                        <div class="form-footer text-right">
                                            <button type="button" class="btn btn-rose btn-fill add_new_task_from_calendar">Add</button>
                                        </div>
                                    
                                        </form>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end new task modal -->
<?php } ?>

<!-- Modal -->

 <!-- Document modal -->
                                            <div class="modal fade" id="addDocumentModal" tabindex="-1" role="dialog" aria-labelledby="myDocumentModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-notice">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
<h5 class="modal-title" id="myDocumentModalLabel">Add Document</h5>                                                        </div>
                                                        <div class="modal-body">
<div class="card">
                                <div class="card-header card-header-icon" data-background-color="rose">
                                    <i class="material-icons">attach_file</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Add New Document</h4> 
                                    <div class="toolbar">
<form id="DocumentForm" name="DocumentForm" class="upload_project_document" method="post" enctype="multipart/form-data">
<input type="hidden" id="document_project_id" name="document_project_id" value="<?php echo $project_edit['id'];?>">
                                                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail">
                                                    <img src="<?php echo IMG;?>image_placeholder.jpg" alt="...">
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                <div>
                                                    <span class="btn btn-rose btn-round btn-file">
                                                        <span class="fileinput-new">Select file</span>
                                                        <span class="fileinput-exists">Change</span>
                                                        <input required="true" type="file" id="document_file" name="document_file" />
                                                    </span>
                                                    <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                                    <p class="document_error text-danger"></p>
                                                </div>
                                            </div>
<div class="form-footer text-right">
                                            <div class='progress progress-line-success' id="progressDocumentDivId">
                                                <div class='progress-bar progress-bar-success' id='progressDocumentBar'>0%</div>
                                            </div>
                                            <button id="btn-upload-document" type="submit" class="btn btn-rose btn-fill">Add</button>
                                        </div>
</form>
</div>
</div>
</div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end Files modal -->