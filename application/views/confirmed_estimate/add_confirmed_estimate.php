<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">star</i>
                                    </div>
                                    <div class="card-content">
                                    <h4 class="card-title">Add Confirmed Estimate</h4>
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
                                        <form id="ConfirmedEstimateForm" method="POST" action="<?php echo SURL ?>confirmed_estimate/send_for_confirmation" enctype="multipart/form-data">
                                    
                                        <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    
                                                    </label>
                                                    <select class="selectpicker" data-style="select-with-transition" title="Select Project *" data-size="7" name="project_id" id="project_id" required="true">
                                                        <option disabled> Choose Project</option>
            											<?php foreach($projects as $project){ ?>
            											<option value="<?php echo $project->project_id; ?>"><?php echo $project->project_title; ?></option>
            											<?php } ?>
                                                    </select>
                                                    <?php echo form_error('project_id', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                        </div>
                                        <div class="col-md-12">
                                                <div class="form-group label-floating suppliers_container">
                                                    <label class="control-label">
                                                    
                                                    </label>
                                                    <select class="selectpicker" data-style="select-with-transition" title="Select Supplier *" data-size="7" name="supplier_id" id="supplier_id" required="true">
                                                        <option disabled> Choose Supplier</option>
            											
                                                    </select>
                                                    <?php echo form_error('supplier_id', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                        </div>
                                        
                                        <input type="hidden" name="selected_project_id" id="selected_project_id" value="">
                                        <input type="hidden" name="selected_supplier_id" id="selected_supplier_id" value="">

                                        <div class="col-md-12">
                                            <div class="form-group label-floating">
            									<table class="table">
                                                    <thead>
                                                      <tr>
                                                        <th><input type="checkbox" class="select_all" name=""></th>
                                                        <th>Stage</th>
                                                        <th>Part</th>
                                                        <th>Component</th>
                                                        <th>QTY</th>
                                                        <th>Unit Of Measure</th>
                                                        <th>Unit Cost</th>
                                                        <th>Line Total</th>
                                                        <th>User Notes</th>
                                                        <th>Supplier Notes</th>
                                                      </tr>
                                                    </thead>
                                                    <tbody class="parts_container">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <div class="form-footer text-right">
                                                        <button type="submit" class="btn btn-warning btn-fill">Send For Confirmation</button>
                                                        <a href="<?php echo SURL;?>confirmed_estimate" class="btn btn-default btn-fill">Cancel</a>
                                                    </div>
                                            </div>
                                        </div>
                                     </form>
                                </div>
                            </div>
                        </div>
                    </div>