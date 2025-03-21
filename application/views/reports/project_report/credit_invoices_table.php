<table id="credit_invoices_table" class="table table-bordered table-striped table-hover" style="text-align:left;">
		        		<thead>
                        <tr>
                           <th>Sr No</th>
                            <th>Project Name</th>
                            <th>Supplier Invoice #</th>
                            <th>Supplier Name</th>
                            <th>Supplier Refrence</th>
                            <th>Invoice Amount</th>
                            <th>Invoice Date</th>
                            <th>Invoice Due Date</th>
                            <th>Created Date</th>
                            <th>Status</th>
                            <th class="disabled-sorting text-right">Actions</th>
                        </tr>
                       </thead>
		        		<tbody>
		        		    <?php if(count($credit_invoices)>0){ ?>
		        		    <?php $count = 1;
                        foreach ($credit_invoices as $key => $po) { ?>
                            <tr>
                                <td><?php echo $count; ?></td>
                                <td><?php echo $project_info['project_title']; ?></td>
                                <td><?php echo $po['id']; ?></td>
                                <td><?php echo $po['supplier_name']; ?></td>
                                <td><?php echo $po['supplierrefrence']; ?></td>
                                <td><?php echo number_format($po['invoice_amount'],2,'.',''); ?></td>
                                <td><?php echo date("d-M-Y", strtotime(str_replace("/", "-", $po['invoice_date']))); ?></td>
                                  <td><?php echo date("d-M-Y", strtotime(str_replace("/", "-", $po['invoice_due_date']))); ?></td>
                                <td><?php echo date("d-M-Y", strtotime($po['created_date'])); ?></td>
                                <td>
                                    <?php $amount_total_entered = $po['invoice_amount'] - $po['va_addclient_cost'];?>
                                    <input type="hidden" name="invoice_amount" id="invoice_amount_<?php echo $po['id'];?>" value="<?php echo $po['invoice_amount'];?>">
                                    <input type="hidden" name="amount_total_entered" id="amount_total_entered_<?php echo $po['id'];?>" value="<?php echo $amount_total_entered;?>">
                                    <div class="status_container_<?php echo $po['id'];?>"><?php echo $po['status'];?></span>
                                    <?php if ($po['status'] == "Pending") { 
                                    ?><span class="label label-danger status_label edit"><?php echo $po['status'];?></span>
                                    <?php } if ($po['status'] == "Approved") { 
                                    ?><span class="label label-info status_label edit"><?php echo $po['status'];?></span>
                                    <?php } if ($po['status'] == "Paid") { 
                                    ?><span class="label label-primary status_label edit"><?php echo $po['status'];?></span>
                                    <?php } if ($po['status'] == "Sales Invoiced") { 
                                    ?><span class="label label-success status_label edit"><?php echo $po['status'];?></span>
                                    <?php } ?> 
                                </div>
                                </td>
                                <td class="text-right">
                                    <a target="_blank" class="btn btn-simple btn-icon btn-warning" href="<?php echo SURL . 'supplier_invoices/viewinvoice/' . $po['id'] ?>"><i class="material-icons">edit</i></a>
                                    
                                </td>
                            </tr>
    <?php $count++;
} 
}
?>
		        		   
		        		    
		        		</tbody>
		        		</table>