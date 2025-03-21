<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">book</i>
                                    </div>
                                    <div class="card-content">
                                    <h4 class="card-title">Send Price Book Request</h4>
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
                                    <form id="PriceBookRequestForm" method="POST" action="<?php echo SURL ?>price_book_requests/send_request_process" enctype="multipart/form-data">
                                     <div class="col-md-12">
                                        <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                      Supplier Users <small>*</small>
                                                    </label>
                                                    <select class="selectpicker" data-style="select-with-transition" data-live-search="true" title="Select Supplier User" data-size="7" name="supplier_user_id" id="supplier_user_id" required="true">
            											<?php foreach($supplier_users as $user){ 
            											?>
            											<option value="<?php echo $user['user_id'];?>"><?php echo $user["com_name"]; ?></option>
            											<?php }  ?>
                                                    </select>
                                                    <?php echo form_error('supplier_user_id', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                        </div>
                                    </div>
                                        <div class="col-md-12">
                                            <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <div class="form-footer text-right">
                                                        <button type="submit" class="btn btn-warning btn-fill">Send</button>
                                                        <a href="<?php echo SURL;?>price_book_requests" class="btn btn-default btn-fill">Close</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                     </form>
                                </div>
                            </div>
                        </div>
                    </div>
                