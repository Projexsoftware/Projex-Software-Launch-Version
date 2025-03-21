<div class="row">
                        <div class="col-md-12">
                            
                            <div class="card">
                                <form id="CashFlowForm" method="POST" action="<?php echo SURL ?>cashflow/add_new_cashflow_process" enctype="multipart/form-data">
                                    <div class="card-header card-header-icon" data-background-color="red">
                                        <i class="material-icons">attach_money</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Add Cash Flow Form</h4>
                                        <?php
										if ($this->session->flashdata('cerr_message')) {
											?>
											<div class="alert alert-danger">
												<?php echo $this->session->flashdata('cerr_message'); ?>
											</div>
											<?php
										}

										if ($this->session->flashdata('cok_message')) {
											?>
											<div class="alert alert-success alert-dismissable">
												<?php echo $this->session->flashdata('cok_message'); ?>
											</div>
											<?php
										}
										?>
                                        <button class="btn btn-simple btn-github" style="font-size:16px;padding-left:0px;">
                                            <i class="fa fa-user"></i> YOUR DETAILS
                                            <div class="ripple-container"></div>
                                        </button>
                                        <div class="form-group label-floating">
                                            <label class="control-label">
                                                Business Name
                                                <small>*</small>
                                            </label>
                                            <input class="form-control" type="text" name="business_name" id="business_name" required="true" value="<?php echo set_value('business_name')?>"/>
                                            <?php echo form_error('business_name', '<div class="custom_error">', '</div>'); ?>
					                    </div>
                                        <div class="form-group label-floating">
                                            <label class="control-label">
                                                Your Name
                                                <small>*</small>
                                            </label>
                                            <input class="form-control" type="text" name="your_name" id="your_name" required="true" value="<?php echo set_value('your_name')?>"/>
                                            <?php echo form_error('your_name', '<div class="custom_error">', '</div>'); ?>
					                    </div>
					                    <div class="form-group label-floating">
                                            <label class="control-label">
                                                Email
                                                <small>*</small>
                                            </label>
                                            <input class="form-control" type="text" name="email" id="email" required="true" email="true" value="<?php echo set_value('email')?>"/>
                                            <?php echo form_error('email', '<div class="custom_error">', '</div>'); ?>
					                    </div>
					                    <div class="project_container">
					                        <div class="add_another_project_container">
    					                    <button class="btn btn-simple btn-github" style="font-size:16px;padding-left:0px;">
                                                <i class="fa fa-info"></i> PROJECT DETAILS
                                                <div class="ripple-container"></div>
                                            </button>
    
                                            <div class="form-group label-floating" style="margin-left: 55px;margin-bottom: 10px;">
                                                <label class="control-label">
                                                    Project Name
                                                    <small>*</small>
                                                </label>
                                                <input class="form-control project_name" type="text" name="project_name[]" required="true" value="<?php echo set_value('project_name')?>"/>
                                                <?php echo form_error('project_name', '<div class="custom_error">', '</div>'); ?>
    					                    </div>
        					                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">attach_money</i>
                                                    </span>
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Project Contract Price <small>*</small></label>
                                                        <input type="text" name="project_contract_price[]" class="form-control" required="true" number="true" value="0">
                                                    </div>
                                            </div>
                                            <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">attach_money</i>
                                                    </span>
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Value of Contract Variations <small>*</small></label>
                                                        <input type="text" name="value_of_contract_variations[]" class="form-control" required="true" number="true" value="0">
                                                    </div>
                                            </div>
                                            <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">attach_money</i>
                                                    </span>
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Total Value of Sales Invoices Issued <small>*</small></label>
                                                        <input type="text" name="total_value_of_sales_invoices_issued[]" class="form-control" required="true" number="true" value="0">
                                                    </div>
                                            </div>
                                            <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">attach_money</i>
                                                    </span>
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Total value of outstanding Sales Invoices <small>*</small></label>
                                                        <input type="text" name="total_value_of_outstanding_sales_invoices[]" class="form-control" required="true" number="true" value="0">
                                                    </div>
                                            </div>
                                            <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">attach_money</i>
                                                    </span>
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Project Contract Budget <small>*</small></label>
                                                        <input type="text" name="project_contract_budget[]" class="form-control" required="true" number="true" value="0">
                                                    </div>
                                        </div>
                                            <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">attach_money</i>
                                                    </span>
                                                    <div class="form-group label-floating">
                                                        <label class="control-label" for="value_of_extra_cost_due_to_variations">Value of extra costs due to variations (or other factors) <small>*</small></label>
                                                        <input type="text" name="value_of_extra_cost_due_to_variations[]" class="form-control" required="true" number="true" value="0">
                                                    </div>
                                        </div>
                                            <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">attach_money</i>
                                                    </span>
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Total Bills received from Suppliers & Subbies <small>*</small></label>
                                                        <input type="text" name="total_bills_received_from_suppliers_and_subbies[]" class="form-control" required="true" number="true" value="0">
                                                    </div>
                                            </div>
                                            <div class="input-group last_object">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">attach_money</i>
                                                    </span>
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Total Value of unpaid bills for this job <small>*</small></label>
                                                        <input type="text" name="total_value_of_unpaid_bill[]" class="form-control" required="true" number="true" value="0">
                                                    </div>
                                            </div>
                                           </div>
                                        <div class="form-group label-floating add_more_container"><a class="btn btn-success btn-fill add_more">Add Another Project</a></div>
                                        </div>
				                        <div class="form-group label-floating">
                                            <button class="btn btn-simple btn-github" style="font-size:16px;padding-left:0px;">
                                                <i class="fa fa-dollar"></i> Cash Details
                                            <div class="ripple-container"></div></button>
                                        </div>
                                        <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">attach_money</i>
                                                </span>
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Total Cash in your bank account <small>*</small></label>
                                                    <input type="text" id="total_cash_in_your_bank_account" name="total_cash_in_your_bank_account" class="form-control" required="true" number="true" value="0">
                                                </div>
                                        </div>
                                        <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">attach_money</i>
                                                </span>
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Current Overdraft Limit <small>*</small></label>
                                                    <input type="text" id="current_overdraft_limit" name="current_overdraft_limit" class="form-control" required="true" number="true" value="0">
                                                </div>
                                        </div>
                                        <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">attach_money</i>
                                                </span>
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Value of employee subsidy (If not included in cash above) <small>*</small></label>
                                                    <input type="text" id="value_of_employee_subsidy" name="value_of_employee_subsidy" class="form-control" required="true" number="true" value="0">
                                                </div>
                                        </div>
                                        <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">attach_money</i>
                                                </span>
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Wages and drawings to be paid during the shut down period <small>*</small></label>
                                                    <input type="text" id="wages_and_drawings_to_be_paid" name="wages_and_drawings_to_be_paid" class="form-control" required="true" number="true" value="0">
                                                </div>
                                        </div>
                                        <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">attach_money</i>
                                                </span>
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Other Costs to be paid during the shut down <small>*</small></label>
                                                    <input type="text" id="other_costs_to_be_paid" name="other_costs_to_be_paid" class="form-control" required="true" number="true" value="0">
                                                </div>
                                        </div>
                                        <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">attach_money</i>
                                                </span>
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Tax and GST to be paid during the shut down <small>*</small></label>
                                                    <input type="text" id="tax_and_gst_to_be_paid" name="tax_and_gst_to_be_paid" class="form-control" required="true" number="true" value="0">
                                                </div>
                                        </div>
                                        <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">attach_money</i>
                                                </span>
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Any revenue expected during the shut down <small>*</small></label>
                                                    <input type="text" id="any_revenue_expected" name="any_revenue_expected" class="form-control" required="true" number="true" value="0">
                                                </div>
                                        </div>
                                        <div class="form-footer text-right">
                                            <button type="submit" class="btn btn-danger btn-fill">Add</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                