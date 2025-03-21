             
                        <div class="col-md-12 manual_project_costing_container">
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
                                                        <select data-container="body" class="selectFromProject" data-style="btn btn-warning btn-round" data-live-search="true" title="Select From Project" id="extproject_id" name="extproject_id" onchange="getCostingbyEditProject(this.value)">                 
                                                        
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-12">
                                                        <select data-container="body" class="selectFromTemplate" data-style="btn btn-warning btn-round" data-live-search="true" title="Select From Template" id="exttemplate_id" name="exttemplate_id" onchange="getCostingbyEditTemplate(this.value)">                 
                                                        
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
                            				                        	    <button type="button" class="btn btn-warning btn-fill edit-import-file-button">Import</button>
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
             <form id="ProjectCostingForm" method="POST" action="<?php echo SURL ?>project_costing/update_project_costing_process/<?php echo $pc_detail->costing_id;?>" onsubmit="return validateForm()" enctype="multipart/form-data">
        
                 <input type="hidden" name="is_takeoffdata_exists" id="is_takeoffdata_exists" value="<?php if(count($ctakeoffdata)>0){ ?>1<?php } else{ ?>0<?php } ?>">   
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">house</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Update Project Costing</h4>
				                    	<div class="form-group label-floating">
                								<?php echo $project_name; ?>
                                        </div>
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
                                        <div class="loader">
                                            <center>
                                                <img class="loading-image" src="<?php echo IMG;?>search.gif" alt="loading.." width="100px">
                                            </center>
                                        </div>
                                        <ul class="nav nav-pills nav-pills-warning">
                                            <li class="active"><a href="#projectCosting" data-toggle="tab">Project Costing</a></li>
                                            <li><a href="<?php echo SURL.'project_costing/specifications/'.$project_id;?>">Specifications</a></li>
                                            <li><a href="<?php echo SURL.'project_costing/allowances/'.$project_id;?>">Allowances</a></li>
                                            <!--<li><a href="<?php echo SURL.'project_costing/plans_and_specifications/'.$project_id;?>">Plans and Specifications</a></li>
                                            <li><a href="<?php echo SURL.'project_costing/create_documents/'.$project_id;?>">Create Documents</a></li>
                                            <li><a href="<?php echo SURL.'project_costing/estimate_request/'.$project_id;?>">Estimate Request <font color="red">"fees apply"</font></a></li>-->
                                        </ul>
                                    	<div class="tab-content">
                                    	    <div class="tab-pane active" id="projectCosting">
                                    	       
                                                <div class="manual_project_costing_container">
                                                    <br>
                                        	         <div class="row">
                                                            <div class="col-md-12"><legend>Show/Hide Columns</legend></div>
                                                            <div class="col-md-12">
                                                                <div class="col-md-2">
                                                                    <div class="checkbox">
                                                                        <label>
                                            								<input type="checkbox" name="column_status" id="column_status"  onchange="showcolumn('status')"> Show Status
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="checkbox">
                                                                        <label>
                                            								<input type="checkbox" name="column_subcategory" id="column_subcategory"  onchange="showcolumn('subcategory')"> Show Sub-Category
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="checkbox">
                                                                        <label>
                                            								<input type="checkbox" name="column_include" id="column_include"  onchange="showcolumn('include')"> Show Include in specification & client allowance
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="checkbox">
                                                                        <label>
                                            								<input type="checkbox" name="column_comments" id="column_comments"  onchange="showcolumn('comments')"> Show Comments
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <!--<div class="col-md-3">
                                                                    <div class="checkbox">
                                                                        <label>
                                            								<input type="checkbox" name="column_boom_mobile" id="column_boom_mobile"  onchange="showcolumn('boom_mobile')"> Show Mobile Settings
                                                                        </label>
                                                                    </div>
                                                                </div>-->
                                                                <div class="col-md-3">
                                                                    <div class="checkbox">
                                                                            <label>
                                                								<input type="checkbox" name="column_component_description" id="column_component_description"  onchange="showcolumn('component_description')"> Show Component Description
                                                                            </label>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                            <!--<div class="col-md-12">
                                                                <div class="col-md-2">
                                                                    <div class="checkbox">
                                                                        <label>
                                            								<input type="checkbox" name="column_component_description" id="column_component_description"  onchange="showcolumn('component_description')"> Show Component Description
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                                    if(in_array(134, $this->session->userdata("permissions")) && in_array(153, $this->session->userdata("permissions"))) {
                                                                ?>
                                                                    <div class="col-md-2">
                                                                        <div class="checkbox">
                                                                            <label>
                                                								<input type="checkbox" name="column_add_task_to_schedule" id="column_add_task_to_schedule"  onchange="showcolumn('add_task_to_schedule')"> Show Add Task to Schedule
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>-->
                                                    </div>
                                                     <div class="form-footer text-right">
                                                        <?php if(in_array(69, $this->session->userdata("permissions"))) {?>
                                                        <button id="addcomponentbtn" class="btn btn-info btn-fill" type="button" data-toggle="modal" href="#addNewComponentModal"><i class="material-icons">add</i> Add Component</button>
                                                        <?php } ?>
                                                        <?php if(in_array(4, $this->session->userdata("permissions"))) {?>
                                                        <button type="button" class="btn btn-warning btn-fill" value="0" onclick="addMorePart(this.value);"><i class="material-icons">add</i> Add Part</button>
                                                        <?php } ?>
                                                    </div>
                                                     <div class="form-group label-floating">
                                                    <div class="table-responsive">
                                            		<table id="add-more-row" class="table sortable_table templates_table" style="display:none;">
                                                		<thead>
                                                		    <th>Stage</th>
                                                		    <th class="subcategory">Sub-Category</th>
                                                            <th>Part</th>
                                                            <th>Component</th>
                                                            <th class="component_description">Component Description</th>
                                                            <th>Supplier</th>
                                                            <th>QTY</th>
                                                            <th>Unit Of Measure</th>
                                                            <th>Unit Cost</th>
                                                            <th>Line Total</th>
                                                            <th>Margin %</th>
                                                            <th>Line Total with Margin</th>
                                                            <th class="status">Status</th>
                                                                        <th class="include">Include in specifications</th>
                                                                        <th class="include">Client Allowance</th>
                                                                        <th class="comments">Comment</th>
                                                                        <th class="boom_mobile">Hide From Mobile <div class="checkbox">
                                                                            <label><input type="checkbox" class="select_all_items"></label></div></th>
                                                                        <?php
                                                                            if(in_array(134, $this->session->userdata("permissions")) && in_array(153, $this->session->userdata("permissions"))) {
                                                                        ?>
                                                                        <th class="add_task_to_schedule">Add Task to Schedule</th>
                                                                        <?php } ?>
                                                            <th>Action</th>
                                                		</thead>
                                                		<tbody></tbody>
                                                	</table>
                                                	</div>
                                                        <?php $count = 0;
                                                        foreach ($stages as $key => $stage): ?>
                        <?php //if (in_array($stage['stage_id'], $saved_stages)) : 
                        $stage_total = $stage["stage_total"];
                        $no_of_items = 0;
                        $no_of_checkboxes = 0;
                        if(isset($stage["costing_parts"]) && count($stage["costing_parts"])>0){
                        foreach ($stage["costing_parts"] As $key => $prjprt) {
    							  $no_of_items++;
    							  if($prjprt->hide_from_boom_mobile){
    							     $no_of_checkboxes++; 
    							  }
    							}
                        }
    					?>
                                                          <div class="panel-group" id="accordion<?php echo $stage['stage_id']; ?>" role="tablist" aria-multiselectable="true">
                                                                <div class="panel panel-default">
                                                                    <div class="panel-heading" role="tab" id="headingOne<?php echo $stage['stage_id']; ?>">
                                                                        <a role="button" data-toggle="collapse" data-parent="#accordion<?php echo $stage['stage_id']; ?>" href="#collapseOne<?php echo $stage['stage_id']; ?>" aria-controls="collapseOne<?php echo $stage['stage_id']; ?>">
                                                                            <h4 class="panel-title">
                                                                                <?php echo $stage['stage_name']; ?>
                                                                                <i class="material-icons">keyboard_arrow_down</i>
                                                                                <span class="pull-right sub_total_<?php echo $stage['stage_id']; ?>">Stage Sub-total : <?php echo "$".number_format($stage_total, 2, '.', '');?></span>
                                                                            </h4>
                                                                        </a>
                                                                    </div>
                                                                    <div id="collapseOne<?php echo $stage['stage_id']; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne<?php echo $stage['stage_id']; ?>">
                                                                        <div class="panel-body">
                                                                           <div class="table-responsive">
                                                                     <table id="partstable" class="table sortable_table templates_table partstable">
                                                                       <thead>
                                                                           <th>Stage</th>
                                                                           <th class="subcategory">Sub-Category</th>
                                                                           <th>Part</th>
                                                                           <th>Component</th>
                                                                           <th class="component_description">Component Description</th>
                                                                           <th>Supplier</th>
                                                                           <th>Quantity</th>
                                                                           <th>Unit Of Measure</th>
                                                                           <th>Unit Cost</th>
                                                                           <th>Line Total</th>
                                                                           <th>Margin %</th>
                                                                           <th>Line Total With Margin</th>
                                                                           <th class="status">Status</th>
                                                                           <th class="include">Include in Specifications</th>
                                                                           <th class="include">Client Allowance</th>
                                                                           <th class="comments">Comment</th>
                                                                           <th class="boom_mobile">Hide From Mobile <div class="checkbox">
                                                                            <label><input type="checkbox" <?php if($no_of_items==$no_of_checkboxes){ ?> checked <?php } ?> class="select_all_line_items" stage_id="<?php echo $stage['stage_id']; ?>"></label></div></th>
                                                                           <?php
                                                                                if(in_array(134, $this->session->userdata("permissions")) && in_array(153, $this->session->userdata("permissions"))) {
                                                                            ?>
                                                                           <th class="add_task_to_schedule">Add Task to Schedule</th>
                                                                           <?php } ?>
                                                                           <th>Action</th>
                                                                       </thead>
                                                                       <tbody>
                                                                            
                                                                            <?php 
                                                                            if(isset($stage["costing_parts"]) && count($stage["costing_parts"])>0){
                                                                            foreach ($stage["costing_parts"] As $key => $prjprt) {
    				        	                                            ?>
                                                                            <tr id="trnumber<?php echo $count;?>" rno="<?php echo $count;?>" tr_val="<?php echo $count;?>">
                                                                              
                                                                              <input  name="costing_tpe_id[]" rno ='<?php echo $count ?>' id="costing_tpe_id<?php echo $count ?>" type="hidden"  class="form-control" value="<?php echo $prjprt->costing_tpe_id ?>" />
    					        	                                          <input  name="costing_part_id[]" rno ='<?php echo $count ?>' id="costing_part_id<?php echo $count ?>" type="hidden"  class="form-control" value="<?php echo $prjprt->costing_part_id ?>" />
    								
                                                                               <td>
                                                                                    <select data-container="body" class="selectStage" data-style="btn btn-warning btn-round" title="Choose Stage" data-size="7" name="stage_id[]" id="stagefield<?php echo $count;?>" required="true">
                                                                                        <option value="<?php echo $prjprt->stage_id;?>" selected><?php echo $prjprt->stage_name;?></option>
                                                                                    </select>  
                                                                               </td>
                                                                               <td class="subcategory">
                                                                                   <input class="form-control sub-category-form-control" type="text" name="sub_category[]" id="subcategoryfield<?php echo $count;?>" value="<?php echo $prjprt->sub_category; ?>"/>
                                                                               </td>
                                                                               <td>
                                                                                   <input class="form-control part-form-control" type="text" name="part_name[]" id="partfield<?php echo $count;?>" required="true" value="<?php echo $prjprt->costing_part_name; ?>"/>
                                                                               </td>
                                                                               <td>
                                                                                   <select rno="<?php echo $count;?>" data-container="body" class="selectComponent" data-style="btn btn-warning btn-round" title="Choose Component" data-live-search="true" data-size="7" name="component_id[]" id="componentfield<?php echo $count;?>" required="true" onchange="return componentval(this);">
                                                                                       <option value="<?php echo $prjprt->component_id;?>" selected><?php echo $prjprt->component_name;?></option>
                                                                                    </select>
                                                                               </td>
                                                                               <td class="component_description"><textarea class="form-control" name="component_description[]" id="componentDescription<?php echo $count ?>" rno ='<?php echo $count ?>' readonly><?php echo $prjprt->component_des;?></textarea></td>
                                                                               <td>
                                                                                   <input type="text" class="form-control part_name_textfield" name="supplier_name[]" id="supplierfieldname<?php echo $count;?>" rno ='<?php echo $count;?>' value="<?php echo $prjprt->supplier_name;?>" readonly>
                                                                                   <input type="hidden" class="form-control" name="supplier_id[]" id="supplierfield<?php echo $count;?>" rno ='<?php echo $count;?>' value="<?php echo $prjprt->costing_supplier;?>" readonly>
                    		                                                       <input type="hidden" class="form-control" name="quantity_type[]" id="quantity_type<?php echo $count;?>" rno ='<?php echo $count;?>' value="<?php echo $prjprt->quantity_type;?>">
                                                                               </td>
                                                                               <td>
                                                                                   <input rno="<?php echo $count;?>" class="form-control qty" type="number" name="manualqty[]" id="manualqty<?php echo $count;?>" required="true" value="<?php echo number_format($prjprt->costing_quantity, 2, '.', ''); ?>" onchange="calculateTotal(this.getAttribute('rno'))"/>
                                                                               </td>
                                                                               <td>
                                                                                   <input rno="<?php echo $count;?>" class="form-control uom-form-control" type="text" name="component_uom[]" id="uomfield<?php echo $count;?>" required="true" value="<?php echo $prjprt->costing_uom ?>"/>
                                                                               </td>
                                                                               <td>
                                                                                   <input rno="<?php echo $count;?>" class="form-control uc-form-control" type="text" name="component_uc[]" id="ucostfield<?php echo $count;?>" required="true" value="<?php echo number_format($prjprt->costing_uc, 2, '.', ''); ?>" onchange="calculateTotal(this.getAttribute('rno'))"/>
                                                                                   <input type="hidden" id="order_unit_cost<?php echo $count ?>" rno ='<?php echo $count ?>' name="order_unit_cost[]" value="<?php echo number_format($prjprt->costing_uc, 2, '.', ''); ?>">
                                                                               </td>
                                                                               <td>
                                                                                   <input rno="<?php echo $count;?>" class="form-control uc-form-control" type="text" name="linetotal[]" id="linetotalfield<?php echo $count;?>" required="true" value="<?php echo number_format($prjprt->line_cost, 2, '.', ''); ?>"/>
                                                                               </td>
                                                                                <td>
                                                                                   <input rno="<?php echo $count;?>" class="form-control uc-form-control profitMargin" type="text" name="margin[]" id="marginfield<?php echo $count;?>" required="true" value="<?php echo $prjprt->margin ?>" onchange="calculateTotal(this.getAttribute('rno'))"/>
                                                                               </td>
                                                                               <td>
                                                                                   <input rno="<?php echo $count;?>" class="form-control uc-form-control line_margin_<?php echo $stage['stage_id']; ?>" type="text" name="margin_line[]" id="margin_linefield<?php echo $count;?>" required="true" value="<?php echo number_format($prjprt->line_margin, 2, '.', ''); ?>"/>
                                                                               </td>
                                                                               <td class="status">
                                                                                   <select rno="<?php echo $count;?>" data-container="body" class="selectpicker1 costestimation" data-style="btn btn-warning btn-round" title="Choose Status" data-size="7" name="status[]" id="statusfield<?php echo $count;?>" required="true" onChange="CheckCostEstimation();">
                                                                                        <option <?php if ($prjprt->type_status == "estimated") { echo "selected"; } ?> value="estimated" selected>Estimated</option>
                                                                                        <option <?php if ($prjprt->type_status == "price_finalized") { echo "selected"; } ?> value="price_finalized">Price Finalized</option>
                                                                                        <option <?php if ($prjprt->type_status == "allowance") { echo "selected"; } ?> value="allowance">Allowance</option>
                                                                                    </select>
                                                                                </td>
                                                                                <td class="include">
                                                                                    <div class="checkbox">
                                                                                        <label>
                                                                                            <input <?php if ($prjprt->include_in_specification == 1) { echo "checked";} ?> type="checkbox" name="specification_check[]" rno ='<?php echo $count;?>' id="specificationcheck<?php echo $count;?>" onClick="changeSpecificationValue(this.id, this.getAttribute('rno'))">
                                                                                        </label>
                                                                                    </div>
                                                                                      <input type="hidden" name="include_in_specification[]" value="<?php if ($prjprt->include_in_specification == 1) { echo "1"; } else {  echo "0";  } ?>" id="include_in_specification<?php echo $count;?>">
                                                                                </td>
                                                                                <td class="include">
                                                                                    <div class="checkbox">
                                                                                        <label>
                                                                                            <input type="checkbox" <?php if ($prjprt->client_allowance == 1) { echo "checked"; } ?> name="allowance_check[]" rno ='<?php echo $count;?>' id="allowance_check<?php echo $count;?>" onClick="changeAllowanceValue(this.id, this.getAttribute('rno'))" value="0">
                                                                                        </label>
                                                                                    </div>
                                                                                    <input type="hidden" name="allowance[]" value="<?php if ($prjprt->client_allowance == 1) { echo "1"; } else { echo "0";}?>" id="allowance<?php echo $count;?>"></td>
                                                                                <td class="comments">
                                                                                   <textarea name="comments[]" id="comments<?php echo $count;?>" class="form-control" style="width:200px;"><?php echo $prjprt->comment;?></textarea>
                                                                                </td>
                                                                                <td class="boom_mobile"> 
                                                                                   <div class="checkbox">
                                                                                        <label>
                                            										        <input <?php if ($prjprt->hide_from_boom_mobile == 1) { echo "checked";} ?> type="checkbox" name="boommobilecheck[]" rno ='<?php echo $count;?>'  id="boommobilecheck<?php echo $count;?>"  class="selected_items" onClick="changeBoomMobileValue(this.id,this.getAttribute('rno'))">
                                                                                        </label>
                                                                                    </div>
                                                                                    <input type="hidden" name="hide_from_boom_mobile[]" value="<?php if ($prjprt->hide_from_boom_mobile == 1) { echo "1"; } else {  echo "0";  } ?>" id="hide_from_boom_mobile<?php echo $count;?>">
                                            									</td>
                                            									    <?php
                                                                                        if(in_array(134, $this->session->userdata("permissions")) && in_array(153, $this->session->userdata("permissions"))) {
                                                                                    ?>
                                            										<td class="add_task_to_schedule"> 
                                                                                       <div class="checkbox">
                                                                                            <label>
                                                										        <input type="checkbox" <?php if ($prjprt->add_task_to_schedule == 1) { echo "checked";} ?> name="addtasktoschedulecheck[]" rno ='<?php echo $count;?>'  id="addtasktoschedulecheck<?php echo $count;?>"  class="selected_items" onClick="changeAddTaskToScheduleValue(this.id,this.getAttribute('rno'))">
                                                                                            </label>
                                                                                        </div>
                                                                                        <input type="hidden" name="add_task_to_schedule[]" value="<?php echo $prjprt->add_task_to_schedule;?>" id="add_task_to_schedule<?php echo $count;?>">
                                                									</td>
                                                									<?php } ?>
                                                                                <td class="text-right">
                                                                                   <a <?php if ($prjprt->is_locked == 1) { ?> class="btn btn-simple btn-danger btn-icon" <?php } else{ ?> class="btn btn-simple btn-success btn-icon" <?php } ?> id="iconlock<?php echo $count;?>" rno ='<?php echo $count;?>' onclick="changeLockStatus(this.getAttribute('rno'))"><?php if ($prjprt->is_locked == 1) { ?><i class="material-icons lock_icon_type lock_icon_type<?php echo $count;?>">lock</i> <?php } else{ ?> <i class="material-icons lock_icon_type<?php echo $count;?>">lock_open</i> <?php } ?></a>
                                                                                   <input type="hidden" name="is_line_locked[]" id="linelock<?php echo $count;?>" value="<?php echo $prjprt->is_locked;?>">
                                                                                   <a <?php if ($prjprt->is_locked == 1) { ?> style="display:none;" <?php } ?> rno="<?php echo $count;?>" class="btn btn-simple btn-danger btn-icon deleterow deleterow<?php echo $count;?>"><i class="material-icons">delete</i></a>
                                                                                   <?php 
                                                                                     $component_info = get_component_info($prjprt->component_id);
                                                                                     
                                                                                    if($prjprt->costing_uc!=$component_info['component_uc']){
                                                                                   ?>
                                                                                   <a <?php if ($prjprt->is_locked == 1) { ?> style="display:none;" <?php } ?> data-toggle="tooltip" title="Update Unit Cost To <?php echo number_format($component_info['component_uc'], 2, ".", "");?>" href="javascript:void(0)" rno ="<?php echo $count ?>" class="btn btn-simple btn-primary btn-icon updateunitcost updateunitcost<?php echo $count ?>"><i class="material-icons">autorenew</i></a>
                                                                                   <?php } ?>
                                                                                   <?php if ($prjprt->is_locked == 1) { ?>
                                                                                   <script>  $(function () {
                                                                                         changeLockToUnLockStatus(<?php echo $count;?>);
                                                                                    })</script>
        						                                                   <?php } ?>
                                                                                   <?php if ($prjprt->quantity_type == "formula") { ?>
                                                                                       <!--<a class="btn btn-simple btn-warning btn-icon" id="model<?php echo $count ?>" data-toggle="modal" role="button" href="#simpleModal" onclick="return modelid(this.title);"><span <?php if ($prjprt->quantity_type == "formula" && $prjprt->formula_text) { ?> data-toggle="tooltip" title="<?php echo str_replace('Formula : ', '', $prjprt->formula_text);?>"
                                                                        
                                                                                        <?php } ?>><i class="material-icons">functions</i></span></a>-->
                                                                                        
                                                                                    <?php } ?>
                                                                                        <input class="form-control formula" rno ='<?php echo $count?>' type="hidden" value="<?php echo $prjprt->quantity_formula; ?>" name="formula[]" id="formula_stage_<?php echo $count?>" title="<?php echo $count?>" alt="<?php echo $count?>">
                                                                                       <input class="form-control formulaqty <?php if ($prjprt->quantity_type == "formula") { echo "formulaqtty"; } ?>"  rno ='<?php echo $count?>' type="hidden" value="<?php echo $prjprt->quantity_formula; ?>" name="formulaqty[]" id="formulaqty_stage_<?php echo $count?>" title="<?php echo $count?>" alt="<?php echo $count?>">
                                                                                       <input class="form-control formulatext"  rno ='<?php echo $count?>' type="hidden" value="<?php echo $prjprt->formula_text;?>" name="formulatext[]" id="formulatext_stage_<?php echo $count?>" title="<?php echo $count?>" alt="<?php echo $count?>">
                                                                                       <input class="form-control"  rno ='<?php echo $count; ?>' type="hidden" value="<?php echo $prjprt->is_rounded;?>" name="is_rounded[]" id="is_rounded_stage_<?php echo $count; ?>" title="<?php echo $count; ?>" alt="<?php echo $count; ?>">
                                                                                      
                                                                                </td>
                                                                            </tr>
                                                                            <?php $count++; ?> 
                                                                            <?php 
                                                                            } 
                                                                            } ?>
                                                                        </tbody>
                                                                       </table>
                                                               </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                   
                                            		<?php endforeach; ?>
                                            		
                                            		<input type="hidden" id="last_row" name="last_row" value="<?php echo $count-1;?>">
                                            		<input type="hidden" id="current_project_id" name="current_project_id" value="<?php echo $project_id;?>">
                                            		<input type="hidden" id="selected_tab" name="selected_tab" value="edit_project_costing">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        
                        <div class="col-md-12 manual_project_costing_container">
                            <div class="card">
                                <div class="card-content">
                                    <div class="panel-group" id="accordionSummary" role="tablist" aria-multiselectable="true">
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingOneSummary">
                                                <a role="button" data-toggle="collapse" data-parent="#accordionSummary" href="#collapseOneSummary" aria-controls="collapseOneSummary">
                                                    <h4 class="panel-title">
                                                        Summary
                                                        <i class="material-icons">keyboard_arrow_down</i>
                                                    </h4>
                                                </a>
                                            </div>
                                            
                                            <?php 
                                            $project_subtotal = number_format($pc_detail->project_subtotal_1, 2, '.', '');
                                            $project_subtotal2 = number_format($pc_detail->project_subtotal_2, 2, '.', '');
                                            $project_subtotal3 = number_format($pc_detail->project_subtotal_3, 2, '.', '');
                                            $total_line_margins = number_format($pc_detail->porfit_margin>0?$pc_detail->porfit_margin:0, 2, '.', '');
                                            $overhead_total_cost = ($pc_detail->project_subtotal_1*($pc_detail->over_head_margin/100)) + $pc_detail->project_subtotal_1;
                                            $line_margins_total_cost = $project_subtotal + $total_line_margins;
                                            ?>
                                            <div id="collapseOneSummary" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOneSummary">
                                                <div class="panel-body">
                                                    <table class="table">
                                                      <tbody>
                                                          <tr>
                                                            <td><b>Project Subtotal</b></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td width="160">
                                                                <b>$<span class="projectSubtotal"><?php echo $project_subtotal;?></span></b>
                                                                <input type="hidden" name="total_cost" id="total_cost" value="<?php echo $project_subtotal;?>">
                                                            </td>
                                                          </tr>
                                                          <tr>
                                                            <td>Line Margins</td>
                                                            <td></td>
                                                            <td></td>
                                                            <td>$<span class="sumOfMargins"><?php echo $total_line_margins;?></span></td>
                                                            <td width="160">
                                                                $<span class="totalLineMargins"><?php echo $total_line_margins;?></span>
                                                                <input type="hidden" name="line_margins" id="line_margins" value="<?php echo $line_margins_total_cost;?>">
                                                            </td>
                                                          </tr>
                                                          <tr>
                                                            <td>Profit Margin (%)</td>
                                                            <td width="160"><input class="form-control cal-on-change" name="profit_margin" id="profit_margin" value="<?php echo number_format($pc_detail->porfit_margin, 2, '.', ''); ?>"></td>
                                                            <td></td>
                                                            <td>$<span class="calculatedProfitMargin"></span></td>
                                                            <td>
                                                                $<span class="profitMarginSubtotal"></span>
                                                                <input type="hidden" name="profitMarginSubtotal" id="profitMarginSubtotal" value="0.00">
                                                            </td>
                                                          </tr>
                                                          <tr>
                                                            <td>Overhead Margin (%)</td>
                                                            <td width="160"><input class="form-control cal-on-change" name="overhead_margin" id="overhead_margin" value="<?php echo number_format($pc_detail->over_head_margin, 2, '.', ''); ?>"  ></td>
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
                                                            <td width="160"><input class="form-control roundme" name="price_rounding" id="price_rounding" value="<?php $total2 = $pc_detail->price_rounding; echo number_format($total2, 2, '.', ''); ?>" required ></td>
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
                                                                <input type="hidden" name="total_cost2" id="total_cost2" value="<?php echo $project_subtotal2;?>">
                                                                <input type="hidden" name="total_cost3" id="total_cost3" value="<?php echo $project_subtotal3;?>">
                                                                <input type="hidden" name="contract_price" id="contract_price" value="<?php $gtotal = $project_subtotal3 + $total2; echo number_format($gtotal, 2, '.', '');?>" ></td>
                                                          </tr>
                                                          <tr>
                                                            <td colspan="2">Lock/Unlock</td>
                                                            <td></td>
                                                            <td></td>
                                                            <td  width="160"><a href="#" <?php if ($pc_detail->is_costing_locked == 1) {?> class="btn btn-simple btn-danger btn-icon" <?php } else{ ?> class="btn btn-simple btn-success btn-icon" <?php } ?> id="iconlockproject" onclick="LockProject()"><i class="material-icons lock_project_icon_type"><?php if ($pc_detail->is_costing_locked == 1) {?> lock <?php } else{ ?> lock_open <?php } ?></i></a>
                                                              <input type="hidden" name="lockproject" id="lockproject" value="<?php echo $pc_detail->is_costing_locked; ?>"></td>
                                                              <?php if ($pc_detail->is_costing_locked == 1) {?>
                                                                <script>  $(function () {
                                                                    LockProject();
                                                                })</script>
                                                            <?php } ?>
                                                          </tr>
                                                      </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="table-for-tod" class="manual_project_costing_container">
                            <?php echo $takeoffdata; ?>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-content">
                                     <div class="form-footer">
                                         <div class="pull-left">
                                            <?php if(in_array(4, $this->session->userdata("permissions"))) {?>
                                            <button type="submit" class="btn btn-warning btn-fill">Update Cost</button>
                                            <?php } ?>
                                         </div>
                                         <div class="pull-right">
                                            <?php if(in_array(2, $this->session->userdata("permissions"))) {?>
                                            <a href="<?php echo SURL;?>project_costing/report/project_costing/<?php echo $project_id;?>" class="btn btn-warning btn-fill">Report</a>
                                            <?php } ?>
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
                