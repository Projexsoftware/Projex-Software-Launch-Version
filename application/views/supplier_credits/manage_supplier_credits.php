<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">credit_card</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Manage Supplier Credits</h4> 
                                    <div class="toolbar">
                                     <?php if(in_array(26, $this->session->userdata("permissions"))) {?>
                                        <a href="<?php echo SURL;?>supplier_credits/create_supplier_credit" class="btn btn-info"><i class="material-icons">add</i> Create Supplier Credit</a>
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
                                            <li class="active"><a href="#activeSupplierCredits" data-toggle="tab">Active</a></li>
                                            <li><a id="completedTab" href="#completedSupplierCredits" data-toggle="tab" onclick="get_completed_job_supplier_credits();">Completed</a></li>
                                        </ul>
                                    	<div class="tab-content">
                                    	    <div class="tab-pane active" id="activeSupplierCredits">
                                            	 <table class="table table-striped table-no-bordered table-hover datatables" cellspacing="0" width="100%" style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Supplier Credit #</th>
                                                                        <th>Project Name</th>
                                                                        <th>Supplier Name</th>
                                                                        <th>Supplier Credit Refrence</th>
                                                                        <th>Credit Amount</th>
                                                                        <th>Credit Date</th>
                                                                        <th>Created Date</th>
                                                                        <th>Status</th>
                                                                        <th class="disabled-sorting text-right">Actions</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                            						<?php 
                                            						$i=1;
                                                                    foreach($supplier_credits as $supplier_credit) {?>
                                                                    <tr class="row_<?php echo $supplier_credit['id'];?>">
                                                                        <td><?php echo $i;?></td>
                                                                        <td>
                                                                            <?php echo $supplier_credit['id']; ?> <?php if($supplier_credit['invoice_type']=="timesheet"){
                                                                                    echo '<i style="color:#777;" title="From Timesheet" class="fa fa-clock fa-lg"></i>';
                                                                            }?>
                                                                        </td>
                                                                        <td><?php echo $supplier_credit['project_title']; ?></td>
                                                                        <td><?php echo $supplier_credit['supplier_name']; ?></td>
                                                                        <td><?php echo $supplier_credit['supplierrefrence']; ?></td>
                                                                        <td><?php echo "$".number_format($supplier_credit['invoice_amount'],2,'.',''); ?></td>
                                                                        <td><?php echo date('d/m/Y', strtotime($supplier_credit['invoice_date'])); ?></td>
                                                                        <td><?php echo date('d/m/Y',strtotime($supplier_credit["created_date"])); ?></td>
                                                            <td>
                                                                <?php $amount_total_entered = $supplier_credit['invoice_amount'] - $supplier_credit['va_addclient_cost'];?>
                                                                <input type="hidden" name="invoice_amount" id="invoice_amount_<?php echo $supplier_credit['id'];?>" value="<?php echo $supplier_credit['invoice_amount'];?>">
                                                                <input type="hidden" name="amount_total_entered" id="amount_total_entered_<?php echo $supplier_credit['id'];?>" value="<?php echo $amount_total_entered;?>">
                                                                <div class="status_container_<?php echo $supplier_credit['id'];?>">
                                                                <?php if ($supplier_credit['status'] == "Pending") { 
                                                                ?><span id="<?php echo $supplier_credit['id'];?>" class="label label-danger status_label edit"><?php echo $supplier_credit['status'];?></span>
                                                                <?php } if ($supplier_credit['status'] == "Approved") { 
                                                                ?><span id="<?php echo $supplier_credit['id'];?>" class="label label-info status_label edit"><?php echo $supplier_credit['status'];?></span>
                                                                <?php } ?>  
                                                                
                                                                <select onchange="update_status(<?php echo $supplier_credit['id'];?>);" class="form-control edit-input <?php if ( $supplier_credit['status']!="Pending" &&  $supplier_credit['status']!="Approved" ) echo 'readonlyme' ?>" name="status" id="status_<?php echo $supplier_credit['id'];?>" <?php if ( $supplier_credit['status']!="Pending" &&  $supplier_credit['status']!="Approved" ) echo 'style="pointer-events: none;" '. 'readonly'?> required>
                                                                <option
                                                                    <?php echo ($supplier_credit['status']!='Pending')?  ' disabled ' :  '' ?>
                        
                                                                    <?php if($supplier_credit['status']=='Pending')  echo ' selected '?> value="Pending">Pending</option>
                                                                 <option<?php if($supplier_credit['status']=='Approved')  echo ' selected '?> value="Approved">Approved</option>
                                                                 </select>
                                   
                                                                
                                                            </div>
                                                            </td>
                                                            <td class="text-right">
                                                                <?php if(in_array(25, $this->session->userdata("permissions")) || in_array(27, $this->session->userdata("permissions"))) {?>
                                                                        <a href="<?php echo SURL;?>supplier_credits/viewcredit/<?php echo $supplier_credit["id"];?>" class="btn btn-simple btn-warning btn-icon edit"><i class="material-icons">edit</i></a>
                                                                <?php } ?>
                                                            </td>
                                                                    </tr>
                                                                    <?php 
                    												$i++;
                    												} ?>
                                                                </tbody>
                                                            </table>
                                            </div>
                                            <div class="tab-pane" id="completedeProjectSupplierCredits">
                                                 <div class="loader">
                                                    <center>
                                                        <img class="loading-image" src="<?php echo IMG;?>search.gif" alt="loading.." width="100px">
                                                    </center>
                                                </div>
                                                <div class="completed_supplier_credits">
                                            	 <table id="completedJobsSupplierCredits" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Supplier Credit #</th>
                                                                        <th>Project Name</th>
                                                                        <th>Supplier Name</th>
                                                                        <th>Supplier Credit Refrence</th>
                                                                        <th>Credit Amount</th>
                                                                        <th>Credit Date</th>
                                                                        <th>Created Date</th>
                                                                        <th>Status</th>
                                                                        <th class="disabled-sorting text-right">Actions</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                            						
                                                                </tbody>
                                                            </table>
                                                </div>
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
});

function get_completed_job_supplier_credits(){
         $.ajax({
            url: '<?php echo SURL.'supplier_credits/get_completed_job_supplier_credits' ?>',
            type: 'post',
            data: {},
            beforeSend: function() {
                      $('.loader').show();
            },
            success: function (result) {
                $('.loader').hide();
                $(".completed_supplier_credits").html(result);
                $('#completedJobsSupplierCredits').dataTable( {
                				"bJQueryUI": true,
                				"sPaginationType": "full_numbers",
                				"bSort":true,
                				"iDisplayLength": 25
                });
                $(".edit-input").attr('style','display:none !important');
            }
        });
    }
    
function update_status(id){
    var status = $('#status_'+id).val();
    var invoice_amount = $('#invoice_amount_'+id).val();
    var amount_total_entered = $('#amount_total_entered_'+id).val();
    $.ajax({
            url: '<?php echo SURL.'supplier_credits/update_status/' ?>',
            type: 'post',
            data: {id: id,status:status,invoice_amount:invoice_amount,amount_total_entered:amount_total_entered},
            beforeSend: function() {
              $('.loader').show();
            },
            success: function (response) {
               $('.loader').hide();
               $('.status_container_'+id).html(response);
               $('.status_container_'+id).next('span.edit').show();
            }
        });
    
}

</script>