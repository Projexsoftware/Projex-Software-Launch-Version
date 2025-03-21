<?php $count = $last_row + 1; 
 if(count($components)>0){
    foreach($components as $component){
        $document_info = get_document_info($component['id']);
        $checklists = get_checklist_items($component['id']);
?>
<tr class="pb<?php echo $count;?>" tr_val="<?php echo $count;?>">
                                      <td>
                                        <input type="hidden" id="selected_price_book<?php echo $count;?>" name="selected_price_book[<?php echo $count;?>]" value="<?php echo $component['price_book_id'];?>"/>
                                        <input type="hidden" id="component_id<?php echo $count;?>" name="component_id[<?php echo $count;?>]" value="<?php echo $component['id'];?>"/>
                                        <select data-container="body" class="selectpicker" name="component_category[<?php echo $count;?>]" data-style="select-with-transition">
                                            <option value="0">Select Category</option>
                                            <?php foreach($categories as $category){ ?>
                                            <option <?php if($component['component_category']==$category['name']){ ?> selected <?php } ?> value="<?php echo $category['name'];?>"><?php echo $category['name'];?></option>
                                            <?php } ?>
                                        </select>
                                      </td>
                                      <td><input class="form-control customfield" type="text" data-validate="required" name="component_name[<?php echo $count;?>]" value="<?php echo $component['component_name'];?>" placeholder="Enter Component Name"></td>
                                      <td><textarea class="form-control customfield" rows="3" name="component_des[<?php echo $count;?>]" data-validate="required" placeholder="Enter Component Description"><?php echo $component['component_des'];?></textarea></td>
                                      <td><input class="form-control customfield" type="text" name="component_uom[<?php echo $count;?>]" data-validate="required" value="<?php echo $component['component_uom'];?>" placeholder="Enter Unit of Measure"></td>
                                      <td> <input class="form-control customfield" type="text" name="component_uc[<?php echo $count;?>]" data-validate="required" value="<?php echo $component['component_uc'];?>" placeholder="Enter Unit Cost"></td>
                                      <td>
                                       <div class="fileinput fileinput-exists text-center" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail">
                                                    <img src="<?php echo IMG;?>image_placeholder.jpg" alt="...">
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail">
                                                    <?php if($component['image']!=""){?><img src="<?php echo SURL."assets/price_books/".$component['image'];?>" alt="..." style="height:100px;"><?php }?>
                                                </div>
                                                <div>
                                                    <span class="btn btn-warning btn-round btn-file">
                                                        <span class="fileinput-new">Select image</span>
                                                        <span class="fileinput-exists">Change</span>
                                                        <input type="file" id="component_img<?php echo $count;?>" name="component_img<?php echo $count;?>" />
                                                        <input type="hidden" name="old_component_img[<?php echo $count;?>]" value="<?php echo $component['image'];?>">
                                                    </span>
                                                    <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                                </div>
                                            </div>
                                      </td>
                                      <td class="specification_column">
                                          <input type="hidden" id="specification<?php echo $count;?>" name="specification[<?php echo $count;?>]" value="<?php if($document_info['specification']!=""){ echo $document_info['specification']; } ?>" rowno="<?php echo $count;?>">
                                           <?php if($document_info['specification']!=""){ ?>
                                              <a target="_Blank" href="<?php echo base_url();?>assets/price_books/component_documents/specification/<?php echo $document_info['specification'];?>"><?php echo $document_info['specification'];?></a>
                                              <?php } ?>
                                          
                                      </td>
                                      <td class="warranty_column">
                                           <input type="hidden" id="warranty<?php echo $count;?>" name="warranty[<?php echo $count;?>]" value="<?php echo $document_info['warranty'];?>" rowno="<?php echo $count;?>">
                                          <div class="warranty_container<?php echo $count;?>">
                                              <?php if($document_info['warranty']!=""){ ?>
                                              <a target="_Blank" href="<?php echo base_url();?>assets/price_books/component_documents/warranty/<?php echo $document_info['warranty'];?>"><?php echo $document_info['warranty'];?></a>
                                              <?php } ?>
                                          </div>
                                      </td>
                                     <td class="maintenance_column">
                                           <input type="hidden" id="maintenance<?php echo $count;?>" name="maintenance[<?php echo $count;?>]" value="<?php echo $document_info['maintenance'];?>" rowno="<?php echo $count;?>">
                                          <div class="maintenance_container<?php echo $count;?>">
                                              <?php if($document_info['maintenance']!=""){ ?>
                                              <a target="_Blank" href="<?php echo base_url();?>assets/price_books/component_documents/maintenance/<?php echo $document_info['maintenance'];?>"><?php echo $document_info['maintenance'];?></a>
                                              <?php } ?>
                                          </div>
                                      </td>
                                      <td class="installation_column">
                                           <input type="hidden" id="installation<?php echo $count;?>" name="installation[<?php echo $count;?>]" value="" rowno="<?php echo $count;?>">
                                          <div class="installation_container<?php echo $count;?>">
                                              <?php if($document_info['installation']!=""){ ?>
                                                 <a target="_Blank" href="<?php echo base_url();?>assets/price_books/component_documents/installation/<?php echo $document_info['installation'];?>"><?php echo $document_info['installation'];?></a>
                                              <?php } ?>
                                          </div>
                                      </td>
                                        <td class="checklist_column">
                                           <div class="checklist_container<?php echo $count;?>">
                                              <?php 
                                                $existing_checklist = "";
                                                foreach($checklists as $checklist){ 
                                                $existing_checklist .=$checklist['checklist'].",";
                                              ?>
                                                  <p class="no-padding" checklist="<?php echo $checklist['checklist'];?>"><?php echo $checklist['checklist'];?><i rowno="<?php echo $count;?>" id="<?php echo $checklist['id'];?>" class="remove_checklist_item checklist_item<?php echo $checklist['id'];?> btn text-danger">&times</i></p>
                                              <?php } ?>
                                          </div>
                                          <input type="hidden" id="checklist<?php echo $count;?>" name="checklist[<?php echo $count;?>]" value="<?php echo $existing_checklist;?>" rowno="<?php echo $count;?>">
                                      </td>
                                      <td>
                                        <select class="selectpicker" name="component_status[<?php echo $count;?>]" data-style="select-with-transition">
                                            <option value="1">Current</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                      </td>
                                      <td>
                                          <a  class="btn btn-icon btn-simple btn-danger remove" tabletype="pocos" type="button" onclick="removeRow(<?php echo $count;?>);"><i class="material-icons">delete</i></a>
                                      </td>
                                  </tr>
                                  
<?php 
     $count++;   
    } 
}
?>