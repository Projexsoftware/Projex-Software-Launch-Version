<?php $count = $last_row; ?>
<tr id="trnumber<?php echo $count?>" tr_val="<?php echo $count ?>">
    <input  name="costing_tpe_id[]" rno ='<?php echo $count ?>' id="costing_tpe_id<?php echo $count ?>" type="hidden"  class="form-control" value="0" />
	<input  name="costing_part_id[]" rno ='<?php echo $count ?>' id="costing_part_id<?php echo $count ?>" type="hidden"  class="form-control" value="0" />
								
   <td>
                                                               <select data-container="body" class="selectItemStage" data-style="btn btn-warning btn-round" title="Choose Stage" data-size="7" name="stage_id[]" id="stagefield<?php echo $count?>" required="true">
                                                                    <option disabled> Choose Stage</option>
                                                                </select>
                                                           </td>
                                                           <td class="subcategory">
                                                               <input rno="<?php echo $count;?>" class="form-control sub-category-form-control" type="text" name="sub_category[]" id="subcategoryfield<?php echo $count?>" value=""/>
                                                           </td>
                                                           <td>
                                                               <input class="form-control part-form-control" type="text" name="part_name[]" id="partfield<?php echo $count?>" required="true" value=""/>
                                                           </td>
                                                           <td>
                                                               <select rno="<?php echo $count?>" data-container="body" class="selectItemComponent" data-style="btn btn-warning btn-round" title="Choose Component" data-live-search="true" data-size="7" name="component_id[]" id="componentfield<?php echo $count?>" required="true" onchange="return componentval(this);">
                                                                    <option disabled> Choose Component</option>
                                                                </select>
                                                           </td>
                                                           <td class="component_description"><textarea class="form-control" name="component_description[]" id="componentDescription<?php echo $count ?>" rno ='<?php echo $count ?>' readonly></textarea></td>
    
                                                           <td>
                                                               <input type="text" class="form-control part_name_textfield" name="supplier_name[]" id="supplierfieldname<?php echo $count ?>" rno ='<?php echo $count ?>' value="" readonly>
                                                               <input type="hidden" class="form-control" name="supplier_id[]" id="supplierfield<?php echo $count ?>" rno ='<?php echo $count ?>' value="0" readonly>
		                                                       <input type="hidden" class="form-control" name="quantity_type[]" id="quantity_type<?php echo $count ?>" rno ='<?php echo $count ?>' value="manual">
		
                                                           </td>
                                                           <td>
                                                               <input rno="<?php echo $count;?>" class="form-control qty" type="number" min="0" name="manualqty[]" id="manualqty<?php echo $count?>" required="true" value="" onchange="calculateTotal(this.getAttribute('rno'))"/>
                                                           </td>
                                                            <td>
                                                               <input rno="<?php echo $count;?>" class="form-control uom-form-control" type="text" name="component_uom[]" id="uomfield<?php echo $count?>" required="true" value=""/>
                                                           </td>
                                                           <td>
                                                               <input rno="<?php echo $count;?>" class="form-control uc-form-control" type="text" name="component_uc[]" id="ucostfield<?php echo $count?>" required="true" value="" onchange="calculateTotal(this.getAttribute('rno'))"/>
                                                               <input type="hidden" id="order_unit_cost<?php echo $count ?>" rno ='<?php echo $count ?>' name="order_unit_cost[]" value="0.00">
                                                         
                                                           </td>
                                                           <td>
                                                               <input rno="<?php echo $count?>" class="form-control uc-form-control" type="text" name="linetotal[]" id="linetotalfield<?php echo $count?>" required="true" value="0.00"/>
                                                           </td>
                                                            <td>
                                                               <input rno="<?php echo $count?>" class="form-control uc-form-control profitMargin" type="text" name="margin[]" id="marginfield<?php echo $count?>" required="true" value="0" onchange="calculateTotal(this.getAttribute('rno'))"/>
                                                           </td>
                                                           <td>
                                                               <input rno="<?php echo $count?>" class="form-control uc-form-control" type="text" name="margin_line[]" id="margin_linefield<?php echo $count?>" required="true" value="0.00"/>
                                                           </td>
                                                           <td class="status">
                                                               <select rno="<?php echo $count?>" data-container="body" class="selectpicker1 costestimation" data-style="btn btn-warning btn-round" title="Choose Status" data-size="7" name="status[]" id="statusfield<?php echo $count?>" required="true" onChange="CheckCostEstimation();">
                                                                    <option value="estimated" selected>Estimated</option>
                                                                    <option value="price_finalized">Price Finalized</option>
                                                                    <option value="allowance">Allowance</option>
                                                                </select>
                                                            </td>
                                                            <td class="include">
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="specification_check[]" rno ='<?php echo $count?>' id="specificationcheck<?php echo $count?>" onClick="changeSpecificationValue(this.id, this.getAttribute('rno'))">
                                                                    </label>
                                                                </div>
                                                                  <input type="hidden" name="include_in_specification[]" value="0" id="include_in_specification<?php echo $count?>">
                                                            </td>
                                                            <td class="include">
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="allowance_check[]" rno ='<?php echo $count?>' id="allowance_check<?php echo $count?>" onClick="changeAllowanceValue(this.id, this.getAttribute('rno'))" value="0">
                                                                    </label>
                                                                </div>
                                                                <input type="hidden" name="allowance[]" value="0" id="allowance<?php echo $count?>"></td>
                                                            <td class="comments">
                                                               <textarea name="comments[]" id="comments<?php echo $count?>" class="form-control" style="width:200px;" placeholder="Enter comments here"></textarea>
                                                            </td>
                                                            <td class="boom_mobile"> 
                                                               <div class="checkbox">
                                                                    <label>
                        										        <input type="checkbox" name="boommobilecheck[]" rno ='<?php echo $count?>'  id="boommobilecheck<?php echo $count?>"  class="selected_items" onClick="changeBoomMobileValue(this.id,this.getAttribute('rno'))">
                                                                    </label>
                                                                </div>
                                                                <input type="hidden" name="hide_from_boom_mobile[]" value="0" id="hide_from_boom_mobile<?php echo $count?>">
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
                                                               <a class="btn btn-simple btn-success btn-icon" id="iconlock<?php echo $count?>" rno ='<?php echo $count?>' onclick="changeLockStatus(this.getAttribute('rno'))"><i class="material-icons lock_icon_type lock_icon_type<?php echo $count?>">lock_open</i></a>
                                                               <input type="hidden" name="is_line_locked[]" id="linelock<?php echo $count?>" value="0">
                                                               <a rno="<?php echo $count?>" class="btn btn-simple btn-danger btn-icon deleterow deleterow<?php echo $count;?>"><i class="material-icons">delete</i></a>
                                                               <input class="form-control formula" rno ='<?php echo $count?>' type="hidden" value="" name="formula[]" id="formula_stage_<?php echo $count?>" title="<?php echo $count?>" alt="<?php echo $count?>">
                                                               <input class="form-control formulaqty"  rno ='<?php echo $count?>' type="hidden" value="" name="formulaqty[]" id="formulaqty_stage_<?php echo $count?>" title="<?php echo $count?>" alt="<?php echo $count?>">
                                                               <input class="form-control formulatext"  rno ='<?php echo $count?>' type="hidden" value="" name="formulatext[]" id="formulatext_stage_<?php echo $count?>" title="<?php echo $count?>" alt="<?php echo $count?>">
                                                               <input class="form-control"  rno ='<?php echo $count; ?>' type="hidden" value="0" name="is_rounded[]" id="is_rounded_stage_<?php echo $count; ?>" title="<?php echo $count; ?>" alt="<?php echo $count; ?>">
                                                              
                                                            </td>
</tr>