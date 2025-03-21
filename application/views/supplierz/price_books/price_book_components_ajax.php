                             <?php 

                                 if(count($price_book_components)){
                                 $count = 1;
                                 foreach($price_book_components as $val){ 
                                 $document_info = get_document_info($val['id']);
                                 $checklists = get_checklist_items($val['id']);
                                 ?>
                             
                                  <tr class="pb<?php echo $count;?>" tr_val="<?php echo $count;?>">
                                      <input type="hidden" name="component_id[<?php echo $count;?>]" value="<?php echo $val['id'];?>">
                                      <td>
                                        <?php echo $val['component_category'];?>
                                      </td>
                                      <td><img style="width:50px!important;height:50px!important;" src="<?php if($val['image']!="") { echo PRICEBOOK_IMG.$val['image']; } else{ echo IMG.'image_placeholder.jpg'; }?>" class="img" /></td>
                                      <td>
                                        <?php echo $val['component_name'];?>  
                                      </td>
                                      <td>
                                           <?php echo $val['component_uom'];?> 
                                      </td>
                                      <td> 
                                          <?php echo $val['component_uc'];?>
                                          <input type="hidden" id="ucostfield<?php echo $count;?>" value="<?php echo $val['component_uc'];?>">
                                      </td>
                                      <td> <input class="form-control customfield" type="text" name="component_margin_percentage[<?php echo $count;?>]" id="marginfield<?php echo $count;?>" value="<?php echo $val['component_margin'];?>" placeholder="Enter Margin %" required="true" onchange="return calculateTotal(<?php echo $count;?>);"></td>
                                      <td> <input class="form-control customfield" type="text" name="component_margin[<?php echo $count;?>]" id="marginlinefield<?php echo $count;?>" value="<?php echo $val['component_marginline'];?>" placeholder="Enter Margin $" required="true" onchange="return calculateTotal(<?php echo $count;?>);"></td>
                                      <td> <input class="form-control customfield" type="text" name="component_sale_price[<?php echo $count;?>]" id="linetotalfield<?php echo $count;?>" value="<?php echo $val['component_sale_price'];?>" placeholder="Enter Sale Price $" required="true" readonly></td>
                                       
                                      <!--<td class="optional_column">
                                       <div class="fileinput fileinput-exists text-center" data-provides="fileinput">
                                                <div class="thumbnail preview_component_image<?php echo $count;?>">
                                                     <?php if($val['image']!=""){?><img src="<?php echo SURL."assets/price_books/".$val['image'];?>" alt="..." style="height:100px;"><?php } else{ ?>
                                                    <img src="<?php echo IMG;?>image_placeholder.jpg" alt="..." style="height:100px;">
                                                    <?php } ?>
                                                </div>
                                                <input type="hidden" id="component_img<?php echo $count;?>" name="component_img[<?php echo $count;?>]" value="<?php echo $val['image'];?>"/>
                                            </div>
                                      </td>-->
                                       <td class="optional_column"><textarea class="form-control customfield" rows="3" name="component_des[<?php echo $count;?>]" required="true" placeholder="Enter Component Description"><?php echo $val['component_des'];?></textarea></td>
                                     
                                      <td class="optional_column">
                                           <input type="hidden" id="specification<?php echo $count;?>" name="specification[<?php echo $count;?>]" value="<?php if(isset($document_info['specification'])){ echo $document_info['specification']; }?>" rowno="<?php echo $count;?>">
                                          <div class="specification_container<?php echo $count;?>">
                                              <?php if(isset($document_info['specification']) && $document_info['specification']!=""){ ?>
                                              <a target="_Blank" href="<?php echo base_url();?>assets/price_books/component_documents/specification/<?php echo $document_info['specification'];?>"><?php echo $document_info['specification'];?></a>
                                              <?php } ?>
                                          </div>
                                          
                                      </td>
                                      <td class="optional_column">
                                           <input type="hidden" id="warranty<?php echo $count;?>" name="warranty[<?php echo $count;?>]" value="<?php if(isset($document_info['warranty'])){ echo $document_info['warranty']; }?>" rowno="<?php echo $count;?>">
                                          <div class="warranty_container<?php echo $count;?>">
                                              <?php if(isset($document_info['warranty']) && $document_info['warranty']!=""){ ?>
                                              <a target="_Blank" href="<?php echo base_url();?>assets/price_books/component_documents/warranty/<?php echo $document_info['warranty'];?>"><?php echo $document_info['warranty'];?></a>
                                              <?php } ?>
                                          </div>
                                      </td>
                                      <td class="optional_column">
                                           <input type="hidden" id="maintenance<?php echo $count;?>" name="maintenance[<?php echo $count;?>]" value="<?php if(isset($document_info['maintenance'])){ echo $document_info['maintenance']; }?>" rowno="<?php echo $count;?>">
                                          <div class="maintenance_container<?php echo $count;?>">
                                              <?php if(isset($document_info['maintenance']) && $document_info['maintenance']!=""){ ?>
                                              <a target="_Blank" href="<?php echo base_url();?>assets/price_books/component_documents/maintenance/<?php echo $document_info['maintenance'];?>"><?php echo $document_info['maintenance'];?></a>
                                              <?php } ?>
                                          </div>
                                      </td>
                                      <td class="optional_column">
                                          <input type="hidden" id="installation<?php echo $count;?>" name="installation[<?php echo $count;?>]" value="<?php if(isset($document_info['installation'])){ echo $document_info['installation']; }?>" rowno="<?php echo $count;?>">
                                          <div class="installation_container<?php echo $count;?>">
                                              <?php if(isset($document_info['installation']) && $document_info['installation']!=""){ ?>
                                                 <a target="_Blank" href="<?php echo base_url();?>assets/price_books/component_documents/installation/<?php echo $document_info['installation'];?>"><?php echo $document_info['installation'];?></a>
                                              <?php } ?>
                                          </div>
                                      </td>
                                      <td align="center">
                                            <?php $component_info = get_component_info($val['component_id']);?>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" class="exclude_from_price_book" name="include_in_price_book[]" id="include_in_price_book<?php echo $val['component_id'];?>" <?php if($component_info!="" && $component_info['include_in_price_book']==1){?> checked <?php } ?> value="<?php echo $val['component_id'];?>">
                                                </label>
                                            </div>
                                            <input type="hidden" name="parent_component_id[]" value="<?php echo $val['component_id'];?>">
                                      </td>
                                      <td>
                                       <span class="label label-success">Current</span> 
                                      </td>
                                      <td>
                                          <a  class="btn btn-danger btn-icon btn-simple remove remove_component" rowno="<?php echo $count;?>" tabletype="pocos" type="button"><i class="material-icons">delete</i></a>
                                      </td>
                                  </tr>
                                  <?php 
                                  $count++;
                                  }}
                                  else{ ?>
                                      <tr>
                                          <td colspan="16"><span class="text-danger">No Components Found!</span></td>
                                      </tr>
                                  <?php } ?>