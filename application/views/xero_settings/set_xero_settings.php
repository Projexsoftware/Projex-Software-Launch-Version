<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">settings</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Xero Settings -
                                        <small class="category">Update your Xero Configuration</small>
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
                                    <form id="XeroSettingsForm" method="post" action="<?php echo SURL;?>xero_settings/getToken" enctype="multipart/form-data" autocomplete="off">
                                       
                                        <div class="col-md-12">
                                         <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Redirect URIs
                                                    <small>*</small>
                                                    </label>
                                                    <input id="redirect_uri" name="redirect_uri" type="text" class="form-control" value="<?php echo SURL;?>xero_settings/getToken" required="true" disabled>
                                                    <p class="text-success">Please copy above URL and paste it into XERO configuration page under Redirect URIs text field.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Client ID
                                                    <small>*</small>
                                                    </label>
                                                    <input id="client_id" name="client_id" type="text" class="form-control" value="" required="true">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Client Secret
                                                    <small>*</small>
                                                    </label>
                                                    <input id="client_secret" name="client_secret" type="text" class="form-control" value="" required="true">
                                                </div>
                                            </div>
                                        </div>
                                       
                                        <input type="submit" name="btnsubmitpass" class="btn btn-warning pull-right" value="Get Token & XERO Tenant ID">
                                        <div class="clearfix"></div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        