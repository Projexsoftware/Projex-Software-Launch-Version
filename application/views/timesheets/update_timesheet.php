<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">schedule</i>
                                    </div>
                                    <div class="card-content">
                                    <h4 class="card-title">Update Timesheet</h4>
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
                                        <div class="col-md-12">
                                        <form id="TimeSheetForm" method="POST" action="<?php echo SURL . 'timesheets/updatetimesheetprocess' ?>" autocomplete="off">
                                            <input type="hidden" class="form-control" name="timesheet_id" value="<?php echo $timesheet_info['id'];?>">
                
                                        <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Staff <small>*</small>
                                                    </label>
                                                    <input type="text" class="form-control" readonly value="<?php echo get_user_name($timesheet_info['user_id']);?>">
    				                        	</div>
                                        </div>
                                        <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                       Status <small>*</small>
                                                    </label>
                                                    <select name="status" id="status" required class="selectpicker" data-style="select-with-transition" required>
                                                        <option value="Draft" <?php if($timesheet_info['status']=="Draft"){ ?> selected <?php } ?>>Draft</option>
                                                        <option value="Pending" <?php if($timesheet_info['status']=="Pending"){ ?> selected <?php } ?>>Pending</option>
                                                    </select>
    				                        	</div>
                                        </div>
                                        <div class="col-md-12">

                                        <table id="imp_timesheet_item" class="table templates_table table-no-bordered">
                                <thead>
                                    <tr class="headers">
                                        <th>Date</th>
                                        <th>Project</th>
                                        <th>Stage</th>
                                        <th>Details</th>
                                        <th>Submitted Hours</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                 <?php 
                                 $count = 1;
                                 if(count($timesheet_items)>0){
                                 foreach($timesheet_items as $val){ 
                                  $date = explode("-", $val['date']);
                                  $date = $date[2]."/".$date[1]."/".$date[0];
                                 ?>
                                 <input type="hidden" name="item_id[]" value="<?php echo $val['id'];?>">
                                  <tr id="nitrnumber<?php echo $count;?>" row_no="<?php echo $count;?>">
                                      <td><input type="text" class="datepicker form-control" name="date[]" id="date<?php echo $count;?>" required value="<?php echo $date;?>">
                                       <?php echo form_error('date[]', '<div class="custom_error">', '</div>'); ?>
                                      </td>
                                      <td>
                                        <select name="project_id[]" id="project_id<?php echo $count;?>" required class="form-control">
                                            <option value="">Select Project</option>
                                            <?php foreach($projects as $project){ ?>
                                               <option value="<?php echo $project->costing_id;?>" <?php if($val['project_id']==$project->costing_id){ ?> selected <?php } ?>><?php echo $project->project_title;?></option>
                                            <?php } ?>
                                        </select>
                                        <?php echo form_error('project_id[]', '<div class="custom_error">', '</div>'); ?>
                                      </td>
                                      <td>
                                          <select name="stage_id[]" id="stage_id<?php echo $count;?>" required class="form-control">
                                            <option value="0">Select Stage</option>
                                            <?php foreach($stages as $stage){ ?>
                                               <option value="<?php echo $stage['stage_id'];?>" <?php if($val['stage_id']==$stage["stage_id"]){ ?> selected <?php } ?>><?php echo $stage["stage_name"];?></option>
                                            <?php } ?>
                                        </select>
                                        <?php echo form_error('stage_id[]', '<div class="custom_error">', '</div>'); ?>
                                      </td>
                                      <td><input type="text" class="form-control" name="details[]" id="details<?php echo $count;?>" value="<?php echo $val['details'];?>"></td>
                                      <td><input type="text" class="form-control" name="submitted_hours[]" id="submitted_hours<?php echo $count;?>" required value="<?php echo $val['submitted_hours'];?>">
                                      <?php echo form_error('submitted_hours[]', '<div class="custom_error">', '</div>'); ?>
                                      </td>
                                       <td>
                                           <a href="javascript:void(0)" rno="<?php echo $count;?>" class="btn btn-danger btn-simple btn-icon deleterow" title="Delete Item"><i class="fa fa-trash delete fa-lg"></i></a>
                                   
                                        </td>
                                  </tr>
                                  <?php } } ?>
                                </tbody>

                            </table>

                        
                                        </div>
                                        <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <div class="form-footer text-right">
                                                        <?php if(in_array(108, $this->session->userdata("permissions"))) { ?>
                                                        <input type="submit" class="btn btn-warning btn-fill" value="Update Timesheet"/>
                                                        <a class="btn btn-primary" style="cursor:pointer;" onclick="addMore();">Add More</a>
                                                        <?php } ?>
                                                        <a href="<?php echo SURL;?>timesheets" class="btn btn-default btn-fill">Cancel</a>
                     
                                                    </div>
                                            </div>
                                        </div>
                                     </form>
                                </div>
                            </div>
                        </div>
                    </div>