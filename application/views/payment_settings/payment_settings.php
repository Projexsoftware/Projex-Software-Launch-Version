<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">settings</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Payment Settings -
                                        <small class="category">Update your stripe configuration settings</small>
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
                                    <form id="PaymentSettingsForm" method="post" action="<?php echo SURL;?>payment_settings/update_credentials" enctype="multipart/form-data">
                                       
                                        <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Publishable Key
                                                    <small>*</small>
                                                    </label>
                                                    <input id="publishable_key" name="publishable_key" type="text" class="form-control" value="<?php if(count($payment_settings)>0){ echo $payment_settings["publishable_key"];}?>" required="true">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Secret Key
                                                    <small>*</small>
                                                    </label>
                                                    <input id="secret_key" name="secret_key" type="text" class="form-control" value="<?php if(count($payment_settings)>0){ echo $payment_settings["secret_key"];}?>" required="true">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    <small></small>
                                                    </label>
                                                    <div class="checkbox">
                                                        <label>
                                                           Sandbox <input type="checkbox" name="sandbox" id="sandbox" value="1" <?php if(count($payment_settings)>0 && $payment_settings["sandbox"]==1){ ?> checked <?php } ?>>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                       <div class="form-footer text-right">
                                            <input type="submit" name="btnsubmitpass" class="btn btn-warning" value="<?php echo count($payment_settings)>0?'Update':'Setup';?>">
                                            
                                            <?php if(count($payment_settings)>0){ ?>
                                            <a onclick="demo.showSwal('deletePaymentSettings', 'payment_settings/delete_payment', <?php echo $payment_settings['id'];?>)" class="btn btn-danger">Delete</a>
                                            <?php } ?>
                                        </div>
                                        <div class="clearfix"></div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        