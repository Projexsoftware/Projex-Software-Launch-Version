<?php $count = $last_row; 
?>

<?php
    $supplier_ordered_quantity = get_supplier_ordered_quantity($partDetail->costing_part_id);
 
    $recent_quantity = get_recent_variation_quantity($partDetail->costing_part_id, $partDetail->costing_supplier);
    $recent_total = 0;
    foreach($recent_quantity as $val){
        $recent_total += $val['total'];
    }
    $updated_total = 0;
    foreach($recent_quantity as $val){
        $updated_total = $val['updated_quantity'];
    }
    if(count($recent_quantity)>0){
              if($partDetail->costing_type=="normal" || $partDetail->costing_type=="autoquote"){
               $uninvoicedquantity = ($partDetail->costing_quantity+$recent_total) - $supplier_ordered_quantity;
               $costing_quantity = ($partDetail->costing_quantity+$recent_total);
              }
              else{
                  $uninvoicedquantity = $updated_total - $supplier_ordered_quantity;
                   $costing_quantity = $updated_total;
              }
            }
            else{
               $uninvoicedquantity = $partDetail->costing_quantity - $supplier_ordered_quantity;
                $costing_quantity = $partDetail->costing_quantity;
            }
    if(($uninvoicedquantity)>0){

?>
<tr id="trnumber<?php echo $count?>" tr_val="<?php echo $count ?>">
   <td>
        <input type="hidden" id="vartypefield<?php echo $count; ?>" name="var_type[<?php echo $count; ?>]" value="0">
        <input type="hidden" id="costing_part_id<?php echo $count; ?>" name="costing_part_id[<?php echo $count; ?>]" value="<?php echo $partDetail->costing_part_id ?>">
        <input type="hidden" id="is_including_pc<?php echo $count; ?>" name="is_including_pc[<?php echo $count; ?>]" value="<?php echo $partDetail->costing_part_id ?>">
        <input  name="variation_part_id[<?php echo $count; ?>]" rno ='<?php echo $count ?>' id="variation_part_id<?php echo $count ?>" type="hidden"  class="form-control" value="<?php echo 0; ?>" />
    
        <input type="hidden" name="stage[<?php echo $count; ?>]" id="stagefield<?php echo $count; ?>" rno ='<?php echo $count; ?>' class="form-control" value="<?php echo $partDetail->stage_id ?>">
        <?php echo $partDetail->stage_name ?>
    </td>
    <td><input type="hidden" name="part[<?php echo $count; ?>]" id="partfield<?php echo $count; ?>" value="<?php echo $partDetail->costing_part_name ?>" rno ='<?php echo $count; ?>' class="form-control" />
        <?php echo $partDetail->costing_part_name; ?>
    </td>
    <td>
        <input type="hidden" name="component[<?php echo $count; ?>]" id="componentfield<?php echo $count; ?>" rno ='<?php echo $count; ?>' value="<?php echo $partDetail->component_id ?>">
        <?php if($partDetail->costing_type=="autoquote"){ 
        $summary_info = get_summary_info_by_autoquote($partDetail->costing_tpe_id);
        ?>
        <?php echo $summary_info["component_name"]; ?>
        <?php } else{ 
         $component_info = get_component_info($partDetail->component_id); 
         ?>                              

        <?php echo escapeString($partDetail->component_name).' ('.escapeString($component_info['supplier_name']).'|'.$component_info['component_uc'].')'; ?>
        <?php } ?>

    </td>
    <td>

        <input type="hidden" name="supplier_id[<?php echo $count; ?>]" id="supplierfield<?php echo $count; ?>" rno ='<?php echo $count; ?>' value="<?php echo $partDetail->costing_supplier ?>">
        <?php echo $partDetail->supplier_name; ?>
    </td>
 <input type="hidden" name="quantity_type[<?php echo $count; ?>]" rno ='<?php echo $count; ?>' id="quantity_type_<?php echo $count; ?>" class="form-control" qtype_number="<?php echo $count; ?>" value="<?php echo $partDetail->quantity_type; ?>">

    <td>
        <div class="manualfield" id="manualfield<?php echo $count; ?>">

            <input type="hidden" name="manualqty[<?php echo $count; ?>]" rno ='<?php echo $count; ?>' id="manualqty<?php echo $count; ?>"  value="<?php echo $uninvoicedquantity; ?>" class="qty form-control readonlyme"  onchange="calculateTotal(this.getAttribute('rno'))"/>

        </div>

        <?php
        $data_array = $uninvoicedquantity;


        echo $data_array;
        ?>
        <div class="formulafield" id="formulafield<?php echo $count; ?>" style="display:none">
            <div class=""> <a class="btn btn-primary btn-small" id="model<?php echo $count; ?>" data-toggle="modal" role="button" title="_stage_<?php echo $count; ?>" href="#simpleModal" rno ='<?php echo $count ?>' onclick="return modelid(this.title, this.getAttribute('rno'));">Create Formula</a>
                <h4 id="viewquanity<?php echo $count; ?>" class="viewquanity" ></h4>
                <input class="form-control formula" rno ='<?php echo $count; ?>' type="hidden" value="<?php echo $partDetail->quantity_formula ?>" name="formula[<?php echo $count; ?>]" id="formula_stage_<?php echo $count; ?>" rno ='<?php echo $count ?>' title="<?php echo $count; ?>" alt="<?php echo $count; ?>">
                <input class="form-control formulaqty " rno ='<?php echo $count; ?>' type="hidden" value="<?php echo $partDetail->quantity_formula ?>" name="formulaqty[<?php echo $count; ?>]" id="formulaqty_stage_<?php echo $count; ?>" title="<?php echo $count; ?>" alt="<?php echo $count; ?>">
                <input class="form-control formulatext"  rno ='<?php echo $count; ?>' type="hidden" value="<?php echo $partDetail->formula_text ?>" name="formulatext[<?php echo $count; ?>]" id="formulatext_stage_<?php echo $count; ?>" title="<?php echo $count; ?>" alt="<?php echo $count; ?>">
            </div>
        </div>
    </td>
    <td>
        <?php echo number_format((($uninvoicedquantity)*$partDetail->costing_uc)*((100+$partDetail->margin)/100), 2, ".", ""); ?></td>
    <td><input type="text" name="changeQty[<?php echo $count; ?>]" rno ='<?php echo $count; ?>' id="changeqty<?php echo $count; ?>"   class=" form-control changeQty" value="0" onchange="calculateUpdatedTotal(this.getAttribute('rno'))"/></td>
    <td><input type="text" name="updatedQty[<?php echo $count; ?>]" rno ='<?php echo $count; ?>' id="updatedqty<?php echo $count; ?>"   class=" form-control" value="<?php
        $data_array2 = $uninvoicedquantity;



        echo
        $data_array2;
        ?>" readonly/></td>
    <td>
        <input type="hidden" name="uom[<?php echo $count; ?>]" id="uomfield<?php echo $count; ?>" rno ='<?php echo $count; ?>' value="<?php echo $partDetail->costing_uom; ?>" class="form-control" width="5" />
    <?php echo $partDetail->costing_uom; ?>
    </td>
    <td><?php if($partDetail->costing_type=="autoquote"){ ?>
        <input type="hidden" name="ucost[<?php echo $count; ?>]" id="ucostfield<?php echo $count; ?>" rno ='<?php echo $count; ?>' class="form-control" value="<?php echo $partDetail->costing_uc; ?>" onchange="calculateTotal(this.getAttribute('rno'))"/>
        Auto Quote
    <?php } else{ ?>
    <input type="text" name="ucost[<?php echo $count; ?>]" id="ucostfield<?php echo $count; ?>" rno ='<?php echo $count; ?>' class="form-control" value="<?php echo $partDetail->costing_uc; ?>" onchange="calculateTotal(this.getAttribute('rno'))"/>
    <?php } ?>
    </td>
    <td><!-- additional cost-->

        <input type="hidden" name="additionalcost[<?php echo $count; ?>]"  rno ='<?php echo $count; ?>' id="additionalcost<?php echo $count; ?>" class="form-control additionalcost"
               value="<?php echo 0.00; ?>" />  <span id = "my_id_additionalcost_<?php echo $count; ?>" > <?php echo "0.00"; ?> </span>
               <input type="hidden" name="useradditionalcost[<?php echo $count; ?>]"  rno ='<?php echo $count; ?>' id="useradditionalcost<?php echo $count; ?>" class="form-control useradditionalcost"
               value="<?php echo number_format(0, 2, '.', ''); ?>" /> 

    </td>
    
    <?php $line_total = $data_array2 * $partDetail->costing_uc; ?>
        <input type="hidden" name="linetotal[<?php echo $count; ?>]"  rno ='<?php echo $count; ?>' id="linetotalfield<?php echo $count; ?>" class="form-control"
               value="<?php echo $line_total; ?>" />
               <input type="hidden" name="margin[<?php echo $count; ?>]" id="marginfield<?php echo $count; ?>" rno ='<?php echo $count; ?>' onchange="calculateTotal(this.getAttribute('rno'))" value = "<?php echo $partDetail->margin; ?>"  class="form-control">
               <input type="hidden" name="marginaddcost_line[<?php echo $count; ?>]"  rno ='<?php echo $count ?>' id="marginaddcost_line<?php echo $count ?>" class="form-control" value="<?php echo number_format(0, 2, '.', ''); ?>"/>
               <?php $total_after_margin = ($line_total * (100 + $partDetail->margin) / 100); ?>

        <input type="hidden" name="margin_line[<?php echo $count; ?>]"  rno ='<?php echo $count ?>' id="margin_linefield<?php echo $count ?>" class="form-control" value="<?php echo number_format($total_after_margin, 2, '.', ''); ?>"/>
    <td>
        <select rno="<?php echo $count?>" data-container="body" class="selectpicker costestimation" data-style="btn btn-warning btn-round" title="Choose Status" data-size="7" name="status[<?php echo $count; ?>]" id="statusfield<?php echo $count?>" required="true" onChange="CheckCostEstimation();">
                <option value="estimated" <?php if ($partDetail->type_status == "estimated") { echo "selected";} ?>>Estimated</option>
                <option value="price_finalized" <?php if ($partDetail->type_status == "price_finalized") { echo "selected"; } ?>>Price Finalized</option>
                <option value="allowance" <?php if ($partDetail->type_status == "estimated") { echo "selected"; } ?>>Allowance</option>
        </select>
    </td>
    <td>
        <div class="checkbox">
            <label>
                <input <?php if ($partDetail->include_in_specification == "1") {
                    echo "checked";
                } ?> type="checkbox" name="specification_check[<?php echo $count; ?>]" rno ='<?php echo $count; ?>'  id="specificationcheck<?php echo $count; ?>" onClick="changeSpecificationValue(this.id, this.getAttribute('rno'))"/>
            
                </label>
        </div>
        <input type="hidden" name="include_in_specification[<?php echo $count; ?>]" value="<?php echo $partDetail->include_in_specification; ?>" id="include_in_specification<?php echo $count; ?>">
    </td>
    <td>
        <div class="checkbox">
                <label>
           <input <?php if ($partDetail->client_allowance == "1") {
            echo "checked";
        } ?> type="checkbox" name="allowance_check[<?php echo $count; ?>]" rno ='<?php echo $count; ?>' id="allowance_check<?php echo $count; ?>" onClick="changeAllowanceValue(this.id, this.getAttribute('rno'))" value="0"/>
            </label>
        </div>
        <input type="hidden" name="allowance[<?php echo $count; ?>]" value="<?php echo $partDetail->client_allowance; ?>" id="allowance<?php echo $count; ?>">
    </td>
    <td>
        <a class="btn btn-simple btn-success btn-icon" id="iconlock<?php echo $count?>" rno ='<?php echo $count?>' onclick="changeLockStatus(this.getAttribute('rno'))"><i class="material-icons">lock_open</i></a>
        <input type="hidden" name="is_line_locked[<?php echo $count; ?>]" id="linelock<?php echo $count?>" value="0">
        <a rno="<?php echo $count?>" class="btn btn-simple btn-danger btn-icon deleterow"><i class="material-icons">delete</i></a>
    </td>
</tr>

<?php $count ++;
}
?>
                                                           