<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <form id="ReminderUserForm" method="POST" action="<?php echo SURL ?>reminder_users/edit_reminder_user_process">
								<input type="hidden" id="reminder_id" name="reminder_id" value="<?php echo $reminder_edit['id']  ?>">
                                    <div class="card-header card-header-icon" data-background-color="rose">
                                        <i class="material-icons">notifications</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Edit Reminder User</h4>
                                         <div class="form-group label-floating task_dropdown">
                                            <select id="task_id" name="task_id" required="true" class="selectpicker" data-style="select-with-transition" title="Choose Task *" disabled>
                                                        
                                                        <?php if(count($tasks)>0){
                                                        foreach($tasks as $val){
                                                        ?>
                                                        <option value="<?php echo $val['id'];?>" <?php if($reminder_edit['task_id']==$val['id']){ ?> selected <?php } ?>><?php echo $val['name'];?></option>
                                                        <?php } } ?>
                                                    </select>
                                            <?php echo form_error('task_id', '<div class="custom_error">', '</div>'); ?>
					</div>
                                        <div class="form-group label-floating">
                                            <label class="control-label">
                                                Email
                                                <small>*</small>
                                            </label>
                                            <input class="form-control" id="email" name="email" type="text" required="true" uniqueEditEmail="true" value="<?php echo $reminder_edit['email'];?>"/>
                                            <?php echo form_error('email', '<div class="custom_error">', '</div>'); ?>
					</div>
                                <div class="form-group label-floating">
                                        										<textarea class="form-control" name="message" id="message" placeholder="Message"><?php echo $reminder_edit['message'];?></textarea>
																</div>
                                <?php if ($this->session->userdata('admin_role_id')!=3) { ?>    
				<div class="form-group label-floating">
                                        
                                        <div class="form-footer text-right">
                                            <button type="submit" id="update_reminder" name="update_reminder" class="btn btn-rose btn-fill">Update</button>
                                        </div>
                                    </div>
                                <?php } ?>
                                </form>
                            </div>
                        </div>
                    </div>
                