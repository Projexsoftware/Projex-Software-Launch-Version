<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <form id="ComponentForm" method="POST" action="<?php if($component_edit['price_book_id']==0){ echo SURL; ?>manage/edit_component_process<?php } ?>" enctype="multipart/form-data">
								<input type="hidden" id="component_id" name="component_id" value="<?php echo $component_edit['component_id'];?>">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">star</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Edit Component <?php if($component_edit['price_book_id']>0){ echo '<i style="color:#6bafbd;" class="fa fa-book"></i>';}?></h4>
                                        <div class="row">
                                            <div class="col-md-12">
                                                 <?php if($component_edit['price_book_id']>0){ ?>
                                                    <span class="text-danger"><i style="vertical-align:middle;" class="material-icons">info</i> <b>This component can only be updated by the supplier. Please contact the supplier if you wish to suggest an update?</b></span>
                                                <?php } ?>
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">
                                                        
                                                        </label>
                                                        <select class="selectpicker" data-live-search="true" data-style="select-with-transition" title="Component Category" data-size="7" name="component_category" id="component_category">
                                                            <option value=""> Select Category</option>
                											<?php foreach($categories as $category){ ?>
                											<option <?php if($component_edit['component_category']==$category['name']){ ?> selected <?php } ?> value="<?php echo $category['name'];?>"><?php echo $category["name"]; ?></option>
                											<?php } ?>
                                                        </select>
        				                        	</div>
                                            </div>
                                            <div class="col-md-12">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">
                                                        
                                                        </label>
                                                        <select class="selectpicker" data-style="select-with-transition" title="Supplier *" data-size="7" name="supplier_id" id="supplier_id" required="true">
                                                            <option disabled> Choose Supplier</option>
                											<?php foreach($suppliers as $supplier){ ?>
                											<option <?php if($component_edit['supplier_id']==$supplier['supplier_id']){ ?> selected <?php } ?> value="<?php echo $supplier['supplier_id'];?>"><?php echo $supplier["supplier_name"]; ?></option>
                											<?php } ?>
                                                        </select>
                                                        <?php echo form_error('supplier_id', '<div class="custom_error">', '</div>'); ?>
        				                        	</div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                 <label class="control-label">
                                                        
                                                 </label>
                                                 <div class="fileinput fileinput-exists text-center" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail">
                                                        <img src="<?php echo IMG;?>image_placeholder.jpg" alt="...">
                                                    </div>
                                                    <div class="fileinput-preview fileinput-exists thumbnail">
                                                        <?php if($component_edit['image']!=""){?><img src="<?php echo COMPONENT_IMG.$component_edit['image'];?>" alt="..." style="height:200px;"><?php } else{?> <img src="<?php echo IMG;?>image_placeholder.jpg" alt="..."><?php } ?>
                                                    </div>
                                                    <div>
                                                        <span class="btn btn-warning btn-round btn-file">
                                                            <span class="fileinput-new">Select Image</span>
                                                            <span class="fileinput-exists">Add/Change Image</span>
                                                            <input type="file" id="image" name="image" />
                                                            <input type="hidden" name="old_image" id="old_image" value="<?php echo $component_edit['image'];?>"/>
                                                        </span>
                                                        <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove Image</a>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">
                                                        Component Name
                                                        <small>*</small>
                                                        </label>
                                                        <input class="form-control" type="text" name="component_name" id="component_name" required="true" uniqueEditComponent="true" value="<?php echo $component_edit['component_name']?>"/>
                                                        <?php echo form_error('component_name', '<div class="custom_error">', '</div>'); ?>
        				                        	</div>
                                            </div>
                                            <div class="col-md-12">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">
                                                        Component Description
                                                        </label>
                                                        <textarea class="form-control" name="component_des" id="component_des"><?php echo $component_edit['component_des']?></textarea>
                                                        <?php echo form_error('component_des', '<div class="custom_error">', '</div>'); ?>
        				                        	</div>
                                            </div>
                                            <div class="col-md-12">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">
                                                        Unit of Measure
                                                        <small>*</small>
                                                        </label>
                                                        <input class="form-control" type="text" name="component_uom" id="component_uom" required="true" value="<?php echo $component_edit['component_uom']?>"/>
                                                        <?php echo form_error('component_uom', '<div class="custom_error">', '</div>'); ?>
        				                        	</div>
                                            </div>
                                            <div class="col-md-12">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">
                                                        Unit Cost
                                                        <small>*</small>
                                                        </label>
                                                        <input class="form-control" type="text" name="component_uc" id="component_uc" required="true" value="<?php echo $component_edit['component_uc']?>"/>
                                                        <?php echo form_error('component_uc', '<div class="custom_error">', '</div>'); ?>
        				                        	</div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group label-floating">
            										<select class="selectpicker" data-style="select-with-transition" title="Status *" data-size="7" name="component_status" id="component_status" required="true">
                                                        <option disabled> Choose Status</option>
            											<option value="1" <?php if($component_edit["component_status"]==1){ ?> selected <?php } ?>>Current</option>
            											<option value="0" <?php if($component_edit["component_status"]==0){ ?> selected <?php } ?>>Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row uploaded_document_container">
                                        <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                    Specification/Technical
                                                    </label>
                                                    <a class="btn btn-success upload_specification" data-target = "#specificationModal" data-toggle="modal" <?php if(($component_edit['specification']) && $component_edit['specification']!=""){ ?> style="display:none;" <?php } ?>>Upload Specification</a>
                                                    <input type="hidden" id="specification" name="specification" value="<?php echo $component_edit['specification'];?>">
                                                    <div class="specification_container">
                                                        <?php if(($component_edit['specification']) && $component_edit['specification']!=""){ ?>
                                                                      <a target="_Blank" href="<?php echo base_url();?>assets/component_documents/specification/<?php echo $component_edit['specification'];?>"><?php echo $component_edit['specification'];?></a><span  id="<?php echo $component_edit['component_id'];?>" class="remove_specification_file btn btn-icon btn-simple btn-sm btn-danger material-icons">close</span>
                                                        <?php } ?>
                                                    </div>
    				                        	</div>
                                        </div>
                                        <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                    Warranty
                                                    </label>
                                                    <a class="btn btn-success upload_warranty" data-target = "#warrantyModal" data-toggle="modal" <?php if(($component_edit['warranty']) && $component_edit['warranty']!=""){ ?> style="display:none;" <?php } ?>>Upload Warranty</a>
                                                    <input type="hidden" id="warranty" name="warranty" value="<?php echo $component_edit['warranty'];?>">
                                                    <div class="warranty_container">
                                                        <?php if(($component_edit['warranty']) && $component_edit['warranty']!=""){ ?>
                                                                      <a target="_Blank" href="<?php echo base_url();?>assets/component_documents/warranty/<?php echo $component_edit['warranty'];?>"><?php echo $component_edit['warranty'];?></a><span  id="<?php echo $component_edit['component_id'];?>" class="remove_warranty_file btn btn-icon btn-simple btn-sm btn-danger material-icons">close</span>
                                                        <?php } ?>
                                                    </div>
    				                        	</div>
                                        </div>
                                        <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                   Maintenance
                                                    </label>
                                                    <a class="btn btn-success upload_maintenance" data-target = "#maintenanceModal" data-toggle="modal" <?php if(($component_edit['maintenance']) && $component_edit['maintenance']!=""){ ?> style="display:none;" <?php } ?>>Upload Maintenance</a>
                                                    <input type="hidden" id="maintenance" name="maintenance" value="<?php echo $component_edit['maintenance'];?>">
                                                    <div class="maintenance_container">
                                                        <?php if(($component_edit['maintenance']) && $component_edit['maintenance']!=""){ ?>
                                                                      <a target="_Blank" href="<?php echo base_url();?>assets/component_documents/maintenance/<?php echo $component_edit['maintenance'];?>"><?php echo $component_edit['maintenance'];?></a><span  id="<?php echo $component_edit['component_id'];?>" class="remove_maintenance_file btn btn-icon btn-simple btn-sm btn-danger material-icons">close</span>
                                                        <?php } ?>
                                                    </div>
    				                        	</div>
                                        </div>
                                        <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                   Installation
                                                    </label>
                                                    <a class="btn btn-success upload_installation" data-target = "#installationModal" data-toggle="modal" <?php if(($component_edit['installation']) && $component_edit['installation']!=""){ ?> style="display:none;" <?php } ?>>Upload Installation</a>
                                                    <input type="hidden" id="installation" name="installation" value="<?php echo $component_edit['installation'];?>">
                                                    <div class="installation_container">
                                                        <?php if(($component_edit['installation']) && $component_edit['installation']!=""){ ?>
                                                                      <a target="_Blank" href="<?php echo base_url();?>assets/component_documents/installation/<?php echo $component_edit['installation'];?>"><?php echo $component_edit['installation'];?></a><span  id="<?php echo $component_edit['component_id'];?>" class="remove_installation_file btn btn-icon btn-simple btn-sm btn-danger material-icons">close</span>
                                                        <?php } ?>
                                                    </div>
    				                        	</div>
                                        </div>
                                         <!--<div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        Checklist
                                                    </label>
                                                    <input type="text" class="form-control updatechecklistitem" id="checklist_name" name="checklist_name" value=""  placeholder="Enter Checklist">
                                                    
                                                    <div class="checklist_container">
                                                  <?php 
                                                    $checklists = get_checklist_items_for_builders($component_edit['component_id']);
                                                    $existing_checklist = "";
                                                    if(count($checklists)>0){
                                                        foreach($checklists as $checklist){ 
                                                        $existing_checklist .=$checklist['checklist'].",";
                                                      ?>
                                                          <p class="no-padding" checklist="<?php echo $checklist['checklist'];?>"><?php echo $checklist['checklist'];?><span id="<?php echo $checklist['id'];?>" class="remove_updated_checklist checklist_item<?php echo $checklist['id'];?> btn btn-danger btn-icon btn-simple btn-sm material-icons">close</span></p>
                                                      <?php } 
                                                       }
                                                      ?>
                                                    </div>
                                                    <input type="hidden" id="checklist" name="checklist" value="<?php echo $existing_checklist;?>">
    				                        	</div>
                                        </div>-->
                                        
                                       
                                    </div>
                                        <div class="row">
                                            <div class="col-md-12">
            				                    <div class="form-group label-floating">
                                                    <div class="form-footer text-right">
                                                        <?php if(in_array(71, $this->session->userdata("permissions")) && $component_edit['price_book_id']==0) {?>
                                                        <button type="submit" id="update_component" name="update_component" class="btn btn-warning btn-fill component-btn">Update</button>
                                                        <?php } ?>
                                                        <a href="<?php echo SURL;?>manage/components" class="btn btn-default btn-fill">Cancel</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                        </div>
                    </div>
            </div>
<div class="modal fade" id="specificationModal" tabindex="-1" role="dialog" aria-labelledby="specificationModalLabel" aria-hidden="true" style="display: none;">
                                                <div class="modal-dialog modal-notice">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                            <h5 class="modal-title" id="specificationModalLabel">Upload Specification/Technical Document</h5>                                                        
                                                        </div>
                                                        <div class="modal-body">
                                                        <form class="upload_specification_document" method="post" enctype="multipart/form-data">
                                                            <input type="hidden" name="document_type" value="specification"> 
                                                            <div class="form-group">
                                                               <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                                    <div class="fileinput-new thumbnail">
                                                                        <img src="<?php echo IMG;?>image_placeholder.jpg" alt="..." style="width:100px;height:100px;">
                                                                    </div>
                                                                    <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                                    <div>
                                                                        <span class="btn btn-warning btn-round btn-file">
                                                                            <span class="fileinput-new">Select document</span>
                                                                            <span class="fileinput-exists">Change</span>
                                                                            <input type="file" id="specification_file" name="specification_file"/>
                                                                        </span>
                                                                        <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                                                    </div>
                                                                </div>
                                                               <p class="specification_file_error text-danger"></p>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="progress progress-line-success" id="progressFileDivSpecification">
                                                                    <div class="progress-bar progress-bar-success" id="progressFileBarSpecification">0%</div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                               <button id="btn-specification" type="submit" class="btn btn-success">Upload</button>
                                                            </div>
                                                        </form>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="modal fade" id="warrantyModal" tabindex="-1" role="dialog" aria-labelledby="warrantyModalLabel" aria-hidden="true" style="display: none;">
                                                <div class="modal-dialog modal-notice">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                            <h5 class="modal-title" id="warrantyModalLabel">Upload Warranty Document</h5>                                                        
                                                        </div>
                                                        <div class="modal-body">
                                                        <form class="upload_warranty_document" method="post" enctype="multipart/form-data">
                                                            <input type="hidden" name="document_type" value="warranty">
                                                            <div class="form-group">
                                                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                                    <div class="fileinput-new thumbnail">
                                                                        <img src="<?php echo IMG;?>image_placeholder.jpg" alt="..." style="width:100px;height:100px;">
                                                                    </div>
                                                                    <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                                    <div>
                                                                        <span class="btn btn-warning btn-round btn-file">
                                                                            <span class="fileinput-new">Select document</span>
                                                                            <span class="fileinput-exists">Change</span>
                                                                            <input type="file" id="warranty_file" name="warranty_file"/>
                                                                        </span>
                                                                        <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                                                    </div>
                                                                </div>
                                                               <p class="warranty_file_error text-danger"></p>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="progress progress-line-success" id="progressFileDivWarranty">
                                                                    <div class="progress-bar progress-bar-success" id="progressFileBarWarranty">0%</div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                               <button id="btn-warranty" type="submit" class="btn btn-success">Upload</button>
                                                            </div>
                                                        </form>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal fade" id="maintenanceModal" tabindex="-1" role="dialog" aria-labelledby="maintenanceModalLabel" aria-hidden="true" style="display: none;">
                                                <div class="modal-dialog modal-notice">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                            <h5 class="modal-title" id="maintenanceModalLabel">Upload Maintenance Document</h5>                                                        
                                                        </div>
                                                        <div class="modal-body">
                                                        <form class="upload_maintenance_document" method="post" enctype="multipart/form-data">
														    <input type="hidden" name="document_type" value="maintenance">
                                                            <div class="form-group">
                                                               <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                                    <div class="fileinput-new thumbnail">
                                                                        <img src="<?php echo IMG;?>image_placeholder.jpg" alt="..." style="width:100px;height:100px;">
                                                                    </div>
                                                                    <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                                    <div>
                                                                        <span class="btn btn-warning btn-round btn-file">
                                                                            <span class="fileinput-new">Select document</span>
                                                                            <span class="fileinput-exists">Change</span>
                                                                            <input type="file" id="maintenance_file" name="maintenance_file"/>
                                                                        </span>
                                                                        <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                                                    </div>
                                                                </div>
                                                               <p class="maintenance_file_error text-danger"></p>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="progress progress-line-success" id="progressFileDivmaintenance">
                                                                    <div class="progress-bar progress-bar-success" id="progressFileBarmaintenance">0%</div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                               <button id="btn-maintenance" type="submit" class="btn btn-success">Upload</button>
                                                            </div>
                                                        </form>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                           
                                            <div class="modal fade" id="installationModal" tabindex="-1" role="dialog" aria-labelledby="installationModalLabel" aria-hidden="true" style="display: none;">
                                                <div class="modal-dialog modal-notice">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                            <h5 class="modal-title" id="installationModalLabel">Upload Installation Document</h5>                                                        
                                                        </div>
                                                        <div class="modal-body">
                                                        <form class="upload_installation_document" method="post" enctype="multipart/form-data">
														    <input type="hidden" name="document_type" value="installation">
                                                            <div class="form-group">
                                                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                                    <div class="fileinput-new thumbnail">
                                                                        <img src="<?php echo IMG;?>image_placeholder.jpg" alt="..." style="width:100px;height:100px;">
                                                                    </div>
                                                                    <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                                    <div>
                                                                        <span class="btn btn-warning btn-round btn-file">
                                                                            <span class="fileinput-new">Select document</span>
                                                                            <span class="fileinput-exists">Change</span>
                                                                            <input type="file" id="installation_file" name="installation_file"/>
                                                                        </span>
                                                                        <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                                                    </div>
                                                                </div>
                                                               <p class="installation_file_error text-danger"></p>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="progress progress-line-success" id="progressFileDivinstallation">
                                                                    <div class="progress-bar progress-bar-success" id="progressFileBarinstallation">0%</div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                               <button id="btn-installation" type="submit" class="btn btn-success">Upload</button>
                                                            </div>
                                                        </form>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>

                
                