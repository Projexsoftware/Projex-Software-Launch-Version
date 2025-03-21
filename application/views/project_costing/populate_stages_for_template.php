<?php $count = $next_row + 1; ?>
<?php 
foreach ($tmpparts As $key => $val) { ?>
<tr id="trnumber<?php echo $count;?>" rno="<?php echo $count;?>" tr_val="<?php echo $count;?>">
    <input  name="costing_tpe_id[]" rno ='<?php echo $count ?>' id="costing_tpe_id<?php echo $count ?>" type="hidden"  class="form-control" value="<?php echo $val->costing_tpe_id;?>" />
	<input  name="costing_part_id[]" rno ='<?php echo $count ?>' id="costing_part_id<?php echo $count ?>" type="hidden"  class="form-control" value="<?php echo $val->costing_part_id;?>" />
		
                                                           <td>
                                                               <select data-container="body" class="selectTemplateStage" data-style="btn btn-warning btn-round" title="Choose Stage" data-size="7" name="stage_id[]" id="stagefield<?php echo $count;?>" required="true">
                                                                    <option value="<?php echo $val->stage_id;?>" selected><?php echo $val->stage_name;?></option>
                                                                </select>
                                                           </td>
                                                           <td class="subcategory">
                                                               <input class="form-control sub-category-form-control" type="text" name="sub_category[]" id="subcategoryfield<?php echo $count;?>" value="<?php echo $val->tpl_sub_category ?>"/>
                                                           </td>
                                                           <td>
                                                               <input class="form-control part-form-control" type="text" name="part_name[]" id="partfield<?php echo $count;?>" required="true" value="<?php echo $val->tpl_part_name ?>"/>
                                                           </td>
                                                           <td>
                                                               <select rno="<?php echo $count;?>" data-container="body" class="selectTemplateComponent" data-style="btn btn-warning btn-round" title="Choose Component" data-live-search="true" data-size="7" name="component_id[]" id="componentfield<?php echo $count;?>" required="true" onchange="return componentval(this);">
                                                                    <option value="<?php echo $val->component_id;?>" selected><?php echo $val->component_name;?></option>
                                                                </select>
                                                           </td>
                                                           <td class="component_description"><textarea class="form-control" name="component_description[]" id="componentDescription<?php echo $count ?>" rno ='<?php echo $count ?>' readonly><?php echo $val->component_des;?></textarea></td>
								
                                                           <td>
                                                               <input type="text" class="form-control part_name_textfield" name="supplier_name[]" id="supplierfieldname<?php echo $count ?>" rno ='<?php echo $count ?>' value="<?php echo $val->supplier_name;?>" readonly>
                                                               <input type="hidden" class="form-control" name="supplier_id[]" id="supplierfield<?php echo $count ?>" rno ='<?php echo $count ?>' value="<?php echo $val->tpl_part_supplier_id;?>" readonly>
                                                            <input type="hidden" class="form-control" name="quantity_type[]" id="quantity_type<?php echo $count ?>" rno ='<?php echo $count ?>' value="<?php echo $val->tpl_quantity_type;?>">
		
                                                           </td>
                                                           <td>
                                                               <input class="form-control qty" type="number" rno="<?php echo $count;?>" name="manualqty[]" id="manualqty<?php echo $count;?>" required="true" value="<?php echo $val->tpl_quantity ?>" onchange="calculateTotal(this.getAttribute('rno'))"/>
                                                           </td>
                                                           <td>
                                                               <input rno="<?php echo $count;?>" class="form-control uom-form-control" type="text" name="component_uom[]" id="uomfield<?php echo $count;?>" required="true" value="<?php echo $val->tpl_part_component_uom; ?>"/>
                                                           </td>
                                                           <td>
                                                               <input rno="<?php echo $count;?>" class="form-control uc-form-control" type="text" name="component_uc[]" id="ucostfield<?php echo $count;?>" required="true" value="<?php echo number_format($val->tpl_part_component_uc, 2, '.', ''); ?>" onchange="calculateTotal(this.getAttribute('rno'))"/>
                                                               <input type="hidden" id="order_unit_cost<?php echo $count ?>" rno ='<?php echo $count ?>' name="order_unit_cost[]" value="<?php echo number_format($val->tpl_part_component_uc, 2, '.', ''); ?>">
		
                                                           </td>
                                                           <td>
                                                               <input rno="<?php echo $count;?>" class="form-control uc-form-control" type="text" name="linetotal[]" id="linetotalfield<?php echo $count;?>" required="true" value="<?php echo number_format((float) $val->tpl_quantity * (float) $val->tpl_part_component_uc, 2, '.', ''); ?>" onchange="calculateTotal(this.getAttribute('rno'))"/>
                                                           </td>
                                                            <td>
                                                               <input rno="<?php echo $count;?>" class="form-control uc-form-control profitMargin" type="text" name="margin[]" id="marginfield<?php echo $count;?>" required="true" onchange="calculateTotal(this.getAttribute('rno'))" value="0"/>
                                                           </td>
                                                           <td>
                                                               <input rno="<?php echo $count;?>" class="form-control uc-form-control" type="text" name="margin_line[]" id="margin_linefield<?php echo $count;?>" required="true" value="<?php echo number_format((float) $val->tpl_quantity * (float) $val->tpl_part_component_uc, 2, '.', ''); ?>"/>
                                                           </td>
                                                           <td class="status">
                                                               <select rno="<?php echo $count;?>" data-container="body" class="selectpicker1 costestimation" data-style="btn btn-warning btn-round" title="Choose Status" data-size="7" name="status[]" id="statusfield<?php echo $count;?>" required="true">
                                                                    <option selected value="estimated">Estimated</option>
                                                                    <option value="price_finalized">Price Finalized</option>
                                                                    <option value="allowance">Allowance</option>
                                                                </select>
                                                            </td>
                                                            <td class="include">
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="specification_check[]" rno ='<?php echo $count;?>' id="specificationcheck<?php echo $count;?>" onClick="changeSpecificationValue(this.id, this.getAttribute('rno'))">
                                                                    </label>
                                                                </div>
                                                                  <input type="hidden" name="include_in_specification[]" value="0" id="include_in_specification<?php echo $count;?>">
                                                            </td>
                                                            <td class="include">
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="allowance_check[]" rno ='<?php echo $count;?>' id="allowance_check<?php echo $count;?>" onClick="changeAllowanceValue(this.id, this.getAttribute('rno'))" value="0">
                                                                    </label>
                                                                </div>
                                                                <input type="hidden" name="allowance[]" value="0" id="allowance<?php echo $count;?>"></td>
                                                            <td class="comments">
                                                               <textarea rno="<?php echo $count;?>" name="comments[]" id="comments<?php echo $count;?>" placeholder="Enter comments here" class="form-control" style="width:200px;"></textarea>
                                                            </td>
                                                            <td class="boom_mobile"> 
                                                               <div class="checkbox">
                                                                    <label>
                        										        <input type="checkbox" name="boommobilecheck[]" rno ='<?php echo $count;?>'  id="boommobilecheck<?php echo $count;?>"  class="selected_items" onClick="changeBoomMobileValue(this.id,this.getAttribute('rno'))">
                                                                    </label>
                                                                </div>
                                                                <input type="hidden" name="hide_from_boom_mobile[]" value="0" id="hide_from_boom_mobile<?php echo $count;?>">
                        									</td>
                        									<?php
                                                                if(in_array(134, $this->session->userdata("permissions")) && in_array(153, $this->session->userdata("permissions"))) {
                                                            ?>
                        									<td class="add_task_to_schedule"> 
                                                               <div class="checkbox">
                                                                    <label>
                        										        <input type="checkbox" name="addtasktoschedulecheck[]" rno ='<?php echo $count;?>'  id="addtasktoschedulecheck<?php echo $count;?>"  class="selected_items" onClick="changeAddTaskToScheduleValue(this.id,this.getAttribute('rno'))">
                                                                    </label>
                                                                </div>
                                                                <input type="hidden" name="add_task_to_schedule[]" value="0" id="add_task_to_schedule<?php echo $count;?>">
                        									</td>
                        									<?php } ?>
                                                            <td class="text-right">
                                                               <a class="btn btn-simple btn-success btn-icon" id="iconlock<?php echo $count;?>" rno ='<?php echo $count;?>' onclick="changeLockStatus(this.getAttribute('rno'))"><i class="material-icons lock_icon_type<?php echo $count;?>">lock_open</i></a>
                                                               <input type="hidden" name="is_line_locked[]" id="linelock<?php echo $count;?>" value="0">
                                                               <a rno="<?php echo $count;?>" class="btn btn-simple btn-danger btn-icon deleterow"><i class="material-icons">delete</i></a>
                                                               <?php if ($val->tpl_quantity_type == "formula") { ?>
                                                               <a class="btn btn-simple btn-warning btn-icon" id="model<?php echo $count ?>" data-toggle="modal" role="button" href="#simpleModal" onclick="return modelid(this.title);"><span <?php if ($val->tpl_quantity_type == "formula" && $val->quantity_formula_text) { ?> data-toggle="tooltip" title="<?php echo str_replace('Formula : ', '', $val->quantity_formula_text);?>"
                                                
                                                                <?php } ?>><i class="material-icons">functions</i></span></a>
                                                                <?php } ?>
                                                                <input class="form-control formula" rno ='<?php echo $count?>' type="hidden" value="<?php echo $val->tpl_quantity_formula; ?>" name="formula[]" id="formula_stage_<?php echo $count?>" title="<?php echo $count?>" alt="<?php echo $count?>">
                                                               <input class="form-control formulaqty <?php if ($val->tpl_quantity_type == "formula") { echo "formulaqtty"; } ?>"  rno ='<?php echo $count?>' type="hidden" value="<?php echo $val->tpl_quantity_formula; ?>" name="formulaqty[]" id="formulaqty_stage_<?php echo $count?>" title="<?php echo $count?>" alt="<?php echo $count?>">
                                                               <input class="form-control formulatext"  rno ='<?php echo $count?>' type="hidden" value="<?php echo $val->quantity_formula_text;?>" name="formulatext[]" id="formulatext_stage_<?php echo $count?>" title="<?php echo $count?>" alt="<?php echo $count?>">
                                                               <input class="form-control"  rno ='<?php echo $count; ?>' type="hidden" value="<?php echo $val->is_rounded;?>" name="is_rounded[]" id="is_rounded_stage_<?php echo $count; ?>" title="<?php echo $count; ?>" alt="<?php echo $count; ?>">
                                                              
                                                            
                                                            </td>
                                                        </tr>
<?php 
$count++;
} ?>