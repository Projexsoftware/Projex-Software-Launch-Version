<div id="row">
    <div class="col-md-12">
        <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">report</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Work In Progress Report</h4> 
                                    <div class="toolbar">
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
									</div>
									<div class="loader">
                                            <center>
                                                <img class="loading-image" src="<?php echo IMG;?>search.gif" alt="loading.." width="100px">
                                            </center>
                                    </div>
                                    <form method="post" id="reportForm" action="<?php echo SURL; ?>reports/export_work_in_progress_report" autocomplete="off">
                                        <div class="row">
                                             <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group label-floating col-md-12">
                                                            <label class="col-md-3 label_with_selectpicker">Select Project <small>*</small></label>
                                                            <div class="col-md-9">
                                                                <select class="selectpicker" data-style="select-with-transition" name="project_id" id="work_inprogress_project_id" title="Select Project" data-live-search="true" required>
                                                                    <?php foreach ($projects as $project) { ?>
                                                                        <option value="<?php echo $project["costing_id"]; ?>"><?php echo $project["project_title"]; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                                <?php echo form_error('project_id', '<div class="custom_error">', '</div>'); ?>
                                                            </div>
                                                    </div>
                                                    <div class="form-group label-floating col-md-12">
                                                            <label class="col-md-3 label_with_selectpicker">Select Date Range Start Date <small>*</small></label>
                                                            <div class="col-md-9">
                                                                <input class="form-control datepicker" name="start_date" id="start_date" value="" required>
                                                                <?php echo form_error('start_date', '<div class="custom_error">', '</div>'); ?>
                                                            </div>
                                                    </div>
                                                    <div class="form-group label-floating col-md-12">
                                                            <label class="col-md-3 label_with_selectpicker">Select Date Range End Date <small>*</small></label>
                                                            <div class="col-md-9">
                                                                <input class="form-control datepicker" name="end_date" id="end_date" value="" required>
                                                                <?php echo form_error('end_date', '<div class="custom_error">', '</div>'); ?>
                                                            </div>
                                                    </div>
                                                    <div class="form-group label-floating col-md-12">
                                                            <div class="col-md-12">
                                                                <div class="pull-right">
                                                                    <input class="btn btn-warning work_in_progress_filters" type="button" id="search_report" name="search_report" value="Search">
                                                                </div>
                                                            </div>
                                                    </div>
                                                </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12">          
                                                    	<div id="report" >
                                                            <table  class="table table-bordered table-striped table-hover" >
                                                                <tr><td colspan="3" style="background-color: #000"></td></tr>
                                                                <tr>
                                                                    <td >Updated Contract Price Including GST</td>
                                                                    <td colspan="2" class="text-right">$<span id="updatepcpigst"></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td >Updated Contract Budget including GST</td>
                                                                    <td colspan="2" class="text-right">$<span id="updatepcostigst"></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td >Projected Profit</td>
                                                                    <td colspan="2" class="text-right">$<span id="projectedprofit"></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td >Contingency % of Contract Budget</td>
                                                                    <td>%</td>
                                                                    <td ><input class="form-control calculate-on-change" name="contigency_of_contract_budget" id="contigency_of_contract_budget" value="1.5"/></td>
                                                                </tr>
                                                                <tr>
                                                                    <td >Contingency Value Including GST</td>
                                                                    <td colspan="2" class="text-right">$<span id="contigency_value_including_gst"></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td >Projected Profit after Contingency</td>
                                                                    <td colspan="2" class="text-right">$<span id="projected_profit_after_contigency"></span></td>
                                                                </tr>
                                                                <tr><td colspan="3" style="background-color: #000"></td></tr>
                                                                <tr>
                                                                    <td>Sales Invoices Created in Date Range Including GST</td>
                                                                    <td colspan="2" class="text-right">$<span id="salesinvoicecreated"></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td >JOB Completion Progress %</td>
                                                                    <td colspan="2" class="text-right"><span id="job_completion_progress"></span>%</td>
                                                                </tr>
                                                                 <tr><td colspan="3" style="background-color: #000"></td></tr>
                                                                <tr>
                                                                    <td>Updated Contract Budget including Contingency & GST</td>
                                                                    <td colspan="2" class="text-right">$<span id="upd_cont_bud_inc_con_gst"></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td >Supplier Invoices Created In Date Range Including GST</td>
                                                                    <td colspan="2" class="text-right">$<span id="supplierinvoicecreated"></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td >Supplier Invoices Based on % Complete</td>
                                                                    <td colspan="2" class="text-right">$<span id="supplier_invoices_based_on_per_completed"></span></td>
                                                                </tr>
                                                                <tr><td colspan="3" style="background-color: #000"></td></tr>
                                                                <tr>
                                                                    <td>WORK IN PROGRESS VALUE</td>
                                                                    <td colspan="2" class="text-right">$<span id="work_in_progress_value"></span></td>
                                                                </tr>
                                                                <tr><td colspan="3" style="background-color: #000"></td></tr>
                                                            </table>
                                                        </div>
                                                </div>
                                        </div>
                                        <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12"> 
                                                     <div class="form-footer">
                                                         	<input type="submit" class="btn btn-success reportBtn" name="work_in_progress_excel" style="display:none;" value="Export To Excel"/>
		                                                    <input type="submit" class="btn btn-success reportBtn" name="work_in_progress_pdf" style="display:none;" value="Export To PDF"/>
                                                     </div>
                                                </div>
                                        </div>
                                        
                                    </form>
        
								</div>
		</div>
    </div>
</div>
