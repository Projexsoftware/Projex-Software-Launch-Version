<?php $count = $last_row; ?>
<tr id="trnumber<?php echo $count?>" tr_val="<?php echo $count ?>">
    <input  name="costing_tpe_id[]" rno ='<?php echo $count ?>' id="costing_tpe_id<?php echo $count ?>" type="hidden"  class="form-control" value="0" />
	<input  name="costing_part_id[]" rno ='<?php echo $count ?>' id="costing_part_id<?php echo $count ?>" type="hidden"  class="form-control" value="0" />
								
                                                            <td>
                                                               <select rno="<?php echo $count;?>" data-container="body" class="selectSupplierzStage" data-style="btn btn-warning btn-round" title="Choose Stage" data-size="7" name="stage_id[]" id="stagefield<?php echo $count?>" required="true">
                                                                    <option disabled> Choose Stage</option>
                                                                </select>
                                                           </td>
                                                           <td>
                                                               <input rno="<?php echo $count;?>" class="form-control part-form-control" type="text" name="part_name[]" id="partfield<?php echo $count?>" required="true" value=""/>
                                                           </td>
                                                           <td>
                                                               <select rno="<?php echo $count?>" data-container="body" class="selectSupplierzComponent" data-style="btn btn-warning btn-round" title="Choose Component" data-live-search="true" data-size="7" name="component_id[]" id="componentfield<?php echo $count?>" required="true" onchange="return componentval(this);">
                                                                    <option disabled> Choose Component</option>
                                                                </select>
                                                           </td>
                                                           
                                                           <td>
                                                               <?php echo $this->session->userdata("company_name");?>
                                                           </td>
                                                           <td>
                                                            <select rno="<?php echo $count;?>" data-container="body" class="selectpicker" data-style="btn btn-warning btn-round" title="Choose Quantity Type" data-size="7" qtype_number="<?php echo $count?>" name="quantity_type[]" id="quantity_type<?php echo $count?>" required="true" onchange="changeQTYType(this)">
                                                                <option value="manual" selected>Manual</option>
                                                                <option value="formula">Formula</option>
                                                            </select>
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
                                                            <td class="text-right">
                                                               <a rno="<?php echo $count?>" class="btn btn-simple btn-danger btn-icon deleterow deleterow<?php echo $count;?>"><i class="material-icons">delete</i></a>
                                                               <a id="model<?php echo $count?>" data-toggle="modal" role="button" rno="<?php echo $count?>" title="_stage_<?php echo $count?>" onclick="return modelid(this.title, this.getAttribute('rno'));"  href="" class="btn btn-simple btn-warning btn-icon formula_btn<?php echo $count?> disabled"><i class="material-icons calculatedFormula<?php echo $count?>">functions</i></a>
                                                               <input class="form-control formula" rno ='<?php echo $count?>' type="hidden" value="" name="formula[]" id="formula_stage_<?php echo $count?>" title="<?php echo $count?>" alt="<?php echo $count?>">
                                                               <input class="form-control formulaqty"  rno ='<?php echo $count?>' type="hidden" value="" name="formulaqty[]" id="formulaqty_stage_<?php echo $count?>" title="<?php echo $count?>" alt="<?php echo $count?>">
                                                               <input class="form-control formulatext"  rno ='<?php echo $count?>' type="hidden" value="" name="formulatext[]" id="formulatext_stage_<?php echo $count?>" title="<?php echo $count?>" alt="<?php echo $count?>">
                                                               <input class="form-control"  rno ='<?php echo $count; ?>' type="hidden" value="0" name="is_rounded[]" id="is_rounded_stage_<?php echo $count; ?>" title="<?php echo $count; ?>" alt="<?php echo $count; ?>">
                                                              
                                                            </td>
</tr>