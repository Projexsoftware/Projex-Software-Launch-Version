<footer class="footer notprint">
                <div class="container-fluid">
                    <nav class="pull-left">
                        <!--<ul>
                            <li>
                                <a href="#">
                                    Home
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Company
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Portfolio
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Blog
                                </a>
                            </li>
                        </ul>-->
                    </nav>
                    <p class="copyright pull-right">
                        &copy;
                        <script>
                            document.write(new Date().getFullYear())
                        </script>
                        <a target="_Blank" href="<?php echo SURL;?>dashboard">Project Software</a>, Developed by Projex Software LTD
                    </p>
                </div>
            </footer>
            <?php $componentSuppliers = getComponentSuppliers();?>
            <div class="modal fade" id="addNewComponentModal">
  <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header"></div>
    <div class="row">
      <div class="col-md-12">
         <div class="card" style="box-shadow:none;">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">star</i>
                                    </div>
                                    <div class="card-content">
                                    <h4 class="card-title">Add Component1</h4>
      <form id="addNewComponentForm" class="form-horizontal no-margin form-border" action="" method="post" name="addNewComponentForm" enctype="multipart/form-data" autocomplete="off">
      <div class="modal-body" style="padding:0px;">
                    
                    
                                    <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    
                                                    </label>
                                                    <select class="selectpicker" data-style="select-with-transition" title="Supplier *" data-live-search="true" data-size="7" name="supplier_id" id="supplier_id" required="true">
                                                        <option disabled> Choose Supplier</option>
            											<?php if(count($componentSuppliers)>0){ foreach($componentSuppliers as $supplier){ ?>
            											<option value="<?php echo $supplier['supplier_id'];?>"><?php echo $supplier["supplier_name"]; ?></option>
            											<?php } } ?>
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
                                                        <span class="fileinput-new">Select image</span>
                                                        <span class="fileinput-exists">Change</span>
                                                        <input type="file" id="image" name="image" />
                                                    </span>
                                                    <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
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
      </div>
      <div class="modal-footer">
            
                       <div class="col-md-12">
                                                                <div class="progress progress-line-success" id="progressFileDivComponent">
                                                                    <div class="progress-bar progress-bar-success" id="progressFileBarComponent">0%</div>
                                                                </div>
                                                            </div>
                        
                       <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <div class="form-footer text-right">
                                                        <button type="submit" class="btn btn-warning btn-fill" id="add_new_component">Add</button>
                                                        <a data-dismiss="modal" aria-hidden="true" class="btn btn-default btn-fill" style="margin-top:0px;">Close</a>
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
    <!-- /.modal-content --> 
  </div>
  <!-- /.modal-dialog --> 
</div>