<table id="sales_invoices_table" class="table table-bordered table-striped table-hover" style="text-align:left;">
                    <thead>
                        <tr>
                            <th>Project</th>
                            <th>Sales Invoice Number</th>
                            <th>Sales Invoice Amount</th>
                            <th>Invoice Created By</th>
                            <th>Approved By</th>
                            <th>Amount Outstanding</th>
                            <th>Amount Paid</th>
                            <th>Invoice Status</th>
                            <th class="disabled-sorting text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody >
                        <?php
                        foreach ($sales_invoices as $p => $po) {  ?>
                            <tr>
                                <td><?= $po['project_title'] ?></td>
                                <td><?= $po['id']+1000000 ?></td>
                                <td class="text-right">$ <?= $po['invoice_amount'] ?></td>
                                <td>
                                    <?php 
                                        if($po['created'] )
                                            echo $po['cuser_fname'] ." ".$po['cuser_lname'] ;
                                    ?>
                                </td>
                                    <?php 
                                        if(!$po['approved'] )
                                            echo '<td><span class="label label-danger">Approval Pending</span></td><td style="display:none"></td>';
                                        else{
                                            
                                            echo '<td><span class="label label-success">'.$po['auser_fname'] ." ".$po['auser_lname'].'</span></td>';
                                        }    
                                    ?>
                                <td class="text-right"  

                                <?php 
                                    $credit_notes = get_sales_credit_notes($po['id']);
                                    $credit_notes_total = 0;
                                    if(count($credit_notes)>0){
                                        foreach($credit_notes as $credit_note_detail){ 
                                            $credit_notes_total +=$credit_note_detail['total'];
                                            
                                        }
                                    }
                        
                                    if($po['outstanding'] - $credit_notes_total>0)  echo 'style="color: red"';
                                    else if($po['outstanding']- $credit_notes_total==0) echo 'style="color: green"';

                                ?>

                                >$ <?php
                                if(count($credit_notes)>0 && $credit_notes[0]['created_by_invoice_id']==$po['id']){
                                    echo number_format($po['outstanding'] + $credit_notes_total, 2, ".", ""); 
                                }
                                else{
                                echo number_format($po['outstanding'] - $credit_notes_total, 2, ".", ""); 
                                }
                                ?></td>
                                <td><?php echo "$".number_format($po['payed_ammount']+ $credit_notes_total, "2", ".", ",") ;?></td>
                                <td>
                                    
                                    <?php 
                                    echo '<span class="label status_label edit label-';

                                    if ($po['status'] == "PENDING") 
                                        echo 'danger';
                                    else if ($po['status'] == "APPROVED")
                                        echo 'info';
                                   
                                    else if ($po['status']== "PAID")
                                        echo 'success';


                                    echo '">';
                                    echo $po['status'];
                                    echo '</span>';
                                    
                                    ?>
                                </td>
                                <td class="text-right">
                                    <a target="_Blank" href="<?php echo base_url().'sales_invoices/viewsalesinvoice/'.$po['id'] ?>" class="btn btn-simple btn-icon btn-warning"><i class="material-icons">edit</i></a>
                                </td>
                            </tr>
                        
                        
                        <?php } ?>
                        

                    </tbody>
                </table>