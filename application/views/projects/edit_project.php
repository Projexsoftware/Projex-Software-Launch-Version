<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <form id="ProjectForm" method="POST" action="<?php echo SURL ?>manage/edit_project_process">
								<input type="hidden" id="project_id" name="project_id" value="<?php echo $project_edit['project_id'];?>">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">android</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Edit Project</h4>
                                        
                                    <div class="col-md-12">
                                        <div class="toolbar text-right">
                                            <?php if(in_array(2, $this->session->userdata("permissions"))) {
                                            ?>
                    						<p><a class="btn btn-warning btn-sm" href="<?php echo SURL.'project_costing/edit_project_costing/'.$project_edit['project_id'] ?>"><i class="fa fa-pencil"></i> Project Costing</a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-warning btn-sm" href="<?php echo SURL.'project_costing/plans_and_specifications/'.$project_edit['project_id'] ?>"><i class="fa fa-pencil"></i> Project Plans and Specifications</a>
                    						&nbsp;&nbsp;&nbsp;&nbsp;<!--<a class="btn btn-warning btn-sm" href="<?php echo SURL.'project_costing/estimate_request/'.$project_edit['project_id'] ?>"><i class="fa fa-pencil"></i> Estimate Request</a>--></p>
                    						<?php } ?>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Project Name
                                                    <small>*</small>
                                                    </label>
                                                    <input class="form-control" type="text" name="project_title" id="project_title" required="true" uniqueEditProject="true" value="<?php echo $project_edit['project_title']?>"/>
                                                    <?php echo form_error('project_title', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                        </div>
                                        <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Client
                                                    <small>*</small>
                                                    </label>
                                                    <select class="selectpicker" data-style="select-with-transition" title="Client *" data-size="7" name="client_id" id="client_id" required="true">
                                                        <option disabled> Choose Client</option>
            											<?php foreach($clients as $client){ ?>
            											<option <?php if($client['client_id']==$project_edit['client_id']){ ?> selected <?php } ?> value="<?php echo $client['client_id'];?>"><?php echo $client["client_fname1"].' '.$client["client_surname1"].' '.$client["client_fname2"].' '.$client["client_surname2"]; ?></option>
            											<?php } ?>
                                                    </select>
                                                    <?php echo form_error('client_id', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                        </div>
                                        <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Project Description
                                                    </label>
                                                    <textarea class="form-control" name="project_des" id="project_des"><?php echo $project_edit['project_des']?></textarea>
                                                    <?php echo form_error('project_des', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-12"><br/><legend>Address</legend></div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Street
                                                    <small>*</small>
                                                    </label>
                                                    <input class="form-control" type="text" name="street_pobox" id="project_address_city" required="true" value="<?php echo $project_edit['street_pobox']?>"/>
                                                    <?php echo form_error('street_pobox', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Suburb
                                                    <small>*</small>
                                                    </label>
                                                    <input class="form-control" type="text" name="suburb" id="suburb" required="true" value="<?php echo $project_edit['suburb']?>"/>
                                                    <?php echo form_error('suburb', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    City
                                                    <small>*</small>
                                                    </label>
                                                    <input class="form-control" type="text" name="project_address_city" id="project_address_city" required="true" value="<?php echo $project_edit['project_address_city']?>"/>
                                                    <?php echo form_error('project_address_city', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Region
                                                    <small>*</small>
                                                    </label>
                                                    <input class="form-control" type="text" name="project_address_state" id="project_address_state" required="true" value="<?php echo $project_edit['project_address_state']?>"/>
                                                    <?php echo form_error('project_address_state', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Country
                                                    <small>*</small>
                                                    </label>
                                                    <input class="form-control" type="text" name="project_address_country" id="project_address_country" required="true" value="<?php echo $project_edit['project_address_country']?>"/>
                                                    <?php echo form_error('project_address_country', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    ZIP Code
                                                    <small>*</small>
                                                    </label>
                                                    <input class="form-control" type="text" name="project_zip" id="project_zip" required="true" value="<?php echo $project_edit['project_zip']?>"/>
                                                    <?php echo form_error('project_zip', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                        Legal Description
                                                    </label>
                                                    <textarea class="form-control" name="project_legal_des" id="project_legal_des"><?php echo $project_edit['project_legal_des']?></textarea>
                                                    <?php echo form_error('project_legal_des', '<div class="custom_error">', '</div>'); ?>
            					               </div>
            					           </div>
            					       </div>
            					       <div class="col-md-12">
            					           <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Bank Account
                                                    </label>
                                                    <input class="form-control" type="text" name="bank_acount" id="bank_acount" value="<?php echo $project_edit['bank_acount']?>"/>
                                                    <?php echo form_error('bank_acount', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-12">
                                                <div class="form-group label-floating">
            										<select class="selectpicker" data-style="select-with-transition" title="Status *" data-size="7" name="project_status" id="project_status" required="true">
                                                        <option disabled> Choose Status</option>
                                                        <option value="2" <?php if($project_edit["project_status"]==2){ ?> selected <?php } ?>>Pending</option>
            											<option value="1" <?php if($project_edit["project_status"]==1){ ?> selected <?php } ?>>Current</option>
            											<option value="0" <?php if($project_edit["project_status"]==0){ ?> selected <?php } ?>>Inactive</option>
            											<option value="3" <?php if($project_edit["project_status"]==3){ ?> selected <?php } ?>>Completed</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-12">
            				                    <div class="form-group label-floating">
                                                    <div class="form-footer text-right">
                                                        <?php if(in_array(60, $this->session->userdata("permissions"))) {?>
                                                        <button type="submit" id="update_project" name="update_project" class="btn btn-warning btn-fill">Update</button>
                                                        <?php } ?>
                                                        <a href="<?php echo SURL;?>manage/projects" class="btn btn-default btn-fill">Cancel</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
                