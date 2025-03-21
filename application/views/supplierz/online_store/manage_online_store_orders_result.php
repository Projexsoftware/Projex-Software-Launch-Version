<div class="material-datatables">
                                        <table id="datatables_result" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Order #</th>
                                                    <th>Date</th>
                                                    <th>Customer</th>
                                                    <th>Order Status</th>
                                                    <th>Payment Status</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                    					 	<?php 
                    						    $i=1;
                    						    
                                                foreach($orders As $key=>$val) { ?>
                                                <tr class="row_<?php echo $val['id'];?>">
                                                    <td><a href="<?php echo SURL;?>supplierz/order_details/<?php echo $val['order_no'];?>"><?php echo "#".$val['order_no'];?></a></td>
                                                    <td><?php echo date("d-M-Y", strtotime($val['order_received_date']));?></td>
                                                    <td><?php echo $val['first_name']." ".$val['last_name']." (".$val['company_name'].")";?></td>
                                                    <td class="status<?php echo $val['id'];?>"><?php if($val['status']==1){ echo "<span class='label label-warning'>Pending</span>"; }
                                                       else if($val['status']==2){ echo "<span class='label label-success'>Delivered</span>"; } else if($val['status']==3){ echo "<span class='label label-success'>Completed</span>"; } else{ echo "<span class='label label-danger'>Canceled</span>"; }?></td>
                                                    <td class="payment_status<?php echo $val['id'];?>"><?php echo ($val['payment_status']==0?"<span class='label label-warning'>Pending</span>":"<span class='label label-success'>Paid</span>");?></td>
                                                    <td><?php echo CURRENCY.get_supplierz_item_total($val['order_no']);?></td>
                                                </tr>
                                                <?php 
												
												} ?>
                                            </tbody>
                                        </table>