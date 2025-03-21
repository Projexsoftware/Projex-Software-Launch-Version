<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">draw</i>
                                    </div>
                                    <div class="card-content">
                                    <h4 class="card-title">Add Designz</h4>
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
                                    <form id="DesignzForm" method="POST" action="<?php echo SURL ?>designz/add_new_designz_process" enctype="multipart/form-data">
                                        <input type="hidden" name="uploadedFiles" id="uploadedFiles" value="">
                                        <div class="row">
                                            <div class="col-md-12">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">
                                                        Designz Name
                                                        <small>*</small>
                                                        </label>
                                                        <input class="form-control" type="text" name="project_name" id="project_name" required="true" uniqueProject="true" value="<?php echo set_value('project_name')?>"/>
                                                        <?php echo form_error('project_name', '<div class="custom_error">', '</div>'); ?>
        				                        	</div>
                                            </div>
                                            <div class="col-md-12">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">
                                                        Floor Area (m²)
                                                        <small>*</small>
                                                        </label>
                                                        <input class="form-control" type="text" name="floor_area" id="floor_area" required="true" digits="true" value="<?php echo set_value('floor_area')?>"/>
                                                        <?php echo form_error('floor_area', '<div class="custom_error">', '</div>'); ?>
        				                        	</div>
                                            </div>
                                            <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">
                                                        Living Areas
                                                        <small>*</small>
                                                        </label>
                                                        <select class="selectpicker" data-style="select-with-transition" name="living_areas" id="living_areas" required="true">
                                                            <option value=""> Select Living Areas</option>
                                                            <option value="0">0</option>
                											<option value="1">1</option>
                											<option value="2">2</option>
                											<option value="3">3</option>
                											<option value="4">4</option>
                                                        </select>
                                                        <?php echo form_error('living_areas', '<div class="custom_error">', '</div>'); ?>
        				                        	</div>
                                            </div>
                                            <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">
                                                        Bedrooms
                                                        <small>*</small>
                                                        </label>
                                                        <select class="selectpicker" data-style="select-with-transition" name="bedrooms" id="bedrooms" required="true">
                                                            <option value=""> Select Bedrooms</option>
                                                            <option value="0">0</option>
                											<option value="1">1</option>
                											<option value="2">2</option>
                											<option value="3">3</option>
                											<option value="4">4</option>
                											<option value="5">5</option>
                											<option value="6">6</option>
                                                        </select>
                                                        <?php echo form_error('bedrooms', '<div class="custom_error">', '</div>'); ?>
        				                        	</div>
                                            </div>
                                            <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">
                                                        Bathrooms
                                                        <small>*</small>
                                                        </label>
                                                        <select class="selectpicker" data-style="select-with-transition" name="bathrooms" id="bathrooms" required="true">
                                                            <option value=""> Select Bathrooms</option>
                                                            <option value="0">0</option>
                											<option value="1">1</option>
                											<option value="2">2</option>
                											<option value="3">3</option>
                											<option value="4">4</option>
                                                        </select>
                                                        <?php echo form_error('bathrooms', '<div class="custom_error">', '</div>'); ?>
        				                        	</div>
                                            </div>
                                            <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">
                                                        Garage
                                                        <small>*</small>
                                                        </label>
                                                        <select class="selectpicker" data-style="select-with-transition" name="garage" id="garage" required="true">
                                                            <option value=""> Select Garage</option>
                                                            <option value="0">0</option>
                											<option value="1">1</option>
                											<option value="2">2</option>
                											<option value="3">3</option>
                											<option value="4">4</option>
                                                        </select>
                                                        <?php echo form_error('garage', '<div class="custom_error">', '</div>'); ?>
        				                        	</div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                        <label class="control-label">
                                                        Images
                                                        <small>*</small>
                                                        </label>
                                                        <br><br>
                                                        <div id="imagesDropzone" class="dropzone"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                        <label class="control-label">
                                                        Plans
                                                        <small>*</small>
                                                        </label>
                                                        <br><br>
                                                        <div id="plansDropzone" class="dropzone"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 thumbnails_container">
                                                <div class="form-group">
                                                        <label class="control-label">
                                                        Designz Thumbnail
                                                        <small>*</small>
                                                        </label>
                                                        <br><br>
                                                        <img id="thumbnail" name="thumbnail" src="<?php echo IMG.'placeholder.jpg';?>" alt="..." style="width:100px;height:100px;">
                                                        <img id="plan_thumbnail" name="plan_thumbnail" src="<?php echo IMG.'placeholder.jpg';?>" alt="..." style="width:100px;height:100px;">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">
                                                        Movies
                                                        </label>
                                                        <textarea class="form-control" name="movies" id="movies" rows="7" cols="3"><?php echo set_value('movies')?></textarea>
        				                        	</div>
                                            </div>
                                            <div class="col-md-12">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">
                                                        3D
                                                        </label>
                                                        <textarea class="form-control" name="3D" id="3D" rows="7" cols="3"><?php echo set_value('3D')?></textarea>
        				                        	</div>
                                            </div>
                                            <div class="col-md-12">
                                                    <div class="form-group label-floating">
                										<select class="selectpicker" data-style="select-with-transition" title="Status *" data-size="7" name="status" id="status" required="true">
                                                            <option disabled> Select Status</option>
                											<option value="1" selected>Current</option>
                											<option value="0">Inactive</option>
                                                        </select>
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <div class="form-footer text-right">
                                                        <button type="submit" class="btn btn-warning btn-fill">Add</button>
                                                        <a href="<?php echo SURL;?>designz/manage_designz" class="btn btn-default btn-fill">Cancel</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                     </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                                           