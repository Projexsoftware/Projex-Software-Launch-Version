<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <form id="UserForm" method="POST" action="<?php echo SURL ?>setup/add_user" enctype="multipart/form-data">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">person</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Add User</h4>
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
                                            <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail img-circle">
                                                    <img src="<?php echo IMG;?>placeholder.jpg" alt="...">
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail img-circle"></div>
                                                <div>
                                                    <span class="btn btn-round btn-warning btn-file">
                                                        <span class="fileinput-new">Add Photo</span>
                                                        <span class="fileinput-exists">Change</span>
                                                        <input type="file" name="profile_image" id="profile_image"/>
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
                                            <input class="form-control" type="text" name="first_name" id="first_name" required="true" value="<?php echo set_value('first_name')?>"/>
                                            <?php echo form_error('first_name', '<div class="custom_error">', '</div>'); ?>
										</div>
										<div class="form-group label-floating">
                                            <label class="control-label">
                                                Last Name
                                                <small>*</small>
                                            </label>
                                            <input class="form-control" type="text" name="last_name" id="last_name" required="true" value="<?php echo set_value('last_name')?>"/>
                                            <?php echo form_error('last_name', '<div class="custom_error">', '</div>'); ?>
										</div>
										<div class="form-group label-floating">
                                            <label class="control-label">
                                                Email
                                                <small>*</small>
                                            </label>
                                            <input class="form-control" type="text" name="email" id="email" required="true" uniqueEmail="true" email="true" value="<?php echo set_value('email')?>"/>
                                            <?php echo form_error('email', '<div class="custom_error">', '</div>'); ?>
										</div>
										<div class="form-group label-floating">
                   
										<select class="selectpicker" data-style="select-with-transition" title="Choose Role *" data-size="7" name="role_id" id="role_id" required="true">
                                            <option disabled> Choose Role</option>
											<?php foreach($roles as $val){ ?>
                                            <option value="<?php echo $val['id'];?>"><?php echo $val['role_title'];?></option>
											<?php } ?>
                                        </select>
										<?php echo form_error('role_id', '<div class="custom_error">', '</div>'); ?>
                                        </div>
                                        <div class="form-footer text-right">
                                            <input type="submit" class="btn btn-warning btn-fill" id="add_new_user" name="add_new_user" value="Add">
                                            <a href="<?php echo SURL;?>setup/users" class="btn btn-default btn-fill">Cancel</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                