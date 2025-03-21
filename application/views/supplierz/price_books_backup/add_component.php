<tr class="pb<?php echo $count;?>" tr_val="<?php echo $count;?>">
    <input type="hidden" id="component_id<?php echo $count;?>" name="component_id[<?php echo $count;?>]" value="0"/>
                                      <td>
                                        <select data-container="body" class="selectpicker"  name="component_category[<?php echo $count;?>]" data-style="select-with-transition" data-live-search="true">
                                            <option value="0">Select Category</option>
                                            <?php foreach($categories as $category){ ?>
                                            <option value="<?php echo $category['name'];?>"><?php echo $category['name'];?></option>
                                            <?php } ?>
                                        </select>
                                      </td>
                                      <td><input class="form-control customfield" type="text" name="component_name[<?php echo $count;?>]" value="" placeholder="Enter Component Name" required="true"></td>
                                      <td><textarea class="form-control customfield" rows="3" name="component_des[<?php echo $count;?>]" placeholder="Enter Component Description" required="true"></textarea></td>
                                      <td><input class="form-control customfield" type="text" name="component_uom[<?php echo $count;?>]" value="" placeholder="Enter Unit of Measure" required="true"></td>
                                      <td> <input class="form-control customfield" type="text" name="component_uc[<?php echo $count;?>]" value="" placeholder="Enter Unit Cost" required="true"></td>
                                      <td>
                                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail">
                                                    <img src="<?php echo IMG;?>image_placeholder.jpg" alt="..." style="width:100px;height:100px;">
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                <div>
                                                    <span class="btn btn-warning btn-round btn-file">
                                                        <span class="fileinput-new">Select image</span>
                                                        <span class="fileinput-exists">Change</span>
                                                        <input type="file" id="component_img<?php echo $count;?>" name="component_img[]"/>
                                                    </span>
                                                    <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                                </div>
                                            </div>
                                      </td>
                                      <td class="specification_column">
                                          <a class="btn btn-success upload_specification upload_specification<?php echo $count;?>" data-toggle="modal" rowno="<?php echo $count;?>">Upload Specification</a>
                                          <input type="hidden" id="specification<?php echo $count;?>" name="specification[<?php echo $count;?>]" value="" rowno="<?php echo $count;?>">
                                          <div class="specification_container<?php echo $count;?>"></div>
                                          
                                      </td>
                                      <td class="warranty_column">
                                          <a class="btn btn-success upload_warranty upload_warranty<?php echo $count;?>" data-toggle="modal" rowno="<?php echo $count;?>">Upload Warranty</a>
                                          <input type="hidden" id="warranty<?php echo $count;?>" name="warranty[<?php echo $count;?>]" value="" rowno="<?php echo $count;?>">
                                          <div class="warranty_container<?php echo $count;?>"></div>
                                      </td>
                                      <td class="maintenance_column">
                                          <a class="btn btn-success upload_maintenance upload_maintenance<?php echo $count;?>" data-toggle="modal" rowno="<?php echo $count;?>">Upload Maintenance</a>
                                          <input type="hidden" id="maintenance<?php echo $count;?>" name="maintenance[<?php echo $count;?>]" value="" rowno="<?php echo $count;?>">
                                          <div class="maintenance_container<?php echo $count;?>"></div>
                                      </td>
                                      <td class="installation_column">
                                          <a class="btn btn-success upload_installation upload_installation<?php echo $count;?>" data-toggle="modal" rowno="<?php echo $count;?>">Upload Installation</a>
                                          <input type="hidden" id="installation<?php echo $count;?>" name="installation[<?php echo $count;?>]" value="" rowno="<?php echo $count;?>">
                                          <div class="installation_container<?php echo $count;?>"></div>
                                      </td>
                                       <td class="checklist_column">
                                          <input type="text" class="form-control checklistitem customfield" id="checklist_name<?php echo $count;?>" name="checklist_name[<?php echo $count;?>]" value="" rowno="<?php echo $count;?>" placeholder="Enter Checklist">
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
                                          <a  class="btn btn-danger btn-icon btn-simple remove" tabletype="pocos" type="button" onclick="removeRow(<?php echo $count;?>);"><i class="material-icons">delete</i></a>
                                      </td>
                                  </tr>