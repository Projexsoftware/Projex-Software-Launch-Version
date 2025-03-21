<div id="row">
    <div class="col-md-12">
        <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">report</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Project Summary</h4> 
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
                                    <form method="post" id="reportForm" action="<?php echo SURL; ?>reports/project_summary_report" autocomplete="off">
                                        <div class="row">
                                             <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group label-floating col-md-12">
                                                            <label class="col-md-3 label_with_selectpicker">Project <small>*</small></label>
                                                            <div class="col-md-9">
                                                                <select class="selectpicker" data-style="select-with-transition" name="project_id" id="project_summary_project_id" title="Select Project" data-live-search="true" required onchange="get_project_summary();">
                                                                    <?php foreach ($projects as $project) { ?>
                                                                        <option value="<?php echo $project["project_id"]; ?>"><?php echo $project["project_title"]; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                                <?php echo form_error('project_id', '<div class="custom_error">', '</div>'); ?>
                                                            </div>
                                                    </div>
                                                    <div class="form-group label-floating col-md-12">
                                                            <label class="col-md-3 label_with_selectpicker">Invoice Start Date <small>*</small></label>
                                                            <div class="col-md-9">
                                                                <input class="form-control datepicker" name="invoice_start_date" id="invoice_start_date" value="" required>
                                                                <?php echo form_error('invoice_start_date', '<div class="custom_error">', '</div>'); ?>
                                                            </div>
                                                    </div>
                                                    <div class="form-group label-floating col-md-12">
                                                            <label class="col-md-3 label_with_selectpicker">Invoice End Date <small>*</small></label>
                                                            <div class="col-md-9">
                                                                <input class="form-control datepicker" name="invoice_end_date" id="invoice_end_date" value="" required>
                                                                <?php echo form_error('invoice_end_date', '<div class="custom_error">', '</div>'); ?>
                                                            </div>
                                                    </div>
                                                    <div class="form-group label-floating col-md-12">
                                                            <div class="col-md-12">
                                                                <div class="pull-right">
                                                                    <input class="btn btn-warning project_summary_filters" type="button" id="search_report" name="search_report" value="Search">
                                                                </div>
                                                            </div>
                                                    </div>
                                                </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12">          
                                                    	<div class="project_report_container">
                <table class="table table-bordered table-striped table-hover print_table">
                    <thead>
                        <tr>
                            <th style="background-color:#495B6C; color:#fff;width:150px;"></th>
                            <th style="background-color:#495B6C; color:#fff;">Date</th>
                            <th style="background-color:#495B6C; color:#fff;">Supplier</th>
                            <th style="background-color:#495B6C; color:#fff;">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                        	<tr>
                        	    <td><b>Sales Invoices</b></td>
                            	<td colspan="3"><center></center></td>
                            </tr>
                            <tr>
                        	    <td colspan="3" style="background-color:#495B6C; color:#fff;"><b>Total</b></td>
                            	<td class="text-right" style="background-color:#495B6C; color:#fff;"><b>$0.00</b></td>
                            </tr>
                            <tr>
                        	    <td><b>Sales Credit Notes</b></td>
                            	<td colspan="3"><center></center></td>
                            </tr>
                             <tr>
                        	    <td colspan="3" style="background-color:#495B6C; color:#fff;"><b>Total</b></td>
                            	<td class="text-right" style="background-color:#495B6C; color:#fff;"><b>$0.00</b></td>
                            </tr>
                            <tr>
                        	    <td><b>Supplier Invoices</b></td>
                            	<td colspan="3"><center></center></td>
                            </tr>
                             <tr>
                        	    <td colspan="3" style="background-color:#495B6C; color:#fff;"><b>Total</b></td>
                            	<td class="text-right" style="background-color:#495B6C; color:#fff;"><b>$0.00</b></td>
                            </tr>
                            <tr>
                        	    <td><b>Supplier Credit Notes</b></td>
                            	<td colspan="3"><center></center></td>
                            </tr>
                             <tr>
                        	    <td colspan="3" style="background-color:#495B6C; color:#fff;"><b>Total</b></td>
                            	<td class="text-right" style="background-color:#495B6C; color:#fff;"><b>$0.00</b></td>
                            </tr>
                        
                    </tbody>
                </table>
            </div>
                                                </div>
                                        </div>
                                    </form>
        
								</div>
		</div>
    </div>
</div>
