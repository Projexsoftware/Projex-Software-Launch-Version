<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-icon" data-background-color="orange">
                <i class="material-icons">menu_book</i>
            </div>
            <div class="card-content">
                <h4 class="card-title">Price Book</h4>
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
                        <br/><br/>
                       <div id='newcomponentdiv' style="display:block;">
                        <div class="row">
                            <div class="col-md-12">
                               <div id="datatables_filter" class="dataTables_filter"><label class="form-group form-group-sm is-empty"><input type="search" class="form-control search-component-field" placeholder="Search components" aria-controls="datatables"><span class="material-input"></span></label></div>
                            </div>
                          <div class="col-md-12">
                         <div class="loader">
                                            <center>
                                                <img class="loading-image" src="<?php echo IMG;?>search.gif" alt="loading.." width="100px">
                                            </center>
                                        </div>
                                         <br>
                        <div class="table-responsive">
                            <table id="impnewitems" class="table sortable_table templates_table">
                                <thead>
                                     <tr>
                                        <th>Component Category</th>
                                        <th>Component Image</th>
                                        <th>Component Name</th>
                                        <th>Unit Of Measure</th>
                                        <th>Unit Cost</th>
                                        <th>Margin %</th>
                                        <th>Margin $</th>
                                        <th>Sale Price $</th>
                                        <!--<th class="optional_column">Image</th>-->
                                        <th class="optional_column">Component Description</th>
                                        <th class="optional_column">Specification/Technical</th>
                                        <th class="optional_column">Warranty</th>
                                        <th class="optional_column">Maintenance</th>
                                        <th class="optional_column">Installation</th>
                                        <th class="">Show in Price Book</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="pricebook-components-list">
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
                                  }} ?>
                                </tbody>
                            </table>
                        </div>
                        </div>
                         </div>
                        </div>
                                           
                                                <div class="form-group label-floating">
                                                    <div class="form-footer text-right">
                                                        <?php if(count($price_book_components)>0){?>
                                                           <button type="submit" class="btn btn-warning btn-fill">Update Price Book</button>
                                                        <?php } ?>
                                                        <a href="<?php echo SURL;?>supplierz/components" class="btn btn-default btn-fill">Close</a>
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
                                <h4 class="card-title">Builderz Users</h4>
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
                                        <th>Price Book Shared</th>
                                    </tr>
                                   
                                </thead>
                                <tbody>
                                 <?php 
                                 $i = 1;
                                 foreach($builderz as $user_info){ 
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
                                      <td>
                                          <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" class="price_book_shared" name="price_book_shared[]" id="price_book_shared<?php echo $user_info['user_id'];?>" <?php if(in_array($user_info['user_id'], $assigned_users)){?> checked <?php } ?> value="<?php echo $user_info['user_id'];?>">
                                                </label>
                                            </div>
                                      </td>
                                  </tr>
                                  <?php 
                                  $i++;
                                  } ?>
                                </tbody>

                            </table>
                            <?php /*if(count($assigned_users)>0){ ?>
                            
                                <div class="row"><div class="col-md-12">
                                <form method="post" action="<?php echo SURL;?>supplierz/update_users">
                                <input type="hidden" id="allocate_price_book" name="allocate_price_book" value="<?php echo $price_book_components[0]['p_book_id'];?>">
            			        <input type="submit" class="btn btn-success" value="Update Users">
            			        &nbsp;&nbsp;&nbsp;<a href="<?php echo SURL;?>supplierz/price_books" class="btn btn-danger">Close</a>
            			        </form>
                            </div>
                        </div>
                        <?php } */?>
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

                