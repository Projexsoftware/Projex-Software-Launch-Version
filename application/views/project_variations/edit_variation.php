          <style>
              .templates_table .form-control{
                  background-image: none;
                  border:1px solid #ccc!important;
                  padding:5px;
                  margin-top:12px;
              }
             .form-group.is-focused .templates_table .form-control{
                  background-image: none!important;
              }
              .part-form-control{
                  width:200px;
              }
              .uom-form-control, .uc-form-control{
                width:100px;
              }
              .no-padding{
                  padding:0px!important;
              }
              .btn-success{
                  margin-top: 0px;
              }
          </style> 
            
               <form id="ProjectVariationForm" method="POST" action="<?php echo SURL ?>project_variations/updateprojectvariation" onsubmit="return validateForm()">
                    <input type="hidden" id="costing_id" name="costing_id" value="<?php echo $variation_detail['costing_id'];?>">
                    <input type="hidden" id="variation_id" name="variation_id" value="<?php echo $variation_detail['id'];?>">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">trending_down</i>
                                    </div>
                                    <div class="card-content">
                                        <?php
                                        if ($variation_detail['status'] == "PENDING") { ?>
                                            <h4 class="card-title">Update & Edit Variation</h4>
                                        <?php } else { ?>
                                            <h4 class="card-title">View Variation</h4>
                                       <?php }
                                        ?>
                                        <?php
										if ($this->session->flashdata('err_message')) {
											?>
											<div class="alert alert-danger">
												<?php echo $this->session->flashdata('err_message'); ?>
											</div>
											<?php
										}

										if ($this->session->flashdata('ok_message')) {
											?>
											<div class="alert alert-success alert-dismissable">
												<?php echo $this->session->flashdata('ok_message'); ?>
											</div>
											<?php
										}
										?>
										<?php if ($variation_detail['var_type']== 'purord') {
                                        ?>
                                           <div class="alert alert-info">
                                                <i class="material-icons" style="color:#fff;vertical-align: middle;">info</i> This variation is from Create purchase order page, you should care about sending the variation to client yourself
                                
                                            </div>
                                        <?php }
                                        if ($variation_detail['var_type']== 'suppinvo') {
                                            ?>
                                
                                            <div class="alert alert-info">
                                                <i class="material-icons" style="color:#fff;vertical-align: middle;">info</i> This variation is from Create Supplier invoice page, you should care about sending the variation to client yourself
                                
                                            </div>
                                        <?php } ?>
                                        
				                    	<div class="form-group label-floating col-md-12">
				                    	    <div class="col-md-3"><b>Project:</b></div>
                                            <div class="col-md-9">
                                                <input class="form-control readonlyme" type="hidden" id="project_id" name="project_id" value="<?php echo $variation_detail['project_id']; ?>" readonly >
                                                <?php echo get_project_name($variation_detail['project_id']);?>
                                            </div>
                                        </div>
                                        <div class="form-group label-floating col-md-12">
				                    	    <div class="col-md-3"><b>Created By:</b></div>
                                            <div class="col-md-9"><?php echo get_user_name($variation_detail['created_by']);?></div>
                                        </div>
                                        <div class="form-group label-floating col-md-12">
				                    	    <div class="col-md-3"><b>Created At:</b></div>
                                            <div class="col-md-9"><?php echo date('d/m/Y h:i A',strtotime($variation_detail["created_date"])); ?></div>
                                        </div>
                                        <div class="form-group label-floating col-md-12">
				                    	    <div class="col-md-3"><b>Variation Number:</b></div>
                                            <div class="col-md-9">
                                                <input type="hidden"name="var_number" id="var_number" value="<?php echo $variation_detail['var_number'];?>">
                                                <?php echo $variation_detail['var_number'];?>
                                            </div>
                                        </div>
                                        <div class="form-group label-floating col-md-12">
				                    	    <div class="col-md-3"><b>Initiated Variation:</b></div>
                                            <div class="col-md-9"><input class="form-control" type="text" name="variname" id="variname" value="<?php echo $variation_detail['variation_name'];?>" placeholder="Enter Initiated Variation *" required="true" uniqueEditVariation="true">
                                                <?php echo form_error('variname', '<div class="custom_error">', '</div>'); ?></div>
                                        </div>
                                        <div class="form-group label-floating col-md-12">
                                            <div class="col-md-3"><b>Variation Description:</b></div>
                							<div class="col-md-9">
                							    <textarea class="form-control" type="text" name="varidescription" id="varidescription" placeholder="Variation Description *" required="true" onblur="update_variation('varidescription');"><?php echo $variation_detail['variation_description'];?></textarea>
                                                <?php echo form_error('varidescription', '<div class="custom_error">', '</div>'); ?>
                                            </div>
                                        </div>
                                        
                                        <div class="loader">
                                            <center>
                                                <img class="loading-image" src="<?php echo IMG;?>search.gif" alt="loading.." width="100px">
                                            </center>
                                        </div>
                                        <div class="form-group label-floating col-md-12">
                                            <?php if ($variation_detail['status'] == "PENDING") { 
                                        if(in_array(8, $this->session->userdata("permissions"))) { 
                                        ?>
                                        <div class="form-footer text-right">
                                            <button type="button" class="btn btn-warning btn-fill" value="0" onclick="addMore(this.value);"><i class="material-icons">add</i> Add New Items</button>
                                            <button type="button" class="btn btn-danger btn-fill removeallbtn"><i class="material-icons">delete</i> Remove All</button>
                                            <a id="repopulateButton" class="btn btn-primary btn-fill" role="button"  href="javascript:void(0)" onclick="repopulate_all_available_components();"><i class="material-icons">refresh</i> Repopulate All Available Components</a>
                                            <?php if(in_array(69, $this->session->userdata("permissions"))) {?>
                                            <button id="addcomponentbtn" class="btn btn-info btn-fill" type="button" data-toggle="modal" href="#addNewComponentModal"><i class="material-icons">add</i> Add Component</button>
                                            <?php } ?>
                                        </div>
                                        <?php } } ?>
                                           <div class="table-responsive">
                                                 <table id="partstable" class="table sortable_table templates_table">
                                                   <thead>
                                                       <tr>
    
                                                        <th>Stage</th>
                            
                                                        <th>Part</th>
                            
                                                        <th>Component</th>
                            
                                                        <th>Supplier</th>
                            
                                                        <th>Uninvoiced Quantity</th>
                                                        
                                                        <th>Uninvoiced Budget</th>
                            
                                                        <th>Change Quantity</th>
                            
                                                        <th>Updated Quantity</th>
                            
                                                        <th>Unit Of Measure</th>
                            
                                                        <th>Unit Cost</th>
                            
                                                        <th>Additional cost</th>
                            
                                                        <th>Status</th>
                            
                                                        <th>Include in specifications</th>
                            
                                                        <th>Client Allowance</th>
                            
                                                        <th>Action</th>
                            
                                                    </tr>
                                                   </thead>
                                                   <tbody>
                                                       <?php 
                                                    $count = 0;
                                                    foreach ($variation_parts As $key => $val) { 
                                                  $costing_quantity = get_costing_quantity($val['costing_part_id']);
                                                  $supplier_ordered_quantity = get_supplier_ordered_quantity($val['costing_part_id']);
                                                  $recent_quantity = get_recent_variation_quantity($val['costing_part_id'], $val['supplier_id']);
                                                  
                                                    $recent_total = 0;
                                                    foreach($recent_quantity as $val1){
                                                        $recent_total += $val1['total'];
                                                    }
                                                    $updated_total = 0;
                                                    foreach($recent_quantity as $val2){
                                                        $updated_total = $val2['updated_quantity'];
                                                    }
                                                  
                                                  $costing_type = get_costing_type($val['costing_part_id']);
                                                 
                                                   if(count($recent_quantity)>0){
                                                           if($costing_type=="normal"){
                                                            $uninvoicedquantity = ($costing_quantity+$recent_total)-$supplier_ordered_quantity;
                                                           }
                                                           else{
                                                             if($updated_total>0){
                                                             $uninvoicedquantity = $updated_total-$supplier_ordered_quantity;
                                                             }
                                                             else{
                                                                 
                                                         $uninvoicedquantity = $costing_quantity - $supplier_ordered_quantity;
                                                             }
                                                           }
                                                   }
                                                   else{
                                                       
                                                         $uninvoicedquantity = $costing_quantity - $supplier_ordered_quantity;
                                                   } ?>
                                                   <tr id="trnumber<?php echo $count ?>" tr_val="<?php echo $count ?>">
                                <input  name="variation_part_id[<?php echo $count; ?>]" rno ='<?php echo $count ?>' id="variation_part_id<?php echo $count ?>" type="hidden"  class="form-control" value="<?php echo $val['id']; ?>" />
                                <input type="hidden" id="costing_part_id<?php echo $count ?>" name="costing_part_id[<?php echo $count; ?>]" value="<?= $val['costing_part_id'] ?>">
                                <input type="hidden" name="is_including_pc[<?php echo $count; ?>]" value="<?php echo $val['is_including_pc']; ?>">

                                <td>
                                    <?php echo get_stage_name($val['stage_id']);?>
                                    <input type="hidden" class="form-control" name="stage[<?php echo $count; ?>]" id="stagefield<?php echo $count ?>" rno ='<?php echo $count ?>' value="<?php echo $val['stage_id'];?>" readonly>
		
                                </td>

                                <td>
                                    <?php echo $val['part_name']; ?>
                                    <input type="hidden" name="part[<?php echo $count; ?>]" id="partfield<?php echo $count ?>" value="<?php echo $val['part_name']; ?>" rno ='<?php echo $count ?>' class="form-control" readonly/></td>
                                <td>
                                    <?php $component_info = get_component_info($val['component_id']); ?>
                                    <?php if($component_info){ echo escapeString($component_info['component_name']).' ('.escapeString($component_info['supplier_name']).'|'.$component_info['component_uc'].')'; }?>
                                    <input type="hidden" class="form-control" name="component[<?php echo $count; ?>]" id="componentfield<?php echo $count ?>" rno ='<?php echo $count ?>' value="<?php echo $val['component_id'];?>" readonly>
                                </td>
                                <td>
                                    <?php echo get_supplier_name($val['supplier_id']);?>
                                    <input type="hidden" class="form-control" name="supplier_id[<?php echo $count; ?>]" id="supplierfield<?php echo $count ?>" rno ='<?php echo $count ?>' value="<?php echo $val['supplier_id'];?>" readonly>
		
                                </td>
                                

                                <td>
                                    <?php echo number_format($uninvoicedquantity, 2, '.', ''); ?>
                                    <div class="manualfield" id="manualfield<?php echo $count ?>">
                                        <input  name="manualqty[<?php echo $count; ?>]" rno ='<?php echo $count ?>' id="manualqty<?php echo $count ?>" type="hidden" class="qty form-control readonlyme" value="<?php echo number_format($uninvoicedquantity, 2, '.', ''); ?>"   readonly="readonly"/>
                                        <input type="hidden" name="quantity_type[<?php echo $count; ?>]" value="<?php echo $val['quantity_type'];?>">
                                    </div>
                                    <div class="formulafield" id="formulafield<?php echo $count ?>" style="<?php
                                    if ($val['quantity_type'] == 'formula') {
                                        echo "display:none";
                                    } else {
                                        echo "display:none";
                                    }
                                    ?>">
                                        <div class=""> <a class="btn btn-primary btn-small" id="model<?php echo $count ?>" data-toggle="modal" role="button" title="_stage_<?php echo $count ?>" href="#simpleModal" rno= '<?php echo $count ?>' onclick="return modelid(this.title, this.getAttribute('rno'));">Create Formula</a>
                                            <h4 id="viewquanity<?php echo $count ?>" class="viewquanity" ></h4>
                                            <input class="form-control formula" rno ='<?php echo $count ?>' type="hidden" value="<?php echo $val['formulaqty']; ?>" name="formula[<?php echo $count; ?>]" id="formula_stage_<?php echo $count ?>" title="<?php echo $count ?>" alt="<?php echo $count ?>">
                                            <input class="form-control formulaqty <?php
                                            if ($val['quantity_type'] == "formula") {
                                                echo "formulaqtty";
                                            }
                                            ?> "  rno ='<?php echo $count ?>' type="hidden" value="<?php echo $val['formulaqty']; ?>" name="formulaqty[<?php echo $count; ?>]" id="formulaqty_stage_<?php echo $count ?>" title="<?php echo $count ?>" alt="<?php echo $count ?>">
                                            <input class="form-control formulatext"  rno ='<?php echo $count ?>' type="hidden" value="<?php echo $val['formulatext']; ?>" name="formulatext[<?php echo $count; ?>]" id="formulatext_stage_<?php echo $count ?>" title="<?php echo $count ?>" alt="<?php echo $count ?>">
                                        </div>
                                    </div>

                                </td>
                                <td><?php //echo number_format((($uninvoicedquantity)*$val['component_uc'])*((100+$val['margin'])/100), 2, ".", ""); 
                                    echo number_format($val['margin_line'], 2, ".", "");
                                ?></td>
                                <td>
                                    <div class="manualfield" id="manualfield<?php echo $count ?>">
                                        <input  name="changeQty[<?php echo $count; ?>]" rno ='<?php echo $count ?>' id="changeqty<?php echo $count ?>" type="text" class="form-control changeQty" value="<?php echo $val['change_quantity'];//number_format($val['change_quantity'], 2, '.', ''); ?>" onchange="calculateUpdatedTotal(this.getAttribute('rno'))"  />
                                    </div>

                                </td>


                                <td>
                                    <div class="manualfield" id="manualfield<?php echo $count ?>">
                                        <input  name="updatedQty[<?php echo $count; ?>]" rno ='<?php echo $count ?>' id="updatedqty<?php echo $count ?>" type="text" class="form-control upq readonlyme" value="<?php echo $val['updated_quantity'];//number_format($val['updated_quantity'], 2, '.', ''); ?>" onchange="calculateTotal(this.getAttribute('rno'))" readonly />
                                    </div>

                                </td>

                                <td><input type="text" name="uom[<?php echo $count; ?>]" id="uomfield<?php echo $count ?>" rno ='<?php echo $count ?>' value="<?php echo $val['component_uom']; ?>" class="form-control" width="5" /></td>
                                <td><input type="text" name="ucost[<?php echo $count; ?>]" id="ucostfield<?php echo $count ?>" rno ='<?php echo $count ?>' class="form-control" value="<?php echo number_format($val['component_uc'], 2, '.', ''); ?>" onchange="calculateTotal(this.getAttribute('rno'))"/></td>
                                <td><!-- additional cost-->

                                    <input type="text" name="additionalcost[<?php echo $count; ?>]"  rno ='<?php echo $count; ?>' id="additionalcost<?php echo $count; ?>" class="form-control additionalcost" value="<?php echo number_format($val['useradditionalcost']==0?$val['component_variation_amount']:$val['useradditionalcost'], 2, '.', ''); ?>" />
                                    <input type="hidden" name="useradditionalcost[<?php echo $count; ?>]"  rno ='<?php echo $count; ?>' id="useradditionalcost<?php echo $count; ?>" class="form-control useradditionalcost" value="<?php echo number_format($val['useradditionalcost']==0?$val['component_variation_amount']:$val['useradditionalcost'], 2, '.', ''); ?>"> 

                                   <input type="hidden" name="linetotal[<?php echo $count; ?>]"  rno ='<?php echo $count ?>' id="linetotalfield<?php echo $count ?>" class="form-control" value="<?php echo $val['linetotal']; ?>" />

                                   <input type="hidden" name="margin[<?php echo $count; ?>]" id="marginfield<?php echo $count ?>" value="<?php echo $val['margin'] ?>" rno ='<?php echo $count ?>' onchange="calculateTotal('<?php echo $count ?>')" class="form-control">
                                   <input type="hidden" name="marginaddcost_line[<?php echo $count; ?>]"  rno ='<?php echo $count ?>' id="marginaddcost_line<?php echo $count ?>" class="form-control" value="<?php echo $val['marginaddcost_line']; ?>"/>
                                   <input type="hidden" name="margin_line[<?php echo $count; ?>]"  rno ='<?php echo $count ?>' id="margin_linefield<?php echo $count ?>" class="form-control" value="<?php echo $val['margin_line']; ?>"/>
                  
                                </td>
                                
                                       <td>
                                    <select rno="<?php echo $count?>" data-container="body" class="selectpicker costestimation" data-style="btn btn-warning btn-round" title="Choose Status" data-size="7" name="status[<?php echo $count; ?>]" id="statusfield<?php echo $count?>" required="true" onChange="CheckCostEstimation();">
                                    <option <?php
                                        if ($val['type_status'] == "estimated") {
                                            echo "selected";
                                        }
                                        ?> value="estimated">Estimated</option>
                                        <option <?php
                                                if ($val['type_status'] == "price_finalized") {
                                                    echo "selected";
                                                }
                                                ?> value="price_finalized">Price Finalized</option>
                                        <option <?php
                                                if ($val['type_status'] == "allowance") {
                                                    echo "selected";
                                                }
                                                ?> value="allowance">Allowance</option>


                                    </select>
                                </td>
                                <td>
                                <div class="checkbox">
                                                                    <label>
                                   <input <?php
                                    if ($val['include_in_specification'] == 1) {
                                        echo "checked";
                                    }
                                    ?> type="checkbox" name="specification_check[<?php echo $count; ?>]" rno ='<?php echo $count ?>'  id="specificationcheck<?php echo $count ?>" onClick="changeSpecificationValue(this.id, this.getAttribute('rno'))"/>
                                    </label>
                                    </div>
                                    <input type="hidden" name="include_in_specification[<?php echo $count; ?>]" value="<?php
                                    if ($val['include_in_specification'] == 1) {
                                        echo "1";
                                    } else {
                                        echo "0";
                                    }
                                    ?> " id="include_in_specification<?php echo $count ?>">
                                </td>
                                <td><div class="checkbox">
                                                                    <label><input <?php
                                    if ($val['allowance'] == 1) {
                                        echo "checked";
                                    }
                                    ?> type="checkbox" name="allowance_check[<?php echo $count; ?>]" rno ='<?php echo $count ?>' id="allowance_check<?php echo $count ?>" onClick="changeAllowanceValue(this.id, this.getAttribute('rno'))" value="0"/>
                                    </label>
                                    </div>
                                    <input type="hidden" name="allowance[<?php echo $count; ?>]" value="<?php
                                    if ($val['allowance'] == 1) {
                                        echo "1";
                                    } else {
                                        echo "0";
                                    }
                                    ?>" id="allowance<?php echo $count ?>">
                                </td>
                                <td>
                                    <a <?php if ($val['is_line_locked'] == 1) { ?> class="btn btn-simple btn-danger btn-icon" <?php } else{ ?> class="btn btn-simple btn-success btn-icon" <?php } ?> id="iconlock<?php echo $count;?>" rno ='<?php echo $count;?>' onclick="changeLockStatus(this.getAttribute('rno'))"><?php if ($val['is_line_locked'] == 1) { ?><i class="material-icons lock_icon_type<?php echo $count;?>">lock</i> <?php } else{ ?> <i class="material-icons lock_icon_type<?php echo $count;?>">lock_open</i> <?php } ?></a>
                                    <input type="hidden" name="is_line_locked[<?php echo $count; ?>]" id="linelock<?php echo $count;?>" value="<?php echo $val['is_line_locked'];?>">
                                    <?php if ($val['is_line_locked'] == 1) { ?>
                                            <script>  
                                            $(function () {
                                                changeLockToUnLockStatus(<?php echo $count;?>);
                                            })
                                            </script>
    						        <?php } ?>                                         
                                </td>
                            </tr>
                                <?php $count++; } ?>                   
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
                                    <table class="table">
                                      <tbody>
                                          <tr>
                                            <td>Hide from Project Sales Summary</td>
                                            <td></td>
                                            <td width="160">
                                                <div class="checkbox">
                                                   <label><input type="checkbox" id="hide_from_summary" name="hide_from_summary" value="1" <?php if($variation_detail['hide_from_sales_summary'] == 1){ echo 'checked'; } ?> onchange="update_variation('hide_from_summary');"></label>
                                                </div>
                                            </td>
                                          </tr>
                                          <tr>
                                            <td >Variation Subtotal</td>
                                            <td>$</td>
                                            <td width="160"><input class="form-control" name="total_cost" id="total_cost" value="<?php echo number_format($variation_detail['project_subtotal1'],2,'.',''); ?>"  readonly></td>
                                          </tr>
                                          <tr>
                                            <td>Overhead margin</td>
                                            <td>%</td>
                                            <td width="160"><input class="form-control cal-on-change" name="overhead_margin" id="overhead_margin" value="<?php echo $variation_detail['overhead_margin']; ?>"  ></td>
                                          </tr>
                                          <tr>
                                            <td>Profit margin</td>
                                            <td>%</td>
                                            <td width="160"><input class="form-control cal-on-change" name="profit_margin" id="profit_margin" value="<?php echo $variation_detail['profit_margin']; ?>" ></td>
                                          </tr>
                                          <tr>
                                            <td>Variation subtotal</td>
                                            <td>$</td>
                                            <td width="160"><input class="form-control" name="total_cost2" id="total_cost2" value="<?php echo $variation_detail['project_subtotal2'] ?>"  readonly ></td>
                                          </tr>
                                          <tr>
                                            <td>Tax</td>
                                            <td>%</td>
                                            <td width="160"><input class="form-control cal-on-change" name="costing_tax" id="costing_tax" value="<?php echo $variation_detail['tax']; ?>" ></td>
                                          </tr>
                                          <tr>
                                            <td >Variation subtotal</td>
                                            <td>$</td>
                                            <td  width="160"><input class="form-control" name="total_cost3" id="total_cost3" value="<?php echo $variation_detail['project_subtotal3'] ?>"  readonly></td>
                                          </tr>
                                          <tr>
                                            <td >Variation Price Rounding / Profit Adjustment</td>
                                            <td>$</td>
                                            <td width="160"><input class="form-control  roundme" name="price_rounding" id="price_rounding" value="<?php echo $variation_detail['project_price_rounding'] ?>" required ></td>
                                          </tr>
                                          <tr>
                                            <td >Variation Contract Price</td>
                                            <td>$</td>
                                            <td  width="160"><input class="form-control" name="contract_price" id="contract_price" value="<?php echo $variation_detail['project_contract_price'] ?>" required ></td>
                                          </tr>
                                          <tr>
                                    <td colspan="2">Status</td>
                                    <td  width="160">

                                        <select class="form-control" name="variationstatus" id="variationstatus"  required <?php if ( $variation_detail['status'] =="APPROVED" || $variation_detail['status']=="SALES INVOICED" || $variation_detail['status']=="PAID" ) echo 'readonlyme' ?>>

                                            <option value="">Select Status</option>

                                            <option value="PENDING" <?php if ($variation_detail['status'] =="PENDING"){ ?> selected <?php } ?> >PENDING</option>
                                            <?php if(in_array(10, $this->session->userdata("permissions"))){ ?>
                                            <option value="ISSUED" <?php if ($variation_detail['status'] =="ISSUED"){ ?> selected <?php } ?>>ISSUED</option>
                                            <?php } ?>
                                            <?php if(in_array(9, $this->session->userdata("permissions"))){ ?>
                                            <option value="APPROVED" <?php if ($variation_detail['status'] =="APPROVED"){ ?> selected <?php } ?>>APPROVED</option>
                                            <?php } ?>

                                            <option value="SALES INVOICED" <?php if ($variation_detail['status'] =="SALES INVOICED"){ ?> selected <?php } ?>>SALES INVOICED</option>

                                            <option value="PAID" <?php if ($variation_detail['status'] =="PAID"){ ?> selected <?php } ?>>PAID</option>

                                        </select>

                                    </td>

                                </tr>
                                          <tr>
                                            <td colspan="2">Lock/Unlock</td>
                                              
                                              <td  width="160"><a href="#" <?php if ($variation_detail['is_variation_locked'] == 1) {?> class="btn btn-simple btn-danger btn-icon" <?php } else{ ?> class="btn btn-simple btn-success btn-icon" <?php } ?> id="iconlockproject" onclick="LockProject()"><i class="material-icons lock_project_icon_type"><?php if ($variation_detail['is_variation_locked'] == 1) {?> lock <?php } else{ ?> lock_open <?php } ?></i></a>
                                              <input type="hidden" name="lockproject" id="lockproject" value="<?php echo $variation_detail['is_variation_locked']; ?>"></td>
                                                              <?php if ($variation_detail['is_variation_locked'] == 1) {?>
                                                                <script>  $(function () {
                                                                    LockProject();
                                                                })</script>
                                                            <?php } ?>
                                          </tr>
                                      </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-content">
                                     <div class="form-footer">
                                         
                        <div class="alert alert-info">
                            <i class="material-icons" style="color:#fff;vertical-align: middle;">info</i> Once a variation has been approved, you will not be able to change or update variation and its status. Variation components will be available to import in purchase orders and supplier invoices in same way as project costing parts

                        </div>
                        <?php if ( $variation_detail['status'] == "PENDING" ){?>
                            <div class="alert alert-info">
                                <i class="material-icons" style="color:#fff;vertical-align: middle;">info</i> If you have made changes in this variation first update the variation then take out the print.
                            </div>
                        <?php } ?>
                        <?php if ( $variation_detail['status'] != "PENDING" && $variation_detail['var_type'] != "purord" && $variation_detail['var_type'] != "suppinvo" ) { ?>

                            <div class="alert alert-info">
                                <i class="material-icons" style="color:#fff;vertical-align: middle;">info</i> You have already sent this variation detail to user
                            </div>

                        <?php } ?>
                    
                                         <div class="pull-left">
                                            <?php if ($variation_detail['status'] == "PENDING" || $variation_detail['status'] == "ISSUED"  ) { 
                                            if(in_array(8, $this->session->userdata("permissions"))) { ?>
                                            <button type="submit" class="btn btn-warning btn-fill">Update Variation</button>
                                            <?php } } ?>
                                            <a href="" style="margin-top: 10px;" class="btn btn-success btn-fill" onclick="printvariation()"  value=""> Print</a>
                                            <a style="margin-top: 10px;" target="_blank" href="<?php echo base_url('project_variations/preview/' . $variation_detail['id']);?>" class="btn btn-primary"  value=""> Open variation preview in new Tab</a>
                                            <?php
                        if ( $variation_detail['status'] == "PENDING" || $variation_detail['status']== "ISSUED" || $variation_detail['var_type'] == "purord" || $variation_detail['var_type'] == "suppinvo" )  {
                            ?>
                            <?php
      if(in_array(10, $this->session->userdata("permissions"))) {
      ?>
                            <a style="margin-top: 10px;" class="btn btn-success btn-issue-variation"  name="issue_variation" value=""> Issue Variation</a>

                        <?php } ?>
                        <?php } ?>
                                         </div>
                                         <div class="pull-right">
                                            <a href="<?php echo SURL;?>project_variations" class="btn btn-default btn-fill">Close</a>
                                      </div>
                                     </div>
                                 </div>
                            </div>
                        </div>
                        
                    <div class="col-md-12" id="printvariation" style="">
<style>
    .row2{
        margin: 0px 0px 15px 0px;
    }
    .boom-custom-img-container {
        padding-bottom: 15px;
        padding-top: 15px;
    }

    .boom-custom-img-container .cusotm-banner {
        height:100px;
        width:100%;
        background:#FC7B00;
    }

    .boom-custom-img-container img {

    }

    .boom-custom-section-1 {
        margin-top: 10px
    }

    .boom-custom-section-1 h2 {
        font-size: 20px;
    }

    .boom-custom-section-2 {
        margin-top: 20px
    }

    .boom-custom-section-2 p {
        color: #777777;
        font-size: 15px;
        text-align: right;
        padding: 6px 0;
    }

    .boom-custom-section-2 .custom-underline {
        display:inline-block;
        width:30%;
        height:auto;
        background: transparent;
        color: #6BAFBD;
        border-bottom: 2px solid #777777;
        text-align: center;
    }

    .boom-custom-section-3 {
        margin-top: 10px
    }

    .boom-custom-section-3 p {
        color: #777777;
        font-size: 16px;
        padding: 6px 0;
        margin-bottom: 10px;
    }

    .boom-custom-section-3 .custom-underline {
        display:inline-block;
        background: transparent;
        color: #6BAFBD;
        border-bottom: 2px solid #777777;
    }

    .boom-custom-section-4 {
        padding-bottom: 10px;
    }

    .boom-custom-section-4 .boom-custom-section-4-inner-1 {

    }

    .boom-custom-section-4 .boom-custom-section-4-inner-1 p {
        color: #777777;
        font-size: 15px;
        text-align: left;
        padding: 6px 0;
    }

    .boom-custom-section-4 .boom-custom-section-4-inner-2 {

    }

    .boom-custom-section-4 .boom-custom-section-4-inner-2 p {
        color: #777777;
        font-size: 15px;
        text-align: right;
        padding: 6px 0;
    }

    .boom-custom-section-5 {

    }

    .boom-custom-section-5 .boom-custom-section-5-inner-1 {

    }

    .boom-custom-section-5 .boom-custom-section-5-inner-1 p {
        color: #777777;
        font-size: 15px;
        text-align: left;
        padding: 6px 0;
    }

    .boom-custom-section-5 .boom-custom-section-5-inner-2 {

    }

    .boom-custom-section-5 .boom-custom-section-5-inner-2 p {
        color: #777777;
        font-size: 15px;
        text-align: right;
        padding: 6px 0;
    }


    .boom-custom-section-6 {

    }

    .boom-custom-section-6 p {
        color: #777777;
        font-size: 16px;
        padding: 6px 0;
    }

    .boom-custom-section-6 .custom-underline {
        background: transparent none repeat scroll 0 0;
        color: #6bafbd;
        display: inline-block;
        height: auto;
        text-align: center;
        text-decoration:underline;
    }

    .boom-custom-section-6 .custom-underline-1 {
        display:inline-block;
        width:25%;
        height:auto;
        background: transparent;
        color: #6BAFBD;
        border-bottom: 2px solid #777777;
        text-align: center;
        margin-left: 10px;
    }

    @media print {
        .form_not{
            display: none !important;
        }

        .boom-custom-img-container {
            padding-bottom: 15px;
            padding-top: 15px;
            float: left;
            width: 100%;
            font-family: 'Open Sans', sans-serif;
             color: #777777;
        }
        .boom-custom-section-1 h2 {
        font-size: 20px;
        font-family: 'Open Sans', sans-serif;
        color: #777777;
    }
        .col-md-6{width: 50%;}
        .img-responsive, .thumbnail>img, .thumbnail a>img, .carousel-inner>.item>img, .carousel-inner>.item>a>img {
        display: block;
        width: 100% \9;
        max-width: 100%;
        height: auto;
    }
    .col-md-4{
    float: right;
    width: 33.33%;
}
.boom-custom-section-1{float: left;width: 100%; margin-top: 10px;}
.text-center {
    text-align: center;
    font-size: 20px;
        font-family: 'Open Sans', sans-serif;
        color: #777777;
}
.boom-custom-section-2{float: left;width: 100%; margin-top: 20px;}
.boom-custom-section-2 p {
    color: #777777;
    font-size: 15px;
    text-align: right;
    padding: 6px 0;
    font-family: 'Open Sans', sans-serif;
}
.boom-custom-section-2 .custom-underline {
    display: inline-block;
    width: 30%;
    height: auto;
    background: transparent;
    color: #6BAFBD;
    border-bottom: 2px solid #777777;
    text-align: center;
    font-family: 'Open Sans', sans-serif;
}
.boom-custom-section-3{float: left;width: 100%; margin-top: 10px;}
.boom-custom-section-3 p {
    color: #777777;
    font-size: 16px;
    padding: 6px 0;
    margin-bottom: 10px;
    font-family: 'Open Sans', sans-serif;
}
.boom-custom-section-3 .custom-underline {
    display: inline-block;
    background: transparent;
    color: #6BAFBD;
    border-bottom: 2px solid #777777;
    font-family: 'Open Sans', sans-serif;
}
.boom-custom-section-4{float: left;width: 100%; padding-bottom: 10px;}
.table {
    width: 100%;
    max-width: 100%;
    margin-bottom: 20px;
    font-family: 'Open Sans', sans-serif;
}
.table tbody > tr {
    border: 1px solid #eee;
}
.table tbody > tr > td {
    border-color: #eee;
    font-family: 'Open Sans', sans-serif;
}

.boom-custom-section-6{float: left;width: 100%; margin-top: 30px;}
.boom-custom-section-6 p {
    color: #777777;
    font-size: 16px;
    padding: 6px 0;
    font-family: 'Open Sans', sans-serif;
}

    }

</style>
                    <div class="row col-md-12 boom-custom-img-container">

                        <div class="col-md-6" style="float:left">
                            <div class="logo img-responsive"><img style="width: 400px;" src="<?php echo SURL; ?>assets/img/homeworx_logo.png"></div>
                        </div>
                        <div class="col-md-4" style="float:right">
                            <!--<div class="logo img-responsive"><img style="width: 150px;" src="<?php echo SURL; ?>assets/img/boom_logo.png"></div>-->
                        </div>
                    </div>
                    <div class="col-md-12 boom-custom-section-1">
                        <h2 class="text-center">AUTHORISATION OF VARIATION OF THE WORK</h2>
                    </div>
                    <div class="col-md-12 boom-custom-section-2">
                        <p>
                            Varation No :
                            <span class="custom-underline"><?= $variation_detail['var_number'] ?></span>
                        </p>
                        <p>
                            Date :
                            <span class="custom-underline"><?=  (date('jS F Y',strtotime($variation_detail['created_date']) ))?></span>
                        </p>
                    </div>
                    <div class="col-md-12 boom-custom-section-3">
                        <p>
                            I, <span class="custom-underline"><?= $clientnameinfo['client_fname1'].' '.$clientnameinfo['client_surname1'].' '.$clientnameinfo['client_fname2'].' '.$clientnameinfo['client_surname2']?></span> authorise Chango Limited Trading as Homeworx to carry out the following variation and we agree
                            to pay any cost difference for the variation
                        </p>
                    </div>

                    <div class="col-md-12 row boom-custom-section-4" >

                        <table class="table">
                            <thead>
                            <tr>
                                <th>Description</th>
                                <th style="text-align: right; width: 150px ">Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><?php echo $variation_detail['variation_description']; ?></td>
                                <td align="right" style="text-align: right; width: 150px">$ <?php echo number_format($variation_detail['project_contract_price'],2,'.','') ?></td>
                            </tr>
                            <tr>
                            
                            <td  style="text-align: right">Subtotal (NZD)</td>
                            <td style="text-align: right">$ <?php echo number_format($variation_detail['project_contract_price'],2,'.','');
                            $subtotal_amount = $variation_detail['project_contract_price'];
                            ?></td>
                        </tr> 
                       <tr>
                           
                            <td style="text-align: right; border-bottom: 3px solid black">Includes GST at 15%</td>
                            <td style="text-align: right; border-bottom: 3px solid black">
                            <?php
                            $tax = ($subtotal_amount*3)/23;
                            ?>
                            $ <?=number_format($tax,2,'.','')?>
                            </td>
                        </tr>
                        <tr>
                            
                            <td  style="text-align: right">Total Payable (NZD)</td>
                            <td style="text-align: right">$ <?=number_format($subtotal_amount,2,'.','')?></td>
                        </tr> 
                            </tbody>
                        </table>

                    </div>

                    <div class="col-md-12 boom-custom-section-6" >
                        <p>Builder's Signature (or duty authorised representatives if applicable)<span class="custom-underline-1"></span> </p>
                        <p>Date :
                            <span class="custom-underline-1" style='width: 30%'></span></p>
                        <p>
                            I/We <span class="custom-underline"><?= $clientnameinfo['client_fname1'].' '.$clientnameinfo['client_surname1'].' '.$clientnameinfo['client_fname2'].' '.$clientnameinfo['client_surname2']?></span> hereby accept the above cost of the Variation.
                        </p>
                        <p>
                            Owner's Signature (or duty authorised representatives if applicable)  <span class="custom-underline-1" style='width: 20%'></span>
                        </p>
                        <p>
                            Date : <span class="custom-underline-1"></span>
                        </p>

                    </div>
                </div>
                    </div>
                </form>
                    
    <div class="modal fade" id="change_project">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Do you really want to change project, all imported data will be removed</h4>
            </div>

            <div class="modal-footer">
                <input class="btn btn-sm btn-danger" data-dismiss="modal" value="Yes" onclick="changeproject()">
                <input class="btn btn-sm btn-success" data-dismiss="modal" value="No" onclick="donotchangeproject()">

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="change_stage">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Do you really want to change stage, all imported data will be removed</h4>
            </div>

            <div class="modal-footer">
                <input class="btn btn-sm btn-danger" data-dismiss="modal" value="Yes" onclick="changestage()">
                <input class="btn btn-sm btn-success" data-dismiss="modal" value="No" onclick="donotchangestage()">

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="change_supplier">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Do you really want to change supplier, all imported data will be removed</h4>
            </div>

            <div class="modal-footer">
                <input class="btn btn-sm btn-danger" data-dismiss="modal" value="Yes" onclick="changesupplier()">
                <input class="btn btn-sm btn-success" data-dismiss="modal" value="No" onclick="donotchangesupplier()">

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="error_no_pc_for_this_project">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="alert alert-info"><strong>Info!</strong> There are no uninvoiced components for the selected project</div>'
            </div>

            <div class="modal-footer">
                 <button class="btn btn-sm btn-success" data-dismiss="modal" aria-hidden="true">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="error_no_pc_for_this_supplier">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="alert alert-info"><strong>Info!</strong> There are no uninvoiced components for the selected supplier</div>'
            </div>

            <div class="modal-footer">
                 <button class="btn btn-sm btn-success" data-dismiss="modal" aria-hidden="true">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="error_no_pc_for_this_stage">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="alert alert-info"><strong>Info!</strong> There are no uninvoiced components in this stage</div>'
            </div>

            <div class="modal-footer">
                 <button class="btn btn-sm btn-success" data-dismiss="modal" aria-hidden="true">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="extpartmodal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4>Import Part</h4>
            </div>
            <div class="modal-body">
                <div class="form-group label-floating">
                       <label for="labelforstage">Select Stage</label>
                    
                        <select class="form-control" name="extstages" id="extstages" onchange="getExistingParts(this.value)" required="true">
                            <option value="">Select Stage</option>
                            <?php foreach($stages as $stage){ ?>
                            <option value="<?php echo $stage->stage_id;?>"><?php echo $stage->stage_name;?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group label-floating">
                        <label for="labelforparts">Part</label>
                        <select class="form-control" name="extparts" id="extparts" required="true">
                            <option value="">Select Part</option>
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                <input id="modelnumber" value="1" type="hidden" name="modelnumber" />
                <input type='hidden' value='1' id='modelforrow' name='modelforrow'>
                <button class="btn btn-success btn-sm" onclick="importSelectedPart();">Import</button>
                <button class="btn btn-sm btn-danger" data-dismiss="modal" aria-hidden="true">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
                