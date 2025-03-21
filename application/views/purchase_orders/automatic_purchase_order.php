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
               <form id="PurchaseOrderForm" method="POST" action="<?php echo SURL ?>purchase_orders/automatic_purchase_order_process" onsubmit="return validateAutomaticForm()">
                    <input type="hidden" name="costing_id" id="costing_id" value="<?php echo $project_costing_id ?>">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">shopping_cart</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Create Automatic Purchase Order</h4>
                                        <br/>
                                        	<div class="form-group label-floating">
                								<div class="col-md-3 text-right"><b>Project For Purchase Order:</b></div>
                								<div class="col-md-9"><?php echo $project_name['project_title']; ?></div>
                                        </div>
                                        <div class="form-group label-floating">
                                                <div class="col-md-3 text-right" style="margin-top:20px;"><b>Supplier:</b></div>
                                                <div class="col-md-9">
                    								<select class="selectpicker" data-live-search="true" data-style="select-with-transition" title="Select Suppliers *" data-size="7" name="parent_supplier_id" id="parent_supplier_id" onChange="getCostingbysupplierauto(this.value);" required="true">
                                                        <option value="0" >All Suppliers</option>
                                                            <?php foreach ($suppliersprj as $key => $supplier) { ?>
                                                                <option value="<?php echo $supplier['costing_supplier']; ?>"><?php echo $supplier['supplier_name']; ?></option>
                                                            <?php } ?>
                                                    </select>
                                                </div>
                                        </div>
                                        <br/><br/>
                                        <div class="form-group label-floating" id="stagediv" style="display:none;">
                                                <div class="col-md-3 text-right" style="margin-top:20px;"><b>Stage:</b></div>
                                                <div class="col-md-9">
                    								<select class="selectpicker" data-style="select-with-transition" title="Select Stage" data-size="7" name="stage_id" id="sstages" onChange="getorderbysupplierandstage(this.value)">
                                                        
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
                                        <div class="form-group label-floating col-md-12">
                                        <div id="populate_supplier">
                                           <div class="table-responsive">
                                                 <table id="partstable" class="table table-no-bordered sortable_table templates_table">
                                                   <thead>
                                                       <tr>
    
                                                        <th>Stage</th>
                                                        <th>Part</th>
                                                        <th>Component</th>
                                                        <th>Supplier</th>
                                                        <th>Quantity</th>
                                                        <th>Unit Of Measure</th>
                                                        <th>Unit Cost</th>
                                                        <th>Line Total</th>
                            
                                                    </tr>
                                                   </thead>
                                                   <tbody>
                                                        <tr>
                                                            <td colspan="8">No Part added yet</td>
                                                        </tr>
                                                   </tbody>
                                                   </table>
                                           </div>
                                        </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-content">
                                     <div id="populateifnoorder"> </div>
                                     <input type="hidden" name="current_id" value="<?php echo $project_id; ?>"/>
                                     <div class="form-footer" id="actionsaveorview">
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
                