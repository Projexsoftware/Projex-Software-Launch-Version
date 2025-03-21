  <div id='estimatewarning' class='alert alert-danger' style='display:none'>Warning: This project costing contains estimated costs.</div>
               
                        <div class="manual_project_costing_container">
                            <div class="card">
                                <div class="card-content">
                                     <div class="panel-group" id="accordionTemplate" role="tablist" aria-multiselectable="true">
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingOneTemplate">
                                                <a role="button" data-toggle="collapse" data-parent="#accordionTemplate" href="#collapseOneTemplate" aria-controls="collapseOneTemplate">
                                                    <h4 class="panel-title">
                                                        Import Items Section
                                                        <i class="material-icons">keyboard_arrow_down</i>
                                                    </h4>
                                                </a>
                                            </div>
                                            <div id="collapseOneTemplate" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOneTemplate">
                                                <div class="panel-body">
                                                    <div class="col-lg-3 col-md-3 col-sm-12">
                                                        <select data-container="body" class="selectFromProject" data-style="btn btn-warning btn-round" data-live-search="true" title="Select From Project" id="extproject_id" name="extproject_id" onchange="getCostingbyProject(this.value)">                 
                                                        
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-12">
                                                        <select data-container="body" class="selectFromTemplate" data-style="btn btn-warning btn-round" data-live-search="true" title="Select From Template" id="exttemplate_id" name="exttemplate_id" onchange="getCostingbyTemplate(this.value)">                 
                                                        
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                                    <form id="ProjectCostingCSVForm" method="POST" enctype="multipart/form-data">
                                                                        <div class="alert alert-danger import_file_error" style="display:none;"></div>
                                                                        <div class="label-floating">
                                                                            <label>
                                                                            Import CSV</label>
                                                                           <input type="file" id="importcsv"  name="importcsv" extension="csv" required="true">
                            				                        	</div>
                            				                        	<div class="label-floating">
                            				                        	    <button type="button" class="btn btn-warning btn-fill import-file-button">Import</button>
                            				                        	</div>
                        				                        	</form>
                        				                            <a href="<?php echo SURL;?>assets/csv/File_Import_Template.csv" class="btn btn-default">Click to View CSV Sample</a>
                        				                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                 </div>
                            </div>
                        </div>
               <form id="ProjectCostingForm" method="POST" action="<?php echo SURL ?>project_costing/savecost" onsubmit="return validateForm()" enctype="multipart/form-data">
                   <input type="hidden" name="is_takeoffdata_exists" id="is_takeoffdata_exists" value="0">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">house</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Add Project Costing</h4>
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
				                    	<div class="form-group label-floating project_list">
                								<select class="selectpicker" data-style="select-with-transition" title="Select Project For Costing *" data-size="7" name="project_id" id="project_id" required="true" data-live-search="true">
                                                    <?php foreach($projects as $project){ ?>
                                                       <option value="<?php echo $project->project_id; ?>"><?php echo $project->project_title; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <?php echo form_error('project_id', '<div class="custom_error">', '</div>'); ?>
                                                <a class="btn btn-sm btn-danger hide_list">Not in List?</a>
                                        </div>
                                        <div class="add_new_project" style="display:none;">
                                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addNewProject">Add New Project</button>
                                            <a class="btn btn-success btn-sm show_list">Show List</a>
                                        </div>
                                        <div class="loader">
                                            <center>
                                                <img class="loading-image" src="<?php echo IMG;?>search.gif" alt="loading.." width="100px">
                                            </center>
                                        </div>
                                         <br>
                                                 <div class="manual_project_costing_container">
                                                    <br>
                                                     <div class="form-header text-right">
                                                        <?php if(in_array(69, $this->session->userdata("permissions"))) {?>
                                                        <button id="addcomponentbtn" class="btn btn-info btn-fill" type="button" data-toggle="modal" href="#addNewComponentModal"><i class="material-icons">add</i> Add Component</button>
                                                        <?php } ?>
                                                        <?php if(in_array(4, $this->session->userdata("permissions"))) {?>
                                                        <button type="button" class="btn btn-warning btn-fill" value="0" onclick="addMore(this.value);"><i class="material-icons">add</i> Add Part</button>
                                                        <button type="button" class="btn btn-danger btn-fill removeallbtn"><i class="material-icons">delete</i> Remove All</button>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="form-group label-floating">
                                                       <div class="table-responsive">
                                                             <table id="partstable" class="table sortable_table templates_table">
                                                               <thead>
                                                                   <th>Stage</th>
                                                                   <th>Sub-Category</th>
                                                                   <th>Part</th>
                                                                   <th>Component</th>
                                                                   <th>Supplier</th>
                                                                   <th>Quantity</th>
                                                                   <th>Unit Of Measure</th>
                                                                   <th>Unit Cost</th>
                                                                   <th>Line Total</th>
                                                                   <th>Margin %</th>
                                                                   <th>Line Total With Margin</th>
                                                                   <th>Status</th>
                                                                   <th>Include in Specifications</th>
                                                                   <th>Client Allowance</th>
                                                                   <th>Comment</th>
                                                                   <th>Hide From Boom Mobile</th>
                                                                   <?php
                                                                        if(in_array(134, $this->session->userdata("permissions")) && in_array(153, $this->session->userdata("permissions"))) {
                                                                    ?>
                                                                   <th>Add Task to Schedule</th>
                                                                   <?php } ?>
                                                                   <th>Action</th>
                                                               </thead>
                                                               <tbody>
                                                                    <tr id="trnumber0" rno="0" tr_val="0">
                                                                            <input  name="costing_tpe_id[]" rno ='0' id="costing_tpe_id0" type="hidden" value="0" />
            	                                                            <input  name="costing_part_id[]" rno ='0' id="costing_part_id0" type="hidden"  value="0" />
                                                                       <td>
                                                                           <select data-container="body" class="selectStage" data-style="btn btn-warning btn-round" title="Choose Stage" data-size="7" name="stage_id[]" id="stagefield0" required="true">
                                                                                <option disabled> Choose Stage</option>
                                                                                
                                                                            </select>
                                                                       </td>
                                                                       <td>
                                                                           <input class="form-control sub-category-form-control" type="text" name="sub_category[]" id="subcategoryfield0" value=""/>
                                                                       </td>
                                                                       <td>
                                                                           <input class="form-control part-form-control" type="text" name="part_name[]" id="partfield0" required="true" value=""/>
                                                                       </td>
                                                                       <td>
                                                                           <select rno="0" data-container="body" class="selectComponent" data-style="btn btn-warning btn-round" title="Choose Component" data-live-search="true" data-size="7" name="component_id[]" id="componentfield0" required="true" onchange="return componentval(this);">
                                                                                <option disabled> Choose Component</option>
                                                                            </select>
                                                                       </td>
                                                                       <td>
                                                                           <input type="text" class="form-control part_name_textfield" name="supplier_name[]" id="supplierfieldname0" rno ='0' value="" readonly>
                                                                           <input type="hidden" name="supplier_id[]" id="supplierfield0" rno ='0' value="0" readonly>
            		                                                       <input type="hidden" name="quantity_type[]" id="quantity_type0" rno ='0' value="manual">
                                                                       </td>
                                                                       <td>
                                                                           <input rno="0" class="form-control qty" type="number" name="manualqty[]" id="manualqty0" required="true" value="" onchange="calculateTotal(this.getAttribute('rno'))"/>
                                                                       </td>
                                                                       <td>
                                                                           <input rno="0" class="form-control uom-form-control" type="text" name="component_uom[]" id="uomfield0" required="true" value=""/>
                                                                       </td>
                                                                       <td>
                                                                           <input rno="0" class="form-control uc-form-control" type="text" name="component_uc[]" id="ucostfield0" required="true" value="0.00" onchange="calculateTotal(this.getAttribute('rno'))"/>
                                                                           <input type="hidden" id="order_unit_cost0" rno ='0' name="order_unit_cost[]" value="0.00">
                                                                       </td>
                                                                       <td>
                                                                           <input rno="0" class="form-control uc-form-control" type="text" name="linetotal[]" id="linetotalfield0" required="true" value="0.00"/>
                                                                       </td>
                                                                        <td>
                                                                           <input rno="0" class="form-control uc-form-control profitMargin" type="text" name="margin[]" id="marginfield0" required="true" value="0" onchange="calculateTotal(this.getAttribute('rno'))"/>
                                                                       </td>
                                                                       <td>
                                                                           <input rno="0" class="form-control uc-form-control" type="text" name="margin_line[]" id="margin_linefield0" required="true" value="0.00"/>
                                                                       </td>
                                                                       <td>
                                                                           <select rno="0" data-container="body" class="selectpicker1 costestimation" data-style="btn btn-warning btn-round" title="Choose Status" data-size="7" name="status[]" id="statusfield0" required="true" onChange="CheckCostEstimation();">
                                                                                <option value="estimated" selected>Estimated</option>
                                                                                <option value="price_finalized">Price Finalized</option>
                                                                                <option value="allowance">Allowance</option>
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <div class="checkbox">
                                                                                <label>
                                                                                    <input type="checkbox" name="specification_check[]" rno ='0' id="specificationcheck0" onClick="changeSpecificationValue(this.id, this.getAttribute('rno'))">
                                                                                </label>
                                                                            </div>
                                                                              <input type="hidden" name="include_in_specification[]" value="0" id="include_in_specification0">
                                                                        </td>
                                                                        <td>
                                                                            <div class="checkbox">
                                                                                <label>
                                                                                    <input type="checkbox" name="allowance_check[]" rno ='0' id="allowance_check0" onClick="changeAllowanceValue(this.id, this.getAttribute('rno'))" value="0">
                                                                                </label>
                                                                            </div>
                                                                            <input type="hidden" name="allowance[]" value="0" id="allowance0"></td>
                                                                        <td>
                                                                           <textarea name="comments[]" id="comments0" class="form-control" style="width:200px;" placeholder="Enter comments here"></textarea>
                                                                        </td>
                                                                        <td> 
                                                                           <div class="checkbox">
                                                                                <label>
                                    										        <input type="checkbox" name="boommobilecheck[]" rno ='0'  id="boommobilecheck0"  class="selected_items" onClick="changeBoomMobileValue(this.id,this.getAttribute('rno'))">
                                                                                </label>
                                                                            </div>
                                                                            <input type="hidden" name="hide_from_boom_mobile[]" value="0" id="hide_from_boom_mobile0">
                                    									</td>
                                    									<?php
                                                                            if(in_array(134, $this->session->userdata("permissions")) && in_array(153, $this->session->userdata("permissions"))) {
                                                                        ?>
                                    									<td> 
                                                                           <div class="checkbox">
                                                                                <label>
                                    										        <input type="checkbox" name="addtasktoschedulecheck[]" rno ='0'  id="addtasktoschedulecheck0"  class="selected_items" onClick="changeAddTaskToScheduleValue(this.id,this.getAttribute('rno'))">
                                                                                </label>
                                                                            </div>
                                                                            <input type="hidden" name="add_task_to_schedule[]" value="0" id="add_task_to_schedule0">
                                    									</td>
                                    									<?php } ?>
                                                                        <td class="text-right">
                                                                           <a class="btn btn-simple btn-success btn-icon" id="iconlock0" rno ='0' onclick="changeLockStatus(this.getAttribute('rno'))"><i class="material-icons lock_icon_type0 lock_icon_type">lock_open</i></a>
                                                                           <input type="hidden" name="is_line_locked[]" id="linelock0" value="0">
                                                                           <a rno="0" class="btn btn-simple btn-danger btn-icon deleterow"><i class="material-icons">delete</i></a>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                               </table>
                                                       </div>
                                                    </div>
                                                </div>
                                    </div>
                            </div>
                        </div>
                        
                        <div class="col-md-12 manual_project_costing_container">
                            <div class="card">
                                <div class="card-content">
                                    <table class="table">
                                      <tbody>
                                                           <tr>
                                                            <td><b>Project Subtotal</b></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td width="160">
                                                                <b>$<span class="projectSubtotal">0.00</span></b>
                                                                <input type="hidden" name="total_cost" id="total_cost" value="0.00">
                                                            </td>
                                                          </tr>
                                                          <tr>
                                                            <td>Line Margins</td>
                                                            <td></td>
                                                            <td></td>
                                                            <td>$<span class="sumOfMargins">0.00</span></td>
                                                            <td width="160">
                                                                $<span class="totalLineMargins">0.00</span>
                                                                <input type="hidden" name="line_margins" id="line_margins" value="0.00">
                                                            </td>
                                                          </tr>
                                                          <tr>
                                                            <td>Profit Margin (%)</td>
                                                            <td width="160"><input class="form-control cal-on-change" name="profit_margin" id="profit_margin" value="0.00"></td>
                                                            <td></td>
                                                            <td>$<span class="calculatedProfitMargin"></span></td>
                                                            <td>
                                                                $<span class="profitMarginSubtotal"></span>
                                                                <input type="hidden" name="profitMarginSubtotal" id="profitMarginSubtotal" value="0.00">
                                                            </td>
                                                          </tr>
                                                          <tr>
                                                            <td>Overhead Margin (%)</td>
                                                            <td width="160"><input class="form-control cal-on-change" name="overhead_margin" id="overhead_margin" value="0.00"  ></td>
                                                            <td></td>
                                                            <td>$<span class="calculatedOverheadMargin"></span></td>
                                                            <td>
                                                                $<span class="overheadMarginSubtotal"></span>
                                                                <input type="hidden" name="overheadMarginSubtotal" id="overheadMarginSubtotal" value="0.00">
                                                            </td>
                                                           </tr>
                                                          <tr>
                                                            <td>GST</td>
                                                            <td><?php echo get_company_tax();?>%</td>
                                                            <td></td>
                                                            <td>$<span class="calculatedGST"></span></td>
                                                            <td width="160">
                                                                $<span class="gstSubtotal"></span>
                                                                <input type="hidden" name="costing_tax" id="costing_tax" value="<?php echo get_company_tax();?>"></td>
                                                                <input type="hidden" name="gstSubtotal" id="gstSubtotal" value="0.00"></td>
                                                          </tr>
                                                          <tr>
                                                            <td>Project Price Rounding ($)</td>
                                                            <td></td>
                                                            <td></td>
                                                            <td width="160"><input class="form-control roundme" name="price_rounding" id="price_rounding" value="0.00" required ></td>
                                                            <td>
                                                                $<span class="priceRoundingSubtotal"></span>
                                                                <input type="hidden" name="priceRoundingSubtotal" id="priceRoundingSubtotal" value="0.00">
                                                            </td>
                                                          </tr>
                                                          <tr>
                                                            <td ><b>Project Contract Price</b></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td  width="160">
                                                                <b>$<span class="priceRoundingSubtotal"></span></b>
                                                                <input type="hidden" name="total_cost2" id="total_cost2" value="0.00">
                                                                <input type="hidden" name="total_cost3" id="total_cost3" value="0.00">
                                                                <input type="hidden" name="contract_price" id="contract_price" value="0.00" ></td>
                                                          </tr>
                                          <tr>
                                            <td colspan="2">Lock/Unlock</td>
                                            <td></td>
                                            <td></td>
                                            <td  width="160"><a href="#" class="btn btn-simple btn-success btn-icon" id="iconlockproject" onclick="LockProject()"><i class="material-icons lock_project_icon_type">lock_open</i></a>
                                              <input type="hidden" name="lockproject" id="lockproject" value="0"></td>
                                          </tr>
                                      </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div id="table-for-tod" class="manual_project_costing_container"></div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-content">
                                     <div class="form-footer">
                                         <div class="pull-left">
                                            <button type="submit" class="btn btn-warning btn-fill">Save Cost</button>
                                         </div>
                                         <div class="pull-right">
                                            <a href="<?php echo SURL;?>project_costing" class="btn btn-default btn-fill">Close</a>
                                      </div>
                                     </div>
                                 </div>
                            </div>
                        </div>
                    </div>
                </form>
                    
    <div class="modal fade" id="simpleModal">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4>Create Formula</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                    <p class="formula-created" style="display:none">Formula Created, Click "Next" to proceed</p>
                    <p class="formula-error" style="display:none">Please Create Formula</p>
                    <div id="addoperator1" style="display:none;" class="addoperator">
                        <label for="exampleInputEmail1">Operator</label>
                        <div class="form-group">
                            <select class="form-control" name="operator" id="operator1" my-check='sereal'>
                                <option value="+">+</option>
                                <option value="-">−</option>
                                <option value="*" selected="selected">×</option>
                                <option value="/">÷</option>
                                <option value="(">(</option>
                                <option value=")">)</option>
                                <option value="a">&radic;</option>
                                <option value="s">sin</option>
                                <option value="c">cos</option>
                                <option value="t">tan</option>
                            </select>
                        </div>
                    </div>
                    <div id="addtakeOffData1" style="display:none;" class="addtakeOffData">
                        <label for="exampleInputEmail1">Take Off Data Name</label>
                        <div class="form-group">
                            <select class="form-control" name="takeoffdata" id="takeoffdata" my-check='sereal'>
                            <?php 
                            $i="a";
                            foreach ($takeoffdatas as $takeoffdata) {
                              
                            ?>
                              <option tod_id='<?php echo $takeoffdata["takeof_id"]?>' value="<?php echo $takeoffdata["takeof_id"]?>" title="<?php echo $takeoffdata["takeof_m"]; ?>"><?php echo $takeoffdata["takeof_name"]; ?></option>
                            <?php $i++;} ?>
                            </select>
                        </div>
                    </div>
                    
                    <div id="addnumber1" style="display:none;" class="addnumber">
                        <label for="exampleInputEmail1">Number</label>
                        <div class="form-group">
                            <input type="number" class="form-control" id="takeoffdata_number" name="takeoffdata_number" value="" my-check='sereal'>
                        </div>
                    </div>
                    <div id="addformulavalue"> </div>
                    <span id="formulainput" style="display:none;"></span> <span id="formulavalue" style="display:none;"></span> <span id="formulatext" class="label label-info" style="font-size:13px;"></span>
                        <div class="actions" style="min-height: 43px;margin-top:18px;">
                            <div class="col-md-12 no-padding">
                                <div class="col-md-4" style="padding-left: 0px;">
                                    <button onclick="return addMoreoperators();" type="button" class="btn btn-sm btn-warning clone"> <i class="fa fa-plus-circle"></i> Add More Operators </button>&nbsp;&nbsp;
            
                                       </div>
                                <div class="col-md-4" style="padding-left: 0px;">
                                    <button onclick="return addMoreTakeoff();" type="button" style="margin-left:18px;" class="btn btn-sm btn-warning clone"> <i class="fa fa-plus-circle"></i> Add More Take Off Data</button>&nbsp;&nbsp;
        
                                         </div>
                                <div class="col-md-4" style="padding-left: 0px;">
                                    <button onclick="return addMoreNumber();" type="button" style="margin-left:50px;" class="btn btn-sm btn-warning clone"> <i class="fa fa-plus-circle"></i> Add Number </button>
                                </div>
                            
                            </div>
                            <div class="col-md-12 no-padding">
                                <div class="col-md-4" style="padding-left: 0px;">
                                    <button onclick="return remove_operator();" style="margin-top:10px;margin-right: 5px;margin-bottom: 10px; display: none;" type="button" class="btn btn-sm btn-danger remove_operator"> <i class="fa fa-times-circle-o"></i> Remove Operator </button>
                                </div>
                                <div class="col-md-4" style="padding-left: 0px;">
                                    <button onclick="return remove_takeoff();" style="margin-top:10px;margin-right: 5px;margin-bottom: 10px; display: none;" type="button" class="btn btn-sm btn-danger remove_takeoff"> <i class="fa fa-times-circle-o"></i> Remove Take Off Data</button>
                                </div>
                                <div class="col-md-4" style="padding-left: 0px;">
                                    <button onclick="return remove_number();" style="margin-left:18px;margin-top:10px;margin-right: 5px;margin-bottom: 10px; display: none;" type="button" class="btn btn-sm btn-danger remove_number"> <i class="fa fa-times-circle-o"></i> Remove Number </button>
                                </div>
                           </div>
                        </div>
    
                    </div>
    
                    <!-- /.col --> 
                </div>
            </div>
            <div class="modal-footer">
                <input id="modelnumber" value="1" type="hidden" name="modelnumber" />
                <input id='modelforrow' type='hidden' value='1' name='modelforrow'>
                <div class="checkbox" style="text-align:left;margin-left:10px;">
                    <label>
                        <input type="checkbox" id="is_rounded" name="is_rounded" value="1"> Rounded up to a whole integer
                    </label>
                </div>
                <button class="btn btn-sm btn-warning" data-dismiss="modal" aria-hidden="true" style="margin-top:10px;">Next</button>
                <button class="btn btn-success btn-sm" onclick="return GetFormula();" style="margin-top:10px;">Save changes</button>
            </div>
        </div>
        <!-- /.modal-content --> 
    </div>
    <!-- /.modal-dialog --> 
    </div>
    
    
<div id="addNewProject" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content" style="width:900px;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add New Project</h4>
      </div>
      <div class="modal-body">
            <form id="ProjectForm" class="form-horizontal no-margin form-border" action="" method="post" name="addproject" autocomplete="off">            
                    <div class="row">
                            <div class="col-md-12">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">
                                                        
                                                        </label>
    								    <div  class="client_list">
        									<select class="selectpicker" id="client_id" name="client_id" required="true" data-live-search="true" data-style="select-with-transition">
        									<option value="">Select Client</option>
                                            <?php foreach($clients as $client) {
                                            	$selected_client = '';
                                            	if ($client["client_id"] == $client_id) {
                                            		$selected_client = 'selected';
                                            	} else { $selected_client == '';}
                                            ?>
        										<option <?php echo $selected_client; ?> value="<?php echo $client['client_id']; ?>" ><?php echo $client["client_fname1"].' '.$client["client_surname1"].' '.$client["client_fname2"].' '.$client["client_surname2"]; ?></option>
                                            <?php } ?>
        									</select>
        								<a class="btn btn-sm btn-danger pull-right hide_client_list" style="margin-top:10px;">Not in List?</a>
    									</div>
    									<div class="add_new_client" style="display:none;">
                    <button type="button" class="btn btn-sm btn-primary btn-lg" data-toggle="modal" data-target="#addNewClient">Add New Client</button>
                    <a class="btn btn-success btn-sm show_client_list" style="margin-top:10px;">Show List</a>
                  </div>
    								</div><!-- /.col -->
    							</div><!-- /form-group -->
    						<div class="col-md-12">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">
                                                        Project Name
                                                        <small>*</small>
                                                        </label>
                                                        <input class="form-control" type="text" name="project_title" id="project_title" required="true" uniqueProject="true" value="<?php echo set_value('project_title')?>"/>
                                                        <?php echo form_error('project_title', '<div class="custom_error">', '</div>'); ?>
        				                        	</div>
                                            </div>
                            <br>
                            <div class="col-md-12">
                                    <div class="form-group label-floating">
                                        <label class="control-label">
                                            Project Description
                                        </label>
                                        <textarea class="form-control" name="project_des" id="project_des"><?php echo set_value('project_des')?></textarea>
                                        <?php echo form_error('project_des', '<div class="custom_error">', '</div>'); ?>
        				            </div>
                            </div>
                                
                            <div class="col-md-12">
                                                <div class="col-md-12"><br/><legend>Address</legend></div>
                                                <div class="col-md-4">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">
                                                        Street
                                                        <small>*</small>
                                                        </label>
                                                        <input class="form-control" type="text" name="street_pobox" id="project_address_city" required="true" value="<?php echo set_value('street_pobox')?>"/>
                                                        <?php echo form_error('street_pobox', '<div class="custom_error">', '</div>'); ?>
        				                        	</div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">
                                                        Suburb
                                                        <small>*</small>
                                                        </label>
                                                        <input class="form-control" type="text" name="suburb" id="suburb" required="true" value="<?php echo set_value('suburb')?>"/>
                                                        <?php echo form_error('suburb', '<div class="custom_error">', '</div>'); ?>
        				                        	</div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">
                                                        City
                                                        <small>*</small>
                                                        </label>
                                                        <input class="form-control" type="text" name="project_address_city" id="project_address_city" required="true" value="<?php echo set_value('project_address_city')?>"/>
                                                        <?php echo form_error('project_address_city', '<div class="custom_error">', '</div>'); ?>
        				                        	</div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">
                                                        Region
                                                        <small>*</small>
                                                        </label>
                                                        <input class="form-control" type="text" name="project_address_state" id="project_address_state" required="true" value="<?php echo set_value('project_address_state')?>"/>
                                                        <?php echo form_error('project_address_state', '<div class="custom_error">', '</div>'); ?>
        				                        	</div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">
                                                        Country
                                                        <small>*</small>
                                                        </label>
                                                        <input class="form-control" type="text" name="project_address_country" id="project_address_country" required="true" value="<?php echo set_value('project_address_country')?>"/>
                                                        <?php echo form_error('project_address_country', '<div class="custom_error">', '</div>'); ?>
        				                        	</div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">
                                                        ZIP Code
                                                        <small>*</small>
                                                        </label>
                                                        <input class="form-control" type="text" name="project_zip" id="project_zip" required="true" value="<?php echo set_value('project_zip')?>"/>
                                                        <?php echo form_error('project_zip', '<div class="custom_error">', '</div>'); ?>
        				                        	</div>
                                                </div>
                                            </div>
                            <div class="col-md-12">
                                                <div class="col-md-12">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">
                                                            Legal Description
                                                        </label>
                                                        <textarea class="form-control" name="project_legal_des" id="project_legal_des"><?php echo set_value('project_legal_des')?></textarea>
                                                        <?php echo form_error('project_legal_des', '<div class="custom_error">', '</div>'); ?>
                					               </div>
                					           </div>
                					       </div>
                			<div class="col-md-12">
                					           <div class="col-md-12">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">
                                                        Bank Account
                                                        </label>
                                                        <input class="form-control" type="text" name="bank_acount" id="bank_acount" value="<?php echo set_value('bank_acount')?>"/>
                                                        <?php echo form_error('bank_acount', '<div class="custom_error">', '</div>'); ?>
        				                        	</div>
                                                </div>
                                            </div>
                            <!--<div class="col-md-12">
                					           <div class="col-md-12">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">
                                                        
                                                        </label>
                                                        <input class="form-control datepicker" type="text" placeholder="Proposed Start Date" name="proposed_start_date" id="proposed_start_date" value="<?php echo set_value('proposed_start_date')?>" required="true"/>
                                                        <?php echo form_error('proposed_start_date', '<div class="custom_error">', '</div>'); ?>
        				                        	</div>
                                                </div>
                                            </div>-->
                            <div class="col-md-12">
                                                <div class="col-md-12">
                                                    <div class="form-group label-floating">
                										<select class="selectpicker" data-style="select-with-transition" title="Status *" data-size="7" name="project_status" id="project_status" required="true">
                                                            <option disabled> Choose Status</option>
                                                            <option value="2" selected>Pending</option>
                											<option value="1" disabled>Current</option>
                											<option value="0" disabled>Inactive</option>
                											<option value="3" disabled>Completed</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                            <div class="col-md-12">
                                                <div class="col-md-12">
                                                    <div class="form-group label-floating">
                                                        <div class="form-footer text-right">
                                                            <button type="button" class="btn btn-warning btn-sm btn-fill add_project_btn" name="add_project">Add Project</button>
                                                            <button class="btn btn-primary btn-sm" type="reset">Reset</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                    </div>
                           
            </form>    
						
      </div>
    </div>

  </div>
</div>

<div id="addNewClient" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content" style="width:900px;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add New Client</h4>
      </div>
      <div class="modal-body">
          <form id="ClientForm" class="form-horizontal no-margin form-border" name="addclient" method="post" action="">
              <div class="row">
                        <div class="col-md-12">
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    First Name 1
                                                    <small>*</small>
                                                    </label>
                                                    <input class="form-control" type="text" name="client_fname1" id="client_fname1" required="true" value="<?php echo set_value('client_fname1')?>"/>
                                                    <?php echo form_error('client_fname1', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    First Name 2
                                                    </label>
                                                    <input class="form-control" type="text" name="client_fname2" id="client_fname2" value="<?php echo set_value('client_fname2')?>"/>
                                                    <?php echo form_error('client_fname2', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Surname 1
                                                    <small>*</small>
                                                    </label>
                                                    <input class="form-control" type="text" name="client_surname1" id="client_surname1" required="true" value="<?php echo set_value('client_surname1')?>"/>
                                                    <?php echo form_error('client_surname1', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Surname 2
                                                    </label>
                                                    <input class="form-control" type="text" name="client_surname2" id="client_surname2" value="<?php echo set_value('client_surname2')?>"/>
                                                    <?php echo form_error('client_surname2', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Home Phone Primary
                                                    <small></small>
                                                    </label>
                                                    <input class="form-control" type="text" name="client_homephone_primary" id="client_homephone_primary" value="<?php echo set_value('client_homephone_primary')?>"/>
                                                    <?php echo form_error('client_homephone_primary', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Home Phone Secondary
                                                    </label>
                                                    <input class="form-control" type="text" name="client_homephone_secondary" id="client_homephone_secondary" value="<?php echo set_value('client_homephone_secondary')?>"/>
                                                    <?php echo form_error('client_homephone_secondary', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Work Phone Primary
                                                    <small></small>
                                                    </label>
                                                    <input class="form-control" type="text" name="client_workphone_primary" id="client_workphone_primary" value="<?php echo set_value('client_workphone_primary')?>"/>
                                                    <?php echo form_error('client_workphone_primary', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Work Phone Secondary
                                                    </label>
                                                    <input class="form-control" type="text" name="client_workphone_secondary" id="client_workphone_secondary" value="<?php echo set_value('client_workphone_secondary')?>"/>
                                                    <?php echo form_error('client_workphone_secondary', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Mobile Phone Primary
                                                    <small>*</small>
                                                    </label>
                                                    <input class="form-control" type="text" name="client_mobilephone_primary" id="client_mobilephone_primary" required="true" value="<?php echo set_value('client_mobilephone_primary')?>"/>
                                                    <?php echo form_error('client_mobilephone_primary', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Mobile Phone Secondary
                                                    </label>
                                                    <input class="form-control" type="text" name="client_mobilephone_secondary" id="client_mobilephone_secondary" value="<?php echo set_value('client_mobilephone_secondary')?>"/>
                                                    <?php echo form_error('client_mobilephone_secondary', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Email Primary
                                                    <small>*</small>
                                                    </label>
                                                    <input class="form-control" type="text" name="client_email_primary" id="client_email_primary" required="true" email="true" uniqueEmail="true" value="<?php echo set_value('client_email_primary')?>"/>
                                                    <?php echo form_error('client_email_primary', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Email Secondary
                                                    </label>
                                                    <input class="form-control" type="text" name="client_email_secondary" id="client_email_secondary" email="true" value="<?php echo set_value('client_email_secondary')?>"/>
                                                    <?php echo form_error('client_email_secondary', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-12"><br/><legend>Address</legend></div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Street
                                                    <small>*</small>
                                                    </label>
                                                    <input class="form-control" type="text" name="street_pobox" id="street_pobox" required="true" value="<?php echo set_value('street_pobox')?>"/>
                                                    <?php echo form_error('street_pobox', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Suburb
                                                    <small>*</small>
                                                    </label>
                                                    <input class="form-control" type="text" name="suburb" id="suburb" required="true" value="<?php echo set_value('suburb')?>"/>
                                                    <?php echo form_error('suburb', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    City
                                                    <small>*</small>
                                                    </label>
                                                    <input class="form-control" type="text" name="client_city" id="client_city" required="true" value="<?php echo set_value('client_city')?>"/>
                                                    <?php echo form_error('client_city', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Region
                                                    <small></small>
                                                    </label>
                                                    <input class="form-control" type="text" name="state" id="state" value="<?php echo set_value('state')?>"/>
                                                    <?php echo form_error('state', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Country
                                                    <small></small>
                                                    </label>
                                                    <input class="form-control" type="text" name="country" id="country" value="<?php echo set_value('country')?>"/>
                                                    <?php echo form_error('country', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    ZIP Code
                                                    <small>*</small>
                                                    </label>
                                                    <input class="form-control" type="text" name="client_zip" id="client_zip" required="true" value="<?php echo set_value('client_zip')?>"/>
                                                    <?php echo form_error('client_zip', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-12"><br/><legend>Postal Address</legend></div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Street
                                                    </label>
                                                    <input class="form-control" type="text" name="post_street_pobox" id="post_street_pobox" value="<?php echo set_value('post_street_pobox')?>"/>
                                                    <?php echo form_error('post_street_pobox', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Suburb
                                                    </label>
                                                    <input class="form-control" type="text" name="post_suburb" id="post_suburb" value="<?php echo set_value('post_suburb')?>"/>
                                                    <?php echo form_error('post_suburb', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    City
                                                    </label>
                                                    <input class="form-control" type="text" name="client_postal_city" id="client_postal_city" value="<?php echo set_value('client_postal_city')?>"/>
                                                    <?php echo form_error('client_postal_city', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Region
                                                    </label>
                                                    <input class="form-control" type="text" name="pstate" id="pstate" value="<?php echo set_value('pstate')?>"/>
                                                    <?php echo form_error('pstate', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Country
                                                    </label>
                                                    <input class="form-control" type="text" name="pcountry" id="pcountry" value="<?php echo set_value('pcountry')?>"/>
                                                    <?php echo form_error('pcountry', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    ZIP Code
                                                    </label>
                                                    <input class="form-control" type="text" name="client_postal_zip" id="client_postal_zip" value="<?php echo set_value('client_postal_zip')?>"/>
                                                    <?php echo form_error('client_postal_zip', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                            Notes
                                                    </label>
                                                    <textarea class="form-control" name="client_note" id="client_note"><?php echo set_value('client_note')?></textarea>
                                                    <?php echo form_error('client_note', '<div class="custom_error">', '</div>'); ?>
            					               </div>
            					           </div>
            					       </div>
                                        <div class="col-md-12">
                                            <div class="col-md-12">
                                                <div class="form-group label-floating">
            										<select class="selectpicker" data-style="select-with-transition" title="Status *" data-size="7" name="client_status" id="client_status" required="true">
                                                        <option disabled> Choose Status</option>
            											<option value="1" selected>Current</option>
            											<option value="0" disabled>Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <div class="form-footer text-right">
                                                        <button type="button" class="btn btn-warning btn-fill btn-sm add_client_btn" name="add_client">Add Client</button>
                                                        <button class="btn btn-primary btn-sm" type="reset">Reset</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
						</form>
    </div>
    </div>

  </div>
</div>

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
                <label for="current_unit_cost">Costing Part Unit Cost:</label>
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

                