<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <form id="HelpForm" method="POST" action="<?php echo AURL ?>help/edit_help_section_process" enctype="multipart/form-data">
								<input type="hidden" id="help_id" name="help_id" value="<?php echo $help_edit['id']  ?>">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">help</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Edit Help Section</h4>
                                        <?php
										if ($this->session->flashdata('err_message')) {
											?>
											<div class="alert alert-danger">
												<?php echo $this->session->flashdata('err_message'); ?>
											</div>
											<?php
										} ?>
                                         <div class="form-group label-floating">
                                            <select id="help_category" name="help_category" required="true" class="selectpicker" data-style="select-with-transition" title="Choose Category*">
                                                <option value="Introduction" <?php if($help_edit['help_category']=="Introduction"){ ?> selected <?php } ?>>Introduction</option>
                                                <option value="Setup" <?php if($help_edit['help_category']=="Setup"){ ?> selected <?php } ?>>Setup</option> 
                                                <option value="Add Designz" <?php if($help_edit['help_category']=="Designz"){ ?> selected <?php } ?>>Designz</option>
                                                <option value="Costingz" <?php if($help_edit['help_category']=="Costingz"){ ?> selected <?php } ?>>Costingz</option>
                                                <option value="Accountz" <?php if($help_edit['help_category']=="Accountz"){ ?> selected <?php } ?>>Accountz</option>
                                                <option value="Buildz" <?php if($help_edit['help_category']=="Buildz"){ ?> selected <?php } ?>>Buildz</option>
                                            </select>
                                            <?php echo form_error('help_category', '<div class="custom_error">', '</div>'); ?>
                                        </div>
                                        <div class="form-group label-floating">
                                            <div class="fileinput fileinput-exists text-center" data-provides="fileinput">
                                                
												<div class="fileinput-new thumbnail">
                                                    <img src="<?php echo IMG;?>image_placeholder.jpg" alt="...">
                                                </div>
												
                                                <div class="fileinput-preview fileinput-exists thumbnail"><?php echo $help_edit['help_uploads'];?></div>
                                                <div>
                                                    <span class="btn btn-round btn-warning btn-file">
                                                        <span class="fileinput-new">Add PDF FILE</span>
                                                        <span class="fileinput-exists">Change</span>
                                                        <input type="file" name="file" id="file"  accept="pdf/*"/>
														<input type="hidden" name="old_file" id="old_file" value="<?php echo $help_edit['help_uploads'];?>"/>
                                                    </span>
                                                    <br />
                                                    <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                                </div>
                                                <span class="file-error"></span>
                                            </div>
										</div> 
										 <div class="form-group label-floating">
                                            <select id="status" name="status" required="true" class="selectpicker" data-style="select-with-transition" title="Choose Status*">
                                                    <option value="1" <?php if($help_edit['status']==1){ ?> selected <?php } ?>>Active</option>
                                                    <option value="0" <?php if($help_edit['status']==0){ ?> selected <?php } ?>>Inactive</option>
                                            </select>
                                            <?php echo form_error('status', '<div class="custom_error">', '</div>'); ?>
                                        </div>
				                        <div class="form-group label-floating">
                                            <div class="form-footer text-right">
                                                <button type="submit" id="update_help_section" name="update_help_section" class="btn btn-warning btn-fill">Update</button>
                                            </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                