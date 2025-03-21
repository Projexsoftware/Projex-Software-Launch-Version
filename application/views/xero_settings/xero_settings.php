<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">settings</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Xero Settings -
                                        <small class="category">Update your xero configuration settings</small>
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
                                    <form id="XeroSettingsForm" method="post" action="<?php echo SURL;?>xero_settings/update_credentials" enctype="multipart/form-data">
                                       
                                        <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Client ID
                                                    <small>*</small>
                                                    </label>
                                                    <input id="client_id" name="client_id" type="text" class="form-control" value="<?php echo $xero_settings["client_id"];?>" required="true">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Client Secret
                                                    <small>*</small>
                                                    </label>
                                                    <input id="client_secret" name="client_secret" type="text" class="form-control" value="<?php echo $xero_settings["client_secret"];?>" required="true">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Xero Tenant ID
                                                    <small>*</small>
                                                    </label>
                                                    <input id="xero_tenant_id" name="xero_tenant_id" type="text" class="form-control" value="<?php echo $xero_settings["xero_tenant_id"];?>" required="true">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Access Token
                                                    <small>*</small>
                                                    </label>
                                                    <textarea class="form-control" id="access_token" name="access_token" required="true"><?php echo $xero_settings["access_token"];?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Refresh Token
                                                    <small>*</small>
                                                    </label>
                                                    <textarea class="form-control" id="refresh_token" name="refresh_token" required="true"><?php echo $xero_settings["refresh_token"];?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        
                                       <div class="form-footer text-right">
                                            <input type="submit" name="btnsubmitpass" class="btn btn-warning" value="Update">
                                            <a onclick="demo.showSwal('deleteXeroAccount', 'xero_settings/delete_account', <?php echo $xero_settings['id'];?>)" class="btn btn-danger">Delete</a>
                                        </div>
                                        <div class="clearfix"></div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        