                                    <?php if ($sinvoice_detail_status == "Pending") { 
                                    ?><span id="<?php echo $order_id;?>" class="label label-danger status_label edit"><?php echo $sinvoice_detail_status;?></span>
                                    <?php } if ($sinvoice_detail_status == "Approved") { ?>
                                    <span id="<?php echo $order_id;?>" class="label label-info status_label edit"><?php echo $sinvoice_detail_status;?></span>
                                    <?php } ?>
                                   
                                                
                                                
                                 </span>
                                <select onchange="update_status(<?php echo $order_id;?>);" class="form-control edit-input <?php if ( $sinvoice_detail_status!="Pending" &&  $sinvoice_detail_status!="Approved" ) echo 'readonlyme' ?>" name="status" id="status_<?php echo $order_id;?>" <?php if ( $sinvoice_detail_status!="Pending" &&   $sinvoice_detail_status!="Approved" ) echo 'style="pointer-events: none;" '. 'readonly'?> required>
                                        <option
                                            <?php echo ($sinvoice_detail_status!='Pending')?  ' disabled ' :  '' ?>

                                            <?php if($sinvoice_detail_status=='Pending')  echo ' selected '?> value="Pending">Pending</option>
                                        <option <?php if($invoice_amount!=$amount_total_entered) echo ' disabled '?>  <?php if($sinvoice_detail_status=='Approved')  echo 'selected'?> class="disableme" value="Approved">Approved</option>
                                        

                                    </select>