<table class="table table-bordered table-striped table-hover print_table" id="project_summary_table">
                    <thead>
                        <tr>
                            <th style="background-color:#495B6C; color:#fff;width:150px;"></th>
                            <th style="background-color:#495B6C; color:#fff;">Date</th>
                            <th style="background-color:#495B6C; color:#fff;">Supplier</th>
                            <th style="background-color:#495B6C; color:#fff;">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php if(count($sales_invoices)>0){ 
                            $i=0;
                            $total_sales_invoices = 0;
                            foreach($sales_invoices as $val){
                            ?>
                            <tr>
                        	    <td><?php if($i==0){ ?> <b>Sales Invoices</b> <?php } ?></td>
                            	<td><?php echo date("d-M-Y", strtotime($val['date_created'])); ?></td>
                            	<td></td>
                            	<td class="text-right">$<?php echo number_format($val['invoice_amount'],2,'.',',');?></td>
                            </tr>
                        	<?php $i++;
                        	$total_sales_invoices += $val['invoice_amount'];
                            } 
                        	?>
                        	<tr>
                        	    <td colspan="3" style="background-color:#495B6C; color:#fff;"><b>Total</b></td>
                            	<td style="background-color:#495B6C; color:#fff;" class="text-right"><b>$<?php echo number_format($total_sales_invoices,2,'.',',');?></b></td>
                            </tr>
                        	<?php
                        	} else { ?>
                            <tr>
                        	    <td><b>Sales Invoices</b></td>
                            	<td colspan="3"><center></center></td>
                            </tr>
                            <tr>
                        	    <td colspan="3" style="background-color:#495B6C; color:#fff;"><b>Total</b></td>
                            	<td class="text-right" style="background-color:#495B6C; color:#fff;"><b>$0.00</b></td>
                            </tr>
                            <?php } ?>
                            <?php if(count($sales_credit_notes)>0){ 
                            $i=0;
                            $total_sales_credit_notes = 0;
                            foreach($sales_credit_notes as $val){
                            ?>
                            <tr>
                        	    <td><?php if($i==0){ ?> <b>Sales Credit Notes</b> <?php } ?></td>
                            	<td><?php echo date("d-M-Y", strtotime($val['date'])); ?></td>
                            	<td><?php echo $val['supplier_name'];?></td>
                            	<td class="text-right">$<?php echo number_format($val['subtotal'],2,'.',',');?></td>
                            </tr>
                        	<?php $i++;
                        	$total_sales_credit_notes += $val['subtotal'];
                        	}
                        	?>
                        	<tr>
                        	    <td colspan="3" style="background-color:#495B6C; color:#fff;"><b>Total</b></td>
                            	<td class="text-right" style="background-color:#495B6C; color:#fff;"><b>$<?php echo number_format($total_sales_credit_notes,2,'.',',');?></b></td>
                            </tr>
                            <?php
                        	} else { ?>
                            <tr>
                        	    <td><b>Sales Credit Notes</b></td>
                            	<td colspan="3"><center></center></td>
                            </tr>
                            <tr>
                        	    <td colspan="3" style="background-color:#495B6C; color:#fff;"><b>Total</b></td>
                            	<td class="text-right" style="background-color:#495B6C; color:#fff;"><b>$0.00</b></td>
                            </tr>
                            <?php } ?>
                            <?php if(count($supplier_invoices)>0){ 
                            $i=0;
                            $total_supplier_invoices = 0;
                            foreach($supplier_invoices as $val){
                            ?>
                            <tr>
                        	    <td><?php if($i==0){ ?> <b>Supplier Invoices</b> <?php } ?></td>
                            	<td><?php 
                            	$invoice_date = str_replace("/", "-", $val['invoice_date']);
                                $invoice_date = date("Y-m-d", strtotime($invoice_date));
                            	echo date("d-M-Y", strtotime($invoice_date)); ?></td>
                            	<td><?php echo $val['supplier_name'];?></td>
                            	<td class="text-right">$<?php echo number_format($val['invoice_amount'],2,'.',',');?></td>
                            </tr>
                        	<?php $i++;
                        	$total_supplier_invoices += $val['invoice_amount'];
                        	} 
                        	?>
                        	<tr>
                        	    <td colspan="3" style="background-color:#495B6C; color:#fff;"><b>Total</b></td>
                            	<td class="text-right" style="background-color:#495B6C; color:#fff;"><b>$<?php echo number_format($total_supplier_invoices,2,'.',',');?></b></td>
                            </tr>
                        	<?php } else { ?>
                            <tr>
                        	    <td><b>Supplier Invoices</b></td>
                            	<td colspan="3"><center></center></td>
                            </tr>
                            <tr>
                        	    <td colspan="3" style="background-color:#495B6C; color:#fff;"><b>Total</b></td>
                            	<td class="text-right" style="background-color:#495B6C; color:#fff;"><b>$0.00</b></td>
                            </tr>
                            <?php } ?>
                            <?php if(count($supplier_credit_notes)>0){ 
                            $i=0;
                            $total_supplier_credit_notes = 0;
                            foreach($supplier_credit_notes as $val){
                            ?>
                            <tr>
                        	    <td><?php if($i==0){ ?> <b>Supplier Credit Notes</b> <?php } ?></td>
                            	<td><?php echo date("d-M-Y", strtotime($val['date'])); ?></td>
                            	<td><?php echo $val['supplier_name'];?></td>
                            	<td class="text-right">$<?php echo number_format($val['subtotal'],2,'.',',');?></td>
                            </tr>
                        	<?php $i++; 
                        	$total_supplier_credit_notes += $val['subtotal'];
                        	} 
                        	?>
                        	<tr>
                        	    <td colspan="3" style="background-color:#495B6C; color:#fff;"><b>Total</b></td>
                            	<td class="text-right" style="background-color:#495B6C; color:#fff;"><b>$<?php echo number_format($total_supplier_credit_notes,2,'.',',');?></b></td>
                            </tr>
                        	<?php }
                        	else { ?>
                            <tr>
                        	    <td><b>Supplier Credit Notes</b></td>
                            	<td colspan="3"><center></center></td>
                            </tr>
                            <tr>
                        	    <td colspan="3" style="background-color:#495B6C; color:#fff;"><b>Total</b></td>
                            	<td class="text-right" style="background-color:#495B6C; color:#fff;"><b>$0.00</b></td>
                            </tr>
                            <?php } ?>
                        
                    </tbody>
                </table>
                <div class="form-footer">
                <?php if(count($supplier_credit_notes)>0 || count($supplier_invoices)>0 || count($sales_credit_notes)>0 || count($sales_invoices)>0){?>
                <input type="submit" id="excel_report_btn" name="excel_report_btn" class="btn btn-success print" value="Export To Excel">
				<input type="submit" id="pdf_report" name="pdf_report" class="btn btn-success print" value="Export To PDF">
				<?php } ?>
				</div>