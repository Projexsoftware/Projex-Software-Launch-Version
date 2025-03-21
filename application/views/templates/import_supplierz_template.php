         <form id="TemplateForm" method="POST" action="<?php echo SURL ?>setup/import_template_rec">
                   <input type="hidden" id="template_id" name="template_id" value="<?php echo $template_info[0]->template_id;?>">
                   <input type="hidden" id="supplier_user_id" name="supplier_user_id" value="<?php echo $request_info['to_user_id'];?>">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">phonelink_setup</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Import Template</h4>
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <div class="col-md-2">
                                                    <label>
                                                        Template Name
                                                        <small>*</small>
                                                    </label>
                                                </div>
                                                <div class="col-md-10">
                                                    <input class="form-control" type="hidden" name="template_name" id="template_name" required="true" value="<?php echo $template_info[0]->template_name;?>"/>
                                                    <?php echo $template_info[0]->template_name;?>
                                               </div>
                                           </div>
					                    </div>
					                    <div class="form-group row">
                                            <div class="col-md-12">
                                                <div class="col-md-2">
                                                    <label>
                                                        Template Description
                                                        <small>*</small>
                                                    </label>
                                                </div>
                                                <div class="col-md-10">
                                                    <input class="form-control" type="hidden" name="template_desc" id="template_desc" required="true" value="<?php echo $template_info[0]->template_desc;?>"/>
                                                    <?php echo $template_info[0]->template_desc;?>
                                               </div>
                                           </div>
					                    </div>
					                     <div class="form-group row">
                                            <div class="col-md-12">
                                                <div class="col-md-2">
                                                    <label>
                                                        Template Status
                                                        <small>*</small>
                                                    </label>
                                                </div>
                                                <div class="col-md-10">
                                                    <input class="form-control" type="hidden" name="template_status" id="template_status" required="true" value="<?php echo $template_info[0]->template_status;?>"/>
                                                <?php if( $template_info[0]->template_status==1){ ?> <span class="label label-success">Current</span> <?php } ?>
                                                <?php if( $template_info[0]->template_status==0){ ?> <span class="label label-danger">Inactive</span> <?php } ?>
                                               </div>
                                           </div>
					                    </div>
                                        <div class="loader">
                                            <center>
                                                <img class="loading-image" src="<?php echo IMG;?>search.gif" alt="loading.." width="100px">
                                            </center>
                                        </div>
                                        <div class="form-group label-floating">
                                            
                                           <div class="table-responsive">
                                                 <table id="partstable" class="table sortable_table templates_table">
                                                   <thead>
                                                       <th>Stage</th>
                                                       <th>Part</th>
                                                       <th>Component</th>
                                                       <th>Unit Of Measure</th>
                                                       <th>Unit Cost</th>
                                                       <th>Supplier</th>
                                                       <th>QTY Type</th>
                                                       <th>Quantity</th>
                                                       <th>Action</th>
                                                   </thead>
                                                   <tbody>
                                                        <?php $count = 0; 
                                                        foreach ($tparts AS $key => $val) { ?>
                                                        <tr id="trnumber<?php echo $count?>" tr_val="<?php echo $count ?>">
                                                           <td>
                                                               <input class="form-control uom-form-control" type="hidden" name="stage_id[<?php echo $count?>]" id="stage_id<?php echo $count?>" required="true" value="<?php echo $val->stage_id;?>"/>
                                                               <?php echo $val->stage_name;?>
                                                           </td>
                                                           <td>
                                                               <?php echo $val->tpl_part_name;?>
                                                               <input class="form-control part-form-control" type="hidden" name="part_name[<?php echo $count?>]" id="partfield<?php echo $count?>" required="true" value="<?php echo $val->tpl_part_name;?>"/>
                                                               <input type="hidden" id="tpl_part_id<?php echo $count?>" name="tpl_part_id[<?php echo $count?>]" value="<?php echo $val->tpl_part_id;?>">
                                                           </td>
                                                           <td>
                                                               <?php
                                                               $component_info = get_component_info( $val->component_id);
                                                               ?>
                                                               <input class="form-control uom-form-control" type="hidden" name="component_id[<?php echo $count?>]" id="component_id<?php echo $count?>" required="true" value="<?php echo $val->component_id;?>"/>
                                                               <?php echo $val->component_name;?>
                                                           </td>
                                                           <td>
                                                               <?php echo $val->tpl_part_component_uom;?>
                                                               <input class="form-control uom-form-control" type="hidden" name="component_uom[<?php echo $count?>]" id="uomfield<?php echo $count?>" required="true" value="<?php echo $val->tpl_part_component_uom;?>"/>
                                                           </td>
                                                           <td>
                                                               <?php echo $val->tpl_part_component_uc;?>
                                                               <input rno="<?php echo $count;?>" class="form-control uc-form-control" type="hidden" name="component_uc[<?php echo $count?>]" id="ucostfield<?php echo $count?>" required="true" value="<?php echo $val->tpl_part_component_uc;?>"/>
                                                           </td>
                                                           <td>
                                                               <?php 
                                                               if($val->tpl_part_supplier_id == 0){
                                                                   echo get_user_company_info($request_info['to_user_id']);
                                                               }
                                                               else{
                                                               echo $val->supplier_name;
                                                               }
                                                               ?>
                                                                <input type="hidden" class="form-control" name="supplier_name[<?php echo $count; ?>]" id="supplierfieldname<?php echo $count ?>" rno ='<?php echo $count ?>' value="<?php echo $val->supplier_name;?>" readonly required="true">
                                                                <input type="hidden" class="form-control" name="supplier_id[]" id="supplierfield<?php echo $count ?>" rno ='<?php echo $count ?>' value="<?php echo $val->tpl_part_supplier_id;?>" readonly>
                                                        
                                                           </td>
                                                           <td>
                                                               <input type="hidden" class="form-control" name="quantity_type[<?php echo $count?>]" id="quantity_type<?php echo $count ?>" rno ='<?php echo $count ?>' value="<?php echo $val->tpl_quantity_type;?>" readonly>
                                                                <?php if ($val->tpl_quantity_type == "manual") { ?> Manual <?php } ?>
                                                                <?php if ($val->tpl_quantity_type == "formula") { ?> Formula <?php } ?>
                                                           </td>
                                                           <td>
                                                               <?php echo $val->tpl_quantity;?>
                                                               <input class="form-control" type="hidden" name="manualqty[<?php echo $count?>]" id="manualqty<?php echo $count?>" required="true" value="<?php echo $val->tpl_quantity;?>"/>
                                                           </td>
                                                           <td class="text-right">
                                                                <a id="model<?php echo $count?>" role="button" rno="<?php echo $count?>" title="_stage_<?php echo $count?>" href="javascript:void(0)" class="btn btn-simple btn-warning btn-icon formula_btn<?php echo $count?> <?php if ($val->tpl_quantity_type == "manual") { ?>disabled<?php } ?>"><i class="material-icons calculatedFormula<?php echo $count?>" <?php if (strtolower($val->tpl_quantity_type) == "formula" && $val->quantity_formula_text) { ?> data-container="body" data-toggle="tooltip" title="<?php echo str_replace('Formula : ', '', $val->quantity_formula_text);?>"

                                                <?php } ?>>functions</i></a>
                                                               <input class="form-control formula" rno ='<?php echo $count?>' type="hidden" value="<?php echo $val->tpl_quantity_formula; ?>" name="formula[]" id="formula_stage_<?php echo $count?>" title="<?php echo $count?>" alt="<?php echo $count?>">
                                                               <input class="form-control formulaqty "  rno ='<?php echo $count?>' type="hidden" value="<?php echo $val->tpl_quantity_formula; ?>" name="formulaqty[]" id="formulaqty_stage_<?php echo $count?>" title="<?php echo $count?>" alt="<?php echo $count?>">
                                                               <input class="form-control formulatext"  rno ='<?php echo $count?>' type="hidden" value="<?php echo $val->quantity_formula_text;?>" name="formulatext[]" id="formulatext_stage_<?php echo $count?>" title="<?php echo $count?>" alt="<?php echo $count?>">
                                                               <input class="form-control"  rno ='<?php echo $count; ?>' type="hidden" value="<?php echo $val->is_rounded;?>" name="is_rounded[]" id="is_rounded_stage_<?php echo $count; ?>" title="<?php echo $count; ?>" alt="<?php echo $count; ?>">
                                                               <!--<a rno="<?php echo $count?>" class="btn btn-simple btn-danger btn-icon deleterow"><i class="material-icons">delete</i></a>-->
                                                               <input rno ='<?php echo $count ?>' type="hidden" name="takeoffdata_id[<?php echo $count?>]" id="takeoffdata_id<?php echo $count ?>" value="0">
                                                   
                                                           </td>
                                                        </tr>
                                                        <?php 
                                                        $count++;
                                                        } ?>
                                                    </tbody>
                                                   </table>
                                                 </div>
                                        </div>
                                        
                                    </div>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-content">
                                     <div class="form-footer">
                                         <div class="pull-left">
                                            <button type="submit" class="btn btn-warning btn-fill">Import Template</button>
                                           
                                         </div>
                                         <div class="pull-right">
                                            <a href="<?php echo SURL;?>setup/request_a_template" class="btn btn-default btn-fill">Close</a>
                                      </div>
                                     </div>
                                 </div>
                            </div>
                        </div>
                    </div>
                </form>
                