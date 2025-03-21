<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <form id="RoleForm" method="POST" action="<?php echo SURL ?>setup/add_new_role_process">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">accessibility</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Add Role</h4>
                                        <div class="form-group label-floating">
                                            <label class="control-label">
                                                Role Title
                                                <small>*</small>
                                            </label>
                                            <input class="form-control is_unique" type="text" name="role_title" id="role_title" required="true" uniqueRole="true" value="<?php echo set_value('role_title')?>"/>
                                            <?php echo form_error('role_title', '<div class="custom_error">', '</div>'); ?>
										</div>
										<div class="form-group label-floating">
                                        <div class="row">
                                            <label class="col-sm-4 label-on-left">Assign Permissions</label>
                                            <div class="col-sm-8 checkbox-radios">
											    <?php
                                                foreach ($menus as $men => $m) {
												?>
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" id="<?php echo "menu_".$m['id']; ?>" name="role_arr[]" value="<?php echo $m['id']; ?>" onclick="checkbox_item(this.id);"> <?php echo $m['menu_title']; ?>
                                                    </label>
                                                </div>
												
												<?php if(!empty($m['sub_menu'])){?>
    												<ul>
                                                        <?php foreach($m['sub_menu'] as $sub_menu){ 
        												?>
            												<li><div class="checkbox">
                                                                <label>
                                                                    <input type="checkbox" class="<?php echo "child_menu_".$m['id']; ?>" id="<?php echo "child_menu_".$sub_menu['id']; ?>" name="role_arr[]" value="<?php echo $sub_menu['id']; ?>" onclick="checkbox_parent_item('<?php echo "menu_".$m['id']; ?>', 'child');checkbox_child_items(this.id);"> <?php echo $sub_menu['menu_title']; ?>
                                                                </label>
                                                            </div>
                                                                <?php if(!empty($sub_menu['child_menu'])){
                                                                ?>
                												<ul>
                                                                <?php foreach($sub_menu['child_menu'] as $sub_menu1){ 
                												?>
                												<li><div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" class="<?php echo "sub_child_menu_".$m['id']; ?> <?php echo "sub_child_menu_".$sub_menu['id']; ?>" id="<?php echo "child_sub_menu_".$sub_menu1['id']; ?>" name="role_arr[]" value="<?php echo $sub_menu1['id']; ?>" onclick="checkbox_parent_item(<?php echo $sub_menu['id']; ?>, 'subchild', <?php echo $m['id']; ?>);"> <?php echo $sub_menu1['menu_title']; ?>
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
                                        <div class="form-footer text-right">
                                            <button type="submit" class="btn btn-warning btn-fill">Add</button>
                                            <a href="<?php echo SURL;?>setup/roles" class="btn btn-default btn-fill">Cancel</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                