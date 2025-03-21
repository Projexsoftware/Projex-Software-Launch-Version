<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <form id="EditProjectForm" method="POST" action="<?php echo SCURL ?>projects/update_project_process" enctype="multipart/form-data">
								<input type="hidden" id="project_id" name="project_id" value="<?php echo $project_edit['id']  ?>">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">android</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Update Project</h4>
                                        <div class="fileinput fileinput-exists text-center" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail">
                                                    <img src="<?php echo IMG;?>image_placeholder.jpg" alt="...">
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail"><?php if($project_edit['image']!=""){?><img src="<?php echo PROJECT_IMG.$project_edit['image'];?>" alt="..." style="height:200px;"><?php } else{
 ?><img src="<?php echo IMG.'image_placeholder.jpg';?>" alt="..." style="height:200px;"> <?php } ?></div>
                                                <div>
                                                    <span class="btn btn-success btn-round btn-file">
                                                        <span class="fileinput-new">Select image</span>
                                                        <span class="fileinput-exists">Change</span>
                                                        <input type="file" id="project_image" name="project_image" /><input type="hidden" name="old_image" id="old_image" value="<?php echo $project_edit['image'];?>"/>
                                                    </span>
                                                    <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                                </div>
                                            </div>
                                        <div class="form-group label-floating">
                                            <label class="control-label">
                                                Name
                                                <small>*</small>
                                            </label>
                                            <input class="form-control" type="text" name="name" id="name" required="true" uniqueEditProject="true" value="<?php echo $project_edit['name']?>"/>
                                            <?php echo form_error('name', '<div class="custom_error">', '</div>'); ?>
					</div>
                                        <div class="form-group label-floating">
                                            <label class="control-label">
                                                Description
                                                <small>*</small>
                                            </label>
                                            <textarea class="form-control" type="text" name="description" id="description" required="true"><?php echo $project_edit['description']?></textarea>
                                            <?php echo form_error('description', '<div class="custom_error">', '</div>'); ?>
					</div>
					 <div class="form-group label-floating">
                                            
                                            <input class="form-control datepicker project_start_date" type="text" name="start_date" id="start_date" required="true" value="<?php if($project_edit['start_date']!="0000-00-00"){ echo date("d/m/Y", strtotime($project_edit['start_date']));}?>" placeholder="Start Date"/>
                                            <?php echo form_error('start_date', '<div class="custom_error">', '</div>'); ?>
					</div>
                                        <div class="form-group label-floating">
                                            
                                            <input class="form-control datepicker" type="text" name="end_date" id="end_date" required="true" value="<?php if($project_edit['end_date']!="0000-00-00"){ echo date("d/m/Y", strtotime($project_edit['end_date']));}?>" placeholder="End Date"/>
                                            <?php echo form_error('end_date', '<div class="custom_error">', '</div>'); ?>
					</div>
					                    <div class="form-group label-floating">
            										<select class="selectpicker" data-style="select-with-transition" title="Status *" data-size="7" name="status" id="status" required="true">
                                                        <option disabled> Choose Status</option>
                                                        <option value="2" <?php if($project_edit["status"]==2){ ?> selected <?php } ?>>Pending</option>
            											<option value="1" <?php if($project_edit["status"]==1){ ?> selected <?php } ?>>Current</option>
            											<option value="0" <?php if($project_edit["status"]==0){ ?> selected <?php } ?>>Inactive</option>
            											<option value="3" <?php if($project_edit["status"]==3){ ?> selected <?php } ?>>Completed</option>
                                                    </select>
                                                </div>
                                         <div class="form-footer text-right">
                                            <button type="submit" class="btn btn-warning btn-fill">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                