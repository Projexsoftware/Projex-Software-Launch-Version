<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">shopping_cart</i>
                                    </div>
                                    <div class="card-content">
                                    <h4 class="card-title">Online Store</h4>
<!-- START SECTION SHOP -->
<div class="section">
	<div class="container">
		<div class="row">
            <div class="col-lg-6 col-md-6 mb-4 mb-md-0">
              <div class="product-image">
                    <div class="product_img_box">
                        <img id="product_img" src='<?php if($product['image']!="") { echo COMPONENT_IMG.$product['image']; } else{ echo IMG.'image_placeholder.jpg'; }?>' data-zoom-image="<?php if($product['image']!="") { echo COMPONENT_IMG.$product['image']; } else{ echo IMG.'image_placeholder.jpg'; }?>" alt="<?php echo $product['component_name'];?>" />
                        <a class="product_img_zoom" href="<?php if($product['image']!="") { echo COMPONENT_IMG.$product['image']; } else{ echo IMG.'image_placeholder.jpg'; }?>" data-lightbox="image-1" data-title="<?php echo $product['component_name'];?>">
                            <span class="linearicons-zoom-in"></span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="pr_detail">
                    <div class="product_description">
                        <div class="product_title"><a href="#"><?php echo $product['component_name'];?></a></div>
                        <?php if($product['component_des']!=""){?>
                        <div class="pr_desc"><h2><?php echo $product['component_des'];?></h2></div>
                        <?php } ?>
                        <div class="product_price">
                            <span class="price"><?php echo CURRENCY.$product["sale_price"];?></span>
                        </div>
                    </div>
                    <input type="hidden" name="price" id="price<?php echo $product['component_id'];?>" value="<?php echo $product['sale_price'];?>">
                    <input type="hidden" name="title" id="title<?php echo $product['component_id'];?>" value="<?php echo $product['component_name'];?>">
                    <input type="hidden" name="image" id="image<?php echo $product['component_id'];?>" value="<?php echo $product['image'];?>">
                    <input type="hidden" name="size" id="size<?php echo $product['component_id'];?>" value="">
                    <input type="hidden" name="color" id="color<?php echo $product['component_id'];?>" value="">
                    
                        <hr />
                        <table class="table">
                            <?php if(count($options)>0){
                            foreach($options as $option){
                            ?>
                            <tr>
                                <td><?php echo $option["option_name"];?></td>
                                <td><?php echo $option["option_values"];?></td>
                            </tr>
                            <?php } } ?>
                        </table>
                         <div class="cart_extra">
                         <?php if($product["company_id"] != $this->session->userdata("company_id")){ ?>
                        <div class="cart-product-quantity">
                            <div class="quantity">
                                <input type="button" value="-" class="minus">
                                <input type="text" id="quantity<?php echo $product['component_id'];?>" name="quantity" value="1" title="Qty" class="qty" size="4">
                                <input type="button" value="+" class="plus">
                            </div>
                        </div>
                        <div class="cart_btn">
                            <?php
                              $items_array = array();
                              if(!empty($this->cart->contents())){ 
                                 foreach($this->cart->contents() as $items){
                                     $items_array[]=$items['id'];
                                 }
                                 if(in_array($product['component_id'], $items_array)){
                                 ?>
                                <a href="<?= SURL?>online_store/cart" class="btn btn-warning">VIEW CART</a>
                                <?php } else{ ?>
                                <a id="<?php echo $product['component_id'];?>" class="btn btn-warning btn-addtocart"><i class="material-icons">shopping_cart</i> ADD TO CART</a>
                          
                          <?php } } else {?>
                          <a id="<?php echo $product['component_id'];?>" class="btn btn-warning btn-addtocart"><i class="material-icons">shopping_cart</i> ADD TO CART</a>
                          <?php }?>
                        <?php
                              $items_array = array();
                              if(!empty($this->wishlist->contents())){ 
                                 foreach($this->wishlist->contents() as $items){
                                     $items_array[]=$items['id'];
                                     if($product['component_id']==$items['id']){
                                         $row_id = $items['rowid'];
                                     }
                                 }
                                 if(in_array($product['component_id'], $items_array)){
                                 ?>
                                <a id="<?php echo $row_id; ?>" href="javascript:void(0)" class="wishlist-active-icon btn-remove-from-wishlist"><i class="icon-heart"></i></a>
                                <?php } else{ ?>
                                <a id="<?php echo $product['component_id'];?>"  href="javascript:void(0)" class="btn-add-to-wishlist wishlist-icon"><i class="icon-heart"></i></a>
                                <?php } } else{ ?>
                                <a id="<?php echo $product['component_id'];?>"  href="javascript:void(0)" class="btn-add-to-wishlist wishlist-icon"><i class="icon-heart"></i></a>
                                <?php } ?>
                        </div>
                        <?php } ?>
                    </div>
                    
                   
                    <ul class="product-meta">
                        
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
        	<div class="col-12">
            	<div class="large_divider clearfix"></div>
            </div>
        </div>
        <div class="row">
        	<div class="col-12">
        	    <h4>More Information</h4>
            	<div class="tab-style3">
					<ul class="nav nav-tabs" role="tablist">
						<li class="nav-item active">
							<a class="nav-link" id="technical-specification-tab" data-toggle="tab" href="#technical-specification" role="tab" aria-controls="technical-specification" aria-selected="true">Technical Specification</a>
                      	</li>
                      	<li class="nav-item">
                        	<a class="nav-link" id="warranty-tab" data-toggle="tab" href="#warranty" role="tab" aria-controls="warranty" aria-selected="false">Warranty</a>
                      	</li>
                      	<li class="nav-item">
                        	<a class="nav-link" id="maintenance-tab" data-toggle="tab" href="#maintenance" role="tab" aria-controls="maintenance" aria-selected="false">Maintenance</a>
                      	</li>
                      	<li class="nav-item">
                        	<a class="nav-link" id="installation-tab" data-toggle="tab" href="#installation" role="tab" aria-controls="installation" aria-selected="false">Installation</a>
                      	</li>
                      	<li class="nav-item">
                        	<a class="nav-link" id="checklist-tab" data-toggle="tab" href="#checklist" role="tab" aria-controls="checklist" aria-selected="false">Checklist</a>
                      	</li>
                      	<li class="nav-item">
                        	<a class="nav-link" id="email-supplier-tab" data-toggle="tab" href="#email-supplier" role="tab" aria-controls="email-supplier" aria-selected="false">Email Supplier</a>
                      	</li>
                    </ul>
                	<div class="tab-content shop_info_tab">
                      	<div class="tab-pane active" id="technical-specification" role="tabpanel" aria-labelledby="technical-specification-tab">
                      	    <?php if(($product['specification']) && $product['specification']!=""){ ?>
                                     <a target="_Blank" href="<?php echo base_url();?>assets/component_documents/specification/<?php echo $product['specification'];?>"><?php echo $product['specification'];?></a>
                            <?php } ?>
                        </div>
                      	<div class="tab-pane" id="warranty" role="tabpanel" aria-labelledby="warranty-tab">
                      	     <?php if(($product['warranty']) && $product['warranty']!=""){ ?>
                                     <a target="_Blank" href="<?php echo base_url();?>assets/component_documents/warranty/<?php echo $product['warranty'];?>"><?php echo $product['warranty'];?></a>
                            <?php } ?>
                      	</div>
                      	<div class="tab-pane" id="maintenance" role="tabpanel" aria-labelledby="maintenance-tab">
                      	     <?php if(($product['maintenance']) && $product['maintenance']!=""){ ?>
                                     <a target="_Blank" href="<?php echo base_url();?>assets/component_documents/maintenance/<?php echo $product['maintenance'];?>"><?php echo $product['maintenance'];?></a>
                            <?php } ?>
                      	</div>
                      	<div class="tab-pane" id="installation" role="tabpanel" aria-labelledby="installation-tab">
                      	     <?php if(($product['installation']) && $product['installation']!=""){ ?>
                                     <a target="_Blank" href="<?php echo base_url();?>assets/component_documents/specification/<?php echo $product['installation'];?>"><?php echo $product['installation'];?></a>
                            <?php } ?>
                      	</div>
                      	<div class="tab-pane" id="checklist" role="tabpanel" aria-labelledby="checklist-tab">
                      	    <?php $checklists = get_checklist_items_for_builders($product['component_id']);
                                                    if(count($checklists)>0){
                                                    ?>
                                                    <ul>
                                                        <?php
                                                        foreach($checklists as $checklist){ 
                                                      ?>
                                                          <li><?php echo $checklist['checklist'];?></li>
                                                      <?php } ?>
                                                    </ul>
                                                      <?php   
                                                       }
                                                      ?>
                      	</div>
                      	<div class="tab-pane" id="email-supplier" role="tabpanel" aria-labelledby="email-supplier-tab">
                      	</div>
                      	
                	</div>
                </div>
            </div>
        </div>
        
    </div>
</div>
<!-- END SECTION SHOP -->
<a href="" id="popup<?php echo $product['component_id'];?>" data-toggle="modal" data-target="#cart<?php echo $product['component_id'];?>"></a>
				            <div id="cart<?php echo $product['component_id'];?>" class="modal fade" role="dialog">
							  <div class="modal-dialog">

								<!-- Modal content-->
								<div class="modal-content">
								  <div class="modal-body">
								  <button type="button" class="close" data-dismiss="modal">&times;</button>
									<p style="text-align:left!important;font-size:14px;">Product <b><?php echo $product['component_name'];?></b> has been added to your shopping cart </p>
									<a class="btn btn-fill-out" href="<?php echo SURL;?>shop/view_my_cart">View my Cart</a>&nbsp;&nbsp;&nbsp;
<a class="btn btn-success" href="<?= SURL?>" >Continue Shopping</a>
								  </div>
								  
								</div>

							  </div>
							</div> 
 </div>
                            </div>
                        </div>
</div>

<script>
		function add_to_cart(id){
			
			var title = $('#title'+id).val();
			var price = $('#price'+id).val();
	                var request_url = "<?php echo SURL;?>shop/add_to_cart";
			var view_cart = "<?php echo SURL;?>shop/view_cart";
			jQuery.post(
				request_url, 
                                {flag: true, title:title, price:price, id:id},
                                function (responseText) {
				if(responseText!="fail"){
				$('#popup'+id).click();
				$('.cart_total').text(responseText);
                                    }
                                }, 
                                "html"
			);
		}
		
		</script>