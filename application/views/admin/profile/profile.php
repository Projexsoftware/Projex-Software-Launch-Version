<div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">perm_identity</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Edit Profile -
                                        <small class="category">Complete your profile</small>
                                    </h4>
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
                                    <form id="ProfileForm" method="post" action="<?php echo AURL;?>profile/update_profile" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                     <div class="fileinput fileinput-exists text-center" data-provides="fileinput">
                                                
												<div class="fileinput-new thumbnail img-circle">
                                                    <img src="<?php echo IMG;?>placeholder.jpg" alt="...">
                                                </div>
												
                                                <div class="fileinput-preview fileinput-exists thumbnail img-circle"><img src="<?php echo ADMIN_PROFILE_IMG.$profile['profile_image'];?>" alt="..."></div>
                                                <div>
                                                    <span class="btn btn-round btn-warning btn-file">
                                                        <span class="fileinput-new">Add Photo</span>
                                                        <span class="fileinput-exists">Change</span>
                                                        <input type="file" name="profile_image" id="profile_image"/>
														<input type="hidden" name="old_image" id="old_image" value="<?php echo $profile['profile_image'];?>"/>
                                                    </span>
                                                    <br />
                                                    <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                                </div>
                                            </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Fist Name</label>
                                                    <input id="first_name" name="first_name" type="text" class="form-control" value="<?php echo $profile['first_name'];?>" required="true">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Last Name</label>
                                                    <input id="last_name" name="last_name" type="text" class="form-control" value="<?php echo $profile['last_name'];?>" required="true">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Email</label>
                                                    <input type="text" class="form-control" value="<?php echo $profile['email'];?>" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Address</label>
                                                    <input id="address" name="address" type="text" class="form-control" value="<?php echo $profile['address'];?>" required="true">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Mobile Number</label>
                                                    <input id="mobile_no" name="mobile_no" type="text" class="form-control" value="<?php echo $profile['mobile_no'];?>" required="true">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Landline Number</label>
                                                    <input id="landline_no" name="landline_no" type="text" class="form-control" value="<?php echo $profile['landline_no'];?>" required="true">
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>About Me</label>
                                                    <div class="form-group label-floating">
                                                       
                                                        <textarea id="about_me" name="about_me" class="form-control" rows="5"><?php echo $profile['about_me'];?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-warning pull-right">Update Profile</button>
                                        <div class="clearfix"></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-profile">
                                <div class="card-avatar">
                                    <a href="#pablo">
                                        <img class="img" src="<?php echo ADMIN_PROFILE_IMG.$profile['profile_image'];?>" />
                                    </a>
                                </div>
                                <div class="card-content">
                                    <h6 class="category text-gray"><?php echo get_role_title($profile['role_id']);?></h6>
                                    <h4 class="card-title"><?php echo $profile['first_name']." ".$profile['last_name'];?></h4>
                                    <p class="description">
                                        <?php echo $profile['about_me'];?>
                                    </p>
                                    
                                </div>
                            </div>
                        </div>
                    </div>