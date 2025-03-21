<table id="completedJobsSalesInvoices" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Project</th>
                                                                        <th>Sales Invoice Number</th>
                                                                        <th>Sales Invoice Amount</th>
                                                                        <th>Invoice Created By</th>
                                                                        <th>Approved By</th>
                                                                        <!--<th>Exported by</th>-->
                                                                        <th>Amount Outstanding</th>
                                                                        <th>Amount Paid</th>
                                                                        <th>Date Created</th>
                                                                        <th>Invoice Status</th>
                                                                        <th class="disabled-sorting text-right">Actions</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                            						<?php 
                                            						$i=1;
                                                                    foreach($sales_invoices as $sales_invoice) {
                                                                    $invoiceType = check_invoice_type($sales_invoice['id']);
                                                                    ?>
                                                                    <tr class="row_<?php echo $sales_invoice['id'];?>">
                                                                        <td>
                                                                            <?php echo $sales_invoice['project_title'];?>
                                                                        </td>
                                                                        <td><?php echo $invoiceType;?><? if($sales_invoice['invoice_number']>0){ echo $sales_invoice['id']+2000000; } else{ echo $sales_invoice['id']+1000000; } ?></td>
                                                                        <td>$ <?= $sales_invoice['invoice_amount'] ?></td>
                                                                        <td>
                                                                        <?php 
                                                                            if($sales_invoice['created'] )
                                                                                echo $sales_invoice['cuser_fname'] ." ".$sales_invoice['cuser_lname'] ;
                                                                        ?>
                                                                    </td>
                                                                    <td class="approvedStatus<?php echo $sales_invoice['id'];?>">
                                                                        <?php 
                                                                            if(!$sales_invoice['approved'] )
                                                                                echo '<span class="label label-danger">Approval Pending</span>';
                                                                            else{
                                                                                
                                                                                echo '<span class="label label-success">'.$sales_invoice['auser_fname'] ." ".$sales_invoice['auser_lname'].'</span>';
                                                                                
                                                                                /*if(!$sales_invoice['exported'])
                                                                                    echo '<td ><span class="label label-warning">Export Pending</span></td>';
                                                                                else 
                                                                                    echo '<td><span class="label label-success">'.$sales_invoice['euser_fname'] ." ".$sales_invoice['euser_lname'].'</span></td>';
                                                                                */
                                                                                    
                                                                            }
                                                                        ?>
                                                                        </td>
                                                                        
                                <td  

                                <?php 
                                    $credit_notes = get_sales_credit_notes($sales_invoice['id'], $invoiceType);
                                    $credit_notes_total = 0;
                                    foreach($credit_notes as $credit_note_detail){ 
                                        $credit_notes_total +=$credit_note_detail['total'];
                                        
                                    }
                                    $amount_outstanding = number_format($sales_invoice["invoice_amount"],2, '.', '')-number_format($sales_invoice['payed_ammount'],2,'.','');
                                    if($amount_outstanding>0)  echo 'style="color: red"';
                                    else if($amount_outstanding==0) echo 'style="color: green"';
                                    

                                ?>

                                >$ <?php
                                if($invoiceType=="CN-"){
                                echo number_format($amount_outstanding + $credit_notes_total, 2, ".", ""); 
                                }
                                else{
                                     echo number_format($amount_outstanding - $credit_notes_total, 2, ".", "");  
                                }
                                
                                ?></td>
                                <td><?php echo "$".number_format($sales_invoice['payed_ammount']+$credit_notes_total, "2", ".", ",");  ?></td>
                                <td><?php echo date('d/m/Y',strtotime($sales_invoice["date_created"])); ?></td>
                                
                                <td>
                                    <div class="status_container_<?php echo $sales_invoice['id'];?>">
                                    
                                    <?php 
                                    echo '<span id="'.$sales_invoice['id'].'"class="label status_label edit label-';

                                    if ($sales_invoice['status'] == "PENDING") 
                                        echo 'danger';
                                    else if ($sales_invoice['status'] == "APPROVED")
                                        echo 'info';
                                   
                                    else if ($sales_invoice['status']== "PAID")
                                        echo 'success';


                                    echo '">';
                                    echo $sales_invoice['status'];
                                    echo '</span>';
                                    
                                    ?>
                                    <select onchange="update_status(<?php echo $sales_invoice['id'];?>);" class="form-control edit-input " name="status" id="status_<?php echo $sales_invoice['id'];?>" required="">
                            
                                        <option <?= ($sales_invoice['status']!='PENDING')? 'disabled':'' ?> <?= ($sales_invoice['status']=='PENDING')? 'selected':'' ?> value="PENDING">PENDING</option>
                                        <option   <?= ($sales_invoice['status']=='PAID')? 'disabled':'' ?> <?= ($sales_invoice['status']=='APPROVED')? 'selected':'' ?> value="APPROVED">APPROVED</option>
                                        <option  <?= ($sales_invoice['status']=='PENDING')? 'disabled':'' ?> <?= ($sales_invoice['status']=='PAID')? 'selected':'' ?> value="PAID">PAID</option>
                                        
                                    </select>
                                    </div>
                                    
                                </td>
                                                            <td class="text-right">
                                                                <?php if(in_array(31, $this->session->userdata("permissions")) || in_array(33, $this->session->userdata("permissions"))) {?>
                                                                        <a href="<?php echo SURL;?>sales_invoices/viewsalesinvoice/<?php echo $sales_invoice["id"];?>" class="btn btn-simple btn-warning btn-icon edit"><i class="material-icons">edit</i></a>
                                                                <?php } ?>
                                                            </td>
                                                                    </tr>
                                                                    <?php 
                    												$i++;
                    												} ?>
                                                                </tbody>
                                                            </table>
