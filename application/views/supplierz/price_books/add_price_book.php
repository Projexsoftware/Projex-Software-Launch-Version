
<div class="row">
                        <div class="col-md-12">
                            
                            <div class="card">
                                <div class="card-content">
                                     <div class="panel-group" id="accordionTemplate" role="tablist" aria-multiselectable="true">
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingOneTemplate">
                                                <a role="button" data-toggle="collapse" data-parent="#accordionTemplate" href="#collapseOneTemplate" aria-controls="collapseOneTemplate">
                                                    <h4 class="panel-title">
                                                        Import Items Section
                                                        <i class="material-icons">keyboard_arrow_down</i>
                                                    </h4>
                                                </a>
                                            </div>
                                            <div id="collapseOneTemplate" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOneTemplate">
                                                <div class="panel-body">
                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                        <select class="selectpicker" data-style="btn btn-warning btn-round" data-live-search="true" title="Select From Existing Price Books" id="existing_price_book" name="existing_price_book">                 
                                                        <?php if(count($existing_price_books)>0){ foreach($existing_price_books as $price_book){ ?>                                       
                                                        <option value="<?php echo $price_book['id'];?>"><?php echo $price_book['name'];?></option>
                                                        <?php } }?>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                                    <form id="PriceBookCSVForm" method="POST" enctype="multipart/form-data">
                                                                        <div class="alert alert-danger import_file_error" style="display:none;"></div>
                                                                        <div class="label-floating">
                                                                            <label>
                                                                            Import CSV</label>
                                                                           <input type="file" id="importcsv"  name="importcsv" extension="csv" required="true">
                            				                        	</div>
                            				                        	<div class="label-floating">
                            				                        	    <button type="button" class="btn btn-warning btn-fill import-file-button">Import</button>
                            				                        	</div>
                        				                        	</form>
                        				                             <?php if(file_exists('./assets/csv/add_price_book_sample.csv')){ ?>
                                				                       <a href="<?php echo SURL;?>assets/csv/add_price_book_sample.csv" target="_Blan" class="btn btn-default">Click to View CSV Sample</a>
                                				                     <?php } ?>
                        				                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                 </div>
                            </div>
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
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Price Book Name
                                                    <small>*</small>
                                                    </label>
                                                    <input class="form-control" type="text" name="name" id="name" required="true" uniquePriceBook="true" value="<?php echo set_value('name')?>"/>
                                                    <?php echo form_error('name', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                    </div>
                                        <div id='newcomponentdiv'>
                   
                                            <div class="row">
                                                    <div class="col-md-12">
                                                            <div class="col-md-3">
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" id="column_optional" onchange="showcolumn('optional')" >Show Optional Columns
                                                                    </label>
                                                                </div> 
                                                            </div>
                                                    </div>
                                            </div>
                                            <div class="row">
                                            <div class="col-md-12">
                                                <div class="text-right">
                                                    <?php if(in_array(69, $this->session->userdata("permissions"))) {?>
                                                        <button id="addcomponentbtn" class="btn btn-info btn-fill" type="button" data-toggle="modal" href="#addNewComponentModal"><i class="material-icons">add</i> Add Component</button>
                                                    <?php } ?>
                                                    <button type="button" class="btn btn-warning btn-fill" onclick="addRow();"><i class="material-icons">add</i> Add New Item</button></div>
                                            </div>
                                            <div class="col-md-12">
                                                 <div class="loader">
                                            <center>
                                                <img class="loading-image" src="<?php echo IMG;?>search.gif" alt="loading.." width="100px">
                                            </center>
                                        </div>
                                         <br>
                                                <div class="table-responsive" >
                        
                                                    <table id="impnewitems" class="table sortable_table templates_table" >
                                                        <thead>
                                                            <tr>
                                                                <th>Component Category</th>
                                                                <th>Component Name</th>
                                                                <th>Unit Of Measure</th>
                                                                <th>Unit Cost</th>
                                                                <th>Margin %</th>
                                                                <th>Margin $</th>
                                                                <th>Sale Price $</th>
                                                                <th class="optional_column">Image</th>
                                                                <th class="optional_column">Component Description</th>
                                                                <th class="optional_column">Specification/Technical</th>
                                                                <th class="optional_column">Warranty</th>
                                                                <th class="optional_column">Maintenance</th>
                                                                <th class="optional_column">Installation</th>
                                                                <th class="optional_column">Checklist</th>
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                           
                                                        </thead>
                                                        <tbody>
                                                          <tr class="pb1 newcomponents_container" tr_val="1">
                                                              <input type="hidden" name="component_type[1]" value="0">
                                                              <td>
                                                                <select data-container="body" class="selectpicker" data-style="select-with-transition" id="component_category1" name="component_category[1]" data-live-search="true">
                                                                    <option value="0">Select Category</option>
                                                                    <?php foreach($categories as $category){ ?>
                                                                    <option value="<?php echo $category['name'];?>"><?php echo $category['name'];?></option>
                                                                    <?php } ?>
                                                                </select>
                                                              </td>
                                                              <td>
                                                                  <div class="form-group">
                                                                     <select name="component_id[1]" id="componentfield1" rno ='1' class="form-control selectComponent" onchange="return getcomponentinfo(1);" data-container="body">
            </select>
                                                                   <input type="hidden" name="component_name[1]" id="componentnamefield1" value="">
                                                                   <input type="hidden" name="supplier_id[1]" id="supplierfield1" value="">
                                                                  </div>
                                                              </td>
                                                              <td><input class="form-control customfield" type="text" name="component_uom[1]" id="uomfield1" value="" placeholder="Enter Unit of Measure" required="true"></td>
                                                              <td> 
                                                              <input class="form-control customfield" type="text" name="component_uc[1]" id="ucostfield1" value="0.00" placeholder="Enter Unit Cost" required="true" onchange="return calculateTotal(1);">
                                                              <input type="hidden" name="order_unit_cost[1]" id="order_unit_cost1" value="0.00">
                                                             
                                                              </td>
                                                              <td> <input class="form-control customfield" type="text" name="component_margin_percentage[1]" id="marginfield1" value="0" placeholder="Enter Margin %" required="true" onchange="return calculateTotal(1);"></td>
                                                              <td> <input class="form-control customfield" type="text" name="component_margin[1]" id="marginlinefield1" value="0.00" placeholder="Enter Margin $" required="true" onchange="return calculateTotal(1);"></td>
                                                              <td> <input class="form-control customfield" type="text" name="component_sale_price[1]" id="linetotalfield1" value="0.00" placeholder="Enter Sale Price $" required="true"></td>
                                                              <td class="optional_column">
                                                                
                                                                <div class="fileinput text-center" data-provides="fileinput">
                                                                        <div class="thumbnail preview_component_image1">
                                                                            <img src="<?php echo IMG;?>image_placeholder.jpg" alt="..." style="width:100px;height:100px;">
                                                                        </div>
                                                                    <input type="hidden" id="component_img1" name="component_img[1]" value=""/>
                                                                </div>
                                                              </td>
                                                              <td class="optional_column"><textarea class="form-control customfield" rows="3" name="component_des[1]" id="component_des1" placeholder="Enter Component Description" required="true"></textarea></td>
                                                              <td class="optional_column">
                                                                  <input type="hidden" id="specification1" name="specification[1]" value="" rowno="1">
                                                                  <div class="specification_container1"></div>
                                                                  
                                                              </td>
                                                              <td class="optional_column">
                                                                  <input type="hidden" id="warranty1" name="warranty[1]" value="" rowno="1">
                                                                  <div class="warranty_container1"></div>
                                                              </td>
                                                              <td class="optional_column">
                                                                  <input type="hidden" id="maintenance1" name="maintenance[1]" value="" rowno="1">
                                                                  <div class="maintenance_container1"></div>
                                                              </td>
                                                              <td class="optional_column">
                                                                  <input type="hidden" id="installation1" name="installation[1]" value="" rowno="1">
                                                                  <div class="installation_container1"></div>
                                                              </td>
                                                              <td class="optional_column">
                                                                  <input type="hidden" id="checklist1" name="checklist[1]" value="" rowno="1">
                                                                  <div class="checklist_container1"></div>
                                                              </td>
                                                              <td>
                                                                <select class="selectpicker" name="component_status[1]" data-style="select-with-transition" data-container="body">
                                                                    <option value="1">Current</option>
                                                                    <option value="0">Inactive</option>
                                                                </select>
                                                              </td>
                                                              <td>
                                                                  <a  class="btn btn-icon btn-danger remove btn-simple remove_component" rowno="1" tabletype="pocos" type="button"><i class="material-icons">delete</i></a>
                                                              </td>
                                                          </tr>
                                                        </tbody>
                        
                                                    </table>
                                                </div>
                                            </div>
                                            
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

     <div id="componentCostModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
        <h4>The Order Unit Cost appears to be different to the current component Unit Cost. Do you want to update the component Unit Cost?</h4>
       <form>
           <input type="hidden" id="update_component_id" value="">
           <input type="hidden" id="update_invoice_unit_cost" value="">
           <input type="hidden" id="update_rno" value="">
            <div class="form-group">
                <label for="current_unit_cost">Current Unit Cost:</label>
                <input type="text" class="form-control" id="current_unit_cost" name="current_unit_cost" value="" readonly>
            </div>
            <div class="form-group">
                <label for="current_unit_cost">Costing Part Unit Cost:</label>
                <input type="text" class="form-control" id="invoice_unit_cost" name="invoice_unit_cost" value="" readonly>
            </div>
       </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" onclick="update_component_unit_cost();">Update</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Don't Update</button>
      </div>
    </div>

  </div>
</div>
                