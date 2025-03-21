<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">shopping_cart</i>
                                    </div>
                                    <div class="card-content">
                                    <h4 class="card-title">Cart</h4>
<div class="section">
	<div class="container">
	    <?php if ($this->cart->total() != 0) { ?>
        <div class="row">
            <div class="col-12">
                 <?php
                                if ($this->cart->total() != 0) {
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
                                }
                                ?>
                <?php
                    
                           echo form_open(SURL.'online_store/update_cart');
                           
                 ?>
                 
                <div class="table-responsive shop_cart_table">
                	<table class="table">
                    	<thead>
                        	<tr>
                            	<th class="product-thumbnail">&nbsp;</th>
                                <th class="product-name">Product</th>
                                 <th class="product-name">Supplier</th>
                                <th class="product-price">Price</th>
                                <th class="product-quantity">Quantity</th>
                                <th class="product-subtotal">Total</th>
                                <th class="product-remove">Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach ($this->cart->contents() as $items):
                              echo form_hidden('rowid[]', $items['rowid']); 
                              ?>
                        	<tr>
                            	<td class="product-thumbnail"><a target="_Blank" href="<?php echo SURL.'online_store/details/'.$items['id'];?>"><img src="<?php echo COMPONENT_IMG.$items['image']; ?>" alt="<?php echo $items['name']; ?>"></a></td>
                                <td class="product-name" data-title="Product">
                                    <a target="_Blank" href="<?php echo SURL.'online_store/details/'.$items['id'];?>"><?php echo $items['name']; ?></a>
                                </td>
                                <td style="text-align:left;">
                                    <?php $company_info = get_supplierz_company_info($items["supplierz"]);?>
                                    <span><i class="fa fa-truck"></i> <?php echo $company_info["com_name"];?></span>
                                </td>
                                <td class="product-price" data-title="Price">
                                                        <span class="price"><?php echo CURRENCY.$this->cart->format_number($items["price"]);?></span>
                                </td>
                                <td class="product-quantity" data-title="Quantity"><div class="quantity">
                                <input type="button" value="-" class="minus">
                                <input type="text" name="quantity[]" value="<?php echo $items['qty'];?>" title="Qty" class="qty" size="4" min="1">
                                <input type="button" value="+" class="plus">
                                <input type="hidden" name="product[]" value="<?php echo $items['id'];?>">
                              </div></td>
                              	<td class="product-subtotal" data-title="Total"><?php echo CURRENCY.' '.$this->cart->format_number($items['subtotal']); ?></td>
                                <td class="product-remove" data-title="Remove"><a href="<?php echo SURL; ?>online_store/remove_cart/<?php echo $items['rowid']; ?>"><i class="ti-close"></i></a></td>
                            </tr>
                             <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                        	<tr>
                            	<td colspan="6" class="px-0">
                                	<div class="row no-gutters align-items-center">
                                        <div class="col-lg-8 col-md-6 text-left text-md-right">
                                            <button class="btn btn-warning btn-sm" type="submit">Update Cart</button>
                                            <a class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to remove all items in the cart?');" href="<?php echo SURL; ?>online_store/empty_cart"><i class="fa fa-trash" aria-hidden="true"></i> Empty Cart</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
            	<div class="medium_divider"></div>
            	<div class="divider center_icon"><i class="ti-shopping-cart-full"></i></div>
            	<div class="medium_divider"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
            	<div class="border p-3 p-md-4">
                    <div class="heading_s1 mb-3">
                        <h6>Cart Totals</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td class="cart_total_label">Cart Subtotal</td>
                                    <td class="cart_total_amount"><?php echo CURRENCY.' '.$this->cart->format_number($this->cart->total()); ?></td>
                                </tr>
                                <tr>
                                    <td class="cart_total_label">Total</td>
                                    <td class="cart_total_amount"><strong><?php echo CURRENCY.' '.$this->cart->format_number($this->cart->total()); ?></strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <a href="<?= SURL?>online_store/checkout" class="btn btn-success">Proceed To CheckOut</a>
                </div>
            </div>
        </div>
         <?php } else { ?>
            <div class="row">
			<div class="col-md-12 empty-card text-center">
				<img src="<?php echo IMG;?>empty_cart.png" alt="">
				<h2><b>Your Cart is Empty!</b></h2>
				<h3>Looks Like you have no Order in your cart</h3>
			</div>
		</div>
     <?php } ?>
    </div>
</div>
</div>
</div>
</div>
</div>