<?php $count = $last_row + 1;
/*echo "<pre>";
foreach ($partDetail as $key => $value) {
        if($value->costing_part_id == 67765){
            print_r($value);
            $ordered_quantity = get_ordered_quantity($value->costing_part_id);
            echo "ordered_quantity:".$ordered_quantity;
            echo "<br>";
            $updated_quantity = get_recent_quantity($value->costing_part_id);
            echo "updated_quantity:".$updated_quantity['updated_quantity'];
            echo "<br>";
        if(count($updated_quantity)>0 && $updated_quantity['updated_quantity']>0){
       
             $remaining_quantity = $updated_quantity['updated_quantity'] - $ordered_quantity;
        
        }
        else  if(count($updated_quantity)>0 && $updated_quantity['updated_quantity']==0){
            $remaining_quantity = $updated_quantity['updated_quantity'];
        }
        else{
           $remaining_quantity = $value->costing_quantity - $ordered_quantity; 
        }
        echo "remaining_quantity:".$remaining_quantity;
            echo "<br>";exit;
        }
}*/
if(count($partDetail)>0){
    /*foreach ($partDetail as $key => $value) {
    if($value->costing_part_id == 67724){
        $ordered_quantity = get_ordered_quantity($value->costing_part_id);
        $updated_quantity = get_recent_quantity($value->costing_part_id);
        if(count($updated_quantity)>0 && $updated_quantity['updated_quantity']>0){
       
             $remaining_quantity = $updated_quantity['updated_quantity'] - $ordered_quantity;
        
        }
        else  if(count($updated_quantity)>0 && $updated_quantity['updated_quantity']==0){
            $remaining_quantity = $updated_quantity['updated_quantity'];
        }
        else{
           $remaining_quantity = $value->costing_quantity - $ordered_quantity; 
        }
            echo "order Quantity =".$ordered_quantity;
            echo "updated Quantity =".$updated_quantity;
            echo "remaining Quantity =".$remaining_quantity;
        }
    }
        exit;*/
    foreach ($partDetail as $key => $value) {
        
        $ordered_quantity = get_ordered_quantity($value->costing_part_id);
        $updated_quantity = get_recent_quantity($value->costing_part_id);
        if(count($updated_quantity)>0 && $updated_quantity['updated_quantity']>0){
       
             $remaining_quantity = $updated_quantity['updated_quantity'] - $ordered_quantity;
        
        }
        else  if(count($updated_quantity)>0 && $updated_quantity['updated_quantity']==0){
            $remaining_quantity = $updated_quantity['updated_quantity'];
        }
        else{
           $remaining_quantity = $value->costing_quantity - $ordered_quantity; 
        }
    
        if($remaining_quantity>0){
 ?>

<tr id="pmtrnumber<?php echo $count; ?>" tr_val="<?php echo $count; ?>">
    <input type="hidden" name="marginaddprojectcost_line[<?php echo $count; ?>]"  rno ='<?php echo $count ?>' id="marginaddprojectcost_line<?php echo $count ?>" class="form-control marginaddprojectcost_line" value="0.00"/>
<input type="hidden"  name="pmcosting_part_id[<?php echo $count; ?>]" value="<?php echo $value->costing_part_id?>">
<input type="hidden"  name="pmclient_allowance[<?php echo $count; ?>]" value="<?php echo $value->client_allowance?>">
<input type="hidden"  name="pminclude_in_specification[<?php echo $count; ?>]" value="<?php echo $value->include_in_specification?>">
<input type="hidden"  name="pmmargin_line[<?php echo $count; ?>]" value="<?php echo $value->line_margin?>">
<input type="hidden"  name="pmstatus[<?php echo $count; ?>]" value="<?php echo $value->type_status?>">
<input type="hidden"  name="pmcomments[<?php echo $count; ?>]" value="<?php echo $value->comment?>">

<td><input type="hidden" value="<?php echo $value->stage_id; ?>" name="pmstage[<?php echo $count; ?>]" ><?php echo $value->stage_name; ?></td>

 <td><input type="hidden"  name="pmpart[<?php echo $count; ?>]" id="pmpartfield<?php echo $count; ?>" value="<?php echo $value->costing_part_name?>" rno ='<?php echo $count; ?>' class="form-control readonlyme" readonly /><?php 
$variationNum = "";
if($value->costing_type=="normal" && $value->isp_variated==0){
   $variationNum = "";
}
else if($value->isp_variated>0){
    $variationNum = 'Variation Number: '.(10000000+$value->is_variated).', ';
}
else {
    $variationNum = 'Variation Number: '.(10000000+get_variation_number($value->costing_id, $value->costing_part_id)).', ';
}
    echo $variationNum;
    echo $value->costing_part_name ;?></td>
    <td>

        <input type="hidden" name="pmcomponent[<?php echo $count; ?>]" id="pmcomponentfield<?php echo $count; ?>" rno ='<?php echo $count; ?>' value="<?php echo $value->component_id?>" class="form-control readonlyme" >
        <?php echo $value->component_name?>

    </td>
    <td>

        <input type="hidden" name="pmsupplier[<?php echo $count; ?>]" id="pmsupplierfield<?php echo $count; ?>" rno ='<?php echo $count; ?>' value="<?php echo $value->costing_supplier?>" class="form-control globalSupplier" >
        <?php echo $value->supplier_name?>

    </td>
    <td><input  readonly  rno ="<?php echo $count; ?>" value="<?php echo $remaining_quantity; ?>" name="pmreqquantitys[<?php echo $count; ?>]" class="form-control readonlyme" id="pmreqquantitys<?php echo $count; ?>"  ></td>

    <td><input readonly type="text"  name="pmuom[<?php echo $count; ?>]" id="pmuomfield<?php echo $count; ?>" rno ='<?php echo $count; ?>' value="<?php echo $value->costing_uom; ?>" class="form-control" width="5" /></td>
    <td><input type="text" readonly  name="pmucost[<?php echo $count; ?>]" id="pmucostfield<?php echo $count; ?>" rno ='<?php echo $count; ?>' class="form-control" value="<?php echo number_format($value->costing_uc, 2, '.', ''); ?>" onchange="calculateTotal(this.getAttribute('rno'))"/></td>
    <td><input readonly type="text"  name="pmlinttotal[<?php echo $count; ?>]"  rno ='<?php echo $count; ?>' id="pmlinetotalfield<?php echo $count; ?>" class="form-control" value="<?php echo number_format(number_format($value->costing_uc, 2, '.', '')*$remaining_quantity,2,'.', ''); ?>" /></td>
    <td>
        <div class="manualfield" id="pmmanualfield<?php echo $count; ?>">
            <input   name="pmmanualqty[<?php echo $count; ?>]" rno ='<?php echo $count; ?>' value="<?php if($is_auto_purchase_order == "true"){ echo $remaining_quantity; } else{ ?>0<?php } ?>" id="pmmanualqty<?php echo $count; ?>" type="text" class="form-control quantity_ordered" ty='pm' onchange="calculateTotal(this.getAttribute('rno'),this.getAttribute('ty'));calculate_order_total(<?php echo $count ?>);"/>
            <input  readonly type="hidden" rno ='<?php echo $count; ?>' value="<?php echo $remaining_quantity; ?>"  name="pmreqquantity[<?php echo $count; ?>]" class="form-control" id="pmreqquantity<?php echo $count; ?>"  >    
    
        </div>
        <div class="formulafield" id="pmformulafield<?php echo $count; ?>" style="display:none">
            <div class=""> <a class="btn btn-primary btn-small" id="pmmodel<?php echo $count; ?>" data-toggle="modal" role="button" title="_stage_<?php echo $count; ?>" href="#simpleModal" rno ='<?php echo $count?>' onclick="return modelid(this.title, this.getAttribute('rno'));">Create Formula</a>
                <h4 id="pmviewquanity<?php echo $count; ?>" class="viewquanity" ></h4>
                <input class="form-control formula" rno ='<?php echo $count; ?>' type="hidden" value="<?php echo $value->quantity_formula?>"  name="pmformula[<?php echo $count; ?>]" id="pmformula_stage_<?php echo $count; ?>" rno ='<?php echo $count?>' title="<?php echo $count; ?>" alt="<?php echo $count; ?>">
                <input class="form-control formulaqty " rno ='<?php echo $count; ?>' type="hidden" value="<?php echo $value->quantity_formula?>"  name="pmformulaqty[<?php echo $count; ?>]" id="pmformulaqty_stage_<?php echo $count; ?>" title="<?php echo $count; ?>" alt="<?php echo $count; ?>">
                <input class="form-control formulatext"  rno ='<?php echo $count; ?>' type="hidden" value="<?php echo $value->formula_text?>"  name="pmformulatext[<?php echo $count; ?>]" id="pmformulatext_stage_<?php echo $count; ?>" title="<?php echo $count; ?>" alt="<?php echo $count; ?>">
            </div>
        </div>
    </td>
    <input type="hidden" name="pmmargin[<?php echo $count; ?>]" id="pmmarginfield<?php echo $count; ?>" rno ='<?php echo $count; ?>' value="<?php echo $value->margin; ?>"  class="form-control readonlyme" readonly>
    <td><input  type="text" name="order_unit_cost[<?php echo $count; ?>]"  rno ='<?php echo $count ?>' id="order_unit_cost<?php echo $count ?>" class="form-control unit_cost" value="<?php echo number_format($value->costing_uc, 2, '.', ''); ?>" rowno="<?php echo $count ?>" onchange="calculate_order_total(<?php echo $count ?>);"/></td>

    <td><input readonly type="text" name="total_order[<?php echo $count; ?>]"  rno ='<?php echo $count ?>' id="total_order<?php echo $count ?>" class="form-control total_order total_order_cost" value="0.00"/></td>
</tr>


<?php $count ++;
}
}
}else{
    ?>
<tr id="nopartadded"><td colspan="11">  No Part Added Yet </td> </tr>
    <?php
}

 ?>