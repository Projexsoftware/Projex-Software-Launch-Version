            <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <form id="DesignzForm" method="POST" action="<?php echo SURL.(($designz_type != "supplierz") ? 'designz/edit_designz_process' : 'designz/edit_supplierz_designz_process');?>" enctype="multipart/form-data">
								<input type="hidden" id="designz_id" name="designz_id" value="<?php echo $designz_edit['designz_id'];?>">
								<input type="hidden" id="designz_type" name="designz_type" value="<?php echo $designz_type;?>">
								<input type="hidden" name="uploadedFiles" id="uploadedFiles" value="">
								<input type="hidden" name="selectedFiles" id="selectedFiles" value="">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">draw</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Edit Designz</h4>
                                        <div class="row">
                                            <div class="col-md-12">
                                                 <?php if($designz_type == "supplierz"){ ?>
                                                    <span class="text-danger"><i style="vertical-align:middle;" class="material-icons">info</i> <b>This designz can only be updated by the Master Administrator. Please contact the Master Administrator if you wish to suggest an update?</b></span>
                                                    <br><br>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="<?php if($designz_type == "builderz"){ ?>col-md-12 <?php } else{ ?>col-md-6 <?php } ?>">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">
                                                        Designz Name
                                                        <small>*</small>
                                                        </label>
                                                        <input class="form-control" type="text" name="project_name" id="project_name" required="true" value="<?php echo $designz_edit['project_name'];?>" <?php if($designz_type == "supplierz"){ ?> readonly <?php } ?>/>
                                                        <?php echo form_error('project_name', '<div class="custom_error">', '</div>'); ?>
        				                        	</div>
                                            </div>
                                            <?php if($designz_type == "supplierz"){ 
                                                $builderz_designz_info = get_designz_builderz_settings($designz_edit['designz_id']);
                                            ?>
                                                <div class="col-md-6">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">
                                                        Builderz Designz Name
                                                        <small>*</small>
                                                        </label>
                                                        <input class="form-control" type="text" name="builderz_designz_name" id="builderz_designz_name" uniqueEditBuilderzDesignzName="true" value="<?php echo isset($builderz_designz_info) && $builderz_designz_info['name']!=""?$builderz_designz_info['name']:$designz_edit['project_name']; ?>"/>
                                                        <?php echo form_error('builderz_designz_name', '<div class="custom_error">', '</div>'); ?>
        				                        	</div>
                                                </div>
                                            <?php } ?>
                                            <div class="col-md-12">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">
                                                        Floor Area (m²)
                                                        <small>*</small>
                                                        </label>
                                                        <input class="form-control" type="text" name="floor_area" id="floor_area" required="true" digits="true" value="<?php echo $designz_edit['floor_area']; ?>" <?php if($designz_type == "supplierz"){ ?> readonly <?php } ?>/>
                                                        <?php echo form_error('floor_area', '<div class="custom_error">', '</div>'); ?>
        				                        	</div>
                                            </div>
                                            <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">
                                                        Living Areas
                                                        <small>*</small>
                                                        </label>
                                                        <select class="selectpicker" data-style="select-with-transition" name="living_areas" id="living_areas" required="true" <?php if($designz_type == "supplierz"){ ?> disabled <?php } ?>>
                                                            <option value=""> Select Living Areas</option>
                                                            <option value="0" <?php if($designz_edit['living_areas'] == 0){?> selected <?php } ?>>0</option>
                											<option value="1" <?php if($designz_edit['living_areas'] == 1){?> selected <?php } ?>>1</option>
                											<option value="2" <?php if($designz_edit['living_areas'] == 2){?> selected <?php } ?>>2</option>
                											<option value="3" <?php if($designz_edit['living_areas'] == 3){?> selected <?php } ?>>3</option>
                											<option value="4" <?php if($designz_edit['living_areas'] == 4){?> selected <?php } ?>>4</option>
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
                                                        <select class="selectpicker" data-style="select-with-transition" name="bedrooms" id="bedrooms" required="true" <?php if($designz_type == "supplierz"){ ?> disabled <?php } ?>>
                                                            <option value=""> Select Bedrooms</option>
                                                            <option value="0" <?php if($designz_edit['bedrooms'] == 0){?> selected <?php } ?>>0</option>
                											<option value="1" <?php if($designz_edit['bedrooms'] == 1){?> selected <?php } ?>>1</option>
                											<option value="2" <?php if($designz_edit['bedrooms'] == 2){?> selected <?php } ?>>2</option>
                											<option value="3" <?php if($designz_edit['bedrooms'] == 3){?> selected <?php } ?>>3</option>
                											<option value="4" <?php if($designz_edit['bedrooms'] == 4){?> selected <?php } ?>>4</option>
                											<option value="5" <?php if($designz_edit['bedrooms'] == 5){?> selected <?php } ?>>5</option>
                											<option value="6" <?php if($designz_edit['bedrooms'] == 6){?> selected <?php } ?>>6</option>
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
                                                        <select class="selectpicker" data-style="select-with-transition" name="bathrooms" id="bathrooms" required="true" <?php if($designz_type == "supplierz"){ ?> disabled <?php } ?>>
                                                            <option value=""> Select Bathrooms</option>
                                                            <option value="0" <?php if($designz_edit['bathrooms'] == 0){?> selected <?php } ?>>0</option>
                											<option value="1" <?php if($designz_edit['bathrooms'] == 1){?> selected <?php } ?>>1</option>
                											<option value="2" <?php if($designz_edit['bathrooms'] == 2){?> selected <?php } ?>>2</option>
                											<option value="3" <?php if($designz_edit['bathrooms'] == 3){?> selected <?php } ?>>3</option>
                											<option value="4" <?php if($designz_edit['bathrooms'] == 4){?> selected <?php } ?>>4</option>
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
                                                        <select class="selectpicker" data-style="select-with-transition" name="garage" id="garage" required="true" <?php if($designz_type == "supplierz"){ ?> disabled <?php } ?>>
                                                            <option value=""> Select Garage</option>
                                                            <option value="0" <?php if($designz_edit['garage'] == 0){?> selected <?php } ?>>0</option>
                											<option value="1" <?php if($designz_edit['garage'] == 1){?> selected <?php } ?>>1</option>
                											<option value="2" <?php if($designz_edit['garage'] == 2){?> selected <?php } ?>>2</option>
                											<option value="3" <?php if($designz_edit['garage'] == 3){?> selected <?php } ?>>3</option>
                											<option value="4" <?php if($designz_edit['garage'] == 4){?> selected <?php } ?>>4</option>
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
                                                        <img id="thumbnail" name="thumbnail" src="<?php echo count($thumbnail)>0?ASSETS.'builderz_designz_uploads/'.$thumbnail['file_name']:IMG.'placeholder.jpg';?>" alt="..." style="width:100px;height:100px;">
                                                        <img id="plan_thumbnail" name="plan_thumbnail" src="<?php echo count($plan_thumbnail)>0?ASSETS.'builderz_designz_uploads/'.$plan_thumbnail['file_name']:IMG.'placeholder.jpg';?>" alt="..." style="width:100px;height:100px;">
                                                </div>
                                            </div>
                        
                                            <div class="col-md-12">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">
                                                        Movies
                                                        </label>
                                                        <textarea class="form-control" name="movies" id="movies" rows="7" cols="3" <?php if($designz_type == "supplierz"){ ?> disabled <?php } ?>><?php echo $designz_edit['movies']; ?></textarea>
        				                        	</div>
                                            </div>
                                            <div class="col-md-12">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">
                                                        3D
                                                        </label>
                                                        <textarea class="form-control" name="3D" id="3D" rows="7" cols="3" <?php if($designz_type == "supplierz"){ ?> disabled <?php } ?>><?php echo $designz_edit['3D']; ?></textarea>
        				                        	</div>
                                            </div>
                                            <div class="col-md-12">
                                                    <div class="form-group label-floating">
                										<select class="selectpicker" data-style="select-with-transition" title="Status *" data-size="7" name="status" id="status" required="true" <?php if($designz_type == "supplierz"){ ?> disabled <?php } ?>>
                                                            <option disabled> Select Status</option>
                											<option value="1" <?php if($designz_edit['status'] == 1){?> selected <?php } ?>>Current</option>
                											<option value="0" <?php if($designz_edit['status'] == 0){?> selected <?php } ?>>Inactive</option>
                                                        </select>
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="col-md-12">
                                                    <div class="form-group label-floating">
                                                        <div class="form-footer text-right">
                                                            <button type="submit" name="update_designz" class="btn btn-warning btn-fill">Update</button>
                                                            <a href="<?php echo SURL;?>designz/manage_designz" class="btn btn-default btn-fill">Cancel</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                        </div>
                    </div>
            </div>
<script>
    var uploadedImages = <?= json_encode($uploadedImages); ?>;
    var uploadedPlans = <?= json_encode($uploadedPlans); ?>;
    var uploadedBuilderzImages = <?= json_encode($uploadedBuilderzImages); ?>;
    var uploadedBuilderzPlans = <?= json_encode($uploadedBuilderzPlans); ?>;
    /*var isClickable = <?php //echo $designz_type == "builderz"?1:0;?>;*/
    var isClickable = 1;
</script>