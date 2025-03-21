<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <form id="TakeoffdataForm" method="POST" action="<?php echo SURL ?>setup/add_new_takeoffdata_process">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">data_usage</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Add Take off Data</h4>
                                        <div class="col-md-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label">
                                                    Take off Data Name
                                                    <small>*</small>
                                                </label>
                                                <input class="form-control" type="text" name="name" id="name" required="true" uniqueTakeoffdata="true" value="<?php echo set_value('name')?>"/>
                                                <?php echo form_error('name', '<div class="custom_error">', '</div>'); ?>
    					                    </div>
                                            <div class="form-group label-floating">
                                                <label class="control-label">
                                                    Take off Data Description
                                                </label>
                                                <textarea class="form-control" name="description" id="description"><?php echo set_value('description')?></textarea>
                                                <?php echo form_error('description', '<div class="custom_error">', '</div>'); ?>
    					                    </div>
                                            <div class="form-group label-floating">
                								<select class="selectpicker" data-style="select-with-transition" title="Status *" data-size="7" name="takeof_status" id="takeof_status" required="true">
                                                    <option disabled> Choose Status</option>
                									<option value="1" selected>Current</option>
                									<option value="0">Inactive</option>
                                                </select>
                                            </div>
    										
                                            <div class="form-footer text-right">
                                                <?php if(in_array(80, $this->session->userdata("permissions"))) {?>
                                                <button type="submit" class="btn btn-warning btn-fill">Add</button>
                                                <?php } ?>
                                                <a href="<?php echo SURL;?>setup/takeoffdata" class="btn btn-default btn-fill">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                