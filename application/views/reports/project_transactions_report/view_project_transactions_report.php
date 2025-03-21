<style>
    .table-striped>tbody>tr:nth-child(odd)>td, .table-striped.table_1>tbody>tr:nth-child(odd)>th {
    background-color: #415160;
    color: #fff;
}
</style>
<div id="row">
    <div class="col-md-12">
        <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">report</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Project Transactions Report</h4> 
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
                                    
                                        <div class="row">
                                             <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group label-floating col-md-12">
                                                            <label class="col-md-3 label_with_selectpicker">Select Project <small>*</small></label>
                                                            <div class="col-md-9">
                                                                <select class="selectpicker" data-style="select-with-transition" name="project_id" id="transactions_project_id" title="Select Project" data-live-search="true" required onchange="filter_projects();">
                                                                    <option value="all" selected>All Projects</option>
                                                                    <?php foreach ($projects as $project) { ?>
                                                                        <option value="<?php echo $project["project_id"]; ?>"><?php echo $project["project_title"]; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                                <?php echo form_error('project_id', '<div class="custom_error">', '</div>'); ?>
                                                            </div>
                                                    </div>
                                                    <div class="form-group label-floating col-md-12">
                                                            <label class="col-md-3 label_with_selectpicker">Select Transaction Type <small>*</small></label>
                                                            <div class="col-md-9">
                                                                <select class="selectpicker" data-style="select-with-transition" name="transaction_type" id="transaction_type" title="Select Transaction Type" data-live-search="true" required onchange="filter_projects();">
                                                                    <option value="all" selected>All Transactions</option>
									                                <option value="paid" >Paid Transactions</option>
                                                                </select>
                                                            </div>
                                                    </div>
                                                </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12">          
                                                    	<div class="project_report_container material-datatables table-responsive">
                                                            <table class="table table-striped table-no-bordered table-hover datatables" cellspacing="0" width="100%" style="width:100%" >
                                                                <thead>
                                                                    <tr>
                                                                        <th class="sr_no_common">Sr No</th>
                                                                        <th class="sr_no_common">Supplier</th>
                                                                        <th class="sr_no_common">Supplier reference</th>
                                                                        <th class="sr_no_common">Supplier invoice</th>
                                                                        <th class="sr_no_common">Supplier Credits</th>
                                                                        <th class="sr_no_common">Status</th>
                                                                        <th class="yellow_cals">Sales Invoice</th>
                                                                        <th class="yellow_cals">Sales invoice paid</th>
                                                                        <th class="yellow_cals">Sales Credits</th>
                                                                        <th class="yellow_cals">Status</th>
                                                                        <th class="yellow_cals">Balance</th>
                                                                    </tr>
                                                                </thead>
                                                                   
                                                                <tbody>
                    <?php if(isset($project_all) && count($project_all)>0){?>
                        <?php $count = 1;
                        foreach ($project_all as $p => $project) { ?>
                            <?php if(array_key_exists($project['project_id'],$supplier_rec_project) || array_key_exists($project['project_id'],$sales_rec_project)){?>
                            <tr class="pro_title">
                            	<td colspan="11" style="background:green!important;"><?php echo $project['project_title'];?></td>
                            </tr>
                            <?php }
							$balance=0;
							?>
                                <?php if(array_key_exists($project['project_id'],$supplier_rec_project)){
								
								?>
									<?php 
									
									foreach($supplier_rec_project[$project['project_id']] as $s_record){?>
                                    <tr>
                                    <td><?php echo $count;?></td>
                                    <td><?php echo $s_record['supplier_name'];?></td>
                                    <td><?php echo $s_record['supplierrefrence'];?></td>
                                    <td><?php echo "$".number_format(($s_record['invoice_amount']*($s_record['va_tax']/100))+$s_record['invoice_amount'], 2, '.', ',');?></td>
                                    <td><?php echo "-$".number_format(get_total_supplier_credits($s_record['id']),2,".",",");?></td>
                                    <td><?php echo $s_record['status'];?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
									<?php 
									$supplier_amount = number_format(($s_record['invoice_amount']*($s_record['va_tax']/100))+$s_record['invoice_amount'], 2, '.', '');
									$supplier_credits = number_format(get_total_supplier_credits($s_record['id']),2,".","");
										$balance -=($supplier_amount-$supplier_credits);
									echo "$".number_format($balance, 2, '.', ',');?>
									</td>
                                    </tr>
                                    <?php $count++;?>
                                    <?php }?>
                                <?php }?>
                                <?php if(array_key_exists($project['project_id'],$sales_rec_project)){
                                ?>
									<?php foreach($sales_rec_project[$project['project_id']] as $sales_record){?>
                                    <tr>
                                    <td><?php echo $count;?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><?php echo $sales_record['notes'];?></td>
                                    <td><?php echo "$".number_format(($sales_record['invoice_amount']*(15/100))+$sales_record['invoice_amount'], 2, '.', '');?></td>
                                    <td><?php echo "-$".number_format(get_total_sales_credits($sales_record['id']),2,".",",");?></td>
                                    <td><?php echo $sales_record['status'];?></td>
                                    <td><?php 
										$balance +=(number_format(($sales_record['invoice_amount']*(15/100))+$sales_record['invoice_amount'], 2, '.', '')-number_format(get_total_sales_credits($sales_record['id']),2,".",""));
									echo "$".number_format($balance, 2, '.', ',');?></td>
                                    </tr>
                                    <?php $count++;?>
                                    <?php }?>
                                <?php }?>
                            <?php } ?>
                        <?php }else{?>
                        	<tr>
                            	<td colspan="9">No Records Found</td>
                            </tr>
                        <?php }?>
                    </tbody>
                                                            </table>
                                                            <?php if(isset($project_all) && count($project_all)>0){ ?>
<div class="row">
    <div class="col-md-12">
     <div class="form-footer">
        <form id="" name="" action="<?php echo base_url(); ?>reports/export_project_transactions_report" method="post" class="print">
            <a href="javascript:window.print()" class="btn btn-success no_print">Print</a>
            <input type="hidden" id="report_type" name="report_type" value="">
            <input type="hidden" id="report_project_id" name="report_project_id" value="all">
			<input type="hidden" id="report_transaction_type" name="report_transaction_type" value="all">
            <input class="btn btn-success no_print" type="submit" id="" name="" value="Export To Excel" onclick="changeReportType('excel', 'project_transactions');">
            <input class="btn btn-success no_print" type="submit" id="" name="" value="Export To PDF" onclick="changeReportType('pdf', 'project_transactions');">
        </form>
    </div>
</div>
</div>
<?php } ?>
                                                        </div>
                                                </div>
                                        </div>
                                        
                                </div>
		</div>
    </div>
</div>
