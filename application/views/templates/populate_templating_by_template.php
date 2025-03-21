<?php $count = $next_row; 
foreach ($tparts AS $key => $val) { ?>
<tr id="trnumber<?php echo $count?>" tr_val="<?php echo $count ?>">
     <input  name="component_type[<?php echo $count;?>]" rno ="<?php echo $count;?>" id="component_type<?php echo $count;?>" type="hidden"  class="form-control" value="<?php echo isset($is_supplierz_template)?2:0;?>" />
   <td>
                                                               <select data-container="body" class="selectStage" data-style="btn btn-warning btn-round" title="Choose Stage" data-size="7" name="stage_id[]" id="stagefield<?php echo $count?>" required="true">
                                                                    <option disabled> Choose Stage</option>
                                                                    <option value="<?php echo isset($is_supplierz_template)?$val->stage_name:$val->stage_id;?>" selected><?php echo $val->stage_name;?></option>
                                                                </select>
                                                           </td>
                                                           <td>
                                                               <input class="form-control part-form-control" type="text" name="part_name[<?php echo $count?>]" id="partfield<?php echo $count?>" required="true" value="<?php echo $val->tpl_part_name;?>"/>
                                                           </td>
                                                           <td>
                                                               <?php
                                                                    /*if($val->tpl_part_supplier_id==0){
                                                                        $component_info = get_supplierz_component($val->parent_component_id);
                                                                    }
                                                                    else{*/
                                                                        $component_info = get_component_info($val->pricebook_component_id); 
                                                                   // }
                                                               ?>
                                                               <select rno="<?php echo $count?>" data-container="body" class="<?php echo isset($is_supplierz_template)?'filterSupplierzComponent':'selectComponent';?>" data-style="btn btn-warning btn-round" title="Choose Component" data-live-search="true" data-size="7" name="component_id[<?php echo $count?>]" id="componentfield<?php echo $count?>" required="true" <?php if(isset($is_supplierz_template)){?>onchange="return supplierzComponentVal(this)" <?php } else{ ?>onchange="return componentVal(this)" <?php } ?>?>>
                                                                    <option disabled> Choose Component</option>
                                                                    <?php if(isset($component_info)){?>
                                                                       <option value="<?php echo isset($is_supplierz_template)?$val->parent_component_id:$component_info['component_id'];?>" selected><?php echo escapeString($component_info['component_name']).' ('.escapeString($component_info["supplier_name"]).'|'.$component_info["component_uc"].')'; ?></option>
                                                                    <?php } ?> 
                                                                </select>
                                                               
                                                           </td>
                                                           <td>
                                                               <input class="form-control uom-form-control" type="text" name="component_uom[<?php echo $count?>]" id="uomfield<?php echo $count?>" required="true" value="<?php echo $val->tpl_part_component_uom;?>"/>
                                                           </td>
                                                           <td>
                                                               <input rno="<?php echo $count;?>" class="form-control uc-form-control" type="text" name="component_uc[<?php echo $count?>]" id="ucostfield<?php echo $count?>" required="true" value="<?php echo $val->tpl_part_component_uc;?>"/>
                                                           </td>
                                                           <td>
                                                               <?php 
                                                               if(isset($is_supplierz_template)){
                                                                   $supplier_info = get_supplierz_company_info($val->company_id);
                                                                   $supplier_name = $supplier_info["com_name"]!=""?$supplier_info["com_name"]:$val->supplier_name;
                                                               }
                                                               else{
                                                                   $supplier_name = $val->supplier_name;
                                                               }
                                                               ?>
                                                               <input type="text" class="form-control" name="supplier_name[<?php echo $count; ?>]" id="supplierfieldname<?php echo $count ?>" rno ='<?php echo $count ?>' value="<?php echo $supplier_name ;?>" readonly required="true">
                                                                <input type="hidden" class="form-control" name="supplier_id[]" id="supplierfield<?php echo $count ?>" rno ='<?php echo $count ?>' value="<?php echo isset($is_supplierz_template)?$val->supplier_id:$val->tpl_part_supplier_id;?>" readonly>
                                                        
                                                           </td>
                                                           <td>
                                                               <select data-container="body" class="selectpicker" data-style="btn btn-warning btn-round" title="Choose Quantity Type" data-size="7" qtype_number="<?php echo $count?>" name="quantity_type[<?php echo $count?>]" id="quantity_type<?php echo $count?>" required="true" onchange="changeQTYType(this)">
                                                                    <option value="manual" <?php if ($val->tpl_quantity_type == "manual") { ?> selected <?php } ?>>Manual</option>
                                                                    <option value="formula" <?php if ($val->tpl_quantity_type == "formula") { ?> selected <?php } ?>>Formula</option>
                                                                </select>
                                                           </td>
                                                           <td>
                                                               <input class="form-control" type="number" name="manualqty[<?php echo $count?>]" id="manualqty<?php echo $count?>" required="true" value="<?php echo $val->tpl_quantity;?>"/>
                                                           </td>
                                                           <td class="text-right">
                                                               <a id="model<?php echo $count?>" data-toggle="modal" role="button" rno="<?php echo $count?>" title="_stage_<?php echo $count?>" onclick="return modelid(this.title, this.getAttribute('rno'));"  href="" class="btn btn-simple btn-warning btn-icon formula_btn<?php echo $count?> <?php if ($val->tpl_quantity_type == "manual") { ?> disabled <?php } ?>"><i class="material-icons calculatedFormula<?php echo $count?>" <?php if (strtolower($val->tpl_quantity_type) == "formula" && $val->quantity_formula_text) { ?> data-container="body" data-toggle="tooltip" title="<?php echo str_replace('Formula : ', '', $val->quantity_formula_text);?>"

                                                               <?php } ?>>functions</i></a>
                                                               <input class="form-control formula" rno ='<?php echo $count?>' type="hidden" value="<?php echo $val->tpl_quantity_formula; ?>" name="formula[]" id="formula_stage_<?php echo $count?>" title="<?php echo $count?>" alt="<?php echo $count?>">
                                                               <input class="form-control formulaqty "  rno ='<?php echo $count?>' type="hidden" value="<?php echo $val->tpl_quantity_formula; ?>" name="formulaqty[]" id="formulaqty_stage_<?php echo $count?>" title="<?php echo $count?>" alt="<?php echo $count?>">
                                                               <input class="form-control formulatext"  rno ='<?php echo $count?>' type="hidden" value="<?php echo $val->quantity_formula_text;?>" name="formulatext[]" id="formulatext_stage_<?php echo $count?>" title="<?php echo $count?>" alt="<?php echo $count?>">
                                                               <input class="form-control"  rno ='<?php echo $count; ?>' type="hidden" value="<?php echo $val->is_rounded;?>" name="is_rounded[]" id="is_rounded_stage_<?php echo $count; ?>" title="<?php echo $count; ?>" alt="<?php echo $count; ?>">
                                                               <a rno="<?php echo $count?>" class="btn btn-simple btn-danger btn-icon deleterow"><i class="material-icons">delete</i></a>
                                                   
                                                           </td>
</tr>
<?php 
$count++;
} ?>