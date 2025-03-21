<?php $count = $next_row; 
foreach ($prjprts As $key => $val) { ?>
<tr id="trnumber<?php echo $count?>" tr_val="<?php echo $count ?>">
<input  name="component_type[<?php echo $count;?>]" rno ="<?php echo $count;?>" id="component_type<?php echo $count;?>" type="hidden"  class="form-control" value="0" />
                                                            <td>
                                                               <select data-container="body" class="selectStage" data-style="btn btn-warning btn-round" title="Choose Stage" data-size="7" name="stage_id[<?php echo $count?>]" id="stagefield<?php echo $count;?>" required="true">
                                                                    <option value="<?php echo $val->stage_id;?>" selected><?php echo $val->stage_name;?></option>
                                                                </select>
                                                           </td>
                                                           <td>
                                                               <input class="form-control part-form-control" type="text" name="part_name[<?php echo $count?>]" id="partfield<?php echo $count;?>" required="true" value="<?php echo $val->costing_part_name ?>"/>
                                                           </td>
                                                           <td>
                                                               <?php
                                                               $component_info = get_component_info( $val->component_id);
                                                               ?>
                                                               <select rno="<?php echo $count?>" data-container="body" class="selectComponent" data-style="btn btn-warning btn-round" title="Choose Component" data-live-search="true" data-size="7" name="component_id[<?php echo $count?>]" id="componentfield<?php echo $count?>" required="true" onchange="return componentval(this);">
                                                                    <option disabled> Choose Component</option>
                                                                    <option value="<?php echo $component_info['component_id'];?>" selected><?php echo escapeString($component_info['component_name']).' ('.escapeString($component_info["supplier_name"]).'|'.$component_info["component_uc"].')'; ?></option>
                                                                       
                                                                </select>
                                                               
                                                           </td>
                                                            <td>
                                                               <input rno="<?php echo $count;?>" class="form-control uom-form-control" type="text" name="component_uom[<?php echo $count?>]" id="uomfield<?php echo $count;?>" required="true" value="<?php echo $val->costing_uom; ?>"/>
                                                           </td>
                                                           <td>
                                                               <input rno="<?php echo $count;?>" class="form-control uc-form-control" type="text" name="component_uc[<?php echo $count?>]" id="ucostfield<?php echo $count;?>" required="true" value="<?php echo number_format($val->costing_uc, 2, '.', ''); ?>"/>
                                                           </td>
                                                           <td>
                                                            <input type="text" class="form-control part_name_textfield" name="supplier_name[<?php echo $count?>]" id="supplierfieldname<?php echo $count ?>" rno ='<?php echo $count ?>' value="<?php echo $val->supplier_name;?>" readonly>
                                                            <input type="hidden" class="form-control" name="supplier_id[<?php echo $count?>]" id="supplierfield<?php echo $count ?>" rno ='<?php echo $count ?>' value="<?php echo $val->costing_supplier;?>" readonly>
                                                           </td>
                                                           <td>
                                                               <select data-container="body" class="selectpicker" data-style="btn btn-warning btn-round" title="Choose Quantity Type" data-size="7" qtype_number="<?php echo $count?>" name="quantity_type[<?php echo $count?>]" id="quantity_type<?php echo $count?>" required="true" onchange="changeQTYType(this)">
                                                                    <option value="manual" <?php if ($val->quantity_type == "manual") { ?> selected <?php } ?>>Manual</option>
                                                                    <option value="formula" <?php if ($val->quantity_type == "formula") { ?> selected <?php } ?>>Formula</option>
                                                                </select>
                                                           </td>
                                                           <td>
                                                               <input rno="<?php echo $count;?>" class="form-control" type="number" name="manualqty[<?php echo $count?>]" id="manualqty<?php echo $count;?>" required="true" value="<?php echo $val->costing_quantity ?>"/>
                                                           </td>
                                                            <td class="text-right">
                                                               
                                                                <a id="model<?php echo $count?>" data-toggle="modal" role="button" rno="<?php echo $count?>" title="_stage_<?php echo $count?>" href="" onclick="return modelid(this.title, this.getAttribute('rno'));" class="btn btn-simple btn-warning btn-icon formula_btn<?php echo $count?> <?php if($val->quantity_type == "manual") {?>disabled <?php } ?>"><i class="material-icons calculatedFormula<?php echo $count?>">functions</i></a>
                                                              
                                                                <input class="form-control formula" rno ='<?php echo $count?>' type="hidden" value="<?php echo $val->quantity_formula; ?>" name="formula[<?php echo $count?>]" id="formula_stage_<?php echo $count?>" title="<?php echo $count?>" alt="<?php echo $count?>">
                                                                <input class="form-control formulaqty <?php if ($val->quantity_type == "formula") { echo "formulaqtty"; } ?>"  rno ='<?php echo $count?>' type="hidden" value="<?php echo $val->quantity_formula; ?>" name="formulaqty[<?php echo $count?>]" id="formulaqty_stage_<?php echo $count?>" title="<?php echo $count?>" alt="<?php echo $count?>">
                                                                <input class="form-control formulatext"  rno ='<?php echo $count?>' type="hidden" value="<?php echo $val->formula_text;?>" name="formulatext[<?php echo $count?>]" id="formulatext_stage_<?php echo $count?>" title="<?php echo $count?>" alt="<?php echo $count?>">
                                                                <input type="hidden" name="is_rounded[<?php echo $count?>]" value="<?php echo $val->is_rounded ?>" id="is_rounded<?php echo $count ?>">
                                                                
                                                               <a rno="<?php echo $count;?>" class="btn btn-simple btn-danger btn-icon deleterow"><i class="material-icons">delete</i></a>
                                                           
                                                            </td>
                                                        </tr>
<?php 
$count++;
} ?>