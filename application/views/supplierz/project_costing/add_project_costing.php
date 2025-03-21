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
                                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                                        <select class="selectpicker" data-live-search="true" data-style="btn btn-warning btn-round" title="Choose Existing Project Costing" id="extcosting_id" name="extcosting_id" onchange="getProjectCostingbyCosting(this.value)">                 
                                                        <?php if(count($extprojects)>0){ foreach($extprojects as $project){ ?>                                       
                                                        <option value="<?php echo $project['costing_id'];?>"><?php echo $project['costing_name'];?></option>
                                                        <?php } }?>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                                        <select class="selectpicker" data-live-search="true" data-style="btn btn-warning btn-round" title="Choose Existing Template" id="exttemplate_id" name="exttemplate_id" onchange="getProjectCostingbyTemplate(this.value)">                 
                                                        <?php if(count($exttemplates)>0){ foreach($exttemplates as $tem){ ?>                                       
                                                        <option value="<?php echo $tem['template_id'];?>"><?php echo $tem['template_name'];?></option>
                                                        <?php } }?>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                                                    <form id="ProjectCostingCSVForm" method="POST" enctype="multipart/form-data">
                                                                        <div class="alert alert-danger import_file_error" style="display:none;"></div>
                                                                        <div class="label-floating">
                                                                            <label>
                                                                            Import CSV</label>
                                                                           <input type="file" id="importcsv"  name="importcsv" extension="csv" required="true">
                            				                        	</div>
                            				                        	<div class="label-floating">
                            				                        	    <button type="button" class="btn btn-warning btn-fill import-components-file-button">Import</button>
                            				                        	</div>
                        				                        	</form>
                        				                            <a href="<?php echo SURL;?>assets/csv/Supplierz_File_Import_Template.csv" class="btn btn-default">Click to View CSV Sample</a>
                        				                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                 </div>
                            </div>
                        </div>
               <form id="ProjectCostingForm" method="POST" action="<?php echo SURL ?>supplierz/savecost" enctype="multipart/form-data">
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
										<div class="form-group label-floating">
                                            <label class="control-label">
                                                Project Costing Name
                                                <small>*</small>
                                            </label>
                                            <input class="form-control" type="text" name="costing_name" id="costing_name" required="true" uniqueCostingName="true" value="<?php echo set_value('costing_name')?>"/>
                                            <?php echo form_error('costing_name', '<div class="custom_error">', '</div>'); ?>
					                    </div>
                                        <div class="form-group label-floating">
                                            <label class="control-label">
                                                Project Costing Description
                                                <small>*</small>
                                            </label>
                                            <textarea class="form-control" type="text" name="costing_description" id="costing_description" required="true"><?php echo set_value('costing_description')?></textarea>
                                            <?php echo form_error('costing_description', '<div class="custom_error">', '</div>'); ?>
				                    	</div>
				                    	<div class="form-group label-floating">
                								<select class="selectpicker" data-style="select-with-transition" title="Status *" data-size="7" name="status" id="status" required="true">
                                                    <option disabled> Choose Status</option>
                									<option value="1" selected>Current</option>
                									<option value="0">Inactive</option>
                                                </select>
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
                                                        <?php if(in_array(149, $this->session->userdata("permissions"))) {?>
                                                        <button id="addcomponentbtn" class="btn btn-info btn-fill" type="button" data-toggle="modal" href="#addNewComponentModal"><i class="material-icons">add</i> Add Component</button>
                                                        <?php } ?>
                                                        <button type="button" class="btn btn-warning btn-fill" value="0" onclick="addMore(this.value, 'costing');"><i class="material-icons">add</i> Add Part</button>
                                                        <button type="button" class="btn btn-danger btn-fill removeallbtn"><i class="material-icons">delete</i> Remove All</button>
                                                    </div>
                                                    <div class="form-group label-floating">
                                                       <div class="table-responsive">
                                                             <table id="partstable" class="table sortable_table templates_table">
                                                               <thead>
                                                                   <th>Stage</th>
                                                                   <th>Part</th>
                                                                   <th>Component</th>
                                                                   <th>Supplier</th>
                                                                   <th>QTY Type</th>
                                                                   <th>Quantity</th>
                                                                   <th>Unit Of Measure</th>
                                                                   <th>Unit Cost</th>
                                                                   <th>Line Total</th>
                                                                   <th>Margin %</th>
                                                                   <th>Line Total With Margin</th>
                                                                   <th>Action</th>
                                                               </thead>
                                                               <tbody>
                                                                    <tr id="trnumber0" rno="0" tr_val="0">
                                                                            <input  name="costing_tpe_id[]" rno ='0' id="costing_tpe_id0" type="hidden" value="0" />
            	                                                            <input  name="costing_part_id[]" rno ='0' id="costing_part_id0" type="hidden"  value="0" />
                                                                       <td>
                                                                           <select data-container="body" class="selectSupplierzStage" data-style="btn btn-warning btn-round" title="Choose Stage" data-size="7" name="stage_id[]" id="stagefield0" required="true">
                                                                                <option disabled> Choose Stage</option>
                                                                                
                                                                            </select>
                                                                       </td>
                                                                       <td>
                                                                           <input class="form-control part-form-control" type="text" name="part_name[]" id="partfield0" required="true" value=""/>
                                                                       </td>
                                                                       <td>
                                                                           <select rno="0" data-container="body" class="selectSupplierzComponent" data-style="btn btn-warning btn-round" title="Choose Component" data-live-search="true" data-size="7" name="component_id[]" id="componentfield0" required="true" onchange="return componentval(this);">
                                                                                <option disabled> Choose Component</option>
                                                                            </select>
                                                                       </td>
                                                                       <td>
                                                                           <?php echo $this->session->userdata("company_name");?>
                                                                       </td>
                                                                       <td>
                                                                           <select data-container="body" class="selectpicker" data-style="btn btn-warning btn-round" title="Choose Quantity Type" data-size="7" qtype_number="0" name="quantity_type[]" id="quantity_type0" required="true" onchange="changeQTYType(this)">
                                                                                <option value="manual" selected>Manual</option>
                                                                                <option value="formula">Formula</option>
                                                                            </select>
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
                                                                        <td class="text-right">
                                                                                <a rno="0" class="btn btn-simple btn-danger btn-icon deleterow"><i class="material-icons">delete</i></a>
                                                                                <a id="model0" data-toggle="modal" role="button" rno="0" title="_stage_0" onclick="return modelid(this.title, this.getAttribute('rno'));"  href="" class="btn btn-simple btn-warning btn-icon formula_btn0 disabled"><i class="material-icons calculatedFormula0">functions</i></a>
                                                                               <input class="form-control formula" rno ='0' type="hidden" value="" name="formula[]" id="formula_stage_0" title="0" alt="0">
                                                                               <input class="form-control formulaqty "  rno ='0' type="hidden" value="" name="formulaqty[]" id="formulaqty_stage_0" title="0" alt="0">
                                                                               <input class="form-control formulatext"  rno ='0' type="hidden" value="" name="formulatext[]" id="formulatext_stage_0" title="0" alt="0">
                                                                               <input class="form-control"  rno ='0' type="hidden" value="0" name="is_rounded[]" id="is_rounded_stage_0" title="0" alt="0">
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
                                            <a href="<?php echo SURL;?>supplierz/project_costing" class="btn btn-default btn-fill">Close</a>
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
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Formula Creation & Takeoff Data</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="material-datatables">
                                        <ul class="nav nav-pills nav-pills-success">
                                            <li class="active"><a href="#formula" data-toggle="tab">Create Formula</a></li>
                                            <li><a href="#testFormula" id="testFormulaTab" mode="Add" data-toggle="tab">Test Formula</a></li>
                                            <?php if(in_array(80, $this->session->userdata("permissions"))) {?>
                                            <li><a href="#takeoffdata" data-toggle="tab">Add New Take Off Data</a></li>
                                            <?php } ?>
                                        </ul>
                                    	<div class="tab-content">
                                    	    <div class="tab-pane active" id="formula">
                                    	        <div class="row">
                                    	            <div class="col-md-12">
                                                        <p class="formula-created" style="display:none">Formula Created, Click "Next" to proceed</p>
                                                        <p class="formula-error" style="display:none">Please Create Formula</p>
                                                        <div id="addoperator0" style="display:none;" class="addoperator">
                                                            <label for="operator0">Operator</label>
                                                            <div class="form-group">
                                                                <select class="form-control" name="operator0" id="operator" my-check='sereal'>
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
                                                        <div id="addtakeOffData0" style="display:none;" class="addtakeOffData">
                                                            <label for="takeoffdata0">Take Off Data Name</label>
                                                            <div class="form-group">
                                                                <select name="takeoffdata" id="takeoffdata0" my-check='sereal'>
                                                                <?php 
                                                                $i="a";
                                                                foreach ($takeoffdatas as $takeoffdata) {
                                                                  
                                                                ?>
                                                                  <option tod_id='<?php echo $takeoffdata["takeof_id"]?>' value="<?php echo $takeoffdata["takeof_id"]?>" title="<?php echo $takeoffdata['takeof_name']; ?>"><?php echo $takeoffdata["takeof_name"]; ?></option>
                                                                <?php $i++;} ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div id="addnumber0" style="display:none;" class="addnumber">
                                                            <label for="takeoffdata_number0">Number</label>
                                                            <div class="form-group">
                                                                <input type="number" class="form-control" id="takeoffdata_number0" name="takeoffdata_number" value="" my-check='sereal'>
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
                                                                        <button onclick="return remove_operator();" style="margin-top:10px;margin-right: 5px;margin-bottom: 10px; display: none;" type="button" class="btn btn-sm btn-danger remove_operator"> <i class="fa fa-close"></i> Remove Operator </button>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <button onclick="return remove_takeoff();" style="margin-top:10px;margin-right: 5px;margin-bottom: 10px; display: none;" type="button" class="btn btn-sm btn-danger remove_takeoff"> <i class="fa fa-close"></i> Remove Take Off Data</button>
                                                                    </div>
                                                                    <div class="col-md-4" style="padding-left: 30px;">
                                                                        <button onclick="return remove_number();" style="margin-left:18px;margin-top:10px;margin-right: 5px;margin-bottom: 10px; display: none;" type="button" class="btn btn-sm btn-danger remove_number"> <i class="fa fa-close"></i> Remove Number </button>
                                                                    </div>
                                                               </div>
                                                            </div>
                                                        
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
                                                                <button class="btn btn-sm btn-warning" data-dismiss="modal" style="margin-top:10px;">Next</button>
                                                                <button class="btn btn-success btn-sm" onclick="return GetFormula();" style="margin-top:10px;">Save changes</button>
                                                        </div>
                                            </div>
                                            <div class="tab-pane" id="testFormula">
                                    	        <div class="row">
                                    	            <div class="col-md-12">
                                    	                <div id="computedFormulaTextAdd" class="label label-info"></div>
                                    	                <div style="font-size:13px;margin-top:15px;">Formula Results: <span id="computedFormulaAdd"></span></div>
                                    	                <form id="testFormulaFormAdd" method="post" action="">
                                        	                <table class="table">
                                                                <tbody>
                                                                        <tr class="actionRow">
                                                                            <td colspan="2" style="text-align: center"><a href="javascript:void(0)" class="btn btn-warning" onclick="testFormula('Add')">Test Formula</a></td>
                                                                       
                                                                        </tr>
                                                                </tbody>
                                                        
                                                            </table>
                                                        </form>
                                    	            </div>
                                    	        </div>
                                    	    </div>
                                            <div class="tab-pane" id="takeoffdata">
                                                <form id="TakeoffdataForm" method="POST" action="">
                                                    <div class="card-content">
                                                        <div class="col-md-12">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">
                                                                    Take off Data Name
                                                                    <small>*</small>
                                                                </label>
                                                                <input class="form-control" type="text" name="name" id="name" required="true" uniqueTakeoffdata="true" value="<?php echo set_value('name')?>"/>
                                                                <?php echo form_error('name', '<div class="custom_error">', '</div>'); ?>
                    					                    </div>
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">
                                                                    Take off Data Description
                                                                </label>
                                                                <textarea class="form-control" name="description" id="description"><?php echo set_value('description')?></textarea>
                                                                <?php echo form_error('description', '<div class="custom_error">', '</div>'); ?>
                    					                    </div>
                                                            <div class="form-group label-floating">
                                								<select class="selectpicker" data-style="select-with-transition" title="Status *" data-size="7" name="takeof_status" id="takeof_status" required="true">
                                                                    <option disabled> Choose Status</option>
                                									<option value="1" selected>Current</option>
                                									<option value="0">Inactive</option>
                                                                </select>
                                                            </div>
                    										
                                                            <div class="form-footer text-right">
                                                                <?php if(in_array(80, $this->session->userdata("permissions"))) {?>
                                                                <button type="button" class="btn btn-warning btn-fill add-takeoffdata-btn">Add</button>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                    </div>
                    <!-- /.col --> 
                </div>
            </div>
        </div>
        <!-- /.modal-content --> 
        </div>
        <!-- /.modal-dialog --> 
        </div>
    </div>
    <div class="modal fade" id="updateFormulaModal">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4>Update Formula & Takeoff Data</h4>
		  </div>
		  <div class="update-modal-container"></div>
		  </div>
		  <!-- /.modal-content --> 
		</div>
		<!-- /.modal-dialog --> 
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

                