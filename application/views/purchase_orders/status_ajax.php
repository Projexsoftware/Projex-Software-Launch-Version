                                <select onchange="update_status(<?php echo $order_id;?>);" 
                                     <?php if ($order_status == "Cancelled"  ) {
                                            echo "style='pointer-events: none;'";
                                        } ?> class="form-control edit-input" name="status" id="status_<?php echo $order_id;?>">
                                        
                                        <option <?php
                                        if ($order_status == "Cancelled") {
                                            echo "selected";
                                        }
                                        ?> value="Cancelled ">Cancelled</option>
                                        <option 
                                            <?php if ($order_status != "Pending") {
                                            echo "disabled";
                                        } ?>
                                            <?php
                                        if ($order_status == "Pending") {
                                            echo "selected";
                                        }                                       
                                        ?>  value="Pending" >Pending</option>
                                        <option <?php
                                        if ($order_status == "Approved") {
                                            echo "selected";
                                        }                                        
                                        ?> value="Approved" >Approved</option>
                                        <option <?php
                                        if ($order_status == "Issued") {
                                            echo "selected";
                                        }
                                        ?> value="Issued" >Issued</option>
                                    </select>
                                    <br/>
                                    <?php 
                                    if ( $order_status == "Cancelled" ) { ?>
                                        <span class="label label-danger status_label edit"><?php echo $order_status ?></span><?php } 
                                    else if ($order_status == "Pending" ) { ?>
                                        <span class="label label-warning status_label edit"><?php echo $order_status ?></span><?php }    
                                    else if ($order_status == "Approved" ) { ?>
                                        <span class="label label-success status_label edit"><?php echo $order_status ?></span><?php }     
                                    else if ($order_status == "Issued") {?>
                                        <span class="label label-success status_label edit"><?php echo $order_status ?></span><?php } ?>
                                    <?php if ($supplier_invoice_id !=0) { 
                                    ?>&nbsp;<span class="label label-primary status_label eidt"><?php echo 'From Supplier Invoice'; ?></span>
                                    <?php } ?> 