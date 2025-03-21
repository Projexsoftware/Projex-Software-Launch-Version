<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">payment</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Payment Settings -
                                        <small class="category">Update your card details</small>
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
                                    <form id="PaymentSettingsForm" method="post" action="<?php echo SURL;?>payment_settings/update_payment_details" enctype="multipart/form-data">
                                       
                                        <div class="col-md-12">
                                        <fieldset>Card Information</fieldset>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Card Number
                                                    <small>*</small>
                                                    </label>
                                                    <input id="card_number" name="card_number" type="text" class="form-control card-number" value="<?php if(count($payment_settings)>0){ echo $payment_settings["card_number"];}?>" required="true" placeholder='Number'>
                                                     <?php echo form_error('card_number', '<div class="custom_error">', '</div>'); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Expiry Month
                                                    <small>*</small>
                                                    </label>
                                                    <input id="expiry_month" name="expiry_month" type="text" class="form-control card-expiry-month" value="<?php if(count($payment_settings)>0){ echo $payment_settings["expiry_month"];}?>" digits="true" month="true" required="true" placeholder='MM'>
                                                     <?php echo form_error('expiry_month', '<div class="custom_error">', '</div>'); ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Expiry Year
                                                    <small>*</small>
                                                    </label>
                                                    <input id="expiry_year" name="expiry_year" type="text" class="form-control card-expiry-year" value="<?php if(count($payment_settings)>0){ echo $payment_settings["expiry_year"];}?>" digits="true" year="true" required="true" placeholder='YYYY'>
                                                     <?php echo form_error('expiry_year', '<div class="custom_error">', '</div>'); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Security Code
                                                    <small>*</small>
                                                    </label>
                                                    <input type="password" id="cvc" name="cvc" class="form-control card-cvc" value="<?php if(count($payment_settings)>0){ echo $payment_settings["cvc"];}?>" required="true" cvc="true" placeholder='CVC'>
                                                </div>
                                            </div>
                                        </div>
                                        
                                       <div class="form-footer text-right">
                                            <input type="submit" name="btnsubmitpass" class="btn btn-warning" value="Update">
                                            
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
                        