          <style>
              .templates_table .form-control{
                  background-image: none;
                  border:1px solid #ccc!important;
                  padding:5px;
                  margin-top:12px;
              }
             .form-group.is-focused .templates_table .form-control{
                  background-image: none!important;
              }
              .part-form-control{
                  width:200px;
              }
              .uom-form-control, .uc-form-control{
                width:100px;
              }
              .no-padding{
                  padding:0px!important;
              }
              .btn-success{
                  margin-top: 0px;
              }
          </style> 
               <form id="PurchaseOrderForm" method="POST" action="<?php echo SURL ?>purchase_orders/update_purchase_order" onsubmit="return validateForm()">
                    <input type="hidden" name="costing_id" id="costing_id" value="<?php echo $pselected ?>">
                    <input type="hidden" id="porder_id" name="porder_id" value="<?php echo $porder_details["id"];?>">  
                     <input type="hidden" id="first_selected_supplier" name="first_selected_supplier" value="<?php echo $porder_details['supplier_id'];?>">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">shopping_cart</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Update Manual Purchase Order</h4>
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
                                        <br/>
                                        	<div class="form-group label-floating col-md-12">
                								<div class="col-md-3 text-right"><b>Project For Purchase Order:</b></div>
                								<div class="col-md-9"><?php echo $project_name['project_title']; ?></div>
                                        </div>
                                        <div class="form-group label-floating col-md-12">
                                                <div class="col-md-3 text-right"><b>Name of supplier who will receive purchase order:</b></div>
                                                <div class="col-md-9">
                    								<?php echo get_supplier_name($porder_details["supplier_id"]); ?>
                                                </div>
                                        </div>
                                        <div class="form-group label-floating filter_section col-md-12">
                                                <div class="col-md-3 text-right" style="margin-top:20px;"><b>Filter by Supplier(s):</b></div>
                                                <div class="col-md-9">
                    								<select class="selectpicker" data-style="select-with-transition" data-live-search="true" multiple="multiple" title="Select Suppliers" data-size="7" name="supplier_idd" id="supplier_id" onChange="getCostingbyFilter(this.value)">
                                                        <?php foreach ($suppliers as $key => $supplier) { ?>
                                                         <option value="<?php echo $supplier['supplier_id']; ?>"><?php echo $supplier['supplier_name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                        </div>
                                        <div class="form-group label-floating filter_section col-md-12">
                                                <div class="col-md-3 text-right" style="margin-top:20px;"><b>Filter by Stage(s)</b></div>
                                                <div class="col-md-9">
                    								<select class="selectpicker" data-style="select-with-transition" multiple="multiple" data-live-search="true" title="Select Stages" data-size="7" name="stage_id" id="stage_id" onChange="getCostingbyFilter(this.value)">
                                                      <?php 
                                                        foreach($stages as $stage){ ?>
                                                            <option  value="<?php echo $stage['stage_id'];?>" ><?php echo $stage['stage_name'];?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                        </div>
                                        <br/><br/><br/>
                                        <div class="loader">
                                            <center>
                                                <img class="loading-image" src="<?php echo IMG;?>search.gif" alt="loading.." width="100px">
                                            </center>
                                        </div>
                                        <div class="alert alert-info col-md-12" style=" display: none" id="creatvariationwarn">
                                              <i class="material-icons" style="color:#fff;vertical-align: middle;">info</i> You should get prior approval from client before creating this variation, the purchase order can only be created for approved variations.
                                        </div>
                                           <div class="form-footer">
                                            <div class="col-md-12 text-right">
                                            <a id="repopulateButton" class="btn btn-primary" role="button"  href="javascript:void(0)" onclick="repopulate_all_available_components();"><i class="material-icons">refresh</i> Repopulate All Available Components</a>
                                            <button type="button" class="btn btn-warning btn-fill" value="0" onclick="addMore(this.value);"><i class="material-icons">add</i> Add New Items</button>
                                            <button type="button" class="btn btn-danger btn-fill removeallbtn"><i class="material-icons">delete</i> Remove All</button>
                                            <?php if(in_array(69, $this->session->userdata("permissions"))) {?>
                                            <button id="addcomponentbtn" class="btn btn-info btn-fill" type="button" data-toggle="modal" href="#addNewComponentModal"><i class="material-icons">add</i> Add Component</button>
                                            <?php } ?>
                                            </div>
                                        </div>
                                        
                                            <div class="form-group label-floating col-md-12">
                                        <div id="impneworderdiv">
                                              
                                              <h4>Order new items not included in project costing</h4>
                                              <div class="table-responsive">
                                                <table id="impneworder" class="table sortable_table templates_table impneworder">            
                                                    <thead>            
                                                        <tr>            
                                                            <th>Stage</th>            
                                                            <th>Part</th>            
                                                            <th>Component</th>            
                                                            <th>Supplier</th>                
                                                            <th>Order Quantity</th>            
                                                            <th>Unit Of Measure</th>            
                                                            <th>Unit Cost</th>            
                                                            <th>Order Total</th>  
                                                            <th>Status</th>   
                                                            <th>Include in specifications</th>            
                                                            <th>Client Allowance</th>  
                                                            <th>Comments</th> 
                                                            <th>Action</th>      
                                                        </tr>            
                                                    </thead>            
                                                    <tbody>            
                                                        <tr id="impnopartadded" class="nopartadded">            
                                                            <td colspan="13">No Part added yet</td>            
                                                        </tr>            
                                                    </tbody>            
                                                </table>                            
                                            </div>
                                            </div>
                                        </div>
                                        <div class="form-group label-floating col-md-12">
                                           <div class="table-responsive">
                                                 <table id="partstable" class="table sortable_table templates_table">
                                                   <thead>
                                                       <tr>
    
                                                        <th>Stage</th>
                                                        <th>Part</th>
                                                        <th>Component</th>
                                                        <th>Supplier</th>
                                                        <th>Available Quantity</th>
                                                        <th>Unit Of Measure</th>
                                                        <th>Unit Cost</th>
                                                        <th>Line Total</th>
                                                        <th>Quantity Ordered</th>
                                                        <th>Order Unit Cost</th>
                                                        <th>Order Total</th>
                                                        
                            
                                                    </tr>
                                                   </thead>
                                                   <tbody>
                                                        <?php $count = 0;
if(count($porder_items)>0){
    foreach ($porder_items as $key => $value) {
        $ordered_quantity = get_ordered_quantity($value["costing_part_id"]);
        $updated_quantity = get_recent_quantity($value["costing_part_id"]);
        $porder_item = get_porder_detail($value["purchase_order_id"], $value["costing_part_id"]);
        
        if(count($updated_quantity)>0){
       
             $remaining_quantity = $updated_quantity['updated_quantity'] - $ordered_quantity;
        
        }
        else{
           $remaining_quantity = $value["costing_quantity"] - $ordered_quantity; 
        }
 ?>

<tr id="pmtrnumber<?php echo $count; ?>" tr_val="<?php echo $count; ?>">
    <input type="hidden" name="marginaddprojectcost_line[<?php echo $count; ?>]"  rno ='<?php echo $count ?>' id="marginaddprojectcost_line<?php echo $count ?>" class="form-control marginaddprojectcost_line" value="0.00"/>
<input type="hidden"  name="pmcosting_part_id[<?php echo $count; ?>]" value="<?php echo $value["costing_part_id"]; ?>">
<input type="hidden"  name="pmclient_allowance[<?php echo $count; ?>]" value="<?php echo $value["client_allowance"]; ?>">
<input type="hidden"  name="pminclude_in_specification[<?php echo $count; ?>]" value="<?php echo $value["include_in_specification"]; ?>">
<input type="hidden"  name="pmmargin_line[<?php echo $count; ?>]" value="<?php echo $value["line_margin"]; ?>">
<input type="hidden"  name="pmstatus[<?php echo $count; ?>]" value="<?php echo $value["type_status"]; ?>">
<input type="hidden"  name="pmcomment[<?php echo $count; ?>]" value="<?php echo $value["comment"]; ?>">

<td><input type="hidden" value="<?php echo $value["stage_id"]; ?>" name="pmstage[<?php echo $count; ?>]" ><?php echo $value["stage_name"]; ?></td>

 <td><input type="hidden"  name="pmpart[<?php echo $count; ?>]" id="pmpartfield<?php echo $count; ?>" value="<?php echo $value["part_name"]; ?>" rno ='<?php echo $count; ?>' class="form-control readonlyme" readonly /><?php 

 if( $value["is_variated"] > 0) 
    echo 'Variation Number: '.(10000000+$value["is_variated"]).', ';
 echo $value["part_name"] ;?></td>
    <td>

        <input type="hidden" name="pmcomponent[<?php echo $count; ?>]" id="pmcomponentfield<?php echo $count; ?>" rno ='<?php echo $count; ?>' value="<?php echo $value["component_id"]?>" class="form-control readonlyme" >
        <?php echo $value["component_name"]?>

    </td>
    <td>

        <input type="hidden" name="pmsupplier[<?php echo $count; ?>]" id="pmsupplierfield<?php echo $count; ?>" rno ='<?php echo $count; ?>' value="<?php echo $value['supplier_id']?>" class="form-control readonlyme" >
        <?php echo $value["supplier_name"]?>

    </td>
    <td><input  readonly  rno ="<?php echo $count; ?>" value="<?php echo $remaining_quantity; ?>" name="pmreqquantitys[<?php echo $count; ?>]" class="form-control readonlyme" id="pmreqquantity<?php echo $count; ?>"  ></td>

    <td><input readonly type="text"  name="pmuom[<?php echo $count; ?>]" id="pmuomfield<?php echo $count; ?>" rno ='<?php echo $count; ?>' value="<?php echo $value["costing_uom"]; ?>" class="form-control" width="5" /></td>
    <td><input type="text" readonly  name="pmucost[<?php echo $count; ?>]" id="pmucostfield<?php echo $count; ?>" rno ='<?php echo $count; ?>' class="form-control" value="<?php echo number_format($value["costing_uc"], 2, '.', ''); ?>" onchange="calculateTotal(this.getAttribute('rno'))"/></td>
    <td><input readonly type="text"  name="pmlinttotal[<?php echo $count; ?>]"  rno ='<?php echo $count; ?>' id="pmlinetotalfield<?php echo $count; ?>" class="form-control" value="<?php if($porder_item['porder_order_quantity']){ echo number_format($value["costing_uc"], 2, '.', '')*$porder_item['porder_order_quantity']; } else{ echo number_format(number_format($value["costing_uc"], 2, '.', '')*$remaining_quantity,2,'.', '');} ?>" /></td>
    <td>
        <div class="manualfield" id="pmmanualfield<?php echo $count; ?>">
        <input <?php if($remaining_quantity==0){?> readonly <?php } ?> name="pmmanualqty[<?php echo $count; ?>]" rno ='<?php echo $count; ?>' id="pmmanualqty<?php echo $count; ?>" type="text" class="form-control quantity_ordered" value="<?php if($porder_item['porder_order_quantity']){ echo $porder_item['porder_order_quantity'];}else{ echo "0";} ?>" ty='pm' onchange="calculateTotal(this.getAttribute('rno'),this.getAttribute('ty'));calculate_order_total(<?php echo $count ?>);"/>
        <input  readonly type="hidden" rno ='<?php echo $count; ?>' value="<?php echo $value["costing_quantity"]?>'];?>"  name="pmreqquantity[<?php echo $count; ?>]" class="form-control" id="pmreqquantity<?php echo $count; ?>"  >    
    
        </div>
        
    </td>
    <!-- <td></td> -->
    <input type="hidden" name="pmmargin[<?php echo $count; ?>]" id="pmmarginfield<?php echo $count; ?>" rno ='<?php echo $count; ?>' value="<?php echo $value["margin"]; ?>"  class="form-control readonlyme" readonly>
    <td><input  type="text" name="order_unit_cost[<?php echo $count; ?>]"  rno ='<?php echo $count ?>' id="order_unit_cost<?php echo $count ?>" class="form-control unit_cost" value="<?php if($porder_item['order_unit_cost']){ echo $porder_item['order_unit_cost'];}else{ echo number_format($value->costing_uc, 2, '.', '');} ?>" rowno="<?php echo $count ?>" onchange="calculate_order_total(<?php echo $count ?>);" <?php if( $remaining_quantity==0){ ?> readonly <?php } ?>/></td>
    <td><input readonly type="text" name="total_order[<?php echo $count; ?>]"  rno ='<?php echo $count ?>' id="total_order<?php echo $count ?>" class="form-control total_order total_order_cost" value="<?php if($porder_item['order_total']){ echo $porder_item['order_total'];}else{ echo "0.00";} ?>" <?php if( $remaining_quantity==0){ ?> readonly <?php } ?>/></td>

</tr>


<?php $count ++;
}
}else{
    ?>
<tr id="nopartadded" class="nopartadded"><td colspan="11">  No Part Added Yet </td> </tr>
    <?php
}

 ?>
                                                   </tbody>
                                                   </table>
                                           </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-content">
                                    <table class="table calstable">
                                      <tbody>
                                          <tr>
                                            <td>Purchase Order Status</td>
                                            <td></td>
                                            <td width="160">
                                                <select class="selectpicker" data-style="select-with-transition" title="Select Status *" name="purchaseorderstatus" id="purchaseorderstatus"  required="true">
                                                    <option value="Pending" <?php if($porder_details["order_status"]== "Pending"){?> selected <?php } ?> >Pending</option>
                                                                                    <?php
                                                  if(in_array(15, $this->session->userdata("permissions"))) {
                                                  ?>
                                                                                    <option value="Approved" <?php if($porder_details["order_status"] =="Approved"){?> selected <?php } ?> >Approved</option>
                                                                                    <?php } ?>
                                                                                    <?php
                                                  if(in_array(16, $this->session->userdata("permissions"))) {
                                                  ?>
                                                                                    <option value="Issued" <?php if($porder_details["order_status"] =="Issued"){?> selected <?php } ?> >Issued</option>
                                                                                    <?php } ?>
                                                                                </select>
                                            </td>
                                          </tr>
                                          </tbody>
                                    </table>
                                    <table class="calstable table" id="nipototal" <?php if(count($variation_details)>0){?> <?php } else { ?> style="display: none" <?php } ?>>
                                            <tbody>
                                            <tr>
                                                <td>Total Additional Client Cost</td>
                                                <td>$</td>
                                                <td width="160"><input class="form-control" name="totaladd_cost" id="totaladd_cost" value="<?php if(count($variation_details)>0){ echo $variation_details["project_subtotal1"]; } else { echo "0.00";}?>"></td>
                                            </tr>
                                            <tr>
                                                            <td>Hide from Project Sales Summary</td>
                                                            <td></td>
                                                            <td width="160">
                                                                <div class="checkbox">
                                                                   <label><input type="checkbox" id="hide_from_summary" name="hide_from_summary" value="1" <?php if(count($variation_details)>0 && $variation_details["hide_from_sales_summary"]){ ?> checked <?php } ?>></label>
                                                                </div>
                                                            </td>
                                                          </tr>
                                            <tr>
                                                <td>Create Variation </td>
                                                <td></td>
                                                <td width="160">
                                                    <div class="checkbox">
                                                                   <label><input type="checkbox" id="creatvariation" name="creatvariation" value="<?php if(count($variation_details)>0){ ?>1<?php } else{ ?> 0 <?php } ?>" <?php if(count($variation_details)>0){ ?> checked <?php } ?> onchange="checkcreatvar(this.id)"></label>
                                                                </div> </td>
                                            </tr>
                                            <tr>
                                                <td>Variation Number </td>
                                                <td></td>
                                                <td width="160"><input class="form-control readonlyme" type="text" id="var_number" name="var_number" value="<?php if(count($variation_details)>0){ echo $variation_details["var_number"];} else{ echo 10000000 + $var_number;}  ?>" readonly></td>
                                            </tr>
                                            <tr>
                                                <td>Variation Description</td>
                                                <td></td>
                                                <td width="160">
                                                        <textarea class="form-control" rows="5"  id="varidescriptioin" name="varidescriptioin" placeholder="Variation Description *" ><?php if(count($variation_details)>0){ echo $variation_details["variation_description"]; } ?></textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td >Purchase Order Variation Subtotal</td>
                                                <td>$</td>
                                                <td width="160"><input class="form-control readonlyme" name="total_cost" id="total_cost" value="<?php if(count($variation_details)>0){ echo $variation_details["project_subtotal1"]; } else { echo "0.00";}?>"  readonly></td>
                                            </tr>
                                            <tr>
                                                <td>Overhead Margin</td>
                                                <td>%</td>
                                                <td width="160"><input class="form-control cal-on-change" name="overhead_margin" id="overhead_margin" value="<?php if(count($variation_details)>0){ echo $variation_details["overhead_margin"]; } else { echo "0.00";}?>"  ></td>
                                            </tr>
                                            <tr>
                                                <td>Profit Margin</td>
                                                <td>%</td>
                                                <td width="160"><input class="form-control cal-on-change" name="profit_margin" id="profit_margin" value="<?php if(count($variation_details)>0){ echo $variation_details["profit_margin"]; } else { echo "0.00";}?>" ></td>
                                            </tr>
                                            <tr>
                                                <td>Purchase Order Variation Subtotal</td>
                                                <td>$</td>
                                                <td width="160"><input class="form-control readonlyme" name="total_cost2" id="total_cost2" value="<?php if(count($variation_details)>0){ echo $variation_details["project_subtotal2"]; } else { echo "0.00";}?>"  readonly ></td>
                                            </tr>
                                            <tr>
                                                <td>Tax</td>
                                                <td>%</td>
                                                <td width="160"><input class="form-control cal-on-change" name="costing_tax" id="costing_tax" value="<?php if(count($variation_details)>0){ echo $variation_details["tax"]; } else{ echo get_company_tax(); }?>" ></td>
                                            </tr>
                                            <tr>
                                                <td >Purchase Order Variation Subtotal</td>
                                                <td>$</td>
                                                <td  width="160"> <input class="form-control readonlyme" name="total_cost3" id="total_cost3" value="<?php if(count($variation_details)>0){ echo $variation_details["project_subtotal3"]; } else { echo "0.00";}?>"  readonly></td>
                                            </tr>
                                            <tr>
                                                <td >Purchase Order Variation Rounding</td>
                                                <td>$</td>
                                                <td width="160"><input class="form-control cal-on-change" name="price_rounding" id="price_rounding" value="<?php if(count($variation_details)>0){ echo $variation_details["project_price_rounding"]; } else { echo "0.00";}?>" required ></td>
                                            </tr>
                                            <tr>
                                                <td >Purchase Order Variation Total </td>
                                                <td>$</td>
                                                <td  width="160"><input readonly class="form-control readonlyme" name="contract_price" id="contract_price" value="<?php if(count($variation_details)>0){ echo $variation_details["project_contract_price"]; } else { echo "0.00";}?>" required ></td>
                                            </tr>
                                            <tr>
                                                <td >Purchase Order Variation Status </td>
                                                <td colspan="2" >
                                                    <select class="selectpicker" data-style="select-with-transition" title="Select Status *" name="purchaseordervarstatus" id="purchaseordervarstatus" required="true">
                                                        <option value="PENDING" <?php if(count($variation_details)>0 && $variation_details["status"] =="PENDING"){ ?> selected <?php } ?> >Pending</option>
                                                        <option value="ISSUED" <?php if(count($variation_details)>0 && $variation_details["status"] =="ISSUED"){ ?> selected <?php } ?> >Issued</option>
                                                        <option value="APPROVED" <?php if(count($variation_details)>0 && $variation_details["status"] =="APPROVED"){ ?> selected <?php } ?> >Approved</option>
                                                        <option value="SALES INVOICED" <?php if(count($variation_details)>0 && $variation_details["status"] =="SSALES INVOICED"){ ?> selected <?php } ?> >Sales Invoiced</option>
                                                        <option value="PAID" <?php if(count($variation_details)>0 && $variation_details["status"]=="PAID"){ ?> selected <?php } ?> >Paid</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            </tbody>
                                       </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-content">
                                     <div class="form-footer">
                                         <div class="pull-left">
                                            <button type="submit" class="btn btn-warning btn-fill">Save Order</button>
                                         </div>
                                         <div class="pull-right">
                                            <a href="<?php echo SURL;?>purchase_orders" class="btn btn-default btn-fill">Close</a>
                                      </div>
                                     </div>
                                 </div>
                            </div>
                        </div>
                    </div>
                </form>
                    
<div id="componentCostModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
        <h4>The Order Unit Cost appears to be different to the current component Unit Cost. Do you want to update the component Unit Cost?</h4>
       <form>
           <input type="hidden" id="update_component_id" value="">
           <input type="hidden" id="update_invoice_unit_cost" value="">
           <input type="hidden" id="update_rno" value="">
            <div class="form-group">
                <label for="current_unit_cost">Current Unit Cost:</label>
                <input type="text" class="form-control" id="current_unit_cost" name="current_unit_cost" value="" readonly>
            </div>
            <div class="form-group">
                <label for="current_unit_cost">Invoice Unit Cost:</label>
                <input type="text" class="form-control" id="invoice_unit_cost" name="invoice_unit_cost" value="" readonly>
            </div>
       </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" onclick="update_component_unit_cost();">Update</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Don't Update</button>
      </div>
    </div>

  </div>
</div>
                