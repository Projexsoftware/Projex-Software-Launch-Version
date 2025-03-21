<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <form id="HelpForm" method="POST" action="<?php echo AURL ?>help/add_new_help_section_process" enctype="multipart/form-data">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">help</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Add Help Section</h4>
                                        <div class="form-group label-floating task_dropdown">
                                            <select id="help_category" name="help_category" required="true" class="selectpicker" data-style="select-with-transition" title="Choose Category*">
                                                <option value="Introduction">Introduction</option>
                                                <option value="Setup">Setup</option> 
                                                <option value="Designz">Designz</option>
                                                <option value="Costingz">Costingz</option>
                                                <option value="Accountz">Accountz</option>
                                                <option value="Buildz">Buildz</option>
                                            </select>
                                            <?php echo form_error('help_category', '<div class="custom_error">', '</div>'); ?>
				                        	</div>
                                        	<div class="form-group label-floating">
                                            <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail">
                                                    <img src="<?php echo IMG;?>image_placeholder.jpg" alt="...">
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                <div>
                                                    <span class="btn btn-round btn-warning btn-file">
                                                        <span class="fileinput-new">Add PDF File</span>
                                                        <span class="fileinput-exists">Change</span>
                                                        <input type="file" name="file" id="file" required="true" extension="pdf"/>
                                                    </span>
                                                    <br />
                                                    <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                                </div>
                                                <span class="file-error"></span>
                                            </div>
										</div>
                                       		 <div class="form-group label-floating task_dropdown">
                                            <select id="status" name="status" required="true" class="selectpicker" data-style="select-with-transition" title="Choose Status*">
                                                <option value="1" selected>Active</option>
                                                <option value="0">Inactive</option> 
                                            </select>
                                            <?php echo form_error('status', '<div class="custom_error">', '</div>'); ?>
				                        	</div>		
                                        <div class="form-footer text-right">
                                            <button type="submit" class="btn btn-warning btn-fill add_new_checklist">Add</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                