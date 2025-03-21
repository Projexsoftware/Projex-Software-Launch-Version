<tr class="pb<?php echo $count;?>" tr_val="<?php echo $count;?>">
    <input type="hidden" id="component_type<?php echo $count;?>" name="component_type[<?php echo $count;?>]" value="0"/>
                                      <td>
                                        <select data-container="body" class="selectpicker"  name="component_category[<?php echo $count;?>]" data-style="select-with-transition" data-live-search="true">
                                            <option value="0">Select Category</option>
                                            <?php foreach($categories as $category){ ?>
                                            <option value="<?php echo $category['name'];?>"><?php echo $category['name'];?></option>
                                            <?php } ?>
                                        </select>
                                      </td>
                                      <td>
                                            <div class="form-group">
                                                <select name="component_id[<?php echo $count;?>]" id="componentfield<?php echo $count;?>" rno ='<?php echo $count;?>' class="form-control selectComponent" onchange="return getcomponentinfo(<?php echo $count;?>);" data-container="body">
                                                </select>
                                                <input type="hidden" name="component_name[<?php echo $count;?>]" id="componentnamefield<?php echo $count;?>" value="">
                                                 <input type="hidden" name="supplier_id[<?php echo $count;?>]" id="supplierfield<?php echo $count;?>" value="">
                                            </div>
                                      </td>
                                       <td><input class="form-control customfield" type="text" name="component_uom[<?php echo $count;?>]" id="uomfield<?php echo $count;?>" value="" placeholder="Enter Unit of Measure" required="true"></td>
                                      <td> 
                                      <input class="form-control customfield" type="text" name="component_uc[<?php echo $count;?>]" id="ucostfield<?php echo $count;?>" value="0.00" onchange="return calculateTotal(<?php echo $count;?>);" placeholder="Enter Unit Cost" required="true">
                                      <input type="hidden" name="order_unit_cost[<?php echo $count;?>]" id="order_unit_cost<?php echo $count;?>" value="0.00">
                                      </td>
                                      <td> <input class="form-control customfield" type="text" name="component_margin_percentage[<?php echo $count;?>]" id="marginfield<?php echo $count;?>" value="0" placeholder="Enter Margin %" required="true" onchange="return calculateTotal(<?php echo $count;?>);"></td>
                                      <td> <input class="form-control customfield" type="text" name="component_margin[<?php echo $count;?>]" id="marginlinefield<?php echo $count;?>" value="0.00" placeholder="Enter Margin $" required="true" onchange="return calculateTotal(<?php echo $count;?>);"></td>
                                      <td> <input class="form-control customfield" type="text" name="component_sale_price[<?php echo $count;?>]" id="linetotalfield<?php echo $count;?>" value="0.00" placeholder="Enter Sale Price $" required="true"></td>
                                                              
                                      <td class="optional_column">
                                                                
                                                                <div class="fileinput text-center" data-provides="fileinput">
                                                                        <div class="thumbnail preview_component_image<?php echo $count;?>">
                                                                            <img src="<?php echo IMG;?>image_placeholder.jpg" alt="..." style="width:100px;height:100px;">
                                                                        </div>
                                                                    <input type="hidden" id="component_img<?php echo $count;?>" name="component_img[<?php echo $count;?>]" value=""/>
                                                                </div>
                                      </td>
                                      <td class="optional_column"><textarea class="form-control customfield" rows="3" name="component_des[<?php echo $count;?>]" placeholder="Enter Component Description" required="true"></textarea></td>
                                      <td class="optional_column">
                                           <input type="hidden" id="specification<?php echo $count;?>" name="specification[<?php echo $count;?>]" value="" rowno="<?php echo $count;?>">
                                          <div class="specification_container<?php echo $count;?>"></div>
                                      </td>
                                      <td class="optional_column">
                                          <input type="hidden" id="warranty<?php echo $count;?>" name="warranty[<?php echo $count;?>]" value="" rowno="<?php echo $count;?>">
                                          <div class="warranty_container<?php echo $count;?>"></div>
                                      </td>
                                      <td class="optional_column">
                                          <input type="hidden" id="maintenance<?php echo $count;?>" name="maintenance[<?php echo $count;?>]" value="" rowno="<?php echo $count;?>">
                                          <div class="maintenance_container<?php echo $count;?>"></div>
                                      </td>
                                      <td class="optional_column">
                                           <input type="hidden" id="installation<?php echo $count;?>" name="installation[<?php echo $count;?>]" value="" rowno="<?php echo $count;?>">
                                          <div class="installation_container<?php echo $count;?>"></div>
                                      </td>
                                       <td class="optional_column">
                                          <input type="hidden" id="checklist<?php echo $count;?>" name="checklist[<?php echo $count;?>]" value="" rowno="<?php echo $count;?>">
                                          <div class="checklist_container<?php echo $count;?>"></div>
                                      </td>
                                      <td>
                                        <select class="selectpicker" data-style="select-with-transition" name="component_status[<?php echo $count;?>]">
                                            <option value="1">Current</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                      </td>
                                      <td>
                                          <a  class="btn btn-danger btn-icon btn-simple remove remove_component" rowno="<?php echo $count;?>" tabletype="pocos" type="button"><i class="material-icons">delete</i></a>
                                      </td>
                                  </tr>