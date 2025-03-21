<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">linear_scale</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Component Orders</h4> 
                                    <div class="toolbar">
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
									 <div class="loader">
                                            <center>
                                                <img class="loading-image" src="<?php echo IMG;?>search.gif" alt="loading.." width="100px">
                                            </center>
                                    </div>
                                    <div class="material-datatables">
                                        
                        		
                                               <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                    							<thead>
                    								<tr>
                    									<th>S.No</th>
                    									<th>Order Receive Date</th>
                    									<th>Order No.</th>
                                                        <th>Company Name</th>
                                                        <th>Contact Name</th>
                                                        <th>Contact Number</th>
                                                        <th>Order Deliver Date</th>
                                                        <th>Status</th>
                    								</tr>
                    							</thead>
                    							<tbody>
                            <?php  $count =1; foreach($orders as $val) {
                                
                                 $user_info = get_price_book_supplier_info($val['user_id']);
                            		
                            	?>
								<tr>
									<td><?php echo $count;?></td>
									<td><?php echo date("d/m/Y", strtotime($val['order_received_date']));?></td>
									<td><a style="color:#428bca;" href="<?php echo SURL;?>supplierz/component_order_details/<?php echo $val['purchase_order_id'];?>">#<?php echo $val['purchase_order_id'];?></a></td>
										<td><?php echo $user_info['com_name'];?></td>
								<td><?php echo $user_info['user_fname']." ".$user_info['user_lname'];?></td>
								
									<td><?php echo $user_info['com_phone_no'];?></td>
									<td class="delivered_date<?php echo $val['id'];?>">
									<?php if($val['order_delivered_date']!=""){ echo date("d-M-Y", strtotime($val['order_delivered_date'])); }?>
									</td>
										<td>
										     <div class="status_container_<?php echo $val['id'];?>">
                                     <select onchange="update_status(<?php echo $val['id'];?>);" <?php if ($val['status'] == "2"  ) {
                                            echo "style='pointer-events: none;'";
                                        } ?> data-style="select-with-transition" class="form-control edit-input" name="status" id="status_<?php echo $val['id'];?>">
                                        
                                        <option <?php
                                        if ($val['status'] == "1") {
                                            echo "selected";
                                        } 
                                        else {
                                            echo "disabled";
                                        } 
                                        ?> value="1" >Order Received</option>
                                        
                                        <option <?php
                                        if ($val['status'] == "2") {
                                            echo "selected";
                                        } 
                                        
                                        ?> value="2" >Order Delivered</option>
                                        
                                        </select>
                                        <?php if($val['status'] == 1){
									   echo '<span id="'.$val['id'].'" class="label label-success status_label edit">Order Received</span>';   
									  } else if($val['status'] == 2){
									   echo '<span id="'.$val['id'].'" class="label label-success status_label edit">Order Delivered</span>'; 
									   
									   
									  }
									  ?>
                                        </div>
									  
									    
									</td>
                                   
								</tr>
                            <?php $count++;} ?>
							</tbody>
					                	</table>
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
});
    function update_status(id){
    var status = $('#status_'+id).val();
    $.ajax({
            url: '<?php echo SURL . 'supplierz/update_status/' ?>',
            type: 'post',
            data: {id: id,status:status},
            beforeSend: function() {
              $('.loader').show();
            },
            success: function (response) {
               $('.loader').hide();
               var html = response.split("|");
               $('.status_container_'+id).html(html[0]);
                $('.status_container_'+id).next('span.edit').show();
                $('.delivered_date'+id).text(html[1]);
                 $(".edit-input").attr('style','display:none !important');
               swal({
                           title: 'Order Delivered!',
                           text: 'Your order has been delivered.',
                           type: 'success',
                           confirmButtonClass: "btn btn-success",
                           buttonsStyling: false
                        })
            }
        });
    
}
</script>