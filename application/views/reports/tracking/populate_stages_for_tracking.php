<?php $count = $counter + 1; ?>
<?php
//echo "<pre>";
//print_r($prjprts); exit;
?>
<?php foreach ($prjprts As $key => $val) { 
$updated_quantity = get_recent_quantity($val->costing_part_id);

if(count($updated_quantity)>0){
       // if($updated_quantity['total']==$updated_quantity['updated_quantity'] && $updated_quantity['available_quantity']>0){
            if($updated_quantity['total']==$updated_quantity['updated_quantity']){
              $updated_quantity['total'] = 0;  
            }
            /*if($updated_quantity['available_quantity']==0){
                $costing_quantity = $updated_quantity['total'];
            }*/
            else{
                $costing_quantity = $val->costing_quantity+$updated_quantity['total'];
            }
}
else if(count($updated_quantity)==0 && $val->is_variated==1){
    $costing_quantity=0;
}
else{
   $costing_quantity = $val->costing_quantity;
}

          
?>

<tr id="trnumber<?php echo $count ?>" tr_val="<?php echo $count ?>">
    <td><input onclick="select_part()" type="checkbox" name="select[]" id="select_<?php echo $count ?>" value="1" rno ='<?php echo $count ?>' class="form-control selected_items" /><input type="hidden" name="is_selected[]" value="0"></td>
    <td>
        <input type="hidden" name="costing_part_id[]" id="costing_part_id_<?php echo $count ?>" value="<?php echo $val->costing_part_id;?>" />
        <select name="stage[]" id="stagefield<?php echo $count ?>" rno ='<?php echo $count ?>' class="form-control" onfocus="getStagesList(<?php echo $count ?>);">
            <option value="<?php echo $val->stage_id;?>" selected><?php echo $val->stage_name;?></option>
        </select>
        <input type="hidden" value="<?php echo $val->stage_id;?>" id="selectedstagefield<?php echo $count ?>">
    </td>

    <td><input type="text" name="part[]" id="partfield<?php echo $count ?>" value="<?php echo $val->costing_part_name ?>" rno ='<?php echo $count ?>' class="form-control" /></td>
    <td>
     <select name="component[]" id="componentfield<?php echo $count ?>" rno ='<?php echo $count ?>' class="form-control selectpicker1" onchange="return componentval(this);" data-live-search="true" onfocus="getComponentList(<?php echo $count ?>);">
       <option value="<?php echo $val->component_id;?>" selected><?php echo $val->component_name;?></option>
   </select>
   <input type="hidden" value="<?php echo $val->component_id;?>" id="selectedcomponentfield<?php echo $count ?>">

</td>
<td>
   <select class="form-control" name="supplier_id[]" id="supplierfield<?php echo $count ?>" rno ='<?php echo $count ?>' onfocus="getSupplierList(<?php echo $count ?>);">
    <option value="<?php echo $val->costing_supplier;?>" selected><?php echo $val->supplier_name;?></option>
</select> 
<input type="hidden" value="<?php echo $val->costing_supplier;?>" id="selectedsupplierfield<?php echo $count ?>">
</td>   
        

        <td>
            <div class="manualfield" id="manualfield<?php echo $count ?>">
                <input  name="manualqty[]" rno ='<?php echo $count ?>' id="manualqty<?php echo $count ?>" type="text" name="" class="qty form-control" value="<?php echo $costing_quantity ?>" onchange="calculateTotal(this.getAttribute('rno'))"/>
            </div>
            <div class="formulafield" id="formulafield<?php echo $count ?>" style="display:none">
                <div class=""> 
                    <h4 id="viewquanity1" class="viewquanity" ></h4>
                    <input class="form-control formula" rno ='<?php echo $count ?>' type="hidden" value="0" name="formula[]" id="formula_stage_<?php echo $count ?>" title="<?php echo $count ?>" alt="<?php echo $count ?>">
                    <input class="form-control formulaqty  <?php if ($val->quantity_type == "formula") { echo 'formulaqtty';} ?>" rno ='<?php echo $count ?>' type="hidden" value="0" name="formulaqty[]" id="formulaqty_stage_<?php echo $count ?>" title="<?php echo $count ?>" alt="<?php echo $count ?>">
                    <input class="form-control formulatext"  rno ='<?php echo $count ?>' type="hidden" value="0" name="formulatext[]" id="formulatext_stage_<?php echo $count ?>" title="<?php echo $count ?>" alt="<?php echo $count ?>">
                </div>
            </div>
        </td>

        <td><input type="text" name="uom[]" id="uomfield<?php echo $count ?>" rno ='<?php echo $count ?>' value="<?php echo $val->costing_uom; ?>" class="form-control" width="5" /></td>
        <td><input type="text" name="ucost[]" id="ucostfield<?php echo $count ?>" rno ='<?php echo $count ?>' class="form-control" value="<?php echo number_format($val->costing_uc,2,'.',''); ?>" onchange="calculateTotal(this.getAttribute('rno'))"/></td>
        <td><input type="text" name="linttotal[]"  rno ='<?php echo $count ?>' id="linetotalfield<?php echo $count ?>" class="form-control" value="<?php echo number_format((float) $costing_quantity * (float) $val->costing_uc,2,'.',''); ?>" /></td>


        <td>
            <input type="text" name="margin[]" id="marginfield<?php echo $count ?>" onchange="calculateTotal()"  rno ='<?php echo $count ?>' class='form-control' value='<?php echo number_format($val->margin,2,'.',''); ?>'>

        </td>
        <td><input type="text" name="margin_line[]"  rno ='<?php echo $count ?>' id="margin_linefield<?php echo $count ?>" class="form-control" value="<?php echo number_format(($val->margin+((float)$costing_quantity * (float) $val->costing_uc)),2,'.',''); ?>" /></td>
       
 
<td style="text-align:center;width:95px;">
    <input type="hidden" name="is_line_locked[]" id="linelock<?php echo $count ?>" value="0">
    <a  href="javascript:void(0)" rno ='<?php echo $count ?>' class='btn btn-danger btn-simple btn-icon deleterow'><i class="material-icons">delete</i></a>
    
    </td>
</tr>
<?php $count ++ ?>
<?php } ?>