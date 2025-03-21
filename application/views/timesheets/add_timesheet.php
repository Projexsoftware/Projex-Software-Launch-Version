<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">schedule</i>
                                    </div>
                                    <div class="card-content">
                                    <h4 class="card-title">Add Timesheet</h4>
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
                                        <form id="TimeSheetForm" method="POST" action="<?php echo SURL . 'timesheets/inserttimesheetprocess' ?>" autocomplete="off">
                                    
                                        <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    
                                                    </label>
                                                    <select name="user_id" id="user_id" class="selectpicker" data-style="select-with-transition" title="Choose Staff *" data-live-search="true" required>
                                                        <option disabled>Select Staff</option>
                                                        <?php foreach($staff as $val){ ?>
                                                           <option value="<?php echo $val['user_id'];?>"><?php echo $val['user_fname']." ".$val['user_lname'];?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <?php echo form_error('user_id', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                        </div>
                                        <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                       Status <small>*</small>
                                                    </label>
                                                    <select name="status" id="status" required class="selectpicker" data-style="select-with-transition" required>
                                                        <option value="Draft">Draft</option>
                                                        <option value="Pending">Pending</option>
                                                    </select>
    				                        	</div>
                                        </div>
                                        <div class="col-md-12">

                                        <table id="imp_timesheet_item" class="table table-striped">
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
                                  <tr id="nitrnumber1" row_no="1">
                                      <td><input type="text" class="datepicker form-control" name="date[]" id="date1" required>
                                          <?php echo form_error('date[]', '<div class="custom_error">', '</div>'); ?>
                                      </td>
                                      <td>
                                        <select name="project_id[]" id="project_id1" required class="selectpicker" title="Choose Project *" data-live-search="true" data-style="select-with-transition">
                                            <option disabled>Select Project</option>
                                            <?php foreach($projects as $project){ ?>
                                               <option value="<?php echo $project->costing_id;?>"><?php echo $project->project_title;?></option>
                                            <?php } ?>
                                        </select>
                                        <?php echo form_error('project_id[]', '<div class="custom_error">', '</div>'); ?>
                                      </td>
                                      <td>
                                          <select name="stage_id[]" id="stage_id1" class="selectpicker" title="Choose Stage *" data-live-search="true" data-style="select-with-transition" required>
                                            <option disabled>Select Stage</option>
                                            <?php foreach($stages as $stage){ ?>
                                               <option value="<?php echo $stage['stage_id'];?>"><?php echo $stage['stage_name'];?></option>
                                            <?php } ?>
                                        </select>
                                        <?php echo form_error('stage_id[]', '<div class="custom_error">', '</div>'); ?>
                                      </td>
                                      <td><input type="text" class="form-control" name="details[]" id="details1"></td>
                                      <td><input type="number" class="form-control" name="submitted_hours[]" id="submitted_hours1" required>
                                      <?php echo form_error('submitted_hours[]', '<div class="custom_error">', '</div>'); ?>
                                      </td>
                                       <td>
                                           <a href="javascript:void(0)" rno="1" class="btn btn-danger btn-simple btn-icon deleterow" title="Delete Item"><i class="fa fa-trash delete fa-lg"></i></a>
                                        </td>
                                  </tr>
                                </tbody>

                            </table>

                        
                                        </div>
                                        <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <div class="form-footer text-right">
                                                        <?php if(in_array(107, $this->session->userdata("permissions"))) { ?>
                                                        <input type="submit" class="btn btn-warning btn-fill" value="Save Timesheet"/>
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