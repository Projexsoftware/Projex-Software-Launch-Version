<style>
  .resEdit {
    padding: 15px;
  }

  .resLine {
    width: 95%;
    padding: 3px;
    margin: 5px;
    border: 1px solid #d0d0d0;
  }

  .ganttButtonBar h1{
    color: #000000;
    font-weight: bold;
    font-size: 28px;
    margin-left: 10px;
  }

</style>

<style>
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
  $project_role = get_user_project_role($project_edit['project_id'], $this->session->userdata("user_id"));
  $current_role = isset($project_role)?$project_role['team_role']:"";
  if($current_role==""){
    $current_role = 1;
  }
  
?>

<input type="hidden" id="original_project_id" name="original_project_id" value="<?php echo $project_edit['project_id'];?>">
<div class="row noprint">
                        <div class="col-md-12">
                            <div class="card">
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
                                <div class="card-header">
                                     <div class="col-md-12"><h4 class="card-title"><?php echo $project_edit['project_title'];?> <!--<a rel="tooltip" href="<?php echo SURL;?>buildz/reset_project/<?php echo $project_edit['project_id'];?>" class="btn btn-sm btn-danger project_edit_btn" data-original-title="Reset Project" title="Reset Project"><i class="material-icons">clear</i> Reset Project</a>--></h4> </div>
                                </div>
                                <div class="card-content">
                                <div class="panel-group col-md-12" id="accordion" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingProjectTeam">
                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion2" href="#projectDescription" aria-controls="projectDescription">
                                                    <h4 class="panel-title">
                                                        Project Log
                                                        <i class="material-icons">keyboard_arrow_down</i>
                                                    </h4>
                                                </a>
                                            </div>
                                            <div id="projectDescription" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingProjectDescription">
                                                <div class="panel-body">
                                                     <div class="text-right">
                                                       <button type="button" class="btn btn-sm btn-warning btn-fill add-new-log"><i class="material-icons">add</i> Add New Log</button>
                                                     </div>
                                                     <form class="project_log_form" id="ProjectLogForm" method="post" enctype="multipart/form-data" rowno="1">
                                                     <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <td><b>Project Log</b></td>
                                                                <td colspan="4"><center><b><?php echo $project_edit['project_title'];?></b></center></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>Date</b></td>
                                                                <td><b>User</b></td>
                                                                <td><b>Entity Type</b></td>
                                                                <td><b>Notes</b></td>
                                                                <td><b>Image</b></td>
                                                            </tr>
                                                        </thead>
                                                         <tbody class="project-logs-container">
                                                             <?php 
                                                                if(count($project_logs)>0){
                                                                foreach($project_logs as $val){ ?>
                                                                <tr>
                                                                    <td><?php echo date("d/m/Y", strtotime($val['date']));?></td>
                                                                    <td><?php echo get_user_name($val["user_id"]);?></td>
                                                                    <td><?php echo $val['entity_type'];?></td>
                                                                    <td><?php echo $val['notes'];?></td>
                                                                    <td align="center">
                                                                     <?php if($val['image']!=""){ ?>
                                                                      <img style="width:200px;height:150px;" src="<?php echo SURL.'assets/scheduling/project_logs/'.$val['image'];?>"> 
                                                                      <?php } ?>
                                                                    </td>
                                                                </tr>
                                                                <?php } } else{ ?>
                                                                <tr><td colspan="5">No Project Logs Found!</td></tr>
                                                                <?php } ?>
                                                         </tbody>
                                                     </table>
                                                     </form>
                                                </div>
                                            </div>
                                        
                                        </div>
									</div>
								<div class="panel-group col-md-12" id="accordion2" role="tablist" aria-multiselectable="true">
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
                                                  <a class="btn btn-info" data-toggle="modal" data-target="#addDocumentModal"><i class="material-icons">attach_file</i> Add Document</a>
                                                 
                                                  <div id="document_container">
                                                     <?php 
$project_documents = get_project_documents($project_edit['project_id']);

if(count($project_documents)>0){ echo "<ul class='list_container'>"; foreach($project_documents as $document){ ?>
                                                       <li> <span class="btn btn-simple btn-icon"><i class="material-icons">insert_drive_file</i></span> <?php echo $document['document'];?><span id="<?php echo $document['id'];?>" class="remove_document pull-right btn btn-simple btn-danger btn-icon"><i class="material-icons">close</i></span><span class="pull-right btn btn-simple btn-icon">|</span><a class="pull-right btn btn-success btn-simple btn-icon" href="<?php echo SURL.'assets/project_plans_and_specifications/'.$document['document'];?>" target="_Blank"><i class="material-icons">file_download</i></a>
                                        <div class="togglebutton pull-right privacy_toggle">
                                                <label class="text-default">
                                                  <input id="privacy_settings<?php echo $document['id'];?>" name="privacy_settings" type="checkbox" <?php if($document['privacy']==0){ ?> checked <?php } ?> onclick="set_privacy(<?php echo $document['id'];?>, 0, 'Document');" >Private
                                                </label>
                                        </div>
                                        </li>
                                                        <?php } echo "</ul>";} ?>
                                                  </div>
                                                </div>
                                            </div>
                                    </div>
                                 </div>
                        </div>
                       
                        </div>
                    </div>
                    </div>
                    <div id="list_view_container" class="row noprint">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">list</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title" style="display:inline;">List View</h4> 
                                    
                                        <a style="margin-top:0px;" class="btn btn-info pull-right" data-toggle="modal" data-target="#addTaskModal"><i class="material-icons">assignment</i> Add Task</a>

<!-- New Task modal -->
                                            <div class="modal fade" id="addTaskModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
                                                <div class="modal-dialog modal-notice">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" ><i class="material-icons">clear</i></button>
<h5 class="modal-title" id="myModalLabel">Add Task</h5>                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="task_response"></div>             
                    				                       	<form id="TaskForm" method="post">
                                                                <input type="hidden" id="task_type" name="task_type" value="0">
                                                                <input type="hidden" id="project_id" name="project_id" value="<?php echo $project_edit['project_id'];?>">
                                                                <div class="form-group label-floating">
                                                                    <select id="stage_id" name="stage_id" required="true" class="selectpicker" data-style="select-with-transition" title="Choose Stage" data-live-search="true">
                                                                                
                                                                                <?php if(count($stages)>0){
                                                                                foreach($stages as $val){
                                                                                ?>
                                                                                <option value="<?php echo $val['stage_id'];?>"><?php echo $val['stage_name'];?></option>
                                                                                <?php } } ?>
                                                                            </select>
                                                                    <?php echo form_error('stage_id', '<div class="custom_error">', '</div>'); ?>
                        					</div>
                                                                <div class="form-group label-floating task_dropdown">
                                                                    <select id="task_id" name="task_id" required="true" class="selectpicker" data-style="select-with-transition" title="Choose Task" data-live-search="true">
                                                                                
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
                                                                
                                                                <div class="form-footer text-right" style="margin-top:45px;">
                                                                    <button type="button" class="btn btn-warning btn-fill add_new_task">Add</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end new task modal -->
                                        
                                     			
                                    <div class="toolbar">
									</div>
                            <div class="row ">
                                <div class="col-md-12 project_items">
<div class="panel-group col-md-12" id="accordionStages" role="tablist" aria-multiselectable="true">
<input type="hidden" id="sortable_stages" class="form-control"/>
                                <?php
                                  if(count($project_stages)>0){
                                  foreach($project_stages as $val){
                                    $project_items = get_project_item_by_stage($val['stage_id'], $project_edit['project_id']);
                                ?>
                                        

                                        <div id="<?php echo $val['stage_id'];?>" class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingTaskItem<?php echo $val['stage_id'];?>">
                                                <a role="button" data-toggle="collapse" data-parent="#accordionStages" href="#taskItem<?php echo $val['stage_id'];?>" aria-controls="taskItem<?php echo $val['stage_id'];?>">
                                                    <h4 class="panel-title">
                                                        <?php echo $val['stage_name'];?><div style="display:inline" class="stage_<?php echo $val['stage_id'];?>" item_count="<?php echo count(get_project_item_by_stage($val['stage_id'], $project_edit['project_id']));?>">&nbsp;&nbsp;&nbsp;&nbsp;
<?php 
$stage_status = get_stage_status($project_edit['project_id'], $val['stage_id'], count(get_project_item_by_stage($val['stage_id'], $project_edit['project_id'])));
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
                                                      $i=1;
                                                      foreach($project_items as $item){
                                                        $hasLinks = checkTasksDependands($project_edit['project_id'], $item['dependent_id'], $item['id']);
                                                      ?>
                                                         <tr rowno="<?php echo $item['id'];?>" hasLinks="<?php if($hasLinks){ echo "true";} else{ echo "false"; }?>">
<input class="form-control" type="hidden" name="task_id<?php echo $item['id'];?>" id="task_id<?php echo $item['id'];?>" value="<?php echo $item['task_id'];?>"/>
<input class="form-control" type="hidden" name="stage_id<?php echo $item['id'];?>" id="stage_id<?php echo $item['id'];?>" value="<?php echo $item['stage_id'];?>"/>
<td class="priority"><?php echo $i;?></td>
                                                           
                                                           <td><?php 
                                                           if($item['parent_item_id']>0){
                                                           $part_name = get_part_name($item['parent_item_id']);
                                                           echo $part_name." - ".$item['task_name'];
                                                           }
                                                           else{
                                                               echo $item['task_name']; 
                                                           }
                                                           ?>
                                                           </td>
                                                           <td>
                                            <?php include("application/views/scheduling/projects/task_items/checklist.php");?>
                                                           </td>
                                            <?php if($current_role!=4){ ?>
                                                           <td>
                                            <?php include("application/views/scheduling/projects/task_items/notes.php");?>
                                                           </td>
                                            <?php } ?>
                                            <?php if($current_role!=4){ ?>
                                                           <td>
                                            <?php include("application/views/scheduling/projects/task_items/files.php");?>
                                                           </td>
                                            <?php } ?>
                                                            <td>
                                            <?php include("application/views/scheduling/projects/task_items/images.php");?>
                                                           </td>
                                                           <td><div id="status<?php echo $item['id'];?>"><?php if($item['status']==0){?> <span class="label label-danger">Not Done</span> <?php } else if($item['status']==1     ){ ?> <span class="label label-warning">Partially Done</span><?php } else{ ?><span class="label label-success">Complete</span> <?php } ?></div></td>
                                            <td><a rowno="<?php echo $item['id'];?>" class="task_actions remove_task btn btn-simple btn-danger btn-icon"><i class="material-icons">delete</i></a>

                                            </td>

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
                                                    <div class="col-lg-6 col-md-6 col-sm-3">
                                                    <select class="selectpicker add_from_template" data-style="btn btn-warning btn-round" title="Choose Template" id="template_id" data-live-search="true">                 
                                                    <?php if(count($templates)>0){ foreach($templates as $tem){ ?>                                       
                                                    <option value="<?php echo $tem['id'];?>"><?php echo $tem['name'];?></option>
                                                    <?php } }?>
                                                    </select>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-3">
                                                    <select class="selectpicker add_from_project" data-style="btn btn-warning btn-round" title="Choose Buildz Project" id="import_project_id" data-live-search="true">                 
                                                    <?php if(count($projects)>0){ foreach($projects as $project){ ?>                                       
                                                    <option value="<?php echo $project['project_id'];?>"><?php echo $project['project_title'];?></option>
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

                    </div>
                    <!-- end row -->
                   
                    


<!-- Modal -->

 <!-- Document modal -->
                                            <div class="modal fade" id="addDocumentModal" tabindex="-1" role="dialog" aria-labelledby="myDocumentModalLabel" >
                                                <div class="modal-dialog modal-notice">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" ><i class="material-icons">clear</i></button>
<h5 class="modal-title" id="myDocumentModalLabel">Add Document</h5>                                                        </div>
                                                        <div class="modal-body">
<div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">attach_file</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Add New Document</h4> 
                                    <div class="toolbar">
<form id="DocumentForm" name="DocumentForm" class="upload_project_document" method="post" enctype="multipart/form-data">
<input type="hidden" id="document_parent_project_id" name="document_parent_project_id" value="<?php echo $project_edit['project_id'];?>">
<input type="hidden" id="document_project_id" name="document_project_id" value="<?php echo $project_edit['project_id'];?>">
                                                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail">
                                                    <img src="<?php echo IMG;?>image_placeholder.jpg" alt="...">
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                <div>
                                                    <span class="btn btn-warning btn-round btn-file">
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
                                            <button id="btn-upload-document" type="submit" class="btn btn-warning btn-fill">Add</button>
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





