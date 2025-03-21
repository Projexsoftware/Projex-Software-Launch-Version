<div class="row">
            <div class="col-md-12">
                            <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">shopping_cart</i>
                                    </div>
                                    <div class="card-content">
                                    <h4 class="card-title">Checkout</h4>
                                <div class="section">
                                	<div class="container">
                                	    <div class="row">
                                	        <div class="row">
        
                	<div class="toggle_info" style="background-color:transparent;">
                    	<span><i class="fas fa-sticky-note"></i>Already Not Registered? Please fill billing details and check the create an acount checkbox to register with us.</span>
                    </div>
          
        </div>
        <div class="row">
            <div class="col-12">
            	<div class="medium_divider"></div>
            	<div class="divider center_icon"><i class="linearicons-credit-card"></i></div>
            	<div class="medium_divider"></div>
            </div>
        </div>
        <form id="PlaceOrderForm" method="post" autocomplete="off">
        <div class="row">
            	<div class="col-md-6">
                	<div class="heading_s1">
                		<h4>Billing Details</h4>
                    </div>
                        <input type="hidden" id="customer_id" name="customer_id" value="<?php if(isset($user_info['user_id'])){ echo $user_info['user_id']; } ?>">
                        <div class="">
                            <input type="text" required="true" class="form-control" name="fname" placeholder="First name *" value="<?php echo ($this->session->userdata('firstname')!='')?$this->session->userdata('firstname'):$user_info['user_fname']; ?>">
                        </div>
                        <div class="">
                            <input type="text" required="true" class="form-control" name="lname" placeholder="Last name *" value="<?php echo ($this->session->userdata('lastname')!='')?$this->session->userdata('lastname'):$user_info['user_lname']; ?>">
                        </div>
                        <div class="">
                            <input class="form-control" type="text" name="cname" placeholder="Company Name" value="<?php echo ($this->session->userdata('company_name')!='')?$this->session->userdata('company_name'):$user_info['com_name']; ?>">
                        </div>
                        
                        <div class="">
                            <input type="text" class="form-control" name="address" required="true" placeholder="Address *" value="<?php echo ($user_info['com_street_address']!='')?$user_info['com_street_address']:''; ?>">
                        </div>
                        <div class="">
                            <input class="form-control" required="true" type="text" name="city" placeholder="City / Town *" value="">
                        </div>
                        <div class="">
                            <input class="form-control" required="true" type="text" name="state" placeholder="State / County *" value="Newzealand" readonly>
                        </div>
                        <div class="">
                            <input class="form-control" required="true" type="text" name="zipcode" placeholder="Postcode / ZIP *" value="">
                        </div>
                        <div class="">
                            <input class="form-control" required="true" type="text" name="phone" placeholder="Phone *" value="<?php echo ($user_info['com_phone_no']!='')?$user_info['com_phone_no']:''; ?>">
                        </div>
                        <div class="">
                            <input class="form-control" required="true" email="true" type="text" id="email" name="email" placeholder="Email address *" value="<?php echo ($user_info['com_email']!='')?$user_info['com_email']:''; ?>">
                        </div>
                        <div class="ship_detail">
                                                <div class="form-check">
                                                <label class="">
                                                  <input class="form-check-input" type="checkbox" name="differentaddress" id="differentaddress" value="1">
                                                  <span class="form-check-sign">
                                                    <span class="check"></span>
                                                  </span>
                                                  Ship to a different address?</label>
                                              </div>
                        	<div class="different_address">
                            <div class="">
                                <input type="text" required="true" class="form-control" name="shipping_fname" placeholder="First name *" value="">
                            </div>
                            <div class="">
                                <input type="text" required="true" class="form-control" name="shipping_lname" placeholder="Last name *" value="">
                            </div>
                            <div class="">
                                <input class="form-control" type="text" name="shipping_cname" placeholder="Company Name" value="">
                            </div>
                            <div class="">
                                <input type="text" class="form-control" name="shipping_address" required="" placeholder="Address *" value="">
                            </div>
                            <div class="">
                                <input class="form-control" required type="text" name="shipping_city" placeholder="City / Town *" value="">
                            </div>
                            <div class="">
                                <input class="form-control" required type="text" name="shipping_state" placeholder="State / County *" value="">
                            </div>
                            <div class="">
                                <input class="form-control" required type="text" name="shipping_zipcode" placeholder="Postcode / ZIP *" value="">
                            </div>
                        </div>
                        </div>
                        <div class="heading_s1">
                            <h4>Additional information</h4>
                        </div>
                        <div class=" mb-0">
                            <textarea rows="5" class="form-control" name="order_notes" placeholder="Order notes"></textarea>
                        </div>
                </div>
                <div class="col-md-6">
                    <div class="order_review">
                        <div class="heading_s1">
                            <h4>Your Orders</h4>
                        </div>
                        <div id="your_order_container">
                           <div class="table-responsive order_table">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Supplier</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($this->cart->contents() as $items): ?>
                                    <tr>
                                        <td class="product-name"><?php echo $items['name']; ?> <span class="product-qty">x <?php echo $items['qty']; ?></span>
                                        </td>
                                        <td style="text-align:left;">
                                        <?php $company_info = get_supplierz_company_info($items["supplierz"]);?>
                                        <span><i class="fa fa-truck"></i> <?php echo $company_info["com_name"];?></span>
                                        </td>
                                        <td>
                                            <span class="price"><?php echo CURRENCY.$this->cart->format_number($items["price"]);?></span>
                                        </td>
                                        <td><?php echo CURRENCY.$this->cart->format_number($items["subtotal"]); ?></td>
                                    </tr>
                                    <?php  endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td align="right"><b>SubTotal:</b></td>
                                        <td><?php echo CURRENCY.$this->cart->format_number($this->cart->total());?></td>
                                    </tr>
                                    
                                    <tr>
                                        <td></td>
                                        <td align="right"><b>Shipping:</b></td>
                                        <td>Free Shipping</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td align="right"><b>Total:</b></td>
                                        <td>
                                        <?php echo CURRENCY.$this->cart->format_number($this->cart->total());?>
                                        <input type="hidden" name="total" id="total" value="<?php echo $this->cart->total();?>">
                                        <input type="hidden" name="subtotal" id="subtotal" value="<?php echo $this->cart->total();?>">
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        </div>
                        <div class="payment_method">
                            <div class="heading_s1">
                                <h4>Payment</h4>
                            </div>
                            <div class="payment_option">
                                <div class="custome-radio">
                                    <input class="form-check-input" type="radio" name="payment_option" id="payment_option7" value="cash" checked="">
                                    <label class="form-check-label" for="payment_option7">Cash On Delivery</label>
                                    <p data-method="option7" class="payment-text"></p>
                                </div>
                            </div>
                        </div>
                         
                           <a href="javascript:Void(0);" class="btn btn-warning btn-block btn-placeorder">Place Order</a>
                       
                    </div>
                </div>
        </div>
        </form>
                                	    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
            </div>
</div>