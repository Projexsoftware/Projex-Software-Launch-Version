<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-icon" data-background-color="orange">
                <i class="material-icons">menu_book</i>
            </div>
            <div class="card-content">
                <h4 class="card-title">Edit Price Book</h4>
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
        
                <form id="PriceBookForm" method="POST" action="<?php echo SURL ?>supplierz/update_price_book_process" enctype="multipart/form-data" autocomplete="off">
                <input type="hidden" id="price_book_id" name="price_book_id" value="<?php echo $price_book_components[0]['p_book_id'];?>"/>
                <div class="row">
                                        <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Price Book Name
                                                    <small>*</small>
                                                    </label>
                                                    <input class="form-control" type="text" name="name" id="name" required="true" uniqueEditPriceBook="true" value="<?php echo $price_book_components[0]['name'];?>"/>
                                                    <?php echo form_error('name', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                        </div>
                                        <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Price Book Created Date
                                                    <small>*</small>
                                                    </label>
                                                    <input class="form-control" type="text" name="created_date" id="created_date" required="true" value="<?php echo date("d/M/Y", strtotime($price_book_components[0]['date_created']));?>" disabled/>
    				                        	</div>
                                        </div>
                                        <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Price Book Status
                                                    <small>*</small>
                                                    </label>
                                                    <select class="selectpicker" data-style="select-with-transition" name="status">
                                                        <option value="1" <?php if($price_book_components[0]['status']==1){ ?> selected <?php } ?>>Current</option>
                                                        <option value="0" <?php if($price_book_components[0]['status']==0){ ?> selected <?php } ?>>Inactive</option>
                                                    </select>
                                                </div>
                                        </div>
                                        <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    
                                                    </label>
                                                    <select class="selectpicker" data-style="select-with-transition" title="Component Type *" data-size="7" name="component_type" id="component_type" required="true"  onchange="checkType(this.value)">
                                                        <option disabled> Price Book Componets By</option>
            											<option value="Import CSV">Import CSV</option>
                                                        <option value="Adding Component" selected>Adding Component</option>
                                                        <option value="Existing Price Book">Existing Price Book</option>
                                                    </select>
    				                        	</div>
                                        </div>
                                        <div class="col-md-12">
                                        <div id="csv_container" class="col-md-12" style="display:none;">
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
                <div class="row">
                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" id="column_specification" onchange="showcolumn('specification')">Show Specification
                                                </label>
                                            </div> 
                                        </div>
                                        <div class="col-md-2">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" id="column_warranty" onchange="showcolumn('warranty')">Show Warranty
                                                </label>
                                            </div> 
                                        </div>
                                        <div class="col-md-2">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" id="column_maintenance" onchange="showcolumn('maintenance')">Show Maintenance
                                                </label>
                                            </div> 
                                        </div>
                                        <div class="col-md-2">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" id="column_installation" onchange="showcolumn('installation')">Show Installation
                                                </label>
                                            </div> 
                                        </div>
                                        <div class="col-md-2">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" id="column_checklist" onchange="showcolumn('checklist')">Show Checklist
                                                </label>
                                            </div> 
                                        </div>
                                </div>
                        </div>
                        <br/><br/>
                       <div id='newcomponentdiv' style="display:block;">
                         <div class="row"><div class="col-md-12"><div class="text-right"><button type="button" class="btn btn-warning btn-fill" onclick="addRow();"><i class="material-icons">add</i> Add Component</button></div></div></div>
                       
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
                                 <?php 

                                 if(count($price_book_components)){
                                 $count = 1;
                                 foreach($price_book_components as $val){ 
                                 $document_info = get_document_info($val['component_id']);
                                 $checklists = get_checklist_items($val['component_id']);
                                 ?>
                             
                                  <tr class="pb<?php echo $count;?>" tr_val="<?php echo $count;?>">
                                      <input type="hidden" id="component_id<?php echo $count;?>" name="component_id[]" value="<?php echo $val['component_id'];?>"/>
                                      <td>
                                        <select data-container="body" class="selectpicker" data-style="select-with-transition" data-live-search="true" name="component_category[]">
                                            <option value="0">Select Category</option>
                                            <?php foreach($categories as $category){ ?>
                                            <option value="<?php echo $category['name'];?>" <?php if($category['name']==$val['component_category']){ ?> selected <?php } ?>><?php echo $category['name'];?></option>
                                            <?php } ?>
                                        </select>
                                      </td>
                                      <td><input class="form-control customfield" type="text" required="true" name="component_name[<?php echo $count;?>]" value="<?php echo $val['component_name'];?>" placeholder="Enter Component Name"></td>
                                      <td><textarea class="form-control customfield" rows="3" name="component_des[<?php echo $count;?>]" required="true" placeholder="Enter Component Description"><?php echo $val['component_des'];?></textarea></td>
                                      <td><input class="form-control customfield" type="text" name="component_uom[<?php echo $count;?>]" required="true" value="<?php echo $val['component_uom'];?>" placeholder="Enter Unit of Measure"></td>
                                      <td> <input class="form-control customfield" type="text" name="component_uc[<?php echo $count;?>]" required="true" value="<?php echo $val['component_uc'];?>" placeholder="Enter Unit Cost"></td>
                                      <td>
                                        <?php if($val['image']!=""){?>
                                        <div class="fileinput fileinput-exists text-center" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail">
                                                    <img src="<?php echo IMG;?>image_placeholder.jpg" alt="...">
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail">
                                                    <?php if($val['image']!=""){?><img src="<?php echo SURL."assets/price_books/".$val['image'];?>" alt="..." style="height:100px;"><?php }?>
                                                </div>
                                                <div>
                                                    <span class="btn btn-warning btn-round btn-file">
                                                        <span class="fileinput-new">Select image</span>
                                                        <span class="fileinput-exists">Change</span>
                                                        <input type="file" id="component_img<?php echo $count;?>" name="component_img[]" />
                                                        <input type="hidden" name="old_component_img[]" value="<?php echo $val['image'];?>">
                                                    </span>
                                                    <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                                </div>
                                            </div>
                                        <?php } else{ ?>
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
                                        <?php } ?>
                                        
                                      </td>
                                      <td class="specification_column">
                                          <a class="btn btn-success upload_specification upload_specification<?php echo $count;?>" data-toggle="modal" rowno="<?php echo $count;?>" <?php if(isset($document_info['specification']) && $document_info['specification']!=""){ ?> style="display:none;" <?php } ?>>Upload Specification</a>
                                          <input type="hidden" id="specification<?php echo $count;?>" name="specification[]" value="<?php if(isset($document_info['specification'])){ echo $document_info['specification']; }?>" rowno="<?php echo $count;?>">
                                          <div class="specification_container<?php echo $count;?>">
                                              <?php if(isset($document_info['specification']) && $document_info['specification']!=""){ ?>
                                              <a target="_Blank" href="<?php echo base_url();?>assets/price_books/component_documents/specification/<?php echo $document_info['specification'];?>"><?php echo $document_info['specification'];?></a><span rowno="<?php echo $count;?>" id="<?php echo $document_info['id'];?>" class="remove_specification_file btn btn-icon btn-simple btn-danger"><i class="material-icons">close</i></span>
                                              <?php } ?>
                                          </div>
                                          
                                      </td>
                                      <td class="warranty_column">
                                          <a class="btn btn-success upload_warranty upload_warranty<?php echo $count;?>" data-toggle="modal" rowno="<?php echo $count;?>" <?php if(isset($document_info['warranty']) && $document_info['warranty']!=""){ ?> style="display:none;" <?php } ?>>Upload Warrnty</a>
                                          <input type="hidden" id="warranty<?php echo $count;?>" name="warranty[]" value="<?php if(isset($document_info['warranty'])){ echo $document_info['warranty']; }?>" rowno="<?php echo $count;?>">
                                          <div class="warranty_container<?php echo $count;?>">
                                              <?php if(isset($document_info['warranty']) && $document_info['warranty']!=""){ ?>
                                              <a target="_Blank" href="<?php echo base_url();?>assets/price_books/component_documents/warranty/<?php echo $document_info['warranty'];?>"><?php echo $document_info['warranty'];?></a><span rowno="<?php echo $count;?>" id="<?php echo $document_info['id'];?>" class="remove_warranty_file btn btn-icon btn-simple btn-danger"><i class="material-icons">close</i></span>
                                              <?php } ?>
                                          </div>
                                      </td>
                                      <td class="maintenance_column">
                                          <a class="btn btn-success upload_maintenance upload_maintenance<?php echo $count;?>" data-toggle="modal" rowno="<?php echo $count;?>" <?php if(isset($document_info['maintenance']) && $document_info['maintenance']!=""){ ?> style="display:none;" <?php } ?> >Upload Maintenance</a>
                                          <input type="hidden" id="maintenance<?php echo $count;?>" name="maintenance[]" value="<?php if(isset($document_info['maintenance'])){ echo $document_info['maintenance']; }?>" rowno="<?php echo $count;?>">
                                          <div class="maintenance_container<?php echo $count;?>">
                                              <?php if(isset($document_info['maintenance']) && $document_info['maintenance']!=""){ ?>
                                              <a target="_Blank" href="<?php echo base_url();?>assets/price_books/component_documents/maintenance/<?php echo $document_info['maintenance'];?>"><?php echo $document_info['maintenance'];?></a><span rowno="<?php echo $count;?>" id="<?php echo $document_info['id'];?>" class="remove_maintenance_file btn btn-icon btn-simple btn-danger"><i class="material-icons">close</i></span>
                                              <?php } ?>
                                          </div>
                                      </td>
                                      <td class="installation_column">
                                          <a class="btn btn-success upload_installation upload_installation<?php echo $count;?>" data-toggle="modal" rowno="<?php echo $count;?>" <?php if(isset($document_info['installation']) && $document_info['installation']!=""){ ?> style="display:none;" <?php } ?>>Upload Installation</a>
                                          <input type="hidden" id="installation<?php echo $count;?>" name="installation[]" value="<?php if(isset($document_info['installation'])){ echo $document_info['installation']; }?>" rowno="<?php echo $count;?>">
                                          <div class="installation_container<?php echo $count;?>">
                                              <?php if(isset($document_info['installation']) && $document_info['installation']!=""){ ?>
                                                 <a target="_Blank" href="<?php echo base_url();?>assets/price_books/component_documents/installation/<?php echo $document_info['installation'];?>"><?php echo $document_info['installation'];?></a><span rowno="<?php echo $count;?>" id="<?php echo $document_info['id'];?>" class="remove_installation_file btn btn-icon btn-simple btn-danger"><i class="material-icons">close</i></span>
                                              <?php } ?>
                                          </div>
                                      </td>
                                      <td class="checklist_column">
                                          <input type="text" class="form-control checklistitem customfield" id="checklist_name<?php echo $count;?>" name="checklist_name[]" value="" rowno="<?php echo $count;?>" placeholder="Enter Checklist">
                                          <div class="checklist_container<?php echo $count;?>">
                                              <?php 
                                                $existing_checklist = "";
                                                if(count($checklists)>0){
                                                foreach($checklists as $checklist){ 
                                                $existing_checklist .=$checklist['checklist'].",";
                                              ?>
                                                  <p class="no-padding" checklist="<?php echo $checklist['checklist'];?>"><?php echo $checklist['checklist'];?><i rowno="<?php echo $count;?>" id="<?php echo $checklist['id'];?>" class="remove_checklist_item checklist_item<?php echo $checklist['id'];?> btn btn-icon btn-simple btn-danger"><i class="material-icons">close</i></i></p>
                                              <?php } } ?>
                                          </div>
                                          <input type="hidden" id="checklist<?php echo $count;?>" name="checklist[]" value="<?php echo $existing_checklist;?>" rowno="<?php echo $count;?>">
                                      </td>
                                      <td>
                                        <select class="selectpicker" data-style="select-with-transition" name="component_status[]">
                                            <option value="1" <?php if($val['component_status']==1){ ?> selected <?php } ?>>Current</option>
                                            <option value="0" <?php if($val['component_status']==0){ ?> selected <?php } ?>>Inactive</option>
                                        </select>
                                      </td>
                                      <td>
                                          <a  class="btn btn-danger btn-icon btn-simple remove" tabletype="pocos" type="button" onclick="removeRow(<?php echo $count;?>);"><i class="material-icons">delete</i></a>
                                      </td>
                                  </tr>
                                  <?php 
                                  $count++;
                                  }} ?>
                                </tbody>

                            </table>
                        </div>
                        </div>
                                                <div class="form-group label-floating">
                                                    <div class="form-footer text-right">
                                                        <button type="submit" class="btn btn-warning btn-fill">Update Price Book</button>
                                                        <a href="<?php echo SURL;?>supplierz/price_books" class="btn btn-default btn-fill">Close</a>
                                                    </div>
                                                </div>
                                                </form>
                                            
                                </div>
                        </div>
                            
                        </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">group</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Assigned Users</h4>
                                <table class="table table-striped table-hover" id="dataTable">
                                <thead>
                                    <tr class="headers">
                                        <th>S.No</th>
                                        <th>User Full Name</th>
                                        <th>User Email</th>
                                        <th>Company Name</th>
                                        <th>Company Contact Number</th>
                                        <th>Company Email</th>
                                        <th>Comapny Website</th>
                                    </tr>
                                   
                                </thead>
                                <tbody>
                                 <?php 
                                 $i = 1;
                                 foreach($assigned_users as $val){ 
                                 $user_info = get_price_book_user_info($val['user_id']);
                                 ?>
                             
                                  <tr>
                                      <td><?php echo  $i;?></td>
                                      <td><?php echo  $user_info['user_fname']." ".$user_info['user_lname'];?></td>
                                      <td><?php echo $user_info['user_email'];?></td>
                                      <td><?php echo $user_info['com_name'];?></td>
                                      <td><?php echo $user_info['com_phone_no'];?></td>
                                      <td>
                                        <?php echo $user_info['com_email'];?>
                                      </td>
                                      <td>
                                        <?php echo $user_info['com_website'];?>
                                      </td>
                                  </tr>
                                  <?php 
                                  $i++;
                                  } ?>
                                </tbody>

                            </table>
                            <?php if(count($assigned_users)>0){ ?>
                            
                                <div class="row"><div class="col-md-12">
                                <form method="post" action="<?php echo SURL;?>supplierz/update_users">
                                <input type="hidden" id="allocate_price_book" name="allocate_price_book" value="<?php echo $price_book_components[0]['p_book_id'];?>">
            			        <input type="submit" class="btn btn-success" value="Update Users">
            			        &nbsp;&nbsp;&nbsp;<a href="<?php echo SURL;?>supplierz/price_books" class="btn btn-danger">Close</a>
            			        </form>
                            </div>
                        </div>
                        <?php } ?>
                            </div>
                        </div>
                    </div>
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

                