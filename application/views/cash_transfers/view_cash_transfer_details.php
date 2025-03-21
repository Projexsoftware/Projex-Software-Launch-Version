<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">money</i>
                                    </div>
                                    <div class="card-content">
                                    <h4 class="card-title">View Cash Transfer Details</h4>
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
                                    
                                        <div class="col-md-12">
                                        <form id="CashTransferForm" method="POST" action="<?php echo SURL.'cash_transfers/updatecashtransfers/'.$cashtransfer_detail["id"]; ?>" autocomplete="off">
                                    
                                        <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                   <label>Project Title <small>*</small></label>
                                                    <?php echo get_project_name($cashtransfer_detail["project_id"]); ?>
    				                        	</div>
                                        </div>
                                       
                                        <div class="col-md-12" id="divsupplierforcurrentcosting">
                                                <div class="form-group label-floating">
                                                   <label>Supplier <small>*</small></label>
                                                    <?php echo  get_supplier_name($cashtransfer_detail["supplier_id"]); ?>
    				                        	</div>
                                        </div>
                                        <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                       Transfer Amount <small>*</small>
                                                    </label>
                                                    <input class="form-control" name="transfer_amount" id="transfer_amount" type="text" number="true" required value="<?php echo $cashtransfer_detail["transfer_amount"];?>">
                                                    <?php echo form_error('transfer_amount', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                        </div>
                                        <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                       Comment <small>*</small>
                                                    </label>
                                                    <textarea class="form-control" rows="5"  id="comment" name="comment" required><?php echo $cashtransfer_detail["comment"];?></textarea> 
                                                    <?php echo form_error('comment', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                        </div>
                                        <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <div class="form-footer text-right">
                                                        <?php
                                                        if(in_array(45, $this->session->userdata("permissions"))) {
                                                         ?>
                                                        <!--<button type="submit" class="btn btn-warning btn-fill">Update</button>-->
                                                        <?php } ?>
                                                        <a href="<?php echo SURL;?>cash_transfers" class="btn btn-default btn-fill">Cancel</a>
                                                    </div>
                                            </div>
                                        </div>
                                     </form>
                                </div>
                            </div>
                        </div>
                    </div>