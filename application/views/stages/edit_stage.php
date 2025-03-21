<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <form id="StageForm" method="POST" action="<?php echo SURL ?>setup/edit_stage_process">
								<input type="hidden" id="stage_id" name="stage_id" value="<?php echo $stage_edit['stage_id']  ?>">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">timeline</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Edit Stage</h4>
                                        <br/>
                                        <div class="col-md-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label">
                                                    Stage Name
                                                    <small>*</small>
                                                </label>
                                                <input class="form-control" id="name" name="name" type="text" required="true" uniqueEditStage="true" value="<?php echo $stage_edit['stage_name'];?>"/>
                                                <?php echo form_error('name', '<div class="custom_error">', '</div>'); ?>
    					</div>
                                             <div class="form-group label-floating">
                                                <label class="control-label">
                                                    Stage Description
                                                    <small>*</small>
                                                </label>
                                                <textarea class="form-control" name="description" id="description" required="true"><?php echo $stage_edit['stage_description'];?></textarea>
                                                <?php echo form_error('description', '<div class="custom_error">', '</div>'); ?>
    					</div>
    					               <div class="form-group label-floating">
                								<select class="selectpicker" data-style="select-with-transition" title="Status *" data-size="7" name="stage_status" id="stage_status" required="true">
                                                    <option disabled> Choose Status</option>
                									<option value="1" <?php if($stage_edit["stage_status"]==1){ ?> selected <?php } ?>>Current</option>
                									<option value="0" <?php if($stage_edit["stage_status"]==0){ ?> selected <?php } ?>>Inactive</option>
                                                </select>
                                        </div>
                                   
    				                    <div class="form-group label-floating">
                                            
                                            <div class="form-footer text-right">
                                                <?php if(in_array(76, $this->session->userdata("permissions"))) {?>
                                                <button type="submit" id="update_stage" name="update_stage" class="btn btn-warning btn-fill">Update</button>
                                                <?php } ?>
                                                <a href="<?php echo SURL;?>setup/stages" class="btn btn-default btn-fill">Close</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                