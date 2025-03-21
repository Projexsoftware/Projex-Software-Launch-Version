<form id="PurchaseOrderForm" method="POST" action="<?php echo SURL ?>purchase_orders/manual_purchase_order_process" onsubmit="return validateForm()" autocomplete="off">
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">shopping_cart</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Create Manual Purchase Order</h4>
                                        <br/>
                                        	<div class="form-group label-floating col-md-12">
                								<div class="col-md-3 text-right" style="margin-top:20px;"><b>Project For Purchase Order:</b></div>
                								<div class="col-md-9">
                								<select class="selectpicker" data-style="select-with-transition" title="Select Project For Purchase Order *" data-size="7" name="costing_id" id="costing_id" onchange="getCostingParts(this.value)" required="true">
                                                    <?php foreach($eprojects as $project){ ?>
                                                       <option value="<?php echo $project->costing_id; ?>"><?php echo $project->project_title; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <?php echo form_error('project_id', '<div class="custom_error">', '</div>'); ?>
                								</div>
                                        </div>
                                        <div class="form-group label-floating col-md-12">
                                                <div class="col-md-3 text-right" style="margin-top:20px;"><b>Name of supplier who will receive purchase order <small>*</small>:</b></div>
                                                <div class="col-md-9">
                    								<select class="selectpicker" data-style="select-with-transition" data-live-search="true" title="Select Supplier *" data-size="7" name="first_selected_supplier" id="first_selected_supplier" required="true">
                                                        <?php foreach ($suppliers as $key => $supplier) { ?>
                                                         <option value="<?php echo $supplier['supplier_id']; ?>"><?php echo $supplier['supplier_name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                        </div>
                                        <div class="form-group label-floating col-md-12">
                                                <div class="col-md-3 text-right" style="margin-top:20px;"><b>Filter by Supplier(s):</b></div>
                                                <div class="col-md-9">
                                                    <div class="suppliersContainer">
                        								<select class="selectpicker" data-style="select-with-transition" data-live-search="true" multiple="multiple" title="Select Suppliers" data-size="7" name="supplier_idd[]" id="supplier_id" onChange="setPartsForStages();">
                                                        </select>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label>Create all purchase orders for this supplier(s) <input type="checkbox" id="autoSupplierPurchaseOrder" name="autoSupplierPurchaseOrder" class="autoPurchaseOrder" value="1" disabled></label>
                                                    </div>
                                                </div>
                                        </div>
                                        <br/><br/>
                                        <div class="form-group label-floating col-md-12">
                                                <div class="col-md-3 text-right" style="margin-top:20px;"><b>Filter by Stage(s):</b></div>
                                                <div class="col-md-9">
                                                    <div class="stagesContainer">
                        								<select class="selectpicker" data-style="select-with-transition" data-live-search="true" multiple="multiple" title="Select Stages" data-size="7" name="stage_id[]" id="supplier_stage_id" onChange="setPartsForStages();">
                                                            
                                                        </select>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label>Create all purchase orders for this stage(s) <input type="checkbox" id="autoStagePurchaseOrder" name="autoStagePurchaseOrder" class="autoPurchaseOrder" value="1" disabled></label>
                                                    </div>
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
                                        <div class="form-group label-floating">
                                            <div class="col-md-6 text-left"><h4>Order new items not included in project costing</h4></div>
                                            <div class="col-md-6 text-right">
                                            <button type="button" class="btn btn-warning btn-fill add-new-item" value="0" onclick="addMore(this.value);"><i class="material-icons">add</i> Add New Item</button>
                                            <button type="button" class="btn btn-danger btn-fill removeallbtn"><i class="material-icons">delete</i> Remove All</button>
                                            <?php if(in_array(69, $this->session->userdata("permissions"))) {?>
                                            <button id="addcomponentbtn" class="btn btn-info btn-fill" type="button" data-toggle="modal" href="#addNewComponentModal"><i class="material-icons">add</i> Add Component</button>
                                            <?php } ?>
                                            
                                        </div>
                                        <br/>
                                        <div id="impneworderdiv">
                                            <div class="form-group label-floating col-md-12">
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
                                                        <tr class="nopartadded">
                                                            <td colspan="11">No Part added yet</td>
                                                        </tr>
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
                                                    <option value="Pending">Pending</option>
                                                                                    <?php
                                                  if(in_array(15, $this->session->userdata("permissions"))) {
                                                  ?>
                                                                                    <option value="Approved">Approved</option>
                                                                                    <?php } ?>
                                                                                    <?php
                                                  if(in_array(16, $this->session->userdata("permissions"))) {
                                                  ?>
                                                                                    <option value="Issued">Issued</option>
                                                                                    <?php } ?>
                                                                                </select>
                                            </td>
                                          </tr>
                                          <tr>
                                                <td>Total Additional Client Cost</td>
                                                <td>$</td>
                                                <td width="160"><input class="form-control" name="totaladd_cost" id="totaladd_cost" value="0.00"></td>
                                            </tr>
                                          </tbody>
                                          </table>
                                </div>
                            </div>
                        </div>
                         <div class="col-md-12" style="display: none" id="nipototal">
                            <div class="card">
                                <div class="card-content">
                                          <table class="calstable table">
                                            <tr>
                                                            <td>Hide from Project Sales Summary</td>
                                                            <td></td>
                                                            <td width="160">
                                                                <div class="checkbox">
                                                                   <label><input type="checkbox" id="hide_from_summary" name="hide_from_summary" value="1"></label>
                                                                </div>
                                                            </td>
                                                          </tr>
                                            <tr>
                                                <td>Create Variation </td>
                                                <td></td>
                                                <td width="160">
                                                    <div class="checkbox">
                                                                   <label><input type="checkbox" id="creatvariation" name="creatvariation" value="0" onchange="checkcreatvar(this.id)"></label>
                                                                </div> </td>
                                            </tr>
                                            <tr>
                                                <td>Variation Number </td>
                                                <td></td>
                                                <td width="160"><input class="form-control readonlyme" type="text" id="var_number" name="var_number" value="<?= 10000000 + $var_number  ?>" readonly></td>
                                            </tr>
                                            <tr>
                                                <td>Variation Description</td>
                                                <td></td>
                                                <td width="160">
                                                        <textarea class="form-control" rows="5"  id="varidescriptioin" name="varidescriptioin" placeholder="Variation Description *" ></textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td >Purchase Order Variation Subtotal</td>
                                                <td>$</td>
                                                <td width="160"><input class="form-control readonlyme" name="total_cost" id="total_cost" value="0.00"  readonly></td>
                                            </tr>
                                            <tr>
                                                <td>Overhead Margin</td>
                                                <td>%</td>
                                                <td width="160"><input class="form-control cal-on-change" name="overhead_margin" id="overhead_margin" value="0.00"  ></td>
                                            </tr>
                                            <tr>
                                                <td>Profit Margin</td>
                                                <td>%</td>
                                                <td width="160"><input class="form-control cal-on-change" name="profit_margin" id="profit_margin" value="0.00" ></td>
                                            </tr>
                                            <tr>
                                                <td>Purchase Order Variation Subtotal</td>
                                                <td>$</td>
                                                <td width="160"><input class="form-control readonlyme" name="total_cost2" id="total_cost2" value="0.00"  readonly ></td>
                                            </tr>
                                            <tr>
                                                <td>Tax</td>
                                                <td>%</td>
                                                <td width="160"><input class="form-control cal-on-change" name="costing_tax" id="costing_tax" value="<?php echo get_company_tax();?>" ></td>
                                            </tr>
                                            <tr>
                                                <td >Purchase Order Variation Subtotal</td>
                                                <td>$</td>
                                                <td  width="160"> <input class="form-control readonlyme" name="total_cost3" id="total_cost3" value="0.00"  readonly></td>
                                            </tr>
                                            <tr>
                                                <td >Purchase Order Variation Rounding</td>
                                                <td>$</td>
                                                <td width="160"><input class="form-control cal-on-change" name="price_rounding" id="price_rounding" value="0.00" required ></td>
                                            </tr>
                                            <tr>
                                                <td >Purchase Order Variation Total </td>
                                                <td>$</td>
                                                <td  width="160"><input readonly class="form-control readonlyme" name="contract_price" id="contract_price" value="0.00" required ></td>
                                            </tr>
                                            <tr>
                                          </tr>
                                            <tr>
                                                <td >Purchase Order Variation Status </td>
                                                <td colspan="2" >
                                                    <select class="selectpicker" data-style="select-with-transition" title="Select Status *" name="purchaseordervarstatus" id="purchaseordervarstatus" required="true">
                                                        <option value="Pending">Pending</option>
                                                        <option value="Issued">Issued</option>
                                                        <option value="Approved">Approved</option>
                                                        <option value="Sales Invoiced">Sales Invoiced</option>
                                                        <option value="Paid">Paid</option>
                                                    </select>
                                                </td>
                                            </tr>
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
                