<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">money</i>
                                    </div>
                                    <div class="card-content">
                                    <h4 class="card-title">Add Cash Transfer</h4>
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
                                        <form id="CashTransferForm" method="POST" action="<?php echo SURL ?>cash_transfers/insertcashtransfer" autocomplete="off">
                                    
                                        <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    
                                                    </label>
                                                    <select class="selectpicker" data-live-search="true" data-style="select-with-transition" title="Select Project *" data-size="7" name="project_id" id="project_id" required="true" onchange="getsupplierbycostingid(this.value)">
                                                        <option disabled> Choose Project</option>
            											<?php foreach($projects as $project){ ?>
            											<option value="<?php echo $project->project_id; ?>"><?php echo $project->project_title; ?></option>
            											<?php } ?>
                                                    </select>
                                                    <?php echo form_error('project_id', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                        </div>
                                        <div class="col-md-12" style="display:none" id="divsupplierforcurrentcosting">
                                                <div class="form-group label-floating suppliers_container">
                                                    <label class="control-label">
                                                    
                                                    </label>
                                                    <select class="selectpicker" data-style="select-with-transition" title="Select Supplier *" data-size="7" name="supplier_id" id="supplier_id" required="true">
                                                        <option disabled> Choose Supplier</option>
            											
                                                    </select>
                                                    <?php echo form_error('supplier_id', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                        </div>
                                        <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                       Transfer Amount <small>*</small>
                                                    </label>
                                                    <input class="form-control" name="transfer_amount" id="transfer_amount" type="text" required number="true">
                                                    <?php echo form_error('transfer_amount', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                        </div>
                                        <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                       Comment <small>*</small>
                                                    </label>
                                                    <textarea class="form-control" rows="5"  id="comment" name="comment" required></textarea> 
                                                    <?php echo form_error('comment', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                        </div>
                                        <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <div class="form-footer text-right">
                                                        <button type="submit" class="btn btn-warning btn-fill">Save</button>
                                                        <a href="<?php echo SURL;?>cash_transfers" class="btn btn-default btn-fill">Cancel</a>
                                                    </div>
                                            </div>
                                        </div>
                                     </form>
                                </div>
                            </div>
                        </div>
                    </div>