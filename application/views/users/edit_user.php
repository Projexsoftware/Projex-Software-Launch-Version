<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <form id="UserForm" method="POST" action="<?php echo SURL ?>setup/update_user" enctype="multipart/form-data">
                                    <input type="hidden" id="user_id" name="user_id" value="<?php echo $user_edit['user_id']  ?>">
									<div class="card-header card-header-icon" data-background-color="rose">
                                        <i class="material-icons">person</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Edit User</h4>
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
										<div class="form-group label-floating">
    										<select class="selectpicker" data-style="select-with-transition" title="Choose Role *" data-size="7" name="role_id" id="role_id" required="true">
                                                <option disabled> Choose Role</option>
    											<?php foreach($roles as $val){ ?>
                                                <option <?php if($val['id']==$user_edit['role_id']){ ?> selected <?php } ?> value="<?php echo $val['id'];?>"><?php echo $val['role_title'];?></option>
    											<?php } ?>
                                            </select>
    										<?php echo form_error('role_id', '<div class="custom_error">', '</div>'); ?>
                                        </div>
										<div class="form-group label-floating">
                                            <div class="fileinput fileinput-exists text-center" data-provides="fileinput">
                                                
												<div class="fileinput-new thumbnail img-circle">
                                                    <img src="<?php echo IMG;?>placeholder.jpg" alt="...">
                                                </div>
												
                                                <div class="fileinput-preview fileinput-exists thumbnail img-circle"><img src="<?php echo PROFILE_IMG.$user_edit['user_img'];?>" alt="..."></div>
                                                <div>
                                                    <span class="btn btn-round btn-warning btn-file">
                                                        <span class="fileinput-new">Add Photo</span>
                                                        <span class="fileinput-exists">Change</span>
                                                        <input type="file" name="profile_image" id="profile_image"/>
														<input type="hidden" name="old_image" id="old_image" value="<?php echo $user_edit['user_img'];?>"/>
                                                    </span>
                                                    <br />
                                                    <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                                </div>
                                            </div>
										</div>
                                        <div class="form-group label-floating">
                                            <label class="control-label">
                                                First Name
                                                <small>*</small>
                                            </label>
                                            <input class="form-control" type="text" name="first_name" id="first_name" required="true" value="<?php echo $user_edit['user_fname'];?>"/>
                                            <?php echo form_error('first_name', '<div class="custom_error">', '</div>'); ?>
										</div>
										<div class="form-group label-floating">
                                            <label class="control-label">
                                                Last Name
                                                <small>*</small>
                                            </label>
                                            <input class="form-control" type="text" name="last_name" id="last_name" required="true" value="<?php echo $user_edit['user_lname'];?>"/>
                                            <?php echo form_error('last_name', '<div class="custom_error">', '</div>'); ?>
										</div>
										<div class="form-group label-floating">
                                            <label class="control-label">
                                                Email
                                                <small>*</small>
                                            </label>
                                            <input class="form-control" type="text" name="email" id="email" required="true" uniqueEditEmail="true" email="true" value="<?php echo $user_edit['user_email'];?>"/>
                                            <?php echo form_error('email', '<div class="custom_error">', '</div>'); ?>
										</div>
                                        <div class="form-group label-floating">
                								<select class="selectpicker" data-style="select-with-transition" title="Status *" data-size="7" name="user_status" id="user_status" required="true">
                                                    <option disabled> Choose Status</option>
                									<option value="1" <?php if($user_edit["user_status"]==1){ ?> selected <?php } ?>>Current</option>
                									<option value="0" <?php if($user_edit["user_status"]==0){ ?> selected <?php } ?>>Inactive</option>
                                                </select>
                                        </div>
                                        <div class="form-footer text-right">
                                            <?php if(in_array(91, $this->session->userdata("permissions"))) {?>
                                            <input type="submit" class="btn btn-rose btn-fill" id="update_new_user" name="update_new_user" value="Update">
                                            <?php } ?>
                                            <a href="<?php echo SURL;?>setup/users" class="btn btn-default btn-fill">Cancel</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                