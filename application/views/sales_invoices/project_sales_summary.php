<style>
    th{
        font-size:14px!important;
        text-align:center;
    }
</style>
<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">summarize</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Project Sales Summary</h4>
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
				                    	<div class="row">
                                             <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="form-group label-floating">
                                                    <select class="selectpicker" data-style="select-with-transition" data-live-search="true" name="project_id" id="project_id" title="Select Project *" onchange="getProjectInvoices(this.value)" required>
                                                        <?php foreach ($projects as $project) { ?>
                                                            <option <?php if($project["project_id"] == $curr_proj) echo 'selected'?> value="<?php echo $project["project_id"]; ?>"><?php echo $project["project_title"]; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <?php echo form_error('project_id', '<div class="custom_error">', '</div>'); ?>
                                                </div>
                                        </div>
                                    </div>
                                        
                                        <div class="loader">
                                            <center>
                                                <img class="loading-image" src="<?php echo IMG;?>search.gif" alt="loading.." width="100px">
                                            </center>
                                        </div>
                                        
                                        <div class="form-group label-floating" id="populatetables" style="display: none">
                                           
                                        <table id="contracttable" class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr>
                    
                                                    <th class="col-md-10"><center>Contract Price</center></th>
                                                    <th class="col-md-2 text-right" id="contractprice">Contract Price</th>
                    
                                                </tr>
                                            </thead>
                                        </table>
                                        <br>
                                        <div class="table-responsive">
                                           <table id="allowancetable" class="table table-bordered table-striped table-hover ">
                                            <thead>
                                                <tr data-background-color="orange">
                                                    <td colspan="6"><center>Contract Allowances</center></td>
                                                </tr>
                                                <tr>
                                                    <th>Part</th>
                                                    <th>Component</th>
                                                    <th>Allowance</th>
                                                    <th>Actual</th>
                                                    <th>Difference</th>
                                                    <!--<th>Invoice Number</th>
                                                    <th>Invoice Amount</th>-->
                                                    <!--<th>Actions</th>-->
                                                    <!--<th>Invoice Amount Paid</th>
                                                    <th>Invoice Amount Owing</th>-->
                                                    <th>Updated Contract Price</th>
                                                </tr>
                                            </thead>
                                            <tbody class="allowancetable_container">
                                                <tr id="impnopartadded">
                                                    <td colspan="6">
                                                        Select Project First
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        </div>
                                        <br>
                                        <table id="variationtable" class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr data-background-color="orange">
                                                    <td colspan="4"><center>Variations</center></td>
                                                </tr>
                                                <tr>
                                                    <th>Variation number</th>
                                                    <th>Variation Description</th>
                                                    <th>Total Cost</th>
                                                    <!--<th>Invoice Number</th>
                                                    <th>Invoice Amount</th>
                                                    <th>Actions</th>
                                                    <th>Invoice Amount Paid</th>
                                                    <th>Invoice Amount Owing</th>-->
                                                    <th>Updated Contract Price</th>
                                                </tr>
                                            </thead>
                                            <tbody class="variationtable_container">
                                                <tr id="impnopartadded">
                                                    <td colspan="4">
                                                        Select Project First
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <br>
                                        <table id="allowancepaymenttable" class="table table-bordered table-striped table-hover ">
                                            <thead>
                                                <tr data-background-color="orange">
                                                    <td colspan="7"><center>Allowance Invoices & Payments</center></td>
                                                </tr>
                                                <tr>
                                                    <th>Component</th>
                                                    <th>Invoice Number</th>
                                                    <th>Invoice Amount</th>
                                                    <th>Actions</th>
                                                    <th>Amount Paid</th>
                                                    <th>Amount Owing</th>
                                                    <th>Balance</th>
                                                </tr>
                                            </thead>
                                            <tbody class="allowancepaymenttable_container">
                                                <tr id="impnopartadded">
                                                    <td colspan="7">
                                                        Select Project First
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <br>
                                        <form id="formtemppayment" action="<?php echo base_url()?>sales_invoices/savetemppayments"  method="post" autocomplete="off">
                                            
                                        <table id="paymenttable" class="table table-bordered table-striped table-hover">
                                            <a id="addbtn" title="Add new payment item" class="btn btn-primary clone pull-right add_new_payment" type="button" value="1" onclick="addMore(this.value);"><i class="fa fa-plus-circle"></i> Add New Payment Item</a>
                                            <thead>
                                                <tr>
                                                    <th>Payment Description</th>
                                                    <th>Payment Amount</th>
                                                    <th>Invoice Number</th>
                                                    <th>Invoice Amount</th>
                                                    <th>Actions</th>
                                                    <th>Invoice Amount Paid</th>
                                                    <th>Invoice Amount Owing</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                 
                                                    <tr id="impnopartadded">
                                                        <td colspan="8">
                                                            Select Project First
                                                        </td>
                                                    </tr>
                                            </tbody>
                                        </table>
                                        
                                            </form>
                                        <hr>
                                        <div class="form-footer">
                                            <div class="pull-left">
                                            </div>
                                            <div class="pull-right">
                                               <span class="report_btn"><a href="#" class="btn btn-success">Report</a></span>
                                            </div>
                                        </div>
                                    </div>
                                        
                                    </div>
                            </div>
                        </div>
                    </div>
<script>
    <?php 

        if($curr_proj!=0): ?>
        $(function(){

            getProjectInvoices(<?=$curr_proj ?>);

        });

        <?php endif; ?>
</script>
                    
    
                