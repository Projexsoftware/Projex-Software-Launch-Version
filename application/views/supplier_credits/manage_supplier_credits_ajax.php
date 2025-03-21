<table id="completedJobsSupplierCredits" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Supplier Credit #</th>
                                                                        <th>Project Name</th>
                                                                        <th>Supplier Name</th>
                                                                        <th>Supplier Credit Refrence</th>
                                                                        <th>Credit Amount</th>
                                                                        <th>Credit Date</th>
                                                                        <th>Created Date</th>
                                                                        <th>Status</th>
                                                                        <th class="disabled-sorting text-right">Actions</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                            						<?php 
                                            						$i=1;
                                                                    foreach($supplier_credits as $supplier_credit) {?>
                                                                    <tr class="row_<?php echo $supplier_credit['id'];?>">
                                                                        <td><?php echo $i;?></td>
                                                                        <td>
                                                                            <?php echo $supplier_invoice['id']; ?> <?php if($supplier_invoice['invoice_type']=="timesheet"){
                                                                                    echo '<i style="color:#777;" title="From Timesheet" class="fa fa-clock fa-lg"></i>';
                                                                            }?>
                                                                        </td>
                                                                        <td><?php echo $supplier_credit['project_title']; ?></td>
                                                                        <td><?php echo $supplier_credit['supplier_name']; ?></td>
                                                                        <td><?php echo $supplier_credit['supplierrefrence']; ?></td>
                                                                        <td><?php echo "$".number_format($supplier_credit['invoice_amount'],2,'.',''); ?></td>
                                                                        <td><?php echo date('d/m/Y', strtotime($supplier_invoice['invoice_date'])); ?></td>
                                                                        <td><?php echo date('d/m/Y',strtotime($supplier_invoice["created_date"])); ?></td>
                                                            <td>
                                                                <?php $amount_total_entered = $supplier_credit['invoice_amount'] - $supplier_credit['va_addclient_cost'];?>
                                                                <input type="hidden" name="invoice_amount" id="invoice_amount_<?php echo $supplier_credit['id'];?>" value="<?php echo $supplier_credit['invoice_amount'];?>">
                                                                <input type="hidden" name="amount_total_entered" id="amount_total_entered_<?php echo $supplier_credit['id'];?>" value="<?php echo $amount_total_entered;?>">
                                                                <div class="status_container_<?php echo $supplier_credit['id'];?>">
                                                                <?php if ($supplier_credit['status'] == "Pending") { 
                                                                ?><span id="<?php echo $supplier_credit['id'];?>" class="label label-danger status_label edit"><?php echo $supplier_credit['status'];?></span>
                                                                <?php } if ($supplier_credit['status'] == "Approved") { 
                                                                ?><span id="<?php echo $supplier_credit['id'];?>" class="label label-info status_label edit"><?php echo $supplier_credit['status'];?></span>
                                                                <?php } ?>  
                                                                
                                                                <select onchange="update_status(<?php echo $supplier_credit['id'];?>);" class="form-control edit-input <?php if ( $supplier_credit['status']!="Pending" &&  $supplier_credit['status']!="Approved" ) echo 'readonlyme' ?>" name="status" id="status_<?php echo $supplier_credit['id'];?>" <?php if ( $supplier_credit['status']!="Pending" &&  $supplier_credit['status']!="Approved" ) echo 'style="pointer-events: none;" '. 'readonly'?> required>
                                                                <option
                                                                    <?php echo ($supplier_credit['status']!='Pending')?  ' disabled ' :  '' ?>
                        
                                                                    <?php if($supplier_credit['status']=='Pending')  echo ' selected '?> value="Pending">Pending</option>
                                                                 <option<?php if($supplier_credit['status']=='Approved')  echo ' selected '?> value="Approved">Approved</option>
                                                                 </select>
                                   
                                                                
                                                            </div>
                                                            </td>
                                                            <td class="text-right">
                                                                <?php if(in_array(25, $this->session->userdata("permissions")) || in_array(27, $this->session->userdata("permissions"))) {?>
                                                                        <a href="<?php echo SURL;?>supplier_credits/viewcredit/<?php echo $supplier_credit["id"];?>" class="btn btn-simple btn-warning btn-icon edit"><i class="material-icons">edit</i></a>
                                                                <?php } ?>
                                                            </td>
                                                                    </tr>
                                                                    <?php 
                    												$i++;
                    												} ?>
                                                                </tbody>
                                                            </table>
