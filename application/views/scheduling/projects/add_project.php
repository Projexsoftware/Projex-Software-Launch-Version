<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <form id="ProjectForm" method="POST" action="<?php echo SURL ?>projects/add_new_project_process" enctype="multipart/form-data">
                                    <div class="card-header card-header-icon" data-background-color="rose">
                                        <i class="material-icons">android</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Add Project</h4>
                                         <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail">
                                                    <img src="<?php echo IMG;?>image_placeholder.jpg" alt="...">
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                <div>
<?php if ($this->session->userdata('admin_role_id')!=3) { ?>
                                                    <span class="btn btn-info btn-round btn-file">
                                                        <span class="fileinput-new">Select image</span>
                                                        <span class="fileinput-exists">Change</span>
                                                        <input type="file" id="project_image" name="project_image" />
                                                    </span>
                                                    <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
<?php } ?>
                                                </div>
                                            </div>
                                        <div class="form-group label-floating">
                                            <label class="control-label">
                                                Name
                                                <small>*</small>
                                            </label>
                                            <input class="form-control" type="text" name="name" id="name" required="true" uniqueProject="true" value="<?php echo set_value('name')?>"/>
                                            <?php echo form_error('name', '<div class="custom_error">', '</div>'); ?>
					</div>
                                        <div class="form-group label-floating">
                                            <label class="control-label">
                                                Description
                                                <small>*</small>
                                            </label>
                                            <textarea class="form-control" type="text" name="description" id="description" required="true"><?php echo set_value('description')?></textarea>
                                            <?php echo form_error('description', '<div class="custom_error">', '</div>'); ?>
					</div>
                                        
                                        <div class="form-group label-floating">
                                            
                                            <input class="form-control datepicker project_start_date" type="text" name="start_date" id="start_date" required="true" value="<?php echo set_value('start_date')?>" placeholder="Start Date"/>
                                            <?php echo form_error('start_date', '<div class="custom_error">', '</div>'); ?>
					</div>
                                        <div class="form-group label-floating">
                                            
                                            <input class="form-control datepicker" type="text" name="end_date" id="end_date" required="true" value="<?php echo set_value('end_date')?>" placeholder="End Date"/>
                                            <?php echo form_error('end_date', '<div class="custom_error">', '</div>'); ?>
					</div>
				        <div class="form-group label-floating">
                                            <button class="btn btn-simple btn-github" style="font-size:16px;padding-left:0px;">
                                                <i class="fa fa-users"></i> Project Team
                                            <div class="ripple-container"></div></button>
                                            <select id="project_manager" name="project_manager" required="true" class="selectpicker" data-style="select-with-transition" title="Choose Project Manager" disabled>
                                                        
                                                        <option value="<?php echo $this->session->userdata('admin_id');?>" selected><?php echo $this->session->userdata('firstname')." ".$this->session->userdata('lastname');?> (Project Manager)</option>
                                                        
                                                    </select>
                                            
					</div>
                                        <div class="form-group label-floating">
                                            
                                            <select id="leaders" name="leaders[]" class="selectpicker select_leaders_team" data-style="select-with-transition" multiple title="Choose Leaders">
                                                        <?php if(count($users)>0){
                                                        foreach($users as $val){
                                                        ?>
                                                        <option value="<?php echo $val['id'];?>"><?php echo $val['first_name']." ".$val['last_name'];?></option>
                                                        <?php } } ?>
                                                    </select>
                                            <?php echo form_error('leaders', '<div class="custom_error">', '</div>'); ?>
					</div>
                                        <div class="form-group label-floating">
                                            
                                            <select id="members" name="members[]" class="selectpicker select_members_team" data-style="select-with-transition" multiple title="Choose Members">
                                                        <?php if(count($users)>0){
                                                        foreach($users as $val){
                                                        ?>
                                                        <option value="<?php echo $val['id'];?>"><?php echo $val['first_name']." ".$val['last_name'];?></option>
                                                        <?php } } ?>
                                                    </select>
                                            <?php echo form_error('members', '<div class="custom_error">', '</div>'); ?>
					</div>	
                                        <div class="form-group label-floating">
                                            
                                            <select id="guest" name="guest[]" class="selectpicker select_guest_team" data-style="select-with-transition" multiple title="Choose Guest">
                                                        <?php if(count($users)>0){
                                                        foreach($users as $val){
                                                        ?>
                                                        <option value="<?php echo $val['id'];?>"><?php echo $val['first_name']." ".$val['last_name'];?></option>
                                                        <?php } } ?>
                                                    </select>
                                            <?php echo form_error('guest', '<div class="custom_error">', '</div>'); ?>
					</div>			
                                        <div class="form-footer text-right">
                                            <button type="submit" class="btn btn-rose btn-fill">Add</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                