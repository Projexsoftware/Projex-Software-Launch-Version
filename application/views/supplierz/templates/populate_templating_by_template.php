<?php $count = $next_row; 
foreach ($tparts AS $key => $val) { ?>
<tr id="trnumber<?php echo $count?>" tr_val="<?php echo $count ?>">
    <input  name="component_type[<?php echo $count;?>]" rno ="<?php echo $count;?>" id="component_type<?php echo $count;?>" type="hidden"  class="form-control" value="0" />
   <td>
                                                                <select rno="<?php echo $count?>" data-container="body" class="selectSupplierzStage" data-style="btn btn-warning btn-round" title="Choose Stage" data-live-search="true" data-size="7" name="stage_id[<?php echo $count?>]" id="stagefield<?php echo $count?>" required="true">
                                                                    
                                                                    <option value="<?php echo $val->pricebook_stage_id;?>" selected><?php echo $val->stage_name; ?></option>
                                                                       
                                                                </select>
                                                           </td>
                                                           <td>
                                                               <input class="form-control part-form-control" type="text" name="part_name[<?php echo $count?>]" id="partfield<?php echo $count?>" required="true" uniques="true" value="<?php echo $val->tpl_part_name;?>"/>
                                                           </td>
                                                           <td>
                                                               <select rno="<?php echo $count?>" data-container="body" class="selectSupplierzComponent" data-style="btn btn-warning btn-round" title="Choose Component" data-live-search="true" data-size="7" name="component_id[<?php echo $count?>]" id="componentfield<?php echo $count?>" required="true" onchange="return componentval(this);">
                                                                    
                                                                    <option value="<?php echo $val->pricebook_component_id;?>" selected><?php echo escapeString($val->component_name).' ('.escapeString($this->session->userdata("company_name")).'|'.$val->component_uc.')'; ?></option>
                                                                       
                                                                </select>
                                                           </td>
                                                           <td>
                                                               <input class="form-control uom-form-control" type="text" name="component_uom[<?php echo $count?>]" id="uomfield<?php echo $count?>" required="true" value="<?php echo $val->tpl_part_component_uom;?>"/>
                                                           </td>
                                                           <td>
                                                               <input rno="<?php echo $count;?>" class="form-control uc-form-control" type="text" name="component_uc[<?php echo $count?>]" id="ucostfield<?php echo $count?>" required="true" value="<?php echo $val->tpl_part_component_uc;?>"/>
                                                           </td>
                                                           <td>
                                                               <?php echo $this->session->userdata("company_name");?>
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
                                                               <input class="form-control formula" rno ='<?php echo $count?>' type="hidden" value="<?php echo $val->tpl_quantity_formula; ?>" name="formula[<?php echo $count?>]" id="formula_stage_<?php echo $count?>" title="<?php echo $count?>" alt="<?php echo $count?>">
                                                               <input class="form-control formulaqty "  rno ='<?php echo $count?>' type="hidden" value="<?php echo $val->tpl_quantity_formula; ?>" name="formulaqty[<?php echo $count?>]" id="formulaqty_stage_<?php echo $count?>" title="<?php echo $count?>" alt="<?php echo $count?>">
                                                               <input class="form-control formulatext"  rno ='<?php echo $count?>' type="hidden" value="<?php echo $val->quantity_formula_text;?>" name="formulatext[<?php echo $count?>]" id="formulatext_stage_<?php echo $count?>" title="<?php echo $count?>" alt="<?php echo $count?>">
                                                               <input class="form-control"  rno ='<?php echo $count; ?>' type="hidden" value="<?php echo $val->is_rounded;?>" name="is_rounded[<?php echo $count?>]" id="is_rounded_stage_<?php echo $count; ?>" title="<?php echo $count; ?>" alt="<?php echo $count; ?>">
                                                               <a rno="<?php echo $count?>" class="btn btn-simple btn-danger btn-icon deleterow"><i class="material-icons">delete</i></a>
                                                   
                                                           </td>
</tr>
<?php 
$count++;
} ?>