<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <form id="StageForm" method="POST" action="<?php echo SURL ?>setup/add_new_stage_process">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">timeline</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Add Stage</h4>
                                        <div class="col-md-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label">
                                                    Stage Name
                                                    <small>*</small>
                                                </label>
                                                <input class="form-control" type="text" name="name" id="name" required="true" uniqueStage="true" value="<?php echo set_value('name')?>"/>
                                                <?php echo form_error('name', '<div class="custom_error">', '</div>'); ?>
    					                    </div>
                                            <div class="form-group label-floating">
                                                <label class="control-label">
                                                    Stage Description
                                                    <small>*</small>
                                                </label>
                                                <textarea class="form-control" name="description" id="description" required="true"><?php echo set_value('description')?></textarea>
                                                <?php echo form_error('description', '<div class="custom_error">', '</div>'); ?>
    					                    </div>
                                            <div class="form-group label-floating">
                								<select class="selectpicker" data-style="select-with-transition" title="Status *" data-size="7" name="stage_status" id="stage_status" required="true">
                                                    <option disabled> Choose Status</option>
                									<option value="1" selected>Current</option>
                									<option value="0">Inactive</option>
                                                </select>
                                            </div>
    										
                                            <div class="form-footer text-right">
                                                <?php if(in_array(75, $this->session->userdata("permissions"))) {?>
                                                <button type="submit" class="btn btn-warning btn-fill">Add</button>
                                                <?php } ?>
                                                <a href="<?php echo SURL;?>setup/stages" class="btn btn-default btn-fill">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                