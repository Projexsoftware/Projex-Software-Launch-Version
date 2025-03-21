<div class="row" id="content">
                <div class="col-md-8">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">shopping_cart</i>
                                </div>
                        <div class="card-content">
                        <div class="panel-group" id="product" role="tablist" aria-multiselectable="true">
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingProduct">
                                                <a class="" role="button" data-toggle="collapse" data-parent="#product" href="#productDescription" aria-controls="productDescription" aria-expanded="true">
                                                    <h4 class="panel-title text-red">
                                                      Order's Item Details
                                                      <i class="material-icons">keyboard_arrow_down</i>
                                                    </h4>
                                                </a>
                                            </div>
                                            <div id="productDescription" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingProduct">
                                                <div class="panel-body project_team_container">
                                                    <div class="material-datatables">
                                                           <table id="datatables_order" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%">

                                                                <thead>
                                                                    <tr>
                                                                    <th>Item Image</th>
                                                                    <th>Item Name</th>
                                                                    <th style="text-align:right">Unit Price</th>
                                                                    <th>Quantity</th>
                                                                    <th style="text-align:right">Total Price</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                        
                                                                <?php $i = 1; $subtotal = 0; ?>
                                                                <?php foreach ($items as $val): 
                                                                   $subtotal +=$val['item_subtotal'];
                                                                ?>
                                                                    <tr>
                                                                       
                                                                        <td>
                                                                            <div class="imglist">
                                                                                
                                                                                <a href="<?php echo ASSETS.'online_store_orders/'.$val['item_image'];?>" data-fancybox >
                                                                                    <img src="<?php echo ASSETS.'online_store_orders/'.$val['item_image'];?>" class="custom_item_img" width="30px" height="30px">
                                                                                </a>
                                                                            </div>    
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $val['item_name']; ?>
                                                                        </td>
                                                                        <td style="text-align:right"><?php echo $val['item_price']; ?></td>
                                                                        <td><?php echo $val['item_quantity'];?></td>
                                                                        <td style="text-align:right"><?php echo CURRENCY.$this->cart->format_number($val['item_price']*$val['item_quantity']); ?></td>
                                                                       
                                                                    </tr>
                        
                                                                    <?php 
                                                                    
                                                                    $i++; ?>
                        
                                                                <?php endforeach; ?>
                                                                
                                                                <tr>
                                                                    <td colspan="3"> </td>
                                                                    <td><strong>Sub Total</strong></td>
                                                                    <td class="right" style="text-align:right"><?php echo CURRENCY.$this->cart->format_number($subtotal); ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="3"> </td>
                                                                    <td><strong>Total</strong></td>
                                                                    <td class="right" style="text-align:right"><?php echo CURRENCY.$this->cart->format_number($subtotal); ?></td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                
                                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                        
							</div>
						</div>
                            <!--  end card  -->
                            <?php /*if(isset($price['promo_code']) && ($price['promo_code']!="NA")){ ?>
                          <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">money_off</i>
                                </div>
                        <div class="card-content">
                        <div class="panel-group" id="discount" role="tablist" aria-multiselectable="true">
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingDiscount">
                                                <a class="" role="button" data-toggle="collapse" data-parent="#discount" href="#discount_description" aria-controls="discount_description" aria-expanded="true">
                                                    <h4 class="panel-title text-red">
                                                      Discount Details
                                                      <i class="material-icons">keyboard_arrow_down</i>
                                                    </h4>
                                                </a>
                                            </div>
                                            <div id="discount_description" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingDiscount">
                                                <div class="panel-body project_team_container">
                                                    <div class="material-datatables">
                                                <table id="datatables_payment" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%">

                                                                <thead>
                                                                    <tr>
                                                                    <th>Code</th>
                                                                    <th>Discount</th>
                                                                </tr>
                                                                </thead>
                                                                <?php if($price){?>
                                                                <tbody>
                                                                    <tr>
                                                                    
                                                                    <td><?= $price['promo_code'] ?></td>
                                                                    <?php if($price['promo_type'] == '%'){?>
                                                                    <td><?= $price['promo_value']; ?><?= $price['promo_type']; ?></td>
                                                                    <?php } else {?>
                                                                    <td><?= $price['promo_type']; ?><?= $price['promo_value']; ?></td>
                                                                    <?php }?>
                                                                </tr>
                                                                </tbody>
                                                                <?php  }?>
                                                            </table>
                                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                        
							</div>
						</div>
						<?php }*/?>
						<div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">monetization_on</i>
                                </div>
                        <div class="card-content">
                        <div class="panel-group" id="payment" role="tablist" aria-multiselectable="true">
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingPayment">
                                                <a class="" role="button" data-toggle="collapse" data-parent="#payment" href="#paymentDescription" aria-controls="paymentDescription" aria-expanded="true">
                                                    <h4 class="panel-title text-red">
                                                      Payment Details
                                                      <i class="material-icons">keyboard_arrow_down</i>
                                                    </h4>
                                                </a>
                                            </div>
                                            <div id="paymentDescription" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingPayment">
                                                <div class="panel-body project_team_container">
                                                    <div class="material-datatables">
                                                <table id="datatables_payment" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%">

                                                                <thead>
                                                                    <tr>
                                                                    <th>Payment Type</th>
                                                                    <th>Transaction Id</th>
                                                                    <th>Gross Payment</th>
                                                                    <th>Payer Email</th>
                                                                    <th>Status</th>
                                                                </tr>
                                                                </thead>
                                                                <?php if($payment){?>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <?php if($payment['payment_type']=="cash"){ echo "Cash On Delivery"; } else if($payment['payment_type']=="stripe"){ echo "Stripe";  } else{ echo "Paypal"; } ?>
                                                                        </td>
                                                                        <td class="minimize_text">
                                                                            <?= $payment['txn_id'];?>
                                                                        </td>
                                                                        <td>
                                                                            <?= CURRENCY.$payment['payment_gross'];?>
                                                                        </td>
                                                                        <td>
                                                                            <?= $payment['payer_email'];?>
                                                                        </td>
                                                                        <td>
                                                                           <?= $payment['payment_status'];?>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                                <?php  }?>
                                                            </table>
                                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                        
							</div>
						</div>
                        </div>
                        <!-- end col-md-12 -->
                        
                        <div class="col-md-12 timeline-section">
						 <div class="card">
						    <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">timeline</i>
                            </div>
						    <h3>Timeline</h3>
                                   
                                                    <ul class="timeline timeline-simple">
                                                            <?php if(count($notifications)>0){
                                                            foreach($notifications as $val){
                                                                $date = explode(" ", $val['created_date']);
                                                                $current_date = date("d-M-Y");
                                                                $notification_detail = get_notification_details($date[0], $val['order_no']);
            
                                        ?>
                                                          
                                <li class="time-label">
                                    <div class="label label-danger">
                                        <i class="fa fa-calendar"></i> <?php if($current_date != date("d-M-Y", strtotime($val['created_date']))){ echo date("d-M-Y", strtotime($val['created_date']));} else{
                                        echo "Today";}?>
                                    </div>
                                </li>
                                <?php 
            foreach($notification_detail as $val){
            if($val['notification_type']==1){ ?>
            <li class="timeline-inverted">
                <div class="timeline-badge info">
                                        <i class="material-icons">email</i>
                 </div>
                <div class="timeline-panel">
                        <span class="label label-info"><i class="fa fa-clock-o"></i> <?php echo date("h:i a", strtotime($val['created_date']));?></span>
                        <h4 class="timeline-header no-border"><?php echo $val['notification'];?> <?php echo $items[0]['first_name']." ".$items[0]['last_name'];?>.</h4>
                </div>
            </li>
           <?php } 
          else if($val['notification_type']==0){ ?>
            <li class="timeline-inverted">
                <div class="timeline-badge warning">
                                        <i class="material-icons">shopping_cart</i>
                 </div>
                <div class="timeline-panel">
                        <span class="label label-warning"><i class="fa fa-clock-o"></i> <?php echo date("h:i a", strtotime($val['created_date']));?></span>
                        <h4 class="timeline-header no-border"><?php echo $items[0]['first_name']." ".$items[0]['last_name'];?> <?php echo $val['notification'];?></h4>
                                        
                </div>
            </li>
           <?php }
          else if($val['notification_type']==3){ ?>
          
          <li class="timeline-inverted">
                <div class="timeline-badge success">
                   <i class="material-icons">payment</i>
                 </div>
                <div class="timeline-panel">
                    <span class="label label-success"><i class="fa fa-clock-o"></i> <?php echo date("h:i a", strtotime($val['created_date']));?></span>
                    <h4 class="timeline-header no-border"><?php echo $val['notification'];?></h4>
                </div>
            </li>
           <?php }
           else if($val['notification_type']==4){ ?>
          
          <li class="timeline-inverted">
                <div class="timeline-badge purple">
                   <i class="material-icons">directions_car</i>
                 </div>
                <div class="timeline-panel">
                    <span class="label label-primary"><i class="fa fa-clock-o"></i> <?php echo date("h:i a", strtotime($val['created_date']));?></span>
                    <h4 class="timeline-header no-border"><?php echo $val['notification'];?></h4>
                </div>
            </li>
           <?php }
           else if($val['notification_type']==5){ ?>
          
          <li class="timeline-inverted">
                <div class="timeline-badge success">
                   <i class="material-icons">done</i>
                 </div>
                <div class="timeline-panel">
                    <span class="label label-success"><i class="fa fa-clock-o"></i> <?php echo date("h:i a", strtotime($val['created_date']));?></span>
                    <h4 class="timeline-header no-border"><?php echo $val['notification'];?></h4>
                </div>
            </li>
           <?php }
          else{ ?>
          
          <li class="timeline-inverted">
                <div class="timeline-badge danger">
                    <i class="material-icons">cancel</i>
                 </div>
                <div class="timeline-panel">
                        <span class="label label-danger"><i class="fa fa-clock-o"></i> <?php echo date("h:i a", strtotime($val['created_date']));?></span>

                <h4 class="timeline-header no-border"><?php echo $val['notification'];?></h4>
                </div>
            </li>
            <?php } } ?>
                                                                						 


                                                            <?php } }?>
                            </ul>
                   </div>
    </div>
				</div>
				<div class="col-md-4">
						
                        <!-- Order Info Section -->
                        
                        <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">history</i>
                            </div>
                        <div class="card-content">
                        <div class="panel-group" id="order_info" role="tablist" aria-multiselectable="true">
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingOrder">
                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#order_info" href="#orderDescription" aria-controls="brandDescription" aria-expanded="true">
                                                    <h4 class="panel-title">
                                                        Order Details
                                                        <i class="material-icons">keyboard_arrow_down</i>
                                                    </h4>
                                                </a>
                                            </div>
                                            <div id="orderDescription" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOrder">
                                                <div class="panel-body">
                                                 	   <!--<h4 class="pull-right"><a href="" class="print_btn" onclick="printDiv();"><i class="fa fa-print"></i> Print Order</a></h4>
                                                       <br/><br/>-->
                                                       <div class="table-responsive">
                                                            <table class="customer_info">
                                                                <?php if($items){?>
                                                                <tbody>
                                                                    <tr>
                                                                    <td><h4 class="card-title">Order No</h4>
                                                                    <?php echo "#".$items[0]['order_no'];?>
                                                                    </td>
                                                                    </tr>
                                                                    <tr>  
                                                                    <td><br><h4 class="card-title">Order Status</h4>
                                                                    <?php if($items[0]['status']==1){ echo "<span class='label label-warning'>Pending</span>"; }
                                                       else if($items[0]['status']==2){ echo "<span class='label label-success'>Delivered</span>"; } else if($items[0]['status']==3){ echo "<span class='label label-success'>Completed</span>"; } else{ echo "<span class='label label-danger'>Canceled</span>"; }?>
                                                                    </td>
                                                                    </tr>
                                                                    <tr>  
                                                                    <td><br><h4 class="card-title">Payment Status</h4>
                                                                    <?php echo ($items[0]['payment_status']==0?"<span class='label label-warning'>Pending</span>":"<span class='label label-success'>Paid</span>");?>
                                                                    </td>
                                                                    </tr>
                                                                    <tr>  
                                                                    <td><br><h4 class="card-title">Order Receive Date</h4>
                                                                    <i class="fa fa-calendar"></i> <?php echo ' '.date("d-M-Y",strtotime($items[0]['order_received_date'])); ?>
                                                                    </td>
                                                                    </tr>
                                                                </tbody>
                                                                <? }?>
                                                            </table>
                                                        </div>
                                                        <!-- End Of table responsive -->
                                                </div>
                                                <!-- End Of panel body -->
                                            </div>
                                            <!-- End Of brand description -->
                                        </div>
                                </div>
                                
							</div>
						</div>
						</div>
						<!-- End Of Order Info Section -->
                        <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">person</i>
                            </div>
                        <div class="card-content">
                        <div class="panel-group" id="brand" role="tablist" aria-multiselectable="true">
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingBrand">
                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#brand" href="#brandDescription" aria-controls="brandDescription" aria-expanded="true">
                                                    <h4 class="panel-title">
                                                        Customer Details
                                                        <i class="material-icons">keyboard_arrow_down</i>
                                                    </h4>
                                                </a>
                                            </div>
                                            <div id="brandDescription" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingBrand">
                                                <div class="panel-body">
                                                 	
                                                       <div class="table-responsive">
                                                            <table class="customer_info">
                                                                <?php if($items){?>
                                                                <tbody>
                                                                    
                                                                    <tr>
                                                                        
                                                                        <td>
                                                                            <div class="round-photo imglist">
                                                                                <?php if(get_user_image($items[0]['user_id'])!=""){ ?>
                                                                                <a href="<?php echo ASSETS.'profile_images/'.get_user_image($items[0]['user_id']);?>" data-fancybox >
                                                                                    <img class="" src="<?php echo ASSETS.'profile_images/'.get_user_image($items[0]['user_id']);?>" alt="...">
                                                                                </a>
                                                                                <?php } else{ ?>
                                                                                <a href="<?php echo ASSETS.'profile_images/project_avatar.png';?>" data-fancybox >
                                                                                    <img class="" src="<?php echo ASSETS.'profile_images/project_avatar.png';?>" alt="...">
                                                                                </a>
                                                                                <?php } ?>
                                                                              
                                                                           </div>
                                                                           <h4 class="card-title photo-title"><?php echo $items[0]['first_name']." ".$items[0]['last_name'];?></h4>
                    													   
												                        </td>
                                                                    </tr>
                                                                    
                                                                    <tr>
                                                                    <td><h4 class="card-title">Comapny Name</h4>
                                                                    <i class="fa fa-envelope"></i> <?php echo $items[0]['company_name'];?>
                                                                    </td>
                                                                    <td><h4 class="card-title">Email</h4>
                                                                    <i class="fa fa-envelope"></i> <?php echo $items[0]['email'];?>
                                                                    </td>
                                                                    </tr>
                                                                    <tr>  
                                                                    <td><br><h4 class="card-title">Billing Address</h4>
                                                                    <i class="fa fa-map-marker"></i> <?php echo $items[0]['address'];?>
                                                                    </td>
                                                                    </tr>
                                                                    <td><br><h4 class="card-title">Customer's Order Count</h4>
                                                                   <a style="color:#007ace;margin-top:2px;" href="<?php echo SURL;?>supplierz/manage_online_store_orders"><?php echo get_no_of_orders($items[0]['user_id']);?></a>
                                                                    </td>
                                                                    </tr>
                                                                </tbody>
                                                                <?php } ?>
                                                            </table>
                                                        </div>
                                                        <!-- End Of table responsive -->
                                                </div>
                                                <!-- End Of panel body -->
                                            </div>
                                            <!-- End Of brand description -->
                                        </div>
                                </div>
                                
							</div>
						</div>
						</div>

						</div>
</div>
<!-- end row -->