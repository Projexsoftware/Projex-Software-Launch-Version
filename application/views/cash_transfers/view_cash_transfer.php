<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">money</i>
                                    </div>
                                    <div class="card-content">
                                    <h4 class="card-title">View and Update Cash Transfer</h4>
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
                                                    <label class="control-label">
                                                    
                                                    </label>
                                                    
                                                    <select class="selectpicker" data-style="select-with-transition" title="Select Project *" data-size="7" name="project_id" id="project_id" required="true" onchange="getsupplierbycostingid(this.value)">
                                                        <option disabled> Choose Project</option>
            											<?php foreach($projects as $project){ ?>
            											<option value="<?php echo $project->project_id; ?>" <?php if($cashtransfer_detail["costing_id"]==$project->costing_id){ ?> selected <?php } ?>><?php echo $project->project_title; ?></option>
            											<?php } ?>
                                                    </select>
                                                    <?php echo form_error('project_id', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                        </div>
                                        <div class="col-md-12" style="display:none" id="divsupplierforcurrentcosting">
                                                <div class="form-group label-floating suppliers_container">
                                                    <label class="control-label">
                                                    
                                                    </label>
                                                    <select class="selectpicker" data-style="select-with-transition" data-live-search="true" title="Select Supplier *" data-size="7" name="supplier_id" id="supplier_id" required="true">
                                                    
                                                    <?php foreach ($suppliers as $supplier) { ?>
                                                       <option value="<?php echo $supplier['costing_supplier']; ?>" <?php if($cashtransfer_detail["supplier_id"]==$supplier['costing_supplier']){ ?> selected <?php } ?>><?php echo $supplier['supplier_name']; ?></option>
                                                    <?php } ?>
                                                    </select>
                                                    <?php echo form_error('supplier_id', '<div class="custom_error">', '</div>'); ?>
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
                                                        <button type="submit" class="btn btn-warning btn-fill">Update</button>
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