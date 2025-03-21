                                                            <?php 
                                            						$i=1;
                                                                    foreach($purchase_orders as $po) {?>
                                                                    <tr class="row_<?php echo $po["id"];?>">
                                                                        <td><?php echo $i;?></td>
                                                                        <td><?php echo get_project_name($po["project_id"]); ?></td>
                                                                        <td><?php echo $po['id']; ?></td>
                                                                         <td><?php if($po['supplier_id'] == 0){ echo get_po_suppliers_name($po['id']); } else { echo $po['supplier_name']; }?></td>
                                                                        
                                                                        <td><?php echo date('d/m/Y',strtotime($po["created_date"])); ?></td>
                                                                        <td>
                                                                            <input type="hidden" id="supplier_invoice_id_<?php echo $po['id'];?>" value="<?php echo $po['supplier_invoice_id'];?>">
                                                                            <div class="status_container_<?php echo $po['id'];?>">
                                                                             <select onchange="update_status(<?php echo $po['id'];?>);" 
                                                                             <?php if ($po['order_status'] == "Cancelled"  ) {
                                                                                    echo "style='pointer-events: none;'";
                                                                                } ?> class="form-control edit-input" name="status" id="status_<?php echo $po['id'];?>">
                                                                                
                                                                                <option <?php
                                                                                if ($po['order_status'] == "Cancelled") {
                                                                                    echo "selected";
                                                                                }
                                                                                ?> value="Cancelled ">Cancelled</option>
                                                                                <option 
                                                                                    <?php if ($po['order_status'] != "Pending") {
                                                                                    echo "disabled";
                                                                                } ?>
                                                                                    <?php
                                                                                if ($po['order_status'] == "Pending") {
                                                                                    echo "selected";
                                                                                }                                       
                                                                                ?>  value="Pending" >Pending</option>
                                                                                <option <?php
                                                                                if ($po['order_status'] == "Approved") {
                                                                                    echo "selected";
                                                                                }                                        
                                                                                ?> value="Approved" >Approved</option>
                                                                                <option <?php
                                                                                if ($po['order_status'] == "Issued") {
                                                                                    echo "selected";
                                                                                }
                                                                                ?> value="Issued" >Issued</option>
                                                                            </select>
                                                                            <br/>
                                                                            <?php 
                                                                            if ( $po['order_status'] == "Cancelled" ) { ?>
                                                                                <span class="label label-danger status_label edit"><?php echo $po['order_status'] ?></span><?php } 
                                                                            else if ($po['order_status'] == "Pending" ) { ?>
                                                                                <span class="label label-warning status_label edit"><?php echo $po['order_status'] ?></span><?php }    
                                                                            else if ($po['order_status'] == "Approved" ) { ?>
                                                                                <span class="label label-success status_label edit"><?php echo $po['order_status'] ?></span><?php }     
                                                                            else if ($po['order_status'] == "Issued") {?>
                                                                                <span class="label label-success status_label edit"><?php echo $po['order_status'] ?></span><?php } ?>
                                                                            <?php if ($po['supplier_invoice_id'] !=0) { 
                                                                            ?>&nbsp;<span class="label label-primary status_label eidt"><?php echo 'From Supplier Invoice'; ?></span>
                                                                            <?php } ?> 
                                                                            </div>
                                                                            <br/>
                                        								</td>
                                                                        <td class="text-right" >
                                                                            <?php if(in_array(12, $this->session->userdata("permissions")) || in_array(14, $this->session->userdata("permissions"))) {?>
                                                                           <a href="<?php echo SURL;?>purchase_orders/pporder/<?php echo $po["id"];?>" class="btn btn-simple btn-warning btn-icon edit"><i class="material-icons">edit</i></a>
                                                                           <?php } ?>
                                                                        </td>
                    
                                                                    </tr>
                                                                    <?php 
                    												$i++;
                    										} ?>