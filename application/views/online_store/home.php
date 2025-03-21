<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">shopping_cart</i>
                                    </div>
                                    <div class="card-content">
                                    <h4 class="card-title">Online Store</h4>
                                    <!-- sidebar + content -->
<section class="">
  <div class="container">
    <div class="row">
      <!-- sidebar -->
     <div class="col-lg-3">
         <div class="col-lg-12">
    <a class="btn btn-warning btn-sm pull-right reset_filters">Reset Filters</a>
    </div>
    <div class="panel-group" id="accordionCategories" role="tablist" aria-multiselectable="true">
    <div class="panel panel-default">
      <div class="panel-heading" role="tab" id="headingOne">
        <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordionCategories" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
         Categories
        </a>
      </h4>
      </div>
      <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
        <div class="panel-body">
            <div class="form-group has-search">
                <span class="fa fa-search form-control-feedback"></span>
                <input type="text" class="form-control search_categories" placeholder="Search">
             </div>
             <div class="categories_container">
             </div>
            <?php if(count($categories)>0){ ?>
                <ul>
                    <li>
                        <div class="checkbox">
                                <label>
                                    <input type="checkbox" class="online_store_filter categoryFilter" name="categories[]" id="category0" value="0"> <span class="categoryLabel0">All Categories</span>
                                </label>
                            </div>
                    </li>
                    <?php foreach($categories as $cat){ ?>
                        <li>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" class="online_store_filter categoryFilter" name="categories[]" id="category<?php echo $cat["id"];?>" value="<?php echo $cat["id"];?>"> <span class="categoryLabel<?php echo $cat["id"];?>"><?php echo $cat["name"];?></span>
                                </label>
                            </div>
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>
        </div>
      </div>
    </div>
    </div>
    <div class="panel-group" id="accordionSuppliers" role="tablist" aria-multiselectable="true">
    <div class="panel panel-default">
      <div class="panel-heading" role="tab" id="headingTwo">
        <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionSuppliers" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          Suppliers
        </a>
      </h4>
      </div>
      <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
        <div class="panel-body">
             <div class="form-group has-search">
                <span class="fa fa-search form-control-feedback"></span>
                <input type="text" class="form-control search_supplierz_users" placeholder="Search">
             </div>
             <div class="supplierz_users_container">
             </div>
  <?php 
  $supplierz_users = get_supplierz_users();
  if(count($supplierz_users)>0){ ?>
                <ul>
                    <li>
                        <div class="checkbox">
                                <label>
                                    <input type="checkbox" class="online_store_filter supplierFilter" name="suppliers[]" id="supplier0" value="0"> <span class="supplierLabel0">All Suppliers</span>
                                </label>
                            </div>
                    </li>
                    <?php foreach($supplierz_users as $supplierz){
                          $permissions_array = explode(";", $supplierz["permissions"]);
                          if((in_array(126, $permissions_array))){
                    ?>
                        <li>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" class="online_store_filter supplierFilter" name="suppliers[]" id="supplier<?php echo $supplierz["user_id"];?>" value="<?php echo $supplierz["user_id"];?>"> <span class="supplierLabel<?php echo $supplierz["user_id"];?>"><?php echo $supplierz['com_name'];?></span>
                                </label>
                            </div>
                        </li>
                    <?php } } ?>
                </ul>
            <?php } ?>
        </div>
      </div>
    </div>
  </div>
      </div>
      <!-- sidebar -->
      <!-- content -->
      <div class="col-lg-9">
            	<div class="row align-items-center mb-4 pb-1">
                    <div class="col-12">
                        <div class="product_header">
                            <div class="product_header_left">
                                <label>Sort By:</label>
                                <div class="custom_select">
                                    <select class="form-control form-control-sm" id="sort_by">
                                        <option value="order">Default Sorting</option>
                                        <option value="category">Category</option>
                                        <option value="supplier">Supplier</option>
                                        <option value="price">Price: Low to high</option>
                                        <option value="price-desc">Price: High to low</option>
                                    </select>
                                </div>
                            </div>
                            <!--<div class="product_header_right">
                            	<div class="products_view">
                                    <a href="javascript:Void(0);" class="shorting_icon grid active"><i class="ti-view-grid"></i></a>
                                    <a href="javascript:Void(0);" class="shorting_icon list"><i class="ti-layout-list-thumb"></i></a>
                                </div>
                                <div class="custom_select">
                                    <select class="form-control form-control-sm">
                                        <option value="">Showing</option>
                                        <option value="9">9</option>
                                        <option value="12">12</option>
                                        <option value="18">18</option>
                                    </select>
                                </div>
                            </div>-->
                        </div>
                    </div>
                </div> 
                <div class="row">
                    <div class="col-md-12 setFiltersContainer"></div>
                    
                    <div class="loader">
                                            <center>
                                                <img class="loading-image" src="<?php echo IMG;?>search.gif" alt="loading.." width="100px">
                                            </center>
                                    </div>
                </div>
                
                <div class="shop_container">
                    <div class="row">
                    <?php if(count($products)>0){
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
                                <input type="hidden" name="supplierz" id="supplierz<?php echo $product['component_id'];?>" value="<?php echo $product["company_id"];?>">
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
                                         <?php if($product["company_id"] != $this->session->userdata("company_id")){ ?>
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
                    }?>
                    </div>
                    <div class="row">
                    <div class="col-12">
                        <?php echo $links;?>
                    </div>
                    </div>
                </div>
        	</div>
    </div>
  </div>
</section>
                                    </div>
                            </div>
                        </div>
</div>
                                    