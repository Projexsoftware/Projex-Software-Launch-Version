<?php $count = $last_row + 1; ?>
<tr id="trnumber<?php echo $count?>" tr_val="<?php echo $count ?>">
   <td>
    <input type="hidden" name="var_type[<?php echo $count ?>]" id="vartypefield<?php echo $count; ?>" rno ='<?php echo $count; ?>' value="1">
    <input type="hidden" id="costing_part_id<?php echo $count; ?>" name="costing_part_id[<?php echo $count ?>]" value="0">
    <input  name="variation_part_id[<?php echo $count ?>]" rno ='<?php echo $count ?>' id="variation_part_id<?php echo $count ?>" type="hidden"  class="form-control" value="<?php echo 0; ?>" />
    <input type="hidden" name="is_including_pc[<?php echo $count ?>]" value="<?php echo 0; ?>">
                                                                <select rno ='<?php echo $count ?>' data-container="body" class="selectStage" data-style="btn btn-warning btn-round" title="Choose Stage" data-size="7" name="stage[<?php echo $count ?>]" id="stagefield<?php echo $count?>" required="true">
                                                                    <option disabled> Choose Stage</option>
                                                                </select>
                                                           </td>
                                                           <td>
                                                               <input class="form-control part-form-control" type="text" name="part[<?php echo $count ?>]" id="partfield<?php echo $count?>" required="true" uniques="true" rno ='<?php echo $count ?>' value=""/>
                                                           </td>
                                                           <td>
                                                               <select rno="<?php echo $count?>" data-container="body" class="selectComponent" data-style="btn btn-warning btn-round" title="Choose Component" data-live-search="true" data-size="7" name="component[<?php echo $count ?>]" id="componentfield<?php echo $count?>" required="true" onchange="return componentval(this);">
                                                                    <option disabled> Choose Component</option>
                                                                </select>
                                                           </td>
                                                           <td>
                                                               <input type="text" class="form-control part_name_textfield" name="supplier_name[<?php echo $count ?>]" id="supplierfieldname<?php echo $count ?>" rno ='<?php echo $count ?>' value="" readonly>
                                                               <input type="hidden" class="form-control" name="supplier_id[<?php echo $count ?>]" id="supplierfield<?php echo $count ?>" rno ='<?php echo $count ?>' value="0" readonly>
		                                                       <input type="hidden" class="form-control" name="quantity_type[<?php echo $count ?>]" id="quantity_type<?php echo $count ?>" rno ='<?php echo $count ?>' value="manual">
		
                                                           </td>
                                                           <td>
                                                               <input rno="<?php echo $count;?>" class="form-control qty" type="hidden" name="manualqty[<?php echo $count ?>]" id="manualqty<?php echo $count?>" value="0" onchange="calculateTotal(this.getAttribute('rno'))"/>
                                                               0
                                                           </td>
                                                           <td>0.00</td>
                                                           <td><input required="true" type="number" name="changeQty[<?php echo $count ?>]" rno ='<?php echo $count; ?>' id="changeqty<?php echo $count; ?>"   class=" form-control changeQty" value="0" onchange="calculateUpdatedTotal(this.getAttribute('rno'))"/></td>
                                                           <td><input type="text" name="updatedQty[<?php echo $count ?>]" rno ='<?php echo $count; ?>' id="updatedqty<?php echo $count; ?>"   class=" form-control upq" value="0"
                                                                       onchange="calculateTotal(this.getAttribute('rno'))" readonly/></td>
                                                            <td>
                                                               <input rno="<?php echo $count;?>" class="form-control uom-form-control" type="text" name="uom[<?php echo $count ?>]" id="uomfield<?php echo $count?>" required="true" value=""/>
                                                           </td>
                                                           <td>
                                                               <input rno="<?php echo $count;?>" class="form-control uc-form-control" type="text" name="ucost[<?php echo $count ?>]" id="ucostfield<?php echo $count?>" required="true" value="" onchange="calculateTotal(this.getAttribute('rno'))"/>
                                                           </td>
                                                           <td>
                                                                <input type="text" name="additionalcost[<?php echo $count ?>]"  rno ='<?php echo $count; ?>' id="additionalcost<?php echo $count; ?>" class="form-control additionalcost" value="0.00" onchange="add_client_additional_cost(this.getAttribute('rno'))" />
                                                                <input type="hidden" name="useradditionalcost[<?php echo $count ?>]"  rno ='<?php echo $count; ?>' id="useradditionalcost<?php echo $count; ?>" class="form-control useradditionalcost" value="0.00">
                                                        
                                                                 <input type="hidden" name="linetotal[<?php echo $count ?>]"  rno ='<?php echo $count; ?>' id="linetotalfield<?php echo $count; ?>" class="form-control" value="0.00" />
                                                                 <input type="hidden" name="margin[<?php echo $count ?>]" id="marginfield<?php echo $count; ?>" rno ='<?php echo $count; ?>' onchange="calculateTotal(this.getAttribute('rno'))" value = "0"  class="form-control">
                                                                 <input type="hidden" name="marginaddcost_line[<?php echo $count ?>]"  rno ='<?php echo $count ?>' id="marginaddcost_line<?php echo $count ?>" class="form-control" value="<?php echo "0.00"; ?>"/>
                                                                 <input type="hidden" name="margin_line[<?php echo $count ?>]"  rno ='<?php echo $count ?>' id="margin_linefield<?php echo $count ?>" class="form-control" value="0.00"/>
                                                           
                                                            </td>
                                                            
                                                           <td class="status">
                                                               <select rno="<?php echo $count?>" data-container="body" class="selectpicker costestimation" data-style="btn btn-warning btn-round" title="Choose Status" data-size="7" name="status[<?php echo $count ?>]" id="statusfield<?php echo $count?>" required="true" onChange="CheckCostEstimation();">
                                                                    <option value="estimated" selected>Estimated</option>
                                                                    <option value="price_finalized">Price Finalized</option>
                                                                    <option value="allowance">Allowance</option>
                                                                </select>
                                                            </td>
                                                            <td class="include">
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="specification_check[<?php echo $count ?>]" rno ='<?php echo $count?>' id="specificationcheck<?php echo $count?>" onClick="changeSpecificationValue(this.id, this.getAttribute('rno'))">
                                                                    </label>
                                                                </div>
                                                                  <input type="hidden" name="include_in_specification[<?php echo $count ?>]" value="<?php echo $count?>" id="include_in_specification<?php echo $count?>">
                                                            </td>
                                                            <td class="include">
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="allowance_check[<?php echo $count ?>]" rno ='<?php echo $count?>' id="allowance_check<?php echo $count?>" onClick="changeAllowanceValue(this.id, this.getAttribute('rno'))" value="0">
                                                                    </label>
                                                                </div>
                                                                <input type="hidden" name="allowance[<?php echo $count ?>]" value="0" id="allowance<?php echo $count?>"></td>
                                                            <td class="text-right">
                                                               <a class="btn btn-simple btn-success btn-icon" id="iconlock<?php echo $count?>" rno ='<?php echo $count?>' onclick="changeLockStatus(this.getAttribute('rno'))"><i class="material-icons">lock_open</i></a>
                                                               <input type="hidden" name="is_line_locked[<?php echo $count ?>]" id="linelock<?php echo $count?>" value="0">
                                                               <a rno="<?php echo $count?>" class="btn btn-simple btn-danger btn-icon deleterow"><i class="material-icons">delete</i></a>
                                                            </td>
</tr>