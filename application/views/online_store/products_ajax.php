<?php if(count($products)>0){ ?>
                    <div class="row">
                    <?php
                        foreach($products as $product){
                    ?>
                    <input type="hidden" name="name" id="name<?php echo $product['component_id'];?>" value="<?php echo $product['component_name'];?>">
                    <input type="hidden" name="image" id="image<?php echo $product['component_id'];?>" value="<?php echo $product['image'];?>">
                    <input type="hidden" name="quantity" id="quantity<?php echo $product['component_id'];?>" value="1">
                    <input type="hidden" name="category" id="category<?php echo $product['component_id'];?>" value="<?php echo $product['component_category'];?>">
                    <input type="hidden" name="price" id="price<?php echo $product['component_id'];?>" value="<?php echo $product['sale_price'];?>">
                    <div class="col-md-4 col-6">
                        <div id="item-<?php echo $product['component_id'];?>" class="product product_box">
                            <?php if($product['component_category']!=""){?>
                             <span class="pr_flash bg-warning"><?php echo $product['component_category'];?></span>
                            <?php } ?>
                            <div class="product_img">
                                <a href="<?php echo SURL.'online_store/details/'.$product['component_id'];?>">
                                    <img src="<?php if($product['image']!="") { echo COMPONENT_IMG.$product['image']; } else{ echo IMG.'image_placeholder.jpg'; }?>" alt="<?php echo $product["component_name"];?>">
                                </a>
                                <div class="product_action_box">
                                    <ul class="list_none pr_action_btn">
                                       <?php $items_array = array();
                              if(!empty($this->cart->contents())){ 
                                 foreach($this->cart->contents() as $items){
                                     $items_array[]=$items['id'];
                                 }
                              }
                                ?>
                                        <li class="add-to-cart"><a href="javascript:void(0)" id="<?php echo $product['component_id'];?>" class="btn-add-to-cart btn-addtocart" 
                                 <?php if(in_array($product['component_id'], $items_array) || $product["company_id"] == $this->session->userdata("company_id")){ ?> style="display:none;" <?php } ?>><i class="icon-basket-loaded"></i> Add To Cart</a></li>
                                        <li><a href="<?php echo SURL.'online_store/details/'.$product['component_id'];?>"><i class="icon-info"></i></a></li>
                                        <?php
                                        if($product["company_id"] != $this->session->userdata("company_id")){ 
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
                                        <li><a id="<?php echo $row_id;?>" href="javascript:void(0)" class="wishlist-active-icon btn-remove-from-wishlist"><i class="icon-heart"></i></a></li>
                                        <?php } else{ ?>
                                        <li><a id="<?php echo $product['component_id'];?>" href="javascript:void(0)" class="wishlist-icon btn-add-to-wishlist"><i class="icon-heart"></i></a></li>
                                        <?php } } else{?>
                                         <li><a id="<?php echo $product['component_id'];?>" href="javascript:void(0)" class="wishlist-icon btn-add-to-wishlist"><i class="icon-heart"></i></a></li>
                                        <?php }
                                        }
                                          ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="product_info">
                                
                                    <!--<span class="pr_supplier bg-warning"><i class="linearicons-truck"></i> <?php $supplier_info = get_supplier_info($product['supplier_id']);
                                echo $supplier_info['supplier_name'];?></span>-->
                                <input type="hidden" name="supplier" id="supplier<?php echo $product['component_id'];?>" value="<?php echo $supplier_info['supplier_name'];?>">
                                <h6 class="product_title"><a href="<?php echo SURL.'online_store/details/'.$product['component_id'];?>"><?php echo $product["component_name"];?></a></h6>
                                <div class="pr_desc">
                                    <p><?php echo $product["component_des"];?></p>
                                </div>
                                <div class="product_price">
                                    <span class="price"><?php echo CURRENCY.$product["sale_price"];?></span>
                                </div>
                                <div class="product_supplier">
                                    <?php $company_info = get_supplierz_company_info($product["company_id"]);?>
                                    <img src="<?php echo COMPANY_LOGO.$company_info['com_logo'];?>">
                                </div>
                                 <?php  if($product["company_id"] != $this->session->userdata("company_id")){ ?>
                                <div class="add-to-cart-button cart_btn<?php echo $product['component_id'];?>">
                            <?php 
                              $items_array = array();
                              if(!empty($this->cart->contents())){ 
                                 foreach($this->cart->contents() as $items){
                                     $items_array[]=$items['id'];
                                 }
                                 if(in_array($product['component_id'], $items_array)){
                                 ?>
                                <a href="<?= SURL?>online_store/cart" class="btn btn-sm btn-warning"><i class="material-icons">shopping_cart</i> VIEW CART</a>
                                <?php } else{ 
                                ?>
                              <a id="<?php echo $product['component_id'];?>" class="btn btn-sm btn-warning btn-addtocart btn-addtocart-<?php echo $product['component_id'];?>"><i class="material-icons">shopping_cart</i> ADD TO CART</a>
                              <?php 
                               } } else {
                              ?>
                               <a id="<?php echo $product['component_id'];?>" class="btn btn-sm btn-warning btn-addtocart btn-addtocart-<?php echo $product['component_id'];?>"><i class="material-icons">shopping_cart</i> ADD TO CART</a>
                          <?php  }
                               ?>
                        </div>
                        <?php } ?>
                                <!--<div class="pr_switch_wrap">
                                    <div class="product_color_switch">
                                        <span class="active" data-color="#87554B"></span>
                                        <span data-color="#333333"></span>
                                        <span data-color="#DA323F"></span>
                                    </div>
                                </div>-->
                                <div class="list_product_action_box">
                                    <ul class="list_none pr_action_btn">
                                         <?php  if($product["company_id"] != $this->session->userdata("company_id")){ ?>
                                          <li class="add-to-cart"><a href="javascript:void(0)" id="<?php echo $product['component_id'];?>" class="btn-add-to-cart btn-addtocart"><i class="icon-basket-loaded"></i> Add To Cart</a></li>
                                          <?php } ?>
                                          <li><a href="<?php echo SURL.'online_store/details/'.$product['component_id'];?>"><i class="icon-info"></i></a></li>
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
                                        <li><a id="<?php echo $row_id;?>" href="javascript:void(0)" class="wishlist-active-icon btn-remove-from-wishlist"><i class="icon-heart"></i></a></li>
                                        <?php } else{ ?>
                                        <li><a id="<?php echo $product['component_id'];?>" href="javascript:void(0)" class="wishlist-icon btn-add-to-wishlist"><i class="icon-heart"></i></a></li>
                                        <?php } } else{?>
                                         <li><a id="<?php echo $product['component_id'];?>" href="javascript:void(0)" class="wishlist-icon btn-add-to-wishlist"><i class="icon-heart"></i></a></li>
                                        <?php }
                                          ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } 
                    ?>
                    </div>
                    <div class="row">
                    <div class="col-12">
                        <?php echo $links;?>
                    </div>
                </div>
                    <?php } else{ ?>
                 <p class="text-danger">No Products Found</p>   
<?php } ?>
