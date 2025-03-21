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
              p.text-danger{
                  margin-bottom:0px;
              }
          </style> 
               <div id='estimatewarning' class='alert alert-danger' style='display:none'>Warning: This project costing contains estimated costs.</div>
               <form id="SupplierCreditForm" method="POST" action="<?php echo SURL ?>supplier_credits/insertcredit" onsubmit="return validateForm()" autocomplete="off">
                    <input type="hidden" id="costing_id" name="costing_id">
                    <input type="hidden" class="form-control" name="totaladd_cost" id="totaladd_cost" value="0.00">
                    <input type="hidden" class="form-control" name="totaladdclient_cost" id="totaladdclient_cost" value="0.00">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">credit_card</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Create Supplier Credit</h4>
				                    	<div class="row">
                                             <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="form-group label-floating col-md-6">
                                                    <label>Select Project For Supplier Credit <small>*</small></label>
                                                    <select class="selectpicker" data-style="select-with-transition" name="project_id" id="project_id" title="Select Project" onchange="getsupplierbycostingid(this.value)" required>
                                                        <?php foreach ($projects as $project) { ?>
                                                            <option value="<?php echo $project->costing_id; ?>"><?php echo $project->project_title; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <?php echo form_error('project_id', '<div class="custom_error">', '</div>'); ?>
                                                </div>
                                                <div class="form-group label-floating col-md-6">
                                                        <label>Select Supplier for Current Project <small>*</small></label>
                                                           <select class="selectpicker" data-style="select-with-transition" name="supplier_id" id="supplier_id" onchange="change_supplier(this.value)" title="Select Supplier" required data-live-search="true">
                                                            </select>
                                                            <?php echo form_error('supplier_id', '<div class="custom_error">', '</div>'); ?>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                             <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="form-group label-floating col-md-6">
                                                    <label>Enter Credit Reference <small>*</small></label>
                                                    <input class="form-control" name="creditreference" id="creditreference" type="text"  required>
                                                    <?php echo form_error('supplierrefrence', '<div class="custom_error">', '</div>'); ?>
                                                </div>
                                                <div class="form-group label-floating col-md-6">
                                                        <label>Enter Credit Amount Excluding GST <small>*</small></label>
                                                           <input class="form-control" name="creditamountist" id="creditamountist" type="text" required number="true">
                                                           <?php echo form_error('creditamountist', '<div class="custom_error">', '</div>'); ?>
                                                </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                             <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="form-group label-floating col-md-6">
                                                    <label>Enter Credit Date <small>*</small></label>
                                                    <input class="form-control datepicker" name="creditdate" id="creditdate" type="text"  required>
                                                    <?php echo form_error('creditdate', '<div class="custom_error">', '</div>'); ?>
                                                </div>
                                                <div class="form-group label-floating col-md-6">
                                                        &nbsp;
                                                </div>
                                        </div>
                                    </div>
                                        
                                        <div class="loader">
                                            <center>
                                                <img class="loading-image" src="<?php echo IMG;?>search.gif" alt="loading.." width="100px">
                                            </center>
                                        </div>
                                        <div class="text-right">
                                            <button type="button" class="btn btn-warning btn-fill" value="0" onclick="addMore(this.value);"><i class="material-icons">add</i> Add New Items</button>
                                        </div>
                                        <div class="form-group label-floating">
                                           <div class="table-responsive">
                                                 <table id="impcos1" class="table sortable_table templates_table">
                                                   <thead>
                                                       <tr><td colspan="12">Import new items not included project costing</td></tr>
                                                       <tr>
                                                           <td colspan="6"><span id="projecttitleimp">My Project</span></td>
                                                           <td colspan="6">Supplier Credits</td>
                                                       </tr>
                                                       <tr>
    
                                                        <th>Stage</th>
                                                        <th>Part</th>
                                                        <th>Component</th>
                                                        <th>Supplier</th>
                                                        <th>Unit Of Measure</th>
                                                        <th>Unit Cost</th>
                                                        <th>Quantity</th>
                                                        <th>Credit Amount</th>
                                                        <th>Action</th>
                            
                                                    </tr>
                                                   </thead>
                                                   <tbody>
                                                        
                                                   </tbody>
                                                   </table>
                                           </div>
                                        </div>
                                        <div id="pcdiv"> </div>
                                    </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-content">
                                   
                                    <table class="table calstable">
                                      <tbody>
                                          <tr>
                                            <td>Credit Amount Entered <small>*</small></td>
                                            <td>$</td>
                                            <td width="160">
                                                <input class="form-control" name="creditamountent" id="creditamountent" value="0.00" required number="true">
                                                <?php echo form_error('creditamountent', '<div class="custom_error">', '</div>'); ?>
                                            </td>
                                          </tr>
                                           <tr>
                                                <td >Amount Not Entered <small>*</small></td>
                                                <td>$</td>
                                                <td width="160">
                                                    <input class="form-control" name="creditamountnotent" id="creditamountnotent" value="0.00" required number="true">
                                                    <?php echo form_error('creditamountnotent', '<div class="custom_error">', '</div>'); ?>
                                                </td>
                                            </tr>
                                          
                                          <tr>
                                        <td colspan="2">Credit Status <small>*</small></td>
                                        <td width="160">

                                        <select class="selectpicker" data-style="select-with-transition" name="suppliercreditstatus" id="suppliercreditstatus"  title="Select Status" required>
                                            <option value="Pending">Pending</option>
                                            <?php
                                              if(in_array(22, $this->session->userdata("permissions"))) {
                                            ?><option value="Approved">Approved</option>
                                            <?php } ?>
                                        </select>
                                        <?php echo form_error('suppliercreditstatus', '<div class="custom_error">', '</div>'); ?>

                                    </td>

                                </tr>
                                      </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" id="suppintot" style="display: none;">
                            <div class="card">
                                <div class="card-content">
                                    <div class="alert alert-info" style=" display: none" id="createvariationwarn">
                                        <strong>Info!</strong> You should get prior approval from client before creating this variation, the Supplier Credit can only be created for approved variations. 
                                    </div>
                                    <table class="table">
                                      <tbody>
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
                                                   <label><input type="checkbox" id="createvariation" name="createvariation" value="0" onchange="checkcreatvar(this.id)"></label>
                                                </div>
                                                </td>
                                        </tr>
                                        <tr>
                                            <td>Variation Number <small>*</small></td>
                                            <td colspan="2"><input class="form-control readonlyme" type="text" id="var_number" name="var_number" value="<?= 10000000 + $var_number ?>" readonly></td>
                                        </tr>
                                        <tr>
                                            <td>Variation Description <small>*</small></td>
                                            <td colspan="2">
                                                    <textarea class="form-control notrequired" rows="5"  id="varidescriptioin" name="varidescriptioin" placeholder="Variation Description *"></textarea>
                                            </td>              
                                        </tr>
                                          <tr>
                                            <td>Supplier Credit Variation Subtotal <small>*</small></td>
                                            <td>$</td>
                                            <td width="160"><input class="form-control notrequired" name="total_cost" id="total_cost" value="0.00"  readonly></td>
                                          </tr>
                                          <tr>
                                            <td>Overhead Margin <small>*</small></td>
                                            <td>%</td>
                                            <td width="160"><input class="form-control cal-on-change notrequired" name="overhead_margin" id="overhead_margin" value="0.00"></td>
                                          </tr>
                                          <tr>
                                            <td>Profit Margin <small>*</small></td>
                                            <td>%</td>
                                            <td width="160"><input class="form-control cal-on-change notrequired" name="profit_margin" id="profit_margin" value="0.00"></td>
                                          </tr>
                                          <tr>
                                            <td>Supplier Credit Variation Subtotal <small>*</small></td>
                                            <td>$</td>
                                            <td width="160"><input class="form-control notrequired" name="total_cost2" id="total_cost2" value="0.00"  readonly></td>
                                          </tr>
                                          <tr>
                                            <td>Tax <small>*</small></td>
                                            <td>%</td>
                                            <td width="160"><input class="form-control cal-on-change notrequired" name="costing_tax" id="costing_tax" value="<?php echo get_company_tax();?>"></td>
                                          </tr>
                                          <tr>
                                            <td>Supplier Credit Variation Subtotal <small>*</small></td>
                                            <td>$</td>
                                            <td  width="160"><input class="form-control notrequired" name="total_cost3" id="total_cost3" value="0.00"  readonly></td>
                                          </tr>
                                          <tr>
                                            <td >Supplier Credit Adjustment <small>*</small></td>
                                            <td>$</td>
                                            <td width="160"><input class="form-control notrequired roundme" name="price_rounding" id="price_rounding" value="0.00"></td>
                                          </tr>
                                          <tr>
                                            <td >Supplier Credit Variation Total <small>*</small></td>
                                            <td>$</td>
                                            <td  width="160"><input class="form-control notrequired" name="contract_price" id="contract_price" value="0.00"></td>
                                          </tr>
                                          <tr>
                                        <td colspan="2">Variation Status <small>*</small></td>
                                        <td width="160">

                                        <select class="selectpicker notrequired" data-style="select-with-transition" name="suppliercreditvarstatus" id="suppliercreditvarstatus" title="Select Status">

                                            <option value="PENDING">Pending</option>
                                            <?php
                                            if(in_array(10, $this->session->userdata("permissions"))) {
                                            ?>
                                              <option value="ISSUED">Issued</option>
                                            <?php } ?>
                                            <?php
                                            if(in_array(9, $this->session->userdata("permissions"))) {
                                            ?>
                                            <option value="APPROVED">Approved</option>
                                            <?php } ?>

                                        </select>

                                    </td>

                                </tr>
                                          <tr>
                                            <td colspan="2">Lock/Unlock</td>
                                            <td  width="160"><a class="btn btn-simple btn-success btn-icon" id="iconlockproject" onclick="LockProject()"><i class="material-icons lock_project_icon_type">lock_open</i></a>
                                              <input type="hidden" name="lockproject" id="lockproject" value="0"></td>
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
                                            <button type="submit" class="btn btn-warning btn-fill">Save Supplier Credit</button>
                                         </div>
                                         <div class="pull-right">
                                            <a href="<?php echo SURL;?>supplier_invoices" class="btn btn-default btn-fill">Close</a>
                                      </div>
                                     </div>
                                 </div>
                            </div>
                        </div>
                    </div>
                </form>
                    
    <div class="modal fade" id="change_project">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Do you really want to change project, all imported data will be removed</h4>
            </div>

            <div class="modal-footer">
                <input class="btn btn-sm btn-danger" data-dismiss="modal" value="Yes" onclick="changeproject()">
                <input class="btn btn-sm btn-success" data-dismiss="modal" value="No" onclick="donotchangeproject()">

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="change_supplierm">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Do you really want to change supplier, all imported data will be removed</h4>
            </div>

            <div class="modal-footer">
                <input class="btn btn-sm btn-danger" data-dismiss="modal" value="Yes" onclick="changesupplier()">
                <input class="btn btn-sm btn-success" data-dismiss="modal" value="No" onclick="donotchangesupplier()">

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="change_stage">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Do you really want to change stage, all imported data will be removed</h4>
            </div>

            <div class="modal-footer">
                <input class="btn btn-sm btn-danger" data-dismiss="modal" value="Yes" onclick="changestage()">
                <input class="btn btn-sm btn-success" data-dismiss="modal" value="No" onclick="donotchangestage()">

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="error_no_po_for_this_supplier">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="alert alert-info"><strong>Info!</strong> No approved purchase order with uninvoiced quantity set for this supplier</div>
            </div>

            <div class="modal-footer">
                 <button class="btn btn-sm btn-success" data-dismiss="modal" aria-hidden="true">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="error_no_pc_for_this_supplier">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="alert alert-info"><strong>Info!</strong> No project part costing without purchase order for this supplier</div>
            </div>

            <div class="modal-footer">
                 <button class="btn btn-sm btn-success" data-dismiss="modal" aria-hidden="true">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!--Upodate component cost-->

<div id="componentCostModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
        <h4>The Invoice Unit Cost appears to be different to the current component Unit Cost. Do you want to update the component Unit Cost?</h4>
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
                