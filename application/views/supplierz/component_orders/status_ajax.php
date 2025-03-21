<select onchange="update_status(<?php echo $order_id;?>);" <?php if ($order_status == "2"  ) {
                                            echo "style='pointer-events: none;'";
                                        } ?> data-style="select-with-transition" class="form-control edit-input" name="status" id="status_<?php echo $order_id;?>">
                                        
                                        <option <?php
                                        if ($order_status == "1") {
                                            echo "selected";
                                        } 
                                        else {
                                            echo "disabled";
                                        } 
                                        ?> value="1" >Order Received</option>
                                        
                                        <option <?php
                                        if ($order_status == "2") {
                                            echo "selected";
                                        } 
                                        
                                        ?> value="2" >Order Delivered</option>
                                        
                                        </select>
                                        <?php if($order_status == 1){
									   echo '<span id="'.$order_id.'" class="label label-success status_label edit">Order Received</span>';   
									  } else if($order_status == 2){
									   echo '<span id="'.$order_id.'" class="label label-success status_label edit">Order Delivered</span>'; 
									   
									   
									  }
									  ?>