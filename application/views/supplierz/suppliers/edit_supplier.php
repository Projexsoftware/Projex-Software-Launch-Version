<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <form id="SupplierForm" method="POST" action="<?php echo SURL ?>supplierz/edit_supplier_process" autocomplete="off">
								<input type="hidden" id="supplier_id" name="supplier_id" value="<?php echo $supplier_edit['supplier_id'];?>">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">local_shipping</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Edit Supplier</h4>
                                        <?php if($supplier_edit["parent_supplier_id"]>0){?>
                                        <div class="col-md-12">
                                            <div class="alert alert-danger">
                                             <strong><i class="fa fa-exclamation-triangle" style="color:#fff"></i></strong>
                                             Supplier User - this cannot be changed
                                            </div>
                                        </div>
                                        <?php } ?>
                                        <div class="col-md-12">
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Supplier Name
                                                    <small>*</small>
                                                    </label>
                                                    <input class="form-control" type="text" name="supplier_name" id="supplier_name" required="true" uniqueEditSupplier="true" value="<?php echo $supplier_edit['supplier_name']?>"/>
                                                    <?php echo form_error('supplier_name', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Supplier Email
                                                    <small></small>
                                                    </label>
                                                    <input class="form-control" type="text" name="supplier_email" id="supplier_email" email="true" uniqueEditSupplierEmail="true" value="<?php echo $supplier_edit['supplier_email']?>"/>
                                                    <?php echo form_error('supplier_email', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Supplier Phone
                                                    <small></small>
                                                    </label>
                                                    <input class="form-control" type="text" name="supplier_phone" id="supplier_phone" value="<?php echo $supplier_edit['supplier_phone']?>"/>
                                                    <?php echo form_error('supplier_phone', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Supplier Website
                                                    <small></small>
                                                    </label>
                                                    <input class="form-control" type="text" name="supplier_web" id="supplier_web" validUrl="true" value="<?php echo $supplier_edit['supplier_web']?>"/>
                                                    <?php echo form_error('supplier_web', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Supplier Contact Person
                                                    <small></small>
                                                    </label>
                                                    <input class="form-control" type="text" name="supplier_contact_person" id="supplier_contact_person" value="<?php echo $supplier_edit['supplier_contact_person']?>"/>
                                                    <?php echo form_error('supplier_contact_person', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Supplier Contact Person Mobile
                                                    <small></small>
                                                    </label>
                                                    <input class="form-control" type="text" name="supplier_contact_person_mobile" id="supplier_contact_person_mobile" value="<?php echo $supplier_edit['supplier_contact_person_mobile']?>"/>
                                                    <?php echo form_error('supplier_contact_person_mobile', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-12"><br/><legend>Address</legend></div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Street
                                                    <small></small>
                                                    </label>
                                                    <input class="form-control" type="text" name="street_pobox" id="street_pobox" value="<?php echo $supplier_edit['street_pobox']?>"/>
                                                    <?php echo form_error('street_pobox', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Suburb
                                                    <small></small>
                                                    </label>
                                                    <input class="form-control" type="text" name="suburb" id="suburb" value="<?php echo $supplier_edit['suburb']?>"/>
                                                    <?php echo form_error('suburb', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    City
                                                    <small></small>
                                                    </label>
                                                    <input class="form-control" type="text" name="supplier_city" id="supplier_city" value="<?php echo $supplier_edit['supplier_city']?>"/>
                                                    <?php echo form_error('supplier_city', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Region
                                                    <small></small>
                                                    </label>
                                                    <input class="form-control" type="text" name="supplier_state" id="supplier_state" value="<?php echo $supplier_edit['supplier_state']?>"/>
                                                    <?php echo form_error('supplier_state', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Country
                                                    <small></small>
                                                    </label>
                                                    <input class="form-control" type="text" name="supplier_country" id="supplier_country" value="<?php echo $supplier_edit['supplier_country']?>"/>
                                                    <?php echo form_error('supplier_country', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    ZIP Code
                                                    <small></small>
                                                    </label>
                                                    <input class="form-control" type="text" name="supplier_zip" id="supplier_zip" value="<?php echo $supplier_edit['supplier_zip']?>"/>
                                                    <?php echo form_error('supplier_zip', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-12"><br/><legend>Postal Address</legend></div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Street
                                                    </label>
                                                    <input class="form-control" type="text" name="post_street_pobox" id="post_street_pobox" value="<?php echo $supplier_edit['post_street_pobox']?>"/>
                                                    <?php echo form_error('post_street_pobox', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Suburb
                                                    </label>
                                                    <input class="form-control" type="text" name="post_suburb" id="post_suburb" value="<?php echo $supplier_edit['post_suburb']?>"/>
                                                    <?php echo form_error('post_suburb', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    City
                                                    </label>
                                                    <input class="form-control" type="text" name="supplier_postal_city" id="supplier_postal_city" value="<?php echo $supplier_edit['supplier_postal_city']?>"/>
                                                    <?php echo form_error('supplier_postal_city', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Region
                                                    </label>
                                                    <input class="form-control" type="text" name="supplier_postal_state" id="supplier_postal_state" value="<?php echo $supplier_edit['supplier_postal_state']?>"/>
                                                    <?php echo form_error('supplier_postal_state', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Country
                                                    </label>
                                                    <input class="form-control" type="text" name="supplier_postal_country" id="supplier_postal_country" value="<?php echo $supplier_edit['supplier_postal_country']?>"/>
                                                    <?php echo form_error('supplier_postal_country', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    ZIP Code
                                                    </label>
                                                    <input class="form-control" type="text" name="supplier_postal_zip" id="supplier_postal_zip" value="<?php echo $supplier_edit['supplier_postal_zip']?>"/>
                                                    <?php echo form_error('supplier_postal_zip', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-12">
                                                <div class="form-group label-floating">
            										<select class="selectpicker" data-style="select-with-transition" title="Status *" data-size="7" name="supplier_status" id="supplier_status" required="true">
                                                        <option disabled> Choose Status</option>
            											<option value="1" <?php if($supplier_edit['supplier_status']==1){?> selected <?php } ?>>Current</option>
            											<option value="0" <?php if($supplier_edit['supplier_status']==0){?> selected <?php } ?>>Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                       <div class="col-md-12">
                                            <div class="col-md-12">
            				                    <div class="form-group label-floating">
                                                    <div class="form-footer text-right">
                                                        <?php if($supplier_edit["parent_supplier_id"]==0){?>
                                                        <?php if(in_array(66, $this->session->userdata("permissions"))) {?>
                                                        <button type="submit" id="update_supplier" name="update_supplier" class="btn btn-warning btn-fill">Update</button>
                                                        <?php } } ?>
                                                        <a href="<?php echo SURL;?>supplierz/suppliers" class="btn btn-default btn-fill">Cancel</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
                