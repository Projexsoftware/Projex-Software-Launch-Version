<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">favorite</i>
                                    </div>
                                    <div class="card-content">
                                    <h4 class="card-title">Wishlist</h4>
                                    <!-- START SECTION SHOP -->
    <div class="material-datatables">
	    
        <?php  if($this->wishlist->total()>0){ ?>
            <div class="col-12">
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
                <div class="table-responsive wishlist_table">
                	<table class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                    	<thead>
                        	<tr>
                            	<th class="product-thumbnail">&nbsp;</th>
                                <th class="product-name">Product</th>
                                <th class="product-name">Supplier</th>
                                <th class="product-price">Price</th>
                                <th class="product-add-to-cart"></th>
                                <th class="product-remove">Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach ($this->wishlist->contents() as $items):
                            ?>
                            <input type="hidden" name="name" id="name<?php echo $items['id'];?>" value="<?php echo $items['name'];?>">
                    <input type="hidden" name="image" id="image<?php echo $items['id'];?>" value="<?php echo $items['image'];?>">
                    <input type="hidden" name="quantity" id="quantity<?php echo $items['id'];?>" value="1">
                    <input type="hidden" name="category" id="category<?php echo $items['id'];?>" value="<?php echo $items['category'];?>">
                    <input type="hidden" name="price" id="price<?php echo $items['id'];?>" value="<?php echo $items['price'];?>">
                    <input type="hidden" name="supplierz" id="supplierz<?php echo $items['id'];?>" value="<?php echo $items['supplierz'];?>">
                        	<tr>
                            	<td class="product-thumbnail"><a target="_Blank" href="<?php echo SURL.'online_store/details/'.$items['id'];?>"><img src="<?php if($items['image']!="") { echo COMPONENT_IMG.$items['image']; } else{ echo IMG.'image_placeholder.jpg'; }?>" alt="<?php echo $items['name']; ?>"></a></td>
                                <td class="product-name" data-title="Product">
                                    <a target="_Blank" href="<?php echo SURL.'online_store/details/'.$items['id'];?>"><?php echo $items['name']; ?></a>
                                </td>
                                <td style="text-align:left;">
                                    <?php $company_info = get_supplierz_company_info($items["supplierz"]);?>
                                    <span><i class="fa fa-truck"></i> <?php echo $company_info["com_name"];?></span>
                                </td>
                                <td class="product-price" data-title="Price">
                                    <span class="price"><?php echo CURRENCY.$this->wishlist->format_number($items["price"]);?></span>
                                </td>
                                <td class="product-add-to-cart">
                                    <?php
                              $items_product_array = array();
                              if(!empty($this->cart->contents())){ 
                                 foreach($this->cart->contents() as $cartitems){
                                     $items_product_array[]=$cartitems['id'];
                                 }
                                 if(in_array($items['id'], $items_product_array)){
                                 ?>
                                <a href="<?= SURL?>online_store/cart" class="btn btn-warning">View Cart</a>
                                <?php } else{ ?>
                                <a id="<?php echo $items['id'];?>" class="btn btn-warning add-to-cart-wishlist-btn"><i class="icon-basket-loaded"></i> Add to Cart</a>
                          <?php } } else {?>
                                <a id="<?php echo $items['id'];?>" class="btn btn-warning add-to-cart-wishlist-btn"><i class="icon-basket-loaded"></i> Add to Cart</a>
                          <?php }?>
                                    
                                </td>
                                <td class="product-remove" data-title="Remove">
                                    <a href="<?php echo SURL; ?>online_store/remove_wishlist/<?php echo $items['rowid']; ?>"><i class="ti-close"></i></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php } else{ ?>
			      <div class="col-md-12 empty-cart text-center">
                    <img src="<?php echo IMG;?>empty_cart.png" alt="">
    				<h2><b>Your Wishlist is Empty!</b></h2>
    				<h3>Looks Like you have no Product in your wishlist</h3>
    			  </div>
				<?php } ?>
        </div>  
    </div>
</div>
<!-- END SECTION SHOP -->
</div>
</div>
