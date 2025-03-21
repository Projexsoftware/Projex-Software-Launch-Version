<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <form id="RoleForm" method="POST" action="<?php echo SURL ?>setup/edit_role_process">
								<input type="hidden" id="role_id" name="role_id" value="<?php echo $admin_role_arr['id']  ?>">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">accessibility</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Edit Role</h4>
                                        <br/>
                                        <div class="form-group label-floating">
                                            <label class="control-label">
                                                Role Title
                                                <small>*</small>
                                            </label>
                                            <input class="form-control" id="role_title" name="role_title" type="text" required="true" uniqueEditRole="true" value="<?php echo $admin_role_arr['role_title'];?>"/>
                                            <?php echo form_error('role_title', '<div class="custom_error">', '</div>'); ?>
										</div>
										<div class="form-group label-floating">
                                        <div class="row">
                                            <label class="col-sm-4 label-on-left">Assign Permissions</label>
                                            <div class="col-sm-8 checkbox-radios">
											    <?php
                                                foreach ($permission_arr as $men => $m) {
												?>
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" id="<?php echo "menu_".$m['id']; ?>" name="role_arr[]" value="<?php echo $m['id']; ?>" <?php echo (in_array($m['id'], $admin_role_arr['user_permissions_arr'])) ? 'checked' : '' ?> onclick="checkbox_item(this.id);"> <?php echo $m['menu_title']; ?>
                                                        </label>
                                                    </div>
												
												<?php if(!empty($m['sub_menu'])){?>
    												<ul>
                                                        <?php foreach($m['sub_menu'] as $sub_menu){ 
        												?>
            												<li><div class="checkbox">
                                                                <label>
                                                                    <input type="checkbox" class="<?php echo "child_menu_".$m['id']; ?>" id="<?php echo "child_menu_".$sub_menu['id']; ?>" name="role_arr[]" value="<?php echo $sub_menu['id']; ?>" <?php echo (in_array($sub_menu['id'], $admin_role_arr['user_permissions_arr'])) ? 'checked' : '' ?> onclick="checkbox_parent_item('<?php echo "menu_".$m['id']; ?>', 'child');checkbox_child_items(this.id);"> <?php echo $sub_menu['menu_title']; ?>
                                                                </label>
                                                            </div>
                                                                <?php if(!empty($sub_menu['child_menu'])){
                                                                ?>
                												<ul>
                                                                <?php foreach($sub_menu['child_menu'] as $sub_menu1){ 
                												?>
                												<li><div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" class="<?php echo "sub_child_menu_".$m['id']; ?> <?php echo "sub_child_menu_".$sub_menu['id']; ?>" id="<?php echo "child_sub_menu_".$sub_menu1['id']; ?>" name="role_arr[]" value="<?php echo $sub_menu1['id']; ?>" <?php echo (in_array($sub_menu1['id'], $admin_role_arr['user_permissions_arr'])) ? 'checked' : '' ?> onclick="checkbox_parent_item(<?php echo $sub_menu['id']; ?>, 'subchild', <?php echo $m['id']; ?>);"> <?php echo $sub_menu1['menu_title']; ?>
                                                                    </label>
                                                                </div></li>
                														<?php } ?>
                												</ul>
                												<?php } ?>
        											    	</li>
    													<?php } ?>
												    </ul>
												<?php } ?>
                                            <?php } ?>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="form-group label-floating">
                								<select class="selectpicker" data-style="select-with-transition" title="Status *" data-size="7" name="status" id="status" required="true">
                                                    <option disabled> Choose Status</option>
                									<option value="1" <?php if($admin_role_arr["status"]==1){ ?> selected <?php } ?>>Current</option>
                									<option value="0" <?php if($admin_role_arr["status"]==0){ ?> selected <?php } ?>>Inactive</option>
                                                </select>
                                        </div>
                                        <div class="form-footer text-right">
                                            <?php if(in_array(96, $this->session->userdata("permissions"))) {?>
                                            <button type="submit" id="update_role" name="update_role" class="btn btn-warning btn-fill">Update</button>
                                            <?php } ?>
                                            <a href="<?php echo SURL;?>setup/roles" class="btn btn-default btn-fill">Cancel</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                