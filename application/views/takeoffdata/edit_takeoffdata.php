<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <form id="TakeoffdataForm" method="POST" action="<?php echo SURL ?>setup/edit_takeoffdata_process">
								<input type="hidden" id="takeof_id" name="takeof_id" value="<?php echo $takeoffdata_edit['takeof_id']  ?>">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">data_usage</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Edit Take off Data</h4>
                                        <br/>
                                        <div class="col-md-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label">
                                                    Take off Data Name
                                                    <small>*</small>
                                                </label>
                                                <input class="form-control" id="name" name="name" type="text" required="true" uniqueEditTakeoffdata="true" value="<?php echo $takeoffdata_edit['takeof_name'];?>"/>
                                                <?php echo form_error('name', '<div class="custom_error">', '</div>'); ?>
    					</div>
                                             <div class="form-group label-floating">
                                                <label class="control-label">
                                                    Take off Data Description
                                                </label>
                                                <textarea class="form-control" name="description" id="description"><?php echo $takeoffdata_edit['takeof_des'];?></textarea>
                                                <?php echo form_error('description', '<div class="custom_error">', '</div>'); ?>
    					</div>
    					               <div class="form-group label-floating">
                								<select class="selectpicker" data-style="select-with-transition" title="Status *" data-size="7" name="takeof_status" id="takeof_status" required="true">
                                                    <option disabled> Choose Status</option>
                									<option value="1" <?php if($takeoffdata_edit["takeof_status"]==1){ ?> selected <?php } ?>>Current</option>
                									<option value="0" <?php if($takeoffdata_edit["takeof_status"]==0){ ?> selected <?php } ?>>Inactive</option>
                                                </select>
                                        </div>
                                   
    				                    <div class="form-group label-floating">
                                            
                                            <div class="form-footer text-right">
                                                <?php if(in_array(81, $this->session->userdata("permissions"))) {?>
                                                <button type="submit" id="update_takeoffdata" name="update_takeoffdata" class="btn btn-warning btn-fill">Update</button>
                                                <?php } ?>
                                                <a href="<?php echo SURL;?>setup/takeoffdata" class="btn btn-default btn-fill">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                