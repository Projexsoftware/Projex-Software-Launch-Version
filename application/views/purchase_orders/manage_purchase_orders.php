<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">shopping_cart</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Purchase Orders</h4> 
                                    <div class="toolbar">
                                     <?php if(in_array(13, $this->session->userdata("permissions"))) {?>
                                        <a href="<?php echo SURL;?>purchase_orders/add_purchase_order" class="btn btn-info"><i class="material-icons">add</i> Add Purchase Order</a>
                                     <?php } ?>
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
									</div>
                                    <div class="material-datatables">
                                        <ul class="nav nav-pills nav-pills-warning">
                                            <li class="active"><a href="#activeProjectPurchaseOrders" data-toggle="tab">Active</a></li>
                                            <li><a href="#completedProjectPurchaseOrders" data-toggle="tab" onclick="get_completed_job_purchase_orders();">Completed</a></li>
                                        </ul>
                                    	<div class="tab-content">
                                    	    <div class="tab-pane active" id="activeProjectPurchaseOrders">
                                            	 <table class="table table-striped table-no-bordered table-hover datatables" cellspacing="0" width="100%" style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Project Name </th> 
                                                                        <th>PO Number </th> 
                                            							<th>Supplier</th>
                                                                        <th>Created Date</th>
                                                                        <th>Status</th>
                                                                        <th class="disabled-sorting text-right">Actions</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                            						<?php 
                                            						$i=1;
                                                                    foreach($purchase_orders as $po) {?>
                                                                    <tr class="row_<?php echo $po["id"];?>">
                                                                        <td><?php echo $i;?></td>
                                                                        <td><?php echo get_project_name($po["project_id"]); ?></td>
                                                                        <td><?php echo $po['id']; ?></td>
                                                                        <td><?php if($po['supplier_id'] == 0){ echo get_po_suppliers_name($po['id']); } else { echo $po['supplier_name']; }?></td>
                                                                        
                                                                        <td><?php echo date('d/m/Y',strtotime($po["created_date"])); ?></td>
                                                                        <td>
                                                                            <input type="hidden" id="supplier_invoice_id_<?php echo $po['id'];?>" value="<?php echo $po['supplier_invoice_id'];?>">
                                                                            <div class="status_container_<?php echo $po['id'];?>">
                                                                             <select onchange="update_status(<?php echo $po['id'];?>);" 
                                                                             <?php if ($po['order_status'] == "Cancelled"  ) {
                                                                                    echo "style='pointer-events: none;'";
                                                                                } ?> class="form-control edit-input" name="status" id="status_<?php echo $po['id'];?>">
                                                                                
                                                                                <option <?php
                                                                                if ($po['order_status'] == "Cancelled") {
                                                                                    echo "selected";
                                                                                }
                                                                                ?> value="Cancelled ">Cancelled</option>
                                                                                <option 
                                                                                    <?php if ($po['order_status'] != "Pending") {
                                                                                    echo "disabled";
                                                                                } ?>
                                                                                    <?php
                                                                                if ($po['order_status'] == "Pending") {
                                                                                    echo "selected";
                                                                                }                                       
                                                                                ?>  value="Pending" >Pending</option>
                                                                                <option <?php
                                                                                if ($po['order_status'] == "Approved") {
                                                                                    echo "selected";
                                                                                }                                        
                                                                                ?> value="Approved" >Approved</option>
                                                                                <option <?php
                                                                                if ($po['order_status'] == "Issued") {
                                                                                    echo "selected";
                                                                                }
                                                                                ?> value="Issued" >Issued</option>
                                                                            </select>
                                                                            <br/>
                                                                            <?php 
                                                                            if ( $po['order_status'] == "Cancelled" ) { ?>
                                                                                <span id="<?php echo $po['id'];?>" class="label label-danger status_label edit"><?php echo $po['order_status'] ?></span><?php } 
                                                                            else if ($po['order_status'] == "Pending" ) { ?>
                                                                                <span id="<?php echo $po['id'];?>" class="label label-warning status_label edit"><?php echo $po['order_status'] ?></span><?php }    
                                                                            else if ($po['order_status'] == "Approved" ) { ?>
                                                                                <span id="<?php echo $po['id'];?>" class="label label-success status_label edit"><?php echo $po['order_status'] ?></span><?php }     
                                                                            else if ($po['order_status'] == "Issued") {?>
                                                                                <span id="<?php echo $po['id'];?>" class="label label-success status_label edit"><?php echo $po['order_status'] ?></span><?php } ?>
                                                                            <?php if ($po['supplier_invoice_id'] !=0) { 
                                                                            ?>&nbsp;<span id="<?php echo $po['id'];?>" class="label label-primary status_label eidt"><?php echo 'From Supplier Invoice'; ?></span>
                                                                            <?php } ?> 
                                                                            </div>
                                                                            <br/>
                                        								</td>
                                                                        <td class="text-right" >
                                                                            <?php if(in_array(12, $this->session->userdata("permissions")) || in_array(14, $this->session->userdata("permissions"))) {?>
                                                                           <a href="<?php echo SURL;?>purchase_orders/pporder/<?php echo $po["id"];?>" class="btn btn-simple btn-warning btn-icon edit"><i class="material-icons">edit</i></a>
                                                                           <?php } ?>
                                                                        </td>
                    
                                                                    </tr>
                                                                    <?php 
                    												$i++;
                    												} ?>
                                                                </tbody>
                                                            </table>
                                            </div>
                                            <div class="tab-pane" id="completedProjectPurchaseOrders">
                                                 <div class="loader">
                                                    <center>
                                                        <img class="loading-image" src="<?php echo IMG;?>search.gif" alt="loading.." width="100px">
                                                    </center>
                                                </div>
                                            	 <table id="completedJobsPurchaseOrders" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Project Name </th> 
                                                                        <th>PO Number </th> 
                                            							<th>Supplier</th>
                                                                        <th>Created Date</th>
                                                                        <th>Status</th>
                                                                        <th class="disabled-sorting text-right">Actions</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="completed_purchase_orders">
                                            						
                                                                </tbody>
                                                            </table>
                                            </div>
                                    	</div>
                                    </div>
                                </div>
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
                    
<script>
    $(document).ready(function() {
    $(".edit-input").attr('style','display:none !important');
    $("body").on("click", 'span.edit', function (e) {
        var dad = $(this).parent();
        var id = $(this).attr("id");
        dad.find('span.status_label').hide();
        $("#status_"+id).attr('style','display:block !important');
    });
    $("body").on("blur", 'select', function (e) {
        var id = $(this).attr("id");
        $(this).hide();
        var span_id = id.split("_");
        $("#"+span_id[1]).show();
    });
    $("body").on("change", 'select', function (e) {
        var id = $(this).attr("id");
        $(this).hide();
        var span_id = id.split("_");
        $("#"+span_id[1]).show();
    });
});
</script>