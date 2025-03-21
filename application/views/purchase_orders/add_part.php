<?php
/**
 * Created by PhpStorm.
 * User: salman jutt
 * Date: 4/30/2017
 * Time: 1:35 PM
 */
$count = $last_row+1; ?>



<tr id="trnumber<?php echo $count; ?>" tr_val="<?php echo $count; ?>" class="new_item_row">
    <td>
        <input type="hidden" name="costing_part_id[<?php echo $count; ?>]" value="0">
        <input type="hidden" name="srno[<?php echo $count; ?>]" value="<?php echo $count; ?>">
        <select data-container="body" class="selectStage" data-style="btn btn-warning btn-round" title="Choose Stage" data-size="7" name="stage[<?php echo $count; ?>]" id="stagefield<?php echo $count?>" required="true">
                                                                    <option disabled> Choose Stage</option>
                                                                </select>
    </td>
    <td><input type="text" name="part[<?php echo $count; ?>]" id="partfield<?php echo $count; ?>" value="" rno ='<?php echo $count; ?>' class="form-control" required="true" uniques="true"/></td>
    <td>
        <select rno="<?php echo $count?>" data-container="body" class="selectComponent" data-style="btn btn-warning btn-round" title="Choose Component" data-live-search="true" data-size="7" name="component[<?php echo $count; ?>]" id="componentfield<?php echo $count?>" required="true" onchange="return componentval(this);">
                                                                    <option disabled> Choose Component</option>
                                                                </select>
    </td>
    <td>
        <input type="text" class="form-control" name="supplier_name[<?php echo $count; ?>]" id="supplierfieldname<?php echo $count ?>" rno ='<?php echo $count ?>' value="" readonly required="true">
        <input type="hidden" class="form-control" name="supplier_id[<?php echo $count; ?>]" id="supplierfield<?php echo $count ?>" rno ='<?php echo $count ?>' value="0" readonly>
		<input type="hidden" class="form-control" name="quantity_type[<?php echo $count; ?>]" id="quantity_type<?php echo $count ?>" rno ='<?php echo $count ?>' value="manual">
		
		
    </td>
    <td>
        <div class="manualfield" id="manualfield<?php echo $count; ?>">
            <input  name="manualqty[<?php echo $count; ?>]" rno ='<?php echo $count; ?>' id="manualqty<?php echo $count; ?>" type="text" name="" class="form-control quantity_ordered" value="0" required="true" onchange="calculateTotal(this.getAttribute('rno'))"/>
        </div>
        <div class="formulafield" id="formulafield<?php echo $count; ?>" style="display:none">
            <div class=""> <a class="btn btn-primary btn-small" id="model<?php echo $count; ?>" data-toggle="modal" role="button" title="_stage_<?php echo $count; ?>" href="#simpleModal" rno ='<?php echo $count?>' onclick="return modelid(this.title, this.getAttribute('rno'));">Create Formula</a>
                <h4 id="viewquanity<?php echo $count; ?>" class="viewquanity" ></h4>

                <input class="form-control formula" rno ='<?php echo $count; ?>' type="hidden" value="0" name="formula[<?php echo $count; ?>]" id="formula_stage_<?php echo $count; ?>" rno ='<?php echo $count?>' title="<?php echo $count; ?>" alt="<?php echo $count; ?>">

                <input class="form-control formulaqty " rno ='<?php echo $count; ?>' type="hidden" value="0" name="formulaqty[<?php echo $count; ?>]" id="formulaqty_stage_<?php echo $count; ?>" title="<?php echo $count; ?>" alt="<?php echo $count; ?>">

                <input class="form-control formulatext"  rno ='<?php echo $count; ?>' type="hidden" value="0" name="formulatext[<?php echo $count; ?>]" id="formulatext_stage_<?php echo $count; ?>" title="<?php echo $count; ?>" alt="<?php echo $count; ?>">

            </div>

        </div>
    </td>

    <td><input type="text" name="uom[<?php echo $count; ?>]" id="uomfield<?php echo $count; ?>" rno ='<?php echo $count; ?>' value="each" class="form-control" width="5" required="true"/></td>

    <td><input type="text" name="ucost[<?php echo $count; ?>]" id="ucostfield<?php echo $count; ?>" rno ='<?php echo $count; ?>' class="form-control" value="0.00" required="true" onchange="calculateTotal(this.getAttribute('rno'))"/></td>

    <td><input type="text" name="linttotal[<?php echo $count; ?>]"  rno ='<?php echo $count; ?>' id="linetotalfield<?php echo $count; ?>" class="form-control total_order_cost" value="0.00" required="true"/>

        <input type="hidden" name="useradditionalcost[<?php echo $count; ?>]"  rno ='<?php echo $count; ?>' id="useradditionalcost<?php echo $count; ?>" class="form-control useradditionalcost" value="0.00">
         <input type="hidden" name="margin[<?php echo $count; ?>]" id="marginfield<?php echo $count; ?>" rno ='<?php echo $count; ?>' onchange="calculateTotal(this.getAttribute('rno'))" value = "0"  class="form-control">
         <input type="hidden" name="marginaddcost_line[<?php echo $count; ?>]"  rno ='<?php echo $count ?>' id="marginaddcost_line<?php echo $count ?>" class="form-control marginaddcost_line" value="0.00"/>
         <input type="hidden" name="margin_line[<?php echo $count; ?>]"  rno ='<?php echo $count ?>' id="margin_linefield<?php echo $count ?>" class="form-control" value="0.00"/>
    </td>
   <td>
        <select data-container="body" name="status[<?php echo $count; ?>]" id="statusfield<?php echo $count; ?>" rno ='<?php echo $count; ?>' class="selectpicker costestimation" data-style="select-with-transition" onChange="CheckCostEstimation()">
            <option value="estimated">Estimated</option>
            <option value="prince_finalized">Price finalized</option>
            <option value="allowance">Allowance</option>
        </select>
    </td>

    <td>
        <div class="checkbox">
            <label><input type="checkbox" name="specification_check[<?php echo $count; ?>]" rno ='<?php echo $count; ?>'  id="specificationcheck<?php echo $count; ?>" onClick="changeSpecificationValue(this.id, this.getAttribute('rno'))"/></label>
        </div>
        
        <input type="hidden" name="include_in_specification[<?php echo $count; ?>]" value="0" id="include_in_specification<?php echo $count; ?>">
    </td>

    <td>
        <div class="checkbox">
            <label>
                <input type="checkbox" name="allowance_check[<?php echo $count; ?>]" rno ='<?php echo $count; ?>' id="allowance_check<?php echo $count; ?>" onClick="changeAllowanceValue(this.id, this.getAttribute('rno'))" value="0"/>
            </label>
        </div>
        <input type="hidden" name="allowance[<?php echo $count; ?>]" value="0" id="allowance<?php echo $count; ?>">
    </td>
    <td>
        <textarea name="comments[<?php echo $count ?>]" id="comments<?php echo $count?>" class="form-control" style="width:200px;" placeholder="Enter comments here"></textarea>
    </td>
    <td class="text-right">
        <a rno="<?php echo $count?>" class="btn btn-simple btn-danger btn-icon deleterow"><i class="material-icons">delete</i></a>
    </td>
</tr>

<?php $count ++ ?>

