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
              .comments, .status, .include, .boom_mobile{
                display:none;
              }
          </style> 
               <form id="ProjectCostingForm" method="POST" action="<?php echo SURL ?>project_costing/update_project_costing_process/<?php echo $pc_detail->costing_id;?>" onsubmit="return validateForm()">
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
                                            <li><a href="<?php echo SURL.'project_costing/edit_project_costing/'.$project_id;?>">Project Costing</a></li>
                                            <li class="active"><a href="#specificationCosting" data-toggle="tab">Specification Costing</a></li>
                                            <li><a href="<?php echo SURL.'project_costing/specification_options/'.$project_id;?>">Specification Options</a></li>
                                            <li><a href="<?php echo SURL.'project_costing/allowance_costing/'.$project_id;?>">Allowance Costing</a></li>
                                            <li><a href="<?php echo SURL.'project_costing/allowance_options/'.$project_id;?>">Allowance Options</a></li>
                                            <li><a href="<?php echo SURL.'project_costing/plans_and_specifications/'.$project_id;?>">Plans and Specifications</a></li>
                                        </ul>
                                    	<div class="tab-content">
                                    	    <div class="tab-pane active" id="specificationCosting">
                                    	        <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="col-md-12"><legend>Show/Hide Columns</legend></div>
                                                        <div class="col-md-2">
                                                            <div class="checkbox">
                                                                <label>
                                    								<input type="checkbox" name="column_status" id="column_status"  onchange="showcolumn('status')"> Status
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox">
                                                                <label>
                                    								<input type="checkbox" name="column_include" id="column_include"  onchange="showcolumn('include')"> Include in specification & client allowance
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="checkbox">
                                                                <label>
                                    								<input type="checkbox" name="column_comments" id="column_comments"  onchange="showcolumn('comments')"> Comments
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox">
                                                                <label>
                                    								<input type="checkbox" name="column_boom_mobile" id="column_boom_mobile"  onchange="showcolumn('boom_mobile')"> Boom Mobile Settings
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group label-floating">
                                                    <?php $count = 0;
                                                    foreach ($stages as $key => $stage): ?>
                    <?php if (in_array($stage['stage_id'], $saved_stages)) : 
                    $stage_total = 0;
                    $no_of_items = 0;
                    $no_of_checkboxes = 0;
                    foreach ($prjprts As $key => $prjprt) {
				        			
				        	if ($prjprt->stage_id == $stage['stage_id']) { 
							  $stage_total +=number_format($prjprt->line_margin, 2, '.', '');
							  $no_of_items++;
							  if($prjprt->hide_from_boom_mobile){
							     $no_of_checkboxes++; 
							  }
							}
							}?>
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
                                                                       <th>Part</th>
                                                                       <th>Component</th>
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
                                                                       <th class="boom_mobile">Hide From Boom Mobile <input type="checkbox" <?php if($no_of_items==$no_of_checkboxes){ ?> checked <?php } ?> class="select_all" stage_id="<?php echo $stage['stage_id']; ?>"</th>
                                                                   </thead>
                                                                   <tbody>
                                                                        
                                                                        <?php foreach ($prjprts As $key => $prjprt) {
				        	                                            if ($prjprt->stage_id == $stage['stage_id']) { ?>
                                                                        <tr id="trnumber<?php echo $count;?>" rno="<?php echo $count;?>" tr_val="<?php echo $count;?>">
                                                                            <input  name="costing_tpe_id[]" rno ='<?php echo $count ?>' id="costing_tpe_id<?php echo $count ?>" type="hidden"  class="form-control" value="<?php echo $prjprt->costing_tpe_id ?>" />
					        	                                          <input  name="costing_part_id[]" rno ='<?php echo $count ?>' id="costing_part_id<?php echo $count ?>" type="hidden"  class="form-control" value="<?php echo $prjprt->costing_part_id ?>" />
								
                                                                           <td>
                                                                                <select data-container="body" class="selectpicker" data-style="btn btn-warning btn-round" title="Choose Stage" data-size="7" name="stage_id[]" id="stagefield<?php echo $count;?>" required="true">
                                                                                    <option disabled> Choose Stage</option>
                                                                                    <?php
                                                                                    if(count($stages)>0){
                                                                                        foreach ($stages as $val) {
                                                                                        ?>
                                                                                            <option <?php if($prjprt->stage_id==$val['stage_id']){ ?> selected <?php } ?> value="<?php echo $val['stage_id'];?>"><?php echo $val["stage_name"];?></option>
                                                                                        <?php
                                                                                        }
                                                                                    }
                                                                                    ?>
                                                                                </select>  
                                                                           </td>
                                                                           <td>
                                                                               <input class="form-control part-form-control" type="text" name="part_name[]" id="partfield<?php echo $count;?>" required="true" uniques="true" value="<?php echo $prjprt->costing_part_name; ?>"/>
                                                                           </td>
                                                                           <td>
                                                                               <select rno="<?php echo $count;?>" data-container="body" class="selectpicker" data-style="btn btn-warning btn-round" title="Choose Component" data-live-search="true" data-size="7" name="component_id[]" id="componentfield<?php echo $count;?>" required="true" onchange="return componentval(this);">
                                                                                    <option disabled> Choose Component</option>
                                                                                    <?php
                                                                                    if(count($components)>0){
                                                                                        foreach ($components as $component) {
                                                                                        $component_info = get_component_info($component['component_id']);
                                                                                        ?>
                                                                                            <option <?php if($prjprt->component_id==$component['component_id']){ ?> selected <?php } ?> value="<?php echo $component['component_id'];?>"><?php echo escapeString($component["component_name"]).' ('.escapeString($component_info["supplier_name"]).'|'.$component_info["component_uc"].')'; ?></option>
                                                                                        <?php
                                                                                        }
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                           </td>
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
                                                                           </td>
                                                                           <td>
                                                                               <input rno="<?php echo $count;?>" class="form-control uc-form-control" type="text" name="linetotal[]" id="linetotalfield<?php echo $count;?>" required="true" value="<?php echo number_format($prjprt->line_cost, 2, '.', ''); ?>"/>
                                                                           </td>
                                                                            <td>
                                                                               <input rno="<?php echo $count;?>" class="form-control uc-form-control" type="text" name="margin[]" id="marginfield<?php echo $count;?>" required="true" value="<?php echo $prjprt->margin ?>" onchange="calculateTotal(this.getAttribute('rno'))"/>
                                                                           </td>
                                                                           <td>
                                                                               <input rno="<?php echo $count;?>" class="form-control uc-form-control line_margin_<?php echo $stage['stage_id']; ?>" type="text" name="margin_line[]" id="margin_linefield<?php echo $count;?>" required="true" value="<?php echo number_format($prjprt->line_margin, 2, '.', ''); ?>"/>
                                                                           </td>
                                                                           <td class="status">
                                                                               <select rno="<?php echo $count;?>" data-container="body" class="selectpicker costestimation" data-style="btn btn-warning btn-round" title="Choose Status" data-size="7" name="status[]" id="statusfield<?php echo $count;?>" required="true" onChange="CheckCostEstimation();">
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
                                                                        </tr>
                                                                        <?php $count++; } ?> 
                                                                        <?php 
                                                                        } ?>
                                                                    </tbody>
                                                                   </table>
                                                           </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                <?php endif; ?>
                                        		<?php endforeach; ?>
                                        		<input type="hidden" id="last_row" name="last_row" value="<?php echo $count-1;?>">
                                        		<input type="hidden" id="current_project_id" name="current_project_id" value="<?php echo $project_id;?>">
                                        		<input type="hidden" id="selected_tab" name="selected_tab" value="specification_costing">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
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
                                            <a href="<?php echo SURL;?>project_costing/report/specification_costing/<?php echo $project_id;?>" class="btn btn-warning btn-fill">Report</a>
                                            <?php } ?>
                                            <a href="<?php echo SURL;?>project_costing" class="btn btn-default btn-fill">Close</a>
                                      </div>
                                     </div>
                                 </div>
                            </div>
                        </div>
                    </div>
                </form>
                    
                