<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <form id="EmailMessageForm" method="POST" action="<?php echo SURL ?>purchase_orders/update_email_message" autocomplete="off">
								<input type="hidden" id="email_message_id" name="email_message_id" value="<?php echo $email_message->id;?>">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">email</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Email Message</h4>
                                        <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="">
                                                    Detail
                                                    <small>*</small>
                                                    </label>
                                                    <textarea class="form-control ckeditor" type="text" name="detail" id="detail" ckrequired="true"><?php echo stripcslashes($email_message->detail);?></textarea>
                                                    <?php echo form_error('detail', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            
                                       <div class="col-md-12">
                                            <div class="col-md-12">
            				                    <div class="form-group label-floating">
                                                    <div class="form-footer text-right">
                                                        <?php if(in_array(98, $this->session->userdata("permissions"))) {?>
                                                        <button type="submit" id="update_email_message" name="update_email_message" class="btn btn-warning btn-fill">Update</button>
                                                        <?php } ?>
                                                        <a href="<?php echo SURL;?>setup/email_message" class="btn btn-default btn-fill">Cancel</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
                