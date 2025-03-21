<div id="user_container<?php echo $item['id'];?>">
<?php 
$users = get_users();
$roles = get_roles();
?>
<?php if($current_role==1 || $current_role==2){ ?>
<div class="form-group label-floating">
        <label class="control-label">
                Assign User
            <small></small>
        </label>
        <select rowno="<?php echo $item['id'];?>" id="assign_to_user_<?php echo $item['id'];?>" name="assign_to_user" class="selectpicker assign_to_user" data-style="select-with-transition" title="Choose User" data-container="body">
            <?php if(count($users)>0){
                    foreach($users as $val){
                                                        
            ?>
             <option value="<?php echo $val['user_id'];?>" <?php if($assign_to_user==$val['user_id']){ ?> selected <?php } ?>><?php echo $val['user_fname']." ".$val['user_lname'];?></option>
            <?php } }?>
        </select>
</div>							
<a class="add_user_btn<?php echo $item['id'];?> btn btn-default btn-round btn-sm" data-toggle="modal" data-target="#addUserModal<?php echo $item['id'];?>">Add User</a>
<?php } else{ 
echo get_user_info($item['assign_to_user']);
 } ?>
                                        <!-- Users modal -->
                                            <div class="modal fade" id="addUserModal<?php echo $item['id'];?>" tabindex="-1" role="dialog" aria-labelledby="myUserModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-notice">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
<h5 class="modal-title" id="myUserModalLabel"><?php echo get_task_name($item['task_id']);?></h5>                                                        </div>
                                                        <div class="modal-body">
                                                           
<?php if($current_role==1 || $current_role==2){ ?>
<div class="card">
                                <div class="card-header card-header-icon" data-background-color="black">
                                    <i class="material-icons">person</i>
                                </div>
                                <div class="card-content">
                                    <h5 class="card-title">Add New User</h5> 
                                    <div class="toolbar">
<form id="UserForm<?php echo $item['id'];?>" method="post" autocomplete="off">

<input type="hidden" id="user_task_id" name="user_task_id" value="0">
							
<input type="hidden" id="user_item_id" name="user_item_id" value="<?php echo $item['id'];?>">
<input type="hidden" id="user_project_id" name="user_project_id" value="<?php echo $item['project_id'];?>">
                                        <div class="form-group label-floating">
    										<select class="selectpicker" data-style="select-with-transition" title="Choose Role *" data-size="7" name="role_id" id="role_id_<?php echo $item['id'];?>" required="true">
                                                <option disabled> Choose Role</option>
    											<?php foreach($roles as $val){ 
    											if($val['id']!=1){
    											?>
                                                <option value="<?php echo $val['id'];?>"><?php echo $val['role_title'];?></option>
    											<?php } } ?>
                                            </select>
    										<?php echo form_error('role_id', '<div class="custom_error">', '</div>'); ?>
                                        </div>		
                                        <div class="form-group label-floating">
                                            <label class="control-label">
                                                First Name
                                                <small>*</small>
                                            </label>
                                            <input class="form-control" type="text" name="first_name" id="first_name_<?php echo $item['id'];?>" required="true" value=""/>
                                            <?php echo form_error('first_name', '<div class="custom_error">', '</div>'); ?>
										</div>
										<div class="form-group label-floating">
                                            <label class="control-label">
                                                Last Name
                                                <small>*</small>
                                            </label>
                                            <input class="form-control" type="text" name="last_name" id="last_name_<?php echo $item['id'];?>" required="true" value=""/>
                                            <?php echo form_error('last_name', '<div class="custom_error">', '</div>'); ?>
										</div>
										<div class="form-group label-floating">
                                            <label class="control-label">
                                                Email
                                                <small>*</small>
                                            </label>
                                            <input class="form-control" type="text" name="email" id="email_<?php echo $item['id'];?>" required="true" uniqueEmail="true" email="true" value=""/>
                                            <?php echo form_error('email', '<div class="custom_error">', '</div>'); ?>
										</div>
										<div class="form-group label-floating">
    										<div class="togglebutton pull-left">
                                                    <label class="text-default">
                                                      <input id="is_sent_activation_email_<?php echo $item['id'];?>" name="is_sent_activation_email" type="checkbox">Sent Activation Email
                                                    </label>
                                            </div>
                                        </div>
                                       
										
																<div class="form-footer text-right">
																	<button rowno="<?php echo $item['id'];?>" type="button" class="btn btn-default btn-fill add_new_user">Add</button>
																</div>
														
															   </form>
</div>
</div>
</div>
<?php } ?>
</div>                                                      </div>
                                                        
                                                    </div>
                                                </div>
                                        <!-- end Users modal -->
</div>