<table id="completedJobsSupplierInvoices" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Supplier Invoice #</th>
                                                                        <th>Project Name</th>
                                                                        <th>Supplier Name</th>
                                                                        <th>Supplier Refrence</th>
                                                                        <th>Invoice Amount</th>
                                                                        <th>Amount Paid/Allocated</th>
                                                                        <th>Outstanding Amount</th>
                                                                        <th>Invoice Date</th>
                                                                        <th>Invoice Due Date</th>
                                                                        <th>Created Date</th>
                                                                        <th>Status</th>
                                                                        <th class="disabled-sorting text-right">Actions</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                            						<?php 
                                            						$i=1;
                                                                    foreach($supplier_invoices as $supplier_invoice) {
                                                                    $invoice_amount = ($supplier_invoice['invoice_amount']+(15/100)*$supplier_invoice['invoice_amount']);
                                                                    $amount_paid = 0;
                                                                    if($supplier_invoice['typeOfInvoice']==0){
                                                                       $credit_notes = get_supplier_credit_notes($supplier_invoice['id']);
                                                                    }else{
                                                                       $credit_notes = get_allocate_supplier_credit_notes($supplier_invoice['id']);
                                                                    }
                                                                    if(count($credit_notes)>0){
                                                                        foreach($credit_notes as $credit_note_detail){
                                                                            $amount_paid +=$credit_note_detail['amount'];
                                                                        }
                                                                    }
                                                                    
                                                                    if($supplier_invoice['typeOfInvoice']==0){
                                                                    
                                                                    $invoice_payments = get_supplier_invoice_payments($supplier_invoice['id']);
                
                                                                        if(count($invoice_payments)>0){
                                                                            foreach($invoice_payments as $invoice_payment){
                                                                                $amount_paid +=$invoice_payment['payment'];
                                                                            }
                                                                        }
                                                                    }
                                                                    
                                                                    ?>
                                                                    <tr class="row_<?php echo $supplier_invoice['id'];?>">
                                                                        <td><?php echo $i;?></td>
                                                                        <td>
                                                                            <?php if($supplier_invoice['typeOfInvoice']==0){ echo $supplier_invoice['id']; ?> 
                                                                            <?php if($supplier_invoice['invoice_type'] == "timesheet"){
                                                                                    echo '<i class="material-icons timesheet-icon" title="From Timesheet">schedule</i>';
                                                                            } } else{ 
                                                                                echo "CR-".$supplier_invoice['supplierrefrence']."-".$supplier_invoice['id'];
                                                                             } ?>
                                                                        </td>
                                                                        <td><?php echo get_project_name(get_project_id_from_costing_id($supplier_invoice['project_id'])); ?></td>
                                                                        <td><?php echo get_supplier_invoice_name($supplier_invoice['id']); ?></td>
                                                                        <td><?php echo $supplier_invoice['supplierrefrence']; ?></td>
                                                                        <td><?php echo '$'.number_format($invoice_amount,2,'.',''); ?></td>
                                                                        <td><?php echo '$'.number_format($amount_paid,2,'.',''); ?></td>
                                                                        <td <?php if(($invoice_amount-$amount_paid)>0){ ?> style="color:red;" <?php } ?> ><?php echo '$'.number_format($invoice_amount-$amount_paid,2,'.',''); ?></td>
                                                                        <td><?php echo $supplier_invoice['invoice_date']; ?></td>
                                                                        <td><?php echo $supplier_invoice['invoice_due_date']; ?></td>
                                                                        <td><?php echo date('d/m/Y',strtotime($supplier_invoice["created_date"])); ?></td>
                                                            <td>
                                                                <?php $amount_total_entered = $supplier_invoice['invoice_amount'] - $supplier_invoice['va_addclient_cost'];?>
                                                                <input type="hidden" name="invoice_amount" id="invoice_amount_<?php echo $supplier_invoice['id'];?>" value="<?php echo $supplier_invoice['invoice_amount'];?>">
                                                                <input type="hidden" name="amount_total_entered" id="amount_total_entered_<?php echo $supplier_invoice['id'];?>" value="<?php echo $amount_total_entered;?>">
                                                                <div class="status_container_<?php echo $supplier_invoice['id'];?>">
                                                                <?php if ($supplier_invoice['status'] == "Pending") { 
                                                                ?><span id="<?php echo $supplier_invoice['id'];?>" class="label label-danger status_label edit">
                                                                <?php } if ($supplier_invoice['status'] == "Approved") { 
                                                                ?><span id="<?php echo $supplier_invoice['id'];?>" class="label label-info status_label edit">
                                                                <?php } if ($supplier_invoice['status'] == "Paid") { 
                                                                ?><span id="<?php echo $supplier_invoice['id'];?>" class="label label-primary status_label edit">
                                                                <?php } if ($supplier_invoice['status'] == "Sales Invoiced") { 
                                                                ?><span id="<?php echo $supplier_invoice['id'];?>" class="label label-success status_label edit">
                                                                <?php }       
                                                                echo $supplier_invoice['status'];
                                                                ?> </span>
                                                                <select onchange="update_status(<?php echo $supplier_invoice['id'];?>);" data-style="select-with-transition" class="form-control edit-input <?php if ( $supplier_invoice['status']!="Pending" &&  $supplier_invoice['status']!="Approved" ) echo 'readonlyme' ?>" name="status" id="status_<?php echo $supplier_invoice['id'];?>" <?php if ( $supplier_invoice['status']!="Pending" &&  $supplier_invoice['status']!="Approved" ) echo 'style="pointer-events: none;" '. 'readonly'?> required>
                                                                    
                                                                    <option
                                                                        <?php echo ($supplier_invoice['status']!='Pending')?  ' disabled ' :  '' ?>
                            
                                                                        <?php if($supplier_invoice['status']=='Pending')  echo ' selected '?> value="Pending">Pending</option>
                                                                    <?php
                                                                      if(in_array(22, $this->session->userdata("permissions"))) {
                                                                    ?><option <?php if($supplier_invoice['invoice_amount']!=$amount_total_entered) echo ' disabled '?>  <?php if($supplier_invoice['status']=='Approved')  echo 'selected'?> class="disableme" value="Approved">Approved</option>
                                                                        <?php } ?>
                                                                    <option
                            
                                                                        <?php echo ($supplier_invoice['status']=='Pending')?  'disabled' :  '' ?>
                            
                                                                        <?php if($supplier_invoice['status']=='Paid')  echo 'selected'?> value="Paid" disabled>Paid</option>
                                                                    <option disabled <?php if($supplier_invoice['status']=='Sales Invoiced')  echo 'selected'?> value="Sales Invoiced">Sales Invoiced</option>
                            
                                                                </select>
                                                                
                                                            </div>
                                                            </td>
                                                            <td class="text-right">
                                                                <?php if($supplier_invoice['typeOfInvoice']==0){ if(in_array(19, $this->session->userdata("permissions")) || in_array(21, $this->session->userdata("permissions"))) {?>
                                                                        <a href="<?php echo SURL;?>supplier_invoices/viewinvoice/<?php echo $supplier_invoice["id"];?>" class="btn btn-simple btn-warning btn-icon edit"><i class="material-icons">edit</i></a>
                                                                <?php } } else{ ?>
                                                                    <?php if(in_array(25, $this->session->userdata("permissions")) || in_array(27, $this->session->userdata("permissions"))) {?>
                                                                        <a href="<?php echo SURL;?>supplier_credits/viewcredit/<?php echo $supplier_invoice["id"];?>" class="btn btn-simple btn-warning btn-icon edit"><i class="material-icons">edit</i></a>
                                                   
                                                                <?php } } ?>
                                                            </td>
                                                                    </tr>
                                                                    <?php 
                    												$i++;
                    												} ?>
                                                                </tbody>
                                                            </table>
