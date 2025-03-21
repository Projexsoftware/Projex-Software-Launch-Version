<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">search</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Order Filters</h4>
									    <div class="form-group col-md-3">
    				                        <div class="input-group">
                            					<span class="input-group-addon"></span>
                            					<input type="number" name="search_text" id="search_text" placeholder="Search by Order Number" class="form-control" />
                            				</div>
                            				
                        			    </div>
                        			   <div class="form-group col-md-3">
    				                        <div class="input-group">
                            					<span class="input-group-addon"></span>
                            					<input type="text" name="customer" id="customer" placeholder="Search by Customer" class="form-control" />
                            				</div>
                            				
                        			    </div>
                        			    <div class="form-group col-md-3">
    				                        <div class="input-group">
                            					<span class="input-group-addon"></span>
                            					<select id="order_status" name="order_status" required="true" class="selectpicker" data-style="select-with-transition">
                                                <option disabled selected>Order Status</option>
                                              
    									            <option value="1">Pending</option>
    											 <option value="2">Delivered</option>
    											 <option value="3">Completed</option>
    											 <option value="-1">Canceled</option>
                                            </select>
                            				</div>
                            				
                        			    </div>
                        			    
                        			    <div class="form-group col-md-3">
    				                        <div class="input-group">
                            					<span class="input-group-addon"></span>
                            					<select id="status_" name="status_" required="true" class="selectpicker" data-style="select-with-transition">
                                                <option disabled selected>Payment Status</option>
                                              
    											 <option value="1">Paid</option>
    											 <option value="0">Pending</option>
                                            </select>
                            				</div>
                            			
                        			    </div>
                        			    <div class="col-md-12"><a href="<?php echo SURL;?>supplierz/manage_online_store_orders" class="btn btn-default pull-right">Reset</a></div>
									</div>
								</div>
							</div>
									    
									
                            </div>
                            <div class="card">
                                <div class="loader">
                                            <center>
                                                <img class="loading-image" src="<?php echo IMG;?>search.gif" alt="loading.." width="100px">
                                            </center>
                                </div>
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">shopping_cart</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Orders</h4> 
                                    <div class="toolbar">
										<div class="col-md-8"></div>
                                        <div id="tableActions col-md-4"></div>
									</div>
									<?php
										if ($this->session->flashdata('err_message')) {
											?>
											<div class="alert alert-danger">
												<?php echo $this->session->flashdata('err_message'); ?>
											</div>
											<?php
										}

										if ($this->session->flashdata('ok_message')) {
											?>
											<div class="alert alert-success alert-dismissable">
												<?php echo $this->session->flashdata('ok_message'); ?>
											</div>
											<?php
										}
										?>
									
                                    <div id="result">
                                        <div class="material-datatables">
                                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
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
                                    </div>
                                        
                                </div>
                                </div>
                                <!-- end content-->
                            </div>
                            <!--  end card  -->
                        </div>
                        <!-- end col-md-12 -->
                    </div>
                    <!-- end row -->