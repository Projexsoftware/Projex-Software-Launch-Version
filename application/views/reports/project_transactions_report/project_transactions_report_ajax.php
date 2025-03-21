 <table class="table table-striped table-no-bordered table-hover datatables print_table" cellspacing="0" width="100%" style="width:100%" >
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
                    <?php	
					$is_record_exists=0;
					if(isset($project_all) && count($project_all)>0){ 
					?>
                        <?php $count = 1;
                        foreach ($project_all as $p => $project) { 
						if(($proj_id==$project['project_id'] && $proj_id!="all") || $proj_id=="all"){
						?>
                            <?php if(array_key_exists($project['project_id'],$supplier_rec_project) || array_key_exists($project['project_id'],$sales_rec_project)){
								$is_record_exists=1;
								?>
                            <tr class="pro_title">
                            	<td colspan="11" style="background:green!important;"><?php echo $project['project_title'];?></td>
                            </tr>
                            <?php }
							$balance=0;
							?>
                                <?php if(array_key_exists($project['project_id'],$supplier_rec_project)){?>
									<?php foreach($supplier_rec_project[$project['project_id']] as $s_record){
									    $supplier_amount = number_format(($s_record['invoice_amount']*($s_record['va_tax']/100))+$s_record['invoice_amount'], 2, '.', '');
										$supplier_credits = number_format(get_total_supplier_credits($s_record['id']),2,".","");
										$balance -=($supplier_amount-$supplier_credits);
										if(($transaction_type=="paid" && ($s_record['status']=="Paid" || $s_record['status']=="PAID")) || $transaction_type=="all"){
									?>
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
                                    <td><?php 
									
									echo "$".number_format($balance, 2, '.', ',');?></td>
                                    </tr>
                                    <?php $count++;?>
                                    <?php }
									}?>
                                <?php }?>
                                <?php if(array_key_exists($project['project_id'],$sales_rec_project)){?>
									<?php foreach($sales_rec_project[$project['project_id']] as $sales_record){
									$balance +=(number_format(($sales_record['invoice_amount']*(15/100))+$sales_record['invoice_amount'], 2, '.', '')-number_format(get_total_sales_credits($sales_record['id']),2,".",""));
									if(($transaction_type=="paid" && ($sales_record['status']=="Paid" || $sales_record['status']=="PAID")) || $transaction_type=="all"){	
									?>
                                    <tr>
                                    <td><?php echo $count;?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                     <td></td>
                                    <td><?php echo $sales_record['notes'];?></td>
                                    <td><?php echo "$".number_format(($sales_record['invoice_amount']*(15/100))+$sales_record['invoice_amount'], 2, '.', ',');?></td>
                                    <td><?php echo "-$".number_format(get_total_sales_credits($sales_record['id']),2,".",",");?></td>
                                    <td><?php echo $sales_record['status'];?></td>
                                    <td><?php 
									
									echo "$".number_format($balance, 2, '.', ',');?></td>
                                    </tr>
                                    <?php $count++;?>
                                    <?php }
									}?>
                                <?php }?>
                            <?php } 
						}
							?>
                        <?php }
						if($is_record_exists==0){?>
                        	<tr>
                            	<td colspan="9">No Records Found</td>
                            </tr>
                        <?php }?>
                    </tbody>
</table>
<?php if($is_record_exists>0){ ?>
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