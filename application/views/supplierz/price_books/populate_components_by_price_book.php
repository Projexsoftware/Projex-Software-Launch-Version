<?php $count = $last_row + 1; 
 if(count($components)>0){
    foreach($components as $component){
        $document_info = get_document_info($component['id']);
        $checklists = get_checklist_items($component['id']);
?>
<tr class="pb<?php echo $count;?>" tr_val="<?php echo $count;?>">
     <input type="hidden" name="price_book_component_id[<?php echo $count;?>]" value="<?php echo $component['id'];?>">
    <input type="hidden" name="component_type[<?php echo $count;?>]" value="1">
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
                                      <td>
                                            <div class="form-group">
                                                <select name="component_id[<?php echo $count;?>]" id="componentfield<?php echo $count;?>" rno ='<?php echo $count;?>' class="form-control selectComponent" onchange="return getcomponentinfo(<?php echo $count;?>);" data-container="body">
                                                  <option value="<?php echo $component["component_id"];?>" selected><?php echo $component["component_name"];?></option>
                                                </select>
                                                 <input type="hidden" name="component_name[<?php echo $count;?>]" id="componentnamefield<?php echo $count;?>" value="<?php echo $component["component_name"];?>">
                                                 <input type="hidden" name="supplier_id[<?php echo $count;?>]" id="supplierfield<?php echo $count;?>" value="<?php echo $component["supplier_id"];?>">
                                            </div>
                                      </td>
                                       <td><input class="form-control customfield" type="text" name="component_uom[<?php echo $count;?>]" data-validate="required" value="<?php echo $component['component_uom'];?>" placeholder="Enter Unit of Measure"></td>
                                      <td> <input class="form-control customfield" type="text" name="component_uc[<?php echo $count;?>]" data-validate="required" value="<?php echo $component['component_uc'];?>" placeholder="Enter Unit Cost" onchange="return calculateTotal(<?php echo $count;?>);">
                                      <input type="hidden" name="order_unit_cost[<?php echo $count;?>]" id="order_unit_cost<?php echo $count;?>" value="<?php echo $component['component_uc'];?>">
                                      </td>
                                       <td> <input class="form-control customfield" type="text" name="component_margin_percentage[<?php echo $count;?>]" id="marginfield<?php echo $count;?>" value="<?php echo $component['component_margin'];?>" placeholder="Enter Margin %" required="true" onchange="return calculateTotal(<?php echo $count;?>);"></td>
                                      <td> <input class="form-control customfield" type="text" name="component_margin[<?php echo $count;?>]" id="marginlinefield<?php echo $count;?>" value="<?php echo $component['component_marginline'];?>" placeholder="Enter Margin $" required="true" onchange="return calculateTotal(<?php echo $count;?>);"></td>
                                      <td> <input class="form-control customfield" type="text" name="component_sale_price[<?php echo $count;?>]" id="linetotalfield<?php echo $count;?>" value="<?php echo $component['component_sale_price'];?>" placeholder="Enter Sale Price $" required="true"></td>
                                      <td class="optional_column">
                                       <div class="fileinput fileinput-exists text-center" data-provides="fileinput">
                                                <div class="thumbnail preview_component_image<?php echo $count;?>">
                                                     <?php if($component['image']!=""){?><img src="<?php echo SURL."assets/price_books/".$component['image'];?>" alt="..." style="height:100px;"><?php } else{ ?>
                                                    <img src="<?php echo IMG;?>image_placeholder.jpg" alt="..." style="height:100px;">
                                                    <?php } ?>
                                                </div>
                                                <input type="hidden" id="component_img<?php echo $count;?>" name="component_img[<?php echo $count;?>]" value="<?php echo $component['image'];?>"/>
                                            </div>
                                      </td>
                                       <td class="optional_column"><textarea class="form-control customfield" rows="3" name="component_des[<?php echo $count;?>]" data-validate="required" placeholder="Enter Component Description"><?php echo $component['component_des'];?></textarea></td>
                                    
                                      <td class="optional_column">
                                          <input type="hidden" id="specification<?php echo $count;?>" name="specification[<?php echo $count;?>]" value="<?php if($document_info['specification']!=""){ echo $document_info['specification']; } ?>" rowno="<?php echo $count;?>">
                                           <?php if($document_info['specification']!=""){ ?>
                                              <a target="_Blank" href="<?php echo base_url();?>assets/price_books/component_documents/specification/<?php echo $document_info['specification'];?>"><?php echo $document_info['specification'];?></a>
                                              <?php } ?>
                                          
                                      </td>
                                      <td class="optional_column">
                                           <input type="hidden" id="warranty<?php echo $count;?>" name="warranty[<?php echo $count;?>]" value="<?php echo $document_info['warranty'];?>" rowno="<?php echo $count;?>">
                                          <div class="warranty_container<?php echo $count;?>">
                                              <?php if($document_info['warranty']!=""){ ?>
                                              <a target="_Blank" href="<?php echo base_url();?>assets/price_books/component_documents/warranty/<?php echo $document_info['warranty'];?>"><?php echo $document_info['warranty'];?></a>
                                              <?php } ?>
                                          </div>
                                      </td>
                                     <td class="optional_column">
                                           <input type="hidden" id="maintenance<?php echo $count;?>" name="maintenance[<?php echo $count;?>]" value="<?php echo $document_info['maintenance'];?>" rowno="<?php echo $count;?>">
                                          <div class="maintenance_container<?php echo $count;?>">
                                              <?php if($document_info['maintenance']!=""){ ?>
                                              <a target="_Blank" href="<?php echo base_url();?>assets/price_books/component_documents/maintenance/<?php echo $document_info['maintenance'];?>"><?php echo $document_info['maintenance'];?></a>
                                              <?php } ?>
                                          </div>
                                      </td>
                                      <td class="optional_column">
                                           <input type="hidden" id="installation<?php echo $count;?>" name="installation[<?php echo $count;?>]" value="" rowno="<?php echo $count;?>">
                                          <div class="installation_container<?php echo $count;?>">
                                              <?php if($document_info['installation']!=""){ ?>
                                                 <a target="_Blank" href="<?php echo base_url();?>assets/price_books/component_documents/installation/<?php echo $document_info['installation'];?>"><?php echo $document_info['installation'];?></a>
                                              <?php } ?>
                                          </div>
                                      </td>
                                        <td class="optional_column">
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
                                            <option value="1" <?php if($component["component_status"]==1){ ?> selected <?php } ?>>Current</option>
                                            <option value="0" <?php if($component["component_status"]==0){ ?> selected <?php } ?>>Inactive</option>
                                        </select>
                                      </td>
                                      <td>
                                          <a  class="btn btn-icon btn-simple btn-danger remove remove_component" rowno="<?php echo $count;?>" tabletype="pocos" type="button"><i class="material-icons">delete</i></a>
                                      </td>
                                  </tr>
                                  
<?php 
     $count++;   
    } 
}
?>