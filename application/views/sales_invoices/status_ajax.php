                                    <?php 
                                    echo '<span id="'.$order_id.'" class="label status_label edit label-';

                                    if ($order_status == "PENDING") 
                                        echo 'danger';
                                    else if ($order_status == "APPROVED")
                                        echo 'info';
                                    
                                    else if ($order_status== "PAID")
                                        echo 'success';


                                    echo '">';
                                    echo $order_status;
                                    echo '</span>';
                                    
                                    ?>
                                    <select onchange="update_status(<?php echo $order_id;?>);" class="form-control edit-input " name="status" id="status_<?php echo $order_id;?>" required="">
                            
                                        <option <?= ($order_status!='PENDING')? 'disabled':'' ?> <?= ($order_status=='PENDING')? 'selected':'' ?> value="PENDING">PENDING</option>
                                        <option  <?= ($order_status=='APPROVED')? 'selected':'' ?> value="APPROVED">APPROVED</option>
                                        <option <?= ($order_status=='PAID')? 'selected':'' ?> value="PAID" disabled>PAID</option>
                                        
                                    </select>