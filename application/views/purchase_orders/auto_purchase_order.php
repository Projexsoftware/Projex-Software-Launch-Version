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
               <div id='estimatewarning' class='alert alert-danger' style='display:none'>Warning: This project costing contains estimated costs.</div>
               <form id="ProjectVariationForm" method="POST" action="<?php echo SURL ?>project_variations/saveprojectvariation" onsubmit="return validateForm()">
                    <input type="hidden" id="costing_id" name="costing_id">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">trending_down</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Add Variation</h4>
				                    	<div class="form-group label-floating">
                								<select class="selectpicker" data-style="select-with-transition" title="Select Project For adding variation *" data-size="7" name="project_id" id="project_id" onchange="get_stages(this.value)" required="true">
                                                    <?php foreach($projects as $project){ ?>
                                                       <option value="<?php echo $project->project_id; ?>"><?php echo $project->project_title; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <?php echo form_error('project_id', '<div class="custom_error">', '</div>'); ?>
                                        </div>
                                        <div class="form-group label-floating">
                								<select class="selectpicker" data-style="select-with-transition" title="Select Stage For adding variation" data-size="7" name="extstages" id="extstages" onchange="getParts(this.value, 'stage');">
                                                    
                                                </select>
                                        </div>
                                        <div class="form-group label-floating">
                								<select class="selectpicker" data-style="select-with-transition" title="Select Suppliers For adding variation" data-size="7" name="extsuppliers" id="extsuppliers" onchange="getParts(this.value, 'supplier');">
                                                    
                                                </select>
                                        </div>
                                        <div class="form-group label-floating">
                								<input class="form-control" type="hidden"  name="var_number" value="<?= 10000000 + $var_number  ?>">
                                                <label>Variation Number:</label>
                                                <?= 10000000 + $var_number  ?>
                                        </div>
                                        <div class="form-group label-floating">
                								<input class="form-control" type="text" name="variname" id="variname" value="" placeholder="Enter Initiated Variation *" required="true" uniqueVariation="true">
                                                <?php echo form_error('variname', '<div class="custom_error">', '</div>'); ?>
                                        </div>
                                        <div class="form-group label-floating">
                								<textarea class="form-control" type="text" name="varidescription" id="varidescription" value="" placeholder="Variation Description *" required="true"></textarea>
                                                <?php echo form_error('varidescription', '<div class="custom_error">', '</div>'); ?>
                                        </div>
                                        
                                        <div class="loader">
                                            <center>
                                                <img class="loading-image" src="<?php echo IMG;?>search.gif" alt="loading.." width="100px">
                                            </center>
                                        </div>
                                        <div class="form-group label-floating">
                                           <div class="table-responsive">
                                                 <table id="partstable" class="table sortable_table templates_table">
                                                   <thead>
                                                       <tr>
    
                                                        <th>Stage</th>
                            
                                                        <th>Part</th>
                            
                                                        <th>Component</th>
                            
                                                        <th>Supplier</th>
                            
                                                        <th>Uninvoiced Quantity</th>
                                                        
                                                        <th>Uninvoiced Budget</th>
                            
                                                        <th>Change Quantity</th>
                            
                                                        <th>Updated Quantity</th>
                            
                                                        <th>Unit Of Measure</th>
                            
                                                        <th>Unit Cost</th>
                            
                                                        <th>Additional cost</th>
                            
                                                        <th>Additional cost charged to client</th>
                                                        <th>Status</th>
                            
                                                        <th>Include in specifications</th>
                            
                                                        <th>Client Allowance</th>
                            
                                                        <th>Action</th>
                            
                                                    </tr>
                                                   </thead>
                                                   <tbody>
                                                        
                                                   </tbody>
                                                   </table>
                                           </div>
                                        </div>
                                        <div class="form-footer text-right">
                                            <button type="button" class="btn btn-warning btn-fill" value="0" onclick="addMore(this.value);"><i class="material-icons">add</i> Add Part</button>
                                            <button type="button" class="btn btn-danger btn-fill removeallbtn"><i class="material-icons">delete</i> Remove All</button>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-content">
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
                                            <td >Variation Subtotal</td>
                                            <td>$</td>
                                            <td width="160"><input class="form-control" name="total_cost" id="total_cost" value="0.00"  readonly></td>
                                          </tr>
                                          <tr>
                                            <td>Overhead margin</td>
                                            <td>%</td>
                                            <td width="160"><input class="form-control cal-on-change" name="overhead_margin" id="overhead_margin" value="0.00"  ></td>
                                          </tr>
                                          <tr>
                                            <td>Profit margin</td>
                                            <td>%</td>
                                            <td width="160"><input class="form-control cal-on-change" name="profit_margin" id="profit_margin" value="0.00" ></td>
                                          </tr>
                                          <tr>
                                            <td>Variation subtotal</td>
                                            <td>$</td>
                                            <td width="160"><input class="form-control" name="total_cost2" id="total_cost2" value="0.00"  readonly ></td>
                                          </tr>
                                          <tr>
                                            <td>Tax</td>
                                            <td>%</td>
                                            <td width="160"><input class="form-control cal-on-change" name="costing_tax" id="costing_tax" value="<?php echo get_company_tax();?>" ></td>
                                          </tr>
                                          <tr>
                                            <td >Variation subtotal</td>
                                            <td>$</td>
                                            <td  width="160"><input class="form-control" name="total_cost3" id="total_cost3" value="0.00"  readonly></td>
                                          </tr>
                                          <tr>
                                            <td >Variation Price Rounding / Profit Adjustment</td>
                                            <td>$</td>
                                            <td width="160"><input class="form-control  roundme" name="price_rounding" id="price_rounding" value="0.00" required ></td>
                                          </tr>
                                          <tr>
                                            <td >Variation Contract Price</td>
                                            <td>$</td>
                                            <td  width="160"><input class="form-control" name="contract_price" id="contract_price" value="0.00" required ></td>
                                          </tr>
                                          <tr>
                                        <td colspan="2">Status</td>
                                        <td width="160">

                                        <select class="form-control" name="variationstatus" id="variationstatus"  required>

                                            <option value="">Select Status</option>

                                            <option value="PENDING">PENDING</option>
                                            <?php if(in_array(10, $this->session->userdata("permissions"))){ ?>
                                            <option value="ISSUED">ISSUED</option>
                                            <?php } ?>
                                            <?php if(in_array(9, $this->session->userdata("permissions"))){ ?>
                                            <option value="APPROVED">APPROVED</option>
                                            <?php } ?>

                                            <option value="SALES INVOICED">SALES INVOICED</option>

                                            <option value="PAID">PAID</option>

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
                                            <button type="submit" class="btn btn-warning btn-fill">Save Variation</button>
                                         </div>
                                         <div class="pull-right">
                                            <a href="<?php echo SURL;?>project_variations" class="btn btn-default btn-fill">Close</a>
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
<div class="modal fade" id="change_supplier">
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
<div class="modal fade" id="error_no_pc_for_this_project">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="alert alert-info"><strong>Info!</strong> There are no uninvoiced components for the selected project</div>'
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
                <div class="alert alert-info"><strong>Info!</strong> There are no uninvoiced components for the selected supplier</div>'
            </div>

            <div class="modal-footer">
                 <button class="btn btn-sm btn-success" data-dismiss="modal" aria-hidden="true">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="error_no_pc_for_this_stage">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="alert alert-info"><strong>Info!</strong> There are no uninvoiced components in this stage</div>'
            </div>

            <div class="modal-footer">
                 <button class="btn btn-sm btn-success" data-dismiss="modal" aria-hidden="true">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
                