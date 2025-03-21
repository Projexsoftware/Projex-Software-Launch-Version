<div class="row">
            <div class="col-md-12">
                            <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">shopping_cart</i>
                                    </div>
                                    <div class="card-content">
                                    <h4 class="card-title">Thankyou</h4>
                                    <section id="order" class="section">
                    <?php
                    $orders =  get_order_items($this->session->userdata('order_no_')); 
                    $order_info = get_order_info($this->session->userdata('order_no_'));
                    ?>
                    	<div class="container thankyou_page">
                    		<!-- Start Row -->
                    		
                    		<div class="row">
                    		    <div class="col-md-12">
                    				<center>
                    				    <h5>Thank you for your purchase!</h5>
                    				    <p>We hope you enjoy your <b>Projex Software</b> recent purchase. If you have any question of your order, feel free to contact with us at info@wizard.net.nz.</p>
                    				</center>
                    			</div>
                    			<div class="col-md-12 text-right">
                    				<h5>ORDER # : <?php echo $this->session->userdata('order_no_');?></h5>
                    			</div>
                    		</div>
                    		<!-- End Row -->
                          
                            <div class="row">
                            <div class="col-md-12">
                            <h5>Order Summary</h5>
                            <div class="table-responsive order_table">
                                    <table class="table">
                                        	<thead>
                                            	<tr>
                                                	<th class="product-thumbnail">&nbsp;</th>
                                                    <th class="product-name">Product</th>
                                                    <th class="product-name">Supplier</th>
                                                    <th class="product-quantity">Quantity</th>
                                                    <th class="product-price">Price</th>
                                                    <th class="product-subtotal">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                 <?php  
                                                 foreach($orders as $order) {
                                                ?>
                                            	<tr>
                                                	<td class="product-thumbnail"><img src="<?php echo ONLINE_STORE_IMAGES.$order['item_image']; ?>" alt="<?php echo $order['item_name']; ?>"></td>
                                                    <td class="product-name" data-title="Product"><?php echo $order['item_name']; ?>
                                                    <?php if($order['item_category']!=""){?>
                                                    <p><span class="pr_supplier bg-warning"><i class="linearicons-pointer-right"></i> <?php echo $order['item_category'];?></span></p>
                                                    <?php } ?>
                                                   
                                                    
                                                    <!--<p><span class="pr_supplier bg-warning"><i class="linearicons-truck"></i> <?php echo $order['item_supplier'];?></span></p>-->
                                                    </td>
                                                    <td style="text-align:left;">
                                                        <?php $company_info = get_supplierz_company_info($order["supplierz_id"]);?>
                                                       <span><i class="fa fa-truck"></i> <?php echo $company_info["com_name"];?></span>
                                                    </td>
                                                    <td class="product-quantity" data-title="Quantity"><?php echo $order['item_quantity']; ?></td>
                                                    <td class="product-price" data-title="Price">
                                                        <?php echo CURRENCY.$order['item_price'];?>
                                                    </td>
                                                  	<td class="product-subtotal" data-title="Total"><?php echo CURRENCY.' '.$this->cart->format_number($order['item_subtotal']); ?></td>
                                                </tr>
                                                 <?php } ?>
                                            </tbody>
                                            <tfoot>
                                                        <tr>
                                                            <td class="empty-cell"> </td>
                                                            <td colspan="4" align="right"><b>Subtotal:</b></td>
                                                            <td class="product-subtotal"><?php echo CURRENCY.$this->cart->format_number($order_info["total"]);?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="empty-cell"> </td>
                                                            <td colspan="4" align="right"><b>Shipping:</b></td>
                                                            <td>Free Shipping</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="empty-cell"> </td>
                                                            <td colspan="4" align="right"><b>Total:</b></td>
                                                            <td class="product-subtotal">
                                                            <?php echo CURRENCY.$this->cart->format_number($order_info["total"]);?>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                        </table>
                            </div>
                            </div>
                            </div>
                            <?php if($order_info["comments"]!=""){?>
                            <div class="row">
                                <div class="col-md-12">
                                        <h5>Order Notes</h5>
                                    	<div class="toggle_info" style="background-color:transparent;">
                                        	<span><i class="fas fa-sticky-note"></i><?php echo $order_info["comments"];?></span>
                                        </div>
                                </div>
                            </div>
                            <br/>
                            <?php } ?>
                            <div class="row">
                            <div class="col-md-12">
                            <h5>Customer Information</h5>
                            </div>
                            <br/><br/>
                            <div class="col-md-6">
                                <h6>Shipping Information</h6>
                                <p><?php echo $order_info["shipping_first_name"]. " ".$order_info["shipping_last_name"];?></p>
                                <p><?php echo $order_info["shipping_address"];?></p>
                                <p><?php echo $order_info["shipping_city"]. " ".$order_info["shipping_zipcode"];?></p>
                                <p><?php echo $order_info["shipping_state"];?></p>
                            </div>
                            <div class="col-md-6">
                                <h6>Billing Information</h6>
                                <p><?php echo $order_info["first_name"]. " ".$order_info["last_name"];?></p>
                                <p><?php echo $order_info["address"];?></p>
                                <p><?php echo $order_info["city"]. " ".$order_info["zipcode"];?></p>
                                <p><?php echo $order_info["state"];?></p>
                            </div>
                            <div class="col-md-6">
                                <h6>Shipping Method</h6>
                                <p>Free Shipping</p>
                            </div>
                            <div class="col-md-6">
                                <h6>Payment Method</h6>
                                <p><?php echo "Cash On Delivery (COD)";?> <?php echo CURRENCY.$this->cart->format_number($order_info['total']);?></p>
                            </div>
                            </div>
                    	</div>
                    </section>
                </div>
            </div>
        </div>
</div>