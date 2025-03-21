<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">vpn_key</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Change Password -
                                        <small class="category">Update your existing password</small>
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
                                    <form id="PasswordForm" method="post" action="<?php echo SURL;?>change_password/set_password" enctype="multipart/form-data">
                                        
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Old Password
                                                    <small>*</small>
                                                    </label>
                                                    <input id="oldpassword" name="oldpassword" type="text" class="form-control" value="" required="true" checkPassword="true">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">New Password
                                                    <small>*</small>
                                                    </label>
                                                    <input id="newpassword" name="newpassword" type="text" class="form-control" value="" required="true">
                                                </div>
                                            </div>
                                       </div>
                                       <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Confirm New Password
                                                    <small>*</small>
                                                    </label>
                                                    <input id="renewpassword" name="renewpassword" type="text" class="form-control" value="" required="true" equalTo="#newpassword">
                                                </div>
                                            </div>
                                       </div>
                                       
                                        <input type="submit" name="btnsubmitpass" class="btn btn-warning pull-right" value="Update Password">
                                        <div class="clearfix"></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        