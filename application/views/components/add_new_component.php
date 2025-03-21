<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">star</i>
                                    </div>
                                    <div class="card-content">
                                    <h4 class="card-title">Add Component</h4>
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
									<div class="row">
									<div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    
                                                    </label>
                                                    <select class="selectpicker" data-style="select-with-transition" title="Component Type *" data-size="7" name="component_type" id="component_type" required="true"  onchange="checkType(this.value)">
                                                        <option disabled> Add Componets By</option>
            											<option value="Import CSV">Import CSV</option>
                                                        <option value="Adding Component" selected>Adding Component</option>
                                                    </select>
    				                        	</div>
                                        </div>
                                    </div>
                                    <div class="csv_container" style="display:none;">
                                    <br>
                                    <legend>Import CSV</legend>
                                    <form id="ComponentCSVForm" method="POST" action="<?php echo SURL ?>manage/add_component_from_csv" enctype="multipart/form-data">
                                    <div class="row">
                                        
                                        <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    </label>
                                                    <select class="selectpicker" data-live-search="true" required="true" data-style="select-with-transition" title="Component Supplier *" data-size="7" name="component_supplier_id" id="component_supplier_id">
                                                        <option value=""> Select Supplier</option>
            											<?php foreach($suppliers as $supplier){ ?>
            											<option value="<?php echo $supplier['supplier_id'];?>"><?php echo $supplier["supplier_name"]; ?></option>
            											<?php } ?>
                                                    </select>
    				                        	</div>
                                        </div>
                                        <div class="col-md-12">
                                                <div class="label-floating">
                                                    <label class="control-label">
                                                    </label>
                                                   <input type="file" id="importcsv"  name="importcsv" extension="csv" required="true">
    				                        	</div>
    				                       <a href="<?php echo SURL;?>assets/csv/add_component_sample.csv" class="btn btn-default">Click to View CSV Sample</a>
    				                     
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <div class="form-footer text-right">
                                                        <button type="submit" class="btn btn-warning btn-fill component-btn">Add</button>
                                                        <a href="<?php echo SURL;?>manage/components" class="btn btn-default btn-fill">Cancel</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </form>
                                    </div>
                                    <div class="adding_component_container">
                                    <form id="ComponentForm" method="POST" action="<?php echo SURL ?>manage/add_new_component_process" enctype="multipart/form-data">
                                        <div class="row">
                                        <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    
                                                    </label>
                                                    <select class="selectpicker" data-live-search="true" data-style="select-with-transition" title="Component Category" data-size="7" name="component_category" id="component_category">
                                                        <option value=""> Select Category</option>
            											<?php foreach($categories as $category){ ?>
            											<option value="<?php echo $category['name'];?>"><?php echo $category["name"]; ?></option>
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
            											<option value="<?php echo $supplier['supplier_id'];?>"><?php echo $supplier["supplier_name"]; ?></option>
            											<?php } ?>
                                                    </select>
                                                    <?php echo form_error('supplier_id', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group label-floating">
                                             <label class="control-label">
                                                    
                                             </label>
                                             <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail">
                                                    <img src="<?php echo IMG;?>image_placeholder.jpg" alt="...">
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                <div>
                                                    <span class="btn btn-warning btn-round btn-file">
                                                        <span class="fileinput-new">Select Image</span>
                                                        <span class="fileinput-exists">Add/Change Image</span>
                                                        <input type="file" id="image" name="image" />
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
                                                    <input class="form-control" type="text" name="component_name" id="component_name" required="true" uniqueComponent="true" value="<?php echo set_value('component_name')?>"/>
                                                    <?php echo form_error('component_name', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                        </div>
                                        <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Component Description
                                                    </label>
                                                    <textarea class="form-control" name="component_des" id="component_des"><?php echo set_value('component_des')?></textarea>
                                                    <?php echo form_error('component_des', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                        </div>
                                        <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Unit of Measure
                                                    <small>*</small>
                                                    </label>
                                                    <input class="form-control" type="text" name="component_uom" id="component_uom" required="true" value="<?php echo set_value('component_uom')?>"/>
                                                    <?php echo form_error('component_uom', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                        </div>
                                        <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Unit Cost
                                                    <small>*</small>
                                                    </label>
                                                    <input class="form-control" type="text" name="component_uc" id="component_uc" required="true" value="<?php echo set_value('component_uc')?>"/>
                                                    <?php echo form_error('component_uc', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group label-floating">
            										<select class="selectpicker" data-style="select-with-transition" title="Status *" data-size="7" name="component_status" id="component_status" required="true">
                                                        <option disabled> Choose Status</option>
            											<option value="1" selected>Current</option>
            											<option value="0">Inactive</option>
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
                                                    <a class="btn btn-success upload_specification" data-target="#specificationModal" data-toggle="modal">Upload Specification</a>
                                                    <input type="hidden" id="specification" name="specification" value="">
                                                    <div class="specification_container">
                                                        
                                                    </div>
    				                        	</div>
                                        </div>
                                        <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                    Warranty
                                                    </label>
                                                    <a class="btn btn-success upload_warranty" data-target="#warrantyModal" data-toggle="modal">Upload Warranty</a>
                                                    <input type="hidden" id="warranty" name="warranty" value="">
                                                    <div class="warranty_container">
                                                        
                                                    </div>
    				                        	</div>
                                        </div>
                                        <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                   Maintenance
                                                    </label>
                                                    <a class="btn btn-success upload_maintenance" data-target="#maintenanceModal" data-toggle="modal">Upload Maintenance</a>
                                                    <input type="hidden" id="maintenance" name="maintenance" value="">
                                                    <div class="maintenance_container">
                                                        
                                                    </div>
    				                        	</div>
                                        </div>
                                        <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                   Installation
                                                    </label>
                                                    <a class="btn btn-success upload_installation" data-target="#installationModal" data-toggle="modal">Upload Installation</a>
                                                    <input type="hidden" id="installation" name="installation" value="">
                                                    <div class="installation_container">
                                                        
                                                    </div>
    				                        	</div>
                                        </div>
                                         <!--<div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        Checklist
                                                    </label>
                                                    <input type="text" class="form-control checklistitem" id="checklist_name" name="checklist_name" value=""  placeholder="Enter Checklist">
                                                    <input type="hidden" id="checklist" name="checklist" value="">
                                                    <div class="checklist_container"></div>
    				                        	</div>
                                        </div>-->
                                    </div>
                                        <div class="col-md-12">
                                            <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <div class="form-footer text-right">
                                                        <button type="submit" class="btn btn-warning btn-fill">Add</button>
                                                        <a href="<?php echo SURL;?>manage/components" class="btn btn-default btn-fill">Cancel</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                     </form>
                                     </div>
                                </div>
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

                