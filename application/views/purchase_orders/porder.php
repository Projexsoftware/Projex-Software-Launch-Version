<?php
$include_in_report = 0;
$contract_allownce = 0;
$total_quantity = '';
$line_cost = '';
$over_head_margin = '';
$porfit_margin = '';
$sale_price = '';
?>

<div class="col-md-12 porder">
                            <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">shopping_cart</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Purchase Order Wizard</h4>
				                    
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
										<div id="error" class="alert alert-danger col-md-12" style="display:none;">
                                            <i class="material-icons" style="color:#fff;vertical-align: middle;">error</i> <span id="error_val"></span>
                                        </div>

                <div class="col-md-12">
                    <?php if($order_detail-> supplier_invoice_id != 0):?>
                        <div class="col-md-2">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="spost" name="spost" onchange="spost(this.id)"> Show more info
                                </label>
                            </div>
                        </div>
                    <?php endif ?>
                    
                    <div class="col-md-2">
                         <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="show_comments" name="show_comments" onchange="show_comments(this.id)" > Show comments
                                </label>
                            </div>
                    </div>
                        
                    <div class="col-md-3">
                        <div class="checkbox">
                            <label>
                                  <input type="checkbox" id="scic" name="scic" onchange="scic(this.id)" > Show Costing information Columns
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="checkbox">
                            <label>
                                  <input type="checkbox" id="showComponentDescription" name="showComponentDescription" onchange="showComponentDescription(this.id)" > Show Component Description
                            </label>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="checkbox">
                            <label>
                               <input type="checkbox" id="email_supplier" name="email_supplier" onchange="show_email_msg()"> Email to supplier
                            </label>
                        </div>
                    </div>
                  
                </div>
                <br/>
           
            <!----------- Select Template ----------------> 


            <form class="form-horizontal no-margin form-border" action="<?php echo SURL . 'purchase_orders/issue_order/' . $postatus["id"]; ?>"  method="post" name="costing" id="formWizard1" novalidate>
            <input type="hidden" id="button_type" name="button_type" value="1">
            <input type="hidden" id="supplier_id" name="supplier_id" value="<?php echo $order_detail->parent_supplier_id;?>">
                <div class="panel-body">
                    <div class="tab-content porderpanel">
                        <div id="porderpanel">
                             <style>
    
    #termandcond{font-size: 12px}
    #termandcond h3, .po_details_container h3{
        font-weight:bold;
    }
    #termandcond {
    padding: 8px 20px;
    border: 1px solid gray;
    color: #000000;
    margin: 8px 0;
    }
    .po_project_container{
        border:2px solid gray; padding:10px 0px;
    }
    #email_message{
        border:2px solid gray; 
        margin-bottom:20px; 
        display: none;
    }
    .po_details_container{
        text-align:center; 
        border:2px solid gray; 
        margin-bottom:20px;
    }
    .hidemeop,.hidemeop2,.hidemeop3,.hidemecomments, .component_description{display:none}
    
</style>
                             <div class="grey" id="email_message">
                                <h3 style="text-align: center;">Email Message</h3>
                                <textarea class="form-control ckeditor" rows="3" id="summernote" name="email_message"><?php if(isset($email_message["detail"])){ echo $email_message["detail"]; }?></textarea>
                            </div>
            
                            <div class="grey po_details_container">
                                
                                <h3>Purchase Order For <?php echo $order_detail->supplier_name?></h3>
                                <p>
                                    New Homes Design & Build Ltd., 336 Meeanee Road, Napier
                                    P: 06 843 8834 E: Info@homeworx.co.nz
                                </p>
                            </div>
                        
                        <div class="col-md-12 po_project_container">
                        <div class="col-md-12"><b>Project Name:</b> &nbsp;  <?= $projectinfo['project_title']?> </div>
                         <div class="col-md-12"><b>Project Adddress:</b> &nbsp;  <?= $projectinfo['street_pobox'].",".$projectinfo['suburb'].", ".$projectinfo['project_address_city'].", ".$projectinfo['project_address_state'].", ".$projectinfo['project_address_country'].", ".$projectinfo['project_zip'] ?> </div>
                        </div>
                        
                        <style>
                        	@media print {
                        	    table{
                        	        width:100%!important;
                        	        border-spacing: 0px!important;
                        	    }
								table tr th, table tr td {
									border: 1px solid #000000; !important;
									padding: 12px 8px!important;
								}
								table tr th {
								    font-weight: normal;
                                    color: #555;
                                    border: none;
                                    background-color: #f0f0f0;
                                    text-align:left!important;
                                    border: 1px solid #000000; !important;
								}
								#porderpanel, #termandcond {
                                    padding: 5px!important;
                                    border: 1px solid gray!important;
                                    color: #000000!important;
                                    margin: 8px 0!important;
                                }
                                #porderpanel h3{
                                    font-size:24px!important;
                                    margin-top: 20px!important;
                                    margin-bottom: 10px!important;
                                }
                                .porder, #porderpanel
                                {
                                    font-family: "Helvetica Neue",Helvetica,Arial,sans-serif!important;
                                    font-size: 14px!important;
                                    color: #333!important;
                                }
                                								
							}

                        </style>
                        <div class="clearfix"></div>
                            
                            <br/>
                            <br/>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>PO Number</th>    
                                        <th >Stage</th>  
                                        <th >Part</th>  
                                        <th >Component</th> 
                                        <th class="component_description">Component Description</th>
                                        <th >QTY</th>
                                        <th class="hidemeop3">Including in project costing or variation</th>
                                        <th >UOM</th>
                                        <th class="hidemecomments">Comments</th>
                                        <th class="hidemeop">COST</th>  
                                        <th class="hidemeop">TOTAL</th> 

                                    </tr>
                                    <?php 
                                    foreach ($order_items AS $pt => $pts): ?>
                                        <tr>
											
                                            <td ><?php echo $pts['purchase_order_id']?></td>    
                                            <!--<td ></td> --> 
                                            <td ><?php echo $pts['stage_name']?></td>  
                                            <td >
                                                <?php 
                                            $part_name_array = explode(", ", $pts['part_name']);
                                            if(isset($part_name_array[1]) && $part_name_array[1]!=""){
                                                echo $part_name_array[1];
                                            }
                                            else{
                                            echo $pts['part_name'];
                                            }
                                            ?>
                                            </td>  
                                            <td ><?php echo $pts['component_name']?></td>  
                                            <td class="component_description"><?php echo $pts['component_des']?></td>  
                                            <td ><?php echo number_format($pts['order_quantity'],2)?></td>
                                            <td class="hidemeop3"><input type="checkbox"  class="form-control" <?php if($pts['costing_part_id']) echo "checked" ?> style="pointer-events: none; position: relative" readonly > </td>
                                            <td ><?php echo $pts['costing_uom']?></td>
                                            <td class="hidemecomments"><?php echo $pts['comment'];?></td>
                                            <td class="hidemeop"><?php echo $pts['costing_uc']?></td>  
                                            <td class="hidemeop"><?php echo number_format($pts['costing_uc']*$pts['order_quantity'],2)?></td>
                                            
                                            <!-- td class="hidemeop"><?php //echo $pts['margin']?></td>  
                                            <td class="hidemeop"><?php //echo number_format($pts['line_margin'],2)?></td> -->
                                        </tr>

                                    <?php endforeach; ?>
                                </table>
                            </div>
                            <br/>
                        <table class="table hidemeop2 table-bordered">
                            <tbody>

                                <?php if($order_detail-> supplier_invoice_id != 0):?>
                                <tr>
                                    <th class="lighte">Supplier Invoice id (this order is completely invoiced by this supplier invoice) </th>
                                    
                                    <th width="160" colspan="2" ><a href="<?php echo SURL;?>supplier_invoices/viewinvoice/<?= $order_detail-> supplier_invoice_id ?>" target="_Blank"><?= $order_detail-> supplier_invoice_id ?></a></th>
                                </tr>
                                <?php endif ?>
                            </tbody>
                        </table>
                        
                        <div id="termandcond">
                            <h3>TERMS AND CONDITIONS</h3>
                            <?php 
                            $get_terms_and_conditions_for_company =  get_terms_and_conditions_for_company();
                            if($get_terms_and_conditions_for_company){
                                echo $get_terms_and_conditions_for_company;
                            }else{
                            ?>
                            <p><strong>Licensed Building Practitioner: </strong>Please ensure you are aware of all obligations including providing relevant LBP License classes for restricted building work.</p>
                            <p><strong>Health and Safety: </strong>You must comply with all relevant Health and Safety Regulations and ALL site specific site safety requirements including site induction. If you are unsure of your obligations contact the New Homes Design & Build Ltd. office or your Health and Safety advisor. NO DOGS ARE PERMITTED ON SITE.</p>
                            <p><strong>Waste Management: </strong>You are responsible for maintaining a clean and safe working environment. This includes cleaning up regularly after your work (including sweeping up any mud tracked inside) and removal of all waste from materials that you supplied to site.</p>
                            <p><strong>Project Schedule: </strong>Refer to the attached project schedule for the anticipated date you are required. This is a fluid document and updates will be available during construction. Please advise the New Homes Design & Build Ltd. office if you are unavailable at the scheduled time.</p>
                            <p><strong>Substitutions: </strong>Absolutely no substitutions allowed without prior written approval of the designer and New Homes Design & Build Ltd. Office. </p>
                            <p><strong>Invoicing and Payment: </strong>
                            Please note the following requirements to avoid processing delays:<br/>
                            <ol>
                                <li>All invoices require a Purchase Order. PO’s will be issued at the time of acceptance of your quote.</li>
                                <li>Additional works and variations will require a PO Number. This should be obtained from the New Homes Design & Build Ltd. Office by emailing info@homeworx or by phone.</li>
                                <li>Our payment terms are payment on the 20th month following, for invoices received by end of previous month (with valid purchase order). Invoices can be delivered by post to PO Box 3394, HB Mail Centre 4142 or emailed to invoice@homeworx.co.nz. </li>
                                <li>Invoices are subject to approval based on the amount claimed, work completed/goods supplied, acceptable quality and supply of warranty documentation/LBP memorandum.</li>
                                <li>We need to clearly demonstrate any additional costs to our clients, hence any additional works must be clearly itemised on a separate invoice.</li>
                            </ol>  
                            </p>
                            <p><strong>Compliance and Warranty Documents: </strong>Please supply all relevant documentation eg. Warranty, LBP memorandum, as-builts, producer statements, etc. with your final invoice.</p>
                            <?php }?>
                        </div>
                        </div>       
                    </div>
					
			<button class="btn btn-success" type="button" onclick= "issuepurchaseorder()"> Issue Purchase Order</button>
			
			<?php 
			$is_supplier_user = is_supplier_user($order_detail->supplier_id);
			if(($is_supplier_user) && $order_detail->is_order_send==0){ ?>
			<button class="btn btn-info" type="button" onclick= "send_order_direct_to_supplier()"> Send Order Direct to Supplier</button>
			<?php } ?>


                </div><!-- /panel -->

            </form>
            <?php if (isset($errorpur)) { ?>
                <div class="alert alert-danger"> <strong>Error!</strong> <?php echo $errorpur; ?> </div>
            <?php } ?>
            <div class="col-md-12">
             <form id="formToggleLine" class="form-horizontal no-margin form-border" action="<?php echo SURL . 'purchase_orders/changedpurchaseorderstatus/' . $postatus["id"]; ?>" method="post" name="addstage">
                    <table class="table">
                        <tbody>
                            <tr><td>PO Number</td><td><?php echo $postatus["id"] ?></td></tr>
                            <tr><td>Created Date</td><td><?php echo date("d-M-Y", strtotime($postatus["created_date"])); ?></td></tr>
                            <tr>
                                <td>Status</td>
                                <td>
                                    <div class="form-group">
                                    <select class="selectpicker" data-style="select-with-transition" id="porder_status" name="status" <?php if ($postatus["order_status"] == "Cancelled"  ) { echo "style='pointer-events: none;'";} ?>>
                                        
                                        <option <?php
                                        if ($postatus["order_status"] == "Cancelled") {
                                            echo "selected";
                                        }
                                        ?> value="Cancelled">Cancelled</option>
                                        <option 
                                            <?php if ($postatus["order_status"] != "Pending") {
                                            echo "disabled";
                                        } ?>
                                            <?php
                                        if ($postatus["order_status"] == "Pending") {
                                            echo "selected";
                                        }                                       
                                        ?>  value="Pending" <?php if ($postatus["order_status"] == "Send Order Direct to Supplier") {
                                            echo "disabled";
                                        } ?>>Pending</option>
                                        <?php if(in_array(15, $this->session->userdata("permissions"))) { ?>
                                        <option <?php
                                        if ($postatus["order_status"] == "Approved") {
                                            echo "selected";
                                        }                                        
                                        ?> value="Approved" <?php if ($postatus["order_status"] == "Send Order Direct to Supplier") {
                                            echo "disabled";
                                        } ?>>Approved</option>
                                        <?php } ?>
                                        <?php if(in_array(16, $this->session->userdata("permissions"))) { ?>
                                        <option <?php
                                        if ($postatus["order_status"] == "Issued") {
                                            echo "selected";
                                        }
                                        ?> value="Issued"  <?php if ($postatus["order_status"] == "Send Order Direct to Supplier") {
                                            echo "disabled";
                                        } ?>>Issued</option>
                                        <?php } ?>
                                        <option <?php
                                        if ($postatus["order_status"] == "Send Order Direct to Supplier") {
                                            echo "selected";
                                        }
                                        ?> disabled value="Send Order Direct to Supplier" >Send Order Direct to Supplier</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr> 
                            <td colspan="2">
                                <?php if($postatus["order_status"] == "Cancelled"){ ?>
                                    <div class="alert alert-info col-md-12">
                                        <i class="material-icons" style="color:#fff;vertical-align: middle;">info</i> The status of Cancelled purchase order can not be updated
                                    </div>
                                <?php } else { ?>
                                   <?php
      if(in_array(14, $this->session->userdata("permissions"))) {
      ?> <button class="btn btn-warning">Update Purchase Order Status</button>
                                <?php  }  } ?>
                                <a href="<?php echo SURL;?>purchase_orders" class="btn btn-success">Close</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>

        </div>
    </div>
</div>
