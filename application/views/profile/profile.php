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
                                    <form id="ProfileForm" method="post" action="<?php echo SURL;?>profile/update_profile" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                     <div class="fileinput fileinput-exists text-center" data-provides="fileinput">
                                                
												<div class="fileinput-new thumbnail img-circle">
                                                    <img src="<?php echo IMG;?>placeholder.jpg" alt="...">
                                                </div>
												
                                                <div class="fileinput-preview fileinput-exists thumbnail img-circle"><img src="<?php echo PROFILE_IMG.$profile['user_img'];?>" alt="..."></div>
                                                <div>
                                                    <span class="btn btn-round btn-warning btn-file">
                                                        <span class="fileinput-new">Add Photo</span>
                                                        <span class="fileinput-exists">Change/Add Profile Photo</span>
                                                        <input type="file" name="profile_image" id="profile_image" extension="png|PNG|jpg|jpeg|JPG|JPEG"/>
														<input type="hidden" name="old_image" id="old_image" value="<?php echo $profile['user_img'];?>"/>
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
                                                    <label class="control-label">Fist Name
                                                    <small>*</small>
                                                    </label>
                                                    <input id="first_name" name="first_name" type="text" class="form-control" value="<?php echo $profile['user_fname'];?>" required="true">
                                                     <?php echo form_error('first_name', '<div class="custom_error">', '</div>'); ?>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Last Name
                                                    <small>*</small>
                                                    </label>
                                                    <input id="last_name" name="last_name" type="text" class="form-control" value="<?php echo $profile['user_lname'];?>" required="true">
                                                     <?php echo form_error('last_name', '<div class="custom_error">', '</div>'); ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Email
                                                    <small>*</small>
                                                    </label>
                                                    <input type="text" class="form-control" value="<?php echo $profile['user_email'];?>" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        $company_id = $this->session->userdata("company_id");
						               if($this->session->userdata('user_id')==$company_id){ 
                                        ?>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p></p>
                                                <legend>Company Details</legend>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                     <div class="fileinput fileinput-exists text-center" data-provides="fileinput">
                                                
												<div class="fileinput-new thumbnail">
                                                    <img src="<?php echo IMG;?>image_placeholder.jpg" alt="...">
                                                </div>
												
                                                <div class="fileinput-preview fileinput-exists thumbnail"><img src="<?php if($profile['com_logo']!=''){ echo COMPANY_LOGO.$profile['com_logo']; } else{ echo IMG.'image_placeholder.jpg'; } ?>" alt="..."></div>
                                                <div>
                                                    <span class="btn btn-round btn-warning btn-file">
                                                        <span class="fileinput-new">Add Logo</span>
                                                        <span class="fileinput-exists">Change/Add Logo</span>
                                                        <input type="file" name="com_logo" id="com_logo" extension="png|PNG|jpg|jpeg|JPG|JPEG"/>
														<input type="hidden" name="old_com_logo" id="old_com_logo" value="<?php echo $profile['com_logo'];?>"/>
                                                    </span>
                                                    <br />
                                                    <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                                </div>
                                            </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Company Name
                                                    <small>*</small>
                                                    </label>
                                                    <input id="com_name" name="com_name" type="text" class="form-control" value="<?php echo $profile['com_name'];?>" required="true">
                                                     <?php echo form_error('com_name', '<div class="custom_error">', '</div>'); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Company Street Address
                                                    <small>*</small>
                                                    </label>
                                                    <input id="com_street_address" name="com_street_address" type="text" class="form-control" value="<?php echo $profile['com_street_address'];?>" required="true">
                                                    <?php echo form_error('com_street_address', '<div class="custom_error">', '</div>'); ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Company Postal Address
                                                    <small>*</small>
                                                    </label>
                                                    <input id="com_postal_address" name="com_postal_address" type="text" class="form-control" value="<?php echo $profile['com_postal_address'];?>" required="true">
                                                    <?php echo form_error('com_postal_address', '<div class="custom_error">', '</div>'); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Company Email
                                                    <small>*</small>
                                                    </label>
                                                    <input id="com_email" name="com_email" type="text" class="form-control" value="<?php echo $profile['com_email'];?>" required="true">
                                                    <?php echo form_error('com_email', '<div class="custom_error">', '</div>'); ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Company Website
                                                    <small></small>
                                                    </label>
                                                    <input id="com_website" name="com_website" type="text" validUrl="true" class="form-control" value="<?php echo $profile['com_website'];?>">
                                                    <?php echo form_error('com_website', '<div class="custom_error">', '</div>'); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Company GST Number
                                                    <small>*</small>
                                                    </label>
                                                    <input id="com_gst_number" name="com_gst_number" type="text" class="form-control" value="<?php echo $profile['com_gst_number'];?>" required="true">
                                                    <?php echo form_error('com_gst_number', '<div class="custom_error">', '</div>'); ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Company Phone Number
                                                    <small>*</small>
                                                    </label>
                                                    <input id="com_phone_no" name="com_phone_no" type="text" class="form-control" value="<?php echo $profile['com_phone_no'];?>" required="true">
                                                     <?php echo form_error('com_phone_no', '<div class="custom_error">', '</div>'); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Current GST Rate
                                                    <small>*</small>
                                                    </label>
                                                    <input id="com_tax" name="com_tax" type="number" class="form-control" value="<?php echo $profile['com_tax'];?>" required="true">
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                &nbsp;
                                            </div>
                                        </div>
                                        <?php } ?>
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
                                        <img class="img" src="<?php echo PROFILE_IMG.$profile['user_img'];?>" />
                                    </a>
                                </div>
                                <div class="card-content">
                                    <h6 class="category text-gray"><?php echo get_role_title($profile['role_id']);?></h6>
                                    <h4 class="card-title"><?php echo $profile['user_fname']." ".$profile['user_lname'];?></h4>
                                    <p class="description">
                                        
                                    </p>
                                    
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">info</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Company Details</h4>
                                    <div class="card-avatar company_logo">
                                    <a href="#pablo">
                                        <img class="img" src="<?php if($profile['com_logo']!=''){ echo COMPANY_LOGO.$profile['com_logo']; } else{ echo IMG.'image_placeholder.jpg'; } ?>" >
                                    </a>
                                    </div>
                                    <h6 class="category text-gray"></h6>
                                    <h6 class="card-title"><b>Company Name :</b> <p class="no-margin"><?php echo $profile["com_name"];?></p></h6>
                                    <h6 class="card-title"><b>Company Street Address :</b> <p class="no-margin"><?php echo $profile["com_street_address"];?></p></h6>
                                    <h6 class="card-title"><b>Company Postal Address :</b> <p class="no-margin"><?php echo $profile["com_postal_address"];?></p></h6>
                                    <h6 class="card-title"><b>Company Email :</b> <p class="no-margin"><?php echo $profile["com_email"];?></p></h6>
                                    <h6 class="card-title"><b>Company Website :</b> <p class="no-margin"><?php echo $profile["com_website"];?></p></h6>
                                    <h6 class="card-title"><b>Company GST Number :</b> <p class="no-margin"><?php echo $profile["com_gst_number"];?></p></h6>
                                    <h6 class="card-title"><b>Company Phone Number :</b> <p class="no-margin"><?php echo $profile["com_phone_no"];?></p></h6>
                                    <p class="description">
                                        
                                    </p>
                                    
                                </div>
                            </div>
                        </div>
                    </div>