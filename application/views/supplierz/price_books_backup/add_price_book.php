<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">menu_book</i>
                                    </div>
                                    <div class="card-content">
                                    <h4 class="card-title">Add Price Book</h4>
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
        
                                    <form id="PriceBookForm" method="POST" action="<?php echo SURL ?>supplierz/add_price_book_process" enctype="multipart/form-data" autocomplete="off">
                                    <div class="col-md-12">
                                        <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Price Book Name
                                                    <small>*</small>
                                                    </label>
                                                    <input class="form-control" type="text" name="name" id="name" required="true" uniquePriceBook="true" value="<?php echo set_value('name')?>"/>
                                                    <?php echo form_error('name', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                        </div>
                                        <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    
                                                    </label>
                                                    <select class="selectpicker" data-style="select-with-transition" title="Component Type *" data-size="7" name="component_type" id="component_type" required="true"  onchange="checkType(this.value)">
                                                        <option disabled> Price Book Componets By</option>
            											<option value="Import CSV" selected>Import CSV</option>
                                                        <option value="Adding Component">Adding Component</option>
                                                        <option value="Existing Price Book">Existing Price Book</option>
                                                    </select>
    				                        	</div>
                                        </div>
                                        <div id="csv_container" class="col-md-12">
                                                <div class="label-floating">
                                                    <label class="control-label">
                                                    <legend>Import CSV</legend>
                                                    </label>
                                                   <input type="file" id="importcsv"  name="importcsv" extension="csv">
    				                        	</div>
    				                        <?php if(file_exists('./assets/csv/add_price_book_sample.csv')){ ?>
    				                       <a href="<?php echo SURL;?>assets/csv/add_price_book_sample.csv" target="_Blan" class="btn btn-default">Click to View CSV Sample</a>
    				                       <?php } ?>
    				                       <hr>
                                        </div>
                                        <div class="col-md-12 existing_pricebook">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Existing Price Books <small>*</small>
                                                    </label>
                                                    <select class="selectpicker" data-style="select-with-transition" title="Select Existing Price Book" data-size="7" name="existing_price_book" id="existing_price_book" required="true">
            											<?php foreach($existing_price_books as $price_book){ ?>
                                                           <option value="<?php echo $price_book['id'];?>"><?php echo $price_book['name'];?></option>
                                                        <?php } ?>
                                                    </select>
    				                        	</div>
                                        </div>
                                    </div>
                                        <div id='newcomponentdiv'>
                   
                                            <div class="row">
                                                    <div class="col-md-12">
                                                            <div class="col-md-2">
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" id="column_specification" onchange="showcolumn('specification')" >Show Specification
                                                                    </label>
                                                                </div> 
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" id="column_warranty" onchange="showcolumn('warranty')" >Show Warranty
                                                                    </label>
                                                                </div> 
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" id="column_maintenance" onchange="showcolumn('maintenance')" >Show Maintenance
                                                                    </label>
                                                                </div> 
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" id="column_installation" onchange="showcolumn('installation')" >Show Installation
                                                                    </label>
                                                                </div> 
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" id="column_checklist" onchange="showcolumn('checklist')" >Show Checklist
                                                                    </label>
                                                                </div> 
                                                            </div>
                                                            
                                                    </div>
                                            </div>
                                            <div class="row">
                                            <div class="col-md-12">
                                                <div class="text-right"><button type="button" class="btn btn-warning btn-fill" onclick="addRow();"><i class="material-icons">add</i> Add Component</button></div>
                                            </div>
                                            </div>
                                            <div class="table-responsive" >
                    
                                                <table id="impnewitems" class="table sortable_table templates_table" >
                                                    <thead>
                                                        <tr>
                                                            <th>Component Category</th>
                                                            <th>Component Name</th>
                                                            <th>Component Description</th>
                                                            <th>Unit Of Measure</th>
                                                            <th>Unit Cost</th>
                                                            <th>Image</th>
                                                            <th class="specification_column">Specification/Technical</th>
                                                            <th class="warranty_column">Warranty</th>
                                                            <th class="maintenance_column">Maintenance</th>
                                                            <th class="installation_column">Installation</th>
                                                            <th class="checklist_column">Checklist</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                       
                                                    </thead>
                                                    <tbody>
                                                      <tr class="pb1 newcomponents_container" tr_val="1">
                                                          <td>
                                                            <select data-container="body" class="selectpicker" data-style="select-with-transition" name="component_category[1]" data-live-search="true">
                                                                <option value="0">Select Category</option>
                                                                <?php foreach($categories as $category){ ?>
                                                                <option value="<?php echo $category['name'];?>"><?php echo $category['name'];?></option>
                                                                <?php } ?>
                                                            </select>
                                                          </td>
                                                          <td>
                                                              <div class="form-group">
                                                                 <input class="form-control" type="text" name="component_name[1]" value="" placeholder="Enter Component Name" required="true">
                                                              </div>
                                                          </td>
                                                          <td><textarea class="form-control customfield" rows="3" name="component_des[1]" placeholder="Enter Component Description" required="true"></textarea></td>
                                                          <td><input class="form-control customfield" type="text" name="component_uom[1]" value="" placeholder="Enter Unit of Measure" required="true"></td>
                                                          <td> <input class="form-control customfield" type="text" name="component_uc[1]" value="" placeholder="Enter Unit Cost" required="true"></td>
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
                                                                            <input type="file" id="component_img1" name="component_img[]"/>
                                                                        </span>
                                                                        <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                                                    </div>
                                                                </div>
                                                          </td>
                                                          <td class="specification_column">
                                                              <a class="btn btn-success upload_specification upload_specification1" data-toggle="modal" rowno="1">Upload Specification</a>
                                                              <input type="hidden" id="specification1" name="specification[]" value="" rowno="1">
                                                              <div class="specification_container1"></div>
                                                              
                                                          </td>
                                                          <td class="warranty_column">
                                                              <a class="btn btn-success upload_warranty upload_warranty1" data-toggle="modal" rowno="1">Upload Warranty</a>
                                                              <input type="hidden" id="warranty1" name="warranty[]" value="" rowno="1">
                                                              <div class="warranty_container1"></div>
                                                          </td>
                                                          <td class="maintenance_column">
                                                              <a class="btn btn-success upload_maintenance upload_maintenance1" data-toggle="modal" rowno="1">Upload Maintenance</a>
                                                              <input type="hidden" id="maintenance1" name="maintenance[]" value="" rowno="1">
                                                              <div class="maintenance_container1"></div>
                                                          </td>
                                                          <td class="installation_column">
                                                              <a class="btn btn-success upload_installation upload_installation1" data-toggle="modal" rowno="1">Upload Installation</a>
                                                              <input type="hidden" id="installation1" name="installation[]" value="" rowno="1">
                                                              <div class="installation_container1"></div>
                                                          </td>
                                                          <td class="checklist_column">
                                                              <input type="text" class="form-control checklistitem customfield" id="checklist_name1" name="checklist_name[]" value="" rowno="1" placeholder="Enter Checklist">
                                                              <input type="hidden" id="checklist1" name="checklist[]" value="" rowno="1">
                                                              <div class="checklist_container1"></div>
                                                          </td>
                                                          <td>
                                                            <select class="selectpicker" name="component_status[]" data-style="select-with-transition">
                                                                <option value="1">Current</option>
                                                                <option value="0">Inactive</option>
                                                            </select>
                                                          </td>
                                                          <td>
                                                              <a  class="btn btn-icon btn-danger remove btn-simple" tabletype="pocos" type="button" onclick="removeRow(1);"><i class="material-icons">delete</i></a>
                                                          </td>
                                                      </tr>
                                                    </tbody>
                    
                                                </table>
                                            </div>
                                        </div>
                                       <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <div class="form-footer text-right">
                                                        <input type="submit" class="btn btn-warning btn-fill" value="Save Price Book"/>
                                                        <a href="<?php echo SURL;?>supplierz/price_books" class="btn btn-default btn-fill">Close</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                           
                                    </form>
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

                
                