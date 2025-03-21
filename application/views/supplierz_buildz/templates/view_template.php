<style>
.no_of_days_container{
  display:none;
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
.list_container .btn{
   padding-left: 0px!important;
   padding-right: 10px!important;
   padding-top: 0px!important;
   padding-bottom: 0px!important;
}
.ui-sortable tr {
	cursor:pointer;
}
</style>
<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title col-md-6">Template Details</h4>
                                    
                                </div>
                                <div class="card-content">
                                <div class="col-md-12">
                                <div class="panel-group col-md-6" id="accordion" role="tablist" aria-multiselectable="true">
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingTemplateName">
                                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#templateName" aria-expanded="true" aria-controls="templateName">
                                                    <h4 class="panel-title">
                                                        Template Name
                                                        <i class="material-icons">keyboard_arrow_down</i>
                                                    </h4>
                                                </a>
                                            </div>
                                            <div id="templateName" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingtemplateName">
                                                <div class="panel-body">
                                                  <?php echo $template_edit['name'];?>
                                                </div>
                                            </div>
                                        </div>
									</div>
									<div class="panel-group col-md-6" id="accordion2" role="tablist" aria-multiselectable="true">
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingTemplateDescription">
                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion2" href="#templateDescription" aria-expanded="true" aria-controls="templateDescription">
                                                    <h4 class="panel-title">
                                                        Template Description
                                                        <i class="material-icons">keyboard_arrow_down</i>
                                                    </h4>
                                                </a>
                                            </div>
                                            <div id="templateDescription" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTemplateDescription">
                                                <div class="panel-body">
                                                    <?php echo $template_edit['description'];?>
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
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">phonelink_setup</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title"><?php echo $template_edit['name'];?>' Items</h4> 
                                    <div class="toolbar">
                                     <?php if ($this->session->userdata('admin_role_id')!=3) { ?>
                                        <a class="btn btn-info" data-toggle="modal" data-target="#addTaskModal"><i class="material-icons">assignment</i> Add Task</a>
                                        <!-- notice modal -->
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
                                        <input type="hidden" id="template_id" name="template_id" value="<?php echo $template_edit['id'];?>">
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
                                            <select id="task_id" name="task_id" required="true" class="selectpicker" data-style="select-with-transition" title="Choose Task"  data-live-search="true">
                                                        
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
                                            
                                            <input class="form-control datepicker" type="hidden" name="start_date" id="start_date" value="<?php echo set_value('start_date')?>" placeholder="Start Date"/>
                                            <?php echo form_error('start_date', '<div class="custom_error">', '</div>'); ?>
					</div>
                                        <div class="form-group label-floating">
                                            
                                            <input class="form-control datepicker" type="hidden" name="end_date" id="end_date" value="<?php echo set_value('end_date')?>" placeholder="End Date"/>
                                            <?php echo form_error('end_date', '<div class="custom_error">', '</div>'); ?>
					</div>
                                        <div class="form-footer text-right">
                                            <button type="button" class="btn btn-warning btn-fill add_new_task">Add</button>
                                        </div>
                                    
                                        </form>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end notice modal -->
                                     <?php } ?>
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
                                <div class="col-md-12 template_items">
<div class="panel-group col-md-12" id="accordionStages" role="tablist" aria-multiselectable="true">
<input type="hidden" id="sortable_stages" class="form-control"/>
                                <?php
                                  if(count($template_stages)>0){
                                  foreach($template_stages as $val){
                                ?>
                                        

                                        <div id="<?php echo $val['stage_id'];?>" class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingTaskItem<?php echo $val['stage_id'];?>">
                                                <a role="button" data-toggle="collapse" data-parent="#accordionStages" href="#taskItem<?php echo $val['stage_id'];?>" aria-expanded="true" aria-controls="taskItem<?php echo $val['stage_id'];?>">
                                                    <h4 class="panel-title">
                                                        <?php echo $val['stage_name'];?><div style="display:inline" class="stage_<?php echo $val['stage_id'];?>" item_count="<?php echo count(get_buildz_template_item_by_stage($val['stage_id'], $template_edit['id']));?>">&nbsp;&nbsp;&nbsp;&nbsp;
<?php 
$stage_status = get_buildz_template_stage_status($template_edit['id'], $val['stage_id'], count(get_buildz_template_item_by_stage($val['stage_id'], $template_edit['id'])));
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
                                                      $template_items = get_buildz_template_item_by_stage($val['stage_id'], $template_edit['id']);
                                                      $i=1;
                                                      foreach($template_items as $item){
                                                      ?>
                                                      <tr rowno="<?php echo $item['id'];?>">
<input class="form-control" type="hidden" name="task_id<?php echo $item['id'];?>" id="task_id<?php echo $item['id'];?>" value="<?php echo $item['task_id'];?>"/>
<input class="form-control" type="hidden" name="stage_id<?php echo $item['id'];?>" id="stage_id<?php echo $item['id'];?>" value="<?php echo $item['stage_id'];?>"/>
<td class="priority"><?php echo $i;?></td>
                                                           
                                                           <td><?php echo $item['task_name'];?></td>
                                                           <td>
                                            <?php include("application/views/supplierz_buildz/templates/task_items/checklist.php");?>
                                                           </td>
                                                           <td>
                                            <?php include("application/views/supplierz_buildz/templates/task_items/notes.php");?>
                                                           </td>
                                                           <td>
                                            <?php include("application/views/supplierz_buildz/templates/task_items/files.php");?>
                                                           </td>
                                                            <td>
                                            <?php include("application/views/supplierz_buildz/templates/task_items/images.php");?>
                                                           </td>
                                                           <td><div id="status<?php echo $item['id'];?>"><?php if($item['status']==0){?> <span class="label label-danger">Not Done</span> <?php } else if($item['status']==1     ){ ?> <span class="label label-warning">Partially Done</span><?php } else{ ?><span class="label label-success">Complete</span> <?php } ?></div></td>
                                                           <td><a rowno="<?php echo $item['id'];?>" class="remove_task btn btn-simple btn-danger btn-icon"><i class="material-icons">delete</i></a></td>
                                                         </tr>
                                                      <?php $i++;  } ?>
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
                        <!-- end col-md-12 -->
                    </div>
                    <!-- end row -->

                    <div id="calendar_view_container" class="row" style="display:none;">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="rose">
                                    <i class="material-icons">date_range</i>
                                </div>
                                <div class="card-content" class="ps-child">
                                    <h4 class="card-title">Calendar View</h4> 
                                    <div id="fullCalendar"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
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
                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                        <select class="selectpicker import_template_from_supplierz_buildz_template" data-live-search="true" data-style="btn btn-warning btn-round" title="Import From Supplierz Buildz Template Catalogue" id="import_supplierz_buildz_template_id" name="import_supplierz_buildz_template_id">                 
                                                        <?php if(count($extsupplierzbuildztemplates)>0){ foreach($extsupplierzbuildztemplates as $tem){ 
                                                        ?>                                       
                                                        <option value="<?php echo $tem['id'];?>"><?php echo $tem['name'];?> - <?php echo $tem['description'];?></option>
                                                        <?php } }?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                 </div>
                            </div>